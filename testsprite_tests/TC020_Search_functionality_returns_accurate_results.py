import asyncio
from playwright import async_api

async def run_test():
    pw = None
    browser = None
    context = None
    
    try:
        # Start a Playwright session in asynchronous mode
        pw = await async_api.async_playwright().start()
        
        # Launch a Chromium browser in headless mode with custom arguments
        browser = await pw.chromium.launch(
            headless=True,
            args=[
                "--window-size=1280,720",         # Set the browser window size
                "--disable-dev-shm-usage",        # Avoid using /dev/shm which can cause issues in containers
                "--ipc=host",                     # Use host-level IPC for better stability
                "--single-process"                # Run the browser in a single process mode
            ],
        )
        
        # Create a new browser context (like an incognito window)
        context = await browser.new_context()
        context.set_default_timeout(5000)
        
        # Open a new page in the browser context
        page = await context.new_page()
        
        # Navigate to your target URL and wait until the network request is committed
        await page.goto("http://localhost:8000", wait_until="commit", timeout=10000)
        
        # Wait for the main page to reach DOMContentLoaded state (optional for stability)
        try:
            await page.wait_for_load_state("domcontentloaded", timeout=3000)
        except async_api.Error:
            pass
        
        # Iterate through all iframes and wait for them to load as well
        for frame in page.frames:
            try:
                await frame.wait_for_load_state("domcontentloaded", timeout=3000)
            except async_api.Error:
                pass
        
        # Interact with the page elements to simulate user flow
        # Click on the search icon to access the product catalog search input.
        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/header/div[3]/div/div/div[2]/a').nth(0)
        await page.wait_for_timeout(3000); await elem.click(timeout=5000)
        

        # Enter a valid product keyword in the search input and submit the search.
        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/div[2]/div[2]/div/form/div[2]/input').nth(0)
        await page.wait_for_timeout(3000); await elem.fill('Natural Supplements')
        

        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/div[2]/div[2]/div/form/div[2]/button').nth(0)
        await page.wait_for_timeout(3000); await elem.click(timeout=5000)
        

        # Search for a non-existent product keyword to verify no results and relevant message.
        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/header/div[3]/div/div/div[2]/a').nth(0)
        await page.wait_for_timeout(3000); await elem.click(timeout=5000)
        

        # Enter a non-existent product keyword 'NonExistentProductXYZ' in the search input and submit the search.
        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/div[2]/div[2]/div/form/div[2]/input').nth(0)
        await page.wait_for_timeout(3000); await elem.fill('NonExistentProductXYZ')
        

        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/div[2]/div[2]/div/form/div[2]/button').nth(0)
        await page.wait_for_timeout(3000); await elem.click(timeout=5000)
        

        # Assertion: Confirm search results display products matching the keyword 'Natural Supplements' in name or description.
        frame = context.pages[-1]
        search_results = await frame.locator('xpath=//div[contains(@class, "product") or contains(@class, "featured_products")]').all_text_contents()
        assert any('Natural Supplements' in result for result in search_results), "Expected product 'Natural Supplements' not found in search results."
          
        # Assertion: Verify no results are found and relevant message is shown for non-existent product keyword.
        no_results_message = await frame.locator('xpath=//div[contains(text(), "No results found") or contains(text(), "no results")]').all_text_contents()
        assert no_results_message, "Expected 'No results found' message not displayed for non-existent product search."
        await asyncio.sleep(5)
    
    finally:
        if context:
            await context.close()
        if browser:
            await browser.close()
        if pw:
            await pw.stop()
            
asyncio.run(run_test())
    
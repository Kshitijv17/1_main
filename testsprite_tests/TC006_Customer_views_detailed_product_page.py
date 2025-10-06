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
        # Click on a product name or image to open the detailed product page.
        frame = context.pages[-1]
        elem = frame.locator('xpath=html/body/main/section[3]/div/div[2]/div/div/div/img').nth(0)
        await page.wait_for_timeout(3000); await elem.click(timeout=5000)
        

        # Assert product name is visible and correct
        assert await frame.locator('text=asdasd').is_visible()
        # Assert product category is visible and correct
        assert await frame.locator('text=Digestive Health').is_visible()
        # Assert product price is visible and correct
        assert await frame.locator('text=$122.00 (Inclusive of all taxes)').is_visible()
        # Assert product description is visible and correct
        assert await frame.locator('text=adasda').is_visible()
        # Assert product image is visible and has correct src attribute
        product_img = frame.locator('img[src="http://localhost:8000/storage/products/PN3TV67BwZS9LDqjLZGppZynAw9eNQCfmMUzOKmd.jpg"]')
        assert await product_img.is_visible()
        await asyncio.sleep(5)
    
    finally:
        if context:
            await context.close()
        if browser:
            await browser.close()
        if pw:
            await pw.stop()
            
asyncio.run(run_test())
    
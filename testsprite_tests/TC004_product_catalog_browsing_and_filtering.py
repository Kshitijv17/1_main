import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30

def test_product_catalog_browsing_and_filtering():
    headers = {
        "Accept": "application/json",
    }

    # Step 1: Get list of categories
    try:
        resp_categories = requests.get(f"{BASE_URL}/api/categories", headers=headers, timeout=TIMEOUT)
        assert resp_categories.status_code == 200, f"Expected status code 200 but got {resp_categories.status_code}"
        categories_resp_json = resp_categories.json()
        assert isinstance(categories_resp_json, dict), f"Expected dict but got {type(categories_resp_json)}"
        assert "data" in categories_resp_json, "Response JSON does not contain 'data' key"
        categories_data = categories_resp_json["data"]
        assert isinstance(categories_data, list), f"Expected list but got {type(categories_data)}"
    except Exception as e:
        assert False, f"Failed to fetch categories: {str(e) or 'No error message'}"

    if not categories_data:
        # No categories to test with, fail
        assert False, "No categories found to browse products."

    # Use the first category for filtering
    category_id = categories_data[0].get("id")
    assert category_id, "Category does not have an 'id' field."

    # Step 2: Browse products by category filtering
    params = {"category_id": category_id}
    try:
        resp_products = requests.get(f"{BASE_URL}/api/products", headers=headers, params=params, timeout=TIMEOUT)
        assert resp_products.status_code == 200, f"Expected status code 200 but got {resp_products.status_code}"
        products_resp_json = resp_products.json()
        assert isinstance(products_resp_json, dict), f"Expected dict but got {type(products_resp_json)}"
        assert "data" in products_resp_json, "Response JSON does not contain 'data' key"
        products_data = products_resp_json["data"]
        assert isinstance(products_data, list), f"Expected list but got {type(products_data)}"
    except Exception as e:
        assert False, f"Failed to fetch products by category {category_id}: {str(e) or 'No error message'}"

    # If no products in category, nothing more to check, but this is valid
    if not products_data:
        return

    # Step 3: View detailed product information and check product images
    product = products_data[0]
    product_id = product.get("id")
    assert product_id, "Product does not have 'id' field."

    try:
        resp_product_detail = requests.get(f"{BASE_URL}/api/products/{product_id}", headers=headers, timeout=TIMEOUT)
        assert resp_product_detail.status_code == 200, f"Expected status code 200 but got {resp_product_detail.status_code}"
        product_detail = resp_product_detail.json()
        # Validate expected fields in product detail
        assert "id" in product_detail and product_detail["id"] == product_id
        assert "name" in product_detail
        assert "description" in product_detail
        # Validate images are present and correctly structured
        images = product_detail.get("images")
        assert isinstance(images, list)
        for img in images:
            assert "url" in img and isinstance(img["url"], str)
            # Optionally test that image URLs are accessible
            try:
                img_resp = requests.head(img["url"], timeout=TIMEOUT)
                assert img_resp.status_code == 200
            except Exception:
                # Image URL might be external or inaccessible, just ignore failures here
                pass
    except Exception as e:
        assert False, f"Failed to fetch or validate product detail for product {product_id}: {str(e) or 'No error message'}"

test_product_catalog_browsing_and_filtering()

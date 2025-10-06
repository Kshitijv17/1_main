import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30
HEADERS = {"Content-Type": "application/json"}

def test_shop_management_functionality():
    # Sample shop data for creation and update
    shop_data_create_1 = {
        "name": "Shop Alpha",
        "description": "Alpha shop description",
        "address": "123 Alpha St",
        "phone": "123-456-7890",
        "email": "alpha@shop.com"
    }
    shop_data_create_2 = {
        "name": "Shop Beta",
        "description": "Beta shop description",
        "address": "456 Beta Ave",
        "phone": "987-654-3210",
        "email": "beta@shop.com"
    }
    shop_update_data = {
        "name": "Shop Alpha Updated",
        "description": "Updated description",
        "address": "123 Updated St",
        "phone": "111-222-3333",
        "email": "alpha_updated@shop.com"
    }

    created_shop_ids = []

    try:
        # Create first shop
        response1 = requests.post(f"{BASE_URL}/api/shops", json=shop_data_create_1, headers=HEADERS, timeout=TIMEOUT)
        assert response1.status_code == 201, f"Failed to create first shop: {response1.text}"
        shop1 = response1.json()
        assert "id" in shop1, "Response missing shop id on creation"
        shop1_id = shop1["id"]
        created_shop_ids.append(shop1_id)

        # Create second shop
        response2 = requests.post(f"{BASE_URL}/api/shops", json=shop_data_create_2, headers=HEADERS, timeout=TIMEOUT)
        assert response2.status_code == 201, f"Failed to create second shop: {response2.text}"
        shop2 = response2.json()
        assert "id" in shop2, "Response missing shop id on creation"
        shop2_id = shop2["id"]
        created_shop_ids.append(shop2_id)

        # Retrieve list of shops and verify both are present
        response_list = requests.get(f"{BASE_URL}/api/shops", headers=HEADERS, timeout=TIMEOUT)
        assert response_list.status_code == 200, f"Failed to list shops: {response_list.text}"
        shops_list = response_list.json()
        shop_ids = [shop.get("id") for shop in shops_list]
        assert shop1_id in shop_ids, "First created shop not found in list"
        assert shop2_id in shop_ids, "Second created shop not found in list"

        # Update first shop
        response_update = requests.put(f"{BASE_URL}/api/shops/{shop1_id}", json=shop_update_data, headers=HEADERS, timeout=TIMEOUT)
        assert response_update.status_code == 200, f"Failed to update first shop: {response_update.text}"
        updated_shop = response_update.json()
        for key in shop_update_data:
            assert updated_shop.get(key) == shop_update_data[key], f"Mismatch in updated {key}"

        # Retrieve updated first shop and verify changes
        response_get_updated = requests.get(f"{BASE_URL}/api/shops/{shop1_id}", headers=HEADERS, timeout=TIMEOUT)
        assert response_get_updated.status_code == 200, f"Failed to retrieve updated shop: {response_get_updated.text}"
        shop_got = response_get_updated.json()
        for key in shop_update_data:
            assert shop_got.get(key) == shop_update_data[key], f"Mismatch in retrieved updated {key}"

    finally:
        # Cleanup: Delete created shops
        for shop_id in created_shop_ids:
            try:
                requests.delete(f"{BASE_URL}/api/shops/{shop_id}", headers=HEADERS, timeout=TIMEOUT)
            except Exception:
                pass


test_shop_management_functionality()
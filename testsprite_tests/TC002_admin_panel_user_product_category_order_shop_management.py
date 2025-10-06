import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30

ADMIN_AUTH = {
    "email": "admin@example.com",
    "password": "adminpassword"
}

def admin_login():
    url = f"{BASE_URL}/api/admin/login"
    payload = {
        "email": ADMIN_AUTH["email"],
        "password": ADMIN_AUTH["password"]
    }
    r = requests.post(url, json=payload, timeout=TIMEOUT)
    r.raise_for_status()
    data = r.json()
    assert "token" in data, "Login response must include token"
    return data["token"]

def test_admin_panel_user_product_category_order_shop_management():
    token = admin_login()
    headers = {"Authorization": f"Bearer {token}", "Content-Type": "application/json"}

    # --- USER CRUD ---
    user_data = {
        "name": "Test User",
        "email": "testuser@example.com",
        "password": "TestPass123!",
        "role": "user"
    }
    # Create user
    r = requests.post(f"{BASE_URL}/api/admin/users", json=user_data, headers=headers, timeout=TIMEOUT)
    assert r.status_code == 201, f"User creation failed: {r.text}"
    user = r.json()
    user_id = user.get("id")
    assert user_id is not None

    try:
        # Read user
        r = requests.get(f"{BASE_URL}/api/admin/users/{user_id}", headers=headers, timeout=TIMEOUT)
        assert r.status_code == 200
        user_resp = r.json()
        assert user_resp["email"] == user_data["email"]

        # Update user
        updated_user_data = {"name": "Updated Test User"}
        r = requests.put(f"{BASE_URL}/api/admin/users/{user_id}", json=updated_user_data, headers=headers, timeout=TIMEOUT)
        assert r.status_code == 200
        user_updated = r.json()
        assert user_updated["name"] == updated_user_data["name"]

        # --- CATEGORY CRUD ---
        category_data = {"name": "Test Category", "description": "Category description"}
        r = requests.post(f"{BASE_URL}/api/admin/categories", json=category_data, headers=headers, timeout=TIMEOUT)
        assert r.status_code == 201, f"Category creation failed: {r.text}"
        category = r.json()
        category_id = category.get("id")
        assert category_id is not None

        try:
            r = requests.get(f"{BASE_URL}/api/admin/categories/{category_id}", headers=headers, timeout=TIMEOUT)
            assert r.status_code == 200
            cat_resp = r.json()
            assert cat_resp["name"] == category_data["name"]

            updated_category_data = {"description": "Updated description"}
            r = requests.put(f"{BASE_URL}/api/admin/categories/{category_id}", json=updated_category_data, headers=headers, timeout=TIMEOUT)
            assert r.status_code == 200
            cat_updated = r.json()
            assert cat_updated["description"] == updated_category_data["description"]

            # --- PRODUCT CRUD ---
            product_data = {
                "name": "Test Product",
                "description": "A product for test",
                "price": 19.99,
                "category_id": category_id,
                "stock": 100
            }
            r = requests.post(f"{BASE_URL}/api/admin/products", json=product_data, headers=headers, timeout=TIMEOUT)
            assert r.status_code == 201, f"Product creation failed: {r.text}"
            product = r.json()
            product_id = product.get("id")
            assert product_id is not None

            try:
                r = requests.get(f"{BASE_URL}/api/admin/products/{product_id}", headers=headers, timeout=TIMEOUT)
                assert r.status_code == 200
                prod_resp = r.json()
                assert prod_resp["name"] == product_data["name"]

                updated_product_data = {"price": 29.99}
                r = requests.put(f"{BASE_URL}/api/admin/products/{product_id}", json=updated_product_data, headers=headers, timeout=TIMEOUT)
                assert r.status_code == 200
                prod_updated = r.json()
                assert prod_updated["price"] == updated_product_data["price"]

                # --- SHOP CRUD ---
                shop_data = {
                    "name": "Test Shop",
                    "description": "Shop description",
                    "location": "Test City"
                }
                r = requests.post(f"{BASE_URL}/api/admin/shops", json=shop_data, headers=headers, timeout=TIMEOUT)
                assert r.status_code == 201, f"Shop creation failed: {r.text}"
                shop = r.json()
                shop_id = shop.get("id")
                assert shop_id is not None

                try:
                    r = requests.get(f"{BASE_URL}/api/admin/shops/{shop_id}", headers=headers, timeout=TIMEOUT)
                    assert r.status_code == 200
                    shop_resp = r.json()
                    assert shop_resp["name"] == shop_data["name"]

                    updated_shop_data = {"description": "Updated Shop description"}
                    r = requests.put(f"{BASE_URL}/api/admin/shops/{shop_id}", json=updated_shop_data, headers=headers, timeout=TIMEOUT)
                    assert r.status_code == 200
                    shop_updated = r.json()
                    assert shop_updated["description"] == updated_shop_data["description"]

                    # --- ORDER CRUD ---
                    # Create order linked to user and shop
                    order_data = {
                        "user_id": user_id,
                        "shop_id": shop_id,
                        "status": "pending",
                        "items": [
                            {
                                "product_id": product_id,
                                "quantity": 2,
                                "price": product_data["price"]
                            }
                        ]
                    }
                    r = requests.post(f"{BASE_URL}/api/admin/orders", json=order_data, headers=headers, timeout=TIMEOUT)
                    assert r.status_code == 201, f"Order creation failed: {r.text}"
                    order = r.json()
                    order_id = order.get("id")
                    assert order_id is not None

                    try:
                        r = requests.get(f"{BASE_URL}/api/admin/orders/{order_id}", headers=headers, timeout=TIMEOUT)
                        assert r.status_code == 200
                        order_resp = r.json()
                        assert order_resp["status"] == order_data["status"]

                        updated_order_data = {"status": "completed"}
                        r = requests.put(f"{BASE_URL}/api/admin/orders/{order_id}", json=updated_order_data, headers=headers, timeout=TIMEOUT)
                        assert r.status_code == 200
                        order_updated = r.json()
                        assert order_updated["status"] == updated_order_data["status"]

                    finally:
                        # Delete order
                        r = requests.delete(f"{BASE_URL}/api/admin/orders/{order_id}", headers=headers, timeout=TIMEOUT)
                        assert r.status_code in (200, 204)

                finally:
                    # Delete shop
                    r = requests.delete(f"{BASE_URL}/api/admin/shops/{shop_id}", headers=headers, timeout=TIMEOUT)
                    assert r.status_code in (200, 204)

            finally:
                # Delete product
                r = requests.delete(f"{BASE_URL}/api/admin/products/{product_id}", headers=headers, timeout=TIMEOUT)
                assert r.status_code in (200, 204)

        finally:
            # Delete category
            r = requests.delete(f"{BASE_URL}/api/admin/categories/{category_id}", headers=headers, timeout=TIMEOUT)
            assert r.status_code in (200, 204)

    finally:
        # Delete user
        r = requests.delete(f"{BASE_URL}/api/admin/users/{user_id}", headers=headers, timeout=TIMEOUT)
        assert r.status_code in (200, 204)

test_admin_panel_user_product_category_order_shop_management()
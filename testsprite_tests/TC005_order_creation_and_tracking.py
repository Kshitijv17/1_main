import requests
import uuid

BASE_URL = "http://localhost:8000"
TIMEOUT = 30


def test_order_creation_and_tracking():
    # Helper function to create a test user (user)
    def create_test_user():
        user_data = {
            "name": "Test User " + str(uuid.uuid4())[:8],
            "email": f"testuser_{uuid.uuid4().hex[:8]}@example.com",
            "password": "TestPassword123!",
            "password_confirmation": "TestPassword123!",
            "role": "user"
        }
        response = requests.post(f"{BASE_URL}/api/register", json=user_data, timeout=TIMEOUT)
        assert response.status_code == 201, f"User registration failed: {response.text}"
        return user_data["email"], user_data["password"]

    # Helper function to login and get auth token
    def login_get_token(email, password):
        resp = requests.post(f"{BASE_URL}/api/login", json={"email": email, "password": password}, timeout=TIMEOUT)
        assert resp.status_code == 200, f"Login failed: {resp.text}"
        json_data = resp.json()
        token = json_data.get("access_token") or json_data.get("token") or json_data.get("data", {}).get("token")
        assert token, "Auth token not found in login response"
        return token

    # Helper function to create a product to order
    def create_test_product(token):
        headers = {"Authorization": f"Bearer {token}"}
        product_data = {
            "name": "Test Product " + str(uuid.uuid4())[:8],
            "description": "Product for order creation test",
            "price": 19.99,
            "stock": 100,
            "category_id": 1  # Assuming category 1 exists
        }
        resp = requests.post(f"{BASE_URL}/api/products", json=product_data, headers=headers, timeout=TIMEOUT)
        if resp.status_code == 201:
            return resp.json().get("id") or resp.json().get("data", {}).get("id")
        # Possibly not authorized to create product, fallback to list first product as test product
        resp_list = requests.get(f"{BASE_URL}/api/products", timeout=TIMEOUT)
        assert resp_list.status_code == 200, f"Failed to list products: {resp_list.text}"
        products = resp_list.json()
        if isinstance(products, dict):
            products = products.get("data") if "data" in products else []
        assert products and len(products) > 0, "No products found for ordering"
        return products[0].get("id")

    # Helper function to delete a created order
    def delete_order(order_id, token):
        headers = {"Authorization": f"Bearer {token}"}
        resp = requests.delete(f"{BASE_URL}/api/orders/{order_id}", headers=headers, timeout=TIMEOUT)
        # No assertion on delete success, just attempt

    user_email, user_password = create_test_user()
    token = login_get_token(user_email, user_password)
    headers = {"Authorization": f"Bearer {token}"}

    product_id = create_test_product(token)

    created_order_id = None
    try:
        # Create Order with one item
        order_payload = {
            "items": [
                {
                    "product_id": product_id,
                    "quantity": 2
                }
            ],
            "shipping_address": "123 Test Street, Test City, TC 12345",
            "billing_address": "123 Test Street, Test City, TC 12345",
            "payment_method": "credit_card"
        }
        create_resp = requests.post(f"{BASE_URL}/api/orders", json=order_payload, headers=headers, timeout=TIMEOUT)
        assert create_resp.status_code == 201, f"Order creation failed: {create_resp.text}"
        order_data = create_resp.json()
        created_order_id = order_data.get("id") or order_data.get("data", {}).get("id")
        assert created_order_id, "Created order ID not returned"

        # Track order status
        track_resp = requests.get(f"{BASE_URL}/api/orders/{created_order_id}/status", headers=headers, timeout=TIMEOUT)
        assert track_resp.status_code == 200, f"Order status tracking failed: {track_resp.text}"
        status_data = track_resp.json()
        assert "status" in status_data or ("data" in status_data and "status" in status_data["data"]), "Order status not in response"

        # Update order item quantity
        update_payload = {
            "items": [
                {
                    "product_id": product_id,
                    "quantity": 3
                }
            ]
        }
        update_resp = requests.put(f"{BASE_URL}/api/orders/{created_order_id}", json=update_payload, headers=headers, timeout=TIMEOUT)
        assert update_resp.status_code in (200, 204), f"Order update failed: {update_resp.text}"

        # Verify updated order items
        get_order_resp = requests.get(f"{BASE_URL}/api/orders/{created_order_id}", headers=headers, timeout=TIMEOUT)
        assert get_order_resp.status_code == 200, f"Get updated order failed: {get_order_resp.text}"
        order_details = get_order_resp.json()
        items = order_details.get("items") or order_details.get("data", {}).get("items")
        assert items is not None, "Order items missing in order details"
        found_item = False
        for item in items:
            if (item.get("product_id") == product_id) and (item.get("quantity") == 3):
                found_item = True
                break
        assert found_item, "Updated order item quantity not reflected"

        # Verify user profile order history reflects the order and updated details
        profile_resp = requests.get(f"{BASE_URL}/api/user/profile", headers=headers, timeout=TIMEOUT)
        assert profile_resp.status_code == 200, f"User profile fetch failed: {profile_resp.text}"
        profile_data = profile_resp.json()
        orders = profile_data.get("orders") or profile_data.get("data", {}).get("orders")
        assert orders is not None, "Orders missing in user profile"
        ordered = any(o.get("id") == created_order_id for o in orders)
        assert ordered, "Created order not found in user profile orders"

    finally:
        if created_order_id:
            delete_order(created_order_id, token)


test_order_creation_and_tracking()

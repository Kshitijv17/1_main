import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30

# Assuming the API requires authentication, first login the user to get a token.
# For this test, we'll register a user, login, test profile viewing, updating, and order history,
# then cleanup the created user and any resources if applicable.

def test_user_profile_and_order_management():
    # Data for new user registration
    register_data = {
        "name": "Test User",
        "email": "test_user@example.com",
        "password": "StrongPass123!",
        "password_confirmation": "StrongPass123!"
    }
    session = requests.Session()
    try:
        # Register new user
        resp_register = session.post(f"{BASE_URL}/api/register", json=register_data, timeout=TIMEOUT)
        assert resp_register.status_code == 201, f"Registration failed: {resp_register.text}"
        user = resp_register.json()
        assert "id" in user, "Registered user ID missing"
        user_id = user["id"]

        # Login the user to get auth token
        login_data = {
            "email": register_data["email"],
            "password": register_data["password"]
        }
        resp_login = session.post(f"{BASE_URL}/api/login", json=login_data, timeout=TIMEOUT)
        assert resp_login.status_code == 200, f"Login failed: {resp_login.text}"
        login_resp = resp_login.json()
        assert "token" in login_resp, "Token missing in login response"
        token = login_resp["token"]

        headers = {
            "Authorization": f"Bearer {token}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        }

        # VIEW user profile
        resp_profile = session.get(f"{BASE_URL}/api/user/profile", headers=headers, timeout=TIMEOUT)
        assert resp_profile.status_code == 200, f"Failed to get profile: {resp_profile.text}"
        profile = resp_profile.json()
        assert profile.get("email") == register_data["email"], "Profile email mismatch"

        # UPDATE user profile
        update_data = {
            "name": "Updated Test User",
            "phone": "123-456-7890"
        }
        resp_update = session.put(f"{BASE_URL}/api/user/profile", headers=headers, json=update_data, timeout=TIMEOUT)
        assert resp_update.status_code == 200, f"Failed to update profile: {resp_update.text}"
        updated_profile = resp_update.json()
        assert updated_profile.get("name") == update_data["name"], "Profile name not updated"
        assert updated_profile.get("phone") == update_data["phone"], "Profile phone not updated"

        # ACCESS order history (empty initially)
        resp_orders = session.get(f"{BASE_URL}/api/user/orders", headers=headers, timeout=TIMEOUT)
        assert resp_orders.status_code == 200, f"Failed to get order history: {resp_orders.text}"
        orders = resp_orders.json()
        assert isinstance(orders, list), "Orders response is not a list"

        # ACCESS interactions (assuming interactions endpoint)
        resp_interactions = session.get(f"{BASE_URL}/api/user/interactions", headers=headers, timeout=TIMEOUT)
        # The interactions endpoint might not exist or might be empty. We accept 200 or 404 as valid.
        assert resp_interactions.status_code in (200,404), f"Unexpected status for interactions: {resp_interactions.status_code}"

    finally:
        # Clean up user by deleting the created user account via API if possible
        # Authentication required for user deletion; using the token obtained above
        try:
            if 'token' in locals():
                delete_headers = {"Authorization": f"Bearer {token}"}
                resp_delete = session.delete(f"{BASE_URL}/api/user/profile", headers=delete_headers, timeout=TIMEOUT)
                # Some APIs return 204 No Content or 200 OK for a successful deletion
                assert resp_delete.status_code in (200,204,202), f"User deletion failed: {resp_delete.text}"
        except Exception:
            # Suppress any exceptions during cleanup
            pass

test_user_profile_and_order_management()

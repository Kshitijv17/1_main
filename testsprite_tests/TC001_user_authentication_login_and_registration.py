import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30
HEADERS = {"Content-Type": "application/json"}


def test_user_authentication_login_and_registration():
    try:
        # Register User
        user_registration_payload = {
            "name": "Test User",
            "email": "test_user@example.com",
            "password": "StrongPass!123",
            "password_confirmation": "StrongPass!123",
            "role": "user"
        }
        reg_resp_user = requests.post(
            f"{BASE_URL}/api/register",
            json=user_registration_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert reg_resp_user.status_code == 201, f"User registration failed: {reg_resp_user.text}"
        user_data = reg_resp_user.json()
        assert "id" in user_data and user_data.get("role") == "user"

        # Register Admin
        admin_registration_payload = {
            "name": "Test Admin",
            "email": "test_admin@example.com",
            "password": "StrongAdminPass!123",
            "password_confirmation": "StrongAdminPass!123",
            "role": "admin"
        }
        reg_resp_admin = requests.post(
            f"{BASE_URL}/api/register",
            json=admin_registration_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert reg_resp_admin.status_code == 201, f"Admin registration failed: {reg_resp_admin.text}"
        admin_data = reg_resp_admin.json()
        assert "id" in admin_data and admin_data.get("role") == "admin"

        # Login User
        user_login_payload = {
            "email": "test_user@example.com",
            "password": "StrongPass!123"
        }
        login_resp_user = requests.post(
            f"{BASE_URL}/api/login",
            json=user_login_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert login_resp_user.status_code == 200, f"User login failed: {login_resp_user.text}"
        login_user_data = login_resp_user.json()
        assert "token" in login_user_data
        assert login_user_data.get("role") == "user"

        # Login Admin
        admin_login_payload = {
            "email": "test_admin@example.com",
            "password": "StrongAdminPass!123"
        }
        login_resp_admin = requests.post(
            f"{BASE_URL}/api/login",
            json=admin_login_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert login_resp_admin.status_code == 200, f"Admin login failed: {login_resp_admin.text}"
        login_admin_data = login_resp_admin.json()
        assert "token" in login_admin_data
        assert login_admin_data.get("role") == "admin"

        # Login failure: wrong password
        wrong_login_payload = {
            "email": "test_user@example.com",
            "password": "WrongPass123"
        }
        login_fail_resp = requests.post(
            f"{BASE_URL}/api/login",
            json=wrong_login_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert login_fail_resp.status_code == 401 or login_fail_resp.status_code == 400

        # Login failure: unregistered user
        unreg_login_payload = {
            "email": "notexists@example.com",
            "password": "DoesNotMatter123"
        }
        unreg_login_resp = requests.post(
            f"{BASE_URL}/api/login",
            json=unreg_login_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        assert unreg_login_resp.status_code == 401 or unreg_login_resp.status_code == 400

    finally:
        # Cleanup - if API supports user deletion: delete test users by login token or admin endpoint
        # Attempt to login as admin to delete test user and admin users
        admin_login_payload = {
            "email": "test_admin@example.com",
            "password": "StrongAdminPass!123"
        }
        login_resp_admin = requests.post(
            f"{BASE_URL}/api/login",
            json=admin_login_payload,
            headers=HEADERS,
            timeout=TIMEOUT,
        )
        if login_resp_admin.status_code == 200:
            token = login_resp_admin.json().get("token")
            auth_headers = {"Authorization": f"Bearer {token}"}

            # Delete test user user if exists
            try:
                # Get users list and find test user
                users_resp = requests.get(
                    f"{BASE_URL}/api/admin/users",
                    headers=auth_headers,
                    timeout=TIMEOUT,
                )
                if users_resp.status_code == 200:
                    users = users_resp.json()
                    for user in users:
                        if user.get("email") == "test_user@example.com":
                            requests.delete(
                                f"{BASE_URL}/api/admin/users/{user.get('id')}",
                                headers=auth_headers,
                                timeout=TIMEOUT,
                            )
                        if user.get("email") == "test_admin@example.com":
                            requests.delete(
                                f"{BASE_URL}/api/admin/users/{user.get('id')}",
                                headers=auth_headers,
                                timeout=TIMEOUT,
                            )
            except Exception:
                pass


test_user_authentication_login_and_registration()

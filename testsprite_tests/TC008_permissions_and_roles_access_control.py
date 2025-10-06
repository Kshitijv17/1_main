import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30

# Presumed admin credentials for authentication
ADMIN_LOGIN_PAYLOAD = {
    "email": "admin@example.com",
    "password": "AdminPass123!"
}

def test_permissions_and_roles_access_control():
    session = requests.Session()
    try:
        # 1. Authenticate as admin to get token
        login_resp = session.post(f"{BASE_URL}/api/login", json=ADMIN_LOGIN_PAYLOAD, timeout=TIMEOUT)
        assert login_resp.status_code == 200, f"Admin login failed: {login_resp.text}"
        token = login_resp.json().get("token")
        assert token, "Token not received after admin login"

        headers = {
            "Authorization": f"Bearer {token}",
            "Content-Type": "application/json"
        }

        # 2. Create a new role
        role_payload = {
            "name": "test_role_api",
            "description": "Role created for testing permissions API"
        }
        role_resp = session.post(f"{BASE_URL}/api/roles", json=role_payload, headers=headers, timeout=TIMEOUT)
        assert role_resp.status_code == 201, f"Role creation failed: {role_resp.text}"
        role_data = role_resp.json()
        role_id = role_data.get("id")
        assert role_id, "Role ID missing in creation response"

        # 3. Create a new permission
        permission_payload = {
            "name": "test_permission_api",
            "description": "Permission created for testing roles API"
        }
        perm_resp = session.post(f"{BASE_URL}/api/permissions", json=permission_payload, headers=headers, timeout=TIMEOUT)
        assert perm_resp.status_code == 201, f"Permission creation failed: {perm_resp.text}"
        perm_data = perm_resp.json()
        perm_id = perm_data.get("id")
        assert perm_id, "Permission ID missing in creation response"

        # 4. Assign permission to role
        assign_payload = {
            "permission_id": perm_id
        }
        assign_resp = session.post(f"{BASE_URL}/api/roles/{role_id}/permissions", json=assign_payload, headers=headers, timeout=TIMEOUT)
        assert assign_resp.status_code == 200, f"Assigning permission to role failed: {assign_resp.text}"

        # 5. Retrieve role permissions to verify assignment
        get_perm_resp = session.get(f"{BASE_URL}/api/roles/{role_id}/permissions", headers=headers, timeout=TIMEOUT)
        assert get_perm_resp.status_code == 200, f"Failed to get permissions for role: {get_perm_resp.text}"
        perms_list = get_perm_resp.json()
        assert any(p.get("id") == perm_id for p in perms_list), "Assigned permission not found in role permissions"

        # 6. Create a test user
        user_payload = {
            "name": "Test User",
            "email": "testuser_api@example.com",
            "password": "UserPass123!",
            "password_confirmation": "UserPass123!"
        }
        user_resp = session.post(f"{BASE_URL}/api/users", json=user_payload, headers=headers, timeout=TIMEOUT)
        assert user_resp.status_code == 201, f"User creation failed: {user_resp.text}"
        user_data = user_resp.json()
        user_id = user_data.get("id")
        assert user_id, "User ID missing in creation response"

        # 7. Assign role to user
        assign_role_resp = session.post(f"{BASE_URL}/api/users/{user_id}/roles", json={"role_id": role_id}, headers=headers, timeout=TIMEOUT)
        assert assign_role_resp.status_code == 200, f"Assigning role to user failed: {assign_role_resp.text}"

        # 8. Authenticate as test user
        user_login_payload = {
            "email": "testuser_api@example.com",
            "password": "UserPass123!"
        }
        user_login_resp = session.post(f"{BASE_URL}/api/login", json=user_login_payload, timeout=TIMEOUT)
        assert user_login_resp.status_code == 200, f"Test user login failed: {user_login_resp.text}"
        user_token = user_login_resp.json().get("token")
        assert user_token, "Token not received after test user login"

        user_headers = {
            "Authorization": f"Bearer {user_token}",
            "Content-Type": "application/json"
        }

        # 9. Attempt to perform an admin-only action with user's token to verify access control is enforced
        admin_action_resp = session.post(f"{BASE_URL}/api/products", json={"name": "Unauthorized Product"}, headers=user_headers, timeout=TIMEOUT)
        # Expect forbidden or unauthorized (403 or 401)
        assert admin_action_resp.status_code in (401, 403), f"User should not have access to admin action: {admin_action_resp.status_code}"

        # 10. Remove permission from role
        remove_perm_resp = session.delete(f"{BASE_URL}/api/roles/{role_id}/permissions/{perm_id}", headers=headers, timeout=TIMEOUT)
        assert remove_perm_resp.status_code == 200, f"Removing permission from role failed: {remove_perm_resp.text}"

        # 11. Remove role from user
        remove_role_resp = session.delete(f"{BASE_URL}/api/users/{user_id}/roles/{role_id}", headers=headers, timeout=TIMEOUT)
        assert remove_role_resp.status_code == 200, f"Removing role from user failed: {remove_role_resp.text}"

    finally:
        # Cleanup created resources
        # Delete user
        try:
            del_user_resp = session.delete(f"{BASE_URL}/api/users/{user_id}", headers=headers, timeout=TIMEOUT)
            assert del_user_resp.status_code == 200 or del_user_resp.status_code == 204
        except Exception:
            pass

        # Delete permission
        try:
            del_perm_resp = session.delete(f"{BASE_URL}/api/permissions/{perm_id}", headers=headers, timeout=TIMEOUT)
            assert del_perm_resp.status_code == 200 or del_perm_resp.status_code == 204
        except Exception:
            pass

        # Delete role
        try:
            del_role_resp = session.delete(f"{BASE_URL}/api/roles/{role_id}", headers=headers, timeout=TIMEOUT)
            assert del_role_resp.status_code == 200 or del_role_resp.status_code == 204
        except Exception:
            pass

test_permissions_and_roles_access_control()

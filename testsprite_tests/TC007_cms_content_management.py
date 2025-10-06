import requests

BASE_URL = "http://localhost:8000"
TIMEOUT = 30

ADMIN_CREDENTIALS = {
    "email": "admin@example.com",
    "password": "adminpassword"
}


def admin_login():
    url = f"{BASE_URL}/api/admin/login"
    try:
        response = requests.post(url, json=ADMIN_CREDENTIALS, timeout=TIMEOUT)
        response.raise_for_status()
        data = response.json()
        token = data.get("token")
        assert token is not None, "No token found in login response"
        return token
    except Exception as e:
        raise RuntimeError(f"Admin login failed: {e}")


def test_cms_content_management():
    token = admin_login()
    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }

    cms_create_url = f"{BASE_URL}/api/admin/cms-contents"
    cms_update_url = lambda content_id: f"{BASE_URL}/api/admin/cms-contents/{content_id}"
    cms_get_url = lambda content_id: f"{BASE_URL}/api/cms-contents/{content_id}"
    cms_list_url = f"{BASE_URL}/api/cms-contents"

    # Define new CMS content data
    new_content_data = {
        "title": "Test Page Title",
        "slug": "test-page-title",
        "content": "<h1>This is a test CMS page</h1><p>Content for the test page.</p>",
        "meta_description": "Test page meta description",
        "meta_keywords": "test,page,content",
        "is_active": True
    }

    created_content_id = None

    try:
        # Create CMS content (admin only)
        create_resp = requests.post(cms_create_url, json=new_content_data, headers=headers, timeout=TIMEOUT)
        assert create_resp.status_code == 201, f"Expected 201 Created, got {create_resp.status_code}"
        create_resp_json = create_resp.json()
        created_content_id = create_resp_json.get("id")
        assert created_content_id is not None, "Created content ID missing in response"

        # Update CMS content (admin only)
        updated_content_data = {
            "title": "Test Page Title Updated",
            "content": "<h1>Updated test CMS page</h1><p>Updated content for the test page.</p>",
            "meta_description": "Updated meta description",
            "meta_keywords": "updated,test,page",
            "is_active": True
        }
        update_resp = requests.put(cms_update_url(created_content_id), json=updated_content_data, headers=headers, timeout=TIMEOUT)
        assert update_resp.status_code == 200, f"Expected 200 OK on update, got {update_resp.status_code}"
        update_resp_json = update_resp.json()
        assert update_resp_json.get("title") == updated_content_data["title"], "Title not updated correctly"
        assert update_resp_json.get("is_active") == updated_content_data["is_active"], "is_active not updated correctly"

        # Retrieve CMS content as admin (to confirm update)
        get_resp_admin = requests.get(cms_get_url(created_content_id), headers=headers, timeout=TIMEOUT)
        assert get_resp_admin.status_code == 200, f"Expected 200 OK on GET by admin, got {get_resp_admin.status_code}"
        get_resp_json = get_resp_admin.json()
        assert get_resp_json.get("title") == updated_content_data["title"], "GET content title mismatch"
        assert get_resp_json.get("content") == updated_content_data["content"], "GET content mismatch"

        # Retrieve CMS content as public user (no auth) - to check display
        get_resp_public = requests.get(cms_get_url(created_content_id), timeout=TIMEOUT)
        assert get_resp_public.status_code == 200, f"Expected 200 OK on GET public, got {get_resp_public.status_code}"
        get_public_json = get_resp_public.json()
        assert get_public_json.get("title") == updated_content_data["title"], "Public GET content title mismatch"
        assert "content" in get_public_json and get_public_json["content"], "Public content missing or empty"

        # List CMS contents publicly to verify content appears in list
        list_resp = requests.get(cms_list_url, timeout=TIMEOUT)
        assert list_resp.status_code == 200, f"Expected 200 OK on CMS list, got {list_resp.status_code}"
        list_contents = list_resp.json()
        assert any(c.get("id") == created_content_id for c in list_contents), "Created content not found in CMS list"

    finally:
        # Cleanup - Delete created CMS content (admin only)
        if created_content_id is not None:
            del_resp = requests.delete(cms_update_url(created_content_id), headers=headers, timeout=TIMEOUT)
            assert del_resp.status_code == 204 or del_resp.status_code == 200, f"Expected 204 or 200 on delete, got {del_resp.status_code}"


test_cms_content_management()
# HerbDash E-commerce API Documentation

## Base URL
```
http://127.0.0.1:8000/api/v1
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

## API Endpoints

### 🔐 Authentication

#### Register User
```http
POST /auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "password": "password123",
    "password_confirmation": "password123",
    "date_of_birth": "1990-01-01",
    "gender": "male"
}
```

#### Login User
```http
POST /auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Guest Login
```http
POST /auth/guest-login
Content-Type: application/json
```

#### Get Profile (Protected)
```http
GET /auth/profile
Authorization: Bearer {token}
```

#### Update Profile (Protected)
```http
PUT /auth/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Updated",
    "phone": "+1234567890",
    "address": "123 Main St"
}
```

#### Logout (Protected)
```http
POST /auth/logout
Authorization: Bearer {token}
```

### 📦 Products

#### Get All Products
```http
GET /products?page=1&per_page=20&category_id=1&search=herbal&min_price=100&max_price=500&sort_by=price_low_to_high&featured=1
```

#### Get Single Product
```http
GET /products/{id}
```

#### Get Featured Products
```http
GET /products/featured?limit=10
```

#### Search Products
```http
GET /products/search?q=neem+oil
```

#### Get Products by Category
```http
GET /products/category/{categoryId}?page=1&sort_by=price_low_to_high
```

#### Get Products by Shop
```http
GET /products/shop/{shopId}?page=1
```

### 🏷️ Categories

#### Get All Categories
```http
GET /categories?show_on_home=1
```

#### Get Single Category
```http
GET /categories/{id}?include_products=1
```

#### Get Featured Categories
```http
GET /categories/featured
```

#### Get Categories with Product Counts
```http
GET /categories/with-counts
```

### 🛒 Cart

#### Get Cart Items
```http
GET /cart
```

#### Add to Cart
```http
POST /cart/add
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 2,
    "product_options": {
        "size": "medium",
        "color": "green"
    }
}
```

#### Update Cart Item
```http
PUT /cart/{cartItemId}
Content-Type: application/json

{
    "quantity": 3
}
```

#### Remove Cart Item
```http
DELETE /cart/{cartItemId}
```

#### Clear Cart
```http
DELETE /cart
```

### 📋 Orders

#### Buy Now (Direct Purchase)
```http
POST /orders/buy-now
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 1,
    "user_name": "John Doe",
    "user_email": "john@example.com",
    "user_phone": "+1234567890",
    "shipping_address": {
        "address_line_1": "123 Main Street",
        "city": "New York",
        "state": "NY",
        "postal_code": "10001",
        "country": "USA"
    },
    "payment_method": "cod",
    "notes": "Please deliver in the evening"
}
```

#### Checkout (Cart to Order)
```http
POST /orders/checkout
Content-Type: application/json

{
    "user_name": "John Doe",
    "user_email": "john@example.com",
    "user_phone": "+1234567890",
    "shipping_address": {
        "address_line_1": "123 Main Street",
        "city": "New York",
        "state": "NY",
        "postal_code": "10001",
        "country": "USA"
    },
    "billing_address": {
        "address_line_1": "123 Main Street",
        "city": "New York",
        "state": "NY",
        "postal_code": "10001",
        "country": "USA"
    },
    "payment_method": "online"
}
```

#### Get User Orders (Protected)
```http
GET /orders
Authorization: Bearer {token}
```

#### Get Single Order (Protected)
```http
GET /orders/{id}
Authorization: Bearer {token}
```

#### Cancel Order (Protected)
```http
POST /orders/{id}/cancel
Authorization: Bearer {token}
```

### 🏪 Shops

#### Get All Shops
```http
GET /shops
```

#### Get Single Shop
```http
GET /shops/{id}
```

### ❤️ Wishlist (Protected)

#### Get Wishlist
```http
GET /wishlist
Authorization: Bearer {token}
```

#### Add to Wishlist
```http
POST /wishlist/add
Authorization: Bearer {token}
Content-Type: application/json

{
    "product_id": 1
}
```

#### Remove from Wishlist
```http
DELETE /wishlist/{id}
Authorization: Bearer {token}
```

### 📱 App Data

#### Get App Configuration
```http
GET /app-data
```

## Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data here
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "error": "Detailed error information",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

## Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Features
- ✅ **Guest Checkout**: Users can purchase without registration
- ✅ **Multi-vendor**: Multiple shops selling products
- ✅ **Session-based Cart**: Works for both authenticated and guest users
- ✅ **Product Search & Filtering**: Advanced product discovery
- ✅ **Order Management**: Complete order lifecycle
- ⏳ **Wishlist**: Coming soon
- ⏳ **Reviews & Ratings**: Coming soon
- ⏳ **Push Notifications**: Coming soon

## Testing with Postman/Insomnia

1. **Set Base URL**: `http://127.0.0.1:8000/api/v1`
2. **Register/Login**: Get authentication token
3. **Set Authorization**: Use Bearer token for protected routes
4. **Test Cart Flow**: Add products → Checkout → View orders
5. **Test Guest Flow**: Use guest-login → Add to cart → Buy now

## Mobile App Integration

This API is designed for Flutter/React Native mobile apps with:
- Token-based authentication
- Session-based cart for guests
- Comprehensive product catalog
- Multi-vendor order management
- Real-time cart synchronization

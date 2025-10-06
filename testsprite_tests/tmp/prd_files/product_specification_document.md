# Product Specification Document: Laravel Admin Panel

## 1. Introduction
This document outlines the key features, purpose, and functionality of the Laravel Admin Panel project. The project aims to provide a robust and scalable platform for managing various aspects of an e-commerce or content-driven website, including user authentication, product catalog, order management, and administrative controls.

## 2. Purpose
The primary purpose of this project is to offer a comprehensive backend administration system alongside a user-facing frontend. It is designed to streamline business operations, enhance user experience, and provide a solid foundation for future expansions.

## 3. Tech Stack
The project is built using the following technologies:
- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Frontend:** JavaScript, Vite, TailwindCSS
- **Package Management:** Composer (PHP), npm (JavaScript)

## 4. Features

### 4.1. User Authentication
- **Description:** Handles user login, registration, and logout for both regular users and administrators.
- **Key Functionality:**
    - Secure user registration with email and password.
    - User login with session management.
    - Administrator login with separate authentication guard.
    - Password reset functionality.
- **Relevant Files:**
    - `app/Http/Controllers/Auth/LoginController.php`
    - `app/Http/Controllers/Auth/RegisterController.php`
    - `app/Http/Controllers/Auth/ForgotPasswordController.php`
    - `app/Http/Controllers/Auth/ResetController.php`
    - `app/Http/Controllers/User/UserAuthController.php`
    - `app/Models/User.php`
    - `app/Models/Admin.php`
    - `config/auth.php`
    - `routes/web.php`
    - `resources/views/auth/login.blade.php`
    - `resources/views/auth/register.blade.php`

### 4.2. Admin Panel
- **Description:** Provides administrative functionalities for managing the application, including users, products, categories, and orders.
- **Key Functionality:**
    - Dashboard for an overview of system activities.
    - Management of product listings (add, edit, delete).
    - Management of product categories.
    - Order processing and status updates.
    - User account management.
- **Relevant Files:**
    - `app/Http/Controllers/Admin/AdminController.php`
    - `app/Http/Controllers/Admin/CategoryController.php`
    - `app/Http/Controllers/Admin/ProductController.php`
    - `app/Http/Controllers/Admin/OrderController.php`
    - `app/Http/Controllers/Admin/UserController.php`
    - `app/Models/Admin.php`
    - `resources/views/admin/dashboard.blade.php`
    - `resources/views/admin/categories.blade.php`
    - `resources/views/admin/products.blade.php`
    - `resources/views/admin/orders.blade.php`
    - `resources/views/admin/users.blade.php`

### 4.3. User Management
- **Description:** Manages user profiles, orders, and interactions.
- **Key Functionality:**
    - User profile viewing and editing.
    - Viewing past orders and their statuses.
    - Account settings management.
- **Relevant Files:**
    - `app/Http/Controllers/User/UserController.php`
    - `app/Models/User.php`
    - `resources/views/user/profile.blade.php`
    - `resources/views/user/pages/my-account.blade.php`
    - `resources/views/user/pages/my-orders.blade.php`

### 4.4. Product Catalog
- **Description:** Displays and manages products, categories, and product images.
- **Key Functionality:**
    - Browse products by category.
    - View detailed product information, including images and descriptions.
    - Search functionality for products.
- **Relevant Files:**
    - `app/Http/Controllers/ProductController.php`
    - `app/Models/Product.php`
    - `app/Models/Category.php`
    - `app/Models/ProductImage.php`
    - `database/migrations/*_create_products_table.php`
    - `database/migrations/*_create_categories_table.php`
    - `database/migrations/*_create_product_images_table.php`
    - `resources/views/user/pages/products.blade.php`
    - `resources/views/user/pages/product-detail.blade.php`

### 4.5. Order Management
- **Description:** Handles order creation, tracking, and order items.
- **Key Functionality:**
    - Create new orders.
    - Track order status (pending, processing, shipped, delivered).
    - View order history and details.
- **Relevant Files:**
    - `app/Http/Controllers/OrderController.php`
    - `app/Models/Order.php`
    - `app/Models/OrderItem.php`
    - `database/migrations/*_create_orders_table.php`
    - `database/migrations/*_create_order_items_table.php`
    - `resources/views/user/pages/my-orders.blade.php`

### 4.6. Shop Management
- **Description:** Manages individual shops within the platform.
- **Key Functionality:**
    - Create and manage shop profiles.
    - Assign products to specific shops.
- **Relevant Files:**
    - `app/Http/Controllers/ShopController.php`
    - `app/Models/Shop.php`
    - `database/migrations/*_create_shops_table.php`

### 4.7. CMS Content
- **Description:** Manages static content pages.
- **Key Functionality:**
    - Create and edit static content pages (e.g., About Us, Contact Us).
- **Relevant Files:**
    - `app/Models/CmsContent.php`
    - `database/migrations/*_create_cms_contents_table.php`

### 4.8. Permissions
- **Description:** Manages user permissions and roles.
- **Key Functionality:**
    - Define roles and assign permissions.
    - Control access to different parts of the application based on user roles.
- **Relevant Files:**
    - `app/Models/Permission.php`
    - `database/migrations/*_create_permissions_table.php`
    - `database/migrations/*_create_user_permissions_table.php`

## 5. How it Works
The application follows a standard Model-View-Controller (MVC) architecture provided by the Laravel framework. Frontend interactions are handled by Blade templates and JavaScript, while backend logic is managed by PHP controllers and models. Data is stored in a MySQL database, with migrations used for schema management and seeders for initial data population. Authentication is session-based, ensuring secure access for both users and administrators.

## 6. Future Considerations
- Integration with payment gateways.
- Advanced search and filtering options.
- Real-time notifications.
- API for mobile applications.
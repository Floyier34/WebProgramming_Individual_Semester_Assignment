# Online Electronics Store - Full PHP & MySQL Project

An e-commerce web application built with PHP and MySQL. It features a complete shopping experience with user authentication, product management, a shopping cart, and a dedicated admin panel for managing the store's inventory.

## Features

*   **User Authentication System:**
    *   Secure Login and Registration with bcrypt password hashing.
    *   Role-based access control (Admin vs. User).
*   **Customer Experience (Public Storefront):**
    *   Browse devices by category or brand.
    *   Search for specific electronics.
    *   Shopping Cart management (Add, Remove, Clear).
    *   Responsive and modern user interface.
*   **Admin Panel:**
    *   Secure dashboard accessible only by administrators.
    *   Manage Devices (Add, Edit, Delete).
    *   Manage Categories (Add, Edit, Delete).
    *   Manage Brands (Add, Edit, Delete).

## Demo Login Accounts

You can test the application using the following credentials, or you can register a new regular user account on the login page:

**Admin Account:**
*   **Email:** `admin@example.com`
*   **Password:** `admin123`

*(Note: Logging in with an admin account will redirect you to the Admin Panel, while regular users are redirected to the main storefront.)*

## Tech Stack

*   **Backend:** PHP
*   **Database:** MySQL
*   **Frontend:** HTML, CSS, JavaScript

## Setup Instructions

1.  Clone or download the repository to your local server (e.g., `htdocs` for XAMPP).
2.  Set up the database:
    *   Create a database named `online_electronics_store_db`.
    *   Import the initial structure and data from `online_electronics_store_db.sql`.
    *   Apply the user authentication migration by importing `db_users_migration.sql` to create the `users` table and default admin.
3.  Ensure your database connection details match your local setup in `db_conn.php` and `login-register/config.php`.
4.  Navigate to the project folder in your browser (e.g., `http://localhost/Electronic_market_semester_ver.02/electronics-store-main/public/`).

---

## Reference Source (Original Project Information)

# Online Book Store - Full PHP & MYSQL Project

version: 1.0.0

### Admin User Name : eliasfsdev@gmail.com

### Admin Password : 12345

## Full Tutorial

[On Youtube](https://youtube.com/playlist?list=PL2WFgdVk-usF5q_zBoHCFeGEj7NCQ_YLq)

## DEMO

[DEMO](https://youtu.be/IMCHi-5Ig40)

## Authors

[Elias Abdurrahman](https://github.com/codingWithElias)
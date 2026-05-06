# Online Electronics Store - Complete Project Architecture & Backend Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Technology Stack](#technology-stack)
3. [Project Structure](#project-structure)
4. [Database Architecture](#database-architecture)
5. [Core Components & Modules](#core-components--modules)
6. [Authentication & Authorization Flow](#authentication--authorization-flow)
7. [Data Flow Architecture](#data-flow-architecture)
8. [API Endpoints & Actions](#api-endpoints--actions)
9. [Key Functionalities](#key-functionalities)
10. [Security Measures](#security-measures)
11. [Session Management](#session-management)
12. [File Upload System](#file-upload-system)

---

## Project Overview

### What is this project?
An **e-commerce web application** for selling electronics online. It provides:
- A **customer-facing storefront** where users can browse, search, and purchase products
- An **admin dashboard** for managing inventory (products, categories, brands)
- A **secure authentication system** with role-based access control
- A **shopping cart system** for managing purchases

### Key Features
- **User Authentication**: Secure login/registration with bcrypt password hashing
- **Role-Based Access**: Separate interfaces for customers and administrators
- **Product Management**: Browse devices by category, brand, or search term
- **Shopping Cart**: Add/remove items, view cart total
- **Admin Panel**: CRUD operations for devices, categories, and brands
- **Pagination**: Large product lists are paginated for better performance
- **File Management**: Upload device images and documentation files

---

## Technology Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 7.x+ with PDO/MySQLi |
| **Database** | MySQL 5.7+ |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Server** | Apache (XAMPP) |
| **Session Management** | PHP Sessions |
| **Password Security** | bcrypt (via password_hash/password_verify) |

---

## Project Structure

```
electronics-store-main/
│
├── config/db_conn.php                    # Main database connection (PDO)
├── README.md                       # Project overview
├── PROJECT_ARCHITECTURE.md         # This file - detailed documentation
│
├── admin/                          # Admin management interface
│   ├── admin.php                   # Admin dashboard
│   ├── add-device.php              # Device creation form
│   ├── edit-device.php             # Device editing form
│   ├── add-category.php            # Category creation form
│   ├── edit-category.php           # Category editing form
│   ├── add-brand.php               # Brand creation form
│   └── edit-brand.php              # Brand editing form
│
├── public/                         # Public customer interface
│   ├── index.php                   # Store homepage (product listing)
│   ├── login.php                   # Login/registration interface
│   ├── logout.php                  # Session termination
│   ├── device.php                  # Single product detail page
│   ├── category.php                # Products filtered by category
│   ├── brand.php                   # Products filtered by brand
│   ├── search.php                  # Search results page
│   ├── cart.php                    # Shopping cart page
│   ├── buy.php                     # Checkout page
│   ├── contact.php                 # Contact page
│   ├── about.php                   # About page
│   ├── sitemap.php                 # Site navigation
│   ├── main.js                     # Client-side JavaScript
│   └── login.php                   # Auth redirect page
│
├── php/                            # Backend business logic & helpers
│   │
│   ├── ===== HELPER FUNCTIONS =====
│   ├── func-device.php             # Device query functions
│   ├── func-category.php           # Category query functions
│   ├── func-brand.php              # Brand query functions
│   ├── func-validation.php         # Form validation utilities
│   ├── func-file-upload.php        # File upload handler
│   ├── func-encryption.php         # Password encryption utilities
│   ├── func-location.php           # Location/redirection helpers
│   │
│   ├── ===== ACTION HANDLERS =====
│   ├── auth.php                    # User authentication (login)
│   ├── action-add-to-cart.php      # Add item to cart
│   ├── action-remove-from-cart.php # Remove item from cart
│   ├── action-clear-cart.php       # Clear entire cart
│   ├── action-add-device.php       # Create new device
│   ├── action-edit-device.php      # Update existing device
│   ├── action-delete-device.php    # Remove device
│   ├── action-add-category.php     # Create new category
│   ├── action-edit-category.php    # Update category
│   ├── action-delete-category.php  # Remove category
│   ├── action-add-brand.php        # Create new brand
│   ├── action-edit-brand.php       # Update brand
│   ├── action-delete-brand.php     # Remove brand
│   ├── delete-brand.php            # Delete brand endpoint
│   ├── delete-category.php         # Delete category endpoint
│   ├── delete-device.php           # Delete device endpoint
│   ├── ajax-search.php             # AJAX search functionality
│   │
│   └── partials/                   # Reusable UI components
│       ├── device-card.php         # Product card template
│       ├── store-navbar.php        # Navigation bar
│       └── store-footer.php        # Footer
│
├── login-register/                 # Authentication module
│   ├── config.php                  # Auth database config (MySQLi)
│   ├── index.php                   # Auth entry point
│   ├── Authentication_display.php  # Auth UI rendering
│   ├── login_register.php          # Core auth logic
│   ├── verify-reset-code.php       # Password reset verification
│   ├── reset-password-handler.php  # Password reset processing
│   ├── new-password-reset.php      # New password form
│   ├── password-changed.php        # Confirmation page
│   ├── forgot-password.php         # Password reset initiation
│   ├── admin_page.php              # Admin redirect after login
│   ├── guest_page.php              # Customer redirect after login
│   ├── user_page.php               # User profile/dashboard
│   ├── main.js                     # Auth UI interactions
│   └── style.css                   # Auth styling
│
├── css/                            # Stylesheets
│   ├── style.css                   # Main styles
│   └── custom-elements.css         # Custom component styles
│
├── img/                            # Static images
│
├── uploads/                        # User-uploaded files (runtime generated)
│   ├── images/                     # Device product images
│   └── files/                      # Device documentation files
│
└── Uploads/                        # Alternative upload directory
    └── files/
```

---

## Database Architecture

### Database Name: `online_electronics_store_db`

### Core Tables

#### 1. **users** Table
Stores user account information and authentication data.

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),         -- bcrypt hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Usage**: User authentication and profile management
**Key Field**: `password` is stored as bcrypt hash for security

#### 2. **devices** Table
Stores product information for all devices in the store.

```sql
CREATE TABLE devices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    price DECIMAL(10, 2),
    short_description TEXT,        -- Brief product summary
    description TEXT,              -- Full product details
    brand_id INT,                  -- Foreign key to brands table
    category_id INT,               -- Foreign key to categories table
    image VARCHAR(255),            -- Image filename
    file VARCHAR(255),             -- Documentation file
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

**Usage**: Product catalog management
**Key Fields**: 
- `image`: Stored as filename in /uploads/images/
- `file`: Stored as filename in /uploads/files/

#### 3. **categories** Table
Product categorization system (e.g., Smartphones, Laptops, Accessories).

```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Usage**: Organizing products by type
**Example Values**: "Smartphones", "Laptops", "Tablets"

#### 4. **brands** Table
Manufacturer/brand information (e.g., Apple, Samsung, Sony).

```sql
CREATE TABLE brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Usage**: Organizing products by manufacturer
**Example Values**: "Apple", "Samsung", "Sony", "Dell"

### Table Relationships

```
devices
├── FOREIGN KEY (brand_id) → brands(id)
└── FOREIGN KEY (category_id) → categories(id)

users (independent)
```

---

## Core Components & Modules

### 1. **Authentication & Authorization Module** (`php/auth.php`)
**Purpose**: Handle user login and session establishment
**Flow**:
1. User submits login form (email + password)
2. System validates form inputs
3. Query database for user by email
4. Compare submitted password with stored bcrypt hash
5. On success: Create session variables (`user_id`, `user_email`)
6. Redirect to admin dashboard (for admin users)

**Security Measures**:
- Use prepared statements to prevent SQL injection
- Passwords stored as bcrypt hashes
- Password verification using `password_verify()`
- Session-based authentication

### 2. **Shopping Cart Module**
**Components**:
- `action-add-to-cart.php` - Add products to session cart
- `action-remove-from-cart.php` - Remove specific products
- `action-clear-cart.php` - Empty entire cart

**Storage**: Session variable `$_SESSION['cart']` stores array of device IDs
**Flow**:
1. User clicks "Add to Cart" on product page
2. System validates device ID exists
3. Add device ID to cart array if not already present
4. Display success message and redirect

### 3. **Product Management Module** (CRUD Operations)
**Devices** (`action-add-device.php`, `action-edit-device.php`, `action-delete-device.php`):
- Create: Validate inputs, upload image/file, insert database record
- Read: Query device details via `func-device.php`
- Update: Modify existing product information
- Delete: Remove product from database

**Categories** (`action-add-category.php`, etc.):
- Manage product categories
- Prevent orphaned products when deleting

**Brands** (`action-add-brand.php`, etc.):
- Manage product manufacturers
- Prevent orphaned products when deleting

### 4. **Search & Filter Module** (`ajax-search.php`)
**Purpose**: Provide real-time product search functionality
**Features**:
- AJAX-based searches (no page reload)
- Filter by name, category, brand, price range
- Pagination support

### 5. **File Upload Module** (`func-file-upload.php`)
**Purpose**: Securely handle device image and documentation uploads
**Process**:
1. Validate file type against whitelist
2. Rename file using `uniqid()` to prevent name collisions
3. Move file to appropriate directory (`/uploads/images/` or `/uploads/files/`)
4. Return filename or error status

**Supported Files**:
- Images: jpg, jpeg, png
- Documents: pdf, docx, pptx

---

## Authentication & Authorization Flow

### Login Flow Diagram
```
User                    Frontend                    Backend                Database
  │                         │                          │                      │
  ├─ Enter Email/Pass ─────>│                          │                      │
  │                         ├─ POST to auth.php ──────>│                      │
  │                         │                          ├─ Validate inputs    │
  │                         │                          ├─ Query user ────────>│
  │                         │                          │<─ User record ───────┤
  │                         │                          ├─ Verify password    │
  │                         │                          ├─ Create session     │
  │                         │<─ Redirect to admin ─────┤                      │
  │<─ Redirect ─────────────┤                          │                      │
```

### Session Management
```
Login             Session Created              Pages Protected              Logout
  │                    │                            │                         │
  v                    v                            v                         v
Session Start    $_SESSION['user_id']      if (!isset($_SESSION))    session_destroy()
              $_SESSION['user_email']     redirect to login.php       Remove session data
```

### Authorization Levels
1. **Unauthenticated**: Access to public store only
2. **Authenticated User**: Access to cart and checkout (when implemented)
3. **Administrator**: Access to admin panel and CRUD operations

---

## Data Flow Architecture

### Product View Flow (Homepage)
```
User visits index.php
        │
        ├─ Include config/db_conn.php (establish DB connection)
        │
        ├─ Include func-device.php (load device functions)
        │
        ├─ Call count_devices($conn)
        │    └─ Returns total device count
        │
        ├─ Calculate pagination
        │    ├─ $page = current page (from GET)
        │    ├─ $per_page = 9
        │    └─ $offset = ($page - 1) * $per_page
        │
        ├─ Call get_devices_paginated($conn, 9, $offset, $sort)
        │    └─ Query: SELECT * FROM devices ORDER BY ... LIMIT 9 OFFSET $offset
        │    └─ Returns array of device objects
        │
        ├─ Loop through devices
        │    └─ Include device-card.php for each device
        │         └─ Display product info (image, price, description)
        │
        └─ Render pagination links
             └─ Links to next/previous pages
```

### Add to Cart Flow
```
User clicks "Add to Cart" on device detail page
        │
        ├─ GET request to action-add-to-cart.php?id=5&redirect=device
        │
        ├─ Validate device ID exists
        │    ├─ Query: SELECT * FROM devices WHERE id=?
        │    └─ If not found, redirect with error
        │
        ├─ Check session cart array
        │    └─ if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        │
        ├─ Add device ID to array
        │    └─ if (!in_array($id, $_SESSION['cart'])) $_SESSION['cart'][] = $id;
        │
        └─ Redirect back with success message
             └─ Display "Added to cart" notification
```

### Add Device (Admin) Flow
```
Admin fills device form and submits
        │
        ├─ POST to action-add-device.php
        │
        ├─ Check admin session
        │    └─ if (!isset($_SESSION['user_id'])) redirect to login
        │
        ├─ Validate all form inputs
        │    ├─ Check required fields not empty
        │    ├─ Validate price is numeric
        │    ├─ Verify category_id and brand_id exist
        │    └─ Redirect with error if validation fails
        │
        ├─ Handle file uploads
        │    ├─ Upload device image
        │    │   └─ Validate extension, rename, move to /uploads/images/
        │    └─ Upload documentation file
        │         └─ Validate extension, rename, move to /uploads/files/
        │
        ├─ Insert device record
        │    └─ INSERT INTO devices VALUES (name, price, desc, brand_id, cat_id, image, file)
        │
        └─ Redirect to admin panel with success/error message
```

---

## API Endpoints & Actions

### Authentication Endpoints
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/auth.php` | POST | Process login request |
| `public/logout.php` | GET | Terminate session |

### Shopping Cart Endpoints
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/action-add-to-cart.php` | GET | Add device to cart |
| `php/action-remove-from-cart.php` | GET | Remove device from cart |
| `php/action-clear-cart.php` | GET | Clear entire cart |

### Device Management Endpoints (Admin)
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/action-add-device.php` | POST | Create new device |
| `php/action-edit-device.php` | POST | Update existing device |
| `php/action-delete-device.php` | GET | Delete device |

### Category Management Endpoints (Admin)
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/action-add-category.php` | POST | Create new category |
| `php/action-edit-category.php` | POST | Update category |
| `php/action-delete-category.php` | GET | Delete category |

### Brand Management Endpoints (Admin)
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/action-add-brand.php` | POST | Create new brand |
| `php/action-edit-brand.php` | POST | Update brand |
| `php/action-delete-brand.php` | GET | Delete brand |

### Search Endpoints
| Endpoint | Method | Purpose |
|----------|--------|---------|
| `php/ajax-search.php` | GET/AJAX | Search products by query |
| `public/search.php` | GET | Display search results page |

---

## Key Functionalities

### 1. **Pagination System** (Index Page)
- **Purpose**: Handle large product lists efficiently
- **Implementation**: 
  - `get_devices_paginated()` queries with LIMIT and OFFSET
  - Frontend renders page links (Previous, 1, 2, 3, Next)
  - Preserves sort parameter across pagination

### 2. **Sorting System**
- **Available Sorts**: 
  - `newest` (default) - Most recently added
  - `oldest` - Oldest first
  - `name_asc` - A-Z alphabetical
  - `name_desc` - Z-A alphabetical
  - `price_asc` - Low to high price
  - `price_desc` - High to low price
- **Implementation**: `get_device_sort_sql()` converts sort parameter to SQL ORDER BY clause

### 3. **Session-Based Cart**
- **Storage**: PHP session array `$_SESSION['cart']`
- **Persistence**: Lost when session ends (no database storage)
- **Operations**: Add, remove, clear, count items

### 4. **Product Short Description**
- **Logic**: `get_short_description()` function
  - If `short_description` field exists and not empty, use it
  - Otherwise, truncate `description` to 120 characters
  - Append "..." if truncated

### 5. **File Upload with Security**
- **Validation**: Check file extension against whitelist
- **Naming**: Rename to `uniqid() + extension` to prevent collisions
- **Directory**: Create if not exists with `mkdir(0777, true)`
- **Error Handling**: Return error array if any step fails

---

## Security Measures

### 1. **SQL Injection Prevention**
- **Method**: Prepared statements with parameter binding
- **Example**:
  ```php
  $sql = "SELECT * FROM users WHERE email=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$email]);
  ```
- **NOT**: Never concatenate user input into SQL strings

### 2. **Password Security**
- **Storage**: bcrypt hashing via `password_hash()`
- **Verification**: `password_verify()` function
- **Never**: Store plain text passwords or use weak hashing

### 3. **Session Security**
- **Protection**: `session_start()` at top of protected pages
- **Check**: Verify `$_SESSION['user_id']` and `$_SESSION['user_email']` exist
- **Guard Clause**: Redirect to login if session not set

### 4. **File Upload Security**
- **Whitelist**: Only allowed extensions (jpg, jpeg, png, pdf, docx, pptx)
- **Rename**: Use random uniqid() to prevent overwriting
- **Location**: Store outside web root if possible (currently in uploads/)
- **Validation**: Check MIME type and file size (can be enhanced)

### 5. **Input Validation**
- **Form Data**: Check for empty fields, proper data types
- **Type Casting**: Cast price to float, IDs to int
- **Trim**: Remove whitespace from strings
- **Redirect**: Always handle validation errors gracefully

### 6. **Error Handling**
- **Redirect**: Send errors via URL parameters instead of exposing details
- **Example**: `?error=Invalid+input` instead of raw error messages
- **TODO**: Implement logging for security audit trail

---

## Session Management

### Session Initialization
```php
session_start();  // Must be at top of every protected page
```

### Session Variables Used
```php
$_SESSION['user_id']    // User ID from database
$_SESSION['user_email'] // User email address
$_SESSION['cart']       // Array of device IDs in cart
```

### Session Flow
1. **Login**: `auth.php` sets `user_id` and `user_email` after successful authentication
2. **Persistence**: Session persists across page requests
3. **Cart**: `$_SESSION['cart']` initialized as empty array on first access
4. **Logout**: `logout.php` calls `session_destroy()` to clear session

### Session Security Considerations
- Sessions stored server-side (secure)
- Session ID in cookie (cannot be manipulated by client)
- TODO: Implement session timeout after inactivity
- TODO: Implement CSRF token for form submissions

---

## File Upload System

### Upload Process
```
User uploads file
        │
        ├─ Check file['error'] === 0
        │    └─ If not, return error
        │
        ├─ Get file extension from filename
        │    └─ $file_ex = pathinfo($file_name, PATHINFO_EXTENSION)
        │
        ├─ Convert extension to lowercase
        │    └─ $file_ex_lc = strtolower($file_ex)
        │
        ├─ Check extension in whitelist
        │    └─ if (!in_array($file_ex_lc, $allowed_exs)) return error
        │
        ├─ Generate unique filename
        │    └─ $new_file_name = uniqid("",true).'.'.$file_ex_lc
        │    └─ Example: "629f8c9a32a0d.4432.jpg"
        │
        ├─ Create upload directory if needed
        │    └─ mkdir('../uploads/'.$path, 0777, true)
        │
        ├─ Move file from temp location to uploads
        │    └─ move_uploaded_file($tmp_name, $upload_path)
        │
        └─ Return success with filename
             └─ Store filename in database
             └─ File accessible at: ../uploads/{path}/{filename}
```

### Directory Structure
```
uploads/
├── images/           # Device product images
│   ├── 629f8c9a32a0d.4432.jpg
│   ├── 629f8cbe4a8c2.5631.png
│   └── ...
└── files/            # Device documentation
    ├── 629f8c9c40a9e.1234.pdf
    ├── 629f8cb5c4d32.5678.docx
    └── ...
```

---

## Connection Configuration

### Two Connection Methods in Project

#### 1. **Main Connection** (`config/db_conn.php`) - PDO
```php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "online_electronics_store_db";

$conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

**Used by**: Most backend files (devices, categories, brands, cart, admin operations)
**Advantage**: Object-oriented, more secure, prepared statements

#### 2. **Auth Connection** (`login-register/config.php`) - MySQLi
```php
$host = "localhost";
$username = "root";
$password = "";
$database = "online_electronics_store_db";

$conn = new mysqli($host, $username, $password, $database);
```

**Used by**: Authentication module only
**Note**: Should ideally be unified with PDO for consistency

### Configuration Changes Required for Deployment
Update both files with production database credentials:
- `config/db_conn.php`
- `login-register/config.php`

---

## Common Patterns & Conventions

### Guard Clauses
```php
// Check if required POST parameters exist
if (!isset($_POST['device_name']) || !isset($_POST['device_price'])) {
    header("Location: ../admin/admin.php");
    exit;
}

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}
```

### Error Response Pattern
```php
// Build error message with user input preserved for re-form filling
$user_input = 'name='.urlencode($name).'&price='.urlencode($price);
$em = "The price must be a valid number";
header("Location: ../admin/add-device.php?error=$em&$user_input");
exit;
```

### Success Response Pattern
```php
$sm = "The device successfully created!";
header("Location: ../admin/add-device.php?success=$sm");
exit;
```

### Query Pattern
```php
// Always use prepared statements with parameter binding
$sql = "SELECT * FROM table WHERE column = ? AND status = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$param1, $param2]);

if ($stmt->rowCount() > 0) {
    $result = $stmt->fetchAll();
} else {
    $result = 0;  // Returns 0 if no results
}
```

---

## Additional Resources

- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- PDO Tutorial: https://www.php.net/manual/en/book.pdo.php
- Password Hashing: https://www.php.net/manual/en/function.password-hash.php
- Sessions: https://www.php.net/manual/en/book.session.php

---

**Document Version**: 1.0  
**Last Updated**: 2026-05-06  
**Project Status**: Complete for demo

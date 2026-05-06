<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if all required input fields are provided
if (!isset($_POST['device_name']) ||
    !isset($_POST['device_short_description']) ||
    !isset($_POST['device_description']) ||
    !isset($_POST['device_price']) ||
    !isset($_POST['device_brand']) ||
    !isset($_POST['device_category']) ||
    !isset($_FILES['device_image']) ||
    !isset($_FILES['file'])) {
    
    header("Location: ../admin/admin.php");
    exit;
}

# Database and Helper Functions
include "../config/db_conn.php";
include "func-validation.php";
include "func-file-upload.php";

/** 
Get data from POST request 
and store them in var
**/
$name              = trim($_POST['device_name']);
$short_description = trim($_POST['device_short_description']);
$description       = trim($_POST['device_description']);
$price             = $_POST['device_price'];
$brand             = $_POST['device_brand'];
$category          = $_POST['device_category'];

# making URL data format
$user_input = 'name='.$name.'&short_desc='.$short_description.'&category_id='.$category.'&desc='.$description.'&brand_id='.$brand.'&price='.$price;

# Form Validation using helper function
$location = "../admin/add-device.php";
$ms = "error";

is_empty($name, "Device name", $location, $ms, $user_input);
is_empty($short_description, "Short description", $location, $ms, $user_input);
is_empty($description, "Full description", $location, $ms, $user_input);
is_empty($brand, "Device brand", $location, $ms, $user_input);
is_empty($category, "Device category", $location, $ms, $user_input);

if ($price === "" || !is_numeric($price) || $price < 0) {
    $em = "The price must be a valid number";
    header("Location: ../admin/add-device.php?error=$em&$user_input");
    exit;
}
$price = number_format((float) $price, 2, '.', '');

# Handle Device Image Upload
$allowed_image_exs = array("jpg", "jpeg", "png");
$path = "images";
$device_image = upload_file($_FILES['device_image'], $allowed_image_exs, $path);

if ($device_image['status'] == "error") {
    $em = $device_image['data'];
    header("Location: ../admin/add-device.php?error=$em&$user_input");
    exit;
}

# Handle File Upload
$allowed_file_exs = array("pdf", "docx", "pptx", "jpg", "jpeg", "png");
$path = "files";
$file = upload_file($_FILES['file'], $allowed_file_exs, $path);

if ($file['status'] == "error") {
    // Note: if image was uploaded above, we should ideally delete it, but preserving original logic.
    $em = $file['data'];
    header("Location: ../admin/add-device.php?error=$em&$user_input");
    exit;
}

$file_URL = $file['data'];
$device_image_URL = $device_image['data'];

// Validate brand_id and category_id exist before insert.

# Insert the data into database
$sql  = "INSERT INTO devices (name, price, short_description, brand_id, description, category_id, image, file)
         VALUES (?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category, $device_image_URL, $file_URL]);

if ($res) {
    $sm = "The device successfully created!";
    header("Location: ../admin/add-device.php?success=$sm");
    exit;
} else {
    $em = "Unknown Error Occurred!";
    header("Location: ../admin/add-device.php?error=$em");
    exit;
}

<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if all required input fields are provided
if (!isset($_POST['device_id']) ||
    !isset($_POST['device_name']) ||
    !isset($_POST['device_short_description']) ||
    !isset($_POST['device_description']) ||
    !isset($_POST['device_price']) ||
    !isset($_POST['device_brand']) ||
    !isset($_POST['device_category']) ||
    !isset($_FILES['device_image']) ||
    !isset($_FILES['file']) ||
    !isset($_POST['current_image']) ||
    !isset($_POST['current_file'])) {
    
    header("Location: ../admin/admin.php");
    exit;
}

# Database and Helper Functions
include "../db_conn.php";
include "func-validation.php";
include "func-file-upload.php";

/** 
Get data from POST request 
and store them in var
**/
$id          = $_POST['device_id'];
$name        = trim($_POST['device_name']);
$short_description = trim($_POST['device_short_description']);
$description = trim($_POST['device_description']);
$price       = $_POST['device_price'];
$brand       = $_POST['device_brand'];
$category    = $_POST['device_category'];
$current_image = $_POST['current_image'];
$current_file  = $_POST['current_file'];

# Form Validation using helper function
$location = "../admin/edit-device.php";
$ms = "id=$id&error";

is_empty($name, "Device name", $location, $ms, "");
is_empty($short_description, "Short description", $location, $ms, "");
is_empty($description, "Full description", $location, $ms, "");
is_empty($brand, "Device brand", $location, $ms, "");
is_empty($category, "Device category", $location, $ms, "");

if ($price === "" || !is_numeric($price) || $price < 0) {
    $em = "The price must be a valid number";
    header("Location: ../admin/edit-device.php?error=$em&id=$id");
    exit;
}
$price = number_format((float) $price, 2, '.', '');

$has_new_image = !empty($_FILES['device_image']['name']);
$has_new_file = !empty($_FILES['file']['name']);

// Default URLs to current files
$device_image_URL = $current_image;
$file_URL = $current_file;

// TODO: Consider wrapping file operations and DB updates in a transaction.

# Handle Image Upload
if ($has_new_image) {
    $allowed_image_exs = array("jpg", "jpeg", "png");
    $path = "images";
    $device_image = upload_file($_FILES['device_image'], $allowed_image_exs, $path);
    
    if ($device_image['status'] == "error") {
        $em = $device_image['data'];
        header("Location: ../admin/edit-device.php?error=$em&id=$id");
        exit;
    }
    $device_image_URL = $device_image['data'];
}

# Handle File Upload
if ($has_new_file) {
    $allowed_file_exs = array("pdf", "docx", "pptx");
    $path = "files";
    $file_upload = upload_file($_FILES['file'], $allowed_file_exs, $path);
    
    if ($file_upload['status'] == "error") {
        // Note: If image was uploaded successfully above, it might be orphaned here if we exit.
        // Handling that is beyond simple refactoring, so we preserve original behavior.
        $em = $file_upload['data'];
        header("Location: ../admin/edit-device.php?error=$em&id=$id");
        exit;
    }
    $file_URL = $file_upload['data'];
}

# Delete old files if new ones were uploaded successfully
if ($has_new_image && $current_image !== 'empty.png') {
    $c_p_device_image = "../uploads/images/$current_image";
    if (file_exists($c_p_device_image)) {
        unlink($c_p_device_image);
    }
}

if ($has_new_file && $current_file !== 'empty.png') {
    $c_p_file = "../uploads/files/$current_file";
    if (file_exists($c_p_file)) {
        unlink($c_p_file);
    }
}

# Update database record
$sql = "UPDATE devices
        SET name=?,
            price=?,
            short_description=?,
            brand_id=?,
            description=?,
            category_id=?,
            image=?,
            file=?
        WHERE id=?";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category, $device_image_URL, $file_URL, $id]);

if (!$res) {
    $em = "Unknown Error Occurred!";
    header("Location: ../admin/edit-device.php?error=$em&id=$id");
    exit;
}

$sm = "Successfully updated!";
header("Location: ../admin/edit-device.php?success=$sm&id=$id");
exit;


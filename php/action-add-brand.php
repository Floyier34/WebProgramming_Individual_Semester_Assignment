<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if author name is submitted
if (!isset($_POST['brand_name'])) {
    header("Location: ../admin/admin.php");
    exit;
}

# Database Connection File
include "../config/db_conn.php";

/** 
Get data from POST request 
and store it in var
**/
$name = trim($_POST['brand_name']);

# simple form Validation
if (empty($name)) {
    $em = "The brand name is required";
    header("Location: ../admin/add-brand.php?error=$em");
    exit;
}

// Enforce unique brand names at the database level.
# Insert Into Database
$sql  = "INSERT INTO brands (name) VALUES (?)";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$name]);

/**
  If there is no error while 
  inserting the data
**/
if ($res) {
    # success message
    $sm = "Successfully created!";
    header("Location: ../admin/add-brand.php?success=$sm");
    exit;
} else {
    # Error message
    $em = "Unknown Error Occurred!";
    header("Location: ../admin/add-brand.php?error=$em");
    exit;
}

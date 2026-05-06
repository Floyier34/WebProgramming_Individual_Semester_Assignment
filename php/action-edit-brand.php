<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if author name is submitted
if (!isset($_POST['brand_name']) || !isset($_POST['brand_id'])) {
    header("Location: ../admin/admin.php");
    exit;
}

# Database Connection File
include "../config/db_conn.php";

/** 
Get data from POST request 
and store them in var
**/
$name = trim($_POST['brand_name']);
$id   = $_POST['brand_id'];

# simple form Validation
if (empty($name)) {
    $em = "The brand name is required";
    header("Location: ../admin/edit-brand.php?error=$em&id=$id");
    exit;
}

// TODO: Enforce unique brand names and validate input length.
# UPDATE the Database
$sql  = "UPDATE brands SET name=? WHERE id=?";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$name, $id]);

/**
  If there is no error while 
  inserting the data
**/
if ($res) {
    # success message
    $sm = "Successfully updated!";
    header("Location: ../admin/edit-brand.php?success=$sm&id=$id");
    exit;
} else {
    # Error message
    $em = "Unknown Error Occurred!";
    header("Location: ../admin/edit-brand.php?error=$em&id=$id");
    exit;
}

<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if the author id set
if (!isset($_GET['id'])) {
    header("Location: ../admin/admin.php");
    exit;
}

# Database Connection File
include "../db_conn.php";

/** 
Get data from GET request 
and store it in var
**/
$id = $_GET['id'];

# simple form Validation
if (empty($id)) {
    $em = "Error Occurred!";
    header("Location: ../admin/admin.php?error=$em");
    exit;
}

// TODO: Prevent deleting a brand that still has devices.
# DELETE the brand from Database
$sql  = "DELETE FROM brands WHERE id=?";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$id]);

/**
  If there is no error while 
  Deleting the data
**/
if ($res) {
    # success message
    $sm = "Successfully removed!";
    header("Location: ../admin/admin.php?success=$sm");
    exit;
} else {
    $em = "Error Occurred!";
    header("Location: ../admin/admin.php?error=$em");
    exit;
}


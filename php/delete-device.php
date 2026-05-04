<?php  
session_start();

# Guard clause: check if the admin is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../public/login.php");
    exit;
}

# Guard clause: check if the device id set
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

# GET device from Database
$sql2  = "SELECT * FROM devices WHERE id=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$id]);
$the_device = $stmt2->fetch();

if ($stmt2->rowCount() === 0) {
    $em = "Error Occurred!";
    header("Location: ../admin/admin.php?error=$em");
    exit;
}

// TODO: Consider soft delete and handle missing files gracefully.
# DELETE the device from Database
$sql  = "DELETE FROM devices WHERE id=?";
$stmt = $conn->prepare($sql);
$res  = $stmt->execute([$id]);

/**
  If there is no error while 
  Deleting the data
**/
if ($res) {
    # delete the current device_image and the file
    $image = $the_device['image'];
    $file  = $the_device['file'];
    $c_b_c = "../uploads/images/$image";
    $c_f = "../uploads/files/$file";
    
    if (file_exists($c_b_c)) unlink($c_b_c);
    if (file_exists($c_f)) unlink($c_f);

    # success message
    $sm = "Successfully removed!";
    header("Location: ../admin/admin.php?success=$sm");
    exit;
} else {
    # Error message
    $em = "Unknown Error Occurred!";
    header("Location: ../admin/admin.php?error=$em");
    exit;
}


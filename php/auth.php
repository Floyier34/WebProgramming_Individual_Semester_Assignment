<?php 
session_start();

if (isset($_POST['email']) && 
	isset($_POST['password'])) {
    
    # Database Connection File
	include "../db_conn.php";
    
    # Validation helper function
	include "func-validation.php";
	
	/** 
	   Get data from POST request 
	   and store them in var
	**/

	$email = $_POST['email'];
	$password = $_POST['password'];

	# simple form validation

	$text = "Email";
	$location = "../public/login.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
	$location = "../public/login.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");

    // TODO: Add login attempt throttling and audit logging.
    # search for the email
    $sql = "SELECT * FROM users 
            WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

	// 1. Check if user exists
	if ($stmt->rowCount() !== 1) {
		$em = "Incorrect User name or password";
		header("Location: ../public/login.php?error=$em");
	}

	$user = $stmt->fetch();
	$user_id = $user['id'];
	$user_email = $user['email'];
	$user_password = $user['password'];

	// 2. Check email
	if ($email !== $user_email) {
		$em = "Incorrect User name or password";
		header("Location: ../public/login.php?error=$em");
	}

	// 3. Verify password
	if (!password_verify($password, $user_password)) {
		$em = "Incorrect User name or password";
		header("Location: ../public/login.php?error=$em");
	}

	// --- SUCCESS PATH ---
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_email'] = $user_email;
	header("Location: ../admin/admin.php");

}else {
	# Redirect to "../public/login.php"
	header("Location: ../public/login.php");
}


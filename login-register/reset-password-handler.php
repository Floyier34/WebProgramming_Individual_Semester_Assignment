<?php 

session_start();
require_once "config.php";

$email = "";
$errors = array();

// Check if email exists in users table and proceed directly to password change
if(isset($_POST['check-email'])){
    $email = $_POST['email'];
    
    $checkEmail = $conn->query("SELECT email FROM users WHERE email='$email'");
    if($checkEmail->num_rows > 0){
        $_SESSION['verified_email'] = $email;
        $_SESSION['info'] = "Email verified. Please enter your new password.";
        header('Location: new-password-reset.php');
        exit();
    }else{
        $errors['email'] = "This email address does not exist in our system.";
    }
}

// Change password
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword'];
    $email = $_SESSION['verified_email'];
    
    if($password !== $confirm_password){
        $errors['password'] = "Passwords do not match!";
    }else{
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $updatePassword = $conn->query("UPDATE users SET password='$hashedPassword', reset_code=0 WHERE email='$email'");
        
        if($updatePassword){
            $_SESSION['info'] = "Your password has been changed successfully. You can now login with your new password.";
            header('Location: password-changed.php');
            exit();
        }else{
            $errors['password'] = "Failed to update password. Please try again.";
        }
    }
}

?>

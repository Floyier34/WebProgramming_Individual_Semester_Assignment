<?php 

session_start();
require_once "config.php";

$email = "";
$errors = array();

// Check if email exists in users table and proceed directly to password change
if(isset($_POST['check-email'])){
    $email = trim($_POST['email']);
    
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $checkEmail = $stmt->get_result();
    
    // Guard clause: Email not found
    if($checkEmail->num_rows === 0){
        $errors['email'] = "This email address does not exist in our system.";
    }
    
    if (empty($errors)) {
        $_SESSION['verified_email'] = $email;
        $_SESSION['info'] = "Email verified. Please enter your new password.";
        $stmt->close();
        header('Location: new-password-reset.php');
        exit();
    }
    
    $stmt->close();
}

// Change password
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword'];
    $email = $_SESSION['verified_email'];
    
    // Guard clause: Password mismatch
    if($password !== $confirm_password){
        $errors['password'] = "Passwords do not match!";
    }
    
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("UPDATE users SET password=?, reset_code=0 WHERE email=?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        
        // Guard clause: Execution failed
        if(!$stmt->execute()){
            $errors['password'] = "Failed to update password. Please try again.";
            $stmt->close();
        } else {
            $_SESSION['info'] = "Your password has been changed successfully. You can now login with your new password.";
            $stmt->close();
            header('Location: password-changed.php');
            exit();
        }
    }
}

?>

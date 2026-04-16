<?php 
session_start();
// If user is not coming from forgot-password.php, redirect them
if(!isset($_SESSION['verified_email'])){
    header('Location: ../public/login.php');
    exit();
}

require_once "config.php";
$errors = array();

if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    if($password !== $cpassword){
        $errors['password'] = "Passwords do not match!";
    } else {
        $email = $_SESSION['verified_email'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Using prepared statement to prevent SQL injection
        $update_pass_sql = "UPDATE users SET password = ?, reset_code = 0 WHERE email = ?";
        $stmt = $conn->prepare($update_pass_sql);
        $stmt->bind_param("ss", $hashedPassword, $email);
        
        if($stmt->execute()){
            $_SESSION['info'] = "Your password has been changed successfully. You can now login with your new password.";
            unset($_SESSION['verified_email']); // Clean up session
            header('Location: password-changed.php');
            exit();
        }else{
            $errors['db-error'] = "Failed to update password. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="login-register-body">
    <div class="login-register-page-container new-password">
        <div class="login-register-form-wrapper">
            <form action="new-password-reset.php" method="POST" autocomplete="off">
                <h1 class="login-register-heading">New Password</h1>
                
                <?php if(isset($_SESSION['info'])){ ?>
                    <div class="login-register-message-box success-message">
                        <?php echo htmlspecialchars($_SESSION['info']); ?>
                    </div>
                <?php 
                    unset($_SESSION['info']); // Show once
                } ?>

                <?php
                if(count($errors) > 0){
                    ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <?php
                        foreach($errors as $error){
                            echo '<div class="login-register-message-box error-message">' . htmlspecialchars($error) . '</div>';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Create new password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="cpassword" placeholder="Confirm your password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <button type="submit" name="change-password" class="btn">Change</button>
            </form>
        </div>
    </div>
</body>
</html>
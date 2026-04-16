<?php 
session_start();
// If user is logged in, redirect them
if (isset($_SESSION['user_id'])) {
    header('Location: ../public/index.php');
    exit();
}

require_once "config.php";
$errors = array();

if(isset($_POST['check-email'])){
    // Using prepared statement to prevent SQL injection
    $email = $_POST['email'];
    $check_email_sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $_SESSION['verified_email'] = $email;
        $_SESSION['info'] = "Email verified. Please enter your new password.";
        header('Location: new-password-reset.php');
        exit();
    }else{
        $errors['email'] = "This email address does not exist in our system.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="login-register-body">
    <div class="login-register-page-container">
        <div class="login-register-form-wrapper">
            <form action="forgot-password.php" method="POST" autocomplete="off">
                <h1 class="login-register-heading">Forgot Password</h1>
                <p class="login-register-description">Enter your email to reset your password.</p>
                
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
                    <input type="email" name="email" placeholder="Enter your email address" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <button type="submit" name="check-email" class="btn">Continue</button>
                
                <p class="login-register-back-link"><a href="../public/login.php">Back to Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
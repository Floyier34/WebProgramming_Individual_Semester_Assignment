<?php 
session_start();
// If user is not coming from new-password-reset.php, redirect them
if(!isset($_SESSION['info'])){
    header('Location: ../public/login.php');
    exit();
}
$info = $_SESSION['info'];
unset($_SESSION['info']); // Clean up session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="login-register-body">
    <div class="login-register-page-container password-changed">
        <div class="login-register-form-wrapper">
            <form action="../public/login.php" method="GET">
                <h1 class="login-register-heading">Success!</h1>
                
                <div class="login-register-message-box success-message">
                    <?php echo htmlspecialchars($info); ?>
                </div>

                <button type="submit" class="btn">Login Now</button>
            </form>
        </div>
    </div>
</body>
</html>
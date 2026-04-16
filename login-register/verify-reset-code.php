<?php require_once "reset-password-handler.php"; ?>
<?php 
$email = $_SESSION['reset_email'] ?? null;
if(!$email){
    header('Location: forgot-password.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reset Code | Login & Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="form-box active">
            <form action="verify-reset-code.php" method="post">
                <h2>Verify Reset Code</h2>
                
                <?php 
                    if(isset($_SESSION['info'])){
                        echo "<p class='success-message'>".$_SESSION['info']."</p>";
                        unset($_SESSION['info']);
                    }
                ?>
                
                <?php 
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error-message'>$error</p>";
                        }
                    }
                ?>
                
                <p style="text-align: center; font-size: 14px; margin-bottom: 20px;">Enter the 6-digit code sent to your email</p>
                
                <input type="number" name="otp" placeholder="Enter verification code" required>
                
                <button type="submit" name="check-reset-otp">Verify Code</button>
                
                <p style="text-align: center; margin-top: 15px;">
                    <a href="forgot-password.php">Didn't receive code? Try again</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>

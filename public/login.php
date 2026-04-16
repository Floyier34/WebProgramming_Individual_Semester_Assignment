<?php
include "../login-register/authentication_display.php";
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - Electronics Store</title>
    <link rel="stylesheet" href="../login-register/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>
    <div class="container <?= ($activeForm === 'register') ? 'active' : ''; ?>">
        <div class="form-box login">
            <form action="../login-register/login_register.php" method="post">
                <h1>Login</h1>
                <?= ($activeForm === 'login') ? displayError($errors['login']) : ''; ?>
                <?= ($activeForm === 'login') ? displaySuccess($success) : ''; ?>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <p>Forgot Password? <a href="../login-register/forgot-password.php">Click Here</a></p>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
                <p style="margin-top: 15px;"><a href="index.php">Back to Store</a></p>
            </form>
        </div>

        <div class="form-box register">
            <form action="../login-register/login_register.php" method="post">
                <h1>Register</h1>
                <?= ($activeForm === 'register') ? displayError($errors['register']) : ''; ?>
                <div class="input-box">
                    <input type="text" name="name" placeholder="Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm-password" placeholder="Confirm Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box" style="margin: 20px 0;">
                    <select name="role" required style="width: 100%; padding: 12px 50px 13px 20px; background: #eee; font-size: 16px; border: none; outline: none; border-radius: 8px; color: #333; font-weight: 500; appearance: none;">
                        <option value="">--Select Role--</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <i class='bx bxs-chevron-down' style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);"></i>
                </div>
                <button type="submit" name="register" class="btn">Register</button>
                <p style="margin-top: 15px;"><a href="index.php">Back to Store</a></p>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Welcome Back!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn" type="button">Register</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Hello, Friend!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn" type="button">Login</button>
            </div>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>






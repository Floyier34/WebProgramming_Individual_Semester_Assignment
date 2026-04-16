<?php

session_start();
require_once "config.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = $_POST['role'];

    if ($password !== $confirmPassword) {
        $_SESSION['register_error'] = "Passwords do not match.";
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/login.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $checkEmail = $conn->query("SELECT email FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = "Email is already exists.";
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', '$role')");
        $_SESSION['register_success'] = "Registration successful. Please login.";
        $_SESSION['active_form'] = 'login';
    }
    header("Location: ../public/login.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
           
            if ($user['role'] == 'admin') {
                header("Location: ../admin/admin.php");
            } else {
                header("Location: ../public/index.php");
            }
        exit();
        }
    }
    $_SESSION['login_error'] = "Wrong email or password.";
    $_SESSION['active_form'] = 'login';
    header("Location: ../public/login.php");
    exit();
}

?>




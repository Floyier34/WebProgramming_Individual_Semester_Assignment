<?php

session_start();
require_once "config.php";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = $_POST['role'];

    // Input Validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['register_error'] = "All fields are required.";
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/login.php");
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['register_error'] = "Password must be at least 8 characters long.";
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/login.php");
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['register_error'] = "Passwords do not match.";
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/login.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepared statement to check if email exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $checkEmail = $stmt->get_result();

    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = "Email already exists.";
        $_SESSION['active_form'] = 'register';
    } else {
        // Prepared statement to insert new user
        $insertStmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $insertStmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        if ($insertStmt->execute()) {
            $_SESSION['register_success'] = "Registration successful. Please login.";
            $_SESSION['active_form'] = 'login';
        } else {
            $_SESSION['register_error'] = "Something went wrong. Please try again.";
            $_SESSION['active_form'] = 'register';
        }
        $insertStmt->close();
    }
    $stmt->close();

    header("Location: ../public/login.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email and password are required.";
        $_SESSION['active_form'] = 'login';
        header("Location: ../public/login.php");
        exit();
    }

    // Prepared statement to get user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

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
    $stmt->close();

    $_SESSION['login_error'] = "Wrong email or password.";
    $_SESSION['active_form'] = 'login';
    header("Location: ../public/login.php");
    exit();
}

?>




<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? null,
    'register' => $_SESSION['register_error'] ?? null,
];

$success = $_SESSION['register_success'] ?? null;
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function displayError($error) {
    return !empty($error)? "<p class='error-message'>{$error}</p>" : "";
}

function displaySuccess($message) {
    return !empty($message)? "<p class='success-message'>{$message}</p>" : "";
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>
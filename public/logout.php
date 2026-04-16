<?php 

session_start();

// Clear all session variables
session_unset();
session_destroy();

// Redirect to login or home page
header("Location: login.php");
exit;






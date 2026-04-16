<?php

// Use the main application database instead of separate user_db
$host = "localhost";
$username = "root";
$password = "";
$database = "online_electronics_store_db"; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


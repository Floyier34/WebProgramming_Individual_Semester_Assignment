<?php
session_start();

# If device ID is not set
if (!isset($_GET['id'])) {
	header("Location: ../public/cart.php?error=Missing device ID");
	exit;
}

$id = (int) $_GET['id'];
$redirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : "";

# Database Connection File
include "../db_conn.php";

# Device helper function
include "func-device.php";
$device = get_device($conn, $id);

# If the ID is invalid
if ($device == 0) {
	header("Location: ../public/cart.php?error=Device not found");
	exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

if (!in_array($id, $_SESSION['cart'], true)) {
	$_SESSION['cart'][] = $id;
}

if ($redirect === "buy") {
	header("Location: ../public/buy.php?success=Added to cart");
	exit;
}

header("Location: ../public/cart.php?success=Added to cart");
exit;


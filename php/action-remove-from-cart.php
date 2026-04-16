<?php
session_start();

# If device ID is not set
if (!isset($_GET['id'])) {
	header("Location: ../public/cart.php?error=Missing device ID");
	exit;
}

$id = (int) $_GET['id'];

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

$_SESSION['cart'] = array_values(array_filter(
	$_SESSION['cart'],
	function ($item_id) use ($id) {
		return (int) $item_id !== $id;
	}
));

header("Location: ../public/cart.php?success=Removed from cart");
exit;


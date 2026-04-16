<?php
session_start();

$_SESSION['cart'] = [];

header("Location: ../public/cart.php?success=Cart cleared");
exit;


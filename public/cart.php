<?php
session_start();

# Database Connection File
include "../db_conn.php";

# Device helper function
include "../php/func-device.php";

# brand helper function
include "../php/func-brand.php";
$brands = get_all_brand($conn);

# Category helper function
include "../php/func-category.php";
$categories = get_all_categories($conn);

# Store locations helper function
include "../php/func-location.php";

require_once __DIR__ . '/../php/partials/device-card.php';
$cart_ids = isset($_SESSION['cart']) && is_array($_SESSION['cart'])
	? $_SESSION['cart']
	: [];

$devices = [];
foreach ($cart_ids as $cart_id) {
	$device = get_device($conn, (int) $cart_id);
	if ($device != 0) {
		$devices[] = $device;
	}
}

$page_title = 'Cart';
$active_page = 'cart';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="View your cart contents at Online Electronics Store and prepare for checkout on the best electronics, laptops, phones, and accessories.">
    <meta name="keywords" content="cart electronics, shopping cart, online store, devices, checkout">
    <meta name="author" content="Online Electronics Store">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?> | Online Electronics Store">
    <meta property="og:description" content="View your cart contents at Online Electronics Store and prepare for checkout on the best electronics, laptops, phones, and accessories.">
    <meta property="og:image" content="../img/store-banner.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?= htmlspecialchars($page_title) ?> | Online Electronics Store">
    <meta property="twitter:description" content="View your cart contents at Online Electronics Store and prepare for checkout on the best electronics, laptops, phones, and accessories.">
    <meta property="twitter:image" content="../img/store-banner.jpg">

    <!-- //TODO: Google Fonts Poppins - matching login form typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/custom-elements.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
	<div class="container">
		<?php include_once __DIR__ . '/../php/partials/store-navbar.php'; ?>
		<nav aria-label="breadcrumb" class="mt-3">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Cart</li>
		  </ol>
		</nav>

		<h1 class="display-4 p-3 fs-3">Your Cart</h1>

		<?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>

		<?php if (count($devices) === 0) { ?>
			<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
			    Your cart is empty
		    </div>
		<?php }else{ ?>
			<div class="main-content-wrapper">
				<div class="main-device-grid">
					<?php foreach ($devices as $device) { ?>
						<?=render_device_card($device, $brands, $categories, ['action_type' => 'cart']);?>
					<?php } ?>
				</div>
			</div>

			<div class="mt-4 device-card-actions">
				<a href="buy.php" class="btn btn-success">Proceed to Buy</a>
				<a href="../php/action-clear-cart.php" class="btn btn-outline-secondary">Clear Cart</a>
			</div>
		<?php } ?>
	</div>
	
<?php include "../php/partials/store-footer.php"; ?>
</body>
</html>

<?php
session_start();

# If device ID is not set
if (!isset($_GET['id'])) {
	header("Location: index.php");
	exit;
}

$id = (int) $_GET['id'];

# Database Connection File
include "../db_conn.php";

# Device helper function
include "../php/func-device.php";
$device = get_device($conn, $id);

if ($device == 0) {
	header("Location: index.php");
	exit;
}

# brand helper function
include "../php/func-brand.php";
$brand = get_brand($conn, $device['brand_id']);

# Category helper function
include "../php/func-category.php";
$category = get_category($conn, $device['category_id']);

# Store locations helper function
include "../php/func-location.php";
$locations = get_locations_for_device($device['id']);

$page_title = htmlspecialchars($device['name']);
$active_page = 'store';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=htmlspecialchars($page_title)?></title>

    <!-- //TODO: Google Fonts Poppins - matching login form typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <!-- //TODO: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/custom-elements.css?v=<?php echo time(); ?>">
</head>
<body>
	<div class="container">
		<?php include_once __DIR__ . '/../php/partials/store-navbar.php'; ?>
		<nav aria-label="breadcrumb" class="mt-3">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		    <li class="breadcrumb-item"><a href="index.php">Items</a></li>
		    <li class="breadcrumb-item active" aria-current="page"><?=htmlspecialchars($device['name'])?></li>
		  </ol>
		</nav>

		<div class="row g-4 align-items-start device-detail-row">
			<div class="col-md-5 device-detail-image-wrapper">
				<img src="../uploads/images/<?=$device['image']?>"
				     class="img-fluid rounded device-main-image"
				     alt="<?=htmlspecialchars($device['name'])?>">
			</div>
			<div class="col-md-7 device-detail-info-wrapper">
				<h1 class="display-5"><?=htmlspecialchars($device['name'])?></h1>
				<div class="device-detail-price">$<?=number_format((float) $device['price'], 2)?></div>
				<p class="device-detail-meta-item mb-1">
					<strong>Brand:</strong> <?=htmlspecialchars($brand['name'] ?? 'Unknown')?>
				</p>
				<p class="device-detail-meta-item mb-3">
					<strong>Category:</strong> <?=htmlspecialchars($category['name'] ?? 'Unknown')?>
				</p>

				<p class="lead device-detail-description"><?=htmlspecialchars($device['description'])?></p>

				<div class="device-detail-locations-section">
					<small class="device-detail-location-label">Available at:</small>
					<ul class="device-detail-locations-list">
						<?php foreach ($locations as $loc) { ?>
							<li>
								<?=htmlspecialchars($loc['name'])?> -
								<a href="<?=$loc['maps_url']?>" target="_blank" rel="noopener">Map</a>
							</li>
						<?php } ?>
					</ul>
				</div>

				<div class="device-detail-actions">
					<a href="../php/action-add-to-cart.php?id=<?=$device['id']?>"
					   class="btn btn-outline-secondary">Add to Cart</a>
					<a href="../php/action-add-to-cart.php?id=<?=$device['id']?>&redirect=buy"
					   class="btn btn-primary">Buy</a>
					<a href="../uploads/files/<?=$device['file']?>"
					   class="btn btn-outline-primary"
					   download="<?=$device['file']?>">Download File</a>
				</div>
			</div>
		</div>
	</div>
	
<?php include "../php/partials/store-footer.php"; ?>
</body>
</html>

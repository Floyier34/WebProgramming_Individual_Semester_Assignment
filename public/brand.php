<?php
session_start();

# If brand ID is not set
if (!isset($_GET['id'])) {
	header("Location: index.php");
	exit;
}

# Get brand ID from GET request
$id = $_GET['id'];

# Database Connection File
include "../config/db_conn.php";

# Device helper function
include "../php/func-device.php";
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : "newest";
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
	$page = 1;
}
$per_page = 9;
$total = count_devices_by_brand($conn, $id);
$total_pages = $total > 0 ? (int) ceil($total / $per_page) : 1;
if ($page > $total_pages) {
	$page = $total_pages;
}
$offset = ($page - 1) * $per_page;
$devices = get_devices_by_brand_paginated($conn, $id, $per_page, $offset, $sort);

# brand helper function
include "../php/func-brand.php";
$brands = get_all_brand($conn);
$current_brand = get_brand($conn, $id);


# Category helper function
include "../php/func-category.php";
$categories = get_all_categories($conn);

# Store locations helper function
include "../php/func-location.php";

require_once __DIR__ . '/../php/partials/device-card.php';
function render_pagination($page, $total_pages, $id, $sort){
	if ($total_pages <= 1) {
		return "";
	}

	$start = $page - 2;
	if ($start < 1) {
		$start = 1;
	}

	$end = $page + 2;
	if ($end > $total_pages) {
		$end = $total_pages;
	}

	ob_start();
	?>
	<nav aria-label="Brand pages">
		<ul class="pagination">
			<li class="page-item <?=$page <= 1 ? "disabled" : ""?>">
				<a class="page-link" href="?id=<?=urlencode($id)?>&sort=<?=urlencode($sort)?>&page=<?=max(1, $page - 1)?>">Previous</a>
			</li>
			<?php for ($p = $start; $p <= $end; $p++) { ?>
				<li class="page-item <?=$p == $page ? "active" : ""?>">
					<a class="page-link" href="?id=<?=urlencode($id)?>&sort=<?=urlencode($sort)?>&page=<?=$p?>"><?=$p?></a>
				</li>
			<?php } ?>
			<li class="page-item <?=$page >= $total_pages ? "disabled" : ""?>">
				<a class="page-link" href="?id=<?=urlencode($id)?>&sort=<?=urlencode($sort)?>&page=<?=min($total_pages, $page + 1)?>">Next</a>
			</li>
		</ul>
	</nav>
	<?php
	return ob_get_clean();
}


$page_title = htmlspecialchars($current_brand['name']);
$seo_desc = "Shop " . htmlspecialchars($current_brand['name']) . " products at Online Electronics Store. Discover top electronics, laptops, phones, accessories, and more from this brand.";
$seo_keywords = "electronics, " . htmlspecialchars($current_brand['name']) . ", online store, devices, tech";
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
$seo_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$active_page = 'store';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=htmlspecialchars($page_title)?></title>
    <meta name="description" content="<?= htmlspecialchars($seo_desc) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($seo_keywords) ?>">
    <meta name="author" content="Online Electronics Store">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($seo_url) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?> | Online Electronics Store">
    <meta property="og:description" content="<?= htmlspecialchars($seo_desc) ?>">
    <meta property="og:image" content="../img/store-banner.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?= htmlspecialchars($page_title) ?> | Online Electronics Store">
    <meta property="twitter:description" content="<?= htmlspecialchars($seo_desc) ?>">
    <meta property="twitter:image" content="../img/store-banner.jpg">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

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
		    <li class="breadcrumb-item"><a href="index.php">Brand</a></li>
		    <li class="breadcrumb-item active" aria-current="page"><?=htmlspecialchars($current_brand['name'])?></li>
		  </ol>
		</nav>
		<h1 class="display-4 p-3 fs-3"> 
			<a href="index.php"
			   class="nd">
				<img src="../img/back-arrow.PNG" 
				     width="35">
			</a>
		   <?=$current_brand['name']?>
		</h1>
		<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
			<form method="get" class="d-flex align-items-center gap-2">
				<input type="hidden" name="id" value="<?=$id?>">
				<label class="form-label mb-0">Sort</label>
				<select class="form-select" name="sort" onchange="this.form.submit()">
					<option value="newest" <?=$sort === "newest" ? "selected" : ""?>>Newest</option>
					<option value="name_asc" <?=$sort === "name_asc" ? "selected" : ""?>>Name (A-Z)</option>
					<option value="name_desc" <?=$sort === "name_desc" ? "selected" : ""?>>Name (Z-A)</option>
					<option value="price_asc" <?=$sort === "price_asc" ? "selected" : ""?>>Price (Low-High)</option>
					<option value="price_desc" <?=$sort === "price_desc" ? "selected" : ""?>>Price (High-Low)</option>
					<option value="oldest" <?=$sort === "oldest" ? "selected" : ""?>>Oldest</option>
				</select>
			</form>
		</div>
		<div class="main-content-wrapper">
			<!-- //TODO: Device grid wrapper - flex:1 ensures sidebar stays pinned even with empty state -->
		<div class="main-device-grid">
		<?php if ($devices == 0){ ?>
				<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
			    There is no device in the database
		       </div>
			<?php }else{ ?>
			<?php foreach ($devices as $device) { ?>
				<?=render_device_card($device, $brands, $categories, ['action_type' => 'download']);?>
			<?php } ?>
		<?php } ?>
		</div>

		<div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($categories as $category ) {?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php } } ?>
			</div>

			<!-- List of brands -->
			<div class="list-group mt-5">
				<?php if ($brands == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Brand</a>
				   <?php foreach ($brands as $brand ) {?>
				  
				   <a href="brand.php?id=<?=$brand['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$brand['name']?></a>
				<?php } } ?>
			</div>
		</div>
		</div>
		<div class="mt-4">
			<?=render_pagination($page, $total_pages, $id, $sort)?>
		</div>
	</div>
	
<?php include "../php/partials/store-footer.php"; ?>

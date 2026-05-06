<?php
session_start();

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
$total = count_devices($conn);
$total_pages = $total > 0 ? (int) ceil($total / $per_page) : 1;
if ($page > $total_pages) {
	$page = $total_pages;
}
$offset = ($page - 1) * $per_page;
$devices = get_devices_paginated($conn, $per_page, $offset, $sort);

require_once __DIR__ . '/../php/partials/device-card.php';

function render_pagination($page, $total_pages, $sort){
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
	<nav aria-label="Device pages">
		<ul class="pagination">
			<li class="page-item <?=$page <= 1 ? "disabled" : ""?>">
				<a class="page-link" href="?sort=<?=urlencode($sort)?>&page=<?=max(1, $page - 1)?>" data-page="<?=max(1, $page - 1)?>">Previous</a>
			</li>
			<?php for ($p = $start; $p <= $end; $p++) { ?>
				<li class="page-item <?=$p == $page ? "active" : ""?>">
					<a class="page-link" href="?sort=<?=urlencode($sort)?>&page=<?=$p?>" data-page="<?=$p?>"><?=$p?></a>
				</li>
			<?php } ?>
			<li class="page-item <?=$page >= $total_pages ? "disabled" : ""?>">
				<a class="page-link" href="?sort=<?=urlencode($sort)?>&page=<?=min($total_pages, $page + 1)?>" data-page="<?=min($total_pages, $page + 1)?>">Next</a>
			</li>
		</ul>
	</nav>
	<?php
	return ob_get_clean();
}

# brand helper function
include "../php/func-brand.php";
$brands = get_all_brand($conn);

# Category helper function
include "../php/func-category.php";
$categories = get_all_categories($conn);

# Store locations helper function
include "../php/func-location.php";

$page_title = 'Electronics Store';
$active_page = 'store';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($page_title) ?></title>

    <!-- Global SEO Meta Tags -->
    <meta name="description" content="Welcome to the Online Electronics Store. Find the best devices, laptops, phones, and accessories at great prices.">
    <meta name="keywords" content="electronics, laptops, phones, online store, tech">
    <meta name="author" content="Online Electronics Store">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="Find the best devices, laptops, phones, and accessories at great prices.">
    <meta property="og:image" content="../img/store-banner.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="twitter:description" content="Find the best devices, laptops, phones, and accessories at great prices.">
    <meta property="twitter:image" content="../img/store-banner.jpg">

    <!-- JSON-LD Structured Data Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ElectronicsStore",
      "name": "Online Electronics Store",
      "description": "Find the best devices, laptops, phones, and accessories at great prices."
    }
    </script>

    <!-- //TODO: Google Fonts Poppins - matching login form typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
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
		    <li class="breadcrumb-item active" aria-current="page">Items</li>
		  </ol>
		</nav>

		<form action="search.php"
             method="get"
             id="search-form"
             class="row g-2 align-items-end my-4"
             style="width: 100%; max-width: 50rem">

       	<div class="col-md-8">
			<div class="input-group">
			  <input type="text" 
			         class="form-control"
			         id="search-key"
			         name="key" 
			         placeholder="Search Device..." 
			         aria-label="Search Device..." 
			         aria-describedby="basic-addon2">

			  <button class="input-group-text
			                 btn btn-primary" 
			          id="basic-addon2">
			          <img src="../img/search.png"
			               width="20">

			  </button>
			</div>
		</div>
		<div class="col-md-4">
			<label class="form-label">Sort</label>
			<select class="form-select" name="sort" id="sort">
				<option value="newest" <?=$sort === "newest" ? "selected" : ""?>>Newest</option>
				<option value="name_asc" <?=$sort === "name_asc" ? "selected" : ""?>>Name (A-Z)</option>
				<option value="name_desc" <?=$sort === "name_desc" ? "selected" : ""?>>Name (Z-A)</option>
				<option value="price_asc" <?=$sort === "price_asc" ? "selected" : ""?>>Price (Low-High)</option>
				<option value="price_desc" <?=$sort === "price_desc" ? "selected" : ""?>>Price (High-Low)</option>
				<option value="oldest" <?=$sort === "oldest" ? "selected" : ""?>>Oldest</option>
			</select>
		</div>
       </form>
		<div class="main-content-wrapper">
			<div class="main-device-grid" id="device-list">
				<?php if ($devices == 0){ ?>
					<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
				    There is no device in the database
			       </div>
				<?php }else{ ?>
				<?php foreach ($devices as $device) { ?>
					<?=render_device_card($device, $brands, $categories, ['action_type' => 'store']);?>
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
		<div id="pagination" class="mt-4">
			<?=render_pagination($page, $total_pages, $sort)?>
		</div>
	</div>
	<script>
	(function () {
		const form = document.getElementById('search-form');
		const input = document.getElementById('search-key');
		const sort = document.getElementById('sort');
		const list = document.getElementById('device-list');
		const pagination = document.getElementById('pagination');
		if (!form || !input || !sort || !list || !pagination) {
			return;
		}

		let debounceTimer;

		function loadDevices(page) {
			const params = new URLSearchParams();
			params.set('key', input.value.trim());
			params.set('sort', sort.value);
			params.set('page', page);

			fetch('../php/ajax-search.php?' + params.toString(), {
				headers: { 'X-Requested-With': 'XMLHttpRequest' }
			})
			.then((response) => response.json())
			.then((data) => {
				list.innerHTML = data.html;
				pagination.innerHTML = data.pagination;
			})
			.catch(() => {
				// If AJAX fails, allow normal form submit behavior
			});
		}

		form.addEventListener('submit', function (event) {
			event.preventDefault();
			loadDevices(1);
		});

		input.addEventListener('input', function () {
			clearTimeout(debounceTimer);
			debounceTimer = setTimeout(function () {
				loadDevices(1);
			}, 300);
		});

		sort.addEventListener('change', function () {
			loadDevices(1);
		});

		pagination.addEventListener('click', function (event) {
			const link = event.target.closest('a[data-page]');
			if (!link) {
				return;
			}
			const item = link.closest('.page-item');
			if (item && (item.classList.contains('disabled') || item.classList.contains('active'))) {
				return;
			}
			event.preventDefault();
			const page = parseInt(link.getAttribute('data-page'), 10);
			if (!page) {
				return;
			}
			loadDevices(page);
		});
	})();
	</script>
<?php include "../php/partials/store-footer.php"; ?>
</body>
</html>

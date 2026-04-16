<?php
session_start();

# Store locations helper function
include "../php/func-location.php";
$locations = get_locations();
foreach ($locations as $i => $loc) {
	$locations[$i]['embed_url'] = "https://www.google.com/maps?q=" . urlencode($loc['address']) . "&output=embed";
}
$default_location = count($locations) > 0 ? $locations[0] : null;
$page_title = 'About & Locations';
$active_page = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($page_title) ?></title>

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
		    <li class="breadcrumb-item active" aria-current="page">About</li>
		  </ol>
		</nav>

		<h1 class="display-4 p-3 fs-3">About & Store Locations</h1>
		<p class="text-muted">Select a location from the sidebar to preview it on the map.</p>

		<?php if (count($locations) === 0) { ?>
			<div class="alert alert-warning">No store locations are available yet.</div>
		<?php } else { ?>
			<div class="row g-4" style="min-height: 65vh;">
				<div class="col-md-4">
					<div class="list-group" id="location-list" role="listbox" aria-label="Store locations">
						<?php foreach ($locations as $index => $loc) {
							$is_active = $index === 0;
							?>
							<button type="button"
							        class="list-group-item list-group-item-action <?=$is_active ? "active" : ""?>"
							        data-embed="<?=htmlspecialchars($loc['embed_url'], ENT_QUOTES)?>"
							        aria-pressed="<?=$is_active ? "true" : "false"?>">
								<i class="fas fa-store location-item-icon"></i>
								<div class="location-item-name"><?=htmlspecialchars($loc['name'])?></div>
								<small class="location-item-address"><?=htmlspecialchars($loc['address'])?></small>
							</button>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-8 map-iframe-container">
					<iframe id="location-map" class="map-iframe-element"
					        src="<?=htmlspecialchars($default_location['embed_url'])?>"
					        allowfullscreen
					        loading="lazy"
					        referrerpolicy="no-referrer-when-downgrade">
					</iframe>
				</div>
			</div>
		<?php } ?>
	</div>
	<script>
	(function () {
		const list = document.getElementById('location-list');
		const map = document.getElementById('location-map');
		if (!list || !map) {
			return;
		}

		list.addEventListener('click', function (event) {
			const button = event.target.closest('[data-embed]');
			if (!button) {
				return;
			}

			list.querySelectorAll('.list-group-item').forEach(function (item) {
				item.classList.remove('active');
				item.setAttribute('aria-pressed', 'false');
			});

			button.classList.add('active');
			button.setAttribute('aria-pressed', 'true');

			const embed = button.getAttribute('data-embed');
			if (embed) {
				map.setAttribute('src', embed);
			}
		});
	})();
	</script>
	
<?php include "../php/partials/store-footer.php"; ?>
</body>
</html>

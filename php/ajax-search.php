<?php
session_start();

header('Content-Type: application/json');

# Database Connection File
include "../config/db_conn.php";

# Device helper function
include "func-device.php";

# brand helper function
include "func-brand.php";
$brands = get_all_brand($conn);

# Category helper function
include "func-category.php";
$categories = get_all_categories($conn);

# Store locations helper function
include "func-location.php";

$key = isset($_GET['key']) ? trim($_GET['key']) : "";
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : "newest";
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
	$page = 1;
}

$per_page = 9;

if ($key === "") {
	$total = count_devices($conn);
}else{
	$total = count_search_devices($conn, $key);
}

$total_pages = $total > 0 ? (int) ceil($total / $per_page) : 1;
if ($page > $total_pages) {
	$page = $total_pages;
}
$offset = ($page - 1) * $per_page;

if ($key === "") {
	$devices = get_devices_paginated($conn, $per_page, $offset, $sort);
}else{
	$devices = search_devices_paginated($conn, $key, $per_page, $offset, $sort);
}

function render_pagination($page, $total_pages){
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
	<nav aria-label="Search pages">
		<ul class="pagination">
			<li class="page-item <?=$page <= 1 ? "disabled" : ""?>">
				<a class="page-link" href="#" data-page="<?=max(1, $page - 1)?>">Previous</a>
			</li>
			<?php for ($p = $start; $p <= $end; $p++) { ?>
				<li class="page-item <?=$p == $page ? "active" : ""?>">
					<a class="page-link" href="#" data-page="<?=$p?>"><?=$p?></a>
				</li>
			<?php } ?>
			<li class="page-item <?=$page >= $total_pages ? "disabled" : ""?>">
				<a class="page-link" href="#" data-page="<?=min($total_pages, $page + 1)?>">Next</a>
			</li>
		</ul>
	</nav>
	<?php
	return ob_get_clean();
}

require_once __DIR__ . '/partials/device-card.php';

ob_start();
if ($devices == 0) {
	?>
	<div class="alert alert-warning text-center p-5" role="alert">
		<img src="../img/empty.png" width="100">
		<br>
		<?php if ($key === "") { ?>
			There is no device in the database
		<?php }else{ ?>
			The key <b>"<?=htmlspecialchars($key)?>"</b> didn't match to any record
			in the database
		<?php } ?>
	</div>
	<?php
}else{
	foreach ($devices as $device) {
		echo render_device_card($device, $brands, $categories, ['action_type' => 'store']);
	}
}

$cards_html = ob_get_clean();

echo json_encode([
	"html" => $cards_html,
	"pagination" => render_pagination($page, $total_pages),
	"page" => $page,
	"pages" => $total_pages,
	"total" => $total
]);

<?php
if (!function_exists('render_device_card')) {
	function render_device_card_actions($device_id, $file, $action_type, $buy_label){
		$buy_label = $buy_label !== "" ? $buy_label : "Buy";
		$buy_label_safe = htmlspecialchars((string) $buy_label);
		$file_safe = htmlspecialchars((string) $file);

		if ($action_type === "store") {
			?>
			<a href="../php/action-add-to-cart.php?id=<?=$device_id?>"
			   class="btn btn-outline-secondary"
			   role="button">Add to Cart</a>

			<a href="../php/action-add-to-cart.php?id=<?=$device_id?>&redirect=buy"
			   class="btn btn-primary"><?=$buy_label_safe?></a>
			<?php
			return;
		}

		if ($action_type === "download") {
			?>
			<a href="../php/action-add-to-cart.php?id=<?=$device_id?>"
			   class="btn btn-outline-secondary"
			   role="button">Add to Cart</a>

			<a href="../uploads/files/<?=$file_safe?>"
			   class="btn btn-primary"
			   download="<?=$file_safe?>"><?=$buy_label_safe?></a>
			<?php
			return;
		}

		if ($action_type === "buy") {
			?>
			<a href="../uploads/files/<?=$file_safe?>"
			   class="btn btn-primary"
			   download="<?=$file_safe?>"><?=$buy_label_safe?></a>
			<?php
			return;
		}

		if ($action_type === "cart") {
			?>
			<a href="../php/action-remove-from-cart.php?id=<?=$device_id?>"
			   class="btn btn-outline-danger">Remove</a>
			<a href="buy.php"
			   class="btn btn-primary"><?=$buy_label_safe?></a>
			<?php
		}
	}

	function render_device_card($device, $brands, $categories, $options = []){
		$action_type = isset($options['action_type']) ? $options['action_type'] : "store";
		$buy_label = isset($options['buy_label']) ? $options['buy_label'] : "Buy";
		$brand_label = isset($options['brand_label']) ? $options['brand_label'] : "Brand";

		$brand_name = "";
		foreach ($brands as $brand) {
			if ($brand['id'] == $device['brand_id']) {
				$brand_name = $brand['name'];
				break;
			}
		}

		$category_name = "";
		foreach ($categories as $category) {
			if ($category['id'] == $device['category_id']) {
				$category_name = $category['name'];
				break;
			}
		}

		$device_id = (int) ($device['id'] ?? 0);
		$device_name = (string) ($device['name'] ?? "");
		$device_image = (string) ($device['image'] ?? "");
		$device_file = (string) ($device['file'] ?? "");
		$device_price = isset($device['price']) ? (float) $device['price'] : 0;

		ob_start();
		?>
		<div class="card m-1">
			<a href="device.php?id=<?=$device_id?>" class="device-card-image-link">
				<img src="../uploads/images/<?=htmlspecialchars($device_image)?>"
				     class="card-img-top"
				     alt="<?=htmlspecialchars($device_name)?>">
			</a>
			<div class="card-body">
				<h5 class="card-title">
					<a href="device.php?id=<?=$device_id?>" class="device-card-name-link">
						<?=htmlspecialchars($device_name)?>
					</a>
				</h5>
				<div class="device-price">
					$<?=number_format($device_price, 2)?>
				</div>
				<p class="card-text">
					<i><b><?=htmlspecialchars($brand_label)?>:
						<?=htmlspecialchars($brand_name)?>
					<br></b></i>
					<?=htmlspecialchars(get_short_description($device))?>
					<br><i><b>Category:
						<?=htmlspecialchars($category_name)?>
					<br></b></i>
				</p>
				<div class="location-list">
					<small class="device-location-label">Available at:</small>
					<ul class="device-locations-list list-unstyled">
						<?php foreach (get_locations_for_device($device_id) as $loc) { ?>
							<li>
								<?=htmlspecialchars($loc['name'])?> -
								<a href="<?=htmlspecialchars($loc['maps_url'])?>" target="_blank" rel="noopener">Map</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="device-card-actions"><?php render_device_card_actions($device_id, $device_file, $action_type, $buy_label); ?></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

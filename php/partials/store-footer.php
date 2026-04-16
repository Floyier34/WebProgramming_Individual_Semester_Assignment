<?php
// Include location functions if not already included
if (!function_exists('get_locations')) {
    // Use __DIR__ to ensure the path is correct from any including file
    include_once __DIR__ . "/../func-location.php";
}
$locations = get_locations();
$primary_location = $locations[0] ?? null;
?>
<footer class="store-footer">
	<div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-section-heading">Online Electronics Store</h5>
                <p class="small footer-text-content">Your one-stop shop for the latest and greatest in electronic devices. We are committed to providing quality products and excellent service.</p>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-section-heading">Quick Links</h5>
                <ul class="footer-link-list list-unstyled">
                    <li class="mb-2"><a href="index.php" class="footer-link-item">Store</a></li>
                    <li class="mb-2"><a href="about.php" class="footer-link-item">About Us</a></li>
                    <li class="mb-2"><a href="contact.php" class="footer-link-item">Contact</a></li>
                    <li class="mb-2"><a href="cart.php" class="footer-link-item">Your Cart</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-section-heading">Contact Us</h5>
                <ul class="footer-link-list list-unstyled">
                    <?php if ($primary_location): ?>
                    <li class="footer-contact-detail mb-2">
                        <i class="fas fa-map-marker-alt fa-fw me-2 mt-1 footer-contact-icon"></i>
                        <span class="footer-text-content"><?= htmlspecialchars($primary_location['address']) ?></span>
                    </li>
                    <?php endif; ?>
                    <li class="footer-contact-detail mb-2">
                        <i class="fas fa-phone-alt fa-fw me-2 mt-1 footer-contact-icon"></i>
                        <span class="footer-text-content">(+84) 123-456-789</span>
                    </li>
                    <li class="footer-contact-detail">
                        <i class="fas fa-envelope fa-fw me-2 mt-1 footer-contact-icon"></i>
                        <a href="mailto:support@electronics-store.test" class="footer-link-item">support@electronics-store.test</a>
                    </li>
                </ul>
            </div>
        </div>
		<div class="footer-bottom-bar">
			<div class="footer-copyright-info">
			    <span class="small footer-copyright-text">&copy; <?= date('Y') ?> Online Electronics Store. All Rights Reserved.</span>
			    <span class="small footer-copyright-text">A Demo Project</span>
            </div>
		</div>
	</div>
</footer>

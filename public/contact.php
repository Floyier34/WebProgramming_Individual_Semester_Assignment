<?php
session_start();

# Store locations helper function
include "../php/func-location.php";
$locations = get_locations();
$primary_location = $locations[0] ?? null; // Get the first location as the primary one

$page_title = 'Contact Us';
$active_page = 'contact';
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
		    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
		  </ol>
		</nav>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-10">
                <div class="contact-page-header">
                    <h1 class="display-4 fs-3">Get in Touch</h1>
                    <p class="text-muted">We'd love to hear from you. Please fill out the form below or use our contact details to reach us.</p>
                </div>

                <div class="row">
                    <!-- Contact Info -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="contact-info-card mb-3">
                            <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h5 class="contact-info-heading">Our Address</h5>
                                <p class="contact-info-text"><?= htmlspecialchars($primary_location['address'] ?? '123 Main St, Ho Chi Minh City') ?></p>
                            </div>
                        </div>
                        <div class="contact-info-card mb-3">
                            <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h5 class="contact-info-heading">Email Us</h5>
                                <p class="contact-info-text"><a href="mailto:support@electronics-store.test" class="contact-email-link">support@electronics-store.test</a></p>
                            </div>
                        </div>
                        <div class="contact-info-card">
                            <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h5 class="contact-info-heading">Call Us</h5>
                                <p class="contact-info-text">(+84) 123-456-789</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-8">
                        <form id="contact-form" class="contact-form-wrapper">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <script>
    document.getElementById('contact-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        
        window.location.href = "contact.php";
    });
    </script>
	
    <?php include "../php/partials/store-footer.php"; ?>
</body>
</html>
<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# If device ID is not set
	if (!isset($_GET['id'])) {
		# Redirect to admin.php page
        header("Location: admin.php");
        exit;
	}

	$id = $_GET['id'];

	# Database Connection File
	include "../config/db_conn.php";

	# Device helper function
	include "../php/func-device.php";
    $device = get_device($conn, $id);
    
    # If the ID is invalid
    if ($device == 0) {
    	# Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }

    # Category helper function
	include "../php/func-category.php";
    $categories = get_all_categories($conn);

    # Brand helper function
	include "../php/func-brand.php";
    $brands = get_all_brand($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
	<title>Edit Device</title>

    <!-- //TODO: Google Fonts Poppins -->
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
		<!-- //TODO: Purple-blue theme navbar -->
		<nav class="navbar navbar-expand-lg navbar-dark store-navbar-purple">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="admin.php">Admin</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="../public/index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-device.php">Add Device</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-category.php">Add Category</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-brand.php">Add Brand</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="../public/logout.php">Logout</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
     <form action="../php/action-edit-device.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Edit Device
     	</h1>
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
     	<div class="mb-3">
		    <label class="form-label">
		           Device Name
		           </label>
		    <input type="text" 
		           hidden
		           value="<?=$device['id']?>" 
		           name="device_id">

		    <input type="text" 
		           class="form-control"
		           value="<?=$device['name']?>" 
		           name="device_name">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Short Description
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=htmlspecialchars($device['short_description'] ?? '')?>"
		           name="device_short_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Full Description
		           </label>
		    <textarea class="form-control"
		              name="device_description"
		              rows="3"><?=htmlspecialchars($device['description'])?></textarea>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Price (USD)
		           </label>
		    <input type="number" 
		           class="form-control"
		           value="<?=number_format((float) $device['price'], 2, '.', '')?>"
		           name="device_price"
		           step="0.01"
		           min="0">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Device Brand
		           </label>
		    <select name="device_brand"
		            class="form-control">
		    	    <option value="0">
		    	    	Select brand
		    	    </option>
		    	    <?php 
                    if ($brands == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($brands as $brand) { 
		    	    	if ($device['brand_id'] == $brand['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$brand['id']?>">
		    	    	  <?=$brand['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$brand['id']?>">
							<?=$brand['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Device Category
		           </label>
		    <select name="device_category"
		            class="form-control">
		    	    <option value="0">
		    	    	Select category
		    	    </option>
		    	    <?php 
                    if ($categories == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($categories as $category) { 
		    	    	if ($device['category_id'] == $category['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$category['id']?>">
		    	    	  <?=$category['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$category['id']?>">
							<?=$category['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Device Image
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="device_image">

		     <input type="text" 
		           hidden
		           value="<?=$device['image']?>" 
		           name="current_image">

		    <a href="../uploads/images/<?=$device['image']?>"
		       class="link-dark">Current Image</a>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           File
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="file">

		     <input type="text" 
		           hidden
		           value="<?=$device['file']?>" 
		           name="current_file">

		    <a href="../uploads/files/<?=$device['file']?>"
		       class="link-dark"
		       download="<?=$device['file']?>">Current File</a>
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Update</button>
     </form>
	</div>
</body>
</html>

<?php }else{
  header("Location: ../public/login.php");
  exit;
} ?>

<?php  
session_start();

# Check if admin is logged in with admin role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
	header("Location: ../public/login.php");
	exit();
}

# Database Connection File
include "../config/db_conn.php";

	# device helper function
	include "../php/func-device.php";
    if (isset($_GET['key'])) {
        $devices = search_devices($conn, $_GET['key']);
    } else {
        $devices = get_all_devices($conn);
    }

    # brand helper function
	include "../php/func-brand.php";
    $brands = get_all_brand($conn);

    # Category helper function
	include "../php/func-category.php";
    $categories = get_all_categories($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ADMIN</title>

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
		<!-- //TODO: Purple-blue theme navbar - changed from navbar-light bg-light -->
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
       <form action="admin.php"
             method="get" 
             style="width: 100%; max-width: 30rem">

       	<div class="input-group my-5">
		  <input type="text" 
		         class="form-control"
		         name="key" 
		         value="<?=isset($_GET['key']) ? htmlspecialchars($_GET['key']) : ''?>"
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
       </form>
       <div class="mt-5"></div>
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


        <?php  if ($devices == 0) { ?>
        	<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
			  There is no device in the database
		  </div>
        <?php }else {?>


        <!-- List of all devices -->
		<h4 class="mt-5">All Devices</h4>
		<table class="table admin-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Price</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Category</th>
					<th class="action-col">Action</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  $i = 0;
			  foreach ($devices as $device) {
			    $i++;
			    $image_file = $device['image'];
			    $image_src = "../uploads/images/$image_file";
			    if (empty($image_file) || !file_exists($image_src)) {
			    	$alt_image_src = "../Uploads/images/$image_file";
			    	if (!empty($image_file) && file_exists($alt_image_src)) {
			    		$image_src = $alt_image_src;
			    	}else{
			    		$image_src = "../img/empty.png";
			    	}
			    }
			  ?>
			  <tr>
				<td><?=$i?></td>
				<td>
					<img width="100"
					     src="<?=$image_src?>" >
					<a  class="admin-device-link"
					    href="../uploads/files/<?=$device['file']?>">
					   <?=$device['name']?>	
					</a>
						
				</td>
				<td>$<?=number_format((float) $device['price'], 2)?></td>
				<td>
					<?php if ($brands == 0) {
						echo "Undefined";}else{ 

					    foreach ($brands as $brand) {
					    	if ($brand['id'] == $device['brand_id']) {
					    		echo $brand['name'];
					    	}
					    }
					}
					?>

				</td>
				<td><?=htmlspecialchars(get_short_description($device))?></td>
				<td>
					<?php if ($categories == 0) {
						echo "Undefined";}else{ 

					    foreach ($categories as $category) {
					    	if ($category['id'] == $device['category_id']) {
					    		echo $category['name'];
					    	}
					    }
					}
					?>
				</td>
				<td>
					<a href="edit-device.php?id=<?=$device['id']?>" 
					   class="btn btn-warning">
					   Edit</a>

					<a href="../php/delete-device.php?id=<?=$device['id']?>" 
					   class="btn btn-danger">
				       Delete</a>
				</td>
			  </tr>
			  <?php } ?>
			</tbody>
		</table>
	   <?php }?>

        <?php  if ($categories == 0) { ?>
        	<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
			  There is no category in the database
		    </div>
        <?php }else {?>
	    <!-- List of all categories -->
		<h4 class="mt-5">All Categories</h4>
		<table class="table admin-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Category Name</th>
					<th class="action-col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$j = 0;
				foreach ($categories as $category ) {
				$j++;	
				?>
				<tr>
					<td><?=$j?></td>
					<td><?=$category['name']?></td>
					<td>
						<a href="edit-category.php?id=<?=$category['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="../php/delete-category.php?id=<?=$category['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	    <?php } ?>

	    <?php  if ($brands == 0) { ?>
        	<div class="alert alert-warning empty-state-card" role="alert">
        	            <img src="../img/empty.png" width="100">
        	     <br>
			  There is no brand in the database
		    </div>
        <?php }else {?>
	    <!-- List of all Brands -->
		<h4 class="mt-5">All Brands</h4>
         <table class="table admin-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Brand Name</th>
					<th class="action-col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$k = 0;
				foreach ($brands as $brand ) {
				$k++;	
				?>
				<tr>
					<td><?=$k?></td>
					<td><?=$brand['name']?></td>
					<td>
						<a href="edit-brand.php?id=<?=$brand['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="../php/delete-brand.php?id=<?=$brand['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
			    <?php } ?>
			</tbody>
		</table> 
		<?php } ?>
	</div>
</body>
</html>

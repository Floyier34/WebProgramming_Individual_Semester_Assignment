<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    # Validation helper function
    include "func-validation.php";

    # File Upload helper function
    include "func-file-upload.php";


    /** 
	  If all Input field
	  are filled
	**/
	if (isset($_POST['device_id'])          &&
        isset($_POST['device_name'])       &&
        isset($_POST['device_short_description']) &&
        isset($_POST['device_description']) &&
        isset($_POST['device_price'])      &&
        isset($_POST['device_brand'])      &&
        isset($_POST['device_category'])    &&
        isset($_FILES['device_image'])      &&
        isset($_FILES['file'])            &&
        isset($_POST['current_image'])    &&
        isset($_POST['current_file'])) {

		/** 
		Get data from POST request 
		and store them in var
		**/
		$id          = $_POST['device_id'];
		$name       = $_POST['device_name'];
		$short_description = $_POST['device_short_description'];
		$description = $_POST['device_description'];
		$price      = $_POST['device_price'];
		$brand      = $_POST['device_brand'];
		$category    = $_POST['device_category'];
        
         /** 
	      Get current image & current file 
	      from POST request and store them in var
	    **/

        $current_image = $_POST['current_image'];
        $current_file  = $_POST['current_file'];

        #simple form Validation
        $text = "Device name";
        $location = "../admin/edit-device.php";
        $ms = "id=$id&error";
		is_empty($name, $text, $location, $ms, "");

		$text = "Short description";
        $location = "../admin/edit-device.php";
        $ms = "id=$id&error";
		is_empty($short_description, $text, $location, $ms, "");

		$text = "Full description";
        $location = "../admin/edit-device.php";
        $ms = "id=$id&error";
		is_empty($description, $text, $location, $ms, "");

		$text = "Device brand";
        $location = "../admin/edit-device.php";
        $ms = "id=$id&error";
		is_empty($brand, $text, $location, $ms, "");

		$text = "Device category";
        $location = "../admin/edit-device.php";
        $ms = "id=$id&error";
		is_empty($category, $text, $location, $ms, "");

		if ($price === "" || !is_numeric($price) || $price < 0) {
			$em = "The price must be a valid number";
			header("Location: ../admin/edit-device.php?error=$em&id=$id");
			exit;
		}
		$price = number_format((float) $price, 2, '.', '');

		// TODO: Consider wrapping file operations and DB updates in a transaction.
        /**
          if the admin try to 
          update the device image
        **/
          if (!empty($_FILES['device_image']['name'])) {
          	  /**
		          if the admin try to 
		          update both 
		      **/
		      if (!empty($_FILES['file']['name'])) {
		      	# update both here

		      	# device image Uploading
		        $allowed_image_exs = array("jpg", "jpeg", "png");
		        $path = "images";
		        $device_image = upload_file($_FILES['device_image'], $allowed_image_exs, $path);

		        # file Uploading
		        $allowed_file_exs = array("pdf", "docx", "pptx");
		        $path = "files";
		        $file = upload_file($_FILES['file'], $allowed_file_exs, $path);
                
                /**
				    If error occurred while 
				    uploading
				**/
		        if ($device_image['status'] == "error" || 
		            $file['status'] == "error") {

			    	$em = ($device_image['status'] == "error")
			    		? $device_image['data']
			    		: $file['data'];

			    	/**
			    	  Redirect to '../admin/edit-device.php' 
			    	  and passing error message & the id
			    	**/
			    	header("Location: ../admin/edit-device.php?error=$em&id=$id");
			    	exit;
			    }else {
                  # current device image path
			      $c_p_device_image = "../uploads/images/$current_image";

			      # current file path
			      $c_p_file = "../uploads/files/$current_file";

			      # Delete from the server
			      unlink($c_p_device_image);
			      unlink($c_p_file);

			      /**
		              Getting the new file name 
		              and the new device image name 
		          **/
		           $file_URL = $file['data'];
		           $device_image_URL = $device_image['data'];

		            # update just the data
		          	$sql = "UPDATE devices
		          	        SET name=?,
		          	            price=?,
		          	            short_description=?,
		          	            brand_id=?,
		          	            description=?,
		          	            category_id=?,
		          	            image=?,
		          	            file=?
		          	        WHERE id=?";
		          	$stmt = $conn->prepare($sql);
					$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category,$device_image_URL, $file_URL, $id]);

				    /**
				      If there is no error while 
				      updating the data
				    **/
				     if ($res) {
				     	# success message
				     	$sm = "Successfully updated!";
						header("Location: ../admin/edit-device.php?success=$sm&id=$id");
			            exit;
				     }else{
				     	# Error message
				     	$em = "Unknown Error Occurred!";
						header("Location: ../admin/edit-device.php?error=$em&id=$id");
			            exit;
				     }


			    }
		      }else {
		      	# update just the device image

		      	# device image Uploading
		        $allowed_image_exs = array("jpg", "jpeg", "png");
		        $path = "images";
		        $device_image = upload_file($_FILES['device_image'], $allowed_image_exs, $path);
                
                /**
				    If error occurred while 
				    uploading
				**/
		        if ($device_image['status'] == "error") {

			    	$em = $device_image['data'];

			    	/**
			    	  Redirect to '../admin/edit-device.php' 
			    	  and passing error message & the id
			    	**/
			    	header("Location: ../admin/edit-device.php?error=$em&id=$id");
			    	exit;
			    }else {
                  # current device image path
			      $c_p_device_image = "../uploads/images/$current_image";

			      # Delete from the server
			      unlink($c_p_device_image);

			      /**
		              Getting the new file name 
		              and the new device image name 
		          **/
		           $device_image_URL = $device_image['data'];

		            # update just the data
		          	$sql = "UPDATE devices
		          	        SET name=?,
		          	            price=?,
		          	            short_description=?,
		          	            brand_id=?,
		          	            description=?,
		          	            category_id=?,
		          	            image=?
		          	        WHERE id=?";
		          	$stmt = $conn->prepare($sql);
					$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category,$device_image_URL, $id]);

				    /**
				      If there is no error while 
				      updating the data
				    **/
				     if ($res) {
				     	# success message
				     	$sm = "Successfully updated!";
						header("Location: ../admin/edit-device.php?success=$sm&id=$id");
			            exit;
				     }else{
				     	# Error message
				     	$em = "Unknown Error Occurred!";
						header("Location: ../admin/edit-device.php?error=$em&id=$id");
			            exit;
				     }


			    }
		      }
          }
          /**
          if the admin try to 
          update just the file

          **/
          else if(!empty($_FILES['file']['name'])){
          	# update just the file
            
            # file Uploading
	        $allowed_file_exs = array("pdf", "docx", "pptx");
	        $path = "files";
	        $file = upload_file($_FILES['file'], $allowed_file_exs, $path);
            
            /**
			    If error occurred while 
			    uploading
			**/
	        if ($file['status'] == "error") {

		    	$em = $file['data'];

		    	/**
		    	  Redirect to '../admin/edit-device.php' 
		    	  and passing error message & the id
		    	**/
		    	header("Location: ../admin/edit-device.php?error=$em&id=$id");
		    	exit;
		    }else {
              # current file path
		      $c_p_file = "../uploads/files/$current_file";

		      # Delete from the server
		      unlink($c_p_file);

		      /**
	              Getting the new file name 
	              and the new file name 
	          **/
	           $file_URL = $file['data'];

	            # update just the data
	          	$sql = "UPDATE devices
	          	        SET name=?,
	          	            price=?,
	          	            short_description=?,
	          	            brand_id=?,
	          	            description=?,
	          	            category_id=?,
	          	            file=?
	          	        WHERE id=?";
	          	$stmt = $conn->prepare($sql);
				$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category, $file_URL, $id]);

			    /**
			      If there is no error while 
			      updating the data
			    **/
			     if ($res) {
			     	# success message
			     	$sm = "Successfully updated!";
					header("Location: ../admin/edit-device.php?success=$sm&id=$id");
		            exit;
			     }else{
			     	# Error message
			     	$em = "Unknown Error Occurred!";
					header("Location: ../admin/edit-device.php?error=$em&id=$id");
		            exit;
			     }


		    }
	      }
            else {
          	# update just the data
          	$sql = "UPDATE devices
          	        SET name=?,
          	            price=?,
          	            short_description=?,
          	            brand_id=?,
          	            description=?,
          	            category_id=?
          	        WHERE id=?";
          	$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category, $id]);

		    /**
		      If there is no error while 
		      updating the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully updated!";
				header("Location: ../admin/edit-device.php?success=$sm&id=$id");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../admin/edit-device.php?error=$em&id=$id");
	            exit;
		     }
          } 
	}else {
      header("Location: ../admin/admin.php");
      exit;
	}

}else{
  header("Location: ../public/login.php");
  exit;
}


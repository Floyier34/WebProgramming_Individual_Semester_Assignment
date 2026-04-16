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
	if (isset($_POST['device_name'])       &&
        isset($_POST['device_short_description']) &&
        isset($_POST['device_description']) &&
        isset($_POST['device_price'])      &&
        isset($_POST['device_brand'])      &&
        isset($_POST['device_category'])    &&
        isset($_FILES['device_image'])      &&
        isset($_FILES['file'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$name       = $_POST['device_name'];
		$short_description = $_POST['device_short_description'];
		$description = $_POST['device_description'];
		$price      = $_POST['device_price'];
		$brand      = $_POST['device_brand'];
		$category    = $_POST['device_category'];

		# making URL data format
		$user_input = 'name='.$name.'&short_desc='.$short_description.'&category_id='.$category.'&desc='.$description.'&brand_id='.$brand.'&price='.$price;

		#simple form Validation

        $text = "Device name";
        $location = "../admin/add-device.php";
        $ms = "error";
		is_empty($name, $text, $location, $ms, $user_input);

		$text = "Short description";
        $location = "../admin/add-device.php";
        $ms = "error";
		is_empty($short_description, $text, $location, $ms, $user_input);

		$text = "Full description";
        $location = "../admin/add-device.php";
        $ms = "error";
		is_empty($description, $text, $location, $ms, $user_input);

		$text = "Device brand";
        $location = "../admin/add-device.php";
        $ms = "error";
		is_empty($brand, $text, $location, $ms, $user_input);

		$text = "Device category";
        $location = "../admin/add-device.php";
        $ms = "error";
		is_empty($category, $text, $location, $ms, $user_input);

		if ($price === "" || !is_numeric($price) || $price < 0) {
			$em = "The price must be a valid number";
			header("Location: ../admin/add-device.php?error=$em&$user_input");
			exit;
		}
		$price = number_format((float) $price, 2, '.', '');
        
        # device image Uploading
        $allowed_image_exs = array("jpg", "jpeg", "png");
        $path = "images";
        $device_image = upload_file($_FILES['device_image'], $allowed_image_exs, $path);

        /**
	    If error occurred while 
	    uploading the device image
	    **/
	    if ($device_image['status'] == "error") {
	    	$em = $device_image['data'];

	    	/**
	    	  Redirect to '../admin/add-device.php' 
	    	  and passing error message & user_input
	    	**/
	    	header("Location: ../admin/add-device.php?error=$em&$user_input");
	    	exit;
	    }else {
	    	# file Uploading
            $allowed_file_exs = array("pdf", "docx", "pptx", "jpg", "jpeg", "png");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

            /**
		    If error occurred while 
		    uploading the file
		    **/
		    if ($file['status'] == "error") {
		    	$em = $file['data'];

		    	/**
		    	  Redirect to '../admin/add-device.php' 
		    	  and passing error message & user_input
		    	**/
		    	header("Location: ../admin/add-device.php?error=$em&$user_input");
		    	exit;
            }else {
		    	/**
		          Getting the new file name 
		          and device image name 
		        **/
		        $file_URL = $file['data'];
		        $device_image_URL = $device_image['data'];
                
                // TODO: Validate brand_id and category_id exist before insert.
                # Insert the data into database
                $sql  = "INSERT INTO devices (name,
                                            price,
                                            short_description,
                                            brand_id,
                                            description,
                                            category_id,
                                            image,
                                            file)
                         VALUES (?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
			    $res  = $stmt->execute([$name, $price, $short_description, $brand, $description, $category, $device_image_URL, $file_URL]);

			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "The device successfully created!";
				header("Location: ../admin/add-device.php?success=$sm");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../admin/add-device.php?error=$em");
	            exit;
		     }

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


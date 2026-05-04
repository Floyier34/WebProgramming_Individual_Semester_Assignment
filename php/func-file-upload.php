<?php 

# File upload helper function 
function upload_file($files, $allowed_exs, $path){
    # get data and store them in var
    $file_name = $files['name'];
    $tmp_name  = $files['tmp_name'];
    $error     = $files['error'];

    # Guard clause: if error occurred while uploading
    if ($error !== 0) {
        $em['status'] = 'error';
        $em['data']   = 'Error occurred while uploading!';
        return $em;
    }

    # get file extension store it in var
    $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);

    /** 
    convert the file extension into lower case 
    and store it in var 
    **/
    $file_ex_lc = strtolower($file_ex);

    # Guard clause: check if the the file extension exist in $allowed_exs array
    if (!in_array($file_ex_lc, $allowed_exs)) {
        $em['status'] = 'error';
        $em['data']   = "You can't upload files of this type";
        return $em;
    }

    /** 
    renaming the file 
    with random strings
    **/
    $new_file_name = uniqid("",true).'.'.$file_ex_lc;

    # assigning upload path
    $upload_dir = '../uploads/'.$path;
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file_upload_path = $upload_dir.'/'.$new_file_name;
    
    /** 
      moving uploaded file to 
      root directory upload/$path folder
    **/
    if (!move_uploaded_file($tmp_name, $file_upload_path)) {
        $em['status'] = 'error';
        $em['data']   = 'Error occurred while saving the uploaded file!';
        return $em;
    }

    /**
       Creating success message associative array
       with named keys status and data
    **/
    $sm['status'] = 'success';
    $sm['data']   = $new_file_name;

    #  Return the sm array
    return $sm;
}

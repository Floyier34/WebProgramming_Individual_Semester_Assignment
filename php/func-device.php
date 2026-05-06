<?php  

# Get All devices function
function get_all_devices($con){
   $sql  = "SELECT * FROM devices ORDER bY id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

function get_short_description($device){
   if (isset($device['short_description']) && trim($device['short_description']) !== "") {
      return $device['short_description'];
   }

   $desc = isset($device['description']) ? trim($device['description']) : "";
   if ($desc === "") {
      return "";
   }

   if (strlen($desc) <= 120) {
      return $desc;
   }

   return substr($desc, 0, 117) . "...";
}

function get_device_sort_sql($sort){
   if ($sort === "name_asc") {
      return "devices.name ASC";
   }
   if ($sort === "name_desc") {
      return "devices.name DESC";
   }
   if ($sort === "price_asc") {
      return "devices.price ASC";
   }
   if ($sort === "price_desc") {
      return "devices.price DESC";
   }
   if ($sort === "oldest") {
      return "devices.id ASC";
   }
   return "devices.id DESC";
}

# Get paginated devices
function get_devices_paginated($con, $limit, $offset, $sort){
   $order_by = get_device_sort_sql($sort);
   $sql  = "SELECT * FROM devices ORDER BY $order_by LIMIT ? OFFSET ?";
   $stmt = $con->prepare($sql);
   $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
   $stmt->bindValue(2, (int) $offset, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
      $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# Count all devices
function count_devices($con){
   $sql  = "SELECT COUNT(*) AS total FROM devices";
   $stmt = $con->prepare($sql);
   $stmt->execute();
   $row = $stmt->fetch();
   return (int) $row['total'];
}



# Get  device by ID function
function get_device($con, $id){
   $sql  = "SELECT * FROM devices WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $device = $stmt->fetch();
   }else {
      $device = 0;
   }

   return $device;
}


// Consider full-text indexes for name/brand/category search as data grows.
# Search devices function
function search_devices($con, $key){
   # creating simple search algorithm :) 
   $key = "%{$key}%";

   $sql  = "SELECT devices.* FROM devices
            LEFT JOIN brands ON brands.id = devices.brand_id
            LEFT JOIN categories ON categories.id = devices.category_id
            WHERE devices.name LIKE ?
            OR brands.name LIKE ?
            OR categories.name LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$key, $key, $key]);

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# Search devices with pagination
function search_devices_paginated($con, $key, $limit, $offset, $sort){
   $order_by = get_device_sort_sql($sort);
   $key = "%{$key}%";

   $sql  = "SELECT devices.* FROM devices
            LEFT JOIN brands ON brands.id = devices.brand_id
            LEFT JOIN categories ON categories.id = devices.category_id
            WHERE devices.name LIKE ?
            OR brands.name LIKE ?
            OR categories.name LIKE ?
            ORDER BY $order_by
            LIMIT ? OFFSET ?";
   $stmt = $con->prepare($sql);
   $stmt->bindValue(1, $key, PDO::PARAM_STR);
   $stmt->bindValue(2, $key, PDO::PARAM_STR);
   $stmt->bindValue(3, $key, PDO::PARAM_STR);
   $stmt->bindValue(4, (int) $limit, PDO::PARAM_INT);
   $stmt->bindValue(5, (int) $offset, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# Count search results
function count_search_devices($con, $key){
   $key = "%{$key}%";

   $sql  = "SELECT COUNT(*) AS total FROM devices
            LEFT JOIN brands ON brands.id = devices.brand_id
            LEFT JOIN categories ON categories.id = devices.category_id
            WHERE devices.name LIKE ?
            OR brands.name LIKE ?
            OR categories.name LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$key, $key, $key]);
   $row = $stmt->fetch();
   return (int) $row['total'];
}
# get devices by category
function get_devices_by_category($con, $id){
   $sql  = "SELECT * FROM devices WHERE category_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# get devices by category (paginated)
function get_devices_by_category_paginated($con, $id, $limit, $offset, $sort){
   $order_by = get_device_sort_sql($sort);
   $sql  = "SELECT * FROM devices WHERE category_id=? ORDER BY $order_by LIMIT ? OFFSET ?";
   $stmt = $con->prepare($sql);
   $stmt->bindValue(1, (int) $id, PDO::PARAM_INT);
   $stmt->bindValue(2, (int) $limit, PDO::PARAM_INT);
   $stmt->bindValue(3, (int) $offset, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# count devices by category
function count_devices_by_category($con, $id){
   $sql  = "SELECT COUNT(*) AS total FROM devices WHERE category_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([(int) $id]);
   $row = $stmt->fetch();
   return (int) $row['total'];
}

# get devices by brand
function get_devices_by_brand($con, $id){
   $sql  = "SELECT * FROM devices WHERE brand_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# get devices by brand (paginated)
function get_devices_by_brand_paginated($con, $id, $limit, $offset, $sort){
   $order_by = get_device_sort_sql($sort);
   $sql  = "SELECT * FROM devices WHERE brand_id=? ORDER BY $order_by LIMIT ? OFFSET ?";
   $stmt = $con->prepare($sql);
   $stmt->bindValue(1, (int) $id, PDO::PARAM_INT);
   $stmt->bindValue(2, (int) $limit, PDO::PARAM_INT);
   $stmt->bindValue(3, (int) $offset, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
        $devices = $stmt->fetchAll();
   }else {
      $devices = 0;
   }

   return $devices;
}

# count devices by brand
function count_devices_by_brand($con, $id){
   $sql  = "SELECT COUNT(*) AS total FROM devices WHERE brand_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([(int) $id]);
   $row = $stmt->fetch();
   return (int) $row['total'];
}


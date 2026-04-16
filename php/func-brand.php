<?php 

# Get all Brand function
function get_all_brand($con){
   $sql  = "SELECT * FROM brands";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $brands = $stmt->fetchAll();
   }else {
      $brands = 0;
   }

   return $brands;
}


# Get  Brand by ID function
function get_brand($con, $id){
   $sql  = "SELECT * FROM brands WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $brand = $stmt->fetch();
   }else {
      $brand = 0;
   }

   return $brand;
}

<?php

# Store locations helper functions
function get_locations(){
   $locations = [
      [
         "id" => 1,
         "name" => "Downtown Showroom",
         "address" => "123 Main St, Ho Chi Minh City, Vietnam"
      ],
      [
         "id" => 2,
         "name" => "Riverside Service Hub",
         "address" => "45 River Rd, Thu Duc, Ho Chi Minh City, Vietnam"
      ],
      [
         "id" => 3,
         "name" => "Airport Pickup Point",
         "address" => "8 Airport Ave, Tan Binh, Ho Chi Minh City, Vietnam"
      ]
   ];

   foreach ($locations as $i => $loc) {
      $locations[$i]["maps_url"] = "https://www.google.com/maps/search/?api=1&query=" . urlencode($loc["address"]);
   }

   return $locations;
}

function get_locations_for_device($device_id){
   $locations = get_locations();
   $available = [];

   foreach ($locations as $loc) {
      if ((($device_id + $loc["id"]) % 2) === 0) {
         $available[] = $loc;
      }
   }

   if (count($available) === 0) {
      $available[] = $locations[0];
   }

   return $available;
}


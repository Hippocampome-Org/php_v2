<?php
  include ("permission_check.php");
  $table = "izhmodels_single";
  $query = "SELECT * FROM $table ORDER BY unique_id ASC";
  $result = mysqli_query($GLOBALS['conn'],$query);
  
  $json_data = array();
  while ($row = mysqli_fetch_assoc($result)) {
	 $name_key = $row["name"];
	 if(!array_key_exists($name_key,$json_data)) {
		$json_data[$name_key] = array($row);
	 } else {
		array_push($json_data[$name_key],$row);
 
	 }
  }

  // Close connection
  //mysqli_close($con);

  // Output JSON string
  $responce = $json_data;
  
 // echo json_encode($json_data);
  

  
?>

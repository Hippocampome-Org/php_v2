<?php

//include 'getMorphology.php';
//$_SESSION['morphology'] = json_encode($responce);

$session_matrix_cache_file = "cache/session_matrix_morph.json";
$get_matrix = "getMorphology.php";
$matrix_type = "morphology";

if (file_exists($session_matrix_cache_file))
{
  session_start();
  include ("access_db.php");
 	 include ("permission_check.php");
  $_SESSION[$matrix_type] = file_get_contents($session_matrix_cache_file);
}
else
{
  include $get_matrix;
  $_SESSION[$matrix_type] = json_encode($responce);
  $fp = fopen($session_matrix_cache_file, 'w');
  fwrite($fp, $_SESSION[$matrix_type]);
  fclose($fp); 
}

//$_SESSION['morphology_set'] = 1;
//echo "done";

?>

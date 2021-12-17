<?php
//ini_set('display_errors', 1); error_reporting(~0);
$session_matrix_cache_file = "cache/session_matrix_phases.json";
$get_matrix = "getPhases.php";
$matrix_type = "phases";

if (file_exists($session_matrix_cache_file))
{
  
	error_log("If");
  session_start();
  include ("access_db.php");
 	include ("permission_check.php");
  $_SESSION[$matrix_type] = file_get_contents($session_matrix_cache_file);
}
else
{
  
  error_log("Else");
  include $get_matrix;
  $_SESSION[$matrix_type] = json_encode($responce);
  $fp = fopen($session_matrix_cache_file, 'w');
  fwrite($fp, $_SESSION[$matrix_type]);
  fclose($fp); 
  
}

//$_SESSION['morphology_set'] = 1;
//echo "done";

?>

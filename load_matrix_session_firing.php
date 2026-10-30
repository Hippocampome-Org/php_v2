<?php

$session_matrix_cache_file = "cache/session_matrix_firing.json";
$get_matrix = "getFiringPatterns.php";
$matrix_type = "firingpattern";

if (file_exists($session_matrix_cache_file))
{
  if (session_status() === PHP_SESSION_NONE) session_start();
  include ("access_db.php");
  $perm = $_SESSION['perm'] ?? null;
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

//echo "done";

?>

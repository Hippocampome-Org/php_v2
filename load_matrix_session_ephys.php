<?php

//include 'getEphys.php';
//$_SESSION['ephys'] = json_encode($responce);

$session_matrix_cache_file = "cache/session_matrix_ephys.json";
$get_matrix = "getEphys.php";
$matrix_type = "ephys";

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
  // PHP83-FIX by KN on 2026-10-30: if the cache folder is missing or not writable, fopen() returns false;
  // PHP 7 only warned, PHP 8 stops with a fatal error in fwrite(). Skip the cache write in that case.
  $fp = @fopen($session_matrix_cache_file, 'w');
  if ($fp) {
  	fwrite($fp, $_SESSION[$matrix_type]);
  	fclose($fp);
  }
}

//echo "done";

?>

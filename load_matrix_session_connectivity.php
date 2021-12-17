<?php
$session_matrix_cache_file = "cache/session_matrix_conn.json";
$get_matrix = "getConnectivity.php";
$matrix_type = "connectivity";

if (file_exists($session_matrix_cache_file))
{
	session_start();
	include ("access_db.php");
	$perm = $_SESSION['perm'];
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
?>
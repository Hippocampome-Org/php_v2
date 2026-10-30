<?php
mysqli_report(MYSQLI_REPORT_OFF); // PHP83-FIX by KN on 2026-10-30: failed queries return false like PHP 7 instead of stopping the page
include ("access_db.php");
$perm = $_SESSION['perm'] ?? null;
if ($perm == NULL) {
	$query = "SELECT permission FROM user WHERE id = '2'";
	$rs = mysqli_query($GLOBALS['conn'],$query);
	while (list($permission) = ($rs ? mysqli_fetch_row($rs) : null)) {
		if ($permission == 1) {
			$anonymous = 1;
		}
		else {
			$anonymous = 0;
		}
	}
	if ((float)$anonymous == 0) {
		header("Location:error1.html");
	}
}
?>

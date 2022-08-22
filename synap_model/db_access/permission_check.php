<?php
include ("access_db.php");
$perm = $_SESSION['perm'];
if ($perm == NULL) {
	header("Location:../../error1.html");
}
?>
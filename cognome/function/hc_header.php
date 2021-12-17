<!--
  General code that is included from the main hippocampome site for the header of the
  page.
-->
<?php
  include ("../access_db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<script type="text/javascript" src="../style/resolution.js"></script>
<link rel="stylesheet" href="../style/style.css" type="text/css" />
<link rel="stylesheet" href="../function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<style type="text/css">
#dvLoading {
background-image: url(../images/ajax-loader.gif);
background-repeat: no-repeat;
background-position: center;
height: 100px;
width: 100px;
position: fixed;
z-index: 1000;
left: 70%;
top: 15%;
margin: -25px 0 0 -25px;
}
</style>
<?php
include("../function/icon.html");
?>
<?php $menuaddr = "../" ?>
<?php include ("../function/title.php"); ?>
<?php include('../function/menu_main.php'); ?>
<link rel="stylesheet" href="../function/menu_support_files/menu_main_style.css" type="text/css" />

<?php
	// server should keep session data for maximum time availible
	// ini_set('session.gc_maxlifetime', 65535);
	// each client should remember their session id for maximum time availible
	// session_set_cookie_params(65535); 
	//
	// TODO: try to get session timeout set before session started, because setting it 
	// afterward is not an option

	if (isset($_SESSION['active_db']) || isset($_REQUEST['active_db'])) {
    	if (isset($_REQUEST['active_db'])) {
		    $active_db = $_REQUEST['active_db'];
		}
		else if (isset($_SESSION['active_db'])) {
		    $active_db = $_SESSION['active_db'];
		    $_SESSION['active_db'] = $active_db; // keep session variable alive (avoid timeout) by setting it here.
		}

    	if ($active_db == "core") {
		    $cog_database = "cognome_core";
		}
		else if ($active_db == "extended") {
			$cog_database = "cognome";
		}
		$cog_conn = mysqli_connect($cog_servername, $cog_username, $cog_password, $cog_database);   		
  	}
?>
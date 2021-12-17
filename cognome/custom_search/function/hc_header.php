<!--
  General code that is included from the main hippocampome site for the header of the
  page.
-->
<?php
  include ("../../access_db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<!-- Site for Hippocampus region models and theories that are described computationally in terms of spiking neural networks. 
References: Javascript select redirect: https://www.webdeveloper.com/d/211180-drop-down-menus-with-url-link-options/2-->
<?php
//-------user login required check----------
/*$_SESSION['perm'] = 0;
$_SESSION['fp']=0;
$_SESSION['if']=0;
$_SESSION['im']=0;
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($cog_conn,$query);
list($permission) = mysqli_fetch_row($rs);
if ($permission == 1) { 
  $_SESSION['perm'] = 1;
}
else{
  $_SESSION['perm'] = 0;
}
//-------------------------------------------
//$_SESSION['perm'] = 0;
$permission1 = $_SESSION['perm'];
if ($_SESSION['perm'] == 0) {
  if (array_key_exists('password', $_REQUEST)) {
    $query = "SELECT permission FROM user WHERE password = '{$_REQUEST['password']}'";
    $rs = mysqli_query($cog_conn,$query);
    while(list($permission) = mysqli_fetch_row($rs)) {
      if ($permission == 1) { 
        $permission1 = $permission;
        $_SESSION['perm'] = $permission1;
      }
      else;
    }
      $query = "SELECT permission FROM user WHERE id=3";
      $rs = mysqli_query($cog_conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['fp']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=4";
      $rs = mysqli_query($cog_conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['if']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=5";
      $rs = mysqli_query($cog_conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['im']=1;
          }
      }
  }
}*/
// delete temporary table for the research: -----------------
/*
include("../../function/remove_table_research.php");
remove_table_by_tyme();
*/
// ------------------------------------------------------------
?>

<script type="text/javascript" src="../../style/resolution.js"></script>
<link rel="stylesheet" href="../../style/style.css" type="text/css" />
<link rel="stylesheet" href="../../function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<style type="text/css">
#dvLoading {
background-image: url(../../images/ajax-loader.gif);
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
include("../../function/icon.html");
?>

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
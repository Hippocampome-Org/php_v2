<?php
  include ("access_db.php");
  include ("page_counter.php");  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<?php
/* include("simphp-2.0.php"); */

//-------user login required check----------
$_SESSION['perm'] = 0;
$_SESSION['fp']=0;
$_SESSION['if']=0;
$_SESSION['im']=0;
$_SESSION['sy']=0;
$_SESSION['cg']=0;
$_SESSION['sp']=0;
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
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
    $rs = mysqli_query($conn,$query);
    while(list($permission) = mysqli_fetch_row($rs)) {
      if ($permission == 1) { 
        $permission1 = $permission;
        $_SESSION['perm'] = $permission1;
      }
      else;
    }
      $query = "SELECT permission FROM user WHERE id=5";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['im']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=6";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['sy']=1;
          }
      }      
      $query = "SELECT permission FROM user WHERE id=7";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['cg']=1;
          }
      }
      $query = "SELECT permission FROM user WHERE id=8";
      $rs = mysqli_query($conn,$query);
      while(list($permission) = mysqli_fetch_row($rs)) {
          if ($permission == 1) {
              $_SESSION['sp']=1;
          }
      }	  
  }
}
// delete temporary table for the research: -----------------
include("function/remove_table_research.php");
remove_table_by_tyme();
// ------------------------------------------------------------
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>

<style type="text/css">
#dvLoading {
  background-image: url(images/ajax-loader.gif);
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

<script>
jQuery(document).ready(function() {
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_markers.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_ephys.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_morphology.php',
    success: function() {}
  });
  $.ajax({
      type: 'GET',
      cache: false,
      contentType: 'application/json; charset=utf-8',
      url: 'load_matrix_session_connectivity.php',
      success: function() {}
    });
	$.ajax({
		type: 'GET',
		cache: false,
		contentType: 'application/json; charset=utf-8',
		url: 'load_matrix_session_firing.php',
		success: function() {}
  });
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_firing_parameter.php',
    success: function() {}
  });
  $('div#menu_main_button_new_clr').css('display','block');
});
</script>

<?php
include("function/icon.html");
?>

<title id="title_id">Hippocampome</title>

</head>

<body>

<?php 
include("function/title.php");
if ($permission1 != 0) {
include("function/menu_main.php");  
}
?>  
<script>
jQuery(document).ready(function() {
  $("#menu_main_button_new_clr").css("diplay","none");
});
</script>

<br /><br /><br /><br /><br />

<!--<table width=1100 class='index_table' id="table_load">-->
<table>
  <tr>    
    <td width=25></td>
    <td width=700>
    <!-- ****************  BODY **************** -->
      <font class='font1' color='#000000'>
      WELCOME TO THE HIPPOCAMPOME PORTAL
      </font>
      <BR>
      <font class='font2' color='#000000'>
      v1.10 - Released: 08/03/2021
      <br>
      28,481 Pieces of Knowledge (PoK) and 36,858 Pieces of Evidence (PoE)
      <br>
      <br>
      The Hippocampome is a curated knowledge base of the circuitry
      of the hippocampus of normal adult, or adolescent, rodents at
      the mesoscopic level of neuronal types. Knowledge concerning
      dentate gyrus, CA3, CA2, CA1, subiculum, and entorhinal cortex
      is distilled from published evidence and is continuously updated
      as new information becomes available. Each reported neuronal
      property is documented with a pointer to, and excerpt from,
      relevant published evidence, such as citation quotes or illustrations.
      <br><br>
      The goal of the Hippocampome is dense coverage of available data
      characterizing neuronal types. The Hippocampome is a public and
      free resource for the neuroscience community, and the knowledge
      is presented for user-friendly browsing and searching and for
      machine-readable downloading.
      <br><br>
      If you have feedback on either functionality or content, or if you
      would like to be informed when the first official version is released,
      please fill out the
      <a href="user_feedback_form_entry.php">feedback form</a>
      or email us at
      <a href="mailto:Hippocampome.org@gmail.com">Hippocampome.org@gmail.com</a>.

      <?php
        if ($permission1 == 0) {
      ?>

      <form action="index.php" method="post" id="form_load">
        <font class='font2'> Please insert password: </font><br />
        <input type="password" size="50" name='password' class='select1' id="password_load"/>
        <input type="submit" name='ok' value=' OK ' id="submit_load"/>
      </form>

      <?php
        }
        else;
      ?>

      <br>
    </td>

    <td width=375 style='vertical-align:top; padding-top:0px; padding-left:50px'>
      <img src='images/brain6.png' width='450px' id="image_brain"/>
      <font class='font2' color='#000000'>
        <br><br>
        <center>
          <a class="twitter-timeline" data-lang="en" data-width="400" data-height="500" data-theme="light" href="https://twitter.com/Hippocampome?ref_src=twsrc%5Etfw">Tweets by Hippocampome</a>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </center>
      </font>
    </td>
  </tr>

  <tr>
    <td colspan="2">
        <!--      <div class='version'> -->
        <div class='version2'>
          <!--  <a href='http://peg.gd/2yN' target="_blank">http://peg.gd/2yN</a> -->
          <hr class='hr2'/>
          <font class='font3' color='#000000'>
          <a href="Help_Terms_of_Use.php">Terms of Use</a>
          <br><br>
            NOTICE: Non-licensed copyrighted content that may be incorporated into this not-for-profit, educational web
            portal was vetted using the "fair use" criteria defined in
            <a href="http://www.copyright.gov/title17/92chap1.html#107" target="_blank">Title 17 of the U.S. Code,
            &sect; 107</a>. This content, cited throughout this portal, may be protected by Copyright Law and unavailable
            for reuse.  Except otherwise noted, this web portal is &copy; 2015-2021 by George Mason University, under a
            <a href =' http://creativecommons.org/licenses/by-sa/3.0/' target="_blank">Creative Commons
            Attribution-ShareAlike [CC BY-SA] license</a>. 

          <!-- <br /><p><?php echo $info; ?> -->
          <br /><p><?php $webpage_id_number = 1; include('report_hits.php'); ?>
          <br>
          28,481 Pieces of Knowledge (PoK) and 36,858 Pieces of Evidence (PoE)
          <br />Last Update: 11 Jan 2022 (<a href="Help_Release_Notes.php">v1.10 R 1E</a>)</font>
          <br />
        </div>
    </td>   
  </tr>
</table>

</body>

</html>

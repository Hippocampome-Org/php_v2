<?php include ("../permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <?php include('set_theme.php'); ?>
  <?php include('../function/hc_header.php'); ?>
</head>
<body>
  <?php include("../function/hc_body.php"); ?>
  <div style="width:90%;position:relative;left:5%;">
    <!--<br>-->
    <br>
  <!-- start of header -->
  <!--?php echo file_get_contents('header.html'); ?-->
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML='Literature Submission';
  </script>
  <!-- end of header -->    
  
  <?php
  include('mysql_connect.php');
  $sub_success='true';   

  $art_num=$_POST['new_art_numb'];
  $art_off_id=$_POST['art_off_id'];
  $art_mod_id=$art_num;
  $art_info_change=false;
  
  // functions and processing of adding/removing property types
  include('add_rem_prop.php');

  if ($art_info_change) {
    // Check if article is existing one or new one
    $result = $cog_conn->query("SELECT ID FROM $cog_database.articles WHERE ID=".$art_num);
    if($result->num_rows == 0) { 
      // check for missing official id
      if($art_off_id == '') {
          echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Error: missing official id description";
          //echo "<br><br><a href='mod_art.php'>Back to update articles collection page</a>";
          echo "<br><br></div>";
          exit();
      }
      // check for duplicate article
      $sql = "SELECT official_id FROM $cog_database.articles WHERE official_id=\"".$art_off_id."\";";
      $result = $cog_conn->query($sql);
      if($result->num_rows == 0 && $_POST['citation'] != '') {
        // submit new article info
        include('submit_info.php');
      } 
      else {
        // duplicate official id found
        $sub_success='false';
        echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Article submission not successful";
        if ($_POST['citation'] != '') {
          echo " because article already exists in the database.<br>Existing article has official id ".$art_off_id." and url <a href='".$_POST['url']."' target='_blank'>".$_POST['url']."</a> .";
          //echo "<br><br><a href='mod_art.php'>Back to update articles collection page</a>";
          echo "<br><br></div>";
        }
        else {
          echo "<br>Error: missing citation description.";
          //echo "<br><br><a href='mod_art.php'>Back to update articles collection page</a>";
          echo "<br><br></div>";
        }
      } 
    } 
    else {
      // update existing article info
      include('update_info.php');
    }

    if ($sub_success=='true') {
      date_default_timezone_set('America/New_York');
      $date = date('m/d/Y h:i:s a', time());
      echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Literature collection update successful.<br>Submission received at: ".$date." EST.";
      //echo "<br><br><a href='mod_art.php'>Back to update articles collection page</a><br>";
      echo "<br><br></div>";
    }
  }
  $cog_conn->close();
  ?>
</center></table></div></div><br></div></body></html>
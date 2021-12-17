<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
  <script type="text/javascript">
    function toggle_vis(elem_name) {
       var elem = document.getElementById(elem_name);
       if (elem.style.display === "none") {
        elem.style.display = "block";
      } else {
        elem.style.display = "none";
      }
    }
  </script>
</head>
<body>
  <?php include("function/hc_body.php"); ?>
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <div style="width:90%;position:relative;left:5%;"> 
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='#' style='text-decoration: none;color:black !important'><span class='title_section'>Database Update Area</span></a>";
    document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
  </script>
  <!-- end of header -->

  <?php
  echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>This part of the site requires administrator access.<br><br><a href='index.php'>Return to main site</a><br><br></div>";
  ?>
  <br><br><br><br>
</div>
</body>
</html>

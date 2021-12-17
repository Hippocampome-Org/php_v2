<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
</head>
<body>
  <?php include("function/hc_body.php"); ?> 
  <div style="width:90%;position:relative;left:5%;">
  <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML='Help and Details About the Site';
  </script>
  <!-- end of header -->

  <!-- theme section -->
  <?php
  echo "<form action='help.php' method='POST'><div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:.9em;'>Choose theme&nbsp&nbsp<select name='site_theme' id='site_theme' size='1' class='select-css' style='position:relative;top:-2px;'><option value='#'>Theme</option><option value='light_white_bg'";
  if (isset($_POST['site_theme']) && $theme=='light_white_bg') {
    echo " selected";
  }
    echo ">Light with White BG Theme</option><option value='light'";
  if (isset($_POST['site_theme']) && $theme=='light') {
    echo " selected";
  }
    echo ">Light Theme</option><option value='dark'";
  if (isset($_POST['site_theme']) && $theme=='dark') {
    echo " selected";
  }
  echo ">Dark Theme</option><option value='medium_dark'";
  if (isset($_POST['site_theme']) && $theme=='medium_dark') {
    echo " selected";
  }
  echo ">Medium Dark Theme</option></select>&nbsp&nbsp<input type='submit' value='  Update  ' style='height:30px;font-size:16px;position:relative;top:-2px;'></input></div></form><br>";
  ?>
  <!-- end of theme section -->

  <!-- main help descriptions -->
  <div class='article_details'>
  <u>Inclusion Criteria of Articles</u><br>
  Articles that describe spiking neural network or circuit computational models. The neural activity in the models must include the region of the hippocampal formation. Some form of a neural network algorithm must be included in the modeling. An original (not previously performed) simulation of the model must be included in the work.
  </div>
  <br><div class='article_details'>
  <u>Subject</u><br>
  This defines what subject area to display relevant work from.
  <br><br><u>Research Dimension</u><br>
  This defines what dimension to include with the work descriptions, and the dimension used for sorting the work.
  <br><br><u>Study Property</u><br>
  This defines specific properties to include with work descriptions. Selecting all causes all properties to be included. This option is not fully implemented yet, selecting any option includes all properties at the current time. Work will be done to implement it more later.
  <br><br><u>Go Button</u><br>
  Press this to update the results based on the options selection made.</div>

  <br><div class='article_details'>
  <u>Core collection design</u><br>
  Details about how the core collection was constructed are included here.
  <br><br><u>Keyword selection</u><br>
  The list of keywords that the optimization software used for creating literature database queries are provided here.
  <br><a href="db_methods.php?disp=short_kwds">Short version of keywords</a>
  <br><a href="db_methods.php?disp=long_kwds">Long version of keywords</a>
  </div>

  <?php
  include('mysql_connect.php');    

  echo "<br><div class='article_details' style='min-width:500px;'><center><u>Glossary</u><br><font style='font-size:16px;'>Click the <img src='info.gif' title='annotation methods description' style='position:relative;top:1px;height:14px;width:14px;'> buttons below for additional descriptions.</font></center><br><center><table style='font-size:0.8em;'>";
  
  include('glossary.php');

  $cog_conn->close();

  ?></center></table>
</div></div><br>
</div>
</body>
</html>

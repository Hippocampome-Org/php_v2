<?php include ("../access_db.php"); ?>
<?php include ("../permission_check.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title id="title_id">Cognome Knowledgebase</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
</head>
<body>
  <?php include("function/hc_body.php"); ?>  
  <br><br> 
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <div style="width:90%;position:relative;left:5%;">
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='index.php' style='text-decoration: none;color:black !important'><span class='title_section'>Cognome Knowledgebase</span></a>";
    document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
  </script>
  <!-- end of header -->  

  <?php
  // retreive dimension names
  include('dimension_names.php');

  /*
    generate article results
    the dimension search bar is created here
  */
  include('search_option.php');    
  echo "
  <form action='#' method='POST' style='font-size:1em;'>
  <center>";
  search_option($cog_conn, $sql, "Filter: subject dimension", "subject", "subjects", "all_on");
  echo "<br>";
  search_option($cog_conn, $sql, "Sort: other dimension", "dimension", "dimensions", "all_on");
  echo "&nbsp";
  search_option($cog_conn, $sql, "detail", "property", "properties", "all_off"); 
  echo "<span style='display: inline-block;'>
  <input type='hidden' name='form_submitted' value='1' />
  &nbsp; &nbsp;<input type='submit' value='   go   '  class='select-css'></span>
  </center></form><br>";

  // check for user's dimension selection
  include('get_dimension.php');

  // construct article search query
  include('search_query.php');

  // display articles based on the user's selection
  include('display_articles.php');

  $cog_conn->close();

  ?>
</div>
</body>
</html>

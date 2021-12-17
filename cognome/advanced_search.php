<?php include ("permission_check.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title id="title_id">Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <script>
    function set_second_filter($selection) {
      document.getElementById('second_filter').value = $selection;
      document.forms["search_options"].submit();
    }
  </script>
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
    document.getElementById('header_title').innerHTML="<a href='advanced_search.php' style='text-decoration: none;color:black !important'><span class='title_section'>Advanced Search</span></a>";
    document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
  </script>
  <!-- end of header -->  

  <?php
  include('mysql_connect.php');     

  // retreive dimension names
  include('dimension_names.php');

  /*
    generate article results
    the dimension search bar is created here
  */
  $description  = "<br>Filter property -";
  $all_switch = "all_off";
  $prop_value = ''; $row_name = ''; $tbl_name = '';
  $second_filter = 'no filter';
  if (isset($_REQUEST['second_filter'])) {
    $second_filter = $_REQUEST['second_filter'];
  }

  include('search_option.php');    
  echo "
  <form name='search_options' action='#' method='POST' style='font-size:1em;'>
  <center>";
  search_option($cog_conn, $sql, "First filter: subject dimension", "subject", "subjects", "all_on");
  echo "<br><span style='display: inline-block;' style='a {text-decoration:none important!;};text-decoration:none important!;'>
  Second filter: dimension entity:&nbsp<a href='javascript:set_second_filter(\"detail\")'><input type='button' class='light_bg select-css' value='level of detail'></a>&nbsp;<a href='javascript:set_second_filter(\"implmnt\")'><input type='button' class='light_bg select-css' value='implementation level'></a>&nbsp;<a href='javascript:set_second_filter(\"keyword\")'><input type='button' class='light_bg select-css' value='keyword'></a><br><a href='javascript:set_second_filter(\"theory\")'><input type='button' class='light_bg select-css' value='theory or network algorithm'></a>&nbsp;<a href='javascript:set_second_filter(\"scale\")'><input type='button' class='light_bg select-css' value='simulation scale'></a>&nbsp;<a href='javascript:set_second_filter(\"neuron\")'><input type='button' class='light_bg select-css' value='neuron types'></a>&nbsp;<a href='javascript:set_second_filter(\"region\")'><input type='button' class='light_bg select-css' value='anatomical region'>
  <input type='hidden' name='second_filter' id='second_filter'";
  if (isset($_REQUEST['second_filter'])) {
    echo " value='".$_REQUEST['second_filter']."'";
  }
  echo " />";
  echo "</a></span>"; 
  function entity_options($cog_conn, $sql, $prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row, $all_switch, $description) {
    echo $description;
    search_option($cog_conn, $sql, $prop_name, $row_name, $tbl_name, $all_switch);

    return array($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row);
  }
  if ($second_filter=='detail') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "level of detail", "detail_level", "details", "article_has_detail", "detail_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='implmnt') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "implementation level", "level", "implementations", "article_has_implmnt", "level_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='keyword') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "keyword", "keyword", "keywords", "article_has_keyword", "keyword_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='region') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "anatomical region", "region", "regions", "article_has_region", "region_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='scale') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "simulation scale", "scale", "network_scales", "article_has_scale", "scale_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='neuron') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "neuron type", "neuron", "neuron_types", "article_has_neuron", "neuron_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  if ($second_filter=='theory') {
    list($prop_name, $row_name, $tbl_name, $prop_relation_tbl, $prop_relation_row) = entity_options($cog_conn, $sql, "theory or network algorithm", "category", "theory_category", "article_has_theory", "theory_id", $all_switch, $description);
    $prop_value = $_POST[$row_name];
  }
  echo "<br>Sort:";
  search_option($cog_conn, $sql, "dimension", "dimension", "dimensions", "all_on");
  search_option($cog_conn, $sql, "detail", "property", "properties", "all_off"); 
  echo "<input type='hidden' name='form_submitted' value='1' />
  <br><span style='padding:20px'><input type='submit' value='   go   '  class='light_bg select-css'></span></span>
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

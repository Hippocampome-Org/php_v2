<?php include ("../permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
  <?php ini_set('max_execution_time', '600'); ?>
  <?php include('secret_key.php'); ?>
  <script type="text/javascript">
    function toggle_vis(elem_name) {
      var elem = document.getElementById(elem_name);
      if (elem.style.display === "none") {
        elem.style.display = "block";
      } else {
        elem.style.display = "none";
      }
    }
    function load_keywords(id) {
      if (document.getElementsByName('search_query')[0].value != '') {
        document.getElementsByName('search_query')[0].value += ', '
      }
      if (id == "subjects_btn") {
        document.getElementsByName('search_query')[0].value += 'spatial memory, spatial memories, associative memory, associative memories, association memory, associative memories, autoassociative, autoassociation, heteroassociative, heteroassociation, time cell, delayed conditioning, pattern completion, pattern separation, long term memory, long term memories, long-term memory, long-term memories, consolidation, reinforcement learning, visual memory, visual memories, auditory, tactile, taste, smell, recognition memory, recognition memories, episodic, semantic memory, semantic memories, working memory, working memories, short-term memory, short-term memories, short term memory, short term memories, epilepsy, epileptic, epileptiform, seizure, schizophrenia, Alzheimer';
      }
      else if (id == "level_btn") {
        document.getElementsByName('search_query')[0].value += 'Hodgkin-Huxley, Hodgkin Huxley, Izhikevich, Integrate-and-fire, Integrate and fire, Mean field, Abstract cognition, Spike response, Firing rate';
      }      
      else if (id == "scale_btn") {
        document.getElementsByName('search_query')[0].value += 'network scale, network size, population size';
      }
      else if (id == "impl_btn") {
        document.getElementsByName('search_query')[0].value += 'modeling equations, modeling formulas, equations used in modeling';
      }
      else if (id == "region_btn") {
        document.getElementsByName('search_query')[0].value += 'hippocampus, dentate gyrus, dg, cornu ammonis i, ca1, cornu ammonis ii, ca2, cornu ammonis iii, ca3, subiculum, entorhinal cortex, ec, mec, basal ganglia';
      }
      else if (id == "theories_btn") {
        document.getElementsByName('search_query')[0].value += 'attractor, oscillatory interference, self-organizing map, self organizing map, phase precession, velocity controlled oscillator, velocity-controlled oscillator, controlled oscillator';
      }
      else if (id == "neurons_btn") {
        document.getElementsByName('search_query')[0].value += 'Granule, Hilar Ectopic Granule, Semilunar Granule, Mossy, Mossy MOLDEN, AIPRIM, DG Axo-axonic, DG Basket, DG Basket CCK+, HICAP, HIPP, HIPROM, MOCAP, MOLAX, MOPP, DG Neurogliaform, Outer Molecular Layer, Total Molecular Layer, CA3 Pyramidal, CA3c Pyramidal, CA3 Giant, CA3 Granule, CA3 Axo-axonic, CA3 Horizontal Axo-axonic, CA3 Basket, CA3 Basket CCK+, CA3 Bistratified, CA3 Interneuron Specific Oriens, CA3 Interneuron Specific Quad, CA3 Ivy, CA3 LMR-Targeting, Lucidum LAX, Lucidum ORAX, Lucidum-Radiatum, Spiny Lucidum, Mossy Fiber-Associated, Mossy Fiber-Associated ORDEN, CA3 O-LM, CA3 QuadD-LM, CA3 Radiatum, CA3 R-LM, CA3 SO-SO, CA3 Trilaminar, CA2 Pyramidal, CA2 Basket, CA2 Wide-Arbor Basket, CA2 Bistratified, CA2 SP-SR, CA1 Pyramidal, Cajal-Retzius, CA1 Radiatum Giant, CA1 Axo-axonic, CA1 Horizontal Axo-axonic, CA1 Back-Projection, CA1 Basket, CA1 Basket CCK+, CA1 Horizontal Basket, CA1 Bistratified, CA1 Interneuron Specific LMO-O, CA1 Interneuron Specific LM-R, CA1 Interneuron Specific LMR-R, CA1 Interneuron Specific O-R, CA1 Interneuron Specific O-Targeting QuadD, CA1 Interneuron Specific R-O, CA1 Interneuron Specific RO-O, CA1 Ivy, CA1 LMR, CA1 LMR Projecting, CA1 Neurogliaform, CA1 Neurogliaform Projecting, CA1 O-LM, CA1 Recurrent O-LM, CA1 O-LMR, CA1 Oriens/Alveus, CA1 Oriens-Bistratified, CA1 Oriens-Bistratified Projecting, CA1 OR-LM, CA1 Perforant Path-Associated, CA1 Perforant Path-Associated QuadD, CA1 Quadrilaminar, CA1 Radiatum, CA1 R-Receiving Apical-Targeting, Schaffer Collateral-Associated, Schaffer Collateral-Receiving R-Targeting, CA1 SO-SO, CA1 Hippocampo-subicular Projecting ENK+, CA1 Trilaminar, CA1 Radial Trilaminar, SUB EC-Projecting Pyramidal, SUB CA1-Projecting Pyramidal, SUB Axo-axonic, LI-II Multipolar-Pyramidal, LI-II Pyramidal-Fan, MEC LII-III Pyramidal-Multiform, MEC LII Oblique Pyramidal, MEC LII Stellate, LII-III Pyramidal-Tripolar, LEC LIII Multipolar Principal, MEC LIII Multipolar Principal, LIII Pyramidal, LEC LIII Complex Pyramidal, MEC LIII Complex Pyramidal, MEC LIII Bipolar Complex Pyramidal, LIII Pyramidal-Stellate, LIII Stellate, LIII-V Bipolar Pyramidal, LIV-V Pyramidal-Horizontal, LIV-VI Deep Multipolar Principal, MEC LV Multipolar-Pyramidal, LV Deep Pyramidal, MEC LV Pyramidal, MEC LV Superficial Pyramidal, MEC LV-VI Pyramidal-Polymorphic, LEC LVI Multipolar-Pyramidal, LII Axo-axonic, MEC LII Basket, LII Basket-Multipolar Interneuron, LEC LIII Multipolar Interneuron, MEC LIII Multipolar Interneuron, MEC LIII Superficial Multipolar Interneuron, LIII Pyramidal-Looking Interneuron, MEC LIII Superficial Trilayered Interneuron';
      }
      else if (id == "keywords_btn") {
        document.getElementsByName('search_query')[0].value += 'alpha, beta, gamma, theta, rhythm, ion channel, rodent, pathfinding, path finding, review, full scale, place cell, grid cell';
      }                              
    }
  </script>
</head>
<body>
  <?php include("function/hc_body.php"); ?>   
    <br>
    <!-- start of header -->
    <?php echo file_get_contents('header.html'); ?>
    <div style="width:90%;position:relative;left:5%;"> 
    <script type='text/javascript'>
      document.getElementById('header_title').innerHTML="<a href='custom_search.php' style='text-decoration: none;color:black !important'><span class='title_section'>Custom Search</span></a>";
      document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
    </script>
    <!-- end of header -->

    <?php
    $show_snippits = false;
    $snippit_size = 400;
    $cog_database = "cognome_core"; // for the current time, restrict search to cognome core
    //$dir = "/var/www/html/cognome/php/cognome/lit_rev/query_optimize/dataset/";
    $dir = "/var/www/html/cognome_articles_renamed/core_collection/txt_ver_rnm/"; // directory of literature in text file format  

    if (isset($_GET['fileview'])) {
      $myFile = $_GET['fileview'];
      $fh = fopen($myFile, 'r');
      $theData = fread($fh, filesize($myFile));
      echo "<center>File Contents</center>";
      echo "<font style='font-size:18px;'>".$theData."</font>";
      fclose($fh);
    }

    function make_button($id, $value) {
      echo "<div style='border:4px solid rgba(0,0,0,0);display:inline-block;'><input type='button' class='button_padding' id='".$id."' value='".$value."' onclick='javascript:load_keywords(\"".$id."\")' />&nbsp&nbsp</div>";  
    }

    $kwd_button_ids = array("subjects_btn", "level_btn", "scale_btn", "impl_btn", "region_btn", "theories_btn", "neurons_btn", "keywords_btn");
    $kwd_button_values = array("Subjects", "Detail Level", "Network Scale", "Implementation Level", "Region", "Theories", "Neuron Types", "Keywords");

    echo "<div class='article_details'><form action='#' method='POST'><center><u><span style='font-size:24px;'>Enter Query</span></u><br><br><textarea name='search_query' id='search_query' style='width:600px;height:100px;font-size:18px;'>";
    if (isset($_POST['search_query'])) {
      echo $_POST['search_query'];
    }
    echo"</textarea><br>";
    echo "<div class='wrap-collabsible' id='art_select' style='width:550px;'><input id='instructions' class='toggle' type='checkbox'><label for='instructions' class='lbl-toggle'>Instructions</label><div class='collapsible-content'><div class='content-inner' style='font-size:18px;'>";
    echo "Enter search into text area and seperate search terms with the comma symbol ','. For example: \"grid cells, place cells\".";
    if ($show_snippits == true) {
      echo " Set the max keyterm results dropdown to select the maximum number of results to return per keyword.";
    }
    echo "</div></input></div></div>";
    echo "<div class='wrap-collabsible' id='kwd_select_dropdown' style='width:550px;'><input id='kwd_select' class='toggle' type='checkbox'><label for='kwd_select' class='lbl-toggle'>Load Keywords</label><div class='collapsible-content'><div class='content-inner' style='font-size:18px;'>";
    for ($b_i = 0; $b_i < count($kwd_button_ids); $b_i++) {
      make_button($kwd_button_ids[$b_i], $kwd_button_values[$b_i]);
    }
    echo "</div></input></div></div>";    
    if ($show_snippits == true) {
    echo "<span style='font-size:22px;position:relative;top:4px;font-family:arial;'>Max keyterm text sample results:&nbsp;&nbsp;</span>";
    echo "<select name='max_keyterm_results' style='width:45px;height:30px;font-size:18px;position:relative;top:5px;'>";    
    for ($k_i = 1; $k_i <= 20; $k_i++) {
      echo "<option value='".$k_i."'";
      if (isset($_POST['max_keyterm_results'])) {
        if ($k_i == $_POST['max_keyterm_results']) {
          echo " selected";
        }
      }
      else if ($k_i == 10) {
        echo " selected";
      }
      echo ">".$k_i."</option>";
    }
    echo "</select><br>";
    }
    echo "<span style='font-size:22px;position:relative;top:4px;font-family:arial;'>Number of articles to search:&nbsp;&nbsp;</span>";
    echo "<select name='articles_to_search' style='width:45px;height:30px;font-size:18px;'>";
    $max_art =array("all",10,50,100);
    for ($a_i = 0; $a_i < sizeof($max_art); $a_i++) {
      echo "<option value='".$max_art[$a_i]."'";
      if (isset($_POST['articles_to_search'])) {
        if ($_POST['articles_to_search'] == $max_art[$a_i]) {
          echo " selected";
        }
      }
      else if ($a_i == "all") {
        echo " selected";
      }
      echo ">".$max_art[$a_i]."</option>";
    }
    echo "</select><br><span style='font-size:22px;position:relative;font-family:arial;'>Currently only core collection articles are searchable here.</span>";
    if ($show_snippits == true) {
      echo "&nbsp;&nbsp;<span style='font-size:22px;position:relative;top:4px;font-family:arial;'>Save results to file:&nbsp;&nbsp;</span><select name='save_to_file' style='width:55px;height:30px;font-size:18px;'>";
      echo "<option value='no' ";
      if (isset($_REQUEST['save_to_file']) && $_REQUEST['save_to_file']=='no') {
        echo "selected";
      }
      echo ">no</option>";
      echo "<option value='yes' ";
      if (isset($_REQUEST['save_to_file']) && $_REQUEST['save_to_file']=='yes') {
        echo "selected";
      }
      echo ">yes</option>";    
      echo "</select>";
    }
    echo "</center>";    
    echo "<div class='wrap-collabsible' id='choose_articles' style='width:90%;position:relative;left:5%;'><input id='choose_articles_list' class='toggle' type='checkbox'><label for='choose_articles_list' class='lbl-toggle'>Articles Availible</label><div class='collapsible-content'><div class='content-inner' style='font-size:18px;height:600px;overflow:auto;'>";
    $sql = "SELECT * FROM $cog_database.articles ORDER BY id";
    $result = $cog_conn->query($sql);
    $articles_chosen=array();
    $articles_chosen_ids=array();
    $c_i = 1;
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) {  
        $art_csn=$row["citation"];
        $art_csn_id=$row["id"];
        if ($art_csn!=''){
          array_push($articles_chosen,$art_csn);
          #echo "<input type='checkbox' name='art_csn_".$c_i."' value='art_csn_".$c_i."' id='art_csn_".$c_i."' class='normal_checkbox'>&nbsp&nbsp".$art_csn."<br>";
          echo "#".$c_i."&nbsp&nbspID:".$art_csn_id."&nbsp;&nbsp;".$art_csn."<br>";
        }
        array_push($articles_chosen_ids,$art_csn_id);
        $c_i++;
      }
    }      
    echo "</div></input></div></div>";    
    echo "<center>";
    echo "<label style='font-family:arial;font-size:22px;'>Enter article or range of articles to search (leave<br>this blank to search all articles):</label>&nbsp&nbsp<input type='text' name='range' style='width:100px;height:25px;font-size:18px' value='";
    if (isset($_REQUEST["range"])) {
      echo $_REQUEST["range"];
    }
    echo "' /><br>";
    echo "<input type='submit' value='search' style='font-size:20px;padding:5px;padding-left:20px;padding-right:20px;position:relative;top:6px;'></center></form></div>";

    if (isset($_POST['search_query'])) {
      $search_query = preg_replace('/[\'\"]/', '', $_POST['search_query']);
      $query = preg_split("/,/i", $search_query);/*explode(' AND ', $search_query);*/

      echo "<br><div class='article_details'>
        <center><u>Search Results</u></center>";

      include('search.php'); 

      if (isset($_POST['max_keyterm_results'])) {
        $max_matches = $_POST['max_keyterm_results'];
      }
      else {
        $max_matches = 10;
      }

      if (isset($_POST['articles_to_search'])) {
        $articles_to_search = $_POST['articles_to_search'];
      }
      else {
        $articles_to_search = "all";
      }

      $article_results = search_directory($cog_conn, $dir, $articles_to_search, $max_matches, $query, $_POST['range'], $snippit_size, $art_text_secret_key, $show_snippits, $cog_database);

      echo "</div>";
    }

    ?>
  <br><br><br><br><br>
  </div>
  <?php
    $output_filename = "results_csv/custom_search_results.csv";
    if (isset($_REQUEST["save_to_file"]) && $_REQUEST["save_to_file"]=="yes") {
      $output_file = fopen($output_filename, 'w') or die("Can't open file.");
      // column names
      fwrite($output_file, "file_name");
      for ($i = 0; $i < sizeof($query); $i++) {
        fwrite($output_file, ",".trim($query[$i]));
      }
      fwrite($output_file, "\n");
      // row values
      for ($i = 0; $i < sizeof($article_results[0]); $i++) {
        fwrite($output_file, $article_results[0][$i]);
        for ($j = 0; $j < sizeof($article_results[1][$i]); $j++) {
          fwrite($output_file, ",".$article_results[1][$i][$j]);
        }
        fwrite($output_file, "\n");
      }
      fclose($output_file);
    }
  ?>
</body>
</html>
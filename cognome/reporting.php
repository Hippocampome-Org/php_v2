<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
  <?php $selected_db = $cog_database; ?>
</head>
<body>
  <?php include("function/hc_body.php"); ?> 
  <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <div style="width:80%;position:relative;left:10%;">
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML='<a href=\'reporting.php\' style=\'text-decoration:none\'>General Statistics and Reporting</a>';
    document.getElementById('fix_title').style='width:80%;position:relative;left:10%;';
  </script>
  <!-- end of header -->   

  <center>
  <?php
  /*
  Glossary
  */
  echo "<div class='article_details' style='min-width:500px;'><div class='wrap-collabsible' id='art_select'><input id='collapsible1' class='toggle' type='checkbox'><label for='collapsible1' class='lbl-toggle'>Glossary:</label><div class='collapsible-content'><div class='content-inner' style='height:600px;overflow: auto;'><center><span style='font-size:30px'><u>Glossary</u></span></center><br>";
  
  echo "<center><table>";
  
  include('glossary.php'); 
  echo "<tr></tr></table><br><br></div></input></div></div></div>";   

  $all_dims = $dim_tbl;

  /*
    Report literature statistics
  */
  // only evi adjustments
  function only_evi_adj($temp_tbl, $temp_col) {
    $sql = " AND ($temp_tbl$temp_col <= ".$GLOBALS['art_start_cutoff']." OR $temp_tbl$temp_col = 310 OR $temp_tbl$temp_col = 313 OR $temp_tbl$temp_col = 314 OR $temp_tbl$temp_col = 266 OR $temp_tbl$temp_col = 267 OR $temp_tbl$temp_col = 269 OR $temp_tbl$temp_col = 270 OR $temp_tbl$temp_col = 303 OR $temp_tbl$temp_col = 288 OR $temp_tbl$temp_col = 305);";
    return $sql;
  }

  $only_evi = " WHERE (id <= ".$GLOBALS['art_start_cutoff']." OR id = 310 OR id = 313 OR id = 314 OR id = 266 OR id = 267 OR id = 269 OR id = 270 OR id = 303 OR id = 288 OR id = 305);";
  $temp_tbl = "article_has_subject.";
  $temp_col = "article_id";
  $only_evi_2 = only_evi_adj($temp_tbl, $temp_col);
  $temp_tbl = "";
  $temp_col = "article_id";
  $only_evi_3 = only_evi_adj($temp_tbl, $temp_col);

  $sql = "SELECT COUNT(*) FROM $selected_db.articles";
  $result = $cog_conn->query($sql);
  $article_count = $result->fetch_assoc();
  echo "<br><form name='db_selection' action='#' method='POST'><div class='article_details'>Total number of articles: ".$article_count["COUNT(*)"];
  if (isset($_REQUEST['active_db'])) {
    $active_db = $_REQUEST['active_db'];
  }
  else if (isset($_SESSION['active_db'])) {
    $active_db = $_SESSION['active_db'];
  }
  else {
    $active_db = "core";
  }
  echo "<br><br>Database version to use: <select name='active_db' size='1' style='height:25px;'><option value='core' ";
  if ($active_db == "core") {
    echo "selected";
    $_SESSION['active_db'] = "core"; // note: session already started in access_db.php
  }
  echo ">Core collection</option><option value='extended' ";
  if ($active_db == "extended") {
    echo "selected";
    $_SESSION['active_db'] = "extended";
  }
  echo ">Extended collection</option></select>&nbsp;&nbsp;<input type='submit' value='Update' style='height:25px;width:75px;font-size:14px;' /></div></form>";

  echo "<br><div class='article_details'><center><u>Subjects</u></center><br>";

  echo "<table cellspacing='5px' cellpadding='30px' style='font-size:20px;'><tr><th><u>Subject</u></th><th><u>Articles</u></th><th><u>Theories</u></th><th><u>Keywords</u></th><tr>";

  $sql = "SELECT id, subject FROM $selected_db.subjects";
  $result = $cog_conn->query($sql);
  //$row = $result->fetch_assoc();    
  /*$dim_count = $row["COUNT(*)"];*/
  $subject_ids = array();
  $subject_names = array();
  if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) {   
        array_push($subject_ids, $row["id"]);
        array_push($subject_names, $row["subject"]);
      }
  }   
  
  //for($i=1;$i<$dim_count+1;$i++) {
  $subj_names = array();
  foreach ($subject_ids as $i) {
    $sql = "SELECT subject FROM $selected_db.subjects WHERE id=".$i;
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc();
    //$subj_names[$i]=$row["subject"];
    array_push($subj_names, $row["subject"]);
  }

  function find_subject_annos($i, $selected_db, $cog_conn) {
    $or_state1 = "";
    $or_state2 = "";
    $or_state3 = "";
    $or_name = "";
    $i2 = $i;
    if ($i == "1 also 11" && !(strcmp("$i", "1") == 0)) {
      //echo "i: ".$i."<br>".strcmp("$i", "1");
      $or_state1 = " OR id = 11";
      $or_state2 = " OR subject_id = 11";
      $or_state3 = " OR article_has_subject.subject_id = 11";
      $or_name = " or episodic_memory";
      $i2 = 1;
    }
    $sql = "SELECT subject FROM $selected_db.subjects WHERE (id=".$i2.$or_state1.")";
    $sql2 = "SELECT COUNT(distinct article_has_subject.article_id) FROM $selected_db.article_has_subject WHERE (subject_id=".$i2.$or_state2.")";
    $sql3 = "SELECT COUNT(distinct article_has_subject.article_id) FROM $selected_db.article_has_subject, article_has_theory WHERE (article_has_subject.subject_id=".$i2.$or_state3.") AND article_has_subject.article_id=article_has_theory.article_id";
    $sql4 = "SELECT COUNT(distinct article_has_subject.article_id) FROM $selected_db.article_has_subject, article_has_keyword WHERE (article_has_subject.subject_id=".$i2.$or_state3.") AND article_has_subject.article_id=article_has_keyword.article_id";
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc();
    $result2 = $cog_conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $result3 = $cog_conn->query($sql3);
    $row3 = $result3->fetch_assoc();
    $result4 = $cog_conn->query($sql4);
    $row4 = $result4->fetch_assoc();            
    echo "<tr><td>".$row["subject"].$or_name."</td><td><center>".$row2["COUNT(distinct article_has_subject.article_id)"]."</center></td><td><center>".$row3["COUNT(distinct article_has_subject.article_id)"]."</center></td><td><center>".$row4["COUNT(distinct article_has_subject.article_id)"]."</center></td></tr>";
  }
  echo "<tr><td><center><u>Spatial Navigation or Episodic Memory</u></center></td></tr>";  
  find_subject_annos(1, $selected_db, $cog_conn);
  find_subject_annos(11, $selected_db, $cog_conn);  
  find_subject_annos("1 also 11", $selected_db, $cog_conn); 
  echo "<tr><td><br><center><u>Other Learning and Memory Types</u></center></td></tr>";  
  find_subject_annos(12, $selected_db, $cog_conn);
  find_subject_annos(6, $selected_db, $cog_conn);
  find_subject_annos(14, $selected_db, $cog_conn);
  find_subject_annos(2, $selected_db, $cog_conn);
  find_subject_annos(7, $selected_db, $cog_conn);
  echo "<tr><td><br><center><u>Pattern Completion and Separation</u></center></td></tr>";  
  find_subject_annos(5, $selected_db, $cog_conn);
  echo "<tr><td><br><center><u>Neurological Disorders</u></center></td></tr>";  
  find_subject_annos(15, $selected_db, $cog_conn);
  find_subject_annos(16, $selected_db, $cog_conn);
  find_subject_annos(18, $selected_db, $cog_conn);
  echo "<tr><td><br><center><u>Other Models</u></center></td></tr>";  
  find_subject_annos(3, $selected_db, $cog_conn);
  find_subject_annos(17, $selected_db, $cog_conn);
  echo "</table></div>";

  /*
  Dimensions
  */
  echo "<br><div class='article_details'><center><u>Dimensions</u></center>";

  echo "<table cellspacing='5px' cellpadding='30px' style='font-size:20px;'><tr><th><u>Dimension</u></th><th><u>Annotations</u></th><th><u>Articles</u></th><br>";
  
  $dim_tbl=array(
    1=>"article_has_detail",
    2=>"article_has_implmnt",
    3=>"article_has_theory",
    4=>"article_has_keyword",
    5=>"article_has_region",
    6=>"article_has_scale");

  $sql = "SELECT id FROM $selected_db.dimensions";
  $result = $cog_conn->query($sql);
  $dim_ids = array();
  if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) {   
        array_push($dim_ids, $row["id"]);
      }
  }   
  
  foreach ($dim_ids as $i) {
    $sql = "SELECT dimension FROM $selected_db.dimensions WHERE id=".$i;
    $sql2 = "SELECT COUNT(*) FROM $selected_db.".$dim_tbl[$i];
    $sql3 = "SELECT COUNT(DISTINCT article_id) FROM $selected_db.".$dim_tbl[$i];
    if ($i == 6) {
      $sql2 = "SELECT COUNT(*) FROM $selected_db.".$dim_tbl[$i]." WHERE scale_id != ''";
      $sql3 = "SELECT COUNT(DISTINCT article_id) FROM $selected_db.".$dim_tbl[$i]." WHERE scale_id != ''";
    }    
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) {          
        $result2 = $cog_conn->query($sql2);
        if ($result2->num_rows > 0) {       
          while($row2 = $result2->fetch_assoc()) { 
            $result3 = $cog_conn->query($sql3);
            if ($result3->num_rows > 0) {       
              while($row3 = $result3->fetch_assoc()) {             
                echo "<tr><td>".$row["dimension"]."</td><td><center>".$row2["COUNT(*)"]."</center></td><td><center>".$row3["COUNT(DISTINCT article_id)"]."</center></td><tr>";
              }
            }
          }
        }
      }
    }
  }
  
  echo "</table></div></center>";

  /*
    Report dimension content details

    Note: index i is dimension type, j is dimension property, k is subject
  */

  $wrap_col_numb = 4;
  $dim_id_names=array(
    1=>"detail_id",
    2=>"level_id",
    3=>"theory_id",
    4=>"keyword_id",
    5=>"region_id",
    6=>"scale_id",
    7=>"neuron_id");
  $dim_heading=array(
    1=>"Levels of Detail",
    2=>"Implementation Levels",
    3=>"Theory Categories",
    4=>"Keywords",
    5=>"Anatomical Regions",
    6=>"Network Scales",
    7=>"Neuron Types");

  $art_id_names=array(
    1=>"article_has_detail.article_id",
    2=>"article_has_implmnt.article_id",
    3=>"article_has_theory.article_id",
    4=>"article_has_keyword.article_id",
    5=>"article_has_region.article_id",
    6=>"article_has_scale.article_id",
    7=>"article_has_neuron.article_id");
  echo "</div><div style='max-width:80%;position:relative;left:10%;'>";
  echo "<br><center><div class='article_details'><center><u>Articles with Dimension Values</u></center>";
  echo "<br>Individual counts of a dimension's value annotations are listed.<br>";

  for($i=1;$i<(sizeof($dim_name)+1);$i++) {
    echo "<br><center><font style='font-size:20px;'>".$dim_heading[$i]."</font></center>";
    echo "<table width='500px' class='reporting_table'>";
    //echo "<tr width='150px' style='width:150px;'><th><br><u>".$dim_heading[$i]."</u><br><br></th><th></th></tr>";
    echo "<tr width='150px' style='width:150px;padding:5px;'><th class='reporting_table_head'>Property</th><th class='reporting_table_head' style='padding:5px;'>Count</th>";
    if ($i == 7) {
      echo "<th class='reporting_table_head' style='padding:5px;'>Count (fuzzy)</th><th class='reporting_table_head' style='padding:5px;'>Count (normal + fuzzy)</th>";
    }
    echo "</tr>";

    // total
    $prp_tot = '';
    $sql="SELECT COUNT(*) FROM $selected_db.".$prp_tbl[$i];
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
        while($row = $result->fetch_assoc()) {   
          $prp_tot = $row['COUNT(*)'];
        }
    }
    // total fuzzy
    $prp_totfzy = '';
    $sql="SELECT COUNT(*) FROM $selected_db.article_has_neuronfuzzy";
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
        while($row = $result->fetch_assoc()) {   
          $prp_totfzy = $row['COUNT(*)'];
        }
    }
    $prp_totcomb = ($prp_tot+$prp_totfzy); // normal and fuzzy

    for($j=1;$j<(sizeof($dim_name[$i])+1);$j++) {
      echo "<tr class='reporting_table_head'><td width='75px' style='width:75px;padding:5px;' class='reporting_table_head'>".$dim_name[$i][$j]."</td>";

      $sql_ids = "SELECT id FROM $selected_db.".$all_dims[$i];
      //echo $sql_ids."<br>";
      $result = $cog_conn->query($sql_ids);   
      $dim_col_ids = array();
      if ($result->num_rows > 0) {       
          while($row = $result->fetch_assoc()) {   
            array_push($dim_col_ids, $row["id"]);
            //echo $row["id"]."<br>";
          }
      }

      $sql="SELECT COUNT(*) FROM $selected_db.".$prp_tbl[$i]." WHERE ".$prp_col[$i]."=".$dim_col_ids[$j-1];
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) {       
          while($row = $result->fetch_assoc()) {   
            $prp_cnt = $row['COUNT(*)'];
            $prp_pct = number_format(($prp_cnt/$prp_tot)*100, 2, '.', '');
            echo "<td width='35px' style='width:35px;padding:5px;' class='reporting_table_head'><center><table style='width:75px;font-size:14px;'><tr><td style='border:0px;'>$prp_cnt&nbsp;&nbsp;&nbsp;</td><td style='border:0px;'>&nbsp;&nbsp;&nbsp;($prp_pct%)</td></tr></table></center></td>";
          }
      }
      if ($i == 7) {
        $sql="SELECT COUNT(*) FROM $selected_db.article_has_neuronfuzzy WHERE neuron_id=".$dim_col_ids[$j-1];
        //echo $sql."<br>";
        $result = $cog_conn->query($sql);
        if ($result->num_rows > 0) {       
            while($row = $result->fetch_assoc()) {   
              $prp_cntfzy = $row['COUNT(*)'];
              $prp_pctfzy = number_format(($prp_cntfzy/$prp_totfzy)*100, 2, '.', '');
              //echo "<td>test</td>";
              echo "<td width='35px' style='width:35px;padding:5px;' class='reporting_table_head'><center><table style='width:75px;font-size:14px;'><tr><td style='border:0px;'>$prp_cntfzy&nbsp;&nbsp;&nbsp;</td><td style='border:0px;'>&nbsp;&nbsp;&nbsp;($prp_pctfzy%)</td></tr></table></center></td>";
              $prp_pctcomb = number_format((($prp_cnt+$prp_cntfzy)/$prp_totcomb)*100, 2, '.', '');
              //echo "<td>test</td>";
              echo "<td width='35px' style='width:35px;padding:5px;' class='reporting_table_head'><center><table style='width:75px;font-size:14px;'><tr><td style='border:0px;'>".($prp_cnt+$prp_cntfzy)."&nbsp;&nbsp;&nbsp;</td><td style='border:0px;'>&nbsp;&nbsp;&nbsp;($prp_pctcomb%)</td></tr></table></center></td>";
            }
        }
      }
      echo "</tr>";
    }    
    echo "<tr width='150px' style='width:150px;' class='reporting_table_head'><td class='reporting_table_head' style='padding:5px;'>All</td><td width='75px' style='width:75px;padding:5px;' class='reporting_table_head'><center>$prp_tot</center></td>";
    if ($i == 7) {
      echo "<td width='75px' style='width:75px;padding:5px;' class='reporting_table_head'><center>$prp_totfzy</center></td><td width='75px' style='width:75px;padding:5px;' class='reporting_table_head'><center>".$prp_totcomb."</center></td>";
    }
    echo "</tr></table>";
  }
  /*
    Neuron types by subregion
  */
  $subregions = array("Dentate Gyrus", "Cornu Ammonis 1", "Cornu Ammonis 2", "Cornu Ammonis 3", "Subiculum", "Entorhinal Cortex LI", "Entorhinal Cortex LII", "Entorhinal Cortex LIII", "Entorhinal Cortex LIV", "Entorhinal Cortex LV", "Entorhinal Cortex LVI");
  $sub_range_min = array(1, 19, 44, 49, 89, 92, 94, 98, 107, 109, 114);
  $sub_range_max = array(18, 43, 48, 88, 91, 93, 97, 106, 108, 113, 114);
  $or_cond = "";

  echo "<br><font style='font-size:20px;'>Neuron Types by Subregion</font><table width='500px' class='reporting_table'>";
  echo "<tr width='150px' style='width:150px;padding:5px;'><th class='reporting_table_head'>Subregion</th><th class='reporting_table_head' style='padding:5px;'>Count (normal + fuzzy)</th></tr>";

  for ($i = 0; $i < count($subregions); $i++) {
    if ($i == 6) {
      // EC LII
      $or_cond = " OR neuron_id=115 OR neuron_id=116 OR neuron_id=117";
    }
    if ($i == 6) {
      // EC LIII
      $or_cond = " OR neuron_id=118 OR neuron_id=119 OR neuron_id=120 OR neuron_id=121 OR neuron_id=122";
    }

    $sql="SELECT COUNT(*) FROM $selected_db.article_has_neuron WHERE (neuron_id>=".$sub_range_min[$i]." AND neuron_id<=".$sub_range_max[$i].")".$or_cond;
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) {   
        $subreg_cnt = $row['COUNT(*)'];
      }
    }
    $sql="SELECT COUNT(*) FROM $selected_db.article_has_neuronfuzzy WHERE neuron_id>=".$sub_range_min[$i]." AND neuron_id<=".$sub_range_max[$i];
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) {   
        $subreg_cntfzy = $row['COUNT(*)'];
      }
    }

    $sub_pctcomb = number_format((($subreg_cnt+$subreg_cntfzy)/$prp_totcomb)*100, 2, '.', '');

    echo "<tr width='150px' style='width:150px;padding:5px;'><td class='reporting_table_head'><center>".$subregions[$i]."</center></td><td class='reporting_table_head' style='padding:5px;'><center><table style='width:100px;font-size:14px;'><tr><td style='border:0px;width:50px;font-size:17px;'>".($subreg_cnt+$subreg_cntfzy)."</td><td style='border:0px;width:50px;font-size:17px;'>(".$sub_pctcomb."%)</td></tr></table></center></td></tr>";
  }

  echo "</table>";
  echo "</div></center>";    

  /*
    Section reporting dimension values on a per subject basis.
  */

  echo "</div><div style='min-width:1700px;position:relative;left:10%;'>";
  echo "<br><center><div class='article_details'><center><u>Articles with Dimension Values</u></center>";
  echo "<br>Individual counts of a dimensions value annotations given a subject are listed. Each entry in the matrices<br>below contains the count value on the left and percentage within its group on the right. These values are<br>different than the ones above that are not grouped by subject because each article can have multiple<br>subject annotations.<br>"; 

  echo "<br><table width='400px' class='reporting_table'>";
  for($i=1;$i<(sizeof($dim_name)+1);$i++) {
  //foreach ($dim_ids as $i) {    
  //foreach ($dim_tbl as $i) {    
    echo "<tr width='300px' style='width:500px;'><th class='reporting_table_head'><br><u>".$dim_heading[$i]."</u><br><br>";
    echo "</th></tr>";
    echo "<tr width='300px' style='width:500px;' class='reporting_table_head'><th class='reporting_table_head'><u>Subject</u>";

    /*$sql = "SELECT id FROM $selected_db.subjects"; //.$dim_name[$i];
    echo $sql;
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc();
    $dim_ids = array();
    if ($result->num_rows > 0) {       
        while($row = $result->fetch_assoc()) {   
          array_push($dim_ids, $row["id"]);
        }
    }

    foreach ($dim_ids as $j) {*/
      //echo "dim id: ".$j;
    for($j=1;$j<(sizeof($dim_name[$i])+1);$j++) {
      echo "<th width='50px' style='word-wrap:break-word' class='reporting_table_head'><u>".$dim_name[$i][$j]."</u></th>";
    }    
    disp_dim_arts($dim_name, $subj_names, $i, $j, "article_has_subject", $dim_tbl, "subject_id", $dim_id_names, "article_has_subject.article_id", $art_id_names, $cog_conn, $selected_db, $dim_ids, $all_dims, $subject_ids);
    echo "</th></tr>"; 
  }
  echo "</table>";  

  function disp_dim_arts($dim_name, $subj_names, $i, $j, $subj_tbl, $dim_tbl, $subj_id_name, $dim_id_names, $subj_art_id, $art_id_names, $cog_conn, $selected_db, $dim_ids, $all_dims, $subject_ids) {

    $sql_ids = "SELECT id FROM $selected_db.".$all_dims[$i];
    //echo $sql_ids."<br>";
    $result = $cog_conn->query($sql_ids);   
    $dim_col_ids = array();
    if ($result->num_rows > 0) {       
        while($row = $result->fetch_assoc()) {   
          array_push($dim_col_ids, $row["id"]);
          //echo $row["id"]."<br>";
        }
    }

    for($k=0;$k<sizeof($subj_names);$k++) {
      echo "<tr width='300px' style='width:500px;'>";
      echo "<td width='50px' style='word-wrap:break-word' class='reporting_table_body'>".$subj_names[$k]."</td>";

      for($j=1;$j<(sizeof($dim_name[$i])+1);$j++) {
      //foreach ($dim_ids as $j) {
        $table1 = $subj_tbl;
        $table2 = $dim_tbl[$i];
        $id_name_1 = $subj_id_name;
        $id_name_2 = $dim_id_names[$i];
        $id_val_1 = $subject_ids[$k]; //$k+1;
        $id_val_2 = $dim_col_ids[$j - 1]; //$j+1;
        $art1 = $subj_art_id;
        $art2 = $art_id_names[$i];

        dim_art_num($dim_name, $table1, $table2, $id_name_1, $id_name_2, $id_val_1, $id_val_2, $art1, $art2, $cog_conn, false, $selected_db);
      }
      echo "</tr>";      
    }   
    /* display totals for all subjects */
    echo "<tr width='300px' style='width:500px;'>";
    echo "<td width='50px' style='word-wrap:break-word' class='reporting_table_head'>all</td>";
    for($j=1;$j<(sizeof($dim_name[$i])+1);$j++) {
    //foreach ($dim_ids as $j) {
      $table1 = $subj_tbl;
      $table2 = $dim_tbl[$i];
      $id_name_1 = $subj_id_name;
      $id_name_2 = $dim_id_names[$i];
      $id_val_1 = $subject_ids[$k]; //$k+1;
      $id_val_2 = $dim_col_ids[$j - 1]; //$j+1;
      $art1 = $subj_art_id;
      $art2 = $art_id_names[$i];
      dim_art_num($dim_name, $table1, $table2, $id_name_1, $id_name_2, $id_val_1, $id_val_2, $art1, $art2, $cog_conn, true, $selected_db);
    }
    echo "</tr>";
  }

  function dim_art_num($dim_name, $table1, $table2, $id_name_1, $id_name_2, $id_val_1, $id_val_2, $art1, $art2, $cog_conn, $all_toggle, $selected_db) {
    /*
      Number of articles given a subject and dimension value

      Example query: SELECT DISTINCT COUNT(*) FROM $selected_db.article_has_detail, article_has_subject WHERE detail_id = 3 AND subject_id = 2 AND article_has_detail.article_id = article_has_subject.article_id;
    */

    if ($all_toggle==false) {
      echo "<td width='50px' style='word-wrap:break-word' class='reporting_table_body'><center>";
      //$sql = "SELECT DISTINCT COUNT(*) FROM $selected_db.".$table1.", $selected_db.".$table2." WHERE ".$id_name_1." = ".$id_val_1." AND ".$id_name_2." = ".$id_val_2." AND ".$art1." = ".$art2;
      $sql = "SELECT DISTINCT b.$id_name_2, b.article_id FROM $selected_db.".$table1." as a, $selected_db.".$table2." as b WHERE ".$id_name_1." = ".$id_val_1." AND ".$id_name_2." = ".$id_val_2." AND a.article_id = b.article_id";
      //echo $sql."<br>";
    }
    else {
      echo "<td width='50px' style='word-wrap:break-word' class='reporting_table_head'><center>";
      //$sql = "SELECT DISTINCT COUNT(".$id_name_2.") FROM $selected_db.".$table1.", $selected_db.".$table2." WHERE ".$id_name_2." = ".$id_val_2." AND ".$art1." = ".$art2;
      $sql = "SELECT DISTINCT COUNT(".$id_name_2.") FROM $selected_db.".$table1.", $selected_db.".$table2." WHERE ".$id_name_2." = ".$id_val_2." AND ".$art1." = ".$art2;
      //$sql = "SELECT DISTINCT COUNT(".$id_name_2.") FROM $selected_db.".$table2." WHERE ".$id_name_2." = ".$id_val_2;
      //echo $sql."<br>";
    }
    $result = $cog_conn->query($sql);
    if ($all_toggle==false) {
      $val_ctr = 0;
      if ($result->num_rows > 0) {       
          while($row = $result->fetch_assoc()) {   
            $val_ctr = $val_ctr + 1;
          }
      }   
      $dim_val = $val_ctr; //$row["COUNT(*)"];
      $sql = "SELECT DISTINCT COUNT(".$id_name_2.") FROM $selected_db.".$table1.", $selected_db.".$table2." WHERE ".$id_name_2." = ".$id_val_2." AND ".$art1." = ".$art2;
      $result = $cog_conn->query($sql);
      $row2 = $result->fetch_assoc();
      $dim_val_total = $row2["COUNT(".$id_name_2.")"];
      /* avoid division by zero */
      if ($dim_val_total > 0) {
        $percent = round($dim_val/$dim_val_total, 3)*100;
      }
      else {
        $percent = 0;
      }
      echo "<div style='position:relative;width:100px;font-size:17px;'><span style='float:left'>".$dim_val."</span><span style='float:right'>".$percent."%</span></div>";
    }
    else {
      $row = $result->fetch_assoc();
      $dim_val_total = $row["COUNT(".$id_name_2.")"];
      $sql = "SELECT DISTINCT COUNT(".$id_name_2.") FROM $selected_db.".$table1.", $selected_db.".$table2." WHERE ".$art1." = ".$art2;
      //echo $sql;
      $result = $cog_conn->query($sql);
      $row2 = $result->fetch_assoc();
      $all_dim_val = $row2["COUNT(".$id_name_2.")"];
      /* avoid division by zero */
      if ($all_dim_val > 0) {
        $percent = round($dim_val_total/$all_dim_val, 3)*100;
      }
      else {
        $percent = 0;
      }
      echo $dim_val_total." (".$percent."% of all)";
    }
    echo "</center></td>";      
  }

  echo "</div>";  

  $cog_conn->close();

  ?></center></table>
</div></div><br>
</body>
</html>

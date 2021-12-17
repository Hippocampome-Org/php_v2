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
      document.getElementById('header_title').innerHTML="<a href='browse.php' style='text-decoration: none;color:black !important'><span class='title_section'>Browse Full Article Entries</span></a>";
      document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
    </script>
    <!-- end of header -->

    <?php
    //include('mysql_connect.php');  

    /*
      Search by Author
    */
    $letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N',
      'O','P','Q','R','S','T','U','V','W','X','Y','Z');

    function alink($first_letter) {
      echo "<a href='author_search.php?letter=".$first_letter."'>".$first_letter."</a>&nbsp";
    }   

    echo "<div class='wrap-collabsible' id='art_select'><input id='collapsible_auth_srch' class='toggle' type='checkbox' checked><label for='collapsible_auth_srch' class='lbl-toggle'>Search by Author:</label><div class='collapsible-content'><div class='content-inner' style='font-size:22px;'><p><table border=1><center>";
    
    foreach ($letters as $auth_letter) {
      alink($auth_letter);
    }

    echo "</center></table></p></div><a style='font-size:10px'><hr></a></div></div><br>";

  /*
    Check for prior collected article details
  */
    $expand_art_list='checked';
    $show_art_prop='display:none';
    if (isset($_GET['art_id'])) {
      $art_mod_id = $_GET['art_id'];
      //list($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id) = getArtDetails($art_mod_id,$servername,$username,$password,$dbname);
      list($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id) = getArtDetails($art_mod_id, $cog_conn, $cog_database);
      list($sub_evid_loc, $sub_evid_des, $det_evid_loc, $det_evid_des, $scl_evid_loc, $scl_evid_des, $impl_evid_loc, $impl_evid_des, $rgn_evid_loc, $rgn_evid_des, $thy_evid_loc, $thy_evid_des, $nrn_evid_loc, $nrn_evid_des, $kwd_evid_loc, $kwd_evid_des) = getResProperties($art_mod_id, $cog_conn, $cog_database);
      $expand_art_list='';
      $show_art_prop='display:visible';
    }  

    //function getArtDetails($art_mod_id,$servername,$username,$password,$dbname) {
    function getArtDetails($art_mod_id, $cog_conn, $cog_database) {
      // Create connection
      //$cog_conn = new mysqli($servername, $username, $password, $dbname);    
      // Check connection
      //if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); echo 'connection failed';}  

      $sql = "SELECT * FROM ".$cog_database.".articles WHERE ID=".$art_mod_id.";";
      $result = $cog_conn->query($sql);
      $row = $result->fetch_assoc();
      $title=$row["title"];
      $year=$row["year"];
      $journal=$row["journal"];
      $citation=$row["citation"];
      $url=$row["url"];
      $abstract=$row["abstract"];
      $theory=$row["theory"];
      $mod_meth=$row["modeling_methods"];
      $cur_notes=$row["curation_notes"];
      $inc_qual=$row["inclusion_qualification"];
      $authors=$row["authors"];
      $art_off_id=$row["official_id"];

      //$cog_conn->close();

      return array($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id);
    }

    function getResPropRow($cog_conn, $tbl, $art_mod_id, $cog_database) {
      $sql = "SELECT ".$tbl.".evidence_position AS position, ".$tbl.".evidence_description AS description FROM $cog_database.".$tbl." WHERE ".$tbl.".article_id=".$art_mod_id.";";
      //echo "query: ".$sql;
      $result = $cog_conn->query($sql);
      $row = $result->fetch_assoc();

      return $row;
    }

    function getResProperties($art_mod_id, $cog_conn, $cog_database) { 

      $no_an = 'No annotation recorded yet';
      $row = getResPropRow($cog_conn, "evidence_of_subjects", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $sub_evid_loc=$row["position"];}
      else {$sub_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $sub_evid_des=$row["description"];}
      else {$sub_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_details", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $det_evid_loc=$row["position"];}
      else {$det_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $det_evid_des=$row["description"];}
      else {$det_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_scales", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $scl_evid_loc=$row["position"];}
      else {$scl_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $scl_evid_des=$row["description"];}
      else {$scl_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_implmnts", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $impl_evid_loc=$row["position"];}
      else {$impl_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $impl_evid_des=$row["description"];}
      else {$impl_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_regions", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $rgn_evid_loc=$row["position"];}
      else {$rgn_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $rgn_evid_des=$row["description"];}
      else {$rgn_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_theories", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $thy_evid_loc=$row["position"];}
      else {$thy_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $thy_evid_des=$row["description"];}
      else {$thy_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_keywords", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $kwd_evid_loc=$row["position"];}
      else {$kwd_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $kwd_evid_des=$row["description"];}
      else {$kwd_evid_des=$no_an;}
      $row = getResPropRow($cog_conn, "evidence_of_neurons", $art_mod_id, $cog_database);
      if ($row["position"]!='') {
      $nrn_evid_loc=$row["position"];}
      else {$nrn_evid_loc=$no_an;}
      if ($row["description"]!='') {
      $nrn_evid_des=$row["description"];}
      else {$nrn_evid_des=$no_an;}      
      
      return array($sub_evid_loc, $sub_evid_des, $det_evid_loc, $det_evid_des, $scl_evid_loc, $scl_evid_des, $impl_evid_loc, $impl_evid_des, $rgn_evid_loc, $rgn_evid_des, $thy_evid_loc, $thy_evid_des, $nrn_evid_loc, $nrn_evid_des, $kwd_evid_loc, $kwd_evid_des);
    }      

  // articles list
    $sql = "SELECT * FROM ".$cog_database.".articles ORDER BY ID DESC;";
    $result = $cog_conn->query($sql);
    $articles_group=array();
    $articles_ids_group=array();
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) {  
        $art_mod=$row["citation"];
        if ($art_mod!=''){
          array_push($articles_group,$art_mod);           
        }
        array_push($articles_ids_group,$row["id"]);
      }
    }  
    echo "</form>";

    $i=1;
    echo "<div class='wrap-collabsible' id='art_select'><input id='collapsible".$i."' class='toggle' type='checkbox' ".$expand_art_list."><label for='collapsible".$i."' class='lbl-toggle'>Article to View:</label><div class='collapsible-content'><div class='content-inner' style='height: 600px;overflow: auto;'><p><table border=1>";
    for ($i=0;$i<sizeof($articles_group);$i++) {
      echo "<tr><td><a href='?art_id=".$articles_ids_group[$i]."' style='text-decoration: none;'>".$articles_group[$i]."</a></td></tr>";
    }
    echo "</table></p></div><a style='font-size:10px'><hr></a></div></div>"; 
    //$cog_conn->close();

  /*
    Article details section
  */
  // Create connection
    //$cog_conn = new mysqli($servername, $username, $password, $dbname);    
  // Check connection
    //if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); } 

  $det_lbl_wth='200px'; //article details label width
  echo "<br><div class='article_details' style='".$show_art_prop."'>
  <center><u>Article Details</u></center>
  <br><table style='min-width:100%;'>
  <tr><td style='min-width:".$det_lbl_wth.";'>Title:</td><td class='browse_table'><label name='title' style='min-width:100%;min-height:50px;font-size:22px;'>".$title."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Article Official ID:</td><td class='browse_table'><label name='art_off_id' style='min-width:400px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$art_off_id."</label></td></tr>  
  <tr><td style='min-width:".$det_lbl_wth.";'>Year:</td><td class='browse_table'><label name='year' style='max-width:70px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$year."</label></td></tr>  
  <tr><td style='min-width:".$det_lbl_wth.";'>Journal:</td><td class='browse_table'><label name='journal' style='min-width:100%;min-height:25px;font-size:22px;'>".$journal."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Citation:</td><td class='browse_table'><label name='citation' style='min-width:100%;min-height:125px;font-size:22px;'>".$citation."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Url:</td><td class='browse_table'><label name='url' style='min-width:100%;min-height:25px;font-size:22px;' id='url'><a href='".$url."'>".$url."</a></label></td></tr> 
  <tr><td style='min-width:".$det_lbl_wth.";'>Authors:</td><td class='browse_table'><label name='authors' style='min-width:100%;min-height:25px;font-size:22px;' id='url'>".$authors."</label></td></tr> 
  <tr><td style='min-width:".$det_lbl_wth.";'>Abstract:</td><td class='browse_table'><label name='abstract' style='min-width:100%;min-height:200px;font-size:22px;'>".$abstract."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Theory Notes:</td><td class='browse_table'><label name='theory' style='min-width:100%;min-height:50px;font-size:22px;'>".$theory."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Modeling Methods:</td><td class='browse_table'><label name='modeling_methods' style='min-width:100%;min-height:50px;font-size:22px;'>".$mod_meth."</label></td></tr>  
  <tr><td style='min-width:".$det_lbl_wth.";'>Citation Notes:</td><td class='browse_table'><label name='curation_notes' style='min-width:100%;min-height:50px;font-size:22px;'>".$cur_notes."</label></td></tr>
  <tr><td style='min-width:".$det_lbl_wth.";'>Inclusion Qualification:</td><td class='browse_table'><label name='inclusion_qualification' style='min-width:100%;min-height:50px;font-size:22px;'>".$inc_qual."</label></td></tr>  
  </table>
  </div>";  

  /*
    Article research properties
  */
  // Check for existing property data
  $sel_sbj=array(); // subjects
  $sel_det=array(); // level of detail
  $sel_ipl=array(); // implementation level
  $sel_thy=array(); // theories
  $sel_kwd=array(); // keywords   

  function chk_prop($sql, $cog_conn, $tbl) {
    /*
      Collect array of existing article properties
    */
      $matches=array();
      //echo "sql:: ".$sql;
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          array_push($matches,$row[$tbl]);
          //echo "match:: ".$row[$tbl];
        }
      }    
      return $matches;
    }

  function chk_prop_name($sql, $cog_conn, $tbl) {
    /*
      Collect name of article property
    */
      $match='';
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $match=$row[$tbl];
        }
      }    
      return $match;
    }    

    function properties_included($prop_descript,$select_size,$col_descript,$tbl_descript,$sel_list,$cog_conn,$multi,$sel_name,$non_sel_name,$cog_database) {
      /*
        Report properties that are selected
      */
        //echo "sizeof($sel_list)::".sizeof($sel_list);
        //echo "<br>"."SELECT ".$col_descript." FROM ".$cog_database.".".$tbl_descript." WHERE id=".$prop_id;
      if ($multi != 'multiple') {
        $non_sel_size=1;
      }
      else {
        $non_sel_size=5;        
      }

      echo "<tr><td style='max-width:3%;'>".$prop_descript.":</td><td  class='browse_table_2'><span class='browse_table_title'>".$sel_name.":</span><br>
      <select name='selections[]' size='".$select_size."' ".$multi." class='select-css' style='min-width:400px;'>"; 
      for ($si=0;$si<sizeof($sel_list);$si++) {
        $prop_id=$sel_list[$si];
        $sql="SELECT ".$col_descript." FROM ".$cog_database.".".$tbl_descript." WHERE id=".$prop_id;
        //echo "sql::: ".$sql;
        $prop_name=chk_prop_name($sql, $cog_conn, $col_descript);
        echo "<option value=".$prop_name.">".$prop_name."</option>";
      }
      echo "</select><br><span class='browse_table_title'>";
      echo $non_sel_name.":</span><br><select name='subjects[]' size='".$non_sel_size."' $multi class='select-css' style='min-width:400px;'>";
      $sql = "SELECT ".$col_descript." FROM ".$tbl_descript;
      $result = $cog_conn->query($sql);
      $i=0;
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $i=$i+1;
          if (!in_array($i,$sel_list)) {
            echo "<option value=".$i.">".$row[$col_descript]."</option>";
          }     
        }
      }  
      echo "</select>&nbsp";
      echo "</td></tr>";  
    }       

    function show_evidence($id, $desc, $e_loc, $e_des) {
      $table = "<table style='min-width:100%;'><tr><td style='min-width:200px;'>Location:&nbsp;&nbsp;&nbsp;&nbsp;</td><td class='browse_table'><label name='title' style='min-width:100%;min-height:50px;font-size:22px;'>".$e_loc."</label></td></tr><tr><td style='min-width:200px;'>Description:</td><td class='browse_table'><label name='title' style='min-width:100%;min-height:50px;font-size:22px;'>".str_replace("\n", "<br>", $e_des)."</label></td></tr></table>";
      echo "<tr><td></td><td class='browse_table_2'><div class='wrap-collabsible' id='evid_collap_".$id."'><input id='evid_".$id."' class='toggle' type='checkbox'><label for='evid_".$id."' class='lbl-toggle'>Evidence of ".$desc."</label><div class='collapsible-content'><div class='content-inner' style='font-size:22px;'>".$table."</div></div></input></div></td></tr>";      
    }

    /* 
      Collect and display existing article properties 
    */
    $tbl=$cog_database.".";    
    if ($art_mod_id!='') {
      $col="subject_id";
      $sql="SELECT ".$col." FROM ".$tbl."article_has_subject WHERE article_id=".$art_mod_id;
      $sel_sbj=chk_prop($sql, $cog_conn, $col);
      //
      $col="detail_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_detail WHERE article_id=".$art_mod_id;
      $sel_det=chk_prop($sql, $cog_conn, $col);
      //
      $col="level_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_implmnt WHERE article_id=".$art_mod_id;
      $sel_ipl=chk_prop($sql, $cog_conn, $col);   
      //
      $col="theory_id";      
      $sql="SELECT ".$col." FROM ".$tbl."article_has_theory WHERE article_id=".$art_mod_id;
      $sel_thy=chk_prop($sql, $cog_conn, $col);
      //
      $col="keyword_id";      
      $sql="SELECT ".$col." FROM ".$tbl."article_has_keyword WHERE article_id=".$art_mod_id;
      $sel_kwd=chk_prop($sql, $cog_conn, $col); 
      //
      $col="scale_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_scale WHERE article_id=".$art_mod_id;
      $sel_scl=chk_prop($sql, $cog_conn, $col);  
      //
      $col="neuron_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_neuron WHERE article_id=".$art_mod_id;
      $sel_nrn=chk_prop($sql, $cog_conn, $col);      
      //
      $col="neuron_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_neuronfuzzy WHERE article_id=".$art_mod_id;
      $sel_nrn_fzy=chk_prop($sql, $cog_conn, $col); 
      //
      $col="region_id";    
      $sql="SELECT ".$col." FROM ".$tbl."article_has_region WHERE article_id=".$art_mod_id;
      $sel_rgn=chk_prop($sql, $cog_conn, $col);                 
    }

    echo "<br><div class='article_details' style='".$show_art_prop."'>
    <center><u>Article Research Properties</u><br><br><table style='min-width:100%'>";
    properties_included('Subjects',3,'subject','subjects',$sel_sbj,$cog_conn,'multiple','Subjects Annotated','Subjects Not Annotated',$cog_database); 
    show_evidence("sub", "Subjects", $sub_evid_loc, $sub_evid_des);
    properties_included('Level of Detail',1,'detail_level','details',$sel_det,$cog_conn,'single','Minimum Level of Detail Annotated','Other Levels of Detail',$cog_database);
    show_evidence("det", "Level of Detail", $det_evid_loc, $det_evid_des); 
    properties_included('Simulation Scale',1,'scale','network_scales',$sel_scl,$cog_conn,'single','Simulation Scale Annotated','Other Simulation Scales',$cog_database);
    show_evidence("scl", "Simulation Scale", $scl_evid_loc, $scl_evid_des);
    properties_included('Implementation Level',1,'level','implementations',$sel_ipl,$cog_conn,'single','Minimum Implementation Level Annotated','Other Implementation Levels',$cog_database); 
    show_evidence("impl", "Implementation Level", $impl_evid_loc, $impl_evid_des);
    properties_included('Anatomical Region',3,'region','regions',$sel_rgn,$cog_conn,'multiple','Anatomical Regions Annotated','Other Anatomical Regions',$cog_database); 
    show_evidence("rgn", "Anatomical Region", $rgn_evid_loc, $rgn_evid_des);   
    properties_included('Theories or Network<br>Algorithms',3,'category','theory_category',$sel_thy,$cog_conn,'multiple','Theories or Network Algorithms Annotated','Theories or Network Algorithms Not Annotated',$cog_database);    
    show_evidence("thy", "Theories and Computational<br>Network Models", $thy_evid_loc, $thy_evid_des);
    properties_included('Neuron Types',3,'neuron','neuron_types',$sel_nrn,$cog_conn,'multiple','Neuron Types Annotated','Neuron Types Not Annotated',$cog_database);   
    properties_included('Fuzzy Neuron Types',3,'neuron','neuron_types',$sel_nrn_fzy,$cog_conn,'multiple','Fuzzy Neuron Types Annotated','Fuzzy Neuron Types Not Annotated',$cog_database);  
    show_evidence("nrn", "Neuron Types (Normal and Fuzzy)", $nrn_evid_loc, $nrn_evid_des);    
    properties_included('Keywords',3,'keyword','keywords',$sel_kwd,$cog_conn,'multiple','Keywords Annotated','Keywords Not Annotated',$cog_database);
    show_evidence("kwd", "Keywords", $kwd_evid_loc, $kwd_evid_des);
    echo "</table></div><br>";

    $cog_conn->close();  

    ?></div></div><br>
  </div>
</body>
</html>
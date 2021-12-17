<?php include ("../permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
    https://ctrlq.org/code/19233-submit-forms-with-javascript
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <?php include('set_theme.php'); ?>
  <?php include('../function/hc_header.php'); ?>
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
  <?php include("../function/hc_body.php"); ?>
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <div style="width:90%;position:relative;left:5%;">
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='mod_art.php' style='text-decoration: none;color:black !important'><span class='title_section'>Update Articles Database</span></a>";
    document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
  </script>
  <!-- end of header -->
  
  <?php
  //include('mysql_connect.php');  

  // add/modify/del options presented
  echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><form action='art_sub.php' method='POST'>Articles:&nbsp&nbsp<input type='button' value='  Add  ' onclick='toggleListDown()' style='height:30px;font-size:22px;position:relative;top:-2px;'>&nbsp&nbsp</input><input type='button' value='  Modify  ' onclick='toggleListUp()' style='height:30px;font-size:22px;position:relative;top:-2px;'></input>";
  $sql = "SELECT * FROM $cog_database.articles ORDER BY ID DESC;";
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
  rem_art_button('Article',$articles_group);
  echo "</form>";

  $i=1;
  echo "<div class='wrap-collabsible' id='mod_art_select' style='display:none;'><input id='collapsible".$i."' class='toggle' type='checkbox' checked><label for='collapsible".$i."' class='lbl-toggle'>Article to Modify:</label><div class='collapsible-content'><div class='content-inner' style='height: 600px;overflow: auto;'><p><table border=1>";
  for ($i=0;$i<sizeof($articles_group);$i++) {
    echo "<tr><td><a href='?art_mod_id=".$articles_ids_group[$i]."' style='text-decoration: none;'>".$articles_group[$i]."</a></td></tr>";
  }
  echo "</table></p></div><a style='font-size:10px'><hr></a></div></div></div>"; 

  function rem_art_button($property,$property_group) {
    echo "&nbsp&nbsp<input type='button' value='  Remove  ' onclick='javascript:toggle_vis(\"remove_".$property."\")' style='height:30px;font-size:22px;position:relative;top:-2px;'>
    <span style='display:none;' id='remove_".$property."'><font style='font-size:.9em;'>Remove ".$property.":</font><br><select name='remove_".$property."' size='1' class='select-css' style='min-width:400px;max-width:70%;position:relative;top:-7px;'>";
    echo "<option value='' ></option>";
    for ($i=0;$i<count($property_group);$i++) {
      echo "<option value='".$property_group[$i]."' >".substr($property_group[$i],0,110)."</option>";
    }
    echo "</select>&nbsp&nbsp&nbsp<input type='submit' value='  Remove  ' style='height:28px;font-size:20px;position:relative;top:-7px;'></input></span>";
  }

  echo "<script type='text/javascript'>
  function toggleListUp() {
    var mod_arts = document.getElementById('mod_art_select');
    var displaySetting = mod_arts.style.display;
    mod_arts.style.display = 'block';
  }
  function toggleListDown() {
    var mod_arts = document.getElementById('mod_art_select');
    var displaySetting = mod_arts.style.display;
    mod_arts.style.display = 'none';
    window.location.replace('mod_art.php');
  }
  </script>";
  //$cog_conn->close();

  /*
    Check for prior collected article details
  */
  $art_mod_id = "";
  if (isset($_GET['art_mod_id'])) {
    $art_mod_id = $_GET['art_mod_id'];
    list($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id) = setArtDetails($art_mod_id,$cog_conn,$cog_database);
  }

  function setArtDetails($art_mod_id,$cog_conn,$cog_database) {
      // Create connection
    //$cog_conn = new mysqli($servername, $username, $password, $dbname);    
      // Check connection
    //if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); echo 'connection failed';}  

    $sql = "SELECT * FROM $cog_database.articles WHERE ID=".$art_mod_id.";";
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

  /*
    Import from pubmed
  */
  // Create connection
  //$cog_conn = new mysqli($servername, $username, $password, $dbname);    
  // Check connection
  //if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); }  

  echo "<br><div class='article_details'><center>
  <form action='#' method='POST'>
  Import from pubmed id:&nbsp;<textarea name='pubmed_id' style='max-width:200px;max-height:25px;font-size:22px;overflow:hidden;resize:none;position:relative;top:5px;'>";
  if (isset($_POST['pubmed_id'])) {echo $_POST['pubmed_id'];}
    echo "</textarea>&nbsp;&nbsp;<button style='min-width:75px;min-height:25px;position:relative;top:-2px;font-size:22px;'>Import</button>&nbsp;&nbsp;&nbsp;&nbsp;E.g. 27870120</form><br>
  <form action='art_sub.php' method='POST' target='iframe-form'>
  <span style='font-size:1em;'>Submit the Article to the Database: <input type='submit' value='  Submit  ' style='height:30px;font-size:22px;position:relative;top:-2px;'></input></span>
  <br><br>Submission Status:<iframe style='display:block;height:250px;width:600px;border-top:1px solid rgb(190,190,190);border-left:1px solid rgb(190,190,190);' name='iframe-form' scrolling='auto' src='no_sub.php'></iframe>";
  echo "</center></div><br><div class='article_details'>";
  if (isset($_POST['pubmed_id'])) {
    $pubmed_id=$_POST['pubmed_id'];
    $pubmed_html=file_get_contents('https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&id='.$pubmed_id.'retmode=json&rettype=abstract');
  }

  /* populate article data */
  // title
  if (isset($title) && $title=='') {
    $pattern='~.*ArticleTitle\>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $title = $match[1];
    }
  }
  // year
  if (isset($year) && $year=='') {
    $pattern='~.*PubDate\W+Year\>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $year = $match[1];
    }
  }
  // journal
  if (isset($journal) && $journal=='') {
    $pattern='~.*JournalIssue\W+Title>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $journal = $match[1];
    }
  }
  // citation data
  // authors
  if (isset($authors) && $authors=='') {
    $authors='';
    $lastname_pattern='~.*LastName>(.+)\<.*~';
    $firstinitials_pattern='~.*Initials>(.+)\<.*~';
    if ($pubmed_html != '') {
      $lastname_result = preg_match_all($lastname_pattern, $pubmed_html, $match_1,PREG_PATTERN_ORDER);
      $firstinitials_result = preg_match_all($firstinitials_pattern, $pubmed_html, $match_2,PREG_PATTERN_ORDER);
      for( $i = 0; $i<sizeof($match_1[0]); $i++ ) {
        $authors=$authors.$match_1[1][$i].', '.$match_2[1][$i].'., ';
      }
    }
  }
  // volume
  if (isset($volume) && $volume=='') {
    $pattern='~.*JournalIssue\W+Volume>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $volume = $match[1];  
    }
  }
  // issue
  if (isset($issue) && $issue=='') {  
    $pattern='~.*JournalIssue\W+Issue>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $issue = $match[1];   
    }
  }
  // pages
  if (isset($pages) && $pages=='') {  
    $pattern='~.*Pagination\W+MedlinePgn>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $pages = $match[1]; 
    }
  }
  // combine for citation 
  if (isset($citation) && $citation=='') {
    if ($title != '') {
      $citation=$authors.$title.' ('.$year.') '.$journal.', '.$volume.' '.$issue.' '.$pages.'.';
    }
    else {
      $citation='';
    }
  }
  // url
  if (isset($url) && $url=='') {
    if ($pubmed_id != '') {
      $url='https://www.ncbi.nlm.nih.gov/pubmed/'.$pubmed_id.'/';
    }
    else {
      $url='';
    }
  }
  // abstract
  if (isset($abstract) && $abstract=='') {  
    $pattern='~.*AbstractText>(.+)\<.*~';
    if ($pubmed_html != '') {
      $result = preg_match($pattern, $pubmed_html, $match);
      $abstract = $match[1];  
    }
  }
  // official id
  if (isset($pubmed_id) && $pubmed_id != '') {
    $art_off_id=$pubmed_id;
  }  

  /* fix all special charactor issues */
  $remove_tag = "\<[A-Za-z0-9\/]+\>";
  $allowed_chr = "[^A-Za-z0-9\-\+\ \,\.\?\:\;\`\'\~\!\@\#\$\%\&\*\_\=\)\(\]\[\}\{\|\/\\\\]";
  $spec_chr = array("–", "'", "-", '"', "&quot;"); // original charactor
  $fixed_chr = array("-", "'", "-", "'", ""); // fixed charactor

  function remove_special_chr($string,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr) {
    $string=preg_replace('/'.$remove_tag.'/', '', $string);
    $string=preg_replace('/'.$allowed_chr.'/', '', $string);
    $string=str_replace($spec_chr, $fixed_chr, $string);    
    return $string;
  }
  
  $title=remove_special_chr($title,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $year=remove_special_chr($year,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $journal=remove_special_chr($journal,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $citation=remove_special_chr($citation,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $url=remove_special_chr($url,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $abstract=remove_special_chr($abstract,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $theory=remove_special_chr($theory,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $mod_meth=remove_special_chr($mod_meth,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $cur_notes=remove_special_chr($cur_notes,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $inc_qual=remove_special_chr($inc_qual,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);
  $authors=remove_special_chr($authors,$remove_tag,$allowed_chr,$spec_chr,$fixed_chr);

  /*
    Article details section
  */
  $det_lbl_wth='100px'; //article details label width
  $dir='/cognome_articles_renamed/';
  include('find_pdf.php');
  echo "<center><u>Article Details</u></center>
  <br>
  <br>
  <table style='min-width:100%;'>
  <tr><td style='max-width:".$det_lbl_wth.";'>Title:</td><td><textarea name='title' style='min-width:100%;min-height:50px;font-size:22px;'>".$title."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Article Official ID:</td><td><textarea name='art_off_id' style='min-width:400px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$art_off_id."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Year:</td><td><textarea name='year' style='max-width:70px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$year."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Journal:</td><td><textarea name='journal' style='min-width:100%;min-height:25px;font-size:22px;'>".$journal."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Citation:</td><td><textarea name='citation' style='min-width:100%;min-height:125px;font-size:22px;'>".$citation."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Url:</td><td><textarea name='url' style='min-width:100%;min-height:25px;font-size:22px;' id='url'>".$url."</textarea><br>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".find_pdf($dir, $art_mod_id)."' target='_blank'>Pdf</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='https://scholar.google.com/scholar?hl=en&as_sdt=0%2C47&q=".str_replace(" ", "+", $title)."' target='_blank' id='scholar_link'>Google Scholar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='?art_mod_id=".($_GET['art_mod_id']+1)."#scholar_link'>Next</a></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Authors:</td><td><textarea name='authors' style='min-width:100%;min-height:25px;font-size:22px;' id='url'>".$authors."</textarea></td></tr> 
  <tr><td style='max-width:".$det_lbl_wth.";'>Abstract:</td><td><textarea name='abstract' style='min-width:100%;min-height:200px;font-size:22px;'>".$abstract."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Theory Notes:</td><td><textarea name='theory' style='min-width:100%;min-height:50px;font-size:22px;'>".$theory."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Modeling Methods:</td><td><textarea name='modeling_methods' style='min-width:100%;min-height:50px;font-size:22px;'>".$mod_meth."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Citation Notes:</td><td><textarea name='curation_notes' style='min-width:100%;min-height:50px;font-size:22px;'>".$cur_notes."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Inclusion Qualification:</td><td><textarea name='inclusion_qualification' style='min-width:100%;min-height:50px;font-size:22px;'>".$inc_qual."</textarea></td></tr>  
  </table>
  </div>";  

  $sql = "SELECT MAX(id) FROM $cog_database.articles;";
  $result = $cog_conn->query($sql);
  $row = $result->fetch_assoc();
  if ($art_mod_id=='') {
    $new_art_numb = $row["MAX(id)"] + 1; // new article id number
  }
  else {
    $new_art_numb = $art_mod_id;
  }
  echo "<input type='hidden' name='new_art_numb' value='".$new_art_numb."' />";

  /*
    Article research properties
  */
  // Check for existing property data
  $sel_sbj=array(); // subjects
  $sel_det=array(); // level of detail
  $sel_ipl=array(); // implementation level
  $sel_thy=array(); // theories
  $sel_kwd=array(); // keywords   

  function chk_prop($sql, $cog_conn, $col) {
    /*
      Collect array of existing article properties
    */
    $matches=array();
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        array_push($matches,$row[$col]);
      }
    }    
    return $matches;
  }

  function add_rem_buttons($property,$property_group) {
    /*
      Provides buttons to add or remove article property
    */
    if ($property == "Neuron" || $property == "Subject" || $property == "Region" || $property == "Theory" || $property == "Keyword") {
      echo "<br><br><br><div style='height:17px;'></div>&nbsp;";
    }
    //echo $propery;
    echo "<font style='font-size:1.3em;'><a href='javascript:toggle_vis(\"add_".$property."\")' style='text-decoration:none;color:black !important;'>+</a>&nbsp<a href='javascript:toggle_vis(\"remove_".$property."\")' style='text-decoration:none;color:black !important'>–</a></font>
    <span style='display:none;' id='add_".$property."'><font style='font-size:.7em;'>Add ".$property.":</font><br><textarea name='add_".$property."' style='min-width:70%;max-height:25px;font-size:22px;'></textarea>&nbsp&nbsp&nbsp<input type='submit' value='  Add  ' style='height:28px;font-size:20px;position:relative;top:-7px;'></input></span>
    <span style='display:none;' id='remove_".$property."'><font style='font-size:.7em;'>Remove ".$property.":</font><br><select name='remove_".$property."' size='1' class='select-css' style='min-width:400px;position:relative;top:-7px;'>";
    echo "<option value='' ></option>";
    for ($i=0;$i<count($property_group);$i++) {
      echo "<option value='".$property_group[$i]."' >".$property_group[$i]."</option>";
    }
    echo "</select>&nbsp&nbsp&nbsp<input type='submit' value='  Remove  ' style='height:28px;font-size:20px;position:relative;top:-7px;'></input></span>";
  }

  /* 
    Collect and display existing article properties 
  */
  $tbl="$cog_database.";     
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
    $col="region_id";    
    $sql="SELECT ".$col." FROM ".$tbl."article_has_region WHERE article_id=".$art_mod_id;
    $sel_rgn=chk_prop($sql, $cog_conn, $col);   
    //
    $col="neuron_id";    
    $sql="SELECT ".$col." FROM ".$tbl."article_has_neuron WHERE article_id=".$art_mod_id;
    $sel_nrn=chk_prop($sql, $cog_conn, $col);      
    //
    $col="neuron_id";    
    $sql="SELECT ".$col." FROM ".$tbl."article_has_neuronfuzzy WHERE article_id=".$art_mod_id;
    $sel_nrnfzy=chk_prop($sql, $cog_conn, $col);          
  }

  $sel_nrntot = array();
  array_push($sel_nrntot, $sel_nrn);
  array_push($sel_nrntot, $sel_nrnfzy);

  echo "<br><div class='article_details'>
  <center><u>Article Research Properties</u></center><br>
  <table>";

  function display_property($cog_conn, $prop_desc, $but_desc, $tbl, $col, $select_group, $multi_sel) {
    echo "<tr><td style='min-width:350px;'>".$prop_desc."</td><td>";
    if ($but_desc == "Neuron") {
      $sel_nrn = $select_group[0];
      $sel_nrnfzy = $select_group[1];
      echo "<div style='width:400px;height:150px;overflow-y:scroll;line-height:20px;float:left;border:1px solid black;'><font style='font-size:18px;'><table>";
      $sql = "SELECT ".$col." FROM ".$tbl;
      $result = $cog_conn->query($sql);
      $prop_group=array();  
      $i=0;
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $i=$i+1;
          $checked='';
          if (in_array($i,$sel_nrn)) {
            $checked='checked';
          }
          $checked_fzy='';
          if (in_array($i,$sel_nrnfzy)) {
            $checked_fzy='checked';
          }
          echo "<tr><td style='width:85px;border-bottom:1px solid black;'>&nbsp;<input type='checkbox' name='neuron_p$i' id='neuron_p$i' style='display: inline;' $checked />&nbsp;proper</td><td style='width:75px;border-bottom:1px solid black;'>&nbsp;<input type='checkbox' name='neuron_f$i' id='neuron_f$i' style='display: inline;' $checked_fzy />&nbsp;fuzzy</td><td style='width:220px;border-bottom:1px solid black;'>&nbsp;".$row[$col]."</td></tr>";
          array_push($prop_group,$row[$col]);
        }
      }
      echo "</table></font></div>";
    }
    else if ($but_desc == "Subject" || $but_desc == "Region" || $but_desc == "Theory" || $but_desc == "Keyword") {
      echo "<div style='width:400px;height:150px;overflow-y:scroll;line-height:20px;float:left;border:1px solid black;'><font style='font-size:18px;'><table>";
      $sql = "SELECT ".$col." FROM ".$tbl;
      $result = $cog_conn->query($sql);
      $prop_group=array();  
      $i=0;
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $i=$i+1;
          $checked='';
          if (in_array($i,$select_group)) {
            $checked='checked';
          }
          echo "<tr><td style='width:25px;border-bottom:1px solid black;'>&nbsp;<input type='checkbox' name='$col$i' id='$col$i' style='display: inline;' $checked /></td><td style='width:375px;border-bottom:1px solid black;'>&nbsp;".$row[$col]."</td></tr>";
          array_push($prop_group,$row[$col]);
        }
      }
      echo "</table></font></div>";
    }
    else {
      echo "<select name='".$tbl."[]'";
      if ($multi_sel) {
        echo " size='5' multiple class='select-css' style='min-width:400px;'>";
      }
      else {
        echo " size='1' class='select-css' style='min-width:500px;position:relative;top:-5px;'>";
        echo "<option></option>";
      }
      $sql = "SELECT ".$col." FROM ".$tbl;
      $result = $cog_conn->query($sql);
      $prop_group=array();  
      $i=0;
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $i=$i+1;
          $selection='';
          if (in_array($i,$select_group)) {
            $selection='selected';
          }
          echo "<option value=".$i." ".$selection.">".$row[$col]."</option>";
          array_push($prop_group,$row[$col]);  
        }
      }
      echo "</select>&nbsp";
    }
    add_rem_buttons($but_desc,$prop_group);
    echo "</td></tr>";
  }

  // display evidence textboxes
  include('display_evidence.php');     

  $evid_loc_h=40; // location textbox height
  $evid_des_h=100; // description textbox height
  if (isset($art_mod_id)) {
  display_property($cog_conn, 'Subjects:', 'Subject', 'subjects', 'subject', $sel_sbj, true);
  display_evidence($cog_conn, "Subject", "Location", "sub_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Subject", "Description", "sub_desc", $evid_des_h, $art_mod_id);
  //
  display_property($cog_conn, 'Level of Detail:', 'Detail', 'details', 'detail_level', $sel_det, false);
  display_evidence($cog_conn, "Detail", "Location", "det_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Detail", "Description", "det_desc", $evid_des_h, $art_mod_id);  
  //
  display_property($cog_conn, 'Network Scale:', 'Scale', 'network_scales', 'scale', $sel_scl, false);  
  display_evidence($cog_conn, "Scale", "Location", "scl_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Scale", "Description", "scl_desc", $evid_des_h, $art_mod_id);  
  //
  display_property($cog_conn, 'Implementation Level:', 'Implementation', 'implementations', 'level', $sel_ipl, false);
  display_evidence($cog_conn, "Implementation", "Location", "impl_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Implementation", "Description", "impl_desc", $evid_des_h, $art_mod_id);  
  //
  display_property($cog_conn, 'Anatomical Region:', 'Region', 'regions', 'region', $sel_rgn, true);
  display_evidence($cog_conn, "Region", "Location", "reg_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Region", "Description", "reg_desc", $evid_des_h, $art_mod_id);  
  //
  display_property($cog_conn, 'Theories and Computational<br>Network Models:', 'Theory', 'theory_category', 'category', $sel_thy, true);
  display_evidence($cog_conn, "Theory or Computational<br>Network Model", "Location", "thy_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Theory or Computational<br>Network Model", "Description", "thy_desc", $evid_des_h, $art_mod_id);  
  //
  display_property($cog_conn, 'Neuron Types:', 'Neuron', 'neuron_types', 'neuron', $sel_nrntot, true);
  display_evidence($cog_conn, "Neuron", "Location", "nrn_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Neuron", "Description", "nrn_desc", $evid_des_h, $art_mod_id);
  //
  display_property($cog_conn, 'Keywords:', 'Keyword', 'keywords', 'keyword', $sel_kwd, true);
  display_evidence($cog_conn, "Keyword", "Location", "kwd_loc", $evid_loc_h, $art_mod_id);
  display_evidence($cog_conn, "Keyword", "Description", "kwd_desc", $evid_des_h, $art_mod_id);
  }

  echo "</table></div><br>";
  echo "<div class='article_details' style='position:fixed;bottom:10px;right:10px;'><span style='font-size:1.2em;'><input type='submit' value='  Submit  ' style='height:30px;font-size:22px;'></input></span></div>";

  $cog_conn->close();

  ?></center></table></form>
</div></div><br>
</div>
</body>
</html>
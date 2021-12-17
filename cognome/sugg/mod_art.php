<?php if (!session_id()) {session_start();}
/* check for login */
if (!isset($_SESSION['user_login']) || $_SESSION['user_login'] == '') {
  echo "<script>window.location.replace('login.php');</script>";
  header("Location: login.php"); 
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
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
  <div style="width:90%;position:relative;left:5%;"> 
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='mod_art.php' style='text-decoration: none;color:black !important'><span class='title_section'>Suggest Literature Entry</span></a>";
  </script>
  <!-- end of header -->
  
  <?php
  include('mysql_connect.php');  

  // add/modify/del options presented
  echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><span style='height:10px'></span><span style='font-size:1.2em'>Welcome Back ".$_SESSION['user_login']."&nbsp&nbsp&nbsp<a href='login.php?logout=true' style='font-size:.7em'>logout?</a><br><span style='height:20px;padding:20px;'><br></span></span><form action='art_sub.php' method='POST'>Articles:&nbsp&nbsp<input type='button' value='  Add  ' onclick='toggleListDown()' style='height:30px;font-size:22px;position:relative;top:-2px;'>&nbsp&nbsp</input><input type='button' value='  Modify  ' onclick='toggleListUp()' style='height:30px;font-size:22px;position:relative;top:-2px;'></input><span style='height:10px'></span>";
  $sql = "SELECT * FROM natemsut_cog_sug.articles ORDER BY ID DESC;";
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
    <span style='display:none;' id='remove_".$property."'><font style='font-size:.9em;'>Remove ".$property.":</font><br>";
    /*
      Remove content deactivated until able to manage it better.
    */
    /*echo "<select name='remove_".$property."' size='1' class='select-css' style='min-width:400px;max-width:70%;position:relative;top:-7px;'>";*/
    echo "<select name='deactivated' size='1' class='select-css' style='min-width:400px;max-width:70%;position:relative;top:-7px;'>";
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
  $cog_conn->close();

  /*
    Check for prior collected article details
  */
  if (isset($_GET['art_mod_id'])) {
    $art_mod_id = $_GET['art_mod_id'];
    list($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id) = setArtDetails($art_mod_id,$servername,$username,$password,$dbname);
  }

  function setArtDetails($art_mod_id,$servername,$username,$password,$dbname) {
      // Create connection
    $cog_conn = new mysqli($servername, $username, $password, $dbname);    
      // Check connection
    if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); echo 'connection failed';}  

    $sql = "SELECT * FROM natemsut_cog_sug.articles WHERE ID=".$art_mod_id.";";
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

    $cog_conn->close();

    return array($title, $year, $journal, $citation, $url, $abstract, $theory, $mod_meth, $cur_notes, $inc_qual, $authors, $art_off_id);
  }

  /*
    Import from pubmed
  */
  // Create connection
  $cog_conn = new mysqli($servername, $username, $password, $dbname);    
  // Check connection
  if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); }  

  echo "<br><div class='article_details'><center>
  <form action='#' method='POST'>
  Import from pubmed id:&nbsp;<textarea name='pubmed_id' style='max-width:200px;max-height:25px;font-size:22px;overflow:hidden;resize:none;position:relative;top:5px;'>".$_POST['pubmed_id']."</textarea>&nbsp;&nbsp;<button style='min-width:75px;min-height:25px;position:relative;top:-2px;font-size:22px;'>Import</button>&nbsp;&nbsp;&nbsp;&nbsp;E.g. 27870120</form><br>
  <form action='art_sub.php' method='POST'>
  <span style='font-size:1em;'>Submit the Article to the Database: <input type='submit' value='  Submit  ' style='height:30px;font-size:22px;position:relative;top:-2px;'></input></span></center></div>";
  echo "<br><div class='article_details'>";
  $pubmed_id=$_POST['pubmed_id'];
  $pubmed_html=file_get_contents('https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&id='.$pubmed_id.'retmode=json&rettype=abstract');

  /* populate article data */
  // title
  if ($title=='') {
  $pattern='~.*ArticleTitle\>(.+)\<.*~';
  $result = preg_match($pattern, $pubmed_html, $match);
  $title = $match[1];
  }
  // year
  if ($year=='') {
  $pattern='~.*PubDate\W+Year\>(.+)\<.*~';
  $result = preg_match($pattern, $pubmed_html, $match);
  $year = $match[1];
  }
  // journal
  if ($journal=='') {
  $pattern='~.*JournalIssue\W+Title>(.+)\<.*~';
  $result = preg_match($pattern, $pubmed_html, $match);
  $journal = $match[1];
  }
  // citation data
  // authors
  if ($authors=='') {
    $authors='';
    $lastname_pattern='~.*LastName>(.+)\<.*~';
    $firstinitials_pattern='~.*Initials>(.+)\<.*~';
    $lastname_result = preg_match_all($lastname_pattern, $pubmed_html, $match_1,PREG_PATTERN_ORDER);
    $firstinitials_result = preg_match_all($firstinitials_pattern, $pubmed_html, $match_2,PREG_PATTERN_ORDER);
    for( $i = 0; $i<sizeof($match_1[0]); $i++ ) {
      $authors=$authors.$match_1[1][$i].', '.$match_2[1][$i].'., ';
    }
  }
  // volume
  if ($volume=='') {
    $pattern='~.*JournalIssue\W+Volume>(.+)\<.*~';
    $result = preg_match($pattern, $pubmed_html, $match);
    $volume = $match[1];  
  }
  // issue
  if ($issue=='') {  
    $pattern='~.*JournalIssue\W+Issue>(.+)\<.*~';
    $result = preg_match($pattern, $pubmed_html, $match);
    $issue = $match[1];   
  }
  // pages
  if ($pages=='') {  
    $pattern='~.*Pagination\W+MedlinePgn>(.+)\<.*~';
    $result = preg_match($pattern, $pubmed_html, $match);
    $pages = $match[1]; 
  }
  // combine for citation 
  if ($citation=='') {
    if ($title != '') {
      $citation=$authors.$title.' ('.$year.') '.$journal.', '.$volume.' '.$issue.' '.$pages.'.';
    }
    else {
      $citation='';
    }
  }
  // url
  if ($url=='') {
    if ($pubmed_id != '') {
      $url='https://www.ncbi.nlm.nih.gov/pubmed/'.$pubmed_id.'/';
    }
    else {
      $url='';
    }
  }
  // abstract
  if ($abstract=='') {  
    $pattern='~.*AbstractText>(.+)\<.*~';
    $result = preg_match($pattern, $pubmed_html, $match);
    $abstract = $match[1];  
  }
  // official id
  if ($pubmed_id != '') {
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
  echo "<center><u>Article Details</u></center>
  <br>
  <br>
  <table style='min-width:100%;'>
  <tr><td style='max-width:".$det_lbl_wth.";'>Title:</td><td><textarea name='title' style='min-width:100%;min-height:50px;font-size:22px;'>".$title."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Article Official ID:</td><td><textarea name='art_off_id' style='min-width:400px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$art_off_id."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Year:</td><td><textarea name='year' style='max-width:70px;max-height:25px;font-size:22px;overflow:hidden;resize:none;'>".$year."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Journal:</td><td><textarea name='journal' style='min-width:100%;min-height:25px;font-size:22px;'>".$journal."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Citation:</td><td><textarea name='citation' style='min-width:100%;min-height:125px;font-size:22px;'>".$citation."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Url:</td><td><textarea name='url' style='min-width:100%;min-height:25px;font-size:22px;' id='url'>".$url."</textarea></td></tr> 
  <tr><td style='max-width:".$det_lbl_wth.";'>Authors:</td><td><textarea name='authors' style='min-width:100%;min-height:25px;font-size:22px;' id='url'>".$authors."</textarea></td></tr> 
  <tr><td style='max-width:".$det_lbl_wth.";'>Abstract:</td><td><textarea name='abstract' style='min-width:100%;min-height:200px;font-size:22px;'>".$abstract."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Theory Notes:</td><td><textarea name='theory' style='min-width:100%;min-height:50px;font-size:22px;'>".$theory."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Modeling Methods:</td><td><textarea name='modeling_methods' style='min-width:100%;min-height:50px;font-size:22px;'>".$mod_meth."</textarea></td></tr>  
  <tr><td style='max-width:".$det_lbl_wth.";'>Citation Notes:</td><td><textarea name='curation_notes' style='min-width:100%;min-height:50px;font-size:22px;'>".$cur_notes."</textarea></td></tr>
  <tr><td style='max-width:".$det_lbl_wth.";'>Inclusion Qualification:</td><td><textarea name='inclusion_qualification' style='min-width:100%;min-height:50px;font-size:22px;'>".$inc_qual."</textarea></td></tr>  
  </table>
  </div>";  

  $sql = "SELECT MAX(id) FROM natemsut_cog_sug.articles;";
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

  function chk_prop($sql, $cog_conn, $tbl) {
    /*
      Collect array of existing article properties
    */
    $matches=array();
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        array_push($matches,$row[$tbl]);
      }
    }    
    return $matches;
  }

  function add_rem_buttons($property,$property_group) {
    /*
      Provides buttons to add or remove article property
    */
    echo "<font style='font-size:1.3em;'><a href='javascript:toggle_vis(\"add_".$property."\")' style='text-decoration:none;color:black !important'>+</a>&nbsp<a href='javascript:toggle_vis(\"remove_".$property."\")' style='text-decoration:none;color:black !important'>–</a></font>
    <span style='display:none;' id='add_".$property."'><font style='font-size:.7em;'>Add ".$property.":</font><br>";
    /* deactivated removal until better able to manage it */
    /*echo "<textarea name='add_".$property."' */
    echo "<textarea name='deactivated_2' 
    style='min-width:70%;max-height:25px;font-size:22px;'></textarea>&nbsp&nbsp&nbsp<input type='submit' value='  Add  ' style='height:28px;font-size:20px;position:relative;top:-7px;'></input></span>
    <span style='display:none;' id='remove_".$property."'><font style='font-size:.7em;'>Remove ".$property.":</font><br>";
    /*echo "<select name='remove_".$property."'*/
    echo "<select name='deactivated_3' 
     size='1' class='select-css' style='min-width:400px;position:relative;top:-7px;'>";
    echo "<option value='' ></option>";
    for ($i=0;$i<count($property_group);$i++) {
      echo "<option value='".$property_group[$i]."' >".$property_group[$i]."</option>";
    }
    echo "</select>&nbsp&nbsp&nbsp<input type='submit' value='  Remove  ' style='height:28px;font-size:20px;position:relative;top:-7px;'></input></span>";
  }

  /* 
    Collect and display existing article properties 
  */
  if ($art_mod_id!='') {
    $sql="SELECT subject_id FROM natemsut_cog_sug.article_has_subject WHERE article_id=".$art_mod_id;
    $tbl="subject_id";
    $sel_sbj=chk_prop($sql, $cog_conn, $tbl);
    $sql="SELECT detail_id FROM natemsut_cog_sug.article_has_detail WHERE article_id=".$art_mod_id;
    $tbl="detail_id";
    $sel_det=chk_prop($sql, $cog_conn, $tbl);
    $sql="SELECT level_id FROM natemsut_cog_sug.article_has_implmnt WHERE article_id=".$art_mod_id;
    $tbl="level_id";
    $sel_ipl=chk_prop($sql, $cog_conn, $tbl);
    $sql="SELECT theory_id FROM natemsut_cog_sug.article_has_theory WHERE article_id=".$art_mod_id;
    $tbl="theory_id";
    $sel_thy=chk_prop($sql, $cog_conn, $tbl);
    $sql="SELECT keyword_id FROM natemsut_cog_sug.article_has_keyword WHERE article_id=".$art_mod_id;
    $tbl="keyword_id";
    $sel_kwd=chk_prop($sql, $cog_conn, $tbl);            
  }

  echo "<br><div class='article_details'>
  <center><u>Article Research Properties</u><br>
  Note: use control key to select multiple choices</center><br>
  <table>  
  <tr><td style='min-width:350px;'>Subjects:</td><td><select name='subjects[]' size='5' multiple class='select-css' style='min-width:400px;'>";
  $sql = "SELECT subject FROM subjects";
  $result = $cog_conn->query($sql);
  $subjects_group=array();
  $i=0;
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $i=$i+1;
      $selection='';      
      if (in_array($i,$sel_sbj)) {
        $selection='selected';
      }
      echo "<option value=".$i." ".$selection.">".$row["subject"]."</option>";
      array_push($subjects_group,$row["subject"]);       
    }
  }  
  echo "</select>&nbsp";
  add_rem_buttons('Subject',$subjects_group);
  echo "</td></tr><tr><td style='min-width:350px;'>Level of Detail:</td><td><select name='details[]' size='1' class='select-css' style='min-width:500px;position:relative;top:-5px;'><option></option>";
  $sql = "SELECT detail_level FROM details";
  $result = $cog_conn->query($sql);
  $details_group=array();  
  $i=0;
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $i=$i+1;
      $selection='';
      if (in_array($i,$sel_det)) {
        $selection='selected';
      }
      echo "<option value=".$i." ".$selection.">".$row["detail_level"]."</option>";
      array_push($details_group,$row["detail_level"]);  
    }
  }
  echo "</select>&nbsp";
  add_rem_buttons('Detail',$details_group);
  echo "</td></tr><tr><td style='min-width:350px;'>Implementation Level:</td><td><center><select name='implmnts[]' size='1' class='select-css' style='min-width:500px;position:relative;top:-5px;'><option></option>";
  $sql = "SELECT level FROM implementations";
  $result = $cog_conn->query($sql);
  $implmnts_group=array();   
  $i=0;
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $i=$i+1;
      $selection='';
      if (in_array($i,$sel_ipl)) {
        $selection='selected';
      }
      echo "<option value=".$i." ".$selection.">".$row["level"]."</option>";
      array_push($implmnts_group,$row["level"]);      
    }
  }
  echo "</select>&nbsp";
  add_rem_buttons('Implementation',$implmnts_group);
  echo "</center></td></tr><tr><td style='min-width:350px;'>Theories:</td><td style='min-width:450px;'><select name='theories[]' size='5' multiple class='select-css' style='min-width:400px;'>";
  $sql = "SELECT category FROM theory_category";
  $result = $cog_conn->query($sql);
  $theories_group=array();  
  $i=0;
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $i=$i+1;
      $selection='';
      if (in_array($i,$sel_thy)) {
        $selection='selected';
      }
      echo "<option value=".$i." ".$selection.">".$row["category"]."</option>";
      array_push($theories_group,$row["category"]);       
    }
  }
  echo "</select>&nbsp";
  add_rem_buttons('Theory',$theories_group);
  echo "</td></tr>
  <tr><td style='min-width:350px;'>Keywords:</td><td><select name='keywords[]' size='5' multiple class='select-css' style='min-width:400px;'>";
  $sql = "SELECT keyword FROM keywords";
  $result = $cog_conn->query($sql);
  $keywords_group=array();    
  $i=0;
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $i=$i+1;
      $selection='';
      if (in_array($i,$sel_kwd)) {
        $selection='selected';
      }
      echo "<option value=".$i." ".$selection.">".$row["keyword"]."</option>";
      array_push($keywords_group,$row["keyword"]);      
    }
  }  
  echo "</select>&nbsp";
  add_rem_buttons('Keyword',$keywords_group);
  echo "</td></tr></table></div><br>";
  echo "<div class='article_details'><center><form action='art_sub.php' method='POST'>
  <span style='font-size:1.2em;'>Submit the Article to the Database: <input type='submit' value='  Submit  ' style='height:30px;font-size:22px;position:relative;top:-2px;'></input></span></center></div>";

  $cog_conn->close();

  ?></center></table></form>
</div></div><br>
</div>
</body>
</html>
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
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
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

  function record_username($cog_conn, $tbl, $username) {
    /*
      Record username of user who made any change to the database
      Find user id, then find entry id, then insert change into
      suggestions table.
    */
    $sql = "SELECT id FROM `natemsut_cog_sug`.`accounts` WHERE username='".$username."';";
    $result = $cog_conn->query($sql);
    $user_id = $result->fetch_assoc()['id'];
    $sql = "SELECT MAX(id) FROM natemsut_cog_sug.".$tbl.";";
    $result = $cog_conn->query($sql);    
    $entry_id = $result->fetch_assoc()['MAX(id)'];
    $sql = "INSERT INTO `natemsut_cog_sug`.`user_suggestions` (`user_id`, `entry_id`, `table`, `username`) VALUES ('".$user_id."', '".$entry_id."', '".$tbl."', '".$username."');";
    $result = $cog_conn->query($sql);
  }
  
  function add_property($tbl,$row_name,$add_prop,$cog_conn) {
    /*
      Adds literature property
    */
    $sql = "SELECT MAX(id) FROM natemsut_cog_sug.".$tbl.";";
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc();
    $prop_id = $row["MAX(id)"] + 1;
    $prop_name = $_POST[$add_prop];
    $sql = "INSERT INTO `natemsut_cog_sug`.`".$tbl."` (`id`, `".$row_name."`) VALUES ('".$prop_id."', '".$prop_name."');";
    $result = $cog_conn->query($sql);
    record_username($cog_conn, $tbl, $_SESSION['user_login']);
    echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>".$row_name." added: ".$prop_name."<br>
    <br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
  }

  function confirm_remove($tbl,$name,$rem_prop,$cog_conn) {     
    /*
      Confirms if property should be removed
    */
    $prop_name = $_POST[$rem_prop];
    $sql = "SELECT id FROM natemsut_cog_sug.".$tbl." WHERE ".$name."='".$prop_name."';";
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc(); 
    echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Are you sure you want to remove the following?<br><br>".$name.": ".$prop_name."<br>
    <br><form action='art_sub.php' method='POST'><input type='hidden' name='".$rem_prop."' value='".$_POST[$rem_prop]."' /><input type='hidden' name='confirm' value='yes' /><input type='submit' value='  yes  ' style='min-width:120px;min-height:40px;font-size:.9em;'/></form>
    &nbsp&nbsp&nbsp<form action='mod_art.php' method='POST'><input type='submit' value='  no  ' style='min-width:120px;min-height:40px;font-size:.9em;'/></form><br><br></div>";
  }

  function remove_property($tbl,$name,$rem_prop,$cog_conn) {
    /*
      Removes literature property
    */    
    if (!isset($_POST['confirm'])) {    
      confirm_remove($tbl,$name,$rem_prop,$cog_conn);
    }
    else if (isset($_POST['confirm']) && $_POST['confirm']== 'yes') {
      $prop_name = $_POST[$rem_prop];
      $sql = "SELECT id FROM natemsut_cog_sug.".$tbl." WHERE ".$name."='".$prop_name."';";
      $result = $cog_conn->query($sql);
      $row = $result->fetch_assoc();
      $prop_id = $row["id"];    
      $sql = "DELETE FROM `natemsut_cog_sug`.`".$tbl."` WHERE (`id` = '".$prop_id."');";
      $result = $cog_conn->query($sql);
      record_username($cog_conn, $tbl, $_SESSION['user_login']);
      echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>".$name." removed: ".$prop_name."<br>
      <br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
    }
  }

  // process research properties add/del or article del
  if (isset($_POST['remove_Article']) && $_POST['remove_Article']!= '') {
    remove_property('articles','citation','remove_Article',$cog_conn);
  }  
  else if (isset($_POST['add_Subject']) && $_POST['add_Subject']!= '') {
    add_property('subjects','subject','add_Subject',$cog_conn);
  }
  else if (isset($_POST['remove_Subject']) && $_POST['remove_Subject']!= '') {
    remove_property('subjects','subject','remove_Subject',$cog_conn);    
  }  
  else if (isset($_POST['add_Detail']) && $_POST['add_Detail']!= '') {
    add_property('details','detail_level','add_Detail',$cog_conn);
  }
  else if (isset($_POST['remove_Detail']) && $_POST['remove_Detail']!= '') {
    remove_property('details','detail_level','remove_Detail',$cog_conn);    
  }  
  else if (isset($_POST['add_Implementation']) && $_POST['add_Implementation']!= '') {
    add_property('implementations','level','add_Implementation',$cog_conn);
  }
  else if (isset($_POST['remove_Implementation']) && $_POST['remove_Implementation']!= '') {
    remove_property('implementations','level','remove_Implementation',$cog_conn);    
  }        
  else if (isset($_POST['add_Theory']) && $_POST['add_Theory']!= '') {
    add_property('theory_category','category','add_Theory',$cog_conn);
  }
  else if (isset($_POST['remove_Theory']) && $_POST['remove_Theory']!= '') {
    remove_property('theory_category','category','remove_Theory',$cog_conn);
  }  
  else if (isset($_POST['add_Keyword']) && $_POST['add_Keyword']!= '') {
    add_property('keywords','keyword','add_Keyword',$cog_conn);
  }
  else if (isset($_POST['remove_Keyword']) && $_POST['remove_Keyword']!= '') {
    remove_property('keywords','keyword','remove_Keyword',$cog_conn);    
  }  
  else {

  // Check for existing property data
  $sel_sbj=array(); // subjects
  //$fnd_sbj=array(); // found subjects
  $sel_det=array(); // level of detail
  //$fnd_det=array();
  $sel_ipl=array(); // implementation level
  //$fnd_det=array();
  $sel_thy=array(); // theories
  //$fnd_thy=array();
  $sel_kwd=array(); // keywords   
  //$fnd_kwd=array();

  function chk_prop($sql, $cog_conn, $tbl) {
    $matches=array();
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        array_push($matches,$row[$tbl]);
      }
    }    
    return $matches;
  }

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

  function process_deletions($cog_conn,$art_num,$tbl,$col,$old_entry,$new_entry) {
    /*
      Create any deletion of values
    */
    $verbose_comments=false;

    for ($i=0; $i<count($old_entry); $i++)
    { 
      if ($verbose_comments) {echo "<br>".$tbl." ".$col.": ".$old_entry[$i]."<br>";}
      if (!in_array($old_entry[$i],$new_entry)) {
        $sql = "SELECT id FROM natemsut_cog_sug.".$tbl." WHERE (`article_id` = '".$art_num."' AND `".$col."` = '".$old_entry[$i]."')";
        $result = $cog_conn->query($sql);
        if ($result->num_rows > 0) { 
          $row = $result->fetch_assoc();
          $del_id=$row["id"];
          if ($verbose_comments) {echo "<br>art_num:".$art_num."<br>del_id:<br>".$del_id."<br>".$sql."<br>";}          
          $sql = "DELETE FROM `natemsut_cog_sug`.`".$tbl."` WHERE (`id` = '".$del_id."')";
          $result = $cog_conn->query($sql); 
          record_username($cog_conn, $tbl, $_SESSION['user_login']);           
          if ($verbose_comments) {echo "<br>deleted: ".$old_entry[$i]."<br>";}
        }
        if ($verbose_comments) {echo "<br>deleted: ".$sql."<br>";}
      }
      else {
        if ($verbose_comments) {echo "<br>not deleted: ".$old_entry[$i]."<br>";}
      }
    }
  }

  function process_additions($cog_conn,$art_num,$tbl,$col,$old_entry,$new_entry) {
    /*
      Create any addition of values
    */
    $verbose_comments=false;

    for ($i=0; $i<count($new_entry); $i++)
    {
      if ($verbose_comments) {echo "<br>".$tbl." ".$col.": ".$new_entry[$i]."<br>";}
      if (!in_array($new_entry[$i],$old_entry)) {
        $sql = "INSERT INTO `natemsut_cog_sug`.`".$tbl."` (`".$col."`, `article_id`) VALUES ('".$new_entry[$i]."', '".$art_num."');";
        $result = $cog_conn->query($sql);
        record_username($cog_conn, $tbl, $_SESSION['user_login']);
        if ($verbose_comments) {echo "<br>added: ".$new_entry[$i]."<br>";}
      }
      else {
        if ($verbose_comments) {echo "<br>not added: ".$new_entry[$i]."<br>";}
      }
    }   
  }

  // Check if article is existing one or new one
  $result = $cog_conn->query("SELECT ID FROM natemsut_cog_sug.articles WHERE ID=".$art_num);
  if($result->num_rows == 0) { 
    // check for missing official id    
    if($art_off_id == '') {
        echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Error: missing official id description<br><br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
        exit();
    }
    // check for duplicate article
    $sql = "SELECT official_id FROM natemsut_cog_sug.articles WHERE official_id=\"".$art_off_id."\";";
    $result = $cog_conn->query($sql);
    if($result->num_rows == 0 && $_POST['citation'] != '') {
      // submit article details
      $sql = "INSERT INTO `natemsut_cog_sug`.`articles` (`url`, `year`, `title`, `theory`, `modeling_methods`, `journal`, `citation`, `abstract`, `curation_notes`, `authors`, `official_id`, `inclusion_qualification`) VALUES (\"".$_POST['url']."\", \"".$_POST['year']."\", \"".$_POST['title']."\", \"".$_POST['theory']."\", \"".$_POST['modeling_methods']."\", \"".$_POST['journal']."\", \"".$_POST['citation']."\", \"".$_POST['abstract']."\", \"".$_POST['curation_notes']."\", \"".$_POST['authors']."\", \"".$_POST['art_off_id']."\", \"".$_POST['inclusion_qualification']."\");";
      $result = $cog_conn->query($sql);
      record_username($cog_conn, 'articles', $_SESSION['user_login']);

      // submit research properties
      if ($_POST['subjects']!='') {
        $subjects = $_POST['subjects'];
        for ($i=0; $i<count($subjects); $i++)
        {
          $sql = "INSERT INTO `natemsut_cog_sug`.`article_has_subject` (`subject_id`, `article_id`) VALUES ('".$subjects[$i]."', '".$_POST['new_art_numb']."');";
          $result = $cog_conn->query($sql);
          record_username($cog_conn, 'article_has_subject', $_SESSION['user_login']);
        }    
      }
      if ($_POST['details']!='') {
        $details = $_POST['details'];
        $sql = "INSERT INTO `natemsut_cog_sug`.`article_has_detail` (`detail_id`, `article_id`) VALUES ('".$details[0]."', '".$_POST['new_art_numb']."');";
        $result = $cog_conn->query($sql);
        record_username($cog_conn, 'article_has_detail', $_SESSION['user_login']);
      }
      if ($_POST['implmnts']!='') {
        $implmnts = $_POST['implmnts'];
        $sql = "INSERT INTO `natemsut_cog_sug`.`article_has_implmnt` (`level_id`, `article_id`) VALUES ('".$implmnts[0]."', '".$_POST['new_art_numb']."');";
        $result = $cog_conn->query($sql);
        record_username($cog_conn, 'article_has_implmnt', $_SESSION['user_login']);
      }
      if ($_POST['theories']!='') {
        $theories = $_POST['theories'];
        for ($i=0; $i<count($theories); $i++)
        {
          $sql = "INSERT INTO `natemsut_cog_sug`.`article_has_theory` (`theory_id`, `article_id`) VALUES ('".$theories[$i]."', '".$_POST['new_art_numb']."');";
          $result = $cog_conn->query($sql);
          record_username($cog_conn, 'article_has_theory', $_SESSION['user_login']);
        }    
      }
      if ($_POST['keywords']!='') {
        $keywords = $_POST['keywords'];
        for ($i=0; $i<count($keywords); $i++)
        {
          $sql = "INSERT INTO `natemsut_cog_sug`.`article_has_keyword` (`keyword_id`, `article_id`) VALUES ('".$keywords[$i]."', '".$_POST['new_art_numb']."');";
          $result = $cog_conn->query($sql);
          record_username($cog_conn, 'article_has_keyword', $_SESSION['user_login']);
        }    
      }    
    } 
    else {
      // duplicate official id found
      $sub_success='false';
      echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Article submission not successful";
      if ($_POST['citation'] != '') {
        echo " because article already exists in the database.<br>Existing article has official id ".$art_off_id." and url <a href='".$_POST['url']."' target='_blank'>".$_POST['url']."</a> .<br><br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
      }
      else if (isset($_POST['deactivated']) || isset($_POST['deactivated_2']) || isset($_POST['deactivated_2'])) {
        echo "<br>Error: deleting articles and adding/removing types of dimension values has been put on hold for user submissions until the development team finds a way to track and manage these changes better. We are working on quickly enabling these features for user submissions and not only administrator access. Thank you for your patience.<br><br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
      }
      else {
        echo "<br>Error: missing citation description<br><br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
      }
    } 
  } 
  else {
    // existing article for modificiation detected
    $sql = "UPDATE `natemsut_cog_sug`.`articles` SET `url` = \"".$_POST['url']."\", `year` = \"".$_POST['year']."\", `title`= \"".$_POST['title']."\", `theory` = \"".$_POST['theory']."\", `modeling_methods` = \"".$_POST['modeling_methods']."\", `journal` = \"".$_POST['journal']."\", `citation` = \"".$_POST['citation']."\", `abstract` = \"".$_POST['abstract']."\", `curation_notes` = \"".$_POST['curation_notes']."\", `official_id` = \"".$_POST['art_off_id']."\", `authors` = \"".$_POST['authors']."\", `inclusion_qualification` = \"".$_POST['inclusion_qualification']."\" WHERE (`id` = ".$art_num.");";
    $result = $cog_conn->query($sql);
    record_username($cog_conn, 'articles', $_SESSION['user_login']);
    
    // submit research properties
    if ($_POST['subjects']!='') {
      $subjects = $_POST['subjects'];
      process_deletions($cog_conn,$art_num,'article_has_subject','subject_id',$sel_sbj,$subjects);
      process_additions($cog_conn,$art_num,'article_has_subject','subject_id',$sel_sbj,$subjects);  
    }
    if ($_POST['details']!='') {
      $det_lvl=$_POST['details'];
      process_deletions($cog_conn,$art_num,'article_has_detail','detail_id',$sel_det,$det_lvl);
      process_additions($cog_conn,$art_num,'article_has_detail','detail_id',$sel_det,$det_lvl); 
    }
    if ($_POST['implmnts']!='') {
      $impl_lvl=$_POST['implmnts'];
      process_deletions($cog_conn,$art_num,'article_has_implmnt','level_id',$sel_ipl,$impl_lvl);
      process_additions($cog_conn,$art_num,'article_has_implmnt','level_id',$sel_ipl,$impl_lvl);       
    }
    if ($_POST['theories']!='') {
      $theories = $_POST['theories'];  
      process_deletions($cog_conn,$art_num,'article_has_theory','theory_id',$sel_thy,$theories);
      process_additions($cog_conn,$art_num,'article_has_theory','theory_id',$sel_thy,$theories);       
    }
    if ($_POST['keywords']!='') {
      $keywords = $_POST['keywords'];   
      process_deletions($cog_conn,$art_num,'article_has_keyword','keyword_id',$sel_kwd,$keywords);
      process_additions($cog_conn,$art_num,'article_has_keyword','keyword_id',$sel_kwd,$keywords);        
    }
  }

  if ($sub_success=='true') {
    echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Literature collection update successful.<br>
    <br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
  }

  }

  $cog_conn->close();

  ?></center></table>
</div></div><br>
</div>
</body>
</html>
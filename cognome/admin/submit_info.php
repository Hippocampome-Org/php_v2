<?php
  //echo "<br>new submission processed<br><br>";

  // submit article details
  $sql = "INSERT INTO `$cog_database`.`articles` (`url`, `year`, `title`, `theory`, `modeling_methods`, `journal`, `citation`, `abstract`, `curation_notes`, `authors`, `official_id`, `inclusion_qualification`) VALUES (\"".$_POST['url']."\", \"".$_POST['year']."\", \"".$_POST['title']."\", \"".$_POST['theory']."\", \"".$_POST['modeling_methods']."\", \"".$_POST['journal']."\", \"".$_POST['citation']."\", \"".$_POST['abstract']."\", \"".$_POST['curation_notes']."\", \"".$_POST['authors']."\", \"".$_POST['art_off_id']."\", \"".$_POST['inclusion_qualification']."\");";
  $result = $cog_conn->query($sql);

  // submit research properties
  if ($_POST['subjects']!='') {
    $subjects = $_POST['subjects'] ?? null;
    for ($i=0; $i<count($subjects ?? array()); $i++)
    {
      $sql = "INSERT INTO `$cog_database`.`article_has_subject` (`subject_id`, `article_id`) VALUES ('".$subjects[$i]."', '".$_POST['new_art_numb']."');";
      $result = $cog_conn->query($sql);
    }    
  }
  if ($_POST['details']!='') {
    $details = $_POST['details'] ?? null;
    $sql = "INSERT INTO `$cog_database`.`article_has_detail` (`detail_id`, `article_id`) VALUES ('".$details[0]."', '".$_POST['new_art_numb']."');";
    $result = $cog_conn->query($sql);
  }
  if ($_POST['implementations']!='') {
    $implementations = $_POST['implementations'] ?? null;
    $sql = "INSERT INTO `$cog_database`.`article_has_implmnt` (`level_id`, `article_id`) VALUES ('".$implementations[0]."', '".$_POST['new_art_numb']."');";
    $result = $cog_conn->query($sql);
  }
  if ($_POST['network_scales']!='') {
    $network_scales = $_POST['network_scales'] ?? null;
    $sql = "INSERT INTO `$cog_database`.`article_has_scale` (`scale_id`, `article_id`) VALUES ('".$network_scales[0]."', '".$_POST['new_art_numb']."');";
    $result = $cog_conn->query($sql);
  }  
  if ($_POST['neuron_types']!='') {
    $network_scales = $_POST['neuron_types'] ?? null;
    for ($i=0; $i<count($network_scales ?? array()); $i++)
    {    
      $sql = "INSERT INTO `$cog_database`.`article_has_neuron` (`neuron_id`, `article_id`) VALUES ('".$network_scales[$i]."', '".$_POST['new_art_numb']."');";
      $result = $cog_conn->query($sql);
    }
  }    
  if ($_POST['regions']!='') {
    $regions = $_POST['regions'] ?? null;
    for ($i=0; $i<count($regions ?? array()); $i++)
    {
      $sql = "INSERT INTO `$cog_database`.`article_has_region` (`region_id`, `article_id`) VALUES ('".$regions[$i]."', '".$_POST['new_art_numb']."');";
      $result = $cog_conn->query($sql);
    } 
  }
  if ($_POST['theory_category']!='') {
    $theories = $_POST['theory_category'] ?? null;
    for ($i=0; $i<count($theories ?? array()); $i++)
    {
      $sql = "INSERT INTO `$cog_database`.`article_has_theory` (`theory_id`, `article_id`) VALUES ('".$theories[$i]."', '".$_POST['new_art_numb']."');";
      $result = $cog_conn->query($sql);
    }    
  }
  if ($_POST['keywords']!='') {
    $keywords = $_POST['keywords'] ?? null;
    for ($i=0; $i<count($keywords ?? array()); $i++)
    {
      $sql = "INSERT INTO `$cog_database`.`article_has_keyword` (`keyword_id`, `article_id`) VALUES ('".$keywords[$i]."', '".$_POST['new_art_numb']."');";
      $result = $cog_conn->query($sql);
    }    
  } 

  // submit evidence entries
  include('sub_evidence.php');    
?>
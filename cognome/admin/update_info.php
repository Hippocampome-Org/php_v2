<?php
  // existing article for modificiation detected
  $sql = "UPDATE `$cog_database`.`articles` SET `url` = \"".$_POST['url']."\", `year` = \"".$_POST['year']."\", `title`= \"".$_POST['title']."\", `theory` = \"".$_POST['theory']."\", `modeling_methods` = \"".$_POST['modeling_methods']."\", `journal` = \"".$_POST['journal']."\", `citation` = \"".$_POST['citation']."\", `abstract` = \"".$_POST['abstract']."\", `curation_notes` = \"".$_POST['curation_notes']."\", `official_id` = \"".$_POST['art_off_id']."\", `authors` = \"".$_POST['authors']."\", `inclusion_qualification` = \"".$_POST['inclusion_qualification']."\" WHERE (`id` = ".$art_num.");";
  $result = $cog_conn->query($sql);

  function get_count($cog_conn, $tbl) {
    // return count of entities for a property type
    $sql = "SELECT id FROM $tbl";
    $result = $cog_conn->query($sql);
    $n_i = 1;
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        $n_i++;
      }
    }
    return $n_i;
  }

  $subjects_count = get_count($cog_conn, "subjects");
  $regions_count = get_count($cog_conn, "regions");
  $theories_count = get_count($cog_conn, "theory_category");
  $neuron_types_count = get_count($cog_conn, "neuron_types");
  $keywords_count = get_count($cog_conn, "keywords");
  
  // submit research properties
  // subjects
  $subjects = array();
  for ($i = 1; $i < $subjects_count; $i++) {
    if (isset($_POST["subject$i"])) {
      array_push($subjects, $i);
    }
  }
  process_deletions($cog_conn,$art_num,'article_has_subject','subject_id',$sel_sbj,$subjects,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_subject','subject_id',$sel_sbj,$subjects,$cog_database); 
  // details
  if ($_POST['details']!='') {
    $det_lvl=$_POST['details'];
    process_deletions($cog_conn,$art_num,'article_has_detail','detail_id',$sel_det,$det_lvl,$cog_database);
    process_additions($cog_conn,$art_num,'article_has_detail','detail_id',$sel_det,$det_lvl,$cog_database); 
  }
  // implementations
  if ($_POST['implementations']!='') {
    $impl_lvl=$_POST['implementations'];
    process_deletions($cog_conn,$art_num,'article_has_implmnt','level_id',$sel_ipl,$impl_lvl,$cog_database);
    process_additions($cog_conn,$art_num,'article_has_implmnt','level_id',$sel_ipl,$impl_lvl,$cog_database);       
  }
  // scales
  if ($_POST['network_scales']!='') {
    $network_scale_update=$_POST['network_scales'];
    process_deletions($cog_conn,$art_num,'article_has_scale','scale_id',$sel_scl,$network_scale_update,$cog_database);
    process_additions($cog_conn,$art_num,'article_has_scale','scale_id',$sel_scl,$network_scale_update,$cog_database);       
  }  
  // neuron types
  $neuron_type_update = array();
  $neuron_type_fuzzy_update = array();
  for ($i = 1; $i < $neuron_types_count; $i++) {
    if (isset($_POST["neuron_p$i"])) {
      array_push($neuron_type_update, $i);
    }
    if (isset($_POST["neuron_f$i"])) {
      array_push($neuron_type_fuzzy_update, $i);
    }    
  }
  process_deletions($cog_conn,$art_num,'article_has_neuron','neuron_id',$sel_nrn,$neuron_type_update,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_neuron','neuron_id',$sel_nrn,$neuron_type_update,$cog_database);    
  process_deletions($cog_conn,$art_num,'article_has_neuronfuzzy','neuron_id',$sel_nrnfzy,$neuron_type_fuzzy_update,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_neuronfuzzy','neuron_id',$sel_nrnfzy,$neuron_type_fuzzy_update,$cog_database);
  // regions
  $regions_list = array();
  for ($i = 1; $i < $regions_count; $i++) {
    if (isset($_POST["region$i"])) {
      array_push($regions_list, $i);
    }
  }  
  process_deletions($cog_conn,$art_num,'article_has_region','region_id',$sel_rgn,$regions_list,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_region','region_id',$sel_rgn,$regions_list,$cog_database);  
  // theories    
  $theories = array();
  for ($i = 1; $i < $theories_count; $i++) {
    if (isset($_POST["category$i"])) {
      array_push($theories, $i);
    }
  }   
  process_deletions($cog_conn,$art_num,'article_has_theory','theory_id',$sel_thy,$theories,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_theory','theory_id',$sel_thy,$theories,$cog_database);    
  // keywords
  $keywords = array();
  for ($i = 1; $i < $keywords_count; $i++) {
    if (isset($_POST["keyword$i"])) {
      array_push($keywords, $i);
    }
  }   
  process_deletions($cog_conn,$art_num,'article_has_keyword','keyword_id',$sel_kwd,$keywords,$cog_database);
  process_additions($cog_conn,$art_num,'article_has_keyword','keyword_id',$sel_kwd,$keywords,$cog_database);        

  // update evidence entries
  include('sub_evidence.php');
?>
<?php
  function get_existing_text($cog_conn, $tbl, $col, $art_mod_id) {
    $existing_entry = '';

    if ($art_mod_id != '') {
      $sql = "SELECT ".$col." FROM ".$tbl." WHERE article_id=".$art_mod_id.";";
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        $existing_entry = $row[$col];
      }    
    }

    return $existing_entry;
  }

  function display_evidence($cog_conn, $prop_desc, $evid_type, $prop_id, $height, $art_mod_id) {
    $existing_entry = '';
    if ($prop_desc == "Subject") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_subjects", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_subjects", "evidence_description", $art_mod_id);
      }
    }   
    else if ($prop_desc == "Detail") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_details", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_details", "evidence_description", $art_mod_id);
      }
    }    
    else if ($prop_desc == "Scale") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_scales", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_scales", "evidence_description", $art_mod_id);
      }
    }    
    else if ($prop_desc == "Implementation") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_implmnts", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_implmnts", "evidence_description", $art_mod_id);
      }
    }    
    else if ($prop_desc == "Region") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_regions", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_regions", "evidence_description", $art_mod_id);
      }
    }    
    else if ($prop_desc == "Theory or Computational<br>Network Model") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_theories", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_theories", "evidence_description", $art_mod_id);
      }
    }  
    else if ($prop_desc == "Neuron") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_neurons", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_neurons", "evidence_description", $art_mod_id);
      }
    }      
    else if ($prop_desc == "Keyword") {
      if ($evid_type == "Location") {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_keywords", "evidence_position", $art_mod_id);
      }
      else if ($evid_type=='Description') {
        $existing_entry = get_existing_text($cog_conn, "evidence_of_keywords", "evidence_description", $art_mod_id);
      }
    }

    echo "<tr><td>".$prop_desc." Evidence ".$evid_type.":</td><td><textarea name='".$prop_id."_evid' style='height:".$height."px;width:85%;font-size:20px;'>".$existing_entry."</textarea></td>";
  } 
?>
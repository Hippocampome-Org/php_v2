<?php 

  $prop_relation = '';
  $prop_tbl_join = '';
  $neuron_types_id = 7;
  $second_filter_active = false;
  if (isset($prop_value) && isset($second_filter) && ($prop_value != "" || $second_filter != 'no filter')) {
    $second_filter_active = true;
  }
  $second_filter_entity_sel = false;
  if (isset($prop_name) && isset($prop_ent_desc) && ($prop_name != "" && $prop_ent_desc != "")) {
    $second_filter_entity_sel = true;
  }

  /*
    Display selected search options
  */
  if ($subject_desc != "" || $dim_desc != "" || $prop_desc != "") {
    echo "<center><div style='font-size:1em;display: inline-block;text-align: center;margin: 0 auto;'>";
    if ($subject != 0) {
      if ($second_filter_active) {
        echo "First Filter: Subject: ".$subject_desc;
      }
      else {
        echo "Filtered by Subject: ".$subject_desc;
      }
    }
    if ($subject != 0 && $second_filter_entity_sel) {
      echo ";<br>";
    }
    if ($second_filter_entity_sel) {
      echo "Second Filter: ";
      if ($prop_name == "level of detail") {
        echo "Level of Detail";
      }
      else if ($prop_name == "theory or network algorithm") {
        echo "Theory or Network Algorithm";
      }
      else {echo ucwords($prop_name);}
      echo ": ".$prop_ent_desc;
    }
    if (($subject != 0 || ($second_filter_entity_sel)) && ($dimension != 0 || $property != 1)) {
      echo ";<br>";
    }
    if ($dimension != 0 || $property != 1) {
      echo "Sorted by: ";
    }
    if ($dimension != 0) {
      echo $dim_desc;
    }
    if ($dimension != 0 && $property != 1) {
      echo " and ";
    }    
    if ($property != 1) {
      echo $prop_desc;
    }
    if ($subject != 0 || $dimension != 0 || $property != 1) {
      echo ".";
    }
    echo "</div></center>";
  }
  echo "<br>";

  /*
    Build query
  */
  if ($second_filter_active) {
    $prop_relation = $prop_relation_tbl;
    $prop_tbl_join = " AND ".$prop_relation_tbl.".article_id = articles.id";
  }
  $sql = "SELECT DISTINCT articles.id, articles.url, articles.citation, articles.theory, articles.modeling_methods, articles.abstract, articles.curation_notes, articles.inclusion_qualification, ";
  if ($dimension != 0) {
    $sql = $sql.$dim_relation.".".$dim_id.", ";
    if ($dimension == $neuron_types_id) {
      $sql = $sql."article_has_neuronfuzzy.neuron_id, ";
    }
  }
  if ($second_filter_entity_sel) {
    $sql = $sql.$prop_relation.".".$prop_relation_row.", ";
  }
  $sql = $sql."articles.".$prop_id." FROM articles, article_has_subject";
  if ($dimension != 0 && $dimension != 8) {
    $sql = $sql.", ".$dim_relation;
    if ($dimension == $neuron_types_id) {
      $sql = $sql.", article_has_neuronfuzzy";
    }
  }
  if ($second_filter_entity_sel && ($dim_relation != $prop_relation_tbl)) {
    $sql = $sql.", ".$prop_relation;
  }
  $sql = $sql." WHERE ";
  if ($subject != 0) {
    $sql = $sql."article_has_subject.`subject_id` = ".$subject." AND ";
  }
  if ($dimension != 0) {
    $sql = $sql.$dim_relation.".`".$article_id."` = articles.id AND ";
    if ($dimension == $neuron_types_id) {
      $sql = $sql."article_has_neuronfuzzy.article_id = articles.id AND ";
    }
  }
  $sql = $sql."article_has_subject.article_id = articles.id";
  if ($second_filter_entity_sel) {
    if ($dimension == $neuron_types_id) {
      $sql = $sql." AND (".$prop_relation_tbl.".".$prop_relation_row." = ".$prop_value." OR article_has_neuronfuzzy.neuron_id = ".$prop_value.")".$prop_tbl_join;
    }
    else {
      $sql = $sql." AND ".$prop_relation_tbl.".".$prop_relation_row." = ".$prop_value.$prop_tbl_join;
    }
  }
  if ($dimension != 0 || $property != 1) {
    // set order by conditions
    // only proceeds if selections are not set to "all"
    $sql = $sql." ORDER BY ";
    if ($dimension != 0) {
      $sql = $sql.$dim_relation.".`".$dim_id."` ASC";
      if ($dimension == $neuron_types_id) {
        $sql = $sql.", article_has_neuronfuzzy.`neuron_id` ASC";
      }
    }
    if ($dimension != 0 && $property != 1) {
      $sql = $sql." , ";
    }
    if ($property != 1) {
      $sql = $sql."`articles`.`".$prop_id."` DESC";
    }
  } 
  //echo $sql;

?>
<?php
  $subject = 1;
  $dimension = 1;
  $property = 1;
  $prop_ent_desc = "";
  if ($_POST['form_submitted']=='1') {
    $subject = $_POST['subject'];
    $dimension = $_POST['dimension'];
    $property = $_POST['property'];
  }
  $dim_id = '';
  $dim_desc = '';
  $subject_desc = '';
  $dim_relation = '';
  $article_id = 'article_id';
  switch($dimension) {
    case 1: $dim_id = 'detail_id'; 
    $dim_desc = 'Level of Detail';
    $dim_relation = 'article_has_detail'; break;
    case 2: $dim_id = 'level_id'; 
    $dim_desc = 'Level of Implementation';
    $dim_relation = 'article_has_implmnt'; break;
    case 3: $dim_id = 'theory_id';
    $dim_desc = 'Theory or Network Algorithm'; 
    $dim_relation = 'article_has_theory'; break;
    case 4: $dim_id = 'keyword_id'; 
    $dim_desc = 'Keyword';
    $dim_relation = 'article_has_keyword'; break;
    case 5: $dim_id = 'region_id'; 
    $dim_desc = 'Anatomical Region';
    $dim_relation = 'article_has_region'; break;    
    case 6: $dim_id = 'scale_id'; 
    $dim_desc = 'Simulation Scale';
    $dim_relation = 'article_has_scale'; break;    
    case 7: $dim_id = 'neuron_id'; 
    $dim_desc = 'Neuron Type';
    $dim_relation = 'article_has_neuron'; break; 
    case 8: $dim_id = 'subject_id'; 
    $dim_desc = 'Subject';
    $dim_relation = 'article_has_subject'; break; 
  }
  switch($property) {
    case 1: $prop_id = 'id'; 
    $prop_desc = 'All';
    $prop_relation = 'articles'; break;
    case 2: $prop_id = 'authors'; 
    $prop_desc = 'Authors';
    $prop_relation = 'articles'; break;
    case 3: $prop_id = 'year';
    $prop_desc = 'Year'; 
    $prop_relation = 'articles'; break;
    case 4: $prop_id = 'title'; 
    $prop_desc = 'Title';
    $prop_relation = 'articles'; break;
    case 5: $prop_id = 'url'; 
    $prop_desc = 'Url';
    $prop_relation = 'articles'; break;  
    case 6: $prop_id = 'theory'; 
    $prop_desc = 'Theory Notes';
    $prop_relation = 'articles'; break;
    case 7: $prop_id = 'modeling_methods';
    $prop_desc = 'Modeling Methods'; 
    $prop_relation = 'articles'; break;
    case 8: $prop_id = 'journal'; 
    $prop_desc = 'Journal';
    $prop_relation = 'articles'; break;
    case 9: $prop_id = 'citation'; 
    $prop_desc = 'Citation';
    $prop_relation = 'articles'; break;       
  }  
  switch($subject) {
    case 1: $subject_desc = 'Spatial Memory or Navigation'; break;
    case 2: $subject_desc = 'Associative Memory'; break;
    case 3: $subject_desc = 'Time Cells or Timekeeping'; break;
    case 4: $subject_desc = 'Delayed Conditioning'; break;
    case 5: $subject_desc = 'Pattern Completion or Separation'; break;
    case 6: $subject_desc = 'Long-term Memory or Consolidation'; break;
    case 7: $subject_desc = 'Reinforcement Learning'; break;
    case 8: $subject_desc = 'Sensory Specific Memory'; break;
    case 9: $subject_desc = 'High-performance Computing'; break;
    case 10: $subject_desc = 'Recognition Memory'; break;
    case 11: $subject_desc = 'Episodic Memory'; break;
    case 12: $subject_desc = 'Semantic Memory'; break;
    case 13: $subject_desc = 'Data for Modeling'; break;
    case 14: $subject_desc = 'Working or Short-term Memory'; break;
    case 15: $subject_desc = 'Epilepsy'; break;
    case 16: $subject_desc = 'Schizophrenia'; break;
    case 17: $subject_desc = 'Other'; break;
    case 18: $subject_desc = 'Alzheimer\'s Disease'; break;
  }    
  if (isset($prop_value)) {
    // collect dimension entity name
    $sql = "SELECT $row_name FROM $tbl_name WHERE id = $prop_value;";
    $result = $cog_conn->query($sql); 
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        $prop_ent_desc = $row[$row_name];
      }
    }
  }
?>
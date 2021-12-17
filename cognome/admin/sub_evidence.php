<?php
  function sub_evidence($cog_conn, $loc_evid, $desc_evid, $col, $art_num, $cog_database) {
    $spec_chr = array("–", "'", "-", '"', "&quot;"); // original charactor
    $fixed_chr = array("-", "'", "-", "'", ""); // fixed charactor
    $loc_evid=str_replace($spec_chr, $fixed_chr, $loc_evid);
    $desc_evid=str_replace($spec_chr, $fixed_chr, $desc_evid);
    // submit evidence entries
    if ($loc_evid!='' || $desc_evid!='') {
      // check for entry      
      $sql = "SELECT id FROM `$cog_database`.`".$col."` WHERE (`article_id` = ".$art_num.");";
      //echo $sql."<br>";
      $result = $cog_conn->query($sql);   
      $row = $result->fetch_assoc();
      $evid_id=$row["id"]; 
      // submit values 
      if ($evid_id!='') {
        $sql = "UPDATE `$cog_database`.`".$col."` SET `evidence_position` = \"".$loc_evid."\", `evidence_description` = \"".$desc_evid."\" WHERE (`id` = ".$evid_id.");";
        //echo $sql."<br>";
        $result = $cog_conn->query($sql);
      }
      else {
        $sql = "INSERT INTO `$cog_database`.`".$col."` (`article_id`, `evidence_position`, `evidence_description`) VALUES ('".$art_num."', '".$loc_evid."', '".$desc_evid."');";
        //echo $sql."<br>";
        $result = $cog_conn->query($sql); 
      }
    } 
  }

  // submit evidence entries
  $loc_evid_list = array($_POST['sub_loc_evid'],$_POST['det_loc_evid'],$_POST['scl_loc_evid'],$_POST['impl_loc_evid'],$_POST['reg_loc_evid'],$_POST['thy_loc_evid'],$_POST['nrn_loc_evid'],$_POST['kwd_loc_evid']);
  $desc_evid_list = array($_POST['sub_desc_evid'],$_POST['det_desc_evid'],$_POST['scl_desc_evid'],$_POST['impl_desc_evid'],$_POST['reg_desc_evid'],$_POST['thy_desc_evid'],$_POST['nrn_desc_evid'],$_POST['kwd_desc_evid']);
  $col_evid_list = array('evidence_of_subjects','evidence_of_details','evidence_of_scales','evidence_of_implmnts','evidence_of_regions','evidence_of_theories','evidence_of_neurons','evidence_of_keywords');
  for ($ei=0;$ei<count($loc_evid_list);$ei++) {
    sub_evidence($cog_conn, $loc_evid_list[$ei], $desc_evid_list[$ei], $col_evid_list[$ei], $art_num, $cog_database);  
  }
?>
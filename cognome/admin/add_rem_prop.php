<?php
  function add_property($tbl,$row_name,$add_prop,$cog_conn,$cog_database) {
    /*
      Adds literature property
    */
    $sql = "SELECT MAX(id) FROM $cog_database.".$tbl.";";
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc();
    $prop_id = $row["MAX(id)"] + 1;
    $prop_name = $_POST[$add_prop];
    $sql = "INSERT INTO `$cog_database`.`".$tbl."` (`id`, `".$row_name."`) VALUES ('".$prop_id."', '".$prop_name."');";
    $result = $cog_conn->query($sql);
    date_default_timezone_set('America/New_York');
      $date = date('m/d/Y h:i:s a', time());
    echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>".$row_name." added: ".$prop_name.".<br>Submission received at: ".$date." EST.";
    //echo "<br><a href='mod_art.php'>Back to update articles collection page</a>";
    echo "<br><br></div>";
  }

  function confirm_remove($tbl,$name,$rem_prop,$cog_conn,$cog_database) {     
    /*
      Confirms if property should be removed
    */
    $prop_name = $_POST[$rem_prop];
    $sql = "SELECT id FROM $cog_database.".$tbl." WHERE ".$name."='".$prop_name."';";
    $result = $cog_conn->query($sql);
    $row = $result->fetch_assoc(); 
    echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>Are you sure you want to remove the following?<br><br>".$name.": ".$prop_name."<br>
    <br><form action='art_sub.php' method='POST'><input type='hidden' name='".$rem_prop."' value='".$_POST[$rem_prop]."' /><input type='hidden' name='confirm' value='yes' /><input type='submit' value='  yes  ' style='min-width:120px;min-height:40px;font-size:.9em;'/></form>
    &nbsp&nbsp&nbsp<form action='mod_art.php' method='POST'><input type='submit' value='  no  ' style='min-width:120px;min-height:40px;font-size:.9em;'/></form><br><br></div>";
  }

  function remove_property($tbl,$name,$rem_prop,$cog_conn,$cog_database) {
    /*
      Removes literature property
    */    
    if (!isset($_POST['confirm'])) {    
      confirm_remove($tbl,$name,$rem_prop,$cog_conn,$cog_database);
    }
    else if (isset($_POST['confirm']) && $_POST['confirm']== 'yes') {
      $prop_name = $_POST[$rem_prop];
      $sql = "SELECT id FROM $cog_database.".$tbl." WHERE ".$name."='".$prop_name."';";
      $result = $cog_conn->query($sql);
      $row = $result->fetch_assoc();
      $prop_id = $row["id"];    
      $sql = "DELETE FROM `$cog_database`.`".$tbl."` WHERE (`id` = '".$prop_id."');";
      $result = $cog_conn->query($sql);
      echo "<div class='article_details' style='text-align: center;margin: 0 auto;padding: .4rem;font-size:1em;'><br>".$name." removed: ".$prop_name."<br>
      <br><a href='mod_art.php'>Back to update articles collection page</a><br><br></div>";
    }
  }

  function process_deletions($cog_conn,$art_num,$tbl,$col,$old_entry,$new_entry,$cog_database) {
    /*
      Create any deletion of values
    */
    $verbose_comments=false;

    for ($i=0; $i<count($old_entry); $i++)
    { 
      if ($verbose_comments) {echo "<br>".$tbl." ".$col.": ".$old_entry[$i]."<br>";}
      if (!in_array($old_entry[$i],$new_entry)) {
        $sql = "SELECT id FROM $cog_database.".$tbl." WHERE (`article_id` = '".$art_num."' AND `".$col."` = '".$old_entry[$i]."')";
        $result = $cog_conn->query($sql);
        if ($result->num_rows > 0) { 
          $row = $result->fetch_assoc();
          $del_id=$row["id"];
          if ($verbose_comments) {echo "<br>art_num:".$art_num."<br>del_id:<br>".$del_id."<br>".$sql."<br>";}          
          $sql = "DELETE FROM `$cog_database`.`".$tbl."` WHERE (`id` = '".$del_id."')";
          $result = $cog_conn->query($sql);            
          if ($verbose_comments) {echo "<br>deleted: ".$old_entry[$i]."<br>";}
        }
        if ($verbose_comments) {echo "<br>deleted: ".$sql."<br>";}
      }
      else {
        if ($verbose_comments) {echo "<br>not deleted: ".$old_entry[$i]."<br>";}
      }
    }
  }

  function process_additions($cog_conn,$art_num,$tbl,$col,$old_entry,$new_entry,$cog_database) {
    /*
      Create any deletion of values
    */      
    $verbose_comments=false;

    for ($i=0; $i<count($new_entry); $i++)
    {
      if ($verbose_comments) {echo "<br>".$tbl." ".$col.": ".$new_entry[$i]."<br>";}
      if (!in_array($new_entry[$i],$old_entry)) {
        $sql = "INSERT INTO `$cog_database`.`".$tbl."` (`".$col."`, `article_id`) VALUES ('".$new_entry[$i]."', '".$art_num."');";
        $result = $cog_conn->query($sql);
        if ($verbose_comments) {echo "<br>added: ".$new_entry[$i]."<br>";}
      }
      else {
        if ($verbose_comments) {echo "<br>not added: ".$new_entry[$i]."<br>";}
      }
    }   
  }   

  // process research properties add/del or article del
  if (isset($_POST['remove_Article']) && $_POST['remove_Article']!= '') {
    remove_property('articles','citation','remove_Article',$cog_conn,$cog_database);
  }  
  else if (isset($_POST['add_Subject']) && $_POST['add_Subject']!= '') {
    add_property('subjects','subject','add_Subject',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Subject']) && $_POST['remove_Subject']!= '') {
    remove_property('subjects','subject','remove_Subject',$cog_conn,$cog_database);    
  }  
  else if (isset($_POST['add_Detail']) && $_POST['add_Detail']!= '') {
    add_property('details','detail_level','add_Detail',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Detail']) && $_POST['remove_Detail']!= '') {
    remove_property('details','detail_level','remove_Detail',$cog_conn,$cog_database);    
  }  
  else if (isset($_POST['add_Implementation']) && $_POST['add_Implementation']!= '') {
    add_property('implementations','level','add_Implementation',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Implementation']) && $_POST['remove_Implementation']!= '') {
    remove_property('implementations','level','remove_Implementation',$cog_conn,$cog_database);
  }
  else if (isset($_POST['add_Scale']) && $_POST['add_Scale']!= '') {
    add_property('network_scales','scale','add_Scale',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Scale']) && $_POST['remove_Scale']!= '') {
    remove_property('network_scales','scale','remove_Scale',$cog_conn,$cog_database);
  }    
  else if (isset($_POST['add_Region']) && $_POST['add_Region']!= '') {
    add_property('regions','region','add_Region',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Region']) && $_POST['remove_Region']!= '') {
    remove_property('regions','region','remove_Region',$cog_conn,$cog_database);
  }        
  else if (isset($_POST['add_Theory']) && $_POST['add_Theory']!= '') {
    add_property('theory_category','category','add_Theory',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Theory']) && $_POST['remove_Theory']!= '') {
    remove_property('theory_category','category','remove_Theory',$cog_conn,$cog_database);
  }  
  else if (isset($_POST['add_Neuron']) && $_POST['add_Neuron']!= '') {
    add_property('neuron_types','neuron','add_Neuron',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Neuron']) && $_POST['remove_Neuron']!= '') {
    remove_property('neuron_types','neuron','remove_Neuron',$cog_conn,$cog_database);    
  }   
  else if (isset($_POST['add_Keyword']) && $_POST['add_Keyword']!= '') {
    add_property('keywords','keyword','add_Keyword',$cog_conn,$cog_database);
  }
  else if (isset($_POST['remove_Keyword']) && $_POST['remove_Keyword']!= '') {
    remove_property('keywords','keyword','remove_Keyword',$cog_conn,$cog_database);    
  }        
  else {
    $art_info_change=true;
    // Check for existing property data
    $sel_sbj=array(); // subjects
    $sel_det=array(); // level of detail
    $sel_ipl=array(); // implementation level
    $sel_thy=array(); // theories
    $sel_kwd=array(); // keywords 
    $sel_scl=array();
    $sel_rgn=array();
    $sel_nrn=array();  
    $sel_nrnfzy=array();  

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
      $sql="SELECT subject_id FROM $cog_database.article_has_subject WHERE article_id=".$art_mod_id;
      $tbl="subject_id";
      $sel_sbj=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT detail_id FROM $cog_database.article_has_detail WHERE article_id=".$art_mod_id;
      $tbl="detail_id";
      $sel_det=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT level_id FROM $cog_database.article_has_implmnt WHERE article_id=".$art_mod_id;
      $tbl="level_id";
      $sel_ipl=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT scale_id FROM $cog_database.article_has_scale WHERE article_id=".$art_mod_id;
      $tbl="scale_id";
      $sel_scl=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT neuron_id FROM $cog_database.article_has_neuron WHERE article_id=".$art_mod_id;
      $tbl="neuron_id";
      $sel_nrn=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT neuron_id FROM $cog_database.article_has_neuronfuzzy WHERE article_id=".$art_mod_id;
      $tbl="neuron_id";
      $sel_nrnfzy=chk_prop($sql, $cog_conn, $tbl);       
      //
      $sql="SELECT region_id FROM $cog_database.article_has_region WHERE article_id=".$art_mod_id;
      $tbl="region_id";
      $sel_rgn=chk_prop($sql, $cog_conn, $tbl);      
      //
      $sql="SELECT theory_id FROM $cog_database.article_has_theory WHERE article_id=".$art_mod_id;
      $tbl="theory_id";
      $sel_thy=chk_prop($sql, $cog_conn, $tbl);
      //
      $sql="SELECT keyword_id FROM $cog_database.article_has_keyword WHERE article_id=".$art_mod_id;
      $tbl="keyword_id";
      $sel_kwd=chk_prop($sql, $cog_conn, $tbl);            
    } 
  }
?>
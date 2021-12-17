<?php
  function search_option($cog_conn, $sql, $prop_name, $row_name, $tbl_name, $all_switch) {
    echo "<span style='display: inline-block;'>&nbsp;".$prop_name.":
    <select name='".$row_name."' size='1' class='select-css'>";
    $sql = "SELECT id, ".$row_name." FROM ".$tbl_name;
    $result = $cog_conn->query($sql); 
    $selection_received=$_POST[$row_name];  
    $all_value = 0;
    if ($tbl_name == "properties") {
      $all_value = 1;
    }
    if ($all_switch == 'all_on') {
      echo "<option value=0";
      if ($selection_received == $all_value) {
        echo " selected='selected'";
      }
      echo ">all</option>";  
    }      
    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) { 
        $d_i=$row["id"];
        $selection='';
        if ($selection_received == $d_i || ($d_i == 1 && $selection_received == '')) {
          $selection=" selected='selected'";
        }      
        echo "<option value=".$d_i." ".$selection.">".$row[$row_name]."</option>";
      }  
    }  
    else { echo "0 results"; }   
    echo "</select></span></span>";
  }
?>
<?php
  $result = $cog_conn->query($sql);
  $i=0; 
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $dim_type_desc=$dim_name[$dimension][$row[$dim_id]];
      if ($dim_type_desc=='') {$dim_type_desc='not yet described';};
      echo "<div class='article_details'><div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Article Abstract</label><div class='collapsible-content'><div class='content-inner'><p>
      ".$row["abstract"]."
      </p></div><a style='font-size:10px'><hr></a></div></div>";
      $i++;      
      echo "<u>Citation</u>: " . $row["citation"];
      if ($row["url"] != "") {
        echo "<br><u>Url</u>: <a href='".$row["url"]."'>" . $row["url"]."</a> ";
      }
      if ($dim_id != "") {
        echo "<br><u>".$dim_desc."</u>: ".$row[$dim_id].". Dimension type description: ".$dim_type_desc.".";
      }
      echo "<span style='float:right;font-size:18px;'><a href='browse.php?art_id=".$row["id"]."'>Full Details</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>";
      if ($row["theory"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Theory Notes</label><div class='collapsible-content'><div class='content-inner'><p>
      ".$row["theory"]."
      </p></div><a style='font-size:10px'><hr></a></div></div>";
      $i++;};
      if ($row["modeling_methods"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Modeling Methods</label><div class='collapsible-content'><div class='content-inner'><p>
      ".$row["modeling_methods"]."
      </p></div><a style='font-size:10px'><hr></a></div></div>";
      $i++;};
      if ($row["curation_notes"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Curation Notes</label><div class='collapsible-content'><div class='content-inner'><p>
      ".$row["curation_notes"]."
      </p></div><a style='font-size:10px'><hr></a></div></div>";
      $i++;};
      if ($row["inclusion_qualification"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Inclusion Qualification</label><div class='collapsible-content'><div class='content-inner'><p>
      ".$row["inclusion_qualification"]."
      </p></div><a style='font-size:10px'><hr></a></div></div>";
      $i++;};            
      echo "</div><br>"; 
    } 
  } 
  else { echo "<br>No results yet but content is being added to the database on a consistent basis. There sould be more results soon if you check back later."; }
?>  
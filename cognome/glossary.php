<?php
  // Collect dimension names
  $dim_tbl=array(
    1=>"details",
    2=>"implementations",
    3=>"theory_category",
    4=>"keywords",
    5=>"regions",
    6=>"network_scales",
    7=>"neuron_types");  
  $dim_col=array(
    1=>"detail_level",
    2=>"level",
    3=>"category",
    4=>"keyword",
    5=>"region",
    6=>"scale",
    7=>"neuron");
  $prp_tbl=array(
    1=>"article_has_detail",
    2=>"article_has_implmnt",
    3=>"article_has_theory",
    4=>"article_has_keyword",
    5=>"article_has_region",
    6=>"article_has_scale",
    7=>"article_has_neuron");
  $prp_col=array(
    1=>"detail_id",
    2=>"level_id",
    3=>"theory_id",
    4=>"keyword_id",
    5=>"region_id",
    6=>"scale_id",
    7=>"neuron_id");  
  $dim_desc=array(
    1=>"The detail level dimension provides the type of simulation model used in the work. The level of biological abstractness of the model can be infered from its
    core equations, without extensions to its complexity. The model included in the work at the lowest level is annotated as this property's value.<a href='anno_methods.php?disp=detail' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>",
    2=>"The level of implementation dimension describes the completeness of the implementation of the model in the literature. This explains what level of implementation the simulation model is currently at in the literature.<a href='anno_methods.php?disp=impl' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>",
    3=>"The theory category dimension describes which theories were found to be included in the literature.<a href='anno_methods.php?disp=theory' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>",
    4=>"The keyword dimension is used for annotating keywords that are useful to track for various research areas.<a href='anno_methods.php?disp=keyword' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>", 
    5=>"The region dimension is an annotation of which anatomical brain regions were included in model(s) in the article's research. Regions that were described but not modeled are not included in this annotation.<a href='anno_methods.php?disp=region' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>",
    6=>"The scale annotation represents the number of neurons in the article's model. This includes the number of neurons directly included in the article's work, not a number of neurons described in other researchs' models. An exception to this annotation method is in the case of articles that did not directly include any models, for those articles if they directly mention a specific neuron count included in a referenced article's work that is included in this annotation. This can occur in review articles and such articles can be filtered out of searches by selecting to display the extended collection database on the site.<a href='anno_methods.php?disp=scale' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>",
    7=>"The neuron types dimension records which hippocampal neuron types were present in an article's simulation(s).<a href='anno_methods.php?disp=types' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a>");
  /* Subjects */
    $j=1;
    echo "<tr><th><u>Dimension: subjects</u></th><th><u>Type: subject</u></th>";
    echo "<tr><td>Dimension Explanation:</td><td>This dimension includes subjects in an article's computational simulation(s).<a href='anno_methods.php?disp=subject' style='text-decoration: none;'><img src='info.gif' title='annotation methods description' style='height:20px;width:20px;float:right;position:relative;'></a></td></tr>";
    echo "</table><div style='max-height:400px;overflow:auto;'><table style='font-size:0.8em;'><tr><td><center><u>ID</u></center></td><td><center><u>Description</u></center></td></tr>";
    $sql = "SELECT subject FROM subjects;";
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) { 
        echo "<tr><td style='min-width:13em;font-size:1.0em;'><center>".$j."</center></td><td style='min-width:10em;font-size:1.0em;'>".$row['subject']."</td></tr>";
        $j++;
      }
    } 
  /* Other dimensions */
  echo "</table></div>";
  for($i=1;$i<(sizeof($dim_tbl)+1);$i++) {
    echo "<table style='font-size:0.8em;'><tr><th><u>Dimension: ".$dim_tbl[$i]."</u></th><th><u>Type: ".$dim_col[$i]."</u></th>";
    echo "<tr><td>Dimension Explanation:</td><td>".$dim_desc[$i]."</td></tr>";
    echo "</table><div style='max-height:400px;overflow:auto;'><table style='font-size:0.8em;'><tr><td><center><u>ID</u></center></td><td><center><u>Description</u></center></td></tr>";
    $sql = "SELECT ".$dim_col[$i]." FROM ".$dim_tbl[$i];
    $result = $cog_conn->query($sql);
    $j=1;
    if ($result->num_rows > 0) {       
      while($row = $result->fetch_assoc()) { 
        $dim_name[$i][$j]=$row[$dim_col[$i]];
        echo "<tr><td style='min-width:13em;font-size:1.0em;'><center>".$j."</center></td><td style='min-width:10em;font-size:1.0em;'>".$row[$dim_col[$i]]."</td></tr>";
        $j++;
      }
    } 
    echo "</table></div>";
  }
?>
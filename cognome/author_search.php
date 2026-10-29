<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <!--
    Name: Author Search
    Author: Nate Sutton
    Copyright: 2019

    Description: Search by Author

    References: https://www.rexegg.com/regex-php.html
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
  <script type="text/javascript">
    function toggle_vis(elem_name) {
     var elem = document.getElementById(elem_name);
     if (elem.style.display === "none") {
      elem.style.display = "block";
    } else {
      elem.style.display = "none";
    }
  }
</script>
</head>
<body>
  <?php include("function/hc_body.php"); ?> 
  <div style="width:90%;position:relative;left:5%;"> 
    <br><br>
    <!-- start of header -->
    <?php echo file_get_contents('header.html'); ?>
    <div style="width:90%;position:relative;left:5%;"> 
    <script type='text/javascript'>
      document.getElementById('header_title').innerHTML="<a href='author_search.php' style='text-decoration: none;color:black !important'><span class='title_section'>Search by Author</span></a>";
      document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
    </script>
    <!-- end of header -->

    <?php

    $letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N',
      'O','P','Q','R','S','T','U','V','W','X','Y','Z');

    $letter_patterns = array('/$[A].*/');
    $letter_patterns=array(
    'A'=>'/^[Aa].*/',
    'B'=>'/^[Bb].*/',
    'C'=>'/^[Cc].*/',
    'D'=>'/^[Dd].*/',
    'E'=>'/^[Ee].*/',
    'F'=>'/^[Ff].*/',
    'G'=>'/^[Gg].*/',
    'H'=>'/^[Hh].*/',
    'I'=>'/^[Ii].*/',        
    'J'=>'/^[Jj].*/',
    'K'=>'/^[Kk].*/',
    'L'=>'/^[Ll].*/',
    'M'=>'/^[Mm].*/',
    'N'=>'/^[Nn].*/',
    'O'=>'/^[Oo].*/',
    'P'=>'/^[Pp].*/',
    'Q'=>'/^[Qq].*/',
    'R'=>'/^[Rr].*/',
    'S'=>'/^[Ss].*/',
    'T'=>'/^[Tt].*/',
    'U'=>'/^[Uu].*/',
    'V'=>'/^[Vv].*/',
    'W'=>'/^[Ww].*/',
    'X'=>'/^[Xx].*/',
    'Y'=>'/^[Yy].*/',
    'Z'=>'/^[Zz].*/');

    if (isset($_GET['letter'])) {
      $letter = $_GET['letter'];
    }
    else {
      $letter = 'A';
    }

    function alink($first_letter) {
      echo "<a href='?letter=".$first_letter."'>".$first_letter."</a>&nbsp";
    }

    echo "<div class='article_details'><center>";

    foreach ($letters as $auth_letter) {
      alink($auth_letter);
    }
    echo "</center></div>";

    echo "<br><div class='article_details'>";

    if (isset($_GET['author_id'])) {
      //
      //  Find author name
      //  Get article ids that incldue the author
      //  Output formatted reports on each article corresponding to the id
      //
      $author_id = $_GET['author_id'];
      $sql = "SELECT author FROM $cog_database.authors WHERE id = ".$author_id.";";
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          $author_name = $row['author'];
        }
      }
      echo "<center><u>".$author_name."</u></center></div><br>";

      $author_ids = array();
      $sql = "SELECT article_id FROM $cog_database.article_has_author WHERE author_name='".$author_name."';";
      $result = $cog_conn->query($sql);
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
          array_push($author_ids,$row['article_id']);
        }
      }

      $i=0;
      foreach ($author_ids as $id) {
        $sql = "SELECT DISTINCT articles.id, articles.url, articles.citation, articles.theory, articles.modeling_methods, articles.abstract, articles.curation_notes, articles.inclusion_qualification FROM $cog_database.articles WHERE articles.id = ".$id.";";
        $result = $cog_conn->query($sql); 
        if ($result->num_rows > 0) { 
          while($row = $result->fetch_assoc()) {
            // abstract
            echo "<div class='article_details'><div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Article Abstract</label><div class='collapsible-content'><div class='content-inner'><p>
            ".$row["abstract"]."
            </p></div><a style='font-size:10px'><hr></a></div></div>";
            $i++;     
            // citation
            echo "<u>Citation</u>: " . $row["citation"].
            "<br><u>Url</u>: <a href='".$row["url"]."'>" . $row["url"].
            "</a>";            
            // full details
            echo "<span style='float:right;font-size:18px;'><a href='browse.php?art_id=".$row["id"]."'>Full Details</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>";
            // theory notes
            if ($row["theory"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Theory Notes</label><div class='collapsible-content'><div class='content-inner'><p>
            ".$row["theory"]."
            </p></div><a style='font-size:10px'><hr></a></div></div>";
            $i++;};
            // modeling methods
            if ($row["modeling_methods"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Modeling Methods</label><div class='collapsible-content'><div class='content-inner'><p>
            ".$row["modeling_methods"]."
            </p></div><a style='font-size:10px'><hr></a></div></div>";
            $i++;};
            // curation notes
            if ($row["curation_notes"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Curation Notes</label><div class='collapsible-content'><div class='content-inner'><p>
            ".$row["curation_notes"]."
            </p></div><a style='font-size:10px'><hr></a></div></div>";
            $i++;};
            // inclusion qualification
            if ($row["inclusion_qualification"]!='') {echo "<div class='wrap-collabsible'><input id='collapsible".$i."' class='toggle' type='checkbox'><label for='collapsible".$i."' class='lbl-toggle'>Inclusion Qualification</label><div class='collapsible-content'><div class='content-inner'><p>
            ".$row["inclusion_qualification"]."
            </p></div><a style='font-size:10px'><hr></a></div></div>";
            $i++;};
            echo "</div><br>"; 
          }
        }
      }
    }
    else {
      $sql = "SELECT id, author FROM $cog_database.authors;";
      $result = $cog_conn->query($sql); 
      if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) {
          $author = $row["author"];
          $auth_id = $row["id"];
          if (preg_match($letter_patterns[$letter], $author)) {
            echo "<a href='?author_id=".$auth_id."'>".$author."</a><br>";
          }
        }
      }   
    }
    echo "</div>";

    ?></div></div><br>
  </div>
</body>
</html>        
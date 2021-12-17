<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <?php include('set_theme.php'); ?>
  <?php include('../function/hc_header.php'); ?>
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
  <?php include("../function/hc_body.php"); ?>
  <div style="width:90%;position:relative;left:5%;"> 
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='review_suggs.php' style='text-decoration: none;color:black !important'><span class='title_section'>Review User Suggestions</span></a>";
  </script>
  <!-- end of header -->
  
  <?php
  include('mysql_connect.php');  

  $orig_db = $cog_database;
  $sugg_db = "natemsut_cog_sug";

  echo "<form name='register' id='register' action='register.php' method='POST'><center>";

  // search for recorded suggestions
  $sql = "SELECT * FROM $sugg_db.user_suggestions;";
  $result = $cog_conn->query($sql);
  if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
      $username = $row['username'];
      //<tr><td>Entry:</td><td>".$row['id']."</td></tr>";
      $tbl = $row['table'];
      $id = $row['entry_id'];

      // get columns
      $all_cols = [];
      $sql_cols = "SHOW COLUMNS FROM $sugg_db.$tbl";
      $result_cols = $cog_conn->query($sql_cols);
      if ($result_cols->num_rows > 0) { 
        while($row_rslt = $result_cols->fetch_assoc()) { 
          array_push($all_cols, $row_rslt['Field']);
        }
      }

      // get sugg entries
      $sugg_entry = [];
      $sql2 = "SELECT * FROM $sugg_db.$tbl WHERE id=$id;";
      $result2 = $cog_conn->query($sql2);
      if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        foreach ($all_cols as $col_name) {
          $col_entry_data = "[blank]";
          if ($row2[$col_name] != '') {
            $col_entry_data = $row2[$col_name];
            array_push($sugg_entry, $col_entry_data);
          }
          //echo "<tr><td>$col_name</td><td>".$col_entry_data."</td><tr>";
          //echo $col_name;
        }
      }
      // get orig entries
      $orig_entry = [];
      $sql2 = "SELECT * FROM $orig_db.$tbl WHERE id=$id;";
      $result2 = $cog_conn->query($sql2);
      if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        foreach ($all_cols as $col_name) {
          $col_entry_data = "[blank]";
          if ($row2[$col_name] != '') {
            $col_entry_data = $row2[$col_name];
            array_push($orig_entry, $col_entry_data);
          }
        }
      }

      // display differences
      // search for sugg
      $diff_found = False;      
      for ($i = 0; $i < count($sugg_entry);$i++) {
        if ($sugg_entry[$i] != $orig_entry[$i]) {
          $diff_found = True;
        }
      }      
      if ($diff_found) {
          echo "<div class='article_details' style='padding: .4rem;font-size:.7em;'><br>";
          echo "Suggested entry:";
          echo "<table style='padding: .4rem;font-size:.9em;'>";
      }
      $article_id = '';
      for ($i = 0; $i < count($sugg_entry);$i++) {
        if ($sugg_entry[$i] != $orig_entry[$i]) {
          //echo "<tr><td>User suggestion from:</td><td>$username</td></tr>";
          if ($tbl == 'article_has_subject') {
            //echo "<tr><td>Tbl:</td><td>$tbl</td></tr>";
            $current_col = $all_cols[$i];
            $current_val = $sugg_entry[$i];
            if ($current_col == 'article_id') {
              $sql = "SELECT title FROM $sugg_db.articles WHERE id=$current_val;";
              $result = $cog_conn->query($sql);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr><td>Article Name:</td><td>".$row['title']."</td></tr>";
                echo "<tr><td>Article Link:</td><td><a href='/cognome/php/cognome/browse.php?art_id=$current_val' target='_blank'>link</a></td></tr>";                
              }
            }
            else if ($current_col == 'subject_id') {
              $sql = "SELECT subject FROM $sugg_db.subjects WHERE id=$current_val;";
              $result = $cog_conn->query($sql);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr><td>Subject Added:</td><td>".$row['subject']."</td></tr>";
              }
            }  
          }
        }
      }
      if ($diff_found) {
        echo "<tr><td><br></td></tr></table></div><br>";
      }
      // search for orig
      $diff_found_orig = False;
      for ($i = 0; $i < count($sugg_entry);$i++) {
        if ($sugg_entry[$i] != $orig_entry[$i] && $orig_entry[$i] != '') {
          $diff_found_orig = True;
        }
      }
      if ($diff_found_orig) {
        echo "<div class='article_details' style='padding: .4rem;font-size:.7em;'><br>";
        echo "Original entry:";
        echo "<table style='padding: .4rem;font-size:.9em;'>";    
      }   
      for ($i = 0; $i < count($sugg_entry);$i++) {
        if ($sugg_entry[$i] != $orig_entry[$i] && $orig_entry[$i] != '') {
            echo "<tr><td>Original entry:</td></tr>";
            $orig_entry_data = '[no entry]';
            if ($orig_entry[$i] != '') {
              $orig_entry_data = $orig_entry[$i];
            }
            echo "<tr><td>".$all_cols[$i]."</td><td>".$orig_entry_data."</td></tr>";
            echo "<tr><td><br></td></tr>";
            if ($all_cols[$i] == 'article_id') {
              $article_id = $all_cols[$i];
            }
            else if ($all_cols[$i] != 'id') {
              $object_id = $all_cols[$i];
            }
        }
      }
      if ($diff_found_orig) {
        echo "<tr><td><br></td></tr></table></div><br>";
      }
    }
  }
  echo "</center></form><br>";   

  $cog_conn->close();

  ?>
</div>
</body>
</html>  
<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
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
  <?php include('function/hc_body.php'); ?>
  <div style="width:90%;position:relative;left:5%;"> 
  <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
    <script type='text/javascript'>
      document.getElementById('header_title').innerHTML="<a href='search_methods.php' style='text-decoration: none;color:black !important'><span class='title_section'>Search Methods</span></a>";
    </script>
    <!-- end of header -->

    <?php
    include('mysql_connect.php'); 

    echo "<div class='article_details'>
    <center><u>Methods Used to Search for Articles</u></center>
    <br>The following are examples of material from methods used in searches. The descriptions below are non-exaustive. The content here is planned to be expanded to a significant extent once a second phase of searching commences, which is planned to start in August 2020. Systematic patterns of search terms for each subject will be described here.
    <br>    
    <br><span class='methods_topic'>Searching for Subjects</span>
    <br>
    <br>Google Scholar:
    <br>(\"cornu ammonis\" OR \"entorhinal cortex\") AND \"spiking neural network\" AND (\"integrate and fire\" OR \"izhikevich\")
    <br>Filter: Since 2009
    <br>(\"declarative memory\") AND \"spiking neural network\" AND (\"integrate and fire\" OR \"izhikevich\")
    <br>(\"pattern completion\") AND \"spiking neural network\" AND (\"integrate and fire\" OR \"izhikevich\") AND (\"hippocamous\" OR \"cornu ammonis\" OR \"entorhinal cortex\") 
    <br>(\"episodic memory\") AND \"spiking neural network\" AND (\"integrate and fire\" OR \"izhikevich\") AND (\"hippocamous\" OR \"cornu ammonis\" OR \"entorhinal cortex\") 
    <br>(\"association memory\") AND \"spiking neural network\"
    <br>(\"hippocamous\" OR \"cornu ammonis\" OR \"entorhinal cortex\") AND (\"python\" OR \"C++\")
    <br>    
    <br><span class='methods_topic'>Review Articles</span>
    <br>
    <br>Citation: Shipston-Sharman, O., Solanka, L., & Nolan, M. F. (2016). Continuous attractor network models of grid cell firing based on excitatory-inhibitory interactions. The Journal of Physiology, 594(22), 6547-6557.
    <br>Url: https://doi.org/10.1113/JP270630
    <br>
    <br><span class='methods_topic'>Searching for Authors</span>
    <br>
    <br>Dr. Mathew Nolan
    <br>Dr. Michael Hasselmo
    <br>Dr. Alessandro Treves
    <br>Dr. Bruce McNaughton
    <br>Dr. Matt Wilson
    <br>Dr. Arne Ekstrom
    <br>Dr. Steve Grossberg
    <br>Dr. Sen Chen
    <br>Dr. Laurenz Wiskott
    <br>
    <br><span class='methods_topic'>Searching Personal Collection of Related Topics</span>
    <br>
    <br>$ grep -iR 'hippo.*computational\|computational.*hippo' ./
    <br>$ grep -iR 'entorhinal.*computational\|computational.*entorhinal' ./
    <br>
    <br><span class='methods_topic'>Using Existing Model Databases</span>
    <br>
    <br>ModelDB Site: https://senselab.med.yale.edu/ModelDB/ModelList.cshtml?id=115946
    <br>
    <br><span class='methods_topic'>Reading About Topics and Trends in Articles to Search for Those Key Terms</span>
    <br>
    <br><span class='methods_topic'>Searching for More Keywords Like \"brian\" or \"nest\"</span>
    <br><br>";

    $cog_conn->close();  

    ?></div></div><br>
  </div>
</body>
</html>            
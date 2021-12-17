<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
</head>
<body>
  <?php include("function/hc_body.php"); ?> 
  <div style="width:90%;position:relative;left:5%;">
  <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML='Inclusion Criteria';
  </script>
  <!-- end of header -->

<div class='article_details' style='min-width:500px;'>
<center><span style='font-size: 1.2em;'>Further Descriptions About Annotation Inclusion Criteria</span></center>
<br>
<center><u>Level of Implementation</u></center>
<br><u>Fully implemented:</u> the research reports having constructed and successfully run a simulation with the model
<br><u>Partially implemented:</u> some approaches, techniques, or formulas are described that can be used in a future model. A model has not been reported to have been run in a simulation.
<br><u>Not implemented:</u> No specific approaches, techniques, or formulas are described for use in a model. A model has not been reported to have been run in a simulation. A general type or category of model has been included in the article’s writing.
<br>
<br><u>All methods available:</u> all information needed to recreate the model is available directly through descriptions included in the article.
<br><u>Some methods available:</u> some methods are included in the articles writing but key elements are missing that are needed for reproduction. Those elements are one of the following: formulas used to represent neurons, biophysical parameters to represent the region under study, formulas used to generate network-level activity of neurons.
<br><u>Not implemented:</u> a significant lack of methods are explicitly described in the literature which would be used to recreate the model described.
<br>
<br>
</div>
<br>
<br>
<br>
<br>
  </div>
</body>
</html>
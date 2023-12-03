<?php
  include ("permission_check.php");
  include ("./GA_analytics/page_views.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Other Useful Links</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0.15in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:.5in .5in .5in .5in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>
</head>

<body>
<a id="top"></a>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
	include ("access_db.php");//Added on Dec 3 2023

?>	
<!-- Main page loading code -->		
<div id="center" style="padding:100px 100px; align:center;">
	<div style="align: center; padding-left:150px;"><h3> Hippocampome is accessed around the world</h3></div>
	<div style="width:100%;">
		<div style="float:left;width=80%;">
			<div id="map" style="position:relative; align:center; width:800px; height:600px; background:#FFF;">
			<iframe src="https://lookerstudio.google.com/embed/reporting/ccc00f1b-8e25-42dd-bd2e-df25bde4f044/page/Kt5fD" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="no" scrolling="no" style="border-width:2px; border-color:#333; background:#FFF; border-style:solid;">
			</iframe>
			</div>
		</div>
		<div style="float:left; width=20%;padding-left:20px;">
			<div style="align: center; padding-top:15px; padding-left:10px; padding-bottom:10px;"> 
				<b>Click on the links below to view detailed statistics</b>
			</div>
			<div id="links" style="padding: 15px; 10px;">
 	    		<ul>
				<li><a href="#neuron">Neuron Statistics</a></li>
				<li><a href="#pageview">Page View Statistics</a></li>
				<li><a href="#subregion">Sub Region Statistics</a></li>
	    		</ul>
			</div>
		</div>
	</div>
</div>
<div style="clear:both"></div>
<!-- Main initial page ends here -->
<?php 
				//<li><a href="#country">Access By Country</a></li>
				//<li><a href="#city">Access By City</a></li>
/*
<!-- When Country is clicked-->
</br></br>
<div id="country" style="padding:100px 100px; align:center;">
	<p style="align: center;">Access By Country  <a href="#top">Back to top</a><p>
	<div id="countryi-inside" style="width: 800px; height: 600px; overflow-x: hidden;overflow-y: auto;position: relative; outline: none;">
		<iframe width="100%" height="100%" src="https://lookerstudio.google.com/embed/reporting/b42b71e6-d63d-49ac-9bdd-83f6d88473ad/page/1M" allowfullscreen > </iframe>
	</div>
</div>
<!-- Till here -->


<!-- When City is clicked-->
</br></br>
<div id="city" style="padding:100px 100px; align:center;">
	<p style="align: center;">Access By City  <a href="#top">Back to top</a><p>
	<div id="city-inside" style="width: 800px; height: 600px; position: relative; outline: none;">
		<iframe width="100%" height="100%" src="https://lookerstudio.google.com/embed/reporting/49789e8a-dda3-4f56-a8bd-c91dceaef5c2/page/mt5fD" allowfullscreen > </iframe>
	</div>
</div>
<!-- Till here -->
*/
?>

<!-- When Neuron Statistics is clicked-->
</br></br>
<div id="neuron" style="padding:100px 100px; align:center;">
	<p style="align: center;">Neuron Statistics  <a href="#top">Back to top</a><p>
	<div id="neuron-inside" style="width: 950px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php echo get_neurons_views_report($conn); //Passing $conn on Dec 3 2023 ?>
	</div>
</div>
<!-- Till here -->

<!-- When Page View Statistics is clicked-->
</br></br>
<div id="pageview" style="padding:100px 100px; align:center;">
	<p style="align: center;">Page View Statistics  <a href="#top">Back to top</a><p>
	<div id="pageview-inside" style="width: 800px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php echo get_pages_views_report($conn); //Passing $conn on Dec 3 2023 ?>	
	</div>
</div>
<!-- Till here -->

<!-- When Sub Regions Statistics is clicked-->
</br></br>
<div id="subregion" style="padding:100px 100px; align:center;">
	<p style="align: center;">Sub Region Statistics  <a href="#top">Back to top</a><p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php echo get_subregion_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

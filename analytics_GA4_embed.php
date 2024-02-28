<?php
 
  include ("permission_check.php");
  include ("./GA_analytics/page_views.php");
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["download_csv"])) {
	if(isset($_POST["param"])){
		download_csvfile($_POST['download_csv'], $conn, $_POST['param']);
	}else{
		download_csvfile($_POST['download_csv'], $conn);
	}
	exit();
  }
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
<style>
table, th, td {
  border: 1px solid black;
}

tr:nth-child(even){
  background-color: #98AFC7;
}

.blue-bg {   background: #98AFC7; }
.white-bg { backgrou: #ffffff; }
.green-bg {  background: #A2D7A7; }
.lightgreen-bg { background: #E2F1E3; }

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
	<font class="font3">
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
				<li><a href="#neuron">Neuron Type Statistics</a></li>
				<li><a href="#property_counts">Neuron Type Census Statistics</a></li>
				<li><a href="#firingpattern">Firing Pattern Statistics</a></li>
				<li><a href="#markersproperty">Markers Property Statistics</a></li>
				<li><a href="#morphologyproperty">Morphology Property Statistics</a></li>
				<li><a href="#pmid_isbn_property">Morphology Linking pmid isbn Property Statistics</a></li>
				<li><a href="#phases_counts">Phases Statistics</a></li>
				<li><a href="#synpro_counts">Synpro Statistics</a></li>
				<li><a href="#synpro_nm_counts">Synpro NM Statistics</a></li>
				<li><a href="#property_functionality">Functionality Property Domain Page Statistics</a></li>
				<li><a href="#page_functionality">Functionality Domain Page Statistics</a></li>
				<li><a href="#pageviews">Views per Page Statistics </a></li>
				<li><a href="#pageview_monthly">Page Views Per Month Statistics</a></li>
	    		</ul>
			</div>
		</div>
	</div>
	</font>
</div>
<div style="clear:both"></div>
<!-- Main initial page ends here -->
<font class="font3">
<!-- When Neuron Type Statistics is clicked-->
</br></br>
<div id="neuron" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
		<span style="display: inline-block; vertical-align: middle;">Neuron Type Statistics <a href="#top">Back to top</a></span>
		<span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_neurons_views_report"><button type="submit">Download CSV</button></form>
		</span>
	</div></p>
	<div id="neuron-inside" style="width: 950px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_neurons_views_report($conn); //Passing $conn on Dec 3 2023 ?>
	</div>
</div>
<!-- Till here -->

<!-- When Property Counts Statistics is clicked-->
</br></br>
<div id="property_counts" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Neuron Type Census Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="counts"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_counts_views_report($conn, 'counts'); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Firing Pattern Statistics is clicked-->
</br></br>
<div id="firingpattern" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Firing Pattern Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_fp_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_fp_property_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Markers Property Statistics is clicked-->
</br></br>
<div id="markersproperty" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Markers Property Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_markers_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php  get_markers_property_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Morphology Property Statistics is clicked-->
</br></br>
<div id="morphologyproperty" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Morphology Property Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_morphology_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php  get_morphology_property_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Morphology Linking pmid isbn Property Statistics is clicked-->
</br></br>
<div id="pmid_isbn_property" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Morphology Linking pmid isbn Property Statistics  <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_pmid_isbn_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php  get_pmid_isbn_property_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Phase Counts Statistics is clicked-->
</br></br>
<div id="phases_counts" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Phase Statistics  <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="phases"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_counts_views_report($conn, 'phases'); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Synpro Count Statistics is clicked-->
</br></br>
<div id="synpro_counts" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Synpro Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="synpro"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_counts_views_report($conn, 'synpro'); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Synpro NM Counts Statistics is clicked-->
</br></br>
<div id="synpro_nm_counts" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Synpro NM Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="synpro_nm"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_counts_views_report($conn, 'synpro_nm'); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Property Domain Functionality  Statistics is clicked-->
</br></br>
<div id="property_functionality" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Functionality Property Domain Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_domain_functionality_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_domain_functionality_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Property Domain Functionality  Statistics is clicked-->
</br></br>
<div id="page_functionality" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Functionality Domain Page Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_page_functionality_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1000px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_page_functionality_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Views per Page Statistics is clicked-->
</br></br>
<div id="pageviews" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Views per Page Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_views_per_page_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="pageview-inside" style="width: 800px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_views_per_page_report($conn); //Passing $conn on Dec 3 2023 ?>	
	</div>
</div>
<!-- Till here -->

<!-- When Page View Monthly Statistics is clicked-->
</br></br>
<div id="pageview_monthly" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Page Views Per Month Statistics <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_pages_views_per_month_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="pageview-inside" style="width: 800px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_pages_views_per_month_report($conn); //Passing $conn on Dec 3 2023 ?>	
	</div>
</div>
<!-- Till here -->
</font>

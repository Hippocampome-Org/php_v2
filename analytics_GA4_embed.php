<?php
 
  include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/permission_check.php");
  include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/GA_Analytics/page_views.php");
  $neuron_ids = NULL;
 // $neuron_ids = get_neuron_ids($conn);  
  if ($_SERVER["REQUEST_METHOD"] === "POST" && ( isset($_POST["download_csv"]) || isset($_POST["views_per_month"]) || isset($_POST["views_per_year"]) ) ) {
	$views_request ="download_csv";
	if(isset($_POST["views_per_month"])){
		$_POST['download_csv'] = $_POST["views_per_month"];
		$views_request = "views_per_month";
	}
	if(isset($_POST["views_per_year"])){
		$_POST['download_csv'] = $_POST["views_per_year"];
		$views_request = "views_per_year";
	}
	if(isset($_POST["param"])){
		download_csvfile($_POST['download_csv'], $conn, $views_request, $neuron_ids, $_POST['param']);
	}else{
		download_csvfile($_POST['download_csv'], $conn, $views_request, $neuron_ids);
	}
	exit();
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Google Analytics Data Reports</title>
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
table {
 width: 100%;
 table-layout: auto;
}
table, th, td {
  border: 1px solid black;
}

tr:nth-child(even){
  background-color: #98AFC7;
}

.blue-bg {   background: #98AFC7; }
.white-bg { background: #ffffff; }
.green-bg {  background: #A2D7A7; }
.lightgreen-bg { background: #E2F1E3; }

</style>
</head>

<body>
<a id="top"></a>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/function/title.php");
	include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/function/menu_main.php");
	include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/access_db.php");//Added on Dec 3 2023
//	include ("/Applications/XAMPP/xamppfiles/htdocs/hippocampome/php_v2/GA_Analycis/index.php");//Added on Dec 3 2023

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
				<li><a href="#neuron">Neuron Type Evidence Page Views</a></li>
				<li><a href="#morphologyproperty">Morphology Property Views</a></li>
				<li><a href="#markersproperty">Markers Property Views</a></li>
				<li><a href="#biophysics">Membrane Biophysics Evidence Page Views<a></li>
				<li><a href="#firingpattern">Firing Pattern Page Views</a></li>
				<li><a href="#pmid_isbn_property">Morphology Linking PMID ISBN Property Views</a></li>
                                <li><a href="#phases_counts">In Vivo Evidence Page Views</a></li>
                                <li><a href="#connectivity_counts">Connectivity Page Views</a></li>
				<li><a href="#property_functionality">Functionality Property Domain Page Views</a></li>
                                <li><a href="#page_functionality">Functionality Domain Page Views</a></li>
				<li><a href="#pageviews">Views per Page </a></li>
				<li><a href="#pageview_monthly">Monthly Page Views</a></li>
	    		</ul>
			</div>
		</div>
	</div>
	</font>
</div>
<div style="clear:both"></div>
<!-- Main initial page ends here -->
<font class="font3">
<!-- When Neuron Type Views is clicked-->
</br></br>
<div id="neuron" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
		<span style="display: inline-block; vertical-align: middle;">Neuron Type Evidence Page Views <a href="#top">Back to top</a></span>
		<span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_neurons_views_report"><button type="submit">Download CSV</button></form>
			<form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_neurons_views_report"><button type="submit">Download Views Per Month CSV</button></form>
			<form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_neurons_views_report"><button type="submit">Download Views Per Year CSV</button></form>
		</span>
	</div></p>
	<div id="neuron-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_neurons_views_report($conn, $neuron_ids); //Passing $conn on Dec 3 2023 ?>
	</div>
</div>
<!-- Till here -->

<!-- When Morphology Property Views is clicked-->
</br></br>
<div id="morphologyproperty" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Morphology / Axonal and Dendritic Lengths / Somatic Distances Evidence Page Views <a href="#top">Back to top</a></span>
		<span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_morphology_property_views_report"><button type="submit">Download CSV</button></form>
			<form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_morphology_property_views_report"><button type="submit">Download Views Per Month CSV</button></form>
			<form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_morphology_property_views_report"><button type="submit">Download Views Per Year CSV</button></form>
		</span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_morphology_property_views_report($conn, $neuron_ids); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Markers Evidence Page Views is clicked-->
</br></br>
<div id="markersproperty" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Markers Evidence Page Views <a href="#top">Back to top</a></span>
		 <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_markers_property_views_report"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_markers_property_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_markers_property_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php  get_markers_property_views_report($conn, $neuron_ids); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When In Membrane Biophysics Evidence Page Views is clicked-->
</br></br>
<div id="biophysics" style="padding:100px 100px; align:center;">
        <p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Membrane Biophysics Evidence Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="biophysics"><button type="submit">Download CSV</button></form>
			<form method="POST" style="display: inline;"><input type="hidden" name="param" value="biophysics"><input type="hidden" name="views_per_month" value="get_counts_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="param" value="biophysics"><input type="hidden" name="views_per_year" value="get_counts_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
        <div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
                <?php get_counts_views_report($conn, 'biophysics', $neuron_ids); //Passing $conn on Dec 3 2023 ?>
        </div>
</div>
<!-- Till here --

<!-- When Firing Pattern Page Views is clicked-->
</br></br>
<div id="firingpattern" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Firing Pattern Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_fp_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_fp_property_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Morphology Linking PMID ISBN Property Page Views is clicked-->
</br></br>
<div id="pmid_isbn_property" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Morphology Linking PMID ISBN Property Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_pmid_isbn_property_views_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php  get_pmid_isbn_property_views_report($conn, $neuron_ids); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When In Vivo Evidence Page Views is clicked-->
</br></br>
<div id="phases_counts" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">In Vivo Evidence Page Views <a href="#top">Back to top</a></span>
		<span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="phases"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="param" value="phases"><input type="hidden" name="views_per_month" value="get_counts_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="param" value="phases"><input type="hidden" name="views_per_year" value="get_counts_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>   
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_counts_views_report($conn, 'phases', $neuron_ids); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->


<!-- When Connectivity Page Views is clicked-->
</br></br>
<div id="connectivity_counts" style="padding:100px 100px; align:center;">
        <p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Connectivity Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_counts_views_report"><input type="hidden" name="param" value="connectivity"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_counts_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_counts_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
        <div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
                <?php get_counts_views_report($conn, 'connectivity', $neuron_ids); //Passing $conn on Dec 3 2023 ?>
        </div>
</div>
<!-- Till here -->

<!-- When Functionality Property Domain Page Views is clicked-->
</br></br>
<div id="property_functionality" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Functionality Property Domain Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_domain_functionality_views_report"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_domain_functionality_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_domain_functionality_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_domain_functionality_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Functionality Domain Page Views is clicked-->
</br></br>
<div id="page_functionality" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Functionality Domain Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_page_functionality_views_report"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_page_functionality_views_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_page_functionality_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
	<div id="subregion-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_page_functionality_views_report($conn); //Passing $conn on Dec 3 2023 ?> 
	</div>
</div>
<!-- Till here -->

<!-- When Views per Page is clicked-->
</br></br>
<div id="pageviews" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Views Per Page <a href="#top">Back to top</a></span>
		 <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_views_per_page_report"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_views_per_page_report"><button type="submit">Download Views Per Month CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_views_per_page_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>
        </div></p>
	<div id="pageview-inside" style="width: 1150px; height: 600px; overflow-x: scroll;overflow-y: scroll; position: relative; outline: none;">
		<?php get_views_per_page_report($conn); //Passing $conn on Dec 3 2023 ?>	
	</div>
</div>
<!-- Till here -->

<!-- When Monthly Page Views is clicked-->
</br></br>
<div id="pageview_monthly" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Monthly Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
			<form method="POST"><input type="hidden" name="download_csv" value="get_pages_views_per_month_report"><button type="submit">Download CSV</button></form>
                </span>
        </div></p>
	<div id="pageview-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
		<?php get_pages_views_per_month_report($conn); //Passing $conn on Dec 3 2023 ?>	
	</div>
</div>
<!-- Till here -->
</font>

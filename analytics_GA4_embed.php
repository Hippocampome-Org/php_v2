<?php
 
  include ("permission_check.php");
  include ("./GA_analytics/page_views.php");
  $neuron_ids = get_neuron_ids($conn);  
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
<?php include_once("analytics.php") ?>
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
	include ("function/title.php");
	include ("function/menu_main.php");
	include ("access_db.php");//Added on Dec 3 2023

?>	
<!-- Main page loading code -->		
<div id="center" style="padding:100px 100px; align:center;">
	<font class="font3">
	<div style="width:100%;">
		<div style="float:left; width=100%;padding-left:20px;">
			<div style="align: center; padding-top:15px; padding-left:10px; padding-bottom:10px;"> 
				<b>Click on the links below to view detailed statistics</b>
			</div>
			<div id="links" style="padding: 15px; 10px;">
 	    		<ul>
                                <li><a href="#page_functionality">Functionality Domain Page Views</a></li>
				<li><a href="#browse_functionality">Browse Menu Page Views</a></li>
				<li><a href="#neuron_types">Neuron Type Page Views</a></li>
				<li><a href="#neuron_type_evidence">Neuron Type Evidence Page Views</a></li>
				<li><a href="#pageview_monthly">Monthly Page Views</a></li>
				<li><a href="#pageviews">Views per Page </a></li>
				<li><a href="#download_reports">Download Views Reports</a></li>
				<li><a href="GA_detailed_views.php">Detailed Access Views</a></li>

	    		</ul>
			</div>
		</div>
	</div>
	</font>
</div>
<div style="clear:both"></div>
<!-- Main initial page ends here -->
<font class="font3">
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

<!-- When Functionality Property Domain Page Views is clicked-->
</br></br>
<div id="browse_functionality" style="padding:100px 100px; align:center;">
	<p><div style="text-align: left;">
                <span style="display: inline-block; vertical-align: middle;">Browse Menu Page Views <a href="#top">Back to top</a></span>
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

<!-- When Neuron Type Views is clicked-->
</br></br>                              
<div id="neuron_types" style="padding:100px 100px; align:center;">
        <p><div style="text-align: left;"> 
                <span style="display: inline-block; vertical-align: middle;">Neuron Type Page Views <a href="#top">Back to top</a></span>
                <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
                        <form method="POST" style="display: inline;"><input type="hidden" name="download_csv" value="get_neuron_types_views_report"><button type="submit">Download CSV</button></form>
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_month" value="get_neuron_types_views_report"><button type="submit">Download Views Per Month CSV</button></form>                                    
                        <form method="POST" style="display: inline;"><input type="hidden" name="views_per_year" value="get_neuron_types_views_report"><button type="submit">Download Views Per Year CSV</button></form>
                </span>                 
        </div></p>                      
        <div id="neuron-inside" style="width: 1150px; height: 600px; overflow-x: auto;overflow-y: scroll; position: relative; outline: none;">
                <?php get_neuron_types_views_report($conn, $neuron_ids); //Passing $conn on Dec 3 2023 ?> 
        </div>                                      
</div>                                              
<!-- Till here -->   

<!-- When Neuron Type Views is clicked-->
</br></br>
<div id="neuron_type_evidence" style="padding:100px 100px; align:center;">
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

<!-- To Download all the data -->
</br></br>
<div id="download_reports" style="padding:100px 100px; text-align:center;">
    <p>                 
        <div style="text-align: left;">
	<span style="display: inline-block; vertical-align: middle;"><a href="#top">Back to top</a></span>
            <span style="display: inline-block; padding-left:10px; vertical-align: middle;">
	    	<form method="POST" action="" style="display: inline;">
	    		<input type="hidden" name="download_csv" value="download_reports">
			<input type="hidden" name="param" value="analytics">
	    		<button type="submit">Download Views Reports</button>
	    	</form>
            </span>         
        </div>  
    </p>
</div>

<!-- Till here -->
</font>

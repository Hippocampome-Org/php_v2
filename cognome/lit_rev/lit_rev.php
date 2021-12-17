<html>
<!-- 
	References: https://gist.github.com/hlashbrooke/ee208fb8be43d23da5a9
-->
<head>
	<title>Browse literature results</title>
	<style>
		.button_link {
			height:19px;
			width:28px;
			border:1px solid black;
			padding:4px;
			font-size:13px;
			font-family:arial;
			text-decoration: none;
			position:relative;
			top:-3px;
		}
		.button_link a { 
			text-decoration: none; 
		}
		textarea.custom_page {
		    white-space: normal;
		    text-align: center;
		    -moz-text-align-last: center; /* Firefox 12+ */
		    text-align-last: center;
		    height:24px;
		    width:38px;
		    position:relative;
		    top:5px;
		    resize:none;
		    font-size:12pt;
		}
	</style>
	<link rel='stylesheet' type='text/css' href='medium_dark_colors.css'> 
	<!--link rel='stylesheet' type='text/css' href='light_white_bg_colors.css'--> 
</head>
<body>
<?php
$base_dir = "query_results/final_selection/";
$filename = "";
$queryfile = "";
if (isset($_REQUEST['file']) && isset($_REQUEST['query'])) {
	$file=$_REQUEST['file'];
	$filename = $base_dir.$file;	
	$query=$_REQUEST['query'];
	$queryfile = $base_dir.$query;
}
else {
	echo "<br><center>Error: please specify variables for an articles file and query file.<br><br><a href='lit_rev.php?file=query_results_gs5.csv&query=gs5_query.txt'>Gs5</a>&nbsp;&nbsp;&nbsp;<a href='lit_rev.php?file=query_results_gs26.csv&query=gs26_query.txt'>Gs26</a>&nbsp;&nbsp;&nbsp;<a href='lit_rev.php?file=query_results_pm30.csv&query=pm30_query.txt'>Pm30</a>&nbsp;&nbsp;&nbsp;<a href='lit_rev.php?file=query_results_pm34.csv&query=pm34_query.txt'>Pm34</a>&nbsp;&nbsp;&nbsp;<a href='lit_rev.php?file=query_results_pm35.csv&query=pm35_query.txt'>Pm35</a>&nbsp;&nbsp;&nbsp;<a href='lit_rev.php?file=query_results_allcomb.csv&query=gs5_query.txt'>AllComb</a></center>";
}

echo '<br><center><font style="font-size:22px">'.file_get_contents($queryfile).'</font></center><br>';

	$start = 1;
	$end = 10;
	if (isset($_REQUEST['start'])) {
		if ($_REQUEST['start'] >= 0) {
			$start = $_REQUEST['start'];
		}
	}
	if (isset($_REQUEST['end'])) {
		if ($_REQUEST['end'] >= 0) {
			$end = $_REQUEST['end'];
		}
	}
	if (isset($_REQUEST['custom_page'])) {
		$custom_page = $_REQUEST['custom_page'];
		$start = ($custom_page*10)-9;
		$end = $custom_page*10;
	}
	else {
		$custom_page = round(($end/980)*100);
	}
	$prev_start = $start - 10;
  	$prev_end = $end - 10;
	$next_start = $start + 10;
  	$next_end = $end + 10;  	
  	echo "<center>Page ".round(($end/980)*100)." of 98. Showing articles with ids $start to $end.</center>";
	echo "<form action='lit_rev.php'><center><a href='?start=$prev_start&end=$prev_end&file=$file&query=$query' style='text-decoration:none;'><span class='button_link'>Prev</span></a>&nbsp;Page <textarea name='custom_page' id='custom_page' class='custom_page'>$custom_page</textarea> <input type='submit' value='Go' style='height:25px;width:36px;position:relative;top:-3px;' />&nbsp;<a href='?start=$next_start&end=$next_end&file=$file&query=$query' style='text-decoration:none;'><span class='button_link'>Next</span></a></center>";
	if (isset($prev_start) && isset($prev_end) && isset($file) && isset($query)) {
		echo "<input type=\"hidden\" name=\"file\" value=\"$file\" />";
		echo "<input type=\"hidden\" name=\"query\" value=\"$query\" />";
	}
	echo "</form>";

function char_replace($find, $replace, $str)
{
	$newstr = "";
	$strlen = strlen($str);
	for( $i = 0; $i <= $strlen; $i++ ) {
    	$char = substr($str, $i, 1);
    	if ($char == $find) {
    		$char == $replace;
    	}
    	$newstr = $newstr.$char;
	}

	return $newstr;
}

function msleep($time)
{
    usleep($time * 1000000);
}

function article_info($title, $gs_authors)
{
	// insert html code
	$title_adj=str_replace(' ', '%20', $title);

	$pm_api_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&retmode=json&term=$title_adj%5Btitle%5D";
	// gs authors //
	foreach ($gs_authors as $author) {
		$author = str_replace(',', '', $author);
		if (strlen($author) > 3) {
			$pm_api_url = $pm_api_url."%20".$author."%20%5Bauthor%5D";
		}
	}
	$html=file_get_contents($pm_api_url);

	// id //
	$pattern='~.*idlist\"\:\[\"(\d+)\"\].*~';
	$result = preg_match($pattern, $html, $match);
	$id = $match[1];

	// abstract //
	$pm_url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&id='.$id.'retmode=json&rettype=abstract';
	$pubmed_html=file_get_contents($pm_url);
	$pattern='~.*AbstractText>(.+)\<.*~';
	$result = preg_match($pattern, $pubmed_html, $match);
	$abstract = $match[1];

	// authors //
	$authors='';
    $lastname_pattern='~.*LastName>(.+)\<.*~';
    $firstinitials_pattern='~.*Initials>(.+)\<.*~';
    $lastname_result = preg_match_all($lastname_pattern, $pubmed_html, $match_1,PREG_PATTERN_ORDER);
    $firstinitials_result = preg_match_all($firstinitials_pattern, $pubmed_html, $match_2,PREG_PATTERN_ORDER);
    for( $i = 0; $i<sizeof($match_1[0]); $i++ ) {
      $authors=$authors.$match_1[1][$i].', '.$match_2[1][$i].'., ';
    }

    // title //
	$pattern='~.*ArticleTitle\>(.+)\<.*~';
	$result = preg_match($pattern, $pubmed_html, $match);
	$pm_title = $match[1];
	$pm_title = str_replace('"', '\'', $pm_title);

	// year //
	$pattern='~.*PubDate\W+Year\>(.+)\<.*~';
	$result = preg_match($pattern, $pubmed_html, $match);
	$year = $match[1];

	// journal //
	$pattern='~.*JournalIssue\W+Title>(.+)\<.*~';
	$result = preg_match($pattern, $pubmed_html, $match);
	$journal = $match[1];
	
	return array($id, $abstract, $pm_title, $pm_api_url, $authors, $year, $journal, $pm_url);
}
// Open the file for reading
$i = 0;
$search_results = "";
if (($h = fopen($filename, "r")) !== FALSE) 
{
  $search_results = $search_results."<table border=1>";
  // Convert each line into the local $data variable
  while (($data = fgetcsv($h, 10000, ",")) !== FALSE) 
  {		
  	if ($i >= $start && $i <= $end) {
  		$title = $data[2];
  		//$url = $data[6];
  		$url_orig = "https://scholar.google.com/scholar?q=".$title."&hl=en";
  		$url = str_replace(" ", "+", $url_orig);

  		$search_results = $search_results."<tr><td style='width:50px;overflow-wrap: anywhere;'>GS #$i<br>Citations</td><td style='width:20px;overflow-wrap: anywhere;'>GS<br>Citations by Year</td><td>Title,&nbsp;&nbsp;Sources: ".$data[24]."</td><td style='width:20px;overflow-wrap: anywhere;'>GS<br>Year</td><td style='width:50px;overflow-wrap: anywhere;'>GS<br>Journal</td></tr>";
	    // Read the data from a single line
	    $search_results = $search_results."<tr><td style='width:20px;overflow-wrap: anywhere;'>".$data[0]."</td><td style='width:20px;overflow-wrap: anywhere;'>".number_format($data[19], 2)."</td><td><font class='abstract_text2'>".$title."</font></td><td style='width:20px;overflow-wrap: anywhere;'>".$data[3]."</td><td style='width:50px;overflow-wrap: anywhere;'>".$data[4]."<br><br>".$data[1]."</td></tr>";
	    //$search_results = $search_results."<tr><td style='width:20px;overflow-wrap: anywhere;'>".$data[0]."</td><td style='width:20px;overflow-wrap: anywhere;'>".number_format($data[19], 2)."</td><td></td><td><font class='abstract_text2'>".$title."</font></td><td>".$data[3]."</td><td></td></tr>";

		$search_results = $search_results."<tr><td>PM<br>ID</td><td>PM<br>Link</td><td>PM<br>Abstract and Title</td><td>PM<br>Year</td><td style='width:50px;overflow-wrap: anywhere;'>PM<br>Journal</td></tr>";

		$gs_authors = str_replace(',', '', $gs_authors);
		$gs_authors = explode(" ", $data[1]);
	    $article_details = article_info($title, $gs_authors);
	    $pm_id = $article_details[0];
	    if ($pm_id=='') {
	    	$pm_id = 'N/A';
	    }
	    $pm_abstract = $article_details[1];
	    if ($pm_abstract=='') {
	    	$pm_abstract = $data[23]."<br>";
	    	//if (strlen(file_get_contents($url))>100) {
	    	$article_url = str_replace(" ", "+", $title);
	    	$pm_abstract = $pm_abstract."<object data=\"article_page.php?article_url=".$article_url."\" style=\"width:100%;height:500px\"><embed src=\"article_page.php?article_url=".$article_url."\" style=\"width:100%;height:500px\"> </embed>Error: Embedded data could not be displayed.</object>";

			//}
	    }	    
	    $pm_title = $article_details[2];
	    if ($pm_title=='') {
	    	//$pm_title = 'N/A';
	    }
	    $pm_api_url = $article_details[3];
	    $pm_authors = $article_details[4];
	    if ($pm_authors=='') {
	    	$pm_authors = 'N/A';
	    }
	    $pm_year = $article_details[5];
	    if ($pm_year=='') {
	    	$pm_year = 'N/A';
	    }
	    $pm_journal = $article_details[6];
	    if ($pm_journal=='') {
	    	$pm_journal = 'N/A';
	    }
	    $pm_url = $article_details[7];

	    if (substr($url, 0, 24)=='https://books.google.com') {
	    	// format query for book search
	    	$query_html = file_get_contents($queryfile);
	    	$query_html2 = str_replace('Query: ', '', $query_html);
	    	$query_html3 = str_replace(" ", "+", $query_html2);
	    	//$query_html4 = str_replace("AND", "", $query_html3);
	    	//$query_html4 = str_replace("AND", "", $query_html3);
	    	$search_phrase = '&q='.$query_html3;//.'&f=false';
	    	$url = $url.$search_phrase;
	    }
	    $search_results = $search_results."<tr><td><center>$i</center></td><td><a href='".$url."' target='_blank'>gs article link</a><br><br><a href='$pm_api_url' target='_blank'>pm api query link</a><br><br><a href='$pm_url' target='_blank'>pm query link</a><br><br><a href='https://pubmed.ncbi.nlm.nih.gov/$pm_id/' target='_blank'>pm link</a></td><td>";
	    //$search_results = $search_results."<tr><td><center>$i</center></td><td><a href='".$url."' target='_blank'>gs article link</a><br><br><a href='$pm_api_url' target='_blank'>pm api query link</a><br><br><a href='$pm_url' target='_blank'>pm query link</a><br><br><a href='https://pubmed.ncbi.nlm.nih.gov/$pm_id/' target='_blank'>pm link</a></td><td></td><td>";
	    if ($pm_title != '') {
	    	$search_results = $search_results."$pm_title<br><br>";
			$search_results = $search_results."<font class='abstract_text'>";
		}
		else {
			$search_results = $search_results."<font class='abstract_text2'>";	
		}
	    $search_results = $search_results."$pm_abstract</font></td><td>$pm_year</td><td style='width:20px;overflow-wrap: anywhere;'>$pm_journal<br><br>$pm_authors</td></tr>";
	    //$search_results = $search_results."$pm_abstract</font></td><td>$pm_year</td><td></td></tr>";

	    //msleep(.1);
	    msleep(.2);
	}
	$i++;
  }
  $search_results = $search_results."</table>";
  echo $search_results;

  // Close the file
  fclose($h);
	$prev_start = $start - 10;
  	$prev_end = $end - 10;
	$next_start = $start + 10;
  	$next_end = $end + 10;  	
  	echo "<center>Page ".round(($end/980)*100)." of 98. Showing articles with ids $start to $end.</center>";
	echo "<form action='lit_rev.php'><center><a href='?start=$prev_start&end=$prev_end&file=$file&query=$query' style='text-decoration:none;'><span class='button_link'>Prev</span></a>&nbsp;Page <textarea name='custom_page' id='custom_page' class='custom_page'>$custom_page</textarea> <input type='submit' value='Go' style='height:25px;width:36px;position:relative;top:-3px;' />&nbsp;<a href='?start=$next_start&end=$next_end&file=$file&query=$query' style='text-decoration:none;'><span class='button_link'>Next</span></a></center></form>";
}
?>
</body>
</html>
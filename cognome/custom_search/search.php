<!--
	Usage - import this file and linclude the line:
	  search_directory($dir, $max_matches, $query);
	
	$dir: directory of literature
	$max_matches: max matches per keyword to return
	$query: keyterms

	Reference: http://www.tizag.com/phpT/fileread.php
-->
<head><title>Search</title></head>
<div style='font-family: arial'>
<?php
$tot_mch = 0;
$total_results = array();
global $tot_mch;
global $total_results;

function report_results($results_text, $total_results, $query, $articles_searched) {
	// report overall results
	$results_text = 'Total Article Matches<br><br>';
	for ($i = 0; $i < sizeof($total_results); $i++) {
		$results_text = $results_text.$total_results[$i]." for keyterm \"".trim($query[$i])."\"<br>";
	}
	$results_text = $results_text."<br>".$articles_searched." total articles searched";
	echo "<script>update_overall('".$results_text."')</script>";	

	return $results_text;
}

function search_directory($cog_conn, $dir, $articles_to_search, $max_matches, $query, $range, $snippit_size, $art_text_secret_key, $show_snippits, $cog_database) {
	global $tot_mch;
	global $total_results;
	$articles_searched = 0;
	$articles_processed = 0;
	$collection_results = array();
	$results_text = "";

	$range_search=false;
	if ($range != '') {
		$range_search=true;
		$range_parsed = preg_split("/-/i", $range);
		if (count($range_parsed) == 1) {
			$start_range=$range;
			$end_range=$range;
			echo "Article searched: ".$range."<br><br>";
		}
		else if (count($range_parsed) == 2) {
			$start_range=$range_parsed[0];
			$end_range=$range_parsed[1];
			echo "Range used: ".$start_range." - ".$end_range."<br><br>";
		}
	}

	// describe overall results
	$total_results = array_fill(0, sizeof($query), 0);
	echo "<script>
	function update_overall(update_text) {
		document.getElementById('overall_results_summary').innerHTML = update_text;
	}
	</script>";

	echo "<br><div class='wrap-collabsible' id='art_select'><input id='collapsible_ovrl_rslts' class='toggle' type='checkbox' checked><label for='collapsible_ovrl_rslts' class='lbl-toggle'>Overall Results</label><div class='collapsible-content'><div class='content-inner' style='font-size:22px;height:300px;overflow:auto;' id='overall_results_summary'>";
	echo "Overall results<br>";
	echo "<br>Now loading overall results. Please wait until the search is completed for the results to display here.</div></input></div></div>";

	$articles_list=array();
	// run directory search
	/*if ($handle = opendir($dir)) {
	    while ($file = readdir($handle)) {
	    	if ($file != "." && $file != "..") {
	    		array_push($articles_list,$file);
	    	}
	    }
	}
	closedir($handle);
	sort($articles_list); #, SORT_STRING */

	$sql = "SELECT filename FROM $cog_database.article_text;";
	$result = $cog_conn->query($sql);
	if ($result->num_rows > 0) {       
	  while($row = $result->fetch_assoc()) {  
	  	array_push($articles_list,$row['filename']);
	  }
	}

	/*$s_i = 1;
	foreach($articles_list as $art_print) {
    	echo "sorted articles: #$s_i ".$art_print."<br>";
    	$s_i = $s_i + 1;
	}*/

	for ($i = 0; $i < count($articles_list); $i++) {
    	if ($articles_to_search == "all" || $articles_searched < $articles_to_search) {
			$art_file_id=$articles_processed+1;
			if ($range_search) {
				#echo "stats: ".$art_file_id." ".$start_range." ".$end_range."<br><br>";
				if ($art_file_id >= $start_range && $art_file_id <= $end_range) {
					$results_group = search($cog_conn, $dir.$articles_list[$i], $articles_list[$i], $max_matches, $query, $snippit_size, $art_text_secret_key, $show_snippits, $cog_database);
					$total_results = $results_group[0];
					array_push($collection_results, $results_group[1]);
					$articles_searched++;
				}
			}
			else {
    			$results_group = search($cog_conn, $dir.$articles_list[$i], $articles_list[$i], $max_matches, $query, $snippit_size, $art_text_secret_key, $show_snippits, $cog_database);
    			$total_results = $results_group[0];
    			array_push($collection_results, $results_group[1]);
    			$articles_searched++;
    		}
    		$articles_processed++;
    	}

    	if ($articles_searched < 25 || $articles_searched == 50 || $articles_searched == 100 || $articles_searched == 150 || $articles_searched == 200 || $articles_searched == 250) {
    		$results_text = report_results($results_text, $total_results, $query, $articles_searched);
    	}
	}

	$results_text = report_results($results_text, $total_results, $query, $articles_searched);

	$article_results = array($articles_list, $collection_results);
	return $article_results;
}

function get_article_text($cog_conn, $filename, $art_text_secret_key, $cog_database) {
	$max_text_size = 1000000000;
	$article_text = "";
	$decrypted_column = "SUBSTRING(AES_DECRYPT(article_text,'".$art_text_secret_key."'),1,".$max_text_size.")";

	$sql = "SELECT $decrypted_column FROM $cog_database.article_text WHERE filename = \"$filename\";";
	$result = $cog_conn->query($sql);
	if ($result->num_rows > 0) {       
	  while($row = $result->fetch_assoc()) {  
	  	$article_text = $row[$decrypted_column];
	  }
	}

	return $article_text;
}

function search($cog_conn, $file, $filename, $max_matches, $query, $snippit_size, $art_text_secret_key, $show_snippits, $cog_database) {
	global $tot_mch;
	global $total_results;
	$matches_to_report = array();

	// set file details
	echo "<br><center><font style='font-size:20px;'>";
	if ($show_snippits == true) {
		echo "File: <a href='?fileview=".$file."' target='_blank'>".$filename."</a>";
	}
	else {
		$article_id = ltrim($filename, "0");
		$article_id = str_replace(".txt", "", "$article_id");
		echo "<a href='../browse.php?art_id=$article_id'>File ID: $article_id</a>";		
	}
	echo "</font></center><br>";
	/*echo "<br><center><font style='font-size:20px;'>File: <a href='/general/cognome_articles/".substr($filename, 0, -4)."''>".substr($filename, 0, -4)."</a></font></center><br>";*/
	/*$myFile = $file;
	$fh = fopen($myFile, 'r');
	$file_contents = fread($fh, filesize($myFile));
	fclose($fh);*/
	$file_contents = get_article_text($cog_conn, $filename, $art_text_secret_key, $cog_database);

	$file_contents2 = preg_replace('/\n/', '<br>', $file_contents); // remove newlines

	if ($show_snippits == true) {
		echo "<div class='wrap-collabsible' id='art_select'><input id='collapsible_srch_".$tot_mch."' class='toggle' type='checkbox'><label for='collapsible_srch_".$tot_mch."' class='lbl-toggle'>First lines in the file</label><div class='collapsible-content'><div class='content-inner' style='font-size:18px;'>";
		echo "<div style='background-color:#dedede;padding:20px;'><center><span style='font-size:16px;'>".substr($file_contents2, 0, 400)."</span></center></div><br>";
		echo "</div></input></div></div>";
	}

	$tot_mch++;

	$file_contents = preg_replace('/\n/', ' ', $file_contents); // remove newlines	

	for ($f_i = 0; $f_i < sizeof($query); $f_i++) {
		// set patterns and remove leading or trailing whitespace type of chars
		$pattern_keyterm = trim($query[$f_i]);
		//$pattern = "/(.{1,500}[ -\(]".$pattern_keyterm."[\)s -].{1,500})/i"; // /i is case insensitive
		$pattern = "/(.{1,$snippit_size}[ -\('.,]".$pattern_keyterm."['?.,\)s -].{1,$snippit_size})/i"; // /i is case insensitive
		$num_matches = preg_match_all($pattern, $file_contents, $matches);

		// update totals
		if ($num_matches > 0) {
			$total_results[$f_i]++;
		}

		// Find maximum matches to report
		$match_limit = 0;
		if ($num_matches >= $max_matches) {
			$match_limit = $max_matches;
		}
		else {
			$match_limit = $num_matches;
		}

		if ($num_matches > 0) {
			if ($show_snippits == true) {
		    	echo "<div class='wrap-collabsible' id='art_select'><input id='collapsible_srch_".$tot_mch."' class='toggle' type='checkbox'><label for='collapsible_srch_".$tot_mch."' class='lbl-toggle'>".$num_matches." matches for keyterm: \"".$pattern_keyterm."\"</label><div class='collapsible-content'><div class='content-inner' style='font-size:18px;max-height: 550px;overflow: auto;'>";
		    }
			else {
				echo "<div style='background-color:#dedede;'><span style='font-size:22px;position:relative;left:33px;top:-4px;font-family:arial;'>$num_matches matches for keyterm: \"".$pattern_keyterm."\"";
			}

			if ($show_snippits == true) {
				// Report matches
				for ($i = 0; $i < $match_limit; $i++) {
					$replacement = "<font style='color:blue'>".$pattern_keyterm."</font>";
					$match = preg_replace('/[ (.,-]('.$pattern_keyterm.')[s?.,) -]/i', ' '.$replacement.' ', $matches[0][$i]);
					echo $match."<br><br>";
					$tot_mch++;
				}

				echo "</div></input></div></div>";	
			}
			else {
				echo "</span></div>";		
			}
		}
		else {
			echo "<div style='background-color:#dedede;'><span style='font-size:22px;position:relative;left:33px;top:-4px;font-family:arial;'>0 matches for keyterm: \"".$pattern_keyterm."\"</span></div>";
		}
		array_push($matches_to_report, $num_matches);
	}
	echo "<br>";

	$results_group = array($total_results, $matches_to_report);
	return $results_group;
}
?>

</div>
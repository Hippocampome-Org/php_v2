<html>
<!--
	References: https://www.php.net/manual/en/function.file-put-contents.php
-->
<head>
	<title>Extract citations</title>
</head>
<body>
<?php
$base_dir = "gs_results/";
$query_name = "30";
$base_dir = "gs_results/".$query_name."/";
$output_file = "gs_results/csv_results/".$query_name.".csv";
$files = scandir($base_dir);
$files = array_diff(scandir($base_dir), array('.', '..')); // remove "." and ".."
$output_lines = array();
$files_processed = 0;

$first_line = "Cites,Authors,Title,Year,Source,Publisher,ArticleURL,CitesURL,GSRank,QueryDate,Type,DOI,ISSN,CitationURL,Volume,Issue,StartPage,EndPage,ECC,CitesPerYear,CitesPerAuthor,AuthorCount,Age,Abstract\n";
// clear file
file_put_contents($output_file, '');
file_put_contents($output_file, $first_line);

foreach ($files as $filename) {
	if (($fh = fopen($base_dir.$filename, "r")) !== FALSE) {
		$output_lines = extract_citations($fh, $output_lines);
	}
	$files_processed++;
	fclose($fh);
}

foreach ($output_lines as $lines_to_output) {
	file_put_contents($output_file, $lines_to_output, FILE_APPEND);
}

function extract_citations($fh, $output_lines) {
	$current_year = date("Y");
	$cite_found = false;
	$cite_found_counter = 0;
	$title_lines = [];
	$extra_line_found = false;
	$sort_date_found = false;
	$articles_found = 0;
	$year_line_num = 0;
	$title_line_num = 1;
	// reported vars
	$citations = 0;
	$year = 0;
	$citations_per_year = 0;
	$title = '';
	$title_final = '';
	$authors = '';
	$journal = '';
	$url = '';
	$blank = '';

	while(($line = fgets($fh)) !== false) {
		//$line = fgets($fh);

		preg_match('/Cited by (\d+)/', $line, $cited_by_results);
		if ($cited_by_results[1] != '') {
			//echo "Citations: ".$cited_by_results[1]."\n";
			$cite_found_counter = 0;
			$title_results = [];
			$title_lines = [];
			$year_results = [];
			$cite_found = true;
			$extra_line_found = false;		
			$citations = $cited_by_results[1];
			$cited_by_results = [];
			$title_line_num = 1;
			$citations_per_year = floatval($citations)/floatval(($current_year + 1 - $year));
			// output article
			$output_line = $citations.",".$authors.",\"".trim($title_final)."\",".$year.",".$blank.",".$blank.",".$url.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".$blank.",".number_format($citations_per_year,2).",".$blank.",".$blank.",".$blank.",".$blank."\n";
			array_push($output_lines, $output_line);
			// reset
			$citations = 0;
			$year = 0;
			$citations_per_year = 0;
			$title = '';		
			$title_final = '';
			$authors = '';
			$journal = '';
			$url = '';
		}
		preg_match('/Swissconsortium/', $line, $swissconsort_results);
		if (sizeof($swissconsort_results) > 0) {
			$title_line_num++;
		}
		preg_match('/Sort by date/', $line, $sort_date_results);
		if (sizeof($sort_date_results) > 0) {
			// use "sort by date" to trigger title collection
			// through $cite_found
			$cite_found = true;
		}

		preg_match('/\[\w+\] (.*)/', $line, $title_results);
		if ($title_results[1] != '') {
			array_push($title_lines, $title_results[1]);
		}
		if ($cite_found_counter == $title_line_num && sizeof($title_lines) == 0) {
			$title = $line;
			$year_line_num = 2;
		}
		if ($cite_found_counter == ($title_line_num + 1)) {
			if (sizeof($title_lines) > 1) {
				$title = $title_lines[1];
				$year_line_num = 3;
			}
			else if (sizeof($title_lines) > 0) {
				$title = $line;
				$year_line_num = 3;
			}
		}
		if ($extra_line_found == true) {
			$title = preg_replace('/(\[\w+\] )(.*)/', '$2', $line);
		}			
		preg_match('/Free from Publisher/', $line, $free_pub_results);
		if (sizeof($free_pub_results) > 0) {
			$extra_line_found = true;
			$year_line_num++;
		}
		if ($cite_found_counter == ($title_line_num + 2)) {
			$articles_found++;
			/*if ($title_line_num == 3) {
				$title = preg_replace('/(\[\w+\] )(.*)/', '$2', $line);
				echo $title."<br>";
			}*/
			if ($title != "Previous\n" && $articles_found < 11) {
				//echo $title."\n";
				$title_final = $title;
			}
		}
		if ($year_line_num != 0) {
			if ($cite_found_counter==$year_line_num) {
				preg_match('/.* ([12][09]\d+) .*/', $line, $year_results);
				if ($year_results[1] != '') {
					//echo "Year: ".$year_results[1]."\n";
					$year = $year_results[1];
				}
			}
		}

		if ($cite_found == true) {
			$cite_found_counter++;
		}
  	}

  	return $output_lines;
}
echo "Files processed: ".$files_processed;
?>
</body>
</html>
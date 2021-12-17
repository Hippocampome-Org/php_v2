<html>
<?php
	set_time_limit(0); // prevent processing time timeout.
	include("generate_file_list.php");
	$base_dir = "combined_results";
	//$file_dir = "3";
	//$list_file = $base_dir."/".$file_dir."/filelist.txt";
	$file_list = array();
	$line_num = 0;
	$file_num = 0;
	$progress_counter = 0; // change this to resume progress at a certain point
	$core_sum = 0;
	$high_score = 0;
	$multi_score_thresholds = array(2000,3000,4000,5000,6000,7000,8000,9000,10000);
	$multi_high_scores = array_fill(0, sizeof($multi_score_thresholds), 0);
	$multi_article_totals = array_fill(0, sizeof($multi_score_thresholds), 0);
	$multi_file_numbers = array_fill(0, sizeof($multi_score_thresholds), 0);
	$output_dataset = FALSE;
	//$output_filepath = "combined_results/combined/combined_".$file_dir.".csv";
	$output_filename = "latest_high_score_17.csv";
	$output_filepath = "combined_results/combined/".$output_filename;
	$core_articles_path = "core_collection_articles.csv";
	$core_articles = array();
	$output_lines = array();
	$gs_files = array(1,2,3,4,5,26,27,28,29,30);
	$pm_files = array(29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69);
	$num_gs_files = 2;//"random";//2;//4;
	$num_pm_files = 3;//"random";//3;//1;
	$max_lines_in_file = 3500; // max articles to search in each query
	$firstline = TRUE;

	// activation trigger
	$run_extraction = FALSE;
	if (isset($_REQUEST['run']) && $_REQUEST['run']=='yes') {
		$run_extraction = TRUE;
	}

	echo "<br><center><h4><a href='combine_results.php' style='text-decoration:none'>Combine Results</a></h4></center>";
	echo "<center><h3><table>
	<tr><td>File combinations processed:</td><td><textarea id='combos_processed'>N/A</textarea></td><td>Highest scoring 3000 max:</td><td><textarea id='highest_3000'>N/A</textarea></td></tr>
	<tr><td>File combination currently processing:&nbsp;&nbsp;&nbsp;&nbsp;</td><td><textarea id='current_processing'>N/A</textarea></td><td>Highest scoring 4000 max:</td><td><textarea id='highest_4000'>N/A</textarea></td></tr>
	<tr><td>Current combo articles processed:</td><td><textarea id='articles_processed'>N/A</textarea></td><td>Highest scoring 5000 max:</td><td><textarea id='highest_5000'>N/A</textarea></td></tr>
	<tr><td>Current combo files processed:</td><td><textarea id='files_processed'>N/A</textarea></td><td>Highest scoring 6000 max:</td><td><textarea id='highest_6000'>N/A</textarea></td></tr>
	<tr><td>Highest scoring files:</td><td><textarea id='high_score_files'>N/A</textarea></td><td>Highest scoring 7000 max:</td><td><textarea id='highest_7000'>N/A</textarea></td></tr>
	<tr><td>Highest scoring matches:</td><td><textarea id='high_score_matches'>N/A</textarea></td><td>Highest scoring 8000 max:</td><td><textarea id='highest_8000'>N/A</textarea></td></tr>
	<tr><td>Highest scoring total articles:</td><td><textarea id='high_total_art'>N/A</textarea></td><td>Highest scoring 9000 max:</td><td><textarea id='highest_9000'>N/A</textarea></td></tr>
	<tr><td>Highest scoring 2000 max:</td><td><textarea id='highest_2000'>N/A</textarea></td><td>Highest scoring 10000 max:</td><td><textarea id='highest_10000'>N/A</textarea></td></tr>
	<tr><td>Current settings:</td><td style='font-size:16px'><center>GS files: $num_gs_files<br>PM files: $num_pm_files<br>Max lines: $max_lines_in_file</center></td><td>Output file:</td><td style='font-size:16px'><center>$output_filename</center></td></tr>
	</table></h3></center>";

	echo "<center><h4><a href='?run=yes' style='text-decoration:none'>Run extraction</a></h4></center><br>";

	if ($run_extraction) {
	/*if (($fh = fopen($list_file, "r")) !== FALSE) 
	{
	  while (! feof($fh)) 
	  {	
	  	$line = fgets($fh);
	  	array_push($file_list, trim($line));
	  }
	}
	fclose($fh); // Close the file*/

	if (($fh = fopen($core_articles_path, "r")) !== FALSE) 
	{
	  $line = fgets($fh); // skip column names
	  while (! feof($fh)) 
	  {	
	  	$line = fgets($fh);
	  	array_push($core_articles, trim($line));
	  }
	}
	fclose($fh);

	$core_found = array_fill(0, sizeof($core_articles), 0);

	function extract_articles($file_desc, $output_lines, $core_articles, $core_found, $line_num, $current_line_num, $max_lines_in_file) {
		$db_name = explode(',', $file_desc)[0];
		$file_name = explode(',', $file_desc)[1];
		$title = "";
		$title_matches = array();
		$current_file_lines = 0;

		if ($file_name!="" && ($fh = fopen($file_name, "r")) !== FALSE) 
		{
		  while (($line_array = fgetcsv($fh, 10000, ",")) !== FALSE && ($current_file_lines <= $max_lines_in_file))
		  {	
		  	if ($db_name == 'scholar') {
		  		$title = str_replace("\"", "", $line_array[2]);
		  		$year = $line_array[3];
		  	}
		  	if ($db_name == 'pubmed') {
		  		$title = str_replace("\"", "", $line_array[1]);
		  		$year = str_replace("\"", "", $line_array[6]);
		  	}

			if ($title != "Title") {
				for ($i = 0; $i < sizeof($core_articles); $i++) {
					// add escape charactors
					$title2 = $title;
					$special_chars = "~,`,!,@,#,$,%,^,&,*,(,),-,_,=,+,{,},|,:,;,\\\\,\\\",',<,>,.,?,/";
					$schars_array = explode(",", $special_chars);
					foreach ($schars_array as $char) {
						$escaped_char = "\\".$char;
						$title2 = str_replace($char,$escaped_char,$title2);
					}

					$title4 = str_replace("[","",$title2);
					$title5 = str_replace("]","",$title4);
					$pattern = "/(".$title5.".*)/";
					$title_matches = array();
					preg_match($pattern, $core_articles[$i], $title_matches);
					if (sizeof($title_matches) > 0 && $title != "") {
						$core_found[$i] = 1;
	  					array_push($output_lines, "\"".$title."\",".$year);
	  					//echo $core_articles[$i]."<br>";
					}
				}
	  		}

		  	$line_num++;
		  	$current_line_num++;
		  	$current_file_lines++;
		  }
		}

		fclose($fh);

		$results_array = array($output_lines, $core_found, $line_num, $current_line_num);
		return $results_array;
	}

	function write_output($output_filepath, $output_file, $output_values, $max_lines_in_file, $firstline) {
		$file_numbers = $output_values[0];
		$core_sum = $output_values[1];
		$progress_marker = $output_values[2];
		$current_line_num = $output_values[3];
		$multi_high_scores = $output_values[4];
		$multi_article_totals = $output_values[5];
		$multi_file_numbers = $output_values[6];
		$multi_score_thresholds = $output_values[7];
		$num_gs_files = $output_values[8];
		$num_pm_files = $output_values[9];

		$output_file = fopen($output_filepath, 'a') or die("Can't open file.");

		if ($firstline == TRUE) {
			fwrite($output_file, "file_numbers,total_matches,total_articles");
			for ($i = 0; $i < sizeof($multi_high_scores); $i++) {
				fwrite($output_file, ",file_numbers_".$multi_score_thresholds[$i].",total_matches_".$multi_score_thresholds[$i].",total_articles_".$multi_score_thresholds[$i]);
			}
			fwrite($output_file, ",progress_marker,$num_gs_files,$num_pm_files,$max_lines_in_file\n");
			$firstline = FALSE;
		}

		fwrite($output_file, "\"$file_numbers\",$core_sum,$current_line_num");
		for ($i = 0; $i < sizeof($multi_high_scores); $i++) {
			fwrite($output_file, ",\"".$multi_file_numbers[$i]."\",".$multi_high_scores[$i].",".$multi_article_totals[$i]);
		}
		fwrite($output_file, ",$progress_marker,,,\n");

		fclose($output_file);

		return $firstline;
	}

	// search file combinations
	//for ($i = $progress_counter; $i < pow(sizeof($gs_files),4); $i++) {
	$i = -1;
	while (TRUE) {
		$i++;
		$file_list_array = generate_file_list($num_gs_files, $num_pm_files, $gs_files, $pm_files, $i);
		$file_list = $file_list_array[0];
		$file_numbers = $file_list_array[1];
		$core_found = array_fill(0, sizeof($core_articles), 0);
		$output_lines = array();
		$current_line_num = 0;
		for ($j = 0; $j < sizeof($file_list); $j++) {
			$file_num++;
			$results_array = extract_articles($file_list[$j], $output_lines, $core_articles, $core_found, $line_num, $current_line_num, $max_lines_in_file);
			$output_lines = $results_array[0];
			$core_found = $results_array[1];
			$line_num = $results_array[2];
			$current_line_num = $results_array[3];
		}

		// count results
		$core_sum = 0;
		$avoid_dups = array();
		foreach ($output_lines as $line) {
			$dup_found = FALSE;
			foreach ($avoid_dups as $found_title) {
				if ($line == $found_title) {
					$dup_found = TRUE;
				}			
			}
			if ($dup_found == FALSE && $line!="\"\",0") {
				array_push($avoid_dups, $line);
				$core_sum++;
			}
		}

		if ($core_sum >= $high_score) {
			echo "<script>document.getElementById('high_score_matches').value = '$core_sum';</script>";
			echo "<script>document.getElementById('high_score_files').value = '$file_numbers';</script>";
			echo "<script>document.getElementById('high_total_art').value = '$current_line_num';</script>";
			$high_score = $core_sum;
			
			$output_values = array_fill(0, 7, 0);
			$output_values[0] = $file_numbers;
			$output_values[1] = $core_sum;
			$output_values[2] = $i;
			$output_values[3] = $current_line_num;
			$output_values[4] = $multi_high_scores;
			$output_values[5] = $multi_article_totals;
			$output_values[6] = $multi_file_numbers;
			$output_values[7] = $multi_score_thresholds;
			$output_values[8] = $num_gs_files;
			$output_values[9] = $num_pm_files;

			$firstline = write_output($output_filepath, $output_file, $output_values, $max_lines_in_file, $firstline);
		}
		for ($j = 0; $j < sizeof($multi_score_thresholds); $j++) {
			if ($current_line_num <= $multi_score_thresholds[$j] && 
				$core_sum >= $multi_high_scores[$j]) {
				$multi_high_scores[$j] = $core_sum;
				$multi_article_totals[$j] = $current_line_num;
				$multi_file_numbers[$j] = $file_numbers;
				$output_values = array_fill(0, 7, 0);
				$output_values[0] = $file_numbers;
				$output_values[1] = $core_sum;
				$output_values[2] = $i;
				$output_values[3] = $current_line_num;
				$output_values[4] = $multi_high_scores;
				$output_values[5] = $multi_article_totals;
				$output_values[6] = $multi_file_numbers;
				$output_values[7] = $multi_score_thresholds;
				$output_values[8] = $num_gs_files;
				$output_values[9] = $num_pm_files;

				$firstline = write_output($output_filepath, $output_file, $output_values, $max_lines_in_file, $firstline);
				echo "<script>document.getElementById('highest_".$multi_score_thresholds[$j]."').value = '$core_sum, $current_line_num';</script>";
			}
		}
		echo "<script>document.getElementById('combos_processed').value = '".($i+1)."';</script>";
		echo "<script>document.getElementById('current_processing').value = '$file_numbers';</script>";
  		echo "<script>document.getElementById('articles_processed').value = '$line_num';</script>";
		echo "<script>document.getElementById('files_processed').value = '$file_num';</script>";
		ob_flush();
	    flush();
	}

  	// Output dataset
  	if ($output_dataset) {
		$output_file = fopen($output_filepath, 'w') or die("Can't open file.");
		fwrite($output_file, "title,year\n");

		/*for ($i = 0; $i < sizeof($core_found); $i++) {
			if ($core_found[$i]==1) {
				//fwrite($output_file, $core_articles[$i]."\n");
				$core_sum++;
			}
		}*/

		$avoid_dups = array();
		foreach ($output_lines as $line) {
			$dup_found = FALSE;
			foreach ($avoid_dups as $found_title) {
				if ($line == $found_title) {
					$dup_found = TRUE;
				}			
			}
			if ($dup_found == FALSE && $line!="\"\",0") {
				fwrite($output_file, $line."\n");
				array_push($avoid_dups, $line);
				$core_sum++;
			}
		}
		fclose($output_file);	

		echo "<br><center><h3>Titles matched: ".$core_sum.".<br>Articles processed: ".$line_num.".<br>Results file creation completed.</h3></center>";
		}
	}

?>
<?php
	function generate_file_list($num_gs_files, $num_pm_files, $gs_files, $pm_files, $progress_counter) {
		/*
			Progress counter is a number that represents how far in the current parameters the 
			combination generator has processed.
		*/
		$file_list = array();
		$gs_size = sizeof($gs_files);
		$pm_size = sizeof($pm_files);
		$file_numbers = "";
		$random_files = array();
		$random_activated = FALSE;
		$f1 = ""; $f2 = ""; $f3 = ""; $f4 = ""; $f5 = "";

		if ($num_gs_files==4 && $num_pm_files==1) {
			$f1_num1 = $progress_counter % $gs_size;
			$f2_num1 = floor($progress_counter / $gs_size) % $gs_size;
			$f3_num1 = floor($progress_counter / pow($gs_size,2)) % $gs_size;
			$f4_num1 = floor($progress_counter / pow($gs_size,3)) % $gs_size;
			$f5_num1 = floor($progress_counter / pow($gs_size,4)) % $pm_size;
			$f1_num2 = $gs_files[$f1_num1];
			$f2_num2 = $gs_files[$f2_num1];
			$f3_num2 = $gs_files[$f3_num1];
			$f4_num2 = $gs_files[$f4_num1];
			$f5_num2 = $pm_files[$f5_num1];
			// try to avoid dups
			while ($f1_num2 == $f2_num2 || $f1_num2 == $f3_num2 || $f1_num2 == $f4_num2) {
				$f1_num2 = ($f1_num2 + 1) % $gs_size;
			}
			while ($f2_num2 == $f1_num2 || $f2_num2 == $f3_num2 || $f2_num2 == $f4_num2) {
				$f2_num2 = ($f2_num2 + 1) % $gs_size;
			}
			while ($f3_num2 == $f1_num2 || $f3_num2 == $f2_num2 || $f3_num2 == $f4_num2) {
				$f3_num2 = ($f3_num2 + 1) % $gs_size;
			}
			while ($f4_num2 == $f1_num2 || $f4_num2 == $f2_num2 || $f4_num2 == $f3_num2) {
				$f4_num2 = ($f4_num2 + 1) % $gs_size;
			}
			$f1="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f1_num2.".csv\n";
			$f2="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f2_num2.".csv\n";
			$f3="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f3_num2.".csv\n";
			$f4="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f4_num2.".csv\n";
			$f5="pubmed,../extract_citations/pubmed_results/29/query_results_pm".$f5_num2.".csv";
			$file_numbers = "gs".$f1_num2.",gs".$f2_num2.",gs".$f3_num2.",gs".$f4_num2.",pm".$f5_num2;
		}

		if ($num_gs_files==2 && $num_pm_files==3) {
			$f1_num1 = floor($progress_counter / (pow($pm_size,2)+$gs_size)) % $gs_size;
			$f2_num1 = floor($progress_counter / (pow($pm_size,2)+(pow($gs_size,2)))) % $gs_size;
			$f3_num1 = $progress_counter % $pm_size;
			$f4_num1 = floor($progress_counter / $pm_size) % $pm_size;
			$f5_num1 = floor($progress_counter / pow($pm_size,2)) % $pm_size;
			$f1_num2 = $gs_files[$f1_num1];
			$f2_num2 = $gs_files[$f2_num1];
			$f3_num2 = $pm_files[$f3_num1];
			$f4_num2 = $pm_files[$f4_num1];
			$f5_num2 = $pm_files[$f5_num1];
			// try to avoid dups
			while ($f1_num2 == $f2_num2) {
				$f1_num2 = ($f1_num2 + 1) % $gs_size;
			}
			while ($f2_num2 == $f1_num2) {
				$f2_num2 = ($f2_num2 + 1) % $gs_size;
			}
			while ($f3_num2 == $f4_num2 || $f3_num2 == $f5_num2) {
				$f3_num2 = ($f3_num2 + 1) % $pm_size;
			}
			while ($f4_num2 == $f3_num2 || $f4_num2 == $f5_num2) {
				$f4_num2 = ($f4_num2 + 1) % $pm_size;
			}
			while ($f5_num2 == $f3_num2 || $f5_num2 == $f4_num2) {
				$f5_num2 = ($f5_num2 + 1) % $pm_size;
			}
			$f1="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f1_num2.".csv\n";
			$f2="scholar,../extract_citations/gs_results/csv_results/query_results_gs".$f2_num2.".csv\n";
			$f3="pubmed,../extract_citations/pubmed_results/".$f3_num2."/query_results_pm".$f3_num2.".csv\n";
			$f4="pubmed,../extract_citations/pubmed_results/".$f4_num2."/query_results_pm".$f4_num2.".csv\n";
			$f5="pubmed,../extract_citations/pubmed_results/".$f5_num2."/query_results_pm".$f5_num2.".csv";
			$file_numbers = "gs".$f1_num2.",gs".$f2_num2.",pm".$f3_num2.",pm".$f4_num2.",pm".$f5_num2;
		}

		if ($num_gs_files=="random" && $num_pm_files=="random") {
			$random_activated = TRUE;
			$gs_filenames = array();
			$pm_filenames = array();
			foreach($gs_files as $file_number) {
				array_push($gs_filenames, "scholar,../extract_citations/gs_results/csv_results/query_results_gs".$file_number.".csv\n");
			}
			foreach($pm_files as $file_number) {
				array_push($pm_filenames, "pubmed,../extract_citations/pubmed_results/".$file_number."/query_results_pm".$file_number.".csv\n");
			}
			$split = rand(1,4);
			$gs_group = array();
			$pm_group = array();
			if ($split == 1) {
				$gs_group = array_rand($gs_filenames,1);
				$pm_group = array_rand($pm_filenames,4);
				foreach ($pm_group as $index) {
					array_push($random_files, trim($pm_filenames[$pm_group[$index]]));
				}
				array_push($random_files, trim($gs_filenames[$gs_group[0]]));
				$file_numbers = "gs".trim($gs_files[$gs_group]).",pm".trim($pm_files[$pm_group[0]]).",pm".trim($pm_files[$pm_group[1]]).",pm".trim($pm_files[$pm_group[2]]).",pm".trim($pm_files[$pm_group[3]]);
			}
			else if ($split == 2) {
				$gs_group = array_rand($gs_filenames,2);
				$pm_group = array_rand($pm_filenames,3);
				foreach ($gs_group as $index) {
					array_push($random_files, trim($gs_filenames[$gs_group[$index]]));
				}
				foreach ($pm_group as $index) {
					array_push($random_files, trim($pm_filenames[$pm_group[$index]]));
				}
				//$file_numbers = $gs_group[0].",".$gs_group[1].",".$pm_group[0].",".$pm_group[1].",".$pm_group[2];
				$file_numbers = "gs".trim($gs_files[$gs_group[0]]).",gs".trim($gs_files[$gs_group[1]]).",pm".trim($pm_files[$pm_group[0]]).",pm".trim($pm_files[$pm_group[1]]).",pm".trim($pm_files[$pm_group[2]]);
			}
			else if ($split == 3) {
				$gs_group = array_rand($gs_filenames,3);
				$pm_group = array_rand($pm_filenames,2);
				foreach ($gs_group as $index) {
					array_push($random_files, trim($gs_filenames[$gs_group[$index]]));
				}
				foreach ($pm_group as $index) {
					array_push($random_files, trim($pm_filenames[$pm_group[$index]]));
				}
				//$file_numbers = $gs_group[0].",".$gs_group[1].",".$gs_group[2].",".$pm_group[0].",".$pm_group[1];
				$file_numbers = "gs".trim($gs_files[$gs_group[0]]).",gs".trim($gs_files[$gs_group[1]]).",gs".trim($gs_files[$gs_group[2]]).",pm".trim($pm_files[$pm_group[0]]).",pm".trim($pm_files[$pm_group[1]]);
			}
			else if ($split == 4) {
				$gs_group = array_rand($gs_filenames,4);
				$pm_group = array_rand($pm_filenames,1);
				foreach ($gs_group as $index) {
					array_push($random_files, trim($gs_filenames[$gs_group[$index]]));
				}
				array_push($random_files, trim($pm_filenames[$pm_group[0]]));
				//$file_numbers = $gs_group[0].",".$gs_group[1].",".$gs_group[2].",".$gs_group[3].",".$pm_group;
				$file_numbers = "gs".trim($gs_files[$gs_group[0]]).",gs".trim($gs_files[$gs_group[1]]).",gs".trim($gs_files[$gs_group[2]]).",gs".trim($gs_files[$gs_group[3]]).",pm".trim($pm_files[$pm_group]);
			}		
		}

		array_push($file_list, trim($f1));
		array_push($file_list, trim($f2));
		array_push($file_list, trim($f3));
		array_push($file_list, trim($f4));
		array_push($file_list, trim($f5));

		if ($random_activated == TRUE) {
			$file_list = $random_files;
		}

		$results = array($file_list, $file_numbers);
		return $results;
	}
?>
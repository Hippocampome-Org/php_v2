<?php
//	include ("generate_json_params.php"); // import parameters for this software

	if ($page=="write_file" || $page==null) {
		include ("/var/www/html/php/permission_check.php");
		echo "
		<html>
		<!--
		This software is for generating json files

		Author: Nate Sutton 
		Date:   2020
		-->

		<head>
			<title>Json Generation</title>
			<link rel='icon' href='../../images/Hippocampome_logo.ico'>
			<style>
			body {
		    	background-color: lightgrey;
			}
			.button {
				padding:20px;
				font-size:20px;
				border-radius: 30px;
				border-color: darkgrey;
				border: 2px solid darkgrey;
			}
			</style>
		</head>
		<body>
		<br><hr><center><h2><a href='generate_json.php' style='color:black;text-decoration:none'>Json Generation Page</a></h2>Note: this page's operations require read and write access to a directory specified<br>in its source code. If that is not availible online this should be run offline to complete its operations.</center><br><hr>

		<h3><center>Choose Json files to create:</center></h3>

		<center><button onclick=\"window.location.href = '?page=write_file';\" class='button'>Generate counts matrix json</button></center><br><hr>
		";
	}
	function value_collect($conn, $i, $col, $neuron_id, $conditions, $referenceID, $refid_condition, $no_endline, $error_col, $error_type, $error_n_col) {
		/*
			return value and properties
		*/

		$entry_output = ''; $id = ''; $val = ''; $val_found=false; $rank_entry = array("","","","","");
		$species = ''; $agetype = ''; $gender = ''; $rec = ''; $behav = '';
		$min_range = ''; $max_range = ''; $count = ''; $gender2 = '';
		$lowest_rank = ''; $lowest_rank_id = ''; $median = ''; $npage_entry = array();
		$val_frag = ''; $lowest_frr = ''; $all_val = ''; $error_val = ''; $error_type_desc = '';
		$val_with_error = ''; $error_val_n = '';

		// return all matching values
		$sql = "SELECT GROUP_CONCAT(DISTINCT id) as id, GROUP_CONCAT(DISTINCT CAST($col AS DECIMAL (10 , 2 ))) AS val, GROUP_CONCAT(DISTINCT CAST($error_col AS DECIMAL (10 , 2 ))) as error_val, GROUP_CONCAT(DISTINCT $error_n_col) as error_val_n, GROUP_CONCAT(DISTINCT $error_type) as error_type, GROUP_CONCAT(DISTINCT species) as species, GROUP_CONCAT(DISTINCT agetype) as agetype, GROUP_CONCAT(DISTINCT gender) as gender, GROUP_CONCAT(DISTINCT recordingMethod) as recordingMethod, GROUP_CONCAT(DISTINCT behavioralStatus) as behavioralStatus, GROUP_CONCAT(DISTINCT metadataRank) as metadataRank";if($col=="firingRateNonBaseline"){$sql=$sql.", GROUP_CONCAT(DISTINCT firingRateRankNonBaseline) AS firingRateRankNonBaseline";}$sql=$sql." FROM counts WHERE cellID = $neuron_id AND $col != \"\"";
		if ($col == "run_stop_ratio") {
			$sql = "SELECT GROUP_CONCAT(DISTINCT id) as id, GROUP_CONCAT(DISTINCT CAST($col AS DECIMAL (10 , 2 ))) AS val, GROUP_CONCAT(DISTINCT species) as species, GROUP_CONCAT(DISTINCT agetype) as agetype, GROUP_CONCAT(DISTINCT gender) as gender, GROUP_CONCAT(DISTINCT recordingMethod) as recordingMethod, GROUP_CONCAT(DISTINCT behavioralStatus) as behavioralStatus, GROUP_CONCAT(DISTINCT metadataRank) as metadataRank";if($col=="firingRateNonBaseline"){$sql=$sql.", GROUP_CONCAT(DISTINCT firingRateRankNonBaseline) AS firingRateRankNonBaseline";}$sql=$sql." FROM counts WHERE cellID = $neuron_id AND $col != \"\"";

		}
		if ($conditions != "") {
			$sql = $sql.$conditions;
		}
		if ($referenceID != "") {
			$sql = $sql.$refid_condition;
		}
		$sql = $sql." GROUP BY species, agetype, gender, recordingMethod, behavioralStatus, metadatarank";if($col=="firingRateNonBaseline"){$sql=$sql.", firingRateRankNonBaseline";}if($referenceID!=""){$sql=$sql.", referenceID";}$sql=$sql." ORDER BY CAST(GROUP_CONCAT(DISTINCT CAST(metadataRank AS DECIMAL (10 , 2 ))) AS DECIMAL (10 , 2 ))";if($col=="firingRateNonBaseline"){$sql=$sql.", CAST(GROUP_CONCAT(DISTINCT CAST(firingRateRankNonBaseline AS DECIMAL (10 , 2 ))) AS DECIMAL (10 , 2 ))";}
		//echo "<br><br><br>sql: ".$sql;
		//if ($col != "counts" && $col != "swr_ratio" && $col != "firingrate") {echo $sql."<br><br>";}
		$result = $conn->query($sql);
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				if ($val_found == false) {
					$id = $row['id'];
					$val = $row['val'];
					$species = $row['species'];
					$agetype = $row['agetype'];
					$gender = $row['gender'];
					if ($gender == 'unknown') {$gender2 = 'unknown sex';} else {$gender2 = $gender;}
					$rec = $row['recordingMethod'];
					$behav = $row['behavioralStatus'];
					$rank = $row['metadataRank'];
					$error_val = $row['error_val'];
					$error_val_n = $row['error_val_n'];
					$error_type_desc = $row['error_type'];
					if ($val != '') {
						$val_found = true;
						$rank_entry[0]=$species;
						$rank_entry[1]=$agetype;
						$rank_entry[2]=$gender;
						$rank_entry[3]=$rec;
						$rank_entry[4]=$behav;
						$lowest_rank = $rank;
						//echo "<br><br><br><br><br><br><br><br>sql: ".$lowest_rank;
						$lowest_rank_id = $id;
						if($col=="firingRateNonBaseline"){$lowest_frr=$row['firingRateRankNonBaseline'];}
						//$all_other = $all_other." ".$low_rank_entry.": ".$other_entries[$o_i];
					}
				}
				if ($val != "") {
					$val_frag = $val_frag.$val."; Representative selection: ".$species.", ".$agetype.", ".$gender2.", ".$rec.", ".$behav;
					$all_val = $val;
					//echo $col." ".$all_val."<br>";
				}
			}
		}
		$median = find_median($conn, $col, $neuron_id, $lowest_rank, $referenceID, $refid_condition, $lowest_frr);
		//if ($neuron_ids[$i] == 2000) {echo "<br><br><br><br><br><br><br><br>sql: ".$sql2;}
		// find min and max
		$sql4 = "SELECT MIN(CAST($col AS DECIMAL (10 , 2 ))) AS min_range, MAX(CAST($col AS DECIMAL (10 , 2 ))) AS max_range, COUNT($col) AS count FROM counts WHERE cellID = $neuron_id AND $col != \"\"";
		$sql4 = $sql4." AND metadataRank=\"".$lowest_rank."\"";
		if ($lowest_frr != "") {
			$sql4 = $sql4." AND firingRateRankNonBaseline=".$lowest_frr;
		}
		if ($conditions != "") {
			$sql4 = $sql4.$conditions;
		}
		if ($referenceID != "") {
			$sql4 = $sql4.$refid_condition;
		}
		//echo "<br><br><br><br><br><br><br><br>sql: ".$sql4;
		$result = $conn->query($sql4);
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$min_range = $row['min_range'];
				$max_range = $row['max_range'];
				$count = $row['count'];
			}
		}
		// return measurements
		$sql5 = "SELECT COUNT($col) AS measurements FROM counts WHERE cellID = $neuron_id AND $col != \"\"";
		if ($conditions != "") {
			$sql5 = $sql5.$conditions;
		}
		$result = $conn->query($sql5);
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$measurements = $row['measurements'];
			}
		}
		// output html
		$entry_output = $entry_output."\"<center><span id='$col".$i."'><a href='property_page_counts.php?id_neuron=$neuron_id&val_property=$col' title='Range: [".$min_range.", ".$max_range."]\\nRepresentative selection: ".$species.", ".$agetype.", ".$gender2.",\\n".$rec.", ".$behav."\\nRepresentative value selected from ".$count." source";
		if ($count > 1) {$entry_output = $entry_output."s";}
		$entry_output = $entry_output."\\nTotal measurements: ".$measurements."' target='_blank'>$median</a></span></center></div>\"";
		if ($no_endline == "true") {
			$entry_output = $entry_output.",";
		}

		$val_sep = explode(",", $val);
		$error_val_sep = explode(",", $error_val);
		$error_val_n_sep = explode(",", $error_val_n);
		for ($v_i = 0; $v_i < count($val_sep); $v_i++) {
			$separator = ", ";
			if ($v_i == (count($val_sep) - 1)) {
				$separator = "";
			}
			$error_desc = " ± ".$error_val_sep[$v_i];
			if ($error_val_n_sep[$v_i] != "NA") {
				$error_desc = $error_desc." (".$error_val_n_sep[$v_i].")";
			}
			if ($error_val_sep[$v_i] == "" || $error_val_sep[$v_i] == "0.0") {
				$error_desc = "";
			}
			if ($col != "run_stop_ratio" && strcmp($val_sep[$v_i],"") !== 0 && $error_val_n_sep[$v_i] == 1) {
				$error_desc = $error_desc." (1)";
			}

			$val_with_error = $val_with_error.$val_sep[$v_i].$error_desc.$separator;
		}
		//if ($val_with_error != "") {echo $neuron_id." ".$val_with_error."<br>";}

		array_push($npage_entry, $neuron_id);
		array_push($npage_entry, $median);
		array_push($npage_entry, "[".$min_range.", ".$max_range."]");
		array_push($npage_entry, $count);
		array_push($npage_entry, $species.", ".$agetype.", ".$gender.",<br>".$rec.", ".$behav);
		array_push($npage_entry, $val_with_error);

		$results = array($entry_output, $val_frag, $rank_entry, $npage_entry, $all_val);

		return $results;
	}

	function find_median($conn, $col, $neuron_id, $lowest_rank, $referenceID, $refid_condition, $lowest_frr) {
		/*
			Notes: do not include an if statement for lowest_rank because lack of a value for that should
			filter out results, rather than being ignored. lowest_frr has an if statement because it is optional. The counts table has a metadatarank for every row, and therefore the existance of lowest_frr is not required for filtering out unchecked conditions.
			lowest_rank has quotes because it can contain an empty value, and in such as case without the
			quotes the query would be broken.
		*/

		$median = "";
		$sql2 = "SELECT CAST(AVG(pp.$col) AS DECIMAL(10,2)) as median_val FROM (SELECT p.$col, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum FROM counts p, (SELECT @rownum:=0) r WHERE p.$col is NOT NULL AND p.$col!='' AND p.cellid=$neuron_id";
		$sql2 = $sql2." AND p.metadataRank=\"".$lowest_rank."\"";
		if ($lowest_frr != "") {
			$sql2 = $sql2." AND p.firingRateRankNonBaseline=".$lowest_frr;
		}
		if ($referenceID != "") {
			$sql2 = $sql2.$refid_condition;
		}
		$sql2 = $sql2." ORDER BY CAST(p.$col AS DECIMAL(10,2))) as pp WHERE pp.row_number IN (FLOOR((@total_rows+1)/2))";
		//echo "<br>".$sql2."<br>";
		$result = $conn->query($sql2);
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$median = $row['median_val'];
			}
		}

		return $median;//." $sql2";
	}

	function retrieve_values($conn, $i, $counts_values, $spw_values, $firingrate_values, $other_values, $neuron_ids, $conditions, $best_ranks_counts, $best_ranks_swr, $best_ranks_firingrate, $npage_counts, $npage_swr, $npage_firingrate, $npage_other, $pmid_limit, $referenceID, $other_all, $val_property, $best_ranks_other) {
		/*
			Return values for all relevant value columns.
		*/
		$entry_output = ""; $id = ''; $counts = ''; $swr_ratio = ''; $firingrate = ''; $other = '';
		$species = ''; $agetype = ''; $gender = ''; $rec = ''; $behav = '';
		$min_range = ''; $max_range = ''; $count = ''; $gender2 = '';
		$counts_found = false; $swr_found = false; $firingrate_found=false; $other_found = false;
		$rank_entry_counts = array(); $rank_entry_swr = array(); $rank_entry_firingrate = array();
		$lowest_rank = ''; $lowest_rank_id = ''; $lowest_swr_rank = ''; $lowest_swr_rank_id = '';
		$lowest_firingrate_rank = ''; $lowest_firingrate_rank_id = '';
		$counts_median = ''; $swr_median = ''; $firingrate_median = ''; $npage_entry = array();
		$all_counts = ''; $all_swr = ''; $all_fr = ''; $all_other = '';
		$refid_condition = " AND referenceID = \"\\\"$referenceID\\\"\"";
		$DS_ratio = ""; $Vrest = ""; $tau = ""; $APthresh = ""; $fAHP = ""; $APpeak_trough = "";
		$values = array(); $best_ranks = array(); $npage = array(); $other_frag = ""; $val_frag = "";
		$other_all_group = array("DS_ratio", "ripple", "gamma", "run_stop_ratio", "epsilon", "firingRateNonBaseline", "Vrest", "tau", "APthresh", "fAHP", "APpeak_trough");
		$error_cols = array("countsError", "SWR_ratioError", "firingRateError", "DS_ratioError", "rippleError", "gammaError", "run_stop_ratioError", "epsilonError", "firingRateErrorNonBaseline", "VrestError", "tauError", "APthreshError", "fAHP_Error", "APpeak_troughError");
		$error_n_cols = array("countsN", "SWR_ratioN", "firingRateN", "DS_ratioN", "rippleN", "gammaN", "run_stop_ratioN", "epsilonN", "firingRateN_NonBaseline", "VrestN", "tauN", "APthreshN", "fAHP_N", "APpeak_troughN");
		$error_types = array("countsErrorType", "SWR_ratioErrorType", "firingRateErrorType", "DS_ratioErrorType", "rippleErrorType", "gammaErrorType", "run_stop_ratioErrorType", "epsilonErrorType", "firingRateErrorTypeNonBaseline", "VrestErrorType", "tauErrorType", "APthreshErrorType", "fAHP_ErrorType", "APpeak_troughErrorType");
		$other_entries = array_fill(0, count($other_all_group), "");
		$other_cond = array_fill(0, count($other_all_group), "");
		$neuron_id = $neuron_ids[$i];
		//echo $neuron_ids." i: ".$i."<br>";

		// counts
		$results = value_collect($conn, $i, "counts", $neuron_id, $conditions, $referenceID, $refid_condition, "true", $error_cols[0], $error_types[0], $error_n_cols[0]);
		$results_nocond = value_collect($conn, $i, "counts", $neuron_id, "", $referenceID, $refid_condition, "true", $error_cols[0], $error_types[0], $error_n_cols[0]);
		array_push($counts_values, $results[0]);
		foreach ($results_nocond[2] as $rank_result) {
			array_push($best_ranks_counts, $rank_result);
			//echo "<br>$rank_result<br>";
		}
		array_push($npage_counts, $results[3]);
		$all_counts = $results[4];
		//echo "<br>".$npage_counts[0][5];		

		// swr ratio
		$results = value_collect($conn, $i, "swr_ratio", $neuron_id, $conditions, $referenceID, $refid_condition, "true", $error_cols[1], $error_types[1], $error_n_cols[1]);
		$results_nocond = value_collect($conn, $i, "swr_ratio", $neuron_id, "", $referenceID, $refid_condition, "true", $error_cols[1], $error_types[1], $error_n_cols[1]);
		array_push($spw_values, $results[0]);
		foreach ($results_nocond[2] as $rank_result) {
			array_push($best_ranks_swr, $rank_result);
		}
		array_push($npage_swr, $results[3]);
		$all_swr = $results[4];
		//echo "<br>".$npage_swr[0][5];		

		// firing rate
		$results = value_collect($conn, $i, "firingRate", $neuron_id, $conditions, $referenceID, $refid_condition, "true", $error_cols[2], $error_types[2], $error_n_cols[2]);
		$results_nocond = value_collect($conn, $i, "firingRate", $neuron_id, "", $referenceID, $refid_condition, "true", $error_cols[2], $error_types[2], $error_n_cols[2]);
		array_push($firingrate_values, $results[0]);
		foreach ($results_nocond[2] as $rank_result) {
			array_push($best_ranks_firingrate, $rank_result);
		}
		array_push($npage_firingrate, $results[3]);
		$all_fr = $results[4];

		// other column section
		$entry_output = "";
		$npage_entry_cond = "";
		for ($o_i = 0; $o_i < count($other_all_group); $o_i++) {
			$results = value_collect($conn, $i, $other_all_group[$o_i], $neuron_id, $conditions, $referenceID, $refid_condition, "false", $error_cols[($o_i+3)], $error_types[($o_i+3)], $error_n_cols[($o_i+3)]);
			$results_nocond = value_collect($conn, $i, $other_all_group[$o_i], $neuron_id, "", $referenceID, $refid_condition, "false", $error_cols[($o_i+3)], $error_types[($o_i+3)], $error_n_cols[($o_i+3)]);
			$entry_output = $entry_output.$results[0];
			$val_frag = $results[3][5];
			$rank_entry = $results[2];
			$species = $rank_entry[0];
			$agetype = $rank_entry[1];
			$gender = $rank_entry[2];
			$rec = $rank_entry[3];
			$behav = $rank_entry[4];
			if ($results[4] != "" && ($val_property == $other_all_group[$o_i] || $val_property == "all_other" || $val_property == "")) {
				$all_other = $all_other.$other_all_group[$o_i].": ".$results[4];
			}

			// find conditions in other columns
			foreach ($results_nocond[2] as $rank_result) {
				array_push($best_ranks_other, $rank_result);
			}
			//echo "best_ranks_other: ".$other_all_group[$o_i]." ".count($best_ranks_other)."<br>";

			/* other all toggle checked */
			if ($other_all == "checked") {
				if ($val_frag != "") {
					$protocol_nr = str_replace('<br>', ' ', $results[3][4]);
					$other_frag = $other_frag.$other_all_group[$o_i].": ".$val_frag."; Protocol: ".$protocol_nr;
				}

				if ($o_i == (count($other_all_group) - 1)) {
					$entry_output = $entry_output."]},";
				}
				else {
					$entry_output = $entry_output.",";
				}
			}

			$other_entries[$o_i] = $val_frag;
			$other_cond[$o_i] = "Representative selection: ".$species.", ".$agetype.", ".$gender.",\\n".$rec.", ".$behav;
		}
		/* other all toggle unchecked */
		if ($other_all != "checked") {
			$low_rank_entry = "";
			$low_rank_cond = "";
			$o_vals_tot = 0;

			for ($o_i = 0; $o_i < count($other_all_group); $o_i++) {
				if ($val_frag != "") {
					$other_frag = $other_frag.$other_all_group[$o_i].": ".$val_frag;
				}				
				if ($other_entries[$o_i] != "") {
					if ($low_rank_entry == "") {
						$low_rank_entry = $other_all_group[$o_i];
						$low_rank_cond = $other_cond[$o_i];
						$npage_entry_cond = str_replace("Representative selection: ", "", $low_rank_cond);
						$npage_entry_cond = str_replace("\\n", "<br>", $npage_entry_cond);
						$all_other = $all_other.$low_rank_entry.": ".$other_entries[$o_i];
					}
					$o_vals_tot++;
				}
			}

			if ($low_rank_entry != "") {

				$entry_output = "\"<center><span id='other".$i."'><a href='property_page_counts.php?id_neuron=".$neuron_id."&val_property=all_other' title='".$low_rank_cond."' target='_blank'>";
				$other = $low_rank_entry;
				if ($o_vals_tot == 2) {
					$other = $other." and 1 other";	
				}
				else if ($o_vals_tot > 2) {
					$other = $other." and ".($o_vals_tot - 1)." others";		
				}
				$entry_output = $entry_output.$other."</a></span></center></div>\"]},";
			}
			else {
				$entry_output = "\"\"]},";
			}
		}
		/* build output arrays */
		array_push($other_values, $entry_output);
		$npage_entry = array();
		array_push($npage_entry, $neuron_id);
		array_push($npage_entry, $other);
		array_push($npage_entry, $npage_entry_cond);
		array_push($npage_other, $npage_entry);
		$all_vals = array();
		array_push($all_vals, $all_counts);
		array_push($all_vals, $all_swr);
		array_push($all_vals, $all_fr);
		array_push($all_vals, $all_other);
		array_push($all_vals, $other_frag);
		//echo "<br>other_frag: ".$other_frag;	

		return array($counts_values, $spw_values, $firingrate_values, $other_values, $best_ranks_counts, $best_ranks_swr, $best_ranks_firingrate, $npage_counts, $npage_swr, $npage_firingrate, $npage_other, $all_vals, $best_ranks_other);	
	}

	/*
	Generate matrices section
	*/
	if ($page=="write_file" || $page=="main_page") {
		for ($i = 0; $i < count($neuron_ids); $i++) {
			if (!isset($pmid_limit)) {
				$pmid_limit = '';
			}
			if (!isset($referenceID)) {
				$referenceID = '';
			}
			if (!isset($other_all)) {
				$other_all = '';
			}
			if (!isset($conditions)) {
				$conditions = '';
			}
			$write_output = retrieve_values($conn, $i, $counts_values, $spw_values, $firingrate_values, $other_values, $neuron_ids, $conditions, $best_ranks_counts, $best_ranks_swr, $best_ranks_firingrate, $npage_counts, $npage_swr, $npage_firingrate, $npage_other, $pmid_limit, $referenceID, $other_all, $val_property, $best_ranks_other);
			$counts_values = $write_output[0];
			$spw_values = $write_output[1];
			$firingrate_values = $write_output[2];
			$other_values = $write_output[3];
			$best_ranks_counts = $write_output[4];
			$best_ranks_swr = $write_output[5];
			$best_ranks_firingrate = $write_output[6];
			$best_ranks_other = $write_output[12];
			$npage_counts = $write_output[7];
			$npage_swr = $write_output[8];
			$npage_firingrate = $write_output[9];
			$npage_other = $write_output[10];
		}

		/* 
		Write to File 
		
		$new_row_col is used because a new row occurs every certain
		number of columns when reading the file.
		*/

		/* specify rows to use from template file */
		$init_col = 0;
		$init_col2 = 1;
		$counts_col = 2;
		$spw_col = 3;
		$firingrate_col = 4;
		$other_col = 5;
		$new_row_col = 6;
		$neuron_classes = 34;
		$max_rows = 100000;
		/* specify indices */
		$neuron_group_cols = array(); // new file indexes
		$counts_cols = array();
		$spw_cols = array();
		$firingrate_cols = array();
		$other_cols = array();
		$total_rows = $new_row_col*$neuron_classes;	
		$i_t = 0;
		$i_s = 0;
		$i_f = 0;		
		$i_o = 0;
		$nl = $json_new_line;
		$json_output_string = "";

		/* create arrays of selected template indexes */
		for ($i = 0; $i < $max_rows; $i++) {
			array_push($neuron_group_cols, ($init_col+($new_row_col*$i)));
			array_push($neuron_group_cols, ($init_col2+($new_row_col*$i)));
			array_push($counts_cols, ($counts_col+($new_row_col*$i)));
			array_push($spw_cols, ($spw_col+($new_row_col*$i)));
			array_push($firingrate_cols, ($firingrate_col+($new_row_col*$i)));
			array_push($other_cols, ($other_col+($new_row_col*$i)));
		}	

		if ($page=='write_file') {
			$output_file = fopen($json_output_file, 'w') or die("Can't open file.");
		}

		for ($i = 0; $i<$total_rows; $i++) {
			if (in_array($i, $neuron_group_cols)) {
				if ($page=='write_file') {
					fwrite($output_file, $neuron_groups[$i]);
				}
				if ($page=='main_page') {
					$json_output_string = $json_output_string.$neuron_groups[$i];
				}
			}
			elseif (in_array($i, $counts_cols)) {
				if ($page=='write_file') {
					fwrite($output_file, $counts_values[$i_t].$nl);
				}
				if ($page=='main_page') {
					$json_output_string = $json_output_string.$counts_values[$i_t].$nl;
				}
				$i_t++;
			}
			elseif (in_array($i, $spw_cols)) {
				if ($page=='write_file') {
					fwrite($output_file, $spw_values[$i_s].$nl);
				}
				if ($page=='main_page') {
					$json_output_string = $json_output_string.$spw_values[$i_s].$nl;
				}
				$i_s++;
			}
			elseif (in_array($i, $firingrate_cols)) {
				if ($page=='write_file') {
					fwrite($output_file, $firingrate_values[$i_f].$nl);
				}
				if ($page=='main_page') {
					$json_output_string = $json_output_string.$firingrate_values[$i_f].$nl;
				}
				$i_f++;
			}
			elseif (in_array($i, $other_cols)) {
				if ($i!=($total_rows-1)) {
					if ($page=='write_file') {
						fwrite($output_file, $other_values[$i_o].$nl);
					}
					if ($page=='main_page') {
						$json_output_string = $json_output_string.$other_values[$i_o].$nl;
					}
				}
				else {
					if ($page=='write_file') {
						//fwrite($output_file, $other_values[$i_o]);
						//fwrite($output_file, "\"\"]}]}".$nl); 
					}
					if ($page=='main_page') {
						$other_val_output = str_replace("\"]},", "\"]}]}", $other_values[$i_o]);
						$json_output_string = $json_output_string.$other_val_output.$nl;
					}
				}
				$i_o++;
			}
		}
		if ($page=='write_file') {
			fclose($output_file);	
			echo "<br><br>Json file written.";
		}
	}

if ($page=="write_file" || $page="") {
	echo "</body>";
}
?>
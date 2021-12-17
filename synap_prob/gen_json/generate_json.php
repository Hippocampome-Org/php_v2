<html>
<!--
This software is for generating json files

Author: Nate Sutton 
Date:   2020

Note:
The "CAST(STD(CAST" and similar entries is needed in below queries because it
first needs to cast the db value from text into decimal, then take std(), then
limit significant digits using cast again.

reference: https://stackoverflow.com/questions/37618679/format-number-to-n-significant-digits-in-php
https://stackoverflow.com/questions/5149129/how-to-strip-trailing-zeros-in-php

-->
<head>
	<title>Json Generation</title>
	<link rel="icon" href="../../images/Hippocampome_logo.ico">
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
<?php
	// import parameters for this software
	include ("generate_json_params.php");	

	echo "<br><hr><center><h2><a href='generate_json.php' style='color:black;text-decoration:none'>Json Generation Page</a></h2>Note: this page's operations require read and write access to a directory specified<br>in its source code. If that is not availible online this should be run offline to complete its operations.</center><br><hr>";


	echo "<h3><center>Choose Json file to create:</center></h3>";

	echo "<center><button onclick=\"window.location.href = '?page=dal';\" class='button'>Dendrite Axon Length</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"window.location.href = '?page=sd';\" class='button'>Somatic Distance</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"window.location.href = '?page=ps';\" class='button'>Number of Potential Synapses</button><br><br><button onclick=\"window.location.href = '?page=noc';\" class='button'>Number of Contacts</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"window.location.href = '?page=prosyn';\" class='button'>Synaptic Probabilities</button></center><br><hr>";

	if ($page!='') {
		echo "<br>Completed processing record: ";
	}

	function toPrecision($value, $digits)
	{
		/*
			Set precision of digits
		*/
	    if ($value == 0) {
	        $decimalPlaces = $digits - 1;
	    } elseif ($value < 0) {
	        $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
	    } else {
	        $decimalPlaces = $digits - floor(log10($value)) - 1;
	    }

	    $answer = ($decimalPlaces > 0) ?
	        number_format($value, $decimalPlaces) : round($value, $decimalPlaces);

	    // remove tailing zeros
	    /*preg_match('/(\d+)\.(\d+)/', $answer, $answer_matches);	
	    $whole_number = $answer_matches[1];
	    $fraction = $answer_matches[2];
		$answer_digits = strlen($fraction);
		if ($answer_digits > $digits) {
			$answer_trimmed_digits = substr($fraction,0,($digits+1));
			$answer = $whole_number.".".$answer_trimmed_digits;
		}*/

	    return $answer; // (float) is to remove trailing 0
	}

	function adjPrecision($old_val,$new_val,$digits)
	{
		/*
			Make $old_van and $new_val match significant digits
		*/
		$adj_old_val = toPrecision($old_val,$digits);

		preg_match('/\d?\.(\d+)/', $adj_old_val, $adj_old_val_matches);
		$adj_old_val_digits = strlen($adj_old_val_matches[1]);

		$adj_new_val = toPrecision($new_val,$digits);		

		preg_match('/\d?\.(\d+)/', $adj_new_val, $adj_new_val_matches);		
		$adj_new_val_digits = strlen($adj_new_val_matches[1]);

		if ($adj_old_val_digits < $adj_new_val_digits) {
			$digits = $digits - 1;
		}
		else if ($adj_old_val_digits > $adj_new_val_digits) {
			$digits = $digits + 1;
		}

		$adj_new_val2 = toPrecision($new_val,$digits);		

		return $adj_new_val2;
	}

	function na_for_zero($value) {
		$test_value = strval(toPrecision($value,3)); 
		$new_value = $value;
		if ($test_value == '0' | $test_value == '0.0' | $test_value == '0.00' | $test_value == '0.000' | $test_value == '0.0000' | $test_value == '0.00000' | $test_value == '0.000000') {
			$new_value = "N/A";
		}

		return $new_value;
	}

	/*
	Generate matrices section

	$i is row that is a neuron type	
	$j is column that is a parcel type
	*/
	for ($i = 0; $i < count($neuron_ids); $i++) {
	//for ($i = 0; $i < 5; $i++) {
		$all_totals='';
		if ($page!='') {echo $i." ";}
		if ($page=='dal' || $page=='sd') {
			for ($j=0;$j<count($parcel_group);$j=$j+2) {
				if (!in_array($j, $parcels_skip)) {
					$entry_output = "\"";
					$i_adj = $i;
					$j_adj = $j;
					// manual rules for organizing column order as listed on the morphology page
					if ($j == 10) {$j_adj = 16;}
					else if ($j == 12) {$j_adj = 14;}
					else if ($j == 14) {$j_adj = 12;}
					else if ($j == 16) {$j_adj = 10;}
					for ($adi=0;$adi<2;$adi++) {
			            if ($adi == 0) {
		                    $j_adj2 = $j_adj;
		                    $entry_output = $entry_output."&nbsp;";
		                }
		                if ($adi == 1) {
		                    $j_adj2 = $j_adj + 1;
		                    $entry_output = $entry_output."<hr class='hr_sub_cell'>&nbsp;";
		                }
		            
		            	if ($page == 'dal') {
			                $sql    = "SELECT CAST(STD(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_tl, CAST(AVG(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, CAST(AVG(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg_trunk, CAST(COUNT(CAST(filtered_total_length AS DECIMAL(10))) AS DECIMAL(10)) AS count_tl FROM neurite_quantified WHERE neurite_quantified.unique_id=".$neuron_ids[$i_adj]." AND neurite_quantified.neurite='" . $parcel_group[$j_adj2] . "' AND filtered_total_length!='' AND filtered_total_length!=0;";
			                $result = $conn->query($sql);
			                if ($result->num_rows > 0) {
			                    while ($row = $result->fetch_assoc()) {
			                        $avg_trunk = $row['avg_trunk'];
			                        if ($avg_trunk != '' && $avg_trunk != 0) {
			                            $entry_output = $entry_output."<a href='property_page_synpro.php?id_neuron=".$neuron_ids[$i_adj]."&val_property=".$parcel_ids[$j_adj2];
				                            if ($adi == 0){
				                            	$entry_output = $entry_output."&color=red&page=1&sp_page=dal'";}
				                            else {
				                            	$entry_output = $entry_output."&color=blue&page=1&sp_page=dal'";	
				                            }
			                            	$entry_output = $entry_output." title='Mean: " . $row['avg'] . "\\nCount of Recorded Values: " . $row['count_tl'] . "\\nStandard Deviation: " . $row['std_tl'] . "' style='color:";
			                            	if ($adi) {$entry_output = $entry_output."blue";} 
			                            	else {$entry_output = $entry_output."red";}
			                            $entry_output = $entry_output." !important' target='_blank'>" . $avg_trunk . "</a>";                            	
			                        }
			                    }
			                }  
			                //$entry_output = $entry_output.$sql;
		                }
		                elseif ($page == 'sd') {
		                	$sql    = "SELECT CAST(STD(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_sd, CAST(AVG(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, CAST(COUNT(CAST(avg_path_length AS DECIMAL(10))) AS DECIMAL(10)) AS count_sd, CAST(AVG(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg_trunk, CAST(MIN(CAST(min_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS min_sd, CAST(MAX(CAST(max_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS max_sd FROM neurite_quantified WHERE neurite_quantified.unique_id=".$neuron_ids[$i_adj]." AND neurite_quantified.neurite='" . $parcel_group[$j_adj2] . "' AND avg_path_length!='' AND avg_path_length!=0;";
		                	//$entry_output = $entry_output.$sql."<br>";
			                $result = $conn->query($sql);
	                        if ($result->num_rows > 0) {
	                            while ($row = $result->fetch_assoc()) {
	                                $avg_trunk = $row['avg_trunk'];
	                                if ($avg_trunk != '' && $avg_trunk != 0) {
			                            $entry_output = $entry_output."<a href='property_page_synpro.php?id_neuron=".$neuron_ids[$i_adj]."&val_property=".$parcel_ids[$j_adj2];
			                            	if ($adi == 0){
				                            	$entry_output = $entry_output."&color=red&page=1&sp_page=sd'";}
				                            else {
				                            	$entry_output = $entry_output."&color=blue&page=1&sp_page=sd'";	
				                            }
			                            	$entry_output = $entry_output." title='Mean: " . $row['avg'] . "\\nCount of Recorded Values: " . $row['count_sd'] . "\\nStandard Deviation: " . $row['std_sd'] . "\\nMinimum Value: " . $row['min_sd'] . "\\nMaximum Value: " . $row['max_sd'] . "' style='color:";
			                            	if ($adi) {$entry_output = $entry_output."blue";} 
			                            	else {$entry_output = $entry_output."red";}
			                            $entry_output = $entry_output." !important' target='_blank'>" . $avg_trunk . "</a>";
			                        }
			                    }
			                }
		                }                      			
					}
					$entry_output = $entry_output."\",";
					array_push($write_output, $entry_output);				
				} 
			}
			// find all parcel values
			for ($adi = 0; $adi < 2; $adi++) {
		        if ($adi == 0) {
		            $a_or_d = 'Axon: ';
		            $prcl   = '';
		            $nl     = "\\n";
		            $all_parcel_search = new ArrayObject($all_parcel_axon);
		        } else {
		            $a_or_d = 'Dendrite: ';
		            $prcl   = '';
		            $nl     = "";
		            $all_parcel_search = new ArrayObject($all_parcel_dend);	            
		        }
		        if ($page == 'dal') {
			        for ($s_i = 0; $s_i < count($all_parcel_search); $s_i++) {
		                $sql    = "SELECT CAST(AVG(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, CAST(STD(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std, CAST(COUNT(CAST(filtered_total_length AS DECIMAL(10))) AS DECIMAL(10)) AS count_tl FROM neurite_quantified WHERE neurite_quantified.unique_id=".$neuron_ids[$i_adj]." AND neurite_quantified.neurite='" . $all_parcel_search[$s_i] . "' AND filtered_total_length!='' AND filtered_total_length!=0;";
		                $result = $conn->query($sql);
		                if ($result->num_rows > 0) {
		                    $row        = $result->fetch_assoc();
		                    if ($row['count_tl'] > 0 && $row['avg'] != '' && $row['count_tl'] != '' && $row['std'] != '') {
		                    $all_totals = $all_totals . $prcl . $a_or_d . '\\nAverage Total Length: ' . $row['avg'] . ' \\nValues Count: ' . $row['count_tl'] . '\\nStandard Deviation: ' . $row['std'] . $nl;
		                	}
		                }
			    	}
		    	}
		    }
			if ($page == 'dal') {
		    	if ($all_totals=='') {
		    		$all_totals = $all_totals . 'Average Total Length: 0\\nValues Count: 0\\nStandard Deviation: 0';
		    	}
		    	array_push($parcel_output, $neuron_group_long2[$i_adj]."\\n".$all_totals);	
		    }
		    elseif ($page == 'sd') {
				array_push($parcel_output, $neuron_group_long2[$i_adj].$all_totals);
		    }
			  
		}
		elseif ($page=='ps') {	
			$write_output = n_by_m_values($conn, 'ps', $neuron_group_hnc, $neuron_group_long, $i, $write_output, $neuron_ids);
		} 
		elseif ($page=='noc') {	
			$write_output = n_by_m_values($conn, 'noc', $neuron_group_hnc, $neuron_group_long, $i, $write_output, $neuron_ids);
		}
		elseif ($page=='prosyn') {	
			$write_output = n_by_m_values($conn, 'prosyn', $neuron_group_hnc, $neuron_group_long, $i, $write_output, $neuron_ids);
		}
	}

	function n_by_m_values($conn, $type, $neuron_group, $neuron_group_long, $i, $write_output, $neuron_ids) {
		for ($j=0;$j<count($neuron_ids);$j++) {
		//for ($j=0;$j<3;$j++) {
			$entry_output = "";
			if ($type == 'ps') {
				$sql = "SELECT NPS_mean_total as val, NPS_stdev_total as stdev FROM SynproNPSTotal as nt, SynproTypeTypeRel as ttr WHERE nt.source_id=".$neuron_ids[$i]." AND nt.target_id=".$neuron_ids[$j]." AND nt.source_id=ttr.type_id";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { 
					while($row = $result->fetch_assoc()) {
						$val = $row['val'];
						$stdev = $row['stdev'];
						if ($val != '' && $val != 0) {
							$entry_output = $entry_output."<center><a href='property_page_synpro_pvals.php?id_neuron_source=".$neuron_ids[$i]."&id_neuron_target=".$neuron_ids[$j]."&color=blue&page=1&nm_page=ps' title='mean: ".toPrecision($val,4)."\\nstd: ".na_for_zero(toPrecision($stdev,4))."' target='_blank'>".toPrecision($val,4)."</a></center>";
						}
					}
				} 
			}
			elseif ($type == 'noc') {
				$sql = "SELECT NC_mean_total as val, NC_stdev_total as stdev FROM SynproNOCTotal as nt, SynproTypeTypeRel as ttr WHERE nt.source_id=".$neuron_ids[$i]." AND nt.target_id=".$neuron_ids[$j]." AND nt.source_id=ttr.type_id";							
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { 
					while($row = $result->fetch_assoc()) {
						$val = $row['val'];
						$stdev = $row['stdev'];
						if ($val != '' && $val != 0) {
							$entry_output = $entry_output."<center><a href='property_page_synpro_pvals.php?id_neuron_source=".$neuron_ids[$i]."&id_neuron_target=".$neuron_ids[$j]."&color=blue&page=1&nm_page=noc' title='mean: ".toPrecision($val,3)."\\nstd: ".na_for_zero(toPrecision($stdev,3))."' target='_blank'>".toPrecision($val,3)."</a></center>";  
						}
					}
				} 	
			}		
			elseif ($type == 'prosyn') {
				$sql = "SELECT CP_mean_total as val, CP_stdev_total as stdev FROM SynproCPTotal as nt, SynproTypeTypeRel as ttr WHERE nt.source_id=".$neuron_ids[$i]." AND nt.target_id=".$neuron_ids[$j]." AND nt.source_id=ttr.type_id";				
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { 
					while($row = $result->fetch_assoc()) {
						$val = $row['val'];
						$stdev = $row['stdev'];
						if ($val != '' && $val != 0) {
							$entry_output = $entry_output."<center><a href='property_page_synpro_pvals.php?id_neuron_source=".$neuron_ids[$i]."&id_neuron_target=".$neuron_ids[$j]."&color=blue&page=1&nm_page=prosyn' title='mean: ".toPrecision($val,4)."\\nstd: ".na_for_zero(toPrecision($stdev,4))."' target='_blank'>".toPrecision($val,4)."</a></center>";            
						}
					}
				} 	
			}
			array_push($write_output, $entry_output);	
		}

		return $write_output;
	}

	/* 
	Write to File 
	
	$new_row_col is used because a new row occurs every certain
	number of columns when reading the file.
	*/
	if ($page == 'dal') {
		$json_output_file = $path_to_files."adl_db_results.json";
	}
	elseif ($page == 'sd') {
		$json_output_file = $path_to_files."sd_db_results.json";
	}
	elseif ($page == 'ps') {
		$json_output_file = $path_to_files."ps_db_results.json";
	}
	elseif ($page == 'noc') {
		$json_output_file = $path_to_files."noc_db_results.json";
	}
	elseif ($page == 'prosyn') {
		$json_output_file = $path_to_files."prosyn_db_results.json";
	}
	echo "<br>";

	if ($page == 'dal' || $page == 'sd') {
		$output_file = fopen($json_output_file, 'w') or die("Can't open file.");
		/* specify rows to use from template file */
		$init_col = 0;
		$init_col2 = 1;
		$new_row_col = 28;
		$total_neuron_classes = 122;
		$max_rows = 100000;
		/* specify indices */
		$neuron_group_cols = array(); // new file indexes
		$neuron_class_cols = array();
		$total_rows = ($total_neuron_classes*$new_row_col)+(2*$total_neuron_classes);
		$t_out = 0;		
		$n_out = 0;		
		$p_out = 0;
		$nl = $json_new_line; // new line
		/* create arrays of selected template indexes */
		for ($r_i = 0; $r_i < $max_rows; $r_i++) {
			array_push($neuron_group_cols, ($init_col+($new_row_col*$r_i)));
			array_push($neuron_class_cols, ($init_col2+($new_row_col*$r_i)));
		}	

		for ($o_i = 0; $o_i<$total_rows; $o_i++) {
			if ($o_i==($total_rows-1)) {
				$last_index = count($write_output)-1; // last line
				fwrite($output_file, $write_output[$last_index]."]}]}"); 
			}
			elseif (in_array($o_i, $neuron_group_cols)) {
				//if ($o_i>2) {fwrite($output_file, "\"\"]},{\"cell\":[");}
				fwrite($output_file, $neuron_groups_ordered[$t_out]);
				$t_out++;
			}
			elseif (in_array($o_i, $neuron_class_cols)) {
				$line_start = substr($neuron_classes[$n_out], 0, 34);
				$title = $parcel_output[$n_out];
				$line_end = substr($neuron_classes[$n_out], 34);
				if ($line_start != '') {
					$full_line = $line_start." title='".$title."'".$line_end;
				}
				else {
					$full_line = "\"\",";
				}
				fwrite($output_file, $full_line);
				$n_out++;
			}
			else {
				if ($write_output[$p_out] != "") {
					$text_output = $write_output[$p_out].$nl;
				}
				else {
					$text_output = "\"\",".$nl;
				}
				fwrite($output_file, $text_output);
				$p_out++;
			}
			if ($o_i == 100 || $o_i == 1000 || $o_i == 5000 || $o_i == 10000) {
				echo "<br>Output line ".$o_i." written";
			}
		}
		fclose($output_file);	

		echo "<br><br><center>Json file successfully written.<br><br><hr>";	
	}
	elseif ($page == 'ps' || $page == 'noc' || $page == 'prosyn') {
		$output_file = fopen($json_output_file, 'w') or die("Can't open file.");
		/* specify rows to use from template file */
		$init_col = 0;
		$init_col2 = 1;
		$new_row_col = 124;
		$max_rows = 100000;
		/* specify indices */
		$neuron_group_cols = array(); // new file indexes
		$neuron_class_cols = array();
		$total_rows = ($new_row_col*$new_row_col)+(2*$new_row_col);
		$t_out = 0;		
		$n_out = 0;		
		$p_out = 0;
		$nl = $json_new_line; // new line
		/* create arrays of selected template indexes */
		for ($r_i = 0; $r_i < $max_rows; $r_i++) {
			array_push($neuron_group_cols, ($init_col+($new_row_col*$r_i)));
			array_push($neuron_class_cols, ($init_col2+($new_row_col*$r_i)));
		}	

		for ($o_i = 0; $o_i<$total_rows; $o_i++) {
			if ($o_i==($total_rows-1)) {
				$last_index = count($write_output)-1; // last line
				fwrite($output_file, "\"".$write_output[$last_index]."\"]}]}"); 
			}
			elseif (in_array($o_i, $neuron_group_cols)) {
				//if ($o_i>2) {fwrite($output_file, "\"\"]},{\"cell\":[");}
				fwrite($output_file, $neuron_groups_ordered[$t_out]);
				$t_out++;
			}
			elseif (in_array($o_i, $neuron_class_cols)) {
				fwrite($output_file, $neuron_classes_ordered[$n_out]);
				$n_out++;
			}
			else {
				if ($write_output[$p_out] != "") {
					$text_output = "\"".$write_output[$p_out]."\",".$nl;
				}
				else {
					$text_output = "\"\",".$nl;
				}
				fwrite($output_file, $text_output);
				$p_out++;
			}
			if ($o_i == 100 || $o_i == 1000 || $o_i == 5000 || $o_i == 10000) {
				echo "<br>Output line ".$o_i." written";
			}
		}
		fclose($output_file);	

		echo "<br><br><center>Json file successfully written.<br><br><hr>";		
	}
	echo "<br><br>";
?>
</body>
<?php
include ('functions.php');

function format_table_markers($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){

	$count = 0;
	$csv_rows=[];
    	$numHeaders = count($csv_headers);

        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);

	$neuronal_segments = ["CB"=>"CB", "CR"=>"CR", "PV"=>"PV", "5HT-3"=>"5HT-3", "CB1"=>"CB1", "Gaba-a-alpha"=>"GABAa_alfa", "mGluR1a"=>"mGluR1a", "Mus2R"=>"Mus2R", "NPY"=>"NPY", "nNOS"=>"nNOS", 
				"AChE"=>"AChE", "AMIGO2"=>"AMIGO2", "Astn2"=>"Astn2", "Caln"=>"Caln", "CaMKII_alpha"=>"CaMKII_alpha", "ChAT"=>"ChAT", "Chrna2"=>"Chrna2", "CRF"=>"CRF", "Ctip2"=>"Ctip2", 
				"Cx36"=>"Cx36", "CXCR4"=>"CXCR4", "Dcn"=>"Dcn", "Disc1"=>"Disc1", "DYN"=>"DYN", "EAAT3"=>"EAAT3", "ErbB4"=>"ErbB4", "GABA-B1"=>"GABA-B1", 
				"GAT-3"=>"GAT-3", "GluA2"=>"GluA2", "GluA3"=>"GluA3", "GluA4"=>"GluA4", "GlyT2"=>"GlyT2", "Gpc3"=>"Gpc3", "Grp"=>"Grp", "Htr2c"=>"Htr2c", "Id_2"=>"Id_2", 
				"Kv3.1"=>"Kv3_1", "Loc432748"=>"Loc432748", "Man1a"=>"Man1a", "Math-2"=>"Math-2", "mGluR1"=>"mGluR1", "mGluR2"=>"mGluR2", "mGluR8a"=>"mGluR8a", 
				"GABAa\beta 1"=>"GABAa_beta1", "GABAa\beta 2"=>"GABAa_beta2", "GABAa\beta 3"=>"GABAa_beta3", "GABAa \delta"=>"GABAa_delta", "GABAa\gamma%201"=>"GABAa_gamma1", 
				"GABAa\gamma%202"=>"GABAa_gamma2", "mGluR2/3"=>"mGluR2/3", "mGluR3"=>"mGluR3", "mGluR4"=>"mGluR4", "mGluR5"=>"mGluR5", "mGluR5a"=>"mGluR5a", "mGluR7a"=>"mGluR7a", 
				"alpha-actinin-2"=>"a-act2", 
				"MOR"=>"MOR", "Mus1R"=>"Mus1R", "Mus3R"=>"Mus3R", "Mus4R"=>"Mus4R", "Ndst4"=>"Ndst4", "NECAB1"=>"NECAB1", "Neuropilin2"=>"Neuropilin2", "NKB"=>"NKB", "NOV"=>"Nov", 
				"Nr3c2"=>"Nr3c2", "Nr4a1"=>"Nr4a1", "p-CREB"=>"p-CREB", "PCP4"=>"PCP4", "PPE"=>"PPE", "PPTA"=>"PPTA", "Prox1"=>"Prox1", "Prss12"=>"Prss12", "Prss23"=>"Prss23", 
				"PSA-NCAM"=>"PSA-NCAM", "SATB1"=>"SATB1", "SATB2"=>"SATB2", "SCIP"=>"SCIP", "SPO"=>"SPO", "SubP"=>"SubP", "Tc1568100"=>"Tc1568100", "TH"=>"TH", "vAChT"=>"vAChT", 
				"vGAT"=>"vGAT", "vGlut1"=>"vGluT1", "vGluT2"=>"vGluT2", "VILIP"=>"VILIP", "Wfs1"=>"Wfs1", "Y1"=>"Y1", "Y2"=>"Y2", "DCX"=>"DCX", "NeuN"=>"NeuN", "NeuroD"=>"NeuroD", 
				"GAT-1"=>"GAT-1", "Sub P Rec"=>"Sub P Rec", "vGluT3"=>"vGluT3", "CCK"=>"CCK", "ENK"=>"ENK", "NG"=>"NG", "SOM"=>"SOM", "VIP"=>"VIP", "CoupTF II"=>"CoupTF_2", "RLN"=>"RLN", 
				"CGRP"=>"CGRP", "GluA2/3"=>"GluA2/3", "GluA1"=>"GluA1", "AR-beta1"=>"AR-beta1", "AR-beta2"=>"AR-beta2", "BDNF"=>"BDNF", "Bok"=>"Bok", "CaM"=>"CaM", "GABAa\alpha 2"=>"GABAa_alpha2", 
				"GABAa\\alpha 2"=>"GABAa_alpha2",
				"GABAa\\\\alpha 2"=>"GABAa_alpha2",
				"GABAa\alpha 3"=>"GABAa_alpha3","GABAa%5Calpha%204"=>"GABAa_alpha4",
				 "GABAa\alpha 4"=>"GABAa_alpha4", "GABAa\alpha 5"=>"GABAa_alpha5", "GABAa\alpha 6"=>"GABAa_alpha6", "CRH"=>"CRH", "NK1R"=>"NK1R",
				""=>"Unknown"];

	$color_segments = [ 
		'negative-negative_inference'=>'Negative Inference',
		'positive'=>'Positive',
		'negative'=>'Negative',
		'positive_inference-negative_inference'=>'Positive-Negative',
		'positive-negative'=>'Positive-Negative', 
		'negative-positive_inference'=>'Negative',
		'negative-negative_inference'=>'Negative Inference',
		'positive-negative'=>'Positive-Negative',
		'positive-negative'=>'Positive-Negative',
		'positive-negative_inference'=>'Positive-Negative Inference',
		'positive-negative-weak_positive'=>'Positive-Negative Inference',
		'positive-negative-negative_inference'=>'Positive-Negative Inference',
		'positive_inference'=>'Positive Inference',
		'positive-positive_inference'=>'Positive Inference',
		'positive-negative-positive_inference'=>'Positive-Negative Inference',
		'positive-negative-weak_positive-negative_inference'=>'Positive-Negative Inference',
		'positive-positive_inference-negative_inference'=>'Positive-Negative Inference',
		'negative-positive_inference-negative_inference'=>'Positive-Negative Inference',
		'weak_positive'=>'Positive Inference',
		'negative_inference'=>'Negative Inference'];

	$color_cols = ['Positive','Negative','Positive-Negative','Positive Inference','Negative Inference','Positive-Negative Inference'];

	$cols= ["CB", "CR", "PV", "5HT-3", "CB1", "GABAa_alfa", "mGluR1a", "Mus2R", "Sub P Rec", "vGluT3", "CCK", "ENK", "NG", "NPY", "SOM", "VIP", "a-act2", "CoupTF_2", "nNOS", "RLN", "AChE", 
			"AMIGO2", "AR-beta1", "AR-beta2", "Astn2", "BDNF", "Bok", "Caln", "CaM", "CaMKII_alpha", "CGRP", "ChAT", "Chrna2", "CRF", "Ctip2", "Cx36", "CXCR4", "Dcn", "Disc1", "DYN", "EAAT3", 
			"ErbB4", "GABAa_alpha2", "GABAa_alpha3", "GABAa_alpha4", "GABAa_alpha5", "GABAa_alpha6", "GABAa_beta1", "GABAa_beta2", "GABAa_beta3", "GABAa_delta", "GABAa_gamma1", "GABAa_gamma2","GABA-B1", 
		"GAT-1", "GAT-3", "GluA1", "GluA2", "GluA2/3", "GluA3", "GluA4", "GlyT2", "Gpc3", "Grp", "Htr2c", "Id_2", "Kv3_1", "Loc432748", "Man1a", "Math-2", "mGluR1", "mGluR2", 
			"mGluR2/3", "mGluR3", "mGluR4", "mGluR5", "mGluR5a", "mGluR7a", "mGluR8a", "MOR", 
			"Mus1R", "Mus3R", "Mus4R", "Ndst4", "NECAB1", "Neuropilin2", "NKB", "Nov", "Nr3c2", "Nr4a1", "p-CREB", "PCP4", "PPE", "PPTA", "Prox1", "Prss12", "Prss23", "PSA-NCAM", "SATB1", 
			"SATB2", "SCIP", "SPO", "SubP", "Tc1568100", "TH", "vAChT", "vGAT", "vGluT1", "vGluT2", "VILIP", "Wfs1", "Y1", "Y2", "DCX", "NeuN", "NeuroD", "CRH", "NK1R", "Unknown"];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}

	while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
    		// Modify neuron name if necessary
		if (isset($neuron_ids[$rowvalue['neuron_name']])) {
			if (!isset($write_file)) {
				$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php', 'neuron');
			}
		}

		// Extract relevant values
		$subregion = $rowvalue['subregion'];
		$neuron_name = $rowvalue['neuron_name'];
		if(!isset($color_segments[$rowvalue['color']])){ var_dump($rowvalue); }
		$color = $color_segments[$rowvalue['color']];
		$evidence = $neuronal_segments[$rowvalue['evidence']];
		//Exception for this entry -- /php/property_page_markers.php?id_neuron=5001&val_property=GABAa\\alpha 2&color=&page=markers
		if($evidence == 'GABAa_alpha2'){
			if(strlen($rowvalue['color']) ==0){
				$rowvalue['color']='positive';
				$color =$color_segments[$rowvalue['color']];
			}
		}
		 $views = intval($rowvalue['views']);

		 // Initialize arrays if necessary
		 if (!isset($array_subs[$subregion])) {
			 $array_subs[$subregion] = [];
		 }

		 if (!isset($array_subs[$subregion][$neuron_name])) {
			 $array_subs[$subregion][$neuron_name] = initializeNeuronArray($cols, $color_cols);
		 }

		 if (!isset($array_subs[$subregion][$neuron_name][$color])) {
			 $array_subs[$subregion][$neuron_name][$color] = [];
		 }

		 if (!isset($array_subs[$subregion][$neuron_name][$color][$evidence])) {
			 $array_subs[$subregion][$neuron_name][$color][$evidence] = 0;
		 }

		 // Initialize 'total' if it does not exist
		 if (!isset($array_subs[$subregion][$neuron_name][$color]['total'])) {
			 $array_subs[$subregion][$neuron_name][$color]['total'] = 0;
		 }

		 // Increment values
		 $array_subs[$subregion][$neuron_name][$color][$evidence] += intval($views);
		 $array_subs[$subregion][$neuron_name][$color]['total'] += intval($views);

	}
	foreach($array_subs as $subregion => $neuron_names){
		foreach($neuron_names as $neuron_name=>$colors){
			foreach($colors as $color=>$colorVals){
				if (!isset($array_subs[$subregion][$neuron_name][$color]['total'])) {
					$array_subs[$subregion][$neuron_name][$color]['total']=0;
				}
			}
		}
	}
        if(isset($write_file)){
		$total_count = 0;
                // Iterate over the types
                foreach ($array_subs as $type => $subtypes) {
                        $keyCounts = count($subtypes);
                        $typeCellAdded = false;

                        foreach ($subtypes as $subtype => $values) {
                                // Write type to the CSV file only once
                                $typeData = [$type];

                                foreach ($values as $category => $properties) {
                                        // Construct the row data starting with type, subtype, and category
                                        $rowData = array_merge($typeData, [$subtype, $category]);

                                        foreach ($properties as $property => $value) {
                                                if($property == "") continue;
                                                $showVal = ($value >= 1) ? $value : '';

                                                if ($property == 'total') {
                                                        // Include the total in the current row
                                                        $rowData[] = $showVal;
                                                        $total_count += $value;
                                                        // Write the row to the CSV file
                                                        $csv_rows[] = $rowData;
                                                } else {
                                                        $rowData[] = $showVal;
                                                }
                                        }
                                }
                        }
                }

                // Write the total count row at the end of the CSV file
		$totalCountRow = array_merge(["Total Count"], array_fill(1, $numHeaders - 2, ''), [$total_count] );
		$csv_rows[] = $totalCountRow; 

		$csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
                return $csv_data[$csv_tablename];
	}
	//var_dump($array_subs);//exit;
	$i = $j = $k = $total_count = 0;
	$table_string2 = '';

	foreach ($array_subs as $type => $subtypes) {
		$keyCounts = count($subtypes);
		$typeCellAdded = false;

		foreach ($subtypes as $subtype => $values) {
			$keyCounts2 = count($values)+1;//Added this 1 as count is giving 6 but then one row is showing as seperate Added on April 25 2024
			$subtyperowspan = $keyCounts2;
			$typerowspan = $keyCounts * $keyCounts2;

			if (!$typeCellAdded) {
				//echo "typerowspan is:".$typerowspan;
				if ($j%2==0) {
					$table_string2 .= "<tr><td class='lightgreen-bg' rowspan='".$typerowspan."'>".$type."</td>";
				} else {
					$table_string2 .= "<tr><td class='green-bg' rowspan='".$typerowspan."'>".$type."</td>";
				}
				// Set the flag to true once the type cell is added
				$typeCellAdded = true;
			}
			if($i%2==0){
				$table_string2 .= "<td  class='white-bg' rowspan='".$subtyperowspan."'>".$subtype."</td>";
			}else{
				$table_string2 .= "<td  class='blue-bg' rowspan='".$subtyperowspan."'>".$subtype."</td>";
			}

			foreach ($values as $category => $properties) {
				if (in_array($category, $color_cols)) {
					$table_string2 .= "<tr>";
				}
				if($k%2==0){
					$table_string2 .= "<td class='white-bg'>".$category."</td>";
				}else{
					$table_string2 .= "<td class='blue-bg'>".$category."</td>";
				}
				foreach ($properties as $property => $value) {
					// Check if the property is "total"
					if($property == ""){continue;}
					$showval='';
					if($value >= 1){$showval = $value;}

					if($k%2==0){
						$table_string2 .= "<td class='white-bg'>".$showval."</td>";
					}else{
						$table_string2 .= "<td class='blue-bg'>".$showval."</td>";
					}
					if ($property == 'total') {
						// Close the row if the property is "total"
						$table_string2 .= "</tr>";
						$total_count += $value;
						$k++;
					}
				}
			}
			$i++;
			$table_string2 .= "</tr>";
		}
		$j++;
	}
	$table_string2 .= "<tr><td colspan='" . ($numHeaders - 1) . "' class='total-row'>Total Count</td><td>$total_count</td></tr>";

	return $table_string2;
}

function get_markers_property_views_report($conn, $neuron_ids, $views_request=NULL, $write_file = NULL){

	$page_property_views_query = "SELECT t.subregion,
		t.page_statistics_name AS neuron_name,
		derived.color AS color,
		derived.evidence AS evidence,
		SUM(REPLACE(page_views, ',', '')) AS views
			FROM (
					SELECT
					CASE
					WHEN INSTR(page, 'id_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
					WHEN INSTR(page, 'id1_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
					WHEN INSTR(page, 'id_neuron_source=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
					ELSE ''
					END AS neuronID,
					CASE
					WHEN INSTR(page, 'val_property=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1)
					ELSE ''
					END AS evidence,
					CASE
					WHEN INSTR(page, 'color=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1)
					ELSE ''
					END AS color,
					page_views
					FROM ga_analytics_pages
					WHERE page LIKE '%/property_page_%'
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'markers'
					AND (
						LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4
						OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
						OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
					    )
					AND (
							SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
							OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
							OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
					    )
					) AS derived
					JOIN Type AS t ON t.id = derived.neuronID
					WHERE derived.neuronID NOT IN ('4168', '4181', '2232')
					AND t.subregion IS NOT NULL AND t.subregion <> ''
					AND t.page_statistics_name IS NOT NULL AND t.page_statistics_name <> ''
					AND derived.color IS NOT NULL AND derived.color <> ''
					AND derived.evidence IS NOT NULL AND derived.evidence <> ''
					GROUP BY t.subregion, t.page_statistics_name, derived.evidence, derived.color
					ORDER BY t.position";
	//echo $page_property_views_query;
	if ($views_request == "views_per_month" || $views_request == "views_per_year") {
		$page_property_views_query = "SET @sql = NULL;";
		// Build dynamic SQL to create column names
		$base_query = "
			SELECT 
			GROUP_CONCAT(
					DISTINCT
					CONCAT(
						'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index), 
							/* Dynamic part depending on the view request */
							' THEN REPLACE(page_views, \",\", \"\") ELSE 0 END) AS `',
						/* Dynamic part depending on the view request */
						@time_unit, '`'
					      )
					ORDER BY YEAR(day_index) /* For 'views_per_month' also add 'MONTH(day_index)' here */
					SEPARATOR ', '
				    ) INTO @sql                 
			FROM ga_analytics_pages                 
			WHERE   
			page LIKE '%/property_page_%'
			AND (   
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'markers'
			    )   
			AND (   
					LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4
					OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
					OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
			    )
			AND (
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN ('4168', '4181', '2232')
					OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN ('4168', '4181', '2232')
					OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN ('4168', '4181', '2232')
			    );";

		// Determine the specific time unit and formatting based on the request
		if ($views_request == "views_per_month") {              
			$time_unit = "CONCAT(YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3))";
			$ordering = "ORDER BY YEAR(day_index), MONTH(day_index)";
		} elseif ($views_request == "views_per_year") {
			$time_unit = "YEAR(day_index)";
			$ordering = "ORDER BY YEAR(day_index)";
		}

		// Construct the final query
		$page_property_views_query .= str_replace(
				['@time_unit', '@ordering'],
				[$time_unit, $ordering],
				$base_query
				);
		$page_property_views_query .= "
			SET @sql = CONCAT(
					'SELECT 
					t.subregion,
					t.page_statistics_name AS neuron_name,
					derived.color AS color,
					derived.evidence AS evidence, ',
					@sql,
					', SUM(REPLACE(derived.page_views, '','', '''')) AS Total_Views',
					' FROM (
						SELECT
						CASE
						WHEN INSTR(page, \'id_neuron=\') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1)
						WHEN INSTR(page, \'id1_neuron=\') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1)
						WHEN INSTR(page, \'id_neuron_source=\') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1)
						ELSE \'\'
						END AS neuronID,
						CASE
						WHEN INSTR(page, \'val_property=\') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'val_property=\', -1), \'&\', 1)
						ELSE \'\'
						END AS evidence,
						CASE
						WHEN INSTR(page, \'color=\') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'color=\', -1), \'&\', 1)
						ELSE \'\'
						END AS color,
						page_views,
						day_index
						FROM ga_analytics_pages
						WHERE page LIKE \'%/property_page_%\'
						AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'/property_page_\', -1), \'.\', 1) = \'markers\'
						AND (   
								LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1)) = 4
								OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1)) = 4
								OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1)) = 4
						    )   
						AND (   
								SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\')
								OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\')
								OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\')
						    )   
						) AS derived    
						JOIN Type AS t ON t.id = derived.neuronID
						WHERE derived.neuronID NOT IN (\'4168\', \'4181\', \'2232\')
						AND t.subregion IS NOT NULL AND t.subregion <> \'\'
						AND t.page_statistics_name IS NOT NULL AND t.page_statistics_name <> \'\'
						AND derived.color IS NOT NULL AND derived.color <> \'\'
						AND derived.evidence IS NOT NULL AND derived.evidence <> \'\'
						GROUP BY t.subregion, t.page_statistics_name, derived.evidence, derived.color
						ORDER BY t.position;'
						);";

		 $page_property_views_query .= "
			PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}

	$columns = ["Subregion", "Neuron Type Name", "Expression", "CB", "CR", "PV", "5HT-3", "CB1", "GABAa_alfa", "mGluR1a", "Mus2R", "Sub P Rec", "vGluT3", "CCK", "ENK", "NG", "NPY", "SOM", "VIP", "a-act2", 
			"CoupTF_2", "nNOS", "RLN", "AChE", "AMIGO2", "AR-beta1", "AR-beta2", "Astn2", "BDNF", "Bok", "Caln", "CaM", "CaMKII_alpha", "CGRP", "ChAT", "Chrna2", "CRF", "Ctip2", "Cx36", "CXCR4", 
			"Dcn", "Disc1", "DYN", "EAAT3", "ErbB4", "GABAa_alpha2", "GABAa_alpha3", "GABAa_alpha4", "GABAa_alpha5", "GABAa_alpha6", "GABAa_beta1", "GABAa_beta2", "GABAa_beta3", "GABAa_delta", 
			"GABAa_gamma1", "GABAa_gamma2", "GABA-B1", "GAT-1", "GAT-3", "GluA1", "GluA2", "GluA2/3", "GluA3", "GluA4", "GlyT2", "Gpc3", "Grp", "Htr2c", "Id_2", "Kv3_1", "Loc432748", "Man1a", 
			"Math-2", "mGluR1", "mGluR2", "mGluR2/3", "mGluR3", "mGluR4", "mGluR5", "mGluR5a", "mGluR7a", "mGluR8a", "MOR", "Mus1R", "Mus3R", "Mus4R", "Ndst4", "NECAB1", "Neuropilin2", "NKB", "Nov",
			"Nr3c2", "Nr4a1", "p-CREB", "PCP4", "PPE", "PPTA", "Prox1", "Prss12", "Prss23", "PSA-NCAM", "SATB1", "SATB2", "SCIP", "SPO", "SubP", "Tc1568100", "TH", "vAChT", "vGAT", "vGluT1", 
			"vGluT2", "VILIP", "Wfs1", "Y1", "Y2", "DCX", "NeuN", "NeuroD", "CRH", "NK1R", "Unknown", "Total"];
        $table_string='';
	 if(isset($write_file)) {
                $file_name = "markers_evidence_page_";
                if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                        $file_name .= $views_request;
                        return format_table_neurons($conn, $page_property_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request); //Using this universally as this is gonna
                }else{
                        $file_name .= "views"; 
			//return format_table_markers($conn, $page_property_views_query, $table_string, 'markers_evidence_page_views', $columns, $neuron_ids, $write_file);
                        return format_table_markers($conn, $page_property_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file);
                }
	}else{
		$table_string .= get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'markers_evidence_page_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}
?>

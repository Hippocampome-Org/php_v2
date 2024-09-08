<?php
include ('functions.php');

function format_table_morphology($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL) {
    $csv_rows = [];
    $rs = mysqli_query($conn, $query);
    $table_string1 = '';
    $numHeaders = count($csv_headers);
    $total_count = 0;

    $color_segments = ['red' => 'Axon Locations', 'blue' => 'Dendrite Locations', 'somata' => 'Soma Locations', 'violet' => 'Axon-Dendrite Locations', 'redSoma' => 'Axon-Somata Locations', 
			'blueSoma' => 'Dendrite-Somata Locations', 'violetSoma' => 'Axon-Dendrite-Somata Locations', 'reddal' => 'Axon Lengths', 'bluedal' => 'Dendrite Lengths', 
			'redsd' => 'Somatic Distances of Axons', 'bluesd' => 'Somatic Distances of Dendrites', 'violetSomadal' => 'Unknown', 'violetSomasd' => 'Unknown', '' => 'Unknown'];

    $color_cols = ['Axon Locations', 'Dendrite Locations', 'Soma Locations', 'Axon-Dendrite Locations', 'Axon-Somata Locations', 'Dendrite-Somata Locations', 'Axon-Dendrite-Somata Locations', 
		   'Axon Lengths', 'Dendrite Lengths', 'Somatic Distances of Axons', 'Somatic Distances of Dendrites', 'Unknown'];

    $cols = ['DG:SMo', 'DG:SMi', 'DG:SG', 'DG:H', 'CA3:SLM', 'CA3:SR', 'CA3:SL', 'CA3:SP', 'CA3:SO', 'CA2:SLM', 'CA2:SR', 'CA2:SP', 'CA2:SO', 'CA1:SLM', 'CA1:SR', 'CA1:SP', 'CA1:SO', 'Sub:SM', 
		'Sub:SP', 'Sub:PL', 'EC:I', 'EC:II', 'EC:III', 'EC:IV', 'EC:V', 'EC:VI', 'Unknown'];

    $neuronal_segments = ['DG_SMo' => 'DG:SMo', 'DG_SMi' => 'DG:SMi', 'DG_SG' => 'DG:SG', 'DG_H' => 'DG:H', 'CA3_SLM' => 'CA3:SLM', 'CA3_SR' => 'CA3:SR', 'CA3_SL' => 'CA3:SL', 'CA3_SP' => 'CA3:SP', 
			  'CA3_SO' => 'CA3:SO', 'CA2_SLM' => 'CA2:SLM', 'CA2_SR' => 'CA2:SR', 'CA2_SP' => 'CA2:SP', 'CA2_SO' => 'CA2:SO', 'CA1_SLM' => 'CA1:SLM', 'CA1_SR' => 'CA1:SR', 'CA1_SP' => 'CA1:SP', 
			  'CA1_SO' => 'CA1:SO', 'SUB_SM' => 'Sub:SM', 'SUB_SP' => 'Sub:SP', 'SUB_PL' => 'Sub:PL', 'EC_I' => 'EC:I', 'EC_II' => 'EC:II', 'EC_III' => 'EC:III', 'EC_IV' => 'EC:IV', 'EC_V' => 'EC:V', 
			  'EC_VI' => 'EC:VI', '' => 'Unknown'];

    if (!$rs || ($rs->num_rows < 1)) {
	    $table_string1 .= "<tr><td> No Data is available </td></tr>";
	    return $table_string1;
    }

    if (!$array_subs) { $array_subs = []; }

    // Process database rows
    while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
        if (empty($rowvalue['neuron_name']) || empty($rowvalue['subregion'])) {
            continue;
        }

        if (isset($neuron_ids[$rowvalue['neuron_name']])) {
            if (!isset($write_file)) {
                $rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php', 'neuron');
            }
        }

        $subregion = $rowvalue['subregion'];
        $neuron_name = $rowvalue['neuron_name'];
        $color_sp = isset($color_segments[$rowvalue['color_sp']]) ? $color_segments[$rowvalue['color_sp']] : 'Unknown';
        $evidence = isset($neuronal_segments[$rowvalue['evidence']]) ? $neuronal_segments[$rowvalue['evidence']] : 'Unknown';

        if ($evidence == 'GABAa_alpha2' && empty($rowvalue['color_sp'])) {
            $rowvalue['color_sp'] = 'positive';
            $color_sp = $color_segments[$rowvalue['color_sp']] ?? 'Unknown';
        }

        $views = intval($rowvalue['views']);

        if (!isset($array_subs[$subregion])) {
            $array_subs[$subregion] = [];
        }

        if (!isset($array_subs[$subregion][$neuron_name])) {
            $array_subs[$subregion][$neuron_name] = initializeNeuronArray($cols, $color_cols);
        }

        if (!isset($array_subs[$subregion][$neuron_name][$color_sp][$evidence])) {
            $array_subs[$subregion][$neuron_name][$color_sp][$evidence] = 0;
        }

        if (!isset($array_subs[$subregion][$neuron_name][$color_sp]['total'])) {
            $array_subs[$subregion][$neuron_name][$color_sp]['total'] = 0;
        }

        $array_subs[$subregion][$neuron_name][$color_sp][$evidence] += $views;
        $array_subs[$subregion][$neuron_name][$color_sp]['total'] += $views;
    }
    foreach($array_subs as $subregion => $neuron_names){
	    foreach($neuron_names as $neuron_name=>$colors){
		    foreach($colors as $colorvalue=>$colorVals){
			    if (!isset($array_subs[$subregion][$neuron_name][$colorvalue]['total'])) {
				    $array_subs[$subregion][$neuron_name][$colorvalue]['total']=0;
			    }
		    }
	    }
    }
    if (isset($write_file)) {
        foreach ($array_subs as $type => $subtypes) {
            foreach ($subtypes as $subtype => $values) {
                $typeData = [$type];

                foreach ($values as $category => $properties) {
                    $rowData = array_merge($typeData, [$subtype, $category]);

                    foreach ($properties as $property => $value) {
                        if ($property == "") continue;
                        $showVal = ($value >= 1) ? $value : '';

                        if ($property == 'total') {
                            $rowData[] = $showVal;
                            $total_count += $value;
                            $csv_rows[] = $rowData;
                        } else {
                            $rowData[] = $showVal;
                        }
                    }
                }
            }
        }
    	$totalCountRow = array_merge(["Total Count"], array_fill(1, $numHeaders - 2, ''), [$total_count] );
        $csv_rows[] = $totalCountRow;

        $csv_data[$csv_tablename] = ['filename' => toCamelCase($csv_tablename), 'headers' => $csv_headers, 'rows' => $csv_rows];
        return $csv_data[$csv_tablename];
    }

    $i = $j = $k = $total_count = 0;
    $table_string2 = '';

    foreach ($array_subs as $type => $subtypes) {
        $keyCounts = count($subtypes);
        $typeCellAdded = false;

        foreach ($subtypes as $subtype => $values) {
            $keyCounts2 = count($values) + 1; // Adjusted count
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

function get_morphology_property_views_report($conn, $neuron_ids = NULL, $views_request=NULL, $write_file=NULL){
    
	$page_property_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, derived.evidence AS evidence, 
    						CONCAT(derived.color, TRIM(derived.sp_page)) AS 'color_sp', SUM(REPLACE(derived.page_views, ',', '')) AS views
					FROM (
						SELECT page_views, 
							IF(
								INSTR(page, 'id_neuron=') > 0, 
								SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1),
								IF(
									INSTR(page, 'id1_neuron=') > 0, 
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1),
									IF(
										INSTR(page, 'id_neuron_source=') > 0, 
										SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), 
										''
									  )
								  )
							  ) AS neuronID,
							IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') AS evidence,
							IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') AS color,
							IF(INSTR(page, 'sp_page=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'sp_page=', -1), '&', 1), '') AS sp_page
							FROM 
							ga_analytics_pages
							WHERE 
							page LIKE '%/property_page_%'
							AND (
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology'
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro'
							    )
							AND (
									LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 OR
									LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4 OR
									LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
							    )
							AND (
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) OR
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) OR
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
							    )
						) AS derived 
						LEFT JOIN Type AS t ON t.id = derived.neuronID
						WHERE   derived.neuronID NOT IN ('4168', '4181', '2232') 
						GROUP BY 
						t.page_statistics_name, t.subregion, color_sp, derived.evidence ORDER BY t.position";

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
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology'
					OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro'
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

		// Build the main query
		$page_property_views_query .= "
			SET @sql = CONCAT(
					'SELECT t.subregion, t.page_statistics_name AS neuron_name, ',
					'REPLACE(derived.evidence, \'_\', \':\') AS evidence, ',
					'CONCAT(derived.color, TRIM(derived.sp_page)) AS color_sp, ',
					@sql,  -- This is the dynamic column part
					', SUM(REPLACE(derived.page_views, '','', '''')) AS Total_Views',
					' FROM (',
						'    SELECT page_views,',
						'        CASE WHEN INSTR(page, ''id_neuron='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1) ',
						'             WHEN INSTR(page, ''id1_neuron='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1) ',
						'             WHEN INSTR(page, ''id_neuron_source='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1) ',
						'             ELSE NULL END AS neuronID,',
						'        CASE WHEN INSTR(page, ''val_property='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''val_property='', -1), ''&'', 1) ELSE NULL END AS evidence,',
						'        CASE WHEN INSTR(page, ''color='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''color='', -1), ''&'', 1) ELSE NULL END AS color,',
						'        CASE WHEN INSTR(page, ''sp_page='') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''sp_page='', -1), ''&'', 1) ELSE NULL END AS sp_page,',
						'        day_index',
						'    FROM ga_analytics_pages',
						'    WHERE page LIKE ''%/property_page_%''',
						'    AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''morphology'' ',
							'        OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''synpro'')',
							'    AND (LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)) = 4 ',
								'         OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)) = 4 ',
								'         OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)) = 4)',
							'    AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1) NOT IN (''4168'', ''4181'', ''2232'') ',
								'         OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1) NOT IN (''4168'', ''4181'', ''2232'') ',
								'         OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1) NOT IN (''4168'', ''4181'', ''2232''))',
							') AS derived',
						' LEFT JOIN Type AS t ON t.id = derived.neuronID',
						' WHERE derived.neuronID NOT IN (''4168'', ''4181'', ''2232'')',
								' GROUP BY t.subregion, t.page_statistics_name, color_sp, derived.evidence',
								' ORDER BY t.position'
								); ";
		$page_property_views_query .= "PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";

	}

        $columns = ['Subregion', 'Neuron Type Name', 'Neuronal Attribute', 'DG:SMo', 'DG:SMi','DG:SG','DG:H','CA3:SLM','CA3:SR','CA3:SL','CA3:SP','CA3:SO','CA2:SLM','CA2:SR','CA2:SP','CA2:SO','CA1:SLM','CA1:SR','CA1:SP','CA1:SO','Sub:SM','Sub:SP','Sub:PL','EC:I','EC:II','EC:III','EC:IV','EC:V','EC:VI','Unknown','Total'];
        $table_string='';
        if(isset($write_file)) {
		$file_name = "morphology_axonal_and_dendritic_lengths_somatic_distances_evidence_page_";
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
			return format_table_neurons($conn, $page_property_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request); //Using this universally as this is gonna 
		}else{
			$file_name .= "views"; 
			//return format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_axonal_and_dendritic_lengths_somatic_distances_evidence_page_views', $columns, $neuron_ids, $write_file);
			return format_table_morphology($conn, $page_property_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file);
		}
        }else{
		$table_string .= get_table_skeleton_first($columns);
		$table_string .= format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
        }       
} 

?>

<?php
global $csv_data;

function get_neuron_ids($conn){
	$neuron_ids = [];
	$query = "SELECT page_statistics_name, id from Type";
	$rs = mysqli_query($conn,$query);
        if(!$rs || ($rs->num_rows < 1)){
                return $neuron_ids;
        }
	while($row = mysqli_fetch_row($rs))
	{
		$neuron_ids[$row[0]]=$row[1];
	}
	return $neuron_ids;	
}

function get_link($text, $id, $path, $str=NULL){
	if($str == 'pmid'){	$path .= $id."/";	}
	if($str == 'neuron'){	$path .= "?id=".$id;	}
	$url_text = "<a href={$path} target='blank'>{$text}</a>";
	return $url_text;
}

function parseUrl($url) {
    $parsedUrl = parse_url($url);
    
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $params);
        return $params;
    }

    return array();
}

function download_csvfile($functionName, $conn, $param = NULL) {
	$allowedFunctions = ['get_neurons_views_report','get_markers_property_views_report', 'get_morphology_property_views_report', 'get_counts_views_report', 
			     'get_fp_property_views_report','get_pmid_isbn_property_views_report', 'get_domain_functionality_views_report','get_page_functionality_views_report', 
			      'get_views_per_page_report', 'get_pages_views_per_month_report']; // TO restrict any unwanted calls or anything
	$neuron_ids_func = ['get_counts_views_report', 'get_neurons_views_report'];
	if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
		if(isset($param)){
			if (in_array($functionName, $neuron_ids_func)){
				$csv_data = $functionName($conn, $param, $neuron_ids = NULL, true);
			}else{
				$csv_data = $functionName($conn, $param, true);
			}
		}else{
			if (in_array($functionName, $neuron_ids_func)){
				$csv_data = $functionName($conn, $neuron_ids = NULL, true);
			}else{
				$csv_data = $functionName($conn, true);
			}
		}
		// Set headers to initiate file download
		header('Content-Type: text/csv');
		$filename=$csv_data['filename'].".csv";
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		$output = fopen('php://output', 'w');

		// Optionally add CSV headers to the first row
		$headers = $csv_data['headers'];
		fputcsv($output, $headers);

		// Sample data for CSV
		$sampleData = $csv_data['rows'];

		// Loop through the data and write to the CSV output
		foreach ($sampleData as $row) {
			fputcsv($output, $row);
		}

		// Close the output stream
		fclose($output);

		// Terminate the script to prevent sending additional output to the response
		exit();
	} else {
		echo "Invalid function.";
	}

}

function processNeuronLink($neuron_id, $neuron_ids_array, $linkText) {
    $neuron_name = array_search($neuron_id, $neuron_ids_array);
	
    if ($neuron_name !== false) {
        //print($neuron_name); // Print the index (for debugging)
        //print($neuron_id); // Print the original value (for debugging)
        $neuron_id = get_link($neuron_name, $neuron_id, './neuron_page.php', $linkText);
    }
    return $neuron_id;
}

function format_table_synpro($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file=NULL){
	$count = 0;
	$csv_rows = [];
	//echo $query;
        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	$rows = count($csv_headers);
	//For Phases page to replciate the string we show
	$phase_evidences=['all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau,
  AP threshold, fAHP, or APpeak trough.', 'theta'=>'Theta', 'swr_ratio'=>'SWR ratio','firingRate'=>'Firing rate'];
	//Neuronal Segment Data
	$neuronal_segments = ['blue'=>'Dendrites','blueSoma'=>'Dendrites-Somata','red'=>'Axons','redSoma'=>'Axons-Somata','somata'=>'Somata','violet'=>'Axons-Dendrites','violetSoma'=>'Axons-Dendrites-Somata'];
	if(!$rs || ($rs->num_rows < 1)){
		$table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
	}
	if($csv_tablename == 'synpro_table'){
		$csv_headers = ['Subregion', 'Layer', 'Neuron Name', 'Neuronal Segment', 'Page', 'Views'];
		$table_string1 = get_table_skeleton_first($csv_headers);
	}
	else if($csv_tablename == 'synpro_nm_table'){
		$csv_headers = ['Subregion', 'Layer', 'Neuron1 Name', 'Neuronal Segment', 'Subregion', 'Layer', 'Neuron2 Name', 'Neuronal Segment', 'Connection Type', 'Known Connection', 'Axonic Basket', 'Page', 'Views'];
		$table_string1 = get_table_skeleton_first($csv_headers);
	}
	else if($csv_tablename == 'synpro_pvals_table'){
                $csv_headers = ['Neuron1 Name', 'Neuronal Segment', 'Neuron2 Name', 'Neuronal Segment', 'Connection Type', 'Known Connection', 'Axonic Basket', 'Page', 'Views'];         
                $table_string1 = get_table_skeleton_first($csv_headers);
        }
	$i=0;
	while($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC))
	{      
		$row = parseUrl($rowvalue['page']);
		if($csv_tablename == 'synpro_table'){
			if(isset($neuronal_segments[$row['color']])){ $row['color'] = $neuronal_segments[$row['color']]; }
			list($subregion, $layer) = explode('_', $row['val_property']);
			$row['id_neuron'] = processNeuronLink( $row['id_neuron'], $neuron_ids, 'neuron');
 			if(!isset($row['sp_page'])){
				$row['sp_page'] = '';
			}

			$row1=[];$row1['subregion']=$subregion; $row1['layer']=$layer;$row1['neuron_name']=$row['id_neuron']; $row1['neuronal_segment']=$row['color'];$row1['page']=$row['sp_page']; $row1['views']=$rowvalue['views']; 
		}
		else if($csv_tablename == 'synpro_nm_table'){
			$connection_types = ['2'=>'Potential Excitatory Connections', '1'=>'Potential Inhibitory Connections'];
			$row1=[];
			if(isset($row['id1_neuron']) && isset($row['id2_neuron']) ){
				$row['id1_neuron'] = processNeuronLink( $row['id1_neuron'], $neuron_ids, 'neuron');
				$row['id2_neuron'] = processNeuronLink( $row['id2_neuron'], $neuron_ids, 'neuron');

				if(isset($neuronal_segments[$row['color1']])){ $row['color1'] = $neuronal_segments[$row['color1']]; }
				if(isset($neuronal_segments[$row['color2']])){ $row['color2'] = $neuronal_segments[$row['color2']]; }
				list($subregion1, $layer1) = explode('_', $row['val1_property']);
				list($subregion2, $layer2) = explode('_', $row['val2_property']);
				if(isset($connection_types[$row['connection_type']])){ $row['connection_type'] = $connection_types[$row['connection_type']]; }

				$row1['subregion1']=$subregion1; $row1['layer1']=$layer1; $row1['id1_neuron']=$row['id1_neuron'];$row1['neuronal_segment1']=$row['color1']; 
				$row1['subregion2']=$subregion2; $row1['layer2']=$layer2; $row1['id2_neuron']=$row['id2_neuron'];$row1['neuronal_segment2']=$row['color2']; 
			}else{
				$row['id_neuron'] = processNeuronLink( $row['id_neuron'], $neuron_ids, 'neuron');
				if(isset($neuronal_segments[$row['color']])){ $row['color'] = $neuronal_segments[$row['color']]; }
				list($subregion, $layer) = explode('_', $row['val_property']);
				$row1['subregion1']=$subregion; $row1['layer1']=$layer; $row1['id1_neuron']=$row['id_neuron'];$row1['neuronal_segment1']=$row['color']; 
				$row1['subregion2']=''; $row1['layer2']=''; $row1['id2_neuron']='';$row1['neuronal_segment2']=''; 
			}
			if(!isset($row['nm_page'])){
				$row['nm_page'] = '';
			}


			$row1['connection_type']=$row['connection_type'];$row1['known_conn_flag']=$row['known_conn_flag'];
			$row1['axonic_basket_flag']=$row['axonic_basket_flag'];
			$row1['page']=$row['nm_page'];$row1['views']=$rowvalue['views'];
		}
		else if($csv_tablename == 'synpro_pvals_table'){
                        $connection_types = ['2'=>'Potential Excitatory Connections', '1'=>'Potential Inhibitory Connections'];
                        $row1=[];
                        if(isset($row['id_neuron_source']) && isset($row['id_neuron_source']) ){
                                $row['id1_neuron'] = processNeuronLink( $row['id_neuron_source'], $neuron_ids, 'neuron');
                                $row['id2_neuron'] = processNeuronLink( $row['id_neuron_target'], $neuron_ids, 'neuron');

                                if(isset($neuronal_segments[$row['color']])){ $row['color'] = $neuronal_segments[$row['color']]; }

				$row1['id1_neuron']=$row['id1_neuron'];$row1['neuronal_segment1']=$row['color'];
				$row1['id2_neuron']=$row['id2_neuron'];$row1['neuronal_segment2']=''; 
                        }else{
				$row['id1_neuron'] = processNeuronLink( $row['id1_neuron'], $neuron_ids, 'neuron');
				$row['id2_neuron'] = processNeuronLink( $row['id2_neuron'], $neuron_ids, 'neuron');

				if(isset($neuronal_segments[$row['color1']])){ $row['color1'] = $neuronal_segments[$row['color1']]; }
				if(isset($neuronal_segments[$row['color2']])){ $row['color2'] = $neuronal_segments[$row['color2']]; }
				if(isset($connection_types[$row['connection_type']])){ $row['connection_type'] = $connection_types[$row['connection_type']]; }

				$row1['id1_neuron']=$row['id1_neuron'];$row1['neuronal_segment1']=$row['color1']; 
				$row1['id2_neuron']=$row['id2_neuron'];$row1['neuronal_segment2']=$row['color2']; 
                        }
                        if(!isset($row['nm_page'])){
                                $row['nm_page'] = '';
                        }

                        $row1['connection_type']=$row['connection_type'];$row1['known_conn_flag']=$row['known_conn_flag'];
                        $row1['axonic_basket_flag']=$row['axonic_basket_flag'];
                        $row1['page']=$row['nm_page'];$row1['views']=$rowvalue['views'];
                }

		$csv_rows[] = $row1;
		if($i%2==0){ $table_string1 .= '<tr class="white-bg" >';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS
		foreach($row1 as $key => $value) {
			$table_string1 .= "<td>".ucwords($value)."</td>";
		}
		$count += $row1['views'];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}

	if(isset($write_file)){
		$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		return $csv_data[$csv_tablename];
	}	
	else{
		$table_string1 .= "<tr><td colspan='".(count($csv_headers)-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";	
		return $table_string1;
	}
}

function format_table($conn, $query, $table_string, $csv_tablename, $csv_headers, $write_file=NULL, $query2=NULL){
	$count = 0;
	$csv_rows = [];
        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	$rows = count($csv_headers);
	//For Phases page to replciate the string we show
	$phase_evidences=['all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau,
  AP threshold, fAHP, or APpeak trough.', 'theta'=>'Theta', 'swr_ratio'=>'SWR ratio','firingRate'=>'Firing rate'];
	//Neuronal Segment Data
	$neuronal_segments = ['blue'=>'Dendrites','blueSoma'=>'Dendrites-Somata','red'=>'Axons','redSoma'=>'Axons-Somata','somata'=>'Somata','violet'=>'Axons-Dendrites','violetSoma'=>'Axons-Dendrites-Somata'];
	if(!$rs || ($rs->num_rows < 1)){
		$table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
	}
	if(isset($query2)){
		$rs2 = mysqli_query($conn,$query2);
		if(!$rs2 || ($rs2->num_rows < 1)){
			$table_string1 .= "<tr><td> No Data is available </td></tr>";
			return $table_string1;
		}
	}
	$i=0;
	while($row = mysqli_fetch_row($rs))
	{       
		$csv_rows[] = $row;
		$j=0;
		if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS
		if($csv_tablename == 'pmid_isbn_table'){
			$row[0] = get_link($row[0], $row[0], 'https://pubmed.ncbi.nlm.nih.gov/', 'pmid');
			$row[3] = get_link($row[3], $neuron_ids[$row[3]], './neuron_page.php','neuron');
		}
		while($j < $rows){
			//if($row[$j] == 'fp'){ $row[$j] = 'Firing Pattern'; }
			if(isset($phase_evidences[$row[$j]])){ $row[$j] = $phase_evidences[$row[$j]]; }
			if(isset($neuronal_segments[$row[$j]])){ $row[$j] = $neuronal_segments[$row[$j]]; }
			if(isset($neuron_ids[$row[$j]])){ $row[$j] = neuron_ids[$row[$j]]; }
			if($row[$rows-1] > 0){
				$table_string1 .= "<td>".ucwords($row[$j])."</td>";
			}
			$j++;
		}
		$count += $row[$rows-1];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}

	if(isset($query2)){
		while($row = mysqli_fetch_row($rs2)){
	  	 	$csv_rows[] = $row;
			$j=0;
			if($i%2==0){ $table_string1 .= '<tr class="white-bg" >';}
			else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

			while($j < $rows){
				if(isset($phase_evidences[$row[$j]])){ $row[$j] = $phase_evidences[$row[$j]]; }
				if(isset($neuronal_segments[$row[$j]])){ $row[$j] = $neuronal_segments[$row[$j]]; }
				if(isset($neuron_ids[$row[$j]])){ $row[$j] = neuron_ids[$row[$j]]; }
				if($row[$rows-1] > 0){
					$table_string1 .= "<td>".$row[$j]."</td>";
				}
				$j++;
			}
			$count += $row[$rows-1];
			$table_string1 .= "</tr>";
			$i++;//increment for color gradient of the row
		}
	}
	if(isset($write_file)){
		$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
                return $csv_data[$csv_tablename];
        }	
	else{
		$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";	
		return $table_string1;
	}
}

function format_table_combined($conn, $query, $csv_tablename, $csv_headers, $write_file=NULL, $options = []) {
    $count = 0;
    $csv_rows = [];
    $rs = mysqli_query($conn, $query);
    $table_string = '';
    $rows = count($csv_headers);
    if (!$rs || mysqli_num_rows($rs) < 1) {
        return "<tr><td colspan='{$rows}'> No Data is available </td></tr>";
    }

    $i = 0;
    while($row = mysqli_fetch_row($rs)){
	$csv_rows[] = $row;
        // Check for row exclusion based on 'exclude' option
        if (isset($options['exclude']) && in_array($row[0], $options['exclude'])) {
            continue;
        }

        // Apply transformations based on 'format' option
        if (isset($options['format']) && array_key_exists($row[0], $options['format'])) {
            $row[0] = $options['format'][$row[0]];
        }

        // Coloring rows alternately
        $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
        $table_string .= "<tr class='$bgColor'>";

        for ($j = 0; $j < $rows; $j++) {
            // Special handling for 'fp' to 'firing pattern'
            if ($row[$j] === 'fp') {
                $row[$j] = 'firing pattern';
            }

            // Only add data cells if the last column value is > 0
            if ($row[$rows - 1] > 0) {
                $table_string .= "<td>" . htmlspecialchars($row[$j]) . "</td>";
            }
        }

        $count += $row[$rows - 1];
        $table_string .= "</tr>";
        $i++;
    }

    if(isset($write_file)){
	    $csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
	    return $csv_data[$csv_tablename];
    } else{
	    $table_string .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";	
	    return $table_string;
    }
}
function flattenArray($array) {
    $result = [];
    foreach ($array as $value) {
        if (is_array($value)) {
            $result = array_merge($result, flattenArray($value));
        } else {
            $result[] = $value;
        }
    }
    return $result;
}

function bg_wg($colors, $count, $neuronal_segments = NULL, $k)
{
    $table_string2 = '';
    foreach ($colors as $colorKey => $value) {
        $bg_class = ($k % 2 == 0) ? 'white-bg' : 'blue-bg';
        $neuronal_segment = isset($neuronal_segments) ? $neuronal_segments[$colorKey] : $colorKey;

        $table_string2 .= "<td class='$bg_class'>$neuronal_segment</td>";
        $table_string2 .= "<td class='$bg_class'>$value</td>";
        $table_string2 .= "</tr>";

        $count += $value;
        $k++;
    }
    return array($table_string2, $count);
}

function format_table_neurons($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
        $i=0;
	if(!$array_subs){ $array_subs = [];}
	while($row = mysqli_fetch_row($rs)){
		if(isset($write_file)){
			$csv_rows[] = $row;
		}else{
			if(isset($neuron_ids[$row[1]])){
				$row[1] = get_link($row[1], $neuron_ids[$row[1]], './neuron_page.php','neuron');
			}
			if ($array_subs[$row[0]]) {
				if ($array_subs[$row[0]][$row[1]]) {
					if (isset($array_subs[$row[0]][$row[1]][$row[2]])) {
						$array_subs[$row[0]][$row[1]][$row[2]] += $row[$rows-1];
					} else {
						$array_subs[$row[0]][$row[1]][$row[2]] = $row[$rows-1];
					}
				} else {
					$array_subs[$row[0]][$row[1]][$row[2]] = $row[$rows-1];
				}
			} else {
				$array_subs[$row[0]][$row[1]][$row[2]] = $row[$rows-1];
			}
		}
        }
	if(isset($write_file)){
		$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		return $csv_data[$csv_tablename];
	} //If write file it will exit here
	$i=$j=0;
	$table_string2='';
	$table_string2 = "<tr>";
	$count=0;
        foreach($array_subs as $groupKey => $subgroups){
		if($j%2==0){
			$rowspan = count($subgroups);
			$table_string2 .= "<td class='lightgreen-bg' rowspan='".$rowspan."'>".$groupKey."</td>";
		}else{
			$rowspan = count($subgroups);
			$table_string2 .= "<td class='green-bg' rowspan='".$rowspan."'>".$groupKey."</td>";
		}
    		foreach ($subgroups as $subgroupKey => $colors) {
			if($i%2==0){
				$table_string2 .= "<td class='white-bg' rowspan='".count($colors)."'>".$subgroupKey;
				$table_string2 .= "</td>";
				list($table_stringt, $count) = bg_wg($colors, $count, $neuronal_segments=NULL, $k=0);
				$table_string2 .= $table_stringt;
				$i++;
			}
			else{ 
				$table_string2 .= "<td class='blue-bg' rowspan='".count($colors)."'>".$subgroupKey;
				$table_string2 .= "</td>";
				list($table_stringt, $count) = bg_wg($colors, $count, $neuronal_segments=NULL, $k=1);
				$table_string2 .= $table_stringt;
				$i++;
			}
		}
		$j++;
        }
	$table_string1 .= $table_string2;

	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
	return $table_string1;
}

function format_table_markers($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	if(($rows > 3) && ($csv_tablename=='morphology_property')){
		$neuronal_segments = ['blue'=>'Dendrites','blueSoma'=>'Dendrites-Somata','red'=>'Axons','redSoma'=>'Axons-Somata','somata'=>'Somata','violet'=>'Axons-Dendrites','violetSoma'=>'Axons-Dendrites-Somata'];
	}
	if(($rows > 3) && ($csv_tablename=='phases')){
		//For Phases page to replciate the string we show
		$neuronal_segments = ['all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.', 'theta'=>'Theta', 'swr_ratio'=>'SWR ratio','firingRate'=>'Firing rate',''=>''];
	}
	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
        $i=0;
	if(!$array_subs){ $array_subs = [];}
	while($row = mysqli_fetch_row($rs)){
		$csv_rows[] = $row;

		if(isset($neuron_ids[$row[1]])){
			$row[1] = get_link($row[1], $neuron_ids[$row[1]], './neuron_page.php','neuron');
		}

		if(($rows > 3)){
			if ($csv_tablename == 'morphology_property' || $csv_tablename == 'phases') {
				$index2 = ($csv_tablename == 'morphology_property') ? $row[2] : $row[3];
				$index2 = ($csv_tablename == 'phases') ? $row[3] : $row[2];
				$index2 = $row[2];

				if ($array_subs[$row[0]]) {
					if ($array_subs[$row[0]][$row[1]]) {
						if (isset($array_subs[$row[0]][$row[1]][$index2])) {
							$array_subs[$row[0]][$row[1]][$index2] += $row[$rows-1];
						} else {
							$array_subs[$row[0]][$row[1]][$index2] = $row[$rows-1];
						}
					} else {
						$array_subs[$row[0]][$row[1]][$index2] = $row[$rows-1];
					}
				} else {
					$array_subs[$row[0]][$row[1]][$index2] = $row[$rows-1];
				}
			 }
		}
		else{
			if($array_subs[$row[0]]){
				if($array_subs[$row[0]][$row[1]]){
					$array_subs[$row[0]][$row[1]] += $row[$rows-1];
				}else{
					$array_subs[$row[0]][$row[1]] = $row[$rows-1];
				}
			}else{
				$array_subs[$row[0]][$row[1]] = $row[$rows-1];
			}
		}
        }
	$i=$j=0;
	$table_string2='';
	$table_string2 = "<tr>";
        foreach($array_subs as $groupKey => $subgroups){
		if($j%2==0){
			if(($rows > 3) && ($csv_tablename=='morphology_property')){
				$keyCounts = count(array_keys($subgroups));
				$flattenedArray = flattenArray($subgroups);
				$values = array_values($flattenedArray);
				$valueCounts = count(array_keys($values));
				$rowspan = $valueCounts;
				$table_string2 .= "<td class='lightgreen-bg' rowspan='".$rowspan."'>".$groupKey."</td>";
			}
			else if(($rows > 3) && ($csv_tablename=='phases')){
				 $rowspan = count($subgroups);
                                 $table_string2 .= "<td class='lightgreen-bg' rowspan='".$rowspan."'>".$groupKey."</td>";

			}else{
				$table_string2 .= "<td class='lightgreen-bg' rowspan='".count($subgroups)."'>".$groupKey."</td>";
			}
		}else{
			if(($rows > 3) && ($csv_tablename=='morphology_property')){
				$keyCounts = count(array_keys($subgroups));
				$flattenedArray = flattenArray($subgroups);
				$values = array_values($flattenedArray);
				$valueCounts = count(array_keys($values));
				$rowspan = $valueCounts;
				$table_string2 .= "<td class='green-bg' rowspan='".$rowspan."'>".$groupKey."</td>";
			}
			else if(($rows > 3) && ($csv_tablename=='phases')){
				$rowspan = count($subgroups);
				$table_string2 .= "<td class='green-bg' rowspan='".$rowspan."'>".$groupKey."</td>";
			}else{
				$table_string2 .= "<td class='green-bg' rowspan='".count($subgroups)."'>".$groupKey."</td>";
			}
		}
    		foreach ($subgroups as $subgroupKey => $colors) {
			if($i%2==0){
				if(($rows > 3) && (($csv_tablename=='morphology_property') || ($csv_tablename=='phases'))){
					$table_string2 .= "<td class='white-bg' rowspan='".count($colors)."'>".$subgroupKey;
					$table_string2 .= "</td>";
					list($table_stringt, $count) = bg_wg($colors, $count, $neuronal_segments, $k=0);
					$table_string2 .= $table_stringt;
				}else{
					$table_string2 .= "<td class='white-bg' >".$subgroupKey."</td>";
					$table_string2 .= "<td class='white-bg' >".$colors."</td>";
					$table_string2 .= "</tr>";
					$count += $colors;
				}
				$i++;
			}
			else{ 
				if(($rows > 3) && (($csv_tablename=='morphology_property') || ($csv_tablename=='phases'))){
					$table_string2 .= "<td class='blue-bg' rowspan='".count($colors)."'>".$subgroupKey;
					$table_string2 .= "</td>";
					list($table_stringt, $count) = bg_wg($colors, $count, $neuronal_segments, $k=1);
					$table_string2 .= $table_stringt;
				}else{
					$table_string2 .= "<td class='blue-bg' >".$subgroupKey."</td>";
                                	$table_string2 .= "<td class='blue-bg' >".$colors."</td>";
					$table_string2 .= "</tr>";
					$count += $colors;
				}
				$i++;
			}
		}
		$j++;
        }
	$table_string1 .= $table_string2;
	if(isset($write_file)){
		$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		return $csv_data[$csv_tablename];
	}
	else{
		$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
        	return $table_string1;
	}
}

function get_page_views($conn){ //Passed on Dec 3 2023
	$page_views_query = "SELECT YEAR(day_index) AS year, 
		MONTH(day_index) AS month, 
		SUM(views) AS views
			FROM ga_analytics_pages_views 
			WHERE views > 0
			GROUP BY YEAR(day_index), MONTH(day_index)";

	$rs = mysqli_query($conn,$page_views_query);
	$result_page_views_array = array();
	while($row = mysqli_fetch_row($rs))
	{
		array_push($result_page_views_array, $row);
	}
	return $result_page_views_array;
}

function get_views_per_page_report($conn, $write_file=NULL){ //Passed $conn on Dec 3 2023

	$page_views_query = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS views  FROM
					ga_analytics_pages gap WHERE gap.day_index IS NULL GROUP BY gap.page order by views desc";
	//echo $page_views_query;
	$page_views_query2 = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS views FROM
					ga_analytics_pages gap WHERE gap.day_index IS NOT NULL and gap.page != '/php/' GROUP BY gap.page order by views desc";
	//echo $page_views_query2;

	$columns = ['Page', 'Views'];
	if(isset($write_file)) {
                return format_table($conn, $page_views_query, $table_string, 'views_per_page', $columns, $write_file, $page_views_query2);
        }
        else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table($conn, $page_views_query, $table_string, 'views_per_page', $columns, $write_file=NULL, $page_views_query2);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_pages_views_per_month_report($conn, $write_file=NULL){ //Passed $conn on Dec 3 2023
	
	$page_views_per_month_query = "select concat(DATE_FORMAT(day_index,'%b'), '-', YEAR(day_index)) as dm, 
				sum(replace(views,',','')) as views 
			     from ga_analytics_pages_views where views > 0 
			     GROUP BY YEAR(day_index), MONTH(day_index)";
	//echo $page_views_per_month_query;
	$columns = ['Month-Year', 'Views'];
	if(isset($write_file)) {
		return format_table($conn, $page_views_per_month_query, $table_string, 'page_views_per_month', $columns, $write_file);
        }else{  
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table($conn, $page_views_per_month_query, $table_string, 'page_views_per_month', $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_table_skeleton_first($cols){
	$table_string1 = "<table>";
	if($cols){
		$table_string1 .= "<tr>";
		foreach($cols as $col){
			$table_string1 .= "<th>".$col."</th>";
		}
		$table_string1 .= "</tr>";
	}
	$table_string1 .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	return $table_string1;
}

function get_table_skeleton_end(){
	return "</tbody></table>";
}

function get_neurons_views_report($conn, $neuron_ids=NULL, $write_file=NULL){ //Passed on Dec 3 2023
	$page_neurons_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, 
		SUM(CASE WHEN derived.page LIKE '%property_page_counts.php?id_neuron=%' THEN 1 ELSE 0 END) AS property_page_counts, 
		SUM(REPLACE(page_views, ',', '')) AS views 
			FROM  
			(
			 SELECT page, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
			 FROM ga_analytics_pages WHERE 
			 ( page LIKE '%id_neuron=%' AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) )
			 OR
			 ( page LIKE '%property_page_counts.php?id_neuron=%' AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) )
			) AS derived
			JOIN Type AS t ON t.id = derived.neuronID GROUP BY
			t.page_statistics_name,  t.subregion 
			ORDER BY 
			CASE
			WHEN derived.page LIKE '%property_page_counts.php?id_neuron=%' THEN 1
			ELSE 0
			END, t.position";
     
	$columns = ['Subregion', 'Neuron Type Name', 'Census', 'Views'];
	$table_string = get_table_skeleton_first($columns);
	if(isset($write_file)) {
		return format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids= NULL, $write_file);
	}else{
		$table_string .= format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_morphology_property_views_report($conn, $write_file=NULL){
	$page_property_views_query = "SELECT
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', 1) AS subregion,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1) AS layer,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '_', -1) AS color,
					SUM(REPLACE(page_views, ',', '')) AS views
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%property_page_morphology.php?id_neuron=%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			GROUP BY
			subregion, layer, color";
	//echo $page_property_views_query;

	$array_subs = ["DG"=>["SMo"=>[],"SMi"=>[],"SG"=>[],"H"=>[]],"CA3"=>["SLM"=>[], "SR"=>[], "SL"=>[], "SP"=>[],"SO"=>[]],"CA2"=>["SLM"=>[],"SR"=>[],"SP"=>[],"SO"=>[]],"CA1"=>["SLM"=>[],"SR"=>[],"SP"=>[],"SO"=>[]],"SUB"=>["SM"=>[],"SP"=>[],"PL"=>[]],"EC"=>["I"=>[],"II"=>[],"III"=>[],"IV"=>[],"V"=>[],"VI"=>[]]];
	
	
	$columns = ['Subregion', 'Layer', 'Neuronal Segment', 'Views'];
	if(isset($write_file)) {
		return format_table_markers($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids = NULL, $write_file, $array_subs);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids=NULL, $write_file=NULL, $array_subs);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_pmid_isbn_property_views_report($conn, $write_file=NULL){

	$page_pmid_isbn_property_views_query = " SELECT linking_pmid_isbn, t.subregion, layer, t.page_statistics_name as neuron_name, color, SUM(REPLACE(page_views, ',', '')) AS views
                        FROM
                        (
                                SELECT 
                                IF(INSTR(page, 'linking_pmid_isbn=') > 0,SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'linking_pmid_isbn=', -1), '&', 1),'') AS linking_pmid_isbn,
                                IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1),'')  AS layer, 
                                SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1) AS neuronID,
                                IF(INSTR(page, 'color=') > 0,SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1),'') as color, page_views
                                FROM ga_analytics_pages
                                WHERE
                                page LIKE '%property_page_morphology_linking_pmid_isbn.php?id_neuron=%'
                                AND LENGTH(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4
                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        ) AS derived
                        JOIN Type AS t ON t.id = derived.neuronID
                        GROUP BY
linking_pmid_isbn, t.subregion, layer, t.page_statistics_name, color  order by t.position";
	//echo $page_pmid_isbn_property_views_query;

	$columns = ['PubMed ID/ISBN', 'Subregion', 'Layer', 'Neuron Type Name', 'Neuronal Segment', 'Views'];
	if(isset($write_file)) {
		return format_table($conn, $page_pmid_isbn_property_views_query, $table_string, 'pmid_isbn_table', $columns, $write_file);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table($conn, $page_pmid_isbn_property_views_query, $table_string, 'pmid_isbn_table', $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_markers_property_views_report($conn, $write_file = NULL){

	$page_property_views_query = "SELECT
		SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1) AS markers,
		SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1) AS color,
		SUM(REPLACE(page_views, ',', '')) AS views
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%property_page_markers.php?id_neuron=%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			GROUP BY
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'property_page_markers.php', -1), '&', 1)
			ORDER BY
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1)";
	//echo $page_property_views_query;
	$columns = ['Markers', 'Expression', 'Views'];
	if(isset($write_file)) {
		return format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns, $neuron_ids = NULL, $write_file);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns);
		$table_string .= get_table_skeleton_end();

		echo $table_string;
	}
}

function get_counts_views_report($conn, $page_string=NULL, $neuron_ids=NULL, $write_file = NULL){

	// Initialize the table string and columns array outside the conditional logic
	$table_string = '';
	$columns = [];

	// Base part of the SQL query
	$page_counts_views_query = "SELECT ";

	// Check for 'phases' or 'counts' page types
	if ($page_string == 'counts') {
		$columns = ['Subregion', 'Neuron Type Name', 'Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query .= "t.subregion, t.page_statistics_name AS neuron_name, SUM(REPLACE(page_views, ',', '')) AS views 
				FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
					FROM ga_analytics_pages WHERE page LIKE '%property_page_{$pageType}.php?id_neuron=%' 
					AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
					AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY t.page_statistics_name ORDER BY t.position";
        //echo $page_neurons_views_query;

	}

	// Check for 'phases' page types
	if ($page_string == 'phases') {
		$columns = ['Subregion', 'Neuron Type Name', 'Evidence', 'Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query .= "t.subregion, t.page_statistics_name AS neuron_name, derived.evidence, SUM(REPLACE(page_views, ',', '')) AS views 
				FROM (SELECT IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') as evidence,
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
					FROM ga_analytics_pages WHERE page LIKE '%property_page_{$pageType}.php?id_neuron=%' 
					AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
					AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY t.page_statistics_name ORDER BY t.position";
		//echo  $page_counts_views_query;
	}

	// Check for 'synpro' or 'synpro_nm' page types
	if ($page_string == 'synpro' || $page_string == 'synpro_nm' || $page_string == 'synpro_pvals') {
		$columns = ['Subregion', 'Layer', 'Neuron Type Name', 'Neuronal Segment', 'Views'];
		$pageType = (($page_string == 'synpro') ? 'property_page_synpro.php' :  (($page_string == 'synpro_nm') ? 'property_page_synpro_nm.php' : 'property_page_synpro_pvals.php'));
		print($pageType);
		// Add 'Sp Page' column if page_string is 'synpro'
		if ($page_string == 'synpro') {
			array_splice($columns, 4, 0, ['Sp Page']); // Insert 'Sp Page' at the correct position
		}
		

		 $page_counts_views_query .= " derived.page, SUM(REPLACE(page_views, ',', '')) AS views
                                                FROM (SELECT page, page_views, SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1) AS neuronID
                                                        FROM ga_analytics_pages
                                                        WHERE  page LIKE '%$pageType?id_neuron=%'
                                                AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4
                                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)

                                                UNION ALL

                                                SELECT page, page_views,
                                                       SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id1_neuron=', -1), '&', 1) AS neuronID
                                                               FROM ga_analytics_pages
                                                               WHERE page LIKE '%$pageType?id1_neuron=%'
                                                               AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
                                                               AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                                               
                                                UNION ALL

                                                SELECT page, page_views,
                                                       SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron_source=', -1), '&', 1) AS neuronID
                                                               FROM ga_analytics_pages
                                                               WHERE page LIKE '%$pageType?id_neuron_source=%'
                                                               AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
                                                               AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                               
                                               )   AS derived JOIN Type AS t ON t.id = derived.neuronID
                                                GROUP BY  derived.page ORDER BY t.position DESC";
	}

	// Initialize table with columns and execute the query if columns array is not empty
	$table_string = get_table_skeleton_first($columns);
	$csv_tablename = $page_string."_table";
	if ($page_string == 'synpro' || $page_string == 'synpro_nm' || $page_string == 'synpro_pvals') {
		if(isset($write_file)) {
			$table_string = '';
			return format_table_synpro($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns, $neuron_ids = NULL, $write_file);
        	}else{
			$table_string = '';
			$table_string .= format_table_synpro($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns, $neuron_ids);
			//echo $page_counts_views_query;
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}
	}else{
		if(isset($write_file)) {
			return format_table_markers($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids = NULL, $write_file);
        	}else{
			$table_string .= format_table_markers($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids);
			//echo $page_counts_views_query;
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}

	}
	
}

function get_fp_property_views_report($conn, $write_file=NULL){
	$fp_format = [
		'ASP.' => 'Adapting Spiking',
		'ASP.ASP.' => 'Adapting Apiking followed by (slower) Adapting Spiking',
		'ASP.NASP' => 'Non-Adapting spiking preceded by Adapting Spiking',
		'ASP.SLN' => 'silence preceded by Adapting Spiking',
		'D.' => 'Delayed Spiking',
		'D.ASP.' => 'Delayed Adapting Spiking',
		'D.NASP' => 'Delayed Non-Sdapting Spiking',
		'D.PSTUT' => 'Delayed Persistent Stuttering',
		'D.RASP.NASP' => 'Non-Adapting Spiking preceded by Delayed Rapidly Adapting Spiking',
		'NASP' => 'Non-Adapting Spiking',
		'PSTUT' => 'Persistent Stuttering',
		'PSWB' => 'Persistent Slow-Wave Bursting',
		'RASP.' => 'Rapidly Adapting Spiking',
		'RASP.ASP.' => 'Rapidly Adapting Spiking followed by Adapting Spiking',
		'RASP.NASP' => 'Non-Adapting Spiking preceded by Rapidly Adapting Spiking',
		'RASP.SLN' => 'Silence preceded by Rapidly Adapting Spiking',
		'TSTUT.' => 'Transient Stuttering',
		'TSTUT.NASP' => 'Non-Adapting Spiking preceded by Transient Stuttering',
		'TSTUT.PSTUT' => 'Transient Stuttering followed by Persistent Stuttering',
		'TSTUT.SLN' => 'Silence preceded by Transient Stuttering',
		'TSWB.NASP' => 'Non-Adapting Spiking preceded by Transient Slow-Wave Bursting',
		'TSWB.SLN' => 'Silence preceded by Transient Slow-Wave Bursting',
		'D.TSWB.NASP' => 'Non-Adapting Spiking preceded by Delayed Transient Slow-Wave Bursting',
		'D.TSTUT.' => 'Delayed Persistent Stuttering',
		'TSTUT.ASP.' => 'Transient Stuttering followed by Adapting Spiking'
			];

	$page_fp_property_views_query = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1) AS fp,
				 SUM(REPLACE(page_views, ',', '')) AS views
		FROM ga_analytics_pages WHERE page LIKE '%property_page_fp.php?id_neuron=%'
		AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
		GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1)
		ORDER BY views DESC";

	//echo $page_fp_property_views_query;
	$columns = ['Firing Pattern', 'Views'];
	$options = ['format' => $fp_format,];
	if(isset($write_file)) {
		return format_table_combined($conn, $page_fp_property_views_query, 'fp_property_table', $columns, $write_file, $options);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_fp_property_views_query, 'fp_property_table', $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_domain_functionality_views_report($conn, $write_file = NULL){
	$page_functionality_views_query = "SELECT
		SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) AS property_page,
		SUM(REPLACE(page_views, ',', '')) AS views
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%/property_page_%'
			AND (LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1)) = 4
					OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
					OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4)
			AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
					OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
					OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			    )
			-- AND page NOT LIKE '%connectivity_orig%'
			-- AND page NOT LIKE '%connectivity%'
			-- AND page NOT LIKE '%connectivity_test%'
			-- AND page NOT LIKE '%synpro_nm_old2%'
			GROUP BY
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '?', 1)";
	//Excluded above as we are not showing the pages as tables to tally
	//echo $page_functionality_views_query;
	$columns = ['Property', 'Views'];
	if(isset($write_file)) {
		return format_table($conn, $page_functionality_views_query, $table_string, 'domain_func_table', $columns, $write_file);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table($conn, $page_functionality_views_query, $table_string, 'domain_func_table', $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_page_functionality_views_report($conn, $write_file=NULL){

	$page_functionality_views_query = "SELECT 
		CASE 
		WHEN page LIKE '%find_author.php%' THEN 'find_author'
		WHEN page LIKE '%index.php%' THEN 'index'
		WHEN page LIKE '%ephys.php%' THEN 'ephys'
		WHEN page LIKE '%Help_%' THEN 'Help'
		WHEN page LIKE '%analytics%' THEN 'analytics'
		WHEN page LIKE '%user_feedback%' THEN 'user_feedback'
		WHEN page LIKE '%phases%' THEN 'phases'
		WHEN page LIKE '%bot-traffic%' THEN 'bot'
		WHEN page = '/' THEN '/'
		WHEN page LIKE '%neuron_by_pattern%' THEN 'neuron_by_pattern'
		WHEN page LIKE '%synapse_probabilities%' THEN 'synapse_probabilities'
		WHEN page LIKE '%synaptome.php%' THEN 'synaptome'
		WHEN page LIKE '%synaptome_modeling.php%' THEN 'synaptome_modeling'
		WHEN page LIKE '%synaptome_model%' THEN 'synaptome_model'
		WHEN page LIKE '%/hipp Better than reCAPTCHA：vaptcha.cn%' THEN 'CAPTCHA'
		WHEN page LIKE '%search_engine%' THEN 'search_engine'
		WHEN page LIKE '%find_neuron_name.php%' THEN 'find_neuron_name'
		WHEN page LIKE '%find_neuron_term.php%' THEN 'find_neuron_term'
		WHEN page LIKE '%neuron_page%' THEN 'neuron_page'
		WHEN page LIKE '%search.php%' THEN 'search'
		WHEN page LIKE '%smtools%' THEN 'smtools'
		WHEN page LIKE '%synaptic_mod_sum.php%' THEN 'synaptic_mod_sum'
		WHEN page LIKE '%firing_patterns.php%' THEN 'firing_patterns'
		WHEN page LIKE '%/synaptic_probabilities/php/%' THEN 'synaptic_probabilities'
		WHEN page LIKE '%view_fp_image.php%' THEN 'view_fp_image'
		WHEN page LIKE '%izhikevich_model.php%' THEN 'izhikevich_model'
		WHEN page LIKE '%markers.php%' THEN 'markers landing'
		WHEN page LIKE '%counts.php%' THEN 'counts landing'
		WHEN page LIKE '%connectivity.php%' THEN 'connectivity'
		WHEN page LIKE '%morphology.php%' THEN 'morphology landing'
		WHEN page LIKE '%simulation_parameters.php%' THEN 'simulation_parameters'
		WHEN page LIKE '%tools.php%' THEN 'tools'
		WHEN page = '/php/' and day_index is null THEN '/php/' 
		WHEN page = '/php/' and day_index is not null THEN 'not php' 
		ELSE 'Landing Page'
		END AS property_page,
		    SUM(REPLACE(page_views, ',', '')) AS views
			    FROM ga_analytics_pages
			    GROUP BY property_page
			    ORDER BY 
			    views DESC ";
	//echo $page_functionality_views_query;
	$options = ['exclude' => ['not php'],];
	$columns = ['Property', 'Views'];
	if(isset($write_file)) {
		return format_table_combined($conn, $page_functionality_views_query, 'func_views_table',  $columns, $write_file, $options);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_functionality_views_query, 'func_views_table',  $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

?>

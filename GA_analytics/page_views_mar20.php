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

function download_csvfile($functionName, $conn, $neuron_ids = NULL, $param = NULL) {
	$allowedFunctions = ['get_neurons_views_report','get_markers_property_views_report', 'get_morphology_property_views_report', 'get_counts_views_report', 
			     'get_fp_property_views_report','get_pmid_isbn_property_views_report', 'get_domain_functionality_views_report','get_page_functionality_views_report', 
			      'get_views_per_page_report', 'get_pages_views_per_month_report']; // TO restrict any unwanted calls or anything
	$neuron_ids_func = ['get_counts_views_report', 'get_neurons_views_report','get_morphology_property_views_report', 'get_markers_property_views_report'];
	if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
		if(isset($param)){
			if (in_array($functionName, $neuron_ids_func)){
				$csv_data = $functionName($conn, $param, $neuron_ids, true);
			}else{
				$csv_data = $functionName($conn, $param, true);
			}
		}else{
			if (in_array($functionName, $neuron_ids_func)){
				$csv_data = $functionName($conn, $neuron_ids, true);
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

function processNeuronLink($neuron_id, $neuron_ids_array, $linkText, $write_file=NULL) {
    $neuron_name = array_search($neuron_id, $neuron_ids_array);
    if ($neuron_name !== false) {
	    if(isset($write_file)){
		    $neuron_id=$neuron_name;
	    }else{
		    $neuron_id = get_link($neuron_name, $neuron_id, './neuron_page.php', $linkText);
	    }
    }
    return $neuron_id;
}
/*
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
*/

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
        $neuronal_segment = isset($neuronal_segments) ? (isset($neuronal_segments[$colorKey]) ? $neuronal_segments[$colorKey] : $colorKey) : $colorKey;

        $table_string2 .= "<td class='$bg_class'>$neuronal_segment</td>";
        $table_string2 .= "<td class='$bg_class'>$value</td>";
        $table_string2 .= "</tr>";

        $count += $value;
        $k++;
    }
    return array($table_string2, $count);
}

function format_table_neurons($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL) {
    $count = 0;
    $csv_rows = [];
    $rs = mysqli_query($conn, $query);
    $table_string1 = '';
    $rows = count($csv_headers);
    if (!$rs || $rs->num_rows < 1) {
        $table_string1 .= "<tr><td> No Data is available </td></tr>";
        return $table_string1;
    }
    if (!$array_subs) {
        $array_subs = [];
    }
    while ($row = mysqli_fetch_row($rs)) {
        if (isset($write_file)) {
            $csv_rows[] = $row;
        } else {
            // Increment count
            $count += $row[$rows - 1];
            // Modify subgroup key if neuron ID exists
            if (isset($neuron_ids[$row[1]])) {
                $row[1] = get_link($row[1], $neuron_ids[$row[1]], './neuron_page.php', 'neuron');
            }
            // Initialize array if not set
            if (!isset($array_subs[$row[0]][$row[1]][$row[2]])) {
                $array_subs[$row[0]][$row[1]][$row[2]] = 0;
            }
            // Increment value
            $array_subs[$row[0]][$row[1]][$row[2]] += $row[$rows - 1];
        }
    }
    if (isset($write_file)) {
        $csv_data[$csv_tablename] = ['filename' => $csv_tablename, 'headers' => $csv_headers, 'rows' => $csv_rows];
        return $csv_data[$csv_tablename];
    }
    // Construct table string
    foreach ($array_subs as $groupKey => $subgroups) {
        $groupBgClass = ($i % 2 == 0) ? 'lightgreen-bg' : 'green-bg';
        $table_string1 .= "<tr><td class='$groupBgClass' rowspan='" . count($subgroups) . "'>$groupKey</td>";
        foreach ($subgroups as $subgroupKey => $colors) {
            $subgroupBgClass = ($i % 2 == 0) ? 'white-bg' : 'blue-bg';
            $table_string1 .= "<td class='$subgroupBgClass' rowspan='" . count($colors) . "'>$subgroupKey</td>";
            foreach ($colors as $color => $value) {
                $colorBgClass = ($i % 2 == 0) ? 'white-bg' : 'blue-bg';
                $table_string1 .= "<td class='$colorBgClass'>$color</td>";
                $table_string1 .= "<td class='$colorBgClass'>$value</td>";
                $table_string1 .= "</tr>";
                $i++;
            }
        }
    }
    // Append total count row
    $table_string1 .= "<tr><td colspan='" . ($rows - 1) . "'><b>Total Count</b></td><td>$count</td></tr>";
    return $table_string1;
}

// Function to initialize neuron array
function initializeNeuronArray($cols, $color_cols) {
    $neuronArray = [];
    foreach ($color_cols as $color_col) {
        if (!empty($color_col)) { // Skip empty color columns
            foreach ($cols as $col) {
                $neuronArray[trim($color_col)][trim($col)] = 0;
            }
        }
    }
    $neuronArray[trim($color_col)][trim($col)] = 0;
    // $array_subs[$subregion][$neuron_name][$color][$evidence]
    return $neuronArray;
}

// Function to initialize neuron array
function initializeConnectionNeuronArray($cols) {
    $neuronArray = [];
    foreach ($cols as $col) {
        if (!empty($col)) { // Skip empty color columns
		$neuronArray[trim($col)] = 0;
        }
    }
    //$neuronArray[trim($color_col)][trim($col)] = 0;
    // $array_subs[$subregion][$neuron_name][$color][$evidence]
    return $neuronArray;
}

function format_table_connectivity($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){

	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	
	$rows = count($csv_headers);
	
	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}

	while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
		//$source_subregion, $source_neuron_name, $target_subregion, $target_neuron_name, views, nm_page, parcel_specific
		
                // Modify neuron name if necessary
                if (isset($neuron_ids[$rowvalue['source_neuron_name']])) {
                        $rowvalue['source_neuron_name'] = get_link($rowvalue['source_neuron_name'], $neuron_ids[$rowvalue['source_neuron_name']], './neuron_page.php', 'neuron');
                }

                // Modify neuron name if necessary
                if (isset($neuron_ids[$rowvalue['target_neuron_name']])) {
                        $rowvalue['target_neuron_name'] = get_link($rowvalue['target_neuron_name'], $neuron_ids[$rowvalue['target_neuron_name']], './neuron_page.php', 'neuron');
                }

                // Extract relevant values
                $source_subregion = $rowvalue['source_subregion'];
                $source_neuron_name = $rowvalue['source_neuron_name'];
                $target_subregion = $rowvalue['target_subregion'];
                $target_neuron_name = $rowvalue['target_neuron_name'];
                $views = intval($rowvalue['views']);
		$parcel_specific = $rowvalue['parcel_specific'];
		$nm_page = $rowvalue['nm_page'];
		$connectivity_cols = ['Potential Connectivity Evidence', 'Number of Potential Synapses Parcel-Specific Table', 'Number of Potential Synapses Evidence', 'Number of Contacts Parcel-Specific Table', 'Number of Contacts Evidence','Synaptic Probability Parcel-Specific Table', 'Synaptic Probability Evidence', 'Unknown'];

                // Initialize arrays if necessary
                if (!isset($array_subs[$source_subregion])) {
                        $array_subs[$source_subregion] = [];
                }

		// Define evidence based on `parcel_specific`
		switch ($parcel_specific) {
			case 'connectivity':
			case 'connectivity_orig':
			case 'connectivity_test':
				$evidence = 'Potential Connectivity Evidence';
				break;

			case 'synpro_pvals':
				// Define evidence based on `nm_page`
				switch ($nm_page) {
					case 'prosyn':
					case 'prosy':
						$evidence = 'Synaptic Probability Parcel-Specific Table';
						break;
					case 'ps':
						$evidence = 'Number of Potential Synapses Parcel-Specific Table';
						break;
					case 'noc':
						$evidence = 'Number of Contacts Parcel-Specific Table';
						break;
					default:
						$evidence = 'Unknown';
				}
				break;

			case 'synpro_nm':
			case 'synpro_nm_old2':
				// Define evidence based on `nm_page`
				switch ($nm_page) {
					case 'prosyn':
					case 'prosy':
						$evidence = 'Synaptic Probability Evidence';
						break;
					case 'ps':
						$evidence = 'Number of Potential Synapses Evidence';
						break;
					case 'noc':
						$evidence = 'Number of Contacts Evidence';
						break;
					default:
						$evidence = 'Unknown';
				}
				break;
		}
		//echo "Source: ".$source_subregion."neuron name".$source_neuron_name."Target: ".$target_subregion." Target Neuron: ".$target_neuron_name." Evidence: ".$evidence; 
		if(!isset($array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name])){
			$array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name] = initializeConnectionNeuronArray($connectivity_cols);
		}
		// Update $array_subs with $evidence and increment values
		if (!isset($array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name][$evidence])) {
			$array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name][$evidence] = 0;
		}
		$array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name][$evidence] += intval($views);

		// Initialize and increment the 'total' counter
		if (!isset($array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name]['total'])) {
			$array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name]['total'] = 0;
		}
		$array_subs[$source_subregion][$source_neuron_name][$target_subregion][$target_neuron_name]['total'] += intval($views);
	}

        // Ensure "total" column is present even if all values are 0
        if(isset($write_file)){
                #$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
                #return $csv_data[$csv_tablename];
        }
        //var_dump($array_subs);//exit;
        $i = $j = $k = $total_count =0;
        $table_string2 = '';
	foreach($array_subs as $type => $subtypes){
		$source_subregion = $type;
		foreach ($subtypes as $subtype => $target_values) {
			$source_neuron_name = $subtype;
			foreach ($target_values as $target_subtype => $target_neuron_values) {
				$target_subregion = $target_subtype;
				foreach ($target_neuron_values as $target_neuron => $values) {
					$target_neuron_name = $target_neuron;
					if ($j % 2 == 0) {
						$table_string2 .= "<tr><td class='white-bg' >".$source_subregion."</td><td class='white-bg'>".$source_neuron_name."</td><td class='white-bg'>".$target_subregion."</td><td class='white-bg'>".$target_neuron_name."</td>";
					} else {
						$table_string2 .= "<tr><td class='blue-bg' >".$source_subregion."</td><td class='blue-bg'>".$source_neuron_name."</td><td class='bluee-bg'>".$target_subregion."</td><td class='blue-bg'>".$target_neuron_name."</td>";
					}
					foreach($values as $property => $value){
						$showval='';
						if($value >= 1){$showval = $value;}
						if ($property == 'total') {
							// Close the row if the property is "total"
							if ($j % 2 == 0) {
								$table_string2 .= "<td class='white-bg'>$showval</td></tr>";
							}else{
								$table_string2 .= "<td class='blue-bg'>$showval</td></tr>";
							}
							$total_count += $value;
						} else {
							if ($j % 2 == 0) {
								$table_string2 .= "<td class='white-bg'>$showval</td>";
							}else{
								$table_string2 .= "<td class='blue-bg'>$showval</td>";
							}
						}
					}
					$j++;
				}
			}	
		}
	}
        $table_string1 .= $table_string2;
        $table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$total_count."</td></tr>";
        return $table_string1;
}

function format_table_morphology($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	
	$color_segments = ['red'=>'Axon Locations','blue'=>'Dendrite Locations','somata'=>'Soma Locations','violet'=>'Axon-Dendrite Locations','redSoma'=>'Axon-Somata Locations',
			   'blueSoma'=>'Dendrite-Somata Locations', 'violetSoma'=>'Axon-Dendrite-Somata Locations'];
	$color_cols = ['Axon Locations', 'Dendrite Locations', 'Soma Locations', 'Axon-Dendrite Locations', 'Axon-Somata Locations','Dendrite-Somata Locations', 'Axon-Dendrite-Somata Locations']; 
	$cols = ['DG:SMo', 'DG:SMi','DG:SG','DG:H','CA3:SLM','CA3:SR','CA3:SL','CA3:SP','CA3:SO','CA2:SLM','CA2:SR','CA2:SP','CA2:SO','CA1:SLM','CA1:SR','CA1:SP','CA1:SO',
			'Sub:SM','Sub:SP','Sub:PL','EC:I','EC:II','EC:III','EC:IV','EC:V','EC:VI','Unknown'];
	$neuronal_segments = ['DG_SMo'=>'DG:SMo', 'DG_SMi'=>'DG:SMi','DG_SG'=>'DG:SG','DG_H'=>'DG:H',
			      'CA3_SLM'=>'CA3:SLM','CA3_SR'=>'CA3:SR','CA3_SL'=>'CA3:SL','CA3_SP'=>'CA3:SP','CA3_SO'=>'CA3:SO',
			      'CA2_SLM'=>'CA2:SLM','CA2_SR'=>'CA2:SR','CA2_SP'=>'CA2:SP','CA2_SO'=>'CA2:SO',
			      'CA1_SLM'=>'CA1:SLM','CA1_SR'=>'CA1:SR','CA1_SP'=>'CA1:SP','CA1_SO'=>'CA1:SO',
			      'SUB_SM'=>'Sub:SM','SUB_SP'=>'Sub:SP','SUB_PL'=>'Sub:PL',
			      'EC_I'=>'EC:I','EC_II'=>'EC:II','EC_III'=>'EC:III','EC_IV'=>'EC:IV','EC_V'=>'EC:V','EC_VI'=>'EC:VI',''=>'Unknown'];
	$rows = count($csv_headers);

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}

	while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
    		// Modify neuron name if necessary
		if (isset($neuron_ids[$rowvalue['neuron_name']])) {
			$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php', 'neuron');
		}

		// Extract relevant values
		$subregion = $rowvalue['subregion'];
		$neuron_name = $rowvalue['neuron_name'];
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
		if(!isset($array_subs[$subregion][$neuron_name][$color][$evidence])){
			/*echo "evidence does not exist and trying to initiate to 0:".$evidence."Evidence from DB:".$rowvalue['evidence'];
			  echo $neuronal_segments[$rowvalue['evidence']];
			  echo "Color is:".$color;
			  echo "db color is:".$rowvalue['color'];
			  echo "Sub Region is:".$subregion;
			  echo "Neuron Name:".$neuron_name; */
			$array_subs[$subregion][$neuron_name][$color][$evidence] = 0;
		}else{
			// Increment values
			$array_subs[$subregion][$neuron_name][$color][$evidence] += intval($views);
			$array_subs[$subregion][$neuron_name][$color]['total'] += intval($views);
		}
		if(!isset($array_subs[$subregion][$neuron_name][$color]['total'])){
			$array_subs[$subregion][$neuron_name][$color]['total']=0;
		}
		else{
			//$array_subs[$subregion][$neuron_name][$color]['total'] += intval($views);
		}
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
	// Ensure "total" column is present even if all values are 0
	if(isset($write_file)){
		#$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		#return $csv_data[$csv_tablename];
	}
	//var_dump($array_subs);//exit;
	$i = $j = $k = $total_count =0;
	$table_string2 = '';
	foreach ($array_subs as $type => $subtypes) {

		$keyCounts = count($subtypes);

		// Flag to track if the type cell has been added
		$typeCellAdded = false;

		foreach ($subtypes as $subtype => $values) {
			// Count the number of properties for the current subtype
			$keyCounts2 = count($values)+1;//Added this 1 as count is giving 6 but then one row is showing as seperate Added on April 25 2024
			$subtyperowspan = $keyCounts2;

			// Calculate typerowspan as the product of keyCounts and keyCounts2
			$typerowspan = $keyCounts * $keyCounts2;

			// Add the type cell only once for each type
			if (!$typeCellAdded) {
				//echo "typerowspan is:".$typerowspan;
				if ($j % 2 == 0) {
					$table_string2 .= "<tr><td class='lightgreen-bg' rowspan='".$typerowspan."'>".$type."</td>";
				} else {
					$table_string2 .= "<tr><td class='green-bg' rowspan='".$typerowspan."'>".$type."</td>";
				}
				// Set the flag to true once the type cell is added
				$typeCellAdded = true;
			}
			
				//echo "subtyperowspan is:".$subtyperowspan;
			// Add the subtype cell
			$table_string2 .= "<td rowspan='".$subtyperowspan."'>".$subtype."</td>";

			// Iterate over categories and properties
			foreach ($values as $category => $properties) {
				if (in_array($category, $color_cols)) {
					// Open a new row if the category is a color column
					$table_string2 .= "<tr><td>".$category."</td>";
				} else {
					// Otherwise, add the category without starting a new row
					$table_string2 .= "<td>".$category."</td>";
				}

				foreach ($properties as $property => $value) {
					// Check if the property is "total"
					if($property == ""){continue;}
					$showval='';
					if($value >= 1){$showval = $value;}
					if ($property == 'total') {
						// Close the row if the property is "total"
						$table_string2 .= "<td>$showval</td></tr>";
						$total_count += $value;
					} else {
						$table_string2 .= "<td>$showval</td>";
					}
				}
			}
			 $table_string2 .= "</tr>";
		}
	}
	$table_string1 .= $table_string2;
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$total_count."</td></tr>";
	return $table_string1;

}

function format_table_markers($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){

	$count = 0;
	$csv_rows=[];
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
			$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php', 'neuron');
		}

		// Extract relevant values
		$subregion = $rowvalue['subregion'];
		$neuron_name = $rowvalue['neuron_name'];
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
		if(!isset($array_subs[$subregion][$neuron_name][$color][$evidence])){
			/*echo "evidence does not exist and trying to initiate to 0:".$evidence."Evidence from DB:".$rowvalue['evidence'];
			  echo $neuronal_segments[$rowvalue['evidence']];
			  echo "Color is:".$color;
			  echo "db color is:".$rowvalue['color'];
			  echo "Sub Region is:".$subregion;
			  echo "Neuron Name:".$neuron_name; */
			$array_subs[$subregion][$neuron_name][$color][$evidence] = 0;
		}else{
			// Increment values
			$array_subs[$subregion][$neuron_name][$color][$evidence] += intval($views);
			$array_subs[$subregion][$neuron_name][$color]['total'] += intval($views);
		}
		if(!isset($array_subs[$subregion][$neuron_name][$color]['total'])){
			$array_subs[$subregion][$neuron_name][$color]['total']=0;
		}
		else{
			//$array_subs[$subregion][$neuron_name][$color]['total'] += intval($views);
		}
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
	// Ensure "total" column is present even if all values are 0
	if(isset($write_file)){
		#$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		#return $csv_data[$csv_tablename];
	}
	//var_dump($array_subs);//exit;
	$i = $j = $k = $total_count =0;
	$table_string2 = '';
	foreach ($array_subs as $type => $subtypes) {

		$keyCounts = count($subtypes);

		// Flag to track if the type cell has been added
		$typeCellAdded = false;

		foreach ($subtypes as $subtype => $values) {
			// Count the number of properties for the current subtype
			$keyCounts2 = count($values)+1;//Added this 1 as count is giving 6 but then one row is showing as seperate Added on April 25 2024
			$subtyperowspan = $keyCounts2;

			// Calculate typerowspan as the product of keyCounts and keyCounts2
			$typerowspan = $keyCounts * $keyCounts2;

			// Add the type cell only once for each type
			if (!$typeCellAdded) {
				//echo "typerowspan is:".$typerowspan;
				if ($j % 2 == 0) {
					$table_string2 .= "<tr><td class='lightgreen-bg' rowspan='".$typerowspan."'>".$type."</td>";
				} else {
					$table_string2 .= "<tr><td class='green-bg' rowspan='".$typerowspan."'>".$type."</td>";
				}
				// Set the flag to true once the type cell is added
				$typeCellAdded = true;
			}
			
				//echo "subtyperowspan is:".$subtyperowspan;
			// Add the subtype cell
			$table_string2 .= "<td rowspan='".$subtyperowspan."'>".$subtype."</td>";

			// Iterate over categories and properties
			foreach ($values as $category => $properties) {
				if (in_array($category, $color_cols)) {
					// Open a new row if the category is a color column
					$table_string2 .= "<tr><td>".$category."</td>";
				} else {
					// Otherwise, add the category without starting a new row
					$table_string2 .= "<td>".$category."</td>";
				}

				foreach ($properties as $property => $value) {
					// Check if the property is "total"
					if($property == ""){continue;}
					$showval='';
					if($value >= 1){$showval = $value;}
					if ($property == 'total') {
						// Close the row if the property is "total"
						$table_string2 .= "<td>$showval</td></tr>";
						$total_count += $value;
					} else {
						$table_string2 .= "<td>$showval</td>";
					}
				}
			}
			 $table_string2 .= "</tr>";
		}
	}
	$table_string1 .= $table_string2;
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$total_count."</td></tr>";
	return $table_string1;

}

// Function to generate alternating row color class
function alternateRowClass($index) {
    return $index % 2 == 0 ? 'white-row' : 'blue-row';
}

// Function to generate alternating key color class
function alternateKeyClass($index) {
    return $index % 2 == 0 ? 'green-key' : 'light-green-key';
}

function format_table_biophysics($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	$neuronal_segments = ['Vrest'=>'Vrest (mV)', 'Rin'=>'Rin (MW)', 'tm'=>'tm (ms)', 'Vthresh'=>'Vthresh(mV)','fast_AHP'=>'Fast AHP (mV)',
		'AP_ampl'=>'APampl (mV)','AP_width'=>'APwidth (ms)', 'max_fr'=>'Max F.R. (Hz)','slow_AHP'=>'Slow AHP (mV)','sag_ratio'=>'Sag Ratio',''=>'Unknown'];

	$cols = ['Vrest (mV)', 'Rin (MW)', 'tm (ms)', 'Vthresh(mV)','Fast AHP (mV)','APampl (mV)','APwidth (ms)','Max F.R. (Hz)','Slow AHP (mV)','Sag Ratio','Unknown'];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}
	while($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)){
		if(isset($neuron_ids[$row['neuron_name']])){
			$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php','neuron');
		}
		if(!isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']])){
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']] = [];
                        foreach($cols as $col){
                                $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$col] = 0;
                        }
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['views']);
			}
		}else{
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['views']);
			}
		}
		if(!isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'])){
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'] = 0;
		}
		if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'])) { 
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'] += intval($rowvalue['views']);
		}
		if(isset($write_file)){
			#array_unshift($row1, $rowvalue['neuron_name']);
			#array_unshift($row1, $rowvalue['subregion']);
			#$csv_rows[] = $row1;
		}
	}
	if(isset($write_file)){
		#$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		#return $csv_data[$csv_tablename];
	}
	#var_dump($array_subs);exit;
	$i=$j=0;
	$table_string2='';
	foreach ($array_subs as $groupKey => $subgroups) {
		$table_string2 .= "<tr>";
		$keyCounts = count(array_keys($subgroups));
		$rowspan = $keyCounts;
		if($j%2==0){
			$table_string2 .= "<td class='lightgreen-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}else{
                        $table_string2 .= "<td class='green-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}
		foreach ($subgroups as $subgroupKey => $colors) {
			if($i%2==0){
				$table_string2 .= "<td class='white-bg' >".$subgroupKey."</td>";
			}else{
				$table_string2 .= "<td class='blue-bg' >".$subgroupKey."</td>";
			}
			foreach($colors as $value){
				if($value > 0){
				$value = $value;}else{$value='';}
				if($i%2==0){
					$table_string2 .= "<td class='white-bg' >".$value."</td>";
				}else{
					$table_string2 .= "<td class='blue-bg' >".$value."</td>";
				}
			}
			$table_string2 .= "</tr>";
			$count += $value;
			$i++;
		}
		$j++;
	}
	$table_string1 .= $table_string2;
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
	return $table_string1;
}

function format_table_phases($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
	//echo $query;
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	//For Phases page to replciate the string we show
	$neuronal_segments = [
		'theta'=>'Theta (deg)', 'swr_ratio'=>'SWR Ratio','firingRate'=>'In Vivo Firing Rate (Hz)', 'gamma' => 'Gamma (deg)', 'DS_ratio' => 'DS Ratio', 
		'Vrest' => 'Vrest (mV)', 'epsilon'=>'Epsilon','firingRateNonBaseline'=>'Non-Baseline Firing Rate (Hz)', 'APthresh'=>'APthresh (mV)', 'tau'=>'Tau (ms)', 
		'run_stop_ratio'=>'Run/Stop Ratio', 'ripple'=>'Ripple (deg)', 'fahp'=>'fAHP (mV)','APpeal'=>'APpeak-trough (ms)',
		'all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.',''=>'Unknown'];
	$cols = [ 'Theta (deg)', 'SWR Ratio','In Vivo Firing Rate (Hz)', 'DS Ratio', 'Ripple (deg)','Gamma (deg)', 'Run/Stop Ratio','Epsilon',
		'Non-Baseline Firing Rate (Hz)', 'Vrest (mV)', 'Tau (ms)',
		'APthresh (mV)','fAHP (mV)','APpeak-trough (ms)','Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.','Unknown'];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}
	while($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)){
		//var_dump($rowvalue);
		if(isset($neuron_ids[$row['neuron_name']])){
			$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php','neuron');
		}
		if(!isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']])){
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']] = [];
                        foreach($cols as $col){
                                $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$col] = 0;
                        }
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['views']);
			}
		}else{
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['views']);
				//$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$rowvalue['evidence']]['views'] += $rowvalue['views'];
			}
		}
		if(!isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'])){
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'] = 0;
		}
		if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'])) { 
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['total'] += intval($rowvalue['views']);
		}
		//var_dump($array_subs);//exit;
		if(isset($write_file)){
			#array_unshift($row1, $rowvalue['neuron_name']);
			#array_unshift($row1, $rowvalue['subregion']);
			#$csv_rows[] = $row1;
		}
	}
	if(isset($write_file)){
		#$csv_data[$csv_tablename]=['filename'=>$csv_tablename,'headers'=>$csv_headers,'rows'=>$csv_rows];
		#return $csv_data[$csv_tablename];
	}
	#var_dump($array_subs);exit;
	$i=$j=0;
	$table_string2='';
	foreach ($array_subs as $groupKey => $subgroups) {
		$table_string2 .= "<tr>";
		$keyCounts = count(array_keys($subgroups));
		$rowspan = $keyCounts;
		if($j%2==0){
			$table_string2 .= "<td class='lightgreen-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}else{
                        $table_string2 .= "<td class='green-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}
		foreach ($subgroups as $subgroupKey => $colors) {
			if($i%2==0){
				$table_string2 .= "<td class='white-bg' >".$subgroupKey."</td>";
			}else{
				$table_string2 .= "<td class='blue-bg' >".$subgroupKey."</td>";
			}
			foreach($colors as $value){
				if($value > 0){
				$value = $value;}else{$value='';}
				if($i%2==0){
					$table_string2 .= "<td class='white-bg' >".$value."</td>";
				}else{
					$table_string2 .= "<td class='blue-bg' >".$value."</td>";
				}
			}
			$table_string2 .= "</tr>";
			$count += $value;
			$i++;
		}
		$j++;
	}
	$table_string1 .= $table_string2;
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
	return $table_string1;
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
		SUM(CASE WHEN nd.is_property_page = 1 THEN REPLACE(nd.page_views, ',', '') ELSE 0 END) AS property_page_views,
		SUM(CASE WHEN nd.is_property_page = 0 THEN REPLACE(nd.page_views, ',', '') ELSE 0 END) AS other_page_views
			FROM 
			(
			 SELECT 
			 CASE 
			 WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
			 WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
			 WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
			 END AS neuronID,
			 page_views,
			 CASE 
			 WHEN page LIKE '%property_page_counts.php%' THEN 1 
			 ELSE 0 
			 END AS is_property_page
			 FROM 
			 ga_analytics_pages
			 WHERE 
			 (page LIKE '%property_page_counts.php%' OR page LIKE '%id_neuron=%' OR page LIKE '%id1_neuron=%' OR page LIKE '%id_neuron_source=%') AND 
			 LENGTH(
				 CASE 
				 WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
				 WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
				 WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
				 END
			       ) = 4 AND 
			 (
			  CASE 
			  WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
			  WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
			  WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
			  END
			 ) NOT IN (4168, 4181, 2232)
			 ) AS nd
			 JOIN 
			 Type AS t ON nd.neuronID = t.id
			 GROUP BY 
			 t.page_statistics_name, 
		t.subregion 
			ORDER BY 
			t.position";
/*	  $page_neurons_views_query = "SELECT 
    SUBSTRING_INDEX(SUBSTRING_INDEX(page, '.php?', 1), '/', -1) AS extracted_string,
    COUNT(*) AS count_of_strings,
    t.subregion,
    t.page_statistics_name AS neuron_name,
    SUM(CASE WHEN nd.is_property_page = 1 THEN REPLACE(nd.page_views, ',', '') ELSE 0 END) AS property_page_views,
    SUM(CASE WHEN nd.is_property_page = 0 THEN REPLACE(nd.page_views, ',', '') ELSE 0 END) AS other_page_views
FROM
    (
        SELECT 
            SUBSTRING_INDEX(SUBSTRING_INDEX(page, '.php?', 1), '/', -1) AS extracted_string, 
            CASE 
                WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
                WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
                WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
            END AS neuronID,
            page_views, 
            page, 
            CASE 
                WHEN page LIKE '%property_page_counts.php%' THEN 1
                ELSE 0 
            END AS is_property_page
        FROM   
            ga_analytics_pages
        WHERE          
            (page LIKE '%property_page_counts.php%' OR page LIKE '%id_neuron=%' OR page LIKE '%id1_neuron=%' OR page LIKE '%id_neuron_source=%') AND
            LENGTH(
                CASE                                   
                    WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
                    WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
                    WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
                END
            ) = 4 AND 
            (
                CASE
                    WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
                    WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
                    WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
                END
            ) NOT IN (4168, 4181, 2232)
    ) AS nd
JOIN
    Type AS t ON nd.neuronID = t.id
GROUP BY
    extracted_string,
    t.subregion,
    t.page_statistics_name
ORDER BY
    t.position"; */

	$columns = ['Subregion', 'Neuron Type Name', 'Census','Views'];
	//$columns = ['Subregion', 'Neuron Type Name', 'Morphology','Markers','Membrane Biophysics','Firing Patterns Dendritic and Axonal Lengths','Somatic Distances of Dendrites and Axons','In Vivo', 'Census','Total'];
	$table_string = get_table_skeleton_first($columns);
	if(isset($write_file)) {
		return format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids= NULL, $write_file);
	}else{
		$table_string .= format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_morphology_property_views_report($conn, $neuron_ids = NULL, $write_file=NULL){
    
	$page_property_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, derived.evidence AS evidence, derived.color, SUM(REPLACE(page_views, ',', '')) AS views 
						FROM (
							SELECT page_views, IF( INSTR(page, 'id_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1),
										IF( INSTR(page, 'id1_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1),
										IF( INSTR(page, 'id_neuron_source=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), '' ) ) 
									     ) AS neuronID,
								IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') AS evidence,
								IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') AS color 
								FROM ga_analytics_pages 
								WHERE page LIKE '%/property_page_%' 
									AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology' 
										OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro' ) 
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
						JOIN Type AS t ON t.id = derived.neuronID
						GROUP BY t.page_statistics_name, t.subregion, derived.color, derived.evidence 
						ORDER BY t.position"; 

        //echo $page_property_views_query;
        
        $columns = ['Subregion', 'Neuron Type Name', 'Neuronal Attribute', 'DG:SMo', 'DG:SMi','DG:SG','DG:H','CA3:SLM','CA3:SR','CA3:SL','CA3:SP','CA3:SO','CA2:SLM','CA2:SR','CA2:SP','CA2:SO','CA1:SLM','CA1:SR','CA1:SP','CA1:SO','Sub:SM','Sub:SP','Sub:PL','EC:I','EC:II','EC:III','EC:IV','EC:V','EC:VI','Unknown','Total'];
        if(isset($write_file)) {
                //return format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids, $write_file, $array_subs);
                return format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids, $write_file);
        }else{
		$table_string = get_table_skeleton_first($columns);
                //$table_string .= format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids, $write_file=NULL, $array_subs);
                $table_string .= format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids);
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
                        GROUP BY linking_pmid_isbn, t.subregion, layer, t.page_statistics_name, color  
			ORDER BY CAST(linking_pmid_isbn AS UNSIGNED) ASC";
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

function get_markers_property_views_report($conn, $neuron_ids, $write_file = NULL){

	/*$page_property_views_query = "select t.subregion, t.page_statistics_name AS neuron_name, derived.color as color, derived.evidence as evidence, 
                                                SUM(REPLACE(page_views, ',', '')) AS views
                                                FROM (
                                                                SELECT
                                                                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID,                    
                                                                IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') 
                                                                AS evidence, 
                                                                IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') AS color, 
                                                                page_views
                                                                FROM
                                                                ga_analytics_pages
                                                                WHERE
                                                                page LIKE '%property_page_markers.php?id_neuron=%'
                                                                AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4                          
                                                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                                     ) AS derived
                                                JOIN Type AS t ON t.id = derived.neuronID
                                                GROUP BY t.subregion, t.page_statistics_name, evidence
                                                ORDER BY t.position"; */
	$page_property_views_query = "select t.subregion, t.page_statistics_name AS neuron_name, derived.color as color, derived.evidence as evidence,
                                                SUM(REPLACE(page_views, ',', '')) AS views
                                                FROM ( SELECT IF(INSTR(page, 'id_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1),
							      IF(INSTR(page, 'id1_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1),
							      IF(INSTR(page, 'id_neuron_source=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), '' ))) AS neuronID,
                                                              IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') AS evidence,
							      IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') AS color, page_views FROM
                                                              ga_analytics_pages WHERE page LIKE '%/property_page_%' AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'markers'
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
						JOIN Type AS t ON t.id = derived.neuronID
						GROUP BY t.subregion, t.page_statistics_name, evidence
						ORDER BY t.position";
	//echo $page_property_views_query;
	$columns = ["Subregion", "Neuron Type Name", "Expression", "CB", "CR", "PV", "5HT-3", "CB1", "GABAa_alfa", "mGluR1a", "Mus2R", "Sub P Rec", "vGluT3", "CCK", "ENK", "NG", "NPY", "SOM", "VIP", "a-act2", 
			"CoupTF_2", "nNOS", "RLN", "AChE", "AMIGO2", "AR-beta1", "AR-beta2", "Astn2", "BDNF", "Bok", "Caln", "CaM", "CaMKII_alpha", "CGRP", "ChAT", "Chrna2", "CRF", "Ctip2", "Cx36", "CXCR4", 
			"Dcn", "Disc1", "DYN", "EAAT3", "ErbB4", "GABAa_alpha2", "GABAa_alpha3", "GABAa_alpha4", "GABAa_alpha5", "GABAa_alpha6", "GABAa_beta1", "GABAa_beta2", "GABAa_beta3", "GABAa_delta", 
			"GABAa_gamma1", "GABAa_gamma2", "GABA-B1", "GAT-1", "GAT-3", "GluA1", "GluA2", "GluA2/3", "GluA3", "GluA4", "GlyT2", "Gpc3", "Grp", "Htr2c", "Id_2", "Kv3_1", "Loc432748", "Man1a", 
			"Math-2", "mGluR1", "mGluR2", "mGluR2/3", "mGluR3", "mGluR4", "mGluR5", "mGluR5a", "mGluR7a", "mGluR8a", "MOR", "Mus1R", "Mus3R", "Mus4R", "Ndst4", "NECAB1", "Neuropilin2", "NKB", "Nov",
			"Nr3c2", "Nr4a1", "p-CREB", "PCP4", "PPE", "PPTA", "Prox1", "Prss12", "Prss23", "PSA-NCAM", "SATB1", "SATB2", "SCIP", "SPO", "SubP", "Tc1568100", "TH", "vAChT", "vGAT", "vGluT1", 
			"vGluT2", "VILIP", "Wfs1", "Y1", "Y2", "DCX", "NeuN", "NeuroD", "CRH", "NK1R", "Unknown", "Total"];

	if(isset($write_file)) {
		return format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns, $neuron_ids, $write_file);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();

		echo $table_string;
	}
}

function get_counts_views_report($conn, $page_string=NULL, $neuron_ids=NULL, $write_file = NULL){

	// Initialize the table string and columns array outside the conditional logic
	$table_string = '';
	$columns = [];

	// Check for 'phases' or 'counts' page types
	if ($page_string == 'counts') {
		$columns = ['Subregion', 'Neuron Type Name', 'Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, SUM(REPLACE(page_views, ',', '')) AS views 
				FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
					FROM ga_analytics_pages WHERE page LIKE '%property_page_{$pageType}.php?id_neuron=%' 
					AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
					AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY t.page_statistics_name ORDER BY t.position";
        //echo $page_neurons_views_query;

	}

	// Check for 'phases' page types
	if ($page_string == 'phases') {
		
		$columns = ['Subregion', 'Neuron Type Name', 'Theta (deg)', 'SWR Ratio','In Vivo Firing Rate (Hz)', 'DS Ratio', 'Ripple (deg)','Gamma (deg)', 'Run/Stop Ratio',
				'Epsilon','Non-Baseline Firing Rate (Hz)', 
				'Vrest (mV)', 'Tau (ms)','APthresh (mV)','fAHP (mV)','APpeak-trough (ms)','Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.', 'Unknown', 'Total'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query = "SELECT derived.page, t.subregion, t.page_statistics_name AS neuron_name, derived.evidence AS evidence, SUM(REPLACE(derived.page_views, ',', '')) AS views 
						FROM (
							SELECT page, page_views, IF( INSTR(page, 'id_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1), 
										 IF( INSTR(page, 'id1_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1),
										 IF( INSTR(page, 'id_neuron_source=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), ''))) AS neuronID,
										 IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') AS evidence 
							FROM ga_analytics_pages WHERE page LIKE '%/property_page_%' AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases'
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
						GROUP BY derived.page, t.subregion, t.page_statistics_name, derived.evidence 
						ORDER BY t.position";
		//echo  $page_counts_views_query;
	}

	// Check for 'connectivity' page types
        if ($page_string == 'connectivity') {
                     
                $columns = ['Presynaptic Subregion', 'Presynaptic Neuron Type Name', 'Postsynaptic Subregion', 'Postsynaptic Neuron Type Name', 'Potential Connectivity Evidence', 'Number of Potential Synapses Parcel-Specific Table', 'Number of Potential Synapses Evidence', 'Number of Contacts Parcel-Specific Table', 'Number of Contacts Evidence', 'Synaptic Probability Parcel-Specific Table', 'Synaptic Probability Evidence', 'Unknown', 'Total'];
                $pageType = $page_string == 'connectivity';
                $page_counts_views_query = "SELECT derived.page, t_source.subregion AS source_subregion, t_source.page_statistics_name AS source_neuron_name, 
							 derived.source_evidence, derived.source_color, t_target.subregion AS target_subregion, 
							 t_target.page_statistics_name AS target_neuron_name, derived.target_evidence, derived.target_color, derived.connection_type, 
							 derived.known_conn_flag, derived.axonic_basket_flag, derived.page_type, derived.nm_page, 
							 SUM(REPLACE(derived.page_views, ',', '')) AS views, derived.parcel_specific 
							FROM (
								SELECT page, page_views, 
								IF( INSTR(page, 'id1_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1), IF( INSTR(page, 'id_neuron_source=') > 0, 
										SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), '' ) )  AS source_neuronID,
								IF(INSTR(page, 'val1_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val1_property=', -1), '&', 1), '') AS source_evidence, 
								IF( INSTR(page, 'color=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), IF( INSTR(page, 'color1=') > 0, 
										SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color1=', -1), '&', 1), '' ) )  AS source_color,
								IF( INSTR(page, 'id2_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id2_neuron=', -1), '&', 1), IF( INSTR(page, 'id_neuron_target=') > 0, 
										SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_target=', -1), '&', 1), '' ) )  AS target_neuronID,
								IF(INSTR(page, 'val2_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val2_property=', -1), '&', 1), '') AS target_evidence, 
								IF(INSTR(page, 'color2=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color2=', -1), '&', 1), '' )   AS target_color,
								IF(INSTR(page, 'connection_type=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'connection_type=', -1), '&', 1), '') AS connection_type, 
								IF(INSTR(page, 'known_conn_flag=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'known_conn_flag=', -1), '&', 1), '') AS known_conn_flag, 
								IF(INSTR(page, 'axonic_basket_flag=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'axonic_basket_flag=', -1), '&', 1), '') AS axonic_basket_flag, 
								IF(INSTR(page, '&page=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, '&page=', -1), '&', 1), '') AS page_type, 
								IF(INSTR(page, 'nm_page=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'nm_page=', -1), '&', 1), '') AS nm_page,
								SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) AS parcel_specific        
								FROM ga_analytics_pages WHERE page LIKE '%/property_page_%' 
								AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_nm_old2' 
								     OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_nm'
								     OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_pvals' 
								     OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'connectivity' 
								     OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'connectivity_test' 
								     OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'connectivity_orig') 
								AND ( LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id2_neuron=', -1), '&', 1)) = 4 
									OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4 
									OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_target=', -1), '&', 1)) = 4 
									OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4 ) 
								AND ( SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id2_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) 
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232) 
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232) 
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_target=', -1), '&', 1) NOT IN (4168, 4181, 2232) ) 
							   ) AS derived 
								JOIN Type AS t_source ON t_source.id = derived.source_neuronID 
							   	JOIN Type AS t_target ON t_target.id = derived.target_neuronID
							   	GROUP BY derived.page, t_source.page_statistics_name, t_source.subregion, derived.source_color, derived.source_evidence,
							 		t_target.page_statistics_name, t_target.subregion, derived.target_color, derived.target_evidence,derived.nm_page ";
                //echo page_counts_views_query;
        }

	// Check for 'biophysics' page types
        if ($page_string == 'biophysics') {
        
                $columns = ['Subregion', 'Neuron Type Name', 'Vrest (mV)', 'Rin (MW)', 'tm (ms)', 'Vthresh(mV)','Fast AHP (mV)','APampl (mV)','APwidth (ms)','Max F.R. (Hz)','Slow AHP (mV)','Sag Ratio','Unknown','Total'];	
                $page_counts_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, derived.evidence as evidence,
                                                SUM(REPLACE(page_views, ',', '')) AS views
                                                FROM (
                                                                SELECT
                                                                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID,                    
                                                                IF(INSTR(page, 'ep=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'ep=', -1), '&', 1), '') AS evidence, 
                                                                page_views
                                                                FROM
                                                                ga_analytics_pages
                                                                WHERE
                                                                page LIKE '%property_page_ephys.php?id_ephys=%'
                                                                AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4                          
                                                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                                     ) AS derived
                                                JOIN Type AS t ON t.id = derived.neuronID
                                                GROUP BY t.subregion, t.page_statistics_name, evidence
                                                ORDER BY t.position"; 

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
		

		 $page_counts_views_query = "SELECT derived.page, SUM(REPLACE(page_views, ',', '')) AS views
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
	}
	if($page_string == 'biophysics'){
		if(isset($write_file)) {
			return format_table_biophysics($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids = NULL, $write_file);
        	}else{
			$table_string .= format_table_biophysics($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids);
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}
	}else if($page_string == 'connectivity'){
                if(isset($write_file)) {
                        return format_table_connectivity($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids = NULL, $write_file);
                }else{
			$array_subs = ["DG"=>[],"CA3"=>[],"CA2"=>[],"CA1"=>[],"Sub"=>[],"EC"=>[]];
                        $table_string .= format_table_connectivity($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids, $write_file = NULL, $array_subs);
                        $table_string .= get_table_skeleton_end();
                        echo $table_string;
                }
        }else{
		if(isset($write_file)) {
			return format_table_phases($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids = NULL, $write_file);
        	}else{
			$table_string .= format_table_phases($conn, $page_counts_views_query, $table_string, $page_string, $columns, $neuron_ids);
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
		CASE 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('connectivity', 'connectivity_orig', 'connectivity_test') THEN 'Connectivity: Known / Potential'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'counts' THEN 'Census'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'fp' THEN 'FP'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases' THEN 'In Vivo'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro' THEN 'Morphology: Axon and Dendrite Lengths / Somatic Distances'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('synpro_nm', 'synpro_nm_old2') THEN 'Connectivity: Number of Potential Synapses / Number of Contacts / Synaptic Probability'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_pvals' THEN 'Connectivity: Parcel-Specific Tables'
		ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1)
		END AS property_page_category,
		    SUM(REPLACE(page_views, ',', '')) AS views
			    FROM    
			    ga_analytics_pages
			    WHERE   
			    page LIKE '%/property_page_%'
			    AND (
					    LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1)) = 4
					    OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
					    OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
				)
			    AND (
					    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
					    OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
					    OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
				)
			    GROUP BY
			    property_page_category";
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
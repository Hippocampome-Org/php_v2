<?php
global $csv_data;

function download_csvfile($functionName, $conn, $param = NULL) {
	$allowedFunctions = ['get_neurons_views_report','get_markers_property_views_report', 'get_morphology_property_views_report', 'get_counts_views_report', 
			     'get_fp_property_views_report','get_pmid_isbn_property_views_report', 'get_domain_functionality_views_report','get_page_functionality_views_report', 
			      'get_views_per_page_report', 'get_pages_views_per_month_report']; // TO restrict any unwanted calls or anything

	if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
		if(isset($param)){
			$csv_data = $functionName($conn, $param, true);
		}else{
			$csv_data = $functionName($conn, true);
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

function format_table($conn, $query, $table_string, $csv_tablename, $csv_headers, $write_file=NULL, $query2=NULL){
	$count = 0;
	$csv_rows = [];
        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	$rows = count($csv_headers);
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

		while($j < $rows){
			if($row[$j] == 'fp'){ $row[$j] = 'firing pattern'; }
			if($row[$rows-1] > 0){
				$table_string1 .= "<td>".$row[$j]."</td>";
			}
			$j++;
		}
		$count += $row[$rows-1];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	if(isset($query2)){
		while($row = mysqli_fetch_row($rs2))
		{
	  	 	$csv_rows[] = $row;
			$j=0;
			if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
			else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

			while($j < $rows){
				if($row[$j] == 'fp'){ $row[$j] = 'firing pattern'; }
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
    while ($row = mysqli_fetch_row($rs)) {
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

function format_table_markers($conn, $query, $table_string, $csv_tablename, $csv_headers, $write_file = NULL, $array_subs = NULL){
	
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
        while($row = mysqli_fetch_row($rs))
        {
		$csv_rows[] = $row;
		if($array_subs[$row[0]]){
			if($array_subs[$row[0]][$row[1]]){
				$array_subs[$row[0]][$row[1]] += $row[2];
			}else{
				$array_subs[$row[0]][$row[1]] = $row[2];
			}
		}else{
			$array_subs[$row[0]][$row[1]] = $row[2];
		}
        }
	$i=$j=0;
        foreach($array_subs as $key => $value){
		$table_string1 .= "<tr>";    
		if($j%2==0){
       			$table_string1 .= "<td class='lightgreen-bg' rowspan='".count($value)."'>".$key."</td>";
		}else{
       			$table_string1 .= "<td class='green-bg' rowspan='".count($value)."'>".$key."</td>";
		}
		foreach($value as $key1 => $value1){
			if($i%2==0){
				$table_string1 .= "<td class='white-bg' >".$key1."</td>";
				$table_string1 .= "<td class='white-bg' >".$value1."</td>";
			}
			else{ 
				$table_string1 .= "<td class='blue-bg' >".$key1."</td>";
                                $table_string1 .= "<td class='blue-bg' >".$value1."</td>";
			}//Color gradient CSS

			$table_string1 .= "</tr>";
			$count += $value1;
			$i++;
		}
		$j++;
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

function get_page_views($conn){ //Passed on Dec 3 2023
	$page_views_query = "SELECT YEAR(day_index) AS year, 
		MONTH(day_index) AS month, 
		SUM(views) AS total_views
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

	$page_views_query = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS total_views  FROM
					ga_analytics_pages gap WHERE gap.day_index IS NULL GROUP BY gap.page order by total_views desc";
	//echo $page_views_query;
	$page_views_query2 = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS total_views FROM
					ga_analytics_pages gap WHERE gap.day_index IS NOT NULL and gap.page != '/php/' GROUP BY gap.page order by total_views desc";
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
				sum(replace(views,',',''))  
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

function get_neurons_views_report($conn, $write_file=NULL){ //Passed on Dec 3 2023
	$page_neurons_views_query = "SELECT t.subregion, t.nickname AS neuron_name,
                SUM(replace(page_views, ',', '')) AS count
                        FROM
                        (
                         SELECT
                         substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) AS neuronID,
                         page_views
                         FROM 
                         ga_analytics_pages
                         WHERE
                         page LIKE '%id_neuron=%'
                         AND LENGTH(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4       
                        AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        ) AS derived
                        JOIN Type AS t ON t.id = derived.neuronID
                        GROUP BY
                        t.nickname, 
			t.subregion order by t.position";
	//echo $page_neurons_views_query;
     
	$columns = ['Subregion', 'Neuron Name', 'Views'];
	if(isset($write_file)) {
		return format_table_markers($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $write_file);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_morphology_property_views_report($conn, $write_file=NULL){
	$page_property_views_query = "SELECT
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', 1) AS subregion,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1) AS layer,
					SUM(REPLACE(page_views, ',', '')) AS count
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%property_page_morphology.php?id_neuron=%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			GROUP BY
			subregion, layer";
	//echo $page_property_views_query;

	$array_subs = ["DG"=>["SMo"=>0,"SMi"=>0,"SG"=>0,"H"=>0],"CA3"=>["SLM"=>0, "SR"=>0, "SL"=>0, "SP"=>0,"SO"=>0],"CA2"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"CA1"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"SUB"=>["SM"=>0,"SP"=>0,"PL"=>0],"EC"=>["I"=>0,"II"=>0,"III"=>0,"IV"=>0,"V"=>0,"VI"=>0]];
	
	
	$columns = ['Morphology', 'Layer', 'Views'];
	if(isset($write_file)) {
		return format_table_markers($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $write_file, $array_subs);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $write_file=NULL, $array_subs);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_pmid_isbn_property_views_report($conn, $write_file=NULL){

	$page_pmid_isbn_property_views_query = " SELECT linking_pmid_isbn, t.subregion, layer, t.nickname as neuron_name, color, SUM(REPLACE(page_views, ',', '')) AS count
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
linking_pmid_isbn, t.subregion, layer, t.nickname, color  order by t.position";
	//echo $page_pmid_isbn_property_views_query;

	$columns = ['pmid_isbn', 'Sub Region', 'Layer', 'Neuron Name', 'Color', 'Views'];
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
		SUM(REPLACE(page_views, ',', '')) AS count
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
		return format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns, $write_file);
        }else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 'markers_property_table', $columns);
		$table_string .= get_table_skeleton_end();

		echo $table_string;
	}
}

function get_counts_views_report($conn, $page_string=NULL, $write_file = NULL){

	// Initialize the table string and columns array outside the conditional logic
	$table_string = '';
	$columns = [];

	// Base part of the SQL query
	$page_counts_views_query = "SELECT ";

	// Check for 'phases' or 'counts' page types
	if ($page_string == 'phases' || $page_string == 'counts') {
		$columns = ['Neuron ID', 'Neuron Name', 'Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query .= "t.id AS neuronID, t.nickname AS neuron_name, SUM(REPLACE(page_views, ',', '')) AS count 
				FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
					FROM ga_analytics_pages WHERE page LIKE '%property_page_{$pageType}.php?id_neuron=%' 
					AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
					AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY derived.neuronID, t.nickname ORDER BY t.position";
	}

	// Check for 'synpro' or 'synpro_nm' page types
	if ($page_string == 'synpro' || $page_string == 'synpro_nm') {
		$columns = ['Sub Region', 'layer', 'Neuron Name', 'Color', 'Views'];
		$pageType = $page_string == 'synpro' ? 'property_page_synpro.php' : 'property_page_synpro_nm.php';
		// Add 'Sp Page' column if page_string is 'synpro'
		if ($page_string == 'synpro') {
			array_splice($columns, 4, 0, ['Sp Page']); // Insert 'Sp Page' at the correct position
		}
		$page_counts_views_query .= "t.subregion, layer, t.nickname as neuron_name, color" . ($page_string == 'synpro' ? ", sp_page" : "") . ", 
						SUM(REPLACE(page_views, ',', '')) AS count 
						FROM (SELECT IF(INSTR(page, 'val_property=') > 0, 
							SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1), '') AS layer, 
							SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1) AS neuronID, 
							IF(INSTR(page, 'color=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') as color" . ($page_string == 'synpro' ? ", 
							IF(INSTR(page, 'sp_page=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'sp_page=', -1), '&', 1), '') as sp_page" : "") . ", page_views 
							FROM ga_analytics_pages 
							WHERE page LIKE '%$pageType?id_neuron=%' 
							AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
							AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
							AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY t.subregion, layer, t.nickname, color" . ($page_string == 'synpro' ? ", sp_page" : "") . " ORDER BY t.position";
	}

	// Initialize table with columns and execute the query if columns array is not empty
	if (!empty($columns)) {
		$table_string = get_table_skeleton_first($columns);
		$csv_tablename = $page_string."_table";
		if(isset($write_file)) {
			return format_table($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns, $write_file);
        	}else{
			$table_string .= format_table($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns);
			//echo $page_counts_views_query;
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}
	}
}

function get_fp_property_views_report($conn, $write_file=NULL){
	$fp_format = [
		'ASP.' => 'adapting spiking',
		'ASP.ASP.' => 'adapting spiking followed by (slower) adapting spiking',
		'ASP.NASP' => 'non-adapting spiking preceded by adapting spiking',
		'ASP.SLN' => 'silence preceded by adapting spiking',
		'D.' => 'delayed spiking',
		'D.ASP.' => 'delayed adapting spiking',
		'D.NASP' => 'delayed non-adapting spiking',
		'D.PSTUT' => 'delayed persistent stuttering',
		'D.RASP.NASP' => 'non-adapting spiking preceded by delayed rapidly adapting spiking',
		'NASP' => 'non-adapting spiking',
		'PSTUT' => 'persistent stuttering',
		'PSWB' => 'persistent slow-wave bursting',
		'RASP.' => 'rapidly adapting spiking',
		'RASP.ASP.' => 'rapidly adapting spiking followed by adapting spiking',
		'RASP.NASP' => 'non-adapting spiking preceded by rapidly adapting spiking',
		'RASP.SLN' => 'silence preceded by rapidly adapting spiking',
		'TSTUT.' => 'transient stuttering',
		'TSTUT.NASP' => 'non-adapting spiking preceded by transient stuttering',
		'TSTUT.PSTUT' => 'transient stuttering followed by persistent stuttering',
		'TSTUT.SLN' => 'silence preceded by transient stuttering',
		'TSWB.NASP' => 'non-adapting spiking preceded by transient slow-wave bursting',
		'TSWB.SLN' => 'silence preceded by transient slow-wave bursting',
		'D.TSWB.NASP' => 'non-adapting spiking preceded by delayed transient slow-wave bursting',
		'D.TSTUT.' => 'delayed persistent stuttering',
		'TSTUT.ASP.' => 'transient stuttering followed by adapting spiking'
			];

	$page_fp_property_views_query = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1) AS fp,
				 SUM(REPLACE(page_views, ',', '')) AS count
		FROM ga_analytics_pages WHERE page LIKE '%property_page_fp.php?id_neuron=%'
		AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
		GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1)
		ORDER BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1)";

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
                        AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1)) = 4
                        AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        GROUP BY
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '?', 1)";
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

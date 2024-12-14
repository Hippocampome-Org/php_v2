<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
require_once('/Applications/XAMPP/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

global $csv_data;
define('DELTA_VIEWS', get_calculated_views_dynamically($conn));

function download_excel_file($conn, $neuron_ids, $param) {
    ini_set('memory_limit', '512M'); // Adjust as necessary
    $spreadsheet = new Spreadsheet();
    $reports_filename="reports.xlsx";
    $views_requests = [];

    if ($param == "analytics") {
	    $views_requests = [
		    'get_page_functionality_views_report' => null,
		    'get_domain_functionality_views_report' => null,
		    'get_neuron_types_views_report' => null, 
		    'get_neurons_views_report' => null,
		    'get_pages_views_per_month_report' => null,
		    'get_views_per_page_report' => null
	    ];
	    $reports_filename = $param . "_reports.xlsx";
    }

    if ($param == "detailed_views") {
	    $views_requests = [
		    'get_morphology_property_views_report' => null,
		    'get_markers_property_views_report' => null,
		    'get_counts_views_report' => ['biophysics', 'phases', 'connectivity'], // Use an array for multiple parameters
		    'get_fp_property_views_report' => null,
	    ];      
	    $reports_filename = $param . "_reports.xlsx";
    }   

    // Iterate through each report request
    foreach ($views_requests as $functionName => $params) {
	    if (is_array($params)) {
		    // Handle multiple parameters
		    foreach ($params as $singleParam) {
			    $excel_data = download_csvfile($functionName, $conn, 'download_csv', $neuron_ids, $singleParam, true);

			    if (empty($excel_data) || empty($excel_data['headers']) || empty($excel_data['rows'])) {
				    error_log("No data returned for $functionName with parameter $singleParam");
				    continue; // Skip to the next iteration
			    }

			    // Create a new sheet
			    $sheet = $spreadsheet->createSheet();
			    $filename = $excel_data['filename'];
			    $clean_title = preg_replace('/[\/:*?"<>|]/', '', $filename);
			    $sheet_title = substr($clean_title, 0, 31); // Limit title to 31 characters
			    $sheet->setTitle($sheet_title);

			    // Add headers to the first row
			    $sheet->fromArray($excel_data['headers'], NULL, 'A1');

			    // Write data to the Excel sheet
			    $sheet->fromArray($excel_data['rows'], NULL, 'A2');
		    }
	    } else {
		    // Handle single parameter
		    $excel_data = download_csvfile($functionName, $conn, 'download_csv', $neuron_ids, $params, true);

		    if (empty($excel_data) || empty($excel_data['headers']) || empty($excel_data['rows'])) {
			    error_log("No data returned for $functionName");
			    continue; // Skip to the next iteration
		    }

		    // Create a new sheet
		    $sheet = $spreadsheet->createSheet();
		    $filename = $excel_data['filename'];
		    $clean_title = preg_replace('/[\/:*?"<>|]/', '', $filename);
		    $sheet_title = substr($clean_title, 0, 31); // Limit title to 31 characters
		    $sheet->setTitle($sheet_title);

		    // Add headers to the first row
		    $sheet->fromArray($excel_data['headers'], NULL, 'A1');

		    // Write data to the Excel sheet
		    $sheet->fromArray($excel_data['rows'], NULL, 'A2');
	    }
    }

    $spreadsheet->removeSheetByIndex(0);

    // Clear output buffering
    if (ob_get_length()) {
	    ob_end_clean();
    }

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$reports_filename\"");
    header('Cache-Control: max-age=0');

    // Create a writer and save the output to the browser
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

function get_neuron_ids($conn){
	$neuron_ids = [];
	//drop_or_create_aggregate_table($conn); // Commented out as this code is gonna be in python after we pull data every morning
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

function get_calculated_views_dynamically($conn) {
    $delta_value = 0;
    $setQuery = "
        SET @total_views = (
            SELECT SUM(
                CASE
                    WHEN REPLACE(page_views, ',', '') > 0
                    THEN REPLACE(page_views, ',', '')
                    ELSE REPLACE(sessions, ',', '')
                END
            )
            FROM GA_combined_analytics
        );
    ";
    if (!mysqli_query($conn, $setQuery)) {
        return $value;
    }
    $selectQuery = "SELECT @total_views AS total_views;";
    $result = mysqli_query($conn, $selectQuery);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $total_views = $row['total_views'];
        if ($total_views > 0) {
            $delta_value = 86523 / $total_views; 
        }
    }
	//echo "INSIDE THE FUNCTION TOTAL VIEWS FROM DB".$total_views;
//	echo "INSIDE FUNCTION DELTA VALUES IS".$delta_value;
    return $delta_value; 
}

/*
function drop_or_create_aggregate_table($conn) {
    // Step 1: Drop the table if it exists
    $dropQuery = "DROP TABLE IF EXISTS GA_combined_analytics;";
    if ($conn->query($dropQuery) === FALSE) {
        die("Error dropping the table: " . $conn->error);
    }

    // Step 2: Create the table
    $createQuery = "
        CREATE TABLE GA_combined_analytics AS
        SELECT 
            CASE 
                WHEN gap.page IS NOT NULL AND gap.page NOT LIKE '%not set%' THEN gap.page
                WHEN galp.landing_page IS NOT NULL AND galp.landing_page NOT LIKE '%not set%' THEN galp.landing_page
                ELSE NULL
            END AS page,
            COALESCE(gap.day_index, galp.day_index) AS day_index,
            COALESCE(gap.page_views, 0) AS page_views,
            COALESCE(galp.sessions, 0) AS sessions,
            COALESCE(gap.page_views, 0) + COALESCE(galp.sessions, 0) AS combined_views,
            COALESCE(gap.bounce_rate_percentage, NULL) AS page_bounce_rate,
            COALESCE(galp.bounce_rate_percentage, NULL) AS landing_bounce_rate,
            gap.page AS source_page,
            galp.landing_page AS source_landing_page
        FROM 
            (SELECT page, page_views, day_index, bounce_rate_percentage FROM ga_analytics_pages) AS gap
        LEFT JOIN 
            (SELECT landing_page, sessions, day_index, bounce_rate_percentage FROM ga_analytics_landing_pages) AS galp
        ON 
            gap.page = galp.landing_page AND gap.day_index = galp.day_index

        UNION ALL

        SELECT 
            CASE 
                WHEN gap.page IS NOT NULL AND gap.page NOT LIKE '%not set%' THEN gap.page
                WHEN galp.landing_page IS NOT NULL AND galp.landing_page NOT LIKE '%not set%' THEN galp.landing_page
                ELSE NULL
            END AS page,
            COALESCE(gap.day_index, galp.day_index) AS day_index,
            COALESCE(gap.page_views, 0) AS page_views,
            COALESCE(galp.sessions, 0) AS sessions,
            COALESCE(gap.page_views, 0) + COALESCE(galp.sessions, 0) AS combined_views,
            COALESCE(gap.bounce_rate_percentage, NULL) AS page_bounce_rate,
            COALESCE(galp.bounce_rate_percentage, NULL) AS landing_bounce_rate,
            gap.page AS source_page,
            galp.landing_page AS source_landing_page
        FROM 
            (SELECT page, page_views, day_index, bounce_rate_percentage FROM ga_analytics_pages) AS gap
        RIGHT JOIN 
            (SELECT landing_page, sessions, day_index, bounce_rate_percentage FROM ga_analytics_landing_pages) AS galp
        ON 
            gap.page = galp.landing_page AND gap.day_index = galp.day_index
        WHERE
            (gap.page IS NOT NULL AND gap.page NOT LIKE '%not set%')
            OR (galp.landing_page IS NOT NULL AND galp.landing_page NOT LIKE '%not set%');
    ";

    if ($conn->query($createQuery) === TRUE) {
        echo "Table 'GA_combined_analytics' created successfully with 'page' column.\n";
    } else {
        die("Error creating the table: " . $conn->error);
    }
} */

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

function download_csvfile($functionName, $conn, $views_request = NULL, $neuron_ids = NULL, $param = NULL, $is_excel = NULL) {
    if($functionName == 'download_reports'){
	$functionName = 'download_excel_file';
	return $functionName($conn, $neuron_ids, $param);
    }
    $allowedFunctions = [
        'get_page_functionality_views_report',
        'get_domain_functionality_views_report',
	'get_neuron_types_views_report',
        'get_neurons_views_report',
        'get_markers_property_views_report',
        'get_morphology_property_views_report',
        'get_counts_views_report',
        'get_fp_property_views_report',
        'get_pages_views_per_month_report',
        'get_views_per_page_report'
    ];

    $neuron_ids_func = [
        'get_counts_views_report',
        'get_neurons_views_report',
	'get_neuron_types_views_report',
	'get_neuron_types_views_report', 
        'get_morphology_property_views_report',
        'get_markers_property_views_report'
    ];

    if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
        if (in_array($functionName, ['get_neurons_views_report', 'get_neuron_types_views_report', 'get_morphology_property_views_report', 'get_markers_property_views_report'])) {
            $csv_data = $functionName($conn, $neuron_ids, $views_request, true);
        } else {
            if (isset($param)) {
                if (in_array($functionName, $neuron_ids_func)) {
                    $csv_data = $functionName($conn, $param, $neuron_ids, $views_request, true);
                } else {
                    $csv_data = $functionName($conn, $param, $views_request, true);
                }
            } else {
                if (in_array($functionName, $neuron_ids_func)) {
                    $csv_data = $functionName($conn, $neuron_ids, $views_request, true);
                } else {
                    $csv_data = $functionName($conn, $views_request, true);
                }
            }
        }

        if ($is_excel === true) {
            return $csv_data; // Return data for outer shell
        } else {
            // Prepare CSV download
            header('Content-Type: text/csv');
            $filename = $csv_data['filename'] . ".csv";
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $output = fopen('php://output', 'w');

            // Add CSV headers to the first row
            fputcsv($output, $csv_data['headers']);
            foreach ($csv_data['rows'] as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
            exit(); // Terminate the script
        }
    } else {
        echo "Invalid function.".$functionName;
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

function format_table($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $views_request = NULL, $query2 = NULL) {
    $count = 0;
    $csv_rows = [];
    $column_totals=[];
    if (isset($write_file)) {
	    if ($views_request == 'views_per_month' || $views_request == 'views_per_year') {
		    if (mysqli_multi_query($conn, $query)) {
			    $header = [];
			    $csv_rows = [];
			    do {    
				    if ($result = mysqli_store_result($conn)) {
					    if (mysqli_num_rows($result) == 0) {
						    echo "No data returned from the query.";
						    return;
					    }
					    if (empty($header)) {
						    $header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
						    mysqli_data_seek($result, 0);
		    				    $csv_headers = camel_replace($header);
					    }
					    while ($rowvalue = mysqli_fetch_assoc($result)) {
						    $validRow = [];
						    foreach ($rowvalue as $column_name => $column_value) {
							    if (!isset($rowvalue[$column_name])) {
								    $validRow[$column_name] = '';
							    } else {
								    $validRow[$column_name] = $rowvalue[$column_name] === 0 ? '' : $rowvalue[$column_name];
							    }
							    if (is_numeric($column_value)) {
								    $column_name = str_replace("_", " ", $column_name);
								    if (!isset($column_totals[$column_name])) {
									    $column_totals[$column_name] = 0;
								    }
								    $column_totals[$column_name] += $column_value;
							    }
						    }
						    $csv_rows[] = $validRow;
					    }
					    mysqli_free_result($result);
				    }
			    } while (mysqli_next_result($conn));
			    $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
			    $csv_data[$csv_tablename] = [
				    'filename' => toCamelCase($csv_tablename),
				    'headers' => $csv_headers,
				    'rows' => $csv_rows
			    ];
			    return $csv_data[$csv_tablename];
		    } else {
			    echo "Error: " . mysqli_error($conn);
		    }
	    }
    }

    $table_string1 = '';
    $count=0;
    $array_subs = [];

    $rs = mysqli_query($conn, $query);
    $rows = count($csv_headers);
    $table_id = 'myTable'; 

    $css_styles = "
    <style>
        #$table_id {
            width: 100%;
            table-layout: fixed; /* Ensures columns have fixed widths */
        }     
        #$table_id td, #$table_id th {
            overflow-wrap: break-word; /* Break long words */
            word-break: break-word; /* Additional word breaking */
            white-space: normal; /* Allow wrapping */
        }
	/* Targeting specific column for width */
        #$table_id td:nth-child(2), #$table_id th:nth-child(2) {
            width: 10%; /* Adjust this width as needed */
        }
    </style>";

    $table_string .= "<html><head>$css_styles</head><body>";
    $table_string .= "<table id='$table_id'>"; // Set table ID here
    $table_string .= "<thead><tr>";
    
    if ($rs){
	    $header=[];
	    if (empty($header)) {
		    $header = array_keys(mysqli_fetch_array($rs, MYSQLI_ASSOC));
		    $rows = count($header);
		    $csv_headers = camel_replace($header);
		    mysqli_data_seek($rs, 0);
	    }
    }
    foreach ($csv_headers as $header) {
        $table_string .= "<th>" . htmlspecialchars($header) . "</th>";
    }
    
    $table_string .= "</tr></thead><tbody>";

    if (!$rs || ($rs->num_rows < 1)) {
        $table_string1 .= "<tr><td colspan='$rows'>No Data is available</td></tr>";
        $table_string .= $table_string1;
        $table_string .= "</tbody></table></body></html>";
        return $table_string;
    }

    if (isset($query2)) {
        $rs2 = mysqli_query($conn, $query2);
        if (!$rs2 || ($rs2->num_rows < 1)) {
            $table_string1 .= "<tr><td colspan='$rows'>No Data is available</td></tr>";
            $table_string .= $table_string1;
            $table_string .= "</tbody></table></body></html>";
            return $table_string;
        }
    }

    // Process the main query results
    $i = 0;

    $column_totals = [];
    // Prepend the "pre-Aug 22, 2019" row with the integer value
    if ($csv_tablename == 'monthly_page_views') {
	    $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
	    $table_string1 .= "<tr class='$bgColor'>";
	    $table_string1 .= "<td>pre-Aug 22, 2019</td><td>".number_format(86523)."</td></tr>";

	    $csv_rows[] = ['pre-Aug 22, 2019', 86523];
	    if (!isset($column_totals[$header])) {
		    $column_totals[$header] = 0;
	    }
	    $column_totals[$header] += 86523;
	    $i++;
    }
    // Reset the result set pointer to the first row
    mysqli_data_seek($rs, 0);
    while ($row = mysqli_fetch_assoc($rs)) {                    
	    $row = update_estimated_totals($row);
	    $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
	    $table_string1 .= "<tr class='$bgColor'>";
	    $csv_rows[] = $row;
	    foreach ($row as $column_name => $column_value) {
		    if (isset($neuron_ids[$column_value])) {
			    $column_value = $neuron_ids[$column_value];
		    }
		    if (is_numeric($column_value)) {
		    	$table_string1 .= "<td>" . number_format(htmlspecialchars($column_value)) . "</td>";
			$column_name = str_replace("_", " ", $column_name);
			if (!isset($column_totals[$column_name])) {
				$column_totals[$column_name] = 0;
			}
			$column_totals[$column_name] += $column_value;
		    }
		    else{
		    	$table_string1 .= "<td>" . htmlspecialchars($column_value) . "</td>";
		    }
	    }
	    $table_string1 .= "</tr>";
	    $i++;
    }
    // Process the additional query results if provided
    if (isset($query2)) {
	    while ($row = mysqli_fetch_assoc($rs2)) {
		    $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
		    $table_string1 .= "<tr class='$bgColor'>";
		    $csv_rows[] = $row;
		    foreach ($row as $column_name => $column_value) {
			    if (isset($neuron_ids[$column_value])) {
				    $column_value= $neuron_ids[$column_value];
			    }
			    if (is_numeric($column_value)) {
		    		$table_string1 .= "<td>" . number_format(htmlspecialchars($column_value)) . "</td>";
				    $column_name = str_replace("_", " ", $column_name);
				    if (!isset($column_totals[$column_name])) {
					    $column_totals[$column_name] = 0;
				    }
				    $column_totals[$column_name] += $column_value;
			    }
			    else{
				    $table_string1 .= "<td>" . htmlspecialchars($column_value) . "</td>";
			    }
		    }
		    $table_string1 .= "</tr>";
		    $i++;
	    }
    }

    if (isset($write_file)) {
	$csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
	$csv_data[$csv_tablename] = ['filename' => toCamelCase($csv_tablename), 'headers' => $csv_headers, 'rows' => $csv_rows];
        return $csv_data[$csv_tablename];
    } else {
	    $table_string .= $table_string1;
	    $table_string .= generateTotalRow($csv_headers, false, $column_totals);
	    $table_string .= "</tbody></table></body></html>";
	    return $table_string;
    }
}

function format_table_combined($conn, $query, $csv_tablename, $csv_headers, $write_file = NULL, $options = [], $views_request = NULL) {
    $count = 0;
    $csv_rows = [];
    if (isset($write_file)) {
	    if (mysqli_multi_query($conn, $query)) {
		    $header = []; // Initialize an array to store column names
		    do {
			    if ($result = mysqli_store_result($conn)) {
				    if (empty($header)) {
					    $header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
					    $rows = count($header);
					    $csv_headers = camel_replace($header);
					    mysqli_data_seek($result, 0);
				    }
				    while ($rowvalue = mysqli_fetch_assoc($result)) {
					    foreach ($rowvalue as $key => $value) {
						    if (is_null($value) || trim($value) === '') {
							    if (is_numeric($value) || $value === '' || $value === null) {
								    $value = '0'; // Replace NULL or empty string with 0 for numeric fields
							    }
						    }
						    // Check if the value is numeric and update the column total
						    if (is_numeric($value)) {
							    $key = str_replace("_", " ", $key);
							    if (!isset($column_totals[$key])) {
								    $column_totals[$key] = 0;
							    }
							    $column_totals[$key] += $value;
						    }
					    }
					    $csv_rows[] = $rowvalue;
				    }
				    mysqli_free_result($result);
			    }
		    } while (mysqli_next_result($conn));
		    $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);

		    // Store information about the CSV file in `$csv_data` array
		    $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
		    return $csv_data[$csv_tablename];
	    } else {
		    // Handle error if query execution fails
		    echo "Error: " . mysqli_error($conn);
	    }
    }

    $count = 0;
    $rs = mysqli_query($conn, $query);
    $table_string = '';
    $rows = count($csv_headers);
    if (!$rs || mysqli_num_rows($rs) < 1) {
        return "<tr><td colspan='{$rows}'> No Data is available </td></tr>";
    }
    if($rs){
	    $header=[];
	    if (empty($header)) {
		    $header = array_keys(mysqli_fetch_array($rs, MYSQLI_ASSOC));
		    $rows = count($header);
		    $csv_headers = camel_replace($header);
		    mysqli_data_seek($rs, 0);
		    $table_string= get_table_skeleton_first($csv_headers);
	    }
    }
    $i = 0;
    // Initialize an array to store column-wise totals
    $column_totals = [];

    while ($row = mysqli_fetch_assoc($rs)) {
	    $csv_rows[] = $row;

	    // Check for row exclusion based on 'exclude' option
	    if (isset($options['exclude']) && in_array(current($row), $options['exclude'])) {
		    continue;
	    }

	    // Apply transformations based on 'format' option
	    $first_column = key($row);
	    if (isset($options['format']) && array_key_exists($row[$first_column], $options['format'])) {
		    $row[$first_column] = $options['format'][$row[$first_column]];
	    }

	    // Coloring rows alternately
	    $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
	    $table_string .= "<tr class='$bgColor'>";

	    foreach ($row as $column_name => $column_value) {
		    if ($column_value === 'fp') {
			    $column_value = 'firing pattern';
		    }
		    if (is_numeric($column_value)) {
			    $column_name = str_replace("_", " ", $column_name);
			    if (!isset($column_totals[$column_name])) {
				    $column_totals[$column_name] = 0;
			    }
			    $column_totals[$column_name] += $column_value;
			    $table_string .= "<td $style>" . number_format(htmlspecialchars($column_value)) . "</td>";
		    }
		    else{
			    $style = ($column_name === array_keys($row)[1]) ? 'style="width: 10%;"' : '';
			    if (end($row) > 0) {
				    $table_string .= "<td $style>" . htmlspecialchars($column_value) . "</td>";
			    }
		    }
	    }

	    $count += end($row);
	    $table_string .= "</tr>";
	    $i++;
    }
    if(isset($write_file)){
	    $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
	    $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
	    return $csv_data[$csv_tablename];
    } else{
	    $table_string .= generateTotalRow($csv_headers, false, $column_totals);
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

function toCamelCase($string) {
	$result = str_replace('_', ' ', $string);
	$result = ucwords($result);
	return $result;
}

function camel_replace($header, $char = NULL)
{
	if(!isset($char)){
		$csv_headers = array_map(function($header) {
                        return str_replace('_', ' ', $header);
                    }, $header);
                    
                    // Capitalize headers containing "SYNPRO"
                    foreach ($csv_headers as $key => $val) {
                        if (stripos(trim($val), 'SYNPRO') !== false) {
                            $csv_headers[$key] = ucwords(strtolower($val));
                        }
			if (stripos($val, 'SYNPRO') !== false) {
				$csv_headers[$key] = implode(' ', array_map('ucfirst', explode(' ', strtolower($val))));
			}
                    }
		return $csv_headers;
	}else{
		$csv_headers = array_map(function($header) {
                        return str_replace('_', $char, $header);
                    }, $header);
		return $csv_headers;
	}
}

function format_table_neurons($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $views_request = NULL) {
	$count =$neuron_page_views = $evidence_page_views = 0;
	$array_subs = []; 
	$csv_rows = [];
	$column_totals = [];
	if (isset($write_file)) {
		if (mysqli_multi_query($conn, $query)) {
			$header = []; // Initialize an array to store column names
			do {
				if ($result = mysqli_store_result($conn)) {
					if (empty($header)) {
						$header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
						$rows = count($header);
						$csv_headers = camel_replace($header);
						mysqli_data_seek($result, 0);
					}
					while ($rowvalue = mysqli_fetch_assoc($result)) {
						foreach ($rowvalue as $key => $value) {
							if($key == 'Subregion' || $key == 'Neuron_Type_Name'){
								continue;
							}
							if($key == 'Neuronal_Attribute'){
								$color_segments = ['red' => 'Axon Locations', 'blue' => 'Dendrite Locations', 'somata' => 'Soma Locations', 'violet' => 'Axon-Dendrite Locations', 
									'redSoma' => 'Axon-Somata Locations', 'blueSoma' => 'Dendrite-Somata Locations', 'violetSoma' => 'Axon-Dendrite-Somata Locations', 											 'reddal' => 'Axon Lengths', 'bluedal' => 'Dendrite Lengths', 'redsd' => 'Somatic Distances of Axons', 
									'bluesd' => 'Somatic Distances of Dendrites', 'violetSomadal' => 'None Of the Above', 'violetSomasd' => 'None of the Above', '' => 'None of the Above'];

								$rowvalue[$key] = isset($color_segments[$value]) ? $color_segments[$value] : 'None of the Above';
							}
							if($key == 'Firing_Pattern'){
								$fp_format = [
									'ASP.' => 'Adapting Spiking',
									'ASP.ASP.' => 'Adapting Spiking followed by (slower) Adapting Spiking',
									'ASP.NASP' => 'Non-Adapting Spiking preceded by Adapting Spiking',
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
								$rowvalue[$key] = isset($fp_format[$value]) ? $fp_format[$value] : 'None of the Above';
							}
							if($key == 'Marker_Evidence'){
								$neuronal_segments = ["CB"=>"CB", "CR"=>"CR", "PV"=>"PV", "5HT-3"=>"5HT-3", "CB1"=>"CB1", "Gaba-a-alpha"=>"GABAa_alfa", "mGluR1a"=>"mGluR1a", "Mus2R"=>"Mus2R", "NPY"=>"NPY", "nNOS"=>"nNOS", "AChE"=>"AChE", "AMIGO2"=>"AMIGO2", "Astn2"=>"Astn2", "Caln"=>"Caln", "CaMKII_alpha"=>"CaMKII_alpha", "ChAT"=>"ChAT", "Chrna2"=>"Chrna2", "CRF"=>"CRF", "Ctip2"=>"Ctip2",
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
									"GABAa\\alpha 2"=>"GABAa_alpha2", "GABAa\\\\alpha 2"=>"GABAa_alpha2", "GABAa\alpha 3"=>"GABAa_alpha3","GABAa%5Calpha%204"=>"GABAa_alpha4", "GABAa\alpha 4"=>"GABAa_alpha4", "GABAa\alpha 5"=>"GABAa_alpha5", "GABAa\alpha 6"=>"GABAa_alpha6", "CRH"=>"CRH", "NK1R"=>"NK1R",""=>"Other"];
								$rowvalue[$key] = isset($neuronal_segments[$value]) ? $neuronal_segments[$value] : 'Other';
							}
							if($key == "Biophysics_Evidence") {
								$neuronal_segments = ['Vrest'=>'Vrest (mV)', 'Rin'=>'Rin (MW)', 'tm'=>'tm (ms)', 'Vthresh'=>'Vthresh(mV)','fast_AHP'=>'Fast AHP (mV)', 
									'AP_ampl'=>'APampl (mV)','AP_width'=>'APwidth (ms)', 'max_fr'=>'Max F.R. (Hz)','slow_AHP'=>'Slow AHP (mV)',
									'sag_ratio'=>'Sag Ratio',''=>'Other'];
								$rowvalue[$key] = isset($neuronal_segments[$value]) ? $neuronal_segments[$value] : 'Other';
							}
							if($key == "Expression"){
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
								$rowvalue[$key] = isset($color_segments[$value]) ? $color_segments[$value] : 'Other';
							}
							if (is_null($value) || trim($value) === '') {
								if (is_numeric($value) || $value === '' || $value === null) {
									$value = '0'; // Replace NULL or empty string with 0 for numeric fields
								}
							}
							if ($value == 0) {
								$rowvalue[$key] = 0; // Replace 0 with an empty string
							} 
							if (is_numeric($value)) {
								$key = str_replace("_", " ", $key);
								if (!isset($column_totals[$key])){
									$column_totals[$key] = 0;
								}
								$column_totals[$key] += $value;
							}
						}
						$csv_rows[] = $rowvalue;
					}
					mysqli_free_result($result);
				}
			} while (mysqli_next_result($conn));
			$csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
			
			// Store information about the CSV file in `$csv_data` array
			$csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
			return $csv_data[$csv_tablename];
		} else {
			// Handle error if query execution fails
			echo "Error: " . mysqli_error($conn);
		}
	}
	$table_string1 = '';
	if (!$array_subs) {
		$array_subs = [];
	}

	$header = []; // Initialize an array to store column names
	if(!$array_subs){ $array_subs = [];}
        if(!$array_subs1){ $array_subs1 = [];}
        if(!$array_subsNA){ $array_subsNA = [];}
	$count = $neuron_page_views = $evidence_page_views = 0; // Initialize count for total views
	$table_string1 = '';
	$column_totals=[];
	if (mysqli_multi_query($conn, $query)) {
		do {
			if ($result = mysqli_store_result($conn)) {
				if (empty($header)) {
					$header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
					$rows = count($header);
					$csv_headers = camel_replace($header);
					mysqli_data_seek($result, 0);
					$table_string1 = get_table_skeleton_first($csv_headers);
				}
				while ($rowvalue = mysqli_fetch_assoc($result)) {
					$value = $rowvalue['Neuron_Type_Name'];
					if (isset($neuron_ids[$value])){ 
						if (!isset($write_file)) {
							$rowvalue['Neuron_Type_Name'] = get_link($value, $neuron_ids[$value], './neuron_page.php', 'neuron');
						}
					}
					if (!isset($array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']])) {
						$array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']] = [];
					}
					foreach($rowvalue as $col=>$value){
						if(($col == 'Neuron_Type_Name') || ($col == 'Subregion')){
							continue;
						}
						array_push($array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']], $value);
						// Check if the value is numeric and update the column total
						/*if (is_numeric($value)) {
							if (!isset($column_totals[$col])){
								$column_totals[$col] = 0;
							}
							$column_totals[$col] += $value;
						}*/
					}
				}
				mysqli_free_result($result);
			}
		} while (mysqli_next_result($conn));
		$array_subs = update_estimated_totals($array_subs);
		$i=0;
		$j=0;
		foreach ($array_subs as $groupKey => $subgroups) {
			$groupBgClass = ($i % 2 == 0) ? 'lightgreen-bg' : 'green-bg';
			$table_string1 .= "<tr><td class='$groupBgClass' rowspan='" . count($subgroups) . "'>$groupKey</td>";
			foreach ($subgroups as $subgroupKey => $colors) {
				$subgroupBgClass = ($j % 2 == 0) ? 'white-bg' : 'blue-bg';
				$table_string1 .= "<td class='$subgroupBgClass' rowspan=''>$subgroupKey</td>";
				$colorBgClass = ($j % 2 == 0) ? 'white-bg' : 'blue-bg';
				foreach ($colors as $col => $color) {
					if($color <=0 ){
						$color=0;
					}
					if (is_numeric($color)) {
						if (!isset($column_totals[$col])){
							$column_totals[$col] = 0;
						}
						$column_totals[$col] += $color;
					}
					$table_string1 .= "<td class='$colorBgClass'>".number_format($color)."</td>";
				}
				$j++;
				$table_string1 .= "</tr>";
			}
			$i++;
		}
		$table_string1 .= generateTotalRow($csv_headers, false, $column_totals);
		return $table_string1;
	}
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
	if(!$array_subs1){ $array_subs1 = [];}
	if(!$array_subsNA){ $array_subsNA = [];} 

	while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                // Modify neuron name if necessary
		if (isset($neuron_ids[$rowvalue['source_neuron_name']]) && $rowvalue['source_neuron_name'] != 'None of the Above' ) {
                        $rowvalue['source_neuron_name'] = get_link($rowvalue['source_neuron_name'], $neuron_ids[$rowvalue['source_neuron_name']], './neuron_page.php', 'neuron');
                }

                // Modify neuron name if necessary
		if (isset($neuron_ids[$rowvalue['target_neuron_name']]) && $rowvalue['target_neuron_name'] != 'None of the Above' ) {
                        $rowvalue['target_neuron_name'] = get_link($rowvalue['target_neuron_name'], $neuron_ids[$rowvalue['target_neuron_name']], './neuron_page.php', 'neuron');
                }

                // Extract relevant values
                $source_subregion = $rowvalue['source_subregion'];
                $source_neuron_name = $rowvalue['source_neuron_name'];
                $target_subregion = $rowvalue['target_subregion'];
                $target_neuron_name = $rowvalue['target_neuron_name'];
		$views = intval($rowvalue['Post_2017_Views']);
                $estimatedViews = intval($rowvalue['Estimated_Pre_2017_Views']);
                $totalViews = intval($rowvalue['Total_Views']);
		$parcel_specific = $rowvalue['parcel_specific'];
		$nm_page = $rowvalue['nm_page'];
		$connectivity_cols = ['Potential Connectivity Evidence', 'Number of Potential Synapses Parcel-Specific Table', 'Number of Potential Synapses Evidence', 'Number of Contacts Parcel-Specific Table', 'Number of Contacts Evidence','Synaptic Probability Parcel-Specific Table', 'Synaptic Probability Evidence', 'Other'];

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
						$evidence = 'Other';
				}
				break;

			case 'synpro_nm':
			case 'synpro':
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
						$evidence = 'Other';
				}
				break;
			case 'morphology':
			case 'fp':
			case 'markers':	
				switch($nm_page){
					case 'N/A':
						$evidence = 'Other';
					default:
						$evidence = 'Other';
				}
				break;
			
		}
		//echo "Source: ".$source_subregion."neuron name".$source_neuron_name."Target: ".$target_subregion." Target Neuron: ".$target_neuron_name." Evidence: ".$evidence; 
		// Determine if the source or target neuron type is 'None of the Above' and the respective subregion
		$isSourceNoneOfTheAbove = ($rowvalue['source_neuron_name'] == 'None of the Above');
		$isTargetNoneOfTheAbove = ($rowvalue['target_neuron_name'] == 'None of the Above');

		// Determine the subregion values to use based on the condition
		$sourceSubregion = $isSourceNoneOfTheAbove ? 'N/A' : $rowvalue['source_subregion'];
		$sourceNeuronType = $isSourceNoneOfTheAbove ? 'None of the Above' : $rowvalue['source_neuron_name'];

		$targetSubregion = $isTargetNoneOfTheAbove ? 'N/A' : $rowvalue['target_subregion'];
		$targetNeuronType = $isTargetNoneOfTheAbove ? 'None of the Above' : $rowvalue['target_neuron_name'];

		if ($isSourceNoneOfTheAbove || $isTargetNoneOfTheAbove) {
			// Determine the actual subregion and neuron type for "None of the Above"
			$actualSourceSubregion = $isSourceNoneOfTheAbove ? $targetSubregion : $sourceSubregion;
			$actualSourceNeuronType = $isSourceNoneOfTheAbove ? $targetNeuronType : $sourceNeuronType;

			$actualTargetSubregion = $isTargetNoneOfTheAbove ? $sourceSubregion : $targetSubregion;
			$actualTargetNeuronType = $isTargetNoneOfTheAbove ? $sourceNeuronType : $targetNeuronType;

			// Initialize the array if not already set
			if (!isset($array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType])) {
				$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType] = initializeConnectionNeuronArray($connectivity_cols);

				// Set all columns to 0 initially
				foreach ($connectivity_cols as $col) {
					$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$col] = 0;
				}
			}

			// Update evidence column and increment values
			if (!isset($array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence])) {
				$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence] = 0;
			}
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence] += intval($views);

			// Increment views and totals
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Post_2017_Views'] += intval($views);
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Estimated_Pre_2017_Views'] += intval($estimatedViews);
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Total_Views'] += intval($totalViews);
		} else {
			// Determine if the source or target has an empty string
			$actualSourceSubregion = $sourceSubregion ?: 'Other';
			$actualSourceNeuronType = $sourceNeuronType ?: 'Other';
			$actualTargetSubregion = $targetSubregion ?: 'Other';
			$actualTargetNeuronType = $targetNeuronType ?: 'Other';

			// Initialize the array if not already set
			if (!isset($array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType])) {
				$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType] = initializeConnectionNeuronArray($connectivity_cols);

				// Set all columns to 0 initially
				foreach ($connectivity_cols as $col) {
					$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$col] = 0;
				}
			}

			// Update evidence column and increment values
			if (!isset($array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence])) {
				$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence] = 0;
			}
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType][$evidence] += intval($views);

			// Increment views and totals
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Post_2017_Views'] += intval($views);
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Estimated_Pre_2017_Views'] += intval($estimatedViews);
			$array_subs1[$actualSourceSubregion][$actualSourceNeuronType][$actualTargetSubregion][$actualTargetNeuronType]['Total_Views'] += intval($totalViews);
		}
	}
	$array_subs = array_merge_recursive($array_subs1, $array_subsNA);
        $column_totals=[];
        if(isset($write_file)){
		$i = $j = $k = $total_count = 0;
		$csv_rows = [];

		foreach ($array_subs as $type => $subtypes) {
			$source_subregion = $type;
			foreach ($subtypes as $subtype => $target_values) {
				$source_neuron_name = $subtype;
				foreach ($target_values as $target_subtype => $target_neuron_values) {
					$target_subregion = $target_subtype;
					foreach ($target_neuron_values as $target_neuron => $values) {
						$target_neuron_name = $target_neuron;

						// Start assembling a row with neuron information
						$row = [$source_subregion, $source_neuron_name, $target_subregion, $target_neuron_name];

						// Add values to the row
						foreach ($values as $property => $value) {
							if ($value >= 0) {
								$row[] = $value; // Only add the value if it's >= 1
							} else {
								$row[] = 0; // Add an empty string for values less than 1
							}
							if (is_numeric($value)) {
								if (!isset($column_totals[$property])) {
									$column_totals[$property] = 0;
								}
								$column_totals[$property] += $value;
							}       
						}
						$csv_rows[] = $row;
					}
				}
			}
		}

		$csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
		$csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
                return $csv_data[$csv_tablename];
        }
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
						$showval=0;
						if($value >= 0){$showval = $value;}
						if (is_numeric($value)) {
							if (!isset($column_totals[$property])) {
								$column_totals[$property] = 0;
							}
							$column_totals[$property] += $value;
						}
						if ($j % 2 == 0) {
							$table_string2 .= "<td class='white-bg'>".number_format($showval)."</td>";
						}else{
							$table_string2 .= "<td class='blue-bg'>".number_format($showval)."</td>";
						}
					}
					$j++;
				}
			}	
		}
	}
        $table_string1 .= $table_string2;
        $table_string1 .= generateTotalRow($csv_headers, false, $column_totals);
        //$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$total_count."</td></tr>";
        return $table_string1;
}

function generateTotalRow($headers, $isCsv = true, $columnTotals = [])
{   
    $numHeaders = count($headers);
    $numTotals = count($columnTotals);
    $totalCountRow = ["Total Count"];
    $numEmptyColumns = $numHeaders - $numTotals - 1;
    $numEmptyColumns = max($numEmptyColumns, 0); 
    if ($numEmptyColumns >= 0) {
        $totalCountRow = array_merge($totalCountRow, array_fill(0, $numEmptyColumns, ''));
    }
    foreach ($headers as $header) {
        if (isset($columnTotals[$header])) {
		$totalCountRow[] = $columnTotals[$header];
        }
    }
    if ($isCsv) {
        return $totalCountRow;
    } else {
        $htmlRow = "<tr><td colspan='" . ($numEmptyColumns + 1) . "' class='total-row'>Total Count</td>";
        foreach ($columnTotals as $total_value) {
            $htmlRow .= "<td>". number_format($total_value) ."</td>";
        }
        $htmlRow .= "</tr>";
        return $htmlRow;
    }
}

function format_table_morphology($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL) {
    $csv_rows = [];
    $rs = mysqli_query($conn, $query);
    $table_string1 = '';
    $numHeaders = count($csv_headers);
    $total_count = 0;

    $color_segments = ['red' => 'Axon Locations', 'blue' => 'Dendrite Locations', 'somata' => 'Soma Locations', 'violet' => 'Axon-Dendrite Locations', 'redSoma' => 'Axon-Somata Locations', 
			'blueSoma' => 'Dendrite-Somata Locations', 'violetSoma' => 'Axon-Dendrite-Somata Locations', 'reddal' => 'Axon Lengths', 'bluedal' => 'Dendrite Lengths', 
			'redsd' => 'Somatic Distances of Axons', 'bluesd' => 'Somatic Distances of Dendrites', 'violetSomadal' => 'None of the Above', 'violetSomasd' => 'None of the Above', '' => 'None of the Above'];

    $color_cols = ['Axon Locations', 'Dendrite Locations', 'Soma Locations', 'Axon-Dendrite Locations', 'Axon-Somata Locations', 'Dendrite-Somata Locations', 'Axon-Dendrite-Somata Locations', 
		   'Axon Lengths', 'Dendrite Lengths', 'Somatic Distances of Axons', 'Somatic Distances of Dendrites', 'None of the Above'];

    $cols = ['DG:SMo', 'DG:SMi', 'DG:SG', 'DG:H', 'CA3:SLM', 'CA3:SR', 'CA3:SL', 'CA3:SP', 'CA3:SO', 'CA2:SLM', 'CA2:SR', 'CA2:SP', 'CA2:SO', 'CA1:SLM', 'CA1:SR', 'CA1:SP', 'CA1:SO', 'Sub:SM', 
		'Sub:SP', 'Sub:PL', 'EC:I', 'EC:II', 'EC:III', 'EC:IV', 'EC:V', 'EC:VI', 'Other'];

    $neuronal_segments = ['DG_SMo' => 'DG:SMo', 'DG_SMi' => 'DG:SMi', 'DG_SG' => 'DG:SG', 'DG_H' => 'DG:H', 'CA3_SLM' => 'CA3:SLM', 'CA3_SR' => 'CA3:SR', 'CA3_SL' => 'CA3:SL', 'CA3_SP' => 'CA3:SP', 
			  'CA3_SO' => 'CA3:SO', 'CA2_SLM' => 'CA2:SLM', 'CA2_SR' => 'CA2:SR', 'CA2_SP' => 'CA2:SP', 'CA2_SO' => 'CA2:SO', 'CA1_SLM' => 'CA1:SLM', 'CA1_SR' => 'CA1:SR', 'CA1_SP' => 'CA1:SP', 
			  'CA1_SO' => 'CA1:SO', 'SUB_SM' => 'Sub:SM', 'SUB_SP' => 'Sub:SP', 'SUB_PL' => 'Sub:PL', 'EC_I' => 'EC:I', 'EC_II' => 'EC:II', 'EC_III' => 'EC:III', 'EC_IV' => 'EC:IV', 'EC_V' => 'EC:V', 
			  'EC_VI' => 'EC:VI', '' => 'Other'];

    if (!$rs || ($rs->num_rows < 1)) {
	    $table_string1 .= "<tr><td> No Data is available </td></tr>";
	    return $table_string1;
    }

    if (!$array_subs) { $array_subs = []; }

    $neuronal_segments = array_change_key_case($neuronal_segments, CASE_LOWER);
    while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
	    if (empty($rowvalue['neuron_name']) || empty($rowvalue['subregion'])) {
		    continue;
	    }
	    if (isset($neuron_ids[$rowvalue['neuron_name']])) {
		    if (!isset($write_file)) {
			    $rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php', 'neuron');
		    }
	    }

	    $color_sp = isset($color_segments[$rowvalue['color_sp']]) ? $color_segments[$rowvalue['color_sp']] : 'None of the Above';
	    $subregion = $rowvalue['subregion'];
	    $neuron_name = $rowvalue['neuron_name'];
	    $color_sp = isset($color_segments[$rowvalue['color_sp']]) ? $color_segments[$rowvalue['color_sp']] : 'None of the Above';

	    $evidence = isset($neuronal_segments[strtolower($rowvalue['evidence'])]) ? $neuronal_segments[strtolower($rowvalue['evidence'])] : 'None of the Above';
//	    $evidence = isset($neuronal_segments[$rowvalue['evidence']]) ? $neuronal_segments[$rowvalue['evidence']] : 'None of the Above';
		
	    if ($evidence == 'GABAa_alpha2' && empty($rowvalue['color_sp'])) {
		    $rowvalue['color_sp'] = 'positive';
		    $color_sp = $color_segments[$rowvalue['color_sp']] ?? 'None of the Above';
	    }

	    if (!isset($array_subs[$subregion])) {
		    $array_subs[$subregion] = [];
	    }

	    if (!isset($array_subs[$subregion][$neuron_name])) {
		    $array_subs[$subregion][$neuron_name] = initializeNeuronArray($cols, $color_cols);
	    }

	    if (!isset($array_subs[$subregion][$neuron_name][$color_sp][$evidence])) {
		    $array_subs[$subregion][$neuron_name][$color_sp][$evidence] = 0;
	    }

	    if (!isset($array_subs[$subregion][$neuron_name][$color_sp]['Post_2017_Views'])) {
		    $array_subs[$subregion][$neuron_name][$color_sp]['Post_2017_Views'] = 0;
	    }

	    if (!isset($array_subs[$subregion][$neuron_name][$color_sp]['Estimated_Pre_2017_Views'])) {
		    $array_subs[$subregion][$neuron_name][$color_sp]['Estimated_Pre_2017_Views'] = 0;
	    }

	    if (!isset($array_subs[$subregion][$neuron_name][$color_sp]['Total_Views'])) {
		    $array_subs[$subregion][$neuron_name][$color_sp]['Total_Views'] = 0;
	    }
	    $views = isset($rowvalue['Post_2017_Views']) && is_numeric($rowvalue['Post_2017_Views']) ? intval($rowvalue['Post_2017_Views']) : 0;
	    $estimated_views = isset($rowvalue['Estimated_Pre_2017_Views']) && is_numeric($rowvalue['Estimated_Pre_2017_Views']) ? intval($rowvalue['Estimated_Pre_2017_Views']) : 0;
	    $total_views = isset($rowvalue['Total_Views']) && is_numeric($rowvalue['Total_Views']) ? intval($rowvalue['Total_Views']) : 0;

	    // Add views to respective categories
	    $array_subs[$subregion][$neuron_name][$color_sp][$evidence] += $views;
	    $array_subs[$subregion][$neuron_name][$color_sp]['Post_2017_Views'] += $views; // Assuming Post_2017_Views is equal to current views
	    $array_subs[$subregion][$neuron_name][$color_sp]['Estimated_Pre_2017_Views'] += $estimated_views;
	    $array_subs[$subregion][$neuron_name][$color_sp]['Total_Views'] += $total_views;
    }

    // Loop through $array_subs to initialize missing view counts and accumulate totals
    foreach ($array_subs as $subregion => &$neuron_names) {
	    foreach ($neuron_names as $neuron_name => &$colors) {
		    foreach ($colors as $color_sp => &$colorVals) {
			    // Initialize missing view counts to 0 for the specific columns
			    if (!isset($colorVals['Post_2017_Views'])) {
				    $colorVals['Post_2017_Views'] = 0;
			    }
			    if (!isset($colorVals['Estimated_Pre_2017_Views'])) {
				    $colorVals['Estimated_Pre_2017_Views'] = 0;
			    }
			    if (!isset($colorVals['Total_Views'])) {
				    $colorVals['Total_Views'] = 0;
			    }
		    }
	    }
    }
    unset($neuron_names, $colors, $colorVals); // Unset references to avoid unintended modifications
    $column_totals = [];
    if (isset($write_file)) {
	    $csv_rows = [];

	    // Iterate over array_subs to create CSV rows and accumulate totals
	    foreach ($array_subs as $type => $subtypes) {
		    foreach ($subtypes as $subtype => $values) {
			    $typeData = [$type]; // First value in the row

			    foreach ($values as $category => $properties) {
				    $rowData = array_merge($typeData, [$subtype, $category]); // Create row with type, subtype, and category

				    foreach ($properties as $property => $value) {
					    if ($property == "") continue; // Skip empty properties

					    if (is_null($value) || trim($value) === '') {
						    if (is_numeric($value) || $value === '' || $value === null) {
							    $value = '0'; // Replace NULL or empty string with 0 for numeric fields
						    }
					    }

					    // Show value if >= 1, otherwise set it to zero
					    $showVal = is_numeric($value) ? $value : 0;

					    if (is_numeric($value)) {
						    if (!isset($column_totals[$property])) {
							    $column_totals[$property] = 0;
						    }
						    $column_totals[$property] += $value;
					    }     
					    $rowData[] = $showVal;
				    }
				    // Add rowData to CSV rows
				    $csv_rows[] = $rowData;
			    }
		    }
	    }
    	    $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
	    // Create final CSV data structure
	    $csv_data[$csv_tablename] = [
		    'filename' => toCamelCase($csv_tablename),
		    'headers' => $csv_headers,
		    'rows' => $csv_rows
	    ];
	    return $csv_data[$csv_tablename];
    }
    $i = $j = $k = $total_count = 0;
    $table_string2 = '';
    $column_totals=[];
    foreach ($array_subs as $type => $subtypes) {
	    $keyCounts = count($subtypes);
	    $typeCellAdded = false;

	    foreach ($subtypes as $subtype => $values) {
		    $keyCounts2 = count($values) + 1; // Adjusted count
		    $subtyperowspan = $keyCounts2;
		    $typerowspan = $keyCounts * $keyCounts2;
		    if (!$typeCellAdded) {
			    if ($j%2==0) {
				    $table_string2 .= "<tr><td class='lightgreen-bg' rowspan='".$typerowspan."'>".$type."</td>";
			    } else {
				    $table_string2 .= "<tr><td class='green-bg' rowspan='".$typerowspan."'>".$type."</td>";
			    }
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
				    $showval=$value;

				    if($k%2==0){
					    $table_string2 .= "<td class='white-bg'>".$showval."</td>";
				    }else{
					    $table_string2 .= "<td class='blue-bg'>".$showval."</td>";
				    }
				    if (is_numeric($value)) {
					    if (!isset($column_totals[$property])) {
						    $column_totals[$property] = 0;
					    }
					    $column_totals[$property] += $value;
				    }     
			    }
		    }
		    $i++;
		    $table_string2 .= "</tr>";
	    }
	    $j++;
    }
    $table_string2 .= generateTotalRow($csv_headers, false, $column_totals);
    return $table_string2;
}

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
				""=>"Other"];

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

	$color_cols = ['Positive','Negative','Positive-Negative','Positive Inference','Negative Inference','Positive-Negative Inference', 'None of the Above'];

	$cols= ["CB", "CR", "PV", "5HT-3", "CB1", "GABAa_alfa", "mGluR1a", "Mus2R", "Sub P Rec", "vGluT3", "CCK", "ENK", "NG", "NPY", "SOM", "VIP", "a-act2", "CoupTF_2", "nNOS", "RLN", "AChE", 
			"AMIGO2", "AR-beta1", "AR-beta2", "Astn2", "BDNF", "Bok", "Caln", "CaM", "CaMKII_alpha", "CGRP", "ChAT", "Chrna2", "CRF", "Ctip2", "Cx36", "CXCR4", "Dcn", "Disc1", "DYN", "EAAT3", 
			"ErbB4", "GABAa_alpha2", "GABAa_alpha3", "GABAa_alpha4", "GABAa_alpha5", "GABAa_alpha6", "GABAa_beta1", "GABAa_beta2", "GABAa_beta3", "GABAa_delta", "GABAa_gamma1", "GABAa_gamma2","GABA-B1", 
		"GAT-1", "GAT-3", "GluA1", "GluA2", "GluA2/3", "GluA3", "GluA4", "GlyT2", "Gpc3", "Grp", "Htr2c", "Id_2", "Kv3_1", "Loc432748", "Man1a", "Math-2", "mGluR1", "mGluR2", 
			"mGluR2/3", "mGluR3", "mGluR4", "mGluR5", "mGluR5a", "mGluR7a", "mGluR8a", "MOR", 
			"Mus1R", "Mus3R", "Mus4R", "Ndst4", "NECAB1", "Neuropilin2", "NKB", "Nov", "Nr3c2", "Nr4a1", "p-CREB", "PCP4", "PPE", "PPTA", "Prox1", "Prss12", "Prss23", "PSA-NCAM", "SATB1", 
			"SATB2", "SCIP", "SPO", "SubP", "Tc1568100", "TH", "vAChT", "vGAT", "vGluT1", "vGluT2", "VILIP", "Wfs1", "Y1", "Y2", "DCX", "NeuN", "NeuroD", "CRH", "NK1R", "Other"];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}
	$color_segments = array_change_key_case($color_segments, CASE_LOWER);
	//$neuronal_segments = array_change_key_case($neuronal_segments, CASE_LOWER);
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
		//if(!isset($color_segments[$rowvalue['color']])){ var_dump($rowvalue); }
		$color = isset($color_segments[strtolower($rowvalue['color'])]) ? $color_segments[strtolower($rowvalue['color'])] : 'None of the Above';
		//$color = $color_segments[$rowvalue['color']];
		$decodedKey = urldecode($rowvalue['evidence']);
		// Check if the key exists in the array
		if (array_key_exists($decodedKey, $neuronal_segments)) {
			$evidence = $neuronal_segments[$decodedKey];
		} else {
			$evidence = $neuronal_segments[""];
		}
		//$evidence = $neuronal_segments[$rowvalue['evidence']];
		if($evidence == 'GABAa_alpha2'){
			if(strlen($rowvalue['color']) ==0){
				$rowvalue['color']='positive';
				$color =$color_segments[$rowvalue['color']];
			}
		}
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

		 if (!isset($array_subs[$subregion][$neuron_name][$color]['Post_2017_Views'])) {
			 $array_subs[$subregion][$neuron_name][$color]['Post_2017_Views'] = 0;
		 }

		 if (!isset($array_subs[$subregion][$neuron_name][$color]['Estimated_Pre_2017_Views'])) {
			 $array_subs[$subregion][$neuron_name][$color]['Estimated_Pre_2017_Views'] = 0;
		 }

		 if (!isset($array_subs[$subregion][$neuron_name][$color]['Total_Views'])) {
			 $array_subs[$subregion][$neuron_name][$color]['Total_Views'] = 0;
		 }

		 $views = isset($rowvalue['Post_2017_Views']) && is_numeric($rowvalue['Post_2017_Views']) ? intval($rowvalue['Post_2017_Views']) : 0;
		 $estimated_views = isset($rowvalue['Estimated_Pre_2017_Views']) && is_numeric($rowvalue['Estimated_Pre_2017_Views']) ? intval($rowvalue['Estimated_Pre_2017_Views']) : 0;
		 $total_views = isset($rowvalue['Total_Views']) && is_numeric($rowvalue['Total_Views']) ? intval($rowvalue['Total_Views']) : 0;
		 // Increment values
		 $array_subs[$subregion][$neuron_name][$color][$evidence] += intval($views);
		 $array_subs[$subregion][$neuron_name][$color]['Post_2017_Views'] += intval($views);
		 $array_subs[$subregion][$neuron_name][$color]['Estimated_Pre_2017_Views'] += intval($estimated_views);
		 $array_subs[$subregion][$neuron_name][$color]['Total_Views'] += intval($total_views);
	}

	// Loop through $array_subs to initialize missing view counts and accumulate totals
	foreach ($array_subs as $subregion => &$neuron_names) {
		foreach ($neuron_names as $neuron_name => &$colors) {
			foreach ($colors as $color => &$colorVals) {
				// Initialize missing view counts to 0 for the specific columns
				if (!isset($array_subs[$subregion][$neuron_name][$color]['Post_2017_Views'])) {
					$colorVals['Post_2017_Views'] = 0;
				}
				if (!isset($array_subs[$subregion][$neuron_name][$color]['Estimated_Pre_2017_Views'])) {
					$colorVals['Estimated_Pre_2017_Views'] = 0;
				}
				if (!isset($array_subs[$subregion][$neuron_name][$color]['Total_Views'])) {
					$colorVals['Total_Views'] = 0;
				}
			}
		}
	}
	unset($neuron_names, $colors, $colorVals); // Unset references to avoid unintended modifications
	$column_totals = [];
	if (isset($write_file)) {
            $csv_rows = [];

            // Iterate over array_subs to create CSV rows and accumulate totals
            foreach ($array_subs as $type => $subtypes) {
                    foreach ($subtypes as $subtype => $values) {
                            $typeData = [$type]; // First value in the row

                            foreach ($values as $category => $properties) {
                                    $rowData = array_merge($typeData, [$subtype, $category]); // Create row with type, subtype, and category

                                    foreach ($properties as $property => $value) {
                                            if ($property == "") continue; // Skip empty properties
					     if (is_null($value) || trim($value) === '') {
                                                    if (is_numeric($value) || $value === '' || $value === null) {
                                                            $value = '0'; // Replace NULL or empty string with 0 for numeric fields
                                                    }
                                            }

                                            // Show value if >= 1, otherwise set it to zero 
                                            $showVal = is_numeric($value) ? $value : 0; 

                                            if (is_numeric($value)) {
                                                    if (!isset($column_totals[$property])) {
                                                            $column_totals[$property] = 0; 
                                                    }    
                                                    $column_totals[$property] += $value;
                                            }                
                                            $rowData[] = $showVal;
                                    }    
                                    // Add rowData to CSV rows 
                                    $csv_rows[] = $rowData;
                            }    
                    }    
            }    
            $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
            // Create final CSV data structure
            $csv_data[$csv_tablename] = [
                    'filename' => toCamelCase($csv_tablename),
                    'headers' => $csv_headers,
                    'rows' => $csv_rows
            ];   
            return $csv_data[$csv_tablename];
	} 
	$i = $j = $k = $total_count = 0; 
	$table_string2 = '';
	$column_totals=[];
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
					$showval=$value;

					if($k%2==0){
						$table_string2 .= "<td class='white-bg'>".$showval."</td>";
					}else{
						$table_string2 .= "<td class='blue-bg'>".$showval."</td>";
					}
					if (is_numeric($value)) {
						if (!isset($column_totals[$property])) {
							$column_totals[$property] = 0; 
						}    
						$column_totals[$property] += $value;
					}            

				}
			}
			$i++;
			$table_string2 .= "</tr>";
		}
		$j++;
	}
	$table_string2 .= generateTotalRow($csv_headers, false, $column_totals);
	return $table_string2;
}

// Function to generate alternating row color class
function alternateRowClass($index) {
    return $index % 2 == 0 ? 'white-row' : 'blue-row';
}

// Function to generate alternating key color class
function alternateKeyClass($index) {
    return $index % 2 == 0 ? 'green-key' : 'light-green-key';
}

/*function update_estimated_totals($array_subs){
        foreach ($array_subs as $groupKey => $subgroups) {
                foreach ($subgroups as $subgroupKey => $colors) {
                        if( ($colors['Post_2017_Views'] > $colors['Estimated_Pre_2017_Views']) || 
                                       ($colors['Estimated_Pre_2017_Views'] == 0 && $colors['Post_2017_Views'] > 1)) {
                               $array_subs[$groupKey][$subgroupKey]['Estimated_Pre_2017_Views'] = ROUND(DELTA_VIEWS * $colors['Post_2017_Views']);
                               $array_subs[$groupKey][$subgroupKey]['Total_Views'] = $colors['Post_2017_Views'] +  $array_subs[$groupKey][$subgroupKey]['Estimated_Pre_2017_Views'] ;
                       }
                }
        }
       return $array_subs;
}
*/

function update_estimated_totals($data) {
    $isSingleRow = isset($data['Post_2017_Views']); // Check if it's a single row
    if ($isSingleRow) {
        $data = [$data];
	foreach ($data as $key => $row) {
		if (!isset($row['Estimated_Pre_2017_Views'])) {
			$row['Estimated_Pre_2017_Views'] = 0;
		}
		if (($row['Post_2017_Views'] > $row['Estimated_Pre_2017_Views']) ||
				($row['Estimated_Pre_2017_Views'] == 0 && $row['Post_2017_Views'] > 1)) {
			$row['Estimated_Pre_2017_Views'] = round(DELTA_VIEWS * $row['Post_2017_Views']);
			$row['Total_Views'] = $row['Post_2017_Views'] + $row['Estimated_Pre_2017_Views'];
		}
		$data[$key] = $row; // Update the processed row in the array
	}
	return $isSingleRow ? $data[0] : $data;
    }
    else{
	    $array_subs = $data;
	    foreach ($array_subs as $groupKey => $subgroups) {
		    foreach ($subgroups as $subgroupKey => $colors) {
			    if( ($colors['Post_2017_Views'] > $colors['Estimated_Pre_2017_Views']) || 
					    ($colors['Estimated_Pre_2017_Views'] == 0 && $colors['Post_2017_Views'] > 1)) {
				    $array_subs[$groupKey][$subgroupKey]['Estimated_Pre_2017_Views'] = ROUND(DELTA_VIEWS * $colors['Post_2017_Views']);
				    $array_subs[$groupKey][$subgroupKey]['Total_Views'] = $colors['Post_2017_Views'] +  $array_subs[$groupKey][$subgroupKey]['Estimated_Pre_2017_Views'] ;
			    }
		    }
	    }
	    return $array_subs;

    }
}

function format_table_biophysics($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
	$neuronal_segments = ['Vrest'=>'Vrest (mV)', 'Rin'=>'Rin (MW)', 'tm'=>'tm (ms)', 'Vthresh'=>'Vthresh(mV)','fast_AHP'=>'Fast AHP (mV)',
		'AP_ampl'=>'APampl (mV)','AP_width'=>'APwidth (ms)', 'max_fr'=>'Max F.R. (Hz)','slow_AHP'=>'Slow AHP (mV)','sag_ratio'=>'Sag Ratio',''=>'Other'];

	$cols = ['Vrest (mV)', 'Rin (MW)', 'tm (ms)', 'Vthresh(mV)','Fast AHP (mV)','APampl (mV)','APwidth (ms)','Max F.R. (Hz)','Slow AHP (mV)','Sag Ratio','Other'];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}
	while($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)){
		if(isset($neuron_ids[$rowvalue['neuron_name']])){
			$rowvalue['neuron_name'] = get_link($rowvalue['neuron_name'], $neuron_ids[$rowvalue['neuron_name']], './neuron_page.php','neuron');
		}
		if(!isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']])){
			$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']] = [];
                        foreach($cols as $col){
                                $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$col] = 0;
                        }
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['Post_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Post_2017_Views'] += intval($rowvalue['Post_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Estimated_Pre_2017_Views'] += intval($rowvalue['Estimated_Pre_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Total_Views'] += intval($rowvalue['Total_Views']);
			}
		}else{
			if(isset($array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]]) && $array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] == 0){
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']][$neuronal_segments[$rowvalue['evidence']]] += intval($rowvalue['Post_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Post_2017_Views'] += intval($rowvalue['Post_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Estimated_Pre_2017_Views'] += intval($rowvalue['Estimated_Pre_2017_Views']);
				$array_subs[$rowvalue['subregion']][$rowvalue['neuron_name']]['Total_Views'] += intval($rowvalue['Total_Views']);
			}
		}
	}
	$array_subs = update_estimated_totals($array_subs);
	$column_totals = [];
	if (isset($write_file)) {
		$csv_rows = [];
		$column_totals = [];
		$all_headers = ['Group', 'Subgroup']; // Start with 'Group' and 'Subgroup'
		foreach ($array_subs as $groupKey => $subgroups) {
			foreach ($subgroups as $subgroupKey => $colors) {
				foreach ($colors as $property => $value) {
					if (!in_array($property, $all_headers, true) && $property !== "") {
						$all_headers[] = $property;
					}
				}
			}
		}
		$csv_rows[] = $all_headers;
		foreach ($array_subs as $groupKey => $subgroups) {
			foreach ($subgroups as $subgroupKey => $colors) {
				$rowData = array_fill(0, count($all_headers), 0); // Initialize the row with zeros
				$rowData[0] = $groupKey; // Set the 'Group' column
				$rowData[1] = $subgroupKey; // Set the 'Subgroup' column

				foreach ($colors as $property => $value) {
					$headerIndex = array_search($property, $all_headers, true);
					if (is_null($value) || trim($value) === '') {
						if (is_numeric($value) || $value === '' || $value === null) {
							$value = '0'; // Replace NULL or empty string with 0 for numeric fields
						}
					}
					if ($headerIndex !== false) {
						$rowData[$headerIndex] = $value > 0 ? $value : 0; // Ensure non-negative values
						if (is_numeric($value)) {
							// Accumulate totals for numeric columns
							if (!isset($column_totals[$property])) {
								$column_totals[$property] = 0;
							}
							$column_totals[$property] += $value;
						}
					}
				}

				// Add the current row to the CSV rows
				$csv_rows[] = $rowData;
			}
		}
		$csv_headers = $all_headers;
		$csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
		// Create final CSV data structure
		$csv_data[$csv_tablename] = [
			'filename' => toCamelCase($csv_tablename),
			'headers' => $csv_headers,
			'rows' => $csv_rows
		];
		return $csv_data[$csv_tablename];
	}
	$i = $j = $k = $total_count = 0;
	$column_totals=[];
	foreach ($array_subs as $groupKey => $subgroups) {
		$table_string1 .= "<tr>";
		$keyCounts = count(array_keys($subgroups));
		$rowspan = $keyCounts;
		if($j%2==0){
			$table_string1 .= "<td class='lightgreen-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}else{
                        $table_string1 .= "<td class='green-bg'  rowspan='".$rowspan."'>".$groupKey."</td>";
		}
		foreach ($subgroups as $subgroupKey => $colors) {
			if($i%2==0){
				$table_string1 .= "<td class='white-bg' >".$subgroupKey."</td>";
			}else{
				$table_string1 .= "<td class='blue-bg' >".$subgroupKey."</td>";
			}
			foreach($colors as $property => $value){
				if($value > 0){
				$value = $value;}else{$value=0;}
				if($i%2==0){
					$table_string1 .= "<td class='white-bg' >".$value."</td>";
				}else{
					$table_string1 .= "<td class='blue-bg' >".$value."</td>";
				}
				if (is_numeric($value)) {
					if (!isset($column_totals[$property])) {
						$column_totals[$property] = 0;
					}
					$column_totals[$property] += $value;
				}
			}
			$table_string1 .= "</tr>";
			$count += (int)$value;
			$i++;
		}
		$j++;
	}
	$table_string1 .= generateTotalRow($csv_headers, false, $column_totals);
	return $table_string1;
}


function initializeNeuronData(array &$arraySubsNA, array &$arraySubs1, array $rowValue, array $columns) {
    $isNoneOfTheAbove = ($rowValue['Neuron_Type_Name'] == 'None of the Above');
    $needsInitialization = $isNoneOfTheAbove
        ? !isset($arraySubsNA['N/A']['None of the Above'])
        : !isset($arraySubs1[$rowValue['Subregion']][$rowValue['Neuron_Type_Name']]);

    if ($needsInitialization) {
        $subregion = $isNoneOfTheAbove ? 'N/A' : $rowValue['Subregion'];
        $neuronType = $isNoneOfTheAbove ? 'None of the Above' : $rowValue['Neuron_Type_Name'];

        $targetArray = $isNoneOfTheAbove ? $arraySubsNA : $arraySubs1;
        $targetArray[$subregion][$neuronType] = [];

        // Initialize all columns to 0
        foreach ($columns as $column) {
            $targetArray[$subregion][$neuronType][$column] = 0;
        }

        // Ensure the reference is assigned back
        if ($isNoneOfTheAbove) {
            $arraySubsNA = $targetArray;
        } else {
            $arraySubs1 = $targetArray;
        }
    }
}

function format_table_phases($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $array_subs = NULL){
	
	$count = 0;
	$csv_rows=[];
        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	$rows = count($csv_headers);
    	$numHeaders = count($csv_headers);
	//For Phases page to replciate the string we show
	$neuronal_segments = [
		'theta'=>'Theta (deg)', 'swr_ratio'=>'SWR Ratio','firingRate'=>'In Vivo Firing Rate (Hz)', 'gamma' => 'Gamma (deg)', 'DS_ratio' => 'DS Ratio', 
		'Vrest' => 'Vrest (mV)', 'epsilon'=>'Epsilon','firingRateNonBaseline'=>'Non-Baseline Firing Rate (Hz)', 'APthresh'=>'APthresh (mV)', 'tau'=>'Tau (ms)', 
		'run_stop_ratio'=>'Run/Stop Ratio', 'ripple'=>'Ripple (deg)', 'fahp'=>'fAHP (mV)','APpeal'=>'APpeak-trough (ms)',
		'all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.',''=>'Other', 'None of the Above' => 'Other'];
	$cols = [ 'Theta (deg)', 'SWR Ratio','In Vivo Firing Rate (Hz)', 'DS Ratio', 'Ripple (deg)','Gamma (deg)', 'Run/Stop Ratio','Epsilon',
		'Non-Baseline Firing Rate (Hz)', 'Vrest (mV)', 'Tau (ms)',
		'APthresh (mV)','fAHP (mV)','APpeak-trough (ms)','Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.','Other', 'Post_2017_Views', 'Estimated_Pre_2017_Views', 'Total_Views'];

	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
	if(!$array_subs){ $array_subs = [];}
	if(!$array_subs1){ $array_subs1 = [];}
	if(!$array_subsNA){ $array_subsNA = [];}
	while ($rowvalue = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
		// Link the neuron_name if it exists in the neuron_ids array
		if (isset($neuron_ids[$rowvalue['Neuron_Type_Name']]) && $rowvalue['Neuron_Type_Name'] != 'None of the Above' ) {
			$rowvalue['Neuron_Type_Name'] = get_link($rowvalue['Neuron_Type_Name'], $neuron_ids[$rowvalue['Neuron_Type_Name']], './neuron_page.php', 'neuron');
		}
		// Initialize subregion and neuron name if not already set
		// Check if the Neuron_Type_Name is 'None of the Above' or not and if it needs to be initialized
		initializeNeuronData($array_subsNA, $array_subs1, $rowvalue, $cols);
		// Get the segment based on evidence
		$segment = $neuronal_segments[$rowvalue['Evidence']] ?? null;
		// Increment count for the segment if it exists
		$neuronTypeName = $rowvalue['Neuron_Type_Name'];
		$subregion = $rowvalue['subregion'] ?? $rowvalue['Subregion'];
		$views = intval($rowvalue['Post_2017_Views']);
		$estimatedViews = intval($rowvalue['Estimated_Pre_2017_Views']);
		$totalViews = intval($rowvalue['Total_Views']);

		if ($segment) {
			// If Neuron_Type_Name is 'None of the Above', use $array_subsNA
			if ($neuronTypeName == 'None of the Above' && isset($array_subsNA['N/A']['None of the Above'])) {

				$sub = "N/A";
				$neuronType = "None of the Above";
				$array_subsNA[$sub][$neuronType][$segment] += $views;
				$array_subsNA[$sub][$neuronType]['Post_2017_Views'] += $views;
				$array_subsNA[$sub][$neuronType]['Estimated_Pre_2017_Views'] += $estimatedViews;
				$array_subsNA[$sub][$neuronType]['Total_Views'] += $totalViews;
				// If Neuron_Type_Name is not 'None of the Above', use $array_subs1
			} else if ($neuronTypeName != 'None of the Above' && isset($array_subs1[$subregion][$neuronTypeName][$segment])) {
				// Update the counts for a specific Neuron Type
				$array_subs1[$subregion][$neuronTypeName][$segment] += $views;
				$array_subs1[$subregion][$neuronTypeName]['Post_2017_Views'] += $views;
				$array_subs1[$subregion][$neuronTypeName]['Estimated_Pre_2017_Views'] += $estimatedViews;
				$array_subs1[$subregion][$neuronTypeName]['Total_Views'] += $totalViews;
			}
		}
	}
//	var_dump($array_subsNA);
	// Merge $array_subs1 and $array_subsNA into $array_subs
	
	$array_subs = array_merge_recursive($array_subs1, $array_subsNA);
 	$column_totals = [];
	if(isset($write_file)){
		foreach ($array_subs as $groupKey => $subgroups) {
			foreach ($subgroups as $subgroupKey => $colors) {
				$rowData = [];
				$rowData[] = $groupKey;  // Include the group key only on the first line of its subgroups
				$rowData[] = $subgroupKey;  // Add subgroup key

				$totalAdded = false;
				foreach ($colors as $property => $value) {
					if($property == "") continue;
					if (is_null($value) || trim($value) === '') {
						if (is_numeric($value) || $value === '' || $value === null) {
							$value = '0'; // Replace NULL or empty string with 0 for numeric fields
						}
					}
					$showVal = 0;
					$showVal = ($value >= 0) ? $value : 0;

					$rowData[] = $showVal;
					if (is_numeric($value)) {
                                                if (!isset($column_totals[$property])) {
                                                        $column_totals[$property] = 0;
                                                }
                                                $column_totals[$property] += $value;
                                        }
				}
				// If 'total' was not added in the loop, ensure it's added now
				if (!$totalAdded) {
					//$rowData[] = '';  // Add an empty column if 'total' wasn't in $colors
				}
				$csv_rows[] = $rowData;  // Write the row to the CSV file
			}
		}
		//$totalCountRow = array_merge(["Total Count"], array_fill(1, $numHeaders - 2, ''), [$count] );
                $csv_rows[] = generateTotalRow($csv_headers, true, $column_totals);
		//$csv_rows[] = $totalCountRow;
		$csv_data[$csv_tablename] = ['filename' => toCamelCase($csv_tablename), 'headers' => $csv_headers, 'rows' => $csv_rows];
		return $csv_data[$csv_tablename];
	}
	//var_dump($array_subs);exit;
	$i=$j=0;
 	$column_totals=[];

	// Loop through the merged $array_subs
	foreach ($array_subs as $groupKey => $subgroups) {
		$table_string1 .= "<tr>";
		$keyCounts = count(array_keys($subgroups));
		$rowspan = $keyCounts;

		// Set background color for group rows
		if ($j % 2 == 0) {
			$table_string1 .= "<td class='lightgreen-bg' rowspan='" . $rowspan . "'>" . $groupKey . "</td>";
		} else {
			$table_string1 .= "<td class='green-bg' rowspan='" . $rowspan . "'>" . $groupKey . "</td>";
		}

		foreach ($subgroups as $subgroupKey => $colors) {
			// Set background color for subgroup rows
			if ($i % 2 == 0) {
				$table_string1 .= "<td class='white-bg'>" . $subgroupKey . "</td>";
			} else {
				$table_string1 .= "<td class='blue-bg'>" . $subgroupKey . "</td>";
			}

			foreach ($colors as $property => $value) {
				// Check if the value is greater than 0, otherwise set to 0
				$value = is_numeric($value) && $value > 0 ? $value : 0;

				// Set background color for the properties
				if ($i % 2 == 0) {
					$table_string1 .= "<td class='white-bg'>" . $value . "</td>";
				} else {
					$table_string1 .= "<td class='blue-bg'>" . $value . "</td>";
				}

				// Accumulate totals if value is numeric
				if (is_numeric($value)) {
					if (!isset($column_totals[$property])) {
						$column_totals[$property] = 0;
					}
					$column_totals[$property] += $value;
				}
			}

			$table_string1 .= "</tr>";
			$count += (int) $value;
			$i++;
		}
		$j++;
	}
        $table_string1 .= generateTotalRow($csv_headers, false, $column_totals);
	
	//$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
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

function get_views_per_page_report($conn, $views_request=NULL, $write_file=NULL){ //Passed $conn on Dec 3 2023

	$page_views_query = "SELECT 
		subquery.page as Page, 
		SUM(subquery.Post_2017_Views) AS Post_2017_Views,
		SUM(subquery.Estimated_Pre_2017_Views) AS Estimated_Pre_2017_Views,
		SUM(subquery.Total_Views) AS Total_Views
			FROM (
					SELECT 
					gap.page, 
					gap.day_index, 
					SUM(
						CASE WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED) 
						ELSE CAST(REPLACE(COALESCE(sessions, '0'), ',', '') AS UNSIGNED) END
					   ) AS Post_2017_Views,
					ROUND(".DELTA_VIEWS." * 
						SUM(
							CASE WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED)
							ELSE CAST(REPLACE(COALESCE(sessions, '0'), ',', '') AS UNSIGNED) END
						   )) AS Estimated_Pre_2017_Views,
					(SUM(
					     CASE WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED)
					     ELSE CAST(REPLACE(COALESCE(sessions, '0'), ',', '') AS UNSIGNED) END
					    )
					 + ROUND(".DELTA_VIEWS." * SUM(
							 CASE WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED)
							 ELSE CAST(REPLACE(COALESCE(sessions, '0'), ',', '') AS UNSIGNED) END
							 ))) AS Total_Views
						FROM 
						GA_combined_analytics gap 
						WHERE 
						gap.day_index IS NOT NULL
						GROUP BY 
						gap.page, gap.day_index
						) AS subquery
						GROUP BY 
						subquery.page
						ORDER BY 
						Total_Views DESC";
	if (($views_request == "views_per_month") || ($views_request == "views_per_year")) {
		$page_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_views_query .= "
				SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' THEN CASE WHEN CAST(REPLACE(COALESCE(page_views, \\'0\\'), \\'\\', \\'\\') AS UNSIGNED) > 0 ',
								'THEN CAST(REPLACE(page_views, \\'\\', \\'\\') AS UNSIGNED) ELSE  CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
						      )
						ORDER BY YEAR(day_index), MONTH(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM GA_combined_analytics
				     ) months;
			";
		}

		if ($views_request == "views_per_year") {
			$page_views_query .= "
				SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN CASE WHEN CAST(REPLACE(COALESCE(page_views, \\'0\\'), \\'\\', \\'\\') AS UNSIGNED) > 0 ',
								'THEN CAST(REPLACE(page_views, \\'\\', \\'\\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END ELSE 0 END) AS `',
							YEAR(day_index), '`'
						      )
						ORDER BY YEAR(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM GA_combined_analytics
				     ) years;
			";
		}

		$page_views_query .= "
			SET @sql = CONCAT(
					'SELECT page as Page, ',
					@sql,
					', SUM(CASE WHEN CAST(REPLACE(COALESCE(page_views, \\'0\\'), \\'\\', \\'\\') AS UNSIGNED) > 0 ',
						'THEN CAST(REPLACE(page_views, \\'\\', \\'\\') AS UNSIGNED) ELSE  CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END) AS Total_Views ',
					'FROM GA_combined_analytics ',
					'WHERE day_index IS NOT NULL ',
					'GROUP BY page ',
					'ORDER BY Total_Views DESC'
					);";

		$page_views_query .= "
			PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}
	//echo $page_views_query;
	$table_string ='';

	$columns = ['Page', 'Views'];
	$file_name='views_per_page';
	if(isset($write_file)) {
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= "_".$views_request;
		}
		return format_table($conn, $page_views_query, $table_string, $file_name, $columns, $neuron_ids=NULL, $write_file, $views_request);
	}
	else{
		$columns =[];
		$table_string .= format_table($conn, $page_views_query, $table_string, $file_name, $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_pages_views_per_month_report($conn, $write_file=NULL){ 
	 $page_views_per_month_query = "select concat(DATE_FORMAT(day_index,'%b'), '-', YEAR(day_index)) as 'Month-Year',
		 SUM(
				 CASE
				 WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED)
				 ELSE CAST(REPLACE(sessions, ',', '') AS UNSIGNED) 
				 END
		    ) AS Page_Views 
                        from GA_combined_analytics 
                        GROUP BY YEAR(day_index), MONTH(day_index)";
	//echo $page_views_per_month_query;
	$columns = ['Month-Year', 'Views'];
	$table_string='';
	if(isset($write_file)) {
		return format_table($conn, $page_views_per_month_query, $table_string, 'monthly_page_views', $columns, $neuron_ids=NULL, $write_file);
	}else{  
		$table_string .= format_table($conn, $page_views_per_month_query, $table_string, 'monthly_page_views', $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_table_skeleton_first($cols, $table_id = NULL){
	$table_string1 = "<table>";
	if($table_id){
		$table_string1 = "<table id='$table_id'>";
	}
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

function get_neurons_views_report($conn, $neuron_ids=NULL, $views_request=NULL, $write_file=NULL){ //Passed on Dec 3 2023
	$columns = ['Subregion', 'Neuron Type Name', 'Census','Views'];
	$page_neurons_views_query = "SELECT 
		COALESCE(Subregion, 'N/A') AS Subregion,
		Neuron_Type_Name,
		IFNULL(Neuron_Page_Views, 0) AS Neuron_Page_Views,
		IFNULL(Evidence_Page_Views, 0) AS Evidence_Page_Views,
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) AS Post_2017_Views,
		ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0))) AS Estimated_Pre_2017_Views,
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) + ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0))) AS Total_Views
			FROM (
					SELECT 
					COALESCE(t.subregion, 'N/A') AS Subregion,
					COALESCE(t.page_statistics_name, 'None of the Above') AS Neuron_Type_Name,
					SUM(
						CASE 
						WHEN nd.page LIKE '%neuron_page.php?id=%' THEN 
						CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Neuron_Page_Views,
					SUM(
						CASE 
						WHEN nd.page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' THEN 
						CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Evidence_Page_Views,
					COALESCE(t.position, 9999) AS position 
						FROM (
								SELECT 
								CASE 
								WHEN page LIKE '%neuron_page.php?id=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1)
								WHEN page REGEXP 'id_neuron=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
								WHEN page REGEXP 'id1_neuron=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
								WHEN page REGEXP 'id_neuron_source=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
								WHEN page REGEXP 'pre_id=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1)
								ELSE NULL 
								END AS neuronID,
								page,
								day_index,
								page_views,
								sessions
								FROM GA_combined_analytics
								WHERE page LIKE '%neuron_page.php?id=%'
								OR page REGEXP 'id_neuron=[0-9]+'
								OR page REGEXP 'id1_neuron=[0-9]+'
								OR page REGEXP 'id_neuron_source=[0-9]+'
								OR page REGEXP 'pre_id=[0-9]+'
						     ) AS nd
						     LEFT JOIN Type t ON nd.neuronID = t.id
						     GROUP BY t.subregion, t.page_statistics_name, t.position
						     UNION ALL
						     SELECT 
						     'N/A' AS Subregion,
					'None of the Above' AS Neuron_Type_Name,
					SUM(
							CASE 
							WHEN page LIKE '%neuron_page.php?id=%' THEN 
							CASE 
							WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Neuron_Page_Views,
					SUM(
							CASE 
							WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' THEN 
							CASE 
							WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Evidence_Page_Views,
					9999 AS position 
						FROM (
								SELECT 
								page, 
								page_views, 
								sessions
								FROM GA_combined_analytics
								WHERE page LIKE '%neuron_page.php?id=%' 
								AND (
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
								    )
						     ) AS unmatched_data
						) AS full_results
						GROUP BY Subregion, Neuron_Type_Name, position
						ORDER BY position ASC, Subregion, Neuron_Type_Name;
";
/*

SELECT 
		COALESCE(Subregion, 'N/A') AS Subregion, 
		Neuron_Type_Name, 
		IFNULL(Neuron_Page_Views, 0) AS Neuron_Page_Views, 
		IFNULL(Evidence_Page_Views, 0) AS Evidence_Page_Views, 
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) AS Post_2017_Views, 
		ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0)), 0) AS Estimated_Pre_2017_Views, 
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) 
			+ ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0)), 0) AS Total_Views 
			FROM (
					SELECT 
					COALESCE(t.subregion, 'N/A') AS Subregion, 
					COALESCE(t.page_statistics_name, 'None of the Above') AS Neuron_Type_Name, 
					SUM(
						CASE 
						WHEN nd.page LIKE '%neuron_page.php?id=%' 
						THEN CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 
						THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Neuron_Page_Views, 
					SUM(
						CASE 
						WHEN nd.page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
						THEN CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 
						THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Evidence_Page_Views, 
					t.position
						FROM 
						(SELECT 
						 CASE 
						 WHEN page LIKE '%neuron_page.php?id=%' 
						 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1)
						 WHEN page REGEXP 'id_neuron=[0-9]+' 
						 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
						 WHEN page REGEXP 'id1_neuron=[0-9]+' 
						 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
						 WHEN page REGEXP 'id_neuron_source=[0-9]+' 
						 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
						 WHEN page REGEXP 'pre_id=[0-9]+' 
						 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1)
						 ELSE NULL 
						 END AS neuronID, 
						 page, 
						 day_index, 
						 page_views, 
						 sessions
						 FROM 
						 GA_combined_analytics 
						 WHERE 
						 page LIKE '%neuron_page.php?id=%' 
						 OR page REGEXP 'id_neuron=[0-9]+' 
						 OR page REGEXP 'id1_neuron=[0-9]+' 
						 OR page REGEXP 'id_neuron_source=[0-9]+' 
						 OR page REGEXP 'pre_id=[0-9]+'
						 ) AS nd
						 LEFT JOIN Type t 
						 ON nd.neuronID = t.id
						 GROUP BY t.subregion, t.page_statistics_name, t.position

						 UNION ALL

						 SELECT 
						 'N/A' AS Subregion, 
					'None of the Above' AS Neuron_Type_Name, 
					SUM(
							CASE 
							WHEN page LIKE '%neuron_page.php?id=%' 
							THEN CASE 
							WHEN REPLACE(page_views, ',', '') > 0 
							THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Neuron_Page_Views, 
					SUM(
							CASE 
							WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
							THEN CASE 
							WHEN REPLACE(page_views, ',', '') > 0 
							THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Evidence_Page_Views, 
					NULL AS position
						FROM 
						(SELECT 
						 page, 
						 page_views, 
						 sessions 
						 FROM 
						 GA_combined_analytics 
						 WHERE 
						 page LIKE '%neuron_page.php?id=%' 
						 AND (
							 SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
							 OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
							 OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
							 OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (SELECT id FROM Type)
							 OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
						     )
						) AS unmatched_data
						) AS full_results
						GROUP BY Subregion, Neuron_Type_Name, position
						ORDER BY position ASC, Subregion, Neuron_Type_Name;";
*/
	echo $page_neurons_views_query;
	if (($views_request == "views_per_month")  || ($views_request == "views_per_year")) {
		$page_neurons_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_neurons_views_query .= "
				SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
							)
						ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', '
					    ) 
				INTO @sql 
				FROM (SELECT DISTINCT day_index FROM GA_combined_analytics) months;";
		}
		if($views_request == "views_per_year"){
			$page_neurons_views_query .= " SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), '`'
						      )
						ORDER BY YEAR(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM GA_combined_analytics 
				     ) years;";
		}

		$page_neurons_views_query .= "
			SET @sql = CONCAT(
					'SELECT COALESCE(Subregion, ''N/A'') AS Subregion, ',
					'Neuron_Type_Name, ', 
					@sql, ', ',
					'SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END) AS Total_Views ',
					'FROM ( ',
						'SELECT COALESCE(t.subregion, ''N/A'') AS Subregion, ',
						'COALESCE(t.page_statistics_name, ''None of the Above'') AS Neuron_Type_Name, ',
						'ga.day_index, ga.page_views, ga.sessions ',
						'FROM ( ',
							'SELECT CASE ',
							'WHEN page REGEXP ''id_neuron=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1) ',
							'WHEN page REGEXP ''id1_neuron=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1) ',
							'WHEN page REGEXP ''id_neuron_source=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1) ',
							'WHEN page REGEXP ''pre_id=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''pre_id='', -1), ''&'', 1) ',
							'ELSE NULL END AS neuronID, page, day_index, page_views, sessions ',
							'FROM GA_combined_analytics ',
							'WHERE page REGEXP ''id_neuron=[0-9]+'' ',
							'OR page REGEXP ''id1_neuron=[0-9]+'' ',
							'OR page REGEXP ''id_neuron_source=[0-9]+'' ',
							'OR page REGEXP ''pre_id=[0-9]+'' ',
							') AS ga ',
						'LEFT JOIN Type t ON ga.neuronID = t.id ',
						'UNION ALL ',
						'SELECT ''N/A'' AS Subregion, ',
						'''None of the Above'' AS Neuron_Type_Name, ',
						'unmatched_data.day_index, unmatched_data.page_views, unmatched_data.sessions ',
						'FROM ( ',
								'SELECT page, day_index, page_views, sessions ',
								'FROM GA_combined_analytics ',
								'WHERE page LIKE ''%neuron_page.php?id=%'' ',
								'AND NOT EXISTS ( ',
									'SELECT 1 FROM Type t ',
									'WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id='', -1), ''&'', 1) = t.id ',
									') ',
								') AS unmatched_data ',
						') AS full_results ',
						'GROUP BY Subregion, Neuron_Type_Name ',
						'ORDER BY (Subregion = ''N/A'') ASC, Subregion, Neuron_Type_Name'
							);

		PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;"; 
	}
	//echo $page_neurons_views_query;
	$table_string='';
	if(isset($write_file)) {
		$file_name = "neurons_";
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		
		return format_table_neurons($conn, $page_neurons_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request);
	}else{
		$table_string = '';
		$table_string .= format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_neuron_types_views_report($conn, $neuron_ids=NULL, $views_request=NULL, $write_file=NULL){ //Passed on Nov 12 2024
	$columns = ['Subregion', 'Neuron Type Name', 'Census','Views'];
	$page_neurons_views_query = " SELECT 
		COALESCE(Subregion, 'N/A') AS Subregion, 
		Neuron_Type_Name, 
		IFNULL(Neuron_Page_Views, 0) AS Neuron_Page_Views, 
		IFNULL(Evidence_Page_Views, 0) AS Evidence_Page_Views, 
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) AS Post_2017_Views, 
		ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0))) AS Estimated_Pre_2017_Views, 
		IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0) + ROUND(".DELTA_VIEWS." * (IFNULL(Neuron_Page_Views, 0) + IFNULL(Evidence_Page_Views, 0))) AS Total_Views
			FROM (
					SELECT 
					COALESCE(t.subregion, 'N/A') AS Subregion, 
					COALESCE(t.page_statistics_name, 'None of the Above') AS Neuron_Type_Name, 
					SUM(
						CASE 
						WHEN nd.page LIKE '%neuron_page.php?id=%' THEN 
						CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Neuron_Page_Views, 
					SUM(
						CASE 
						WHEN nd.page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' THEN 
						CASE 
						WHEN REPLACE(nd.page_views, ',', '') > 0 THEN REPLACE(nd.page_views, ',', '') 
						ELSE REPLACE(nd.sessions, ',', '') 
						END 
						ELSE 0 
						END
					   ) AS Evidence_Page_Views, 
					COALESCE(t.position, 9999) AS position 
						FROM (
								SELECT 
								CASE 
								WHEN page LIKE '%neuron_page.php?id=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1)
								WHEN page REGEXP 'id_neuron=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
								WHEN page REGEXP 'id1_neuron=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
								WHEN page REGEXP 'id_neuron_source=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
								WHEN page REGEXP 'pre_id=[0-9]+' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1)
								ELSE NULL 
								END AS neuronID, page, day_index, page_views, sessions 
								FROM GA_combined_analytics 
								WHERE page LIKE '%neuron_page.php?id=%' 
								OR page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
						     ) AS nd 
						LEFT JOIN Type t ON nd.neuronID = t.id 
						GROUP BY t.subregion, t.page_statistics_name, t.position

						UNION ALL

						SELECT 
						'N/A' AS Subregion, 
					'None of the Above' AS Neuron_Type_Name, 
					SUM(
							CASE 
							WHEN page LIKE '%neuron_page.php?id=%' THEN 
							CASE 
							WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Neuron_Page_Views, 
					SUM(
							CASE 
							WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' THEN 
							CASE 
							WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
							ELSE REPLACE(sessions, ',', '') 
							END 
							ELSE 0 
							END
					   ) AS Evidence_Page_Views, 
					9999 AS position
						FROM (
								SELECT 
								page, 
								page_views, 
								sessions 
								FROM GA_combined_analytics 
								WHERE page LIKE '%neuron_page.php?id=%' 
								AND (
									SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (SELECT id FROM Type)
									OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1) NOT IN (SELECT id FROM Type)
								    )
						     ) AS unmatched_data 
						) AS full_results 
						GROUP BY Subregion, Neuron_Type_Name, position 
						ORDER BY position ASC, Subregion, Neuron_Type_Name;";
	if (($views_request == "views_per_month") || ($views_request == "views_per_year")) {
		$page_neurons_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_neurons_views_query .= "
				SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
							)
						ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', '
					    ) 
				INTO @sql 
				FROM (SELECT DISTINCT day_index FROM GA_combined_analytics) months;";
		}    

		if ($views_request == "views_per_year") {
			$page_neurons_views_query .= "
				SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), '`'
							)
						ORDER BY YEAR(day_index) SEPARATOR ', '
					    ) 
				INTO @sql 
				FROM (SELECT DISTINCT day_index FROM GA_combined_analytics) years; ";
		}
		$page_neurons_views_query .= "SET @sql = CONCAT(
				'SELECT Subregion,
				Neuron_Type_Name, ',
				@sql, ', 
				SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END) AS Post_2017_Views,
				ROUND(".DELTA_VIEWS." * SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END)) AS Pre_Estimated_2017_Views,
				SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END) +
				ROUND(".DELTA_VIEWS." * SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END)) AS Total_Views
				FROM (
					SELECT
					COALESCE(t.subregion, ''N/A'') AS Subregion,
					COALESCE(t.page_statistics_name, ''None of the Above'') AS Neuron_Type_Name,
					t.position,
					nd.day_index,
					nd.page_views,
					nd.sessions
					FROM (
						SELECT
						CASE
						WHEN page LIKE ''%neuron_page.php?id=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id='', -1), ''&'', 1)
						WHEN page REGEXP ''id_neuron=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
						WHEN page REGEXP ''id1_neuron=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
						WHEN page REGEXP ''id_neuron_source=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
						WHEN page REGEXP ''pre_id=[0-9]+'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''pre_id='', -1), ''&'', 1)
						ELSE NULL
						END AS neuronID,
						page,
						day_index,
						page_views,
						sessions
						FROM GA_combined_analytics
						WHERE page LIKE ''%neuron_page.php?id=%''
						OR page REGEXP ''id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+''
					     ) AS nd
					LEFT JOIN Type t ON nd.neuronID = t.id
					UNION ALL
					SELECT ''N/A'' AS Subregion,
					       ''None of the Above'' AS Neuron_Type_Name,
					       9999 AS position,
					       unmatched_data.day_index,
					       unmatched_data.page_views,
					       unmatched_data.sessions
						       FROM (
								       SELECT page, day_index, page_views, sessions
								       FROM GA_combined_analytics
								       WHERE page LIKE ''%neuron_page.php?id=%''
								       AND NOT EXISTS (
									       SELECT 1
									       FROM Type t
									       WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id='', -1), ''&'', 1) = t.id
									       )
							    ) AS unmatched_data
						       ) AS full_results
						       GROUP BY Subregion, Neuron_Type_Name
						       HAVING Subregion IS NOT NULL
						       ORDER BY (Subregion = ''N/A'') ASC, position ASC, Subregion, Neuron_Type_Name'
						       );
		PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}
	//echo $page_neurons_views_query;//exit;
	$table_string='';
	//$table_string = get_table_skeleton_first($columns);
	if(isset($write_file)) {
		$file_name = "neuron_types_";
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		
		return format_table_neurons($conn, $page_neurons_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request);
	}else{
		$table_string = '';
		$table_string .= format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neuron_types_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_morphology_property_views_report($conn, $neuron_ids = NULL, $views_request=NULL, $write_file=NULL){
	$page_property_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, derived.evidence AS evidence, CONCAT(derived.color, TRIM(derived.sp_page)) AS color_sp, 
		SUM( CASE WHEN REPLACE(derived.page_views, ',', '') > 0 THEN REPLACE(derived.page_views, ',', '') ELSE REPLACE(derived.sessions, ',', '') END ) AS views FROM (
				SELECT IF(INSTR(page, 'id_neuron=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1), IF(INSTR(page, 'id1_neuron=') > 0, 
						SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1), 
						IF(INSTR(page, 'id_neuron_source=') > 0, 
							SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), 
							''))) AS neuronID,
				IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '') AS evidence,
				IF(INSTR(page, 'color=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), '') AS color,
				IF(INSTR(page, 'sp_page=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'sp_page=', -1), '&', 1), '') AS sp_page,
				page_views, sessions
				FROM GA_combined_analytics 
				WHERE 
				page LIKE '%/property_page_%' 
				AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology' ) 
				AND (
					INSTR(page, 'id_neuron=') > 0 OR INSTR(page, 'id1_neuron=') > 0 OR INSTR(page, 'id_neuron_source=') > 0
				    ) ) AS derived
		LEFT JOIN Type AS t ON t.id = derived.neuronID 
		GROUP BY t.page_statistics_name, t.subregion, color_sp, derived.evidence ORDER BY t.position;";
	$page_property_views_query = "SELECT 
    t.subregion, 
    t.page_statistics_name AS neuron_name, 
    derived.evidence AS evidence, 
    CONCAT(derived.color, TRIM(derived.sp_page)) AS color_sp, 
    SUM(
        CASE 
            WHEN REPLACE(derived.page_views, ',', '') > 0 
            THEN REPLACE(derived.page_views, ',', '') 
            ELSE REPLACE(derived.sessions, ',', '') 
        END
    ) AS Post_2017_Views,
    ROUND(".DELTA_VIEWS." * SUM(
        CASE 
            WHEN REPLACE(derived.page_views, ',', '') > 0 
            THEN REPLACE(derived.page_views, ',', '') 
            ELSE REPLACE(derived.sessions, ',', '') 
        END
    )) AS Estimated_Pre_2017_Views,
    SUM(
        CASE 
            WHEN REPLACE(derived.page_views, ',', '') > 0 
            THEN REPLACE(derived.page_views, ',', '') 
            ELSE REPLACE(derived.sessions, ',', '') 
        END
    ) + ROUND(".DELTA_VIEWS." * SUM(
        CASE 
            WHEN REPLACE(derived.page_views, ',', '') > 0 
            THEN REPLACE(derived.page_views, ',', '') 
            ELSE REPLACE(derived.sessions, ',', '') 
        END
    )) AS Total_Views
FROM 
    (
        SELECT 
            IF(INSTR(page, 'id_neuron=') > 0, 
                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1), 
                IF(INSTR(page, 'id1_neuron=') > 0, 
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1), 
                    IF(INSTR(page, 'id_neuron_source=') > 0, 
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1), 
                        ''
                    )
                )
            ) AS neuronID, 
            IF(INSTR(page, 'val_property=') > 0, 
                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), 
                ''
            ) AS evidence, 
            IF(INSTR(page, 'color=') > 0, 
                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1), 
                ''
            ) AS color, 
            IF(INSTR(page, 'sp_page=') > 0, 
                SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'sp_page=', -1), '&', 1), 
                ''
            ) AS sp_page, 
            page_views, 
            sessions
        FROM 
            GA_combined_analytics
        WHERE 
            page LIKE '%/property_page_%' 
            AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology') 
            AND (
                INSTR(page, 'id_neuron=') > 0 
                OR INSTR(page, 'id1_neuron=') > 0 
                OR INSTR(page, 'id_neuron_source=') > 0
            )
    ) AS derived 
    LEFT JOIN Type AS t ON t.id = derived.neuronID GROUP BY t.page_statistics_name, t.subregion, color_sp, derived.evidence ORDER BY t.position;";
	//echo $page_property_views_query;
	if ($views_request == "views_per_month" || $views_request == "views_per_year") {
		$page_property_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";
		$base_query = "SELECT GROUP_CONCAT(DISTINCT CONCAT(
						'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index), 
							' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
							ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
						@time_unit, '`'
					      ) ORDER BY YEAR(day_index) SEPARATOR ', '
				    ) INTO @sql
			FROM GA_combined_analytics WHERE
			page LIKE '%/property_page_%'
			AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'morphology');";

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
					'SELECT ',
					't.subregion AS Subregion, ',
					't.page_statistics_name AS Neuron_Name, ',
					'derived.evidence AS Evidence, ',
					'CONCAT(derived.color, TRIM(derived.sp_page)) AS Color_SP, ',
					@sql, ', ',
					'SUM(CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') ELSE REPLACE(sessions, \'\', \'\') END) AS Total_Views ',
					'FROM (',
						'   SELECT ',
						'       IF(INSTR(page, ''id_neuron='') > 0, ',
							'           SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1), ',
							'           IF(INSTR(page, ''id1_neuron='') > 0, ',
								'               SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1), ',
								'               IF(INSTR(page, ''id_neuron_source='') > 0, ',
									'                   SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1), ',
									'                   '''' ',
									'               ) ',
								'           ) ',
							'       ) AS neuronID, ',
						'       IF(INSTR(page, ''val_property='') > 0, ',
							'           SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''val_property='', -1), ''&'', 1), ',
							'           '''' ',
							'       ) AS evidence, ',
						'       IF(INSTR(page, ''color='') > 0, ',
							'           SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''color='', -1), ''&'', 1), ',
							'           '''' ',
							'       ) AS color, ',
						'       IF(INSTR(page, ''sp_page='') > 0, ',
							'           SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''sp_page='', -1), ''&'', 1), ',
							'           '''' ',
							'       ) AS sp_page, ',
						'       page_views, ',
						'       sessions, ',
						'       day_index ',
						'   FROM GA_combined_analytics ',
						'   WHERE ',
						'       page LIKE ''%/property_page_%'' ',
						'       AND (',
								'           SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''morphology'' ',
								'       ) ',
						') AS derived ',
						'LEFT JOIN Type AS t ON t.id = derived.neuronID ',
						'GROUP BY t.subregion, t.page_statistics_name, derived.evidence, Color_SP ',
						'ORDER BY t.position'
							);";
		$page_property_views_query .= "PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}

        $columns = ['Subregion', 'Neuron Type Name', 'Neuronal Attribute', 'DG:SMo', 'DG:SMi','DG:SG','DG:H','CA3:SLM','CA3:SR','CA3:SL','CA3:SP','CA3:SO','CA2:SLM','CA2:SR','CA2:SP','CA2:SO','CA1:SLM','CA1:SR','CA1:SP','CA1:SO','Sub:SM','Sub:SP','Sub:PL','EC:I','EC:II','EC:III','EC:IV','EC:V','EC:VI','Other','Post_2017_Views', 'Estimated_Pre_2017_Views', 'Total_Views'];
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
			//echo $page_property_views_query;
		$table_string .= get_table_skeleton_first($columns);
		$table_string .= format_table_morphology($conn, $page_property_views_query, $table_string, 'morphology_property', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
        }       
} 

function get_markers_property_views_report($conn, $neuron_ids, $views_request=NULL, $write_file = NULL){
	$page_property_views_query = "SELECT page,
		COALESCE(t.subregion, 'N/A') AS subregion, 
		COALESCE(t.page_statistics_name, 'None of the Above') AS neuron_name, 
		COALESCE(NULLIF(derived.color, ''), 'None of the Above') AS color, 
		COALESCE(NULLIF(derived.evidence, ''), 'None of the Above') AS evidence, 
		SUM(
				CASE 
				WHEN REPLACE(derived.page_views, ',', '') > 0 
				THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
				ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
				END
		   ) AS Post_2017_Views, 
		ROUND( ".DELTA_VIEWS."  * SUM(
					CASE 
					WHEN REPLACE(derived.page_views, ',', '') > 0 
					THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
					ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
					END
					)
		     ) AS Estimated_Pre_2017_Views, 
		SUM(
				CASE 
				WHEN REPLACE(derived.page_views, ',', '') > 0 
				THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
				ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
				END
		   ) + ROUND(".DELTA_VIEWS." * SUM(
				   CASE 
				   WHEN REPLACE(derived.page_views, ',', '') > 0 
				   THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
				   ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
				   END
				   )
			   ) AS Total_Views
		   FROM (
				   SELECT 
				   page,
				   CASE 
				   WHEN INSTR(page, 'id_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) 
				   WHEN INSTR(page, 'id1_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) 
				   WHEN INSTR(page, 'id_neuron_source=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) 
				   ELSE NULL 
				   END AS neuronID, 
				   CASE 
				   WHEN INSTR(page, 'val_property=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1) 
				   ELSE NULL 
				   END AS evidence, 
				   CASE 
				   WHEN INSTR(page, 'color=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1) 
				   ELSE NULL 
				   END AS color, 
				   page_views, 
				   sessions 
				   FROM GA_combined_analytics 
				   WHERE page LIKE '%/property_page_%' 
				   AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'markers' 
				   AND (
						   INSTR(page, 'id_neuron=') > 0 
						   OR INSTR(page, 'id1_neuron=') > 0 
						   OR INSTR(page, 'id_neuron_source=') > 0
				       )
				   ) AS derived 
				   LEFT JOIN Type AS t 
				   ON t.id = derived.neuronID 
				   GROUP BY 
				   page,
		COALESCE(t.subregion, 'N/A'), 
		COALESCE(t.page_statistics_name, 'None of the Above'), 
		COALESCE(NULLIF(derived.evidence, ''), 'None of the Above'), 
		COALESCE(NULLIF(derived.color, ''), 'None of the Above') 
			ORDER BY t.position;";
	//echo $page_property_views_query;
	if ($views_request == "views_per_month" || $views_request == "views_per_year") {
		$page_property_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";
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
			FROM GA_combined_analytics 
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
					t.subregion AS Subregion,
					t.page_statistics_name AS Neuron_Type_Name,
					derived.color AS Expression,
					derived.evidence AS Marker_Evidence, ',
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
						FROM GA_combined_analytics 
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
			"vGluT2", "VILIP", "Wfs1", "Y1", "Y2", "DCX", "NeuN", "NeuroD", "CRH", "NK1R", "Other", "Post_2017_Views","Estimated_Pre_2017_Views","Total_Views"];
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

function get_counts_views_report($conn, $page_string=NULL, $neuron_ids=NULL, $views_request=NULL, $write_file=NULL){

	// Initialize the table string and columns array outside the conditional logic
	$table_string = '';
	$columns = [];

	// Check for 'phases' or 'counts' page types
	if ($page_string == 'counts') {
		$columns = ['Subregion', 'Neuron Type Name', 'Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, SUM(REPLACE(page_views, ',', '')) AS views 
				FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views 
					FROM GA_combined_analytics WHERE page LIKE '%property_page_{$pageType}.php?id_neuron=%' 
					AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4 
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)) 
					AS derived JOIN Type AS t ON t.id = derived.neuronID
					 WHERE derived.neuronID NOT IN ('4168', '4181', '2232') 
					GROUP BY t.page_statistics_name ORDER BY t.position";
        //echo $page_neurons_views_query;

	}

	// Check for 'phases' page types
	if ($page_string == 'phases') {
		
		$columns = ['Subregion', 'Neuron Type Name', 'Theta (deg)', 'SWR Ratio','In Vivo Firing Rate (Hz)', 'DS Ratio', 'Ripple (deg)','Gamma (deg)', 'Run/Stop Ratio',
				'Epsilon','Non-Baseline Firing Rate (Hz)', 
				'Vrest (mV)', 'Tau (ms)','APthresh (mV)','fAHP (mV)','APpeak-trough (ms)','Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.', 'Other', 'Post_2017_Views', 'Estimated_Pre_2017_Views', 'Total_Views'];
		$pageType = $page_string == 'phases' ? 'phases' : 'counts';
		$page_counts_views_query = "SELECT 
			COALESCE(t.subregion, 'N/A') AS Subregion,
			COALESCE(t.page_statistics_name, 'None of the Above') AS Neuron_Type_Name,
			COALESCE(NULLIF(derived.evidence, ''), 'None of the Above') AS Evidence,
			SUM(
					CASE 
					WHEN REPLACE(derived.page_views, ',', '') > 0 
					THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
					ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
					END
			   ) AS Post_2017_Views,
			ROUND(
					".DELTA_VIEWS." * SUM(
						CASE 
						WHEN REPLACE(derived.page_views, ',', '') > 0 
						THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
						ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
						END
						)
			     ) AS Estimated_Pre_2017_Views,
			SUM(
					CASE 
					WHEN REPLACE(derived.page_views, ',', '') > 0 
					THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
					ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
					END
			   ) + ROUND(
				   ".DELTA_VIEWS." * SUM(
					   CASE 
					   WHEN REPLACE(derived.page_views, ',', '') > 0 
					   THEN CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED) 
					   ELSE CAST(REPLACE(derived.sessions, ',', '') AS UNSIGNED) 
					   END
					   )
				   ) AS Total_Views
			   FROM (
					   SELECT 
					   page,
					   CASE 
					   WHEN INSTR(page, 'id_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) 
					   WHEN INSTR(page, 'id1_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) 
					   WHEN INSTR(page, 'id_neuron_source=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) 
					   WHEN INSTR(page, 'pre_id=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'pre_id=', -1), '&', 1) 
					   ELSE NULL 
					   END AS neuronID,
					   CASE 
					   WHEN INSTR(page, 'val_property=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1) 
					   ELSE NULL 
					   END AS evidence, page_views, sessions
					   FROM GA_combined_analytics
					   WHERE 
					   page LIKE '%/property_page_%' 
					   AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases'
					   AND (
						   page REGEXP 'id_neuron=[0-9]+' 
						   OR page REGEXP 'id1_neuron=[0-9]+' 
						   OR page REGEXP 'id_neuron_source=[0-9]+'
						   OR page REGEXP 'pre_id=[0-9]+'
					       )
					   ) AS derived
					   LEFT JOIN Type AS t ON t.id = derived.neuronID
					   GROUP BY derived.page,
			COALESCE(t.subregion, 'N/A'), COALESCE(t.page_statistics_name, 'None of the Above'),
			COALESCE(NULLIF(derived.evidence, ''), 'None of the Above') ORDER BY CASE WHEN t.subregion = 'N/A' THEN 2 ELSE 1 END, t.position;";
			//echo $page_counts_views_query;
		if ($views_request == "views_per_month" || $views_request == "views_per_year") {
			$page_counts_views_query= "SET SESSION group_concat_max_len = 1000000;
			SET @sql = NULL;";
			$base_query = "
				SELECT
				GROUP_CONCAT(
						DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN REPLACE(page_views, \",\", \"\") ELSE 0 END) AS `',
							@time_unit, '`'
						      )
						ORDER BY YEAR(day_index) 
						SEPARATOR ', '
					    ) INTO @sql
				FROM GA_combined_analytics 
				WHERE
				page LIKE '%/property_page_%'
				AND (
						SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases'
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
			$page_counts_views_query .= str_replace(
					['@time_unit', '@ordering'],
					[$time_unit, $ordering],
					$base_query
					);

			// Build the main query
			$page_counts_views_query .= "
				SET @sql = CONCAT(
						'SELECT ',
						't.subregion AS Subregion, ',
						't.page_statistics_name AS Neuron_Type_Name, ',
						'CASE ',
						'    WHEN derived.evidence = \'theta\' THEN \'Theta (deg)\' ',
						'    WHEN derived.evidence = \'swr_ratio\' THEN \'SWR Ratio\' ',
						'    WHEN derived.evidence = \'firingRate\' THEN \'In Vivo Firing Rate (Hz)\' ',
						'    WHEN derived.evidence = \'gamma\' THEN \'Gamma (deg)\' ',
						'    WHEN derived.evidence = \'DS_ratio\' THEN \'DS Ratio\' ',
						'    WHEN derived.evidence = \'Vrest\' THEN \'Vrest (mV)\' ',
						'    WHEN derived.evidence = \'epsilon\' THEN \'Epsilon\' ',
						'    WHEN derived.evidence = \'firingRateNonBaseline\' THEN \'Non-Baseline Firing Rate (Hz)\' ',
						'    WHEN derived.evidence = \'APthresh\' THEN \'APthresh (mV)\' ',
						'    WHEN derived.evidence = \'tau\' THEN \'Tau (ms)\' ',
						'    WHEN derived.evidence = \'run_stop_ratio\' THEN \'Run/Stop Ratio\' ',
						'    WHEN derived.evidence = \'ripple\' THEN \'Ripple (deg)\' ',
						'    WHEN derived.evidence = \'fahp\' THEN \'fAHP (mV)\' ',
						'    WHEN derived.evidence = \'APpeal\' THEN \'APpeak-trough (ms)\' ',
						'    WHEN derived.evidence = \'all_other\' THEN \'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.\' ',
						'    ELSE \'Other\' ',
						'END AS Evidence_Description, ',
						@sql, 
							', SUM(REPLACE(derived.page_views, \',\', \'\')) AS Total_Views ',
						'FROM (',
								'    SELECT page_views, ',
								'        IF(INSTR(page, \'id_neuron=\') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1), ',
									'           IF(INSTR(page, \'id1_neuron=\') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1), ',
										'           IF(INSTR(page, \'id_neuron_source=\') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1), \'\' ',
											'           ))) AS neuronID, ',
								'        IF(INSTR(page, \'val_property=\') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'val_property=\', -1), \'&\', 1), \'\') AS evidence, ',
								'        day_index ',
								'    FROM GA_combined_analytics ',
								'    WHERE page LIKE \'%/property_page_%\' ',
								'      AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'/property_page_\', -1), \'.\', 1) = \'phases\' ',
								'      AND (LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1)) = 4 ',
									'           OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1)) = 4 ',
									'           OR LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1)) = 4) ',
								'      AND (SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\') ',
									'           OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id1_neuron=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\') ',
									'           OR SUBSTRING_INDEX(SUBSTRING_INDEX(page, \'id_neuron_source=\', -1), \'&\', 1) NOT IN (\'4168\', \'4181\', \'2232\')) ',
								') AS derived ',
						'LEFT JOIN Type AS t ON t.id = derived.neuronID ',
						'WHERE derived.neuronID NOT IN (\'4168\', \'4181\', \'2232\') ',
						'GROUP BY t.subregion, t.page_statistics_name, Evidence_Description ',
						'ORDER BY t.position' 
						); ";
			$page_counts_views_query .= "PREPARE stmt FROM @sql;
							EXECUTE stmt;
							DEALLOCATE PREPARE stmt;";

		}
		//echo  $page_counts_views_query;
	}

	// Check for 'connectivity' page types
        if ($page_string == 'connectivity') {
                     
                $columns = ['Presynaptic Subregion', 'Presynaptic Neuron Type Name', 'Postsynaptic Subregion', 'Postsynaptic Neuron Type Name', 'Potential Connectivity Evidence', 'Number of Potential Synapses Parcel-Specific Table', 'Number of Potential Synapses Evidence', 'Number of Contacts Parcel-Specific Table', 'Number of Contacts Evidence', 'Synaptic Probability Parcel-Specific Table', 'Synaptic Probability Evidence', 'Other', 'Post_2017_Views', 'Estimated_Pre_2017_Views', 'Total Views'];
                $pageType = $page_string = 'connectivity';
		$page_counts_views_query = "SELECT derived.page, derived.source_neuronID, derived.target_neuronID,
			COALESCE(t_source.subregion, 'N/A') AS source_subregion,
			COALESCE(t_source.page_statistics_name, 'None of the Above') AS source_neuron_name, 
			derived.source_evidence, derived.source_color, 
			COALESCE(t_target.subregion, 'N/A') AS target_subregion,
			COALESCE(t_target.page_statistics_name, 'None of the Above') AS target_neuron_name, 
			derived.target_evidence, derived.target_color, derived.parcel_specific,
			COALESCE(derived.nm_page, 'N/A') AS nm_page,
			SUM(CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED)) AS Post_2017_Views,
			ROUND(".DELTA_VIEWS." * SUM(CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED))) AS Estimated_Pre_2017_Views,
			SUM(CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED)) + ROUND(".DELTA_VIEWS." * SUM(CAST(REPLACE(derived.page_views, ',', '') AS UNSIGNED))) AS Total_Views
				FROM (
						SELECT 
						page, 
						CASE 
						WHEN REPLACE(page_views, ',', '') > 0 THEN page_views 
						ELSE sessions 
						END AS page_views, 
						CASE 
						WHEN INSTR(page, 'id1_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) 
						WHEN INSTR(page, 'id_neuron_source=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) 
						ELSE NULL 
						END AS source_neuronID, 
						CASE 
						WHEN INSTR(page, 'val1_property=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val1_property=', -1), '&', 1) 
						ELSE NULL 
						END AS source_evidence, 
						CASE 
						WHEN INSTR(page, 'color=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1) 
						WHEN INSTR(page, 'color1=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color1=', -1), '&', 1) 
						ELSE NULL 
						END AS source_color, 
						CASE 
							WHEN INSTR(page, 'id2_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id2_neuron=', -1), '&', 1) 
							WHEN INSTR(page, 'id_neuron_target=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_target=', -1), '&', 1) 
							ELSE NULL 
							END AS target_neuronID, 
						CASE 
							WHEN INSTR(page, 'val2_property=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val2_property=', -1), '&', 1) 
							ELSE NULL 
							END AS target_evidence, 
						CASE 
							WHEN INSTR(page, 'color2=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color2=', -1), '&', 1) 
							ELSE NULL 
							END AS target_color,
						SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) AS parcel_specific,
						CASE 
							WHEN INSTR(page, 'nm_page=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'nm_page=', -1), '&', 1) 
							ELSE NULL 
							END AS nm_page 
							FROM GA_combined_analytics 
							WHERE 
							page REGEXP 'property_page_synpro|synapse_probabilities|property_page_connectivity'
							AND (page REGEXP 'id1_neuron=[0-9]+|id_neuron_source=[0-9]+|id_neuron=[0-9]+')
							) AS derived 
							LEFT JOIN Type AS t_source ON t_source.id = derived.source_neuronID 
							LEFT JOIN Type AS t_target ON t_target.id = derived.target_neuronID 
							GROUP BY 
							derived.page, 
						derived.source_neuronID, 
						derived.target_neuronID, 
						t_source.page_statistics_name, 
						t_source.subregion, 
						derived.source_color, 
						derived.source_evidence, 
						t_target.page_statistics_name, 
						t_target.subregion, 
						derived.target_color, 
						derived.target_evidence, 
						derived.parcel_specific, 
						derived.nm_page 
							ORDER BY 
							CASE 
							WHEN t_source.subregion = 'N/A' OR t_target.subregion = 'N/A' THEN 1 
							ELSE 0 
							END, 
						t_source.position, 
						t_source.page_statistics_name, 
						t_target.page_statistics_name;";
		//echo $page_counts_views_query;
        }

	// Check for 'biophysics' page types
        if ($page_string == 'biophysics') {
                $pageType = $page_string = 'biophysics';
                $columns = ['Subregion', 'Neuron Type Name', 'Vrest (mV)', 'Rin (MW)', 'tm (ms)', 'Vthresh(mV)','Fast AHP (mV)','APampl (mV)','APwidth (ms)','Max F.R. (Hz)','Slow AHP (mV)','Sag Ratio','Other','Post_2017_Views', 'Estimated_Pre_2017_Views', 'Total_Views'];	
		$page_counts_views_query = "SELECT t.subregion, t.page_statistics_name AS neuron_name, derived.evidence AS evidence, 
			SUM(REPLACE(derived.page_views, ',', '')) AS Post_2017_Views, 
			ROUND(".DELTA_VIEWS." * SUM(REPLACE(derived.page_views, ',', ''))) AS Estimated_Pre_2017_Views, 
			SUM(REPLACE(derived.page_views, ',', '')) + ROUND(".DELTA_VIEWS." * SUM(REPLACE(derived.page_views, ',', ''))) AS 
				Total_Views 
				FROM ( SELECT CASE WHEN INSTR(page, 'id_neuron=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) ELSE NULL END AS neuronID, 
						CASE WHEN INSTR(page, 'ep=') > 0 THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'ep=', -1), '&', 1) ELSE '' END AS evidence, 
						CASE WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') ELSE sessions END AS page_views 
						FROM GA_combined_analytics WHERE page REGEXP 'property_page_ephys\.php' AND page REGEXP 'id_neuron=[0-9]+' ) AS 
				derived JOIN Type AS t ON t.id = derived.neuronID 
				GROUP BY t.subregion, t.page_statistics_name, derived.evidence ORDER BY t.position;
		";
		//echo $page_counts_views_query;
		if ($views_request == "views_per_month" || $views_request == "views_per_year") {

			$page_counts_views_query = "
				SET SESSION group_concat_max_len = 1000000;

			SET @sql = NULL;";

			if ($views_request == "views_per_month") {
				$page_counts_views_query .= "
					SELECT 
					GROUP_CONCAT(
							DISTINCT CONCAT(
								'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
									' AND MONTH(day_index) = ', MONTH(day_index),
									' THEN REPLACE(page_views, \'\', \'\') ELSE 0 END) AS `',
								YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
								)
							ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', '
						    ) 
					INTO @sql 
					FROM GA_combined_analytics
					WHERE 
					page REGEXP 'property_page_ephys\\.php'
					AND page REGEXP 'id_neuron=[0-9]+';
				";
			} elseif ($views_request == "views_per_year") {
				$page_counts_views_query .= "
					SELECT 
					GROUP_CONCAT(
							DISTINCT CONCAT(
								'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
									' THEN REPLACE(page_views, \'\', \'\') ELSE 0 END) AS `',
								YEAR(day_index), '`'
								)
							ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', '
						    ) 
					INTO @sql 
					FROM GA_combined_analytics
					WHERE 
					page REGEXP 'property_page_ephys\\.php'
					AND page REGEXP 'id_neuron=[0-9]+';
				";
			}

			$page_counts_views_query .= "
				SET @sql = CONCAT(
						'SELECT ',
						't.subregion AS Subregion, ',
						't.page_statistics_name AS Neuron_Name, ',
						'derived.evidence AS Evidence, ',
						@sql, ', ',
						'SUM(REPLACE(derived.page_views, \'\', \'\')) AS Total_Views ',
						'FROM (',
							'   SELECT ',
							'       CASE ',
							'           WHEN INSTR(page, ''id_neuron='') > 0 ',
							'               THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1) ',
							'           ELSE NULL ',
							'       END AS neuronID, ',
							'       CASE ',
							'           WHEN INSTR(page, ''ep='') > 0 ',
							'               THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''ep='', -1), ''&'', 1) ',
							'           ELSE ''No Evidence'' ',
							'       END AS evidence, ',
							'       CASE ',
							'           WHEN REPLACE(page_views, \'\', \'\') > 0 ',
							'               THEN REPLACE(page_views, \'\', \'\') ',
							'           ELSE REPLACE(sessions, \'\', \'\') ',
							'       END AS page_views, ',
							'       day_index ',
							'   FROM GA_combined_analytics ',
							'   WHERE page REGEXP ''property_page_ephys\\.php'' ',
							'     AND page REGEXP ''id_neuron=[0-9]+'' ',
							') AS derived ',
							'JOIN Type AS t ON t.id = derived.neuronID ',
							'GROUP BY t.subregion, t.page_statistics_name, derived.evidence ',
							'ORDER BY t.position'
								);


			PREPARE stmt FROM @sql;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;";

                }
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
                                                        FROM GA_combined_analytics 
                                                        WHERE  page LIKE '%$pageType?id_neuron=%'
                                                AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) = 4
                                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)

                                                UNION ALL

                                                SELECT page, page_views,
                                                       SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id1_neuron=', -1), '&', 1) AS neuronID
                                                               FROM GA_combined_analytics 
                                                               WHERE page LIKE '%$pageType?id1_neuron=%'
                                                               AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) = 4
                                                               AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                                               
                                                UNION ALL

                                                SELECT page, page_views,
                                                       SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron_source=', -1), '&', 1) AS neuronID
                                                               FROM GA_combined_analytics 
                                                               WHERE page LIKE '%$pageType?id_neuron_source=%'
                                                               AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) = 4
                                                               AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                                               
                                               )   AS derived JOIN Type AS t ON t.id = derived.neuronID
					        WHERE   derived.neuronID NOT IN ('4168', '4181', '2232')
                                                 GROUP BY  derived.page ORDER BY t.position DESC";
	}

	// Initialize table with columns and execute the query if columns array is not empty
	$table_string = get_table_skeleton_first($columns);
	$csv_tablename = $page_string."_table";
	if ($page_string == 'synpro' || $page_string == 'synpro_nm' || $page_string == 'synpro_pvals') {
		if(isset($write_file)) {
			return format_table_synpro($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns, $neuron_ids = NULL, $write_file);
		}else{
			$table_string = format_table_synpro($conn, $page_counts_views_query, $table_string, $csv_tablename, $columns, $neuron_ids);
			//echo $page_counts_views_query;
			$table_string .= get_table_skeleton_end();
			echo $table_string;
		}
	}
	if($page_string == 'biophysics'){
		if(isset($write_file)) {
                	$file_name = "membrane_biophysics_evidence_page_";
                	if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                        	$file_name .= $views_request;
				//echo $page_counts_views_query;
                        	return format_table_neurons($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request); //Using this universally as this is gonna
			}else{
                        	$file_name .= "views";
				//return format_table_biophysics($conn, $page_counts_views_query, $table_string, 'membrane_biophysics_evidence_page_views', $columns, $neuron_ids = NULL, $write_file);
				return format_table_biophysics($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids = NULL, $write_file);
			}
        	}else{
			//echo $page_counts_views_query;
			$table_string .= format_table_biophysics($conn, $page_counts_views_query, $table_string, 'membrane_biophysics_evidence_page_views', $columns, $neuron_ids);
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}
	}else if($page_string == 'connectivity'){
                if(isset($write_file)) {
			 $file_name = "connectivity_page_";
                        if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                                $file_name .= $views_request;
                                //echo $page_counts_views_query;
                                return format_table_neurons($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request); //Using this universally as this is gonna
                        }else{
                                $file_name .= "views";
                        	//return format_table_connectivity($conn, $page_counts_views_query, $table_string, 'connectivity_page_views', $columns, $neuron_ids = NULL, $write_file);
                                return format_table_connectivity($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids = NULL, $write_file);
                        }
                }else{
			$array_subs = ["DG"=>[],"CA3"=>[],"CA2"=>[],"CA1"=>[],"Sub"=>[],"EC"=>[]];
                        $table_string .= format_table_connectivity($conn, $page_counts_views_query, $table_string, 'connectivity_page_views', $columns, $neuron_ids, $write_file = NULL, $array_subs);
                        $table_string .= get_table_skeleton_end();
                        echo $table_string;
                }
        }else{
		 if(isset($write_file)) {
                        $file_name = "in_vivo_evidence_page_";
                        if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                                $file_name .= $views_request;
                                return format_table_neurons($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids=NULL, $write_file, $views_request); //Using this universally as this is gonna                               
                        }else{                  
                                $file_name .= "views";
                                //return format_table_biophysics($conn, $page_counts_views_query, $table_string, 'membrane_biophysics_evidence_page_views', $columns, $neuron_ids = NULL, $write_file);
                                return format_table_phases($conn, $page_counts_views_query, $table_string, $file_name, $columns, $neuron_ids = NULL, $write_file);
				//return format_table_phases($conn, $page_counts_views_query, $table_string, 'in_vivo_evidence_page_views', $columns, $neuron_ids = NULL, $write_file);
                        }                       
                }else{
			$table_string .= format_table_phases($conn, $page_counts_views_query, $table_string, 'in_vivo_evidence_page_views', $columns, $neuron_ids);
			$table_string .= get_table_skeleton_end();
        		echo $table_string;
		}
	}
}

function get_fp_property_views_report($conn, $views_request=NULL, $write_file=NULL){
	$fp_format = [
		'ASP.' => 'Adapting Spiking',
		'ASP.ASP.' => 'Adapting Spiking followed by (slower) Adapting Spiking',
		'ASP.NASP' => 'Non-Adapting Spiking preceded by Adapting Spiking',
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

	$page_fp_property_views_query = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'meter=', -1), '&', 1) AS Firing_Pattern, 
		SUM( CASE WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') ELSE REPLACE(sessions, ',', '') END ) AS Post_2017_Views,
		ROUND(".DELTA_VIEWS." * SUM( CASE WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '')  
					ELSE REPLACE(sessions, ',', '') END )) AS Estimated_Pre_2017_Views, 
		SUM( CASE WHEN REPLACE(page_views, ',', '') > 0 
				THEN REPLACE(page_views, ',', '') ELSE REPLACE(sessions, ',', '') END ) + ROUND(".DELTA_VIEWS." * SUM( CASE 
					WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') ELSE REPLACE(sessions, ',', '') END )) AS 
				Total_Views 
				FROM GA_combined_analytics WHERE page REGEXP 'property_page_fp\.php' AND page REGEXP 'id_neuron=[0-9]+' 
				GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'meter=', -1), '&', 1) ORDER BY Total_Views DESC;";
	//echo $page_fp_property_views_query;
	if ($views_request == "views_per_year" || $views_request == "views_per_month") {
		$page_fp_property_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";
		if ($views_request == "views_per_month") {
			$page_fp_property_views_query .= " 
				SELECT GROUP_CONCAT( DISTINCT CONCAT( 'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index), ' AND MONTH(day_index) = ', 
								MONTH(day_index), 
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 ',
								' THEN REPLACE(page_views, \'\', \'\') ',
								' ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `', 
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`' ) 
						ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', ' ) INTO @sql FROM GA_combined_analytics 
				WHERE page REGEXP 'property_page_fp\.php' AND page REGEXP 'id_neuron=[0-9]+'; ";
		}
		if ($views_request == "views_per_year") {
			$page_fp_property_views_query .= "
				SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 ',
								' THEN REPLACE(page_views, \'\', \'\') ',
								' ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `', 
							YEAR(day_index), '`'
							)
						ORDER BY YEAR(day_index) 
						SEPARATOR ', '
					    ) 
				INTO @sql
				FROM GA_combined_analytics
				WHERE 
				page REGEXP 'property_page_fp\\.php' 
				AND page REGEXP 'id_neuron=[0-9]+'; ";
		}
		$page_fp_property_views_query .= "
			SET @sql = CONCAT(
					'SELECT ',
					'SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''meter='', -1), ''&'', 1) AS Firing_Pattern, ',
					@sql, ', ', 
					' SUM(
						CASE 
						WHEN REPLACE(page_views, \",\",\"\") > 0 
						THEN REPLACE(page_views, \",\", \"\") 
						ELSE REPLACE(sessions, \",\", \"\") 
						END
					     ) AS Total_Views ', 
					'FROM GA_combined_analytics ', 
					' WHERE page REGEXP ''property_page_fp\.php'' AND page REGEXP ''id_neuron=[0-9]+'' ',
					'GROUP BY Firing_Pattern ',
					'ORDER BY Total_Views DESC'
					);
		";
		$page_fp_property_views_query .= " PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt; ";
	}
	//echo $page_fp_property_views_query;
	$columns = ['Firing Pattern', 'Views'];
	$options = ['format' => $fp_format,];
	if(isset($write_file)) {
		//	return format_table_combined($conn, $page_fp_property_views_query, 'firing_pattern_page_views', $columns, $write_file, $options);
		$file_name = "firing_pattern_page_";
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		return format_table_neurons($conn, $page_fp_property_views_query, '', $file_name, $columns, $write_file, $views_request);
	}else{
		$table_string = ''; // get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_fp_property_views_query, 'firing_pattern_page_views', $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}


function get_domain_functionality_views_report($conn, $views_request = NULL, $write_file = NULL){
	$page_functionality_views_query="SELECT 
		CASE 
		WHEN page REGEXP 'property_page_fp|fp\.php' THEN 'Firing Patterns'
		WHEN page REGEXP 'property_page_markers|markers\.php' THEN 'Molecular Markers'
		WHEN page REGEXP 'property_page_morphology|morphology\.php' 
		AND page NOT REGEXP 'property_page_morphology_linking_pmid_isbn' THEN 'Morphology'
		WHEN page REGEXP 'property_page_phases|phases\.php' THEN 'In Vivo Recordings'
		WHEN page REGEXP 'property_page_synpro|property_page_synpro_nm|property_page_synpro_pvals|property_page_synpro_nm_old2|synapse_probabilites\.php' THEN 'Synapse Probabilities'
		WHEN page REGEXP 'property_page_connectivity|property_page_connectivity_orig|property_page_connectivity_test|connectivity\.php' THEN 'Connectivity'
		WHEN page REGEXP 'property_page_ephys|ephys\.php' THEN 'Membrane Biophysics'
		WHEN page REGEXP 'synaptic_mod_sum|params_summary|synaptome|synaptome_modeling\.php' THEN 'Synaptic Physiology'
		WHEN page REGEXP 'property_page_counts|counts\.php' THEN 'Neuron Type Census'
		WHEN page REGEXP 'Izhikevich_model' THEN 'Izhikevich Models'
		WHEN page REGEXP '/cognome/' THEN 'Cognome'
		WHEN page REGEXP 'simulation_parameters' THEN 'Simulation Parameters'
		ELSE 'Other' 
		END AS Property_Page_Category, 
		    SUM(
				    CASE 
				    WHEN day_index IS NOT NULL 
				    AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
				    AND page REGEXP '^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$' 
				    THEN CASE 
				    WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
				    ELSE REPLACE(sessions, ',', '') 
				    END 
				    ELSE 0 
				    END
		       ) AS Main_Matrix_Accesses,
		    SUM(
				    CASE 
				    WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' 
				    THEN CASE 
				    WHEN page NOT REGEXP '^.*\/(property_page_fp|property_page_markers|property_page_morphology|property_page_phases|property_page_synpro|property_page_connectivity|property_page_ephys|synaptic_mod_sum|params_summary|synaptome|synaptome_modeling|property_page_counts|Izhikevich_model|cognome|simulation_parameters).*\.php$'
				    THEN CASE 
				    WHEN REPLACE(page_views, ',', '') > 0 THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED)
				    ELSE CAST(REPLACE(sessions, ',', '') AS UNSIGNED)
				    END
				    ELSE 0
				    END 
				    ELSE 0 
				    END
		       ) AS Evidence_Accesses,
		    SUM(
				    CASE 
				    WHEN day_index IS NOT NULL 
				    AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
				    AND page REGEXP '^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$' 
				    THEN CASE 
				    WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
				    ELSE REPLACE(sessions, ',', '') 
				    END 
				    ELSE 0 
				    END
		       ) + SUM(
			       CASE 
			       WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' 
			       THEN CASE 
			       WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
			       ELSE REPLACE(sessions, ',', '') 
			       END 
			       ELSE 0 
			       END
			      ) AS Post_2017_Views,
		    ROUND(
				    ".DELTA_VIEWS." * (
					    SUM(
						    CASE 
						    WHEN day_index IS NOT NULL 
						    AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
						    AND page REGEXP '^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$' 
						    THEN CASE 
						    WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
						    ELSE REPLACE(sessions, ',', '') 
						    END 
						    ELSE 0 
						    END
					       ) + SUM(
						       CASE 
						       WHEN page REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' 
						       THEN CASE 
						       WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
						       ELSE REPLACE(sessions, ',', '') 
						       END 
						       ELSE 0 
						       END
						      )
					       )
					       ) AS Estimated_Pre_2017_Views,
		    SUM(
				    CASE 
				    WHEN day_index IS NOT NULL 
				    AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
				    AND page REGEXP '^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$'
				    THEN CASE 
				    WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
				    ELSE REPLACE(sessions, ',', '') 
				    END 
				    ELSE 0 
				    END
		       ) + ROUND(
			       ".DELTA_VIEWS." * SUM(
				       CASE 
				       WHEN day_index IS NOT NULL 
				       AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'
				       AND page REGEXP '^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$'
				       THEN CASE 
				       WHEN REPLACE(page_views, ',', '') > 0 THEN REPLACE(page_views, ',', '') 
				       ELSE REPLACE(sessions, ',', '') 
				       END 
				       ELSE 0 
				       END
				       )
			       ) AS Total_Views
		       FROM GA_combined_analytics
		       GROUP BY Property_Page_Category
		       ORDER BY FIELD(
				       Property_Page_Category, 
				       'Morphology', 
				       'Molecular Markers', 
				       'Membrane Biophysics', 
				       'Connectivity', 
				       'Synaptic Physiology', 
				       'Firing Patterns', 
				       'Izhikevich Models', 
				       'Synapse Probabilities', 
				       'In Vivo Recordings', 
				       'Cognome', 
				       'Neuron Type Census', 
				       'Simulation Parameters', 
				       'Other'
				     );";
	//echo $page_functionality_views_query;
	// Check if the request is for monthly or yearly views
	if (($views_request == "views_per_month") || ($views_request == "views_per_year")) {
		$page_functionality_views_query = "SET SESSION group_concat_max_len = 1000000; SET @sql = NULL;";
		if ($views_request == "views_per_month") {
			$page_functionality_views_query .= "SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' AND (
									page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\" 
									OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
								      )
								THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
								ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
							)
						ORDER BY YEAR(day_index), MONTH(day_index) SEPARATOR ', '
					    ) 
				INTO @sql 
				FROM (SELECT DISTINCT day_index FROM GA_combined_analytics) months;";
		}

		if ($views_request == "views_per_year") {
			$page_functionality_views_query .= "SELECT 
				GROUP_CONCAT(
						DISTINCT CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND (
									page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\" 
									OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
								      )
								THEN CASE WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
								ELSE REPLACE(sessions, \'\', \'\') END ELSE 0 END) AS `',
							YEAR(day_index), '`'
							)
						ORDER BY YEAR(day_index) SEPARATOR ', '
					    ) 
				INTO @sql 
				FROM (SELECT DISTINCT day_index FROM GA_combined_analytics) years;";
		}
		$page_functionality_views_query .= "
			SET @sql = CONCAT(
					'SELECT
					CASE
					WHEN page REGEXP \"property_page_fp|fp\\.php\" THEN \"Firing Patterns\"
					WHEN page REGEXP \"property_page_markers|markers\\.php\" THEN \"Molecular Markers\"
					WHEN page REGEXP \"property_page_morphology|morphology\\.php\"
					AND page NOT REGEXP \"property_page_morphology_linking_pmid_isbn\" THEN \"Morphology\" 
					WHEN page REGEXP \"property_page_phases|phases\\.php\" THEN \"In Vivo Recordings\"
					WHEN page REGEXP \"property_page_synpro|property_page_synpro_nm|property_page_synpro_pvals|property_page_synpro_nm_old2|synapse_probabilites\\.php\" THEN \"Synapse Probabilities\"
					WHEN page REGEXP \"property_page_connectivity|property_page_connectivity_orig|property_page_connectivity_test|connectivity\\.php\" THEN \"Connectivity\"
					WHEN page REGEXP \"property_page_ephys|ephys\\.php\" THEN \"Membrane Biophysics\"
					WHEN page REGEXP \"synaptic_mod_sum|params_summary|synaptome|synaptome_modeling\\.php\" THEN \"Synaptic Physiology\"
					WHEN page REGEXP \"property_page_counts|counts\\.php\" THEN \"Neuron Type Census\"
					WHEN page REGEXP \"Izhikevich_model\" THEN \"Izhikevich Models\"
					WHEN page REGEXP \"/cognome/\" THEN \"Cognome\"
					WHEN page REGEXP \"simulation_parameters\" THEN \"Simulation Parameters\"
					ELSE \"Other\"
					END AS `Property Page Category`, ',
					@sql, ',
					SUM(
						CASE
						WHEN (
							page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\"
							OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
						     )
						THEN CASE 
						WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
						ELSE REPLACE(sessions, \'\', \'\') 
						END
						ELSE 0
						END
					   ) AS POST_2017_Views,
					ROUND(" . DELTA_VIEWS . " * SUM(
								CASE
								WHEN (
									page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\"
									OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
								     )
								THEN CASE 
								WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
								ELSE REPLACE(sessions, \'\', \'\') 
								END
								ELSE 0
								END
								)) AS Pre_Estimated_2017_Views,
					SUM(
							CASE
							WHEN (
								page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\"
								OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
							     )
							THEN CASE 
							WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
							ELSE REPLACE(sessions, \'\', \'\') 
							END
							ELSE 0
							END
					   ) + ROUND(" . DELTA_VIEWS . " * SUM(
							   CASE
							   WHEN (
								   page REGEXP \"^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$\"
								   OR page REGEXP \"id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+\"
								)
							   THEN CASE 
							   WHEN REPLACE(page_views, \'\', \'\') > 0 THEN REPLACE(page_views, \'\', \'\') 
							   ELSE REPLACE(sessions, \'\', \'\') 
							   END
							   ELSE 0
							   END
							   )) AS Total_Views
					   FROM GA_combined_analytics
					   GROUP BY `Property Page Category`
					   ORDER BY FIELD(
							   `Property Page Category`,
							   \"Morphology\", \"Molecular Markers\", \"Membrane Biophysics\",
							   \"Connectivity\", \"Synaptic Physiology\", \"Firing Patterns\",
							   \"Izhikevich Models\", \"Synapse Probabilities\",
							   \"In Vivo Recordings\", \"Cognome\", \"Neuron Type Census\",
							   \"Simulation Parameters\", \"Other\"
							 )'
					   );

		PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		";
	}
	//echo $page_functionality_views_query;//exit;
	$columns = ['Property Page Category', 'Main Matrix Accesses', 'Evidence Accesses', 'Post 2017 Views', 'Estimated Pre 2017 Views', 'Total Views'];
        $table_string='';
	$file_name='functionality_property_domain_page_';
        if(isset($write_file)) {
                if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                        $file_name .= $views_request;
                	return format_table($conn, $page_functionality_views_query, $table_string, $file_name, $columns, $neuron_ids=NULL, $write_file, $views_request);
                }else{ $file_name .= 'views';
                	return format_table($conn, $page_functionality_views_query, $table_string, $file_name, $columns, $neuron_ids=NULL, $write_file, $views_request);
 		}
		//return format_table($conn, $page_functionality_views_query, $table_string, 'functionality_property_domain_page_views', $columns, $neuron_ids=NULL, $write_file);
	}else{
		$file_name .= 'views';
		$table_string = format_table($conn, $page_functionality_views_query, $table_string, $file_name, $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

function get_page_functionality_views_report($conn, $views_request=NULL, $write_file=NULL){
	$page_functionality_views_query ="
		SELECT 
		Property_Page_Category, 
		SUM(Views) AS Post_2017_Views, 
		ROUND(".DELTA_VIEWS." * SUM(Views)) AS Estimated_Pre_2017_Views, 
		SUM(Views) + ROUND(".DELTA_VIEWS." * SUM(Views)) AS Total_Views
			FROM (
					SELECT 
					CASE 
					WHEN page LIKE '%/neuron_page.php?id=%' THEN 'Neuron Type Pages'
					WHEN page REGEXP '^.*\\/(property_page_.*\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|synaptic_mod_sum\\.php)\\?.*(id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+)' THEN 'Evidence'
					WHEN page REGEXP '^.*\\/(property_page_.*\\.php|morphology\\.php|markers\\.php|ephys\\.php|connectivity(_test|_orig)?\\.php|synaptome_modeling\\.php|firing_patterns\\.php|Izhikevich_model\\.php|synapse_probabilities\\.php|phases\\.php|cognome\\/.*|synaptome\\.php|property_page_counts\\.php|property_page_morphology\\.php|property_page_ephys\\.php|property_page_markers\\.php|property_page_connectivity\\.php|property_page_fp\\.php|property_page_phases\\.php|simulation_parameters\\.php|synaptome/php/synaptome\\.php)$' 
					AND page NOT REGEXP 'id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+' THEN 'Browse'
					WHEN page REGEXP '(search|find_author|find_neuron_name|find_neuron_term|find_pmid|search_engine_custom)' THEN 'Search'
					WHEN page REGEXP '(tools\\.php|connection_probabilities|synapse_modeler)' THEN 'Tools'
					WHEN page REGEXP '(Help_Quickstart|Help_FAQ|Help_Known_Bug_List|Help_Other_Useful_Links|Help_|help|user_feedback_form_entry)' THEN 'Help'
					WHEN page REGEXP '(bot-traffic|/hipp Better than reCAPTCHA：vaptcha\\.cn|^/$|^/php/$)' AND (page != '/php/' OR day_index IS NOT NULL) THEN 'All Others'
					ELSE 'Home'
					END AS Property_Page_Category,
					page,
					day_index,
					CASE 
					WHEN CAST(REPLACE(COALESCE(page_views, '0'), ',', '') AS UNSIGNED) > 0 
					THEN CAST(REPLACE(page_views, ',', '') AS UNSIGNED) 
					ELSE CAST(REPLACE(COALESCE(sessions, '0'), ',', '') AS UNSIGNED)
					END AS Views
					FROM GA_combined_analytics
					WHERE day_index IS NOT NULL
					) AS PageCategories
					GROUP BY Property_Page_Category
					ORDER BY FIELD(Property_Page_Category, 'Home', 'Browse', 'Search', 'Tools', 'Help', 'Neuron Type Pages', 'Evidence', 'All Others');
	";
	if (($views_request == "views_per_month") || ($views_request == "views_per_year")) {
		$page_functionality_views_query = "SET SESSION group_concat_max_len = 1000000;
		SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_functionality_views_query .= "SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								  ' THEN CASE WHEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
						      )
						ORDER BY YEAR(day_index), MONTH(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM GA_combined_analytics 
				     ) months;";
		}

		if ($views_request == "views_per_year") {
			$page_functionality_views_query .= "SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN CASE WHEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED)  END ELSE 0 END) AS `',
							YEAR(day_index), '`'
						      )
						ORDER BY YEAR(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM GA_combined_analytics 
				     ) years;";
		}

		$page_functionality_views_query .= "
			SET @sql = CONCAT(
					'SELECT CASE 
					WHEN page LIKE ''%/neuron_page.php?id=%'' THEN ''Neuron Type Pages''
					WHEN ( page REGEXP ''^.*\/(property_page_.*\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php| property_page_fp\.php|property_page_phases\.php|synaptic_mod_sum\.php)\?.*(id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+)'' ) THEN ''Evidence'' 
					WHEN ( page REGEXP ''^.*\/(property_page_.*\.php|morphology\.php|markers\.php|ephys\.php|connectivity(_test|_orig)?\.php|synaptome_modeling\.php|firing_patterns\.php|Izhikevich_model\.php|synapse_probabilities\.php|phases\.php|cognome\/.*|synaptome\.php|property_page_counts\.php|property_page_morphology\.php|property_page_ephys\.php|property_page_markers\.php|property_page_connectivity\.php|property_page_fp\.php|property_page_phases\.php|simulation_parameters\.php|synaptome/php/synaptome\.php)$'' 
						AND page NOT REGEXP ''id_neuron=[0-9]+|id1_neuron=[0-9]+|id_neuron_source=[0-9]+|pre_id=[0-9]+'' ) 
						THEN ''Browse'' 
					WHEN page REGEXP ''(search|find_author|find_neuron_name|find_neuron_term|find_pmid|search_engine_custom)'' 
						THEN ''Search''
					WHEN page REGEXP ''(tools\.php|connection_probabilities|synapse_modeler)'' THEN ''Tools'' 
					WHEN page REGEXP ''(Help_Quickstart|Help_FAQ|Help_Known_Bug_List|Help_Other_Useful_Links|Help_|help|user_feedback_form_entry)'' THEN ''Help'' 
					WHEN (page REGEXP ''(bot-traffic|/hipp Better than reCAPTCHA：vaptcha\.cn|^/$|^/php/$)'' 
						AND (page != ''/php/'' OR day_index IS NOT NULL)) THEN ''All Others'' ELSE ''Home'' 
					END AS Property, ', 
					    @sql, ', 
 SUM(CASE WHEN CAST(REPLACE(COALESCE(page_views, \'0\'), \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END) AS POST_2017_Views,
                                        ROUND(" . DELTA_VIEWS . " *  SUM(CASE WHEN CAST(REPLACE(COALESCE(page_views, \'0\'), \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END)) AS Pre_Estimated_2017_Views,
                                        SUM(CASE WHEN CAST(REPLACE(COALESCE(page_views, \'0\'), \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END) +  ROUND(" . DELTA_VIEWS . " *  SUM(CASE WHEN CAST(REPLACE(COALESCE(page_views, \'0\'), \'\', \'\') AS UNSIGNED) > 0 THEN CAST(REPLACE(page_views, \'\', \'\') AS UNSIGNED) ELSE CAST(REPLACE(sessions, \'\', \'\') AS UNSIGNED) END)) AS Total_Views                                                                  
						    FROM GA_combined_analytics 
						    GROUP BY Property
						    ORDER BY FIELD ( 
							Property,
							\"Home\",
							\"Browse\", 
							\"Search\", 
							\"Tools\", 
							\"Help\", 
							\"Neuron Type Pages\", 
							\"Evidence\", 
							\"All Others\"
							) '
						    );";

		$page_functionality_views_query .= "
			PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}

	// echo $page_functionality_views_query;
	$options = ['exclude' => ['not php'],];
	$options = [];//'exclude' => ['not php'],]; //Added this line to make sure we are getting all counts can remove it later
	$columns = ['Property', 'Views'];
	$file_name = "functionality_domain_page_";
	if(isset($write_file)) {
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		return format_table_combined($conn, $page_functionality_views_query, $file_name,  $columns, $write_file, $options, $views_request);
		//	return format_table_combined($conn, $page_functionality_views_query, 'functionality_domain_page_views',  $columns, $write_file, $options);
	}else{
		$table_string = '';//get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_functionality_views_query, 'functionality_domain_page_views',  $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}
?>

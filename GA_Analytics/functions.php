<?php

include ("functionality_views_report.php");
include ("pmid_views_report.php");
 
global $csv_data;

function generateForm($action, $buttonText, $hiddenFields = []) {
    echo '<form method="POST" style="display: inline;">';
    foreach ($hiddenFields as $name => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '<button type="submit">' . htmlspecialchars($buttonText) . '</button>';
    echo '</form>';
}

function generateSection($id, $title, $phpFunction, $hiddenFields = [], $extraText = '') {
    echo '<br><br>';
    echo '<div id="' . htmlspecialchars($id) . '" class="section-container">';
    echo '<div class="section-header">';
    echo '<span class="button-group">';
    echo htmlspecialchars($title) . ' <a href="#top">Back to top</a>';
    echo '</span>';
    echo '<span class="button-group">';
    foreach ($hiddenFields as $name => $value) {
        generateForm($value, 'Download CSV', [$name => $value]);
    }
    echo $extraText;
    echo '</span>';
    echo '</div>';
    echo '<div id="subregion-inside">';
    $phpFunction();
    echo '</div>';
    echo '</div>';
}
 
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
        if($str == 'pmid'){     $path .= $id."/";       }
        if($str == 'neuron'){   $path .= "?id=".$id;    }
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

function download_csvfile($functionName, $conn, $views_request = NULL, $neuron_ids = NULL, $param = NULL) {
    $allowedFunctions = [
        'get_neurons_views_report', 'get_markers_property_views_report', 'get_morphology_property_views_report',
        'get_counts_views_report', 'get_fp_property_views_report', 'get_pmid_isbn_property_views_report',
        'get_domain_functionality_views_report', 'get_page_functionality_views_report',
        'get_views_per_page_report', 'get_pages_views_per_month_report'
    ];  
        
    $neuron_ids_func = [
        'get_counts_views_report', 'get_neurons_views_report', 'get_morphology_property_views_report',
        'get_markers_property_views_report', 'get_pmid_isbn_property_views_report'
    ]; 
        
    if (!in_array($functionName, $allowedFunctions) || !function_exists($functionName)) {
        echo "Invalid function.";
        return;
    }

    $csv_data = call_function($functionName, $conn, $views_request, $neuron_ids, $param, $neuron_ids_func);

    output_csv($csv_data);
    exit();
}

function call_function($functionName, $conn, $views_request, $neuron_ids, $param, $neuron_ids_func) {
    if (in_array($functionName, ['get_neurons_views_report', 'get_morphology_property_views_report', 'get_markers_property_views_report'])) {
        return $functionName($conn, $neuron_ids, $views_request, true);
    }

    if (isset($param)) {
        if (in_array($functionName, $neuron_ids_func)) {
            return $functionName($conn, $param, $neuron_ids, $views_request, true);
        }
        return $functionName($conn, $param, $views_request, true);
    }

    if (in_array($functionName, $neuron_ids_func)) {
        return $functionName($conn, $neuron_ids, $views_request, true);
    }

    return $functionName($conn, $views_request, true);
}

function output_csv($csv_data) {
    // Set headers to initiate file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csv_data['filename'] . '.csv"');
    $output = fopen('php://output', 'w');
    
    // Optionally add CSV headers to the first row
    fputcsv($output, $csv_data['headers']);

    // Write rows to CSV output
    foreach ($csv_data['rows'] as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
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
                        if (stripos($val, 'SYNPRO') !== false) {
                            $csv_headers[$key] = ucwords(strtolower($val));
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

?>


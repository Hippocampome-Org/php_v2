<?php

function get_csv($filepath, $csv_file_name, $excel_param_data){
    $csv_file_name .= date('m-d-Y_H_i_s').".csv";
    $csv_file = $filepath."/".$csv_file_name;
    $file = fopen($csv_file, 'w'); //w is the flag for write mode.
    if($file === false)
    {
        die('Cannot open the file');
    }
    foreach($excel_param_data[0] as $param_data)
    {
        fputcsv($file, $param_data);
    }
    fclose($file);
}

function create_csv_files($filepath, $excel_file_names, $excel_conn_param_data, $excel_neuron_param_data){
    $csv_file_name = join('', $excel_file_names);
    get_csv($filepath, $csv_file_name.'neuron_parameters', $excel_neuron_param_data);
    get_csv($filepath, $csv_file_name.'conn_parameters', $excel_conn_param_data);
}

?>
<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

require_once('/Applications/XAMPP/vendor/autoload.php');

function format_cells($spreadsheet){
    $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray(
        array(
           'fill' => array(
               'type' => Fill::FILL_SOLID,
               'color' => array('rgb' => 'E5E4E2' )
           ),
           'font'  => array(
               'bold'  =>  true
           )
        )
      );
}

function autosize_cells($spreadsheet){
    $activeSheet = $spreadsheet->getActiveSheet();
    foreach (range('A','Z') as $col) {
      $activeSheet->getColumnDimension($col)->setAutoSize(true);  
    }
}

function get_readme_tab($spreadsheet){
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheet->setTitle('README');
    
    $worksheet->setCellValue('A1', "This XL file contains parameter values for both neuron 
    and connection types to simulate a full scale spiking neural network (SNN) 
    model of the CA1. Values color-coded in light blue have been estimated based on 
    experimental evidence and exist on Hippocampome.org. Values color-coded in red are 
    default parameter values from CARLsim. Parameter sets that define the neuron type\'s 
    input-output relationship are for the 9-parameter Izhikevich model formalism, 
    and those that define a connection type\'s short-term plasticity are for the 
    Tsodyks-Pawelzik-Markram (TPM) formalism. Importantly, these parameter values 
    are simulator agnostic, so one can simulate the full scale CA1 SNN in an environment 
    of their choice.");
    $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
    autosize_cells($spreadsheet);
}

function get_neuron_parameters_tab($spreadsheet, $excel_neuron_param_data){

    $spreadsheet->createSheet();
    $spreadsheet->setActiveSheetIndex(1)->setTitle('neuron_parameters');

    $spreadsheet->getActiveSheet()->fromArray(
        $excel_neuron_param_data[0],   // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    format_cells($spreadsheet);

    autosize_cells($spreadsheet);
}

function get_conn_parameters_tab($spreadsheet, $excel_conn_param_data){
    $spreadsheet->createSheet();
    $spreadsheet->setActiveSheetIndex(2)->setTitle('conn_parameters');

    $spreadsheet->getActiveSheet()->fromArray(
        $excel_conn_param_data[0],   // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
    format_cells($spreadsheet);
    autosize_cells($spreadsheet);
}

function create_excel_file($filepath, $excel_file_names, $excel_conn_param_data, $excel_neuron_param_data){
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    get_readme_tab($spreadsheet);
    
    get_neuron_parameters_tab($spreadsheet, $excel_neuron_param_data);
    
    get_conn_parameters_tab($spreadsheet, $excel_conn_param_data);

    $spreadsheet->setActiveSheetIndex(0);

    header("Pragma: public");//Added in second attempt
    header('Content-Type: application/vnd.ms-excel');
    $excel_file_name = join('', $excel_file_names);
    $excel_file_name .= date('m-d-Y_H_i_s').".xlsx"; 
    header('Content-Disposition: attachment;filename="'.$excel_file_name.'"');

    header('Cache-Control: max-age=0');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

    $excel_file = $filepath."/".$excel_file_name;
    $writer->save($excel_file); // Here use the file name from joining thems    
}

?>
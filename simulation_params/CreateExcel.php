<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

require_once('/Applications/XAMPP/vendor/autoload.php');

function format_header_cells($spreadsheet, $startColumn, $fillColor, $endColumn, $fontColor){

    $styleArray = array(
        'font'  => array(
            'bold' => true,
            'color' => array('rgb' => 'FFFFFF')//,//$fontColor),
           // 'size'  => 12,
           // 'name' => 'Verdana'
        ),
        'borders' => array(
            'allBorders' => array(
                'borderStyle' => Border::BORDER_THIN,
                'color' => array('argb' => 'FFFFFF'),
            ),
        ),
    );

    // set autofilter range   
    $spreadsheet->getActiveSheet()
    ->getStyle($startColumn.':'.$endColumn)
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB($fillColor)
   // ->getFont()->applyFromArray(['bold' => true,'color' => ['argb' => 'FFFFFF'],'size'  => 12,'name' => 'Verdana'])
    ->applyFromArray($styleArray);

    //https://spreadsheet-coding.com/phpspreadsheet/create-excel-files-with-different-cell-font-colors
}

function format_cells($spreadsheet, $fillColumn, $fillColor, $highestColumn = NULL, $fontColor=NULL){
    // determine the the number of rows in the active sheet
    $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
    // get the highest column letter
    if(!isset($highestColumn)){
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
    }

    $styleArray = array(
        'borders' => array(
            'allBorders' => array(
                'borderStyle' => Border::BORDER_THIN,
                'color' => array('argb' => 'FFFFFF'),
            ),
        ),
    );

    $spreadsheet->getActiveSheet()->getStyle(
        'A1:'.$highestColumn.$highestRow)
        ->applyFromArray($styleArray);

    // set autofilter range   
    $spreadsheet
    ->getActiveSheet()
    ->getStyle($fillColumn.':'.$highestColumn.$highestRow)
    //->getStyle('D2:'.$highestColumn.$highestRow)
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    //->setARGB('ADD8E6');
    ->setARGB($fillColor)
    ->applyFromArray($styleArray);

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
    
    $worksheet->setCellValue('A1', "This XL file contains parameter values for both 
    neuron and connection types to simulate a full scale spiking neural network (SNN). 
    Values color-coded in light blue have been estimated based on 
    experimental evidence and exist on Hippocampome.org. Values color-coded in red are 
    default parameter values from CARLsim. Parameter sets that define the neuron type\'s 
    input-output relationship are for the 9-parameter Izhikevich model formalism, 
    and those that define a connection type\'s short-term plasticity are for the 
    Tsodyks-Pawelzik-Markram (TPM) formalism. Importantly, these parameter values 
    are simulator agnostic, so one can simulate the full scale SNN in an environment 
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

    format_header_cells($spreadsheet,'A1','336699', 'N1', 'FFFFFF');

    format_cells($spreadsheet,'A2','CCCCCC','C');

    format_cells($spreadsheet,'D2','3399CC');
    format_cells($spreadsheet,'N2','FF0000');

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
    format_header_cells($spreadsheet,'A1','336699', 'K1', 'FFFFFF'); //For First row

    format_cells($spreadsheet,'A2','CCCCCC','D'); //From A to D Grey
    format_cells($spreadsheet,'E2','3399CC');//E Column to all Blue
    format_cells($spreadsheet,'K2','FF0000');//k Red

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
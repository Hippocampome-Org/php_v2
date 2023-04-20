<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

require_once('/Applications/XAMPP/vendor/autoload.php');

function format_cells($spreadsheet, $fillcol){
    // determine the the number of rows in the active sheet
    $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
    // get the highest column letter
    $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
    // set autofilter range
    $spreadsheet->getActiveSheet()->setAutoFilter('A1:'.$highestColumn.$highestRow);
/*
    // Create Table
    $table = new Table('A1:D17', 'Sales_Data');
    // Create Table Style
    $tableStyle = new TableStyle();
    // this line is the style type you want, you can verify this in Excel by clicking the "Format as Table" button and then hovering over the style you like to get the name
    $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM2);
    // this gives you the alternate row color; I suggest to use either this or columnStripes as both together do not look good
    $tableStyle->setShowRowStripes(true);
    // similar to the alternate row color but does it for columns; I suggest to use either this or rowStripes as both together do not look good; I personally set to false and only used the rowStripes
    $tableStyle->setShowColumnStripes(true);
    // this will bold everything in the first column; I personally set to false
    $tableStyle->setShowFirstColumn(true);
    // this will bold everything in the last column; I personally set to false
    $tableStyle->setShowLastColumn(true);
    $table->setStyle($tableStyle);
*/
    $spreadsheet
    ->getActiveSheet()
    ->getStyle($fillcol.':'.$highestColumn.$highestRow)
    //->getStyle('D2:'.$highestColumn.$highestRow)
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('ADD8E6');
   /* $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray(
        array(
           'fill' => array(
               'type' => Fill::FILL_SOLID,
               'color' => array('rgb' => 'ADD8E6')//'E5E4E2' )
           ),
           'font'  => array(
               'bold'  =>  true
           )
        )
      );*/

      
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
    //format_cells($spreadsheet);
    format_cells($spreadsheet,'D2');


    autosize_cells($spreadsheet);
   /* $spreadsheet
    ->getActiveSheet()
    ->getStyle('B1:B5')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('808080');*/
   // $spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
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
    //format_cells($spreadsheet);
    format_cells($spreadsheet,'E2');

    autosize_cells($spreadsheet);
    /*$spreadsheet
    ->getActiveSheet()
    ->getStyle('A1:A5')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('808080');*/
   // $spreadsheet->getActiveSheet()->getStyle('B7')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
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
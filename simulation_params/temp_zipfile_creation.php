<?php

include ("../../access_db.php");
include ("./CreateExcel.php");
ini_set('display_errors', 'On');
include ("./get_connection_parameters.php");
include ("./get_neuron_parameters.php");

$excel_file_names = array();
$result_default_synaptome_array = array();
$excel_conn_param_data = array();

$result_default_neuron_params_array = array();
$excel_neuron_param_data = array();

function neuron_alter(&$item1, $key, $prefix)
{
    $neu_vals = explode('_', $item1);
    $item1 = implode(" ", $neu_vals);
    $item1 = $item1;
}

function if_filename_exists($str, $excel_file_names){
    foreach($excel_file_names as $key){
        $pos = strpos($key, $str);
        if ($pos === 0) {
            return true;
        }
    }
    return false;
}

function generate_file_name($neu_vals, $excel_file_names){
    //Make sure CA3c – CA3 name
    //EC, MEC, LEC – – EC name
    $excel_file_name = NULL;
    $f1 = $f2 = NULL;
    if (in_array(trim($neu_vals[0]), array('CA3', 'CA3c'))) {
        if(!if_filename_exists("CA3_",$excel_file_names)){
            $excel_file_name = "CA3_";
           // $excel_file_name = "CA3_".date('m-d-Y_H_i_s').".xlsx";
        }
    }
    else if (in_array(trim($neu_vals[0]), array('EC', 'MEC', 'LEC'))) {
        if(!if_filename_exists("EC_",$excel_file_names)){
            $excel_file_name = "EC_";
            //$excel_file_name = "EC_".date('m-d-Y_H_i_s').".xlsx";
        }
    }
    else{
        if(!if_filename_exists(trim($neu_vals[0]),$excel_file_names)){
            $excel_file_name = trim($neu_vals[0])."_";
            if($f1){$excel_file_name .= $f1;}
            if($f2){$excel_file_name .= $f2;}
            //$excel_file_name .= date('m-d-Y_H_i_s').".xlsx"; commented for one file name
        }
    }
    return $excel_file_name;
}
if($_POST){
    $neurons =  explode(",", array_keys($_POST)[0]);

    //Including this table name is for future as we know we might need details from different tables
    $result_default_synaptome_array['tm_cond16'] = get_default_synaptome_details($conn_synaptome, 'tm_cond16');
    array_push($excel_conn_param_data, $result_default_synaptome_array['tm_cond16']);

    $result_default_neuron_params_array = get_default_neuron_params_details($conn);
    array_push($excel_neuron_param_data, $result_default_neuron_params_array);

    foreach($neurons as $neuron){
        $neu_vals = explode('_', $neuron);
        $neuron = implode(" ", $neu_vals);
        //To generate the file name dynamically
        $excel_file_name = generate_file_name($neu_vals, $excel_file_names);
        if($excel_file_name){
            array_push($excel_file_names, $excel_file_name);
        }
        
        if (array_key_exists($neuron, $result_default_synaptome_array['tm_cond16'])) {
        }else{
          
        }
        //Till Here
    }
}else{
    echo "Please select Neurons to create zip file.";
    return;
}

// Enter the name of directory
$root = $_SERVER["DOCUMENT_ROOT"];
$root_server = $_SERVER['HTTP_SERVER'];
$pathdir = "/hippocampome/php_v2/data/"; 
$filepath = $root . $pathdir;
$downloadpath = $root_server. $pathdir;

//Create function to create temp directory
function create_directory($temp_dir, $dir_path){
    //$temp_dir = "temp_zipfiles/";
    if(!is_dir($dir_path.$temp_dir)){
        if(mkdir($dir_path.$temp_dir, 0777,true)){
            //  echo "Directory ".$dir_path.$temp_dir." Created"; //log
        }else{
          //  echo "Directory ".$dir_path.$temp_dir." exists"; /log
        }
    }
}

function copy_files($src, $dest){
    shell_exec("cp -r $src $dest");
}

function get_files($folder){
    $valid_files = array();
    $files = scandir($folder);
    foreach($files as $file) {
        if(substr($file, 0, 1) == "." || !is_readable($folder . '/' . $file)) {
            continue;
        }
        if(is_dir($file)){
            array_merge($valid_files, get_files($folder . '/' . $file));
        } else {
            $valid_files[] = $folder . '/' . $file;
        }
    }
    return $valid_files;
}

function emptyDir($dir) {
    if (is_dir($dir)) {
        $scn = scandir($dir);
        foreach ($scn as $files) {
            if ($files !== '.') {
                if ($files !== '..') {
                    if (!is_dir($dir . '/' . $files)) {
                        unlink($dir . '/' . $files);
                    } else {
                        emptyDir($dir . '/' . $files);
                        rmdir($dir . '/' . $files);
                    }
                }
            }
        }
    }
}

function delete_old_folders($path){
    $cache_max_age= 86400; # 24h
    $ffs = scandir($path);
    foreach($ffs as $file){
        if ($file != "." && $file != ".." && !strstr($file,'.php')) {
            $filectime=stat($path.$file)['ctime'];
            if($filectime and $filectime+$cache_max_age<time()){
              //  echo "unlinking ".$path.$file;
                emptyDir($path.$file);
                rmdir($path.$file);
            }
        }
    }
}

function download_zip($filepath,$filename, $download_zip_file){
    $zipfile = $filepath.$filename;
    if (headers_sent()) {
        echo 'HTTP header already sent';
    } else {
        if (!is_file($zipfile)) {
            header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            echo 'File not found';
        } else if (!is_readable($zipfile)) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo 'File not readable';
        } else {
            while (ob_get_level()) {
                ob_end_clean();
            }
            ob_start();
            header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length: ".(string)filesize($filepath.$filename));
            header('Pragma: no-cache');
           // header("Content-Disposition: attachment; filename=\"".basename($zipfile)."\"");
            header("Content-Disposition: attachment; filename=\"export.zip\"");

            ob_clean();
            ob_end_flush();
            echo $download_zip_file."/".$filename;
        }
    }
  
}

$name = date('Y-m-d_H-i-s');
//Create directory
$temp_dir = "temp_zipfiles/";
create_directory($temp_dir, $filepath); //create temp directory if it does not exist

if(!is_dir($filepath.$temp_dir.$name)){
    if( !file_exists($filepath.$temp_dir.$name) ) {
        mkdir($filepath.$temp_dir.$name, 0777, true);
        if(file_exists($filepath.$temp_dir.$name) ) {
            //echo "Directory made ".$filepath.$temp_dir.$name; //log dont echo
        }else{
           // echo "Directory is not created";
        }
    }
    else{
       // echo "Line 36 ...".$filepath.$temp_dir.$name." Exists";
    }
}
$file_name = date('Y-m-d_H-i-s').'.csv';
$zipcreated = "paramsfile".date('m-d-Y_H_i_s').".zip";

if(is_dir($filepath.$temp_dir.$name)){
    delete_old_folders($filepath.$temp_dir);
    $src = $filepath."/default_zipfiles/";  // source folder or file
    $dest = $filepath.$temp_dir.$name;   // destination folder or file        
    copy_files($src, $dest);

    if($excel_conn_param_data){
        create_excel_file($filepath.$temp_dir.$name, $excel_file_names, $excel_conn_param_data, $excel_neuron_param_data);
    }
    //Make the zip file of the excel file too

    $tmp_zip_file = $filepath.$temp_dir.$name."/".$zipcreated;
   // $download_zip_file = $downloadpath.$temp_dir.$name."/".$zipcreated;
    $download_zip_file = $downloadpath.$temp_dir.$name;

    $valid_files = get_files($dest);//."/");
    if(count($valid_files)) {    
        $newzip = new ZipArchive();

        if($newzip->open($tmp_zip_file, ZIPARCHIVE::CREATE) !== true) {
            return false;
        }

        foreach($valid_files as $file) {
            $newzip->addFile($file,$file);
        }
        $newzip->close();
        if (file_exists($filepath.$temp_dir.$name."/".$zipcreated)) {
            chmod($filepath.$temp_dir.$name."/".$zipcreated, 0777);
            download_zip($filepath.$temp_dir.$name."/", $zipcreated, $download_zip_file); 
        }
    }
    else
    {
        return false;
    }
}
?>
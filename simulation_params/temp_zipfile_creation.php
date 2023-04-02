<?php

include ("../../access_db.php");
ini_set('display_errors', 'On');

$result_default_synaptome_array = array();
$excel_file_names = array();
$excel_data = array();

function get_default_synaptome_details($conn_synaptome, $table_name = NULL){
   $columns = array();
   $columns = ['pre'];
   if($table_name == NULL){$table_name ='tm_cond16';}
   $select_default_synaptome_query = "SELECT pre, ";

   $column = "means_g, means_tau_d, means_tau_r, means_tau_f, means_u";
   $select_default_synaptome_query .= "AVG(means_g) as means_g, AVG(means_tau_d) as means_tau_d, 
                                       AVG(means_tau_r) as means_tau_r, 
                                       AVG(means_tau_f) as means_tau_f, AVG(means_u) 
                                       as means_u, ";
   $column .= "min_g, min_tau_d, min_tau_r, min_tau_f, min_u";
   $select_default_synaptome_query .= " AVG(min_g) as min_g, AVG(min_tau_d) as min_tau_d, 
                                       AVG(min_tau_r) as min_tau_r, 
                                       AVG(min_tau_f) as min_tau_f, AVG(min_u) as min_u, ";

   $column .= "max_g, max_tau_d, max_tau_r, max_tau_f, max_u";
   $select_default_synaptome_query .= " AVG(max_g) as max_g, AVG(max_tau_d) as max_tau_d, 
                                       AVG(max_tau_r) as max_tau_r, 
                                       AVG(max_tau_f) as max_tau_f, AVG(max_u) as max_u, ";

   $select_default_synaptome_query = substr($select_default_synaptome_query, 0, -2);
   $select_default_synaptome_query .= " from ".$table_name;
   if($_POST){
    $neurons =  explode(",", array_keys($_POST)[0]);
    $select_default_synaptome_query .= " WHERE ";
    foreach($neurons as $neuron){
        $neu_vals = explode('_', $neuron);
        $neuron = implode(" ", $neu_vals);
        $select_default_synaptome_query .= " pre like '".$neuron."%' OR ";
    }
    //echo $select_default_synaptome_query;
    $select_default_synaptome_query = substr($select_default_synaptome_query, 0, -3);
   }
   $select_default_synaptome_query .= " GROUP BY pre"; 
   //echo $select_default_synaptome_query;
   $rs = mysqli_query($conn_synaptome,$select_default_synaptome_query);
   $columns += explode(", ", $column);
   $result_default_synaptome_array = array();
   while($row = mysqli_fetch_row($rs))
   {	
       $arrVal = [];  
       $i=0;          
       foreach($columns as $colVal){
           if($colVal=='pre'){
               $pre = $row[$i]; //To get the pre value as key
               $pre = trim(substr($row[$i], 0, strpos($row[$i], '('))); //Getting DG Granule from DG Granule (+)2201p
           }else{
               $arrVal[$colVal] = $row[$i]; //tp get other values like mean etc as key and value
           }
           $i++;
       }
       $result_default_synaptome_array[$pre] = $arrVal;
   }
   return  $result_default_synaptome_array;
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

    if (in_array(trim($neu_vals[0]), array('CA3', 'CA3c'))) {
        if(!if_filename_exists("CA3_",$excel_file_names)){
        $excel_file_name = "CA3_".date('m-d-Y_H_i_s').".xls";
        }
    }
    else if (in_array(trim($neu_vals[0]), array('EC', 'MEC', 'LEC'))) {
        if(!if_filename_exists("EC_",$excel_file_names)){
        $excel_file_name = "EC_".date('m-d-Y_H_i_s').".xls";
        }
    }
    else{
        if(!if_filename_exists(trim($neu_vals[0]),$excel_file_names)){
        $excel_file_name = trim($neu_vals[0])."_".date('m-d-Y_H_i_s').".xls";
        }
    }
    return $excel_file_name;
}
//var_dump($_POST);exit;
if($_POST){
    $neurons =  explode(",", array_keys($_POST)[0]);

    //Including this table name is for future as we know we might need details from different tables
    $result_default_synaptome_array['tm_cond16'] = get_default_synaptome_details($conn_synaptome, 'tm_cond16');

    foreach($neurons as $neuron){
        $neu_vals = explode('_', $neuron);
        $neuron = implode(" ", $neu_vals);
        //To generate the file name dynamically
        $excel_file_name = generate_file_name($neu_vals, $excel_file_names);
        if($excel_file_name){
            array_push($excel_file_names, $excel_file_name);
        }
        
        //Till Here
       // var_dump($excel_data);
        //Pushing data into the array
        /*array_push($excel_data, array($neuron));
        if (array_key_exists($neuron, $result_default_synaptome_array['tm_cond16'])) {
            array_push($excel_data, $result_default_synaptome_array['tm_cond16'][$neuron]);
        }else{
            array_push($excel_data, []);
        }*/
        if (array_key_exists($neuron, $result_default_synaptome_array['tm_cond16'])) {
            $excel_data[$neuron]["key"] =  array($neuron);
            $excel_data[$neuron]["fields"] = $result_default_synaptome_array['tm_cond16'][$neuron];
            //array_push($excel_data, $result_default_synaptome_array['tm_cond16'][$neuron]);
        }else{
            $excel_data[$neuron]["key"] =  array($neuron);
            $excel_data[$neuron]["fields"] = [];
           
            //array_push($excel_data, []);
           // $excel_data[$neuron] = [];
        }
        //Till Here
    }
}else{
    echo "Please select Neurons to create zip file.";
    return;
}


// Enter the name of directory
$root = $_SERVER["DOCUMENT_ROOT"];

$pathdir = "/hippocampome/php_v2/data/"; 
$filepath = $root . $pathdir;

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


function create_excel_file($filepath, $excel_file_names, $excel_data){
    foreach($excel_file_names as $excel_file_name){
        $excel_file = $filepath."/".$excel_file_name;
        $fp = fopen($excel_file, 'w');
        foreach ($excel_data as $key => $fields) {
            $excel_file_str = trim(explode("_", $excel_file_name)[0]);
            $pos = strpos($key, $excel_file_str);
            if($pos === 0){
                fputcsv($fp, $fields["key"], "\t", '"');
                fputcsv($fp, $fields["fields"], "\t", '"');
            }
        }
        fclose($fp);
    }
}

function download_zip($filepath,$filename){
    header("Pragma: public");
    //header("Content-type: application/zip"); 
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$filename."\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($filepath.$filename));
    while (ob_get_level()) {
        ob_end_clean();
   }

    //if(is_readable($filepath.$filename)){
        @readfile($filepath.$filename);
    //    exit;
    //}else{
     //   echo "Zip file is not readable";
   // }

    //header("Pragma: no-cache");
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

    if($excel_data){
        create_excel_file($filepath.$temp_dir.$name, $excel_file_names, $excel_data);
    }

    $tmp_zip_file = $filepath.$temp_dir.$name."/".$zipcreated;

   $newzip = new ZipArchive;
   if($newzip -> open($tmp_zip_file, ZipArchive::CREATE ) === TRUE) {
        $ffs = scandir($dest."/");
        foreach($ffs as $file){
            if ($file != "." && $file != ".." && !strstr($file,'.php')) {
                $newzip -> addFile($dest."/".$file, $file);
            }
        }
        $newzip ->close();
        if (file_exists($filepath.$temp_dir.$name."/".$zipcreated)) {
            download_zip($filepath.$temp_dir.$name."/", $zipcreated); 
        }
    }
}


?>
<?php
ini_set('display_errors', 'On');
// Enter the name of directory
$root = $_SERVER["DOCUMENT_ROOT"];

$pathdir = "/hippocampome/php_v2/data/"; 
$filepath = $root . $pathdir;
$yourcontent = "HElloo Kasturi";

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

function delete_old_folders($path){
    $cache_max_age= 86400; # 24h
    $ffs = scandir($path);
    foreach($ffs as $file){
        if ($file != "." && $file != ".." && !strstr($file,'.php')) {
            $filectime=stat($path.$file)['ctime'];
            if($filectime and $filectime+$cache_max_age<time()){
              //  echo "unlinking ".$path.$file;
                unlink($path.$file);
            }
        }
    }
}

function download_zip($filepath,$filename){
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$filename."\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($filepath.$filename));
    ob_end_flush();
    @readfile($filepath.$filename);
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
        download_zip($filepath.$temp_dir.$name."/", $zipcreated);
        /*
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$tmp_zip_file"); 
        header("Content-length: " . filesize($tmp_zip_file));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$tmp_zip_file");
        exit;*/
    }
}


?>
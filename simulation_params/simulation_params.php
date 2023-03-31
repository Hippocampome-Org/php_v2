<?php
    //require_once('simulation_params/class/class.simulation_param.php');
    include('./functions/retrieve_subregions.php');
    include ("../../access_db.php");
?>
<?php
/*
function get_default_synaptome_details($conn_synaptome, $table_name){
    $columns = array();
    $columns = ['pre'];
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
    $select_default_synaptome_query .= " from ".$table_name." GROUP BY pre";
   // echo $select_default_synaptome_query;
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
            }else{
                $arrVal[$colVal] = $row[$i]; //tp get other values like mean etc as key and value
            }
            $i++;
        }
        $result_default_synaptome_array[$pre] = $arrVal;
    }
    return  $result_default_synaptome_array;
}*/

function get_synaptome_details($sub_synaptome, $sub, $conn_synaptome, $table_name){
    $subs = explode(", ", substr($sub, 0, -2));
    $sub_synaptomes = explode(", ", substr($sub_synaptome, 0, -2));
   // var_dump($sub_synaptomes);
    $columns = array();
    $columns = ['pre'];
    $select_synaptome_query = "SELECT pre, ";
    foreach($sub_synaptomes as $sub_synaptome){
        if($sub_synaptome == "mean"){
            $column = "means_g, means_tau_d, means_tau_r, means_tau_f, means_u";
            $select_synaptome_query .= "AVG(means_g) as means_g, AVG(means_tau_d) as means_tau_d, 
                                        AVG(means_tau_r) as means_tau_r, 
                                        AVG(means_tau_f) as means_tau_f, AVG(means_u) 
                                        as means_u, ";
        }
        if($sub_synaptome == "minimum"){
            $column .= "min_g, min_tau_d, min_tau_r, min_tau_f, min_u";
            $select_synaptome_query .= " AVG(min_g) as min_g, AVG(min_tau_d) as min_tau_d, 
                                        AVG(min_tau_r) as min_tau_r, 
                                        AVG(min_tau_f) as min_tau_f, AVG(min_u) as min_u, ";
        }
        if($sub_synaptome == "maximum"){
            $column .= "max_g, max_tau_d, max_tau_r, max_tau_f, max_u";
            $select_synaptome_query .= " AVG(max_g) as max_g, AVG(max_tau_d) as max_tau_d, 
                                        AVG(max_tau_r) as max_tau_r, 
                                        AVG(max_tau_f) as max_tau_f, AVG(max_u) as max_u, ";
        }
        if($sub_synaptome == "median"){
        //, AVG(std_g), AVG(std_tau_d), AVG(std_tau_r), AVG(std_tau_f), AVG(std_u) ";
        //AVG(cv_g), AVG(cv_tau_d), AVG(cv_tau_r), AVG(cv_tau_f), AVG(cv_u),
        }
    }
    $select_synaptome_query = substr($select_synaptome_query, 0, -2);
    $select_synaptome_query .= " from ".$table_name." GROUP BY pre";
   // echo $select_synaptome_query;
    $rs = mysqli_query($conn_synaptome,$select_synaptome_query);
    $columns += explode(", ", $column);
    $result_synaptome_array = array();
    while($row = mysqli_fetch_row($rs))
    {	
        $arrVal = [];  
        $i=0;          
        foreach($columns as $colVal){
            if($colVal=='pre'){
                $pre = $row[$i]; //To get the pre value as key original
                $pre = trim(substr($row[$i], 0, strpos($row[$i], '('))); //Getting DG Granule from DG Granule (+)2201p
                //Added above line on March 30 2023
            }else{
                $arrVal[$colVal] = $row[$i]; //tp get other values like mean etc as key and value
            }
            $i++;
        }
        $result_synaptome_array[$pre] = $arrVal;
    }
    return  $result_synaptome_array;
}
//var_dump($_POST);
$select_query = "SELECT id, name, subregion, nickname, excit_inhib, 
type_subtype, ranks , v2p0 from type ";
$where = " WHERE status = 'active' ";
$sub = "";
$sub_synaptome = "";
$result_synaptome_array = [];
if(isset($_POST) && (count($_POST) > 0 )){
    foreach($_POST as $key => $postval){
        if($postval == 'v1_neurons'){
            $where .= " and ranks in (1, 2, 3, 4, 5) ";
        }
        else if($postval == 'v13_neurons'){
            $where .= " and ranks in (1, 2, 3) ";
        } 
        else if($postval == 'v1_canonical'){
            $where .= "and ranks in (1) ";
        }
        else if(in_array(strtoupper($postval), array('CA2','SUB','CA3','EC','DG','CA1'))){
            $sub .= "'".$postval."', ";
        }
        else if(in_array($postval, array('mean','median','maximum','minimum'))){
            $sub_synaptome .= $postval.", ";
        }
    }
    if(strlen($sub) > 1){
        $sub = substr($sub, 0, -2);
        $where .= "and subregion in (".$sub.")";
    }
    if(strlen($sub_synaptome) > 1){ 
        $result_synaptome_array = get_synaptome_details($sub_synaptome, $sub, $conn_synaptome, 'tm_cond16');
    }
    #var_dump($result_synaptome_array);
}else{
    //$where .= "and subregion in ('DG')";
}
$select_query .= $where;
$select_query .= " ORDER BY position asc";

$rs = mysqli_query($conn,$select_query);
$n=0;
$result_array = array();

$result_array = ["DG"=>array(), "CA3"=>array(), "CA1"=>array(), 
        "EC"=>array(), "CA2"=>array(),"Sub"=>array()];

while(list($id, $name, $subregion, $nickname, $excit_inhib, $type_subtype, $ranks , $v2p0) = mysqli_fetch_row($rs))
{	
    $value=NULL;
    //Get the Synaptome details if exists
    if($result_synaptome_array && (count($result_synaptome_array) > 0)){
        $results = array();
        foreach($result_synaptome_array as $k=>$v) {
            if(preg_match("/\b$nickname\b/i", $k)) {
                $results[$nickname] = $v;
                //$value = retrieve_detail($v);
                //var_dump($results[$nickname]);
                $value = retrieve_detail_tool($v);
            }
        }
    }
    //Using this on Feb 23 2023 as we got new db with nickname updated    
    array_push($result_array[$subregion], 
    array('id'=>$id,'name'=>$nickname, 'excit_inhib'=>$excit_inhib, 'type_subtype'=>$type_subtype, 
    'ranks'=>$ranks , 'v2p0'=>$v2p0, 'synaptome_details'=>$value));
}
if(isset($_POST) && (count($_POST) > 0 )){ //Once we select the Sub regions
    $sub_count = count(explode(',', $sub));
    $param_count = ($sub_count*25)+$sub_count; //To get the count
    echo json_encode(array($param_count, $result_array, $result_synaptome_array));//Changed on March 30 2023
}else{ //Initial page without any parameters selected
    $final_result = retrieve_subregions($result_array);
    echo $final_result;
}
?>
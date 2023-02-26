<?php
//require_once('simulation_params/class/class.simulation_param.php');
include('./functions/retrieve_subregions.php');
include ("../access_db.php");
include ("../access_synaptome_db.php");

?>
<?php

function get_synaptome_details($sub_synaptome, $sub, $conn_synaptome, $table_name){
    //$sub = substr($sub, 0, -2);
    //$sub_synaptome = substr($sub_synaptome, 0, -2);

    $select_synaptome_query = "SELECT pre, AVG(cv_g), AVG(cv_tau_d), 
        AVG(cv_tau_r), AVG(cv_tau_f), AVG(cv_u), AVG(max_g), AVG(max_tau_d), 
        AVG(max_tau_r), AVG(max_tau_f), AVG(max_u), AVG(min_g), 
        AVG(min_tau_d), AVG(min_tau_r), AVG(min_tau_f), AVG(min_u), 
        AVG(means_g), AVG(means_tau_d), AVG(means_tau_r), AVG(means_tau_f), 
        AVG(means_u), AVG(std_g), AVG(std_tau_d), AVG(std_tau_r), 
        AVG(std_tau_f), AVG(std_u) from ".$table_name." GROUP BY pre";
    
    $rs = mysqli_query($conn_synaptome,$select_synaptome_query);
    $n=0;
    $result_synaptome_array = array();
    while(list($pre, $cv_g, $cv_tau_d, $cv_tau_r, $cv_tau_f, 
        $cv_u, $max_g, $max_tau_d, $max_tau_r, $max_tau_f,$max_u, 
        $min_g, $min_tau_d, $min_tau_r, $min_tau_f, $min_u, $means_g, 
        $means_tau_d, $means_tau_r, $means_tau_f, $means_u, $std_g, 
        $std_tau_d, $std_tau_r, $std_tau_f, $std_u) 
        = mysqli_fetch_row($rs))
        {	
            array_push($result_synaptome_array[$pre], 
            array('cv_g' => $cv_g, 'cv_tau_d' =>$cv_tau_d, 'cv_tau_r' =>$cv_tau_r, 
            'cv_tau_f' =>$cv_tau_f, 'cv_u' =>$cv_u, 
            'max_g' =>$max_g, 'max_tau_d' =>$max_tau_d, 'max_tau_r' =>$max_tau_r, 
            'max_tau_f' => $max_tau_f,'max_u' => $max_u, 
            'min_g' => $min_g, 'min_tau_d' => $min_tau_d, 'min_tau_r' => $min_tau_r, 
            'min_tau_f' => $min_tau_f, 'min_u' => $min_u, 'means_g' => $means_g, 
            'means_tau_d' => $means_tau_d, 'means_tau_r' => $means_tau_r, 
            'means_tau_f' => $means_tau_f, 'means_u' => $means_u, 
            'std_g' => $std_g, 'std_tau_d' => $std_tau_d, 'std_tau_r' => $std_tau_r, 
            'std_tau_f' => $std_tau_f, 'std_u' => $std_u));
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
            $sub_synaptome .= "'".$postval."', ";
        }
    }
    if(strlen($sub) > 1){
        $sub = substr($sub, 0, -2);
        $where .= "and subregion in (".$sub.")";
    }
    if(strlen($sub_synaptome) > 1){ 
       // $result_synaptome_array = get_synaptome_details($sub_synaptome, $sub, $conn_synaptome, 'tm_cond16');
    }
    #var_dump($result_synaptome_array);
}else{
    //$where .= "and subregion in ('DG')";
}
$select_query .= $where;
$select_query .= " ORDER BY position asc";
//echo $select_query;

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
        //echo count($result_synaptome_array);
        $value = $result_synaptome_array[current(preg_grep('/^'.$nickname.'/', array_keys($result_synaptome_array)))];
    }
    /*array_push($result_array[$subregion], 
    array('id'=>$id,'name'=>$subregion." ".$nickname, 'excit_inhib'=>$excit_inhib, 'type_subtype'=>$type_subtype, 
    'ranks'=>$ranks , 'v2p0'=>$v2p0));*/
    //Using this on Feb 23 2023 as we got new db with nickname updated    
    array_push($result_array[$subregion], 
    array('id'=>$id,'name'=>$nickname, 'excit_inhib'=>$excit_inhib, 'type_subtype'=>$type_subtype, 
    'ranks'=>$ranks , 'v2p0'=>$v2p0, 'synaptome_details'=>$value));
}
if(isset($_POST) && (count($_POST) > 0 )){ //Once we select the Sub regions
    $sub_count = count(explode(',', $sub));
    $param_count = ($sub_count*25)+$sub_count; //To get the count
    echo json_encode(array($param_count, $result_array));
}else{
    $final_result = retrieve_subregions($result_array);
    echo $final_result;
}
?>
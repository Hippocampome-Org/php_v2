<?php
//require_once('simulation_params/class/class.simulation_param.php');
include ("../access_db.php");
include ("../access_synaptome_db.php");

include('./functions/retrieve_subregions.php');
?>
<?php
//var_dump($_POST);
$select_query = "SELECT name, subregion, nickname, excit_inhib, 
type_subtype, ranks , v2p0 from type ";
$where = " WHERE status = 'active' ";
$sub = "";
$sub_synaptome = "";

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
        $sub =     substr($sub, 0, -2);
        $where .= "and subregion in (".$sub.")";
    }
}else{
    $where .= "and subregion in ('DG')";
    if(strlen($sub_synaptome) > 1){
        $select_synaptome_query = "SELECT pre, post, cv_g, cv_tau_d, cv_tau_r, 
        cv_tau_f, cv_u, max_g, max_tau_d, max_tau_r, max_tau_f, max_u, min_g, 
        min_tau_d, min_tau_r, min_tau_f, min_u, means_g, means_tau_d, 
        means_tau_r, means_tau_f, means_u, std_g, std_tau_d, std_tau_r, 
        std_tau_f, std_u from tm_cond16 ";
        $where = " WHERE pre like 'DG%' ";
        echo $select_synaptome_query;exit;
        $rs = mysqli_query($conn_synaptome,$select_synaptome_query);
        $n=0;
        $result_synaptome_array = array();
        $result_synaptome_array = ["CA2"=>array(),"Sub"=>array(),"CA3"=>array(),"EC"=>array(),
        "DG"=>array(),"CA1"=>array()];

        while(list($pre, $post, $cv_g, $cv_tau_d, $cv_tau_r, $cv_tau_f, 
        $cv_u, $max_g, $max_tau_d, $max_tau_r, $max_tau_f,$max_u, 
        $min_g, $min_tau_d, $min_tau_r, $min_tau_f, $min_u, $means_g, 
        $means_tau_d, $means_tau_r, $means_tau_f, $means_u, $std_g, 
        $std_tau_d, $std_tau_r, $std_tau_f, $std_u) 
        = mysqli_fetch_row($rs))
        {	
            array_push($result_synaptome_array[$subregion], 
            array('pre'=>$pre, 'post'=>$post, 'cv_g' => $cv_g, 
            'cv_tau_d' =>$cv_tau_d, 'cv_tau_r' =>$cv_tau_r, 'cv_tau_f' =>$cv_tau_f, 
            'cv_u' =>$cv_u, 'max_g' =>$max_g, 'max_tau_d' =>$max_tau_d, 
            'max_tau_r' =>$max_tau_r, 'max_tau_f' => $max_tau_f,
            'max_u' => $max_u, 'min_g' => $min_g, 'min_tau_d' => $min_tau_d, 
            'min_tau_r' => $min_tau_r, 'min_tau_f' => $min_tau_f, 
            'min_u' => $min_u, 'means_g' => $means_g, 
            'means_tau_d' => $means_tau_d, 'means_tau_r' => $means_tau_r, 
            'means_tau_f' => $means_tau_f, 'means_u' => $means_u, 
            'std_g' => $std_g, 'std_tau_d' => $std_tau_d, 'std_tau_r' => $std_tau_r, 
            'std_tau_f' => $std_tau_f, 'std_u' => $std_u));
        }
    }
    #var_dump($result_synaptome_array);
}
$select_query .= $where;
$select_query .= " ORDER BY position asc";
//echo $select_query;

$rs = mysqli_query($conn,$select_query);
$n=0;
$result_array = array();
$result_array = ["CA2"=>array(),"Sub"=>array(),"CA3"=>array(),"EC"=>array(),
"DG"=>array(),"CA1"=>array()];

while(list($name, $subregion, $nickname, $excit_inhib, $type_subtype, $ranks , $v2p0) = mysqli_fetch_row($rs))
{	
    array_push($result_array[$subregion], 
    array('name'=>$subregion." ".$nickname, 'excit_inhib'=>$excit_inhib, 'type_subtype'=>$type_subtype, 
    'ranks'=>$ranks , 'v2p0'=>$v2p0));
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
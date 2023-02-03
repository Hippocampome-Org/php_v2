<?php
//require_once('simulation_params/class/class.simulation_param.php');
include ("../access_db.php");
include('/functions/retrieve_subregions.php');
?>
<style>
<?php include('simulation_params/css/main.css');?>
</style>
<?php
function retrieve_subregions($result_array)
{	
    $return_value = '';	
    foreach($result_array as $key => $val_arr){
        $class_name = strtolower($key)."_th_color";
        if(count($val_arr) == 0){
            continue;
        }
        if($key == 'DG'){
            $return_value.="<table>";
            //$return_value.="<tr><th class='".$class_name."'>";
            $return_value.="<tr><th <th bgcolor='#770000'>";
            $return_value.="<span style='color:#ffffff'>";
            $return_value.="<strong>".$key."</strong>";
            $return_value.="</span>";
            $return_value.="</th></tr>";
            foreach($val_arr as $vals){
                $return_value.="<tr><td>";
                if($vals['excit_inhib'] == 'i'){
                    $return_value.="<span style='color:#800000'>";
                }
                if($vals['excit_inhib'] == 'e'){
                    $return_value.="<span style='color:#558D12'>";
                }
                $return_value.=$vals['name'];
                $return_value.="</span>";
                $return_value.="</td></tr>";
            }
            $return_value.="</table>";
        }
        if($key == 'CA1'){
            $return_value.="<table>";
            //$return_value.="<tr><th class='".$class_name."'>";
            $return_value.="<tr><th <th bgcolor='#FF6103'>";
            $return_value.="<span style='color:#ffffff'>";
            $return_value.="<strong>".$key."</strong>";
            $return_value.="</span>";
            $return_value.="</th></tr>";
            foreach($val_arr as $vals){
                $return_value.="<tr><td>";
                if($vals['excit_inhib'] == 'i'){
                    $return_value.="<span style='color:#800000'>";
                }
                if($vals['excit_inhib'] == 'e'){
                    $return_value.="<span style='color:#558D12'>";
                }
                $return_value.=$vals['name'];
                $return_value.="</span>";
                $return_value.="</td></tr>";
            }
            $return_value.="</table>";
        }
    }
    return $return_value;
}
$select_query = "SELECT name, subregion, excit_inhib, 
type_subtype, ranks , v2p0 from type ";
$where = " WHERE status = 'active' ";
$sub = "";
foreach($_POST as $key => $postval){
    //echo $postval;
    if($postval == 'all_neuron'){

    }if($postval == 'v1_neurons'){
        $where .= " and ranks = 1 ";
    }
    if($postval == 'all_neuron'){
        $where .= "and ranks in (1, 2, 3)";
    } 
    if($postval == 'v1_canonical'){
       // and ranks in (1, 2, 3);
        //$where .= "and ranks in (1, 2, 3)";
    }
    else{
        $sub .= "'".$postval."', ";
    }
}
if(strlen($sub) > 1){
    $sub =     substr($sub, 0, -2);
    $where .= "and subregion in (".$sub.")";
}
$select_query .= $where;
//echo $select_query;
//var_dump($conn);
$rs = mysqli_query($conn,$select_query);
$n=0;
$result_array = ['CA2'=>[],'Sub'=>[],'CA3'=>[],'EC'=>[],'DG'=>[],'CA1'=>[]];

while(list($name, $subregion, $excit_inhib, $type_subtype, $ranks , $v2p0) = mysqli_fetch_row($rs))
{	
    array_push($result_array[$subregion], 
    array('name'=>$name, 'excit_inhib'=>$excit_inhib, 'type_subtype'=>$type_subtype, 
    'ranks'=>$ranks , 'v2p0'=>$v2p0));
}
//var_dump($result_array);
$final_result = retrieve_subregions($result_array);
echo $final_result;
?>
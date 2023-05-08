<?php

function style_subregionsdynamically($result_array, $div_location){

    if($div_location == 'left'){
        $return_value = "<div style='width:25%;float:left;'>"; //left div which will have DG, CA2 and EC
    } else if($div_location == 'right'){
        $return_value = "<div style='width:70%;float:left;'>"; //right div which will have CA3, CA1 and EC
    }
        
    foreach($result_array as $key => $val_arr){
        if(count($val_arr) == 0){
            continue;
        }

        if( ($div_location == 'left') && (in_array(trim($key), array('CA3', 'CA1', 'EC')))){ //To get only required list
            continue;
        }
        else if( ($div_location == 'right') && (in_array($key, array('DG', 'CA2', 'Sub')))){
            continue;
        }
        $class_name = strtolower($key)."_th_color";
        $span_name = "countVal_".strtolower($key);

        if( ($div_location == 'left') && (in_array(trim($key), array('DG', 'CA2', 'Sub')))){
        //if(in_array(trim($key), array('DG', 'CA2', 'Sub'))){
            $return_value.="<table style='float:left;width:100%;'>";
        }
        else if( ($div_location == 'right') && (in_array($key, array('CA3', 'CA1', 'EC')))){
        //else if(in_array($key, array('CA3', 'CA1', 'EC'))){
            $return_value.="<table style='float:left;width:33%;'>";
        }
        $return_value.="<tr><th class='".$class_name."'>";
        $return_value.="<strong>".$key." (<span id='".$span_name."' name='".$span_name."'>0</span>/".count($val_arr).")</strong>";
        $return_value.="</th></tr>";
        foreach($val_arr as $vals){
            $td_name=strtolower($key)."_".$vals['id'];
            $return_value.="<tr><td id='".$td_name."' name='".$td_name."' style='font-size:11px' class='default-background' >"; //10 px is all in one line
            $return_value.="<input name='".$td_name."_checkbox' id='".$td_name."_checkbox' type='checkbox' value='".$vals['name']."' />";//To add checkbox
            if($vals['excit_inhib'] == 'i'){
                $return_value.="<span style='color:#800000'>";
            }
            if($vals['excit_inhib'] == 'e'){
                $return_value.="<span style='color:#558D12'>";
            }
            $return_value.=$vals['name'];
            $return_value.="</span>";
            $return_value.="<div id='detail_div".$td_name."' name='detail_div".$td_name."' style='display:none;float:right;padding-right:20px;'>";
            $return_value.="<a href='#' onclick=\"newWindow('".$pathdir."simulations_popup.php?pre=".$vals['name']."', 400, 400)\">";
            $return_value.="<sup style='margin-left:4px;color:#RRGGBB;'>
                Details</sup>";
            $return_value.=$vals['synaptome_details'];
            $return_value.="</a>";
            $return_value.="</div>";
            $return_value.="</td></tr>";
            $i++;
        }
        $return_value.="</table>";
    }
    $return_value .= "</div>";
    return $return_value;
}

function retrieve_subregions($result_array)
{
    $pathdir = "/hippocampome/php_v2/simulation_params/";

    $return_value = style_subregionsdynamically($result_array, 'left');
    $return_value .= style_subregionsdynamically($result_array, 'right');
    
    $return_value .= "<div style='clear: both;'></div>";

    return $return_value;
}

function retrieve_detail($result_array)
{
    $return_value = "";
    $return_value.="<table style='float:left;width:23%;'>";
    $return_value.="<tr><th>Details";
    $return_value.="</th></tr>";
    foreach($result_array as $key => $val){
        $return_value .= "<tr><td style='font-size:5px' class='default-background' >"; //10 px is all in one line
        $return_value .= $key.":".$val;
        $return_value .= "</td></tr>";
    }
    $return_value.="</table>";
    return $return_value;
}
function retrieve_detail_tool($result_array)
{
    $return_value = "";
    $return_value.="<span style='float:left;width:23%;font-size:5px;display:none;'>";
    $return_value.="ToolTip";
    foreach($result_array as $key => $val){
        $return_value .= $key.":".$val;
    }
    $return_value.="</span>";
    return $return_value;
}
?>
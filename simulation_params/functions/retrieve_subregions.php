<?php
function retrieve_subregions($result_array)
{
    $return_value = "";
    foreach($result_array as $key => $val_arr){
        $class_name = strtolower($key)."_th_color";
        $span_name = "countVal_".strtolower($key);

        if(count($val_arr) == 0){
            continue;
        }
        $return_value.="<table style='float:left;width:23%;'>";
        $return_value.="<tr><th class='".$class_name."'>";
        $return_value.="<strong>".$key." (<span id='".$span_name."' name='".$span_name."'>0</span>/".count($val_arr).")</strong>";
        $return_value.="</th></tr>";
        $i=1;
        foreach($val_arr as $vals){//11 is like 2 to second row but to the right
            $td_name=strtolower($key)."_".$i;
            $return_value.="<tr><td id='".$td_name."' name='".$td_name."' style='font-size:11px'>"; //10 px is all in one line
            if($vals['excit_inhib'] == 'i'){
                $return_value.="<span style='color:#800000'>";
            }
            if($vals['excit_inhib'] == 'e'){
                $return_value.="<span style='color:#558D12'>";
            }
            $return_value.=$vals['name'];
            $return_value.="</span>";
            $return_value.="</td></tr>";
            $i++;
        }
        $return_value.="</table>";
    }
    return $return_value;
}
?>
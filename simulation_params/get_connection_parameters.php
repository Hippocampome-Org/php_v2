<?php

function  get_ei_vals($type_details, $id_type){
    $ei_vals = array();
    //var_dump($type_details);
    foreach($type_details as $key => $type_detail) {
        //foreach($type_detail as $key=>$values){
            if($type_detail['excit_inhib'] == $id_type){
                array_push($ei_vals, $key);
            }
       // }
    }
    return $ei_vals;
}

function mmmr($array, $output = 'mean'){ 
    if(!is_array($array)){ 
        return FALSE; 
    }else{ 
        switch($output){ 
            case 'mean': 
                $count = count($array); 
                $sum = array_sum($array); 
                $total = $sum / $count; 
            break; 
            case 'median': 
                rsort($array); 
                $middle = round(count($array) / 2); 
                $total = $array[$middle-1]; 
            break; 
            case 'minimum': 
                $total = min($array);
            break; 
            case 'maximum': 
                $total = max($array);
            break; 
        } 
        return $total; 
    } 
} 

//function calculate_cptotals($synprocptotal_data, $source_id_type, $target_id_type, $calc_type = NULL)
function calculate_cptotals($synprocptotal_data, $source_id_type, $source_ei_vals, $target_id_type, $target_ei_vals, $calc_type = NULL)
{
    if(!isset($calc_type)){
        $calc_type ='mean';
    }
    $mean_vals = $stdev_vals = array();
    $mean_count = $stdev_count = 0;
    foreach($source_ei_vals as $source_ei_val){
        foreach($target_ei_vals as $target_ei_val){
            $key = $source_ei_val.",".$target_ei_val;
            if(isset($synprocptotal_data[$key])){
                if(isset($synprocptotal_data[$key]['cp_mean_total'])){
                    array_push($mean_vals, $synprocptotal_data[$key]['cp_mean_total']);
                    $mean_count++;
                }
                if(isset($synprocptotal_data[$key]['cp_stdev_total'])){
                    array_push($stdev_vals, $synprocptotal_data[$key]['cp_stdev_total']);
                    $stdev_count++;
                }
            }
        }
    }
    return mmmr($mean_vals, $calc_type);
}

function get_connection_probability($row, $synprocptotal_data, $type_details)
{
    $connection_probability = 1;
    $carlsim_default = 'Y';
    $source_id = $row[2];
    $target_id = $row[5];
    $source_id_type = $type_details[$source_id]['excit_inhib'];
    $target_id_type = $type_details[$target_id]['excit_inhib'];
    $source_ei_vals = $target_ei_vals =array();

    $key = $row[2].",".$row[5];
    //$row[2], $row[5];
    if(isset($synprocptotal_data[$key])){
        $connection_probability = $synprocptotal_data[$key]['cp_mean_total'];
        $carlsim_default = 'N';
    }
    else{
        //If mean, median and other option is selected
        $source_ei_vals = get_ei_vals($type_details, $source_id_type);
        $target_ei_vals = get_ei_vals($type_details, $target_id_type);

        $connection_probability = calculate_cptotals($synprocptotal_data, $source_id_type, $source_ei_vals, $target_id_type, $target_ei_vals);
    }
    return array($connection_probability, $carlsim_default);
}

function create_conn_params_query_string($neurons)
{
   /* SELECT pre, post from tm_cond16 WHERE  (
        pre  like 'DG Semilunar Granule%' AND (
        post like 'DG Semilunar Granule%' 
            OR post like 'CA3 Axo-axonic%' 
          OR post like 'CA1 Axo-axonic%'
         ) )
         OR 
         (pre  like 'CA3 Axo-axonic%' AND (
        post like 'DG Semilunar Granule%' 
            OR post like 'CA3 Axo-axonic%' 
          OR post like 'CA1 Axo-axonic%'
         ) )
         OR 
         (pre  like 'CA1 Axo-axonic%' AND (
        post like 'DG Semilunar Granule%' 
            OR post like 'CA3 Axo-axonic%' 
          OR post like 'CA1 Axo-axonic%'
         ))
        ; */
        $post_neuron = NULL;
        $post_neuron = ' AND (    ';
        foreach($neurons as $neuron){
            $post_neuron .= "POST LIKE ";
            $post_neuron .= "'".$neuron."%' OR ";
        }
        $post_neuron =  substr($post_neuron, 0, -3);
        $post_neuron .= ' ) ';
        return $post_neuron;
}

function get_default_synaptome_details($conn_synaptome, $table_name = NULL, $synprocptotal_data, $type_details, $neurons_default = NULL){
    if($table_name == NULL){$table_name ='tm_cond16';}
    $select_default_synaptome_query = "SELECT 
    left(pre,LOCATE(' ',pre) - 1) as source_subregion, 
    left(pre,LOCATE(' (',pre) - 1) as pre,  
    (select sr.type_id from synprotypetyperel sr where 
    sr.type_name = pre
    or sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(pre ,' (',1),' ',-2) 
    OR 
    sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(pre,' (',1),' ',-3) 
    ) as pre_type_id, 
    left(post,LOCATE(' ',post) - 1) as target_subregion,  
    left(post,LOCATE(' (',post) - 1) as post, 
    (select sr.type_id from synprotypetyperel sr where 
    sr.type_name = post
    or sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(post,' (',1),' ',-2) 
    OR 
    sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(post,' (',1),' ',-3) 
    ) as post_type_id, ";

   // $column = "Source Subregion, Presynaptic Neuron Type, Target Subregion, Postsynaptic Neuron Type, g, tau_d, tau_r, tau_f, u, ";//Connection Probability, Synaptic Delay";
    $column = "Source Subregion, Presynaptic Neuron Type, Target Subregion, Postsynaptic Neuron Type, g, tau_d, tau_r, tau_f, u, Connection Probability, Synaptic Delay, CARLsim_default, ";

    $select_default_synaptome_query .= " means_g, means_tau_d, means_tau_r, means_tau_f, means_u, ";

    $column = substr($column, 0, -2);
    $select_default_synaptome_query = substr($select_default_synaptome_query, 0, -2);
    $select_default_synaptome_query .= " FROM ".$table_name;
    if($_POST){
        if(array_keys($_POST)[0] == "selectall_neuron"){
            $neurons = $neurons_default;
        }else{
            $neurons =  explode(",", array_keys($_POST)[0]);
        }
        $select_default_synaptome_query .= " WHERE ";
        $post_neuron = [];
        array_walk($neurons, 'neuron_alter', '');
        $result_default_synaptome_array = array();
 
        for ($i = 0; $i < count($neurons); $i++){
            $neuron = $neurons[$i];

            if($i != 0){
                $select_default_synaptome_query .= " OR ";
            }
            $select_default_synaptome_query .= " ( pre like '".$neuron."%'  ";
            $select_default_synaptome_query .= create_conn_params_query_string($neurons);
            $select_default_synaptome_query .= " ) ";
        }
    }
    $select_default_synaptome_query .= " ORDER BY pre ASC";
    //echo "get_connection_params query is : ".$select_default_synaptome_query;
    $rs = mysqli_query($conn_synaptome,$select_default_synaptome_query);
    $columns = explode(", ", $column);
   
    while($row = mysqli_fetch_row($rs))
    {	
        $arrVal = array();  
        $i=0;  
        list($connection_probability, $carlsim_default) = get_connection_probability($row, $synprocptotal_data, $type_details);
        foreach($columns as $colVal){
            if($colVal == 'Synaptic Delay'){
                array_push($arrVal, 1);
            }elseif($colVal =='Connection Probability'){
                array_push($arrVal, $connection_probability); //To add Connection probability -- need to tweak somemore
            }elseif($colVal == 'CARLsim_default'){
                //array_push($arrVal, 'N');
                array_push($arrVal, $carlsim_default); // To add carlsim_default which is N by default
            }else{
                array_push($arrVal, $row[$i]);
            }
            $i++;
        }
        //$connection_probability = 1;
        /*array_push($arrVal, $connection_probability); //To add Connection probability -- need to tweak somemore
        array_push($arrVal, 1); // To add Synaptic delay which is 1 by default
        array_push($arrVal, $carlsim_default); // To add Synaptic delay which is N by default
*/
        array_push($result_default_synaptome_array, $arrVal);
    }
    /*array_push($columns, "Connection Probability");
    array_push($columns, "Synaptic Delay");
    array_push($columns, "CARLsim_default");*/
    array_unshift($result_default_synaptome_array, $columns);
    //var_dump($result_default_synaptome_array);
    return  $result_default_synaptome_array;
}
?>
<?php

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

function get_default_synaptome_details($conn_synaptome, $table_name = NULL){
    if($table_name == NULL){$table_name ='tm_cond16';}
    $select_default_synaptome_query = "SELECT 
    left(pre,LOCATE(' ',pre) - 1) as source_subregion, 
    left(pre,LOCATE(' (',pre) - 1) as pre,  
    left(post,LOCATE(' ',post) - 1) as target_subregion,  
    left(post,LOCATE(' (',post) - 1) as post, ";

    $column = "Source Subregion, Presynaptic Neuron Type, Target Subregion, Postsynaptic Neuron Type, g, tau_d, tau_r, tau_f, u, ";//Connection Probability, Synaptic Delay";
    $select_default_synaptome_query .= " means_g, means_tau_d, means_tau_r, means_tau_f, means_u, ";

    $column = substr($column, 0, -2);
    $select_default_synaptome_query = substr($select_default_synaptome_query, 0, -2);
    $select_default_synaptome_query .= " from ".$table_name;
    if($_POST){
     $neurons =  explode(",", array_keys($_POST)[0]);
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
    //echo $select_default_synaptome_query;
    $rs = mysqli_query($conn_synaptome,$select_default_synaptome_query);
    $columns = explode(", ", $column);
   
    while($row = mysqli_fetch_row($rs))
    {	
        $arrVal = [];  
        $i=0;      
        foreach($columns as $colVal){
            array_push($arrVal, $row[$i]);
            $i++;
        }
        array_push($arrVal, 1); //To add Connection probability -- need to tweak somemore
        array_push($arrVal, 1); // To add Synaptic delay which is 1 by default
        array_push($result_default_synaptome_array, $arrVal);
    }
    array_push($columns, "Connection Probability");
    array_push($columns, "Synaptic Delay");
    array_unshift($result_default_synaptome_array, $columns);
    return  $result_default_synaptome_array;
}
?>
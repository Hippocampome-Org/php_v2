<?php
//No need of this one for neurons
function create_neurons_params_query_string($neurons)
{
   /* select type.nickname, Type.excit_inhib,Type.ranks, (select sum(counts) from Counts where unique_ID = Type.id) as population, 
izhmodels_single.C , izhmodels_single.k, 
izhmodels_single.Vr, izhmodels_single.Vt, izhmodels_single.a, izhmodels_single.b, izhmodels_single.Vpeak, izhmodels_single.Vmin, 
izhmodels_single.d from Type join izhmodels_single on izhmodels_single.unique_id = type.id 
where Type.nickname IN  ('CA1 Basket', 
'CA1 Horizontal Basket', 
'CA1 Basket CCK') and izhmodels_single.preferred = 'Y'
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

function get_default_neuron_params_details($conn){
    $select_default_neuron_params_query = "SELECT 
                    Type.nickname, Type.excit_inhib,
                    Type.ranks, 
                    (select sum(counts) from Counts where unique_ID = Type.id) as population, 
                    izhmodels_single.C , izhmodels_single.k, 
                    izhmodels_single.Vr, izhmodels_single.Vt, izhmodels_single.a, 
                    izhmodels_single.b, izhmodels_single.Vpeak, izhmodels_single.Vmin, 
                    izhmodels_single.d   
                    from Type 
                    join izhmodels_single on izhmodels_single.unique_id = type.id ";

    $column = 'Neuron Type, E/I, rank, Population Size, Izh C, Izh k, Izh Vr, Izh Vt, Izh a, Izh b, Izh Vpeak, Izh Vmin, Izh d, Refractory Period';
    if($_POST){
        $result_default_neuron_params_array = array();
        if(array_keys($_POST)[0] != "selectall_neuron"){
            $neurons =  explode(",", array_keys($_POST)[0]);
            $post_neuron = [];
            array_walk($neurons, 'neuron_alter', '');
            $select_default_neuron_params_query .= " WHERE Type.nickname in (";
    
            for ($i = 0; $i < count($neurons); $i++){
                $neuron = $neurons[$i];
                $select_default_neuron_params_query .= " '".$neuron."', ";
            }
            $select_default_neuron_params_query = substr($select_default_neuron_params_query, 0, -2);
            $select_default_neuron_params_query .= " ) ";
        }
    }
    $select_default_neuron_params_query .= " and izhmodels_single.preferred = 'Y'  ORDER BY Type.nickname ASC";
    echo $select_default_neuron_params_query;
    $rs = mysqli_query($conn,$select_default_neuron_params_query);
    $columns = explode(", ", $column);
   
    while($row = mysqli_fetch_row($rs))
    {   
        $arrVal = [];  
        $i=0;      
        foreach($columns as $colVal){
            if($colVal == 'Refractory Period'){
                array_push($arrVal, 1);
            }else{
                array_push($arrVal, $row[$i]);
                $i++;
            }
        }
        array_push($result_default_neuron_params_array, $arrVal);
    }
    array_unshift($result_default_neuron_params_array, $columns);
   // var_dump($result_default_neuron_params_array); // exit;
    return  $result_default_neuron_params_array;
}

?>

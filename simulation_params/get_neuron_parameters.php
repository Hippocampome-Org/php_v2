<?php

//No need of this one for neurons
function create_neurons_params_query_string($neurons)
{
   /* select type.nickname, Type.excit_inhib,Type.ranks, (select sum(counts) from Counts where unique_ID = Type.id) as population, 
izhmodels_single.C , izhmodels_single.k, 
izhmodels_single.Vr, izhmodels_single.Vt, izhmodels_single.a, izhmodels_single.b, izhmodels_single.Vpeak, izhmodels_single.Vmin, 
izhmodels_single.d from Type join izhmodels_single on izhmodels_single.unique_id = Type.id 
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

function update_neurons_withmissing($result_default_neuron_params_array, $defualt_neuron_calculations, $missing_neurons, $columns){
    foreach($missing_neurons as $missing_neuron){
        $missing_neuron = trim($missing_neuron);
        if($missing_neuron == 'EC LII Basket-Neurogliaform'){
            $missing_neuron = 'EC LII Basket Multipolar Interneuron';
        }
        /*echo "Line 29 missing_neuron ----";
        var_dump($missing_neuron);*/
        if(isset($defualt_neuron_calculations[$missing_neuron])){
            $arrVal = array();  
            $i=0;
            foreach($columns as $colVal){
                if($colVal == 'Refractory Period'){
                    array_push($arrVal, 1);
                }elseif($colVal == 'CARLsim_default'){
                    array_push($arrVal, 'Y');
                }else{
                    array_push($arrVal, $defualt_neuron_calculations[$missing_neuron][$i]);
                    $i++;
                }
            }
            /*echo "Line 44 ----";
            var_dump($arrVal);*/
            array_push($result_default_neuron_params_array, $arrVal);
        }
    }
    return $result_default_neuron_params_array;
}

function get_default_neuron_params_details($conn, $neurons_default=NULL){
    $select_default_neuron_params_query = "SELECT 
                    Type.nickname, Type.excit_inhib,
                    Type.ranks, 
                    (select sum(counts) from Counts where unique_ID = Type.id) as population, 
                    izhmodels_single.C , izhmodels_single.k, 
                    izhmodels_single.Vr, izhmodels_single.Vt, izhmodels_single.a, 
                    izhmodels_single.b, izhmodels_single.Vpeak, izhmodels_single.Vmin, 
                    izhmodels_single.d   
                    from Type 
                    join izhmodels_single on izhmodels_single.unique_id = Type.id ";

    $column = 'Neuron Type, E/I, rank, Population Size, Izh C, Izh k, Izh Vr, Izh Vt, Izh a, Izh b, Izh Vpeak, Izh Vmin, Izh d, Refractory Period, CARLsim_default';
    if($_POST){
        $result_default_neuron_params_array = array();
        if(array_keys($_POST)[0] == "selectall_neuron"){
            $neurons = $neurons_default;
        }else{
            $neurons =  explode(",", array_keys($_POST)[0]);
        }
            $post_neuron = [];
            array_walk($neurons, 'neuron_alter', '');
            $select_default_neuron_params_query .= " WHERE Type.nickname in (";
    
            for ($i = 0; $i < count($neurons); $i++){
                $neuron = $neurons[$i];
                $select_default_neuron_params_query .= " '".trim($neuron)."', ";
            }
            $select_default_neuron_params_query = substr($select_default_neuron_params_query, 0, -2);
            $select_default_neuron_params_query .= " ) ";
    }
    $select_default_neuron_params_query .= " AND status = 'active' AND v2p0 = 0 ";
    $select_default_neuron_params_query .= " AND izhmodels_single.preferred = 'Y' ";
    $select_default_neuron_params_query .= " ORDER BY Type.nickname ASC";
    //echo "get_neuron_params query is : ".$select_default_neuron_params_query;
    $rs = mysqli_query($conn,$select_default_neuron_params_query);
    $columns = explode(", ", $column);
    $defualt_neuron_calculations = array();
    $defualt_neuron_calculations = get_default_neuron_calc_values();
    //var_dump($defualt_neuron_calculations);exit;
    $missing_neurons = array();
    $neurons_db = array();
    while($row = mysqli_fetch_row($rs))
    {   
        $arrVal = array();  
        $i=0;      
        foreach($columns as $colVal){
            if($colVal == 'Refractory Period'){
                array_push($arrVal, 1);
            }elseif($colVal == 'CARLsim_default'){
                array_push($arrVal, 'N');
            }else{
                if($colVal == 'Neuron Type'){
                    array_push($neurons_db, $row[$i]);
                }
                array_push($arrVal, $row[$i]);
                $i++;
            }
        }
        array_push($result_default_neuron_params_array, $arrVal);
    }
    $missing_neurons = array_diff($neurons, $neurons_db);
    /*echo "count of neurons: ";echo count($neurons);
    echo "neurons: ";var_dump($neurons);
    echo "neurons_db: ";var_dump($neurons_db);
    echo "missing neurons: ";var_dump($missing_neurons);*/
    if(isset($missing_neurons) && count($missing_neurons) > 0){
        $result_default_neuron_params_array = update_neurons_withmissing($result_default_neuron_params_array, $defualt_neuron_calculations, $missing_neurons, $columns);
    }
    array_unshift($result_default_neuron_params_array, $columns);
    //var_dump($result_default_neuron_params_array); // exit;
    return  $result_default_neuron_params_array;
}

?>

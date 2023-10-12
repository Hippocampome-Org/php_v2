<?php 
function get_default_neuron_calc_values(){
    $default_neuron_calc_calculations = array(
        'CA1 Interneuron Specific LMO-O' => array('CA1 Interneuron Specific LMO-O', 'i','5', '417','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'CA1 Interneuron Specific LM-R'=>array('CA1 Interneuron Specific LM-R','i','4','2042','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'CA1 Interneuron Specific LMR-R'=>array('CA1 Interneuron Specific LMR-R', 'i', '4', '2464', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Interneuron Specific O-R'=>array('CA1 Interneuron Specific O-R', 'i', '5', '177', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Interneuron Specific O-Targeting QuadD'=>array('CA1 Interneuron Specific O-Targeting QuadD', 'i', '4', '417', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Interneuron Specific R-O'=>array('CA1 Interneuron Specific R-O', 'i', '5', '1703', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Interneuron Specific RO-O'=>array('CA1 Interneuron Specific RO-O', 'i', '5', '417', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 LMR Projecting'=>array('CA1 LMR Projecting', 'i', '4', '1604', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Oriens-Bistratified Projecting'=>array('CA1 Oriens-Bistratified Projecting', 'i', '5', '465', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Cajal-Retzius'=>array('CA1 Cajal-Retzius', 'e', '4', '1153', '100.00', '0.70', '-60.00', '-40.00', '0.03', '-2.00', '35.00', '-50.00', 100.00),
        'CA1 Schaffer Collateral-Receiving R-Targeting'=>array('CA1 Schaffer Collateral-Receiving R-Targeting', 'i', '5', '204', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1 Hippocampo-subicular Projecting ENK+'=>array('CA1 Hippocampo-subicular Projecting ENK+', 'i', '5', '287', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Basket CCK' => array('CA3 Basket CCK', 'i', '3', '408', '135.00', '0.58', '-59.00', '-39.40', '0.01', '-1.24', '18.27', '-42.77', 54.00), 
        'CA3 Bistratified'=>array('CA3 Bistratified', 'i', '2', '483', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Interneuron Specific Oriens'=>array('CA3 Interneuron Specific Oriens', 'i', '5', '2117', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Interneuron Specific Quad'=>array('CA3 Interneuron Specific Quad', 'i', '5', '2422', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Ivy'=>array('CA3 Ivy', 'i', '3', '176', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Lucidum LAX'=>array('CA3 Lucidum LAX', 'i', '5', '133', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Lucidum-Radiatum'=>array('CA3 Lucidum-Radiatum', 'i', '5', '127', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 QuadD-LM'=>array('CA3 QuadD-LM', 'i', '4', '4060', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Radiatum'=>array('CA3 Radiatum', 'i', '3', '765', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 R-LM'=>array('CA3 R-LM', 'i', '4', '185', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 SO-SO'=>array('CA3 SO-SO', 'i', '5', '2959', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG Basket CCK'=>array('DG Basket CCK', 'i', '3', '128', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG Basket CCK+'=>array('DG Basket CCK+', 'i', '3', '128', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG MOCAP'=>array('DG MOCAP', 'i', '5', '9067', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG Outer Molecular Layer'=>array('DG Outer Molecular Layer', 'i', '5', '10', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG Mossy MOLDEN'=>array('DG Mossy MOLDEN', 'e', '5', '5206', '100.00', '0.70', '-60.00', '-40.00', '0.03', '-2.00', '35.00', '-50.00', 100.00),
        'EC LIV-V Pyramidal-Horizontal' =>array('EC LIV-V Pyramidal-Horizontal', 'e', '3', '56273', '100.00', '0.70', '-60.00', '-40.00', '0.03', '-2.00', '35.00', '-50.00', 100.00),
        'EC LII Basket Multipolar Interneuron'=>array('EC LII Basket-Neurogliaform', 'i', '3', '4698', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'EC LII Axo-axonic'=>array('EC LII Axo-axonic', 'i', '3', '13120', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'MEC LII Basket'=>array('MEC LII Basket', 'i', '4', '6560', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'EC LII Basket Multipolar Interneuron'=>array('EC LII Basket Multipolar Interneuron','i','3','4698','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'LEC LIII Multipolar Interneuron'=>array('LEC LIII Multipolar Interneuron','i','4','2404','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'Sub Axo-axonic'=>array('Sub Axo-axonic','i','3','12796','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'Sub EC-Projecting Pyramidal'=>array('Sub EC-Projecting Pyramidal','e','3','116326','100.00','0.70','-60.00','-40.00','0.03','-2.00','35.00','-50.00',100.00)
    );
    return $default_neuron_calc_calculations;
}

function get_type_details($conn){
    $select_query = "SELECT id, name, subregion, nickname, excit_inhib, position, type_subtype, ranks , v2p0 ";
    $select_query .= " FROM Type ";
    $select_query .= " WHERE status = 'active' AND v2p0 = 0 ORDER BY position ASC";
    $rs = mysqli_query($conn,$select_query);
    $n=0;

    $result_array = array();
    while(list($id, $name, $subregion, $nickname, $excit_inhib, $position, $type_subtype, $ranks , $v2p0) = mysqli_fetch_row($rs))
    {
        if(in_array($nickname, array('CA1 Deep Pyramidal', 'CA1 Superficial Pyramidal'))){ continue; }

        //Using this on Feb 23 2023 as we got new db with nickname updated    
        $result_array[$id] = array('id'=>$id,'name'=>$name,'nickname'=>$nickname,'excit_inhib'=>$excit_inhib,
                                    'position'=>$position,'subregion'=>$subregion,'type_subtype'=>$type_subtype,
                                    'ranks'=>$ranks ,'v2p0'=>$v2p0);
         //var_dump($result_array);
    }
    return $result_array;
}

function get_neurons($type_details, $subregions){
    $neurons = $neurons_subregions = array();
    $type_details_vals = array_values($type_details);
    foreach($subregions as $subregion){
        $neurons_subregions[$subregion] = array();
    }
    foreach($type_details as $key => $type_detail) {
        //$type_detail['nickname'] = str_replace(' ', '_', $type_detail['nickname']); //Added for "select all" //Commented on May 7 2023
        array_push($neurons, $type_detail['nickname']);
        array_push($neurons_subregions[$type_detail['subregion']], $type_detail['nickname']);
    }
    return array($neurons, $neurons_subregions);

}

function get_synproCPtotal_data($conn){
    $select_query = "SELECT source_id, (select excit_inhib from Type where id = source_id) as source_excit_inhib, ";
    $select_query .= "target_id, (select excit_inhib from Type where id = target_id) as target_excit_inhib, ";
    $select_query .= "CP_mean_total, CP_stdev_total, parcel_count ";
    $select_query .= "FROM SynproCPTotal";
    //var_dump($conn);echo $select_query;
    $rs = mysqli_query($conn,$select_query);

    $result_array = array();
    while(list($source_id, $source_excit_inhib, $target_id, $target_excit_inhib, $cp_mean_total, $cp_stdev_total, $parcel_count) = mysqli_fetch_row($rs))
    //var_dump($rs);
    //while(list($source_id, $target_id, $cp_mean_total, $cp_stdev_total, $parcel_count) = mysqli_fetch_row($rs))
    {
        //Using this on Feb 23 2023 as we got new db with nickname updated
        $key = $source_id.",".$target_id;
        $result_array[$key] = array();
        $result_array[$key]['source_id']=$source_id;
        $result_array[$key]['source_excit_inhib']=$source_excit_inhib;
        $result_array[$key]['target_id']=$target_id;
        $result_array[$key]['target_excit_inhib']=$target_excit_inhib;
        $result_array[$key]['cp_mean_total']=$cp_mean_total;
        $result_array[$key]['cp_stdev_total']=$cp_stdev_total;
        $result_array[$key]['parcel_count']=$parcel_count;
    }
    //var_dump($result_array);
    return $result_array;
}
/*
function get_synprotypetyperel_data($conn_synaptome){
    $select_query = "select  tm.pre, 
    (select sr.type_id from synprotypetyperel sr where 
    sr.type_name = tm.pre
    or sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(tm.pre ,' (',1),' ',-2) 
    OR 
    sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(tm.pre,' (',1),' ',-3) 
    ) as pre_type_id, 
    tm.post, (select sr.type_id from synprotypetyperel sr where 
    sr.type_name = tm.post
    or sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(tm.post,' (',1),' ',-2) 
    OR 
    sr.type_nickname = SUBSTRING_INDEX(SUBSTRING_INDEX(tm.post,' (',1),' ',-3) 
    ) as post_type_id
    from tm_cond16 tm";

    $rs = mysqli_query($conn_synaptome,$select_query);
    $n=0;
    $result_array = array();
    while(list($pre, $pre_id, $post, $post_id) = mysqli_fetch_row($rs))
    {
        //Using this on Feb 23 2023 as we got new db with nickname updated    
        array_push($result_array, 
        array('pre'=>$pre,'pre_type_id'=>$pre_type_id, 
                'post'=>$post, 
                'post_type_id'=>$post_type_id));
    }
    var_dump($result_array);
    return $result_array;
}
*/
?>

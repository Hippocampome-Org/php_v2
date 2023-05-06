<?php 
function get_default_neuron_calc_values(){
    $default_neuron_calc_calculations = array(
        'CA1_Interneuron_Specific_LMO_O' => array('CA1_Interneuron_Specific_LMO_O', 'i','5', '417','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'CA1_Interneuron_Specific_LM_R'=>array('CA1_Interneuron_Specific_LM_R','i','4','2042','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'CA1_Interneuron_Specific_LMR_R'=>array('CA1_Interneuron_Specific_LMR_R', 'i', '4', '2464', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Interneuron_Specific_O_R'=>array('CA1_Interneuron_Specific_O_R', 'i', '5', '177', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Interneuron_Specific_O_Targeting_QuadD'=>array('CA1_Interneuron_Specific_O_Targeting_QuadD', 'i', '4', '417', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Interneuron_Specific_R_O'=>array('CA1_Interneuron_Specific_R_O', 'i', '5', '1703', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Interneuron_Specific_RO_O'=>array('CA1_Interneuron_Specific_RO_O', 'i', '5', '417', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_LMR_Projecting'=>array('CA1_LMR_Projecting', 'i', '4', '1604', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Oriens_Bistratified_Projecting'=>array('CA1_Oriens_Bistratified_Projecting', 'i', '5', '465', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Schaffer_Collateral_Receiving_R_Targeting'=>array('CA1_Schaffer_Collateral_Receiving_R_Targeting', 'i', '5', '204', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA1_Hippocampo_Subicular_Projecting_ENK'=>array('CA1_Hippocampo_Subicular_Projecting_ENK', 'i', '5', '287', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Basket CCK' => array('CA3 Basket CCK', 'i', '3', '408', '135.00', '0.58', '-59.00', '-39.40', '0.01', '-1.24', '18.27', '-42.77', 54.00), 
        'CA3 Bistratified'=>array('CA3 Bistratified', 'i', '2', '483', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_Interneuron_Specific_Oriens'=>array('CA3_Interneuron_Specific_Oriens', 'i', '5', '2117', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_Interneuron_Specific_Quad'=>array('CA3_Interneuron_Specific_Quad', 'i', '5', '2422', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Ivy'=>array('CA3 Ivy', 'i', '3', '176', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_Lucidum_LAX'=>array('CA3_Lucidum_LAX', 'i', '5', '133', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_Lucidum_Radiatum'=>array('CA3_Lucidum_Radiatum', 'i', '5', '127', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_QuadD_LM'=>array('CA3_QuadD_LM', 'i', '4', '4060', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3 Radiatum'=>array('CA3 Radiatum', 'i', '3', '765', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_R_LM'=>array('CA3_R_LM', 'i', '4', '185', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'CA3_SO_SO'=>array('CA3_SO_SO', 'i', '5', '2959', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG Basket CCK'=>array('DG Basket CCK', 'i', '3', '128', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG_MOCAP'=>array('DG_MOCAP', 'i', '5', '9067', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'DG_Outer_Molecular_Layer'=>array('DG_Outer_Molecular_Layer', 'i', '5', '10', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'EC LIV-V Pyramidal-Horizontal' =>array('EC LIV-V Pyramidal-Horizontal', 'e', '3', '56273', '100.00', '0.70', '-60.00', '-40.00', '0.03', '-2.00', '35.00', '-50.00', 100.00),
        'EC LII Basket Multipolar Interneuron'=>array('EC LII Basket-Neurogliaform', 'i', '3', '4698', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'EC LII Axo-axonic'=>array('EC LII Axo-axonic', 'i', '3', '13120', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'MEC_LII_Basket'=>array('MEC_LII_Basket', 'i', '4', '6560', '20.00', '1.00', '-55.00', '-40.00', '0.15', '8.00', '25.00', '-55.00', 200.00),
        'EC LII Basket Multipolar Interneuron'=>array('EC LII Basket Multipolar Interneuron','i','3','4698','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'LEC_LIII_Multipolar_Interneuron'=>array('LEC_LIII_Multipolar_Interneuron','i','4','2404','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'Sub Axo-axonic'=>array('Sub Axo-axonic','i','3','12796','20.00','1.00','-55.00','-40.00','0.15','8.00','25.00','-55.00',200.00),
        'Sub EC-Projecting Pyramidal'=>array('Sub EC-Projecting Pyramidal','e','3','116326','100.00','0.70','-60.00','-40.00','0.03','-2.00','35.00','-50.00',100.00)
    );
    return $default_neuron_calc_calculations;
}

function get_type_details($conn){
    $select_query = "SELECT id, name, subregion, nickname, excit_inhib, position, type_subtype, ranks , v2p0 ";
    $select_query .= " FROM Type ORDER BY position ASC";
    $rs = mysqli_query($conn,$select_query);
    $n=0;

    $result_array = array();
    while(list($id, $name, $subregion, $nickname, $excit_inhib, $position, $type_subtype, $ranks , $v2p0) = mysqli_fetch_row($rs))
    {
        //Using this on Feb 23 2023 as we got new db with nickname updated    
        $result_array[$id] = array('id'=>$id,'name'=>$name,'nickname'=>$nickname,'excit_inhib'=>$excit_inhib,
                                    'position'=>$position,'subregion'=>$subregion,'type_subtype'=>$type_subtype,
                                    'ranks'=>$ranks ,'v2p0'=>$v2p0);
         //var_dump($result_array);
    }
    return $result_array;
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
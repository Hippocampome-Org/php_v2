<?php 
function get_default_neuron_calculations(){
    $default_neuron_calculations = array(
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
    return $default_neuron_calculations;
}
?>
<?php

function value($n, $property, $min, $max)
{
	if ($property == 'Morphology')
	{
		if ($n == 0)
			$value = 'Hippocampal formation'; 
		if ($n == 1)	
			$value = 'DG'; 
		if ($n == 2)
			$value = 'DG:SMo'; 
		if ($n == 3)	
			$value = 'DG:SMi'; 
		if ($n == 4)	
			$value = 'DG:SG';
		if ($n == 5)	 
			$value = 'DG:H'; 
		if ($n == 6)	
			$value = 'CA3'; 
		if ($n == 7)	
			$value = 'CA3:SLM'; 
		if ($n == 8)	
			$value = 'CA3:SR'; 
		if ($n == 9)	
			$value = 'CA3:SL'; 
		if ($n == 10)
			$value = 'CA3:SP'; 
		if ($n == 11)	
			$value = 'CA3:SO';
		if ($n == 12)	
			$value = 'CA2';			 
		if ($n == 13)	
			$value = 'CA2:SLM';
		if ($n == 14)	 
			$value = 'CA2:SR'; 
		if ($n == 15)	
			$value = 'CA2:SP'; 
		if ($n == 16)	
			$value = 'CA2:SO'; 
		if ($n == 17)	
			$value = 'CA1'; 			
		if ($n == 18)	
			$value = 'CA1:SLM'; 
		if ($n == 19)		
			$value = 'CA1:SR';
		if ($n == 20)	
			$value = 'CA1:SP'; 
		if ($n == 21)	
			$value = 'CA1:SO';
		if ($n == 22)	
			$value = 'SUB'; 			
		if ($n == 23)	
			$value = 'SUB:SM'; 
		if ($n == 24)	  	
			$value = 'SUB:SP';
		if ($n == 25)	
			$value = 'SUB:PL';
		if ($n == 26)	
			$value = 'EC';			
		if ($n == 27)	
			$value = 'EC:I';
		if ($n == 28)	
			$value = 'EC:II';
		if ($n == 29)	
			$value = 'EC:III';
		if ($n == 30)	
			$value = 'EC:IV';
		if ($n == 31)	
			$value = 'EC:V';
		if ($n == 32)	
			$value = 'EC:VI';
	}

	if ($property == 'Electrophysiology')
	{
		$dif = $max - $min;
		$var = $dif / 10;
	
		if ($n == 0)
			$value = $min.' mV'; 
		if ($n == 1)	
			$value = $min + $var.' mV'; 
		if ($n == 2)
			$value = $min + (2*$var).' mV';  	
		if ($n == 3)
			$value = $min + (3*$var).' mV'; 
		if ($n == 4)	
			$value = $min + (4*$var).' mV'; 
		if ($n == 5)
			$value = $min + (5*$var).' mV'; 					
		if ($n == 6)
			$value = $min + (6*$var).' mV'; 
		if ($n == 7)	
			$value = $min + (7*$var).' mV'; 
		if ($n == 8)
			$value = $min + (8*$var).' mV';
		if ($n == 9)
			$value = $min + (9*$var).' mV'; 
		if ($n == 10)	
			$value = $max.' mV'; 										
	}
	if ($property == 'Firing Pattern')
	{
		if ($n == 0)
			$value = '0'; 
		if ($n == 1)
			$value = '1'; 
		if ($n == 2)	
			$value = '2'; 
		if ($n == 3)
			$value = '3'; 
		if ($n == 4)	
			$value = '4'; 
	}
	return $value;

}

// STM this is used on the ephys search page to generate
// electrophysiology values with the correct unit

function value_ephys($n, $property, $min, $max, $unit) {	
  $range = $max - $min;
  $step = $range / 10.;
  $value = ($min + $n * $step) . ' ' . $unit;
  return $value;
}


function value_fp_parameter($n, $property, $min, $max, $unit,$digit_precision) {	
  $range = $max - $min;
  $step = $range / 10.;
  $value = ($min + $n * $step) ;
  $value=number_format((float)$value,$digit_precision, '.', ''). ' ' . $unit;
  return $value;
}

function value_connectivity($n, $type) {	
	$id = $type->getID_array($n);
	$type -> retrive_by_id($id);
	$nickname_type = $type->getNickname();
	$subregion_type = $type->getSubregion();
	$value = $subregion_type . ":" . $nickname_type;
	return $value;
}
function getIndexOfParameter($parameter){
	$query_to_get_firing_pattern_parameter = "SELECT * FROM FiringPattern fp WHERE id=1";
	$rs_firing_pattern_parameter = mysqli_query($GLOBALS['conn'],$query_to_get_firing_pattern_parameter);	
	$firing_pattern=mysqli_fetch_array($rs_firing_pattern_parameter, MYSQLI_NUM);
	for($ind=0;$ind<(count($firing_pattern)) ;$ind++ ){	
		if($parameter==$firing_pattern[$ind])
			return $ind;
	}	
	return -1;			
}
function getUnitOfParameter($parameter_index){
	$query_to_get_firing_pattern_parameter_unit = "SELECT * FROM FiringPattern fp WHERE id=4";
	$rs_firing_pattern_parameter_unit = mysqli_query($GLOBALS['conn'],$query_to_get_firing_pattern_parameter_unit);	
	$firing_pattern_param_unit=mysqli_fetch_array($rs_firing_pattern_parameter_unit, MYSQLI_NUM);
	if($parameter_index>=0 and $parameter_index<count($firing_pattern_param_unit))
		return $firing_pattern_param_unit[$parameter_index];
	return "";			
}
function getDigitOfParameter($parameter_index){
	$query_to_get_firing_pattern_parameter_digit = "SELECT * FROM FiringPattern fp WHERE id=5";
	$rs_firing_pattern_parameter_digit = mysqli_query($GLOBALS['conn'],$query_to_get_firing_pattern_parameter_digit);	
	$firing_pattern_param_digit=mysqli_fetch_array($rs_firing_pattern_parameter_digit, MYSQLI_NUM);
	if($parameter_index>=0 and $parameter_index<count($firing_pattern_param_digit))
		return $firing_pattern_param_digit[$parameter_index];
	return "0";			
}
// partUniqueId
function partUniqueId()
{
	$part=array();
	$index=0;
	$query_to_get_unique_ids = "SELECT DISTINCT id FROM Type";
	$rs_unique_ids = mysqli_query($GLOBALS['conn'],$query_to_get_unique_ids);	
	while(list($unique_ids) = mysqli_fetch_row($rs_unique_ids))						
		$part[$index++] = $unique_ids;
	return $part;
}
?>

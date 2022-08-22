<?php
include("permission_check.php");
include("function/ephys_unit_table.php"); // Include unit table
include("function/ephys_num_decimals_table.php"); // Include num decimals table

//$research = $_REQUEST['research'];
$research = $_REQUEST['research'];
$table = $_REQUEST['table_result'];

// Define all the necessary classes needed for the application
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.epdataevidencerel.php');
require_once('class/class.epdata.php');
require_once('class/class.evidenceevidencerel.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.fragment.php');
require_once('class/class.temporary_result_neurons.php');

function getUrlForLink($id,$img,$key,$color1)
{
	$url = '';
	if ($img != '')
	{
		$url ='<a href="property_page_morphology.php?id_neuron='.$id.'&val_property='.$key.'&color='.$color1.'&page=markers" target="_blank">'.$img.'</a>';
	}
	return ($url);
}

function print_ephys_value_and_hover($param_str, $i, $number_type, $id_ephys2, $id_type, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2)
{
	include("function/ephys_unit_table.php");
	include("function/ephys_num_decimals_table.php");
	$num_decimals = $ephys_num_decimals_table[$param_str];
	$units = $ephys_unit_table[$param_str];
	if ($units == 'MOhm') {
		$units = 'M&Omega;';
	}
	if ($unvetted_ephys2[$param_str] == 1) {
		$color_unvetted = 'font4_unvetted';
	}
	else {
		$color_unvetted = 'font4';
	}
	if ($ephys2[$param_str] != NULL) {
		$formatted_value = number_format($ephys2[$param_str], $num_decimals, ".", "");
	}
	else {
		$formatted_value = NULL;
	}
	if ($gt_ephys2[$param_str]) {
		$gt_str = ">";
	}
	else {
		$gt_str = "";
	}
	if ($error_ephys2[$param_str] != 0) {
		$error_ephys2[$param_str] = number_format($error_ephys2[$param_str], $num_decimals,".","");
	}
	if ($value1_ephys2[$param_str] != 0) {
		$value1_ephys2[$param_str] = number_format($value1_ephys2[$param_str], $num_decimals,".","");
	}
	if ($value2_ephys2[$param_str] != 0) {
		$value2_ephys2[$param_str] = number_format($value2_ephys2[$param_str], $num_decimals,".","");
	}
	if ($param_str == 'sag_ratio') {
		$span_class_str = 'link_right';
	}
	else {
		$span_class_str = 'link_left';
	}
	if ($number_type - $i <= 4) {
		$span_class_str = $span_class_str . '_bottom';
	}
	$outputStr = '';
	if ($formatted_value != '') {
		// print value in matrix
		$outputStr = '<span class="'.$span_class_str.'"><a href="property_page_ephys.php?id_ephys='.$id_ephys2[$param_str].'&id_neuron='.$id_type.'&ep='.$param_str.'&page=1" target="_blank" class="'.$color_unvetted.'">' . $gt_str . $formatted_value;
		
		// print hover box
		//$print_str = $formatted_value . ' &plusmn; ' . $error_ephys2[$param_str] . ' ' . $units;
//		$print_str = '&plusmn;' . $value1_ephys2[$param_str] . ' ' . $units;
		if ($error_ephys2[$param_str] == NULL) {
			$print_str = ' [' . $value1_ephys2[$param_str] . ', ' . $value2_ephys2[$param_str] . '] ' . $units;
			if ($value2_ephys2[$param_str] == NULL) {
				$print_str = ' ' . $units;
			}
		}
		else if ($error_ephys2[$param_str] != 0) {
			$print_str = '&plusmn;' . $error_ephys2[$param_str] . ' ' . $units;
		}
		$print_str = $print_str . ' ' . $protocol_ephys2[$param_str];
		
		$outputStr.='<span class="' . $span_class_str . '">' . $print_str . '&#013;';
		$outputStr.='Measurements: ' . $tot_n1_ephys2[$param_str] . ' &#013;';
		$outputStr.='Representative value selected from ' . $nn_ephys2[$param_str] . ' source';
		if ($nn_ephys2[$param_str] > 1) {
			$outputStr.='s';
		}
		//if ($protocol_ephys2[$param_str] != '') {
		//	$outputStr.='&#013;' . $protocol_ephys2[$param_str];
		//}
		//else {
		//	$outputStr.='default conditions';
		//}
		$outputStr.='</span></a></span>';
	}
	return $outputStr;
}
// Check the UNVETTED color: ***************************************************************************
function check_unvetted1($id, $id_property, $evidencepropertyyperel) // $id = type_id,$id_property = propert_id,
{
	//echo " Type id: ".$id." Property Id : ".$id_property;
	$evidencepropertyyperel->retrive_unvetted($id, $id_property);
	$unvetted1 = $evidencepropertyyperel->getUnvetted();
	return ($unvetted1);
}
// *****************************************************************************************************
if (!isset($_GET['page']))
{
	$page = 1;
}
else
{
	$page = $_GET['page'];
}

//page=1&rows=5&sidx=1&sord=asc
// get how many rows we want to have into the grid - rowNum parameter in the grid
if (!isset($_GET['rows']))
{
	$limit = 176;
}
else
{
	$limit = $_GET['rows'];
}
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
if (!isset($_GET['sidx']))
{
	$sidx = 1;
}
else
{
	$sidx = $_GET['sidx'];
}
// sorting order - at first time sortorder
if (!isset($_GET['sord']))
{
	$sord = "asc";
}
else
{
	$sord = $_GET['sord'];
}
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
{
	$sidx = 1;
}
$type = new type($class_type);
//$research = $_GET['researchVar'];
if (isset($research)) // From page of search; retrieve the id from search_table (temporary) -----------------------
{
	$table_result = $_REQUEST['table_result'];
	$temporary_result_neurons = new temporary_result_neurons();
	$temporary_result_neurons->setName_table($table_result);
	
	$temporary_result_neurons->retrieve_id_array();
	$n_id_res = $temporary_result_neurons->getN_id();
	$number_type = 0;
	for ($i2=0; $i2<$n_id_res; $i2++)
	{
		$id2 = 	$temporary_result_neurons->getID_array($i2); // Retrieve  each ID corresponding to the id Array
		if (strpos($id2, '0_') != 1)
		{
			$type->retrive_by_id($id2); // For each Id  retrieve the type characteristics
			$status = $type->getStatus(); // Retrieve the status for each id
			if ($status == 'active')
			{
				$id_search[$number_type] = $id2;
				$position_search[$number_type] = $type->getPosition();
				$number_type = $number_type + 1;
			}
		}
	} // END $i2
	array_multisort($position_search, $id_search);
	// sort($id_search);
}
else // not from search page --------------
{
	if ($_GET['_search'] == 'false') // Condition to check ifthe 
	{
		$type->retrive_id();
		$number_type = $type->getNumber_type();
	}
	else
	{
		//Retrieve types by Search conditions
		//echo "Search ".$_GET['_search'];
		/* echo "Search Field : ".$_GET['searchField']; // � the name of the field defined in colModel
		echo "Search String : ".$_GET['searchString']; // � the string typed in the search field
		echo "Search Operator : ".$_GET['searchOper']; //� the operator choosen in the search field (ex. equal, greater than, �) */
	}
}
$property = new property($class_property);
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$epdataevidencerel = new epdataevidencerel($class_epdataevidencerel);
$evidenceevidencerel = new evidenceevidencerel($class_evidenceevidencerel);
$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);
$fragment = new fragment ($class_fragment);
$epdata = new epdata($class_epdata);

//$hippo_select = $_SESSION['hippo_select'];
$count = $number_type;

//echo "The number of elements are ".$count." and the limit is ".$limit;
if ($count <= $limit)
{
	$limit = $count;
}
// calculate the total pages for the query
if ($count > 0 && $limit > 0)
{
	$total_pages = ceil($count/$limit);
}
else
{
	$total_pages = 0;
}
// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) 
{
	$page=$total_pages;
}
// calculate the starting position of the rows
$start = $limit*$page - $limit;

// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if ($start < 0) 
{
	$start = 0;
}
$n_DG = 0;
$n_CA3 = 0;
$n_CA2 = 0;
$n_CA1 = 0;
$n_SUB = 0;
$n_EC = 0;

//header("Content-type: application/json;charset=utf-8");
$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

if ($research != "1")
{
	//$type->retieve_ordered_List($start,$limit);
	$type->retrive_id();
	$number_type = $type->getNumber_type();

	$type -> retrieve_id_by_subregion('DG');
	$nDG = $type->getNumber_subregion_type();
	$type -> retrieve_id_by_subregion('CA3');
	$nCA3 = $type->getNumber_subregion_type();
	$type -> retrieve_id_by_subregion('CA2');
	$nCA2 = $type->getNumber_subregion_type();
	$type -> retrieve_id_by_subregion('CA1');
	$nCA1 = $type->getNumber_subregion_type();
	$type -> retrieve_id_by_subregion('Sub');
	$nSub = $type->getNumber_subregion_type();
	$type -> retrieve_id_by_subregion('EC');
	$nEC = $type->getNumber_subregion_type();
}
$neuron = array("DG"=>'DG('.$nDG.')',"CA3"=>'CA3('.$nCA3.')',"CA3c"=>'CA3('.$nCA3.')',"CA2"=>'CA2('.$nCA2.')',"CA1"=>'CA1('.$nCA1.')',"Sub"=>'Sub('.$nSub.')',"EC"=>'EC('.$nEC.')');
//$neuron = array("DG"=>'DG(36)',"CA3"=>'CA3(35)',"CA3c"=>'CA3(35)',"CA2"=>'CA2(5)',"CA1"=>'CA1(60)',"Sub"=>'Sub(7)',"EC"=>'EC(33)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"Sub"=>'#FFCC33',"EC"=>'#336633');
$ephys = array("0"=>"Vrest", "1"=>"Rin","2"=>"tm","3"=>"Vthresh", "4"=>"fast_AHP",
		"5" =>"AP_ampl", "6" =>"AP_width", "7" =>"max_fr", "8" =>"slow_AHP", "9" =>"sag_ratio");
for ($i=0; $i<$number_type; $i++) //$number_type // Here he determines the number of active neuron types to print each row in the data table
{
	if (isset($id_search))
	{
		$id = $id_search[$i];	
	}
	else
	{
		$id = $type->getID_array($i);
	}
	$ephys2 = array("Vrest"=>NULL, "Rin"=>NULL,"tm"=>NULL, "Vthresh"=>NULL, "fast_AHP"=>NULL,
					"AP_ampl" =>NULL, "AP_width" =>NULL, "max_fr" =>NULL, "slow_AHP" =>NULL, "sag_ratio" =>NULL);
	$id_ephys2 = array("Vrest"=>NULL, "Rin"=>NULL,"tm"=>NULL, "Vthresh"=>NULL, "fast_AHP"=>NULL,
					"AP_ampl" =>NULL, "AP_width" =>NULL, "max_fr" =>NULL, "slow_AHP" =>NULL, "sag_ratio" =>NULL);
	$unvetted_ephys2 = array("Vrest"=>NULL, "Rin"=>NULL,"tm"=>NULL, "Vthresh"=>NULL, "fast_AHP"=>NULL,
					"AP_ampl" =>NULL, "AP_width" =>NULL, "max_fr" =>NULL, "slow_AHP" =>NULL, "sag_ratio" =>NULL);
	$soma_location = array("DG:SMo"=>0, "DG:SMi"=>1, "DG:SG"=>2, "DG:H"=>3, 
	                       "CA3:SLM"=>0, "CA3:SR"=>1, "CA3:SL"=>2, "CA3:SP"=>3, "CA3:SO"=>4, 
						   "CA2:SLM"=>0, "CA2:SR"=>1, "CA2:SP"=>2, "CA2:SO"=>3,
						   "CA1:SLM"=>0, "CA1:SR"=>1, "CA1:SP"=>2, "CA1:SO"=>3,
						   "SUB:SM"=>0, "SUB:SP"=>1, "SUB:PL"=>2, 
						   "EC:I"=>0, "EC:II"=>1, "EC:III"=>2, "EC:IV"=>3, "EC:V"=>4, "EC:VI"=>5);
 	$type->retrive_by_id($id); // Retrieve id
 	$nickname = $type->getNickname(); // Retrieve nick name
 	$position = $type->getPosition(); // Retrieve the position
 	$subregion = $type->getSubregion(); // Retrieve the sub region
	//$neurite_pattern_value = substr($name,6,4);
	
	$excit_inhib =$type-> getExcit_Inhib();
	$evidencepropertyyperel->retrive_Property_id_by_Type_id($id); // Retrieve distinct Property ids for each type id
	$n_property = $evidencepropertyyperel->getN_Property_id(); // Count of the number of properties for a given type id
	
	for($j=0 ; $j<$n_property ; $j++)  //To obtain soma location
	{
		$prop_id = $evidencepropertyyperel -> getProperty_id_array($j);
		$property->retrive_by_id($prop_id);
		$part1 = $property->getPart();
		$rel1 = $property->getRel();
		if(($property->getPart() == 'somata') && ($property->getRel() == 'in'))
		{
			$object_value = $property->getVal();
			$soma_position = $soma_location["$object_value"];
		}	
	}
	$q = 0;
	for ($i1=0; $i1<count($ephys); $i1++) // check for each name Eg. Vrest,Rin,tm etc..
	{
		$name_epys= $ephys[$i1]; // retrieve each property for the corresponding index value
		$property->retrive_ID(3, $name_epys, NULL, NULL); // Retrieve Id for a particular name_ephys
		$n_id_property = $property->getNumber_type(); // Retrive the count of property ids
		for ($ii2=0; $ii2<$n_id_property; $ii2++)
		{
			$tot_value = 0;
			$tot_n = 0;
			$tot_n_squared = 0;
			$weighted_sum = 0;
			$error_sum = 0;
			$final_value = 0;
			$n_Value = 0;
			$evidence_id = NULL;
			$property_id = $property->getProperty_id($ii2); // Get property id corresponding to a particular index
			// Keep only property_id related by id_type and retrieve id_evidence by these id:
			$evidencepropertyyperel->retrive_evidence_id($property_id, $id); // Retrive evidence ids for a particular property
			$nn = $evidencepropertyyperel->getN_evidence_id(); // get count of all evidences for a particular property id
			$nn_rep_value = 0;
			if ($nn != 0) // there are more VALUE1:
			{
				$max_n_measurement = 0;
				
				for ($t1=0; $t1<$nn; $t1++)
				{
					$evidence_id = $evidencepropertyyperel->getEvidence_id_array($t1); // At each index of the array get the Evidence id array
					$epdataevidencerel->retrive_Epdata($evidence_id); // For each evidence id retrive the EpdataId
					$epdata_id = $epdataevidencerel->getEpdata_id();
					$epdata->retrive_all_information($epdata_id); // Retrieve all information for a given epdata
					$rep_value = $epdata->getRep_value();
					
					// Borrowed from property_page_ephys.php ---------->
					// with evidence_id1 it needs to have evidence_id2 that is used for the id_article
					$evidenceevidencerel -> retrive_evidence2_id($evidence_id);
					$evidence_id_2 = $evidenceevidencerel -> getEvidence2_id_array(0);
		
					// retrieve information about fragment: --------------
					$evidencefragmentrel -> retrive_fragment_id_1($evidence_id_2);
					$id_fragment = $evidencefragmentrel -> getFragment_id();
					$fragment -> retrive_by_id($id_fragment);
					$page_loc = $fragment -> getPage_location();
					
					// Extract page_location and protocol
					$protoc = explode(",", $page_loc);
					$page_location=$protoc[0];
					
					//$locationValue1[$i1] = str_replace(' ', '', $locationValue[$i1]);
					//$location_protoc = explode(",", $locationValue1[$i1]);
					//$location_protocol = $location_protoc[1];
					//$location_animal = strpos($locationValue1[$i1],'mouse');					
					
					$protoc[1] = str_replace(' ', '', $protoc[1]);
					$protoc_pieces = explode("|", $protoc[1]);
					
					if($location_protocol == 'patchelectrode' && $protoc_pieces[1] != 'p')
					{
						$protoc_pieces[1] = 'p';
					}
					if($location_animal != null && $protoc_pieces[0] != 'm')
					{
						$protoc_pieces[0] = 'm';
					}
					// <---------- Borrowed from property_page_ephys.php

					$value1 = $epdata->getValue1(); // Retrieve value 1 for a give epdata id
					$value2 = $epdata->getValue2(); // Retrieve value 2 for a give epdata id
					$error = $epdata->getError(); // Retrieve error value for a given epdata id
					$gt_value = $epdata->getGt_value();
					$std_sem = $epdata->getStd_sem();

					$non_default_conditions_str = "";
					if ($rep_value != NULL)
					{
						$nn_rep_value += 1;
						
//						if (strpos($rep_value,'mice') !== false) {
						if ($protoc_pieces[0] == 'm'){
							$non_default_conditions_str = "(mice, ";
						}
						else {
							$non_default_conditions_str = "(rats, ";
						}
//						if (strpos($rep_value,'microelectrodes') !== false) {
						if ($protoc_pieces[1] == 'e'){
							$non_default_conditions_str = $non_default_conditions_str . "microelectrodes, ";
						}
						else {
							$non_default_conditions_str = $non_default_conditions_str . "patch clamp, ";
						}
//						if (strpos($rep_value,'room') !== false) {
						if ($protoc_pieces[3] == 'r'){
							$non_default_conditions_str = $non_default_conditions_str . "room temp)";
						}
						else {
							$non_default_conditions_str = $non_default_conditions_str . "body temp)";
						}

						// $value1 = $epdata->getValue1(); // Retrieve value 1 for a give epdata id
						// $value2 = $epdata->getValue2(); // Retrieve value 2 for a give epdata id
						// $error = $epdata->getError(); // Retrieve error value for a given epdata id
						// $gt_value = $epdata->getGt_value();
						// $std_sem = $epdata->getStd_sem();
						
						
						if ($value2) // if value 2 is set
						{
							$final_value = ($value1 + $value2) / 2; // final value for that particular evidence id is the mean
							//$final_value_array[$t1] = $final_value;
						}
						else
						{
							$final_value = $value1; // else final value for that evidence is value 1
							//$final_value_array[$t1] = $value1;
						}
						$n_measurement = $epdata->getN();
						if (!$n_measurement) // if n_measurement is not set
						{
							if ($value2) {
								$n_measurement = 2; // n default for a range is 2
							}
							else {
								$n_measurement = 1; // n_measurement is 1
							}
						}
						//$n_array[$t1] = $n_measurement;
						//$tot_value = $tot_value + $final_value; // Total value is calculated as the sum of all evidences
						//$tot_n = $tot_n + $n_measurement; // Total of all n values for evidences for a given property
						//$tot_n_squared = $tot_n_squared + pow($n_measurement,2); // Total of all (n*n) values for evidences for a given property
						//$weighted_sum = $weighted_sum + ($final_value * $n_measurement); // Product of final_value and n of all evidences for property
						//$error_sum += $error;
						
						// PICK THE REP VALUE WITH THE BIGGEST N (choose first one if tied)
						if ($n_measurement > $max_n_measurement) {
							$max_n_measurement = $n_measurement;
							$max_n_epdata_value = $final_value;
							
							$final_value_array[$t1] = $final_value;
							$n_array[$t1] = $n_measurement;
							
							if ($std_sem == 'sem') {
								$representative_error = $error*sqrt($n_measurement);
							}
							elseif ($std_sem == 'range' OR $std_sem == 'single_value') {
								$representative_error = NULL;
							}
							else {
								$representative_error = $error;
							}
							
							$max_n_statistics_strng = $representative_error;

							if ($gt_value != NULL) {
								$max_gt_flag = 1;
							}
							else{

								$max_gt_flag = 0;
							}
							
							$max_n_non_default_conditions_str = $non_default_conditions_str;
						}						
					}
					else
					{
						$final_value_array[$t1] = 0;
						$n_array[$t1] = 0;
					}
					
					
				}
				
				/*
				// calculate weighted mean
				if ($tot_n != 0) {
					$mean_value = $weighted_sum / $tot_n; // Calculate the mean for each property
				}
				else {
					$mean_value = -999999; // print a value to indicate an error; div by 0 
				}
				
				
				// calculated weighted variance				
				$weighted_var_sum = 0;
				for ($y2=0; $y2<$nn_rep_value; $y2++) {
					$weighted_var_sum = $weighted_var_sum + ($n_array[$y2] * pow($final_value_array[$y2] - $mean_value, 2));//calculate weighted variable sum
				}
				$weighted_var = $weighted_var_sum / $tot_n;
				$weighted_std = sqrt($weighted_var);
				*/
				
				//$ephys2[$name_epys] = $mean_value; // Store the mean value for each header name
				$id_ephys2[$name_epys] = $epdata_id; // Store the epdata id for each epdata
				$nn_ephys2[$name_epys] = $nn; // Store the n measurement for each header name
				$ephys2[$name_epys] = $max_n_epdata_value;
				$tot_n1_ephys2[$name_epys] = $max_n_measurement;
				$protocol_ephys2[$name_epys] = $max_n_non_default_conditions_str;
				$error_ephys2[$name_epys] = $max_n_statistics_strng;
				$gt_ephys2[$name_epys] = $max_gt_flag;
				$value1_ephys2[$name_epys] = $value1;
				$value2_ephys2[$name_epys] = $value2;
				//$nn_ephys2[$name_epys] = $nn_rep_value; // Store the n measurement for each header name
				//$tot_n1_ephys2[$name_epys] = $tot_n; // Store the total for each header name
				/*$weighted_std_ephys2[$name_epys] = $weighted_std; // Store the weighted standard deviation 
				if ($nn_rep_value > 0)
				{
					$weighted_std_ephys2[$name_epys] = $error_sum / $nn_rep_value;
				}
				else
				{
					$weighted_std_ephys2[$name_epys] = 0;
				}
				*/

			}
			// Check the UNVETTED color: ***************************************************************************
			$evidencepropertyyperel->retrive_unvetted($id, $property_id); // For a particular type and property id check if vetted or unvetted
			$unvetted = $evidencepropertyyperel->getUnvetted();
			$unvetted_ephys2[$name_epys] = $unvetted;
			$property_id_ephys2[$name_epys] = $property_id;
		}
	}

	if ($excit_inhib == 'e') {
		$fontColor='#339900';
	}
	elseif ($excit_inhib == 'i') {
		$fontColor='#CC0000';
	}
	
	preg_match('!\d+!',substr($type->getName(),strpos($type->getName(), ')')),$matches);
	$neurite_pattern=str_split($matches[0]);
	$new_neurite_pattern = str_replace($neurite_pattern[$soma_position], "<strong>".$neurite_pattern[$soma_position]."</strong>", $neurite_pattern);
	$neurite_pattern_new = implode('',$new_neurite_pattern);
	//print_r($neurite_pattern_new);
	
	if ($type->get_type_subtype($id) == 'subtype')
	{
		$fontColor='#000099';
		if ($excit_inhib == 'i')
			$fontColor='#CC5500';
		$rows[$i]['cell'] =
			array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>',
				"    ".'<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>',
				'<span style="color:black">'.$neurite_pattern_new.'</span>',
				print_ephys_value_and_hover('Vrest'    , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('Rin'      , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('tm'       , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('Vthresh'  , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('fast_AHP' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('AP_ampl'  , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('AP_width' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('max_fr'   , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('slow_AHP' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('sag_ratio', $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2) 
	  		); 
	}
	else
	{
		$rows[$i]['cell'] =
			array(	'<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>',
				'<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>',
				'<span style="color:black">'.$neurite_pattern_new.'</span>',
				print_ephys_value_and_hover('Vrest'    , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('Rin'      , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('tm'       , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('Vthresh'  , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('fast_AHP' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('AP_ampl'  , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('AP_width' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('max_fr'   , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('slow_AHP' , $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2),
	  			print_ephys_value_and_hover('sag_ratio', $i, $number_type, $id_ephys2, $id, $unvetted_ephys2, $ephys2, $nn_ephys2, $tot_n1_ephys2, $error_ephys2, $protocol_ephys2, $gt_ephys2, $value1_ephys2, $value2_ephys2) 
	  		); 
	}
	$responce->rows = $rows;
}
//echo json_encode($responce);
?>

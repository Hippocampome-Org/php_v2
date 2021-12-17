<?php
  include ("permission_check.php");
  include("function/stm_lib.php");
  //$research = $_REQUEST['research'];
  // Define all the necessary classes needed for the application
  require_once('class/class.type.php');
  require_once('class/class.property.php');
  require_once('class/class.evidencepropertyyperel.php');
  require_once('class/class.temporary_result_neurons.php');
  // total parcles in layers in morphology
  define('NO_CONNECTION',0);
  define('P_INHIBITORY_CONN',1);
  define('P_EXCITATORY_CONN',2);
  define('NON_PRESENT',0);

  define('DENDRITES_PRESENT',2);
  define('AXONS_PRESENT',1);
  define('AXONS_DENDRITES_PRESENT',3);
  define('ONLY_SOMA_PRESENT',4);

  define('AXONS_SOMA_PRESENT',14);
  define('DENDRITES_SOMA_PRESENT',24);
  define('AXONS_DENDRITES_SOMA_PRESENT',34);
$research = $_REQUEST['research'];
$table = $_REQUEST['table_result'];
// $h = fopen('log_test.txt', 'a');
// fwrite($h, 'In getmorphology.php \n');
// fclose($h);
/* if(isset($research))
	echo "Research variable Set !";
 */
// Check the UNVETTED color: ***************************************************************************
function check_unvetted1($id, $id_property, $evidencepropertyyperel) // $id = type_id,$id_property = propert_idy,
{

	$evidencepropertyyperel -> retrive_unvetted($id, $id_property);
	$unvetted1 = $evidencepropertyyperel -> getUnvetted();
	return ($unvetted1);
}
// *****************************************************************************************************

//*******************************Changes to handle somata evidence**************************************
function check_color_somata($id,$type, $unvetted,$val,$part){
	$soma_location_check_somata="SELECT DISTINCT p.subject, p.object
      FROM EvidencePropertyTypeRel eptr
      JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id)
      WHERE predicate = 'in' AND object REGEXP ':'AND eptr.Type_id = '$id' AND subject = 'somata';";
	
	$soma_location_check_axons="SELECT DISTINCT p.subject, p.object
      FROM EvidencePropertyTypeRel eptr
      JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id)
      WHERE predicate = 'in' AND object REGEXP ':'AND eptr.Type_id = '$id' AND subject = 'axons';";
	
	$soma_location_check_dendrites="SELECT DISTINCT p.subject, p.object
      FROM EvidencePropertyTypeRel eptr
      JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id)
      WHERE predicate = 'in' AND object REGEXP ':'AND eptr.Type_id = '$id' AND subject = 'dendrites';";
	
	$result_somata = mysqli_query($GLOBALS['conn'],$soma_location_check_somata);
	$result_axons = mysqli_query($GLOBALS['conn'],$soma_location_check_axons);
	$result_dendrites = mysqli_query($GLOBALS['conn'],$soma_location_check_dendrites);
	$axons_dendrites_check=0;
	
	while(list($subject,$object) = mysqli_fetch_row($result_axons)){
		if($subject=='axons' && $object==$val){
			$axons_dendrites_check=1;
			break;
		}
	}
	
	while(list($subject,$object) = mysqli_fetch_row($result_dendrites)){
		if($subject=='dendrites' && $object==$val){
			$axons_dendrites_check=1;
			break;
		}
	}
	
	$flag=0;
//	if($axons_dendrites_check!=1){
		while(list($subject,$object) = mysqli_fetch_row($result_somata)){
			if($subject=='somata' && $object==$val){
				
				$flag=1;
				break;
			}
		}
//	}
	
	 if ($type == 'somata'){
			if($flag==1)
				$link[0] = "<img src='images/morphology/neuron_soma.png' border='0'/>";
                $link[1]='somata';
		}
	
	return ($link);
}


function check_color($id,$type, $unvetted,$val,$part) //$type --> whether axons/dendrites or both
{
	$soma_location_check="SELECT DISTINCT p.subject, p.object
      FROM EvidencePropertyTypeRel eptr
      JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id)
      WHERE predicate = 'in' AND object REGEXP ':'AND eptr.Type_id = '$id' AND subject = 'somata';";
	
	$result = mysqli_query($GLOBALS['conn'],$soma_location_check);
	$flag=0;
	while(list($subject,$object) = mysqli_fetch_row($result)){
		if($subject=='somata' && $object==$val){
			$flag=1;
			break;
		}
	}
	if ($type == 'axons')
	{
		if ($unvetted == 1){
			$link[0] = "<img src='images/morphology/axons_present_unvetted.png' border='0'/>";
			$link[1] = 'red';
		}
		else{
			if($flag==1){
				$link[0] = "<img src='images/morphology/axons_present_soma.png' border='0'/>";
				$link[1] = 'redSoma';
				
			}
			else{
				$link[0] = "<img src='images/morphology/axons_present.png' border='0'/>";
				$link[1] = 'red';
			}
		}
		// $link[1] = 'red';
	}
	else if ($type == 'dendrites')
	{
		if ($unvetted == 1){
			$link[0] = "<img src='images/morphology/dendrites_present_unvetted.png' border='0'/>";
			$link[1] = 'blue';
		}
		else{
			if($flag==1){
				$link[0] = "<img src='images/morphology/dendrites_present_soma.png' border='0'/>";
				$link[1] = 'blueSoma';
			}
			else{
				$link[0] = "<img src='images/morphology/dendrites_present.png' border='0'/>";
				$link[1] = 'blue';
				
			}
		}
		
	}
	else if ($type == 'both')
	{
		//echo "Should come here";
		if ($unvetted == 1){
			$link[0] = "<img src='images/morphology/somata_present_unvetted.png' border='0'/>";
			$link[1] = 'violet';
		}
		else{
			if($flag==1)
			{
				$link[0] = "<img src='images/morphology/somata_present_soma.png' border='0'/>";
			    $link[1] = 'violetSoma';
			}
		
				
		else {
			$link[0] = "<img src='images/morphology/somata_present.png' border='0'/>";
		    $link[1] = 'violet';
		}

	}
	}
	return ($link);
}
// check for link
/*  
 * $id - Type id
 * $img - img path
 * $key - DG_Smo For Type SMo 0f DG
 * $color - red/blue or violet 
 * */
function getUrlForLink($id,$img,$key,$color1) 
{
	
	$url = '';
	if($color1!=''){
		if($img!='')
		{
			$url ='<a href="property_page_morphology.php?id_neuron='.$id.'&val_property='.$key.'&color='.$color1.'&page=1" target="_blank">'.$img.'</a>';	
		}
	}
	else{
	if($img!='')
		{
			//$url =$img;
             $url ='<a href="property_page_morphology.php?id_neuron='.$id.'&val_property='.$key.'&color=somata&page=1" target="_blank">'.$img.'</a>';			
		}
	}
	return ($url);	
}
if(!isset($_GET['page'])) $page=1;
else $page = $_GET['page'];
//page=1&rows=5&sidx=1&sord=asc
// get how many rows we want to have into the grid - rowNum parameter in the grid
if(!isset($_GET['rows'])) $limit=122;
else $limit = $_GET['rows'];

// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
if(!isset($_GET['sidx'])) $sidx=1;
else $sidx = $_GET['sidx'];

// sorting order - at first time sortorder
if(!isset($_GET['sord'])) $sord="asc";
else $sord = $_GET['sord'];

// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1;

$type = new type($class_type);
//$research = 0;
/* if(isset($research)
	$research = $_GET['researchVar']; */
if (isset($research)) // From page of search; retrieve the id from search_table (temporary) -----------------------
{
	$table_result = $_REQUEST['table_result'];
	$temporary_result_neurons = new temporary_result_neurons();
	$temporary_result_neurons -> setName_table($table_result);
	
	$temporary_result_neurons -> retrieve_id_array();
	$n_id_res = $temporary_result_neurons -> getN_id();
	$number_type = 0;
	for ($i2=0; $i2<$n_id_res; $i2++)
	{
		$id2 = 	$temporary_result_neurons -> getID_array($i2); // Retrieve  each ID corresponding to the id Array

		if (strpos($id2, '0_') == 1);
		else
		{
			$type -> retrive_by_id($id2); // For each Id  retrieve the type characteristics
			$status = $type -> getStatus(); // Retrieve the status for each id
				
			if ($status == 'active')
			{
				$id_search[$number_type] = $id2;
				$position_search[$number_type] = $type -> getPosition();
				$number_type = $number_type + 1;
			}
		}
	} // END $i2

	array_multisort($position_search, $id_search);
	// sort($id_search);
}
else // not from search page --------------
{
		if($_GET['_search']=='false') // Condition to check ifthe 
		{
			$type -> retrive_id();
			$number_type = $type->getNumber_type();
		}
		else{
			//Retrieve types by Search conditions

			//echo "Search ".$_GET['_search'];
			/* echo "Search Field : ".$_GET['searchField']; // – the name of the field defined in colModel
			echo "Search String : ".$_GET['searchString']; // – the string typed in the search field
			echo "Search Operator : ".$_GET['searchOper']; //– the operator choosen in the search field (ex. equal, greater than, …) */
				
		}
}

$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

//$hippo_select = $_SESSION['hippo_select'];
$count = $number_type;
//echo "The number of elements are ".$count." and the limit is ".$limit;
if($count <= $limit)
	$limit = $count;

// calculate the total pages for the query
if( $count > 0 && $limit > 0) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}

// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) 
	$page=$total_pages;

// calculate the starting position of the rows
$start = $limit*$page - $limit;

// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if($start <0) 
	$start = 0;

$n_DG = 0;
$n_CA3 = 0;
$n_CA2 = 0;
$n_CA1 = 0;
$n_SUB = 0;
$n_EC = 0;

//header("Content-type: application/json;charset=utf-8");
$responce = (object) array('page' => 1, 'total' => $total_pages, 'records' =>$count, 'rows' => "", 'potential_array' =>$pon_conn_display_array, 'potn_conn_neuron_pcl_array' =>$potn_conn_neuron_pcl);

//$responce->page = $page;
//$responce->total = $total_pages;
$responce->records = $count; 

if($research!="1")
{
	//$type -> retieve_ordered_List($start,$limit);
	$type -> retrive_id();
	$number_type = $type->getNumber_type();
}
$neuron = array("DG"=>'DG(18)',"CA3"=>'CA3(25)',"CA3c"=>'CA3(25)',"CA2"=>'CA2(5)',"CA1"=>'CA1(42)',"SUB"=>'SUB(3)',"EC"=>'EC(31)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');
for ($i=0; $i<$number_type; $i++) //$number_type // Here he determines the number of active neuron types to print each row in the data table
{

	// Array to store each neuron property
	$hippo = array("DG:SMo"=>'',"DG:SMi"=>'',"DG:SG"=>'',"DG:H"=>'',
			"CA3:SLM" =>'', "CA3:SR" =>'', "CA3:SL" =>'', "CA3:SP" =>'', "CA3:SO" =>'',
			"CA2:SLM" =>'', "CA2:SR" =>'', "CA2:SP" =>'', "CA2:SO" =>'',
			"CA1:SLM" =>'', "CA1:SR" =>'', "CA1:SP" =>'', "CA1:SO" =>'',
			"SUB:SM" =>'', "SUB:SP" =>'', "SUB:PL" =>'',
			"EC:I" =>'', "EC:II" =>'', "EC:III" =>'', "EC:IV" =>'', "EC:V" =>'', "EC:VI" =>'' );
	
	// Color array for each property depending on Axon,Dendrite or both being present
	$hippo_color = array("DG:SMo"=>'',"DG:SMi"=>'',"DG:SG"=>'',"DG:H"=>'',
			"CA3:SLM" =>'', "CA3:SR" =>'', "CA3:SL" =>'', "CA3:SP" =>'', "CA3:SO" =>'',
			"CA2:SLM" =>'', "CA2:SR" =>'', "CA2:SP" =>'', "CA2:SO" =>'',
			"CA1:SLM" =>'', "CA1:SR" =>'', "CA1:SP" =>'', "CA1:SO" =>'',
			"SUB:SM" =>'', "SUB:SP" =>'', "SUB:PL" =>'',
			"EC:I" =>'', "EC:II" =>'', "EC:III" =>'', "EC:IV" =>'', "EC:V" =>'', "EC:VI" =>'' );
		$hippo_color_copy=$hippo_color;
		if(isset($id_search))
			$id = $id_search[$i];	
		else
	 		$id = $type->getID_array($i);
	 
	 $type -> retrive_by_id($id); // Retrieve id
	 $nickname = $type->getNickname(); // Retrieve nick name
	 $position = $type->getPosition(); // Retrieve the position
	 $subregion = $type -> getSubregion(); // Retrieve the sub region
	 $excit_inhib =$type-> getExcit_Inhib();//Retrieve the Excit or Inhib
	
	$evidencepropertyyperel -> retrive_Property_id_by_Type_id($id); // Retrieve properties for each Type id
	
	$n_property_id = $evidencepropertyyperel -> getN_Property_id(); // retrieve a count of the total number of property ids
	
	$q=0;
	for ($i5=0; $i5<$n_property_id; $i5++) // For Each Property id he derives by using an Index
	{
		$Property_id = $evidencepropertyyperel -> getProperty_id_array($i5); // Retrieve the property to the corresponding index passed
		$property -> retrive_by_id($Property_id); // For a property id derived as above,retrieve its corresponding properties
		$rel = $property->getRel(); // Retrieve Predicate (from the property table)
		$part1 = $property->getPart(); // Retrieve Subject (from the property table)
	
		if (($rel == 'in'))
	//	if (($rel == 'in') && ($part1 != 'somata')) // Why are we eliminating Somata in ?
		{
			$id_p[$q] = $property->getID();
			$val[$q] = $property->getVal();  // Get the Object
			$part[$q] = $property->getPart();  // Get the Subject
			$q = $q+1;
		}
	}
	for ($ii=0; $ii<$q; $ii++) // For all the preperties derieved check the required conditions
	{
		if($part[$ii]!='somata')
		{		
			$val_array=explode(':', $val[$ii]); // Check the object from the property index
			// DG +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if(count($val_array) > 1) // To check if the explode has returned both the postfix value and the prefix value
			{
				$unvetted = check_unvetted1($id, $id_p[$ii], $evidencepropertyyperel); // Checks if a particular property is vetted or unvetted
				$neuronType = ''; // Whether neuron present is Axon,Dendrite or Both
		//		if($hippo[$val[$ii]]!='') // Check if for a particular property , the associated value 
				if($hippo_color[$val[$ii]]!='')
				{
					$neuronType ='both';
					/* $img = check_color('both', $unvetted);
					$hippo[$val[$ii]] = $img[0]; */
				}
				else{
					if ($part[$ii] == 'axons')
						$neuronType ='axons';
						//$hippo[$val[$ii]] ='<img src=images/morphology/axons_present.png>';
					else
						$neuronType ='dendrites';
						//$hippo[$val[$ii]] ='<img src=images/morphology/dendrites_present.png>';
				}
				 $img = check_color($id,$neuronType, $unvetted,$val[$ii],$part[$ii]);
				 $hippo[$val[$ii]] = $img[0];
				 $hippo_color[$val[$ii]] = $img[1];
				 $hippo_color_copy[$val[$ii]]=$img[1]; 
			} 
		}
		if($part[$ii]=='somata'){	
			$val_array=explode(':', $val[$ii]);
			if(count($val_array) > 1) // To check if the explode has returned both the postfix value and the prefix value
			{
				$unvetted = check_unvetted1($id, $id_p[$ii], $evidencepropertyyperel); // Checks if a particular property is vetted or unvetted
				$neuronType ='somata';
				$img_somata = check_color_somata($id,$neuronType, $unvetted,$val[$ii],$part[$ii]);
				if($img_somata!=''){
				 	$hippo[$val[$ii]] = $img_somata[0];
                    //$hippo_color[$val[$ii]] = $img_somata[1];	
                    $hippo_color_copy[$val[$ii]] = 'pcl_soma';
			        if($val[$ii]=='DG:SG' || $val[$ii]=='CA3:SP' || $val[$ii]=='CA2:SP' || $val[$ii]=='CA1:SP' || $val[$ii]=='SUB:SP')
			        {
			            $soma_pcl[$id]=$val[$ii];
			            $soma_ids[$i]=$id;
			        	}	
				} 
			}
		}
		$hippo_color_new[$i]=$hippo_color_copy;
	}
//	if (strpos($nickname, '(+)') == TRUE)
	if ($excit_inhib == 'e')
		$fontColor='#339900';
//	if (strpos($nickname, '(-)') == TRUE)
	if ($excit_inhib == 'i')
		$fontColor='#CC0000';

	if ($type->get_type_subtype($id) == 'subtype')
	{
		$fontColor='#000099';
		if ($excit_inhib == 'i')
			$fontColor='#CC5500';
		$rows[$i]['cell']=array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>',"    ".'<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>',$type->retrieve_supertype($id),
				getUrlForLink($id,$hippo['DG:SMo'],'DG_SMo',$hippo_color['DG:SMo']),
				getUrlForLink($id,$hippo['DG:SMi'],'DG_SMi',$hippo_color['DG:SMi']),
				getUrlForLink($id,$hippo['DG:SG'],'DG_SG',$hippo_color['DG:SG']),
				getUrlForLink($id,$hippo['DG:H'],'DG_H',$hippo_color['DG:H']),
				getUrlForLink($id,$hippo['CA3:SLM'],'CA3_SLM',$hippo_color['CA3:SLM']),
				getUrlForLink($id,$hippo['CA3:SR'],'CA3_SR',$hippo_color['CA3:SR']),
				getUrlForLink($id,$hippo['CA3:SL'],'CA3_SL',$hippo_color['CA3:SL']),
				getUrlForLink($id,$hippo['CA3:SP'],'CA3_SP',$hippo_color['CA3:SP']),
				getUrlForLink($id,$hippo['CA3:SO'],'CA3_SO',$hippo_color['CA3:SO']),
				getUrlForLink($id,$hippo['CA2:SLM'],'CA2_SLM',$hippo_color['CA2:SLM']),
				getUrlForLink($id,$hippo['CA2:SR'],'CA2_SR',$hippo_color['CA2:SR']),
				getUrlForLink($id,$hippo['CA2:SP'],'CA2_SP',$hippo_color['CA2:SP']),
				getUrlForLink($id,$hippo['CA2:SO'],'CA2_SO',$hippo_color['CA2:SO']),
				getUrlForLink($id,$hippo['CA1:SLM'],'CA1_SLM',$hippo_color['CA1:SLM']),
				getUrlForLink($id,$hippo['CA1:SR'],'CA1_SR',$hippo_color['CA1:SR']),
				getUrlForLink($id,$hippo['CA1:SP'],'CA1_SP',$hippo_color['CA1:SP']),
				getUrlForLink($id,$hippo['CA1:SO'],'CA1_SO',$hippo_color['CA1:SO']),
				getUrlForLink($id,$hippo['SUB:SM'],'SUB_SM',$hippo_color['SUB:SM']),
				getUrlForLink($id,$hippo['SUB:SP'],'SUB_SP',$hippo_color['SUB:SP']),
				getUrlForLink($id,$hippo['SUB:PL'],'SUB_PL',$hippo_color['SUB:PL']),
				getUrlForLink($id,$hippo['EC:I'],'EC_I',$hippo_color['EC:I']),
				getUrlForLink($id,$hippo['EC:II'],'EC_II',$hippo_color['EC:II']),
				getUrlForLink($id,$hippo['EC:III'],'EC_III',$hippo_color['EC:III']),
				getUrlForLink($id,$hippo['EC:IV'],'EC_IV',$hippo_color['EC:IV']),
				getUrlForLink($id,$hippo['EC:V'],'EC_V',$hippo_color['EC:V']),
				getUrlForLink($id,$hippo['EC:VI'],'EC_VI',$hippo_color['EC:VI']),
				);
	}
	else
	{
		$rows[$i]['cell']=array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>','<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>',$type->retrieve_supertype($id),
				getUrlForLink($id,$hippo['DG:SMo'],'DG_SMo',$hippo_color['DG:SMo']),
				getUrlForLink($id,$hippo['DG:SMi'],'DG_SMi',$hippo_color['DG:SMi']),
				getUrlForLink($id,$hippo['DG:SG'],'DG_SG',$hippo_color['DG:SG']),
				getUrlForLink($id,$hippo['DG:H'],'DG_H',$hippo_color['DG:H']),
				getUrlForLink($id,$hippo['CA3:SLM'],'CA3_SLM',$hippo_color['CA3:SLM']),
				getUrlForLink($id,$hippo['CA3:SR'],'CA3_SR',$hippo_color['CA3:SR']),
				getUrlForLink($id,$hippo['CA3:SL'],'CA3_SL',$hippo_color['CA3:SL']),
				getUrlForLink($id,$hippo['CA3:SP'],'CA3_SP',$hippo_color['CA3:SP']),
				getUrlForLink($id,$hippo['CA3:SO'],'CA3_SO',$hippo_color['CA3:SO']),
				getUrlForLink($id,$hippo['CA2:SLM'],'CA2_SLM',$hippo_color['CA2:SLM']),
				getUrlForLink($id,$hippo['CA2:SR'],'CA2_SR',$hippo_color['CA2:SR']),
				getUrlForLink($id,$hippo['CA2:SP'],'CA2_SP',$hippo_color['CA2:SP']),
				getUrlForLink($id,$hippo['CA2:SO'],'CA2_SO',$hippo_color['CA2:SO']),
				getUrlForLink($id,$hippo['CA1:SLM'],'CA1_SLM',$hippo_color['CA1:SLM']),
				getUrlForLink($id,$hippo['CA1:SR'],'CA1_SR',$hippo_color['CA1:SR']),
				getUrlForLink($id,$hippo['CA1:SP'],'CA1_SP',$hippo_color['CA1:SP']),
				getUrlForLink($id,$hippo['CA1:SO'],'CA1_SO',$hippo_color['CA1:SO']),
				getUrlForLink($id,$hippo['SUB:SM'],'SUB_SM',$hippo_color['SUB:SM']),
				getUrlForLink($id,$hippo['SUB:SP'],'SUB_SP',$hippo_color['SUB:SP']),
				getUrlForLink($id,$hippo['SUB:PL'],'SUB_PL',$hippo_color['SUB:PL']),
				getUrlForLink($id,$hippo['EC:I'],'EC_I',$hippo_color['EC:I']),
				getUrlForLink($id,$hippo['EC:II'],'EC_II',$hippo_color['EC:II']),
				getUrlForLink($id,$hippo['EC:III'],'EC_III',$hippo_color['EC:III']),
				getUrlForLink($id,$hippo['EC:IV'],'EC_IV',$hippo_color['EC:IV']),
				getUrlForLink($id,$hippo['EC:V'],'EC_V',$hippo_color['EC:V']),
				getUrlForLink($id,$hippo['EC:VI'],'EC_VI',$hippo_color['EC:VI']),
				);
	}
	$responce->rows = $rows;
}

//Procees to get the potential connectivity matrix
/*Legend  for $pot_conn_array
0-blank
1-axon
2-dedrites
3-axon and Dendrite
4-soma present
*/
// array to hold parcels
$col_array=array("DG:SMo","DG:SMi","DG:SG","DG:H","CA3:SLM","CA3:SR","CA3:SL","CA3:SP","CA3:SO","CA2:SLM","CA2:SR","CA2:SP","CA2:SO","CA1:SLM","CA1:SR","CA1:SP","CA1:SO","SUB:SM","SUB:SP","SUB:PL","EC:I","EC:II","EC:III","EC:IV","EC:V","EC:VI");
$layer_col_count=count($col_array);

// find type of property present for each type in parcels
for ($i=0; $i < $number_type ; $i++) {
  for ($j=0; $j < $layer_col_count; $j++) {
    if($hippo_color_new[$i][$col_array[$j]]=='blue')
    {
      $pot_conn_array[$i][$j]=DENDRITES_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='blueSoma') {
      $pot_conn_array[$i][$j]=DENDRITES_SOMA_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='red') {
      $pot_conn_array[$i][$j]=AXONS_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='redSoma') {
      $pot_conn_array[$i][$j]=AXONS_SOMA_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='violet') {
      $pot_conn_array[$i][$j]=AXONS_DENDRITES_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='violetSoma') {
      $pot_conn_array[$i][$j]=AXONS_DENDRITES_SOMA_PRESENT;
    }
    elseif ($hippo_color_new[$i][$col_array[$j]]=='pcl_soma') {
      $pot_conn_array[$i][$j]=ONLY_SOMA_PRESENT;
    }
    else {
      $pot_conn_array[$i][$j]=NON_PRESENT;
    }
  }
}


//Computation for the potential connec array creation
/*LEGEND for $pon_conn_display_array:
0-blank
1-gray -Potential Inhibitory Connections
2-black --Potential Excitatory Connections
*/

//special case neuron types
$special_case_basket = "SELECT id FROM Type WHERE id in (SELECT DISTINCT Type_id FROM EvidencePropertyTypeRel
WHERE perisomatic_targeting_flag=2) ORDER BY position";
$result_special_case_basket = mysqli_query($GLOBALS['conn'], $special_case_basket);
$special_neuron_id_basket = result_set_to_array($result_special_case_basket, 'id');

// query to get axonic types
$special_case_axo_axonic = "SELECT id FROM Type WHERE id in (SELECT DISTINCT Type_id FROM EvidencePropertyTypeRel
WHERE perisomatic_targeting_flag=1) ORDER BY position";
$result_special_case_axo_axonic = mysqli_query($GLOBALS['conn'], $special_case_axo_axonic);
$special_neuron_id_axo_axonic = result_set_to_array($result_special_case_axo_axonic, 'id');

// query to get pc and soma_pcl flag associated with all types
// portions of the query that formerly accessed the mec_lec and is flags have been removed 03/26/2020 DWW
$query_pc_and_somapcl_flag="SELECT DISTINCT e.Type_id,e.pc_flag,e.soma_pcl_flag 
FROM EvidencePropertyTypeRel e, Type t
WHERE t.id=e.Type_id and e.pc_flag is not null and e.soma_pcl_flag is not null
GROUP BY t.id
ORDER BY t.position";
$result_pc_and_somapcl_flag = mysqli_query($GLOBALS['conn'], $query_pc_and_somapcl_flag);

$index=0;
if (!$result_pc_and_somapcl_flag) {
    print("<p>Error occured in Listing Connectivity Records.</p>");
}
// store pc and soma pcl flag values for each type in pc_flag and soma_pcl_flag_array.
// mec_lec and is flag-related code has been commented out 03/26/2020 DWW
while($row=mysqli_fetch_array($result_pc_and_somapcl_flag, MYSQLI_ASSOC))
{
    $pc_flag = $row['pc_flag'];
    $soma_pcl_flag=$row['soma_pcl_flag'];
//    $mec_lec_flag = $row['mec_lec_flag'];
//    $is_flag = $row['is_flag'];
    $pc_flag_array[$index]=$pc_flag;
    $soma_pcl_flag_array[$index]=$soma_pcl_flag;
//    $mec_lec_flag_array[$index]=$mec_lec_flag;
//    $is_flag_array[$index] = $is_flag;
    $index++;   
}

// @nmsutton This is where a new query of TypeTypeRel accessing connection_status needs to be written

// Initialize connectivity display array to zero
for ($i=0; $i < $number_type; $i++) {
  for ($j=0; $j < $number_type; $j++) {
    $pon_conn_display_array[$i][$j]=0;
    $potn_conn_neuron_pcl[$i][$j]="";
    $connection_status_array[$i][$j] = "";
  }
}

$connection_status_query = "SELECT Type1_id, Type2_id, connection_status FROM TypeTypeRel;";
$connection_status_result = mysqli_query($GLOBALS['conn'],$connection_status_query);
while(list($Type1_id,$Type2_id,$connection_status) = mysqli_fetch_row($connection_status_result)){
	$connection_status_array[$Type1_id][$Type2_id] = $connection_status;
}

// create map
$color_map=array(AXONS_PRESENT => "red",AXONS_SOMA_PRESENT => "redSoma",DENDRITES_PRESENT => "blue",DENDRITES_SOMA_PRESENT => "blueSoma",
AXONS_DENDRITES_PRESENT => "violet",AXONS_DENDRITES_SOMA_PRESENT => "violetSoma", ONLY_SOMA_PRESENT=> "somata");
// create connectivity matrix using morphology data
for ($i = 0; $i < $number_type; $i++) {
    if (isset($id_search))
        $id = $id_search[$i];
    else
        $id = $type->getID_array($i);

    $type->retrive_by_id($id); // Retrieve id
    $excit_inhib = $type->getExcit_Inhib(); //Retrieve the Excit or Inhib
    if (!(in_array($id, $special_neuron_id_basket) or in_array($id, $special_neuron_id_axo_axonic))){
		for ($j = 0; $j < $layer_col_count; $j++) {
			if ($pot_conn_array[$i][$j] == AXONS_PRESENT || $pot_conn_array[$i][$j] == AXONS_DENDRITES_PRESENT || $pot_conn_array[$i][$j] == AXONS_SOMA_PRESENT || $pot_conn_array[$i][$j] == AXONS_DENDRITES_SOMA_PRESENT) {
				$src_column = $j;
				for ($k = 0; $k < $number_type; $k++) {
					if ($pot_conn_array[$k][$src_column] == DENDRITES_PRESENT || $pot_conn_array[$k][$src_column] == DENDRITES_SOMA_PRESENT || $pot_conn_array[$k][$src_column] == AXONS_DENDRITES_PRESENT || $pot_conn_array[$k][$src_column] == AXONS_DENDRITES_SOMA_PRESENT) {
						if ($excit_inhib == "i" && $pon_conn_display_array[$i][$k]==0) {
						    $pon_conn_display_array[$i][$k] = P_INHIBITORY_CONN; //gray
						    // Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_INHIBITORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;
						    
						} elseif($excit_inhib == "e" && $pon_conn_display_array[$i][$k]==0) {
							$pon_conn_display_array[$i][$k] = P_EXCITATORY_CONN; //black

							// Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_EXCITATORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;
						}
					}
					if ($i == $k && ($pot_conn_array[$i][$j] == AXONS_DENDRITES_PRESENT || $pot_conn_array[$i][$j] == AXONS_DENDRITES_SOMA_PRESENT)) {
						if ($excit_inhib == "i" && $pon_conn_display_array[$i][$k]==0) {
							$pon_conn_display_array[$i][$k] = P_INHIBITORY_CONN; //gray

							// Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_INHIBITORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;

						} else if ($excit_inhib == "e" && $pon_conn_display_array[$i][$k]==0) {
							$pon_conn_display_array[$i][$k] = P_EXCITATORY_CONN; //black

							// Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_EXCITATORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;

						}
					}
				}
			}
			/*
			// code for potential connections
			if ($connection_status_array[$i][$j]=='negative') {
				$pon_conn_display_array[$i][$k] = P_INHIBITORY_CONN;
			}
			else if ($connection_status_array[$i][$j]=='positive') {
				$pon_conn_display_array[$i][$k] = P_EXCITATORY_CONN;
			}
			else if ($connection_status_array[$i][$j]=='potential') {
				$pon_conn_display_array[$i][$k] = P_EXCITATORY_CONN;
			}
			*/
		}
	}
	// check axon to soma link for axonic and basket neurons
	else{
		for ($j = 0; $j < $layer_col_count; $j++) {
			$src_column = $j;
		    if ($pot_conn_array[$i][$src_column] == AXONS_PRESENT || $pot_conn_array[$i][$src_column] == AXONS_DENDRITES_PRESENT || $pot_conn_array[$i][$src_column] == AXONS_SOMA_PRESENT || $pot_conn_array[$i][$src_column] == AXONS_DENDRITES_SOMA_PRESENT) { 
		        for ($k = 0; $k < $number_type; $k++) {
		            if ($pot_conn_array[$k][$src_column] == ONLY_SOMA_PRESENT || $pot_conn_array[$k][$src_column] == DENDRITES_SOMA_PRESENT || $pot_conn_array[$k][$src_column] == AXONS_SOMA_PRESENT || $pot_conn_array[$k][$src_column] == AXONS_DENDRITES_SOMA_PRESENT) {
						if ($excit_inhib == "i" && $pon_conn_display_array[$i][$k]==0) {
						  $pon_conn_display_array[$i][$k] = P_INHIBITORY_CONN; //gray

						  // Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_INHIBITORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;
/* This code has been commented out because axo-axonic and basket connections are never excitatoty
// 03/26/2020 DWW
						} elseif($excit_inhib == "e" && $pon_conn_display_array[$i][$k]==0) {
						  $pon_conn_display_array[$i][$k] = P_EXCITATORY_CONN; //black

						  // Link code
						    $data=$type->getID_array($i).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$i][$j]].",".
						    $type->getID_array($k).",".str_replace(":","_",$col_array[$j]).",".$color_map[$pot_conn_array[$k][$src_column]].",".
						    P_EXCITATORY_CONN;
						    $potn_conn_neuron_pcl[$i][$k]=$data;
*/
						}
		            }
		        }
		    }
		}
	}
}
// Logic for axonic and basket neurons
for ($row_index = 0; $row_index < $number_type; $row_index++) {
    if (isset($id_search))
        $id = $id_search[$row_index];
    else
        $id = $type->getID_array($row_index);
    if (in_array($id, $special_neuron_id_basket) or in_array($id, $special_neuron_id_axo_axonic)) {
	    for ($col_index = 0; $col_index < $number_type; $col_index++) {
	    	
	    	
	    	if(in_array($id, $special_neuron_id_basket) and $soma_pcl_flag_array[$col_index]!=1){
	            $pon_conn_display_array[$row_index][$col_index]=NO_CONNECTION;
		   }
		   else if(in_array($id, $special_neuron_id_axo_axonic) and $pc_flag_array[$col_index]!=1) {
		   		$pon_conn_display_array[$row_index][$col_index]=NO_CONNECTION;
		   }
		     
		   
	    }
    }
}

/* @nmsutton This is the section of code that needs to be rewritten to access the connection_status variable*/
 for ($row_index = 0; $row_index < $number_type; $row_index++) {
    //$row_value = $mec_lec_flag_array[$row_index];
    //$is_row_value = $is_flag_array[$row_index];
    $row_id = $type->getID_array($row_index);
    for ($col_index = 0; $col_index < $number_type; $col_index++) {
    	//$col_value = $mec_lec_flag_array[$col_index];
    	//$is_col_value = $is_flag_array[$col_index];
        $col_id = $type->getID_array($col_index);
        if(($row_id==4056&&$col_id==4036)||($row_id==4056&&$col_id==4078)||($row_id==4031&&$col_id==4036)||($row_id==4031&&$col_id==4078)){
        	$pon_conn_display_array[$row_index][$col_index]=NO_CONNECTION;
        }
        if ($connection_status_array[$row_id][$col_id]=='negative') {
			$pon_conn_display_array[$row_index][$col_index] = 0;//NO_CONNECTION;
			//echo "<br>".$row_id." ".$col_id;
		}
		//echo "<br>".$connection_status_array[$row_id][$col_id];
        /*
    	if($row_value*$col_value==-1){
            $pon_conn_display_array[$row_index][$col_index]=NO_CONNECTION;
	    }
	    if($is_row_value==1 && $is_col_value==-1){
	    	$pon_conn_display_array[$row_index][$col_index]=NO_CONNECTION;    
	    }
	    */
    }
}




/* This code section has been commented out due to disuse 03/26/2020 DWW
// Save potential connection to database
for ($row_index = 0; $row_index < $number_type; $row_index++) {
    for ($col_index = 0; $col_index < $number_type; $col_index++) {
    	 $source = $type->getID_array($row_index);
    	 $destination = $type->getID_array($col_index);
    	 if($pon_conn_display_array[$row_index][$col_index]!=0){
    	 	$query="SELECT * FROM Conndata WHERE Type1_id='$source' AND Type2_id='$destination' AND connection_status='potential'";
			$result=mysqli_query($GLOBALS['conn'], $query);
			if(mysqli_num_rows($result)==0){
			 	#set time zone
			 	date_default_timezone_set('America/New_York');
				$date_curr=date('Y-m-d H:i:s');
				$query="INSERT INTO Conndata VALUES (NULL,'$date_curr','$source','$destination','potential',NULL)";
				mysqli_query($GLOBALS['conn'], $query);
			}
    	 }
    }
}
*/


$responce->potential_array=$pon_conn_display_array;
$responce->potn_conn_neuron_pcl_array=$potn_conn_neuron_pcl;
?>
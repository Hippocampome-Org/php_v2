<?php
  include ("permission_check.php");
  $research = $_REQUEST['research'];
  // Define all the necessary classes needed for the application
  require_once('class/class.type.php');
  require_once('class/class.property.php');
  require_once('class/class.firingpattern.php');
  require_once('class/class.firingpatternrel.php');
  require_once('class/class.evidencepropertyyperel.php');
  require_once('class/class.temporary_result_neurons.php');
  define('ORANGE', '#FF8C00');
  define('BLUE', '#0000FF');
  define('BROWN', '#7A5230');
  define('GRAY', '#808080');
  define('WHITE', '#FFFFFF');
  
// check for link
/*  
 * $id - Type id
 * $img - img path
 * $key - DG_Smo For Type SMo 0f DG
 * $color - red/blue or violet 
 * */
function getUrlForLink($id,$img,$key,$count1) 
{
	
	$url = $img;
	if($count1 != NULL)
	{
		if($img != NULL)
		{
			$url ='<a style="text-decoration:none" href="property_page_fp.php?id_neuron='.$id.'&parameter='.$key.'&count='.$count1.'&page=1" target="_blank">'.$img.'</a>';	
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

$research = $_REQUEST['research'];
$table = $_REQUEST['table_result'];
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

$firingpattern = new firingpattern($class_firing_pattern);

$firingpatternrel = new firingpatternrel($class_firing_pattern_rel);

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
$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

if($research!="1")
{
	//$type -> retieve_ordered_List($start,$limit);
	$type -> retrive_id();
	$number_type = $type->getNumber_type();
}
//$number_type=$number_type+6;
$neuron = array("DG"=>'DG(18)',"CA3"=>'CA3(25)',"CA3c"=>'CA3(25)',"CA2"=>'CA2(5)',"CA1"=>'CA1(40)',"SUB"=>'SUB(3)',"EC"=>'EC(31)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');
//$prev_subregion="NONE";

$n_firing = 22;
for ($i=0; $i<$number_type; $i++) //$number_type // Here he determines the number of active neuron types to print each row in the data table
{
	$hippo = array("ASP."=>NULL, "ASP.ASP."=>NULL, "ASP.NASP"=>NULL, "ASP.SLN"=>NULL, "D."=>NULL, "D.ASP."=>NULL, "D.RASP.NASP"=>NULL, "D.NASP."=>NULL, "D.PSTUT"=>NULL, "D.TSWB.NASP"=>NULL, "RASP."=>NULL, "RASP.ASP."=>NULL, "RASP.NASP"=>NULL, "RASP.SLN"=>NULL, "NASP"=>NULL, "PSTUT"=>NULL, "PSWB"=>NULL, "TSTUT."=>NULL, "TSTUT.ASP."=>NULL, "TSTUT.NASP"=>NULL, "TSTUT.SLN"=>NULL, "TSWB.NASP"=>NULL, "TSWB.SLN"=>NULL,  "-"=>NULL);
	$hippo_color = array("ASP."=>NULL, "ASP.ASP."=>NULL, "ASP.NASP"=>NULL, "ASP.SLN"=>NULL, "D."=>NULL, "D.ASP."=>NULL, "D.RASP.NASP"=>NULL, "D.NASP"=>NULL, "D.PSTUT"=>NULL, "D.TSWB.NASP"=>NULL, "RASP."=>NULL, "RASP.ASP."=>NULL, "RASP.NASP"=>NULL, "RASP.SLN"=>NULL, "NASP"=>NULL, "PSTUT"=>NULL, "PSWB"=>NULL, "TSTUT."=>NULL, "TSTUT.ASP."=>NULL, "TSTUT.NASP"=>NULL, "TSTUT.SLN"=>NULL, "TSWB.NASP"=>NULL, "TSWB.SLN"=>NULL, "-"=>NULL);
	$hippo_count = array("ASP."=>NULL, "ASP.ASP."=>NULL, "ASP.NASP"=>NULL, "ASP.SLN"=>NULL, "D."=>NULL, "D.ASP."=>NULL, "D.RASP.NASP"=>NULL, "D.NASP"=>NULL, "D.PSTUT"=>NULL, "D.TSWB.NASP"=>NULL, "RASP."=>NULL, "RASP.ASP."=>NULL, "RASP.NASP"=>NULL, "RASP.SLN"=>NULL, "NASP"=>NULL, "PSTUT"=>NULL, "PSWB"=>NULL, "TSTUT."=>NULL, "TSTUT.ASP."=>NULL, "TSTUT.NASP"=>NULL, "TSTUT.SLN"=>NULL, "TSWB.NASP"=>NULL, "TSWB.SLN"=>NULL, "-"=>NULL);
	$name_firing = array("0"=>"ASP.", "1"=>"ASP.ASP.", "2"=>"ASP.NASP", "3"=>"ASP.SLN", "4"=>"D.", "5"=>"D.ASP.", "6"=>"D.RASP.NASP", "7"=>"D.NASP", "8"=>"D.PSTUT", "9"=>"D.TSWB.NASP", "10"=>"RASP.", "11"=>"RASP.ASP.", "12"=>"RASP.NASP", "13"=>"RASP.SLN", "14"=>"NASP", "15"=>"PSTUT", "16"=>"PSWB", "17"=>"TSTUT.", "18"=>"TSTUT.ASP.", "19"=>"TSTUT.NASP", "20"=>"TSTUT.SLN", "21"=>"TSWB.NASP",  "22"=>"TSWB.SLN", "23"=>"-");
	$soma_location = array("DG:SMo"=>0, "DG:SMi"=>1, "DG:SG"=>2, "DG:H"=>3, 
	                       "CA3:SLM"=>0, "CA3:SR"=>1, "CA3:SL"=>2, "CA3:SP"=>3, "CA3:SO"=>4, 
						   "CA2:SLM"=>0, "CA2:SR"=>1, "CA2:SP"=>2, "CA2:SO"=>3,
						   "CA1:SLM"=>0, "CA1:SR"=>1, "CA1:SP"=>2, "CA1:SO"=>3,
						   "SUB:SM"=>0, "SUB:SP"=>1, "SUB:PL"=>2, 
						   "EC:I"=>0, "EC:II"=>1, "EC:III"=>2, "EC:IV"=>3, "EC:V"=>4, "EC:VI"=>5);
	
	if(isset($id_search))
	{
		$id = $id_search[$i];	
	}
	else
		$id = $type->getID_array($i);
	
			
	$type -> retrive_by_id($id); // Retrieve id
	$nickname = $type->getNickname(); // Retrieve nick name
	$position = $type->getPosition(); // Retrieve the position
	$subregion = $type -> getSubregion(); // Retrieve the sub region
	$excit_inhib =$type-> getExcit_Inhib(); //Retrieve the Excit or Inhib
	
	$evidencepropertyyperel -> retrive_Property_id_by_Type_id($id); // Retrieve distinct Property ids for each type id
	$n_property = $evidencepropertyyperel -> getN_Property_id(); // Count of the number of properties for a given type id
	
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
	
	//$firing -> retrive_by_id($id);
	//$n_type = $firing->getN_Type_id();
	$firingpatternrel->retrieve_by_typeId($id);
	$n_firingpatternid = $firingpatternrel->getN_firing_pattern_ID();
	
	//echo $n_firingpatternid;
	
	for($j=0 ; $j<$n_firingpatternid ; $j++)
	{
		$pattern_id = $firingpatternrel->getPattern_array($j);
		//echo $pattern_id;
		//echo '-';
		//echo $pattern[$j];
		//echo "         ";
		$firingpattern->retrieve_by_id($pattern_id);
		$pattern_name = $firingpattern->getOverall_fp();
		//echo $pattern_name;
		//echo '-';
		$hippo_count[$pattern_name]+=1;
		//print $hippo_count[$pattern_name];
		//$hippo_count[$pattern[$j]]+=1;
		//print $hippo_count[$pattern_name];
	}
	
	
	for($j=0; $j<=$n_firing ; $j++)
	{
		if($hippo_count[$name_firing[$j]] == 1)
		{
			$bgColor = ORANGE;
			$hippo[$name_firing[$j]] = "<div style='background-color:".$bgColor."'><font color='white'> 1</font></div>";
			$hippo_color[$name_firing[$j]] = $hippo_count[$name_firing[$j]];
		}
		elseif($hippo_count[$name_firing[$j]] == 2)
		{
			$bgColor = BLUE;
			$hippo[$name_firing[$j]] = "<div style='background-color:" .$bgColor. "'><font color='white'> 2</font></div>";
			$hippo_color[$name_firing[$j]] = $hippo_count[$name_firing[$j]];
		}
		elseif($hippo_count[$name_firing[$j]] == 3)
		{
			$bgColor = BROWN;
			$hippo[$name_firing[$j]] = "<div style='background-color:" .$bgColor. "'><font color='white'> 3</font></div>";
			$hippo_color[$name_firing[$j]] = $hippo_count[$name_firing[$j]];
		}
		elseif($hippo_count[$name_firing[$j]] == 4)
		{
			$bgColor = GRAY;
			$hippo[$name_firing[$j]] = "<div style='background-color:" .$bgColor. "'><font color='white'> 4</font></div>";
			$hippo_color[$name_firing[$j]] = $hippo_count[$name_firing[$j]];
		}
		/*else
		{
			$bgColor = WHITE;
			$hippo[$name_firing[$j]] = "<div style='background-color:" .$bgColor. "'> </div>";
			$hippo_color[$name_firing[$j]] = NULL;
		}*/
	}
	
	if ($excit_inhib == 'e')
		$fontColor='#339900';
	elseif ($excit_inhib == 'i')
		$fontColor='#CC0000';
	
	$rows[$i]['cell'] = array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>','<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$nickname.'"'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>',
		getUrlForLink($id,$hippo['ASP.'],$name_firing['0'],$hippo_color['ASP.']),
		getUrlForLink($id,$hippo['ASP.ASP.'],$name_firing['1'],$hippo_color['ASP.ASP.']),
		getUrlForLink($id,$hippo['ASP.NASP'],$name_firing['2'],$hippo_color['ASP.NASP']),
		getUrlForLink($id,$hippo['ASP.SLN'],$name_firing['3'],$hippo_color['ASP.SLN']),
		getUrlForLink($id,$hippo['D.'],$name_firing['4'],$hippo_color['D.']),
		getUrlForLink($id,$hippo['D.ASP.'],$name_firing['5'],$hippo_color['D.ASP.']),
		getUrlForLink($id,$hippo['D.RASP.NASP'],$name_firing['6'],$hippo_color['D.RASP.NASP']),
		getUrlForLink($id,$hippo['D.NASP'],$name_firing['7'],$hippo_color['D.NASP']),
		getUrlForLink($id,$hippo['D.PSTUT'],$name_firing['8'],$hippo_color['D.PSTUT']),
		getUrlForLink($id,$hippo['D.TSWB.NASP'],$name_firing['9'],$hippo_color['D.TSWB.NASP']),
		getUrlForLink($id,$hippo['RASP.'],$name_firing['10'],$hippo_color['RASP.']),
		getUrlForLink($id,$hippo['RASP.ASP.'],$name_firing['11'],$hippo_color['RASP.ASP.']),
		getUrlForLink($id,$hippo['RASP.NASP'],$name_firing['12'],$hippo_color['RASP.NASP']),
		getUrlForLink($id,$hippo['RASP.SLN'],$name_firing['13'],$hippo_color['RASP.SLN']),
		getUrlForLink($id,$hippo['NASP'],$name_firing['14'],$hippo_color['NASP']),
		getUrlForLink($id,$hippo['PSTUT'],$name_firing['15'],$hippo_color['PSTUT']),
		getUrlForLink($id,$hippo['PSWB'],$name_firing['16'],$hippo_color['PSWB']),
		getUrlForLink($id,$hippo['TSTUT.'],$name_firing['17'],$hippo_color['TSTUT.']),
		getUrlForLink($id,$hippo['TSTUT.ASP..'],$name_firing['18'],$hippo_color['TSTUT.ASP.']),
		getUrlForLink($id,$hippo['TSTUT.NASP'],$name_firing['19'],$hippo_color['TSTUT.NASP']),
		getUrlForLink($id,$hippo['TTSTUT.SLN'],$name_firing['20'],$hippo_color['TSTUT.SLN']),
		getUrlForLink($id,$hippo['TSWB.NASP'],$name_firing['21'],$hippo_color['TSWB.NASP']),
		getUrlForLink($id,$hippo['TSWB.SLN'],$name_firing['22'],$hippo_color['TSWB.SLN']),
		getUrlForLink($id,$hippo['-'],$name_firing['23'],$hippo_color['-'])
		);
	
	$responce->rows = $rows;
	
	
}
//echo json_encode($responce);




?>
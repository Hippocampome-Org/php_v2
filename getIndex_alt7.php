<?php
  include ("permission_check.php");
  $research = $_REQUEST['research'];
  // Define all the necessary classes needed for the application
  require_once('class/class.type.php');
  require_once('class/class.izhmodelsmodel.php');
  require_once('counts/class/class.counts.php');
  require_once('citations/class/class.citations.php');

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

if(!isset($_GET['page'])) $page=1;
else $page = $_GET['page'];
//page=1&rows=5&sidx=1&sord=asc
// get how many rows we want to have into the grid - rowNum parameter in the grid
if(!isset($_GET['rows'])) $limit=200;
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
$number_type = 0;

$type = new type($class_type);
$izhmodelsmodel = new izhmodelsmodel($class_izhmodels_model);
$counts = new counts($class_counts);
$citations = new citations($class_citations);

$research = $_REQUEST['research'];
$table = $_REQUEST['table_result'];

if (isset($research)) // From page of search; retrieve the id from search_table (temporary) -----------------------
{
	echo("<script>console.log('PHP: In ifvich.php');</script>");
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
	     echo("<script>console.log('PHP: In elsevich.php');</script>");
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
//$neuron = array("DG"=>'DG(35)',"CA3"=>'CA3(35)',"CA3c"=>'CA3(35)',"CA2"=>'CA2(5)',"CA1"=>'CA1(60)',"Sub"=>'Sub(7)',"EC"=>'EC(33)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');
echo("<script>console.log('PHP: In getizhikevich.php');</script>");
// main logic for calculating anf filling json starts here -->
$ii = -1;
$retrieved_citations = $citations -> retrieve_citations();
$number_citations = $citations -> getN_citations();

// for($i = 0; $i<$number_type; $i++)
$i = 0;
for($citation_id = 0; $citation_id<$number_citations; $citation_id++)
{
	if(isset($id_search))
	{
		$id = $id_search[$i];		
	}
	else
	{
		$id = $type->getID_array($i);
	}

	$type -> retrive_by_id($id); // Retrieve id
	$nickname = $type->getNickname(); // Retrieve nick name
	$name = $type->getName();
	$position = $type->getPosition(); // Retrieve the position
	$subregion = $type -> getSubregion(); // Retrieve the sub region
	$excit_inhib =$type-> getExcit_Inhib(); //Retrieve the Excit or Inhib

	$optimum = $counts -> retrieve_counts($id);
	$lower_bound = $counts -> retrieve_lower_bound($id);
	$upper_bound = $counts -> retrieve_upper_bound($id);

	// $citation_id = 0;
	$citation_html = 'http://elifesciences.org/content/4/e09960';
	$brief_citation = $citations -> retrieve_brief_citation($citation_id);
	$full_citation = $citations -> retrieve_full_citation($citation_id);
	
/*
	$izhmodelsmodelArray = $izhmodelsmodel->getElementsArray($id);

	$min;
	$max;
	$mean;

    //initialise the min max and mean array...
	foreach($izhmodelsmodelArray as $izIteration)
	{
	    $min[$izIteration] = 10000; // setting min greater than max absolute value in the table.
	    $max[$izIteration] = -99999; // setting the max lesser than min absolute value in the table.
	    $mean[$izIteration] = -99999;
	}

	$getterString;
	$getterValue;
	$iterator = 0;
	$izValues = $izhmodelsmodel->get_all_id($id);
	foreach ($izValues as $variable) {
		$iterator++;
		foreach($izhmodelsmodelArray as $izIteration)
		{
			$getterString = "get".$izIteration;
			$getterValue = $variable->{$getterString}(); // gets the getter for that specific colunm
			error_log("ID ".$id." For getter  ".$getterString." , the value is ".$getterValue);

			if((string)$getterValue===""){
				if($min[$izIteration]==10000){
					$min[$izIteration] = "";
				}
				if($max[$izIteration]==-99999){
				$max[$izIteration] = "";
			   }
			   if($mean[$izIteration]==-99999){
				$mean[$izIteration] = "";
			   }
				continue;
			}
			if($min[$izIteration]>$getterValue)
			{

				$min[$izIteration] = round($getterValue,4);
			}

			if($max[$izIteration] < $getterValue)
			{
				$max[$izIteration] = round($getterValue,4);	
			}

			if($variable->getPreferred() == 'Y')
			{
				$mean[$izIteration] = round($getterValue,4);

			}
            
		}
	}
*/
    
	$type -> retrieve_v2p0_by_id($id);
	$v2p0 = $type -> getV2p0();

	if ($v2p0 == 0)
	{
		$ii = $ii + 1;

		//Code for Json generation starts...
		if ($excit_inhib == 'e')
			$fontColor='#339900';
		elseif ($excit_inhib == 'i')
			$fontColor='#CC0000';

		if ($type->get_type_subtype($id) == 'subtype')
		{
			$fontColor='#000099';
			if ($excit_inhib == 'i')
				$fontColor='#CC5500';

			// $rows[$ii]['cell'][0] = '<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>';
			// $rows[$ii]['cell'][1] = "    ".'<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>';
			// if ($optimum == 0){
			// 	$rows[$ii]['cell'][2] = '';
			// }else{
			// 	$rows[$ii]['cell'][2] = '<span class="link_left font4"><a href = "property_page_counts.php?id_neuron='.$id.'&val_property=counts" target="_blank">'.$optimum.'<span class = "link_left">&#10;['.$lower_bound.', '.$upper_bound.']</span></a></span>';		
			// }
			// if ($optimum == 0){
			// 	$rows[$ii]['cell'][3] = '';
			// }else{
				// $rows[$ii]['cell'][3] = '<span class="link_left font4">'.$brief_citation.'</span>';		
				// $rows[$ii]['cell'][0] = '<span class="link_left font4"><a href = "" target="_blank">'.$brief_citation.'<span class = "link_left">&#10;'.$full_citation.'</span></a></span>';
				// $rows[$ii]['cell'][0] = '<span class="link_left font4"><a href = "property_page_counts.php?id_neuron='.$id.'&val_property=counts" target="_blank">'.$optimum.'<span class = "link_left">&#10;['.$brief_citation.']</span></a></span>';
				// $rows[$ii]['cell'][0] = '<a href="'.$citation_html.'" target="blank" title="'.$full_citation.'"><font color="'.$fontColor.'">'.$nickname.'</font></a>';	
				$rows[$ii]['cell'][0] = '<a href="'.$citation_html.'" target="blank" title="'.$full_citation.'">'.$brief_citation.'</a>';	
				// $rows[$ii]['cell'][0] = $brief_citation;		
			// }
		}
		else
		{
			// $rows[$ii]['cell'][0] = '<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>';
			// $rows[$ii]['cell'][1] = '<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>';
			// if ($optimum == 0){
			// 	$rows[$ii]['cell'][2] = '';
			// }else{
			// 	$rows[$ii]['cell'][2] = '<span class="link_left font4"><a href = "property_page_counts.php?id_neuron='.$id.'&val_property=counts" target="_blank">'.$optimum.'<span class = "link_left">&#10;['.$lower_bound.', '.$upper_bound.']</span></a></span>';		
			// }
			// if ($optimum == 0){
			// 	$rows[$ii]['cell'][3] = '';
			// }else{
				// $rows[$ii]['cell'][3] = '<span class="link_left font4">'.$brief_citation.'</span>';		
				// $rows[$ii]['cell'][0] = '<span class="link_left font4">'.$brief_citation.'<span class = "link_left">&#10;'.$full_citation.'</span></span>';
				// $rows[$ii]['cell'][0] = '<span class="link_left font4"><a href = "" target="_blank">'.$brief_citation.'<span class = "link_left">&#10;'.$full_citation.'</span></a></span>';
				// $rows[$ii]['cell'][0] = '<span class="link_left font4"><a href = "property_page_counts.php?id_neuron='.$id.'&val_property=counts" target="_blank">'.$optimum.'<span class = "link_left">&#10;['.$brief_citation.']</span></a></span>';
				// $rows[$ii]['cell'][0] = '<a href="'.$citation_html.'" target="blank" title="'.$full_citation.'"><font color="'.$fontColor.'">'.$nickname.'</font></a>';	
				$rows[$ii]['cell'][0] = '<a href="'.$citation_html.'" target="blank" title="'.$full_citation.'">'.$brief_citation.'</a>';	
				// $rows[$ii]['cell'][0] = $brief_citation;		
			// }
		}
	}
	
	$responce->rows = $rows;
}
?>
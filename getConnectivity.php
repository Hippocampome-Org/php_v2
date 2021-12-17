<?php
  include ("permission_check.php");
  include("function/stm_lib.php");
  require_once('class/class.type.php');
  require_once('class/class.property.php');
  require_once('class/class.evidencepropertyyperel.php');
  require_once('class/class.temporary_result_neurons.php');
  define('KNOWN_CONNECTION', 1);
  define('KNOWN_NON_CONNECTION', -1);
  define('P_INHIBITORY_CONN',1);
  define('P_EXCITATORY_CONN',2);
  define('BLACK','#000000');
  define('GRAY', '#AAAAAA');
  define('ORANGE', '#FF8C00');
  define('WHITE','#FFFFFF');
  define('EXCIT_FONT_COLOR','#339900');
  define('INHIBIT_FONT_COLOR','#CC0000');
?>
<script>
$.ajax({
  type: 'GET',
  cache: false,
  contentType: 'application/json; charset=utf-8',
  url: 'load_matrix_session_morphology.php',
  success: function() {}
});
</script>

<?php

$morphology_connection_information= $_SESSION['morphology'];
$array_decoded = json_decode($morphology_connection_information, true);
$potential_conn_display_array = $array_decoded['potential_array'];
$potn_conn_neuron_pcl_array=$array_decoded['potn_conn_neuron_pcl_array'];

// Check the UNVETTED color: ***************************************************************************
function check_unvetted1($id, $id_property, $evidencepropertyyperel) // $id = type_id,$id_property = propert_idy,
{

	$evidencepropertyyperel -> retrive_unvetted($id, $id_property);
	$unvetted1 = $evidencepropertyyperel -> getUnvetted();
	return ($unvetted1);
}
// *****************************************************************************************************



function check_color($type, $unvetted) //$type --> whether axons/dendrites or both
{
	//echo "Neuron Type : ".$type." for id ".$id."\n";
	if ($type == 'axons')
	{
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/axons_present_unvetted.png' border='0'/>";
		else
			$link[0] = "<img src='images/morphology/axons_present.png' border='0'/>";

		 $link[1] = 'red';

	}
	if ($type == 'dendrites')
	{
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/dendrites_present_unvetted.png' border='0'/>";
		else
			$link[0] = "<img src='images/morphology/dendrites_present.png' border='0'/>";

		$link[1] = 'blue';
	}
	if ($type == 'both')
	{
		//echo "Should come here";
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/somata_present_unvetted.png' border='0'/>";
		else
			$link[0] = "<img src='images/morphology/somata_present.png' border='0'/>";
		
		$link[1] = 'violet';
	}
	/* if ($variable == NULL)
	{
		$link[0] = "<img src='images/blank_morphology.png' border='0'/>";
		$link[1] = $variable;
	} */
	//echo $link;
	return ($link);
}
// check for link

function getUrlForLink($id_type_row,$id_type_col,$link_parameter,$img,$know_unknow_flag=0,$special_neuron_id_axo_axonic,$special_neuron_id_basket) 
{
	$url = '';
	if($img!='')
	{
		$axonic_basket_flag=0;
		if(in_array($id_type_row, $special_neuron_id_axo_axonic) ){
			$axonic_basket_flag=1;
		}
		elseif(in_array($id_type_row, $special_neuron_id_basket)){
			$axonic_basket_flag=2;
		}
		$url ='<a href="property_page_connectivity.php?id1_neuron='.$id_type_row.'&val1_property='.$link_parameter[1].'&color1='.$link_parameter[2].
		'&id2_neuron='.$id_type_col.'&val2_property='.$link_parameter[4].'&color2='.$link_parameter[5].
		'&connection_type='.$link_parameter[6].'&known_conn_flag='.$know_unknow_flag.'&axonic_basket_flag='.$axonic_basket_flag.'&page=1" target="_blank"><img src="images/connectivity/'.$img.'" height="20px" width="20px" border="0"/></a>';
	}
	#}
	/*
	else{
		if($img!=''){
			$url ='<a href="property_page_connectivity.php?id_neuron='.$id_1.'&id_neuron_2='.$id_2.'&val_property='.$key.'&color='.$color1.'&page=1" target="_blank">'.$img.'</a>';
		}
	}
	*/
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

$research = $_REQUEST['research'];

$type = new type($class_type);
$type ->retrive_id();

$number_type = $type ->getNumber_type();
$total_neurons=$number_type;
$research = $_REQUEST['research'];
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

//array for selecting the nicknames for known conn
$source_query = "SELECT DISTINCT nickname from Type order by position asc";
$result       = mysqli_query($GLOBALS['conn'], $source_query);
$sources      = result_set_to_array($result, 'nickname');
//print_r($sources[2]);
$id_query     = "SELECT DISTINCT id from Type order by position asc";
$result_id    = mysqli_query($GLOBALS['conn'], $id_query);
$id_array     = result_set_to_array($result_id, 'id');
for($index_neuron=0;$index_neuron<count($id_array);$index_neuron++){
	$key=$id_array[$index_neuron];
	$neuron_map[$key]=$index_neuron;
}


$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "", 'Unknowncount' => $unknowncount, 'black'=>$bl, 'orange' =>$or, 'gray' =>$gr);


//$responce->page = $page;
//$responce->total = $total_pages;
$responce->records = $count;
$bl=$or=$gr=0;
$knowncount =0;
$unknowncount =0;

//$count123 = (object) array('knowncount' => $knowncount, 'hello' => $unknowncount);


$neuron = array("DG"=>'DG(18)',"CA3"=>'CA3(25)',"CA3c"=>'CA3(25)',"CA2"=>'CA2(5)',"CA1"=>'CA1(42)',"SUB"=>'SUB(3)',"EC"=>'EC(31)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');

//The source query for Retriving the known and known non connections
$explicit_target_and_source_base_query = "SELECT 
t1.id as t1_id, t1.subregion as t1_subregion, t1.nickname as t1_nickname,
t2.id as t2_id, t2.subregion as t2_subregion, t2.nickname as t2_nickname 
FROM TypeTypeRel ttr 
JOIN (Type t1, Type t2) ON ttr.Type1_id = t1.id AND ttr.Type2_id = t2.id";

//read in the potential connectivity matrix from the database
//print($number_type);
//Computation for the potential connec array creation
/*LEGEND for $known_matrix_array:
0-blank
4-Known connections
6-Known non-connections
*/


for ($i = 0; $i < $total_neurons; $i++) {
    for ($j = 0; $j < $total_neurons; $j++) {
        $known_matrix_array[$i][$j] = 0;
    }
}
$count_known = 0;
$count_known_non=0;

//retrived connection from conndata

for ($r = 0; $r < $total_neurons; $r++) {
    $explicit_target_query = "SELECT  Type2_id FROM Conndata WHERE Type1_id='$id_array[$r]' AND connection_status= 'positive'";

    $explicit_nontarget_query = "SELECT  Type2_id FROM Conndata WHERE Type1_id='$id_array[$r]' AND connection_status= 'negative'";

    $explicit_target_result = mysqli_query($GLOBALS['conn'], $explicit_target_query);
    $result_target = result_set_to_array($explicit_target_result, "Type2_id");

    $explicit_nontarget_result  = mysqli_query($GLOBALS['conn'], $explicit_nontarget_query);
    $result_nontarget = result_set_to_array($explicit_nontarget_result, "Type2_id");

    for ($c = 0; $c < $total_neurons; $c++) {
        for ($k = 0; $k < count($result_target); $k++) {
            if ($result_target[$k] == $id_array[$c]) {
                $count_known++;
                $known_matrix_array[$r][$c] = KNOWN_CONNECTION; //known _connection
                break;
            }
        }
        for ($m = 0; $m < count($result_nontarget); $m++) {
            if ($result_nontarget[$m] == $id_array[$c]) {
                $count_known_non++;
                $known_matrix_array[$r][$c] = KNOWN_NON_CONNECTION; // known non-connection
                break;
            }

        }
    }
}

// Get the information fo potential connectivity from morphology
/* LEGEND
0-blank
1-gray -Potential Inhibitory Connections
2-black --Potential Excitatory Connections
*/
//$potential_conn_display_array = $_SESSION['pot_conn_array_d'];

// To handle the special neuron cases

for ($i=0; $i < $total_neurons; $i++) {
  $id = $type->getID_array($i);
  $type -> retrive_by_id($id); // Retrieve id
  $excit_inhib =$type-> getExcit_Inhib();
  // add known connection and known non connection data to connectivity matrix
  for ($j=0; $j < $total_neurons; $j++) {
    if($potential_conn_display_array[$i][$j] == 0)
    {
      if($known_matrix_array[$i][$j] == KNOWN_CONNECTION)
      {
        if ($excit_inhib=="i")
        {
          $potential_conn_display_array[$i][$j]=P_INHIBITORY_CONN;
        }
        elseif ($excit_inhib=="e")
        {
          $potential_conn_display_array[$i][$j]=P_EXCITATORY_CONN;
        }
      }
    }
  }
}

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

// create link and image for each connection
for ($row=0; $row<$number_type; $row++) {
			for($i = 0; $i < $number_type; $i++){
		    $hippo_nickname[$i]=NULL;
		  }		
		  			$actual_row=$row;
					// retrieve the id_type from Type
					if (isset($research))
						$id_type_row = $id_search[$row];
					else
						$id_type_row = $type->getID_array($row);
					
					$type -> retrive_by_id($id_type_row);
					$nickname_type_row = $type->getNickname();
					$name = $type->getName();
					
					$subregion_type_row = $type->getSubregion();
					$position = $type->getPosition(); // Retrieve the position
					$subregion = $type -> getSubregion(); // Retrieve the sub region 
					$excit_inhib =$type-> getExcit_Inhib();
					
					$nickname_type_row = str_replace('_', ' ', $nickname_type_row);
					$subregion_nickname_type_row = $subregion_type_row . ":" . $nickname_type_row;
					$position_row = $type->getPosition();
				
					if ($excit_inhib == 'e')
						$fontColor=EXCIT_FONT_COLOR;
					if ($excit_inhib == 'i')
						$fontColor=INHIBIT_FONT_COLOR;
						
				for ($col=0; $col<$total_neurons; $col++) {
						$image ="";
						$id_type_col = $type->getID_array($col);
						
						$type -> retrive_by_id($id_type_col);
						$nickname_type_col = $type->getNickname();
						$subregion_type_col = $type->getSubregion();
					
						$nickname_type_col = str_replace('_', ' ', $nickname_type_col);
						$subregion_nickname_type = $subregion_type_col . " " . $nickname_type_col;
						$position_col = $type->getPosition();
						// retrive search neuron information
						if(isset($research)){
							$row=$neuron_map[$id_type_row];
							$link_parameter=explode(",",$potn_conn_neuron_pcl_array[$row][$col]);
							
						}
						// get link parameters	
						else{
							$link_parameter=explode(",",$potn_conn_neuron_pcl_array[$row][$col]);
						}
						if ($known_matrix_array[$row][$col] == KNOWN_NON_CONNECTION) 
						{
							$presynaptic_bg_color = WHITE;
						}
						else {
							// Potential connections determine background color
							switch ($potential_conn_display_array[$row][$col]) {
								case P_INHIBITORY_CONN:
									$presynaptic_bg_color = GRAY;
									$responce->gray++;	
									break;
								case P_EXCITATORY_CONN:
									$presynaptic_bg_color = BLACK;
									$responce->black++;
									break;
								case 9:
									$presynaptic_bg_color = ORANGE;
									$responce->orange++;
									break;
								default:
									$presynaptic_bg_color = WHITE;
									break;
							}
						}
						// potential connection determines image to be displayed					
						if ($known_matrix_array[$row][$col] == KNOWN_NON_CONNECTION)
						{
							$responce->Unknowncount++;
							$url=getUrlForLink($id_type_row,$id_type_col,$link_parameter,"known_nonconnection.png",KNOWN_NON_CONNECTION,$special_neuron_id_axo_axonic,$special_neuron_id_basket);
							$image = "<div style='background-color:" . $presynaptic_bg_color . ";padding:0 2px;'>".$url."</div>";
						}
						elseif ($known_matrix_array[$row][$col] == KNOWN_CONNECTION)
						{
							$responce->knowncount++;
							$url=getUrlForLink($id_type_row,$id_type_col,$link_parameter,"known_connection.png",KNOWN_CONNECTION,$special_neuron_id_axo_axonic,$special_neuron_id_basket);
							$image = "<div style='background-color:" . $presynaptic_bg_color . ";padding:0 2px;'>".$url."</div>";
						}
						else if ($potential_conn_display_array[$row][$col] != 0) 
						{
							if($presynaptic_bg_color==BLACK)
							{
								$url=getUrlForLink($id_type_row,$id_type_col,$link_parameter,"spacer_black.png",0,$special_neuron_id_axo_axonic,$special_neuron_id_basket);
								$image = "<div style='background-color:" . $presynaptic_bg_color . ";padding:0 2px;'>".$url."</div>";
							}
							else if($presynaptic_bg_color==ORANGE)
							{
								
								$url=getUrlForLink($id_type_row,$id_type_col,$link_parameter,"spacer_orange.png",0,$special_neuron_id_axo_axonic,$special_neuron_id_basket);
								$image = "<div style='background-color:" . $presynaptic_bg_color . ";padding:0 2px;'>".$url."</div>";
							}
							if($presynaptic_bg_color == GRAY)
							{	
								$url=getUrlForLink($id_type_row,$id_type_col,$link_parameter,"spacer_gray.png",0,$special_neuron_id_axo_axonic,$special_neuron_id_basket);
								$image = "<div style='background-color:" . $presynaptic_bg_color . ";padding:0 2px;'>".$url."</div>";
							}
						} 
						$hippo_nickname[$col] = $image;
					}
					// create connectivity matrix array
					if ($type->get_type_subtype($id_type_row) == 'subtype'){
						$fontColor='#000099';
						if ($excit_inhib == 'i')
							$fontColor='#CC5500';
						$hippo_array=array('&nbsp;<span style="color:'.$neuronColor[$subregion_type_row].'"><strong>'.$neuron[$subregion_type_row].'</strong></span>',"    ".'&nbsp;<a href="neuron_page.php?id='.$id_type_row.'" target="blank" title="'.$name.'"><font color="'.$fontColor.'">'.$nickname_type_row.'</font></a>');
					    for($i=0; $i<$total_neurons; $i++){
					      	array_push($hippo_array,$hippo_nickname[$i]);
					    }
					}
					else{ // type_subtype = 'type' OR type_subtype = 'None'
						$hippo_array=array('&nbsp;<span style="color:'.$neuronColor[$subregion_type_row].'"><strong>'.$neuron[$subregion_type_row].'</strong></span>','&nbsp;<a href="neuron_page.php?id='.$id_type_row.'" target="blank" title="'.$name.'"><font color="'.$fontColor.'">'.$nickname_type_row.'</font></a>');
					    for($i=0; $i<$total_neurons; $i++){
					      	array_push($hippo_array,$hippo_nickname[$i]);
					    }						
					}
				    $row=$actual_row;
				    $rows[$row]['cell']=$hippo_array;
				    $responce->rows = $rows;
				    


}
?>

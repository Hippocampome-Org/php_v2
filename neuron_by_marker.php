<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$parameter=$_GET['marker'];

if ($parameter=="alpha-actinin-2")
	$title = "&alpha;-act2";
elseif ($parameter=="Gaba-a-alpha")
	$title = "GABAa &alpha;1";
else {
	$title = $parameter;
	$title = str_replace("\alpha ", " &alpha;", $title);
	$title = str_replace("\beta ", " &beta;", $title);
	$title = str_replace("\delta", " &delta;", $title);
	$title = str_replace("\gamma ", " &gamma;", $title);
}

if (strpos($parameter,'\\') != false) {
	$parameter = str_replace('\\', '\\\\', $parameter);
}


$predicateArr=array('positive'=>'Types with positive expression','negative'=>'Types with negative expression','mixed'=>'Types with mixed expression','unknown'=>'Types with unknown expression');

//include ("access_db.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.evidenceevidencerel.php');
require_once('class/class.epdataevidencerel.php');
require_once('class/class.epdata.php');
require_once('class/class.typetyperel.php');

include ("function/name_ephys.php");
include ("function/stm_lib.php");

$type = new type($class_type);
$type -> retrive_id();
$number_type = $type->getNumber_type();
$property_1 = new property($class_property);
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$evidenceevidencerel = new evidenceevidencerel($class_evidenceevidencerel);
$epdataevidencerel = new epdataevidencerel($class_epdataevidencerel);
$epdata = new epdata($class_epdata);
$typetyperel = new typetyperel();

$objArr = $property_1->retrievePropertyIdByName($parameter);


// SEARCH Function for MARKERS: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function markers_search($evidencepropertyyperel, $property_1, $type, $predicate, $parameter) {	
	$n_tot = 0;				// Variable to be used as an index for storing the resultant Type ID
	$new_type_id = NULL;	// Variable to store and return the complete list of Matched and Unmatched IDs
	
	if(($predicate != 'unknown')) {
		// Call the function to search for the appropriate Type Ids
		$evidencepropertyyperel -> retrive_Type_id_by_Subject_override($parameter, $predicate);
	}
	else {// if it unknown
		$evidencepropertyyperel -> retrive_Type_id_by_Subject_Object($parameter, $predicate);
	}
	
	$n_type_id = $evidencepropertyyperel -> getN_Type_id();		// Get the total number of the search result Type IDs
	
	// Get the total number of Type Ids in Type table
	$number_type= $type -> getNumber_type();
	
	// Iterate through the result of the conflict override searched Type Ids
	for ($i1=0; $i1<$n_type_id; $i1++) {
		if(($predicate != 'unknown')) {
			$type_id[$n_tot] = $evidencepropertyyperel -> getType_id_array($i1);
		}
		else {
			$type_r = $evidencepropertyyperel -> getType_id_array($i1);
			$type_id[$n_tot] = "10_".$type_r;
		}
		
		$n_tot = $n_tot + 1;
	}
	
	// Check if Type_id arrary is not null
	if ($type_id != NULL)
		$new_type_id = array_unique($type_id);
	
	if (!empty($new_type_id)) {
		foreach ($new_type_id as $an_id) {
			//$new_type_id['note_key'][$an_id] = $predicate;
			$new_type_conflict_note[$an_id] = $predicate;
		}
	}
	
	return array($new_type_id, $new_type_conflict_note);
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
	include ("function/icon.html"); 
	print("<title>" . $title . " expression</title>");
?>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
.title_area2 {
	position:absolute; top: 80px; left: 50px;
	width: 1000px;
	border:none;
}
</style>
</head>
<!-- COPY IN ALL PAGES -->

<?php 
	include ("function/title.php");
	include ("function/menu_main.php");	
?>
<body>
	<div class='title_area2'>
	<font class="font1">
	<?php
	$markerName=$parameter;
	if (strpos($parameter,'\\') != false) 
		$markerName = str_replace('\\', '\\\\', $markerName);
	$query_to_get_name="SELECT p.object
						FROM Property p
						WHERE subject like '$markerName'
						AND predicate like 'has name'";
	//print($query_to_get_name);
	$rs_name = mysqli_query($GLOBALS['conn'],$query_to_get_name);
	$row_name = mysqli_fetch_assoc($rs_name);
	$name_val=$row_name['object'];
	if($name_val!="")
		print("$name_val [$title]");
	else
		print($title);
	?>
	</font>
	</div>
	
	<div align='center'>
	<table width="85%" border="0" cellspacing="2" cellpadding="0" class='body_table'>

	<tr height="50">
		<td></td>
	</tr>
	<tr>
    <td align="center">
		<br/><br/><br/>
				
	<table width="80%" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td width="20%" align="center" class="table_neuron_page3">Molecular Markers</td>			
		</tr>			
	</table>
<?php 

$n_result_tot = 0;
$id_t = Array();
$pos_Array = Array();
$pos_intr_Array = Array();
$pos_conf_intr_Array = Array();
$pos_inf_intr_Array = Array();
$pos_inf_conf_intr_Array = Array();
$neg_Array = Array();
$neg_inf_Array = Array();
$mixed_type = Array();
$name_type = "";
$subregion_type ="";
$position_type = "";
foreach ($predicateArr as $k => $v)
{
	$marker_id = Array();
	$n_result_tot = 0;
	
	if($k=='mixed')
	{
        if(!empty($evidencepropertyyperel)){
        	$pos_neg_all = array();
        	
			list($pos_neg_all[], $conf_notes_subtypes) = markers_search($evidencepropertyyperel, $property_1, $type, 'subtypes', $parameter);
			list($pos_neg_all[], $conf_notes_se) = markers_search($evidencepropertyyperel, $property_1, $type, 'subcellular expression differences', $parameter);
			list($pos_neg_all[], $conf_notes_sp) = markers_search($evidencepropertyyperel, $property_1, $type, 'species/protocol differences', $parameter);
			list($pos_neg_all[], $conf_notes_unresolved) = markers_search($evidencepropertyyperel, $property_1, $type, 'unresolved', $parameter);
			list($pos_neg_all[], $conf_notes_pni) = markers_search($evidencepropertyyperel, $property_1, $type, 'positive; negative inference', $parameter);
			list($pos_neg_all[], $conf_notes_pin) = markers_search($evidencepropertyyperel, $property_1, $type, 'positive inference; negative', $parameter);
			list($pos_neg_all[], $conf_notes_pini) = markers_search($evidencepropertyyperel, $property_1, $type, 'positive inference; negative inference', $parameter);
			list($pos_neg_all[], $conf_notes_unresolvedInf) = markers_search($evidencepropertyyperel, $property_1, $type, 'unresolved inferential conflict', $parameter);
			list($pos_neg_all[], $conf_notes_spInf) = markers_search($evidencepropertyyperel, $property_1, $type, 'species/protocol inferential conflict', $parameter);
			
        	$marker_id = array();

			foreach($pos_neg_all as $arr) {
			    if(is_array($arr)) {
			        $marker_id = array_merge($marker_id, $arr);
			    }
			}
		}
	}
	elseif($k == 'positive' || $k == 'negative') {
		if(!empty($evidencepropertyyperel)){
			list($pos_intr_Array, $conf_notes_pos) = markers_search($evidencepropertyyperel, $property_1, $type, 'positive', $parameter);
			list($pos_conf_intr_Array, $conf_notes_pos_conf) = markers_search($evidencepropertyyperel, $property_1, $type, 'confirmed positive', $parameter);
			list($pos_inf_intr_Array, $conf_notes_pi) = markers_search($evidencepropertyyperel, $property_1, $type, 'positive inference', $parameter);
			list($pos_inf_conf_intr_Array, $conf_notes_pi_conf) = markers_search($evidencepropertyyperel, $property_1, $type, 'confirmed positive inference', $parameter);
			
			list($neg_Array, $conf_notes_neg) = markers_search($evidencepropertyyperel, $property_1, $type, 'negative', $parameter);
			list($neg_conf_Array, $conf_notes_neg_conf) = markers_search($evidencepropertyyperel, $property_1, $type, 'confirmed negative', $parameter);
			list($neg_inf_Array, $conf_notes_ni) = markers_search($evidencepropertyyperel, $property_1, $type, 'negative inference', $parameter);
			list($neg_inf_conf_Array, $conf_notes_ni_conf) = markers_search($evidencepropertyyperel, $property_1, $type, 'confirmed negative inference', $parameter);

			$arrayOfPosArrays = array();
			$arrayOfPosArrays[0] = $pos_intr_Array;
			$arrayOfPosArrays[1] = $pos_conf_intr_Array;
			$arrayOfPosArrays[2] = $pos_inf_intr_Array;
			$arrayOfPosArrays[3] = $pos_inf_conf_intr_Array;
			
			$pos_combined_array = array();
			
			foreach($arrayOfPosArrays as $arr) {
				if(is_array($arr)) {
					$pos_combined_array = array_merge($pos_combined_array, $arr);
				}
			}
			
			$arrayOfNegArrays = array();
			$arrayOfNegArrays[0] = $neg_Array;
			$arrayOfNegArrays[1] = $neg_conf_Array;
			$arrayOfNegArrays[2] = $neg_inf_Array;
			$arrayOfNegArrays[3] = $neg_inf_conf_Array;
			
			$neg_combined_array = array();
			
			foreach($arrayOfNegArrays as $arr) {
				if(is_array($arr)) {
					$neg_combined_array = array_merge($neg_combined_array, $arr);
				}
			}
			

			/*if (!empty($pos_intr_Array) && !empty($pos_inf_intr_Array))
			 $pos_combined_array = array_merge($pos_intr_Array, $pos_inf_intr_Array);
			 elseif (!empty($pos_intr_Array))
			 $pos_combined_array = $pos_intr_Array;
			 elseif (!empty($pos_inf_intr_Array))
			 $pos_combined_array = $pos_inf_intr_Array;
			 	
			 if (!empty($neg_Array) && !empty($neg_inf_Array))
			 	$neg_combined_array = array_merge($neg_Array, $neg_inf_Array);
		 	elseif (!empty($neg_Array))
			 	$neg_combined_array = $neg_Array;
		 	elseif (!empty($neg_inf_Array))
			 	$neg_combined_array = $neg_inf_Array; */
			 
			
			if((!empty($pos_combined_array)) && (!empty($neg_combined_array))) {
				$mixed_type = array_intersect($pos_combined_array, $neg_combined_array);
			}
			if($k == 'positive' && !empty($pos_combined_array)) $marker_id = array_diff($pos_combined_array, $mixed_type);
			if($k == 'negative' && !empty($neg_combined_array)) $marker_id = array_diff($neg_combined_array, $mixed_type);			
		}
	}
	else {
		list($marker_id, $conf_notes_unknown) = markers_search($evidencepropertyyperel, $property_1, $type, $k, $parameter);
	}
	
	
?>

		

<?php
	print("<table  border='0' width='80%' border='0' cellspacing='2' cellpadding='0'>");
	print("<tr><td align='center' width='20%' class='table_neuron_page1'>$predicateArr[$k]</td>");
	if($k=="unknown"){
		print("<td align='left' width='80%' class='table_neuron_page1'></td></tr>");
	}
	else{
		print("<td align='left' width='60%' class='table_neuron_page1'></td>
				<td align='center' width='20%' class='table_neuron_page1'>View page</td>
			</tr>");
	}
	if(count($marker_id) > 0)
	{
		foreach ($marker_id as $idToConsider) {
			$id = $idToConsider;
			
			if (strpos($id, '0_') == 1)
				$id = str_replace('10_', '',$id);
		 
			$type -> retrieve_by_id($id);
			$status = $type -> getStatus();
		
			if ($status == 'active') {
				if($k=='positive') {
					$pos_Array[$id] = $id;
					$pos_intr_Array[] = $id;
				}
				elseif($k=='negative') {
					$neg_Array[] = $id;			
				}
				
				$id_t = $id;
				$name_type = $type -> getNickname();
				$inhib_excit=$type->getExcit_Inhib();
				if ((!empty($conf_notes_pi) && array_key_exists($id_t, $conf_notes_pi)) ||
						(!empty($conf_notes_ni) && array_key_exists($id_t, $conf_notes_ni)))
					$name_type = $name_type . " (inference)";
						
				if ((!empty($conf_notes_pos_conf) && array_key_exists($id_t, $conf_notes_pos_conf)) ||
						(!empty($conf_notes_neg_conf) && array_key_exists($id_t, $conf_notes_neg_conf)))
					$name_type = $name_type . " (confirmed by inference)";
							
				if ((!empty($conf_notes_pi_conf) && array_key_exists($id_t, $conf_notes_pi_conf)) ||
						(!empty($conf_notes_ni_conf) && array_key_exists($id_t, $conf_notes_ni_conf)))
					$name_type = $name_type . " (inference confirmed by additional inference(s))";						
				
				//$subregion_type = $type -> getSubregion();
				$position_type = $type -> getPosition();
				$n_result_tot = $n_result_tot + 1;
				
				if($k=='mixed') {
					if ((!empty($conf_notes_subtypes) && array_key_exists($id_t, $conf_notes_subtypes)) ||
							(!empty($conf_notes_se) && array_key_exists($id_t, $conf_notes_se)) ||
							(!empty($conf_notes_sp) && array_key_exists($id_t, $conf_notes_sp)) ||
							(!empty($conf_notes_unresolved) && array_key_exists($id_t, $conf_notes_unresolved))) {
						$evidencepropertyyperel -> retrive_unvetted($id,$objArr['positive']);
						$unvetted = $evidencepropertyyperel -> getUnvetted();
						$evidencepropertyyperel -> retrieve_conflict_note($objArr['positive'], $id);
						$conflict_note = $evidencepropertyyperel -> getConflict_note();
					}
					elseif ((!empty($conf_notes_pin) && array_key_exists($id_t, $conf_notes_pin)) ||							
							(!empty($conf_notes_pini) && array_key_exists($id_t, $conf_notes_pini)) ||
							(!empty($conf_notes_unresolvedInf) && array_key_exists($id_t, $conf_notes_unresolvedInf)) ||
							(!empty($conf_notes_spInf) && array_key_exists($id_t, $conf_notes_spInf))) {
						$evidencepropertyyperel -> retrive_unvetted($id,$objArr['positive_inference']);
						$unvetted = $evidencepropertyyperel -> getUnvetted();
						$evidencepropertyyperel -> retrieve_conflict_note($objArr['positive_inference'], $id);
						$conflict_note = $evidencepropertyyperel -> getConflict_note();
					}
					elseif (!empty($conf_notes_pni) && array_key_exists($id_t, $conf_notes_pni)) {
						$evidencepropertyyperel -> retrive_unvetted($id,$objArr['negative_inference']);
						$unvetted = $evidencepropertyyperel -> getUnvetted();
						$evidencepropertyyperel -> retrieve_conflict_note($objArr['negative_inference'], $id);
						$conflict_note = $evidencepropertyyperel -> getConflict_note();
					}
					if ($inhib_excit == 'e') {
					    $font_class = 'font10a';
					} else { 
						$font_class = 'font11';
					}
					$mixed_conflict = $conflict_note;
					
					if (!$mixed_conflict)
						$mixed_conflict = 'not yet determined';
				}
		
?>			<tr>
				<td align='right' width='20%' ></td>
				<td align='left' width='60%' class='table_neuron_page2'> 
					<a href='neuron_page.php?id=<?php echo $id_t ?>'>
						<?php if($inhib_excit == 'e'){?>
						<font class='font10a'>
						<?php } else {?>
						<font class='font11'>
						<?php } 
						echo $subregion_type." ".$name_type; if($k=='mixed')
						{ echo " (".$mixed_conflict.")"; } 
						?>
				</a>
			</td>
			<td align='center' width='20%' class='table_neuron_page2'>
			<?php
			if($k!="unknown"){
				$query_to_get_color="SELECT GROUP_CONCAT(sub.object SEPARATOR '-') AS object
						FROM (SELECT DISTINCT eptr.Type_id, p.object
						    FROM Property p, EvidencePropertyTypeRel eptr
						    WHERE p.id = eptr.Property_id  AND eptr.Type_id = $id AND p.subject LIKE '$parameter' AND p.object NOT LIKE 'unknown'
						    ORDER BY eptr.Type_id , FIELD(p.object, 'positive', 'negative', 'positive_inference', 'negative_inference', 'weak_positive', 'unknown')
							) AS sub
						GROUP BY sub.Type_id";
				$rs_color = mysqli_query($GLOBALS['conn'],$query_to_get_color);
				$row = mysqli_fetch_assoc($rs_color);
				$color_val=$row['object'];
				//print("$query_to_get_color,$color_val");
				print("<a align='left' href='property_page_markers.php?id_neuron=$id&val_property=$parameter&color=$color_val&page=markers' target='_blank'> [Evidence] </a>
					<a align='right' href='neuron_page.php?id=$id_t' target='_blank'> [Neuron] </a>");
			}
			?>
			</td>
			</tr>
<?php			}
		}
?>
		</table> 
<?php }
	  else {
?>
		<tr>
				<td align='right' width='20%' ></td>
	  	<td align='left' width='60%' class='table_neuron_page2'> 
	  		<div><font><?php echo "No ".$k." type found " ?></font></div>
	  	</td>
	  	<td align='right' width='20%' class='table_neuron_page2'></td>
	  </tr>
<?php }
	}?>
	</table>
	<br/><br/><br/>
	</div>
</body>
</html>

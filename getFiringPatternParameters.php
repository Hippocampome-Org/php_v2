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

  
// return parameter that needs to be displayed for firing pattern either return human readable name or database column names
function getFPViewParameters($fp_parameters_array,$fp_pattern,$flag) 
{

	$query_for_view_flag="SELECT * FROM FiringPattern WHERE definition_parameter like 'definition' AND overall_fp='$fp_pattern'";
	$query_for_name="SELECT * FROM FiringPattern WHERE id=1";
	$query_for_units="SELECT * FROM FiringPattern WHERE id=4";
	$query_for_description="SELECT * FROM FiringPattern WHERE id=3";

	$result_view_flag = mysqli_query($GLOBALS['conn'],$query_for_view_flag);
	$result_name = mysqli_query($GLOBALS['conn'],$query_for_name);
	$result_units = mysqli_query($GLOBALS['conn'],$query_for_units);
	$result_description = mysqli_query($GLOBALS['conn'],$query_for_description);

	$row_name=mysqli_fetch_array($result_name, MYSQLI_BOTH);
	$row_units=mysqli_fetch_array($result_units, MYSQLI_BOTH);
	$row_description=mysqli_fetch_array($result_description, MYSQLI_BOTH);
	
	$ind=2;
	if($flag=="MR"){
		$fp_view_name_mr[0]="tstim_ms";
		$fp_view_name_mr[1]="istim_pa";
	}
	else{
		$fp_view_name_hr[0]="<span title='Duration of stimulation'>Tstim (ms)</span>";
		$fp_view_name_hr[1]="<span title='Amplitude of stimulation'>Istim (pA)</span>";
	}
	while ($row_view_flag =  mysqli_fetch_array($result_view_flag,MYSQLI_BOTH)) {
		for($index=2;$index<count($fp_parameters_array);$index++){
			$key=$fp_parameters_array[$index];
			$key_col=$row_view_flag[$key];
			// get human readable name
			if($key_col==1&&$flag=="HR"){
				$value=$row_name[$key];
				// parse to remove formula at end
				$value=substr($value, 0, strpos($value, "="));
				$unit=$row_units[$key];
				// append description of parameter
				$desc=$row_description[$key];
				// append unit of parameter
				if($unit)
					$unit=" ($unit)";
				else
					$unit="";
				// if formula removed from parameter name
				if($value)
					$fp_view_name_hr[$ind++]="<span title='$desc'>$value.$unit</span>";
				else
					$fp_view_name_hr[$ind++]="<span title='$desc'>".$row_name[$key]."$unit</span>";
			}
			// get Machine readable name
			else if($key_col==1&&$flag=="MR"){
				$fp_view_name_mr[$ind++]=$key;
			}
			
		}
	}

	if($flag=="MR"){
			return $fp_view_name_mr;
	}
	else{
		return $fp_view_name_hr;
	}
}
function getUrlForLink($fp_param_array,$fp_pattern) 
{
	// get firing pattern parameters
	$query_for_values="SELECT fpr.Type_id,fpr.istim_pa,fpr.tstim_ms,fp.* FROM FiringPattern fp, FiringPatternRel fpr
						WHERE fpr.FiringPattern_id=fp.id
						AND fp.definition_parameter='parameter' AND fp.overall_fp='$fp_pattern'";
	$query_for_digits="SELECT * FROM FiringPattern WHERE id=5";
	
	$result_values = mysqli_query($GLOBALS['conn'],$query_for_values);
	$result_digits = mysqli_query($GLOBALS['conn'],$query_for_digits);
	
	$row_digits=mysqli_fetch_array($result_digits, MYSQLI_BOTH);
	
	// get the paramters to view for this firing pattern
	$fp_view_param=getFPViewParameters($fp_param_array,$fp_pattern,"MR"); 
	
	// create array to hold firing pattern parameter values
	$ind=0;
	while ($row =  mysqli_fetch_array($result_values, MYSQLI_BOTH)) {
		$type_id=$row["Type_id"];
		for($index=0;$index<count($fp_param_array);$index++){
			$key_col=$fp_param_array[$index];
			$key_col_value=$row[$key_col];
			if($key_col_value!="no value"){
				$key_col_value=number_format((float)$key_col_value,$row_digits[$key_col], '.', '');
				if(in_array($key_col, $fp_view_param)){
					if($fp_values[$type_id][$key_col]){
						$fp_values[$type_id][$key_col]=$fp_values[$type_id][$key_col].",".$key_col_value;
					}
					else	
						$fp_values[$type_id][$key_col]=$key_col_value;
					$ind++;
				}
			}
		}
	}
	return $fp_values;	
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
	$type -> retrive_id();
	$number_type = $type->getNumber_type();
}
$neuron = array("DG"=>'DG(18)',"CA3"=>'CA3(25)',"CA3c"=>'CA3(25)',"CA2"=>'CA2(5)',"CA1"=>'CA1(40)',"SUB"=>'SUB(3)',"EC"=>'EC(31)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');
$hippo = array("ASP."=>NULL, "ASP.ASP."=>NULL, "ASP.NASP"=>NULL, "ASP.SLN"=>NULL, "D."=>NULL, "D.ASP."=>NULL, "D.RASP.NASP"=>NULL, "D.NASP."=>NULL, "D.PSTUT"=>NULL, "D.TSWB.NASP"=>NULL, "RASP."=>NULL, "RASP.ASP."=>NULL, "RASP.NASP"=>NULL, "RASP.SLN"=>NULL, "NASP"=>NULL, "PSTUT"=>NULL, "PSWB"=>NULL, "TSTUT."=>NULL, "TSTUT.ASP."=>NULL, "TSTUT.NASP"=>NULL, "TSTUT.SLN"=>NULL, "TSWB.NASP"=>NULL, "TSWB.SLN"=>NULL,  "-"=>NULL);
$name_firing = array("0"=>"ASP.", "1"=>"ASP.ASP.", "2"=>"ASP.NASP", "3"=>"ASP.SLN", "4"=>"D.", "5"=>"D.ASP.", "6"=>"D.RASP.NASP", "7"=>"D.NASP", "8"=>"D.PSTUT", "9"=>"D.TSWB.NASP", "10"=>"RASP.", "11"=>"RASP.ASP.", "12"=>"RASP.NASP", "13"=>"RASP.SLN", "14"=>"NASP", "15"=>"PSTUT", "16"=>"PSWB", "17"=>"TSTUT.", "18"=>"TSTUT.ASP.", "19"=>"TSTUT.NASP", "20"=>"TSTUT.SLN", "21"=>"TSWB.NASP",  "22"=>"TSWB.SLN", "23"=>"-");
$firing_pattern_parameter_values=array("tstim_ms","istim_pa","delay_ms","pfs_ms","swa_mv","nisi","isiav_ms","sd_ms","max_isi_ms","min_isi_ms","first_isi_ms","isiav1_2_ms","isiav1_3_ms","isiav1_4_ms","last_isi_ms","isiavn_n_1_ms","isiavn_n_2_ms","isiavn_n_3_ms","maxisi_minisi","maxisin_isin_m1","maxisin_isin_p1","ai","rdmax","df","sf","tmax_scaled","isimax_scaled","isiav_scaled","sd_scaled","slope","intercept","slope1","intercept1","css_yc1","xc1","slope2","intercept2","slope3","intercept3","xc2","yc2","f1_2","f1_2crit","f2_3","f2_3crit","f3_4","f3_4crit","p1_2","p2_3","p3_4","p1_2uv","p2_3uv","p3_4uv","isii_isii_m1","i","isiav_i_n_isi1_i_m1","maxisij_isij_m1","maxisij_isij_p1","nisi_c","isiav_ms_c","maxisi_ms_c","minisi_ms_c","first_isi_ms_c","tmax_scaled_c","isimax_scaled_c","isiav_scaled_c","sd_scaled_c","slope_c","intercept_c","slope1_c","intercept1_c","css_yc1_c","xc1_c","slope2_c","intercept2_c","slope3_c","intercept3_c","xc2_c","yc2_c","f1_2_c","f1_2crit_c","f2_3_c","f2_3crit_c","f3_4_c","f3_4crit_c","p1_2_c","p2_3_c","p3_4_c","p1_2uv_c","p2_3uv_c","p3_4uv_c","m_2p","c_2p","m_3p","c1_3p","c2_3p","m1_4p","c1_4p","m2_4p","c2_4p","n_isi_cut_3p","n_isi_cut_4p","f_12","f_crit_12","f_23","f_crit_23","f_34","f_crit_34","p_12","p_12_uv","p_23","p_23_uv","p_34","p_34_uv","m_fasp","c_fasp","n_isi_cut_fasp");
$firing_pattern_names=array("ASP.","ASP.ASP.","ASP.NASP","ASP.SLN","D.","D.ASP.","D.RASP.NASP","D.NASP","D.PSTUT","D.TSWB.NASP","RASP.","RASP.ASP.","RASP.NASP","RASP.SLN","NASP","PSTUT","PSWB","TSTUT.","TSTUT.ASP.","TSTUT.NASP","TSTUT.SLN","TSWB.NASP","TSWB.SLN");
// loop over firing pattern 
for($fp_count=0;$fp_count<count($firing_pattern_names);$fp_count++)
{
	$type_index=0;
	$fp_pattern=$firing_pattern_names[$fp_count];
	$fp_array=getUrlForLink($firing_pattern_parameter_values,$fp_pattern); 
	$view_param_hr=getFPViewParameters($firing_pattern_parameter_values,$fp_pattern,"HR");
	$view_param_mr=getFPViewParameters($firing_pattern_parameter_values,$fp_pattern,"MR");
	// loop over type
	for ($i=0; $i<$number_type; $i++) //$number_type // Here he determines the number of active neuron types to print each row in the data table
	{
		
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
		if ($excit_inhib == 'e')
			$fontColor='#339900';
		elseif ($excit_inhib == 'i')
			$fontColor='#CC0000';
		
		$column_array= array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>','<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$nickname.'"'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>');
		// only push type row that have value for a parameter 
		$flagShow=0;
		// get matrix parameters for a type
		for($index=0;$index<count($view_param_mr);$index++){
			if($fp_array[$id][$view_param_mr[$index]]){
				$title=$fp_array[$id][$view_param_mr[$index]];
				$data=$fp_array[$id][$view_param_mr[$index]];
				$data=explode(",",$data);
				// multiple value of parameter
				if(count($data)>1){
					$min=min($data);
					$max=max($data);
					sort($data);
					$title=implode(", ", $data);
					$title="[ $title ]";
					$count=count($data);
					$valueParameter="<a href='property_page_fp.php?id_neuron=$id&parameter=$fp_pattern&count=$count&page=1' target='_blank'><span title='$title'>$min to $max</span></a>";
				}
				// signle value parameter
				else
					$valueParameter="<a href='property_page_fp.php?id_neuron=$id&parameter=$fp_pattern&count=1&page=1'target='_blank'>$title</a>";
				array_push($column_array,$valueParameter);
				$flagShow=1;
			}
			else
				array_push($column_array,null);
		}
		if($flagShow){
			// push type row for particular firing pattern 
			$rows[$fp_count]["data"][$type_index++]["cell"]=$column_array;
			$responce->rows = $rows;
		}
	}
	// push firing pattern headers(view only parameters) for particular firing pattern 
	$responce->header[$fp_count]=$view_param_hr;	
}
?>
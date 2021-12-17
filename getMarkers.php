<?php
  include ("permission_check.php");
  $research = $_REQUEST['research'];
  // Define all the necessary classes needed for the application
  require_once('class/class.type.php');
  require_once('class/class.property.php');
  require_once('class/class.evidencepropertyyperel.php');
  require_once('class/class.temporary_result_neurons.php');
  include("function/markers/marker_helper.php");
  
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);

if(!isset($_GET['page'])) $page=1;
else $page = $_GET['page'];
//page=1&rows=5&sidx=1&sord=asc
// get how many rows we want to have into the grid - rowNum parameter in the grid
if(!isset($_GET['rows'])) $limit=124;
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
			/* echo "Search Field : ".$_GET['searchField']; // � the name of the field defined in colModel
			echo "Search String : ".$_GET['searchString']; // � the string typed in the search field
			echo "Search Operator : ".$_GET['searchOper']; //� the operator choosen in the search field (ex. equal, greater than, �) */
				
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
$neuron = array("DG"=>'DG(18)',"CA3"=>'CA3(25)',"CA3c"=>'CA3(25)',"CA2"=>'CA2(5)',"CA1"=>'CA1(42)',"SUB"=>'SUB(3)',"EC"=>'EC(31)');
$neuronColor = array("DG"=>'#770000',"CA3"=>'#C08181',"CA3c"=>'#C08181',"CA2"=>'#FFCC00',"CA1"=>'#FF6103',"SUB"=>'#FFCC33',"EC"=>'#336633');
//$prev_subregion="NONE";
for ($i=0; $i<$number_type; $i++) //$number_type // Here he determines the number of active neuron types to print each row in the data table
{
	// ARRAY Creation for hippocampome properties: +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$hippo_property_id = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_property_id_arr = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	

	$hippo_property = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_negative = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_positive = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_weak_positive = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_negative_inference = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);
	
	$hippo_positive_inference = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);
	
	$hippo_unknown = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

	$hippo_color = array("CB"=>NULL,"CR"=>NULL,"PV"=>NULL,"5HT_3"=>NULL,"CB1"=>NULL,"GABAa_alfa"=>NULL,"mGluR1a"=>NULL,"Mus2R"=>NULL,"Sub_P_Rec"=>NULL,"vGluT3"=>NULL,"CCK"=>NULL,"ENK"=>NULL,"NG"=>NULL,"NPY"=>NULL,"SOM"=>NULL,"VIP"=>NULL,"a-act2"=>NULL,"CoupTF_2"=>NULL,"nNOS"=>NULL,"RLN"=>NULL,"AChE"=>NULL,"AMIGO2"=>NULL,"AR-beta1"=>NULL,"AR-beta2"=>NULL,"Astn2"=>NULL,"BDNF"=>NULL,"Bok"=>NULL,"Caln"=>NULL,"CaM"=>NULL,"CaMKII_alpha"=>NULL,"CGRP"=>NULL,"ChAT"=>NULL,"Chrna2"=>NULL,"CRF"=>NULL,"Ctip2"=>NULL,"Cx36"=>NULL,"CXCR4"=>NULL,"Dcn"=>NULL,"Disc1"=>NULL,"DYN"=>NULL,"EAAT3"=>NULL,"ErbB4"=>NULL,"GABAa_alpha2"=>NULL,"GABAa_alpha3"=>NULL,"GABAa_alpha4"=>NULL,"GABAa_alpha5"=>NULL,"GABAa_alpha6"=>NULL,"GABAa_beta1"=>NULL,"GABAa_beta2"=>NULL,"GABAa_beta3"=>NULL,"GABAa_delta"=>NULL,"GABAa_gamma1"=>NULL,"GABAa_gamma2"=>NULL,"GABA-B1"=>NULL,"GAT_1"=>NULL,"GAT-3"=>NULL,"GluA1"=>NULL,"GluA2"=>NULL,"GluA2_3"=>NULL,"GluA3"=>NULL,"GluA4"=>NULL,"GlyT2"=>NULL,"Gpc3"=>NULL,"Grp"=>NULL,"Htr2c"=>NULL,"Id_2"=>NULL,"Kv3_1"=>NULL,"Loc432748"=>NULL,"Man1a"=>NULL,"Math-2"=>NULL,"mGluR1"=>NULL,"mGluR2"=>NULL,"mGluR2_3"=>NULL,"mGluR3"=>NULL,"mGluR4"=>NULL,"mGluR5"=>NULL,"mGluR5a"=>NULL,"mGluR7a"=>NULL,"mGluR8a"=>NULL,"MOR"=>NULL,"Mus1R"=>NULL,"Mus3R"=>NULL,"Mus4R"=>NULL,"Ndst4"=>NULL,"NECAB1"=>NULL,"Neuropilin2"=>NULL,"NKB"=>NULL,"Nov"=>NULL,"Nr3c2"=>NULL,"Nr4a1"=>NULL,"p-CREB"=>NULL,"PCP4"=>NULL,"PPE"=>NULL,"PPTA"=>NULL,"Prox1"=>NULL,"Prss12"=>NULL,"Prss23"=>NULL,"PSA-NCAM"=>NULL,"SATB1"=>NULL,"SATB2"=>NULL,"SCIP"=>NULL,"SPO"=>NULL,"SubP"=>NULL,"Tc1568100"=>NULL,"TH"=>NULL,"vAChT"=>NULL,"vGAT"=>NULL,"vGlut1"=>NULL,"vGluT2"=>NULL,"VILIP"=>NULL,"Wfs1"=>NULL,"Y1"=>NULL,"Y2"=>NULL);

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
	 $excit_inhib =$type-> getExcit_Inhib();
	
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
	
	
	$q=0;

	for ($i5=0; $i5<$n_property; $i5++) // For Each Property id he derieves by using an Index
	{
		$Property_id = $evidencepropertyyperel -> getProperty_id_array($i5); // retrive the respective property id at a particular id index
		
		$property -> retrive_by_id($Property_id); // For each property id retrieve the respective properties
		$rel1 = $property->getRel(); // Retrieve a predicate for a particular property id
		$part1 = $property->getPart(); // Retrieve Subject (from the property table)
		if ($rel1 == 'has expression')
		{
			$id_p[$q] = $property->getID(); // Retrieve the id
			$val[$q] = $property->getVal(); // retrieve object
			$part[$q] = remap_marker_names($property->getPart()); // Retrieve the subject
			$rel[$q] = $property->getRel(); // Retrieve the Predicate
			
			if ($val[$q] == 'positive')
				$hippo_positive[$part[$q]]=1;
			if ($val[$q] == 'negative')
				$hippo_negative[$part[$q]]=1;
			if ($val[$q] == 'weak_positive')
				$hippo_weak_positive[$part[$q]]=1;
			if ($val[$q] == 'positive_inference')
				$hippo_positive_inference[$part[$q]]=1;
			if ($val[$q] == 'negative_inference')
				$hippo_negative_inference[$part[$q]]=1;
			if ($val[$q] == 'unknown')
				$hippo_unknown[$part[$q]]=1;
			
			$hippo_property_id[$part[$q]] = $id_p[$q];
			
			$q = $q+1;
		}	
	}
	
	$hippo_property = determinePosNegCombosForAllMarkers($name_markers, $hippo_positive, $hippo_negative, $hippo_weak_positive, $hippo_positive_inference, $hippo_negative_inference, $hippo_unknown);	

	for ($f1=0; $f1<$n_markers; $f1++) {
		$this_remapped_name = remap_marker_names($name_markers[$f1]);
		
		$evidencepropertyyperel -> retrieve_conflict_note($hippo_property_id[$this_remapped_name], $id);
	    $conflict_note = $evidencepropertyyperel -> getConflict_note();	    
	    $nam_unv1 = check_unvetted1($id, $hippo_property_id[$this_remapped_name], $evidencepropertyyperel);
	    
		$img = check_color($hippo_property[$name_markers[$f1]], $nam_unv1, $conflict_note,$permission);
		
		$hippo[$name_markers[$f1]] = $img[0];
		
		if ($img[1] == NULL)
			$hippo[$name_markers[$f1]] = $img[0];
		else	
			$hippo_color[$name_markers[$f1]] = $img[1];
	}
	
		
	preg_match('!\d+!',substr($type->getName(),strpos($type->getName(), ')')),$matches);
	$neurite_pattern=str_split($matches[0]);
	$neurite_pattern_temp = str_replace($neurite_pattern[$soma_position], "<strong>".$neurite_pattern[$soma_position]."</strong>", $neurite_pattern);
	$neurite_pattern_soma_location = implode('',$neurite_pattern_temp);
	
	if ($excit_inhib == 'e')
		$fontColor='#339900';
	elseif ($excit_inhib == 'i')
		$fontColor='#CC0000';
	
	if ($type->get_type_subtype($id) == 'subtype'){
		$fontColor='#000099';
		if ($excit_inhib == 'i')
			$fontColor='#CC5500';
		$rows[$i]['cell']=array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>',"    ".'<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>','<span style="color:black;float:right">'.$neurite_pattern_soma_location.'</span>',
		
				getUrlForLink($id,$hippo['CB'],$name_markers['0'],$hippo_color['CB']),
				getUrlForLink($id,$hippo['CR'],$name_markers['1'],$hippo_color['CR']),
				getUrlForLink($id,$hippo['PV'],$name_markers['2'],$hippo_color['PV']),
				
				getUrlForLink($id,$hippo['5HT_3'],$name_markers['3'],$hippo_color['5HT_3']),
				getUrlForLink($id,$hippo['CB1'],$name_markers['4'],$hippo_color['CB1']),
				getUrlForLink($id,$hippo['GABAa_alfa'],$name_markers['5'],$hippo_color['GABAa_alfa']),
				getUrlForLink($id,$hippo['mGluR1a'],$name_markers['6'],$hippo_color['mGluR1a']),
				getUrlForLink($id,$hippo['Mus2R'],$name_markers['7'],$hippo_color['Mus2R']),
				getUrlForLink($id,$hippo['Sub_P_Rec'],$name_markers['8'],$hippo_color['Sub_P_Rec']),
				getUrlForLink($id,$hippo['vGluT3'],$name_markers['9'],$hippo_color['vGluT3']),
				
				getUrlForLink($id,$hippo['CCK'],$name_markers['10'],$hippo_color['CCK']),
				getUrlForLink($id,$hippo['ENK'],$name_markers['11'],$hippo_color['ENK']),
				getUrlForLink($id,$hippo['NG'],$name_markers['12'],$hippo_color['NG']),
				getUrlForLink($id,$hippo['NPY'],$name_markers['13'],$hippo_color['NPY']),
				getUrlForLink($id,$hippo['SOM'],$name_markers['14'],$hippo_color['SOM']),
				getUrlForLink($id,$hippo['VIP'],$name_markers['15'],$hippo_color['VIP']),
				
				
				getUrlForLink($id,$hippo['a-act2'],$name_markers['16'],$hippo_color['a-act2']),
				getUrlForLink($id,$hippo['CoupTF_2'],$name_markers['17'],$hippo_color['CoupTF_2']),
				getUrlForLink($id,$hippo['nNOS'],$name_markers['18'],$hippo_color['nNOS']),
				getUrlForLink($id,$hippo['RLN'],$name_markers['19'],$hippo_color['RLN']),
				
				getUrlForLink($id,$hippo['AChE'],$name_markers['20'],$hippo_color['AChE']),
				getUrlForLink($id,$hippo['AMIGO2'],$name_markers['21'],$hippo_color['AMIGO2']),
				getUrlForLink($id,$hippo['AR-beta1'],$name_markers['22'],$hippo_color['AR-beta1']),
				getUrlForLink($id,$hippo['AR-beta2'],$name_markers['23'],$hippo_color['AR-beta2']),
				getUrlForLink($id,$hippo['Astn2'],$name_markers['24'],$hippo_color['Astn2']),
				getUrlForLink($id,$hippo['BDNF'],$name_markers['25'],$hippo_color['BDNF']),
				getUrlForLink($id,$hippo['Bok'],$name_markers['26'],$hippo_color['Bok']),
				getUrlForLink($id,$hippo['Caln'],$name_markers['27'],$hippo_color['Caln']),
				getUrlForLink($id,$hippo['CaM'],$name_markers['28'],$hippo_color['CaM']),
				getUrlForLink($id,$hippo['CaMKII_alpha'],$name_markers['29'],$hippo_color['CaMKII_alpha']),
				getUrlForLink($id,$hippo['CGRP'],$name_markers['30'],$hippo_color['CGRP']),
				getUrlForLink($id,$hippo['ChAT'],$name_markers['31'],$hippo_color['ChAT']),
				getUrlForLink($id,$hippo['Chrna2'],$name_markers['32'],$hippo_color['Chrna2']),
				getUrlForLink($id,$hippo['CRF'],$name_markers['33'],$hippo_color['CRF']),
				getUrlForLink($id,$hippo['Ctip2'],$name_markers['34'],$hippo_color['Ctip2']),
				getUrlForLink($id,$hippo['Cx36'],$name_markers['35'],$hippo_color['Cx36']),
				getUrlForLink($id,$hippo['CXCR4'],$name_markers['36'],$hippo_color['CXCR4']),
				getUrlForLink($id,$hippo['Dcn'],$name_markers['37'],$hippo_color['Dcn']),
				getUrlForLink($id,$hippo['Disc1'],$name_markers['38'],$hippo_color['Disc1']),
				getUrlForLink($id,$hippo['DYN'],$name_markers['39'],$hippo_color['DYN']),
				getUrlForLink($id,$hippo['EAAT3'],$name_markers['40'],$hippo_color['EAAT3']),
				getUrlForLink($id,$hippo['ErbB4'],$name_markers['41'],$hippo_color['ErbB4']),
				getUrlForLink($id,$hippo['GABAa_alpha2'],$name_markers['42'],$hippo_color['GABAa_alpha2']),
				getUrlForLink($id,$hippo['GABAa_alpha3'],$name_markers['43'],$hippo_color['GABAa_alpha3']),
				getUrlForLink($id,$hippo['GABAa_alpha4'],$name_markers['44'],$hippo_color['GABAa_alpha4']),
				getUrlForLink($id,$hippo['GABAa_alpha5'],$name_markers['45'],$hippo_color['GABAa_alpha5']),
				getUrlForLink($id,$hippo['GABAa_alpha6'],$name_markers['46'],$hippo_color['GABAa_alpha6']),
				getUrlForLink($id,$hippo['GABAa_beta1'],$name_markers['47'],$hippo_color['GABAa_beta1']),
				getUrlForLink($id,$hippo['GABAa_beta2'],$name_markers['48'],$hippo_color['GABAa_beta2']),
				getUrlForLink($id,$hippo['GABAa_beta3'],$name_markers['49'],$hippo_color['GABAa_beta3']),
				getUrlForLink($id,$hippo['GABAa_delta'],$name_markers['50'],$hippo_color['GABAa_delta']),
				getUrlForLink($id,$hippo['GABAa_gamma1'],$name_markers['51'],$hippo_color['GABAa_gamma1']),
				getUrlForLink($id,$hippo['GABAa_gamma2'],$name_markers['52'],$hippo_color['GABAa_gamma2']),
				getUrlForLink($id,$hippo['GABA-B1'],$name_markers['53'],$hippo_color['GABA-B1']),
				getUrlForLink($id,$hippo['GAT_1'],$name_markers['54'],$hippo_color['GAT_1']),
				getUrlForLink($id,$hippo['GAT-3'],$name_markers['55'],$hippo_color['GAT-3']),
				getUrlForLink($id,$hippo['GluA1'],$name_markers['56'],$hippo_color['GluA1']),
				getUrlForLink($id,$hippo['GluA2'],$name_markers['57'],$hippo_color['GluA2']),
				getUrlForLink($id,$hippo['GluA2_3'],$name_markers['58'],$hippo_color['GluA2_3']),
				getUrlForLink($id,$hippo['GluA3'],$name_markers['59'],$hippo_color['GluA3']),
				getUrlForLink($id,$hippo['GluA4'],$name_markers['60'],$hippo_color['GluA4']),			
				getUrlForLink($id,$hippo['GlyT2'],$name_markers['61'],$hippo_color['GlyT2']),
				getUrlForLink($id,$hippo['Gpc3'],$name_markers['62'],$hippo_color['Gpc3']),
				getUrlForLink($id,$hippo['Grp'],$name_markers['63'],$hippo_color['Grp']),
				getUrlForLink($id,$hippo['Htr2c'],$name_markers['64'],$hippo_color['Htr2c']),
				getUrlForLink($id,$hippo['Id_2'],$name_markers['65'],$hippo_color['Id_2']),
				getUrlForLink($id,$hippo['Kv3_1'],$name_markers['66'],$hippo_color['Kv3_1']),
				getUrlForLink($id,$hippo['Loc432748'],$name_markers['67'],$hippo_color['Loc432748']),
				getUrlForLink($id,$hippo['Man1a'],$name_markers['68'],$hippo_color['Man1a']),
				getUrlForLink($id,$hippo['Math-2'],$name_markers['69'],$hippo_color['Math-2']),
				getUrlForLink($id,$hippo['mGluR1'],$name_markers['70'],$hippo_color['mGluR1']),
				getUrlForLink($id,$hippo['mGluR2'],$name_markers['71'],$hippo_color['mGluR2']),
				getUrlForLink($id,$hippo['mGluR2_3'],$name_markers['72'],$hippo_color['mGluR2_3']),
				getUrlForLink($id,$hippo['mGluR3'],$name_markers['73'],$hippo_color['mGluR3']),
				getUrlForLink($id,$hippo['mGluR4'],$name_markers['74'],$hippo_color['mGluR4']),
				getUrlForLink($id,$hippo['mGluR5'],$name_markers['75'],$hippo_color['mGluR5']),
				getUrlForLink($id,$hippo['mGluR5a'],$name_markers['76'],$hippo_color['mGluR5a']),
				getUrlForLink($id,$hippo['mGluR7a'],$name_markers['77'],$hippo_color['mGluR7a']),
				getUrlForLink($id,$hippo['mGluR8a'],$name_markers['78'],$hippo_color['mGluR8a']),
				getUrlForLink($id,$hippo['MOR'],$name_markers['79'],$hippo_color['MOR']),
				getUrlForLink($id,$hippo['Mus1R'],$name_markers['80'],$hippo_color['Mus1R']),
				getUrlForLink($id,$hippo['Mus3R'],$name_markers['81'],$hippo_color['Mus3R']),
				getUrlForLink($id,$hippo['Mus4R'],$name_markers['82'],$hippo_color['Mus4R']),
				getUrlForLink($id,$hippo['Ndst4'],$name_markers['83'],$hippo_color['Ndst4']),
				getUrlForLink($id,$hippo['NECAB1'],$name_markers['84'],$hippo_color['NECAB1']),
				getUrlForLink($id,$hippo['Neuropilin2'],$name_markers['85'],$hippo_color['Neuropilin2']),
				getUrlForLink($id,$hippo['NKB'],$name_markers['86'],$hippo_color['NKB']),
				getUrlForLink($id,$hippo['Nov'],$name_markers['87'],$hippo_color['Nov']),
				getUrlForLink($id,$hippo['Nr3c2'],$name_markers['88'],$hippo_color['Nr3c2']),
				getUrlForLink($id,$hippo['Nr4a1'],$name_markers['89'],$hippo_color['Nr4a1']),
				getUrlForLink($id,$hippo['p-CREB'],$name_markers['90'],$hippo_color['p-CREB']),
				getUrlForLink($id,$hippo['PCP4'],$name_markers['91'],$hippo_color['PCP4']),
				getUrlForLink($id,$hippo['PPE'],$name_markers['92'],$hippo_color['PPE']),
				getUrlForLink($id,$hippo['PPTA'],$name_markers['93'],$hippo_color['PPTA']),
				getUrlForLink($id,$hippo['Prox1'],$name_markers['94'],$hippo_color['Prox1']),
				getUrlForLink($id,$hippo['Prss12'],$name_markers['95'],$hippo_color['Prss12']),
				getUrlForLink($id,$hippo['Prss23'],$name_markers['96'],$hippo_color['Prss23']),
				getUrlForLink($id,$hippo['PSA-NCAM'],$name_markers['97'],$hippo_color['PSA-NCAM']),
				getUrlForLink($id,$hippo['SATB1'],$name_markers['98'],$hippo_color['SATB1']),
				getUrlForLink($id,$hippo['SATB2'],$name_markers['99'],$hippo_color['SATB2']),
				getUrlForLink($id,$hippo['SCIP'],$name_markers['100'],$hippo_color['SCIP']),
				getUrlForLink($id,$hippo['SPO'],$name_markers['101'],$hippo_color['SPO']),
				getUrlForLink($id,$hippo['SubP'],$name_markers['102'],$hippo_color['SubP']),
				getUrlForLink($id,$hippo['Tc1568100'],$name_markers['103'],$hippo_color['Tc1568100']),
				getUrlForLink($id,$hippo['TH'],$name_markers['104'],$hippo_color['TH']),
				getUrlForLink($id,$hippo['vAChT'],$name_markers['105'],$hippo_color['vAChT']),
				getUrlForLink($id,$hippo['vGAT'],$name_markers['106'],$hippo_color['vGAT']),
				getUrlForLink($id,$hippo['vGlut1'],$name_markers['107'],$hippo_color['vGlut1']),
				getUrlForLink($id,$hippo['vGluT2'],$name_markers['108'],$hippo_color['vGluT2']),
				getUrlForLink($id,$hippo['VILIP'],$name_markers['109'],$hippo_color['VILIP']),
				getUrlForLink($id,$hippo['Wfs1'],$name_markers['110'],$hippo_color['Wfs1']),
				getUrlForLink($id,$hippo['Y1'],$name_markers['111'],$hippo_color['Y1']),
				getUrlForLink($id,$hippo['Y2'],$name_markers['112'],$hippo_color['Y2'])
				);
	}
	else{
		$rows[$i]['cell']=array('<span style="color:'.$neuronColor[$subregion].'"><strong>'.$neuron[$subregion].'</strong></span>','<a href="neuron_page.php?id='.$id.'" target="blank" title="'.$type->getName().'"><font color="'.$fontColor.'">'.$nickname.'</font></a>','<span style="color:black;float:right">'.$neurite_pattern_soma_location.'</span>',
	
			getUrlForLink($id,$hippo['CB'],$name_markers['0'],$hippo_color['CB']),
			getUrlForLink($id,$hippo['CR'],$name_markers['1'],$hippo_color['CR']),
			getUrlForLink($id,$hippo['PV'],$name_markers['2'],$hippo_color['PV']),
			
			getUrlForLink($id,$hippo['5HT_3'],$name_markers['3'],$hippo_color['5HT_3']),
			getUrlForLink($id,$hippo['CB1'],$name_markers['4'],$hippo_color['CB1']),
			getUrlForLink($id,$hippo['GABAa_alfa'],$name_markers['5'],$hippo_color['GABAa_alfa']),
			getUrlForLink($id,$hippo['mGluR1a'],$name_markers['6'],$hippo_color['mGluR1a']),
			getUrlForLink($id,$hippo['Mus2R'],$name_markers['7'],$hippo_color['Mus2R']),
			getUrlForLink($id,$hippo['Sub_P_Rec'],$name_markers['8'],$hippo_color['Sub_P_Rec']),
			getUrlForLink($id,$hippo['vGluT3'],$name_markers['9'],$hippo_color['vGluT3']),
			
			getUrlForLink($id,$hippo['CCK'],$name_markers['10'],$hippo_color['CCK']),
			getUrlForLink($id,$hippo['ENK'],$name_markers['11'],$hippo_color['ENK']),
			getUrlForLink($id,$hippo['NG'],$name_markers['12'],$hippo_color['NG']),
			getUrlForLink($id,$hippo['NPY'],$name_markers['13'],$hippo_color['NPY']),
			getUrlForLink($id,$hippo['SOM'],$name_markers['14'],$hippo_color['SOM']),
			getUrlForLink($id,$hippo['VIP'],$name_markers['15'],$hippo_color['VIP']),
			
			
			getUrlForLink($id,$hippo['a-act2'],$name_markers['16'],$hippo_color['a-act2']),
			getUrlForLink($id,$hippo['CoupTF_2'],$name_markers['17'],$hippo_color['CoupTF_2']),
			getUrlForLink($id,$hippo['nNOS'],$name_markers['18'],$hippo_color['nNOS']),
			getUrlForLink($id,$hippo['RLN'],$name_markers['19'],$hippo_color['RLN']),
			
				getUrlForLink($id,$hippo['AChE'],$name_markers['20'],$hippo_color['AChE']),
				getUrlForLink($id,$hippo['AMIGO2'],$name_markers['21'],$hippo_color['AMIGO2']),
				getUrlForLink($id,$hippo['AR-beta1'],$name_markers['22'],$hippo_color['AR-beta1']),
				getUrlForLink($id,$hippo['AR-beta2'],$name_markers['23'],$hippo_color['AR-beta2']),
				getUrlForLink($id,$hippo['Astn2'],$name_markers['24'],$hippo_color['Astn2']),
				getUrlForLink($id,$hippo['BDNF'],$name_markers['25'],$hippo_color['BDNF']),
				getUrlForLink($id,$hippo['Bok'],$name_markers['26'],$hippo_color['Bok']),
				getUrlForLink($id,$hippo['Caln'],$name_markers['27'],$hippo_color['Caln']),
				getUrlForLink($id,$hippo['CaM'],$name_markers['28'],$hippo_color['CaM']),
				getUrlForLink($id,$hippo['CaMKII_alpha'],$name_markers['29'],$hippo_color['CaMKII_alpha']),
				getUrlForLink($id,$hippo['CGRP'],$name_markers['30'],$hippo_color['CGRP']),
				getUrlForLink($id,$hippo['ChAT'],$name_markers['31'],$hippo_color['ChAT']),
				getUrlForLink($id,$hippo['Chrna2'],$name_markers['32'],$hippo_color['Chrna2']),
				getUrlForLink($id,$hippo['CRF'],$name_markers['33'],$hippo_color['CRF']),
				getUrlForLink($id,$hippo['Ctip2'],$name_markers['34'],$hippo_color['Ctip2']),
				getUrlForLink($id,$hippo['Cx36'],$name_markers['35'],$hippo_color['Cx36']),
				getUrlForLink($id,$hippo['CXCR4'],$name_markers['36'],$hippo_color['CXCR4']),
				getUrlForLink($id,$hippo['Dcn'],$name_markers['37'],$hippo_color['Dcn']),
				getUrlForLink($id,$hippo['Disc1'],$name_markers['38'],$hippo_color['Disc1']),
				getUrlForLink($id,$hippo['DYN'],$name_markers['39'],$hippo_color['DYN']),
				getUrlForLink($id,$hippo['EAAT3'],$name_markers['40'],$hippo_color['EAAT3']),
				getUrlForLink($id,$hippo['ErbB4'],$name_markers['41'],$hippo_color['ErbB4']),
				getUrlForLink($id,$hippo['GABAa_alpha2'],$name_markers['42'],$hippo_color['GABAa_alpha2']),
				getUrlForLink($id,$hippo['GABAa_alpha3'],$name_markers['43'],$hippo_color['GABAa_alpha3']),
				getUrlForLink($id,$hippo['GABAa_alpha4'],$name_markers['44'],$hippo_color['GABAa_alpha4']),
				getUrlForLink($id,$hippo['GABAa_alpha5'],$name_markers['45'],$hippo_color['GABAa_alpha5']),
				getUrlForLink($id,$hippo['GABAa_alpha6'],$name_markers['46'],$hippo_color['GABAa_alpha6']),
				getUrlForLink($id,$hippo['GABAa_beta1'],$name_markers['47'],$hippo_color['GABAa_beta1']),
				getUrlForLink($id,$hippo['GABAa_beta2'],$name_markers['48'],$hippo_color['GABAa_beta2']),
				getUrlForLink($id,$hippo['GABAa_beta3'],$name_markers['49'],$hippo_color['GABAa_beta3']),
				getUrlForLink($id,$hippo['GABAa_delta'],$name_markers['50'],$hippo_color['GABAa_delta']),
				getUrlForLink($id,$hippo['GABAa_gamma1'],$name_markers['51'],$hippo_color['GABAa_gamma1']),
				getUrlForLink($id,$hippo['GABAa_gamma2'],$name_markers['52'],$hippo_color['GABAa_gamma2']),
				getUrlForLink($id,$hippo['GABA-B1'],$name_markers['53'],$hippo_color['GABA-B1']),
				getUrlForLink($id,$hippo['GAT_1'],$name_markers['54'],$hippo_color['GAT_1']),
				getUrlForLink($id,$hippo['GAT-3'],$name_markers['55'],$hippo_color['GAT-3']),
				getUrlForLink($id,$hippo['GluA1'],$name_markers['56'],$hippo_color['GluA1']),
				getUrlForLink($id,$hippo['GluA2'],$name_markers['57'],$hippo_color['GluA2']),
				getUrlForLink($id,$hippo['GluA2_3'],$name_markers['58'],$hippo_color['GluA2_3']),
				getUrlForLink($id,$hippo['GluA3'],$name_markers['59'],$hippo_color['GluA3']),
				getUrlForLink($id,$hippo['GluA4'],$name_markers['60'],$hippo_color['GluA4']),			
				getUrlForLink($id,$hippo['GlyT2'],$name_markers['61'],$hippo_color['GlyT2']),
				getUrlForLink($id,$hippo['Gpc3'],$name_markers['62'],$hippo_color['Gpc3']),
				getUrlForLink($id,$hippo['Grp'],$name_markers['63'],$hippo_color['Grp']),
				getUrlForLink($id,$hippo['Htr2c'],$name_markers['64'],$hippo_color['Htr2c']),
				getUrlForLink($id,$hippo['Id_2'],$name_markers['65'],$hippo_color['Id_2']),
				getUrlForLink($id,$hippo['Kv3_1'],$name_markers['66'],$hippo_color['Kv3_1']),
				getUrlForLink($id,$hippo['Loc432748'],$name_markers['67'],$hippo_color['Loc432748']),
				getUrlForLink($id,$hippo['Man1a'],$name_markers['68'],$hippo_color['Man1a']),
				getUrlForLink($id,$hippo['Math-2'],$name_markers['69'],$hippo_color['Math-2']),
				getUrlForLink($id,$hippo['mGluR1'],$name_markers['70'],$hippo_color['mGluR1']),
				getUrlForLink($id,$hippo['mGluR2'],$name_markers['71'],$hippo_color['mGluR2']),
				getUrlForLink($id,$hippo['mGluR2_3'],$name_markers['72'],$hippo_color['mGluR2_3']),
				getUrlForLink($id,$hippo['mGluR3'],$name_markers['73'],$hippo_color['mGluR3']),
				getUrlForLink($id,$hippo['mGluR4'],$name_markers['74'],$hippo_color['mGluR4']),
				getUrlForLink($id,$hippo['mGluR5'],$name_markers['75'],$hippo_color['mGluR5']),
				getUrlForLink($id,$hippo['mGluR5a'],$name_markers['76'],$hippo_color['mGluR5a']),
				getUrlForLink($id,$hippo['mGluR7a'],$name_markers['77'],$hippo_color['mGluR7a']),
				getUrlForLink($id,$hippo['mGluR8a'],$name_markers['78'],$hippo_color['mGluR8a']),
				getUrlForLink($id,$hippo['MOR'],$name_markers['79'],$hippo_color['MOR']),
				getUrlForLink($id,$hippo['Mus1R'],$name_markers['80'],$hippo_color['Mus1R']),
				getUrlForLink($id,$hippo['Mus3R'],$name_markers['81'],$hippo_color['Mus3R']),
				getUrlForLink($id,$hippo['Mus4R'],$name_markers['82'],$hippo_color['Mus4R']),
				getUrlForLink($id,$hippo['Ndst4'],$name_markers['83'],$hippo_color['Ndst4']),
				getUrlForLink($id,$hippo['NECAB1'],$name_markers['84'],$hippo_color['NECAB1']),
				getUrlForLink($id,$hippo['Neuropilin2'],$name_markers['85'],$hippo_color['Neuropilin2']),
				getUrlForLink($id,$hippo['NKB'],$name_markers['86'],$hippo_color['NKB']),
				getUrlForLink($id,$hippo['Nov'],$name_markers['87'],$hippo_color['Nov']),
				getUrlForLink($id,$hippo['Nr3c2'],$name_markers['88'],$hippo_color['Nr3c2']),
				getUrlForLink($id,$hippo['Nr4a1'],$name_markers['89'],$hippo_color['Nr4a1']),
				getUrlForLink($id,$hippo['p-CREB'],$name_markers['90'],$hippo_color['p-CREB']),
				getUrlForLink($id,$hippo['PCP4'],$name_markers['91'],$hippo_color['PCP4']),
				getUrlForLink($id,$hippo['PPE'],$name_markers['92'],$hippo_color['PPE']),
				getUrlForLink($id,$hippo['PPTA'],$name_markers['93'],$hippo_color['PPTA']),
				getUrlForLink($id,$hippo['Prox1'],$name_markers['94'],$hippo_color['Prox1']),
				getUrlForLink($id,$hippo['Prss12'],$name_markers['95'],$hippo_color['Prss12']),
				getUrlForLink($id,$hippo['Prss23'],$name_markers['96'],$hippo_color['Prss23']),
				getUrlForLink($id,$hippo['PSA-NCAM'],$name_markers['97'],$hippo_color['PSA-NCAM']),
				getUrlForLink($id,$hippo['SATB1'],$name_markers['98'],$hippo_color['SATB1']),
				getUrlForLink($id,$hippo['SATB2'],$name_markers['99'],$hippo_color['SATB2']),
				getUrlForLink($id,$hippo['SCIP'],$name_markers['100'],$hippo_color['SCIP']),
				getUrlForLink($id,$hippo['SPO'],$name_markers['101'],$hippo_color['SPO']),
				getUrlForLink($id,$hippo['SubP'],$name_markers['102'],$hippo_color['SubP']),
				getUrlForLink($id,$hippo['Tc1568100'],$name_markers['103'],$hippo_color['Tc1568100']),
				getUrlForLink($id,$hippo['TH'],$name_markers['104'],$hippo_color['TH']),
				getUrlForLink($id,$hippo['vAChT'],$name_markers['105'],$hippo_color['vAChT']),
				getUrlForLink($id,$hippo['vGAT'],$name_markers['106'],$hippo_color['vGAT']),
				getUrlForLink($id,$hippo['vGlut1'],$name_markers['107'],$hippo_color['vGlut1']),
				getUrlForLink($id,$hippo['vGluT2'],$name_markers['108'],$hippo_color['vGluT2']),
				getUrlForLink($id,$hippo['VILIP'],$name_markers['109'],$hippo_color['VILIP']),
				getUrlForLink($id,$hippo['Wfs1'],$name_markers['110'],$hippo_color['Wfs1']),
				getUrlForLink($id,$hippo['Y1'],$name_markers['111'],$hippo_color['Y1']),
				getUrlForLink($id,$hippo['Y2'],$name_markers['112'],$hippo_color['Y2'])
			);
	}
	$responce->rows = $rows;

}

//Retrieve header names from database by creating [key,value] pair
		$headernames= array();
		
		$keys=array_keys($hippo_property_id_arr);

		//Function as a replacement of mysql_real_escape_string()
		function real_escape($value)
		{
    		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
   			 $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

   			 return str_replace($search, $replace, $value);
		}
		for($ind=0;$ind<$n_markers;$ind++){
    		$key=$keys[$ind];

    		$post=real_escape($key);

    		$header_query= "Select Distinct object from Property  where subject= '$post' and predicate = 'has name'";
    		
    		$header_result=mysqli_query($GLOBALS['conn'],$header_query);
     
    		$rows = mysqli_fetch_array($header_result, MYSQLI_ASSOC);
    
    		$headernames[$key]=$rows['object'];
    		
    		
    
}

    $responce->header=$headernames;
//echo json_encode($responce);
?>

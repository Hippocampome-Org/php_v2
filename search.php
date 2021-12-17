<?php

  include ("permission_check.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

session_start();

include ("function/property.php");

include ("function/part.php");

include ("function/relation.php");

include ("function/value.php");

include ("function/ephys_unit_table.php");

require_once('class/class.type.php');

require_once('class/class.epdata.php');

require_once('class/class.property.php');

require_once('class/class.evidencepropertyyperel.php');

require_once('class/class.epdataevidencerel.php');

require_once('class/class.temporary_search.php');



$type = new type($class_type);

$number_type = $type->getNumber_type();

$epdata = new epdata($class_epdata);

$property_ob = new property($class_property);

$evidencepropertyyperel =  new evidencepropertyyperel($class_evidence_property_type_rel);

$epdataevidencerel =  new epdataevidencerel($class_epdataevidencerel);

$temporary_search = new temporary_search();



$full_search_string="";





// Comes from INDEX:PHP and in this case the program creates the temporary table:

if ($_REQUEST['searching'])

{

	$ip_address = $_SERVER['REMOTE_ADDR'];

	$ip_address = str_replace('.', '_', $ip_address);

	$time_t = time();

	

	$name_temporary_table ='search1_'.$ip_address."__".$time_t;

	echo " Temporary Table Name : ".$name_temporary_table;

	$_SESSION['name_temporary_table'] = $name_temporary_table;



	// Creates the temporary table:

	$temporary_search -> setName_table($name_temporary_table);

	$temporary_search -> create_temp_table();

	

	$temporary_search -> insert_temporary('1', NULL, NULL, NULL, NULL, NULL);	

}





$N = $_REQUEST['N'];

{

	// ************ INSERT THE DATA IN THE TEMPORARY TABLE ********************************************************************************			

	// Insert the property in the temporary table: --------------------------------------------------------------

	$property = $_REQUEST['property'];

	if ($property)

	{		

		$name_temporary_table = $_SESSION['name_temporary_table'];

		

		$temporary_search -> setName_table($name_temporary_table);

		$temporary_search -> update(1, $property, NULL, NULL, NULL, $N);	

	}

	

	// Insert the part in the temporary table: --------------------------------------------------------------

	$part = $_REQUEST['part'];

	if ($part)

	{	

		$name_temporary_table = $_SESSION['name_temporary_table'];

	

		$temporary_search -> setName_table($name_temporary_table);

		$temporary_search -> update(2, NULL, $part, NULL, NULL, $N);

	}

	

	// Insert the part in the temporary table: --------------------------------------------------------------

	$relation = $_REQUEST['relation'];

	if ($relation)

	{	

		$name_temporary_table = $_SESSION['name_temporary_table'];



		$temporary_search -> setName_table($name_temporary_table);

		$temporary_search -> update(3, NULL, NULL, $relation, NULL, $N);

	}

	

	// Insert the value in the temporary table: --------------------------------------------------------------

	$value = $_REQUEST['value'];

	if ($value||$value==0)

	{	

		$name_temporary_table = $_SESSION['name_temporary_table'];



		$temporary_search -> setName_table($name_temporary_table);

		$temporary_search -> update(4, NULL, NULL, NULL, $value, $N);

	}

		

	// OPERATOR *** creates a new searc line and nue row in the temporary table:

	$operator = $_REQUEST['operator'];

	if ($operator)

	{

		print($name_temporary_table);

		$N = $_REQUEST['N'];

		$N_old = $N - 1;

	

		$name_temporary_table = $_SESSION['name_temporary_table'];

		$temporary_search -> setName_table($name_temporary_table);

		

		// Check if all field are filled, otherway the program does not insert a new line:		

		$temporary_search -> retrieve_by_id($N_old);

		

		$property3 = $temporary_search -> getProperty();

		$part3 = $temporary_search -> getPart();

		$relation3 = $temporary_search -> getRelation();

		$value3 = $temporary_search -> getValue();	

					

		if (($property3 == 'Molecular markers') || ($property3 == 'Major Neurotransmitter'))

		{

			if ( ($property3 != NULL) && ($part3 != NULL) && ($relation3 != NULL )

			&& ($property3 != '-') && ($part3 != '-') && ($relation3 != '-' ) )

			{

					$temporary_search -> insert_temporary($N, NULL, NULL, NULL, NULL, $operator);

			}	

		

		}

		else if($property3 == 'Unique Id'){

			if ( ($relation3 != NULL ) && ($value3 != NULL)  && ($relation3 != '-' ) && ($value3 != '-'))

				$temporary_search -> insert_temporary($N, NULL, NULL, NULL, NULL, $operator);

		}	

		else 

		{

			if ( ($property3 != NULL) && ($part3 != NULL) && ($relation3 != NULL ) && ($value3 != NULL) 

			&& ($property3 != '-') && ($part3 != '-') && ($relation3 != '-' ) && ($value3 != '-'))

			{

					$temporary_search -> insert_temporary($N, NULL, NULL, NULL, NULL, $operator);

			}

		}

	}



	// Remove a search line:

	$line = $_REQUEST['remove_line'];

	if ($line)

	{

		$name_temporary_table = $_SESSION['name_temporary_table'];

		$temporary_search -> setName_table($name_temporary_table);



		$temporary_search -> remove_line($line);

	}

	

	// ***************************************************************************************************************************

}





// Clear all ---------------------------------------------

if ($_REQUEST['clear_all'])

{

	$name_temporary_table = $_SESSION['name_temporary_table'];

	$query = "TRUNCATE $name_temporary_table";

	$rs = mysqli_query($GLOBALS['conn'],$query);



	// Creates the temporary table:

	$temporary_search -> setName_table($name_temporary_table);	

	$temporary_search -> insert_temporary('1', NULL, NULL, NULL, NULL, NULL);

}

// -------------------------------------------------------







$n_property = 8;



?>





<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?php

$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user

$rs = mysqli_query($conn,$query);

list($permission) = mysqli_fetch_row($rs);

?>

<script type="text/javascript">

// Javascript function *****************************************************************************************************

function property(link, i0)

{

	

	var property_name=link[link.selectedIndex].value;

	var N = i0;



	var destination_page = "search.php";

	location.href = destination_page+"?property="+property_name+"&N="+N;

}



function part_js(link, i0)

{

	var part_name=link[link.selectedIndex].value;

	var N = i0;



	var destination_page = "search.php";

	part_name=encodeURIComponent(part_name);

	location.href = destination_page+"?part="+part_name+"&N="+N;

}



function relation(link, i0)

{

	var relation_name=link[link.selectedIndex].value;

	var N = i0;



	var destination_page = "search.php";

	location.href = destination_page+"?relation="+relation_name+"&N="+N;

}



function value1(link, i0)

{

	var name=link[link.selectedIndex].value;

	var N = i0;



	var destination_page = "search.php";

	location.href = destination_page+"?value="+name+"&N="+N;

}



function operator(link, i0)

{

	var name=link[link.selectedIndex].value;

	var N = i0;



	var N_new = N + 1;

	

	var destination_page = "search.php";

	location.href = destination_page+"?operator="+name+"&N="+N_new;

}



</script>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php 

include ("function/icon.html"); 

?>

<title>Find Neuron</title>

<script type="text/javascript" src="style/resolution.js"></script>

</head>



<body>



<!-- COPY IN ALL PAGES -->

<?php 

	include ("function/title.php");

	include ("function/menu_main.php");

?>	



<div class='title_area'>

	<font class="font1">Search by neuron type</font>

</div>

		

<!-- submenu no tabs 

<div class='sub_menu'>

	<table width="90%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td width="100%" align="left">

			<font class='font1'><em>Find:</em></font> &nbsp; &nbsp; 

		

			<font class="font7_B">Neuron</font> <font class="font7_A">|</font> 

			<a href="find_author.php?searching=1"><font class="font7"> Author</font> </a> <font class="font7_A">|</font> 

			<a href="find_pmid.php?searching=1"><font class="font7"> PMID/ISBN</font> </a><font class="font7_A">|</font> 

			</font>	

		</td>

	</tr>

	</table>

</div>

-->

<!-- ------------------------ -->



<div class="table_position_search_page">

<table width="95%" border="0" cellspacing="5" cellpadding="0" class='body_table'>

  <tr>

    <td >

		<!-- ****************  BODY **************** -->	

		<table border="0" cellspacing="3" cellpadding="0" class='table_search'>

		<tr>

			<td align="center" width="4%" class='table_neuron_page3'>  </td>

			<td align="center" width="22%" class='table_neuron_page3'> Property </td>

			<td align="center" width="18%" class='table_neuron_page3'> Part </td>

			<td align="center" width="22%" class='table_neuron_page3'> Relation </td>

			<td align="center" width="31%" class='table_neuron_page3'> Value </td>

			<td align="center" width="8%" class='table_neuron_page3'>  Operator </td>

		</tr>

	<?php

		

		$temporary_search -> retrieve_n_search();

		$n_search = $temporary_search -> getN_search();

		

		// Retrieve Number of ID:

		$temporary_search -> retrieve_id_array();

		$n_id = $temporary_search -> getN_id();

		

		

		for ($i0=0; $i0<$n_id; $i0++)

			$id_2[$i0] = $temporary_search -> getID_array($i0);





		for ($i0=0; $i0<$n_id; $i0++)

		{	

			print ("<tr>");

			

			$temporary_search -> retrieve_by_id($id_2[$i0]);

			

			$id1 = $temporary_search -> getID();

			$N1 = $temporary_search -> getN();

			$property1 = $temporary_search -> getProperty();

			$part1 = $temporary_search -> getPart();

			$relation1 = $temporary_search -> getRelation();

			$value1 = $temporary_search -> getValue();

			

			if ( ($n_id != 1) || ($i0 != 0) ) {

				print ("<td align='center' width='4%' class='table_neuron_page1'>

						<a href='search.php?remove_line=$id1'><img src='images/delete.png' width='15px' border='0'></a>

						</td>");

			}

			else

				print ("<td align='center' width='4%'> </td>");

				

			// Property **************************************************************************************************

			print ("<td width='22%' align='center' class='table_neuron_page1'>");

			print ("<select name='property' size='1' cols='10' class='select1' onChange=\"property(this, $id1)\">");

			 

			//Permission blocks the page content related to Firing Pattern

  

			if($property1){

				$property1_adj = $property1;
				if ($property1 == "Electrophysiology") {
					$property1_adj = "Membrane Biophysics";
				}				

                print("<OPTION VALUE='$property1'>$property1_adj</OPTION>");

			}



			print ("<OPTION VALUE='-'>-</OPTION>");

			for ($i=0; $i<$n_property; $i++)

			{

				$value_property = property($i); 

				$value_property_adj = $value_property;
				if ($value_property == "Electrophysiology") {
					$value_property_adj = "Membrane Biophysics";
				}

				if (($value_property != $property1)){

                    print ("<OPTION VALUE='$value_property'>$value_property_adj</OPTION>");

                }

			}

			print ("</select>");

			print ("</td>");

			// END Property **************************************************************************************************



			// Part **************************************************************************************************	

			$value_part = array();

		

			if ($property1 == 'Morphology')

				$n_part = 3;

			if ($property1 == 'Molecular markers')

			{

				getSubject_untracked();	// Function to store all the untracked Subjects from the property table (function/part.php)

				$n_part = 96;

			}

			if ($property1 == 'Electrophysiology')

				$n_part = 10;		

			if ($property1 == 'Connectivity')

				$n_part = 2;

			if ($property1 == 'Major Neurotransmitter')	

				$n_part = 2;

			if ($property1 == 'Unique Id')	

				$n_part = 0;								

			if($property1=='Firing Pattern' or $property1=='Firing Pattern Parameter'){

				if($property1=='Firing Pattern'){

					$value_part=partFiringPattern(); 

					array_push($value_part,"All");

					$phenotype=array("ASP Element","D Element","RASP Element","TSTUT Element","TSWB Element","NASP Element","PSTUT Element","PSWB Element","SLN Element");

					$value_part=array_merge($phenotype,$value_part);

					$n_part=count($value_part);

				}

				if($property1=='Firing Pattern Parameter'){

					$value_part=partFiringPatternParameter(); 

					$n_part=count($value_part);

				}



			}

			else{

				for ($i=0; $i<$n_part; $i++)

					$value_part[$i] = part($i, $property1); 

			}

								

			print ("<td width='18%' align='center' class='table_neuron_page1'>");

			if($property1 != 'Unique Id'){



			print ("<select name='part' size='1' cols='10' class='select1' onChange=\"part_js(this, $id1)\">");

			if ($part1)

				print ("<OPTION VALUE='$part1'>$part1</OPTION>");

			

			print ("<OPTION VALUE='-'>-</OPTION>");

			

			if ($property1 == 'Molecular markers')

			{

				// Store the first 20 Tracked markers(part) in a separate array

				// and conver into lower case

				for($iter = 0; $iter < 20; $iter++)

				{

					$value_part_tracked[$iter] = $value_part[$iter];

					$lowercase = strtolower($value_part_tracked[$iter]);

					$value_part_tracked[$iter] = $lowercase;

				}	

				

				// Store the Untracked markers(part) - untracked markers start from 20th index

				// and conver into lower case

				for($j_iter = 20; $j_iter < count($value_part); $j_iter++)

				{

					$value_part_untracked[$j_iter] = $value_part[$j_iter];

					$lowercase = strtolower($value_part_untracked[$iter]);

					$value_part_untracked[$iter] = $lowercase;

				}

				

				// Copy all the Part to a temporary arrary

				for ($c = 0; $c < count($value_part); $c++) {

						$value_part_temp[$c] = $value_part[$c];

				}

				

				// Sort the Tracker Markers (Part)

				sort($value_part_tracked);

				

				// --------------------------------------------------------

				// --------------------------------------------------------

				// Since "value_part_untracked" array starts from 20th index

				// and sort() function doesn't correctly sort this array

				// Hence a temp array has been used to store the untracked marker starting from 0th index

				// After sorting the temp array is used to store back to "value_part_untracked" array that 

				// begins from 20th index for further processing

				$counter = 20;

				for($k_iter = 0; $k_iter < count($value_part_untracked); $k_iter++)

				{

					$value_part_untracked_temp[$k_iter] = $value_part_untracked[$counter];

					$counter++;

				}

	

				sort($value_part_untracked_temp);

				

				$counter = 20;

				for($k_iter = 0; $k_iter < count($value_part_untracked_temp); $k_iter++)

				{

					$value_part_untracked[$counter] = $value_part_untracked_temp[$k_iter];

					$counter++;

				}

				// --------------------------------------------------------

				// --------------------------------------------------------

				

				for ($c = 0; $c < count($value_part); $c++) 

				{

					// Add a Delimeter after all the tracked markers

					if($c == 20)

						print ("<OPTION VALUE='--'>-------------------</OPTION>");

						

					for($cc=0;$cc<count($value_part_temp);$cc++)

					{

						if($c < 20)

						{

							// Check all the Tracked Markers have correct names

							if(strcasecmp($value_part_tracked[$c],$value_part_temp[$cc])==0)

							{

								$value_part_tracked[$c] = $value_part_temp[$cc];

								

								// Check if Part is already used by the user; if not print

								if ($value_part_tracked[$c] != $part1)

									print ("<OPTION VALUE='$value_part_tracked[$c]'>$value_part_tracked[$c]</OPTION>");

							}

						}

						else	

						{

							// Check all the Untracked Markers have correct names

							if(strcasecmp($value_part_untracked[$c],$value_part_temp[$cc])==0)

							{

								$value_part_untracked[$c] = $value_part_temp[$cc];

								

								// Check if Part is already used by the user; if not print

								if ($value_part_untracked[$c] != $part1)

									print ("<OPTION VALUE='$value_part_untracked[$c]'>$value_part_untracked[$c]</OPTION>");

							}

						}

					}

				}

			}

			else // if ($property1 != 'Molecular markers')

			{

				if($property1 !='Firing Pattern Parameter'){

					for ($c = 0; $c < count($value_part); $c++)

					{

						$value_part_temp[$c] = $value_part[$c];

					}

					for ($c = 0; $c < count($value_part); $c++)

					{

						$lowercase = strtolower($value_part[$c]);

						$value_part[$c] = $lowercase;

					}

					sort($value_part);

					for ($c = 0; $c < count($value_part); $c++)

					{

						for($cc=0;$cc<count($value_part_temp);$cc++)

						{

							if(strcasecmp($value_part[$c],$value_part_temp[$cc])==0)

							{

								$value_part[$c]=$value_part_temp[$cc];

							}

						}

					}

				}

				for ($i=0; $i<$n_part; $i++)

				{

					if ($value_part[$i] != $part1)

						print ("<OPTION VALUE='$value_part[$i]'>$value_part[$i]</OPTION>");

				}

			}

			print ("</select>");

			}

			print ("</td>");				

			// END Part **************************************************************************************************



			// Relation **************************************************************************************************

			if ($property1 == 'Morphology')

				$n_relation = 2;

			if ($property1 == 'Molecular markers')

				$n_relation = 6;

			if ($property1 == 'Electrophysiology'||$property1 == 'Unique Id')

				$n_relation = 5;	

			if ($property1 == 'Connectivity')

				$n_relation = 3;

			if ($property1 == 'Major Neurotransmitter')

				$n_relation = 2;

			if ($property1 == 'Firing Pattern')

				$n_relation = 5;

			if ($property1 == 'Firing Pattern Parameter')

				$n_relation = 5;

			

			print ("<td width='22%' align='center' class='table_neuron_page1'>");									



			print ("<select name='relation' size='1' cols='10' class='select1'  onChange=\"relation(this, $id1)\">");

			

			if ($relation1)

				print ("<OPTION VALUE='$relation1'>$relation1</OPTION>");

			

			print ("<OPTION VALUE='-'>-</OPTION>");

			

			for ($i=0; $i<$n_relation; $i++) {

				$value_relation = relation($i, $property1, $part1);

				

				if ($value_relation != $relation1)

					print ("<OPTION VALUE='$value_relation'>$value_relation</OPTION>");

			}

			

			print ("</select>");



				

			print ("</td>");																	

			// END Relation **************************************************************************************************



			// Value **************************************************************************************************				

			if ($property1 == 'Electrophysiology') {	

				// in case Electrophysiology is need to have the max, min and mean of value1 from table Epdata------------

				if ($part1 == 'tau m')

					$part2 = 'tm';

				else if ($part1 == 'R in')

					$part2 = 'Rin';		

				else if ($part1 == 'V rest')

					$part2 = 'Vrest';

				else if ($part1 == 'V thresh')

					$part2 = 'Vthresh';

				else if ($part1 == 'Fast AHP')

					$part2 = 'fast_AHP';

				else if ($part1 == 'AP ampl')

					$part2 = 'AP_ampl';						

				else if ($part1 == 'AP width')

					$part2 = 'AP_width';						

				else if ($part1 == 'Max F.R.')

					$part2 = 'max_fr';					

				else if ($part1 == 'Slow AHP')

					$part2 = 'slow_AHP';						

				else if ($part1 == 'Sag ratio')

					$part2 = 'sag_ratio';					

				else

					$part2 = $part1;

	

				$unit = $ephys_unit_table[$part2];

				$property_ob -> retrive_ID(3, $part2, NULL, NULL);

				$n_id_property = $property_ob -> getNumber_type();

						

				for ($z1=0; $z1<$n_id_property; $z1++) {

					$property_id = $property_ob -> getProperty_id($z1);



					$evidencepropertyyperel -> retrive_evidence_id1($property_id);

				

					$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();

				

					for ($z2=0; $z2<$n_evidence_id ; $z2++)

					{

						$evidence_id = $evidencepropertyyperel -> getEvidence_id_array($z2);

					

						$epdataevidencerel -> retrive_Epdata($evidence_id);

						$id_epdata = $epdataevidencerel -> getEpdata_id();

					

						$epdata -> retrive_value1_array($id_epdata);

					

						$value_1[$z2] = $epdata -> getValue1_array(0);						

					}

				}

							

			 	if ($part2 != NULL)

					sort ($value_1);



	            // STM Setting min/max values via SQL

	            //$query_base = " FROM Epdata WHERE subject = '$part2'";

	            //$max_query = "SELECT MAX (value1)" . $query_base;

	            //$min_query = "SELECT MIN (value1)" . $query_base;

	

	            $yy=$n_evidence_id-1;			

	            $min_value1 = $value_1[0];

	            $max_value1 = $value_1[$yy]; 

	

	            // Mean: 

	            $mean_value1 = ($min_value1 + $max_value1) / 2;

							

				$query = "UPDATE $name_temporary_table SET max = '$max_value1', min = '$min_value1', mean = '$mean_value1' WHERE id = '$id1' ";	

				$rs2 = mysqli_query($GLOBALS['conn'],$query);	

				// ---------------------------------------------------------------------------------------------------------



				// Electrophysiology

				$valuesOfEphys=array();

				$index=0;

				$query_to_get_ephys = "SELECT DISTINCT e.value1 

										FROM EvidencePropertyTypeRel eptr, Epdata e, EpdataEvidenceRel eer, Property p

										WHERE e.id=eer.Epdata_id

										AND eer.Evidence_id=eptr.Evidence_id

										AND p.id=eptr.Property_id

										AND p.subject like '$part2'";

				#print($query_to_get_ephys);

				$rs_ephys = mysqli_query($GLOBALS['conn'],$query_to_get_ephys);	

				while(list($ephys) = mysqli_fetch_row($rs_ephys))						

					$valuesOfEphys[$index++] = $ephys;	



				sort($valuesOfEphys);

				$valuesOfEphys=array_unique($valuesOfEphys);

						

				for($ind=0;$ind<count($valuesOfEphys);$ind++){

					$valuesOfEphys[$ind]=$valuesOfEphys[$ind]." ".$unit;

				}					

			}	

			// firing pattern parameter

			if ($property1 == 'Firing Pattern Parameter') {	

				$min=null;

				$max=null;

				$min_value1 = 0;

	            $max_value1 = 0; 

	            $mean_value1= 0;

	            $unit="";

				$index=0;

	            $valuesOf=array();

	            #print("Part1 is:$part1");

				if($part1 and $part1!="-"){

					$index_of_param=getIndexOfParameter($part1);

					//print("indes:$index_of_param");

					if($index_of_param!=-1){

						$digit_precision=getDigitOfParameter($index_of_param);

						$query_to_get_firing_pattern_parameter_value = "SELECT * FROM FiringPattern fp WHERE definition_parameter LIKE 'parameter'";

						$rs_firing_pattern_parameter_value = mysqli_query($GLOBALS['conn'],$query_to_get_firing_pattern_parameter_value);	

						while($firing_pattern = mysqli_fetch_array($rs_firing_pattern_parameter_value,MYSQLI_NUM)){

							if(is_numeric($firing_pattern[$index_of_param]))

								$valuesOf[$index++]=$firing_pattern[$index_of_param];

							if(is_numeric($firing_pattern[$index_of_param]) and $min==null)

								$min=$firing_pattern[$index_of_param];

							elseif(is_numeric($firing_pattern[$index_of_param]) and $min>$firing_pattern[$index_of_param])

								$min=$firing_pattern[$index_of_param];



							if(is_numeric($firing_pattern[$index_of_param]) and $max==null)

								$max=$firing_pattern[$index_of_param];

							elseif(is_numeric($firing_pattern[$index_of_param]) and $max<$firing_pattern[$index_of_param])

								$max=$firing_pattern[$index_of_param];		

						}

						

						$min_value1 = number_format((float)$min,$digit_precision, '.', '');

		            	$max_value1 = number_format((float)$max,$digit_precision, '.', '');

		            	//print("Digit precision:$digit_precision,$min_value1,$max_value1 ");

		            	$mean_value1 = number_format((($min_value1 + $max_value1) / 2),$digit_precision, '.', '');

						$unit =	getUnitOfParameter($index_of_param);

						//print("$unit,$index_of_param");







						//to get individual values

						

						$valuesOfParameter=array();

						$index=0;	

						for($ind=0;$ind<count($valuesOf);$ind++){

							$val=number_format((float)$valuesOf[$ind],$digit_precision, '.', '');

							if(!(in_array($val, $valuesOfParameter))){

								$valuesOfParameter[$index++]=$val;

							}

						}

						sort($valuesOfParameter);	



						for($ind=0;$ind<count($valuesOfParameter);$ind++){

							$valuesOfParameter[$ind]=$valuesOfParameter[$ind]." ".$unit;

						}

					}

					

				}

				//print("$name_temporary_table,$unit,$index_of_param");

				//print("$min_value1,$max_value1");

	            // Mean: 

	            

				$query = "UPDATE $name_temporary_table SET max = '$max_value1', min = '$min_value1', mean = '$mean_value1' WHERE id = '$id1' ";	

				$rs2 = mysqli_query($GLOBALS['conn'],$query);	

			



			}





							

			if ($property1 == 'Morphology')

				$n_value = 33;

			if ($property1 == 'Molecular markers')

				$n_value = 0;

			if ($property1 == 'Electrophysiology')

				$n_value = count($valuesOfEphys);

			if ($property1 == 'Major Neurotransmitter')

				$n_value = 0;

			if ($property1 == 'Connectivity') {

				$type -> retrive_id();

				$n_value = $type->getNumber_type();

			}

			if($property1 == 'Firing Pattern'){

				$n_value = 5;

			}

			if($property1 == 'Firing Pattern Parameter'){

				$n_value = count($valuesOfParameter);

			}

			if($property1 == 'Unique Id'){

				$valuesOfUniqueIds=partUniqueId();

				$n_value = count($valuesOfUniqueIds);

			}

			

																

			print ("<td width='31%' align='center' class='table_neuron_page1'>");

			

			if ($n_value == 0) ;

			else

				print ("<select name='value' size='1' cols='10' class='select1' onChange=\"value1(this, $id1)\">");

			

			if ($value1||$value1==0)

				print ("<OPTION VALUE='$value1'>$value1</OPTION>");

								

	        print ("<OPTION VALUE='-'>-</OPTION>");

        	for ($i=0; $i<$n_value; $i++) {

	            if ($property1 == 'Electrophysiology') // STM hack for correct ephys units

					$value_value = $valuesOfEphys[$i];

				elseif ($property1 == 'Unique Id')

					$value_value = $valuesOfUniqueIds[$i];

	            elseif ($property1 == 'Connectivity')

					$value_value = value_connectivity($i, $type);

				elseif ($property1 == 'Firing Pattern Parameter') {

					//$value_value = value_fp_parameter($i, $property1, $min_value1, $max_value1, $unit,$digit_precision);

					$value_value = $valuesOfParameter[$i];

				}

	            else

					$value_value = value($i, $property1, $min_value1, $max_value1); 

				

				if ($value_value != $value1)

					print ("<OPTION VALUE='$value_value'>$value_value</OPTION>");

			}

				

			print ("</select>");

			print ("</td>");				

			// END Value **************************************************************************************************



			// Operator **************************************************************************************************	

				

			$tt1 = $i0 + 1;

			$i_new = $id_2[$tt1];

			

			$query = "SELECT operator FROM $name_temporary_table WHERE id = '$i_new'";

			$rs = mysqli_query($GLOBALS['conn'],$query);

			

			while(list($operator) = mysqli_fetch_row($rs))						

				$operator1 = $operator;

			

			print ("<td width='8%' align='center' class='table_neuron_page1'>");

			

			print ("<select name='value' size='1' cols='10' class='select1' onChange=\"operator(this, $id1)\">");	

			

			if ($operator1)

				print ("<OPTION VALUE='$operator1'>$operator1</OPTION>");

													

			print ("<OPTION VALUE='-'>-</OPTION>");

			print ("<OPTION VALUE='AND'>AND</OPTION>");

			print ("<OPTION VALUE='OR'>OR</OPTION>");

			print ("</select>");

			print ("</td>");

			

			$operator1 = NULL;		

			// END Operator **************************************************************************************************



			print ("</tr>");

		} // end FOR $i0

		?>

		</table>



	<div align="center">

	<table width="600px" border="0" cellpadding="0" cellspacing="0">

	<tr>

		<td width='100%' align='center' bgcolor="#CCCCCC">

		<?php

			// Search is assembled in a non-editable box for the user's benefit:

			$query = "SELECT N, operator, property, part, relation, value FROM $name_temporary_table";

			$rs = mysqli_query($GLOBALS['conn'],$query);

			$n9=0;

			while(list($N, $operator, $property, $part, $relation, $value) = mysqli_fetch_row($rs))

			{	

				if($property=='Unique Id')

					$part=$property;

				if (($part == '-') || ($part == NULL));

				else

				{

					// Commenting the print statements that is used to display the search string

					// It will be implemented for advanced search

					if ($n9 == 0){

						if ($value == NULL) { // for markers, no value, so no space after relation 

						//	print ("$part: ($relation) ");

							$full_search_string = $part . ": (" . $relation . ")";

						}

						else {

						//	print ("$part: ($relation $value) ");

							$full_search_string = $part . ": (" . $relation . " " . $value . ")";

						}

					}

					else{

						if ($value == NULL) { // for markers, no value, so no space after relation

						//	print ("<br>$operator $part: ($relation) ");

							$full_search_string = $full_search_string . " " . $operator . " " . $part . ": (" . $relation . ")";

						}

						else {

						//	print ("<br>$operator $part: ($relation $value) ");

							$full_search_string = $full_search_string . " " . $operator . " " . $part . ": (" . $relation . " " . $value . ")";

						}

					}					

				}

				$n9 = $n9 + 1;

			}				

		?>

		</td>

	</tr>

	</table>

	<?php

		$_SESSION['full_search_string'] = $full_search_string;

	?>

	</div>	

		<div align="left">

		<table width='100px'>

		<tr>

		<td width='40%'><form action="search.php" method="post" style='display:inline'>	

			<input type='submit' name='clear_all' value='RESET' />

		</form></td>

		<td width='20%'></td>

		<td width='40%'><form action='search_engine.php' method="post">

			<input type="submit" name='go_search' value='  SEE RESULTS  ' />

			<input type="hidden" name='name_table' value='<?php print $name_temporary_table ?>' />

		</form></td>

		</tr>

		</table>

		</div>	

		</td>

		<td width="20%">

		<br /><br />

		<!-- Table for minimun, maximun and mean value for Electrophysiological data -->

		<div align="left">

		<?php

		$query = "SELECT DISTINCT part, max, min, mean,property FROM $name_temporary_table WHERE property = 'Electrophysiology' or property='Firing Pattern Parameter'";

		$rs = mysqli_query($GLOBALS['conn'],$query);

		$m1 = 0;

		while(list($part, $max, $min, $mean,$property_val) = mysqli_fetch_row($rs))

		{

			$part_3[$m1] = $part;

			$max_3[$m1] = $max;

			$min_3[$m1] = $min;

			$mean_3[$m1] = $mean;

			$m1 = $m1 + 1;

			$fp_parameter=$property_val;

		}	

		?>	

		

		<?php

		for ($i6=0; $i6<$m1; $i6++)

		{

			if  ($part_3[$i6] != NULL)

			{

		?> 

				<table border="0" cellpadding="0" cellspacing="0" class='table_search2'>

				<tr>

					<td width='100%' align='center' bgcolor='#6699CC'>

						<?php

							if($fp_parameter=='Electrophysiology'){

								print("<font class='font6'><strong>Electrophysiology :");

								print($part_3[$i6]); 

								print("</strong></font>");

							}

							else{

								print("<font class='font6'><strong>Parameter : ");

								print($part_3[$i6]); 

								print("</strong></font>");

							}



						?>

					</td>

				</tr>	

				<tr>

					<td width='100%' align='center' bgcolor='#6699CC'>

						<font class='font6'>Minimum = <?php print "$min_3[$i6] $unit"; ?></font>

					</td>

				</tr>

				<tr>

					<td width='100%' align='center' bgcolor='#6699CC'>

						<font class='font6'>Median = <?php print "$mean_3[$i6] $unit"; ?></font>

					</td>

				</tr>

				<tr>

					<td width='100%' align='center' bgcolor='#6699CC'>

						<font class='font6'>Maximum = <?php print "$max_3[$i6] $unit"; ?></font>

					</td>

				</tr>		

				</table>

				<br />

		<?php

			}

		}	

		?>	

		</div>	

	

	</td>

  </tr>

</table>

</div>

</body>

</html>


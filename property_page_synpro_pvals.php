<?php
  include ("permission_check.php");

  /* reference: https://stackoverflow.com/questions/37618679/format-number-to-n-significant-digits-in-php
  https://stackoverflow.com/questions/5149129/how-to-strip-trailing-zeros-in-php
  */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
require_once('class/class.type.php');
require_once('class/class.property.php');

function checkNeuronProperty($color)
{
	$part="";
	if ($color == 'red')
		$part = "axons";
	if ($color == 'redSoma')
		$part = "axons_somata";
	if ($color == 'blue')
		$part = "dendrites";
	if ($color == 'blueSoma')
		$part = "dendrites_somata";
	if ($color == 'violet')
		$part = "axons_dendrites";
	if ($color == 'blue')
		$part = "axons_dendrites_somata";
	if ($color == 'somata')
		$part = "somata";	
	return $part;
}

function toPrecision($value, $digits)
{
	/*
		Set precision of digits
	*/
    if ($value == 0) {
        $decimalPlaces = $digits - 1;
    } elseif ($value < 0) {
        $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
    } else {
        $decimalPlaces = $digits - floor(log10($value)) - 1;
    }

    $answer = ($decimalPlaces > 0) ?
        number_format($value, $decimalPlaces) : round($value, $decimalPlaces);
    //$answer = round($value, $decimalPlaces);
    //$answer = $value;

    // remove tailing zeros
    /*preg_match('/(\d+)\.(\d+)/', $answer, $answer_matches);	
    $whole_number = $answer_matches[1];
    $fraction = $answer_matches[2];
	$answer_digits = strlen($fraction);
	if ($answer_digits > $digits) {
		$answer_trimmed_digits = substr($fraction,0,($digits+1));
		$answer = $whole_number.".".$answer_trimmed_digits;
	}*/

    return $answer;
}

function adjPrecision($old_val,$new_val,$digits)
{
	/*
		Make $old_van and $new_val match significant digits
	*/
	$adj_old_val = toPrecision($old_val,$digits);

	preg_match('/(\d+)\.(\d+)/', $adj_old_val, $adj_old_val_matches);
	$old_val_whole = $adj_old_val_matches[1];
	$old_val_fraction = $adj_old_val_matches[2];
	$adj_old_val_digits = strlen($adj_old_val_matches[2]);

	$adj_new_val = toPrecision($new_val,$digits);		

	preg_match('/(\d+)\.(\d+)/', $adj_new_val, $adj_new_val_matches);	
	$new_val_whole = $adj_new_val_matches[1];
	$new_val_fraction = $adj_new_val_matches[2];
	$adj_new_val_digits = strlen($adj_new_val_matches[2]);

	if ($adj_old_val_digits < $adj_new_val_digits) {
		$digits = $digits - 1;
	}
	else if ($adj_old_val_digits > $adj_new_val_digits) {
		$digits = $digits + 1;
	}

	// fix some rounding and trailing zeros
	$adj_new_val2 = round($new_val,$adj_old_val_digits);
	$adj_new_val2 = number_format($adj_new_val2,$adj_old_val_digits);

	return $adj_new_val2;
}

// set properties
$page = $_REQUEST['page'];
$nm_page = $_REQUEST['nm_page'];
$flag = $_REQUEST['flag'];
$id_neuron = $_SESSION['id_neuron'];
$val_property = $_SESSION['val_property'];
//$color = $_SESSION['color'];
$color = $_REQUEST['color'];
$type_source = new type($class_type);
$source_id = $_REQUEST['id_neuron_source'];
$type_source -> retrive_by_id($source_id);
$type_target = new type($class_type);
$target_id = $_REQUEST['id_neuron_target'];
$type_target -> retrive_by_id($target_id);
$property = new property($class_property);
$pre_id=$type_source->getId();
$pre_name=$type_source->getName();
$post_id=$type_target->getId();
$post_name=$type_target->getName();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type_source->getNickname();
	$name2=$type_target->getNickname();
	print("<title>Evidence - $name and $name2</title>");
?>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>

<div class='title_area' style="width:1200px;">
	<?php
	if ($nm_page=='ps') {
		echo '<font class="font1">Number of Potential Synapses - Parcel-Specific Number of Potential Synapses Per Neuron Pair</font>';
	}
	if ($nm_page=='noc') {
		echo '<font class="font1">Number of Contacts - Parcel-Specific Number of Contacts Per Neuron Pair</font>';
	}
	if ($nm_page=='prosyn') {
		echo '<font class="font1">Synapse Probabilities - Parcel-Specific Potential Synapses Per Neuron Pair</font>';
	}
	?>
</div>

<br><br /><br><br />
<table width="85%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr height="40">
    <td></td>
  </tr>
  <tr>
    <td align="center">
		<!-- ****************  BODY **************** -->
		
		<!-- TABLE NAME AND PROPERTY-->
		<table width="80%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="20%" align="right" class="table_neuron_page1">
					Connection Details:
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; 
					<?php 
					print("From: <a href='neuron_page.php?id=$pre_id'>$pre_name</a> To: <a href='neuron_page.php?id=$post_id'>$post_name</a>"); 
					?>
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right"></td>
				<td align="left" width="80%" class="table_neuron_page2">&nbsp; <strong>Hippocampome Presynaptic Neuron ID: </strong> <strong><?php echo $source_id?></strong></td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
				<?php
					$name1 = checkNeuronProperty($color);						
					print ("&nbsp; <strong>Hippocampome Postsynaptic Neuron ID: </strong> <strong>$target_id</strong>");
				?>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					<?php
					$E_or_I_found=false;
					$E_or_I_val=Null;
					echo "&nbsp;&nbsp;Type: <b>";
					$query = "SELECT distinct source_E_or_I FROM number_of_contacts WHERE source_ID=$source_id and target_ID=$target_id;";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					while(list($source_E_or_I) = mysqli_fetch_row($rs))
					{	
						if ($source_E_or_I=='E') {
							echo "Potential Excitatory Connections";
							$E_or_I_found=true;
							$E_or_I_val=2;
						}
						else if ($source_E_or_I=='I') {
							echo "Potential Inhibitory Connections";
							$E_or_I_found=true;
							$E_or_I_val=1;
						}
					}
					if (!$E_or_I_found) {
						echo "N/A";
					}
					echo "</b>";
					?>
				</td>
			</tr>								
		</table>
		
    <table width="80%" border="0" cellspacing="2" cellpadding="5" padding-top="5"> 
<tr>
</tr>
    </table>
		<br style='font-size: 8px;'>
		</center>
	<?php 
	include ('synap_prob/n_m_params.php');
	$cell_width='70px';
	$cell_height='30px';
	$cell_border='2px solid #282d7b';
	$parcel_group_match=null;
	for($as_i=0;$as_i<count($find_parcel_group_id);$as_i++) {
		//if ($target_id==$find_parcel_group_id[$as_i]) {
		if ($source_id==$find_parcel_group_id[$as_i]) {
			$parcel_group_match=$as_i;
		}
	}
	if ($find_parcel_group_name[$parcel_group_match]=='DG') {
			$parcel_group = $dg_group; $parcel_group_short = $dg_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='CA3') {
			$parcel_group = $ca3_group; $parcel_group_short = $ca3_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='CA2') {
			$parcel_group = $ca2_group; $parcel_group_short = $ca2_group_short;}		
	else if ($find_parcel_group_name[$parcel_group_match]=='CA1') {
			$parcel_group = $ca1_group; $parcel_group_short = $ca1_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='SUB') {
			$parcel_group = $sub_group; $parcel_group_short = $sub_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='EC') {
			$parcel_group = $ec_group; $parcel_group_short = $ec_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='MEC') {
			$parcel_group = $mec_group; $parcel_group_short = $ec_group_short;}
	else if ($find_parcel_group_name[$parcel_group_match]=='LEC') {
			$parcel_group = $lec_group; $parcel_group_short = $ec_group_short;}

	function query_value($source_id, $target_id, $parcel, $prop, $table, $nm_page, $totals_col, $totals_table) {
		$value_result = 0;
		$all_value_result = 0;
		$decimal_places='DECIMAL(10,5)';
		if ($nm_page=='noc') {
			$decimal_places='DECIMAL(10,2)';
		}
		preg_match('/(\w+):(\w+):\w+/', $parcel, $parcel_matches);
		$subregion_name = $parcel_matches[1];
		$parcel_name = $parcel_matches[2];
		/*$query = "
		SELECT source_ID, source_Name, target_ID, target_Name, neurite, CAST(AVG(CAST($prop AS ".$decimal_places.")) AS ".$decimal_places.")
		FROM $table
		WHERE source_ID=$source_id AND target_ID=$target_id AND neurite='$parcel'
		AND $prop!=''
		GROUP BY source_ID, source_Name, target_ID, target_Name, neurite
		LIMIT 500000;
		";*/
		$query = "
		SELECT source_ID, target_ID, subregion, parcel, AVG($prop)
		FROM $table
		WHERE source_ID=$source_id AND target_ID=$target_id AND subregion='$subregion_name' AND parcel='$parcel_name'
		LIMIT 500000;
		";
		#echo "<br>$query<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($sid, $tid, $subregion, $parcel_section, $val) = mysqli_fetch_row($rs))
		{	
			//echo $val;
			$value_result = $val;
		}		

		$query = "SELECT $totals_col as val FROM $totals_table as nt, SynproTypeTypeRel as ttr WHERE nt.source_id=$source_id AND nt.target_id=$target_id AND nt.source_id=ttr.type_id";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($val) = mysqli_fetch_row($rs))
		{	
			//echo $val;
			if ($parcel_name == 'All' || $parcel_name == 'ALL' || $parcel_name == 'all') {
				$value_result = $val;
			//echo "<br>$query<br>$val";				
			}
			$all_value_result = $val;
		}	
		$results = array($value_result, $all_value_result);
		//echo "<br>$query<br>";
		//echo "all_value_result:$all_value_result<br>value_result:$value_result<br>";

		return $results;
	}
	function return_stats($source_id, $target_id, $par_grp_conv, $nm_page, $all_value_result) {
		//echo "par_grp_conv: ".$par_grp_conv;
		preg_match('/(.*)_(.*)/', $par_grp_conv, $output_array);
		$subregion = $output_array[1];
		$parcel = $output_array[2];
		//$subregion = explode("_", $par_grp_conv)[0];
		//$parcel = explode("_", $par_grp_conv)[1];
		$stat_results = array();
		$mean_result = 0;
		$std_result = 0;

		if ($nm_page=='ps') {
			if ($parcel == 'All' || $parcel == 'ALL' || $parcel == 'all') {
				$query = "SELECT NPS_mean_total, NPS_stdev_total FROM SynproNPSTotal WHERE source_id=$source_id AND target_id=$target_id;";
			}
			else {
				$query = "SELECT NPS_mean, NPS_std FROM SynproNoPS WHERE source_id = $source_id AND target_id = $target_id AND subregion = '$subregion' AND parcel = '$parcel';";
			}
		}
		if ($nm_page=='noc') {
			if ($parcel == 'All' || $parcel == 'ALL' || $parcel == 'all') {
				$query = "SELECT NC_mean_total, NC_stdev_total FROM SynproNOCTotal WHERE source_id=$source_id AND target_id=$target_id;";
			}
			else {
				$query = "SELECT NC_mean, NC_std FROM SynproNOC WHERE source_id = $source_id AND target_id = $target_id AND subregion = '$subregion' AND parcel = '$parcel';";
			}
		}
		if ($nm_page=='prosyn') {
			if ($parcel == 'All' || $parcel == 'ALL' || $parcel == 'all') {
				$query = "SELECT CP_mean_total, CP_stdev_total FROM SynproCPTotal WHERE source_id=$source_id AND target_id=$target_id;";
			}
			else {
				$query = "SELECT CP_mean, CP_std FROM SynproCP WHERE source_id = $source_id AND target_id = $target_id AND subregion = '$subregion' AND parcel = '$parcel';";
			}
		}
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($mean_db, $std_db) = mysqli_fetch_row($rs))
		{	
			$mean_result = $mean_db;
			$std_result = $std_db;
		}	

		if ($nm_page=='noc') {
			$mean = toPrecision($mean_result, 3); //adjPrecision($all_value_result, $mean_result, 3); 
			$std = toPrecision($std_result, 3);
		}
		else {
			$mean = toPrecision($mean_result, 4); 	
			$std = toPrecision($std_result, 4); 
		}
		//echo $query."<br>".$mean_result."<br>".$std_result;

		array_push($stat_results, $mean);
		array_push($stat_results, $std);
		//cho $query."<br>".$mean."<br>".$std;
		//array_push($stat_results, 0.5);
		//array_push($stat_results, 0.5);

		return $stat_results;
	}

	function report_parcel_values($title, $source_id, $target_id, $prop, $table, $cell_width, $cell_height, $cell_border, $parcel_group, $parcel_group_short,$color,$nm_page,$E_or_I_val,$totals_col,$totals_table) {
	echo "
	<span style='float:middle;font-size:12px;background-color:white;' class='table_neuron_page2'><strong>$title</strong></span>
	<font style='font-size:4px'><br>
	<br></font>";
	echo "<table cellspacing='2' cellpadding='5' padding-top='5' class='table_neuron_page2' style='font-size:12px;bottom:5px;position:relative;background-color:white;'>
	<tr style='text-align:center'>";
	for ($pg_i=0;$pg_i<count($parcel_group_short);$pg_i++) {
		echo "<td style='width:$cell_width;height:$cell_height;'><strong>";
		echo $parcel_group_short[$pg_i]." ";
		echo "</strong></td>";
	}
	echo "</tr><tr style='text-align:center'>";

	for ($pg_i=0;$pg_i<count($parcel_group);$pg_i++) {
		$last_index = count($parcel_group)-1;
		$results = query_value($source_id, $target_id, $parcel_group[$pg_i], $prop, $table, $nm_page, $totals_col, $totals_table);
		$value_result = $results[0];
		$all_value_result = $results[1];
		$par_grp_conv = str_replace(':', '_', $parcel_group[$pg_i]);
		$par_grp_conv = str_replace('_Both', '', $par_grp_conv);

		$stat_results = return_stats($source_id, $target_id, $par_grp_conv, $nm_page, $all_value_result);
		$stat_mean = $stat_results[0];
		$stat_std = $stat_results[1];	
		if (!($stat_std > 0)) {
			$stat_std = "N/A";
		}	

		if ($value_result == 0 && $nm_page!='noc') {
			echo "<td style='width:$cell_width;border:$cell_border;height:$cell_height;'>";
			echo "</td>";			
		}
		else if ($value_result == 0 && $nm_page=='noc') {
			echo "<td style='width:$cell_width;border:$cell_border;height:$cell_height;'>";
			echo $value_result;
			echo "</td>";
		}
		else if ($pg_i != $last_index) {
			// parcel-specific value
			$par_grp_conv_adj = $par_grp_conv;
			// preg replace included to adjust text for evidence page description matching
			$par_grp_conv_adj = preg_replace('/^MEC/', 'EC', $par_grp_conv_adj);
			$par_grp_conv_adj = preg_replace('/^LEC/', 'EC', $par_grp_conv_adj);
			//echo "<br><br><br>".$par_grp_conv_adj;
			echo "<td style='width:$cell_width;border:$cell_border;height:$cell_height;'><a href='property_page_synpro_nm.php?id1_neuron=".$source_id."&val1_property=".$par_grp_conv_adj."&color1=red&id2_neuron=".$target_id."&val2_property=".$par_grp_conv_adj."&color2=blue&connection_type=".$E_or_I_val."&known_conn_flag=1&axonic_basket_flag=0&page=1&nm_page=".$nm_page."' target='_blank' style='text-decoration:none' title='mean: $stat_mean\nstd: $stat_std'>";
			if ($nm_page=='noc') {
				//echo adjPrecision($all_value_result, $value_result, 3);
				echo toPrecision($value_result, 3);
				//echo $value_result;
			}
			else {
				//echo adjPrecision($all_value_result, $value_result, 4);
				echo toPrecision($value_result, 4);
				//echo $value_result;
			}
			echo "</a></td>";
		}
		else {
			// total
			echo "<td style='width:$cell_width;border:$cell_border;height:$cell_height;'>";
			//echo toPrecision($value_result, 4);
			if ($nm_page=='noc') {
				echo "<a href='#' title='mean: $stat_mean\nstd: $stat_std' style='text-decoration:none;color:black'>".toPrecision($value_result, 3)."</a>";
				//echo toPrecision($value_result, 3);
			}
			else {
				echo "<a href='#' title='mean: $stat_mean\nstd: $stat_std' style='text-decoration:none;color:black'>".toPrecision($value_result, 4)."</a>";
				//echo toPrecision($value_result, 4);
			}
			echo "</td>";
		}
	}
	echo "
	</tr>
	</table>";
	}
	if ($nm_page=='ps') {
		//report_parcel_values('Potential Number of Synapses', $source_id, $target_id, 'potential_synapses', 'potential_synapses', $cell_width, $cell_height, $cell_border, $parcel_group, $parcel_group_short,$color,$nm_page,$E_or_I_val);
		report_parcel_values('Potential Number of Synapses', $source_id, $target_id, 'NPS_mean', 'SynproNoPS', $cell_width, $cell_height, $cell_border, $parcel_group, $parcel_group_short,$color,$nm_page,$E_or_I_val,'NPS_mean_total','SynproNPSTotal');
	}
	else if ($nm_page=='noc') {
		report_parcel_values('Number of Contacts', $source_id, $target_id, 'NC_mean', 'SynproNOC', $cell_width, $cell_height, $cell_border, $parcel_group, $parcel_group_short,$color,$nm_page,$E_or_I_val,'NC_mean_total','SynproNOCTotal');
	}
	else if ($nm_page=='prosyn') {
		report_parcel_values('Probability of Connection', $source_id, $target_id, 'CP_mean', 'SynproCP', $cell_width, $cell_height, $cell_border, $parcel_group, $parcel_group_short,$color,$nm_page,$E_or_I_val,'CP_mean_total','SynproCPTotal');
	}
	?>					
</body>
</html>	

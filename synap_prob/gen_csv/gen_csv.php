<html>
<!--
This software is for generating csv files

Author: Nate Sutton 
Date:   2020
-->
<head>
	<title>Synpro CSV File Generation</title>
	<link rel="icon" href="../../images/Hippocampome_logo.ico">
	<style>
	body {
    	background-color: lightgrey;
	}
	.button {
		padding:20px;
		font-size:20px;
		border-radius: 30px;
		border-color: darkgrey;
		border: 2px solid darkgrey;
	}
	</style>
</head>
<body>
<?php
	// import parameters for this software
	include ("gen_csv_params.php");
	include ("gen_csv_utils.php");	

	echo "<br><hr><center><h2><a href='gen_csv.php' style='color:black;text-decoration:none'>CSV Generation Page</a></h2>Note: this page's operations require read and write access to a directory specified<br>in its source code. If that is not availible online this should be run offline to complete its operations.</center><br><hr>";

	echo "<h3><center>Choose CSV file to create:</center></h3>";

	echo "<center><button onclick=\"window.location.href = '?page=nbyk';\" class='button'>N by K</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick=\"window.location.href = '?page=nbyn';\" class='button'>N by N</button></center><br><hr>";

	// write csv file
	$page=$_REQUEST['page'];
	if ($page=='nbyk') {
		// import parameters for this software
		//include ("gen_nbyk_params.php");
		//include ("gen_nbyk_utils.php");

		$csv_output_file = $path_to_files."evi_prop_type_rel_results.csv";
		$output_file = fopen($csv_output_file, 'w') or die("Can't open file.");

		$sql = "SELECT distinct unique_ID, neurite, reference_ID FROM hippodevome.neurite_quantified;";
		$result = $conn->query($sql);
		$id = 0;
		fwrite($output_file, "id,neuron_id,neurite_id,reference_id,frag_id,evi_id\n");
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				//if ($id < 5){
				$neuron_id = $row['unique_ID'];
				$neurite_id = neurite_to_neuriteID($prop_parcel_rel, $row['neurite']);
				$reference_id = $row['reference_ID'];
				$frag_id = refID_to_fragID($fragments, $reference_id);
				$evi_id = fragID_to_eviID($evidence, $frag_id);
				fwrite($output_file, $id.",".$neuron_id.",".$neurite_id.",".$reference_id.",".$frag_id.",".$evi_id."\n");
				//echo $id.", ".$neuron_id.", ".$row['neurite'].", ".$reference_id.", ".$frag_id.", ".$evi_id."<br>";
				//}
				$id++;
			}
		}	

		fclose($output_file);

		echo "<br><center>$csv_output_file<br>file successfully written</center>";
	}	
	else if ($page=='nbyn') {
		$csv_output_file = $path_to_files."evi_source_target_rel_results.csv";
		$output_file = fopen($csv_output_file, 'w') or die("Can't open file.");

		$sql = "SELECT source_id, target_id, refIDs FROM hippodevome.number_of_contacts where refIDs!='';";
		$result = $conn->query($sql);
		$id = 0;
		fwrite($output_file, "id,source_id,target_id,reference_id,frag_id,evi_id\n");
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$refIDs=explode(";", $row['refIDs']);
				foreach ($refIDs as $refID) {
					$source_id=$row['source_id'];
					$target_id=$row['target_id'];
					$refID=str_replace(' ', '', $refID); # remove whitespace
					$frag_id = refID_to_fragID($fragments, $refID);
					$evi_id = fragID_to_eviID($evidence, $frag_id);
					#if ($refID!=''&&$refID!='NooverlapinSP') {
					if ($refID!=''&&$evi_id!='') {
						fwrite($output_file, $id.",".$source_id.",".$target_id.",".$refID.",".$frag_id.",".$evi_id."\n");
						//echo $source_id.",".$target_id.",".$refID.",".$frag_id.",".$evi_id."<br>";
						$id++;
					}
				}
			}
		}	

		fclose($output_file);		

		echo "<br><center>$csv_output_file<br>file successfully written</center>";
	}
?>
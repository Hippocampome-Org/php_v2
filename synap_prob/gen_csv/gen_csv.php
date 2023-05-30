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

	echo "<h3><center>Click to generate csv files:</center></h3>";

	echo "<center><button onclick=\"window.location.href = '?page=allcsvs';\" class='button'>Generate Evidence CSV Files</button></center><br><hr>";

	// write csv file
	$page=$_REQUEST['page'];
	if ($page=='allcsvs') {
		$csv_output_file1 = $path_to_files."evi_pro_type_rel_nbyk.csv";
		$output_file1 = fopen($csv_output_file1, 'w') or die("Can't open file.");
		$csv_output_file2 = $path_to_files."evi_pro_type_rel_nbym.csv";
		$output_file2 = fopen($csv_output_file2, 'w') or die("Can't open file.");

		$sql = "SELECT distinct unique_ID, neurite, reference_ID FROM neurite_quantified;";
		$result = $conn->query($sql);
		fwrite($output_file1, "evidence_ID,neurite_ID,type_ID,original_id,fragment_id,Article_id,priority,conflict_note,unvetted,linking_quote,interpretation_notes,property_type_explanation,pc_flag,soma_pcl_flag,ax_de_pcl_flag,perisomatic_targeting_flag,supplemental_pmids\n");
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$neuron_id = $row['unique_ID'];
				$neurite_id = neurite_to_neuriteID($prop_parcel_rel, $row['neurite']);
				$reference_id = $row['reference_ID'];
				$frag_id = refID_to_fragID($fragments, $reference_id);
				$evi_id = fragID_to_eviID($evidence, $frag_id);
				fwrite($output_file1, "$evi_id,$neurite_id,$neuron_id,$reference_id,$frag_id,0,0,NULL,0,NULL,NULL,NULL,0,0,0,0,NULL\n");
			}
		}

		$sql = "SELECT source_id, target_id, refIDs FROM number_of_contacts where refIDs!='';";
		$result = $conn->query($sql);
		fwrite($output_file2, "evidence_ID,property_ID,source_id,target_id,original_id,fragment_id,Article_id,priority,conflict_note,unvetted,linking_quote,interpretation_notes,property_type_explanation,pc_flag,soma_pcl_flag,ax_de_pcl_flag,perisomatic_targeting_flag,supplemental_pmids\n");
		if ($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
				$refIDs=explode(";", $row['refIDs']);
				foreach ($refIDs as $refID) {
					$source_id=$row['source_id'];
					$target_id=$row['target_id'];
					$refID=str_replace(' ', '', $refID); # remove whitespace
					$frag_id = refID_to_fragID($fragments, $refID);
					$evi_id = fragID_to_eviID($evidence, $frag_id);
					if ($refID!=''&&$evi_id!='') {
						fwrite($output_file2, "$evi_id,NULL,$source_id,$target_id,$refID,$frag_id,0,0,NULL,0,NULL,NULL,NULL,0,0,0,0,NULL\n");
					}
				}
			}
		}	

		fclose($output_file1); fclose($output_file2);

		echo "<br><center>$csv_output_file1<br>and<br>$csv_output_file2<br>files successfully written</center>";
	}
?>
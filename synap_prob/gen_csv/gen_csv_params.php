<?php
	/*
	Parameters for the generate csv program. This is similar to a header file.

	Note: $path_to_files must be an existing and read/write access
	granted directory to read/write files with this software.
	For example on linux, run
	$ chmod -R 777 <directory>
	where <directory> is the $path_to_files folder

	Author: Nate Sutton 
	Date:   2020
	*/

	include ("../../permission_check.php"); // must be logged in

	$path_to_files = "/var/www/html/synapse_probabilities/php/synap_prob/gen_csv/";

	// create $property parcel relation array
	$prop_parcel_rel = array();
	$sql = "SELECT property_id, parcel, property_desc, property_neurite FROM SynProPropParcelRel;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) { 
		while($row = $result->fetch_assoc()) {
			$entry=array($row['property_id'], $row['parcel'], $row['property_desc'], $row['property_neurite']);
			array_push($prop_parcel_rel, $entry);
		}
	}		

	// create reference_id fragment_id array
	$fragments = array();
	$sql = "SELECT * FROM SynproFragment;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) { 
		while($row = $result->fetch_assoc()) {
			$entry=array($row['id'], $row['original_id'], $row['dt'], $row['quote'], $row['page_location'], $row['pmid_isbn'], $row['pmid_isbn_page'], $row['type'], $row['attachment'], $row['attachment_type'], $row['source_id'], $row['target_id'], $row['parameter'], $row['interpretation'], $row['interpretation_notes'], $row['linking_cell_id'], $row['linking_pmid_isbn'], $row['linking_pmid_isbn_page'], $row['linking_quote'], $row['linking_page_location'], $row['species_tag'], $row['species_descriptor'], $row['age_weight'], $row['protocol']);
			array_push($fragments, $entry);
		}
	}	
	//echo "count fragments:<br>";
	//echo (count($fragments));

	// create fragment_id evidence_id array
	$evidence = array();
	$sql = "SELECT Fragment_id, Evidence_id FROM SynproEvidenceFragmentRel;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) { 
		while($row = $result->fetch_assoc()) {
			$entry=array($row['Fragment_id'], $row['Evidence_id']);
			array_push($evidence, $entry);
		}
	}	
?>	
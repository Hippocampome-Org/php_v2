<?php
// output headers so that the file is downloaded rather than displayed
include("access_db.php");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=ISI_Spike_Data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
$fp_id = $_REQUEST['id'];
// output the column headings
fputcsv($output, array('Spike Data'));

// fetch the data
$query_to_get_data="SELECT spike_data FROM SpikeTime WHERE FiringPattern_id=$fp_id";
$rows = mysqli_query($GLOBALS['conn'],$query_to_get_data);
// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows)) 
	fputcsv($output, $row);
?>
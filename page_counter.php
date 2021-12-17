<?php
	/*
		This is a webpage traffic hits counter. 
		
		Install instructions:
		For any site two database tables are needed. One 'hits' table and one 'nodups'
		table. All hit tracking for any page on the site are stored in the tables. 
		Currently there is a database named 'counters' that stores the tables for all
		hippocampome sites' hits. In this file, both tables specific to this site are 
		specified. 

		Also, on the database for the site, e.g., database "hippocampome", there needs
		to be a table with the name "counters_db_id" and a column "database_id" of the
		type int. That column should have one row with the int value that represents
		which of the sites the one being accessed is, for example, for "hippocampome" 
		it is 1, for "hippodevome" it is 2.

		On each page, there needs to be two lines. 
		<?php include ("page_counter.php"); ?>
		<?php $webpage_id_number = 1; include('report_hits.php'); ?>
		
		** The page_counter.php line needs to be directly below the 
		include ("access_db.php") line to receive database access info correctly. **
		$webpage_id_number is the id number for unique tracking of each page on a
		site. The report_hits.php line goes anywhere on the page the hits are wanted 
		to be reported. The way they are displayed can be customized there if wanted.

		Files needed on each site:
		page_counter.php, phpcount.php, report_hits.php

		Reference: https://defuse.ca/php-hit-counter.htm
	*/
	
	$counters_db = 'counters';
	$database_id = 0;
	$sql = "SELECT database_id FROM ".$database.".counters_db_id;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) { 
		$row = $result->fetch_assoc();
		$database_id = $row["database_id"];
	}	
	switch($database_id){
		case 1: 
			$hitstbl = "campome_hits";
			$dupstbl = "campome_nodupes";
		break;
		case 2: 
			$hitstbl = "devome_hits";
			$dupstbl = "devome_nodupes";
		break;
		case 3: 
			$hitstbl = "revome_hits";
			$dupstbl = "revome_nodupes";
		break;
		case 4: 
			$hitstbl = "csv2dbome_hits";
			$dupstbl = "csv2dbome_nodupes";
		break;		
	}
    $_SESSION['servername'] = $servername;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;	
	$_SESSION['hitstbl'] = $hitstbl;
	$_SESSION['dupstbl'] = $dupstbl;	
	$_SESSION['counters_db'] = $counters_db;
	require_once("phpcount.php");
?>
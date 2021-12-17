<?php
	/*
		Variables used to connect to database
	*/
    $cog_servername = "localhost";    
    $cog_username = "nsutton2";
    $cog_password = "N3uraln3ts848";    
    $cog_dbname = "cognome";
    // Create connection
    $cog_conn = new mysqli($cog_servername, $cog_username, $cog_password, $cog_dbname);    
    // Check connection
    if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); }
?>
<?php
	/*
		Variables used to connect to database
        Add in variable values and save this as mysql_connect.php
	*/
    $cog_servername = "";    
    $cog_username = "";
    $cog_password = "";    
    $cog_dbname = "";
    // Create connection
    $cog_conn = new mysqli($cog_servername, $cog_username, $cog_password, $cog_dbname);    
    // Check connection
    if ($cog_conn->connect_error) { die("Connection failed: " . $cog_conn->connect_error); }
?>
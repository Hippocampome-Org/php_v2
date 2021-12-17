<?php
// Remove temporary table for the research:
function remove_table_by_tyme()  // after 2 hours:
{
	//global $conn,$DB_NAME;
	$time_rem = 7200;   // 7200 -> 2 ore

	$time_1 = time();
	$query = "SHOW TABLES";// from {$GLOBALS['DB_NAME']} ";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
	$n_table = 0;
	while ($row = mysqli_fetch_assoc($rs2))
	{
		if  ((strpos($row[0], 'search') == 'TRUE') || (strpos($row[0], 'temp') == 'TRUE') )
		{
			$table[$n_table] = $row[0];
			$n_table = $n_table + 1;  
  		}
	}		

	for ($i=0; $i<$n_table; $i++)
	{		
		// for search table:
		if (strpos($table[$i], 'search1_') == 'TRUE')
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', $new_name);
			
			$delta_t = $time_1 - $new_name; 
						
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}

		// for result table:
		if (strpos($table[$i], 'search_result_table_') == 'TRUE')
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', $new_name);
			
			$delta_t = $time_1 - $new_name; 
			
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}

		// for temp table (page evidence):
		if (strpos($table[$i], 'temp_') == 'TRUE')
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', $new_name);
			
			$delta_t = $time_1 - $new_name; 
			
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}
		
	}
}

?>

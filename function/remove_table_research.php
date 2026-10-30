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
	//Changed from here on Nov 2 2023 by @KN as we need to handle it dynamically as it will change based on database
        while ($row = ($rs2 ? mysqli_fetch_assoc($rs2) : null)) {
                foreach($row as $rowkey => $rowvalue) {
                        if  ((strpos($rowvalue, 'search') === 0) || (strpos($rowvalue, 'temp') === 0) )
                        {
                                $table[$n_table] = $rowvalue;
                                $n_table = $n_table + 1;
                        }
                }
        }

	for ($i=0; $i<$n_table; $i++)
	{		
		/*
		//Commented by KN on Oct 29 2026
		// for search table:
		if (strpos($table[$i], 'search1_') === 0)
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));
			
			$delta_t = $time_1 - $new_name; 
						
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE IF EXISTS $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}

		// for result table:
		if (strpos($table[$i], 'search_result_table_') === 0)
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));
			
			$delta_t = $time_1 - $new_name; 
			
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE IF EXISTS $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}

		// for temp table (page evidence):
		if (strpos($table[$i], 'temp_') === 0)
		{
			$new_name = strstr($table[$i], '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));
			
			$delta_t = $time_1 - $new_name; 
			
			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table ="DROP TABLE IF EXISTS $table[$i]";
				$query = mysqli_query($GLOBALS['conn'],$drop_table);	
			}
		}
		// Till Here
		*/
		$tableName = $table[$i] ?? '';

		// for search table:
		if (strpos($tableName, 'search1_') !== false)
		{
			$new_name = strstr($tableName, '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));

			$delta_t = $time_1 - $new_name;

			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table = "DROP TABLE IF EXISTS $tableName";
				mysqli_query($GLOBALS['conn'], $drop_table);
			}
		}

		// for result table:
		if (strpos($tableName, 'search_result_table_') !== false)
		{
			$new_name = strstr($tableName, '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));

			$delta_t = $time_1 - $new_name;

			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table = "DROP TABLE IF EXISTS $tableName";
				mysqli_query($GLOBALS['conn'], $drop_table);
			}
		}

		// for temp table (page evidence):
		if (strpos($tableName, 'temp_') !== false)
		{
			$new_name = strstr($tableName, '__');
			$new_name = str_replace('__', '', ($new_name ?? ''));

			$delta_t = $time_1 - $new_name;

			if ($delta_t > $time_rem)  // 36000
			{
				$drop_table = "DROP TABLE IF EXISTS $tableName";
				mysqli_query($GLOBALS['conn'], $drop_table);
			}
		}
	}
}

?>

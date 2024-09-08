<?php
include ('functions.php');

function format_table($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $views_request = NULL, $query2 = NULL) {
    $count = 0;
    $csv_rows = [];
    if (isset($write_file)) {
	    if($views_request == 'views_per_month' || $views_request == 'views_per_year'){

		    if (mysqli_multi_query($conn, $query)) {
			    $header = []; // Initialize an array to store column names
			    do {
				    if ($result = mysqli_store_result($conn)) {
					    if (empty($header)) {
						    $header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
						    $rows = count($header);
						    $csv_headers = camel_replace($header);
						    mysqli_data_seek($result, 0);
					    }
					    while ($rowvalue = mysqli_fetch_assoc($result)) {
						    foreach ($rowvalue as $key => $value) {
							    if ($value == 0) {
								    $rowvalue[$key] = ''; // Replace 0 with an empty string
							    } else {
								    // Add to the count if the value is numeric and not zero
								    if (is_numeric($value)) {
									if($key == 'Total_Views'){
									    $count += $value;
									}
								    }
							    }
						    }
						    if (!is_null($rowvalue['Total_Views']) && $rowvalue['Total_Views'] > 0) {
							    $csv_rows[] = $rowvalue;
						    }
					    }
					    mysqli_free_result($result);
				    }
			    } while (mysqli_next_result($conn));
			    $spaces = $rows - 2;
			    $totalRow = array_pad([], $spaces, '');
			    $totalRow[] = $count;
			    // Add "Total Count" at the beginning of the array
			    array_unshift($totalRow, "Total Count");

			    $csv_rows[] = $totalRow;

			    // Store information about the CSV file in `$csv_data` array
			    $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
			    return $csv_data[$csv_tablename];
		    } else {
			    // Handle error if query execution fails
			    echo "Error: " . mysqli_error($conn);
		    }
	    }
    }
    $table_string1 = '';
	$count=0;
    $array_subs = [];

    $rs = mysqli_query($conn, $query);
    $rows = count($csv_headers);
    $table_id = 'myTable'; // Specify your table ID here

    // Add CSS to the table string for the specific table ID
    $css_styles = "
    <style>
        #$table_id {
            width: 100%;
            table-layout: fixed; /* Ensures columns have fixed widths */
        }     
        #$table_id td, #$table_id th {
            overflow-wrap: break-word; /* Break long words */
            word-break: break-word; /* Additional word breaking */
            white-space: normal; /* Allow wrapping */
        }
	/* Targeting specific column for width */
        #$table_id td:nth-child(2), #$table_id th:nth-child(2) {
            width: 10%; /* Adjust this width as needed */
        }
    </style>";

    $table_string .= "<html><head>$css_styles</head><body>";
    $table_string .= "<table id='$table_id'>"; // Set table ID here
    $table_string .= "<thead><tr>";
    
    foreach ($csv_headers as $header) {
        $table_string .= "<th>" . htmlspecialchars($header) . "</th>";
    }
    
    $table_string .= "</tr></thead><tbody>";

    if (!$rs || ($rs->num_rows < 1)) {
        $table_string1 .= "<tr><td colspan='$rows'>No Data is available</td></tr>";
        $table_string .= $table_string1;
        $table_string .= "</tbody></table></body></html>";
        return $table_string;
    }

    if (isset($query2)) {
        $rs2 = mysqli_query($conn, $query2);
        if (!$rs2 || ($rs2->num_rows < 1)) {
            $table_string1 .= "<tr><td colspan='$rows'>No Data is available</td></tr>";
            $table_string .= $table_string1;
            $table_string .= "</tbody></table></body></html>";
            return $table_string;
        }
    }

    // Process the main query results
    $i = 0;
    while ($row = mysqli_fetch_row($rs)) {
        $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
        $table_string1 .= "<tr class='$bgColor'>";
	if($csv_tablename == 'monthly_page_views' && $i==0){
		$csv_rows[] = ["Pre-Aug-2019",470480];
		$table_string1 .= "<td>Pre-Aug-2019</td><td>470480</td>";	
		$count += 470480;
	}else{
		$csv_rows[] = $row;
		for ($j = 0; $j < $rows; $j++) {
			if (isset($neuron_ids[$row[$j]])) { 
				$row[$j] = $neuron_ids[$row[$j]]; 
			}
			if ($row[$rows-1] > 0) {
				$table_string1 .= "<td>" . htmlspecialchars($row[$j]) . "</td>";
			}
		}

		$count += $row[$rows-1];
	}
	$table_string1 .= "</tr>";
	$i++;
    }

    // Process the additional query results if provided
    if (isset($query2)) {
        while ($row = mysqli_fetch_row($rs2)) {
            $csv_rows[] = $row;
            $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
            $table_string1 .= "<tr class='$bgColor'>";

            for ($j = 0; $j < $rows; $j++) {
                if (isset($neuron_ids[$row[$j]])) { 
                    $row[$j] = $neuron_ids[$row[$j]]; 
                }
                if ($row[$rows-1] > 0) {
                    $table_string1 .= "<td>" . htmlspecialchars($row[$j]) . "</td>";
                }
            }

            $count += $row[$rows-1];
            $table_string1 .= "</tr>";
            $i++;
        }
    }

    if (isset($write_file)) {
	//pre-Aug-2019” with 470,480 views
        //$totalRow = ($csv_tablename == 'pmid_isbn_table') ? ["Total Count", '', '', '', '', $count] : ["Total Count", $count];
        $totalRow = ["Total Count", $count];
        $csv_rows[] = $totalRow;
	$csv_data[$csv_tablename] = ['filename' => toCamelCase($csv_tablename), 'headers' => $csv_headers, 'rows' => $csv_rows];
        return $csv_data[$csv_tablename];
    } else {
        $table_string1 .= "<tr><td colspan='" . ($rows - 1) . "'><b>Total Count</b></td><td>" . $count . "</td></tr>";    
        $table_string .= $table_string1;
        $table_string .= "</tbody></table></body></html>";
        return $table_string;
    }
}

function format_table_combined($conn, $query, $csv_tablename, $csv_headers, $write_file = NULL, $options = [], $views_request = NULL) {
    $count = 0;
    $csv_rows = [];
    if (isset($write_file)) {
            if($views_request == 'views_per_month' || $views_request == 'views_per_year'){

                    if (mysqli_multi_query($conn, $query)) {
                            $header = []; // Initialize an array to store column names
                            do {
                                    if ($result = mysqli_store_result($conn)) {
                                            if (empty($header)) {
                                                    $header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
                                                    $rows = count($header);
                                                    $csv_headers = camel_replace($header);
                                                    mysqli_data_seek($result, 0);
                                            }
                                            while ($rowvalue = mysqli_fetch_assoc($result)) {
                                                    foreach ($rowvalue as $key => $value) {
                                                            if ($value == 0) {
                                                                    $rowvalue[$key] = ''; // Replace 0 with an empty string
                                                            } else {
                                                                    // Add to the count if the value is numeric and not zero
                                                                    if (is_numeric($value)) {
                                                                        if($key == 'Total_Views'){
                                                                            $count += $value;
                                                                        }
                                                                    }
                                                            }
                                                    }
                                                    if (!is_null($rowvalue['Total_Views']) && $rowvalue['Total_Views'] > 0) {
                                                            $csv_rows[] = $rowvalue;
                                                    }
                                            }
                                            mysqli_free_result($result);
                                    }
                            } while (mysqli_next_result($conn));
                            $spaces = $rows - 2;
                            $totalRow = array_pad([], $spaces, '');
                            $totalRow[] = $count;
                            // Add "Total Count" at the beginning of the array
                            array_unshift($totalRow, "Total Count");

                            $csv_rows[] = $totalRow;

                            // Store information about the CSV file in `$csv_data` array
                            $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
                            return $csv_data[$csv_tablename];
                    } else {
                            // Handle error if query execution fails
                            echo "Error: " . mysqli_error($conn);
                    }
            }
    }
    $count = 0;
    $rs = mysqli_query($conn, $query);
    $table_string = '';
    $rows = count($csv_headers);
    if (!$rs || mysqli_num_rows($rs) < 1) {
        return "<tr><td colspan='{$rows}'> No Data is available </td></tr>";
    }

    $i = 0;
    while($row = mysqli_fetch_row($rs)){
	$csv_rows[] = $row;
        // Check for row exclusion based on 'exclude' option
        if (isset($options['exclude']) && in_array($row[0], $options['exclude'])) {
            continue;
        }

        // Apply transformations based on 'format' option
        if (isset($options['format']) && array_key_exists($row[0], $options['format'])) {
            $row[0] = $options['format'][$row[0]];
        }

        // Coloring rows alternately
        $bgColor = $i % 2 == 0 ? 'white-bg' : 'blue-bg';
        $table_string .= "<tr class='$bgColor'>";

        for ($j = 0; $j < $rows; $j++) {
            // Special handling for 'fp' to 'firing pattern'
            if ($row[$j] === 'fp') {
                $row[$j] = 'firing pattern';
            }
	    
	    // Apply inline style for the second column (index 1)
	    $style = $j == 1 ? 'style="width: 10%;"' : '';

	    // Only add data cells if the last column value is > 0
	    if ($row[$rows - 1] > 0) {
		    $table_string .= "<td $style>" . htmlspecialchars($row[$j]) . "</td>";
            }
        }

        $count += $row[$rows - 1];
        $table_string .= "</tr>";
        $i++;
    }

    if(isset($write_file)){
	    $totalRow = ["Total Count",$count]; 
	    $csv_rows[] = $totalRow;
	    $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
	    return $csv_data[$csv_tablename];
    } else{
	    $table_string .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";	
	    return $table_string;
    }
}

function format_table_neurons($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids = NULL, $write_file = NULL, $views_request = NULL) {
	$count = 0;
	$array_subs = []; 
	$csv_rows = [];
	if (isset($write_file)) {
		if (mysqli_multi_query($conn, $query)) {
			$header = []; // Initialize an array to store column names
			do {
				if ($result = mysqli_store_result($conn)) {
					if (empty($header)) {
						$header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
						$rows = count($header);
						$csv_headers = camel_replace($header);
						mysqli_data_seek($result, 0);
					}
					while ($rowvalue = mysqli_fetch_assoc($result)) {
						foreach ($rowvalue as $key => $value) {
							if($key == 'Subregion' || $key == 'Neuron_Type_Name'){
								continue;
							}
							if ($value == 0) {
								$rowvalue[$key] = ''; // Replace 0 with an empty string
							} else {
								// Add to the count if the value is numeric and not zero
								if (is_numeric($value)) {
									if($key == 'Total_Views'){
									$count += $value;
									}
								}
							}
						}
						$csv_rows[] = $rowvalue;
					}
					mysqli_free_result($result);
				}
			} while (mysqli_next_result($conn));
			$numHeaders = count($header); // Get the number of headers
			$totalCountRow = array_merge(["Total Count"], array_fill(0, $numHeaders - 2, ''), [$count]);
			$csv_rows[] = $totalCountRow;

			// Store information about the CSV file in `$csv_data` array
			$csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
			return $csv_data[$csv_tablename];
		} else {
			// Handle error if query execution fails
			echo "Error: " . mysqli_error($conn);
		}
	}
	$table_string1 = '';
	if (!$array_subs) {
		$array_subs = [];
	}

    $header = []; // Initialize an array to store column names
    $array_subs = []; // Initialize array to store CSV rows
    $count = 0; // Initialize count for total views
    $table_string1 = '';
    
    if (mysqli_multi_query($conn, $query)) {
	    do {
		    if ($result = mysqli_store_result($conn)) {
			    if (empty($header)) {
				    $header = array_keys(mysqli_fetch_array($result, MYSQLI_ASSOC));
				    $rows = count($header);
				    $csv_headers = camel_replace($header);
				    mysqli_data_seek($result, 0);
				    $table_string1 = get_table_skeleton_first($csv_headers);
			    }
			    while ($rowvalue = mysqli_fetch_assoc($result)) {
				    $count += $rowvalue['Total_Views'];
				    $value = $rowvalue['Neuron_Type_Name'];
				    //if ($col === 'Neuron_Type_Name' && isset($neuron_ids[$value])) {
				    if (isset($neuron_ids[$value])) {
					    if (!isset($write_file)) {
						    $rowvalue['Neuron_Type_Name'] = get_link($value, $neuron_ids[$value], './neuron_page.php', 'neuron');
					    }
				    }
				    if (!isset($array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']])) {
					    $array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']] = [];
				    }
				    foreach($rowvalue as $col=>$value){
					if(($col == 'Neuron_Type_Name') || ($col == 'Subregion')){
						continue;
					}
					    array_push($array_subs[$rowvalue['Subregion']][$rowvalue['Neuron_Type_Name']], $value);
				    }
			    }
			    mysqli_free_result($result);
		    }
	    } while (mysqli_next_result($conn));
	    $i=0;
	    $j=0;
	    foreach ($array_subs as $groupKey => $subgroups) {
		    $groupBgClass = ($i % 2 == 0) ? 'lightgreen-bg' : 'green-bg';
		    $table_string1 .= "<tr><td class='$groupBgClass' rowspan='" . count($subgroups) . "'>$groupKey</td>";
		    foreach ($subgroups as $subgroupKey => $colors) {
			    $subgroupBgClass = ($j % 2 == 0) ? 'white-bg' : 'blue-bg';
			    $table_string1 .= "<td class='$subgroupBgClass' rowspan=''>$subgroupKey</td>";
				    $colorBgClass = ($j % 2 == 0) ? 'white-bg' : 'blue-bg';
			    foreach ($colors as $color) {
				    if($color <=0 ){
					$color='';
				    }
				    $table_string1 .= "<td class='$colorBgClass'>$color</td>";
			    }
				    $j++;
				    $table_string1 .= "</tr>";
		    }
		    $i++;
	    }
            // Append total count row
            $table_string1 .= "<tr><td colspan='" . ($rows - 1) . "'><b>Total Count</b></td><td>$count</td></tr>";
            return $table_string1;
    }
}

?>

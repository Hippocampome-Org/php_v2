<?php

function get_page_views($conn){ //Passed on Dec 3 2023
	$page_views_query = "select day_index, views 
		from ga_analytics_pages_views where views > 0 
		GROUP BY YEAR(day_index), MONTH(day_index)";

	$rs = mysqli_query($conn,$page_views_query);
	$result_page_views_array = array();
	while($row = mysqli_fetch_row($rs))
	{
		array_push($result_page_views_array, $row);
	}
	return $result_page_views_array;

}

function format_table($conn, $query, $table_string, $rows){

        $rs = mysqli_query($conn,$query);
	if(!$rs){
		$table_string .= "<tr style='border: 1px solid black;'><td> No Data is available </td></tr>";
	}

	$i=0;
        while($row = mysqli_fetch_row($rs))
        {       
		$j=0;
		if($i%2==0){ $table_string .= '<tr bgcolor="#fff">';}
		else{ $table_string .= '<tr bgcolor="#98AFC7">';}//Color gradient CSS

		while($j < $rows){
			$table_string .= "<td style='border: 1px solid black;'>".$row[$j]."</td>";
			$j++;
		}
		$table_string .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	echo $table_string;
}

function get_pages_views_report($conn){ //Passed $conn on Dec 3 2023
	//include ("../access_db.php");//Commented on Dec 3 2023
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Month-Year</th><th style='border: 1px solid black;'>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	
	$page_views_query = "select concat(DATE_FORMAT(day_index,'%b'), '-', YEAR(day_index)) as dm, views 
			     from ga_analytics_pages_views where views > 0 
			     GROUP BY YEAR(day_index), MONTH(day_index)";

	$table_string .= format_table($conn, $page_views_query, $table_string, 2);
	$table_string .= "</tbody></table>";
	
	return $table_string;
}

function get_neurons_views_report($conn){ //Passed on Dec 3 2023
	//include ("../access_db.php");//Commented on Dec 3 2023
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Page</th>";
	$table_string .= "<th style='border: 1px solid black;'>Views</th>";
	$table_string .= "<th style='border: 1px solid black;'>neuronID</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	$page_neurons_views_query = "SELECT page, count(*) as count, substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID
			     	FROM ga_analytics_pages 
			     	WHERE page LIKE '%id_neuron=%' 
				GROUP BY substring_index(substring_index(page, 'id_neuron=', -1),'&', 1)";

	$table_string .= format_table($conn, $page_neurons_views_query, $table_string, 3);
	$table_string .= "</tbody></table>";
	
	return $table_string;
}

function get_subregion_views_report($conn){ //Passed on Dec 3 2023
	//include ("../access_db.php");//Commented on Dec 3 2023
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Page</th>";
	$table_string .= "<th style='border: 1px solid black;'>Views</th>";
	$table_string .= "<th style='border: 1px solid black;'>Subregion</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	$page_subregion_views_query = "SELECT page, count(*) as count, substring_index(substring_index(page, '&val_property=', -1), '&', 1) as subregion
			     	FROM ga_analytics_pages 
			     	WHERE page LIKE '%id_neuron=%' 
				GROUP BY substring_index(substring_index(page, '&val_property=', -1),'&', 1)";

	$table_string .= format_table($conn, $page_subregion_views_query, $table_string, 3);
	$table_string .= "</tbody></table>";
	
	return $table_string;
}

?>

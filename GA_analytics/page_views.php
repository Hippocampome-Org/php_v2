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
	$table_string1 = '';
	if(!$rs){
		$table_string1 .= "<tr style='border: 1px solid black;'><td> No Data is available </td></tr>";
	}
	$i=0;
	while($row = mysqli_fetch_row($rs))
	{       
		$j=0;
		if($i%2==0){ $table_string .= '<tr bgcolor="#fff">';}
		else{ $table_string1 .= '<tr bgcolor="#98AFC7">';}//Color gradient CSS

		while($j < $rows){
			$table_string1 .= "<td style='border: 1px solid black;'>".$row[$j]."</td>";
			$j++;
		}
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	return $table_string1;
}

function format_table_sub($conn, $query, $table_string, $rows){

        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	if(!$rs){
		$table_string1 .= "<tr style='border: 1px solid black;'><td> No Data is available </td></tr>";
	}
	$dg = $ca3 = $ca2 = $ca1 = $sub = $ec = 0;
	$array_subs = ["DG"=>0, "CA3"=>0, "CA2"=>0,"CA1"=>0,"Subiculum"=>0,"Entorhinal Cortex"=>0];
	while($row = mysqli_fetch_row($rs))
	{
		if($row[0] >= 1000 && $row[0] < 2000){
			$dg = $dg + $row[1];
		}
		else  if($row[0] >= 2000 && $row[0] < 3000){
			$ca3 = $ca3 + $row[1];
		}
		else  if($row[0] >= 3000 && $row[0] < 4000){
			$ca2 = $ca2 + $row[1];
		}
		else  if($row[0]  >= 4000 && $row[0] < 5000){
			$ca1 = $ca1 + $row[1];
		}
		else  if($row[0] >= 5000 && $row[0] < 6000){
			$sub = $sub + $row[1];
		}
		else  if($row[0] >= 6000 && $row[0] < 7000){
			$ec = $ec + $row[1];
		}
	}
	$array_subs["DG"]=$dg;
	$array_subs["CA3"]=$ca3;
	$array_subs["CA2"]=$ca2;
	$array_subs["CA1"]=$ca1;
	$array_subs["Subiculum"]=$sub;
	$array_subs["Entorhinal Cortex"]=$ec;
	$i=0;
	foreach($array_subs as $key => $value){
		if($i%2==0){ $table_string .= '<tr bgcolor="#fff">';}
		else{ $table_string1 .= '<tr bgcolor="#98AFC7">';}//Color gradient CSS

		$table_string1 .= "<td style='border: 1px solid black;'>".$key."</td>";
		$table_string1 .= "<td style='border: 1px solid black;'>".$value."</td>";
		$table_string1 .= "</tr>";
		$i++;
	}
	
	return $table_string1;
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
	
	echo $table_string;
}

function get_neurons_views_report($conn){ //Passed on Dec 3 2023
	//include ("../access_db.php");//Commented on Dec 3 2023
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Neuron ID</th>";
	$table_string .= "<th style='border: 1px solid black;'>Neuron Name</th>";
	$table_string .= "<th style='border: 1px solid black;'>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	$page_neurons_views_query = " SELECT substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID,
                                    (select name from Type where id = substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) ) as neuron_name,
                                count(*) as count
                                FROM ga_analytics_pages
                                WHERE page LIKE '%id_neuron=%' and page LIKE '%/php/%' 
                                and substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) not in (4181, 2232, 23223 )
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) >2
                                GROUP BY substring_index(substring_index(page, 'id_neuron=', -1),'&', 1)"; //exclude '4181', '2232', '23223')

	$table_string .= format_table($conn, $page_neurons_views_query, $table_string, 3);
	$table_string .= "</tbody></table>";
	
	echo $table_string;
}

function get_morphology_property_views_report($conn){
	$table_string = "<table style='border: 1px solid black;'>";
        $table_string .= "<tr>";
	//<th style='border: 1px solid black;'>Morphology</th>"; //Commented on Dec 8 2023
        //$table_string .= "<th style='border: 1px solid black;'>Color</th>"; //Commented on Dec 8 2023
        $table_string .= "<th style='border: 1px solid black;'>Neuron ID</th>";
        $table_string .= "<th style='border: 1px solid black;'>Neuron Name</th>";
        $table_string .= "<th style='border: 1px solid black;'>Views</th></tr>";
        $table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
        $page_property_views_query = " SELECT 
				-- substring_index(substring_index(page, 'val_property=', -1), '&', 1) as morphology, -- Commented on Dec 8 2023
                                -- substring_index(substring_index(page, 'color=', -1), '&', 1) as color, -- commented on Dec 8 2023
                                 substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID, 
				(select name from Type where id = substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) ) as neuron_name, 
				count(*) 
                                FROM ga_analytics_pages
                                WHERE page LIKE '%morphology.php?id_neuron=%' and page LIKE '%/php/%' 
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) >2 
				AND length(substring_index(substring_index(page, 'val_property=', -1), '&', 1)) > 2 
				AND length(substring_index(substring_index(page, 'color=', -1), '&', 1)) > 2 
                                GROUP BY substring_index(substring_index(page, 'morphology.php', -1),'&', 1)";

        //$table_string .= format_table($conn, $page_property_views_query, $table_string, 5);//Commented on Dec 8 2023 as we are getting only 3 columns from db
        $table_string .= format_table($conn, $page_property_views_query, $table_string, 3);
        $table_string .= "</tbody></table>";

        echo $table_string;
}

function get_markers_property_views_report($conn){
	$table_string = "<table style='border: 1px solid black;'>";
        $table_string .= "<tr>";
	//<th style='border: 1px solid black;'>Markers</th>"; //Commented on Dec 8 2023
        //$table_string .= "<th style='border: 1px solid black;'>Color</th>"; //Commented on Dec 8 2023
        $table_string .= "<th style='border: 1px solid black;'>Neuron ID</th>";
        $table_string .= "<th style='border: 1px solid black;'>Neuron Name</th>";
        $table_string .= "<th style='border: 1px solid black;'>Views</th></tr>";
        $table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
        $page_property_views_query = " SELECT 
				-- substring_index(substring_index(page, 'val_property=', -1), '&', 1) as morphology, -- Commented on Dec 8 2023
                                -- substring_index(substring_index(page, 'color=', -1), '&', 1) as color, -- Commented on Dec 8 2023
                                 substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID, 
				(select name from Type where id = substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) ) as neuron_name, 
				count(*) 
                                FROM ga_analytics_pages
                                WHERE page LIKE '%markers.php?id_neuron=%' and page LIKE '%/php/%'  
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) >2 
				AND length(substring_index(substring_index(page, 'val_property=', -1), '&', 1)) > 2 
				AND length(substring_index(substring_index(page, 'color=', -1), '&', 1)) > 2 
                                GROUP BY substring_index(substring_index(page, 'markers.php', -1),'&', 1)";

        //$table_string .= format_table($conn, $page_property_views_query, $table_string, 5); //Commted on Dec 8 2023 as we have 3 cols only
        $table_string .= format_table($conn, $page_property_views_query, $table_string, 3);
        $table_string .= "</tbody></table>";

        echo $table_string;
}


function get_subregion_views_report($conn){ //Passed on Dec 3 2023
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Subregion</th><th style='border: 1px solid black;'>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	$page_subregion_views_query = "SELECT 
                                substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID, 
				count(*) as views 
                                FROM ga_analytics_pages
                                WHERE page LIKE '%id_neuron=%' and page LIKE '%/php/%'  
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) >2 
                                GROUP BY substring_index(substring_index(page, 'id_neuron=', -1),'&', 1)";
	$table_string .= format_table_sub($conn, $page_subregion_views_query, $table_string, 2);
	$table_string .= "</tbody></table>";
	
	echo $table_string;
}

function get_functionality_views_report($conn){
	$table_string = "<table style='border: 1px solid black;'>";
	$table_string .= "<tr><th style='border: 1px solid black;'>Property</th><th style='border: 1px solid black;'>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	$page_subregion_views_query = "  select substring_index(substring_index(page, '/php/property_page_', -1),'.', 1), count(*)
                                FROM ga_analytics_pages where page like '%/php/property%' 
				AND substring_index(substring_index(page, '/php/property_page_', -1),'.', 1) 
                                NOT IN ('synpro_nm_old2', 'connectivity_test', 'connectivity_orig') 
                                GROUP BY substring_index(substring_index(page, '/php/property', -1),'?', 1)";
                                
	// -- exclude _page_synpro_nm_old2.php, _page_connectivity_test.php, _page_connectivity_orig.php"

	$table_string .= format_table($conn, $page_subregion_views_query, $table_string, 2);
	$table_string .= "</tbody></table>";
	
	echo $table_string;
}

?>

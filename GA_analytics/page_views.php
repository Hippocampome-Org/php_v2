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
	if(!$rs || ($rs->num_rows < 1)){
		$table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
	}
	$i=0;
	while($row = mysqli_fetch_row($rs))
	{       
		$j=0;
		if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

		while($j < $rows){
			$table_string1 .= "<td>".$row[$j]."</td>";
			$j++;
		}
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	return $table_string1;
}

function format_table_markers($conn, $query, $table_string, $rows, $array_subs = NULL){

        $rs = mysqli_query($conn,$query);
        $table_string1 = '';
	if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
        }
        $i=0;
	if(!$array_subs){ $array_subs = [];}
        while($row = mysqli_fetch_row($rs))
        {
		if($array_subs[$row[0]]){
			if($array_subs[$row[0]][$row[1]]){
				$array_subs[$row[0]][$row[1]] += $row[2];
			}else{
				$array_subs[$row[0]][$row[1]] = $row[2];
			}
		}else{
			$array_subs[$row[0]][$row[1]] = $row[2];
		}
        }
	$i=$j=0;
        foreach($array_subs as $key => $value){
		$table_string1 .= "<tr>";    
		if($j%2==0){
       			$table_string1 .= "<td class='lightgreen-bg' rowspan='".count($value)."'>".$key."</td>";
		}else{
       			$table_string1 .= "<td class='green-bg' rowspan='".count($value)."'>".$key."</td>";
		}
		foreach($value as $key1 => $value1){
			if($i%2==0){
				$table_string1 .= "<td class='white-bg' >".$key1."</td>";
				$table_string1 .= "<td class='white-bg' >".$value1."</td>";
			}
			else{ 
				$table_string1 .= "<td class='blue-bg' >".$key1."</td>";
                                $table_string1 .= "<td class='blue-bg' >".$value1."</td>";
			}//Color gradient CSS

			$table_string1 .= "</tr>";
			$i++;
		}
		$j++;
        }

        return $table_string1;
}

function format_table_sub($conn, $query, $table_string, $rows){

        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	if(!$rs || ($rs->num_rows < 1)){
		$table_string1 .= "<tr ><td> No Data is available </td></tr>";
		return $table_string1;
	}
	$dg = $ca3 = $ca2 = $ca1 = $sub = $ec = 0;
	$array_subs = ["DG"=>0, "CA3"=>0, "CA2"=>0,"CA1"=>0,"Subiculum"=>0,"Entorhinal Cortex"=>0];
	while($row = mysqli_fetch_row($rs))
	{
		if($row[0] >= 1000 && $row[0] < 2000){		$array_subs["DG"] += $row[1];			}
		else  if($row[0] >= 2000 && $row[0] < 3000){	$array_subs["CA3"] += $row[1];			}
		else  if($row[0] >= 3000 && $row[0] < 4000){	$array_subs["CA2"] += $row[1];			}
		else  if($row[0]  >= 4000 && $row[0] < 5000){	$array_subs["CA1"] += $row[1];			}
		else  if($row[0] >= 5000 && $row[0] < 6000){	$array_subs["Subiculum"] += $row[1];		}
		else  if($row[0] >= 6000 && $row[0] < 7000){	$array_subs["Entorhinal Cortex"] += $row[1];	}
	}
	$i=0;
	foreach($array_subs as $key => $value){
		if($i%2==0){ $table_string .= '<tr class="white-bg">';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

		$table_string1 .= "<td>".$key."</td>";
		$table_string1 .= "<td>".$value."</td>";
		$table_string1 .= "</tr>";
		$i++;
	}
	
	return $table_string1;
}

function get_pages_views_report($conn){ //Passed $conn on Dec 3 2023
	$table_string = "<table>";
	$table_string .= "<tr><th>Month-Year</th><th>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	
	$page_views_query = "select concat(DATE_FORMAT(day_index,'%b'), '-', YEAR(day_index)) as dm, views 
			     from ga_analytics_pages_views where views > 0 
			     GROUP BY YEAR(day_index), MONTH(day_index)";

	$table_string .= format_table($conn, $page_views_query, $table_string, 2);
	$table_string .= "</tbody></table>";
	
	echo $table_string;
}
function get_table_skeleton_first($cols){
	$table_string1 = "<table>";
	if($cols){
		$table_string1 .= "<tr>";
		foreach($cols as $col){
			$table_string1 .= "<th>".$col."</th>";
		}
		$table_string1 .= "</tr>";
	}
	$table_string1 .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	return $table_string1;
}

function get_table_skeleton_end(){
	return "</tbody></table>";
}

function get_neurons_views_report($conn){ //Passed on Dec 3 2023
	$table_string = get_table_skeleton_first(['Neuron ID', 'Neuron Name', 'Views']);
	$page_neurons_views_query = " SELECT substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID,
                                    (select name from Type where id = substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) ) as neuron_name,
                                count(*) as count
                                FROM ga_analytics_pages
                                WHERE page LIKE '%id_neuron=%' -- and page LIKE '%/php/%' 
                                and substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) not in (4181, 2232, 23223 )
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4
                                GROUP BY substring_index(substring_index(page, 'id_neuron=', -1),'&', 1)"; //exclude '4181', '2232', '23223')

	$table_string .= format_table($conn, $page_neurons_views_query, $table_string, 3);
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

function get_morphology_property_views_report($conn){
	$table_string = get_table_skeleton_first(['Morphology', 'Layer', 'Views']);
	$page_property_views_query = "SELECT
				  SUBSTRING_INDEX(substring_index(substring_index(page, 'val_property=', -1), '&', 1),'_',1) AS subregion,
                                   SUBSTRING_INDEX(substring_index(substring_index(page, 'val_property=', -1), '&', 1),'_',-1) AS layer,
                                count(*)
                                FROM ga_analytics_pages
                                WHERE page LIKE '%property_page_morphology.php?id_neuron=%' -- and page LIKE '%/php/%'
				GROUP BY  substring_index(substring_index(page, 'val_property=', -1), '&', 1)";

	$array_subs = ["DG"=>["SMo"=>0,"SMi"=>0,"SG"=>0,"H"=>0],"CA3"=>["SLM"=>0, "SR"=>0, "SL"=>0, "SP"=>0,"SO"=>0],"CA2"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"CA1"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"SUB"=>["SM"=>0,"SP"=>0,"PL"=>0],"EC"=>["I"=>0,"II"=>0,"III"=>0,"IV"=>0,"V"=>0,"VI"=>0]];
        $table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 3, $array_subs);
	$table_string .= get_table_skeleton_end();

        echo $table_string;
}

function get_markers_property_views_report($conn){
	$table_string = get_table_skeleton_first(['Markers', 'Expression', 'Views']);
        $page_property_views_query = " SELECT
                                substring_index(substring_index(page, 'val_property=', -1), '&', 1) as markers,
                                substring_index(substring_index(page, 'color=', -1), '&', 1) as color,
                                count(*)
                                FROM ga_analytics_pages
				WHERE page like '%property_page_markers.php?id_neuron=%' 
                                -- WHERE page LIKE '%markers.php?id_neuron=%' -- and page LIKE '%/php/%'
                                GROUP BY substring_index(substring_index(page, 'property_page_markers.php', -1),'&', 1) 
				ORDER BY  substring_index(substring_index(page, 'val_property=', -1), '&', 1) ";

        $table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 3);
	$table_string .= get_table_skeleton_end();

        echo $table_string;
}


function get_subregion_views_report($conn){ //Passed on Dec 3 2023
	$table_string = get_table_skeleton_first(['Subregion', 'Views']);
	$page_subregion_views_query = "SELECT 
                                substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) as neuronID, 
				count(*) as views 
                                FROM ga_analytics_pages
                                WHERE page LIKE '%id_neuron=%' -- and page LIKE '%/php/%'  
                                AND length(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4
                                GROUP BY substring_index(substring_index(page, 'id_neuron=', -1),'&', 1)";
	$table_string .= format_table_sub($conn, $page_subregion_views_query, $table_string, 2);
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

function get_functionality_views_report($conn){
	$table_string = get_table_skeleton_first(['Property', 'Views']);

	$page_functionality_views_query = " select substring_index(substring_index(page, '/property_page_', -1),'.', 1), count(*)
                                FROM ga_analytics_pages where page like '%/property_page_%' 
				AND length(substring_index(substring_index(page, '?id_neuron=', -1), '&', 1)) = 4
                                AND substring_index(substring_index(page, '/property_page_', -1),'.', 1)
                                NOT IN ('synpro_nm_old2', 'connectivity_test', 'connectivity_orig') 
                                GROUP BY substring_index(substring_index(page, '/property_page_', -1),'?', 1)";
	 // -- exclude _page_synpro_nm_old2.php, _page_connectivity_test.php, _page_connectivity_orig.php"

	$table_string .= format_table($conn, $page_functionality_views_query, $table_string, 2);
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

?>

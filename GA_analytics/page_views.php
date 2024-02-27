<?php

function get_page_views($conn){ //Passed on Dec 3 2023
	/*$page_views_query = "select day_index, views 
		from ga_analytics_pages_views where views > 0 
		GROUP BY YEAR(day_index), MONTH(day_index)"; */
	$page_views_query = "SELECT YEAR(day_index) AS year, 
		MONTH(day_index) AS month, 
		SUM(views) AS total_views
			FROM ga_analytics_pages_views 
			WHERE views > 0
			GROUP BY YEAR(day_index), MONTH(day_index)";

	//AND day_index >= '2023-07-01' 
	$rs = mysqli_query($conn,$page_views_query);
	$result_page_views_array = array();
	while($row = mysqli_fetch_row($rs))
	{
		array_push($result_page_views_array, $row);
	}
	return $result_page_views_array;

}

function format_table($conn, $query, $table_string, $rows, $query2=NULL){
	$count = 0;
        $rs = mysqli_query($conn,$query);
	$table_string1 = '';
	if(!$rs || ($rs->num_rows < 1)){
		$table_string1 .= "<tr><td> No Data is available </td></tr>";
		return $table_string1;
	}
	if(isset($query2)){
		$rs2 = mysqli_query($conn,$query2);
		if(!$rs2 || ($rs2->num_rows < 1)){
			$table_string1 .= "<tr><td> No Data is available </td></tr>";
			return $table_string1;
		}
	}
	$i=0;
	while($row = mysqli_fetch_row($rs))
	{       
		$j=0;
		if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

		while($j < $rows){
			if($row[$j] == 'fp'){ $row[$j] = 'firing pattern'; }
			if($row[$rows-1] > 0){
				$table_string1 .= "<td>".$row[$j]."</td>";
			}
			$j++;
		}
		$count += $row[$rows-1];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	if(isset($query2)){
		while($row = mysqli_fetch_row($rs2))
		{
			$j=0;
			if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
			else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

			while($j < $rows){
				if($row[$j] == 'fp'){ $row[$j] = 'firing pattern'; }
				if($row[$rows-1] > 0){
					$table_string1 .= "<td>".$row[$j]."</td>";
				}
				$j++;
			}
			$count += $row[$rows-1];
			$table_string1 .= "</tr>";
			$i++;//increment for color gradient of the row
		}
	}
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";	
	return $table_string1;
}

function format_table_functionality($conn, $query, $table_string, $rows, $exclude=NULL){
        $count = 0; 
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
		if (isset($exclude) && $row[0] == $exclude) {
			continue;
		}
		if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
		else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS

		while($j < $rows){
			if($row[$j] == 'fp'){ $row[$j] = 'firing pattern'; }
			if($row[$rows-1] > 0){
				$table_string1 .= "<td>".$row[$j]."</td>";
			}
			$j++;
		}
		$count += $row[$rows-1];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
        }
        $table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
        return $table_string1;
}
function format_table_property($conn, $query, $table_string, $rows, $format){
	$count = 0;
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
			$row[0] = $format[$row[0]];
			if($row[$rows-1] > 0){
				$table_string1 .= "<td>".$row[$j]."</td>";
			}
			$j++;
		}
		$count += $row[$rows-1];
		$table_string1 .= "</tr>";
		$i++;//increment for color gradient of the row
	}
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
	return $table_string1;
}
function format_table_markers($conn, $query, $table_string, $rows, $array_subs = NULL){
	
	$count = 0;
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
			$count += $value1;
			$i++;
		}
		$j++;
        }
	$table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";

        return $table_string1;
}

function get_views_per_page_report($conn){ //Passed $conn on Dec 3 2023
	$table_string = "<table>";
	$table_string .= "<tr><th>Page</th><th>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";

	$page_views_query = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS total_views  FROM
					ga_analytics_pages gap WHERE gap.day_index IS NULL GROUP BY gap.page order by total_views desc";
	//echo $page_views_query;
	$page_views_query2 = "SELECT gap.page, SUM(CAST(REPLACE(gap.page_views, ',', '') AS SIGNED)) AS total_views FROM
					ga_analytics_pages gap WHERE gap.day_index IS NOT NULL and gap.page != '/php/' GROUP BY gap.page order by total_views desc";
	//echo $page_views_query2;

	$table_string .= format_table($conn, $page_views_query, $table_string, 2, $page_views_query2);

	$table_string .= "</tbody></table>";
	
	echo $table_string;
}

function get_pages_views_per_month_report($conn){ //Passed $conn on Dec 3 2023
	$table_string = "<table>";
	$table_string .= "<tr><th>Month-Year</th><th>Views</th></tr>";
	$table_string .= "<tbody style='height: 590px !important; overflow: scroll; '>";
	
	$page_views_per_month_query = "select concat(DATE_FORMAT(day_index,'%b'), '-', YEAR(day_index)) as dm, 
				sum(replace(views,',',''))  
			     from ga_analytics_pages_views where views > 0 
			     GROUP BY YEAR(day_index), MONTH(day_index)";
	//echo $page_views_per_month_query;
	$table_string .= format_table($conn, $page_views_per_month_query, $table_string, 2);
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
	$table_string = get_table_skeleton_first(['Subregion', 'Neuron Name', 'Views']);
	$page_neurons_views_query = "SELECT t.subregion, t.nickname AS neuron_name,
                SUM(replace(page_views, ',', '')) AS count
                        FROM
                        (
                         SELECT
                         substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) AS neuronID,
                         page_views
                         FROM 
                         ga_analytics_pages
                         WHERE
                         page LIKE '%id_neuron=%'
                         AND LENGTH(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4       
                        AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        ) AS derived
                        JOIN Type AS t ON t.id = derived.neuronID
                        GROUP BY
                        t.nickname, 
			 t.subregion";
	//echo $page_neurons_views_query;
	$table_string .= format_table_markers($conn, $page_neurons_views_query, $table_string, 3);
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

function get_morphology_property_views_report($conn){
	$table_string = get_table_skeleton_first(['Morphology', 'Layer', 'Views']);
	$page_property_views_query = "SELECT
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', 1) AS subregion,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1) AS layer,
					SUM(REPLACE(page_views, ',', '')) AS count
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%property_page_morphology.php?id_neuron=%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			GROUP BY
			subregion, layer";
	//echo $page_property_views_query;

	$array_subs = ["DG"=>["SMo"=>0,"SMi"=>0,"SG"=>0,"H"=>0],"CA3"=>["SLM"=>0, "SR"=>0, "SL"=>0, "SP"=>0,"SO"=>0],"CA2"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"CA1"=>["SLM"=>0,"SR"=>0,"SP"=>0,"SO"=>0],"SUB"=>["SM"=>0,"SP"=>0,"PL"=>0],"EC"=>["I"=>0,"II"=>0,"III"=>0,"IV"=>0,"V"=>0,"VI"=>0]];
        $table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 3, $array_subs);
	$table_string .= get_table_skeleton_end();

        echo $table_string;
}

function get_markers_property_views_report($conn){
	$table_string = get_table_skeleton_first(['Markers', 'Expression', 'Views']);

	$page_property_views_query = "SELECT
		SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1) AS markers,
		SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1) AS color,
		SUM(REPLACE(page_views, ',', '')) AS count
			FROM
			ga_analytics_pages
			WHERE
			page LIKE '%property_page_markers.php?id_neuron=%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
			GROUP BY
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'property_page_markers.php', -1), '&', 1)
			ORDER BY
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1)";
	//echo $page_property_views_query;
        $table_string .= format_table_markers($conn, $page_property_views_query, $table_string, 3);
	$table_string .= get_table_skeleton_end();

        echo $table_string;
}

function get_counts_views_report($conn, $page_string=NULL){
	$table_string = get_table_skeleton_first(['Neuron ID', 'Neuron Name', 'Views']);

        $page_counts_views_query = "SELECT
		t.id AS neuronID, t.nickname AS neuron_name, SUM(replace(page_views, ',', '')) AS count FROM
		( SELECT substring_index(substring_index(page, 'id_neuron=', -1), '&', 1) AS neuronID, page_views
		FROM ga_analytics_pages WHERE page LIKE ";
	if($page_string == 'phases'){
		$page_counts_views_query .= " '%property_page_phases.php?id_neuron=%' ";
	}
	if($page_string == 'counts'){
		$page_counts_views_query .= " '%property_page_counts.php?id_neuron=%' ";
	}
	$page_counts_views_query .= " AND LENGTH(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4
					AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
		)AS derived JOIN Type AS t ON t.id = derived.neuronID GROUP BY derived.neuronID, t.nickname";
        //echo $page_counts_views_query;
        $table_string .= format_table($conn, $page_counts_views_query, $table_string, 3);
        $table_string .= get_table_skeleton_end();

        echo $table_string;

}

function get_fp_property_views_report($conn){
	$table_string = get_table_skeleton_first(['Firing Pattern', 'Views']);
	$fp_format = [
		'ASP.' => 'adapting spiking',
		'ASP.ASP.' => 'adapting spiking followed by (slower) adapting spiking',
		'ASP.NASP' => 'non-adapting spiking preceded by adapting spiking',
		'ASP.SLN' => 'silence preceded by adapting spiking',
		'D.' => 'delayed spiking',
		'D.ASP.' => 'delayed adapting spiking',
		'D.NASP' => 'delayed non-adapting spiking',
		'D.PSTUT' => 'delayed persistent stuttering',
		'D.RASP.NASP' => 'non-adapting spiking preceded by delayed rapidly adapting spiking',
		'NASP' => 'non-adapting spiking',
		'PSTUT' => 'persistent stuttering',
		'PSWB' => 'persistent slow-wave bursting',
		'RASP.' => 'rapidly adapting spiking',
		'RASP.ASP.' => 'rapidly adapting spiking followed by adapting spiking',
		'RASP.NASP' => 'non-adapting spiking preceded by rapidly adapting spiking',
		'RASP.SLN' => 'silence preceded by rapidly adapting spiking',
		'TSTUT.' => 'transient stuttering',
		'TSTUT.NASP' => 'non-adapting spiking preceded by transient stuttering',
		'TSTUT.PSTUT' => 'transient stuttering followed by persistent stuttering',
		'TSTUT.SLN' => 'silence preceded by transient stuttering',
		'TSWB.NASP' => 'non-adapting spiking preceded by transient slow-wave bursting',
		'TSWB.SLN' => 'silence preceded by transient slow-wave bursting',
		'D.TSWB.NASP' => 'non-adapting spiking preceded by delayed transient slow-wave bursting',
		'D.TSTUT.' => 'delayed persistent stuttering',
		'TSTUT.ASP.' => 'transient stuttering followed by adapting spiking'
			];

	$page_fp_property_views_query = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1) AS fp,
				 SUM(REPLACE(page_views, ',', '')) AS count
		FROM ga_analytics_pages WHERE page LIKE '%property_page_fp.php?id_neuron=%'
		AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
		GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1)
		ORDER BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'parameter=', -1), '&', 1)";

	//echo $page_fp_property_views_query;
        $table_string .= format_table_property($conn, $page_fp_property_views_query, $table_string, 2, $fp_format);
	$table_string .= get_table_skeleton_end();

        echo $table_string;
}

function get_domain_functionality_views_report($conn){
	$table_string = get_table_skeleton_first(['Property', 'Views']);

	$page_functionality_views_query = "SELECT
                SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) AS property_page,
                SUM(REPLACE(page_views, ',', '')) AS views
                        FROM
                        ga_analytics_pages 
                        WHERE
                        page LIKE '%/property_page_%'
                        AND LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1)) = 4
                        AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        GROUP BY
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '?', 1)";
	//echo $page_functionality_views_query;
	$table_string .= format_table($conn, $page_functionality_views_query, $table_string, 2);
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

function get_page_functionality_views_report($conn){
	$table_string = get_table_skeleton_first(['Property', 'Views']);

	$page_functionality_views_query = "SELECT 
		CASE 
		WHEN page LIKE '%find_author.php%' THEN 'find_author'
		WHEN page LIKE '%index.php%' THEN 'index'
		WHEN page LIKE '%ephys.php%' THEN 'ephys'
		WHEN page LIKE '%Help_%' THEN 'Help'
		WHEN page LIKE '%analytics%' THEN 'analytics'
		WHEN page LIKE '%user_feedback%' THEN 'user_feedback'
		WHEN page LIKE '%phases%' THEN 'phases'
		WHEN page LIKE '%bot-traffic%' THEN 'bot'
		WHEN page = '/' THEN '/'
		WHEN page LIKE '%neuron_by_pattern%' THEN 'neuron_by_pattern'
		WHEN page LIKE '%synapse_probabilities%' THEN 'synapse_probabilities'
		WHEN page LIKE '%synaptome%' THEN 'synaptome'
		WHEN page LIKE '%synaptome_modeling%' THEN 'synaptome_modeling'
		WHEN page LIKE '%synaptome_model%' THEN 'synaptome_model'
		WHEN page LIKE '%/hipp Better than reCAPTCHA：vaptcha.cn%' THEN 'CAPTCHA'
		WHEN page LIKE '%search_engine%' THEN 'search_engine'
		WHEN page LIKE '%connectivity%' THEN 'connectivity'
		WHEN page LIKE '%find_neuron_name%' THEN 'find_neuron_name'
		WHEN page LIKE '%neuron_page%' THEN 'neuron_page'
		WHEN page LIKE '%search.php%' THEN 'search'
		WHEN page LIKE '%smtools%' THEN 'smtools'
		WHEN page LIKE '%synaptic_mod_sum.php%' THEN 'synaptic_mod_sum'
		WHEN page LIKE '%firing_patterns.php%' THEN 'firing_patterns'
		WHEN page LIKE '%/synaptic_probabilities/php/%' THEN 'synaptic_probabilities'
		WHEN page LIKE '%view_fp_image.php%' THEN 'view_fp_image'
		WHEN page LIKE '%markers.php%' THEN 'markers landing'
		WHEN page LIKE '%counts.php%' THEN 'counts landing'
		WHEN page LIKE '%morphology.php%' THEN 'morphology landing'
		WHEN page LIKE '%simulation_parameters.php%' THEN 'simulation_parameters'
		WHEN page LIKE '%tools.php%' THEN 'tools'
		WHEN page = '/php/' and day_index is null THEN '/php/' 
		WHEN page = '/php/' and day_index is not null THEN 'not php' 
		ELSE 'Landing Page'
		END AS property_page,
		    SUM(REPLACE(page_views, ',', '')) AS views
			    FROM ga_analytics_pages
			    GROUP BY property_page
			    ORDER BY 
			    views DESC ";
	//echo $page_functionality_views_query;
	$table_string .= format_table_functionality($conn, $page_functionality_views_query, $table_string, 2, 'not php');
	$table_string .= get_table_skeleton_end();
	
	echo $table_string;
}

?>

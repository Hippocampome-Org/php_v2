<?php
include ('functions.php');

function get_fp_property_views_report($conn, $write_file=NULL){
	$fp_format = [
		'ASP.' => 'Adapting Spiking',
		'ASP.ASP.' => 'Adapting Spiking followed by (slower) Adapting Spiking',
		'ASP.NASP' => 'Non-Adapting Spiking preceded by Adapting Spiking',
		'ASP.SLN' => 'silence preceded by Adapting Spiking',
		'D.' => 'Delayed Spiking',
		'D.ASP.' => 'Delayed Adapting Spiking',
		'D.NASP' => 'Delayed Non-Sdapting Spiking',
		'D.PSTUT' => 'Delayed Persistent Stuttering',
		'D.RASP.NASP' => 'Non-Adapting Spiking preceded by Delayed Rapidly Adapting Spiking',
		'NASP' => 'Non-Adapting Spiking',
		'PSTUT' => 'Persistent Stuttering',
		'PSWB' => 'Persistent Slow-Wave Bursting',
		'RASP.' => 'Rapidly Adapting Spiking',
		'RASP.ASP.' => 'Rapidly Adapting Spiking followed by Adapting Spiking',
		'RASP.NASP' => 'Non-Adapting Spiking preceded by Rapidly Adapting Spiking',
		'RASP.SLN' => 'Silence preceded by Rapidly Adapting Spiking',
		'TSTUT.' => 'Transient Stuttering',
		'TSTUT.NASP' => 'Non-Adapting Spiking preceded by Transient Stuttering',
		'TSTUT.PSTUT' => 'Transient Stuttering followed by Persistent Stuttering',
		'TSTUT.SLN' => 'Silence preceded by Transient Stuttering',
		'TSWB.NASP' => 'Non-Adapting Spiking preceded by Transient Slow-Wave Bursting',
		'TSWB.SLN' => 'Silence preceded by Transient Slow-Wave Bursting',
		'D.TSWB.NASP' => 'Non-Adapting Spiking preceded by Delayed Transient Slow-Wave Bursting',
		'D.TSTUT.' => 'Delayed Persistent Stuttering',
		'TSTUT.ASP.' => 'Transient Stuttering followed by Adapting Spiking'
			];

	$page_fp_property_views_query = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'meter=', -1), '&', 1) AS fp,
		SUM(REPLACE(page_views, ',', '')) AS views FROM ga_analytics_pages
			WHERE page LIKE '%/property_page_%'
			AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'fp'
			AND LENGTH(
					CASE
					WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) > 0 THEN
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '%', 1)
					ELSE
					SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
					END
				  ) = 4
			AND
			CASE
			WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) > 0 THEN
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '%', 1)
			ELSE
			SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
			END NOT IN (4168, 4181, 2232)
			GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'meter=', -1), '&', 1)
			ORDER BY views DESC";

	$columns = ['Firing Pattern', 'Views'];
	$options = ['format' => $fp_format,];
	if(isset($write_file)) {
		return format_table_combined($conn, $page_fp_property_views_query, 'firing_pattern_page_views', $columns, $write_file, $options);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_fp_property_views_query, 'firing_pattern_page_views', $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

?>

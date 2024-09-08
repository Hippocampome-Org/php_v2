<?php
include ('functions.php');

function get_page_functionality_views_report($conn, $views_request=NULL, $write_file=NULL){

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
		WHEN page LIKE '%synaptome.php%' THEN 'synaptome'
		WHEN page LIKE '%synaptome_modeling.php%' THEN 'synaptome_modeling'
		WHEN page LIKE '%synaptome_model%' THEN 'synaptome_model'
		WHEN page LIKE '%/hipp Better than reCAPTCHA：vaptcha.cn%' THEN 'CAPTCHA'
		WHEN page LIKE '%search_engine%' THEN 'search_engine'
		WHEN page LIKE '%find_neuron_name.php%' THEN 'find_neuron_name'
		WHEN page LIKE '%find_neuron_term.php%' THEN 'find_neuron_term'
		WHEN page LIKE '%neuron_page%' THEN 'neuron_page'
		WHEN page LIKE '%search.php%' THEN 'search'
		WHEN page LIKE '%smtools%' THEN 'smtools'
		WHEN page LIKE '%synaptic_mod_sum.php%' THEN 'synaptic_mod_sum'
		WHEN page LIKE '%firing_patterns.php%' THEN 'firing_patterns'
		WHEN page LIKE '%/synaptic_probabilities/php/%' THEN 'synaptic_probabilities'
		WHEN page LIKE '%view_fp_image.php%' THEN 'view_fp_image'
		WHEN page LIKE '%izhikevich_model.php%' THEN 'izhikevich_model'
		WHEN page LIKE '%markers.php%' THEN 'markers landing'
		WHEN page LIKE '%counts.php%' THEN 'counts landing'
		WHEN page LIKE '%connectivity.php%' THEN 'connectivity'
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

	if (($views_request == "views_per_month") || ($views_request == "views_per_year")) {
		$page_functionality_views_query = "SET SESSION group_concat_max_len = 1000000;
		SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_functionality_views_query .= "SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' THEN REPLACE(page_views, \\'\\', \\'\\') ELSE 0 END) AS `',
							YEAR(day_index), ' ', LEFT(MONTHNAME(day_index), 3), '`'
						      )
						ORDER BY YEAR(day_index), MONTH(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM ga_analytics_pages
				     ) months;";
		}

		if ($views_request == "views_per_year") {
			$page_functionality_views_query .= "SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' THEN REPLACE(page_views, \\'\\', \\'\\') ELSE 0 END) AS `',
							YEAR(day_index), '`'
						      )
						ORDER BY YEAR(day_index)
						SEPARATOR ', '
					    ) INTO @sql
				FROM (
						SELECT DISTINCT day_index
						FROM ga_analytics_pages
				     ) years;";
		}

		$page_functionality_views_query .= "
			SET @sql = CONCAT(
					'SELECT
					CASE
					WHEN page LIKE ''%find_author.php%'' THEN ''find_author''
					WHEN page LIKE ''%index.php%'' THEN ''index''
					WHEN page LIKE ''%ephys.php%'' THEN ''ephys''
					WHEN page LIKE ''%Help_%'' THEN ''Help''
					WHEN page LIKE ''%analytics%'' THEN ''analytics''
					WHEN page LIKE ''%user_feedback%'' THEN ''user_feedback''
					WHEN page LIKE ''%phases%'' THEN ''phases''
					WHEN page LIKE ''%bot-traffic%'' THEN ''bot''
					WHEN page = ''/'' THEN ''/''
					WHEN page LIKE ''%neuron_by_pattern%'' THEN ''neuron_by_pattern''
					WHEN page LIKE ''%synapse_probabilities%'' THEN ''synapse_probabilities''
					WHEN page LIKE ''%synaptome.php%'' THEN ''synaptome''
					WHEN page LIKE ''%synaptome_modeling.php%'' THEN ''synaptome_modeling''
					WHEN page LIKE ''%synaptome_model%'' THEN ''synaptome_model''
					WHEN page LIKE ''%/hipp Better than reCAPTCHA：vaptcha.cn%'' THEN ''CAPTCHA''
					WHEN page LIKE ''%search_engine%'' THEN ''search_engine''
					WHEN page LIKE ''%find_neuron_name.php%'' THEN ''find_neuron_name''
					WHEN page LIKE ''%find_neuron_term.php%'' THEN ''find_neuron_term''
					WHEN page LIKE ''%neuron_page%'' THEN ''neuron_page''
					WHEN page LIKE ''%search.php%'' THEN ''search''
					WHEN page LIKE ''%smtools%'' THEN ''smtools''
					WHEN page LIKE ''%synaptic_mod_sum.php%'' THEN ''synaptic_mod_sum''
					WHEN page LIKE ''%firing_patterns.php%'' THEN ''firing_patterns''
					WHEN page LIKE ''%/synaptic_probabilities/php/%'' THEN ''synaptic_probabilities''
					WHEN page LIKE ''%view_fp_image.php%'' THEN ''view_fp_image''
					WHEN page LIKE ''%izhikevich_model.php%'' THEN ''izhikevich_model''
					WHEN page LIKE ''%markers.php%'' THEN ''markers landing''
					WHEN page LIKE ''%counts.php%'' THEN ''counts landing''
					WHEN page LIKE ''%connectivity.php%'' THEN ''connectivity''
					WHEN page LIKE ''%morphology.php%'' THEN ''morphology landing''
					WHEN page LIKE ''%simulation_parameters.php%'' THEN ''simulation_parameters''
					WHEN page LIKE ''%tools.php%'' THEN ''tools''
					WHEN page = ''/php/'' AND day_index IS NULL THEN ''/php/''
					WHEN page = ''/php/'' AND day_index IS NOT NULL THEN ''not php''
					ELSE ''Landing Page''
					END AS property_page, ', 
					    @sql, ',
					    SUM(CAST(REPLACE(page_views, \\'\\', \\'\\') AS SIGNED)) AS Total_Views
						    FROM ga_analytics_pages
						    GROUP BY property_page
						    ORDER BY total_views DESC'
						    );";

		$page_functionality_views_query .= "
			PREPARE stmt FROM @sql;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;";
	}

	//echo $page_functionality_views_query;
	$options = ['exclude' => ['not php'],];
	$options = [];//'exclude' => ['not php'],]; //Added this line to make sure we are getting all counts can remove it later
	$columns = ['Property', 'Views'];
	$file_name = "functionality_domain_page_";
	if(isset($write_file)) {
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		return format_table_combined($conn, $page_functionality_views_query, $file_name,  $columns, $write_file, $options, $views_request);
		//	return format_table_combined($conn, $page_functionality_views_query, 'functionality_domain_page_views',  $columns, $write_file, $options);
	}else{
		$table_string = get_table_skeleton_first($columns);
		$table_string .= format_table_combined($conn, $page_functionality_views_query, 'functionality_domain_page_views',  $columns, $write_file=NULL, $options);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}
?>

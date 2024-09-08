<?php
include ('functions.php');

function get_domain_functionality_views_report($conn, $views_request = NULL, $write_file = NULL){
	$page_functionality_views_query = "SELECT 
		CASE 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('morphology') THEN 'Morphology'
        WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('morphology_linking_pmid_isbn') THEN 'Morphology: PMID / ISBN'
        WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('/synaptome/php/synaptome') THEN 'Synaptome'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('connectivity', 'connectivity_orig', 'connectivity_test') THEN 'Connectivity: Known / Potential' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'counts' THEN 'Census' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'ephys' THEN 'Membrane Biophysics' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'fp' THEN 'FP'
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases' THEN 'In Vivo' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'markers' THEN 'Markers' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro' THEN 'Morphology: Axon and Dendrite Lengths / Somatic Distances' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('synpro_nm', 'synpro_nm_old2') THEN 'Connectivity: Number of Potential Synapses / Number of Contacts / Synaptic Probability' 
		WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_pvals' THEN 'Connectivity: Parcel-Specific Tables' 
		ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) 
		END AS property_page_category,
		    SUM(REPLACE(page_views, ',', '')) AS views 
			    FROM ga_analytics_pages 
			    WHERE page LIKE '%/property_page_%' 
			    AND (
					    LENGTH(
						    CASE 
						    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) > 0 THEN
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '%', 1)
						    ELSE
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
						    END
						  ) = 4 
					    OR LENGTH(
						    CASE 
						    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) > 0 THEN
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '%', 1)
						    ELSE
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
						    END
						    ) = 4 
					    OR LENGTH(
						    CASE 
						    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) > 0 THEN
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '%', 1)
						    ELSE
						    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
						    END
						    ) = 4
					    )
					    AND (
							    CASE 
							    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)) > 0 THEN
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '%', 1)
							    ELSE
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
							    END NOT IN (4168, 4181, 2232)
							    OR CASE 
							    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)) > 0 THEN
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '%', 1)
							    ELSE
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
							    END NOT IN (4168, 4181, 2232)
							    OR CASE 
							    WHEN LOCATE('%', SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)) > 0 THEN
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '%', 1)
							    ELSE
							    SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
							    END NOT IN (4168, 4181, 2232)
						)
					    GROUP BY property_page_category
					    ORDER BY views DESC";
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
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''morphology'') THEN ''Morphology''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''morphology_linking_pmid_isbn'') THEN ''Morphology: PMID / ISBN''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''/synaptome/php/synaptome'') THEN ''Synaptome''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''connectivity'', ''connectivity_orig'', ''connectivity_test'') THEN ''Connectivity: Known / Potential''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''counts'' THEN ''Census''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''ephys'' THEN ''Membrane Biophysics''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''fp'' THEN ''FP''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''phases'' THEN ''In Vivo''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''markers'' THEN ''Markers''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''synpro'' THEN ''Morphology: Axon and Dendrite Lengths / Somatic Distances''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''synpro_nm'', ''synpro_nm_old2'') THEN ''Connectivity: Number of Potential Synapses / Number of Contacts / Synaptic Probability''
                    WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''synpro_pvals'' THEN ''Connectivity: Parcel-Specific Tables''
                    ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1)
                END AS property_page_category, ', 
                @sql, ',
                SUM(REPLACE(page_views, \\'\\', \\'\\')) AS Total_Views
                FROM ga_analytics_pages
                WHERE page LIKE ''%/property_page_%''
                AND (
                    LENGTH(
                        CASE 
                        WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)) > 0 THEN
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''%'', 1)
                        ELSE
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
                        END
                    ) = 4
                    OR LENGTH(
                        CASE
                        WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)) > 0 THEN
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''%'', 1)
                        ELSE
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
                        END
                    ) = 4 
                    OR LENGTH(
                        CASE
                        WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)) > 0 THEN
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''%'', 1)
                        ELSE
                        SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
                        END
                    ) = 4
                )
                AND (
                    CASE
                    WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)) > 0 THEN
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''%'', 1)
                    ELSE
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
                    END NOT IN (4168, 4181, 2232)
                    OR CASE
                    WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)) > 0 THEN
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''%'', 1)
                    ELSE
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
                    END NOT IN (4168, 4181, 2232)
                    OR CASE
                    WHEN LOCATE(''%'', SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)) > 0 THEN
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''%'', 1)
                    ELSE
                    SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
                    END NOT IN (4168, 4181, 2232)
                )
                GROUP BY property_page_category
                ORDER BY Total_Views DESC'
        );";

    $page_functionality_views_query .= "
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;";
}

	//echo $page_functionality_views_query;
	$columns = ['Property', 'Views'];
        $table_string='';
	$file_name='functionality_property_domain_page_';
        if(isset($write_file)) {
                if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
                        $file_name .= $views_request;
                }else{ $file_name .= 'views'; }
                return format_table($conn, $page_functionality_views_query, $table_string, $file_name, $columns, $neuron_ids=NULL, $write_file, $views_request);
		//return format_table($conn, $page_functionality_views_query, $table_string, 'functionality_property_domain_page_views', $columns, $neuron_ids=NULL, $write_file);
	}else{
		$file_name .= 'views';
		$table_string = format_table($conn, $page_functionality_views_query, $table_string, $file_name, $columns);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

?>

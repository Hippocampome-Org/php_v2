<?php
include ('functions.php');

function get_neurons_views_report($conn, $neuron_ids=NULL, $views_request=NULL, $write_file=NULL){ //Passed on Dec 3 2023

	$columns = ['Subregion', 'Neuron Type Name', 'Census','Views'];
     
	$page_neurons_views_query = "SET @sql = NULL;

SELECT GROUP_CONCAT(DISTINCT CONCAT(
    'SUM(CASE WHEN nd.property_page_category = ''', property_page_category, ''' THEN 
    REPLACE(nd.page_views, '','', '''') ELSE 0 END) AS `', property_page_category, '`'
)) INTO @sql
FROM (
    SELECT DISTINCT 
        CASE 
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('morphology') THEN 'Morphology: ADL / SD'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('morphology_linking_pmid_isbn') THEN 'Morphology: PMID / ISBN'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('markers') THEN 'Molecular Markers'
            WHEN page LIKE '%property_page_counts.php%' THEN 'Census'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('connectivity', 'connectivity_orig', 'connectivity_test') THEN 'Connectivity: Known / Potential'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'ephys' THEN 'Membrane Biophysics'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'fp' THEN 'FP'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'phases' THEN 'In Vivo'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('synpro_nm', 'synpro_nm_old2') THEN 'Connectivity: NoPS / NoC / PS'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) = 'synpro_pvals' THEN 'Connectivity: Parcel-Specific Tables'
            WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1) IN ('/synaptome/php/synaptome', 'synaptome') THEN 'Synaptome'
            ELSE CONCAT( UPPER(SUBSTRING_INDEX(SUBSTRING_INDEX(page, '/property_page_', -1), '.', 1)) )
        END AS property_page_category
    FROM ga_analytics_pages 
    WHERE (page LIKE '%property_page_counts.php%' OR page LIKE '%id_neuron=%' OR page LIKE '%id1_neuron=%' OR page LIKE '%id_neuron_source=%')
        AND LENGTH(
            CASE 
                WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
                WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
                WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
            END
        ) = 4
        AND (
            CASE 
                WHEN page LIKE '%id_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1)
                WHEN page LIKE '%id1_neuron=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id1_neuron=', -1), '&', 1)
                WHEN page LIKE '%id_neuron_source=%' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron_source=', -1), '&', 1)
            END NOT IN (4168, 4181, 2232)
        )
) AS categories
WHERE property_page_category IN (
    'Census', 'Connectivity: Known / Potential', 'Connectivity: NoPS / NoC / PS', 'Connectivity: Parcel-Specific Tables',
    'FP', 'In Vivo', 'Membrane Biophysics', 'Molecular Markers', 'Morphology: ADL / SD', 'Morphology: PMID / ISBN',
    'SYNPRO', 'Synaptome'
);

SET @sql = CONCAT(
    ' SELECT t.subregion AS Subregion, t.page_statistics_name AS Neuron_Type_Name, ', @sql, ', 
    SUM(REPLACE(nd.page_views, '','', '''')) AS Total_Views 
    FROM (
        SELECT 
            CASE 
                WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
                WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
                WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
            END AS neuronID, 
            CASE WHEN page LIKE ''%property_page_counts.php%'' THEN 1 ELSE 0 END AS is_property_page, 
            CASE 
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''morphology'') THEN ''Morphology: ADL / SD''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''morphology_linking_pmid_isbn'') THEN ''Morphology: PMID / ISBN''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''markers'') THEN ''Molecular Markers''
                WHEN page LIKE ''%property_page_counts.php%'' THEN ''Census''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''connectivity'', ''connectivity_orig'', ''connectivity_test'') THEN ''Connectivity: Known / Potential''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''ephys'' THEN ''Membrane Biophysics''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''fp'' THEN ''FP''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''phases'' THEN ''In Vivo''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''synpro_nm'', ''synpro_nm_old2'') THEN ''Connectivity: NoPS / NoC / PS''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) = ''synpro_pvals'' THEN ''Connectivity: Parcel-Specific Tables''
                WHEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1) IN (''/synaptome/php/synaptome'', ''synaptome'') THEN ''Synaptome''
                ELSE CONCAT(UPPER(SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''/property_page_'', -1), ''.'', 1)))
            END AS property_page_category, 
            page_views 
        FROM ga_analytics_pages 
        WHERE (page LIKE ''%property_page_counts.php%'' OR page LIKE ''%id_neuron=%'' OR page LIKE ''%id1_neuron=%'' OR page LIKE ''%id_neuron_source=%'')
            AND LENGTH(
                CASE 
                    WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
                    WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
                    WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
                END
            ) = 4
            AND (
                CASE 
                    WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
                    WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
                    WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
                END NOT IN (4168, 4181, 2232)
            )
    ) AS nd 
    JOIN Type AS t ON nd.neuronID = t.id 
    GROUP BY t.page_statistics_name, t.subregion 
    ORDER BY t.position;'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
";
	if (($views_request == "views_per_month")  || ($views_request == "views_per_year")) {
		$page_neurons_views_query = "SET @sql = NULL;";

		if ($views_request == "views_per_month") {
			$page_neurons_views_query .= "SELECT
				GROUP_CONCAT(DISTINCT
						CONCAT(
							'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
								' AND MONTH(day_index) = ', MONTH(day_index),
								' THEN REPLACE(nd.page_views, '','', '''') ELSE 0 END) AS `',
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
		if($views_request == "views_per_year"){
		$page_neurons_views_query .= " SELECT
			GROUP_CONCAT(DISTINCT
					CONCAT(
						'SUM(CASE WHEN YEAR(day_index) = ', YEAR(day_index),
							' THEN REPLACE(nd.page_views, \",\", \"\") ELSE 0 END) AS `',
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

		$page_neurons_views_query .= "
								SET @sql = CONCAT(
									'SELECT t.subregion AS Subregion, t.page_statistics_name AS Neuron_Type_Name, ',
									@sql,
									', SUM(REPLACE(nd.page_views, '','', '''')) AS Total_Views',
									' FROM (
										SELECT
										CASE
										WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
										WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
										WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
										END AS neuronID,
										page_views,
										day_index,
										CASE
										WHEN page LIKE ''%property_page_counts.php%'' THEN 1
										ELSE 0
										END AS is_property_page
										FROM ga_analytics_pages
										WHERE
										(page LIKE ''%id_neuron=%'' OR page LIKE ''%id1_neuron=%'' OR page LIKE ''%id_neuron_source=%'') AND
										LENGTH(
											CASE
											WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
											WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
											WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
											END
										      ) = 4 AND
										(
										 CASE
										 WHEN page LIKE ''%id_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron='', -1), ''&'', 1)
										 WHEN page LIKE ''%id1_neuron=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id1_neuron='', -1), ''&'', 1)
										 WHEN page LIKE ''%id_neuron_source=%'' THEN SUBSTRING_INDEX(SUBSTRING_INDEX(page, ''id_neuron_source='', -1), ''&'', 1)
										 END
										) NOT IN (''4168'', ''4181'', ''2232'')
										) AS nd
										JOIN Type AS t ON nd.neuronID = t.id
										GROUP BY t.subregion, t.page_statistics_name
										ORDER BY t.position'); 	PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;"; 
	}

//Till Here on Jul 2 2024

	//$table_string = get_table_skeleton_first($columns);
	if(isset($write_file)) {
		$file_name = "neurons_";
		if($views_request == 'views_per_month' || $views_request == 'views_per_year'){
			$file_name .= $views_request;
		}else{$file_name .= "views"; }
		
		return format_table_neurons($conn, $page_neurons_views_query, $table_string, $file_name, $columns, $neuron_ids, $write_file, $views_request);
	}else{
		$table_string = '';
		$table_string .= format_table_neurons($conn, $page_neurons_views_query, $table_string, 'neurons_views', $columns, $neuron_ids);
		$table_string .= get_table_skeleton_end();
		echo $table_string;
	}
}

?>

<?php
include ('functions.php');

function format_table_pmid($conn, $query, $table_string, $csv_tablename, $csv_headers, $neuron_ids=NULL, $write_file=NULL){
        $count = 0;
        $csv_rows = [];
    $rs = mysqli_query($conn,$query);
        $table_string1 = '';
        $rows = count($csv_headers);
        //For Phases page to replciate the string we show
        $phase_evidences=['all_other'=>'Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau, AP threshold, fAHP, or APpeak trough.',
                                'theta'=>'Theta', 'swr_ratio'=>'SWR ratio','firingRate'=>'Firing rate'];
        //Neuronal Segment Data
        $neuronal_segments = ['blue'=>'Dendrites','blueSoma'=>'Dendrites-Somata','red'=>'Axons','redSoma'=>'Axons-Somata','somata'=>'Somata','violet'=>'Axons-Dendrites','violetSoma'=>'Axons-Dendrites-Somata'];
        if(!$rs || ($rs->num_rows < 1)){
                $table_string1 .= "<tr><td> No Data is available </td></tr>";
                return $table_string1;
        }
        $i=0;
        while($row = mysqli_fetch_row($rs))
        {       
                $csv_rows[] = $row;
                $j=0;
                if($i%2==0){ $table_string .= '<tr class="white-bg" >';}
                else{ $table_string1 .= '<tr class="blue-bg">';}//Color gradient CSS
                if($csv_tablename == 'pmid_isbn_table'){
                        $row[0] = get_link($row[0], $row[0], 'https://pubmed.ncbi.nlm.nih.gov/', 'pmid');
                        $row[3] = get_link($row[3], $neuron_ids[$row[3]], './neuron_page.php','neuron');
                }
                while($j < $rows){
                        if(isset($phase_evidences[$row[$j]])){ $row[$j] = $phase_evidences[$row[$j]]; }
                        if(isset($neuronal_segments[$row[$j]])){ $row[$j] = $neuronal_segments[$row[$j]]; }
                        if(isset($neuron_ids[$row[$j]])){ $row[$j] = neuron_ids[$row[$j]]; }
                        if($row[$rows-1] > 0){
                                $table_string1 .= "<td>".ucwords($row[$j])."</td>";
                        }
                        $j++;
                }
                $count += $row[$rows-1];
                $table_string1 .= "</tr>";
                $i++;//increment for color gradient of the row
        }

        if(isset($write_file)){
                $totalRow = ["Total Count",'','','','',$count];
                $csv_tablename='morphology_linking_PMID_ISBN_property_page_views';
                $csv_rows[] = $totalRow;
                $csv_data[$csv_tablename]=['filename'=>toCamelCase($csv_tablename),'headers'=>$csv_headers,'rows'=>$csv_rows];
                return $csv_data[$csv_tablename];
        }
        else{
                $table_string1 .= "<tr><td colspan='".($rows-1)."'><b>Total Count</b></td><td>".$count."</td></tr>";
                return $table_string1;
        }
}

function get_pmid_isbn_property_views_report($conn, $neuron_ids, $write_file=NULL){
        
        $page_pmid_isbn_property_views_query = " SELECT linking_pmid_isbn, t.subregion, layer, t.page_statistics_name as neuron_name, color, SUM(REPLACE(page_views, ',', '')) AS views
                        FROM
                        (
                                SELECT
                                IF(INSTR(page, 'linking_pmid_isbn=') > 0,SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'linking_pmid_isbn=', -1), '&', 1),'') AS linking_pmid_isbn,
                                IF(INSTR(page, 'val_property=') > 0, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'val_property=', -1), '&', 1), '_', -1),'')  AS layer,
                                SUBSTRING_INDEX(SUBSTRING_INDEX(page, '?id_neuron=', -1), '&', 1) AS neuronID,
                                IF(INSTR(page, 'color=') > 0,SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'color=', -1), '&', 1),'') as color, page_views
                                FROM ga_analytics_pages
                                WHERE
                                page LIKE '%property_page_morphology_linking_pmid_isbn.php?id_neuron=%'
                                AND LENGTH(substring_index(substring_index(page, 'id_neuron=', -1), '&', 1)) = 4
                                AND SUBSTRING_INDEX(SUBSTRING_INDEX(page, 'id_neuron=', -1), '&', 1) NOT IN (4168, 4181, 2232)
                        ) AS derived
                        JOIN Type AS t ON t.id = derived.neuronID
                         WHERE   derived.neuronID NOT IN ('4168', '4181', '2232')
                         GROUP BY linking_pmid_isbn, t.subregion, layer, t.page_statistics_name, color
                        ORDER BY CAST(linking_pmid_isbn AS UNSIGNED) ASC";
        //echo $page_pmid_isbn_property_views_query;
    
        $columns = ['PubMed ID/ISBN', 'Subregion', 'Layer', 'Neuron Type Name', 'Neuronal Segment', 'Views'];
        $table_string='';
        if(isset($write_file)) {
                return format_table_pmid($conn, $page_pmid_isbn_property_views_query, $table_string, 'pmid_isbn_table', $columns, $neuron_ids, $write_file);
        }else{ 
                $table_string .= get_table_skeleton_first($columns);
                $table_string .= format_table_pmid($conn, $page_pmid_isbn_property_views_query, $table_string, 'pmid_isbn_table', $columns, $neuron_ids);
                $table_string .= get_table_skeleton_end();
                echo $table_string;
        }
}

?>

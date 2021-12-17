<?php

// Returns an html string containing abbreviation definitions
// matched to the abbreviations present in $std_sem_list

$definition_table = array(
  'std' => 'SD: standard deviation',
  'sem' => 'SEM: standard error from the mean',
  'istim' => 'Istimul: amplitude of current step stimulus',  // DWW new abbreviation definition
  'time' => 'Tstimul: duration of current step stimulus'		// DWW new abbreviation definition
);

function get_abbreviation_definition_box($abbreviation_list) {
  $definitions = get_abbreviation_definitions($abbreviation_list);
  $definition_str = implode('; ', $definitions);
    //"<table align='center' width='70%' border='0' cellspacing='2' cellpadding='2'>
    //<tr>
    //<td width='20%' align='right' class='table_neuron_page1'>
    //</td>
    //<td align='left' width='80%' class='table_neuron_page2'>
    //$definition_str
    //</td>				
    //</tr>							
    //</table>";
  $box_html =
  "<tr>
					<td width='20%' align='right'>
					</td>
					<td align='left' width='80%' class='table_neuron_page2'>
						<br>
            $definition_str
					</td>					
				</tr>";
    return $box_html;
}

// helper that returns the definitions as a list
function get_abbreviation_definitions($abbreviation_list) {
  global $definition_table;
  $present_abbreviations = array_intersect(array_keys($definition_table), $abbreviation_list);
  $definition_strs = array_values(array_intersect_key($definition_table, array_flip($present_abbreviations)));
  return $definition_strs;
}

?>


<?php
include ("../../access_db.php");


function display_neuron_details($results){
    
    $neuron = array_keys($results);
    $neuron = $neuron[0];
    $neuron_vals = $results[$neuron];

    echo "<table width:'50%;'>";
    echo "<tr><td><b>";
    echo $neuron." Synaptome Details:";
    echo "</b></td></tr>";
    foreach($neuron_vals as $key => $value){
        echo "<tr>";
        echo "<td><b>";
        echo $key;
        echo "</b></td>";
        echo "<td>";
            echo $value;
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function get_default_synaptome_details($conn_synaptome, $table_name = NULL, $neuron){
   $columns = array();
   $columns = ['pre'];
   if($table_name == NULL){$table_name ='tm_cond16';}
   $select_default_synaptome_query = "SELECT pre, ";

   $column = "means_g, means_tau_d, means_tau_r, means_tau_f, means_u, ";
   $select_default_synaptome_query .= "AVG(means_g) as means_g, AVG(means_tau_d) as means_tau_d, 
                                       AVG(means_tau_r) as means_tau_r, 
                                       AVG(means_tau_f) as means_tau_f, AVG(means_u) 
                                       as means_u, ";
   $column .= "min_g, min_tau_d, min_tau_r, min_tau_f, min_u, ";
   $select_default_synaptome_query .= " AVG(min_g) as min_g, AVG(min_tau_d) as min_tau_d, 
                                       AVG(min_tau_r) as min_tau_r, 
                                       AVG(min_tau_f) as min_tau_f, AVG(min_u) as min_u, ";

   $column .= "max_g, max_tau_d, max_tau_r, max_tau_f, max_u, ";
   $select_default_synaptome_query .= " AVG(max_g) as max_g, AVG(max_tau_d) as max_tau_d, 
                                       AVG(max_tau_r) as max_tau_r, 
                                       AVG(max_tau_f) as max_tau_f, AVG(max_u) as max_u, ";

   $select_default_synaptome_query = substr($select_default_synaptome_query, 0, -2);
   $select_default_synaptome_query .= " from ".$table_name;
   $select_default_synaptome_query .= " WHERE pre like '".$neuron."%' ";
   $select_default_synaptome_query .= " GROUP BY pre"; 
  // echo $select_default_synaptome_query;
   $rs = mysqli_query($conn_synaptome,$select_default_synaptome_query);
   $column = substr($column, 0, -2);
   $columns += explode(", ", $column);
   $result_default_synaptome_array = array();
   while($row = mysqli_fetch_row($rs))
   {	
       $arrVal = [];  
       $i=0;          
       foreach($columns as $colVal){
           if($colVal=='pre'){
               $pre = $row[$i]; //To get the pre value as key
               $pre = trim(substr($row[$i], 0, strpos($row[$i], '('))); //Getting DG Granule from DG Granule (+)2201p
           }else{
               $arrVal[$colVal] = $row[$i]; //tp get other values like mean etc as key and value
           }
           $i++;
       }
       $result_default_synaptome_array[$pre] = $arrVal;
   }
   return  $result_default_synaptome_array;
}

$result_default_synaptome_array = array();
$excel_data = array();
$neuron = trim($_GET['pre']);

echo "<HTML>";
echo "<HEAD>";
echo "<TITLE>".$neuron." Synaptome Details</TITLE>";
echo "</HEAD>";
echo "<BODY>";

//Including this table name is for future as we know we might need details from different tables
$result_default_synaptome_array = get_default_synaptome_details($conn_synaptome, 'tm_cond16', $neuron);
if($result_default_synaptome_array){
    display_neuron_details($result_default_synaptome_array);
}

echo "</BODY>";
echo "</HTML>";
?>
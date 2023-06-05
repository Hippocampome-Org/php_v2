<?php
  include ("permission_check.php");
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!--
Probability of Connection Tool

References: https://stackoverflow.com/questions/7431268/how-to-read-data-from-csv-file-using-javascript
https://stackoverflow.com/questions/5316697/jquery-return-data-after-ajax-call-success
https://gist.github.com/carolineartz/ae3f1021bb41de2b1935
http://www.endmemo.com/js/jstatistics.php
https://stackoverflow.com/questions/2140627/how-to-do-case-insensitive-string-comparison
https://stackoverflow.com/questions/53798216/toprecision-rounding-direction
-->
<head>
    <meta charset="UTF-8">
    <title>Probability of Connection Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
    <link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
    <script type="text/javascript" src="style/resolution.js"></script>
</head>
<body>

<?php 
include("function/title.php");
include("function/menu_main.php");  
?> 
<div id="main" class="main" style="padding-top: 1%; padding-left: 1%">
    <form id="conn_form" class="pure-form" onsubmit="return false;">
        <fieldset>
            <h2>Probability of connection</h2>
            <table>
                <tr>
                   <td>Presynaptic</td>
                    <td>
                        <?php
                            if (isset($_REQUEST["source"])) {
                                echo "<select id='source' name='source' onchange='sourceSelected()' value='".$_REQUEST["source"]."'></select>";
                            }
                            else {
                                echo "<select id='source' name='source' onchange='sourceSelected()' disabled></select>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Postsynaptic</td>
                    <td>
                        <?php
                            if (isset($_REQUEST["target"])) {
                                echo "<select id='target' name='target' onchange='targetSelected()' value='".$_REQUEST["target"]."'></select>";
                            }
                            else {
                                echo "<select id='target' name='target' onchange='targetSelected()' disabled></select>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> Dendritic spine distance (μm)</td>
                    <td>
                        <?php
                            if (isset($_REQUEST["spine_distance"])) {
                                echo "<input id='spine_distance' name='spine_distance' type='text' value='".$_REQUEST["spine_distance"]."' />";
                            }
                            else {
                                echo "<input id='spine_distance' name='spine_distance' type='text' value='1.09' disabled />";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> Inter-bouton distance (μm)</td>
                    <td>
                        <?php
                            if (isset($_REQUEST["bouton_distance"])) {
                                echo "<input id='bouton_distance' name='bouton_distance' type='text' value='".$_REQUEST["bouton_distance"]."' />";
                            }
                            else {
                                echo "<input id='bouton_distance' name='bouton_distance' type='text' value='6.2' disabled />";
                            }
                        ?>
                    </td>
                </tr>
                <!-- tr>
                    <td>Number of contacts</td>
                    <td> <input id="contacts" type="text" disabled></td>
                </tr -->
                <input id="contacts" type="hidden" />
                <tr>
                    <td>Radius of interaction (μm)</td>
                    <td>
                        <?php
                            if (isset($_REQUEST["interaction"])) {
                                echo "<input id='interaction' name='interaction' type='text' value='".$_REQUEST["interaction"]."' />";
                            }
                            else {
                                echo "<input id='interaction' name='interaction' type='text' value='2' disabled />";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="source_id" name="source_id" value="" />
            <input type="hidden" id="target_id" name="target_id" value="" />
            <?php
                echo "<button id='s' name='conn_submit' class='pure-button pure-button-primary' onclick='submitClicked()' ";
                if (isset($_REQUEST["conn_submit"])) {
                    // no output
                }
                else {
                    echo "disabled";
                }
                echo " style='z-index:10;'>Submit</button>";
            ?>
        </fieldset>
    </form>
    <div id="title1" style="position:relative;top:-20px;display: none;z-index:5"><center>Probability of Connection Per Neuron Pair</center></div>
    <div id="graph" style="height:300px;position:relative;top:-20px;z-index:1"></div>
    <div id="title2" style="position:relative;bottom:300px;display: none;z-index:5"><center>Number of Contacts Per Connected Neuron Pair</center></div>
    <div id="graph_noc" style="height:300px;position:relative;top:-180px;z-index:1"></div>
</div>
    <script>
        let connDic = {};
        let sourceIDDic = {};
        let targetIDDic = {};
        function parcel_volume(all_groups, source_id, target_id, subregion, parcel) {    
            //
            //    toUpperCase() is used for case insensitive matching
            //        
            let parcel_volumes_group = all_groups[4];
            let volume = 0;
            //document.write(source_id+" "+target_id+" "+subregion+" "+parcel);

            for (var i = 0; i < parcel_volumes_group.length; i++) {
                let curr_source_id = parcel_volumes_group[i][0];
                let curr_target_id = parcel_volumes_group[i][1];
                let curr_subregion = parcel_volumes_group[i][2];
                let curr_parcel = parcel_volumes_group[i][3];
                let curr_vol = parcel_volumes_group[i][4];

                if ((source_id == curr_source_id) && (target_id == curr_target_id) && (subregion.toString()).toUpperCase() === (curr_subregion.toString()).toUpperCase() && (parcel.toString()).toUpperCase() === (curr_parcel.toString()).toUpperCase()) {
                    volume = curr_vol;
                }
            }

            return volume;
        }
        function variance(arr)
        {
            var len = 0;
            var sum=0;
            for(var i=0;i<arr.length;i++)
            {
                if (arr[i] == ""){}
                else
                {
                    len = len + 1;
                    sum = sum + parseFloat(arr[i]);
                }
            }
            var v = 0;
            if (len > 1)
            {
                var mean = sum / len;
                for(var i=0;i<arr.length;i++)
                {
                    if (arr[i] == ""){}
                    else { v = v + (arr[i] - mean) * (arr[i] - mean); }
                }
                return v / len;
            }
            else { return 0; }
        }
        function stdev(array) {
            let new_array = Array();
            for (let i = 0; i < array.length; i++) {
                let value = parseFloat(array[i]);
                if (!isNaN(value) && value > 0) {
                    new_array.push(value);
                }
            }
            return Math.sqrt(variance(new_array));
        } 
        function sum(array) {
            let total = 0;
            for (let i=0; i<array.length; i++) {
                let value = parseFloat(array[i]);
                if (!isNaN(value) && value > 0) {
                    total = total + value;
                }
            }
            return total;
        };
        function mean(array) {
            let arraySum = sum(array);
            
            return arraySum / array.length;
        }
        function calc_stats(all_groups, parcel) {
            let spine_distance = parseFloat(document.getElementById("spine_distance").value);
            let bouton_distance = parseFloat(document.getElementById("bouton_distance").value);
            let interaction = parseFloat(document.getElementById("interaction").value);     
            let vint = (4.0 / 3) * Math.PI * Math.pow(interaction, 3);
            let c = vint /(spine_distance*bouton_distance);
            let nps_mean = 0;
            let nps_stdev = 0;
            let nc_mean = 0;
            let nc_stdev = 0;
            let cp_mean = 0;
            let cp_stdev = 0;
            let overlap_volume_mean = 0;
            let overlap_volume_stdev = 0;
            let source = document.getElementById("source").value.trim();
            let target = document.getElementById("target").value.trim();
            let source_id = sourceIDDic[source];
            let target_id = targetIDDic[target];
            let source_subregion = document.getElementById("source").value.split(" ")[0];
            if (source_subregion == "CA3c") {source_subregion = "CA3";}
            let target_subregion = document.getElementById("target").value.split(" ")[0];
            if (target_subregion == "CA3c") {target_subregion = "CA3";}
            let dendrite_lengths_group = all_groups[0];
            let dendrite_volumes_group = all_groups[1];
            let axon_lengths_group = all_groups[2];
            let axon_volumes_group = all_groups[3];
            let dendrite_lengths = Array();
            let dendrite_volumes = Array();
            let axon_lengths = Array();
            let axon_volumes = Array();
            let axonal_length_mean = 0;
            let dendritic_length_mean = 0;
            let volume = 0;            
            let stat_values = Array();
            let parcels_axon = Array();
            let parcels_dendrite = Array();
            let parcels_both = Array();
            let n_parcels = 0;

            for (let i = 0; i < axon_lengths_group.length; i++) {
                let axon_neuron_id = axon_lengths_group[i][0];
                let axon_subregion = axon_lengths_group[i][1];
                let axon_parcel = axon_lengths_group[i][2];
                let axon_neurite = axon_lengths_group[i][3];
                let axon_length = axon_lengths_group[i][4];
                let axon_volume = axon_volumes_group[i][4];
                //if (parcel != "I") {document.write(parcel+" "+parcel.length+" "+axon_parcel+" "+axon_parcel.length+" "+(parcel===axon_parcel)+"<br>");}
                //if (parcel != "I") {document.write((source_id === axon_neuron_id && source_subregion === axon_subregion && (parcel.toString()).toUpperCase() === (axon_parcel.toString()).toUpperCase() && axon_neurite === "A")+" "+axon_length+"<br>");}

                if (source_id === axon_neuron_id && source_subregion === axon_subregion && (parcel.toString()).toUpperCase() === (axon_parcel.toString()).toUpperCase() && axon_neurite === "A") {
                    axon_lengths.push(axon_length);
                    axon_volumes.push(axon_volume);
                }

                if (source_id === axon_neuron_id && source_subregion === axon_subregion && axon_neurite === "A") {
                    parcels_axon.push(axon_parcel);
                }
            }
            for (let i = 0; i < dendrite_lengths_group.length; i++) {
                let dendrite_neuron_id = dendrite_lengths_group[i][0];
                let dendrite_subregion = dendrite_lengths_group[i][1];
                let dendrite_parcel = dendrite_lengths_group[i][2];
                let dendrite_neurite = dendrite_lengths_group[i][3];
                let dendrite_length = dendrite_lengths_group[i][4];
                let dendrite_volume = dendrite_volumes_group[i][4];
                if (parcel == "SLM") {
                    //document.write(dendrite_length+"<br>");
                }

                if (target_id === dendrite_neuron_id && target_subregion === dendrite_subregion && (parcel.toString()).toUpperCase() === (dendrite_parcel.toString()).toUpperCase() && dendrite_neurite == "D") {
                    dendrite_lengths.push(dendrite_length);
                    dendrite_volumes.push(dendrite_volume);
                }

                if (target_id === dendrite_neuron_id && target_subregion === dendrite_subregion && dendrite_neurite === "D") {
                    parcels_dendrite.push(dendrite_parcel);
                }
            }

            // find number of parcels with values (n_parcels)
            let parcel_found = false;
            for (let i = 0; i < parcels_axon.length; i++) {
                for (let j = 0; j < parcels_dendrite.length; j++) {
                    if (parcels_axon[i] === parcels_dendrite[j]) {
                        parcel_found = false;
                        for (let k = 0; k < parcels_both.length; k++) {
                            if (parcels_both[k] === parcels_axon[i]) {
                                parcel_found = true;
                            }
                        }
                        if (parcel_found === false) {
                            parcels_both.push(parcels_axon[i]);
                        }
                    }
                }
            }
            n_parcels = parcels_both.length;

            dendritic_length_mean = mean(dendrite_lengths);
            axonal_length_mean = mean(axon_lengths);
            volume = parcel_volume(all_groups, source_id, target_id, source_subregion, parcel);
            dendritic_length_stdev = stdev(dendrite_lengths);            
            axonal_length_stdev = stdev(axon_lengths);

            // nps
            nps_mean = c * axonal_length_mean * dendritic_length_mean / volume;
            //if (parcel === "SLM") {document.write(c+" "+axonal_length_mean+" "+dendritic_length_mean+" "+volume);}
            //if (true) {document.write(parcel+" "+c+" "+axonal_length_mean+" "+dendritic_length_mean+" "+volume);}
            //if (parcel === "SR") {document.write(nps_mean);}
            //document.write(" test");
            nps_stdev = nps_mean * Math.sqrt(Math.pow((axonal_length_stdev / axonal_length_mean),2) + Math.pow((dendritic_length_stdev / dendritic_length_mean),2));

            // noc
            let axonal_convex_hull_mean = mean(axon_volumes);
            let axonal_convex_hull_stdev = stdev(axon_volumes);
            let dendritic_convex_hull_mean = mean(dendrite_volumes);
            let dendritic_convex_hull_stdev = stdev(dendrite_volumes);

            overlap_volume_mean = ((axonal_convex_hull_mean + dendritic_convex_hull_mean) / 4)
            overlap_volume_stdev = Math.sqrt(Math.pow(axonal_convex_hull_stdev,2) + Math.pow(dendritic_convex_hull_stdev,2));

            nc_mean = (1/n_parcels) + (c * axonal_length_mean * dendritic_length_mean) / overlap_volume_mean;
            nc_stdev = nc_mean * Math.sqrt(Math.pow((axonal_length_stdev / axonal_length_mean),2) + Math.pow((dendritic_length_stdev / dendritic_length_mean),2) + Math.pow((overlap_volume_stdev / overlap_volume_mean),2));

            // cp
            cp_mean = nps_mean / nc_mean;
            cp_stdev = cp_mean * Math.sqrt(Math.pow((nps_stdev / nps_mean),2) + Math.pow((nc_stdev / nc_mean),2));

            stat_values = Array(nc_mean, nc_stdev, cp_mean, cp_stdev);

            return stat_values;
        }
        function stdev_calcs(all_groups, parcels) {
            let stdev_values = Array(parcels.length);
            let stdev_parcel_values = Array((parcels.length-1));
            let total_nc_mean = 0;
            let total_nc_stdev = 0;
            let total_cp_mean = 0;
            let total_cp_stdev = 0;
            let nc_means = Array();
            let nc_stdev = Array();
            let cp_means = Array();
            let cp_stdev = Array();

            // values per parcel
            for (var i = 0; i < parcels.length; i++) {
                stdev_values[i] = Array(Array(),Array());
                if (i < (parcels.length - 1)) {
                    stdev_values[i] = calc_stats(all_groups, parcels[i]);
                    nc_means.push(stdev_values[i][0]);
                    nc_stdev.push(stdev_values[i][1]);
                    cp_means.push(stdev_values[i][2]);
                    cp_stdev.push(stdev_values[i][3]);
                }
            }

            var nc_stdev_tally = 0;
            var cp_mean_tally = 1;
            var cp_stdev_tally = 0;
            // total values
            for (var i = 0; i < stdev_parcel_values.length; i++) {
                total_nc_mean = sum(nc_means);
                if (!isNaN(nc_stdev[i])) {
                    nc_stdev_tally += Math.pow(nc_stdev[i],2);
                }
                // probability
                if (!isNaN(cp_means[i])) {
                    cp_mean_tally = cp_mean_tally * (1 - cp_means[i]);
                }
                if (!isNaN(cp_stdev[i])) {
                    cp_stdev_tally += Math.pow(cp_stdev[i]/cp_means[i],2);
                }
            }
            total_nc_stdev = Math.sqrt(nc_stdev_tally);
            total_cp_mean = parseFloat(1 - cp_mean_tally).toString(); // parseFloat( .toString()) is for avoiding a trailing 0
            total_cp_stdev = total_cp_mean * Math.sqrt(cp_stdev_tally);

            stdev_values[i] = Array(total_nc_mean, total_nc_stdev, total_cp_mean, total_cp_stdev);

            return stdev_values;
        }
        function parse(all_groups){
            let source = document.getElementById("source").value.trim();
            let target = document.getElementById("target").value.trim();
            let source_id = sourceIDDic[source];
            let target_id = targetIDDic[target];

            let source_id_str = source_id.toString();
            let subregion_number = source_id_str.substring(0, 1);

            /* generate tables */
            <?php include("synap_prob/n_m_params.php"); ?>
            let cname = Array();
            if (subregion_number == 1) {
                <?php
                    for ($i = 0; $i < count($dg_group_short); $i++) {
                        echo "cname.push(\"".$dg_group_short[$i]."\");";
                    }
                ?>                
            };
            if (subregion_number == 2) {
                <?php
                    for ($i = 0; $i < count($ca3_group_short); $i++) {
                        echo "cname.push(\"".$ca3_group_short[$i]."\");";
                    }
                ?> 
            }
            if (subregion_number == 3) {
                <?php
                    for ($i = 0; $i < count($ca2_group_short); $i++) {
                        echo "cname.push(\"".$ca2_group_short[$i]."\");";
                    }
                ?> 
            }
            if (subregion_number == 4) {
                <?php
                    for ($i = 0; $i < count($ca1_group_short); $i++) {
                        echo "cname.push(\"".$ca1_group_short[$i]."\");";
                    }
                ?> 
            }
            if (subregion_number == 5) {
                <?php
                    for ($i = 0; $i < count($sub_group_short); $i++) {
                        echo "cname.push(\"".$sub_group_short[$i]."\");";
                    }
                ?> 
            }
            if (subregion_number == 6) {
                <?php
                    for ($i = 0; $i < count($ec_group_short); $i++) {
                        echo "cname.push(\"".$ec_group_short[$i]."\");";
                    }
                ?> 
            }

            parcel = Array();
            let parcel_entry = "";
            for (let i = 0; i < cname.length; i++) {
                parcel_entry = cname[i].toString();
                parcel_entry = parcel_entry.replace("LI","I");
                parcel_entry = parcel_entry.replace("LII","II");
                parcel_entry = parcel_entry.replace("LIII","III");
                parcel_entry = parcel_entry.replace("LIV","IV");
                parcel_entry = parcel_entry.replace("LV","V");
                parcel_entry = parcel_entry.replace("LVI","VI");
                parcel.push(parcel_entry);
            }
            let stdev_values = stdev_calcs(all_groups, parcel);
            //document.write(stdev_values[3][0]);

            document.getElementById('title1').style.display='block';
            let cp_text = "<center>Probability of Connection Per Neuron Pair<br><br><table style='text-align:center;border: 1px solid black;width:88%;height:10px;table-layout: fixed;font-size:16px;'><tr style='background-color:grey;font-color:white;color:white;'>";
            for (let i = 0; i < cname.length; i++) {
              cp_text += "<td style='padding: 5px;font-color:white;color:white;border: 1px solid black;'>"+cname[i]+'</td>';
            } 
            cp_text += "</tr><tr style='border: 1px solid black;'>";
            for (let i = 0; i < cname.length; i++) {
              cp_text += "<td style='padding: 5px;border: 1px solid black;'>";
              let cp_final_mean = parseFloat(0.0).toPrecision(4);
              if (parseFloat(stdev_values[i][2]).toPrecision(4) > 0) {
                cp_final_mean = parseFloat(stdev_values[i][2]).toPrecision(4);
              }
              if (cp_final_mean > 0) {
                cp_text += "<a title='mean: "+cp_final_mean+"\nstdev: ";
                if (stdev_values[i][3].toPrecision(4) > 0) {
                    cp_text += stdev_values[i][3].toPrecision(4);
                }
                else {
                    cp_text += "N\/A";
                }
                cp_text += "' style='text-decoration:none;color:black;'>";
              }
              cp_text += cp_final_mean;//result[i];
              if (cp_final_mean > 0) {
                cp_text += "</a>";
              }
              cp_text += "</td>";
            }
            cp_text += '</tr></table></center>';
            document.getElementById('title1').innerHTML = cp_text;
            document.getElementById('title2').style.display='block';
            let noc_text = "<center>Number of Contacts Per Connected Neuron Pair<br><br><table style='text-align:center;border: 1px solid black;width:88%;height:10px;table-layout: fixed;font-size:16px;'><tr style='background-color:grey;font-color:white;color:white;'>";
            for (let i = 0; i < cname.length; i++) {
              noc_text += "<td style='padding: 5px;font-color:white;color:white;border: 1px solid black;'>"+cname[i]+'</td>';
            }
            noc_text += "</tr><tr style='border: 1px solid black;'>";
            for (let i = 0; i < cname.length; i++) {
              noc_text += "<td style='padding: 5px;border: 1px solid black;'>";
              let noc_final_mean = parseFloat(0.0).toPrecision(3);
              if (parseFloat(stdev_values[i][0]).toPrecision(3) > 0) {
                noc_final_mean = parseFloat(stdev_values[i][0]).toPrecision(3);
              }
              if (noc_final_mean > 0) {
                noc_text += "<a title='mean: "+noc_final_mean+"\nstdev: ";
                if (stdev_values[i][1].toPrecision(3) > 0) {
                    noc_text += stdev_values[i][1].toPrecision(3);
                }
                else {
                    noc_text += "N\/A";
                }
                noc_text += "' style='text-decoration:none;color:black;'>";
              }
              noc_text += noc_final_mean;
              if (noc_final_mean > 0) {
                noc_text += "</a>";
              }
              noc_text += "</td>";
            }
            noc_text += '</tr></table></center>';
            document.getElementById('title2').innerHTML = noc_text;
        }
        function readData(url,volume_data,volumes_index,columns_index,all_groups){
            $.ajax({
                url:url,
                dataType:"text",
                success:[function(data){
                   parse(volume_data,volumes_index,columns_index,all_groups);
                }]
            });
        }
        <?php
            function get_volumes($filename) {
                $csv_file = array_map('str_getcsv', file($filename));
                for ($i = 0; $i < count($csv_file); $i++) {
                    if (count($csv_file[$i])>0) {
                        $line = $csv_file[$i][0];
                        for ($j = 1; $j < count($csv_file[$i]); $j++) {
                            $line = $line.",".$csv_file[$i][$j];
                        }
                        echo "volume_data.push(\"".$line."\");";
                    }
                }   
            }     
        ?>
        function createTables() {
            <?php
                $axon_group = array();
                $dendrite_group = array();
                $parcel_volumes = array();
                if (isset($_REQUEST["source"])) {
                    echo "document.getElementById('source').value='".$_REQUEST["source"]."';";
                    $sql_general = "SELECT unique_id, sl.sub_layer as subregion, SUBSTRING_INDEX(SUBSTRING_INDEX(neurite,':',2),':',-1) as parcel, SUBSTRING_INDEX(neurite,':',-1) as neurite, filtered_total_length as length, convexhull as volume FROM neurite_quantified as nq, SynproSubLayers as sl WHERE nq.unique_id!='' AND nq.filtered_total_length != 0 AND nq.filtered_total_length != '' AND nq.neurite not like '%:All:%' AND nq.convexhull != 0 AND nq.convexhull != '' AND nq.unique_id = sl.neuron_id AND ((sl.sub_layer = SUBSTRING_INDEX(SUBSTRING_INDEX(neurite,':',1),':',-1)) OR (sl.sub_layer = 'MEC' AND SUBSTRING_INDEX(SUBSTRING_INDEX(neurite,':',1),':',-1) = 'EC') OR (sl.sub_layer = 'LEC' AND SUBSTRING_INDEX(SUBSTRING_INDEX(neurite,':',1),':',-1) = 'EC'))";
                    $sql    = $sql_general." AND unique_id = ".$_REQUEST["source_id"];
                    //echo "document.write(\"".$sql."\");";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $entry = array();
                            array_push($entry, $row['unique_id']);
                            array_push($entry, $row['subregion']);
                            array_push($entry, $row['parcel']);
                            array_push($entry, $row['neurite']);
                            array_push($entry, $row['length']);
                            array_push($entry, $row['volume']);
                            if ($row['neurite'] == "A") {
                                array_push($axon_group, $entry);
                            }
                        }
                    }
                    $sql    = $sql_general." AND unique_id = ".$_REQUEST["target_id"];
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $entry = array();
                            array_push($entry, $row['unique_id']);
                            array_push($entry, $row['subregion']);
                            array_push($entry, $row['parcel']);
                            array_push($entry, $row['neurite']);
                            array_push($entry, $row['length']);
                            array_push($entry, $row['volume']);
                            if ($row['neurite'] == "D") {
                                array_push($dendrite_group, $entry);
                            }
                        }
                    }
                    //echo "document.write(\"".$sql."\")";                    
                    $sql   = "SELECT * FROM SynproVolumesSelected;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $entry = array();
                            array_push($entry, $row['source_id']);
                            array_push($entry, $row['target_id']);
                            array_push($entry, $row['subregion']);
                            array_push($entry, $row['parcel']);
                            array_push($entry, $row['selected_volume']);
                            array_push($parcel_volumes, $entry);
                        }
                    }
                }
                //echo "document.write(\"entry:<br>".$axon_group[2][2]."\")";
                //echo "document.write(\"entry:<br>".sizeof($dendrite_group)."\")";
                //echo "document.write(\"entry:<br>".$sql_general."\")";
            ?>

            let dendrite_lengths_group = Array();
            let dendrite_volumes_group = Array();
            let axon_lengths_group = Array();
            let axon_volumes_group = Array();
            let parcel_volumes_group = Array();
            <?php
                echo "let entry = Array();";
                echo "let entry2 = Array();";
                echo "let lengths_entry = Array();";
                echo "let lengths_entry2 = Array();";
                echo "let volumes_entry = Array();";
                echo "let volumes_entry2 = Array();";

                foreach ($dendrite_group as $entry) {
                    echo "entry = Array();";
                    foreach ($entry as $entry_value) {
                        echo "entry.push(\"".$entry_value."\");";
                    }
                    //echo "document.write(entry[4]);";
                    //echo "document.write(\"".$dendrite_group[0][4]."<br>\");";
                    echo "lengths_entry = Array(entry[0], entry[1], entry[2], entry[3], entry[4]);";
                    echo "volumes_entry = Array(entry[0], entry[1], entry[2], entry[3], entry[5]);";
                    echo "dendrite_lengths_group.push(lengths_entry);";
                    echo "dendrite_volumes_group.push(volumes_entry);";
                }
                //echo "document.write(dendrite_lengths_group[1][4]);";
                foreach ($axon_group as $entry2) {
                    echo "entry2 = Array();";
                    foreach ($entry2 as $entry_value2) {
                        echo "entry2.push(\"".$entry_value2."\");";
                    }
                    echo "lengths_entry2 = Array(entry2[0], entry2[1], entry2[2], entry2[3], entry2[4]);";
                    echo "volumes_entry2 = Array(entry2[0], entry2[1], entry2[2], entry2[3], entry2[5]);";
                    echo "axon_lengths_group.push(lengths_entry2);";
                    echo "axon_volumes_group.push(volumes_entry2);";
                }
                foreach ($parcel_volumes as $entry3) {
                    echo "entry3 = Array();";
                    foreach ($entry3 as $entry_value3) {
                        echo "entry3.push(\"".$entry_value3."\");";
                    }
                    echo "parcel_volumes_group.push(entry3);";
                }
            ?>
            
            all_groups = Array(dendrite_lengths_group, dendrite_volumes_group, axon_lengths_group, axon_volumes_group, parcel_volumes_group);
            //document.write(document.getElementById("source").value);
            let name = document.getElementById("source").value.split(" ")[0];
            parse(all_groups);
        }
        function submitClicked(){
            let source = document.getElementById("source").value.trim();
            let target = document.getElementById("target").value.trim();
            let source_id = sourceIDDic[source];
            let target_id = targetIDDic[target];
            document.getElementById("source_id").value = source_id;
            document.getElementById("target_id").value = target_id;

            document.forms["conn_form"].submit();
        }
        function targetSelected(){
            let spine_distance = document.getElementById("spine_distance");
            let bouton_distance = document.getElementById("bouton_distance");
            let interaction = document.getElementById("interaction");
            let contacts = document.getElementById("contacts");
            let submit = document.getElementById("s");
            spine_distance.disabled = true;
            bouton_distance.disabled = true;
            interaction.disabled = true;
            contacts.disabled = true;
            submit.disabled = true;
            spine_distance.innerText = null;
            bouton_distance.innerText = null;
            interaction.innerText = null;
            contacts.innerText = null;
            spine_distance.disabled = false;
            bouton_distance.disabled = false;
            interaction.disabled = false;
            contacts.disabled = false;
            submit.disabled = false;

        }
        function sourceSelected() {
            let source = document.getElementById("source").value;
            let target = document.getElementById("target");
            target.disabled = true;
            target.length = 0;
            addOption(target, "-", "-");
            for(let value in connDic[source]){
                addOption(target,connDic[source][value],connDic[source][value]);
            }
            target.disabled = false;
        }
        addOption = function(selectbox, text, value) {
            let optn = document.createElement("OPTION");
            optn.text = text;
            optn.value = value;
            selectbox.options.add(optn);
        };
        function init() {
            let exclude_pre = ["CA3 Giant","CA3 Interneuron Specific Quad","CA3 Lucidum LAX","MEC LIII Multipolar Principal","LEC LIII Multipolar Interneuron","EC LIII Pyramidal-Looking Interneuron","DG Axo-Axonic", "DG Basket" ,"DG Basket CCK+", "CA3 Axo-Axonic", "CA3 Horizontal Axo-Axonic" ,"CA3 Basket","CA2 Basket" ,"CA3 Basket CCK+","CA2 Basket+","CA2 Wide-Arbor Basket"
                ,"CA1 Axo-Axonic","CA1 Horizontal Axo-Axonic","CA1 Basket","CA1 Basket CCK+","CA1 Horizontal Basket","SUB Axo-axonic","EC LII Axo-Axonic","MEC LII Basket","EC LII Basket-Multipolar"]
            let exclude_post = ["CA3 Giant", "CA3 Interneuron Specific Quad", "CA3 Lucidum LAX","MEC LIII Multipolar Principal","LEC LIII Multipolar Interneuron","EC LIII Pyramidal-Looking Interneuron"]
            $.ajax({
                url:"data/conndata.csv",
                dataType:"text",
                success:[function(data){
                    let rows = data.split(/\r?\n|\r/);
                    for(let count = 1; count<rows.length-1; count=count+1) {
                    let row = rows[count].split(",");
                    let sourceID = row[0];
                    let source = row[1];
                    let targetID = row[2];
                    let target = row[3];
                    if (target !== undefined && source !== undefined && !(exclude_pre.indexOf(source.trim()) > -1) && !(exclude_post.indexOf(target.trim()) > -1)) {
                        source = source.trim();
                        target = target.trim();
                        let sourceName = source.split(" ")[0];                        
                        let targetName = target.split(" ")[0];
                        if (sourceName === targetName || (sourceName==="EC"||sourceName==="LEC"||sourceName==="MEC")&&(targetName==="EC"||targetName==="LEC"||targetName==="MEC") || (sourceName==="CA3"&&targetName==="CA3c") || (sourceName==="CA3c"&&targetName==="CA3")) {
                            if (!connDic[source]) {
                                connDic[source] = [];
                            }
                            connDic[source].push(target);
                            sourceIDDic[source] = sourceID;
                            targetIDDic[target] = targetID;
                            //document.write(source+" "+target+"<br>");
                        }
                    }
                }
                let source_html = document.getElementById("source");
                source_html.disabled = true;
                source_html.length = 0;
                addOption(source_html, "-", "-");
                for (let key in connDic) {
                    addOption(source_html, key, key);
                }
                source_html.disabled = false;

                <?php
                if (isset($_REQUEST["source"])) {
                    echo "document.getElementById('source').value='".$_REQUEST["source"]."';";
                }
                ?>
                sourceSelected();

                <?php
                    if (isset($_REQUEST["target"])) {
                        echo "document.getElementById('target').value='".$_REQUEST["target"]."';";
                    }
                ?>
           }] });}

       init();
    </script>
    <?php
    if (isset($_REQUEST["source"])) {
        echo "<script>";
        /*  
            timeout is to allow time for select options to populate before 
            setting the value.
        */
        echo "setTimeout(() => {  document.getElementById('source').value='".$_REQUEST["source"]."';";
        echo "createTables(); }, 1000);";
        echo "</script>";
    }
    ?>
</body>
</html>
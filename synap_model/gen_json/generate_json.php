<html>
<!--
This software is for generating json files

Author: Nate Sutton 
Date:   2020

Note:
The "CAST(STD(CAST" and similar entries is needed in below queries because it
first needs to cast the db value from text into decimal, then take std(), then
limit significant digits using cast again.

reference: https://stackoverflow.com/questions/37618679/format-number-to-n-significant-digits-in-php
https://stackoverflow.com/questions/5149129/how-to-strip-trailing-zeros-in-php

-->
<head>
        <title>Json Generation</title>
        <link rel="icon" href="../../images/Hippocampome_logo.ico">
        <style>
        body {
        background-color: lightgrey;
        }
        .button {
                padding:20px;
                font-size:20px;
                border-radius: 30px;
                border-color: darkgrey;
                border: 2px solid darkgrey;
        }
        </style>
</head>
<body>
<?php
        include ("generate_json_params.php"); // import parameters for this software
        $cond_num = $_REQUEST['cond_num'] ?? null;
        $param_num = $_REQUEST['param_num'] ?? null;
        $param = $params[$param_num];

        echo "<br><hr><center><h2><a href='generate_json.php' style='color:black;text-decoration:none'>Json Generation Page</a></h2>Note: this page's operations require read and write access to a directory specified<br>in its source code. If that is not availible online this should be run offline to complete its operations.</center><br><hr>";

        echo "<h3><center>Choose Json files to create:</center></h3>";

        echo "<center><button onclick=\"window.location.href = '?page=syn_model_1st&cond_num=1&param_num=0';\" class='button'>Synaptome Model Values 1st Condition</button>&nbsp;&nbsp;&nbsp;<button onclick=\"window.location.href = '?page=syn_model&cond_num=1&param_num=0';\" class='button'>Synaptome Model Values All Conditions</button></center><br><hr>";
        function toPrecision($value, $digits, $main_value)
        {
                /* Convert number to a set precision. the strlen comparison is to satisfy the requested
			condition that "standard deviations cannot be more accurate than the main values". */

		               // find main value significant digits
            if ((float)$main_value == 0) {
                  $decimalPlaces = $digits - 1;
                } elseif ($main_value < 0) {
                  $decimalPlaces = $digits - floor(log10($main_value * -1)) - 1;
                } else {
                  $decimalPlaces = $digits - floor(log10($main_value)) - 1;
                }
                $main_value_adj = ($decimalPlaces > 0) ?
                  number_format($main_value, $decimalPlaces) : round($main_value, $decimalPlaces);

            // conver value to decimal places from main value
                preg_match('/\.(.*)/', ($main_value_adj ?? ''), $fraction);
                $mv_dec_places = strlen(strval($fraction[1]));
                $val_dp_adj = number_format((float)$value, $mv_dec_places, '.', '');

            return $val_dp_adj;
        }

        function find_connectivity($neuron_id1, $neuron_id2, $conn, $val) {
                $connection_status = "";
                $excit_inhib = "";
                $status_html = "";
                $sql = "SELECT connection_status FROM TypeTypeRel WHERE Type1_id = $neuron_id1 AND Type2_id = $neuron_id2;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                                $connection_status = $row['connection_status'];
                        }
                }

                $sql2 = "SELECT excit_inhib FROM Type WHERE id = $neuron_id1;";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
                                $excit_inhib = $row2['excit_inhib'];
                        }
                }
                if ($connection_status != "negative" && $val == '') {
                        /* non-potential */
                        $status_html = "<div style='width:100%;height:100%;'><font style='font-size:5px'><br></font><br>";
                }
                else if ($connection_status == "negative") {
                        /* negated */
                        $status_html = "<div style='width:100%;height:100%;'><img src='synap_model/media/negation.png' width='100%' height='100%' border='0' />";
                }
                else if ($excit_inhib == "e") {
                        /* excitatory */
			$status_html = "<div style='width:100%;height:100%;' class='custom_colors'><font style='font-size:5px'><br></font><br>";
		}
                else if ($excit_inhib == "i") {
                        /* inhibitory */
                        $status_html = "<div style='width:100%;height:100%;background-color:#AAAAAA;'><font style='font-size:5px'><br></font><br>";
                }

                return $status_html;
        }

        function retreive_values($conn_synaptome, $conn, $type, $neuron_group, $neuron_group_long, $i, $write_output, $neuron_ids, $cond_num, $param) {
                for ($j=0;$j<count($neuron_ids ?? array());$j++) {
                //for ($j=0;$j<3;$j++) {
                        $entry_output = "";
                        if ($type == 'syn_model') {
                                $val = '';
                                $std = '';
                                $min = '';
                                $max = '';
                                $cv = '';
                                $sql = "SELECT CAST(means_".$param." AS DECIMAL(10,5)) as avg, CAST(std_".$param." AS DECIMAL(10,5)) as std, CAST(min_".$param." AS DECIMAL(10,5)) as min, CAST(max_".$param." AS DECIMAL(10,5)) as max, CAST(cv_".$param." AS DECIMAL(10,5)) as cv FROM tm_cond".$cond_num." WHERE pre='".$neuron_group_long[$i]."' AND post='".$neuron_group_long[$j]."';";
                                //$entry_output = $entry_output.$sql;
                                $result = $conn_synaptome->query($sql);
                                if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                                $val = $row['avg'];
                                                $std = $row['std'];
                                                $min = $row['min'];
                                                $max = $row['max'];
                                                $cv = $row['cv'];
                                        }
                                }
                                if ($val != '' && (float)$val != 0) {
                                        $entry_output = $entry_output.find_connectivity($neuron_ids[$i], $neuron_ids[$j], $conn, $val)."<center><a href='synaptic_mod_sum.php?pre_id=".$neuron_ids[$i]."&post_id=".$neuron_ids[$j]."' title='".toPrecision($val,4,$val)." ± ".toPrecision($std,4,$val)." (n=100)\\n[".toPrecision($min,4,$val)." to ".toPrecision($max,4,$val)."]\\nCV=".toPrecision($cv,4,$val)."' target='_blank'>".toPrecision($val,4,$val)."</a></center></div>";
                                }
                                else {
                                        $entry_output = $entry_output.find_connectivity($neuron_ids[$i], $neuron_ids[$j], $conn, $val)."<center></center></div>";
                                }
                        }
                        array_push($write_output, $entry_output);
                }

                return $write_output;
        }

        /*
        Generate matrices section

$i is row that is a neuron type 
        $j is column that is a parcel type
        */
        if ($param_num < sizeof($params)) {
                for ($i = 0; $i < count($neuron_ids ?? array()); $i++) {
                        if ($page=='syn_model' || $page=='syn_model_1st') {
                                $write_output = retreive_values($conn_synaptome, $conn, 'syn_model', $neuron_group_hnc, $neuron_group_long, $i, $write_output, $neuron_ids, $cond_num, $param);
                        }
                }

                /* 
                Write to File 
                
                $new_row_col is used because a new row occurs every certain
                number of columns when reading the file.
                */
                if ($page=='syn_model' || $page=='syn_model_1st') {
                        $json_output_file = $path_to_files."json_files/cond".$cond_num."_".$param.".json";
                        $output_file = fopen($json_output_file, 'w') or die("Can't open file.");
                        /* specify rows to use from template file */
                        $init_col = 0;
                        $init_col2 = 1;
                        $new_row_col = 124;
                        $max_rows = 100000;
                        /* specify indices */
                        $neuron_group_cols = array(); // new file indexes
                        $neuron_class_cols = array();
                        $total_rows = ($new_row_col*$new_row_col)+(2*$new_row_col);
                        $t_out = 0;
                        $n_out = 0;
                        $p_out = 0;
                        $nl = $json_new_line; // new line
                        /* create arrays of selected template indexes */
                        for ($r_i = 0; $r_i < $max_rows; $r_i++) {
                                array_push($neuron_group_cols, ($init_col+($new_row_col*$r_i)));
                                array_push($neuron_class_cols, ($init_col2+($new_row_col*$r_i)));
                        }

                        for ($o_i = 0; $o_i<$total_rows; $o_i++) {
                                if ($o_i==($total_rows-1)) {
                                        $last_index = count($write_output ?? array())-1; // last line
                                        fwrite($output_file, "\"".$write_output[$last_index]."\"]}]}");
                                }
                                elseif (in_array($o_i, ($neuron_group_cols ?? array()))) {
                                        fwrite($output_file, $neuron_groups_ordered[$t_out]);
                                        $t_out++;
                                }
                                elseif (in_array($o_i, ($neuron_class_cols ?? array()))) {
                                        fwrite($output_file, $neuron_classes_ordered[$n_out]);
  					$n_out++;
                                }
                                else {
                                        if ($write_output[$p_out] != "") {
                                                $text_output = "\"".$write_output[$p_out]."\",".$nl;
                                        }
                                        else {
                                                $text_output = "\"\",".$nl;
                                        }
                                        fwrite($output_file, $text_output);
                                        $p_out++;
                                }
                        }
                        fclose($output_file);
                }

                if ($page!='') {
                        echo "<br><center>Status: json files condition #".$cond_num." param ".$param." successfully written.<br>";
                        echo "<br><hr><br><br>";
                }
        }
        else if ($cond_num <= $num_conds) {
                        echo "<br><center>Status: moving to processing condition #".($cond_num + 1)."<br>";
                        echo "<br><hr><br><br>";
        }
        else if ($cond_num > $num_conds) {
                        echo "<br><center>Status: finished processing<br>";
                        echo "<br><hr><br><br>";
        }

        if (($page=='syn_model' || $page=='syn_model_1st') && !($cond_num >= $num_conds && $param_num > sizeof($params))) {
                if ($param_num <= sizeof($params)) {
                        $param_num++;
                }
                else {
                        $cond_num++;
                        $param_num = 0;
                }
                if ($page=='syn_model') {
                        echo "<script>
                        window.location.replace('generate_json.php?page=syn_model&cond_num=".$cond_num."&param_num=".$param_num."');
                        </script>";
                }
                else if ($cond_num < 2) {
			echo "<script>
                        window.location.replace('generate_json.php?page=syn_model_1st&cond_num=".$cond_num."&param_num=".$param_num."');
                        </script>";
                }
        }
?>
</body>

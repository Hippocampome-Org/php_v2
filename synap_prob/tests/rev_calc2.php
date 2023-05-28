<?php
  include ("/var/www/html/php/permission_check.php");
?>
<html>
<h2><center>Example Calculation</center></h2>
<br>
<textarea rows="30" cols="170" id="examplecalc" name="examplecalc"></textarea>
<script>
<?php
$source_id = 1002;
$target_id = 1002;
echo "let source_id = $source_id;";
echo "let target_id = $target_id;";
?>
let length_spine = 1.09;
let length_bouton = 6.2;
let radius_spine = 2;
let c = ((4.0/3)*Math.PI*Math.pow(radius_spine,3))/(length_spine*length_bouton);
let calcs = "";
let parcels = Array("SMo","SMi","SG","H");
let n_parcels = 1;//parcels.length;
let SMI_PAR = 1;
let H_PAR = 3;

let axonal_lengths = Array();
let axonal_length_mean = Array();
let axonal_length_stdev = Array();
let axonal_volumes = Array();
let axonal_volume_mean = Array();
let axonal_volume_stdev = Array();
let dendritic_lengths = Array();
let dendritic_length_mean = Array();
let dendritic_length_stdev = Array();
let dendritic_volumes = Array();
let dendritic_volume_mean = Array();
let dendritic_volume_stdev = Array();
let overlap_volume_mean = Array();
let overlap_volume_stdev = Array();
let nps_mean = Array();
let nps_stdev = Array();
let nc_mean = Array();
let nc_stdev = Array();
let cp_mean = Array();
let cp_stdev = Array();
for (let i = 0; i < parcels.length; i++) {
	axonal_lengths.push(0);
	axonal_length_mean.push(0);
	axonal_length_stdev.push(0);
	axonal_volumes.push(0);
	axonal_volume_mean.push(0);
    axonal_volume_stdev.push(0);
	dendritic_lengths.push(0);
	dendritic_length_mean.push(0);
	dendritic_length_stdev.push(0);
	dendritic_volumes.push(0);
	dendritic_volume_mean.push(0);
    dendritic_volume_stdev.push(0);
	overlap_volume_mean.push(0);
	overlap_volume_stdev.push(0);
	nps_mean.push(0);
	nps_stdev.push(0);
	nc_mean.push(0);
	nc_stdev.push(0);
	cp_mean.push(0);
	cp_stdev.push(0);
}

// dg mossy (1002) and dg mossy molden (1043)
//parcel_volumes= Array(9518233055,4759116527,3174600000,3515908637);
parcel_volumes = Array();
parcel_volumes.push(0);
parcel_volumes.push(0);
parcel_volumes.push(0);
<?php
$sql = "SELECT selected_volume FROM SynproVolumesSelected WHERE source_id=".$source_id." AND target_id=".$target_id." AND parcel = 'H';";
//echo "document.write(\"$sql\");";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "parcel_volumes.push(".$row['selected_volume'].");";
    }
}
?>

axon_values = Array();
<?php
$sql = "SELECT * FROM SynproLengthsHullVols WHERE unique_id=$source_id AND full_loc='DG:H:A';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "axon_values.push(Array(".$row['unique_id'].",\"".$row['subregion']."\",\"".$row['parcel']."\",\"".$row['neurite']."\",".$row['length_mean'].",".$row['length_std'].",".$row['convex_hull_mean'].",".$row['convex_hull_std']."));\n";
    }
}
?>

dendrite_values = Array();
<?php
$sql = "SELECT * FROM SynproLengthsHullVols WHERE unique_id=$target_id AND full_loc='DG:H:D';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "dendrite_values.push(Array(".$row['unique_id'].",\"".$row['subregion']."\",\"".$row['parcel']."\",\"".$row['neurite']."\",".$row['length_mean'].",".$row['length_std'].",".$row['convex_hull_mean'].",".$row['convex_hull_std']."));\n";
    }
}
?>

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
}
function mean(array) {
    //document.getElementById("examplecalc").value+=array[0]+"\n";
    let arraySum = sum(array);
    
    return arraySum / array.length;
}


//neurites
let curr_parcel = "";
for (let i = 0; i < parcels.length; i++) {
    if (parcels[i] == "H") {
        for (let j = 0; j < axon_values.length; j++) {
            curr_parcel = axon_values[j][2];
            //calcs += parcels[i];
            //calcs += axon_values[j][2];
            if (curr_parcel == "H") {
                //calcs += "i";
                //calcs += "\n";
                axonal_length_mean[i] = axon_values[j][4];
                axonal_length_stdev[i] = axon_values[j][5];
                axonal_volume_mean[i] = axon_values[j][6];
                axonal_volume_stdev[i] = axon_values[j][7];
                dendritic_length_mean[i] = dendrite_values[j][4];
                dendritic_length_stdev[i] = dendrite_values[j][5];
                dendritic_volume_mean[i] = dendrite_values[j][6];
                dendritic_volume_stdev[i] = dendrite_values[j][7];
            }
        }
    }
}

//overlap_volume
//overlap_volume_mean[1] = (axonal_volume_mean[1] + dendritic_volume_mean[1]) / 4;
overlap_volume_mean[3] = (axonal_volume_mean[3] + dendritic_volume_mean[3]) / 4;
//overlap_volume_stdev[1] = Math.sqrt(Math.pow(stdev(axonal_volumes[1]),2)+Math.pow(stdev(dendritic_volumes[1]),2));
overlap_volume_stdev[3] = Math.sqrt(Math.pow(axonal_volume_stdev[3],2)+Math.pow(dendritic_volume_stdev[3],2));

//nps_mean[1] = (c * axonal_length_mean[1] * dendritic_length_mean[1]) / parcel_volumes[1];
nps_mean[3] = (c * axonal_length_mean[3] * dendritic_length_mean[3]) / parcel_volumes[3];
//nps_stdev[1] = nps_mean[1] * Math.sqrt(Math.pow((axonal_length_stdev[1] / axonal_length_mean[1]),2)+Math.pow((dendritic_length_stdev[1] / dendritic_length_mean[1]),2));
nps_stdev[3] = nps_mean[3] * Math.sqrt(Math.pow((axonal_length_stdev[3] / axonal_length_mean[3]),2)+Math.pow((dendritic_length_stdev[3] / dendritic_length_mean[3]),2));

//nc_mean[1] = (1/n_parcels) + ((c * axonal_length_mean[1] * dendritic_length_mean[1]) / overlap_volume_mean[1]);
nc_mean[3] = (1/n_parcels) + ((c * axonal_length_mean[3] * dendritic_length_mean[3]) / overlap_volume_mean[3]);
//nc_stdev[1] = nc_mean[1] * Math.sqrt(Math.pow((axonal_length_stdev[1]/axonal_length_mean[1]),2)+Math.pow((dendritic_length_stdev[1]/dendritic_length_mean[1]),2)+Math.pow((overlap_volume_stdev[1]/overlap_volume_mean[1]),2));
nc_stdev[3] = nc_mean[3] * Math.sqrt(Math.pow((axonal_length_stdev[3]/axonal_length_mean[3]),2)+Math.pow((dendritic_length_stdev[3]/dendritic_length_mean[3]),2)+Math.pow((overlap_volume_stdev[3]/overlap_volume_mean[3]),2));

//cp_mean[1] = nps_mean[1] / nc_mean[1];
cp_mean[3] = nps_mean[3] / nc_mean[3];
//cp_stdev[1] = cp_mean[1] * Math.sqrt(Math.pow((nps_stdev[1]/nps_mean[1]),2)+Math.pow((nc_stdev[1]/nc_mean[1]),2));
cp_stdev[3] = cp_mean[3] * Math.sqrt(Math.pow((nps_stdev[3]/nps_mean[3]),2)+Math.pow((nc_stdev[3]/nc_mean[3]),2));

nc_mean_total = nc_mean[3];
nc_stdev_total = Math.sqrt(Math.pow(nc_stdev[3],2));
cp_mean_total = 1 - ((1 - cp_mean[3]));
cp_stdev_total = cp_mean_total * Math.sqrt(Math.pow(cp_stdev[3]/cp_mean[3],2));

calcs += "dg (1041) and dg (1027)\n";
calcs += "(1/n_parcels): "+(1/n_parcels)+"\n";
calcs += "parcel_volumes[H_PAR]: "+parcel_volumes[H_PAR]+"\n";
//calcs += "parcel_volumes[SMI_PAR]: "+parcel_volumes[SMI_PAR]+"\n";
calcs += "axonal_length_mean[H_PAR]: "+axonal_length_mean[H_PAR]+"\n";
//calcs += "axonal_length_mean[SMI_PAR]: "+axonal_length_mean[SMI_PAR]+"\n";
calcs += "dendritic_length_mean[H_PAR]: "+dendritic_length_mean[H_PAR]+"\n";
//calcs += "dendritic_length_mean[SMI_PAR]: "+dendritic_length_mean[SMI_PAR]+"\n";
calcs += "axonal_volume_mean[H_PAR]: "+axonal_volume_mean[H_PAR]+"\n";
calcs += "dendritic_volume_mean[H_PAR]: "+dendritic_volume_mean[H_PAR]+"\n";
calcs += "nps_mean = (c * axonal_length_mean[3] * dendritic_length_mean[3]) / parcel_volumes[3]; \nnps_mean = ("+c+" * "+axonal_length_mean[3]+" * "+dendritic_length_mean[3]+") / "+parcel_volumes[3]+"\n";
calcs += "nc_mean = (1/n_parcels) + ((c * axonal_length_mean[3] * dendritic_length_mean[3]) / overlap_volume_mean[3]);\n";
calcs += "nc_mean = "+(1/n_parcels)+" + "+"(("+c+" * "+axonal_length_mean[3]+" * "+dendritic_length_mean[3]+") / "+overlap_volume_mean[3]+");\n";
calcs += "nc_stdev[3] = nc_mean[3] * Math.sqrt(Math.pow((axonal_length_stdev[3]/axonal_length_mean[3]),2)+\nMath.pow((dendritic_length_stdev[3]/dendritic_length_mean[3]),2)+Math.pow((overlap_volume_stdev[3]/overlap_volume_mean[3]),2));\n";
calcs += "nc_stdev[3] = "+nc_mean[3]+" * Math.sqrt(Math.pow(("+axonal_length_stdev[3]+"/"+axonal_length_mean[3]+"),2)+Math.pow(("+dendritic_length_stdev[3]+"/\n"+dendritic_length_mean[3]+"),2)+Math.pow(("+overlap_volume_stdev[3]+"/"+overlap_volume_mean[3]+"),2));\n";
calcs += " \n";
calcs += "  end results \n";
calcs += "                        H                 Total \n";
calcs += "nps mean:  "+nps_mean[3]+"\n";
calcs += "nps stdev: "+nps_stdev[3]+"\n";
calcs += "nc mean:   "+nc_mean[3]+"      "+nc_mean_total+"\n";
calcs += "nc stdev:  "+nc_stdev[3]+"      "+nc_stdev_total+"\n";
calcs += "cp mean:   "+cp_mean[3]+"    "+cp_mean_total+"\n";
calcs += "cp stdev:  "+cp_stdev[3]+"    "+cp_stdev_total+"\n";


document.getElementById("examplecalc").value+=calcs;
//document.getElementById("examplecalc").value="test";

</script>
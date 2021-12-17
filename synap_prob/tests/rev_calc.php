<html>
<h2><center>Example Calculation</center></h2>
<br>
<textarea rows="30" cols="170" id="examplecalc" name="examplecalc"></textarea>
<script>
let length_spine = 1.09;
let length_bouton = 6.2;
let radius_spine = 2;
let c = ((4.0/3)*Math.PI*Math.pow(radius_spine,3))/(length_spine*length_bouton);
let calcs = "";
let parcels = Array("SMo","SMi","SG","H");
let n_parcels = 2;//parcels.length;
let SMI_PAR = 1;
let H_PAR = 3;

let axonal_lengths = Array();
let axonal_length_mean = Array();
let axonal_length_stdev = Array();
let axonal_volumes = Array();
let axonal_volume_mean = Array();
let dendritic_lengths = Array();
let dendritic_length_mean = Array();
let dendritic_length_stdev = Array();
let dendritic_volumes = Array();
let dendritic_volume_mean = Array();
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
	dendritic_lengths.push(0);
	dendritic_length_mean.push(0);
	dendritic_length_stdev.push(0);
	dendritic_volumes.push(0);
	dendritic_volume_mean.push(0);
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
parcel_volumes= Array(9518233055,4759116527,3174600000,3515908637);

axon_values = Array(
/*                            length      volume     */
Array(1002, "DG", "SMi", "A", 1199.50, 326077428.78),
Array(1002, "DG", "H", "D", 4823.40, 74021575.74),
Array(1002, "DG", "H", "A", 6240.72, 204470899.31),
Array(1002, "DG", "SMi", "A", 3413.32, 285694229.63),
Array(1002, "DG", "H", "D", 5172.63, 91540191.59),
Array(1002, "DG", "H", "A", 5035.87, 137870315.29),
Array(1002, "DG", "SMi", "A", 1699.63, 250019805.34),
Array(1002, "DG", "H", "D", 4382.53, 71895544.19),
Array(1002, "DG", "H", "A", 4830.42, 192739927.57)
);

dendrite_values = Array(
Array(1043, "DG", "SMo", "D", 717.99, 36464991.82),
Array(1043, "DG", "SMi", "D", 746.49, 15319926.10),
Array(1043, "DG", "SMi", "A", 593.07, 512396.69),
Array(1043, "DG", "SG", "D", 675.05, 10146743.40),
Array(1043, "DG", "H", "D", 5259.47, 76538044.98),
Array(1043, "DG", "H", "A", 4191.86, 155975206.61)
);

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

axonal_lengths[1] = Array(axon_values[0][4], axon_values[3][4], axon_values[6][4]);
axonal_lengths[3] = Array(axon_values[2][4], axon_values[5][4], axon_values[8][4]);
axonal_length_mean[1] = mean(axonal_lengths[1]);
axonal_length_mean[3] = mean(axonal_lengths[3]);
axonal_length_stdev[1] = stdev(axonal_lengths[1]);
axonal_length_stdev[3] = stdev(axonal_lengths[3]);
axonal_volumes[1] = Array(axon_values[0][5], axon_values[3][5], axon_values[6][5]);
axonal_volumes[3] = Array(axon_values[2][5], axon_values[5][5], axon_values[8][5]);
axonal_volume_mean[1] = mean(axonal_volumes[1]);
axonal_volume_mean[3] = mean(axonal_volumes[3]);

dendritic_lengths[0] = dendrite_values[0][4];
dendritic_lengths[1] = dendrite_values[1][4];
dendritic_lengths[3] = dendrite_values[4][4];
dendritic_lengths[4] = dendrite_values[5][4];
let test2 = Array();
test2.push(dendritic_lengths[0]);
dendritic_length_mean[0] = mean(test2);
dendritic_length_mean[1] = dendritic_lengths[1];
dendritic_length_mean[3] = dendritic_lengths[3];
dendritic_length_mean[4] = dendritic_lengths[4];
dendritic_length_stdev[0] = 0;
dendritic_length_stdev[1] = 0;
dendritic_length_stdev[3] = 0;
dendritic_length_stdev[4] = 0;
dendritic_volumes[0] = dendrite_values[0][5];
dendritic_volumes[1] = dendrite_values[1][5];
dendritic_volumes[3] = dendrite_values[4][5];
dendritic_volumes[4] = dendrite_values[5][5];
dendritic_volume_mean[0] = dendritic_volumes[0];
dendritic_volume_mean[1] = dendritic_volumes[1];
dendritic_volume_mean[3] = dendritic_volumes[3];
dendritic_volume_mean[4] = dendritic_volumes[4];

overlap_volume_mean[1] = (axonal_volume_mean[1] + dendritic_volume_mean[1]) / 4;
overlap_volume_mean[3] = (axonal_volume_mean[3] + dendritic_volume_mean[3]) / 4;
overlap_volume_stdev[1] = Math.sqrt(Math.pow(stdev(axonal_volumes[1]),2)+Math.pow(stdev(dendritic_volumes[1]),2));
overlap_volume_stdev[3] = Math.sqrt(Math.pow(stdev(axonal_volumes[3]),2)+Math.pow(stdev(dendritic_volumes[3]),2));

nps_mean[1] = (c * axonal_length_mean[1] * dendritic_length_mean[1]) / parcel_volumes[1];
nps_mean[3] = (c * axonal_length_mean[3] * dendritic_length_mean[3]) / parcel_volumes[3];
nps_stdev[1] = nps_mean[1] * Math.sqrt(Math.pow((axonal_length_stdev[1] / axonal_length_mean[1]),2)+Math.pow((dendritic_length_stdev[1] / dendritic_length_mean[1]),2));
nps_stdev[3] = nps_mean[3] * Math.sqrt(Math.pow((axonal_length_stdev[3] / axonal_length_mean[3]),2)+Math.pow((dendritic_length_stdev[3] / dendritic_length_mean[3]),2));

nc_mean[1] = (1/n_parcels) + ((c * axonal_length_mean[1] * dendritic_length_mean[1]) / overlap_volume_mean[1]);
nc_mean[3] = (1/n_parcels) + ((c * axonal_length_mean[3] * dendritic_length_mean[3]) / overlap_volume_mean[3]);
nc_stdev[1] = nc_mean[1] * Math.sqrt(Math.pow((axonal_length_stdev[1]/axonal_length_mean[1]),2)+Math.pow((dendritic_length_stdev[1]/dendritic_length_mean[1]),2)+Math.pow((overlap_volume_stdev[1]/overlap_volume_mean[1]),2));
nc_stdev[3] = nc_mean[3] * Math.sqrt(Math.pow((axonal_length_stdev[3]/axonal_length_mean[3]),2)+Math.pow((dendritic_length_stdev[3]/dendritic_length_mean[3]),2)+Math.pow((overlap_volume_stdev[3]/overlap_volume_mean[3]),2));

cp_mean[1] = nps_mean[1] / nc_mean[1];
cp_mean[3] = nps_mean[3] / nc_mean[3];
cp_stdev[1] = cp_mean[1] * Math.sqrt(Math.pow((nps_stdev[1]/nps_mean[1]),2)+Math.pow((nc_stdev[1]/nc_mean[1]),2));
cp_stdev[3] = cp_mean[3] * Math.sqrt(Math.pow((nps_stdev[3]/nps_mean[3]),2)+Math.pow((nc_stdev[3]/nc_mean[3]),2));

nc_mean_total = nc_mean[1] + nc_mean[3];
nc_stdev_total = Math.sqrt(Math.pow(nc_stdev[1],2) + Math.pow(nc_stdev[3],2));
cp_mean_total = 1 - ((1 - cp_mean[1]) * (1 - cp_mean[3]));
cp_stdev_total = cp_mean_total * Math.sqrt(Math.pow(cp_stdev[1]/cp_mean[1],2) + Math.pow(cp_stdev[3]/cp_mean[3],2));

calcs += "dg mossy (1002) and dg mossy molden (1043)\n";
calcs += "(1/n_parcels): "+(1/n_parcels)+"\n";
calcs += "parcel_volumes[H_PAR]: "+parcel_volumes[H_PAR]+"\n";
calcs += "parcel_volumes[SMI_PAR]: "+parcel_volumes[SMI_PAR]+"\n";
calcs += "axonal_length_mean[H_PAR]: "+axonal_length_mean[H_PAR]+"\n";
calcs += "axonal_length_mean[SMI_PAR]: "+axonal_length_mean[SMI_PAR]+"\n";
calcs += "dendritic_length_mean[H_PAR]: "+dendritic_length_mean[H_PAR]+"\n";
calcs += "dendritic_length_mean[SMI_PAR]: "+dendritic_length_mean[SMI_PAR]+"\n";
calcs += "(c * axonal_length_mean[3] * dendritic_length_mean[3]) / parcel_volumes[3]; ("+c+" * "+axonal_length_mean[3]+" * "+dendritic_length_mean[3]+") / "+parcel_volumes[3]+"\n";
calcs += " \n";
calcs += "  end results \n";
calcs += "                      SMi                   H                 Total \n";
calcs += "nps mean:  "+nps_mean[1]+" "+nps_mean[3]+"\n";
calcs += "nps stdev: "+nps_stdev[1]+" "+nps_stdev[3]+"\n";
calcs += "nc mean:   "+nc_mean[1]+"    "+nc_mean[3]+"      "+nc_mean_total+"\n";
calcs += "nc stdev:  "+nc_stdev[1]+"   "+nc_stdev[3]+"      "+nc_stdev_total+"\n";
calcs += "cp mean:   "+cp_mean[1]+"  "+cp_mean[3]+"    "+cp_mean_total+"\n";
calcs += "cp stdev:  "+cp_stdev[1]+"  "+cp_stdev[3]+"    "+cp_stdev_total+"\n";

/*
test = Array(3.4,4.221,9.0229,9.7,1.1,5,2);
calcs += stdev(test);
*/

//calcs += dendritic_volume_mean;
document.getElementById("examplecalc").value+=calcs;
</script>
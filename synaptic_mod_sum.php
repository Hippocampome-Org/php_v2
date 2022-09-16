<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html" />
<link rel="stylesheet" type="text/css" media="screen" href="synap_prob/css/main_nbyn.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Summary of Synaptic Modeling Values</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
body {
	font-family: arial;
	font-size: 17px;
}
table {
  border-collapse: collapse;
  font-size: 16px;
}
td, th {
  border: 2px solid #999;
  padding: 0.2rem;
  text-align: left;
  min-width: 90px;
  height: 15px;
  text-align: center;
}
</style>
</head>

<!-- main html section -->
<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title_v1.php");
	include ("function/menu_main.php");
?>		
<?php
    $database = "synaptome";
    $num_conditions=32;
    // Create connection
	if(is_null($conn2)){
		$conn2 = mysqli_connect($servername, $username, $password, $database);   
	}
	if(!$conn2)
	{
	  die("Connection failed: " . mysqli_connect_error());
	}

	function toPrecision($value, $digits)
	{
	    if ($value == 0) {
	        $decimalPlaces = $digits - 1;
	    } elseif ($value < 0) {
	        $decimalPlaces = $digits - floor(log10($value * -1)) - 1;
	    } else {
	        $decimalPlaces = $digits - floor(log10($value)) - 1;
	    }

	    $answer = ($decimalPlaces > 0) ?
	        number_format($value, $decimalPlaces) : round($value, $decimalPlaces);
	    return $answer; // (float) is to remove trailing 0
	}

	# get neuron names
	$pre_id = 0;
	$post_id = 0;
	if (isset($_REQUEST['pre_id'])) {
		$pre_id = $_REQUEST['pre_id'];
	}
	if (isset($_REQUEST['post_id'])) {
		$post_id = $_REQUEST['post_id'];
	}	
	$query = "SELECT type_name FROM synprotypetyperel WHERE type_id=$pre_id;";
	$rs = mysqli_query($conn2,$query);
	while(list($type_name) = mysqli_fetch_row($rs))
	{$pre_name = $type_name;}

	$query = "SELECT type_name FROM synprotypetyperel WHERE type_id=$post_id;";
	$rs = mysqli_query($conn2,$query);
	while(list($type_name) = mysqli_fetch_row($rs))
	{$post_name = $type_name;}
?>

<center>
  <span style='position:relative;top:100px'><font class="font1">Summary of Synaptic Modeling Values</font><br><font style='font-size: 5px'><br></font>
  <font>Presynaptic neuron: <?php echo "<a href='neuron_page.php?id=$pre_id' target='_blank'>$pre_name</a>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;Postsynaptic neuron: <?php echo "<a href='neuron_page.php?id=$post_id' target='_blank'>$post_name</a>"; ?></font></span>
<span style='position:relative;top:125px'>
<div>
	<table border="0" cellspacing="3" cellpadding="0" class='table_result'>
		<tr>
			<td align='center' class='table_neuron_page1'>Species</td>
			<td align='center' class='table_neuron_page1'>Sex</td>
			<td align='center' class='table_neuron_page1'>Age</td>
			<td align='center' class='table_neuron_page1'>Temperature</td>
			<td align='center' class='table_neuron_page1'>Recording<br>Mode (mV)</td>
			<td align='center' class='table_neuron_page1'>g (nS)</td>
			<td align='center' class='table_neuron_page1'>
				<font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>d</sub> (ms)
			</td>
			<td align='center' class='table_neuron_page1'>
				<font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>r</sub> (ms)
			</td>
			<td align='center' class='table_neuron_page1'>
				<font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>f</sub> (ms)
			</td>
			<td align='center' class='table_neuron_page1'>U</td>
		</tr>
		<?php
		for ($i = 1; $i <= $num_conditions; $i++) {
			$query = "SELECT species, sex, age, temp, rec_mode FROM conditions WHERE id=$i;";
			$rs = mysqli_query($conn2,$query);
			while(list($species, $sex, $age, $temp, $rec_mode) = mysqli_fetch_row($rs))
			{	
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".$species."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".$sex."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".$age."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".$temp."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".$rec_mode."</font></td>";
			}

			$query = "SELECT means_g, means_tau_d, means_tau_r, means_tau_f, means_u FROM tm_cond$i WHERE pre='$pre_name' AND post='$post_name';";

			$rs = mysqli_query($conn2,$query);
			while(list($means_g, $means_tau_d, $means_tau_r, $means_tau_f, $means_u) = mysqli_fetch_row($rs))
			{	
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".toPrecision($means_g,4)."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".toPrecision($means_tau_d,4)."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".toPrecision($means_tau_r,4)."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".toPrecision($means_tau_f,4)."</font></td>";
				echo "<td align='center' class='table_neuron_page2'><font size='2pt'>".toPrecision($means_u,4)."</font></td>";
			}
			echo "</tr>";
		}
		?>
	</table>
</div>

<!-- <center>
  <span style='position:relative;top:100px'><font class="font1">Summary of Synaptic Modeling Values</font><br><font style='font-size: 5px'><br></font>
  <font>Presynaptic neuron: <?php echo "<a href='neuron_page.php?id=$pre_id' target='_blank'>$pre_name</a>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;Postsynaptic neuron: <?php echo "<a href='neuron_page.php?id=$post_id' target='_blank'>$post_name</a>"; ?></font></span>
<span style='position:relative;top:125px'>
<table>
	<tr>
		<td>Species</td>
		<td>Sex</td>
		<td>Age</td>
		<td>Temperature</td>
		<td>Recording<br>Mode<br>(-60 mV)</td>
		<td>g (nS)</td>
		<td><font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>d</sub> (ms)</td>
		<td><font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>r</sub> (ms)</td>
		<td><font style='font-family: Times,"Times New Roman",monospace;'>&tau;</font><sub>f</sub> (ms)</td>
		<td>U</td>
	</tr>
	<?php
	for ($i = 1; $i <= $num_conditions; $i++) {
		$query = "SELECT species, sex, age, temp, rec_mode FROM conditions WHERE id=$i;";
		$rs = mysqli_query($conn2,$query);
		while(list($species, $sex, $age, $temp, $rec_mode) = mysqli_fetch_row($rs))
		{	
			echo "<td>".$species."</td>";
			echo "<td>".$sex."</td>";
			echo "<td>".$age."</td>";
			echo "<td>".$temp."</td>";
			echo "<td>".$rec_mode."</td>";
		}

		$query = "SELECT means_g, means_tau_d, means_tau_r, means_tau_f, means_u FROM tm_cond$i WHERE pre='$pre_name' AND post='$post_name';";

		$rs = mysqli_query($conn2,$query);
		while(list($means_g, $means_tau_d, $means_tau_r, $means_tau_f, $means_u) = mysqli_fetch_row($rs))
		{	
			echo "<td>".toPrecision($means_g,4)."</td>";
			echo "<td>".toPrecision($means_tau_d,4)."</td>";
			echo "<td>".toPrecision($means_tau_r,4)."</td>";
			echo "<td>".toPrecision($means_tau_f,4)."</td>";
			echo "<td>".toPrecision($means_u,4)."</td>";
		}
		echo "</tr>";
	}
	?>
</table> -->
<br>
<br>
</center>
<br>
<br>
</span>
<br>
<br>
<br>
<br>
</body>
</html>
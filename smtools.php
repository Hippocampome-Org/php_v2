<?php
  include ("permission_check.php");
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Synapse Modeling Tools</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
table {
  border-collapse: collapse;
  border: 1px solid black;
}
th, td {
  padding: 5px;
  border: 1px solid black;
}
</style>
</head>
<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
<br>
<div class='title_area' style="position:absolute; top:80px; left:30%;width:500px;">
	<br>
	<center><font class="font1"><u>Synapse Modeling Tools</u></font></center>
</div>
<div style="position:absolute; top:145px; left:19%;width:775px;">	
	<table>
		<tr>
			<td>Tools, model, or data</td>
			<td>Direct download</td>
			<td>External links</td>
		</tr>
		<tr>
			<td>The convergence of a four-state and a three-state formalism of a synaptic plasticity model in the NEURON Simulation Environment.</td>
			<td>[<a href="/general/synapse_modeling/NEURON_Model.zip">Hippocampome.org</a>]</td>
			<td>[<a href="https://senselab.med.yale.edu/modeldb/ShowModel?model=266934">ModelDB</a>]</td>
		</tr>
		<tr>
			<td>Synapse Modeling Utility/Trace Reconstructor plus digitized traces and parametric fitting results.</td>
			<td>[<a href="/general/synapse_modeling/Modeling.rar">Hippocampome.org</a>]</td>
			<td>[<a href="https://github.com/k1moradi/SynapseModelingUtility">GitHub</a>]</td>
		</tr>
		<tr>
			<td>Machine Learning Library and preprocessed data.</td>
			<td>[<a href="/general/synapse_modeling/MachineLearningSynapsePhysiology.zip">Hippocampome.org</a>]</td>
			<td>[<a href="https://github.com/k1moradi/MachineLearningSynapsePhysiology">GitHub</a>]</td>
		</tr>
	</table>
	<br />
</div>
</body>
</html>

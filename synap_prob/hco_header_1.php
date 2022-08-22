<?php
	echo "<script type='text/javascript' src='style/resolution.js'></script>
	<link rel='stylesheet' href='function/menu_support_files/menu_main_style.css' type='text/css' />
	<script src='jqGrid-4/js/jquery-1.11.0.min.js' type='text/javascript'></script>
	<script src='https://code.jquery.com/jquery-migrate-1.2.1.js'></script>
	<script src='jqGrid-4/js/i18n/grid.locale-en.js' type='text/javascript'></script>
	<script src='jqGrid-4/js/jquery.jqGrid.src.js' type='text/javascript'></script>
	<script src='synap_prob/js/main.js' type='text/javascript'></script>";

	require_once('class/class.type.php');
	require_once('class/class.property.php');
	require_once('class/class.evidencepropertyyperel.php');
	require_once('class/class.temporary_result_neurons.php');

	$color_selected ='#EBF283';
	$type = new type($class_type);
	$research = $_REQUEST['research'];
	$property = new property($class_property);
	$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
	$hippo_select = $_SESSION['hippo_select'];

if ($_SESSION['perm'] == NULL)
{
	$_SESSION['perm'] = 1;
	echo "<script>
	window.onload = function() 
	{ 
		if (!window.location.search) 
		{ 
			setTimeout('window.location+=\'?refreshed\';', 0); 
		} 
	} 
	</script>";
}
?>
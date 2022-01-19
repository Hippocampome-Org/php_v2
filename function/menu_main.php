<!-- <%@LANGUAGE="JAVASCRIPT" CODEPAGE="1252"%> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<title></title>
<?php
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);
$devur2 = 0;
$query = "SELECT permission FROM user WHERE password=\"dev2\""; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($devur2) = mysqli_fetch_row($rs);
session_start();
?>
</head>

<body>

	<div id="menu_main_button_new_clr">

	<ul id="css3menu0" class="topmenu">
		<!--
			Note: <?php echo $menuaddr ?> is present below to allow files in subdirectories to set a
			different base directory in links. Given that relative location links are used this fixes
			link address issues.
		-->
		
		<li class="topfirst"><a href="<?php echo $menuaddr ?>morphology.php" style="height:32px;line-height:32px;"><span><img src="<?php echo $menuaddr ?>function/menu_support_files/news.png" alt="" id="image_news"/>Browse</span></a>
	
		<ul>
	
			<li class="subfirst"><a href="<?php echo $menuaddr ?>morphology.php">Morphology</a></li>
			<li><a href="<?php echo $menuaddr ?>markers.php">Molecular markers</a></li>
            <li><a href="<?php echo $menuaddr ?>ephys.php">Membrane biophysics</a></li>
            <li><a href="<?php echo $menuaddr ?>connectivity.php">Connectivity</a></li>
            <li><a href="<?php echo $menuaddr ?>synaptome.php">Synaptic physiology</a></li>
	        <li><a href="<?php echo $menuaddr ?>firing_patterns.php">Firing patterns</a></li>
	        <li><a href="<?php echo $menuaddr ?>Izhikevich_model.php">Izhikevich models</a></li>
            <li><a href="<?php echo $menuaddr ?>synapse_probabilities.php">Synapse probabilities</a></li>
            <li><a href="<?php echo $menuaddr ?>phases.php">In vivo recordings</a></li>
	        <li><a href="<?php echo $menuaddr ?>cognome/index.php">Cognome</a></li>
		</ul></li>
	
		<li class="topmenu"><a href="<?php echo $menuaddr ?>search.php?searching=1" style="height:32px;line-height:32px;"><span><img src="<?php echo $menuaddr ?>function/menu_support_files/find.png" alt="" id="image_find"/>Search</span></a>
	
		<ul>
	
			<li><a href="<?php echo $menuaddr ?>find_author.php?searching=1">Author</a></li>
			<li><a href="<?php echo $menuaddr ?>find_neuron_name.php?searching=1">Neuron Name/Synonym</a></li>
			<li><a href="<?php echo $menuaddr ?>find_neuron_fp.php?searching=1">Original Firing Pattern</a></li>
			<li><a href="<?php echo $menuaddr ?>find_neuron_term.php?searching=1">Neuron Term (Neuron ID)</a></li>
			<li class="subfirst"><a href="<?php echo $menuaddr ?>search.php?searching=1">Neuron Type</a></li>
			<li><a href="<?php echo $menuaddr ?>find_pmid.php?searching=1">PMID/ISBN</a></li>
			<li><a href="<?php echo $menuaddr ?>search_engine_custom.php">Advanced Search</a></li>
	
		</ul></li>
	
	     <li class="topmenu"><a style="height:32px;line-height:32px;"><span><img src="<?php echo $menuaddr ?>function/menu_support_files/tools.ico" alt="" id="image_find"/>Tools</span></a>
      		<ul>
       	 		<!-- <li><a href="">Pixel Counter Program</a></li> -->
        		<li><a href="<?php echo $menuaddr ?>connprob.php">Connection Probabilities</a></li>
        		<li><a href="https://github.com/k1moradi/SynapseModelersWorkshop/archive/master.zip">Synapse Modelers</a></li>
        		<!-- <li><a href="">Liquid Junction Potential Calculator</a></li>
        		<li><a href="">Simulator</a></li>
        		<li><a href="">Post Synaptic Potential Responce</a></li> -->
      		</ul>
    	</li>
		<li class="toplast"><a href="<?php echo $menuaddr ?>help.php" style="height:32px;line-height:32px;"><img src="<?php echo $menuaddr ?>function/menu_support_files/help.png" alt=""/>Help</a>
		
		<ul>
		
		    <li><a href="<?php echo $menuaddr ?>Help_Quickstart.php">Quickstart</a></li>
		    <li><a href="<?php echo $menuaddr ?>Help_FAQ.php">FAQ</a></li>
		    <li><a href="<?php echo $menuaddr ?>Help_Known_Bug_List.php">Known Bugs and Issues</a></li>
		    <li><a href="<?php echo $menuaddr ?>user_feedback_form_entry.php">User Feedback Form</a></li>
		    <li><a href="<?php echo $menuaddr ?>Help_Other_Useful_Links.php">Other Useful Links</a></li>
		    		
		</ul></li>
	
	</ul>

	<a href="<?php echo $menuaddr ?>Help_Known_Bug_List.php" style="height:32px;line-height:32px;"><img src="<?php echo $menuaddr ?>function/menu_support_files/v2p0_icon.jpg" alt=""/></a>

	</div>  

</body>
</html>

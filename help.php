<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Help</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>
<body>
<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
<div class='title_area'>
	<font class="font1">Help topics</font>
</div>
<div>	
	<table width="40%" border="0" cellspacing="0" cellpadding="0" style="position:absolute; top:125px; left:80px;">
	<tr>
		<td width="100%" align="left">
			<font class='font1a'>General:</font> &nbsp; &nbsp;
			<ul> 
  			<li><a href='Help_Quickstart.php'><font class="font7"> Quickstart</font></a></li>
  			<li><a href='Help_FAQ.php'><font class="font7"> FAQs</font></a></li>
  			<li><a href='Help_Terms_of_Use.php'><font class="font7"> Terms of Use</font></a></li>
			<li><a href='images/Interpretation_Flowchart.jpeg'><font class="font7"> Interpretation Protocols Flowchart</font></a></li>
  			<li><a href='Help_Formal_Name_Encoding.php'><font class="font7"> Formal Name Encoding</font></a></li>
  			<li><a href='help/Formal_Neuron_Type_Definitions.html'><font class="font7"> Formal Neuron Type Definitions</font></a></li>
			</ul>

			<font class='font1a'>Feedback:</font> &nbsp; &nbsp;
			<ul> 
			<li><a href='user_feedback_form_entry.php'><font class="font7"> User Feedback Form</font></a></li>
  			<li><a href='Help_Feedback_Submissions.php'><font class="font7"> Feedback Submissions</font></a></li>
			</ul>
			
			<font class='font1a'>ABA Counts Database:</font> &nbsp; &nbsp;
			<ul> 
			<li><a href='attachment/ABA_Counts_Database/ReadMe - ABA Counts Database.docx'><font class="font7"> ReadMe - ABA Counts Database.docx</font></a></li>
  			<li><a href='attachment/ABA_Counts_Database/ReadMe - ABA Counts Database.txt'><font class="font7"> ReadMe - ABA Counts Database.txt</font></a></li>
  			<li><a href='attachment/ABA_Counts_Database/Masked_Segmentations.zip'><font class="font7"> Masked_Segmentations.zip</font></a>
  			<li><a href='attachment/ABA_Counts_Database/Output_Files.zip'><font class="font7"> Output_Files.zip</font></a></li>
  			<li><a href='attachment/ABA_Counts_Database/Scripts.zip'><font class="font7"> Scripts.zip</font></a></li>
  			<li><a href='attachment/ABA_Counts_Database/Stereoinvestigator_Files.zip'><font class="font7"> Stereoinvestigator_Files.zip</font></a></li>
			</ul>
			
			<font class='font1a'>Morphology:</font> &nbsp; &nbsp;
			<ul> 
			<li><a href='Help_Morphological_Abbreviations.php'><font class="font7"> Abbreviations</font></a></li>
  			<li><a href='Help_Morphological_Bibliographic_Protocols.php'><font class="font7"> Bibliographic Protocols</font></a></li>
  			<li><a href='Help_Morphological_Interpretations_Brief.php'><font class="font7"> Interpretations (Brief)</font></a>
  			<li><a href='Help_Morphological_Interpretations_Full.php'><font class="font7"> Interpretations (Full)</font></a></li>
			</ul>
			
			<font class='font1a'>Molecular markers:</font> &nbsp; &nbsp;
			<ul>
			<li><a href='Help_Marker_Abbreviations.php'><font class="font7"> Abbreviations</font></a></li>
			<li><a href='data/High-conf-genes_CA1-SP.pdf'><font class="font7"> High-conf-genes_CA1-SP</font></a></li>
			<li><a href='data/High-conf-genes_CA2-SP.pdf'><font class="font7"> High-conf-genes_CA2-SP</font></a></li>
			<li><a href='data/High-conf-genes_CA3-SP.pdf'><font class="font7"> High-conf-genes_CA3-SP</font></a></li>
			<li><a href='data/High-conf-genes_DG-SG.pdf'><font class="font7"> High-conf-genes_DG-SG</font></a></li>
			<li><a href='data/GeneParcelExpressionConfidence.xlsx'><font class="font7"> Allen Brain Atlas gene expression confidence by parcel</font></a></li>
			<li><a href='http://hippocampome.org/genexan'><font class="font7"> Gene Expression Analyzer</font></a></li>
			<li><a href='data/REIs.xlsx'><font class="font7"> Relational Expression Inferences (REIs)</font></a></li>
			</ul>
			
			<font class='font1a'>Electrophysiology:</font> &nbsp; &nbsp;
			<ul>
  			<li><a href='Help_Electrophysiological_Abbreviations_and_Definitions.php'><font class="font7"> Abbreviations and Definitions</font></a></li>
			</ul>
			
			<font class='font1a'>Firing Patterns:</font> &nbsp; &nbsp;
			<ul>
  			<li><a href='Help_FP_Abbreviations.php'><font class="font7"> Abbreviations and Definitions</font></a></li>
  			<li><a href='Help_Principles_of_Classification_of_Firing_Pattern_Elements.php'><font class="font7"> Principles of Classification of Firing Pattern Elements</font></a></li>
  			<li><a href='Help_Firing_Pattern_Identification_Pseudocode.php'><font class="font7"> Firing Pattern Identification Pseudocode</font></a></li>
			</ul>
			
			<font class='font1a'>Simulation of Firing Patterns:</font> &nbsp; &nbsp;
			<ul>
  			<li><a href='Help_Model_Definition.php'><font class="font7"> Model Definition</font></a></li>
  			<li><a href='Help_Model_Fitting.php'><font class="font7"> Model Fitting</font></a></li>
  			<li><a href='Help_Model_Simulation.php'><font class="font7"> Model Simulation Using CARLsim</font></a></li>
  			<li><a href='data/NeuroML2.zip'><font class="font7"> NeuroML2 files</font></a></li>
			</ul>
			
			<font class='font1a'>Connectivity:</font> &nbsp; &nbsp;			
			<ul>
			<li><a href='Help_Connectivity.php'><font class="font7"> Definitions and Protocols</font></a></li>
			<li><a href='data/netlist.csv'><font class="font7"> Netlist</font></a></li>
			<li><a href='Help_ConnectivityJava.php'><font class="font7"> Java Connectivity Map Won't Launch</font></a></li>  			
			</ul>
			
			<font class='font1a'>Synaptome:</font> &nbsp; &nbsp;			
			<ul>
			<li><a href='synaptome.php'><font class="font7"> Requirements, Installation, and Advanced Access Instructions</font></a></li>
			</ul>
			
			<font class='font1a'>Search:</font> &nbsp; &nbsp;			
			<ul>
  			<li><a href='Help_Search_Engine.php'><font class="font7"> Advanced Search Engine User Manual</font></a></li>
			</ul>
			
			<font class='font1a'>Hi-resolution images:</font> &nbsp; &nbsp;			
			<ul>
			<li><a href='images/morphology/Morphology_Matrix.jpg'><font class="font7"> Morphology Matrix</font></a></li>  			
			<li><a href='images/marker/Marker_Matrix.jpg'><font class="font7"> Marker Matrix</font></a></li>  			
			<li><a href='images/electrophysiology/Electrophysiology_Table.jpg'><font class="font7"> Electrophysiology Table</font></a></li>  			
			<li><a href='images/FP/Principles_of_Classification_of_Firing_Pattern_Elements.jpg'><font class="font7"> Principles of Classification of Firing Pattern Elements Table</font></a></li>  			
			<li><a href='images/connectivity/Connectivity_Matrix.jpg'><font class="font7"> Connectivity Matrix</font></a></li>
			<li><a href='images/connectivity/DG_Circuit_Diagram.jpg'><font class="font7"> Dentate Gyrus Circuit Diagram</font></a></li>
			<li><a href='images/connectivity/DG_Circuit_Diagram.graffle.zip'><font class="font7"> Dentate Gyrus Circuit Diagram (source)</font></a></li>
			</ul>			
			
			<font class='font1a'>Synapse Probabilities:</font> &nbsp; &nbsp;			
			<ul>
  			<li><a href='data/Bio-protocol_sample_files.zip'><font class="font7"> Bio-protocol sample files</font></a></li>
			</ul>
			
			<font class='font1a'>Miscellaneous:</font> &nbsp; &nbsp;			
			<ul>
  			<li><a href='Help_Known_Bug_List.php'><font class="font7"> Known Bugs and Issues</font></a></li>
  			<li><a href='Help_Future_Updates.php'><font class="font7"> Future Updates</font></a></li>
  			<li><a href='Help_Ongoing_Literature_Mining.php'><font class="font7"> Ongoing Literature Mining</font></a></li>
  			<li><a href='Help_Release_Notes.php'><font class="font7"> Release Notes</font></a></li>
  			<li><a href='Help_On-hold_Types.php'><font class="font7"> On-hold Types</font></a></li>
  			<li><a href='Help_Supplemental_Evidence.php'><font class="font7"> Supplemental Evidence</font></a></li>
  			<li><a href='Help_Use_Case_Scenario.php'><font class="font7"> Usage Scenario</font></a></li>
  			<li><a href='Hippocampome_Video_Overview/Hippocampome_Video_Overview_player.html' target="_blank"><font class="font7"> Hippocampome Video Overview</font></a></li>
  			<li><a href='Help_Bibliography.php'><font class="font7"> Bibliography</font></a></li>
  			<li><a href='https://github.com/Hippocampome-Org/'><font class="font7"> Hippocampome.org GitHub code repository</font></a></li>
  			<li><a href='Help_Other_Useful_Links.php'><font class="font7"> Other Useful Links</font></a></li>
  			<li><a href='Help_Acknowledgements.php'><font class="font7"> Acknowledgements</font></a></li>
			</ul>
						
		</td>
	</tr>
	</table>
	<br />
</div>
</body>

</html>

<?php
require_once('synap_prob/class/class.attachment_synpro.php');

function retrieve_evidences($show1, $type_for_display, $fragment, $conn, $id1_neuron, $id_original, $val1_property, $name_temporary_table, $subquery, $id_fragment, $class_fragment, $color1, $nm_page, $page_location, $quote, $attachment_obj)
{		
	if ($show1 == 1)
	{
		$type_show  = "";
		$query_type = "SELECT distinct type FROM $name_temporary_table WHERE id_fragment = $id_fragment $subquery ORDER BY type ASC";
		$rs_type = mysqli_query($conn,$query_type);	
		while(list($type) = mysqli_fetch_row($rs_type))
		{
			$type_show  = $type_show . $type;
		}				
		if($color1 != ''){
			//if ($type_show == 'Axons')
			if ($type_for_display == 'Axons')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axon'>");
			if ($type_for_display == 'Dendrites')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendrite'>");
			if ($type_for_display == 'Somata')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='somata'>");
			if ($type_for_display == 'AxonsSomata')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axonsomata'>");
			if ($type_for_display == 'AxonsDendrites')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendrite'>");
			if ($type_for_display == 'DendritesSomata')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendritesomata'>");
			if ($type_for_display == 'AxonsDendritesSomata')
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendritesomata'>");						
		}

		if ($type_for_display == '')						
			print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table'>");
		print ("<tr>");

		$row_span=30;
		if ($type_for_display == 'Axons')		
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top'><img src='images/axon.png'></td>");
		if ($type_for_display == 'Dendrites')		
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top'><img src='images/dendrite.png'></td>");	
		if ($type_for_display == 'Somata')		
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top'><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p></td>");
		if ($type_for_display == 'AxonsSomata')	
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell' class='comboflag-axonsomata'> <p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon.png'></td>");										   
		if ($type_for_display == 'AxonsDendrites')	
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell' class='comboflag-axondendrite'><img src='images/axon-dendrite.png'></td>");
		if ($type_for_display == 'DendritesSomata')
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell' class='comboflag-dendritesomata'><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/dendrite.png'></td>");	
		if ($type_for_display == 'AxonsDendritesSomata')
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell' class='comboflag-axondendritesomata'> <p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon-dendrite.png'></td>");
		if ($type_for_display == '')									
			print ("<td width='15%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell'></td>");								
								// retrieve the attachament
		$dendrite_group = array('Dendrites', 'Somata', 'AxonsSomata', 'AxonsDendrites', 'DendritesSomata', 'AxonsDendritesSomata');
		$axon_group = array('Axons','Somata','AxonsSomata','AxonsDendrites','AxonsDendritesSomata');
		$original_id = $fragment -> getOriginal_id();
		if (in_array($type_for_display,$dendrite_group)) {
			$neurite_ref = $val1_property.":D";
		}
		elseif (in_array($type_for_display,$axon_group)) {
			$neurite_ref = $val1_property.":A";	
		}
		$attachment_obj = new attachment_synpro($class_attachment); // this clears prior attachment results
		$attachment_obj -> retrive_by_props($id_original, $id1_neuron, $neurite_ref);
		$attachment = $attachment_obj -> getName();
		$attachment_type = $attachment_obj -> getType();
		//$attachment_type="synpro_figure";
		$link_figure="";									
		$attachment_jpg = $attachment;//str_replace('jpg', 'jpeg', $attachment);
		// original article attachment
		$attachment_obj2 = new attachment_synpro($class_attachment); // this clears prior attachment results
		$attachment_obj2 -> retrive_by_props($id_original, $id1_neuron, 'Original');
		$art_orig_attachment = $attachment_obj2 -> getName();
		$art_orig_attachment_type = $attachment_obj2 -> getType();
		$art_orig_attachment_jpg = $art_orig_attachment;//str_replace('jpg', 'jpeg', $art_orig_attachment);

		if($attachment_type=="synpro_figure"){
			$link_figure = "attachment/neurites/".$attachment_jpg;
			$art_orig_link_figure = "attachment/neurites/".$art_orig_attachment_jpg;
		}								
		$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
		$link_figure_pdf = "figure_pdf/".$attachment_pdf;
		
		// get protocol age species and interpretation
		$query_to_get_info = "SELECT interpretation_notes,protocol,age_weight,species_tag  FROM ".$class_fragment." WHERE id=$id_fragment ";
		//echo "<br>query_to_get_info:".$query_to_get_info;
		$rs_to_get_info = mysqli_query($conn,$query_to_get_info);	
		$seg_1_text="";
		$seg_2_text="";
		while(list($interpretation_notes,$protocol,$age_weight,$species_tag) = mysqli_fetch_row($rs_to_get_info))
		{
			if ($interpretation_notes=='NULL') {$interpretation_notes='';}
			if ($protocol=='NULL') {$protocol='';}
			if ($age_weight=='NULL') {$age_weight='';}
			if ($species_tag=='NULL') {$species_tag='';}
			$species=$fragment->refid_to_species($id_original);
			if ($species=='NULL') {$species='';}

			if($protocol){
				$seg_1_text=$seg_1_text."	<tr>
				<td width='70%' class='table_neuron_page2' align='left'>
				PROTOCOL: $protocol
				</td>
				<td width='15%' align='center'> </td></tr>";
			}
			if($species){
				$seg_1_text=$seg_1_text."<tr>	
				<td width='70%' class='table_neuron_page2' align='left'>
				SPECIES: $species 
				</td>
				<td width='15%' align='center'> </td></tr>";
			}
			if($age_weight){
				$seg_1_text=$seg_1_text."	<tr>
				<td width='70%' class='table_neuron_page2' align='left'>
				Age/Weight: $age_weight
				</td>
				<td width='15%' align='center'> </td></tr>";
			}
			#$seg_2_text="";
			if($interpretation_notes){
				$seg_2_text=$seg_2_text."</br></br> Interepretation Notes: $interpretation_notes";
			}
			#array_push($segment1, $seg_1_text);
			#array_push($segment2, $seg_2_text);
		}
		print ($seg_1_text);
		// describe neurite statistics
		$neuron_id=$id1_neuron;
		$nq_neurite_name = $fragment->prop_name_to_nq_name($neurite_ref);
		$refID=$id_original;
		$parcel=$val1_property;
		//print ("
		//	<tr>
		//	<td width='70%' class='table_neuron_page2' align='left'>");
		//$somatic_distances=$fragment->getSomaticDistances($neuron_id,$nq_neurite_name,$refID);
		/*
		$download_icon='images/download_RAR.png';
		$att_desc="RAR compressed somatic-distance paths for ".$neurite_ref.":";
		$att_link='attachment/neurites_rar/'.$fragment->getRarFile($neuron_id,$nq_neurite_name,$refID);
		*/
		// retrieve the attachament
		$dendrite_group = array('Dendrites', 'Somata', 'AxonsSomata', 'AxonsDendrites', 'DendritesSomata', 'AxonsDendritesSomata');
		$axon_group = array('Axons','Somata','AxonsSomata','AxonsDendrites','AxonsDendritesSomata');
		$original_id = $fragment -> getOriginal_id();
		if (in_array($type_for_display,$dendrite_group)) {
			$neurite_ref = $val1_property.":D";
		}
		elseif (in_array($type_for_display,$axon_group)) {
			$neurite_ref = $val1_property.":A";	
		}
		$attachment_obj -> retrive_by_props($id_original, $id_neuron, $neurite_ref);
		$attachment = $attachment_obj -> getName();
		$attachment_type = $attachment_obj -> getType();
		//$attachment_type="synpro_figure";								
		$attachment_jpg = $attachment;//str_replace('jpg', 'jpeg', $attachment);
		$link_figure = "attachment/neurites/".$attachment_jpg;
		$download_icon='images/download_PNG.png';
		$att_desc="Figure segmentation evidence for ".$neurite_ref.":";
		$att_link=$link_figure;
		/*$values_count=$somatic_distances[2];
		if ($values_count>1) {
			if ($color1=='red') {
				print ("Somatic distances of axons: mean ".$somatic_distances[1]." ± standard deviation ".$somatic_distances[0]." (n = ".$somatic_distances[2]."; min = ".$somatic_distances[3]."; max = ".$somatic_distances[4].")");
			}
			if ($color1=='blue') {
				print ("Somatic distances of dendrites: mean ".$somatic_distances[1]." ± standard deviation ".$somatic_distances[0]." (n = ".$somatic_distances[2]."; min = ".$somatic_distances[3]."; max = ".$somatic_distances[4].")");
			}
		}
		else {
			if ($color1=='red') {
				print ("Somatic distance of axons in ".$parcel.": ".$somatic_distances[1]." μm (n = 1)");
			}
			if ($color1=='blue') {
				print ("Somatic distance of dendrites in ".$parcel.": ".$somatic_distances[1]." μm (n = 1)");
			}			
		}*/
		if ($nm_page=='prosyn' or $nm_page=='noc') {
			print ("
			<tr>
			<td width='70%' class='table_neuron_page2' align='left'>");
			$convexhullvolume=$fragment->getConvexHullVolume($neuron_id,$nq_neurite_name,$refID);
			print ("Convex hull volume in ".$val1_property.": $convexhullvolume μm&sup3;");
			print ("</td></tr>");
		}
		if ($nm_page=='ps' or $nm_page=='noc') {
			print ("
			<tr>
			<td width='70%' class='table_neuron_page2' align='left'>");
			$neurite_lengths=$fragment->getNeuriteLengths($neuron_id,$nq_neurite_name,$refID);
			$values_count=$neurite_lengths[2];
			if ($values_count>1) {
				if ($color1=='red') {
					print ("Axonal lengths: mean ".$neurite_lengths[1]." ± standard deviation ".$neurite_lengths[0]." (n = ".$neurite_lengths[2]."; min = ".$neurite_lengths[3]."; max = ".$neurite_lengths[4].")");
				}
				if ($color1=='blue') {
					print ("Dendritic lengths: mean ".$neurite_lengths[1]." ± standard deviation ".$neurite_lengths[0]." (n = ".$neurite_lengths[2]."; min = ".$neurite_lengths[3]."; max = ".$neurite_lengths[4].")");
				}
			}
			else {
				if ($color1=='red') {
					print ("Axonal length in ".$parcel.": ".$neurite_lengths[1]." μm");										}
				if ($color1=='blue') {
					print ("Dendritic length in ".$parcel.": ".$neurite_lengths[1]." μm");
				}
			}
			print ("</td></tr>");
		}
		print ("
			<tr>	
			<td width='70%' class='table_neuron_page2' align='left'>");

		print ($att_desc);
			//print ($id_fragment);
		print("</td>
			<td width='15%' class='table_neuron_page2' align='center'>");

			//if ($attachment_type=="morph_figure"||$attachment_type=="morph_table")
		if ($attachment_type=="synpro_figure"&&$link_figure!='attachment/neurites/')
		{
			print ("<a href='".$att_link."' target='_blank'>");
			print ("<img src='".$download_icon."' border='0' width='40%' style='background-color:white;'>");
			print ("</a>");
		}
		print("</td></tr>");
		//print ($id_fragment." ".$id_original." ".$id1_neuron." ".$nq_neurite_name);

		// view info
		print ("
			<tr>	
			<td width='70%' class='table_neuron_page2' align='left'>
			Page location: <span title='$id_fragment (original: $id_original)'>$page_location</span>
			</td>
			<td width='15%' align='center'>");	
		print ("</td></tr>	
			<tr>		
			<td width='70%' class='table_neuron_page2' align='left'>
			<em>$quote</em>");
		print ($seg_2_text);
		print("</td>
			<td width='15%' class='table_neuron_page2' align='center'>");

		//if ($attachment_type=="morph_figure"||$attachment_type=="morph_table")
		if ($attachment_type=="synpro_figure"&&$link_figure!='attachment/neurites/')
		{
			print ("<a href='$art_orig_link_figure' target='_blank'>");
			print ("<img src='$art_orig_link_figure' border='0' width='80%' style='background-color:white;'>");
			print ("</a>");
		}	
		else;
		print("</td></tr>");

		print ("</table>");
	}
}
?>
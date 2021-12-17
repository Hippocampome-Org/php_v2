<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include ("function/neuron_page_text_file.php");
include ("function/name_ephys_for_evidence.php");
include ("function/show_ephys.php");
include ("function/get_abbreviation_definition_box.php");
include ("function/stm_lib.php");
include ("function/quote_manipulation.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.synonym.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.epdataevidencerel.php');
require_once('class/class.epdata.php');
require_once('class/class.synonymtyperel.php');
require_once('class/class.fragmenttyperel.php');
require_once('class/class.fragment.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.typetyperel.php');

require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');
require_once('class/class.parcel.php');

//$id = $_REQUEST['id'];
$subregionForSelection = $_REQUEST['subregion'];
$selectionType = $_REQUEST['type'];

$parcelForSelection = $_REQUEST['parcel'];
$title = $subregionForSelection;

if($selectionType=="parcel")
	$title = $title.":".$parcelForSelection;


if($selectionType=="parcel")
	$array_for_use = array($parcelForSelection);
else
{
	if($subregionForSelection=="DG")
		$array_for_use = array("SMo","SMi","SG","H");
	else if($subregionForSelection=="CA3")
		$array_for_use = array("SLM","SR","SL","SP","SO");
	else if($subregionForSelection=="CA2" || $subregionForSelection=="CA1")
		$array_for_use = array("SLM","SR","SL","SP","SO");
	else if($subregionForSelection=="SUB")
		$array_for_use = array("SM","SP","PL");
	else
		$array_for_use = array("I","II","III","IV","V","VI");
}

$type = new type($class_type);
$type -> retrive_by_id($id);

$synonym = new synonym($class_synonym);

$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

$epdataevidencerel = new epdataevidencerel($class_epdataevidencerel);

$epdata = new epdata($class_epdata);

$synonymtyperel = new synonymtyperel('SynonymTypeRel');

$fragmenttyperel = new fragmenttyperel();

$fragment = new fragment($class_fragment);

$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);

$typetyperel = new typetyperel();

$articleevidencerel = new articleevidencerel($class_articleevidencerel);

$article = new article($class_article);

$articleauthorrel = new articleauthorrel($class_articleauthorrel);

$author = new author($class_author);

$parcel = new parcel();

if ($text_file_creation)
{
	$name_file = neuron_page_text_file($id, $type, $synonymtyperel, $synonym, $evidencepropertyyperel, $property, $epdataevidencerel, $epdata, $class_type);
	print ("<script type=\"text/javascript\">");
	echo("window.open('$name_file','', 'menubar=yes, width=900, height=700' );");
	print ("</script>");
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
include ("function/icon.html"); 
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Parcel page</title>
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>
<link href="lightbox/css/lightbox.css" rel="stylesheet"/>

<script src="jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.min.css" />
<script src="jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js"></script>
 <link rel="stylesheet" href="/resources/demos/style.css" />
  
  <script>
  $(function(){
	  
	 $( "#list_acc" ).accordion({collapsible:true,active:null,heightStyle: "content",autoHeight:false});
    $( "#accordion" ).accordion({collapsible:true,heightStyle: "content",event: "click hoverintent"});
    });

  $.event.special.hoverintent = {
		    setup: function() {
		      $( this ).bind( "mouseover", jQuery.event.special.hoverintent.handler );
		    },
		    teardown: function() {
		      $( this ).unbind( "mouseover", jQuery.event.special.hoverintent.handler );
		    },
		    handler: function( event ) {
		      var currentX, currentY, timeout,
		        args = arguments,
		        target = $( event.target ),
		        previousX = event.pageX,
		        previousY = event.pageY;
		 
		      function track( event ) {
		        currentX = event.pageX;
		        currentY = event.pageY;
		      };
		 
		      function clear() {
		        target
		          .unbind( "mousemove", track )
		          .unbind( "mouseout", clear );
		        clearTimeout( timeout );
		      }
		 
		      function handler() {
		        var prop,
		          orig = event;
		 
		        if ( ( Math.abs( previousX - currentX ) +
		            Math.abs( previousY - currentY ) ) < 7 ) {
		          clear();
		 
		          event = $.Event( "hoverintent" );
		          for ( prop in orig ) {
		            if ( !( prop in event ) ) {
		              event[ prop ] = orig[ prop ];
		            }
		          }
		          // Prevent accessing the original event since the new event
		          // is fired asynchronously and the old event is no longer
		          // usable (#6028)
		          delete event.originalEvent;
		 
		          target.trigger( event );
		        } else {
		          previousX = currentX;
		          previousY = currentY;
		          timeout = setTimeout( handler, 200 );
		        }
		      }
		 
		      timeout = setTimeout( handler, 200 );
		      target.bind({
		        mousemove: track,
		        mouseout: clear
		      });
		    }
		  };
  </script>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
	
	function morphology_sub_table_head($title) {
		$html ="<table width='80%' border='0' cellspacing='2' cellpadding='0'>
		<tr>
		<td width='20%' align='right' class='table_neuron_page1'>
		$title
		</td>
		<td align='left' width='80%' class='table_neuron_page1'>
		</td>
		</tr>";
		return $html;
	}
	
	function parcel_row($parcel, $part) {
		$color_table = array("axons" => "red", "dendrites" => "blue", "somata" => "somata");
		$color = $color_table[$part];
		$html = "<tr>
				<td width='20%' align='right'> </td>
				<td align='left' width='80%' class='table_neuron_page2'>
					<a href='neuron_page.php?id=".$parcel->getTypeId()."'>
						<font class='".get_excit_inhib_font_class($parcel->getExcitInhib())."'>".$parcel->getNickName()."</font>
					</a>
				</td>
			</tr>";
		return $html;
						//<font class='".get_excit_inhib_font_class($parcel->getExcitInhib())."'>".$parcel->getSubRegion().":".$parcel->getNickName()."</font>
	}
	
    function morphology_sub_table_foot()
	{
		$html = "</table>";
	    return $html;
	}
	
	function connection_table_head($title,$subregion,$parcel) {
		$html = "<table width='80%' border='0' cellspacing='2' cellpadding='0'>
		<tr>
		<td width='100%' align='center' class='table_neuron_page3'>
		$title
		</td>
		</tr>
		</table>
	
		<table width='80%' border='0' cellspacing='2' cellpadding='0'>
		<tr>
		<td width='20%' align='right' class='table_neuron_page1' >".$subregion.":".$parcel."&nbsp;</td>
		<td width='40%' align='center' class='table_neuron_page1'>
          	Source of Input
          </td>
          <td width='40%' align='center' class='table_neuron_page1'>
          	Target of Output
          </td>
          </tr>";
        return $html;
      }
	
      function get_excit_inhib_font_class($name) {
	 //     if (strpos($name, '(+)')) {
			 if ($name == 'e') {
	      $font_class = 'font10a';
	} else { // is (i)
	$font_class = 'font11';
	}
		return $font_class;
      }
	
		function name_row($inputList,$outputList) {
		$itrCount = max(count($inputList),count($outputList));
	
		$html ="";
		for($var=0;$var<$itrCount;$var++)
		{
			$html = $html."<tr><td width='20%' align='center'>&nbsp;</td>";
			if(isset($inputList[$var]))
				$html = $html."<td width='40%' align='left' class='table_neuron_page2'>&nbsp;<a href='neuron_page.php?id=".$inputList[$var]["id"]."' class='".get_excit_inhib_font_class($inputList[$var]["excit_inhib"])."'>".$inputList[$var]["subregion"]." ".$inputList[$var]["nickname"]."</a></td>";
						else
						$html = $html."<td width='40%' align='left' class='table_neuron_page2'>&nbsp;</td>";
	
		    if(isset($outputList[$var]))
			    		$html = $html."<td width='40%' align='left' class='table_neuron_page2'>&nbsp;<a href='neuron_page.php?id=".$outputList[$var]["id"]."' class='".get_excit_inhib_font_class($outputList[$var]["excit_inhib"])."'>".$outputList[$var]["subregion"]." ".$outputList[$var]["nickname"]."</a></td>";
			    				else
				$html = $html."<td width='40%' align='left' class='table_neuron_page2'>&nbsp;</td>";
			    				 
		    $html = $html."</tr>";;
			}
			    				return $html;
			}
	
			function name_row_none($name_none) { // the list of targets or sources is empty
					$html =
			"<tr>
			<td width='20%' align='right'>&nbsp;</td>
			<td align='left' width='40%' class='table_neuron_page2'>
			$name_none
				</td>
				<td align='left' width='40%' class='table_neuron_page2'>
				$name_none
				</td>
				</tr>";
				return $html;
			}
	
			function connection_table_foot() {
			$html= "</table>
			</br></br>";
			return $html;
			}
			
	$morphology_properties_query ="SELECT DISTINCT t.name, t.subregion, t.nickname, p.subject, p.predicate, p.object, eptr.Type_id, eptr.Property_id 
	FROM EvidencePropertyTypeRel eptr JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id) 
	WHERE predicate = 'in' AND object REGEXP ':'";
?>	

<div class='title_area'>
	<font class="font1"><?php echo $title?></font>
</div>
<div align="center">
<table width="85%" border="0" cellspacing="2" cellpadding="0" class='body_table'>
  <tr height="50">
    <td></td>
  </tr>
  <tr>
    <td align="center">
		<!-- ****************  BODY **************** -->		
				
		
		<br/><br/><br/>
		
		
		
<?php 
 for($ivar=0;$ivar < count($array_for_use);$ivar++)
 {
?>
<table width="80%" border="0" cellspacing="2" cellpadding="0">
<?php if($selectionType=="subregion"){?> 	
	<tr>
		<td width="100%" align="left"><font class="font1"><?php echo $subregionForSelection.":".$array_for_use[$ivar]?></font></td>
	</tr>
<?php }?>
	<tr>
		<td width="20%" align="center" class="table_neuron_page3">Morphology</td>			
	</tr>			
</table>
<?php
	$list_potential_sources = Array();
	$list_potential_targets = Array();
	$possible_sources = Array();
	$possible_targets = Array();
	$dendrite_parcels = Array();
	$axon_parcels = Array();
	$explicit_sources = Array();
	$list_explicit_nonsources = Array();
	
	$parcel->retrieve_neuron_list_by_property($subregionForSelection.":".$array_for_use[$ivar], "somata"); // Change in implementation
    $soma_parcels = $parcel->getParcelList();
    
    print morphology_sub_table_head("Soma"); // Generate header for the SOMA table
    foreach($soma_parcels as $parcel) { print parcel_row($parcel, "somata"); }
    print morphology_sub_table_foot(); // Generate footer for the table

    $parcel->retrieve_neuron_list_by_property($subregionForSelection.":".$array_for_use[$ivar], "axons");
    $axon_collection = $parcel->getParcelList();
    
    print morphology_sub_table_head("Axons"); // Generate header for the AXON table
    foreach($axon_collection as $parcel) { print parcel_row($parcel, "axons"); }
    print morphology_sub_table_foot();// Generate footer for the table 
    
    $parcel->retrieve_neuron_list_by_property($subregionForSelection.":".$array_for_use[$ivar], "dendrites");
    $dendrite_collection = $parcel->getParcelList();
  	
    print morphology_sub_table_head("Dendrites"); // Generate header for the DENDRITES table
    foreach($dendrite_collection as $parcelEntry) 
	{ 
		print parcel_row($parcelEntry, "dendrites"); 
	}
    print morphology_sub_table_foot();// Generate footer for the table */
	?>
<br /><br />
<?php       
	  /* INPUT LIST  */
	  // Known Sources of Input

	  /* $dendrite_parcels[]  = $subregionForSelection.":".$array_for_use[$ivar]; // Change in Later implementation
      $possible_sources = filter_types_by_morph_property('axons', $dendrite_parcels);
      
      $parcel->retrive_neuron_list_by_input_output("positive","Type2_id",$subregionForSelection.":".$array_for_use[$ivar]); // Generate a list of all neurons for the parcel --> To be changed in Later Implementation
      $knownInputList = $parcel -> getParcelList(); // generate a list for the parcel
      
      foreach($knownInputList as $parcelEntry) // Create an array of explicit sources
      {
      	$explicit_sources[] = $parcelEntry->getType1Id();
      }
       
      if(count($explicit_sources) >= 1) {
      	$list_explicit_sources = array_unique($explicit_sources);
      	$list_explicit_sources = get_sorted_records($list_explicit_sources);
      }
      // Potential Sources of Input
      $parcel->retrive_neuron_list_by_input_output("negative","Type2_id",$subregionForSelection.":".$array_for_use[$ivar]); // Generate a list of all neurons for the parcel --> To be changed in Later Implementation
      $explicit_nonsources = Array();
      $PotentialInputList = Array();
      $PotentialInputList = $parcel -> getParcelList(); // generate a Potential List for the parcel
      
      foreach($knownInputList as $parcelEntry) // Create an array of explicit sources
      {
      	$explicit_nonsources[] = $parcelEntry->getType1Id();
      }
      
      if (count($explicit_nonsources) >= 1) {
      	$list_explicit_nonsources = array_unique($explicit_nonsources);
      	$list_explicit_nonsources = get_sorted_records($list_explicit_nonsources);
      }
      
      $list_potential_sources = array_diff(array_diff($possible_sources, $explicit_nonsources), $explicit_sources);
      $list_potential_sources = array_unique($list_potential_sources);
      $list_potential_sources = get_sorted_records($list_potential_sources);
      
      /* OUTPUT LIST  
      // Known Sources of Output
      $axon_parcels[] = $subregionForSelection.":".$array_for_use[$ivar]; // Change in Later implementation
      $possible_targets = filter_types_by_morph_property('dendrites',$axon_parcels);
      $explicit_targets = Array();
      $parcel->retrive_neuron_list_by_input_output("positive","Type1_id",$subregionForSelection.":".$array_for_use[$ivar]); // Generate a list of all neurons for the parcel
      $knownOutputList = $parcel -> getParcelList(); // generate a list for the parcel
      
      $list_explicit_targets = Array();
      foreach($knownOutputList as $parcelEntry) // Create an array of explicit targets
      {
      	$explicit_targets[] = $parcelEntry->getType2Id();
      }
      
	  if (count($explicit_targets) >= 1) {
			$list_explicit_targets = array_unique($explicit_targets);
			$list_explicit_targets = get_sorted_records($list_explicit_targets);
	  }
	  
	  // Potential Sources of Output
	  $explicit_nontargets = Array();
	  $parcel->retrive_neuron_list_by_input_output("negative","Type1_id",$subregionForSelection.":".$array_for_use[$ivar]); // Generate a list of all neurons for the parcel
	  $potentialOutputList = $parcel -> getParcelList(); // generate a list for the parcel
	  
	  
	  foreach($potentialOutputList as $parcelEntry) // Create an array of explicit targets
	  {
	  	$explicit_nontargets[] = $parcelEntry->getType2Id();
	  }
	  
	  $list_explicit_nontargets = Array();
	  if (count($explicit_nontargets) >= 1) {
			$list_explicit_nontargets = array_unique($explicit_nontargets);
			$list_explicit_nontargets = get_sorted_records($list_explicit_nontargets);
	  }
	  
	  $list_potential_targets = array_diff(array_diff($possible_targets, $explicit_nontargets), $explicit_targets);
	  $testArr1 = array_diff($possible_targets, $explicit_nontargets);
	  
      $list_potential_targets = array_unique($list_potential_targets);
      $list_potential_targets = get_sorted_records($list_potential_targets);
      
      // Start R 2C connectivity changes
      // print it out
      print connection_table_head("Known Connections",$subregionForSelection,$array_for_use[$ivar]);
      if ((count($list_explicit_targets) < 1) && (count($list_explicit_sources) < 1)) // the list of targets or sources is empty
			print name_row_none("none known");
	  else
	  { 
			print name_row($list_explicit_sources,$list_explicit_targets); 
	  }
	  print connection_table_foot();
	  
	  print connection_table_head("Potential Connections",$subregionForSelection,$array_for_use[$ivar]);
	  if ((count($list_potential_targets) < 1) && (count($list_potential_sources) < 1)) // the list of targets or sources is empty
	  	print name_row_none("none known");
	  else
	  {
	  	print name_row($list_potential_sources,$list_potential_targets);
	  }
	  print connection_table_foot();*/
 } 
	  ?>
		</table>	
			<br />	<br />		
		</td>
	</tr>
</table>		
</div>		
</body>
</html>

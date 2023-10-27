<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.firingpattern.php');
require_once('class/class.firingpatternrel.php');

$parameter=$_GET['pattern'];
$title = $parameter;
$array_for_use = array($parameter);

$type = new type($class_type);
$type -> retrive_by_id($id);

$property = new property($class_property);
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$firingpattern = new firingpattern($class_firing_pattern);
$firingpatternrel = new firingpatternrel($class_firing_pattern_rel);

$firingpatternrel = new firingpatternrel($class_firing_pattern_rel);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<?php 
include ("function/icon.html"); 
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pattern page</title>
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
<style>
.title_area2 {
	position:absolute; top: 80px; left: 50px;
	width: 1000px;
	border:none;
}
</style>
</head>

<body>
<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
	
	function firing_sub_table_head($title) {
		$html ="<table width='80%' border='0' cellspacing='2' cellpadding='1'>
		<tr>
		<td width='20%' align='right' class='table_neuron_page1'>
		$title
		</td>
		<td align='left' width='80%' class='table_neuron_page1'>
		</td>
		</tr>";
		return $html;
	}
	
	function parcel_row($type) {
		$html = "<tr>
				<td width='20%' align='right'> </td>
				<td align='left' width='80%' class='table_neuron_page2'>
					<a href='neuron_page.php?id=".$type->getId()."'>
						<font class='".get_excit_inhib_font_class($type->getExcit_Inhib())."'>".$type->getNickname()."</font>
					</a>
				</td>
			</tr>";
		return $html;
	}
	
	function parameter_row($parameter_name, $parameter_values) {
		$html = "<tr>
				<td width='20%' align='right'> </td>
				<td align='left' width='80%' class='table_neuron_page2'>
					".$parameter_name.":".$parameter_values."
				</td>
			</tr>";
		return $html;
	}
	
	function firing_sub_table_foot()
	{
		$html = "</table>";
	    return $html;
	}
	
	function get_excit_inhib_font_class($name) {
		if ($name == 'e') {
			$font_class = 'font10a';
		} 
		else { 
			$font_class = 'font11';
		}
		return $font_class;
	}
?>

<div class='title_area2'>
	<font class="font1"><?php
	$query = "SELECT fp_name FROM FiringPattern WHERE overall_fp like '$parameter'";
	$rs = mysqli_query($GLOBALS['conn'],$query);
	$row_data = mysqli_fetch_row($rs);
	$fp_name_val=$row_data[0];
	print("$fp_name_val ($title)");
	?>
	[<a href="Help_Principles_of_Classification_of_Firing_Pattern_Elements.php">formal defintion</a>]</font>
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

<table width="80%" border="0" cellspacing="2" cellpadding="0">	
	<tr>
		<td width="20%" align="center" class="table_neuron_page3">Firing Pattern</td>			
	</tr>			
</table>
<table width='80%' border='0' cellspacing='2' cellpadding='0'>
		<tr>
		<td width='20%' align='right' class='table_neuron_page1'>
		Images
		</td>
		<td align='right' width='80%' class='table_neuron_page1'>
		</td>
		</tr>
<tr>
<td width='20%' align='left'> </td>
<td align='right' width='80%' class='table_neuron_page2'>
<div style="width:100%; background-color:white; height:95px; overflow:scroll;overflow-x: scroll;overflow-y: scroll;">
	<?php
	$firing_parameter=$_REQUEST['pattern'];
	$query_to_get_images = "SELECT DISTINCT name FROM Attachment WHERE parameter LIKE '$firing_parameter' group by substr(original_id,5,length(original_id)) order by name";
	$rs_images = mysqli_query($GLOBALS['conn'],$query_to_get_images);
	while(list($image) = mysqli_fetch_row($rs_images))			
		print("<a href='view_fp_image.php?image=$image' target='_blank'><img style='float:left;' title='$image' src='attachment/fp/$image' border='1' width='160' height='90' alt='Image Missing' /></a>");
		//print("<div style='border-left:medium #CC0000 solid; height:300px;' />");
		
	?>
</div>
</td>
</tr>
</table>

<?php
	
	$type->retrive_id();
	$n_type = $type->getNumber_type();
	
	//Initializing firing_pattern_count with all the type ID's
	$firing_pattern_count = array();
	for($i=0; $i<$n_type ; $i++)
	{
		$t_id = $type->getID_array($i);
		$firing_pattern_count[$t_id]=NULL;
	}
	
	$parameter_list=array('delay_ms', 'pfs_ms', 'swa_mv', 'nisi', 'isiav_ms', 'sd_ms', 'max_isi_ms', 'min_isi_ms', 'first_isi_ms', 'isiav1_2_ms', 'isiav1_3_ms', 'isiav1_4_ms', 'last_isi_ms', 'isiavn_n_1_ms', 'isiavn_n_2_ms', 'isiavn_n_3_ms', 'maxisi_minisi', 'maxisin_isin_m1', 'maxisin_isin_p1', 'ai', 'rdmax', 'df', 'sf', 'tmax_scaled', 'isimax_scaled', 'isiav_scaled', 'sd_scaled', 'slope', 'intercept', 'slope1', 'intercept1', 'css_yc1', 'xc1', 'slope2', 'intercept2', 'slope3', 'intercept3', 'xc2', 'yc2', 'f1_2', 'f1_2crit', 'f2_3', 'f2_3crit', 'f3_4', 'f3_4crit', 'p1_2', 'p2_3', 'p3_4', 'p1_2uv', 'p2_3uv', 'p3_4uv', 'isii_isii_m1', 'i', 'isiav_i_n_isi1_i_m1', 'maxisij_isij_m1', 'maxisij_isij_p1', 'nisi_c', 'isiav_ms_c', 'maxisi_ms_c', 'minisi_ms_c', 'first_isi_ms_c', 'tmax_scaled_c', 'isimax_scaled_c', 'isiav_scaled_c', 'sd_scaled_c', 'slope_c', 'intercept_c', 'slope1_c', 'intercept1_c', 'css_yc1_c', 'xc1_c', 'slope2_c', 'intercept2_c', 'slope3_c', 'intercept3_c', 'xc2_c', 'yc2_c', 'f1_2_c', 'f1_2crit_c', 'f2_3_c', 'f2_3crit_c', 'f3_4_c', 'f3_4crit_c', 'p1_2_c', 'p2_3_c', 'p3_4_c', 'p1_2uv_c', 'p2_3uv_c', 'p3_4uv_c');
	$parameter_method_list=array('get_delay_ms', 'get_pfs_ms', 'get_swa_mv', 'get_nisi', 'get_isiav_ms', 'get_sd_ms', 'get_max_isi_ms', 'get_min_isi_ms', 'get_first_isi_ms', 'get_isiav1_2_ms', 'get_isiav1_3_ms', 'get_isiav1_4_ms', 'get_last_isi_ms', 'get_isiavn_n_1_ms', 'get_isiavn_n_2_ms', 'get_isiavn_n_3_ms', 'get_maxisi_minisi', 'get_maxisin_isin_m1', 'get_maxisin_isin_p1', 'get_ai', 'get_rdmax', 'get_df', 'get_sf', 'get_tmax_scaled', 'get_isimax_scaled', 'get_isiav_scaled', 'get_sd_scaled', 'get_slope', 'get_intercept', 'get_slope1', 'get_intercept1', 'get_css_yc1', 'get_xc1', 'get_slope2', 'get_intercept2', 'get_slope3', 'get_intercept3', 'get_xc2', 'get_yc2', 'get_f1_2', 'get_f1_2crit', 'get_f2_3', 'get_f2_3crit', 'get_f3_4', 'get_f3_4crit', 'get_p1_2', 'get_p2_3', 'get_p3_4', 'get_p1_2uv', 'get_p2_3uv', 'get_p3_4uv', 'get_isii_isii_m1', 'get_i', 'get_isiav_i_n_isi1_i_m1', 'get_maxisij_isij_m1', 'get_maxisij_isij_p1', 'get_nisi_c', 'get_isiav_ms_c', 'get_maxisi_ms_c', 'get_minisi_ms_c', 'get_first_isi_ms_c', 'get_tmax_scaled_c', 'get_isimax_scaled_c', 'get_isiav_scaled_c', 'get_sd_scaled_c', 'get_slope_c', 'get_intercept_c', 'get_slope1_c', 'get_intercept1_c', 'get_css_yc1_c', 'get_xc1_c', 'get_slope2_c', 'get_intercept2_c', 'get_slope3_c', 'get_intercept3_c', 'get_xc2_c', 'get_yc2_c', 'get_f1_2_c', 'get_f1_2crit_c', 'get_f2_3_c', 'get_f2_3crit_c', 'get_f3_4_c', 'get_f3_4crit_c', 'get_p1_2_c', 'get_p2_3_c', 'get_p3_4_c', 'get_p1_2uv_c', 'get_p2_3uv_c', 'get_p3_4uv_c');	
	$parameter_method_values=array();
	
	//Printing parameters
	$firingpattern->retrieve_parameter_to_show($parameter);

	
	
	$firingpattern->retrieve_by_overall_fp($parameter);
	$n_fp_id = $firingpattern->getN_id();
	
	$type_id_array = array();
	for($j=0; $j<$n_fp_id ; $j++)
	{
		$fp_id = $firingpattern->getid_array($j);
		$firingpatternrel->retrieve_by_firingPatternId($fp_id);
		$type_id = $firingpatternrel->getTypeId();
		array_push($type_id_array,$type_id);
		$firing_pattern_count[$type_id]+=1;
	}
	
	//COUNT1
	print firing_sub_table_head("Count1");
	for($k=0; $k < $n_type ; $k++)
	{
		$t_id = $type->getID_array($k);
		if($firing_pattern_count[$t_id] == 1)
		{
			$type->retrive_by_id($t_id);
			print parcel_row($type);
		}
	}
	print firing_sub_table_foot();	
	
	//COUNT2
	print firing_sub_table_head("Count2");
	for($k=0; $k < $n_type ; $k++)
	{
		$t_id = $type->getID_array($k);
		if($firing_pattern_count[$t_id] == 2)
		{
			$type->retrive_by_id($t_id);
			print parcel_row($type);
		}
	}
	print firing_sub_table_foot();
	
	//COUNT3 
	print firing_sub_table_head("Count3");
	for($k=0; $k < $n_type ; $k++)
	{
		$t_id = $type->getID_array($k);
		if($firing_pattern_count[$t_id] == 3)
		{
			$type->retrive_by_id($t_id);
			print parcel_row($type);
		}
	}
	print firing_sub_table_foot();
	
	//COUNT4 
	print firing_sub_table_head("Count4");
	for($k=0; $k < $n_type ; $k++)
	{
		$t_id = $type->getID_array($k);
		if($firing_pattern_count[$t_id] == 4)
		{
			$type->retrive_by_id($t_id);
			print parcel_row($type);
		}
	}
	print firing_sub_table_foot();
	
	
?>
		
</table>
<br/><br/><br/>
</div>
</body>
</html>

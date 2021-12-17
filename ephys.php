<?php
  include ("permission_check.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jqGrid-4/js/jquery.jqGrid.src.js" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_markers.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_ephys.php',
    success: function() {}
  }); 
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_morphology.php',
    success: function() {}
  });
  $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_connectivity.php',
    success: function() {}
  });
  $.ajax({
		type: 'GET',
		cache: false,
		contentType: 'application/json; charset=utf-8',
		url: 'load_matrix_session_firing.php',
		success: function() {}
  });
  $.ajax({
		type: 'GET',
		cache: false,
		contentType: 'application/json; charset=utf-8',
		url: 'load_matrix_session_firing_parameter.php',
		success: function() {}
  });
  $('div#menu_main_button_new_clr').css('display','block');
});
</script>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
//include ("access_db.php");
$jsonStr = $_SESSION['ephys'];
//include ("getEphys.php");
include ("function/ephys_unit_table.php");
include ("function/ephys_num_decimals_table.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.epdataevidencerel.php');
require_once('class/class.epdata.php');
require_once('class/class.temporary_result_neurons.php');


$type = new type($class_type);

$research = "";
if(isset($_REQUEST['research']))
	$research = $_REQUEST['research'];

$table_result ="";
if(isset($_REQUEST['table_result']))
	$table_result = $_REQUEST['table_result'];
	

$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

$epdataevidencerel = new epdataevidencerel($class_epdataevidencerel);

$epdata = new epdata($class_epdata);

?>


<?php include ("function/icon.html"); ?>
<title>Ephys Matrix</title>
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid.css" />
<script type="text/javascript" src="style/resolution.js"></script>
<style>
.ui-jqgrid tr.jqgrow td 
{
	height:auto !important;
	text-align:center;
}
.ui-jqgrid tr.jqgrow td:nth-child(2)
{
	height:18px !important;
	text-align:left;
}
.ui-jqgrid .ui-jqgrid-htable th div 
{
 position:relative;
 height: auto
 }

.highlighted{
	border-right: solid 1px Chartreuse !important;
	border-left: solid 1px Chartreuse !important;
	border-bottom:solid 1px Chartreuse !important; 
}
.highlighted_top{
	border: solid 1px Chartreuse !important;
}
#jqgh_nGrid_Vrest,#jqgh_nGrid_Rin,#jqgh_nGrid_Tm,#jqgh_nGrid_Vthresh,#jqgh_nGrid_FastAhp,#jqgh_nGrid_Apampl,#jqgh_nGrid_Apwidth,#jqgh_nGrid_MaxFr,#jqgh_nGrid_SlowAhp,#jqgh_nGrid_Sagratio
{
	cursor:auto;
}
.header_highlight
{
	color:#66FFFF;
}
</style>
<?php
if ($_SESSION['perm'] == NULL)
{
	$_SESSION['perm'] = 1;
?>
	<script>
	window.onload = function() 
	{ 
		if (!window.location.search) 
		{ 
			setTimeout("window.location+='?refreshed';", 0); 
		} 
	} 
	</script>
<?php
}
?>
<script type="text/javascript">
$(function(){
	var dataStr = <?php echo $jsonStr?>;
	function Merger(gridName,cellName){
		var mya = $("#" + gridName + "").getDataIDs();	
		var rowCount = mya.length;
		var rowSpanCount = 1;
		var countRows = 0;
		var lastRowDelete =0;
		var firstElement = 0;

		for(var i=0;i<=rowCount;i=i+countRows)
		{ 
			var before = $("#" + gridName + "").jqGrid('getRowData', mya[i]); // Fetch me the data for the first row
			for (j = i+1; j <=rowCount; j++) 
			{
				var end = $("#" + gridName + "").jqGrid('getRowData', mya[j]); // Fetch me the data for the next row
				if (before[cellName] == end[cellName]) // If the previous row and the next row data are the same
				{
					$("#" + gridName + "").setCell(mya[j], cellName,'&nbsp;');
					$("tr#"+j+" td#type"+j).css("border-bottom","none");
					if(rowSpanCount > 1) // For the first row Don't delete the cell and its contents
					{ 
						$("tr#"+j+" td#type"+j).css("border-bottom","none");
					}
					else
					{
						firstElement = j;
					}
					rowSpanCount++;	
                } 
                else 
                {
					$("tr#"+j).css("border-bottom", "2px red");
					countRows = rowSpanCount;
                	rowSpanCount = 1;
                	break;
                }
			}
		} 
	}
	var research = "<?php echo $research?>";
	var table = "<?php echo $table_result?>";
	
	$("#nGrid").jqGrid({
	datatype: "jsonstring",
	datastr: dataStr,
	/* url:'getEphys.php',
    datatype: 'json', 
    mtype: 'GET',
    ajaxGridOptions :{
		contentType : "application/json"
        },
    postData: {
        researchVar: research,
        table_result : table
    }, */
    colNames:['','Neuron Type','Neurite<br/>Pattern','V<sub>rest</sub><br/><small>(mV)</small>','R<sub>in</sub><br/><small>(M&Omega;)</small>','&tau;<sub>m</sub><br/><small>(ms)</small>','V<sub>thresh</sub><br/><small>(mV)</small>','Fast AHP<br/><small>(mV)</small>','AP<sub>ampl</sub><br/><small>(mV)</small>','AP<sub>width</sub><br/><small>(ms)</small>','Max F.R.<br/><small>(Hz)</small>','Slow AHP<br/><small>(mV)</small>','Sag ratio'],
    colModel :[
	  {name:'type', index:'type', width:50,sortable:false,cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'";   
      } },
      {name:'Neuron type', index:'nickname', width:175,sortable:false},
	  {name:'NeuritePattern', index:'NeuritePattern', width:80,sortable:false, hidden: true},
          //,searchoptions: {sopt: ['bw','bn','cn','in','ni','ew','en','nc']}},
      {name:'Vrest', index:'Vrest', width:75,height:130,search:false,sortable:false},
      {name:'Rin', index:'Rin', width:75,height:130,search:false,sortable:false},
      {name:'Tm', index:'Tm', width:75,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="border-right:medium solid #C08181;"';
       }
      },
      {name:'Vthresh', index:'Vthresh', width:75,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                return 'style="border-left:medium solid #770000;"';
       }
      },
      {name:'FastAhp', index:'FastAhp', width:75,height:150,search:false,sortable:false},
      {name:'Apampl', index:'Apampl', width:75,height:150,search:false,sortable:false},
      {name:'Apwidth', index:'Apwidth', width:75,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="border-right:medium solid #C08181;"';
       }
      },
      {name:'MaxFr', index:'MaxFr', width:75,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                   return 'style="border-left:medium solid #770000;"';
       }
      },
      {name:'SlowAhp', index:'SlowAhp', width:75,height:150,search:false,sortable:false},
      {name:'Sagratio', index:'CR', width:75,height:150,search:false,sortable:false}
    ], 
   	rowNum:125,
    rowList:[125],
    viewrecords: true, 
    gridview: true,
    jsonReader : {
      page: "page",
      total: "total",
      records: "records",
      root:"rows",
      repeatitems: true,
      onSelectRow: function() {
    	     return false;
    	},
      cell:"cell",
      id: "invid"
   },
    scrollerbar:true,
    height:"440",
    width:"85%",
    gridComplete: function () {
    	var gridName = "nGrid"; // Access the grid Name
    	Merger(gridName,"type");
		HideShowColumns();
		}  
    });
	
	$("#jqgh_nGrid_Vrest").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Vrest").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Rin").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Rin").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});
	
	$("#jqgh_nGrid_Tm").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Tm").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Vthresh").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Vthresh").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_FastAhp").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_FastAhp").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Apampl").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Apampl").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Apwidth").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Apwidth").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_MaxFr").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_MaxFr").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Vrest").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Vrest").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_SlowAhp").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_SlowAhp").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});

	$("#jqgh_nGrid_Sagratio").mouseover(function(e) {
		$(this).addClass('header_highlight');
	}); 
	$("#jqgh_nGrid_Sagratio").mouseout(function(e) {
		$(this).removeClass('header_highlight');
	});
	
	var cm = $("#nGrid").jqGrid('getGridParam', 'colModel');

	$("#nGrid").mouseover(function(e) {

		var count = $("#nGrid").jqGrid('getGridParam', 'records') + 1;
	    var $td = $(e.target).closest('td'), $tr = $td.closest('tr.jqgrow'),
	        rowId = $tr.attr('id');
	    
	   	if (rowId) {
	        var ci = $.jgrid.getCellIndex($td[0]); // works mostly as $td[0].cellIndex
			$row = "#"+rowId+" td"; 
			$($row).addClass('highlighted_top');

			/* for(var i=0;i<count;i++)
			{
				$colSelected = "tr#"+i+" td:eq("+ci+")";
				$($colSelected).addClass('highlighted');
				
			}  */
		}
		});
		
		$("#nGrid").mouseout(function(e) {
			var count = $("#nGrid").jqGrid('getGridParam', 'records') + 1;
	    	var $td = $(e.target).closest('td'), $tr = $td.closest('tr.jqgrow'),
	        	rowId = $tr.attr('id'), ci;
	   		if (rowId) {
	        ci = $.jgrid.getCellIndex($td[0]); // works mostly as $td[0].cellIndex
	        	$row = "#"+rowId+" td";  
				$($row).removeClass('highlighted_top');
				/* for(var i=0;i<count;i++)
				{
					$colSelected = "tr#"+i+" td:eq("+ci+")";
					$($colSelected).removeClass('highlighted');
				}  */
			}
		}); 
});
function HideShowColumns ()
{
	var myGrid = $("#nGrid");
	$("#checkbox1").click(function() {
		if ($("#checkbox1").is(':checked')) {
			myGrid.jqGrid('showCol', ["NeuritePattern"]);
		}
		else {
			myGrid.jqGrid('setGridParam', {shrinkToFit: true});
			myGrid.jqGrid('setGridParam', {scrollerbar: false});
			myGrid.jqGrid('hideCol', ["NeuritePattern"]);
		}
	});
}
</script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
		
<div class='title_area'>
	<form id="myform">
		<font class="font1">Browse electrophysiology matrix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>       
		<input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="checkbox1"><span style="color: rgb(0, 0, 153);">Neurite Patterns&nbsp;&nbsp;</span></input>
	</form>
</div>

<!--  submenu no tabs
<div class='sub_menu'>
	<?php
		if ($research);
		else
		{
	?>
			<table width="90%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%" align="left">
					<font class='font1'><em>Matrix:</em></font> &nbsp; &nbsp; 
					<a href='morphology.php'><font class="font7">Morphology</font> <font class="font7_A">|</font> 
					<a href='markers.php'><font class="font7"> Markers</font> </a> <font class="font7_A">|</font> 
					<font class="font7_B">Electrophysiology</font> <font class="font7_A">|</font> 
					<a href='connectivity.php'><font class="font7"> Connectivity</font></a>
					</font>	
				</td>
			</tr>
			</table>
	<?php
		}
	?>		
</div>
-->
<!-- ------------------------ -->

<div class="table_position">
<table border="0" cellspacing="0" cellpadding="0" class="tabellauno">
	<tr>
 		<td>
		  	<table id="nGrid"></table>
			<div id="pager"></div>	
		</td>
	</tr>
</table>		
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr>
    <td>
		<!-- ****************  BODY **************** -->
		<?php 
			if ($research){
				$full_search_string = $_SESSION['full_search_string'];
				if ($number_type == 1)
					print ("<font class='font3'> $number_type Result  [$full_search_string]</font>");
				else
					print ("<font class='font3'> $number_type Results  [$full_search_string]</font>");			
			}
		?>
		<font class='font5'><strong>Legend:</strong> </font>&nbsp;
		<font face="Verdana, Arial, Helvetica, sans-serif" color="#339900" size="2"> +/green: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Excitatory</font>
		&nbsp; &nbsp; 
		<font face="Verdana, Arial, Helvetica, sans-serif" color="#CC0000" size="2"> -/red: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Inhibitory</font>
		<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<font class='font5'>Values are selected from the source with the greatest number of measurements taken at preferred experimental conditions (rats, patch clamp, & body temperature, when available).</font>
		<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<font class='font5'>Hover over a value for standard deviation, experimental conditions, number of measurements, and number of sources.</font>
		<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<font class='font5'>Pale versions of the colors in the matrix indicate interpretations of neuronal property information that have not yet been fully verified.</font>
	</td>
  </tr>
</table>
</div>
</body>
</html>

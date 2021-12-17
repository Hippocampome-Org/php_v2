<?php
  include ("permission_check.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
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
$jsonStr = $_SESSION['firingpatternparameter'];

require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.temporary_result_neurons.php');

// view firing pattern matrix for selected dropdown
if($_REQUEST['show_only'])
	$indexFP = $_REQUEST['show_only'];
else
	$indexFP = 0;

$type = new type($class_type);

$research = "";
if(isset($_REQUEST['research']))
	$research = $_REQUEST['research'];

$table_result ="";
if(isset($_REQUEST['table_result']))
	$table_result = $_REQUEST['table_result'];
	

$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);


?>


<?php include ("function/icon.html"); ?>
<title>Firing Pattern Parameter Matrix</title>
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
.ui-jqgrid-hdiv {
	overflow-y: hidden !important;
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
function show_only(link)
{
	var value=link[link.selectedIndex].value;
	var destination_page = "firing_patterns_parameters.php";
	location.href = destination_page+"?show_only="+value;
}
$(function(){
	var indexFP=<?php echo $indexFP?>;
	var dataStrPHP = <?php echo $jsonStr?>;
	var objJson={};
	// only get firing pattern matrix for selected dropdown
	objJson["page"] = 0;
	objJson["total"] = 0;
	objJson["records"] = null;
	objJson["rows"] = dataStrPHP.rows[indexFP].data;
	var dataStr=JSON.stringify(objJson);
	var value=dataStrPHP.header[indexFP];
	var columnNames=['','Neuron Type'];
	var columnHeader=[
	  {name:'type', index:'type', width:50,sortable:false,frozen: true,cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'";   
      } },
      {name:'Neuron type', index:'nickname', width:175,sortable:false,frozen: true},
    ];
    for( var index=0;index<value.length;index++){
    	var headers={};
    	headers["name"]=index;
    	headers["index"]=index;
    	headers["height"]=150;
    	headers["search"]=false;
    	headers["sortable"]=false;
    	columnNames.push(value[index]);
    	columnHeader.push(headers);
    }
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
    colNames:columnNames,
    colModel :columnHeader, 
   	rowNum:122,
    rowList:[122],
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
    width: "1150",
    shrinkToFit: false,
    gridComplete: function () {
    	var gridName = "nGrid"; // Access the grid Name
    	Merger(gridName,"type");
		}  
    });
	for(index=0;index<value.length;index++){
		$("#jqgh_nGrid_"+index).mouseover(function(e) {
			$(this).addClass('header_highlight');
		}); 
		$("#jqgh_nGrid_"+index).mouseout(function(e) {
			$(this).removeClass('header_highlight');
		});
	}
	
	
	
	var cm = $("#nGrid").jqGrid('getGridParam', 'colModel');

	$("#nGrid").mouseover(function(e) {

		var count = $("#nGrid").jqGrid('getGridParam', 'records') + 1;
	    var $td = $(e.target).closest('td'), $tr = $td.closest('tr.jqgrow'),
	        rowId = $tr.attr('id');
	    
	   	if (rowId) {
	        var ci = $.jgrid.getCellIndex($td[0]); // works mostly as $td[0].cellIndex
			$row = "#"+rowId+" td"; 
			$($row).addClass('highlighted_top');

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
		}
	}); 
	jQuery("#nGrid").jqGrid("setFrozenColumns");
});

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
		<font class="font1">Browse firing pattern parameters matrix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>       
		<span style="color: rgb(0, 0, 153);">Firing Pattern:</span>
		<?php
			print ("<select  name='check1'  onChange=\"show_only(this)\">");
			$hippo = array("ASP.", "ASP.ASP.", "ASP.NASP", "ASP.SLN", "D.", "D.ASP.", "D.FASP.NASP", "D.NASP.", "D.PSTUT", "D.TSWB.NASP", "FASP.", "FASP.ASP.", "FASP.NASP", "FASP.SLN", "NASP", "PSTUT", "PSWB", "TSTUT.", "TSTUT.ASP.", "TSTUT.NASP", "TSTUT.SLN", "TSWB.NASP", "TSWB.SLN");
			if($indexFP!=0){
				print("<option value='".$indexFP."'>".$hippo[$indexFP]."</option>");
			}
			for($i=0;$i<count($hippo);$i++){
				print("<option value='".$i."'>".$hippo[$i]."</option>");
			}
		?>
		</select>
	</form>
</div>


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
	</td>
  </tr>
</table>
</div>
</body>
</html>

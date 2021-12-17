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
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>
<?php
if($_SESSION['check']=="no_reload")
	$_SESSION['check']='reload';
include ("getFiringPatterns.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.temporary_result_neurons.php');
$research = $_REQUEST['research'];
$width1='25%';
$width2='2%';
include ("function/icon.html");
?>
<title>Firing Pattern Matrix</title>
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid.css" />
<style>
#nGrid_PV,#nGrid_vGluT3,#nGrid_NG,#nGrid_RLN
{
	border-right:medium solid #000099;
}
.frozen-div #nGrid_type {
	height: 150px !important;
}
#ca3_subregion,#dg_subregion,#ec_subregion
{
	color:#000099 !important;
}
#ca2_subregion,#ca1_subregion,#sub_subregion
{
	color:#000099 !important;
}
.ui-jqgrid tr.jqgrow td
{
	height:18px !important;
}

.highlighted{
	border-right: solid 1px Chartreuse !important;
	border-left: solid 1px Chartreuse !important;
	border-bottom:solid 1px Chartreuse !important; 
}
.highlighted_top{
	border: solid 1px Chartreuse !important;
}
.expand{
	top:85px
}
.rotate 
{
	-webkit-transform: rotate(-90deg); /* Safari 3.1+, Chrome */
	-moz-transform: rotate(-90deg); /* Firefox 3.5+ */
	-o-transform: rotate(-90deg); /* Opera starting with 10.50 */
	/* Internet Explorer: */
	-ms-transform: rotate(-90deg);
	top: 55px; !important;
	left:3px;
	font-size:12px;
	font-weight:bold;
	padding:0 0 0 5.5px;
	font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
}
.rotateIE9 
{
	-webkit-transform: rotate(-90deg); /* Safari 3.1+, Chrome */
	-moz-transform: rotate(-90deg); /* Firefox 3.5+ */
	-o-transform: rotate(-90deg); /* Opera starting with 10.50 */
	/* Internet Explorer: */
	-ms-transform: rotate(-90deg);
	top:25px;
	left:3px; 
	font-size:12px;
	font-weight:bold;
	padding:0 0 0 4px;
	font:Verdana;
}
#jqgh_nGrid_NeuritePattern {
	text-align: right;
	padding-left: 4px;
}

.patternHeight {
	top: 48.5px !important;
}  
.title_area_marker {
	position:absolute; top: 80px; left: 50px;
	width: 700px;
	border:none;
}
 .expandChrome {
	top: 93px !important;
	}
.expandOther {
	top: 105px !important;
}
.expandIE9 {
	top: 85px !important;
}
.expandIEOther {
	top: 97px !important;
}
.ui-jqgrid-hdiv {
	overflow-y: hidden !important;
}
.legendClass{
	height:80%; 
	width:5%;
	border-top:1px solid white;
	border-bottom:1px solid white;
	border-right:6px solid white;
	border-left:6px solid white;
}
</style>
<script language="javascript">
function OpenInNewTab(aEle)
{
	//var win = window.open(aEle.href,'_self'); // stay in same tab
	var win = window.open(aEle.href,'_blank'); // open in new tab
	win.focus();
}
function ctr(select_nick_name2, color, select_nick_name_check)
{
	if (document.getElementById(select_nick_name_check).checked == false)
	{	
		document.getElementById(select_nick_name2).bgColor = "#FFFFFF";
	}
	else if (document.getElementById(select_nick_name_check).checked == true)
	{	
		document.getElementById(select_nick_name2).bgColor = "#EBF283";	
	}
}
function getIEVersion()
{
	var rv = -1; // Return value assumes failure.
	if (navigator.appName == 'Microsoft Internet Explorer')
	{
		var ua = navigator.userAgent;
		var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.test(ua) != null)
		{
			rv = parseFloat( RegExp.$1 );
		}
	}
	return rv;
}
function checkVersion() {
	var ver = getIEVersion();
	return ver;
}
checkVersion();
</script>
<script type="text/javascript">
$(function()
{
	var dataStr = <?php echo json_encode($responce)?>;
	function Merger(gridName,cellName)
	{
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
	var table = "<?php if(isset($_REQUEST['table_result'])){echo $_REQUEST['table_result'];}?>";
	
	$("#nGrid").jqGrid(
	{
		datatype: "jsonstring",
		datastr: dataStr,
		mtype: 'GET',
		postData: {
			researchVar: research,
			table_result : table
		},
		colNames:['','Neuron Type','<a href="neuron_by_pattern.php?pattern=ASP." onClick="OpenInNewTab(this);">ASP.</a>','<a href="neuron_by_pattern.php?pattern=ASP.ASP." onClick="OpenInNewTab(this);">ASP.ASP.</a>','<a href="neuron_by_pattern.php?pattern=ASP.NASP" onClick="OpenInNewTab(this);">ASP.NASP</a>','<a href="neuron_by_pattern.php?pattern=ASP.SLN" onClick="OpenInNewTab(this);">ASP.SLN</a>','<a href="neuron_by_pattern.php?pattern=D." onClick="OpenInNewTab(this);">D.</a>','<a href="neuron_by_pattern.php?pattern=D.ASP." onClick="OpenInNewTab(this);">D.ASP.</a>','<a href="neuron_by_pattern.php?pattern=D.RASP.NASP" onClick="OpenInNewTab(this);">D.RASP.NASP</a>','<a href="neuron_by_pattern.php?pattern=D.NASP" onClick="OpenInNewTab(this);">D.NASP</a>','<a href="neuron_by_pattern.php?pattern=D.PSTUT" onClick="OpenInNewTab(this);">D.PSTUT</a>','<a href="neuron_by_pattern.php?pattern=D.TSWB.NASP" onClick="OpenInNewTab(this);">D.TSWB.NASP</a>','<a href="neuron_by_pattern.php?pattern=RASP." onClick="OpenInNewTab(this);">RASP.</a>','<a href="neuron_by_pattern.php?pattern=RASP.ASP." onClick="OpenInNewTab(this);">RASP.ASP.</a>','<a href="neuron_by_pattern.php?pattern=RASP.NASP" onClick="OpenInNewTab(this);">RASP.NASP</a>','<a href="neuron_by_pattern.php?pattern=RASP.SLN" onClick="OpenInNewTab(this);">RASP.SLN</a>','<a href="neuron_by_pattern.php?pattern=NASP" onClick="OpenInNewTab(this);">NASP</a>','<a href="neuron_by_pattern.php?pattern=PSTUT" onClick="OpenInNewTab(this);">PSTUT</a>','<a href="neuron_by_pattern.php?pattern=PSWB" onClick="OpenInNewTab(this);">PSWB</a>','<a href="neuron_by_pattern.php?pattern=TSTUT." onClick="OpenInNewTab(this);">TSTUT.</a>','<a href="neuron_by_pattern.php?pattern=TSTUT.ASP." onClick="OpenInNewTab(this);">TSTUT.ASP.</a>','<a href="neuron_by_pattern.php?pattern=TSTUT.NASP" onClick="OpenInNewTab(this);">TSTUT.NASP</a>','<a href="neuron_by_pattern.php?pattern=TSTUT.SLN" onClick="OpenInNewTab(this);">TSTUT.SLN</a>','<a href="neuron_by_pattern.php?pattern=TSWB.NASP" onClick="OpenInNewTab(this);">TSWB.NASP</a>','<a href="neuron_by_pattern.php?pattern=TSWB.SLN" onClick="OpenInNewTab(this);">TSWB.SLN</a>'],	
		colModel :
		[
			{name:'type', index:'type', width:50,sortable:false,cellattr: function (rowId, tv, rawObject, cm, rdata) {return 'id=\'type' + rowId + "\'";}},
			{name:'NeuronType', index:'nickname', width:250,sortable:false},
			{name:'ASP', index:'ASP', width:15,height:50,search:false,sortable:false},
			{name:'ASPASP', index:'ASPASP', width:15,height:50,search:false,sortable:false},
			{name:'ASPNASP', index:'ASPNASP', width:15,height:50,search:false,sortable:false},
			{name:'ASPSLN', index:'ASPSLN', width:15,height:50,search:false,sortable:false},
			{name:'D', index:'D', width:15,height:50,search:false,sortable:false},
			{name:'DASP', index:'DASP', width:15,height:50,search:false,sortable:false},
			{name:'DRASPNASP', index:'DRASPNASP', width:15,height:50,search:false,sortable:false},
			{name:'DNASP', index:'DNASP', width:15,height:50,search:false,sortable:false},
			{name:'DPSTUT', index:'DPSTUT', width:15,height:50,search:false,sortable:false},
			{name:'DTSWBNASP', index:'DTSWBNASP', width:15,height:50,search:false,sortable:false},
			{name:'RASP', index:'RASP', width:15,height:50,search:false,sortable:false},
			{name:'RASPASP', index:'RASPASP', width:15,height:50,search:false,sortable:false},
			{name:'RASPNASP', index:'RASPNASP', width:15,height:50,search:false,sortable:false},
			{name:'RASPSLN', index:'RASPSLN', width:15,height:50,search:false,sortable:false},
			{name:'NASP', index:'NASP', width:15,height:50,search:false,sortable:false},
			{name:'PSTUT', index:'PSTUT', width:15,height:50,search:false,sortable:false},
			{name:'PSWB', index:'PSWB', width:15,height:50,search:false,sortable:false},
			{name:'TSTUT', index:'TSTUT', width:15,height:50,search:false,sortable:false},
			{name:'TSTUTASP', index:'TSTUTASP', width:15,height:50,search:false,sortable:false},
			{name:'TSTUTNASP', index:'TSTUTNASP', width:15,height:50,search:false,sortable:false},
			{name:'TSTUTSLN', index:'TSTUTSLN', width:15,height:50,search:false,sortable:false},
			{name:'TSWBNASP', index:'TSWBNASP', width:15,height:50,search:false,sortable:false},
			{name:'TSWBSLN', index:'TSWBSLN', width:15,height:50,search:false,sortable:false}
			], 
		rowNum: 125,
		rowList:[125],
		viewrecords: true, 
		gridview: true,
		jsonReader:
		{
			page: "page",
			total: "total",
			records: "records",
			root: "rows",
			repeatitems: true,
			onSelectRow: function() {return false;},
			cell: "cell",
			id: "invid"
		},
		scrollerbar: false,
		height: "402",
		width: "705",
		shrinkToFit: true,
		gridComplete: function ()
		{
			var gridName = "nGrid"; // Access the grid Name
			Merger(gridName,"type");
		//	HideShowColumns();
		} 
	});
	
	if(checkVersion()=="9")
	{
		var myGrid = $('#nGrid');
		var colModelVal = $("#nGrid").jqGrid('getGridParam','colModel');
		var colModelName = "";
		for(var i=2;i<25;i++)
		{
			colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
			$(colModelName).addClass("rotateIE9");
		} 
	}
	else
	{
		var myGrid = $('#nGrid');
		var colModelVal = $("#nGrid").jqGrid('getGridParam','colModel');
		var colModelName = "";
		var htmlAttri =  "top: 105px !important";
		for(var i=2;i<25;i++)
		{
			colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
			$(colModelName).addClass("rotate");
		}
		//var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
		//var is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;
		//var is_ietrident = navigator.userAgent.toLowerCase().indexOf('trident') > -1;
		//var is_ieedge = navigator.userAgent.toLowerCase().indexOf('edge') > -1;
		
	}
	$("#nGrid_TSTUTNASP").css("height","120");
	$("#nGrid_TSTUTSLN").css("height","120");
	var cm = $("#nGrid").jqGrid('getGridParam', 'colModel');
	$("#nGrid").mouseover(function(e)
	{
		var count = $("#nGrid").jqGrid('getGridParam', 'records') + 1;
		var $td = $(e.target).closest('td'), $tr = $td.closest('tr.jqgrow'), rowId = $tr.attr('id');
		if (rowId)
		{
			var ci = $.jgrid.getCellIndex($td[0]); // works mostly as $td[0].cellIndex
			$row = "#"+rowId+" td"; 
			$($row).addClass('highlighted_top');
		}
	});
	$("#nGrid").mouseout(function(e)
	{
		var count = $("#nGrid").jqGrid('getGridParam', 'records') + 1;
		var $td = $(e.target).closest('td'), $tr = $td.closest('tr.jqgrow'), rowId = $tr.attr('id'), ci;
		if (rowId)
		{
			ci = $.jgrid.getCellIndex($td[0]); // works mostly as $td[0].cellIndex
			$row = "#"+rowId+" td";  
			$($row).removeClass('highlighted_top');
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
<div class="title_area_marker">   
      <font class="font1">Browse Firing Pattern Matrix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>       
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

<table width="50%" border="0" cellspacing="0" class='body_table' style="border-width:10px; border-color:white">
	<tr>
		<td><font class='font5' style="width=20%;"><strong>Legend:</strong></font></td>
		<td><font class='font5' style="width=40%"># of pattern occurences in reference(s)</font></td>
		
		<td bgcolor="#FF8C00" class='legendClass'><font color="#FF8C00"> </font></td>
		<td style="height:100%; width:5%;"><font class='font5'>1</font></td>
		
		<td bgcolor="#0000FF" class='legendClass'><font color="#0000FF"> </font></td>
		<td style="height:100%; width:5%;"><font class='font5'>2</font></td>
		
		<td bgcolor="#7A5230" class='legendClass'><font color="#7A5230"> </font></td>
		<td style="height:100%; width:5%;"><font class='font5'>3</font></td>
	
		<td bgcolor="#808080" class='legendClass'><font color="#808080"> </font></td>
		<td style="height:100%; width:5%;"><font class='font5'>4</font></td>	
	</tr>
</table>
</div>
</body>
</html>

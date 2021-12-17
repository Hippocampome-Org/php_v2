<?php
include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include ("getMarkers.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.temporary_result_neurons.php');
$width1='25%';
$width2='2%';
$research = "";
$table_result = "";
if(isset($_REQUEST['research']))
	$research = $_REQUEST['research'];
if(isset($_REQUEST['table_result']))
	$table_result = $_REQUEST['table_result'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Molecular Markers Matrix</title>
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid.css" />
<?php
$query = "SELECT permission FROM user WHERE id=2"; // id=2 is anonymous user
$rs = mysqli_query($conn,$query);
list($permission) = mysqli_fetch_row($rs);
?>
<style>
#nGrid_PV,#nGrid_vGluT3,#nGrid_VIP,#nGrid_RLN
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
.rotate
{
	-webkit-transform: rotate(-90deg); /* Safari 3.1+, Chrome */
	-moz-transform: rotate(-90deg); /* Firefox 3.5+ */
	-o-transform: rotate(-90deg); /* Opera starting with 10.50 */
	/* Internet Explorer: */
	-ms-transform: rotate(-90deg);
	top: 65px; !important;
	left:3px;
	font-size:12px;
	font-weight:bold;
	padding:0 0 0 5.5px;
	font:Verdana;
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

#jqgh_nGrid_NeuronType{
	text-align: center;
	padding-bottom: 60px;
}


.patternHeight {
	top: 48.5px !important;
}
.title_area_marker {
	position:absolute; top: 80px; left: 55px;
	width: 900px;
	border:none;
}
 .expandChrome {
	top: 98px !important;
	}
.expandOther {
	top: 99px !important;
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
</style>
<script language="javascript">
function OpenInNewTab(aEle)
{
	var win = window.open(aEle.href,'_blank');
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
			rv = parseFloat( RegExp.$1 );
	}
	return rv;
}
function checkVersion()
{
	var ver = getIEVersion();
	return ver;
}
checkVersion();
</script>
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>
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
	var table = "<?php echo $table_result?>";


	//Get the names of headers from session
  	var values=dataStr.header;

	//Replacing null values with the key
	$.each(values, function(key,value){
    	if(value==null){
        values[key]=key;
    	}

	});


	//pushing the header names in an array colNames
 	var colName=['','Neuron Type','Neurite<br>Pattern'];

	$.each(values, function(key,value){

		if(key=="Gaba-a-alpha")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;1</a>');
		}
		else if(key=="alpha-actinin-2")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">&alpha;-act2</a>');
		}
		else if(key=="GABAa \\delta")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &delta;</a>');
		}
		else if(key=="GABAa\\alpha 2")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;2</a>');
		}
		else if(key=="GABAa\\alpha 3")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;3</a>');
		}
		else if(key=="GABAa\\alpha 4")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;4</a>');
		}
		else if(key=="GABAa\\alpha 5")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;5</a>');
		}
		else if(key=="GABAa\\alpha 6")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &alpha;6</a>');
		}
		else if(key=="GABAa\\beta 1")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &beta;1</a>');
		}
		else if(key=="GABAa\\beta 2")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &beta;2</a>');
		}
		else if(key=="GABAa\\beta 3")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &beta;3</a>');
		}
		else if(key=="GABAa\\gamma 1")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &gamma;1</a>');
		}
		else if(key=="GABAa\\gamma 2")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAa &gamma;2</a>');
		}
		else if(key=="GABA-B1")
		{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">GABAb 1</a>');
		}
		else if(key=="5HT_3")
		{
			colName.push('<a href="neuron_by_marker.php?marker=5HT-3" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alfa")
		{
			colName.push('<a href="neuron_by_marker.php?marker=Gaba-a-alpha" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="Sub_P_Rec")
		{
			colName.push('<a href="neuron_by_marker.php?marker=Sub P Rec" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="a-act2")
		{
			colName.push('<a href="neuron_by_marker.php?marker=alpha-actinin-2" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="CoupTF_2")
		{
			colName.push('<a href="neuron_by_marker.php?marker=CoupTF II" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alpha2")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\alpha 2" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alpha3")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\alpha 3" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alpha4")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\alpha 4" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alpha5")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\alpha 5" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_alpha6")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\alpha 6" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_beta1")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\beta 1" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_beta2")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\beta 2" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_beta3")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\beta 3" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_delta")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa \\delta" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_gamma1")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\gamma 1" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GABAa_gamma2")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GABAa\\gamma 2" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GAT_1")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GAT-1" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="GluA2_3")
		{
			colName.push('<a href="neuron_by_marker.php?marker=GluA2/3" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="Kv3_1")
		{
			colName.push('<a href="neuron_by_marker.php?marker=Kv3.1" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else if(key=="mGluR2_3")
		{
			colName.push('<a href="neuron_by_marker.php?marker=mGluR2/3" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
		else{
			colName.push('<a href="neuron_by_marker.php?marker='+key+'" onClick="OpenInNewTab(this);" title="'+value+'">'+key+'</a>');
		}
	});


	$("#nGrid").jqGrid(
	{
		datatype: "jsonstring",
		datastr: dataStr,
		mtype: 'GET',
		postData:
		{
			researchVar: research,
			table_result : table
		},
		colNames: colName,
		/*colNames:['','Neuron Type','Neurite<br>Pattern','<a href="neuron_by_marker.php?marker=CB" onClick="OpenInNewTab(this);">CB</a>','<a href="neuron_by_marker.php?marker=CR" onClick="OpenInNewTab(this);">CR</a>','<a href="neuron_by_marker.php?marker=PV" onClick="OpenInNewTab(this);">PV</a>','<a href="neuron_by_marker.php?marker=5HT-3" onClick="OpenInNewTab(this);">5HT-3</a>','<a href="neuron_by_marker.php?marker=CB1" onClick="OpenInNewTab(this);">CB1</a>','<a href="neuron_by_marker.php?marker=Gaba-a-alpha" onClick="OpenInNewTab(this);">GABAa &alpha;1</a>','<a href="neuron_by_marker.php?marker=mGluR1a" onClick="OpenInNewTab(this);">mGluR1a</a>','<a href="neuron_by_marker.php?marker=Mus2R" onClick="OpenInNewTab(this);">Mus2R</a>','<a href="neuron_by_marker.php?marker=Sub P Rec" onClick="OpenInNewTab(this);">Sub P Rec</a>','<a href="neuron_by_marker.php?marker=vGluT3" onClick="OpenInNewTab(this);">vGluT3</a>','<a href="neuron_by_marker.php?marker=CCK" onClick="OpenInNewTab(this);">CCK</a>','<a href="neuron_by_marker.php?marker=ENK" onClick="OpenInNewTab(this);">ENK</a>','<a href="neuron_by_marker.php?marker=NG" onClick="OpenInNewTab(this);">NG</a>','<a href="neuron_by_marker.php?marker=NPY" onClick="OpenInNewTab(this);">NPY</a>','<a href="neuron_by_marker.php?marker=SOM" onClick="OpenInNewTab(this);">SOM</a>','<a href="neuron_by_marker.php?marker=VIP" onClick="OpenInNewTab(this);">VIP</a>','<a href="neuron_by_marker.php?marker=alpha-actinin-2" onClick="OpenInNewTab(this);">&alpha;-act2</a>','<a href="neuron_by_marker.php?marker=CoupTF II" onClick="OpenInNewTab(this);">CoupTF II</a>','<a href="neuron_by_marker.php?marker=nNOS" onClick="OpenInNewTab(this);">nNOS</a>','<a href="neuron_by_marker.php?marker=RLN" onClick="OpenInNewTab(this);">RLN</a>','<a href="neuron_by_marker.php?marker=AChE" onClick="OpenInNewTab(this);">AChE</a>','<a href="neuron_by_marker.php?marker=AMIGO2" onClick="OpenInNewTab(this);">AMIGO2</a>','<a href="neuron_by_marker.php?marker=AR-beta1" onClick="OpenInNewTab(this);">AR-beta1</a>','<a href="neuron_by_marker.php?marker=AR-beta2" onClick="OpenInNewTab(this);">AR-beta2</a>','<a href="neuron_by_marker.php?marker=BDNF" onClick="OpenInNewTab(this);">BDNF</a>','<a href="neuron_by_marker.php?marker=Bok" onClick="OpenInNewTab(this);">Bok</a>','<a href="neuron_by_marker.php?marker=Caln" onClick="OpenInNewTab(this);">Caln</a>','<a href="neuron_by_marker.php?marker=CaM" onClick="OpenInNewTab(this);">CaM</a>','<a href="neuron_by_marker.php?marker=CGRP" onClick="OpenInNewTab(this);">CGRP</a>','<a href="neuron_by_marker.php?marker=ChAT" onClick="OpenInNewTab(this);">ChAT</a>','<a href="neuron_by_marker.php?marker=Chrna2" onClick="OpenInNewTab(this);">Chrna2</a>','<a href="neuron_by_marker.php?marker=CRF" onClick="OpenInNewTab(this);">CRF</a>','<a href="neuron_by_marker.php?marker=Ctip2" onClick="OpenInNewTab(this);">Ctip2</a>','<a href="neuron_by_marker.php?marker=Cx36" onClick="OpenInNewTab(this);">Cx36</a>','<a href="neuron_by_marker.php?marker=CXCR4" onClick="OpenInNewTab(this);">CXCR4</a>','<a href="neuron_by_marker.php?marker=Disc1" onClick="OpenInNewTab(this);">Disc1</a>','<a href="neuron_by_marker.php?marker=DYN" onClick="OpenInNewTab(this);">DYN</a>','<a href="neuron_by_marker.php?marker=EAAT3" onClick="OpenInNewTab(this);">EAAT3</a>','<a href="neuron_by_marker.php?marker=ErbB4" onClick="OpenInNewTab(this);">ErbB4</a>','<a href="neuron_by_marker.php?marker=GABAa\\alpha 2" onClick="OpenInNewTab(this);">GABAa &alpha;2</a>','<a href="neuron_by_marker.php?marker=GABAa\\alpha 3" onClick="OpenInNewTab(this);">GABAa &alpha;3</a>','<a href="neuron_by_marker.php?marker=GABAa\\alpha 4" onClick="OpenInNewTab(this);">GABAa &alpha;4</a>','<a href="neuron_by_marker.php?marker=GABAa\\alpha 5" onClick="OpenInNewTab(this);">GABAa &alpha;5</a>','<a href="neuron_by_marker.php?marker=GABAa\\alpha 6" onClick="OpenInNewTab(this);">GABAa &alpha;6</a>','<a href="neuron_by_marker.php?marker=GABAa\\beta 1" onClick="OpenInNewTab(this);">GABAa &beta;1</a>','<a href="neuron_by_marker.php?marker=GABAa\\beta 2" onClick="OpenInNewTab(this);">GABAa &beta;2</a>','<a href="neuron_by_marker.php?marker=GABAa\\beta 3" onClick="OpenInNewTab(this);">GABAa &beta;3</a>','<a href="neuron_by_marker.php?marker=GABAa \\delta" onClick="OpenInNewTab(this);">GABAa &delta;</a>','<a href="neuron_by_marker.php?marker=GABAa\\gamma 1" onClick="OpenInNewTab(this);">GABAa &gamma;1</a>','<a href="neuron_by_marker.php?marker=GABAa\\gamma 2" onClick="OpenInNewTab(this);">GABAa &gamma;2</a>','<a href="neuron_by_marker.php?marker=GABA-B1" onClick="OpenInNewTab(this);">GABAb 1</a>','<a href="neuron_by_marker.php?marker=GAT-1" onClick="OpenInNewTab(this);">GAT-1</a>','<a href="neuron_by_marker.php?marker=GAT-3" onClick="OpenInNewTab(this);">GAT-3</a>','<a href="neuron_by_marker.php?marker=GluA1" onClick="OpenInNewTab(this);">GluA1</a>','<a href="neuron_by_marker.php?marker=GluA2" onClick="OpenInNewTab(this);">GluA2</a>','<a href="neuron_by_marker.php?marker=GluA2/3" onClick="OpenInNewTab(this);">GluA2/3</a>','<a href="neuron_by_marker.php?marker=GluA3" onClick="OpenInNewTab(this);">GluA3</a>','<a href="neuron_by_marker.php?marker=GluA4" onClick="OpenInNewTab(this);">GluA4</a>','<a href="neuron_by_marker.php?marker=GlyT2" onClick="OpenInNewTab(this);">GlyT2</a>','<a href="neuron_by_marker.php?marker=Id-2" onClick="OpenInNewTab(this);">Id-2</a>','<a href="neuron_by_marker.php?marker=Kv3.1" onClick="OpenInNewTab(this);">Kv3.1</a>','<a href="neuron_by_marker.php?marker=Man1a" onClick="OpenInNewTab(this);">Man1a</a>','<a href="neuron_by_marker.php?marker=Math-2" onClick="OpenInNewTab(this);">Math-2</a>','<a href="neuron_by_marker.php?marker=mGluR1" onClick="OpenInNewTab(this);">mGluR1</a>','<a href="neuron_by_marker.php?marker=mGluR2" onClick="OpenInNewTab(this);">mGluR2</a>','<a href="neuron_by_marker.php?marker=mGluR2/3" onClick="OpenInNewTab(this);">mGluR2/3</a>','<a href="neuron_by_marker.php?marker=mGluR3" onClick="OpenInNewTab(this);">mGluR3</a>','<a href="neuron_by_marker.php?marker=mGluR4" onClick="OpenInNewTab(this);">mGluR4</a>','<a href="neuron_by_marker.php?marker=mGluR5" onClick="OpenInNewTab(this);">mGluR5</a>','<a href="neuron_by_marker.php?marker=mGluR5a" onClick="OpenInNewTab(this);">mGluR5a</a>','<a href="neuron_by_marker.php?marker=mGluR7a" onClick="OpenInNewTab(this);">mGluR7a</a>','<a href="neuron_by_marker.php?marker=mGluR8a" onClick="OpenInNewTab(this);">mGluR8a</a>','<a href="neuron_by_marker.php?marker=MOR" onClick="OpenInNewTab(this);">MOR</a>','<a href="neuron_by_marker.php?marker=Mus1R" onClick="OpenInNewTab(this);">Mus1R</a>','<a href="neuron_by_marker.php?marker=Mus3R" onClick="OpenInNewTab(this);">Mus3R</a>','<a href="neuron_by_marker.php?marker=Mus4R" onClick="OpenInNewTab(this);">Mus4R</a>','<a href="neuron_by_marker.php?marker=NECAB1" onClick="OpenInNewTab(this);">NECAB1</a>','<a href="neuron_by_marker.php?marker=Neuropilin2" onClick="OpenInNewTab(this);">Neuropilin2</a>','<a href="neuron_by_marker.php?marker=NKB" onClick="OpenInNewTab(this);">NKB</a>','<a href="neuron_by_marker.php?marker=p-CREB" onClick="OpenInNewTab(this);">p-CREB</a>','<a href="neuron_by_marker.php?marker=PCP4" onClick="OpenInNewTab(this);">PCP4</a>','<a href="neuron_by_marker.php?marker=PPE" onClick="OpenInNewTab(this);">PPE</a>','<a href="neuron_by_marker.php?marker=PPTA" onClick="OpenInNewTab(this);">PPTA</a>','<a href="neuron_by_marker.php?marker=Prox1" onClick="OpenInNewTab(this);">Prox1</a>','<a href="neuron_by_marker.php?marker=PSA-NCAM" onClick="OpenInNewTab(this);">PSA-NCAM</a>','<a href="neuron_by_marker.php?marker=SATB1" onClick="OpenInNewTab(this);">SATB1</a>','<a href="neuron_by_marker.php?marker=SATB2" onClick="OpenInNewTab(this);">SATB2</a>','<a href="neuron_by_marker.php?marker=SCIP" onClick="OpenInNewTab(this);">SCIP</a>','<a href="neuron_by_marker.php?marker=SPO" onClick="OpenInNewTab(this);">SPO</a>','<a href="neuron_by_marker.php?marker=Sub P" onClick="OpenInNewTab(this);">SubP</a>','<a href="neuron_by_marker.php?marker=TH" onClick="OpenInNewTab(this);">TH</a>','<a href="neuron_by_marker.php?marker=vAChT" onClick="OpenInNewTab(this);">vAChT</a>','<a href="neuron_by_marker.php?marker=vGAT" onClick="OpenInNewTab(this);">vGAT</a>','<a href="neuron_by_marker.php?marker=vGlut1" onClick="OpenInNewTab(this);">vGlut1</a>','<a href="neuron_by_marker.php?marker=vGluT2" onClick="OpenInNewTab(this);">vGluT2</a>','<a href="neuron_by_marker.php?marker=VILIP" onClick="OpenInNewTab(this);">VILIP</a>','<a href="neuron_by_marker.php?marker=Y1" onClick="OpenInNewTab(this);">Y1</a>'],*/

		colModel :
		[
			{name:'type', index:'type', width:50,sortable:false,cellattr: function (rowId, tv, rawObject, cm, rdata) {return 'id=\'type' + rowId + "\'";}},
			{name:'NeuronType', index:'nickname', width:175, sortable:false},
			{name:'NeuritePattern', index:'NeuritePattern', width:50,hidden:true},
			{name:'CB',index:'CB',width:15, search:false,sortable:false},
			{name:'CR',index:'CR',width:15,search:false,sortable:false},
			{name:'PV',index:'PV',width:15,search:false,sortable:false,
				cellattr: function(rowId, tv, rawObject, cm, rdata)
					{
						return 'style="border-right:medium solid #000099;"';
					}
			},
			{name:'5HT-3',index:'5HT-3',width:15,search:false,sortable:false},
			{name:'CB1',index:'CB1',width:15,search:false,sortable:false},
			{name:'GABAa', index:'GABAa', width:15,search:false,sortable:false},
			{name:'mGluR1a',index:'mGluR1a',width:15,search:false,sortable:false},
			{name:'Mus2R',index:'Mus2R',width:15,search:false,sortable:false},
			{name:'SubPRec',index:'SubPRec',width:15,search:false,sortable:false},
			{name:'vGluT3',index:'vGluT3',width:15,search:false,sortable:false,
				cellattr: function(rowId, tv, rawObject, cm, rdata)
					{
						return 'style="border-right:medium solid #000099;"';
					}
			},
			{name:'CCK',index:'CCK',width:15,search:false,sortable:false},
			{name:'ENK',index:'ENK',width:15,search:false,sortable:false},
			{name:'NG',index:'NG',width:15,search:false,sortable:false},
			{name:'NPY',index:'NPY',width:15,search:false,sortable:false},
			{name:'SOM',index:'SOM',width:15,search:false,sortable:false},
			{name:'VIP',index:'VIP',width:15,search:false,sortable:false,
			cellattr: function(rowId, tv, rawObject, cm, rdata)
				{
					return 'style="border-right:medium solid #000099;"';
				}
			},
			{name:'a-act2',index:'a-act2',width:15,search:false,sortable:false},
			{name:'CoupTFII',index:'CoupTFII',width:15,search:false,sortable:false},
			{name:'nNos',index:'nNos',width:15,search:false,sortable:false},
			{name:'RLN',index:'RLN',width:15,search:false,sortable:false,
				cellattr: function(rowId, tv, rawObject, cm, rdata)
					{
						return 'style="border-right:medium solid #000099;"';
					}
			},
			{name:'AChE',index:'AChE',width:15,search:false,sortable:false,hidden:true},
			{name:'AMIGO2',index:'AMIGO2',width:15,search:false,sortable:false,hidden:true},
			{name:'AR-beta1',index:'AR-beta1',width:15,search:false,sortable:false,hidden:true},
			{name:'AR-beta2',index:'AR-beta2',width:15,search:false,sortable:false,hidden:true},
			{name:'Astn2',index:'Astn2',width:15,search:false,sortable:false,hidden:true},
			{name:'BDNF',index:'BDNF',width:15,search:false,sortable:false,hidden:true},
			{name:'Bok',index:'Bok',width:15,search:false,sortable:false,hidden:true},
			{name:'Caln',index:'Caln',width:15,search:false,sortable:false,hidden:true},
			{name:'CaM',index:'CaM',width:15,search:false,sortable:false,hidden:true},
			{name:'CaMKII_alpha',index:'CaMKII_alpha',width:15,search:false,sortable:false,hidden:true},
			{name:'CGRP',index:'CGRP',width:15,search:false,sortable:false,hidden:true},
			{name:'ChAT',index:'ChAT',width:15,search:false,sortable:false,hidden:true},
			{name:'Chrna2',index:'Chrna2',width:15,search:false,sortable:false,hidden:true},
			{name:'CRF',index:'CRF',width:15,search:false,sortable:false,hidden:true},
			{name:'Ctip2',index:'Ctip2',width:15,search:false,sortable:false,hidden:true},
			{name:'Cx36',index:'Cx36',width:15,search:false,sortable:false,hidden:true},
			{name:'CXCR4',index:'CXCR4',width:15,search:false,sortable:false,hidden:true},
			{name:'Dcn',index:'Dcn',width:15,search:false,sortable:false,hidden:true},
			{name:'Disc1',index:'Disc1',width:15,search:false,sortable:false,hidden:true},
			{name:'DYN',index:'DYN',width:15,search:false,sortable:false,hidden:true},
			{name:'EAAT3',index:'EAAT3',width:15,search:false,sortable:false,hidden:true},
			{name:'ErbB4',index:'ErbB4',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_alpha2',index:'GABAa_alpha2',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_alpha3',index:'GABAa_alpha3',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_alpha4',index:'GABAa_alpha4',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_alpha5',index:'GABAa_alpha5',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_alpha6',index:'GABAa_alpha6',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_beta1',index:'GABAa_beta1',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_beta2',index:'GABAa_beta2',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_beta3',index:'GABAa_beta3',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_delta',index:'GABAa_delta',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_gamma1',index:'GABAa_gamma1',width:15,search:false,sortable:false,hidden:true},
			{name:'GABAa_gamma2',index:'GABAa_gamma2',width:15,search:false,sortable:false,hidden:true},
			{name:'GABA-B1',index:'GABA-B1',width:15,search:false,sortable:false,hidden:true},
			{name:'GAT-1',index:'GAT-1',width:15,search:false,sortable:false,hidden:true},
			{name:'GAT-3',index:'GAT-3',width:15,search:false,sortable:false,hidden:true},
			{name:'GluA1',index:'GluA1',width:15,search:false,sortable:false,hidden:true},
			{name:'GluA2',index:'GluA2',width:15,search:false,sortable:false,hidden:true},
			{name:'GluA2_3',index:'GluA2_3',width:15,search:false,sortable:false,hidden:true},
			{name:'GluA3',index:'GluA3',width:15,search:false,sortable:false,hidden:true},
			{name:'GluA4',index:'GluA4',width:15,search:false,sortable:false,hidden:true},
			{name:'GlyT2',index:'GlyT2',width:15,search:false,sortable:false,hidden:true},
			{name:'Gpc3',index:'Gpc3',width:15,search:false,sortable:false,hidden:true},
			{name:'Grp',index:'Grp',width:15,search:false,sortable:false,hidden:true},
			{name:'Htr2c',index:'Htr2c',width:15,search:false,sortable:false,hidden:true},
			{name:'Id-2',index:'Id-2',width:15,search:false,sortable:false,hidden:true},
			{name:'Kv3_1',index:'Kv3_1',width:15,search:false,sortable:false,hidden:true},
			{name:'Loc432748',index:'Loc432748',width:15,search:false,sortable:false,hidden:true},
			{name:'Man1a',index:'Man1a',width:15,search:false,sortable:false,hidden:true},
			{name:'Math-2',index:'Math-2',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR1',index:'mGluR1',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR2',index:'mGluR2',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR2_3',index:'mGluR2_3',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR3',index:'mGluR3',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR4',index:'mGluR4',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR5',index:'mGluR5',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR5a',index:'mGluR5a',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR7a',index:'mGluR7a',width:15,search:false,sortable:false,hidden:true},
			{name:'mGluR8a',index:'mGluR8a',width:15,search:false,sortable:false,hidden:true},
			{name:'MOR',index:'MOR',width:15,search:false,sortable:false,hidden:true},
			{name:'Mus1R',index:'Mus1R',width:15,search:false,sortable:false,hidden:true},
			{name:'Mus3R',index:'Mus3R',width:15,search:false,sortable:false,hidden:true},
			{name:'Mus4R',index:'Mus4R',width:15,search:false,sortable:false,hidden:true},
			{name:'Ndst4',index:'Ndst4',width:15,search:false,sortable:false,hidden:true},
			{name:'NECAB1',index:'NECAB1',width:15,search:false,sortable:false,hidden:true},
			{name:'Neuropilin2',index:'Neuropilin2',width:15,search:false,sortable:false,hidden:true},
			{name:'NKB',index:'NKB',width:15,search:false,sortable:false,hidden:true},
			{name:'Nov',index:'Nov',width:15,search:false,sortable:false,hidden:true},
			{name:'Nr3c2',index:'Nr3c2',width:15,search:false,sortable:false,hidden:true},
			{name:'Nr4a1',index:'Nr4a1',width:15,search:false,sortable:false,hidden:true},
			{name:'p-CREB',index:'p-CREB',width:15,search:false,sortable:false,hidden:true},
			{name:'PCP4',index:'PCP4',width:15,search:false,sortable:false,hidden:true},
			{name:'PPE',index:'PPE',width:15,search:false,sortable:false,hidden:true},
			{name:'PPTA',index:'PPTA',width:15,search:false,sortable:false,hidden:true},
			{name:'Prox1',index:'Prox1',width:15,search:false,sortable:false,hidden:true},
			{name:'Prss12',index:'Prss12',width:15,search:false,sortable:false,hidden:true},
			{name:'Prss23',index:'Prss23',width:15,search:false,sortable:false,hidden:true},
			{name:'PSA-NCAM',index:'PSA-NCAM',width:15,search:false,sortable:false,hidden:true},
			{name:'SATB1',index:'SATB1',width:15,search:false,sortable:false,hidden:true},
			{name:'SATB2',index:'SATB2',width:15,search:false,sortable:false,hidden:true},
			{name:'SCIP',index:'SCIP',width:15,search:false,sortable:false,hidden:true},
			{name:'SPO',index:'SPO',width:15,search:false,sortable:false,hidden:true},
			{name:'SubP',index:'SubP',width:15,search:false,sortable:false,hidden:true},
			{name:'Tc1568100',index:'Tc1568100',width:15,search:false,sortable:false,hidden:true},
			{name:'TH',index:'TH',width:15,search:false,sortable:false,hidden:true},
			{name:'vAChT',index:'vAChT',width:15,search:false,sortable:false,hidden:true},
			{name:'vGAT',index:'vGAT',width:15,search:false,sortable:false,hidden:true},
			{name:'vGlut1',index:'vGlut1',width:15,search:false,sortable:false,hidden:true},
			{name:'vGluT2',index:'vGluT2',width:15,search:false,sortable:false,hidden:true},
			{name:'VILIP',index:'VILIP',width:15,search:false,sortable:false,hidden:true},
			{name:'Wfs1',index:'Wfs1',width:15,search:false,sortable:false,hidden:true},
			{name:'Y1',index:'Y1',width:15,search:false,sortable:false,hidden:true},
			{name:'Y2',index:'Y2',width:15,search:false,sortable:false,hidden:true}
		],
		rowNum:125,
		rowList:[125],
		viewrecords: true,
		gridview: true,
		jsonReader :
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
		width: "722",
		shrinkToFit: true,
		gridComplete: function ()
		{
			var gridName = "nGrid"; // Access the grid Name
			Merger(gridName,"type");
			HideShowColumns();
		}
	});
	jQuery("#nGrid").jqGrid('setGroupHeaders', { useColSpanStyle: true,
		groupHeaders:[
      		{startColumnName: 'CB', numberOfColumns: 3, titleText: '<b>Ca2+ binding proteins<b>'},
    		{startColumnName: '5HT-3', numberOfColumns: 7, titleText: '<b>Receptors/Transporters</b>'},
    		{startColumnName: 'CCK', numberOfColumns: 6, titleText: '<b>Neuropeptides</b>'},
    		{startColumnName: 'a-act2', numberOfColumns: 4, titleText: '<b>Misc</b>'},
		]
	});
	let $n_columns = 116;
	if(checkVersion()=="9")
	{
		var myGrid = $('#nGrid');
		var colModelVal = $("#nGrid").jqGrid('getGridParam','colModel');
		var colModelName = "";
		for(var i=3;i<$n_columns;i++)
		{
			colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
			$(colModelName).addClass("rotateIE9");
		}
		for(var i=23;i<$n_columns;i++)
		{
			colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
			$(colModelName).addClass("expandIE9");
		}
	}
	else
	{
		var myGrid = $('#nGrid');
		var colModelVal = $("#nGrid").jqGrid('getGridParam','colModel');
		var colModelName = "";
		var htmlAttri =  "top: 105px !important";
		for(var i=3;i<$n_columns;i++)
		{
			colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
			$(colModelName).addClass("rotate");
		}
		var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
		var is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;
		var is_ietrident = navigator.userAgent.toLowerCase().indexOf('trident') > -1;
		var is_ieedge = navigator.userAgent.toLowerCase().indexOf('edge') > -1;
		if(is_chrome && is_ieedge) {
			is_ieedge = 1;
			is_chrome = 0;
		}
		if (is_chrome) {
			for(var i=23;i<$n_columns;i++)
			{
				colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
				$(colModelName).addClass("expandChrome");
			}
		}
		else if (is_ie || is_ietrident || is_ieedge) {
			for(var i=23;i<$n_columns;i++)
			{
				colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
				$(colModelName).addClass("expandIEOther");
			}
		}
		else {
		    for(var i=23;i<$n_columns;i++)
			{
				colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
				$(colModelName).addClass("expandOther");
			}
		}
	}
	$("#nGrid_5HT-3").css("height","80");
	$("#nGrid_act2").css("height","80");
	var cm = $("#nGrid").jqGrid('getGridParam', 'colModel');

	function HideShowColumns ()
{
	var myGrid = $('#nGrid');
	var customWidth = screen.availWidth-100;

	//myGrid.jqGrid('setFrozenColumns');
	//set frozen columns when document is loaded
	$(document).ready(function() {
    myGrid.jqGrid('setColProp', 'type', {frozen: true });
	myGrid.jqGrid('setColProp', 'NeuronType', {frozen: true });
	myGrid.jqGrid('setFrozenColumns');
	myGrid.jqGrid('setGridParam', {shrinkToFit: false});

	//myGrid.jqGrid('setGridParam', {autowidth: true});
});

	$("#checkbox1").click(function() {
		if ($("#checkbox1").is(':checked')) {
			var myGrid = $("#nGrid");
			myGrid.setGridWidth("722");
			//myGrid.jqGrid('setColProp', 'type', {frozen: true });
			//myGrid.jqGrid('setColProp', 'NeuronType', {frozen: true });
			myGrid.jqGrid('setGridParam', {autowidth: true});
			//myGrid.jqGrid('setGridParam', {shrinkToFit: false});
			//myGrid.jqGrid('setGridParam', {scrollerbar: true});
			myGrid.jqGrid('showCol', ["NeuritePattern"]);
			$("#jqgh_nGrid_NeuronType").addClass("patternHeight");
			$("#jqgh_nGrid_NeuritePattern").addClass("patternHeight");
			//myGrid.jqGrid('setFrozenColumns');
			$("#checkbox2").click(function() {
				if ($("#checkbox2").is(':checked')) {
					myGrid.setGridWidth(customWidth,false);
					myGrid.jqGrid('setGridParam', {autowidth: true});
					//myGrid.jqGrid('setGridParam', {shrinkToFit: false});
					myGrid.jqGrid('setGridParam', {scrollerbar: true});
				} else {
					//myGrid.setGridWidth("722");
				}
			});
		}
 		else {
			var myGrid = $("#nGrid");
			myGrid.jqGrid('hideCol', ["NeuritePattern"]);
			myGrid.setGridWidth("722");
			$("#checkbox2").click(function() {
				if ($("#checkbox2").is(':checked')) {
					myGrid.setGridWidth(customWidth,false);
					myGrid.jqGrid('setGridParam', {autowidth: true});
					myGrid.jqGrid('setGridParam', {shrinkToFit: false});
					myGrid.jqGrid('setGridParam', {scrollerbar: true});
				} else {
					myGrid.setGridWidth("722");
				}
			});
		}
	});
	$("#checkbox2").click(function() {
		if ($("#checkbox2").is(':checked')) {
			$("#jqgh_nGrid_NeuronType").addClass("patternHeight");
			$("#jqgh_nGrid_NeuritePattern").addClass("patternHeight");
			//myGrid.jqGrid('setColProp', 'type', {frozen: true });
			//myGrid.jqGrid('setColProp', 'NeuronType', {frozen: true });
			//myGrid.jqGrid('setFrozenColumns');
			myGrid.setGridWidth(customWidth,false);
			myGrid.jqGrid('setGridParam', {autowidth: true});
			//myGrid.jqGrid('setGridParam', {shrinkToFit: false});
			myGrid.jqGrid('setGridParam', {scrollerbar: true});
			myGrid.jqGrid('showCol', ["AChE","AMIGO2","AR-beta1","AR-beta2","Astn2","BDNF","Bok","Caln","CaM","CaMKII_alpha","CGRP","ChAT","Chrna2","CRF","Ctip2","Cx36","CXCR4","Dcn","Disc1","DYN","EAAT3","ErbB4","GABA-B1","GABAa_delta","GABAa_alpha2","GABAa_alpha3","GABAa_alpha4","GABAa_alpha5","GABAa_alpha6","GABAa_beta1","GABAa_beta2","GABAa_beta3","GABAa_gamma1","GABAa_gamma2","GAT-1","GAT-3","GluA1","GluA2","GluA2_3","GluA3","GluA4","GlyT2","Gpc3","Grp","Htr2c","Id-2","Kv3_1","Loc432748","Man1a","Math-2","mGluR1","mGluR2","mGluR2_3","mGluR3","mGluR4","mGluR5","mGluR5a","mGluR7a","mGluR8a","MOR","Mus1R","Mus3R","Mus4R","Ndst4","NECAB1","Neuropilin2","NKB","Nov","Nr3c2","Nr4a1","p-CREB","PCP4","PPE","PPTA","Prox1","Prss12","Prss23","PSA-NCAM","SATB1","SATB2","SCIP","SPO","SubP","Tc1568100","TH","vAChT","vGAT","vGlut1","vGluT2","VILIP","Wfs1","Y1","Y2"]);
			$("#checkbox1").click(function() {
				if ($("#checkbox1").is(':checked')) {
					myGrid.setGridWidth(customWidth,false);
					myGrid.jqGrid('setGridParam', {autowidth: true});
					//myGrid.jqGrid('setGridParam', {shrinkToFit: false});
					myGrid.jqGrid('setGridParam', {scrollerbar: true});
				} else {
					myGrid.setGridWidth(customWidth,false);
				}
			});
		}
		else {
			myGrid.setGridWidth("722");
			myGrid.jqGrid('hideCol', ["AChE","AMIGO2","AR-beta1","AR-beta2","Astn2","BDNF","Bok","Caln","CaM","CaMKII_alpha","CGRP","ChAT","Chrna2","CRF","Ctip2","Cx36","CXCR4","Dcn","Disc1","DYN","EAAT3","ErbB4","GABA-B1","GABAa_delta","GABAa_alpha2","GABAa_alpha3","GABAa_alpha4","GABAa_alpha5","GABAa_alpha6","GABAa_beta1","GABAa_beta2","GABAa_beta3","GABAa_gamma1","GABAa_gamma2","GAT-1","GAT-3","GluA1","GluA2","GluA2_3","GluA3","GluA4","GlyT2","Gpc3","Grp","Htr2c","Id-2","Kv3_1","Loc432748","Man1a","Math-2","mGluR1","mGluR2","mGluR2_3","mGluR3","mGluR4","mGluR5","mGluR5a","mGluR7a","mGluR8a","MOR","Mus1R","Mus3R","Mus4R","Ndst4","NECAB1","Neuropilin2","NKB","Nov","Nr3c2","Nr4a1","p-CREB","PCP4","PPE","PPTA","Prox1","Prss12","Prss23","PSA-NCAM","SATB1","SATB2","SCIP","SPO","SubP","Tc1568100","TH","vAChT","vGAT","vGlut1","vGluT2","VILIP","Wfs1","Y1","Y2"]);
			$("#checkbox1").click(function() {
				if ($("#checkbox1").is(':checked')) {
					myGrid.setGridWidth("722");
					myGrid.jqGrid('setGridParam', {autowidth: true});
					myGrid.jqGrid('setGridParam', {shrinkToFit: false});
					myGrid.jqGrid('setGridParam', {scrollerbar: true});
				} else {
					myGrid.setGridWidth("722");
					myGrid.jqGrid('setGridParam', {autowidth: true});
					myGrid.jqGrid('setGridParam', {shrinkToFit: false});
					myGrid.jqGrid('setGridParam', {scrollerbar: true});
				}
			});
		}
	});
	$("#checkbox3").click(function() {
				ShowHideInference();
	});
}
});
function ShowHideInference(){
			var negative_inference=$("img[src='images/marker/negative_inference.png']");
			var positive_inference=$("img[src='images/marker/positive_inference.png']");
			var negative_inference_confirmed=$("img[src='images/marker/negative_inference_confirmed.png']");
			var positive_inference_confirmed=$("img[src='images/marker/positive_inference_confirmed.png']");
			var species_inference=$("img[src='images/marker/positive_inference-negative_inference-species.png']");
			var subtypes_inference=$("img[src='images/marker/positive_inference-negative_inference-subtypes.png']");
			var unresolved_inference=$("img[src='images/marker/positive_inference-negative_inference-unresolved.png']");
			if ($("#checkbox3").is(':checked')) {
				negative_inference.parents("a").show();
				positive_inference.parents("a").show();
				negative_inference_confirmed.parents("a").show();
				positive_inference_confirmed.parents("a").show();
				species_inference.parents("a").show();
				subtypes_inference.parents("a").show();
				unresolved_inference.parents("a").show();
			}
			else{
				negative_inference.parents("a").hide();
				positive_inference.parents("a").hide();
				negative_inference_confirmed.parents("a").hide();
				positive_inference_confirmed.parents("a").hide();
				species_inference.parents("a").hide();
				subtypes_inference.parents("a").hide();
				unresolved_inference.parents("a").hide();
			}
}
</script>
</head>
<body onload="ShowHideInference()">
<!-- COPY IN ALL PAGES -->
<?php
include ("function/title.php");
include ("function/menu_main.php");
?>
<div class="title_area_marker">
		<form id="myform">
      <font class="font1">Browse molecular markers matrix&nbsp;&nbsp;&nbsp;&nbsp;</font>
			<input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="checkbox1"><span style="color: rgb(0, 0, 153);">Neurite Patterns&nbsp;&nbsp;</span></input>
        <input type="checkbox" style="background-color: rgb(0, 0, 153); " value="check2" name="check2" id="checkbox2"/><span style="color: rgb(0, 0, 153);">All Markers&nbsp;&nbsp;</span></input>
		<?php
        if($permission!=1)
        	{
        ?>
        <input type="checkbox" checked style="background-color: rgb(0, 0, 153); " value="check3" name="check3" id="checkbox3"/><span style="color: rgb(0, 0, 153);">Inferences</span></input>
        <?php
			}
		?>
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
	<tr>
		<td>

		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
	<tr>
		<td>
			<font class='font5'><strong>Legend:</strong> </font>&nbsp; &nbsp;

			<img src='images/positive_half.png' width="7px" border="0"/> <font class='font5'>Positive</font> &nbsp;
			<img src='images/negative_half.png' width="7px" border="0"/> <font class='font5'>Negative</font> &nbsp;
			<img src="images/positive-negative-subtypes.png" width="13px" border="0"/> <font class='font5'>Positive-Negative (subtypes)</font> &nbsp;
			<img src="images/positive-negative-species.png" width="13px" border="0"/> <font class='font5'>Positive-Negative (species/protocol differences)</font> &nbsp;
			<img src="images/positive-negative-subcellular.png" width="13px" border="0"/> <font class='font5'>Positive-Negative (subcellular expression differences)</font> &nbsp;
			<img src="images/positive-negative-conflicting.png" width="13px" border="0"/> <font class='font5'>Positive-Negative (unresolved)</font>

			<!--
			<img src='images/positive-negative_inference.png' width="13px" border="0"/> <font class='font5'>Positive; negative inference</font> &nbsp;
			<img src='images/positive_inference-negative.png' width="13px" border="0"/> <font class='font5'>Negative; positive inference</font> &nbsp;
			-->
			<?php
             	if($permission!=1)
        			{
        	?>
			<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

			<img src='images/positive_inference_half.png' width="7px" border="0"/> <font class='font5'>Positive inference</font> &nbsp;
			<img src='images/negative_inference_half.png' width="7px" border="0"/> <font class='font5'>Negative inference</font> &nbsp;
			<img src='images/positive_inference-negative_inference-subtypes.png' width="13px" border="0"/> <font class='font5'>Positive inference; negative inference (subtypes)</font> &nbsp;
			<img src='images/positive_inference-negative_inference-species.png' width="13px" border="0"/> <font class='font5'>Positive inference; negative inference (species/protocol differences)</font> &nbsp;
			<img src='images/positive_inference-negative_inference-unresolved.png' width="13px" border="0"/> <font class='font5'>Positive inference; negative inference (unresolved)</font> &nbsp;
			<?php
					}
        	?>

			<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<img src="images/unknown.png" width="13px" border="0"/> <font class='font5'>No Data Found </font> &nbsp; &nbsp;
			<img src="images/searching.png" width="13px" border="0"/> <font class='font5'>Search Incomplete </font> &nbsp; &nbsp;
			<?php
             	if($permission!=1)
        			{
        	?>
			<img src="images/positive_half_confirm.png" width="7px" border="0"/>
				<img src="images/negative_half_confirm.png" width="7px" border="0"/>
				<img src="images/positive_inference_half_confirm.png" width="7px" border="0"/>
				<img src="images/negative_inference_half_confirm.png" width="7px" border="0"/>
				<font class='font5'>Additional confirmation by inference(s) </font> &nbsp; &nbsp;
			<?php
					}
        	?>

			<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<font face="Verdana, Arial, Helvetica, sans-serif" color="#339900" size="2"> green: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Excitatory</font>
			&nbsp; &nbsp;
			<font face="Verdana, Arial, Helvetica, sans-serif" color="#CC0000" size="2"> red: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Inhibitory</font>

			<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<font class='font5'>Pale versions of the colors in the matrix indicate interpretations of neuronal property information that have not yet been fully verified.</font>

			</br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<font class='font5'>Twenty matrix markers displayed by default are from our publication.</font>
		</td>
	</tr>
</table>
</div>
</body>
</html>

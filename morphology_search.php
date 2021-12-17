<?php
  include ("permission_check.php");
  include ("getMorphology.php");
  require_once('class/class.type.php');
  require_once('class/class.property.php');
  require_once('class/class.evidencepropertyyperel.php');
  require_once('class/class.temporary_result_neurons.php');
// FUNCTIONS -------------------------------------------------------------------------------
// Check the UNVETTED color: ***************************************************************************
/* function check_unvetted1($id, $id_property, $evidencepropertyyperel)
{
	$evidencepropertyyperel -> retrive_unvetted($id, $id_property);
	$unvetted1 = $evidencepropertyyperel -> getUnvetted();
	return ($unvetted1);
}
// *****************************************************************************************************
function check_color($variable, $unvetted)
{
	if ($variable == 'red')
	{
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/axons_present_unvetted.png' border='0'/>";
		else
			$link[0] = "<img src='images/morphology/axons_present.png' border='0'/>";
		
		$link[1] = $variable;
	
	}
	if ($variable == 'blue')
	{
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/dendrites_present_unvetted.png' border='0'/>";	
		else	
			$link[0] = "<img src='images/morphology/dendrites_present.png' border='0'/>";	
		
		$link[1] = $variable;
	}
	if ($variable == 'violet')
	{
		if ($unvetted == 1)
			$link[0] = "<img src='images/morphology/somata_present_unvetted.png' border='0'/>";
		else	
			$link[0] = "<img src='images/morphology/somata_present.png' border='0'/>";
		$link[1] = $variable;
	}
	if ($variable == NULL)
	{
		$link[0] = "<img src='images/blank_morphology.png' border='0'/>";
		$link[1] = $variable;
	}	
	
	return ($link);
}
function check_axon_dendrite($variable, $hippo_axon, $hippo_dendrite)
{
	if (($hippo_axon[$variable] == 1) && ($hippo_dendrite[$variable] == 1))
		$result = 'violet';
	if (($hippo_axon[$variable] == 1) && ($hippo_dendrite[$variable] == 0))
		$result = 'red';
	if (($hippo_axon[$variable] == 0) && ($hippo_dendrite[$variable] == 1))
		$result = 'blue';

	return ($result);
} */	
// ------------------------------------------------------------------------------------------
$color_selected ='#EBF283';
$type = new type($class_type);
$research = $_REQUEST['research'];
/* if ($research) // From page of search; retrieve the id from search_table (temporary) -----------------------
{
	$table_result = $_REQUEST['table_result'];

	$temporary_result_neurons = new temporary_result_neurons();
	$temporary_result_neurons -> setName_table($table_result);

	$temporary_result_neurons -> retrieve_id_array();
	$n_id_res = $temporary_result_neurons -> getN_id();

	$number_type = 0;
	for ($i2=0; $i2<$n_id_res; $i2++)
	{
		$id2 = 	$temporary_result_neurons -> getID_array($i2);
		
		if (strpos($id2, '0_') == 1);
		else
		{
			$type -> retrive_by_id($id2);
			$status = $type -> getStatus();
			
			if ($status == 'active')
			{
				$id_search[$number_type] = $id2;
				$position_search[$number_type] = $type -> getPosition();
				$number_type = $number_type + 1;
			}		
		}	
	} // END $i2
	array_multisort($position_search, $id_search);
	// sort($id_search);								
}
else // not from search page --------------
{
	$type -> retrive_id();
	$number_type = $type->getNumber_type();
} */
// -------------------------------------------------------------------------------------------------------------
$property = new property($class_property);
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$hippo_select = $_SESSION['hippo_select'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
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
    -webkit-transform: rotate(-90deg);    /* Safari 3.1+, Chrome */
    -moz-transform: rotate(-90deg);    /* Firefox 3.5+ */
    -o-transform: rotate(-90deg); /* Opera starting with 10.50 */
    /* Internet Explorer: */
    /*filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); /* IE6, IE7 */
   /*-ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=3)" /* IE8 */
   -ms-transform: rotate(-90deg);
   left:8px;
   font-size:11px;
   font-weight:bold;
   padding:0px;
   font:Verdana;
}
.rotateIE9 
{
    -webkit-transform: rotate(-90deg);    /* Safari 3.1+, Chrome */
    -moz-transform: rotate(-90deg);    /* Firefox 3.5+ */
    -o-transform: rotate(-90deg); /* Opera starting with 10.50 */
    /* Internet Explorer: */
   /* filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); /* IE6, IE7 */
   /*-ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=3)" /* IE8 */
   -ms-transform: rotate(-90deg);
   left:8px;
   font-size:11px;
   font-weight:bold;
   padding:0px;
   font:Verdana;
}
#nGrid_H,#nGrid_SO,#nGrid_2_SO,#nGrid_1_SO,#nGrid_SUB_PL
{
	border-right:medium solid #C08181;
	width:auto !important;
}
#nGrid_SLM,#nGrid_2_SLM,#nGrid_1_SLM,#nGrid_SUB_SM,#nGrid_I
{
	border-left:medium solid #770000;
	width:auto !important;
}
.ui-jqgrid {
    font-size: 11px !important;
}
#dg_subregion,#ca3_subregion,#ec_subregion
{
	color: white;
}
#ca2_subregion,#ca1_subregion
{
	color:#000099;
}
</style>
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid_morph.css" />
<script language="javascript">
function OpenInNewTab(aEle)
{
	//alert(aEle.href);
	var win = window.open(aEle.href,'_blank');
	win.focus();
}

/* function ctr(select_nick_name2, color, select_nick_name_check)
{
	if (document.getElementById(select_nick_name_check).checked == false)
	{	
		document.getElementById(select_nick_name2).bgColor = "#FFFFFF";
		
	}
	else if (document.getElementById(select_nick_name_check).checked == true)
		document.getElementById(select_nick_name2).bgColor = "#EBF283";	
} */

function getIEVersion() {
    var rv = -1; // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.test(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}


function checkVersion() {
    var ver = getIEVersion();
	//alert("Version : "+ver);
    /*if ( ver != -1 ) {
        if (ver <= 9.0) {
            // do something
        }
    }*/
    return ver;
}
checkVersion();

</script>
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jqGrid-4/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('#super_check').change(function() {
		var bgColorArray = ["","","","#770000","#C08181","#FFFF99","#FF6103","#FFCC33","#336633"];
		var fontColorArray = ["","","","#FFFFFF","#FFFFFF","#000099","#000099","#000099","#FFFFFF"];
		if ($("#super_check").is(':checked')) {
           $("#nGrid").jqGrid('showCol',["Supertype"]);
		}
		else{
			$("#nGrid").jqGrid('hideCol',["Supertype"]);
		}
		var $i=0;
		$(".jqg-second-row-header").children().each(function()
		{
			$(this).css("background",bgColorArray[$i]);
			$(this).css("color",fontColorArray[$i]);
			$i++;	
		});
	});
	var dataStr = <?php echo json_encode($responce)?>;
	function Merger(gridName,cellName){
		var mya = $("#" + gridName + "").getDataIDs();	
		var rowCount = mya.length;
		//alert(mya.length);
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
					//$("#" + cellName + "" + mya[i] + "").attr("rowSpan",rowSpanCount);
					rowSpanCount++;	
                } 
                else 
                {
					/* if(rowSpanCount > 1) // Condition to check if there is a single row and no rowspan is needed
					{
                		//$("tr#"+j+" td#type"+j).remove();
                		//$("#" + cellName + "" + mya[i] + "").attr("rowSpan",rowSpanCount);
                		$("tr#"+j).css("border-bottom", "2px red");
					}
					else */
					/* { */
						$("tr#"+j).css("border-bottom", "2px red");
					/* } */
                    countRows = rowSpanCount;
                	rowSpanCount = 1;
                	break;
                }
			}
			//$("tr#"+firstElement).css("border-bottom", "2px red");
		} 
	}
	var research = "<?php echo $research?>";
	var table = "<?php if(isset($_REQUEST['table_result'])){echo $_REQUEST['table_result'];}?>";
	//alert(table);
	$("#nGrid").jqGrid({
	datatype: "jsonstring",
	datastr: dataStr,
    //mtype: 'GET',
   /*  ajaxGridOptions :{
		contentType : "application/json"
        }, */
    //jsonReader: { repeatitems: false },
    /* postData: {
        researchVar: research,
        table_result : table
    } */
    colNames:['','Neuron Type','Supertype','<a href="parcel_page.php?parcel=SMo&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SMo</a>','<a href="parcel_page.php?parcel=SMi&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SMi</a>','<a href="parcel_page.php?parcel=SG&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SG</a>','<a href="parcel_page.php?parcel=H&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">H</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SL&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SL</a>','<a href="parcel_page.php?parcel=SP&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SP&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SP&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SM&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SM</a>','<a href="parcel_page.php?parcel=SP&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=PL&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">PL</a>','<a href="parcel_page.php?parcel=I&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">I</a>','<a href="parcel_page.php?parcel=II&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">II</a>','<a href="parcel_page.php?parcel=III&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">III</a>','<a href="parcel_page.php?parcel=IV&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">IV</a>','<a href="parcel_page.php?parcel=V&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">V</a>','<a href="parcel_page.php?parcel=VI&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">VI</a>'],
    colModel :[
	  {name:'type', index:'type', width:50,sortable:false,cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'";   
      } },
      {name:'Neuron type', index:'nickname', width:200,sortable:false},
      {name:'Supertype', index:'supertype', width:300,sortable:false,hidden: true},
          //,searchoptions: {sopt: ['bw','bn','cn','in','ni','ew','en','nc']}},
      {name:'SMo', index:'DG_SMo', width:15,search:false,sortable:false},
      {name:'SMi', index:'DG_SMi', width:15,height:150,search:false,sortable:false},
      {name:'SG', index:'DG_SG', width:15,height:150,search:false,sortable:false},
      {name:'H', index:'DG_H', width:18,height:150,search:false,sortable:false, 
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="border-right:medium solid #C08181;"';
       }
      },
      {name:'SLM', index:'CA3_SLM', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'SR', index:'CA3_SR', width:15,height:150,search:false,sortable:false},
      {name:'SL', index:'CA3_SL', width:15,height:150,search:false,sortable:false},
      {name:'SP', index:'CA3_SP', width:15,height:150,search:false,sortable:false},
      {name:'SO', index:'CA3_SO', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'2_SLM', index:'CA2_SLM', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'2_SR', index:'CA2_SR', width:15,height:150,search:false,sortable:false},
      {name:'2_SP', index:'CA2_SP', width:15,height:150,search:false,sortable:false},
      {name:'2_SO', index:'CA2_SO', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'1_SLM', index:'CA1_SLM', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'1_SR', index:'CA1_SR', width:15,height:150,search:false,sortable:false},
      {name:'1_SP', index:'CA1_SP', width:15,height:150,search:false,sortable:false},
      {name:'1_SO', index:'CA1_SO', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'SUB_SM', index:'SUB_SM', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                return 'style="border-left:medium solid #770000;"';
       }},
      {name:'SUB_SP', index:'SUB_SP', width:15,height:150,search:false,sortable:false},
      {name:'SUB_PL', index:'SUB_PL', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                   return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'I', index:'EC_I', width:18,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                   return 'style="border-left:medium solid #770000;"';
       }},
      {name:'II', index:'EC_II', width:15,height:150,search:false,sortable:false},
      {name:'III', index:'EC_III', width:15,height:150,search:false,sortable:false},
      {name:'IV', index:'EC_IV', width:15,height:150,search:false,sortable:false},
      {name:'V', index:'EC_V', width:15,height:150,search:false,sortable:false},
      {name:'VI', index:'EC_VI', width:28,height:150,search:false,sortable:false}
 	], 
    //multiselect: true,
   /* pager: '#pager',*/
    rowNum:125,
    rowList:[125],
   /*  sortname: 'invid',
    sortorder: 'desc',*/
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
    //caption: 'Morphology Matrix',
    scrollerbar:true,
    //height:"2807", //full height
    height:"440", //page height
    width:"60%",
    gridComplete: function () {
    	var gridName = "nGrid"; // Access the grid Name
    	Merger(gridName,"type");
		}
    });
	jQuery("#nGrid").jqGrid('setGroupHeaders', { useColSpanStyle: true, 
		groupHeaders:[ 
		      		/* {startColumnName: 'Type', numberOfColumns: 2, titleText: '<b>Neuron Type<b>'}, */
		      		{startColumnName: 'SMo', numberOfColumns: 4, titleText: '<b><a id="dg_subregion" href="parcel_page.php?subregion=DG&type=subregion" onClick="OpenInNewTab(this);" >DG</a><b>'},
		      		{startColumnName: 'SLM', numberOfColumns: 5, titleText: '<b><a id="ca3_subregion" href="parcel_page.php?subregion=CA3&type=subregion" onClick="OpenInNewTab(this);">CA3</a></b>'},
		      		{startColumnName: '2_SLM', numberOfColumns: 4, titleText: '<b><a id="ca2_subregion" href="parcel_page.php?subregion=CA2&type=subregion" onClick="OpenInNewTab(this);">CA2</a></b>'},
		      		{startColumnName: '1_SLM', numberOfColumns: 4, titleText: '<b><a id="ca1_subregion" href="parcel_page.php?subregion=CA1&type=subregion" onClick="OpenInNewTab(this);">CA1</a></b>'},
		      		{startColumnName: 'SUB_SM', numberOfColumns: 3, titleText: '<b><a id="sub_subregion" href="parcel_page.php?subregion=SUB&type=subregion" onClick="OpenInNewTab(this);">SUB</a></b>'},
		      		{startColumnName: 'I', numberOfColumns: 6, titleText: '<b><a id="ec_subregion" href="parcel_page.php?subregion=EC&type=subregion" onClick="OpenInNewTab(this);">EC</a></b>'}
		      		] 
	});
	//jQuery("#nGrid").jqGrid('navGrid','#pager',{search:true,edit:false,add:false,del:false});
	if(checkVersion()=="9")
	{
		$("#jqgh_nGrid_SMo").addClass("rotateIE9");
		$("#jqgh_nGrid_SMi").addClass("rotateIE9");
		$("#jqgh_nGrid_SG").addClass("rotateIE9");
		$("#jqgh_nGrid_H").addClass("rotateIE9");
		$("#jqgh_nGrid_SLM").addClass("rotateIE9");
		$("#jqgh_nGrid_SR").addClass("rotateIE9");
		$("#jqgh_nGrid_SL").addClass("rotateIE9");
		$("#jqgh_nGrid_SP").addClass("rotateIE9");
		$("#jqgh_nGrid_SO").addClass("rotateIE9");
		$("#jqgh_nGrid_2_SLM").addClass("rotateIE9");
		$("#jqgh_nGrid_2_SR").addClass("rotateIE9");
		$("#jqgh_nGrid_2_SP").addClass("rotateIE9");
		$("#jqgh_nGrid_2_SO").addClass("rotateIE9");
		$("#jqgh_nGrid_1_SLM").addClass("rotateIE9");
		$("#jqgh_nGrid_1_SR").addClass("rotateIE9");
		$("#jqgh_nGrid_1_SP").addClass("rotateIE9");
		$("#jqgh_nGrid_1_SO").addClass("rotateIE9");
		$("#jqgh_nGrid_SUB_SM").addClass("rotateIE9");
		$("#jqgh_nGrid_SUB_SP").addClass("rotateIE9");
		$("#jqgh_nGrid_SUB_PL").addClass("rotateIE9");
		$("#jqgh_nGrid_I").addClass("rotateIE9");
		$("#jqgh_nGrid_II").addClass("rotateIE9");
		$("#jqgh_nGrid_III").addClass("rotateIE9");
		$("#jqgh_nGrid_IV").addClass("rotateIE9");
		$("#jqgh_nGrid_V").addClass("rotateIE9");
		$("#jqgh_nGrid_VI").addClass("rotateIE9");
	}
	else
	{
		$("#jqgh_nGrid_SMo").addClass("rotate");
		$("#jqgh_nGrid_SMi").addClass("rotate");
		$("#jqgh_nGrid_SG").addClass("rotate");
		$("#jqgh_nGrid_H").addClass("rotate");
		$("#jqgh_nGrid_SLM").addClass("rotate");
		$("#jqgh_nGrid_SR").addClass("rotate");
		$("#jqgh_nGrid_SL").addClass("rotate");
		$("#jqgh_nGrid_SP").addClass("rotate");
		$("#jqgh_nGrid_SO").addClass("rotate");
		$("#jqgh_nGrid_2_SLM").addClass("rotate");
		$("#jqgh_nGrid_2_SR").addClass("rotate");
		$("#jqgh_nGrid_2_SP").addClass("rotate");
		$("#jqgh_nGrid_2_SO").addClass("rotate");
		$("#jqgh_nGrid_1_SLM").addClass("rotate");
		$("#jqgh_nGrid_1_SR").addClass("rotate");
		$("#jqgh_nGrid_1_SP").addClass("rotate");
		$("#jqgh_nGrid_1_SO").addClass("rotate");
		$("#jqgh_nGrid_SUB_SM").addClass("rotate");
		$("#jqgh_nGrid_SUB_SP").addClass("rotate");
		$("#jqgh_nGrid_SUB_PL").addClass("rotate");
		$("#jqgh_nGrid_I").addClass("rotate");
		$("#jqgh_nGrid_II").addClass("rotate");
		$("#jqgh_nGrid_III").addClass("rotate");
		$("#jqgh_nGrid_IV").addClass("rotate");
		$("#jqgh_nGrid_V").addClass("rotate");
		$("#jqgh_nGrid_VI").addClass("rotate");
    }
	
	$("#jqgh_nGrid_SMo").css("height","25");
	$("#jqgh_nGrid_SMo").css("top","12");
	$("#jqgh_nGrid_SMi").css("height","25");
	$("#jqgh_nGrid_SMi").css("top","12");
	$("#jqgh_nGrid_SG").css("height","25");
	$("#jqgh_nGrid_SG").css("top","12");
	$("#jqgh_nGrid_H").css("height","25");
	$("#jqgh_nGrid_H").css("top","12");
	$("#jqgh_nGrid_SLM").css("height","25");
	$("#jqgh_nGrid_SLM").css("top","12");
	
	
	$("#jqgh_nGrid_SR").css("height","25");
	$("#jqgh_nGrid_SR").css("top","12");
	
	$("#jqgh_nGrid_SL").css("height","25");
	$("#jqgh_nGrid_SL").css("top","12");
	
	$("#jqgh_nGrid_SP").css("height","25");
	$("#jqgh_nGrid_SP").css("top","12");
	
	$("#jqgh_nGrid_SO").css("height","25");
	$("#jqgh_nGrid_SO").css("top","12");
	
	$("#jqgh_nGrid_2_SLM").css("height","25");
	$("#jqgh_nGrid_2_SLM").css("top","12");
	
	$("#jqgh_nGrid_2_SR").css("height","25");
	$("#jqgh_nGrid_2_SR").css("top","12");
	
	$("#jqgh_nGrid_2_SP").css("height","25");
	$("#jqgh_nGrid_2_SP").css("top","12");
	
	$("#jqgh_nGrid_2_SO").css("height","25");
	$("#jqgh_nGrid_2_SO").css("top","12");
	
	$("#jqgh_nGrid_1_SLM").css("height","25");
	$("#jqgh_nGrid_1_SLM").css("top","12");
	
	$("#jqgh_nGrid_1_SR").css("height","25");
	$("#jqgh_nGrid_1_SR").css("top","12");
	
	$("#jqgh_nGrid_1_SP").css("height","25");
	$("#jqgh_nGrid_1_SP").css("top","12");
	
	$("#jqgh_nGrid_1_SO").css("height","25");
	$("#jqgh_nGrid_1_SO").css("top","12");
	
	$("#jqgh_nGrid_SUB_SM").css("height","25");
	$("#jqgh_nGrid_SUB_SM").css("top","12");
	
	$("#jqgh_nGrid_SUB_SP").css("height","25");
	$("#jqgh_nGrid_SUB_SP").css("top","12");
	
	$("#jqgh_nGrid_SUB_PL").css("height","25");
	$("#jqgh_nGrid_SUB_PL").css("top","12");
	
	$("#jqgh_nGrid_I").css("height","25");
	$("#jqgh_nGrid_I").css("top","12");
	
	$("#jqgh_nGrid_II").css("height","25");
	$("#jqgh_nGrid_II").css("top","12");
	
	$("#jqgh_nGrid_III").css("height","25");
	$("#jqgh_nGrid_III").css("top","12");
	
	$("#jqgh_nGrid_IV").css("height","25");
	$("#jqgh_nGrid_IV").css("top","12");
	
	$("#jqgh_nGrid_V").css("height","25");
	$("#jqgh_nGrid_V").css("top","12");
	
	$("#jqgh_nGrid_VI").css("height","25");
	$("#jqgh_nGrid_VI").css("top","12");
	
	var bgColorArray = ["","","","#770000","#C08181","#FFFF99","#FF6103","#FFCC33","#336633"];
	var fontColorArray = ["","","","#FFFFFF","#FFFFFF","#000099","#000099","#000099","#FFFFFF"];
	var $i=0;
	$(".jqg-second-row-header").children().each(function()
	{
		$(this).css("background",bgColorArray[$i]);
		$(this).css("color",fontColorArray[$i]);
		$i++;	
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
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Morphology Matrix</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>		

<div class='title_area'>
	<form id='supertypeForm'>
	<font class="font1">Browse morphology matrix</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="checkbox" style="background-color: rgb(0, 0, 153);" value="check1" name="check1" id="super_check"><span style="color: rgb(0, 0, 153);">&nbsp;Supertype &nbsp;&nbsp;</span></input>
	</form>
	<?php 
			if ($research){
				$full_search_string = $_SESSION['full_search_string'];
				if ($number_type == 1)
					print ("<font class='font3'> $number_type Result  [$full_search_string]</font>");
				else
					print ("<font class='font3'> $number_type Results  [$full_search_string]</font>");
			}
		?>
</div>

<!-- Submenu tabs
<div class='sub_menu'>
	<div class="clr-page-tabs clr-subnav-tabs">		
		<ul class="ui-tabs">
			<li class="title">Browse:</li>
			<li class="active"><a href="morphology.php">Morphology</a></li>
			<li><a href="markers.php">Molecular markers</a></li>
			<li><a href="ephys.php">Electrophysiology</a></li>
			<li><a href="connectivity.php">Connectivity</a></li>
		</ul>
	</div>
</div>
 -->
<!-- ------------------------ -->

<div class='table_position'>
<table border="0" cellspacing="0" cellpadding="0" class="tabellauno">
	<tr>
		<td>
			<table id="nGrid"></table>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr>
    <td>
		<font class='font5'><strong>Legend:</strong> </font>&nbsp; &nbsp;
		<img src="images/morphology/axons_present.png" width="10px" border="0"/> <font class='font5'>Axon present </font> &nbsp; &nbsp; 
		<img src="images/morphology/dendrites_present.png" width="10px" border="0"/> <font class='font5'>Dendrite present </font>&nbsp; &nbsp; 
		<img src="images/morphology/somata_present.png" width="10px" border="0"/> <font class='font5'>Axon & Dendrite present </font> &nbsp; &nbsp; 
		<img src="images/morphology/neuron_soma.png" width="10px" border="0"/> <font class='font5'>possible somata locations </font>  &nbsp; &nbsp;
		<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<font face="Verdana, Arial, Helvetica, sans-serif" color="#339900" size="2"> +/green: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Excitatory</font>
		&nbsp; &nbsp; 
		<font face="Verdana, Arial, Helvetica, sans-serif" color="#CC0000" size="2"> -/red: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Inhibitory</font>
		<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<font class='font5'>Pale versions of the colors in the matrix indicate interpretations of neuronal property information that have not yet been fully verified.</font>
	</td>
  </tr>
</table>
</div>
</body>
</html>

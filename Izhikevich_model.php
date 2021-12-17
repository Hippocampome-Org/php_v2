<?php
session_start();
include("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jqGrid-4/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {
   $.ajax({
    type: 'GET',
    cache: false,
    contentType: 'application/json; charset=utf-8',
    url: 'load_matrix_session_izhikevich_model.php',
    success: function() {}
  });
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


<?php
require_once("load_matrix_session_izhikevich_model.php");
$jsonStr = $_SESSION['Izhikevich_model'];
$color_selected ='#EBF283';
$research = $_REQUEST['research'];
$hippo_select = $_SESSION['hippo_select'];
?>

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

// All param implementeation will be done later
/*	$('#all_parameters').change(function() {
		var bgColorArray = ["","","","#770000","#C08181","#FFFF99","#FF6103","#FFCC33","#336633"];
		var fontColorArray = ["","","","#FFFFFF","#FFFFFF","#000099","#000099","#000099","#FFFFFF"];
		if ($("#all_parameters").is(':checked')) {
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
	});*/

	var dataStr = <?php echo $jsonStr?>;
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
					$("#" + gridName + "").setCell(mya[j], cellName);
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
  console.log(dataStr);
	$("#nGrid").jqGrid({
	datatype: "jsonstring",
	datastr: dataStr,
    //mtype: 'GET',
   /*  ajaxGridOptions :{
		contentType : "application/json"
        }, */
    //jsonReader: { repeatitems: false },
    /* \: {
        researchVar: research,
        table_result : table
    } */
    colNames:['','Neuron Type','k','a','b','d','C','Vr','Vt','Vpeak','Vmin','k0','a0','b0','d0','C0','Vr0','Vt0','Vpeak0','Vmin0','k1','a1','b1','d1','C1','Vr1','Vt1','Vpeak1','Vmin1','G0','P0','k2','a2','b2','d2','C2','Vr2','Vt2','Vpeak2','Vmin2','G1','P1','k3','a3','b3','d3','C3','Vr3','Vt3','Vpeak3','Vmin3','G2','P2']
    ,colModel :[
	   {name:'type', index:'type', width:50,sortable:false, cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'";   
      } },
      {name:'NeuronType', index:'nickname', width:175,sortable:false},
      {name:'k', index:'k', width:75,search:false,sortable:false},
      {name:'a', index:'a', width:75,search:false,sortable:false},
      {name:'b', index:'b', width:75,search:false,sortable:false},
      {name:'d', index:'d', width:75,search:false,sortable:false},
      {name:'C', index:'C', width:75,search:false,sortable:false},
      {name:'Vr', index:'Vr', width:75,search:false,sortable:false},
      {name:'Vt', index:'Vt', width:75,search:false,sortable:false},
      {name:'Vpeak', index:'Vpeak', width:75,search:false,sortable:false},
      {name:'Vmin', index:'Vmin', width:75,search:false,sortable:false},
      {name:'k0', index:'k0', width:75, search:false,sortable:false,hidden: true}
      ,{name:'a0', index:'a0', width:75, search:false,sortable:false,hidden: true}
,{name:'b0', index:'b0', width:75, search:false,sortable:false,hidden: true}
,{name:'d0', index:'d0', width:75, search:false,sortable:false,hidden: true}
,{name:'C0', index:'C0', width:75, search:false,sortable:false,hidden: true}
,{name:'Vr0', index:'Vr0', width:75, search:false,sortable:false,hidden: true}
,{name:'Vt0', index:'Vt0', width:75, search:false,sortable:false,hidden: true}
,{name:'Vpeak0', index:'Vpeak0', width:75, search:false,sortable:false,hidden: true}
,{name:'Vmin0', index:'Vmin0', width:75, search:false,sortable:false,hidden: true}
,{name:'k1', index:'k1', width:75, search:false,sortable:false,hidden: true}
,{name:'a1', index:'a1', width:75, search:false,sortable:false,hidden: true}
,{name:'b1', index:'b1', width:75, search:false,sortable:false,hidden: true}
,{name:'d1', index:'d1', width:75, search:false,sortable:false,hidden: true}
,{name:'C1', index:'C1', width:75, search:false,sortable:false,hidden: true}
,{name:'Vr1', index:'Vr1', width:75, search:false,sortable:false,hidden: true}
,{name:'Vt1', index:'Vt1', width:75, search:false,sortable:false,hidden: true}
,{name:'Vpeak1', index:'Vpeak1', width:75, search:false,sortable:false,hidden: true}
,{name:'Vmin1', index:'Vmin1', width:75, search:false,sortable:false,hidden: true}
,{name:'G0', index:'G0', width:75, search:false,sortable:false,hidden: true}
,{name:'P0', index:'P0', width:75, search:false,sortable:false,hidden: true}
,{name:'k2', index:'k2', width:75, search:false,sortable:false,hidden: true}
,{name:'a2', index:'a2', width:75, search:false,sortable:false,hidden: true}
,{name:'b2', index:'b2', width:75, search:false,sortable:false,hidden: true}
,{name:'d2', index:'d2', width:75, search:false,sortable:false,hidden: true}
,{name:'C2', index:'C2', width:75, search:false,sortable:false,hidden: true}
,{name:'Vr2', index:'Vr2', width:75, search:false,sortable:false,hidden: true}
,{name:'Vt2', index:'Vt2', width:75, search:false,sortable:false,hidden: true}
,{name:'Vpeak2', index:'Vpeak2', width:75, search:false,sortable:false,hidden: true}
,{name:'Vmin2', index:'Vmin2', width:75, search:false,sortable:false,hidden: true}
,{name:'G1', index:'G1', width:75, search:false,sortable:false,hidden: true}
,{name:'P1', index:'P1', width:75, search:false,sortable:false,hidden: true}
,{name:'k3', index:'k3', width:75, search:false,sortable:false,hidden: true}
,{name:'a3', index:'a3', width:75, search:false,sortable:false,hidden: true}
,{name:'b3', index:'b3', width:75, search:false,sortable:false,hidden: true}
,{name:'d3', index:'d3', width:75, search:false,sortable:false,hidden: true}
,{name:'C3', index:'C3', width:75, search:false,sortable:false,hidden: true}
,{name:'Vr3', index:'Vr3', width:75, search:false,sortable:false,hidden: true}
,{name:'Vt3', index:'Vt3', width:75, search:false,sortable:false,hidden: true}
,{name:'Vpeak3', index:'Vpeak3', width:75, search:false,sortable:false,hidden: true}
,{name:'Vmin3', index:'Vmin3', width:75, search:false,sortable:false,hidden: true}
,{name:'G2', index:'G2', width:75, search:false,sortable:false,hidden: true}
,{name:'P2', index:'P2', width:75, search:false,sortable:false,hidden: true}
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
    //caption: 'Morphology Matrix',
    scrollerbar:false,
    height:"450",
    width:"900",
    shrinkToFit: true,
    gridComplete: function () {
    	var gridName = "nGrid"; // p the grid Name
    	Merger(gridName,"type");
      HideShowColumns();
		}
    });

  
 /* if(checkVersion()=="9")
  {
    var myGrid = $('#nGrid');
    var colModelVal = $("#nGrid").jqGrid('getGridParam','colModel');
    var colModelName = "";
    for(var i=11;i<=53;i++)
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
    for(var i=11;i<=53;i++)
    {
      colModelName = "#jqgh_nGrid_"+colModelVal[i].name;
      $(colModelName).addClass("rotate");
    }
  }*/
  $("#nGrid_CB").css("height","80");
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

function HideShowColumns ()
{

  var customWidth = screen.availWidth-300;
  var myGrid = $("#nGrid");
    $(document).ready(function() {
    myGrid.jqGrid('setGridParam', {scrollerbar: true});
    myGrid.jqGrid('setColProp', 'type', {frozen: true });
    myGrid.jqGrid('setColProp', 'NeuronType', {frozen: true })
    myGrid.jqGrid('setFrozenColumns');
    myGrid.jqGrid('setGridParam', {shrinkToFit: false});
  
  //myGrid.jqGrid('setGridParam', {autowidth: true});
});
  $("#checkbox1").click(function() {
  
    if ($("#checkbox1").is(':checked')) { 
      myGrid.setGridWidth(customWidth,false);  
      myGrid.jqGrid('setGridParam', {autowidth: true});
      myGrid.jqGrid('setGridParam', {shrinkToFit: false});

      myGrid.jqGrid('showCol', ["k0","a0","b0","d0","C0","Vr0","Vt0","Vpeak0","Vmin0","k1","a1","b1","d1","C1","Vr1","Vt1","Vpeak1","Vmin1","G0","P0","k2","a2","b2","d2","C2","Vr2","Vt2","Vpeak2","Vmin2","G1","P1","k3","a3","b3","d3","C3","Vr3","Vt3","Vpeak3","Vmin3","G2","P2"]);
      myGrid.jqGrid('hideCol', ["k"]);
      myGrid.jqGrid('hideCol', ["a"]);
      myGrid.jqGrid('hideCol', ["b"]);
      myGrid.jqGrid('hideCol', ["d"]);
      myGrid.jqGrid('hideCol', ["C"]);
      myGrid.jqGrid('hideCol', ["Vr"]);
      myGrid.jqGrid('hideCol', ["Vt"]);
      myGrid.jqGrid('hideCol', ["Vpeak"]);
      myGrid.jqGrid('hideCol', ["Vmin"]);
      myGrid.jqGrid('setGridParam', {scrollerbar: true});
      //myGrid.jqGrid('setColProp', 'type', {frozen: true });
      //myGrid.jqGrid('setColProp', 'NeuronType', {frozen: true });
      //myGrid.jqGrid('setFrozenColumns');
      //myGrid.jqGrid('setGridParam', {autowidth: true});
      
    }
    else {
      myGrid.jqGrid('destroyFrozenColumns')
      myGrid.jqGrid('showCol', ["k"]);
      myGrid.jqGrid('showCol', ["a"]);
      myGrid.jqGrid('showCol', ["b"]);
      myGrid.jqGrid('showCol', ["d"]);
      myGrid.jqGrid('showCol', ["C"]);
      myGrid.jqGrid('showCol', ["Vr"]);
      myGrid.jqGrid('showCol', ["Vt"]);
      myGrid.jqGrid('showCol', ["Vpeak"]);
      myGrid.jqGrid('showCol', ["Vmin"]);
      myGrid.jqGrid('hideCol', ["k0","a0","b0","d0","C0","Vr0","Vt0","Vpeak0","Vmin0","k1","a1","b1","d1","C1","Vr1","Vt1","Vpeak1","Vmin1","G0","P0","k2","a2","b2","d2","C2","Vr2","Vt2","Vpeak2","Vmin2","G1","P1","k3","a3","b3","d3","C3","Vr3","Vt3","Vpeak3","Vmin3","G2","P2"]);
      myGrid.setGridWidth("900",true);
      //myGrid.jqGrid('setGridParam', {autowidth: true});
      myGrid.jqGrid('setGridParam', {shrinkToFit: true});
      myGrid.jqGrid('setGridParam', {scrollerbar: true});
     
    }
  });

}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Izhikevich Matrix</title>
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
    <font id= "title" class="font1">Browse Izhikevich matrix</font>
    <input type="checkbox" value="check1" name="check1" id="checkbox1"><span>Multi Compartment Model</span>
  </form>
</div>

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
    </td>
	   <!-- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -->
		<td><font face="Verdana, Arial, Helvetica, sans-serif" color="#339900" size="2"> +/green: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Excitatory</font></td>
		&nbsp; &nbsp; 
		<td><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC0000" size="2"> -/red: </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Inhibitory</font></td>
  </tr>
	
</table>
</div>
</body>
</html>
<?php
mysqli_close($GLOBALS['conn']);
echo "<script>console.log('Is conn set ? ".mysqli_ping($GLOBALS['conn'])."');</script>";
?>
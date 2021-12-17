<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html" />

<?php 
  /* set json data to load */
  $matrix_type = "synaptic_distance";
  $session_matrix_cache_file = "synap_prob/gen_json/sd_db_results.json";
  $_SESSION[$matrix_type] = file_get_contents($session_matrix_cache_file);
  $jsonStr = $_SESSION[$matrix_type]; 
?>
<?php include_once("synap_prob/hco_header_1.php") ?>

<link rel="stylesheet" type="text/css" media="screen" href="synap_prob/css/main.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid_morph.css" />

<!-- ************* Start of Matrix Section ************* -->

<script type="text/javascript">
$(function(){
	$('#super_check').change(function() {
		var bgColorArray = ["","","#770000","#C08181","#FFFF99","#FF6103","#FFCC33","#336633",""];
		var fontColorArray = ["","","#FFFFFF","#FFFFFF","#000099","#000099","#000099","#FFFFFF",""];
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
	var dataStr = <?php echo $jsonStr?>;
		 var rotateFunction = function (grid, headerHeight) {
	 // we use grid as context (if one have more as one table on the page)
	 	var trHead = $("thead:first tr", grid.hdiv),
        cm = grid.getGridParam("colModel") ,
        ieVer = $.browser.version.substr(0, 3),
        iCol, cmi, headDiv,
        isSafariAndNotChrome = (($.browser.webkit || $.browser.safari) &&
                               !(/(chrome)[ \/]([\w.]+)/i.test(navigator.userAgent))); 

    
    headerHeight = $("thead:first tr th").height();
   for (iCol = 0; iCol < cm.length; iCol++) 
    {
        cmi = cm[iCol];
        // prevent text cutting based on the current column width
        headDiv = $("th:eq(" + iCol + ") div", trHead);
        if (!$.browser.msie || ieVer === "9.0" || document.documentMode >= 9) {
            headDiv.width(headerHeight)
                   .addClass("rotate")
                   .css("left",3);
        }
        else {
            // Internet Explorer 6.0-8.0 or Internet Explorer 9.0 in compatibility mode
            headDiv.width(headerHeight).addClass("rotateOldIE");
            if (ieVer === "8.0" || document.documentMode === 8) { // documentMode is important to test for IE compatibility mode
            	headDiv.width(headerHeight)
                .addClass("rotate")
                .css("left",3);
            } else {
                headDiv.css("left", 3);
            }
            headDiv.parent().css("zoom",1);
        } 
    }
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
	var table = "<?php if(isset($_REQUEST['table_result'])){echo $_REQUEST['table_result'];}?>";
	var head_col_width = 50;
	//alert(table);
	$grid = $("#nGrid"),
    fixPositionsOfFrozenDivs = function () {
        var $rows;
        if (typeof this.grid.fbDiv !== "undefined") {
            $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
            $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
                var rowHight = $($rows[i]).height(); 
                var rowHightFrozen = $(this).height();
                if ($(this).hasClass("jqgrow")) {
                    $(this).height(rowHight);
                    rowHightFrozen = $(this).height();
                    if (rowHight !== rowHightFrozen) {
                        $(this).height(rowHight + (rowHight - rowHightFrozen));
                    }
                }
            });
            $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
            $(this.grid.fbDiv).css($(this.grid.bDiv).position());
        }
        if (typeof this.grid.fhDiv !== "undefined") {
            $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
            $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
                var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
                $(this).height(rowHight);
                rowHightFrozen = $(this).height();
                if (rowHight !== rowHightFrozen) {
                    $(this).height(rowHight + (rowHight - rowHightFrozen));
                }
            });
            $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
            $(this.grid.fhDiv).css($(this.grid.hDiv).position());
        }
        $( "#frmCntr" ).remove();
        $( "#toCntr" ).remove();
    },
    resizeColumnHeader = function () {
        var rowHight, resizeSpanHeight,
            // get the header row which contains
            headerRow = $(this).closest("div.ui-jqgrid-view")
                .find("table.ui-jqgrid-htable>thead>tr.ui-jqgrid-labels");

        // reset column height
        headerRow.find("span.ui-jqgrid-resize").each(function () {
            this.style.height = '';
        });

        // increase the height of the resizing span
        resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
        headerRow.find("span.ui-jqgrid-resize").each(function () {
            this.style.cssText = resizeSpanHeight;
        });

        // set position of the dive with the column header text to the middle
        rowHight = headerRow.height();
        headerRow.find("div.ui-jqgrid-sortable").each(function () {
            var ts = $(this);
            ts.css('top', (rowHight - ts.outerHeight()) + 'px');
        });
    },
    fixGboxHeight = function () {
        var gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight(),
            pagerHeight = $(this.p.pager).outerHeight();

        $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
        gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight();
        pagerHeight = $(this.p.pager).outerHeight();
        $("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
    };

    $grid.jqGrid({
	datatype: "jsonstring",
	datastr: dataStr,
    colNames:['','<div id="frmCntr">Neuron Type</div>','<a href="parcel_page.php?parcel=SMo&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SMo</a>','<a href="parcel_page.php?parcel=SMi&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SMi</a>','<a href="parcel_page.php?parcel=SG&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SG</a>','<a href="parcel_page.php?parcel=H&subregion=DG&type=parcel" onClick="OpenInNewTab(this);" target="_blank">H</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SL&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SL</a>','<a href="parcel_page.php?parcel=SP&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA3&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SP&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA2&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SLM&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SLM</a>','<a href="parcel_page.php?parcel=SR&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SR</a>','<a href="parcel_page.php?parcel=SP&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=SO&subregion=CA1&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SO</a>','<a href="parcel_page.php?parcel=SM&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SM</a>','<a href="parcel_page.php?parcel=SP&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">SP</a>','<a href="parcel_page.php?parcel=PL&subregion=SUB&type=parcel" onClick="OpenInNewTab(this);" target="_blank">PL</a>','<a href="parcel_page.php?parcel=I&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">I</a>','<a href="parcel_page.php?parcel=II&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">II</a>','<a href="parcel_page.php?parcel=III&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">III</a>','<a href="parcel_page.php?parcel=IV&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">IV</a>','<a href="parcel_page.php?parcel=V&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">V</a>','<a href="parcel_page.php?parcel=VI&subregion=EC&type=parcel" onClick="OpenInNewTab(this);" target="_blank">VI</a>'],
    colModel :[
	  {name:'type', index:'type', width:50,sortable:false,frozen:true,cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'" + ' style="height:75px;"';  
      }, frozen:true},
      {name:'Neuron_Type', index:'Neuron_Type', width:200,sortable:false,frozen:true,
      cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="height:75px;"';
       }
   	  },
      //{name:'Supertype', index:'supertype', width:300,sortable:false,hidden: true},
          //,searchoptions: {sopt: ['bw','bn','cn','in','ni','ew','en','nc']}},
      {name:'SMo', index:'DG_SMo', width:head_col_width,search:false,sortable:false},
      {name:'SMi', index:'DG_SMi', width:head_col_width,height:250,search:false,sortable:false},
      {name:'SG', index:'DG_SG', width:head_col_width,height:150,search:false,sortable:false},
      {name:'H', index:'DG_H', width:head_col_width,height:150,search:false,sortable:false, 
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="border-right:medium solid #C08181;"';
       }
      },
      {name:'SLM', index:'CA3_SLM', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'SR', index:'CA3_SR', width:head_col_width,height:150,search:false,sortable:false},
      {name:'SL', index:'CA3_SL', width:head_col_width,height:150,search:false,sortable:false},
      {name:'SP', index:'CA3_SP', width:head_col_width,height:150,search:false,sortable:false},
      {name:'SO', index:'CA3_SO', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'2_SLM', index:'CA2_SLM', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'2_SR', index:'CA2_SR', width:head_col_width,height:150,search:false,sortable:false},
      {name:'2_SP', index:'CA2_SP', width:head_col_width,height:150,search:false,sortable:false},
      {name:'2_SO', index:'CA2_SO', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'1_SLM', index:'CA1_SLM', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
             return 'style="border-left:medium solid #770000;"';
       }},
      {name:'1_SR', index:'CA1_SR', width:head_col_width,height:150,search:false,sortable:false},
      {name:'1_SP', index:'CA1_SP', width:head_col_width,height:150,search:false,sortable:false},
      {name:'1_SO', index:'CA1_SO', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'SUB_SM', index:'SUB_SM', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                return 'style="border-left:medium solid #770000;"';
       }},
      {name:'SUB_SP', index:'SUB_SP', width:head_col_width,height:150,search:false,sortable:false},
      {name:'SUB_PL', index:'SUB_PL', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                   return 'style="border-right:medium solid #C08181;"';
       }},
      {name:'I', index:'EC_I', width:head_col_width,height:150,search:false,sortable:false,
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
                   return 'style="border-left:medium solid #770000;"';
       }},
      {name:'II', index:'EC_II', width:head_col_width,height:150,search:false,sortable:false},
      {name:'III', index:'EC_III', width:head_col_width,height:150,search:false,sortable:false},
      {name:'IV', index:'EC_IV', width:head_col_width,height:150,search:false,sortable:false},
      {name:'V', index:'EC_V', width:head_col_width,height:150,search:false,sortable:false},
      {name:'VI', index:'EC_VI', width:head_col_width,height:150,search:false,sortable:false}
 	], 
    //multiselect: true,
   /* pager: '#pager',*/
    rowNum:122,
    rowList:[122],
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
    shrinkToFit:false,
    height:"440",
    //width:"60%",
    width:"1050",
    gridComplete: function () {
    	var gridName = "nGrid"; // Access the grid Name
    	Merger(gridName,"type");
    	 $grid.jqGrid('setFrozenColumns');
    	 rotateFunction($grid,235); 
    	 fixPositionsOfFrozenDivs.call($grid[0]);    	
		}
    });
	jQuery("#nGrid").jqGrid('setGroupHeaders', { useColSpanStyle: true, 
		groupHeaders:[ 
		{startColumnName: 'Type', numberOfColumns: 2, titleText: '<b>Neuron Type<b>'},
		{startColumnName: 'SMo', numberOfColumns: 4, titleText: '<b><a id="dg_subregion" href="parcel_page.php?subregion=DG&type=subregion" onClick="OpenInNewTab(this);">DG</a><b>', ID: 'test',
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
            return ' style="background: rgb(119, 0, 0) !important;"';
       }},
		{startColumnName: 'SLM', numberOfColumns: 5, titleText: '<b><a id="ca3_subregion" href="parcel_page.php?subregion=CA3&type=subregion" onClick="OpenInNewTab(this);">CA3</a></b>'},
		{startColumnName: '2_SLM', numberOfColumns: 4, titleText: '<b><a id="ca2_subregion" href="parcel_page.php?subregion=CA2&type=subregion" onClick="OpenInNewTab(this);">CA2</a></b>'},
		{startColumnName: '1_SLM', numberOfColumns: 4, titleText: '<b><a id="ca1_subregion" href="parcel_page.php?subregion=CA1&type=subregion" onClick="OpenInNewTab(this);">CA1</a></b>'},
		{startColumnName: 'SUB_SM', numberOfColumns: 3, titleText: '<b><a id="sub_subregion" href="parcel_page.php?subregion=SUB&type=subregion" onClick="OpenInNewTab(this);">SUB</a></b>'},
		{startColumnName: 'I', numberOfColumns: 6, titleText: '<b><a id="ec_subregion" href="parcel_page.php?subregion=EC&type=subregion" onClick="OpenInNewTab(this);">EC</a></b>'}
		] 
	});
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
	
	var bgColorArray = ["","","#770000","#C08181","#FFFF99","#FF6103","#FFCC33","#336633",""];
	var fontColorArray = ["","","#FFFFFF","#FFFFFF","#000099","#000099","#000099","#FFFFFF",""];
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
	}
}); 
});

</script>

<!-- ************* End of Matrix Section ************* -->

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Somatic Distances of Dendrites and Axons</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>		

<div class='title_area'>
  <span style='position:relative;float:left;'><font class="font1">Browse synaptic connections matrix</font>&nbsp;&nbsp;&nbsp;&nbsp;</span>
<form name="main_matrix_selection"> 
<span class='top_matrix_menu'>  
<select name="matrix_selection" size="1" onChange="go()">
<option value="#" selected>Select Data</option>
<option value="synapse_probabilities_dal.php">Dendritic and Axonal Lengths</option>
<option value="synapse_probabilities_sd.php">Somatic Distances</option>
<option value="synapse_probabilities_ps.php">Number of Potential Synapses</option>
<option value="synapse_probabilities_noc.php">Number of Contacts</option>
<option value="synapse_probabilities_sypr.php">Synaptic Probabilities</option>
</select></span>

<span class='data_selection'>Somatic Distances of Dendrites and Axons</span>
</form>
</div>

<div class='table_position'>
<table border="0" cellspacing="0" cellpadding="0" class="tabellauno">
	<tr>
		<td>
			<table id="nGrid"></table>
		</td>	
  <?php echo file_get_contents('synap_prob/n_k_footer_1.php');?>
  <a href='synap_prob/data/sd_values.csv'><img id='csvCN' src='synap_prob/media/ExportCSV.png' width='30px' border='0'/></a></td><td><span style='float:left'><font class='font5'>&nbsp;CSV for the Somatic Distances of Dendrites and Axons</font></span>
  <?php echo file_get_contents('synap_prob/n_k_footer_2.php');?>
  </tr>
</table>
</div>
</body>
</html>

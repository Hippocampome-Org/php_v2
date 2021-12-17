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
  $matrix_type = "probabilities_of_synapses";
  $session_matrix_cache_file = "synap_prob/gen_json/ps_db_results.json";
  $_SESSION[$matrix_type] = file_get_contents($session_matrix_cache_file);
  $jsonStr = $_SESSION[$matrix_type]; 
?>
<?php 
  include_once("synap_prob/hco_header_1.php");
  include_once("synap_prob/synap_prob_params.php");
?>

<link rel="stylesheet" type="text/css" media="screen" href="synap_prob/css/main_nbyn.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="jqGrid-4/css/ui.jqgrid_morph.css" />
<style type="text/css">
.ui-jqgrid-hdiv {
  /*height:200px; !important;*/
  /*width:200px;*/
}
</style>

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
            cm = grid.getGridParam("colModel"),
            iCol, cmi, headDiv
        headerHeight = $("thead:first tr th").height();
        for (iCol = 0; iCol < cm.length; iCol++) 
        {
            cmi = cm[iCol];
            // prevent text cutting based on the current column width
            headDiv = $("th:eq(" + iCol + ") div", trHead);
            headDiv.width(headerHeight)
           .addClass("rotate")
           .css("left",3);
        }
        /*trHead = $("thead:second tr", grid.hdiv)
        headerHeight = $("thead:second tr th").height();
        for (iCol = 0; iCol < cm.length; iCol++) 
        {
            cmi = cm[iCol];
            // prevent text cutting based on the current column width
            headDiv = $("th:eq(" + iCol + ") div", trHead);
            headDiv.width(headerHeight)
           .addClass("rotate")
           .css("left",3);
        }*/
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
        //resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
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
    colNames:['','<div id="frmCntr_2">From</div><div id="toCntr_2" class="rotate">To</div>',
    <?php
      for ($i = 0; $i < count($neurons_with_links); $i++) {
        echo '"'.$neurons_with_links[$i].'"';
        if ($i != count($neurons_with_links)-1) {
          echo ", ";
        }
      }
    ?>
    ],
    colModel :[
	  {name:'type', index:'type', width:50,sortable:false,frozen:true,cellattr: function (rowId, tv, rawObject, cm, rdata) {
          return 'id=\'type' + rowId + "\'" + ' style="height:75px;"';  
      }, frozen:true},
      {name:'Neuron_Type_2', index:'Neuron_Type_2', width:200,sortable:false,frozen:true,
      cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
          return 'style="height:75px;"';
       }
   	  },
      //{name:'Supertype', index:'supertype', width:300,sortable:false,hidden: true},
          //,searchoptions: {sopt: ['bw','bn','cn','in','ni','ew','en','nc']}},
      <?php
        for ($i = 0; $i < count($neuron_IDs); $i++) {
          $neuron = str_replace(' ', '_', $neuron_IDs[$i]);
          echo "{name:'".$neuron."', index:'".$neuron."', width:head_col_width,search:false,sortable:false}";
          if ($i != count($neuron_IDs)-1) {
            echo ", ";
          }
        }
      ?>      
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
		{startColumnName: 'Granule', numberOfColumns: 18, titleText: '<b><a id="dg_subregion" href="parcel_page.php?subregion=DG&type=subregion" onClick="OpenInNewTab(this);">DG</a><b>', ID: 'test',
       cellattr: function(rowId, tv, rawObject, cm, rdata) 
       {
            return ' style="background: rgb(119, 0, 0) !important;"';
       }},
		{startColumnName: 'CA3_Pyramidal', numberOfColumns: 25, titleText: '<b><a id="ca3_subregion" href="parcel_page.php?subregion=CA3&type=subregion" onClick="OpenInNewTab(this);">CA3</a></b>'},
		{startColumnName: 'CA2_Pyramidal', numberOfColumns: 5, titleText: '<b><a id="ca2_subregion" href="parcel_page.php?subregion=CA2&type=subregion" onClick="OpenInNewTab(this);">CA2</a></b>'},
		{startColumnName: 'CA1_Pyramidal', numberOfColumns: 40, titleText: '<b><a id="ca1_subregion" href="parcel_page.php?subregion=CA1&type=subregion" onClick="OpenInNewTab(this);">CA1</a></b>'},
		{startColumnName: 'SUB_EC-Proj_Pyramidal', numberOfColumns: 3, titleText: '<b><a id="sub_subregion" href="parcel_page.php?subregion=SUB&type=subregion" onClick="OpenInNewTab(this);">SUB</a></b>'},
		{startColumnName: 'LI-II_Multipolar-Pyramidal', numberOfColumns: 31, titleText: '<b><a id="ec_subregion" href="parcel_page.php?subregion=EC&type=subregion" onClick="OpenInNewTab(this);">EC</a></b>'}
		] 
	});
  <?php include('synap_prob/nbyn_css_mods.php'); ?>
  
	if(checkVersion()=="9")
	{
		$("#jqgh_nGrid_Granule").addClass("rotateIE9");
	}
	else
	{
		$("#jqgh_nGrid_Granule").addClass("rotate");
    }
	
  <?php
    /*
    for ($i = 0; $i < count($neuron_IDs); $i++) {
      $neuron = str_replace(' ', '_', $neuron_IDs[$i]); //replace spaces
      echo "$('#jqgh_nGrid_".$neuron."').addClass('header_adjust');";
      echo "$('#jqgh_nGrid_".$neuron."').css('height','30');";
    }
    */
  ?>
	
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
<title>Number of Potential Synapses</title>
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

<span class='data_selection'>Number of Potential Synapses</span>
</form>
</div>

<div class='table_position'>
<table border="0" cellspacing="0" cellpadding="0" class="tabellauno">
	<tr>
		<td>
			<table id="nGrid"></table>
		</td>
  <?php echo file_get_contents('synap_prob/n_m_footer_1.php');?>
  <tr height="20">
        <td style="float:right"><a href='synap_prob/data/nops_values.csv'><img id='csvCN' src='synap_prob/media/ExportCSV.png' width='30px' border='0'/></a></td><td><span style='float:left'><font class='font5'>&nbsp;CSV for the Number of Potential Synapses</font></span></td> 
      </tr> 
	<?php echo file_get_contents('synap_prob/n_m_footer_2.php');?>
  </tr>
</table>
</div>
</body>
</html>
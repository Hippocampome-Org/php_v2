<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
//include ("access_db.php");
include ("function/quote_manipulation.php");
include ("function/markers/marker_helper.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.synonym.php');
require_once('class/class.fragment.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');
require_once('class/class.evidencemarkerdatarel.php');
require_once('class/class.markerdata.php');
require_once('class/class.evidenceevidencerel.php');
require_once('class/class.attachment.php');

function create_temp_table ($name_temporary_table)
{	
	$drop_table ="DROP TABLE $name_temporary_table";
	$query = mysqli_query($GLOBALS['conn'],$drop_table);
	
	$creatable=	"CREATE TABLE IF NOT EXISTS $name_temporary_table (
				   id int(4) NOT NULL AUTO_INCREMENT,
				   id_fragment varchar(10),
				   id_original varchar(20),
				   quote MEDIUMTEXT,
				   interpretation varchar(80),
				   interpretation_notes varchar(400),
				   linking_pmid_isbn varchar(80),
				   linking_pmid_isbn_page varchar(80),
				   linking_quote MEDIUMTEXT,
				   linking_page_location varchar(40),
				   authors varchar(600),
				   title MEDIUMTEXT,
				   publication varchar(100),
				   year varchar(30),
				   PMID varchar(25),
				   pages varchar(30),
				   page_location varchar(100),
				   id_markerdata varchar(10),
				   id_evidence1 varchar(20),
				   id_evidence2 varchar(20),
				   show1 varchar(5),
				   type varchar(20),
				   type_marker varchar (70),
				   color varchar (100),		
				   pmcid varchar (50),	
				   NIHMSID varchar (50),
				   doi varchar (150),
				   citation varchar(7), 
				   show2 varchar(4),  
				   show_button varchar(4),
				   volume varchar (20),
				   issue varchar (20),
           		   secondary_pmid varchar(50),
				   PRIMARY KEY (id));";
	$query = mysqli_query($GLOBALS['conn'],$creatable);	
}


function insert_temporary($table, $id_fragment, $id_original, $quote, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location, $authors, $title, $publication, $year, $PMID, $pages, $page_location, $id_markerdata, $id_evidence1, $id_evidence2, $type, $type_marker, $ccolor, $pmcid, $NIHMSID, $doi, $citation, $volume, $issue, $secondary_pmid)
{
		$quote = mysqli_real_escape_string($GLOBALS['conn'],$quote);
	$query_i = "INSERT INTO $table
	  (id,
	   id_fragment,
	   id_original,
	   quote,
	   interpretation,
	   interpretation_notes,
	   linking_pmid_isbn,
	   linking_pmid_isbn_page,
	   linking_quote,
	   linking_page_location,
	   authors,
	   title,
	   publication,
	   year,
	   PMID,
	   pages,
	   page_location,
	   id_markerdata,
	   id_evidence1,
	   id_evidence2,
	   show1,
	   type,
	   type_marker,
	   color,
	   pmcid,
	   NIHMSID,
	   doi,
	   citation,
	   show2,
	   show_button,
	   volume,
     issue,
     secondary_pmid)
	VALUES
	  (NULL,
	   '$id_fragment',
	   '$id_original',
	   '$quote',
	   '$interpretation',
	   '$interpretation_notes',
	   '$linking_pmid_isbn',
	   '$linking_pmid_isbn_page',
	   '$linking_quote',
	   '$linking_page_location',
	   '$authors',
	   '$title',
	   '$publication',
	   '$year',
	   '$PMID',
	   '$pages',
	   '$page_location',
	   '$id_markerdata',
	   '$id_evidence1',
	   '$id_evidence2',
	   '1',
	   '$type',
	   '$type_marker',
	   '$ccolor',
	   '$pmcid',
	   '$NIHMSID',
	   '$doi',
	   '$citation',
	   '1',
	   '0',
	   '$volume',
	   '$issue',
     '$secondary_pmid'
	   )";
	$rs2 = mysqli_query($GLOBALS['conn'],$query_i);
}


// STM
function header_row($title, $value) {
                $html = "
                <tr>
                <td width='15%'></td>	
                <td align='left' width='70%' class='table_neuron_page2'>				
                $title: $value
                </td>	
                <td width='15%'></td>
                </tr>";
                return $html;
              }
              
function header_row_special($title, $value) {
              	$html = "
              	<tr>
              	<td width='15%'></td>
              	<td align='left' width='70%' class='table_neuron_page2_special'>
              	$title: $value
              	</td>
              	<td width='15%'></td>
              	</tr>";
              	return $html;
              }              

$page = $_REQUEST['page'];
$sub_show_only = $_SESSION['conn_sub_show_only']; 
$name_show_only_article = $_SESSION['conn_name_show_only_article'];

if ($page)
{
	$name_show_only = 'all';
	$_SESSION['marker_name_show_only'] = $name_show_only;
	$sub_show_only = NULL;
	$_SESSION['marker_sub_show_only'] = $sub_show_only;	
	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';
	$name_show_only_authors = 'all';

	$id_neuron = $_REQUEST['id_neuron'];
	$val_property = $_REQUEST['val_property'];
	$color = $_REQUEST['color'];
	$valTitle = '';

	if ($val_property == 'Sub_P_Rec')
		$val_property = 'Sub P Rec';
	if ($val_property == 'GABAa_alfa')
		$val_property = 'Gaba-a-alpha';	
	if ($val_property == 'a-act2')
		$val_property = 'alpha-actinin-2';	
	if ($val_property == 'GAT_1')
		$val_property = 'GAT-1';	
 	if ($val_property == 'mGluR2_3')
		$val_property = 'mGluR2/3';	  		
	if (strpos($val_property,'\\') != false) {
		$valTitle = $val_property;
		$val_property = str_replace('\\', '\\\\', $val_property);
	}

	$_SESSION['id_neuron'] = $id_neuron;
	$_SESSION['val_property'] = $val_property;	
	$_SESSION['colore'] = $color;
	
	$color_table = remap_temp_table_names($color);
	
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	
	$color_temporary_table = str_replace('-', '', $color_table);	
	
	$time_t = time();
	
	$val_property_temp = str_replace('-', '', $val_property_temp);
	
	
	$name_temporary_table ='temp_'.$ip_address.'_'.$id_neuron.$val_property_temp.$color_temporary_table.'__'.$time_t;
	$_SESSION['marker_name_temporary_table'] = $name_temporary_table;
	create_temp_table ($name_temporary_table);

	// default order by:
	$order_by = "year";
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
	$name_show_only = $_SESSION['marker_name_show_only'];
	$_SESSION['marker_name_show_only'] = $name_show_only;
	$name_show_only_journal = $_SESSION['marker_name_show_only_journal'];
	$name_show_only_authors = $_SESSION['marker_name_show_only_authors'];
	$name_show_only_article = $_SESSION['marker_name_show_only_article'];

	$color=$_SESSION['colore'];	

	$order_ok = $_REQUEST['order_ok'];
	if ($order_ok == 'GO')             // Was clicked the Order By options
	{
		$order_by = $_REQUEST['order'];
		$_SESSION['order_by'] = $order_by;
		
		if ($order_by == 'year')
			$type_order = 'DESC';
		else
			$type_order = 'ASC';

		$_SESSION['type_order'] = $type_order;			
	}
	else{
		$order_by = $_SESSION['order_by'];
		$type_order = $_SESSION['type_order'];
	}

	$flag = $_REQUEST['flag'];
	
	$id_neuron = $_SESSION['id_neuron'];
	$val_property = $_SESSION['val_property'];

	
	$name_temporary_table = $_SESSION['marker_name_temporary_table'];
	$id_change = $_REQUEST['id_change'];

	// update the show1 variable in the temporary table:	
	if ($flag == 'on')
		$query = "UPDATE $name_temporary_table SET show1 = '1' WHERE id = '$id_change' ";	
	else
		$query = "UPDATE $name_temporary_table SET show1 = '0' WHERE id = '$id_change' ";
	
	$rs2 = mysqli_query($GLOBALS['conn'],$query);			
}


// -------------------------------------------------------------------------------------------------


$type = new type($class_type);
$type -> retrive_by_id($id_neuron);


$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

$evidencemarkerdatarel = new evidencemarkerdatarel($class_evidencemarkerdatarel);

$markerdata = new markerdata($class_markerdata);

$evidenceevidencerel = new evidenceevidencerel($class_evidenceevidencerel);

$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);

$fragment = new fragment($class_fragment);

$articleevidencerel = new articleevidencerel($class_articleevidencerel);

$article = new article($class_article);

$articleauthorrel = new articleauthorrel($class_articleauthorrel);

$author = new author($class_author);

$attachment_obj = new attachment($class_attachment);


// SHOW ONLY --------------------------------------------------------------
// ------------------------------------------------------------------------
$name_show_only_var = $_REQUEST['name_show_only_var'];

if ($name_show_only_var)
{
	$color = $_REQUEST['color'];

	$order_by = $_SESSION['order_by'];
	$type_order = $_SESSION['type_order'];

	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['marker_name_show_only'] = $name_show_only;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['marker_name_temporary_table'];
	
	$sub_show_only = $_REQUEST['sub_show_only'];
	$_SESSION['marker_sub_show_only'] = $sub_show_only;	
	

	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['marker_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$_SESSION['marker_name_show_only_article'] = $name_show_only_article;
		$sub_show_only = 'article';
		$_SESSION['marker_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$_SESSION['marker_name_show_only_journal']=$name_show_only_journal;
		$sub_show_only = 'name_journal';
		$_SESSION['marker_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$_SESSION['marker_name_show_only_authors'] = $name_show_only_authors;
		$sub_show_only = 'authors';
		$_SESSION['marker_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Morphology:
	if ($name_show_only == 'morphology')
	{
		$name_show_only_morphology = 'both';
		$sub_show_only = 'morphology';
		$_SESSION['marker_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
} // end if $name_show_only_var




// ARTICLE - BOOK OPTION
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$color = $_REQUEST['color'];
	$order_by = $_SESSION['order_by'];
	$type_order = $_SESSION['type_order'];

	$sub_show_only = $_SESSION['marker_sub_show_only'];
		
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['marker_name_show_only_article'] = $name_show_only_article;
	$_SESSION['marker_name_show_only_journal'] = 'all';
	$_SESSION['marker_name_show_only_authors'] = 'all';

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['marker_name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	
	$query ="SELECT id, PMID FROM $name_temporary_table";
	$rs = mysqli_query($GLOBALS['conn'],$query);					
	while(list($id, $pmid) = mysqli_fetch_row($rs))	
	{	
		if ($name_show_only_article == 'article')
		{
			if (strlen($pmid) > 10)
				$query = "UPDATE $name_temporary_table SET show2 =  '0' WHERE id = '$id'";
		}
		else if ($name_show_only_article == 'book')
		{
			if (strlen($pmid) < 10)
				$query = "UPDATE $name_temporary_table SET show2 =  '0' WHERE id = '$id'";
		}	
		else
			$query = "UPDATE $name_temporary_table SET show2 =  '1' WHERE id = '$id'";
				
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
} // end if $name_show_only_article


// JUORNAL OPTION
$name_show_only_journal_var = $_REQUEST['name_show_only_journal_var'];
if ($name_show_only_journal_var)
{
	$color = $_REQUEST['color'];
	$order_by = $_SESSION['order_by'];
	$type_order = $_SESSION['type_order'];

	$sub_show_only = $_SESSION['marker_sub_show_only'];
				
	$name_show_only_journal = $_REQUEST['name_show_only_journal'];
	$_SESSION['marker_name_show_only_journal'] = $name_show_only_journal;
	$_SESSION['marker_name_show_only_article'] = 'all';
	$_SESSION['marker_name_show_only_authors'] = 'all';

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['marker_name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show2 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
		
	if ($name_show_only_journal == 'all')
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
	else
		$query = "UPDATE $name_temporary_table SET show2 =  '0' WHERE publication != '$name_show_only_journal'";
	
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	

} // end if $name_show_only_journal
	
// AUTHORS OPTION
$name_show_only_authors_var  = $_REQUEST['name_show_only_authors_var'];
if ($name_show_only_authors_var)
{
	$color = $_REQUEST['color'];
	$order_by = $_SESSION['order_by'];
	$type_order = $_SESSION['type_order'];

	$sub_show_only = $_SESSION['marker_sub_show_only'];
			
	$name_show_only_authors = $_REQUEST['name_show_only_authors'];
	$_SESSION['marker_name_show_only_authors'] = $name_show_only_authors;
	$_SESSION['marker_name_show_only_article'] = 'all';
	$_SESSION['marker_name_show_only_journal'] = 'all';

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['marker_name_temporary_table'];


	if ($name_show_only_authors == 'all')
	{
		$query = "UPDATE $name_temporary_table SET show2 =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);		
	}
	else
	{
		$query = "UPDATE $name_temporary_table SET show2 =  '0'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
				
		$query ="SELECT id FROM $name_temporary_table WHERE authors LIKE '%$name_show_only_authors%'";
		$rs = mysqli_query($GLOBALS['conn'],$query);					
		while(list($id) = mysqli_fetch_row($rs))		
		{
			$query = "UPDATE $name_temporary_table SET show2 =  '1' WHERE id = '$id'";
			$rs2 = mysqli_query($GLOBALS['conn'],$query);
		}	
	}

} // end if $name_show_only_authors	

//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function show_only(link, color)
{
	var name=link[link.selectedIndex].value;
	var destination_page = "property_page_markers.php";

	location.href = destination_page+"?name_show_only="+name+"&name_show_only_var=1&color="+color;
}

function show_only_article(link, color)
{
	var name=link[link.selectedIndex].value;
	var destination_page = "property_page_markers.php";
	
	location.href = destination_page+"?name_show_only_article="+name+"&name_show_only_article_var=1&color="+color;
}

function show_only_publication(link, color)
{
	var name=link[link.selectedIndex].value;
	var destination_page = "property_page_markers.php";

	location.href = destination_page+"?name_show_only_journal="+name+"&name_show_only_journal_var=1&color="+color;
}

function show_only_authors(link, color)
{
	var name=link[link.selectedIndex].value;
	var destination_page = "property_page_markers.php";
	
	location.href = destination_page+"?name_show_only_authors="+name+"&name_show_only_authors_var=1&color="+color;
}

//Javascript function *****************************************************************************************************
//================changes===========================

function  singleevidencetoggle(btn,class_name){
	     var btn_id = btn.getAttribute( 'id' );
		 var btn_class = btn.className;
	     var btntoggle = document.getElementById(btn_id);
		 //alert(btntoggle.getAttribute('class'));
		 var element_to_hide = document.querySelectorAll('[class$="tab_' + class_name +'"]');
		if(btn_class == "show1")
		{	    	
			for(var l=0;l<element_to_hide.length;l++){
				element_to_hide[l].style.display = 'table';
			}
			btntoggle.style.display = "none";
			 var btntoggle0 = document.getElementById('btntoggle0_' + class_name);
			 //alert (btntoggle0.getAttribute('class'));
			 btntoggle0.style.display = "block";
		}
		else
		{ 
	         // alert(btntoggle.className);
			for(var l=0;l<element_to_hide.length;l++){
				element_to_hide[l].style.display = 'none';
			}
			btntoggle.style.display = "none";
			 var btntoggle1 = document.getElementById('btntoggle1_' + class_name);
			// alert(btntoggle1.className);
			 btntoggle1.style.display = "block";
			
		}
			
}

function evidencetoggleclose(){
var arr_animal = ["mouse", "rat", "unspecified_rodent"];
var arr_protocol = ["immunohistochemistry", "mRNA", "immunohistochemistry_mRna","unknown"];
var arr_expression = ["positive", "negative", "positive_negative","weak_positive"];
var class_name_hide;

			for(var i=0;i<arr_animal.length;i++){							
				for(var j=0;j<arr_protocol.length;j++){
					for(var k=0;k<arr_expression.length;k++){
						class_name_hide = arr_animal[i] + "_" + arr_protocol[j] + "_" + arr_expression[k];
						var element_to_hide = document.querySelectorAll('*[class^="' + class_name_hide +'"]');
				    	//var element_to_hide= document.getElementsByClassName(arr_animal[i] + "_" + arr_protocol[j] + "_" + arr_expression[k]);
						for(var l=0;l<element_to_hide.length;l++){
				            element_to_hide[l].style.display = 'none';
						}
				    }
		        }
			}
			
			var button_to_hide = document.querySelectorAll('*[id^=btntoggle0]');
			var button_to_show = document.querySelectorAll('*[id^=btntoggle1]');
			for(var l=0;l<button_to_hide.length;l++){
				            button_to_hide[l].style.display = 'none';
			}
			for(var l=0;l<button_to_show.length;l++){
				            button_to_show[l].style.display = 'block';
			}
}

function evidencetoggle(){
var animal_select_value     = document.getElementById('animal_select').value;
var protocol_select_value   = document.getElementById('protocol_select').value;
var expression_select_value =  document.getElementById('expression_select').value;
var arr_animal = ["mouse", "rat", "unspecified_rodent"];
var arr_protocol = ["immunohistochemistry", "mRNA", "immunohistochemistry_mRna","unknown"];
var arr_expression = ["positive", "negative", "positive_negative","weak_positive"];
var class_name_hide,class_name_show,element_to_hide,button_to_hide,button_to_show;

			for(var i=0;i<arr_animal.length;i++){							
				for(var j=0;j<arr_protocol.length;j++){
					for(var k=0;k<arr_expression.length;k++){
						class_name_hide = arr_animal[i] + "_" + arr_protocol[j] + "_" + arr_expression[k];
						element_to_hide = document.querySelectorAll('*[class^="' + class_name_hide +'"]');
						button_to_hide = document.querySelectorAll('*[id^=btntoggle0]');
						button_to_show = document.querySelectorAll('*[id^=btntoggle1]');				    	
						for(var l=0;l<element_to_hide.length;l++){
				            element_to_hide[l].style.display = 'none';
						}
						for(var l=0;l<button_to_hide.length;l++){
				            button_to_hide[l].style.display = 'none';
							button_to_show[l].style.display = 'block';
						}
				    }
		        }
			}
var arr_animal_to_show,arr_protocol_to_show, arr_expression_to_show;
var index,previndex = 0, element_class,element_to_show;

if(animal_select_value == "all")
  arr_animal_to_show = ["mouse", "rat", "unspecified_rodent"];
else {
  arr_animal_to_show = new Array(1);
  arr_animal_to_show[0] = animal_select_value;
}

if(protocol_select_value == "all")
  arr_protocol_to_show = ["immunohistochemistry", "mRNA", "immunohistochemistry_mRNA","unknown"];
 else if (protocol_select_value =="immunohistochemistry and mRNA")
  arr_protocol_to_show = ["immunohistochemistry_mRNA"];
 else
 {
  arr_protocol_to_show = new Array(1);
  arr_protocol_to_show[0] = protocol_select_value;
 }
	
if(expression_select_value =="all")
	 arr_expression_to_show = ["positive", "negative", "positive_negative", "weak_positive"];
else if (expression_select_value == "positive and negative")
	arr_expression_to_show = ["positive_negative","weak_positive"];
else {
	arr_expression_to_show = new Array(2);
	arr_expression_to_show[0] = expression_select_value;
	arr_expression_to_show[2] = "weak_positive";
}

			for(var i=0;i<arr_animal_to_show.length;i++){							
				for(var j=0;j<arr_protocol_to_show.length;j++){
					for(var k=0;k<arr_expression_to_show.length;k++){
						class_name_show = arr_animal_to_show[i] + "_" + arr_protocol_to_show[j] + "_" + arr_expression_to_show[k];
						 element_to_show = document.querySelectorAll('*[class^="' + class_name_show +'"]');
				    	//var element_to_show= document.getElementsByClassName(arr_animal_to_show[i] + "_" + arr_protocol_to_show[j] + "_" + arr_expression_to_show[k]);
						for(var l=0;l<element_to_show.length;l++){
				            element_to_show[l].style.display = 'table';
							element_class = element_to_show[l].className;
							index = element_class.lastIndexOf("_");							
							var button_to_hide = document.getElementById("btntoggle1"+ element_class.substring(index));
							var button_to_show = document.getElementById("btntoggle0"+ element_class.substring(index));
							button_to_hide.style.display = "none";
							button_to_show.style.display = "block";
							previndex = index;
							
						}
				    }
		        }
			} 

}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type->getNickname();
	print("<title>Evidence - $name ($val_property)</title>");
?>

<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	

<div class='title_area'>
	<font class="font1">Molecular markers evidence page</font>
</div>

<!-- 
<div align="center" class="title_3">
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<font size='5' color="#990000" face="Verdana, Arial, Helvetica, sans-serif">Evidence Page</font>
		</td>
	</tr>
	</table>
</div>
-->

<br><br /><br><br />
<!-- ---------------------- -->

<table width="85%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr height="40">
    <td></td>
  </tr>
  <tr>
    <td align="center">
		<!-- ****************  BODY **************** -->

		<!-- TABLE NAME AND PROPERTY-->
		<table width="80%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="20%" align="right" class="table_neuron_page1">
					Neuron Type &nbsp;
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					<?php			
					    $id=$type->getId();
						$name=$type->getName();
						print("<a href='neuron_page.php?id=$id'>$name</a>");
					 ?>
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right">&nbsp;</td>
				<td align="left" width="80%" class="table_neuron_page2"><strong>Hippocampome Neuron ID: <?php echo $id?></strong></td>
			</tr>	
			<tr>
				<td width="20%" align="right" valign="top" class="table_neuron_page1">
					<?php
						if (strpos($val_property,'\\') != false) {
							print ("$valTitle Expression &nbsp;");
						} else {
						if ($val_property == 'Gaba-a-alpha')
							print ("GABAa &alpha;1 Expression &nbsp;");
						else if ($val_property == 'alpha-actinin-2')
							print ("&alpha;-act2 Expression &nbsp;");
						else
							print ("$val_property Expression &nbsp;");
						}
					?>
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					<?php			  

		              $type_id = $type -> getId();
		              $subject = $val_property;
		              $predicate = 'has expression';
		                            
		              
		              // look at calls for evidence and build summary arrays
		              	
		              $pos_summary = Array( Array(0, 0), Array (0, 0));
		              $pos_summary[0][0] = 0;
		              $pos_summary[0][1] = 0;
		              $pos_summary[1][0] = 0;
		              $pos_summary[1][1] = 0;
		              $neg_summary = Array( Array(0, 0), Array (0, 0));
		              $neg_summary[0][0] = 0;
		              $neg_summary[0][1] = 0;
		              $neg_summary[1][0] = 0;
		              $neg_summary[1][1] = 0;
		              $mixed_summary = Array( Array(0, 0), Array (0, 0));
		              $mixed_summary[0][0] = 0;
		              $mixed_summary[0][1] = 0;
		              $mixed_summary[1][0] = 0;
		              $mixed_summary[1][1] = 0;
		              
		              // positive +
		              $property -> retrive_ID(2, $subject, 'has expression', 'positive');
		              $property_id_pos = $property -> getProperty_id(0);
		              $num_ids_pos = $property -> getNumber_type();	// should be 1, or 0 if id for this marker (positive) is not in DB
		              	
		              if ($num_ids_pos > 0) {
		              	$evidencepropertyyperel -> retrive_evidence_id($property_id_pos, $type_id);
		              	$n_id_evidence = $evidencepropertyyperel -> getN_evidence_id();
		              }
		              else
		              	$n_id_evidence = 0;
		              
		              for ($i=0; $i<$n_id_evidence; $i++) {
		              	$id_this_evidence = $evidencepropertyyperel -> getEvidence_id_array($i);
		              	$evidencemarkerdatarel -> retrive_Markerdata_id($id_this_evidence);
		              	$id_markerdata1 = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
		              	$markerdata -> retrive_info($id_markerdata1);
		              
		              	$expression = $markerdata -> getExpression();
		              	$expression = preg_replace('/[\[\]"]/', '', $expression);
		              	$animal = $markerdata -> getAnimal();
		              	$animal = preg_replace('/[\[\]"]/', '', $animal);
		              	$protocol = $markerdata -> getProtocol();
		              	$protocol = preg_replace('/[\[\]"]/', '', $protocol);
		              
		              	if ($expression != "positive, negative") {
		              		if ($protocol != "unknown") {
		              			if ($animal=="rat" && $protocol=="immunohistochemistry") $pos_summary[0][0]++;
		              			elseif ($animal=="rat" && $protocol=="mRNA") $pos_summary[0][1]++;
		              			elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $pos_summary[1][0]++;
		              			elseif ($animal=="mouse" && $protocol=="mRNA") $pos_summary[1][1]++;
		              		}
		              	}
		              	else {
		              		if ($protocol != "unknown") {
		              			if ($animal=="rat" && $protocol=="immunohistochemistry") $mixed_summary[0][0]++;
		              			elseif ($animal=="rat" && $protocol=="mRNA") $mixed_summary[0][1]++;
		              			elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $mixed_summary[1][0]++;
		              			elseif ($animal=="mouse" && $protocol=="mRNA") $mixed_summary[1][1]++;
		              		}
		              	}
		              }
		              
		              
		              // negative -
		              $property -> retrive_ID(2, $subject, 'has expression', 'negative');
		              $property_id_neg = $property -> getProperty_id(0);
		              $num_ids_neg = $property -> getNumber_type();	// should be 1, or 0 if id for this marker (positive) is not in DB
		              	
		              if ($num_ids_neg > 0) {
		              	$evidencepropertyyperel -> retrive_evidence_id($property_id_neg, $type_id);
		              	$n_id_evidence = $evidencepropertyyperel -> getN_evidence_id();
		              }
		              else
		              	$n_id_evidence = 0;		              
		              	
		              for ($i=0; $i<$n_id_evidence; $i++) {
		              	$id_this_evidence = $evidencepropertyyperel -> getEvidence_id_array($i);
		              	$evidencemarkerdatarel -> retrive_Markerdata_id($id_this_evidence);
		              	$id_markerdata1 = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
		              	$markerdata -> retrive_info($id_markerdata1);
		              
		              	$expression = $markerdata -> getExpression();
		              	$expression = preg_replace('/[\[\]"]/', '', $expression);
		              	$animal = $markerdata -> getAnimal();
		              	$animal = preg_replace('/[\[\]"]/', '', $animal);
		              	$protocol = $markerdata -> getProtocol();
		              	$protocol = preg_replace('/[\[\]"]/', '', $protocol);
		              
		              	if ($expression != "positive, negative") {
		              		if ($protocol != "unknown") {
		              			if ($animal=="rat" && $protocol=="immunohistochemistry") $neg_summary[0][0]++;
		              			elseif ($animal=="rat" && $protocol=="mRNA") $neg_summary[0][1]++;
		              			elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $neg_summary[1][0]++;
		              			elseif ($animal=="mouse" && $protocol=="mRNA") $neg_summary[1][1]++;
		              		}
		              	}
		              }
		              
		              
		              // property has expression positive_inference
		              $property -> retrive_ID(2, $subject, 'has expression', 'positive_inference');
		              $property_id_pos = $property -> getProperty_id(0);
		              $num_ids_pos = $property -> getNumber_type();	// should be 1, or 0 if id for this marker (positive) is not in DB
		               
		              if ($num_ids_pos > 0) {
		              	$evidencepropertyyperel -> retrive_evidence_id($property_id_pos, $type_id);
		              	$n_id_evidence = $evidencepropertyyperel -> getN_evidence_id();
		              }
		              else
		              	$n_id_evidence = 0;
		              
		              	for ($i=0; $i<$n_id_evidence; $i++) {
		              		$id_this_evidence = $evidencepropertyyperel -> getEvidence_id_array($i);
		              		$evidencemarkerdatarel -> retrive_Markerdata_id($id_this_evidence);
		              		$id_markerdata1 = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
		              		$markerdata -> retrive_info($id_markerdata1);
		              
		              		$expression = $markerdata -> getExpression();
		              		$expression = preg_replace('/[\[\]"]/', '', $expression);
		              		$animal = $markerdata -> getAnimal();
		              		$animal = preg_replace('/[\[\]"]/', '', $animal);
		              		$protocol = $markerdata -> getProtocol();
		              		$protocol = preg_replace('/[\[\]"]/', '', $protocol);
		              
		              		if ($expression != "positive, negative") {
		              			if ($protocol != "unknown") {
		              				if ($animal=="rat" && $protocol=="immunohistochemistry") $pos_summary[0][0]++;
		              				elseif ($animal=="rat" && $protocol=="mRNA") $pos_summary[0][1]++;
		              				elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $pos_summary[1][0]++;
		              				elseif ($animal=="mouse" && $protocol=="mRNA") $pos_summary[1][1]++;
		              			}
		              		}
		              		else {
		              			if ($protocol != "unknown") {
		              				if ($animal=="rat" && $protocol=="immunohistochemistry") $mixed_summary[0][0]++;
		              				elseif ($animal=="rat" && $protocol=="mRNA") $mixed_summary[0][1]++;
		              				elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $mixed_summary[1][0]++;
		              				elseif ($animal=="mouse" && $protocol=="mRNA") $mixed_summary[1][1]++;
		              			}
		              		}
		              	}
		              	
		              	
		              // property has expression negative_inference
		              $property -> retrive_ID(2, $subject, 'has expression', 'negative_inference');
		              $property_id_neg = $property -> getProperty_id(0);
		              $num_ids_neg = $property -> getNumber_type();	// should be 1, or 0 if id for this marker (positive) is not in DB
		               
		              if ($num_ids_neg > 0) {
		              	$evidencepropertyyperel -> retrive_evidence_id($property_id_neg, $type_id);
		              	$n_id_evidence = $evidencepropertyyperel -> getN_evidence_id();
		              }
		              else
		              	$n_id_evidence = 0;
		              	 
		              	for ($i=0; $i<$n_id_evidence; $i++) {
		              		$id_this_evidence = $evidencepropertyyperel -> getEvidence_id_array($i);
		              		$evidencemarkerdatarel -> retrive_Markerdata_id($id_this_evidence);
		              		$id_markerdata1 = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
		              		$markerdata -> retrive_info($id_markerdata1);
		              
		              		$expression = $markerdata -> getExpression();
		              		$expression = preg_replace('/[\[\]"]/', '', $expression);
		              		$animal = $markerdata -> getAnimal();
		              		$animal = preg_replace('/[\[\]"]/', '', $animal);
		              		$protocol = $markerdata -> getProtocol();
		              		$protocol = preg_replace('/[\[\]"]/', '', $protocol);
		              
		              		if ($expression != "positive, negative") {
		              			if ($protocol != "unknown") {
		              				if ($animal=="rat" && $protocol=="immunohistochemistry") $neg_summary[0][0]++;
		              				elseif ($animal=="rat" && $protocol=="mRNA") $neg_summary[0][1]++;
		              				elseif ($animal=="mouse" && $protocol=="immunohistochemistry") $neg_summary[1][0]++;
		              				elseif ($animal=="mouse" && $protocol=="mRNA") $neg_summary[1][1]++;
		              			}
		              		}
		              	}
		              	
		              	
		              $total_pos_evid = $pos_summary[0][0] + $pos_summary[0][1] + $pos_summary[1][0] + $pos_summary[1][1];
		              $total_neg_evid = $neg_summary[0][0] + $neg_summary[0][1] + $neg_summary[1][0] + $neg_summary[1][1];
		              $total_mixed_evid = $mixed_summary[0][0] + $mixed_summary[0][1] + $mixed_summary[1][0] + $mixed_summary[1][1];
		              
		              	if ( ($total_pos_evid > 0 && ($total_neg_evid > 0 || $total_mixed_evid > 0)) ||
	              		($total_neg_evid > 0 && ($total_pos_evid > 0 || $total_mixed_evid > 0)) ||
		              	($total_mixed_evid > 0 && ($total_pos_evid > 0 || $total_neg_evid > 0)) )
	              			$individual_calls_conflict = 1;
	              		else
	              			$individual_calls_conflict = 0;

		              
		              // handle mixed flag explanation notes
		              
		              //$expression_values = explode('-', $_REQUEST['color']);
		              $expression_values = explode('-', $color);
		              $object = $expression_values[0];
		              $property -> retrive_ID(2, $subject, $predicate, $object);
		              $property_id = $property -> getProperty_id(0);
		              
		              $conflict_note = $evidencepropertyyperel -> retrieve_conflict_note($property_id, $type_id);
		              $conflict_note = $evidencepropertyyperel -> getConflict_note();
		              $conflict_explanation_statement = $evidencepropertyyperel -> retrieve_property_type_explanation($property_id, $type_id);
		              $conflict_explanation_statement = $evidencepropertyyperel -> getProperty_type_explanation();
		              
		              if (($conflict_note == "positive") || ($conflict_note == "negative")) {
		              	$print_color = $conflict_note;
		              	
		              	if ($conflict_note=="positive")
		              		$image_link = "<img src='images/marker/positive_clear.png' border='0' width='8px' />";
	              		elseif ($conflict_note=="negative")
	              			$image_link = "<img src='images/marker/negative_clear.png' border='0' width='8px' />";
	              		
              			$mixed_data = false;
              			$conflict_note = "";
              			$conflict_explanation_statement = "";
		              	
		              	if ($individual_calls_conflict)
		              		$dissent_note = "* Contradictory evidence exists (open all evidence to view)";
		              	else
		              		$dissent_note = NULL;
		              }
		              
		              elseif (($conflict_note == "confirmed positive") || ($conflict_note == "confirmed negative")) {
		              	if ($conflict_note == "confirmed positive") {
		              		$print_color = "positive";
		              		$image_link = "<img src='images/marker/positive_confirmed_clear.png' border='0' width='8px' />";
		              	}
	              		elseif ($conflict_note == "confirmed negative") {
	              			$print_color = "negative";
	              			$image_link = "<img src='images/marker/negative_confirmed_clear.png' border='0' width='8px' />";
	              		}              			
	              		
              			$mixed_data = false;
              			$conflict_note = "; confirmed by inference(s)";
              			$conflict_explanation_statement = "";
		              	
		              	if ($individual_calls_conflict)
		              		$dissent_note = "* Contradictory evidence exists (open all evidence to view)";
		              	else
		              		$dissent_note = NULL;
		              }
		              
		              elseif (($conflict_note == "positive inference") || ($conflict_note == "negative inference")) {
		              	$print_color = $conflict_note;
		              	 
		              	if ($conflict_note=="positive inference")
		              		$image_link = "<img src='images/marker/positive_inference_clear.png' border='0' width='8px' />";
	              		elseif ($conflict_note=="negative inference")
	              			$image_link = "<img src='images/marker/negative_inference_clear.png' border='0' width='8px' />";
	              		
              			$mixed_data = false;
              			$conflict_note = "";
              			$conflict_explanation_statement = "";
		              }
		              
		              elseif (($conflict_note == "confirmed positive inference") || ($conflict_note == "confirmed negative inference")) {
		              	if ($conflict_note=="confirmed positive inference") {
		              		$print_color = "positive inference";
		              		$image_link = "<img src='images/marker/positive_inference_confirm_clear.png' border='0' width='8px' />";
		              	}
	              		elseif ($conflict_note=="confirmed negative inference") {
	              			$print_color = "negative inference";
		              		$image_link = "<img src='images/marker/negative_inference_confirm_clear.png' border='0' width='8px' />";
	              		}
		              		 
	              		$mixed_data = false;
	              		$conflict_note = "; confirmed by additional inferences";
	              		$conflict_explanation_statement = "";
		              }

		              // mixed data
		              else {
						if ($conflict_note == "species/protocol differences")
		              		$image_link = "<img src='images/marker/positive-negative-species_clear.png' border='0' width='15px' />";
		              	elseif ($conflict_note == "subcellular expression differences")
		              		$image_link = "<img src='images/marker/positive-negative-subcellular_clear.png' border='0' width='15px' />";
		              	elseif ($conflict_note == "subtypes")
		              		$image_link = "<img src='images/marker/positive-negative-subtypes_clear.png' border='0' width='15px' />";
		              	elseif (($conflict_note == "conflicting data") || ($conflict_note == "unresolved")) {
		              		$image_link = "<img src='images/marker/positive-negative-conflicting_clear.png' border='0' width='15px' />";
		              		$conflict_explanation_statement = "Data come from multiple sources that use the same species and technique; however, non-identical experimental details (e.g., the antibodies used) prevent interpretation.";
		              	}
		              	elseif ($conflict_note == "positive; negative inference")
		              		$image_link = "<img src='images/marker/positive-negative_inference_clear.png' border='0' width='15px' />";
	              		elseif ($conflict_note == "positive inference; negative")
		              		$image_link = "<img src='images/marker/positive_inference-negative_clear.png' border='0' width='15px' />";
	              		elseif ($conflict_note == "positive inference; negative inference") {
		              		$image_link = "<img src='images/marker/positive_inference-negative_inference-subtypes_clear.png' border='0' width='15px' />";
		              		$conflict_note = "inferential conflict likely due to subtypes";
	              		}
	              		elseif ($conflict_note == "unresolved inferential conflict")
		              		$image_link = "<img src='images/marker/positive_inference-negative_inference-unresolved_clear.png' border='0' width='15px' />";
	              		elseif ($conflict_note == "species/protocol inferential conflict")
		              		$image_link = "<img src='images/marker/positive_inference-negative_inference-species_clear.png' border='0' width='15px' />";
		              	
		              	 
		              	$mixed_data = true;
		              	$print_color = "positive-negative";
		              	$conflict_note = ": " . $conflict_note;
		              	$dissent_note = NULL;
		              }
		              
		              print ("$image_link&nbsp;<strong>$print_color$conflict_note</strong>");
		              
		              if ($dissent_note)
		              	print ("<BR>$dissent_note");
		              if ($conflict_explanation_statement)
		              	print ("<BR>Explanation: $conflict_explanation_statement");
		              
		              
		              
		              // print summary arrays for debugging and vetting
		              
		              list($permission) = mysqli_fetch_row(mysqli_query($GLOBALS['conn'],"SELECT permission FROM user WHERE id = '2'"));
		              if ($permission == 0) { // only enabled for curation, where anonymous user is disabled

						// table containing both table options
		              	echo "<TABLE> <TR> <TD width='7%'></TD> <TD width='44%'>";
		              
		              	// first table option
		              	echo "<HR><TABLE class='table_neuron_page2' padding='10'>";
		              	
		              	echo "<TR> <TD valign='top'> <TABLE><TR><TD><strong>Positive</strong></TD></TR></TABLE> </TD>";
		              	echo "<TD valign='top'><TABLE><TR>";
		              	if ($total_pos_evid > 0) {	              						
			              	if ($pos_summary[0][0] > 0) {echo "<TD>Rat;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $pos_summary[0][0] . "]</TD></TR>";}
			              	if ($pos_summary[0][1] > 0) {echo "<TD>Rat;</TD> <TD>mRNA</TD> <TD>[" . $pos_summary[0][1] . "]</TD></TR>";}
			              	if ($pos_summary[1][0] > 0) {echo "<TD>Mouse;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $pos_summary[1][0] . "]</TD></TR>";}
			              	if ($pos_summary[1][1] > 0) {echo "<TD>Mouse;</TD> <TD>mRNA</TD> <TD>[" . $pos_summary[1][1] . "]</TD></TR>";}
			              	echo "</TABLE>";	              	
		              	}
		              	else
		              		 echo "<TD>(none)</TD></TR> </TABLE>";
		              	
		              	echo "<TR> <TD valign='top'> <TABLE><TR><TD><strong>Negative</strong></TD></TR></TABLE> </TD>";
		              	echo "<TD valign='top'><TABLE><TR>";
		              	if ($total_neg_evid > 0) {              	
			              	if ($neg_summary[0][0] > 0) {echo "<TD>Rat;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $neg_summary[0][0] . "]</TD></TR>";}
			              	if ($neg_summary[0][1] > 0) {echo "<TD>Rat;</TD> <TD>mRNA</TD> <TD>[" . $neg_summary[0][1] . "]</TD></TR>";}
			              	if ($neg_summary[1][0] > 0) {echo "<TD>Mouse;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $neg_summary[1][0] . "]</TD></TR>";}
			              	if ($neg_summary[1][1] > 0) {echo "<TD>Mouse;</TD> <TD>mRNA</TD> <TD>[" . $neg_summary[1][1] . "]</TD></TR>";}
			              	echo "</TABLE>";
			            }
			            else
			            	echo "<TD>(none)</TD></TR> </TABLE>";
			              		
			            echo "<TR> <TD valign='top'> <TABLE><TR><TD><strong>Mixed</strong></TD></TR></TABLE> </TD>";
			            echo "<TD valign='top'><TABLE><TR>";
		              	if ($total_mixed_evid > 0) {
			              	if ($mixed_summary[0][0] > 0) {echo "<TD>Rat;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $mixed_summary[0][0] . "]</TD></TR>";}
			              	if ($mixed_summary[0][1] > 0) {echo "<TD>Rat;</TD> <TD>mRNA</TD> <TD>[" . $mixed_summary[0][1] . "]</TD></TR>";}
			              	if ($mixed_summary[1][0] > 0) {echo "<TD>Mouse;</TD> <TD>Immunohistochemistry</TD> <TD>[" . $mixed_summary[1][0] . "]</TD></TR>";}
			              	if ($mixed_summary[1][1] > 0) {echo "<TD>Mouse;</TD> <TD>mRNA</TD> <TD>[" . $mixed_summary[1][1] . "]</TD></TR>";}
			              	echo "</TABLE>";
			            }
			            else
			            	echo "<TD>(none)</TD></TR> </TABLE>";
			            
		              	echo "</TD></TR></TABLE> <HR>";
		              
		              	
		              	// Empty TD between table options
		              	echo "</TD> <TD width='5%'></TD> <TD width='44%'>";
		              	 
		              	//Second table option
		              	echo "<HR><TABLE class='table_neuron_page2' padding='10' width=300> <TR> <TD width='20%'></TD> <TD width='35%'><center><strong>Immunohistochemistry</strong></center></TD> <TD width='10%'></TD> <TD width='35%'><center><strong>mRNA</strong></center></TD> </TR>";
		              	echo "<TR> <TD><strong>Rat</strong></TD> <TD><center>";
		              	 
		              	//if rat & immuno
		              	if ($pos_summary[0][0] > 0 && $neg_summary[0][0] > 0 && $mixed_summary[0][0] > 0)
		              		echo "Pos. [" . $pos_summary[0][0] . "]; Neg. [" . $neg_summary[0][0] . "]; Mixed [" . $mixed_summary[0][0] . "]";
		              	elseif ($pos_summary[0][0] > 0 && $neg_summary[0][0] > 0)
		              		echo "Pos. [" . $pos_summary[0][0] . "]; Neg. [" . $neg_summary[0][0] . "]";
		              	elseif ($pos_summary[0][0] > 0 && $mixed_summary[0][0] > 0)
		              		echo "Pos. [" . $pos_summary[0][0] . "]; Mixed [" . $mixed_summary[0][0] . "]";
		              	elseif ($neg_summary[0][0] > 0 && $mixed_summary[0][0] > 0)
		              		echo "Neg. [" . $neg_summary[0][0] . "]; Mixed [" . $mixed_summary[0][0] . "]";
		              	elseif ($pos_summary[0][0] > 0) echo "Pos. [" . $pos_summary[0][0] . "]";
		              	elseif ($neg_summary[0][0] > 0) echo "Neg. [" . $neg_summary[0][0] . "]";
		              	elseif ($mixed_summary[0][0] > 0) echo "Mix [" . $mixed_summary[0][0] . "]";
		              	else echo "unknown";
		              	echo "</center></TD> <TD></TD> <TD><center>";
		              	 
		              	//if rat & mRna
		              	if ($pos_summary[0][1] > 0 && $neg_summary[0][1] > 0 && $mixed_summary[0][1] > 0)
		              		echo "Pos. [" . $pos_summary[0][1] . "]; Neg. [" . $neg_summary[0][1] . "]; Mixed [" . $mixed_summary[0][1] . "]";
		              	elseif ($pos_summary[0][1] > 0 && $neg_summary[0][1] > 0)
		              		echo "Pos. [" . $pos_summary[0][1] . "]; Neg. [" . $neg_summary[0][1] . "]";
		              	elseif ($pos_summary[0][1] > 0 && $mixed_summary[0][1] > 0)
		              		echo "Pos. [" . $pos_summary[0][1] . "]; Mixed [" . $mixed_summary[0][1] . "]";
		              	elseif ($neg_summary[0][1] > 0 && $mixed_summary[0][1] > 0)
		              		echo "Neg. [" . $neg_summary[0][1] . "]; Mixed [" . $mixed_summary[0][1] . "]";
		              	elseif ($pos_summary[0][1] > 0) echo "Pos. [" . $pos_summary[0][1] . "]";
		              	elseif ($neg_summary[0][1] > 0) echo "Neg. [" . $neg_summary[0][1] . "]";
		              	elseif ($mixed_summary[0][1] > 0) echo "Mix [" . $mixed_summary[0][1] . "]";
		              	else echo "unknown";
		              	echo "</center></TD> </TR>";
		              	echo "<TR> <TD><strong>Mouse</strong</TD> <TD><center>";
		              	 
		              	// mouse & immuno
		              	if ($pos_summary[1][0] > 0 && $neg_summary[1][0] > 0 && $mixed_summary[1][0] > 0)
		              		echo "Pos. [" . $pos_summary[1][0] . "]; Neg. [" . $neg_summary[1][0] . "]; Mixed [" . $mixed_summary[1][0] . "]";
		              	elseif ($pos_summary[1][0] > 0 && $neg_summary[1][0] > 0)
		              		echo "Pos. [" . $pos_summary[1][0] . "]; Neg. [" . $neg_summary[1][0] . "]";
		              	elseif ($pos_summary[1][0] > 0 && $mixed_summary[1][0] > 0)
		              		echo "Pos. [" . $pos_summary[1][0] . "]; Mixed [" . $mixed_summary[1][0] . "]";
		              	elseif ($neg_summary[1][0] > 0 && $mixed_summary[1][0] > 0)
		              		echo "Neg. [" . $neg_summary[1][0] . "]; Mixed [" . $mixed_summary[1][0] . "]";
		              	elseif ($pos_summary[1][0] > 0) echo "Pos. [" . $pos_summary[1][0] . "]";
		              	elseif ($neg_summary[1][0] > 0) echo "Neg. [" . $neg_summary[1][0] . "]";
		              	elseif ($mixed_summary[1][0] > 0) echo "Mix [" . $mixed_summary[1][0] . "]";
		              	else echo "unknown";
		              	echo "</center></TD> <TD></TD> <TD><center>";
		              	 
		              	// mouse & mRNA
		              	if ($pos_summary[1][1] > 0 && $neg_summary[1][1] > 0 && $mixed_summary[1][1] > 0)
		              		echo "Pos. [" . $pos_summary[1][1] . "]; Neg. [" . $neg_summary[1][1] . "]; Mixed [" . $mixed_summary[1][1] . "]";
		              	elseif ($pos_summary[1][1] > 0 && $neg_summary[1][1] > 0)
		              		echo "Pos. [" . $pos_summary[1][1] . "]; Neg. [" . $neg_summary[1][1] . "]";
		              	elseif ($pos_summary[1][1] > 0 && $mixed_summary[1][1] > 0)
		              		echo "Pos. [" . $pos_summary[1][1] . "]; Mixed [" . $mixed_summary[1][1] . "]";
		              	elseif ($neg_summary[1][1] > 0 && $mixed_summary[1][1] > 0)
		              		echo "Neg. [" . $neg_summary[1][1] . "]; Mixed [" . $mixed_summary[1][1] . "]";
		              	elseif ($pos_summary[1][1] > 0) echo "Pos. [" . $pos_summary[1][1] . "]";
		              	elseif ($neg_summary[1][1] > 0) echo "Neg. [" . $neg_summary[1][1] . "]";
		              	elseif ($mixed_summary[1][1] > 0) echo "Mix [" . $mixed_summary[1][1] . "]";
		              	else echo "unknown";
		              	echo "</center></TD> </TR>";
		              	echo "</TABLE><HR>";
		              	echo "</TD> </TR></TABLE>";

	              } //END only enabled for curation, where anonymous user is disabled
              
				?>

				</td>				
			</tr>								
		</table>
    <table width="80%" border="0" cellspacing="2" cellpadding="5" padding-top="5"> 
 <!--  <tr>
        <td class="table_neuron_page2" padding="5">
          All experiments were conducted on rats with an immunohistochemical staining protocol, unless otherwise specified. 
        </td>
     </tr> -->
<tr>
<td class="table_neuron_page2" padding="5">
      All of the evidence provided on Hippocampome.org are quotes from scientific texts.  
			However, because quoted passages may be difficult to understand in isolation, contextual information and expanded abbreviations set in square brackets have been added for clarity.
</td>
</tr>
    </table>
		<br />		

		<?php
		$color_1 = explode("-", $color);
		$number_marker = count($color_1);
		
		// for on number of marker (number of $color) ++++		
		for ($m2=0; $m2<$number_marker; $m2++) {			
			// Retrieve Id_property from Property By using Val_property (object) AND Color (predicate)
			$property -> retrive_ID(2, $val_property, NULL, $color_1[$m2]);
			$id_property = $property -> getProperty_id(0);
			
			// Retrieve the ID EVIDENCE from EvidencePropertyTypeRel by using ID TYPE and ID PROPERTY:
			$evidencepropertyyperel -> retrive_evidence_id($id_property, $id_neuron);
			$n_id_evidence = $evidencepropertyyperel -> getN_evidence_id();
			
			$n_tot_marker = 0;
			$old_id_marker = 0;
			
			for ($i=0; $i<$n_id_evidence; $i++) {
				$id_evidence[$i] = $evidencepropertyyperel -> getEvidence_id_array($i);
				$linking_quote_evidence[$i]= $evidencepropertyyperel-> getLinking_quote_array($i);
				$interpretation_notes_evidence[$i]= $evidencepropertyyperel-> getInterpretation_notes_array($i);

	        	// STM getting the linking PMID
	        	$id_secondary_article = $evidencepropertyyperel -> retrive_article_id($id_property, $id_neuron, $id_evidence[$i]);
	        	if ($id_secondary_article) {
					$article -> retrive_by_id($id_secondary_article);
		          	$secondary_pmid = $article -> getPmid_isbn();
	          	}
	          	else
	          		$secondary_pmid = NULL;
	        	
				
				// Retrieve EVIDENCE2_ID from EvidenceEvidenceRel by using EVIDENCE1_ID:
				$evidenceevidencerel -> retrive_evidence2_id($id_evidence[$i]);
			
				$n_evidence2 = $evidenceevidencerel -> getN_evidence2();
						
				for ($i1=0; $i1<$n_evidence2; $i1++) {	
					$id_evidence2[$i1] = $evidenceevidencerel -> getEvidence2_id_array($i1);
							
					// Retrieve Fragment_id from Fragment by using Evidence_id =  $id_evidence2[$i1]
					$evidencefragmentrel -> retrive_fragment_id($id_evidence2[$i1]);
					$n_fragment_id = $evidencefragmentrel -> getN_Fragment_id();
		
					$evidencefragmentrel -> retrive_fragment_id_1($id_evidence2[$i1]);
					$fragment_id_1 = $evidencefragmentrel -> getFragment_id();
	
					$fragment -> retrive_by_id($fragment_id_1);
					$quote = $fragment -> getQuote();
					$quote = quote_replaceIDwithName($quote);
					$interpretation= $fragment -> getInterpretation();
					$interpretation = quote_replace_IDwithName($interpretation);
					$interpretation_notes= $fragment ->getInterpretation_notes();
					if($interpretation_notes_evidence[$i])
						$interpretation_notes = $interpretation_notes_evidence[$i]; 
					
					//$linking_cell_id= $fragment ->getLinking_cell_id();
					$linking_pmid_isbn= $fragment ->getLinking_pmid_isbn();
					$linking_pmid_isbn_page= $fragment ->getLinking_pmid_isbn_page();
					$linking_quote = preg_replace("/\'/","\'",$fragment ->getLinking_quote());
					if($linking_quote_evidence[$i])
						$linking_quote = $linking_quote . "<BR>Linking notes: " . $linking_quote_evidence[$i];
					//$linking_quote= $fragment ->getLinking_quote();
					$linking_page_location= $fragment ->getLinking_page_location();
					
					$original_id = $fragment -> getOriginal_id();
					$type = $fragment -> getType();
					$page_location = $fragment -> getPage_location();				
																	
					// retrive information in Article table:
					$articleevidencerel -> retrive_article_id($id_evidence2[$i1]);				
					$id_article = $articleevidencerel -> getarticle_id_array(0);		
			
					$article -> retrive_by_id($id_article);
					$title = preg_replace("/\'/","\'",$article -> getTitle());
					$publication = preg_replace("/\'/","\'",$article -> getPublication());
					$year = preg_replace("/\'/","\'",$article -> getYear());
					$pmid_isbn = preg_replace("/\'/","\'",$article -> getPmid_isbn()); 
					$first_page = preg_replace("/\'/","\'",$article -> getFirst_page()); 
					$last_page = preg_replace("/\'/","\'",$article -> getLast_page()); 
					$pmcid = preg_replace("/\'/","\'",$article -> getPmcid()); 
					$nihmsid = preg_replace("/\'/","\'",$article -> getNihmsid()); 
					$doi = $article -> getDoi(); 
					$open_access = preg_replace("/\'/","\'",$article -> getOpen_access()); 
					$citation = preg_replace("/\'/","\'",$article -> getLast_page()); 
					$volume = preg_replace("/\'/","\'",$article -> getVolume()); 
					$issue = preg_replace("/\'/","\'",$article -> getIssue()); 
		
					$pages = $first_page." - ".$last_page;								
					//echo "frag".$fragment_id_1." "."orig id:". " ". $original_id." "."evidence id:". $id_evidence2[$i1]." "."quote:". $quote." "."inter:". $interpretation." "." int notes:". $interpretation_notes." "."lpmid:". $linking_pmid_isbn." "."lpmisb:". $linking_pmid_isbn_page." "." lquote:". $linking_quote." ". $linking_page_location." authors:". $name_authors." "."title: ". $title." "."pub:". $publication." "."year:". $year." "."pmidisb: ". $pmid_isbn." "."pages: ". $pages." "."page_loc:". $page_location." "."id_marker: ". $id_markerdata." "."id_evidence: ". $id_evidence[$i]." "."id2: ". $id_evidence2[$i1]." "."type:". $type." ". "color:". $color_1[$m2]." "."pmcid:". $pmcid." "."nihmsid:". $nihmsid." "." doi:". $doi." "."citation:". $citation." "."vol:". $volume." "."issue:". $issue." "."sec_pmid:". $secondary_pmid." ";
					// retrive the Author Position from ArticleAuthorRel ++++++++++++++++++++++++++++++++++++++++++
					$articleauthorrel -> retrive_author_position($id_article);
					$n_author = $articleauthorrel -> getN_author_id();
					for ($ii3=0; $ii3<$n_author; $ii3++)
						$auth_pos[$ii3] = $articleauthorrel -> getAuthor_position_array($ii3);
							
					sort ($auth_pos);
						
					$name_authors = NULL;
					for ($ii3=0; $ii3<$n_author; $ii3++) {
						$articleauthorrel -> retrive_author_id($id_article, $auth_pos[$ii3]);
						$id_author = $articleauthorrel -> getAuthor_id_array(0);
							
						$author -> retrive_by_id($id_author);
						$name_a = $author -> getName_author_array(0);
							
						$name_authors = $name_authors.', '.$name_a;
					}
						
					$name_authors[0] = ' ';
					$name_authors[1] = ' ';	
						
					$name_authors = ltrim($name_authors);
					$name_authors = preg_replace("/\'/","\'",$name_authors);

					// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					if ($page) {
						// Insert the data in the temporary table ********************************************************************************
						insert_temporary($name_temporary_table, $fragment_id_1, $original_id, $quote, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $page_location, $id_markerdata, $id_evidence[$i], $id_evidence2[$i1], $type, '0', $color_1[$m2], $pmcid, $nihmsid, $doi, $citation, $volume, $issue, $secondary_pmid);
					}							
									
					// SHOW ONLY TYPE = DATA:			
					$query = "UPDATE $name_temporary_table SET show1 = '1' WHERE type = 'data' ";							
					$rs = mysqli_query($GLOBALS['conn'],$query);
					
				} // end for n_evidence2
			} // end for n_id_evidence
		
			// Retrieve MARKERDATA ID from EvidenceMarkerdataRel by using ID EVIDENCE: *****************************
			$query = "SELECT id_evidence1 FROM $name_temporary_table";
			$rs = mysqli_query($GLOBALS['conn'],$query);
			while(list($id_evidence1) = mysqli_fetch_row($rs)) {
				$evidencemarkerdatarel -> retrive_Markerdata_id($id_evidence1);
				$id_markerdata1 = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
	
				$query1 = "UPDATE $name_temporary_table SET id_markerdata = '$id_markerdata1' WHERE $id_evidence1 = '$id_evidence1' ";							
				$rs1 = mysqli_query($GLOBALS['conn'],$query1);					
			}	
			// ****************************************************************************************************
		}

		$query = "SELECT show1 FROM $name_temporary_table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n_show1=0;
		while(list($show1) = mysqli_fetch_row($rs)) {
			if ($show1 == 1)
				$n_show1 = $n_show1 + 1;
		}			
	?>
	<table width="80%" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td width="20%" align="left">
				<font class="font2">Animal:</font> 
				<select id='animal_select' onchange='evidencetoggle()' style='width: 100px;' class='select1'>
				<OPTION VALUE='all' >All</OPTION>
				<OPTION VALUE='rat'>Rat</OPTION>
				<OPTION VALUE='mouse'>Mouse</OPTION>
				<OPTION VALUE='unspecified rodent'>Unspecified rodent</OPTION>
				</select>					
			</td>
			<td width="20%" align="center">
				<font class="font2">Protocol:</font> 
				<select id='protocol_select' onchange='evidencetoggle()' style='width: 100px;' class='select1'>
				<OPTION VALUE='all'>All</OPTION>
				<OPTION VALUE='immunohistochemistry'>Immunohistochemistry</OPTION>
				<OPTION VALUE='mRNA'>mRNA</OPTION>
				<OPTION VALUE='immunohistochemistry and mRNA'>Immunohistochemistry and mRNA</OPTION>
				<OPTION VALUE='unknown'>unknown</OPTION>
				</select>					
			</td>
	 				
			<td width="20%" align="right">
				<font class="font2">Expression:</font> 
				<select id='expression_select' onchange='evidencetoggle()' class='select1'>
				<OPTION VALUE='all'>All</OPTION>
				<OPTION VALUE='positive'>positive</OPTION>
				<OPTION VALUE='negative'>negative</OPTION>
				<!--OPTION VALUE='positive and negative'>positive and negative</OPTION-->
				</select>					
			</td>
			<td width="30%" align="right">
					</form>	
					<button  type="button" onclick ="evidencetoggle()" >Open All Evidence</button>
					<button  type="button" onclick ="evidencetoggleclose()" >Close All Evidence</button>
					<?php print ("<input type='hidden' name='name_show_only' value='$name_show_only'>"); ?>
					</form>				
			</td>	
			
		</tr>
	</table>
	<!--   END TABLE SHOW ONLY ***************************************************************************************************************-->
	<br/>
		<!-- ORDER BY: _______________________________________________________________________________________________________ -->
		<table width="80%" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td width="25%" align="left">
				<font class="font2">Show:</font> 
			<?php 
				print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only(this, '$color')\">");
					
				if ($name_show_only)
				{
					if ($name_show_only == 'all')
						$name_show_only1 = 'All';
					if ($name_show_only == 'article_book')
						$name_show_only1 = 'Articles / Books';								
					if ($name_show_only == 'name_journal')
						$name_show_only1 = 'Name of Publication';
					if ($name_show_only == 'authors')
						$name_show_only1 = 'Authors';
					if ($name_show_only == 'morphology')
						$name_show_only1 = 'Morphology';
																												
					print ("<OPTION VALUE='$name_show_only1'>$name_show_only1</OPTION>");
					print ("<OPTION VALUE='all'>----</OPTION>");
				}
			?>	
				<OPTION VALUE='all'>All</OPTION>
				<OPTION VALUE='article_book'>Articles / Books</OPTION>
				<OPTION VALUE='name_journal'>Name of Publication</OPTION>
				<OPTION VALUE='authors'>Authors</OPTION>
				</select>					
			</td>
		
			<td width="35%" align="center">
			<?php 
				// ARTICLE - BOOK: ++++++++++++++++++++++++

				if ($sub_show_only == 'article')
				{
					// retrieve the number of article or number of book:
					print("<font class='font2'>By:</font> ");
					$query = "SELECT DISTINCT title, PMID FROM $name_temporary_table WHERE show1 = '1'";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$number_of_articles_1 = 0;
					$number_of_books_1 = 0;
					while(list($title, $pmid) = mysqli_fetch_row($rs))		
					{	
						if (strlen($pmid) > 10)
							$number_of_books_1 = $number_of_books_1 + 1;
						if (strlen($pmid) < 10)
							$number_of_articles_1 = $number_of_articles_1 + 1;							
					}
					
				
					if ($name_show_only_article == 'article')
					{
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, '$color')\">");
						print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
						print ("<OPTION VALUE='all'>All</OPTION>");
						print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
						print ("</select>");							
					}
					else if ($name_show_only_article == 'book')
					{
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, '$color')\">");
						print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
						print ("<OPTION VALUE='all'>All</OPTION>");
						print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
						print ("</select>");
					}
					else
					{
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, '$color')\">");
						print ("<OPTION VALUE='all'>All</OPTION>");
						print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
						print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
						print ("</select>");
					}							
				}						
			
				// PUBLICATION: ++++++++++++++++++++++++
				if ($sub_show_only == 'name_journal')
				{						
					print("<font class='font2'>By:</font> ");
					print ("<select name='order' size='1' cols='10' class='select1' style='width: 200px;' onChange=\"show_only_publication(this, '$color')\">");
					
					if ( ($name_show_only_journal != 'all') &&  ($name_show_only_journal != NULL) )
						print ("<OPTION VALUE='$name_show_only_journal'>$name_show_only_journal</OPTION>");
					
					print ("<OPTION VALUE='all'>All</OPTION>");
					
					// retrieve the name of journal from temporary table:
					$query ="SELECT DISTINCT publication FROM $name_temporary_table WHERE show1 = '1'";
					$rs = mysqli_query($GLOBALS['conn'],$query);					
					while(list($pub) = mysqli_fetch_row($rs))	
					{	
						// retrieve the number of articles for this publication:
						$query1 ="SELECT DISTINCT title FROM $name_temporary_table WHERE publication = '$pub'";
						$rs1 = mysqli_query($GLOBALS['conn'],$query1);
						$n_pub1=0;					
						while(list($id) = mysqli_fetch_row($rs1))							
							$n_pub1 = $n_pub1 + 1;
					
						if ($pub == $name_show_only_journal);
						else
							print ("<OPTION VALUE='$pub'>$pub ($n_pub1)</OPTION>");		
					}
					print ("</select>");				
				}
				
				// AUTHORS: ++++++++++++++++++++++++
				$aut1 = NULL;
				if ($sub_show_only == 'authors')
				{
					// retrieve the name of authors from temporary table:
					print("<font class='font2'>By:</font> ");
					$query ="SELECT DISTINCT authors FROM $name_temporary_table WHERE show1 = '1'";
					$rs = mysqli_query($GLOBALS['conn'],$query);				
					
					while(list($aut) = mysqli_fetch_row($rs))
					{
						$aut1=$aut1.", ".$aut;
					}					
					$aut1=str_replace(', ', '*', $aut1);
					$single_aut=explode('*', $aut1);

					sort($single_aut);
					$single_aut2=array_unique($single_aut);

					// Remove the blank from array:
					$ni=0;
					for ($i1=0; $i1<count($single_aut2); $i1++)
					{		 
						if ($single_aut2[$i1] == NULL);
						else
						{
							$single_aut3[$ni] = $single_aut2[$i1];
							$ni = $ni + 1;
						}
					}							

					print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_authors(this, '$color')\">");
					
					if ( ($name_show_only_authors != 'all') &&  ($name_show_only_authors != NULL) )
					{
						print ("<OPTION VALUE='$name_show_only_authors'>$name_show_only_authors</OPTION>");
						print ("<OPTION VALUE='all'>---</OPTION>");
					}
					print ("<OPTION VALUE='all'> ALL </OPTION>");
					
					for ($i1=0; $i1<count($single_aut3); $i1++)
					{
					
						// retrieve the number of articles for this publication:
						$query1 ="SELECT DISTINCT title FROM $name_temporary_table WHERE authors LIKE '%$single_aut3[$i1]%'";
						$rs1 = mysqli_query($GLOBALS['conn'],$query1);
						$n_auth1=0;					
						while(list($id) = mysqli_fetch_row($rs1))	
							$n_auth1 = $n_auth1 + 1;	

						print ("<OPTION VALUE='$single_aut3[$i1]'>$single_aut3[$i1] ($n_auth1)</OPTION>");
					}
					print ("</select>");				
				}						
			?>	
			</td>							
	
				<?php 
					// -----------------------------------------------------------------------------------------
					if ($n_show1 != 1)
					{
				?>			
					<td width="25%" align="right">
						<font class="font2">Order:</font>				
					<form action="property_page_markers.php" method="POST" style="display:inline">
						<select name='order' size='1' cols='10' class='select1' onchange="this.form.submit()">
						
						<?php
							if ($order_by)
							{	
								if ($order_by == 'year')
									print ("<OPTION VALUE='$order_by'>Date</OPTION>");
								if ($order_by == 'publication')
									print ("<OPTION VALUE='$order_by'>Journal / Book</OPTION>");
								if ($order_by == 'authors')
									print ("<OPTION VALUE='$order_by'>Authors</OPTION>");							
							}							
						?>
						<OPTION VALUE='year'>-</OPTION>
						<OPTION VALUE='year'>Date</OPTION>
						<OPTION VALUE='publication'>Journal / Book</OPTION>
						<OPTION VALUE='authors'>First Authors</OPTION>
						</select>
						<input type="hidden" name='order_ok' value="GO"/>
 						</form>	
						</td>
				<?php
					}
					// ---------------------------------------------------------------------------------------------
					else
					{
						print ("<td width='25%'></td>");
					}
				?>

		</table>

		<br />	


		<!-- TABLE SHOW ONLY *******************************************************************************************************************
		************************************************************************************************************************************* -->				
		

	<?php		

		// Select only DOI, to have the exact number of articles and to show only one time the name of article.
		$query = "SELECT DISTINCT authors, title, publication, year, PMID, pages, pmcid, NIHMSID, doi, citation, show2, show_button, volume, issue, secondary_pmid FROM $name_temporary_table ORDER BY $order_by $type_order ";	
		//$query = "SELECT DISTINCT authors, title, publication, year, PMID, pages, pmcid, NIHMSID, doi, citation, show2, show_button, volume, issue, secondary_pmid FROM $name_temporary_table";
		$rs = mysqli_query($GLOBALS['conn'],$query);	
		$number_of_article = 0;		
		while(list($authors, $title, $publication, $year, $PMID, $pages, $pmcid, $NIHMSID, $doi, $citation, $show2, $show_button, $volume, $issue, $secondary_pmid) = mysqli_fetch_row($rs))		
		{
			$DOI[$number_of_article]=$doi;
			
			$authors1[$number_of_article]=$authors;
			$title1[$number_of_article]=$title;
			$publication1[$number_of_article]=$publication;
			$year1[$number_of_article]=$year;
			$PMID1[$number_of_article]=$PMID;
			$pages1[$number_of_article]=$pages;		
			$pmcid1[$number_of_article]=$pmcid;
			$NIHMSID1[$number_of_article]=$NIHMSID;
			$citation1[$number_of_article]=$citation;	
			$show_2[$number_of_article]=$show2;		
			$show_button1[$number_of_article]=$show_button;	
			$volume1[$number_of_article]=$volume;
			$issue1[$number_of_article]=$issue;	
			$number_of_article = $number_of_article + 1;
		}
	
		for ($t3=0; $t3<$number_of_article ; $t3++)
		{	
			if ($show_2[$t3] == 1)
			{				
				if (strlen($PMID1[$t3]) < 10)
				{
					$color_back = '#D5B1B1';
					$value_link ='PMID: '.$PMID1[$t3];
					$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";								
					$string_pmid = "<strong>PMID: </strong>".$link2;					
				
				}	
				else
				{
					$color_back = '#98B1B5';
					$link2 = "<a href='$link_isbn$PMID1[$t3]' target='_blank'>";
					$string_pmid = "<strong>ISBN: </strong>".$link2;										
				}
					
				print ("<table width='80%' border='0' cellspacing='2' cellpadding='5'>");
				print ("<tr><td width='10%'></td>");
				
				// Buttons RED or GREEN to show the quotes: -----------------------------------------------------------------
				print ("<td width='5%' class='table_neuron_page2' align='center' valign='center'><button id='btntoggle1_".$t3."' class='show1' title='Show Evidence' alt = 'Close Evidence' onclick ='singleevidencetoggle(this,". $t3.")'></button><button id='btntoggle0_".$t3."'class='show0' title = 'Close Evidence' alt = 'Close Evidence' onclick ='singleevidencetoggle(this,". $t3.")' style='display:none'");
				//if ($show_button1[$t3] == 0)
				//{
					//print ("<form action='property_page_markers.php' method='post' style='display:inline'>");
					//print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
					//print ("<input type='hidden' name='title' value='$title1[$t3]'>");
					//print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
					//print ("</form>");
				//}
				//if ($show_button1[$t3] == 1)
				//{
					//print ("<form action='property_page_markers.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
					//print ("<input type='submit' name='show_0' value=' ' class='show0'>");
					//print ("<input type='hidden' name='title' value='$title1[$t3]'>");
					//print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");				
					//print ("</form>");
					
				//}	
								
				print ("</td>");	
									
				if ($issue1[$t3] != NULL)
					$issue_tot = "($issue1[$t3]),";
				else
					$issue_tot = "";									

				if ($DOI[$t3] != NULL)
					$doi_tot = "DOI: $DOI[$t3]";
				else
					$doi_tot = "";	
													
				print ("						
					<td align='left' width='85%' class='table_neuron_page2'>				
						<font color='#000000'><strong>$title1[$t3] </strong></font> <br>
						$authors1[$t3] <br>
						$publication1[$t3], $year1[$t3], $volume1[$t3] $issue_tot pages: $pages1[$t3]<br>
						$string_pmid<font class='font13'>  $PMID1[$t3]</font></a>; $doi_tot <br>
					</td>	
				</tr>	
				</table>");																																	
			//	print ("<br>");
		
				
				//$query = "SELECT DISTINCT id, id_fragment, id_original, quote, interpretation, interpretation_notes, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location,page_location, id_markerdata, show1, type, type_marker, color, id_evidence1, id_evidence2, secondary_pmid, PMID FROM $name_temporary_table WHERE title = '$title1[$t3]' ";				
				$query = "SELECT DISTINCT id_fragment, id_original, quote, interpretation, interpretation_notes, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location,page_location, id_markerdata, show1, type, type_marker, id_evidence1, id_evidence2, secondary_pmid, PMID FROM $name_temporary_table WHERE title = '$title1[$t3]' ";				
				$rs = mysqli_query($GLOBALS['conn'],$query);											
				//while(list($aa, $id_fragment, $id_original, $quote, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location, $page_location, $id_markerdata, $show1, $type, $type_marker, $color_see, $id_evidence1, $id_evidence2, $secondary_pmid, $PMID) = mysqli_fetch_row($rs))		
				while(list($id_fragment, $id_original, $quote, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location, $page_location, $id_markerdata, $show1, $type, $type_marker, $id_evidence1, $id_evidence2, $secondary_pmid, $PMID) = mysqli_fetch_row($rs))		
				{
					//bhawna
					//if ($show1 == 1)
					//{
            // STM markerdata was not being loaded
			          $evidencemarkerdatarel -> retrive_Markerdata_id($id_evidence1);
			          $id_markerdata = $evidencemarkerdatarel -> getMarkerdata_id_array(0);
						$markerdata -> retrive_info($id_markerdata);

						$expression = $markerdata -> getExpression();	
            			$expression = preg_replace('/[\[\]"]/', '', $expression);
            			$expression = str_replace("_", " ", $expression);
            			$expression = str_replace("inference", "(inference)", $expression);
						$animal = $markerdata -> getAnimal();	
            			$animal = preg_replace('/[\[\]"]/', '', $animal);
						$protocol = $markerdata -> getProtocol();	
           				$protocol = preg_replace('/[\[\]"]/', '', $protocol);
							
						//if ($id_fragment_compare == $id_fragment);
						if (($id_fragment_compare == $id_fragment) && ($id_evidence1_compare == $id_evidence1));
						else	
						{		

							// retrieve the attachament from "fragment" with original_id *****************************
					//		$fragment -> retrive_attachment_by_original_id($id_original);
					//		$attachment = $fragment -> getAttachment();
					//		$attachment_type = $fragment -> getAttachment_type();

							// retrieve the attachament from "attachment" with original_id and cell-id(id_neuron)*****************************
							//$attachment_obj -> retrive_attachment_by_original_id($id_original, $id_neuron);

							// retrieve the attachament from the "Attachment" table with original_id and cell_id and parameter *******
							$isInference = strpos($expression,"inference");
							if ($isInference>0)
								$id_neuron_for_attachement = 0;
							else
								$id_neuron_for_attachement = $id_neuron;
							$attachment_obj -> retrieve_attachment_by_original_id($id_original, $id_neuron_for_attachement, $val_property);
							$attachment = $attachment_obj -> getName();
							$attachment_type = $attachment_obj -> getType();
									
							
							// change PFD in JPG:
							$link_figure="";
							$attachment_jpg = str_replace('jpg', 'jpeg', $attachment);
					//	echo "$attachment_jpg";
							if($attachment_type=="marker_figure"||$attachment_type=="marker_table"){
								$link_figure = "attachment/marker/".$attachment_jpg;
					//			echo "marker:-".$link_figure;
							}
							
							if($attachment_type=="morph_figure"||$attachment_type=="morph_table"){
								$link_figure = "attachment/morph/".$attachment_jpg;
						//		echo "morph:-".$link_figure;
							}
							
							if($attachment_type=="ephys_figure"||$attachment_type=="ephys_table"){
								$link_figure = "attachment/ephys/".$attachment_jpg;
								//echo "ephys:-".$link_figure;
							}			
							
							
							//$link_figure = "figure/".$attachment_jpg;
							
							$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
							$link_figure_pdf = "figure_pdf/".$attachment_pdf;
							// **************************************************************************************							
              // STM Formatting header

			  if (($expression == $print_color) || ($print_color == "positive-negative") || 
		  		  ($expression == "positive (inference)" && $print_color == "positive") || ($expression == "negative (inference)" && $print_color == "negative") ||
		  		  ($expression == "positive (inference)" && $print_color == "positive inference") || ($expression == "negative (inference)" && $print_color == "negative inference"))
              	$header_html = header_row("EXPRESSION", $expression);
			  else 
			  	$header_html = header_row("EXPRESSION (* contradictory evidence)", $expression);
			  	//$header_html = header_row_special("EXPRESSION (* contradictory evidence)", $expression);
              
              if ($animal != 'rat')
                $header_html = $header_html . header_row("ANIMAL", $animal);
               else 
                $header_html = $header_html . header_row("ANIMAL", 'rat');
              if ($protocol != 'immunohistochemistry')
                $header_html = $header_html . header_row("PROTOCOL", $protocol);
               else 
                $header_html = $header_html . header_row("PROTOCOL", 'immunohistochemistry');
			 // bhawna changes
			 $protocol_new = "";
			 $expression_new = "";
			 if($protocol == "immunohistochemistry, mRNA" )
				 $protocol_new = "immunohistochemistry_mRNA";
			 else $protocol_new = $protocol;
			
			if($expression=="positive, negative")
				$expression_new = "positive_negative";
			else $expression_new = $expression;
		       
	        print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' class='".$animal."_".$protocol_new."_".$expression_new. "_tab_".$t3. "' style='display:none'>");
			print $header_html;
              print ("
                <tr>
                <td width='15%'></td>	
                <td align='left' width='70%' class='table_neuron_page2'>				
                Page location: <span title='$id_fragment (original: ".$id_original.")'>$page_location</span>
                </td>	
                ");

				/*
				// Display Interpretation quotes and notes, if any.
				if ($interpretation||$interpretation_notes) {
					print ("</tr>
					<tr>
					<td width='15%'>
					<td width='70%' class='table_neuron_page2' align='left'>");
					if($interpretation) {
						print ("Interpretation: <span>$interpretation</span>");
						if($interpretation_notes) {
							print ("<br>Interpretation notes: <span>$interpretation_notes</span>");
						}
					} else if($interpretation_notes) {
						print ("Interpretation notes: <span>$interpretation_notes</span>");
					}

						
					//print ("</td><td width='15%' align='center'>");
				}
				*/
				
				// Display Linking information, if any.linking_cell_id, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location
				if ($linking_pmid_isbn||$linking_pmid_isbn_page||$linking_quote||$linking_page_location)
				{
					print ("</td></tr>
					<tr>
					<td width='15%'>
					<td width='70%' class='table_neuron_page2' align='left'>");
					//if($linking_cell_id)
					//print ("Linking cell ID: <span>$linking_cell_id</span>");
					if ($linking_pmid_isbn)
					{
						if (strlen($linking_pmid_isbn) > 10 )
						{
							$link2 = "<a href='$link_isbn$PMID1' target='_blank'>";
							$string_pmid = "Linking ISBN:".$link2;
						}
						else
						{
							$value_link ='PMID: '.$linking_pmid_isbn;
							$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";
							$string_pmid = "Linking PMID: ".$link2;
						}
						print ("$string_pmid<font class='font13'>$linking_pmid_isbn</font></a>");
					}
						
					if($linking_quote)
					{
						$evidencepropertyyperel -> retrieve_morphology_evidence_id_by_type_and_pmid_isbn($id_neuron, $linking_pmid_isbn);
						$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
						$linking_quote_url_to_property_page_morphology_linking_pmid_isbn =
							"<a href='property_page_morphology_linking_pmid_isbn.php?id_neuron=$id_neuron&linking_pmid_isbn=$linking_pmid_isbn&val_property=DG_H&color=somata&page=1'>$linking_quote</a>";
						if ($n_evidence_id > 0)
						{
							print ("<br>Linking Quote: <span>$linking_quote_url_to_property_page_morphology_linking_pmid_isbn</span>");
						}
						else
						{
							print ("<br>Linking Quote: <span>$linking_quote</span>");
						}
					}

					if($linking_page_location)
					{
						print ("<br>Linking Page Location: <span>$linking_page_location</span>");
					}
						
					print ("</td><td width='15%' align='center'>");
				}

				print ("</td></tr>");
						
				// concatenate interpretation notes after quote, then print quote
				if ($interpretation_notes)
					$quote = $quote . "<BR><BR>Interpretation notes: <span>$interpretation_notes</span>";
						
				print ("<tr>
					<td width='15%'></td>	
					<td align='left' width='70%' class='table_neuron_page2'>$quote</td>	
					<td width='15%' class='table_neuron_page2' align='center'>");

					if ($attachment_type=="marker_figure"||$attachment_type=="marker_table")
					{
						print ("<a href='$link_figure' target='_blank'>");
						print ("<img src='$link_figure' border='0' width='80%'>");
						print ("</a>");
					}	

				print ("</td></tr>");					

                // STM added for linking PMID
                if ($secondary_pmid and $secondary_pmid != $PMID) {
                print ("
                  <tr>
                  <td width='15%'></td>	
                  <td align='left' width='70%' class='table_neuron_page2'>				
                  Linked through: <a href=http://www.ncbi.nlm.nih.gov/pubmed/$secondary_pmid>PMID $secondary_pmid</a>
                  </td>	
                  <td width='15%'>");
              }
							print ("</table>");
						//	print ("<br>");	

							$id_fragment_compare = $id_fragment;
							$id_evidence1_compare = $id_evidence1;
						} // END IF	($id_fragment_compare == $id_fragment)
					
					//}// end IF show1
					
				} // end WHILE
				
			//	print ("<br>");	

			} // end show2		
		} // end FOR $t3
		
		?>	
		</td>
	</tr>
</table>		
    <div height="10" width="80%"/>
</body>
</html>

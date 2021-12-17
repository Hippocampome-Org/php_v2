<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
//include ("access_db.php");
include ("function/quote_manipulation.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.synonym.php');
require_once('class/class.fragment.php');
require_once('class/class.attachment.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');


function create_temp_table ($name_temporary_table)
{	
	$drop_table ="DROP TABLE $name_temporary_table";
	$query = mysqli_query($GLOBALS['conn'],$drop_table);
	
	$creatable=	"CREATE TABLE IF NOT EXISTS $name_temporary_table (
				   id int(4) NOT NULL AUTO_INCREMENT,
				   id_fragment int(10),
				   id_original int(10),
				   quote text(2000),
				   authors varchar(600),
				   title varchar(300),
				   publication varchar(100),
				   year varchar(15),
				   PMID BIGint(25),
				   pages varchar(20),
				   page_location varchar(100),
				   id_evidence int(20),
				   show1 int(5),
				   pmcid varchar(400),
				   nihmsid varchar(400),
				   doi varchar(400),
				   open_access int(6),
				   citation_count int(7),
				   type varchar(30),
				   show_only int(30),
				   volume varchar(20),
				   issue varchar(20),
				   PRIMARY KEY (id));";
	$query = mysqli_query($GLOBALS['conn'],$creatable);
	

}

function insert_temporary($table, $id_fragment, $id_original, $quote, $authors, $title, $publication, $year, $PMID, $pages, $page_location, $id_evidence, $show1,  $pmcid, $nihmsid, $doi, $open_access, $citation_count, $type, $volume, $issue)
{
	if ($open_access == NULL)
		$open_access = -1;
	if ($citation_count == NULL)
		$citation_count = -1;
	//set_magic_quotes_runtime(0);	
		if (get_magic_quotes_gpc()) {
        	$publication = stripslashes($publication);  
        	$quotes = stripslashes($quotes);   
	$authors = stripslashes($authors);  
	}
		$publication= mysqli_real_escape_string($GLOBALS['conn'],$publication);
	$quote = mysqli_real_escape_string($GLOBALS['conn'],$quote);
	$authors = mysqli_real_escape_string($GLOBALS['conn'],$authors);
	$query_i = "INSERT INTO $table
	  (id,
	   id_fragment,
	   id_original,
	   quote,
	   authors,
	   title,
	   publication,
	   year,
	   PMID,
	   pages,
	   page_location,
	   id_evidence,
	   show1,
	   pmcid,
	   nihmsid,
	   doi,
	   open_access,
	   citation_count,
	   type,
	   show_only,
	   volume,
	   issue
	   )
	VALUES
	  (NULL,
	   '$id_fragment',
	   '$id_original',
	   '$quote',
	   '$authors',
	   '$title',
	   '$publication',
	   '$year',
	   '$PMID',
	   '$pages',
	   '$page_location',
	   '$id_evidence',
	   '$show1',
	   '$pmcid',
	   '$nihmsid',
	   '$doi',
	   '$open_access',
	   '$citation_count',
	   '$type',
	   '1',
	   '$volume' ,
	   '$issue'   
	   )";
	$rs2 = mysqli_query($GLOBALS['conn'],$query_i);					
 }

// *********************************************************************************************************************************

$page = $_REQUEST['page'];

$sub_show_only = $_SESSION['sub_show_only']; 
$name_show_only_article = $_SESSION['name_show_only_article'];


$see_all = $_REQUEST['see_all']; 
if ($see_all == 'Open All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}

if ($see_all == 'Close All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}

// Change the show coloums in the temporary table: ------------------------------------------------
if ($_REQUEST['show_1']) //  ==> ON
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$title_paper = $_REQUEST['title'];

	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
				
	$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

if ($_REQUEST['show_0']) //  ==> OFF
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	
	$query = "UPDATE $name_temporary_table SET show1 =  '0' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

// --------------------------------------------------------------------------------------------------

if ($page) // Come from another page
{
	$name_show_only = 'all';
	$_SESSION['name_show_only'] = $name_show_only;
		
	$sub_show_only = NULL;
	$_SESSION['sub_show_only'] = $sub_show_only;	
	
	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';	
	
	$id_neuron = $_REQUEST['id_neuron'];
	$val_property = $_REQUEST['val_property'];
	$linking_pmid_isbn = $_REQUEST['linking_pmid_isbn'];
	$color = $_REQUEST['color'];
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	
	$time_t = time();
	
	$name_temporary_table ='temp_'.$ip_address.'_'.$id_neuron.$color.'__'.$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;

	create_temp_table($name_temporary_table);	

	$val_property = str_replace('_', ':', $val_property);

	$_SESSION['id_neuron'] = $id_neuron;
	$_SESSION['val_property'] = $val_property;	
	$_SESSION['linking_pmid_isbn'] = $linking_pmid_isbn;	
	$_SESSION['color'] = $color;
	
	$page_in = 0;
	$page_end = 10;
	
	$order_by = 'year';     //Default
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
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
			
		$page_in = 0;
		$page_end = 10;
	}
	else    // Was clicked the paginations
	{
		$order_by = $_SESSION['order_by'];

		$type_order = $_SESSION['type_order'];
	
		if ($_REQUEST['up'])
		{
			$page_in = $_REQUEST['start'];
			$page_end = $page_in+10;		
		}
		if ($_REQUEST['down'])
		{
			$page_in = $_REQUEST['start'];
			$page_end = $page_in+10;		
		}	
		if ($_REQUEST['last_page'])
		{
			$value_last_page = $_REQUEST['value_last_page'];
			$page_in = $value_last_page;
			$page_end = $_REQUEST['value_last_page_final'];
		}
		if ($_REQUEST['first_page'])
		{
			$page_in = 0;
			$page_end = 10;
		}
	}


	$flag = $_REQUEST['flag'];
	
	$id_neuron = $_SESSION['id_neuron'];
	$val_property = $_SESSION['val_property'];
	$linking_pmid_isbn = $_SESSION['linking_pmid_isbn'];
	$color = $_SESSION['color'];
	
	$name_temporary_table = $_SESSION['name_temporary_table'];
	
}


// SHOW ONLY --------------------------------------------------------------
// ------------------------------------------------------------------------
$name_show_only_var = $_REQUEST['name_show_only_var'];

if ($name_show_only_var)
{
	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['name_show_only'] = $name_show_only;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];
	//$name_temporary_attachment=

	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$sub_show_only = 'article';
		$_SESSION['sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$sub_show_only = 'name_journal';
		$_SESSION['sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$sub_show_only = 'authors';
		$_SESSION['sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}

	// Option: Morphology:
	if ($name_show_only == 'morphology')
	{
		$name_show_only_morphology = 'both';
		$sub_show_only = 'morphology';
		$_SESSION['sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
} // end if $name_show_only_var




// ARTICLE - BOOK OPTION
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['name_show_only_article'] = $name_show_only_article;

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	
	$query ="SELECT id, PMID FROM $name_temporary_table";
	$rs = mysqli_query($GLOBALS['conn'],$query);					
	while(list($id, $pmid) = mysqli_fetch_row($rs))	
	{	
		if ($name_show_only_article == 'article')
		{
			if (strlen($pmid) > 10)
				$query = "UPDATE $name_temporary_table SET show_only =  '0' WHERE id = '$id'";
		}
		else if ($name_show_only_article == 'book')
		{
			if (strlen($pmid) < 10)
				$query = "UPDATE $name_temporary_table SET show_only =  '0' WHERE id = '$id'";
		}	
		else
			$query = "UPDATE $name_temporary_table SET show_only =  '1' WHERE id = '$id'";
				
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
} // end if $name_show_only_article


// JOURNAL OPTION
$name_show_only_journal_var = $_REQUEST['name_show_only_journal_var'];
if ($name_show_only_journal_var)
{
	$name_show_only_journal = $_REQUEST['name_show_only_journal'];
	$_SESSION['name_show_only_journal'] = $name_show_only_journal;

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
		
	if ($name_show_only_journal == 'all')
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	else
		$query = "UPDATE $name_temporary_table SET show_only =  '0' WHERE publication != '$name_show_only_journal'";
	
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	

} // end if $name_show_only_journal
	
// AUTHORS OPTION
$name_show_only_authors_var  = $_REQUEST['name_show_only_authors_var'];
if ($name_show_only_authors_var)
{
	$name_show_only_authors = $_REQUEST['name_show_only_authors'];
	$_SESSION['name_show_only_authors'] = $name_show_only_authors;

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];


	if ($name_show_only_authors == 'all')
	{
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);		
	}
	else
	{
		$query = "UPDATE $name_temporary_table SET show_only =  '0'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
				
		$query ="SELECT id FROM $name_temporary_table WHERE authors LIKE '%$name_show_only_authors%'";
		$rs = mysqli_query($GLOBALS['conn'],$query);					
		while(list($id) = mysqli_fetch_row($rs))		
		{
			$query = "UPDATE $name_temporary_table SET show_only =  '1' WHERE id = '$id'";
			$rs2 = mysqli_query($GLOBALS['conn'],$query);
		}	
	}

} // end if $name_show_only_authors	

// MORPHOLOGY OPTION
$name_show_only_morphology_var = $_REQUEST['name_show_only_morphology_var'];
if ($name_show_only_morphology_var)
{
	$name_show_only_morphology = $_REQUEST['name_show_only_morphology'];
	$_SESSION['name_show_only_morphology'] = $name_show_only_morphology;

	$name_show_only = $_SESSION['name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show_only =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
	
	if ($name_show_only_morphology == 'Axons')
	{
		$query = "UPDATE $name_temporary_table SET show_only =  '1' WHERE type = 'axons'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	if ($name_show_only_morphology == 'Dendrites')
	{
		$query = "UPDATE $name_temporary_table SET show_only =  '1' WHERE type = 'dendrites'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	if ($name_show_only_morphology == 'both')
	{
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}


} // end if $name_show_only_morphology
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------


if ($color == 'red')
	$part = "axons";
if ($color == 'blue')
	$part = "dendrites";				
if ($color == 'violet')
	$part = "axons_dendrites";	
if ($color == 'somata')
	$part = "somata";	


		
$type = new type($class_type);
$type -> retrive_by_id($id_neuron);

$property = new property($class_property);

$fragment = new fragment($class_fragment);

$attachment_obj = new attachment($class_attachment);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);

$articleevidencerel = new articleevidencerel($class_articleevidencerel);

$article = new article($class_article);

$articleauthorrel = new articleauthorrel($class_articleauthorrel);

$author = new author($class_author);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<script type="text/javascript">
// Javascript function *****************************************************************************************************
//================changes===========================
function evidencetoggle(){	

	
	var element_axondendrite= document.getElementsByClassName('axondendrite');
	var element_axon= document.getElementsByClassName('axon');
	var element_dendrite= document.getElementsByClassName('dendrite');

		var element_combo_dendrite= document.getElementsByClassName('comboflag-dendrite');
	var 	element_combo_axon= document.getElementsByClassName('comboflag-axon');
	var 	element_combo_axondendrite= document.getElementsByClassName('comboflag-axondendrite');
	if (document.getElementById('axoncheck').checked==false) {
		 document.getElementById("axoncheck").disabled = false;
		 document.getElementById("dendritecheck").disabled = false;
		for(var i=0;i<element_dendrite.length;i++){
			
			element_dendrite[i].style.display = 'table';
			
		}  
    	for(var i=0;i<element_axon.length;i++){
    		
			element_axon[i].style.display = 'none';
			
			
		}  
    	for(var i=0;i<element_axondendrite.length;i++){
    		
			element_axondendrite[i].style.display = 'table';
			
			
		}  
    	
		 document.getElementById("dendritecheck").disabled = true;
	//A-D hybrid flag change js code change begins
	     for(var i=0;i<element_combo_dendrite.length;i++){
				
	    	 element_combo_dendrite[i].style.display = 'table-cell';
				
			}  
	    	for(var i=0;i<element_combo_axon.length;i++){
	    		
	    		element_combo_axon[i].style.display = 'none';
				
				
			}  
	    	for(var i=0;i<element_combo_axondendrite.length;i++){
	    		
	    		element_combo_axondendrite[i].style.display = 'none';
				
				
			}   

	    	document.getElementById('axon-quote').style.display='none';
	    	document.getElementById('dendrite-quote').style.display='block';
	    	document.getElementById('combo-quote').style.display='none';
	    	
			//A-D hybrid flag change js code ends
    } 
	 if (document.getElementById('dendritecheck').checked==false) {
		 document.getElementById("axoncheck").disabled = false;
		 document.getElementById("dendritecheck").disabled = false;
		for(var i=0;i<element_dendrite.length;i++){
			
			element_dendrite[i].style.display = 'none';
			
		}  
    	for(var i=0;i<element_axon.length;i++){
    		
			element_axon[i].style.display = 'table';
			
			
		}  
    	for(var i=0;i<element_axondendrite.length;i++){
    		
			element_axondendrite[i].style.display = 'table';
			
			
		}  
    	document.getElementById("axoncheck").disabled = true;
	 //A-D hybrid flag change js code change begins
	     for(var i=0;i<element_combo_dendrite.length;i++){
				
	    	 element_combo_dendrite[i].style.display = 'none';
				
			}  
	    	for(var i=0;i<element_combo_axon.length;i++){
	    		
	    		element_combo_axon[i].style.display = 'table-cell';
				
				
			}  
	    	for(var i=0;i<element_combo_axondendrite.length;i++){
	    		
	    		element_combo_axondendrite[i].style.display = 'none';
				
				
			}   
	    	document.getElementById('axon-quote').style.display='block';
	    	document.getElementById('dendrite-quote').style.display='none';
	    	document.getElementById('combo-quote').style.display='none';
			//A-D hybrid flag change js code ends
	 }
     if (document.getElementById('dendritecheck').checked==true && document.getElementById('axoncheck').checked==true) {
    	 document.getElementById("axoncheck").disabled = false;
		 document.getElementById("dendritecheck").disabled = false;
     	for(var i=0;i<element_dendrite.length;i++){
    		
			element_dendrite[i].style.display = 'table';
			
		}  
    	for(var i=0;i<element_axon.length;i++){
    		
			element_axon[i].style.display = 'table';
			
			
		}  
    	for(var i=0;i<element_axondendrite.length;i++){
    		
			element_axondendrite[i].style.display = 'table';
			
			
		}  
		 //A-D hybrid flag change js code change begins
	     	for(var i=0;i<element_combo_dendrite.length;i++){
				
	    	 element_combo_dendrite[i].style.display = 'none';
				
			}  
	    	for(var i=0;i<element_combo_axon.length;i++){
	    		
	    		element_combo_axon[i].style.display = 'none';
				
				
			}  
	    	for(var i=0;i<element_combo_axondendrite.length;i++){
	    		
	    		element_combo_axondendrite[i].style.display = 'table-cell';
				
				
			}   
	    	document.getElementById('axon-quote').style.display='none';
	    	document.getElementById('dendrite-quote').style.display='none';
	    	document.getElementById('combo-quote').style.display='block';
			//A-D hybrid flag change js code ends
    }
		

}

//====================================================
function show_only(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_morphology_linking_pmid_isbn.php";

	location.href = destination_page+"?name_show_only="+name+"&start="+start2+"&stop="+stop2+"&name_show_only_var=1";
}

function show_only_article(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_morphology_linking_pmid_isbn.php";
	location.href = destination_page+"?name_show_only_article="+name+"&start=0&stop="+stop2+"&name_show_only_article_var=1";
}

function show_only_publication(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_morphology_linking_pmid_isbn.php";
	location.href = destination_page+"?name_show_only_journal="+name+"&start=0&stop="+stop2+"&name_show_only_journal_var=1";
}

function show_only_authors(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_morphology_linking_pmid_isbn.php";
	location.href = destination_page+"?name_show_only_authors="+name+"&start=0&stop="+stop2+"&name_show_only_authors_var=1";
}

function show_only_morphology(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_morphology_linking_pmid_isbn.php";
	location.href = destination_page+"?name_show_only_morphology="+name+"&start=0&stop="+stop2+"&name_show_only_morphology_var=1";
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>Evidence Page</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>

<div class='title_area'>
	<font class="font1">Morphology evidence page</font>
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
					Neuron Type
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; <?php $id=$type->getId();
								 $name=$type->getName();
					print("<a href='neuron_page.php?id=$id'>$name</a>"); ?>
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right">&nbsp;</td>
				<td align="left" width="80%" class="table_neuron_page2">&nbsp;&nbsp;<strong>Hippocampome Neuron ID: <?php echo $id?></strong></td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
				<?php
					if ($color == 'red')
						$name1 = "Axons";
					if ($color == 'blue')
						$name1 = "Dendrites";				
					if ($color == 'violet')
						$name1 = "Axons and Dendrites";			
					if ($color == 'somata')
						$name1 = "Somata";				
					
					//print ("&nbsp; <strong>$name1</strong> in <strong>$val_property</strong>");
					print ("&nbsp; <strong>PMID/ISBN: $linking_pmid_isbn</strong>");
				?>
				</td>
			</tr>								
		</table>
		
    <table width="80%" border="0" cellspacing="2" cellpadding="5" padding-top="5"> 
<tr>
<td class="table_neuron_page2" padding="5">
      All of the evidence provided on Hippocampome.org are quotes from scientific texts.  
			However, because quoted passages may be difficult to understand in isolation, contextual information and expanded abbreviations set in square brackets have been added for clarity.
</td>
</tr>
</table>
<br/>			
<?php
	if ($part != 'axons_dendrites')
		$n_interraction = 1;
	else
		$n_interraction = 2;
						
	for ($tt=0; $tt<$n_interraction; $tt++)
	{
		if ($n_interraction == 1)
		{	
			// Axons or Dendrites
			// Retrieve property_id from Property by using Type_id
			$property  -> retrive_ID(1, $part, 'in', $val_property);
			$n_property_id = $property -> getNumber_type();				
		}
		else
		{
			// Axons and Dendrites
			if ($tt == 0)
			{
				$part1[$tt] = 'Axons';
				$property  -> retrive_ID(1, 'axons', 'in', $val_property);
				$n_property_id = $property -> getNumber_type();										
			}
			if ($tt == 1)
			{
				$part1[$tt] = 'Dendrites';
				$property  -> retrive_ID(1, 'dendrites', 'in', $val_property);
				$n_property_id = $property -> getNumber_type();										
			}			
		}
						
		for ($i=0; $i<$n_property_id; $i++)
		{
			$property_id[$i] = $property -> getProperty_id($i);
			// Retrive Evidence_id from evidencepropertyyperel by using $property_id and $type_id:
			$evidencepropertyyperel -> retrive_evidence_id($property_id[$i], $id_neuron);				
			$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
		}

		// Retrieve morphology Evidence_id from EvidenceProperTyypeRel by using $type_id and $pmid_isbn
		$evidencepropertyyperel -> retrieve_morphology_evidence_id_by_type($id_neuron);				
		$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
												
		$n_article = 0; // <-- Number of articles
		for ($i=0; $i<$n_evidence_id; $i++)
		{
			$evidence_id[$i] = $evidencepropertyyperel -> getEvidence_id_array($i);
				
			// Retrieve Fragment_id frmo EvidenceFragmentRel by using Evidence_id
			$evidencefragmentrel -> retrive_fragment_id($evidence_id[$i]);
					
			$n_fragment_id = $evidencefragmentrel -> getN_fragment_id();
				
			for ($i1=0; $i1<$n_fragment_id; $i1++)
			{
				$fragment_id[$n_article] = $evidencefragmentrel -> getFragment_id_array($i1);
				$n_article = $n_article + 1;
			}
		}
				
		for ($i=0; $i<$n_article; $i++)
		{
			// Retrieve Quote and page_location and original_id from Fragment bu using fragment_id:
			$fragment -> retrive_by_id($fragment_id[$i]);
			$pmid_isbn= $fragment -> getPmid_isbn();
			if ($pmid_isbn!=$linking_pmid_isbn)
			{
				continue;
			}
			$quote = $fragment -> getQuote();
			$quote = quote_replaceIDwithName($quote);
			$original_id = $fragment -> getOriginal_id();
			$pmid_isbn_page= $fragment -> getPmid_isbn_page();
			$page_location = $fragment -> getPage_location();
				
			//Retreive information from attachment table
			//$attachment_obj->retrive_by_id($fragment_id[$i],$id_neuron);
					
			if ($pmid_isbn_page!=0 && $pmid_isbn_page!= NULL)
			{
				$article -> retrive_by_pmid_isbn_and_page_number($pmid_isbn, $pmid_isbn_page);
				$id_article= $article -> getID();
			}
					
			//$articleevidencerel -> retrive_article_id($fragment_id[$i]);
			else 
			{
				// retrieve article_id from ArticleEvidenceRel by using Evidence_id
				$articleevidencerel -> retrive_article_id($evidence_id[$i]);
				$id_article = $articleevidencerel -> getArticle_id_array(0);
				// retrieve all information from article table by using article_id
				$article -> retrive_by_id($id_article) ;
			}
					
			$title = $article -> getTitle();
			$publication = $article -> getPublication();
			$year = $article -> getYear();
			$pmid_isbn = $article -> getPmid_isbn(); 
			$first_page = $article -> getFirst_page(); 
			$last_page = $article -> getLast_page(); 
			$pmcid = $article -> getPmcid(); 
			$nihmsid = $article -> getNihmsid(); 
			$doi = $article -> getDoi(); 
			$open_access = $article -> getOpen_access(); 
			$citation_count = $article -> getLast_page(); 
			$volume = $article -> getVolume();
			$issue = $article -> getIssue();
						
			// remove period in the title ------------------------------------------	
			if ($title[$ui] == '.')
				$title[$ui] = '';	
					
			// retrive the Author Position from ArticleAuthorRel
			$articleauthorrel -> retrive_author_position($id_article);
			$n_author = $articleauthorrel -> getN_author_id();
			for ($ii3=0; $ii3<$n_author; $ii3++)
				$auth_pos[$ii3] = $articleauthorrel -> getAuthor_position_array($ii3);
						
			if ($auth_pos)	
				sort ($auth_pos);
					
			$name_authors = NULL;
			for ($ii3=0; $ii3<$n_author; $ii3++)
			{
				$articleauthorrel -> retrive_author_id($id_article, $auth_pos[$ii3]);
				$id_author = $articleauthorrel -> getAuthor_id_array(0);
						
				$author -> retrive_by_id($id_author);
				$name_a = $author -> getName_author_array(0);
						
				$name_authors = $name_authors.', '.$name_a;
			}
			$name_authors[0] = '';
			//$name_authors = trim($name_authors);						
			//$name_authors = preg_replace("/'/", "\'", $name_authors);

			$pages= $first_page." - ".$last_page;

			if ($page)
			{
						
				// Insert the data in the temporary table: +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
				insert_temporary($name_temporary_table, $fragment_id[$i], $original_id, $quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $page_location, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, $part1[$tt], $volume, $issue);
				// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
		}
	}	
								
	// find the total number of Articles: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1";
	$rs = mysqli_query($GLOBALS['conn'],$query);
	$n_id_tot = 0;	 // Total number of articles:
	while(list($id) = mysqli_fetch_row($rs))			
		$n_id_tot = $n_id_tot + 1;
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
				
	// find the total number of quotes: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$query = "SELECT DISTINCT quote FROM $name_temporary_table WHERE show_only = 1";	
	$rs = mysqli_query($GLOBALS['conn'],$query);
	$number_of_quotes = 0;  // total number of quotes
	while(list($id) = mysqli_fetch_row($rs))			
		$number_of_quotes = $number_of_quotes + 1;
						
	// find the total number of quotes of type axon: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$query = "SELECT DISTINCT quote FROM $name_temporary_table WHERE show_only = 1 and type='Axons'";	
	$rs = mysqli_query($GLOBALS['conn'],$query);
	$number_of_quotes_axon = 0;  // total number of axon quotes
	while(list($id) = mysqli_fetch_row($rs))			
		$number_of_quotes_axon = $number_of_quotes_axon + 1;	
					
	// find the total number of quotes of type dendrite: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$query = "SELECT DISTINCT quote FROM $name_temporary_table WHERE show_only = 1 and type='Dendrites'";	
	$rs = mysqli_query($GLOBALS['conn'],$query);
	$number_of_quotes_dendrite = 0;  // total number of dendrite quotes
	while(list($id) = mysqli_fetch_row($rs))			
		$number_of_quotes_dendrite = $number_of_quotes_dendrite + 1;

	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++					
	$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 ORDER BY $order_by $type_order LIMIT $page_in , 10";
	$rs = mysqli_query($GLOBALS['conn'],$query);					
	$n_id = 0;
	while(list($title) = mysqli_fetch_row($rs))
	{
		$title_temp[$n_id] = $title;											
		$n_id = $n_id + 1;
	}					
?>	

<!-- ORDER BY: _______________________________________________________________________________________________________ -->
					
<table width="80%" border="0" cellspacing="2" cellpadding="0">
	<tr>		
		<?php 
			// -----------------------------------------------------------------------------------------
			if ($n_id_tot > 1)
			{
		?>			
				<td width="10%">
					<font class="font2">Order by:</font>
				</td>
				<td width="20%">				
					<form action="property_page_morphology_linking_pmid_isbn.php" method="post" style="display:inline">
						<select name='order' size='1' cols='10' class='select1'>
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
							<OPTION VALUE='-'>-</OPTION>
							<OPTION VALUE='year'>Date</OPTION>
							<OPTION VALUE='publication'>Journal / Book</OPTION>
							<OPTION VALUE='authors'>First Authors</OPTION>
						</select>
					</form>	
				</td>
				<td width="10%">
					<input type="submit" name='order_ok' value="GO"  />
				</td>
		<?php
			}
			// ---------------------------------------------------------------------------------------------
			else
			{
				print ("<td width='40%'></td>");
			}
		?>

		<td width="20%">
			<?php
				if ($color == 'violet')
				{
			?>	
					<form>
						<span style='color:rgb(254,1,2)'  ><input type="checkbox" name="violet" value="axon" id="axoncheck" checked onclick="evidencetoggle()"> axon</input></span>
						<span style='color:rgb(1,1,153)' ><input type="checkbox" name="violet" value="dendrite" id="dendritecheck" checked onclick="evidencetoggle()" >dendrite</input></span>
					</form>
			<?php
				}
			?>
		</td>
		<td width="40%" align="center">
			<form action="property_page_morphology_linking_pmid_isbn.php" method="post" style="display:inline">
				<input type="submit" name='see_all' value="Open All Evidence">
				<input type="submit" name='see_all' value="Close All Evidence">
				<input type="hidden" name='start' value='<?php print $page_in; ?>' />
				<input type="hidden" name='stop' value='<?php print $page_end; ?>' />
				<?php print ("<input type='hidden' name='name_show_only' value='$name_show_only'>"); ?>
			</form>
		</td>						
	</tr>
</table>
				
				<!-- TABLE SHOW ONLY *******************************************************************************************************************
				************************************************************************************************************************************* -->				
				<!-- END TABLE SHOW ONLY ***************************************************************************************************************
				************************************************************************************************************************************* -->				
				<br/>

			<?php	
				// There are no results available:
				if ($n_id == 0)
					print ("<br><font class='font12'>There are no results available.</font><br><br>");
									
				for ($i=0; $i<$n_id; $i++)
				{	
				
					// retrieve information about the authors, journals and otehr by using name of article:
					$query = "SELECT id, authors, publication, year, PMID, pages, page_location, show1, pmcid, nihmsid, doi, show_only, volume, issue FROM $name_temporary_table WHERE title = '$title_temp[$i]' ";					
					$rs = mysqli_query($GLOBALS['conn'],$query);	
					$auth=array();	
							
					while(list($id, $authors, $publication, $year, $PMID, $pages, $page_location, $show, $pmcid, $nihmsid, $doi, $show_only, $volume, $issue) = mysqli_fetch_row($rs))
					{			
						$auth=array();
						$authors2="";
						$f_auth="";
						$authors1 = $authors;
						$temp=explode(",", $authors);
						$auth=array_merge($auth,$temp);
						for($x=0;$x<sizeof($auth);$x++)
						{
							$f_auth=substr(trim($auth[$x]),0,1);
							$auth_final=trim($auth[$x]);
							$auth_final=preg_replace("/'/", "&#39;", $auth_final);
							if($x!=sizeof($auth)-1)
								$authors2.=" <a href='find_author.php?name_author=$auth_final&first_author=$f_auth&new=1&see_result=1'>$auth[$x]</a>,";	
							else 
								$authors2.=" <a href='find_author.php?name_author=$auth_final&first_author=$f_auth&new=1&see_result=1'>$auth[$x]</a>";
						}
						
						$year1 = $year;
						$publication1 = $publication;
						$PMID1 = $PMID;
						$pages1 = $pages;	
						$doi1 = $doi;
						$show1 = $show;
						$show_only1 = $show_only;
						$volume1 = $volume;
						$issue1 = $issue;
					}					
				
					// TABLE OF THE ARTICLES: ************************************************************************************************
						$first_author = NULL;
						for ($yy=0; $yy<strlen($authors1); $yy++)
						{
							if ($authors1[$yy] != ',')
								$first_author = $first_author.$authors1[$yy];
							else
								break;	
						}
						
						print ("<table width='80%' border='0' cellspacing='2' cellpadding='5'>");
						
						print ("
							<tr>
							<td width='10%' align='center'>
							</td>
							<td width='5%' align='center' class='table_neuron_page2' valign='center'>
						");							
						
						if ($show1 == 0)
						{
							print ("<form action='property_page_morphology_linking_pmid_isbn.php' method='post' style='display:inline'>");
							print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
							print ("<input type='hidden' name='start' value='$page_in' />");
							print ("<input type='hidden' name='stop' value='$page_end' />");
							print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
							print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
							print ("</form>");
						}
						if ($show1 == 1)
						{
							print ("<form action='property_page_morphology_linking_pmid_isbn.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
							print ("<input type='submit' name='show_0' value=' ' class='show0'>");
							print ("<input type='hidden' name='start' value='$page_in' />");
							print ("<input type='hidden' name='stop' value='$page_end' />");
							print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
							print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
							print ("</form>");
						}
						
						
						if (strlen($PMID1) > 10 )
						{									
							$link2 = "<a href='$link_isbn$PMID1' target='_blank'>";
							$string_pmid = "<strong>ISBN: </strong>".$link2;	
						}
						else
						{
							$value_link ='PMID: '.$PMID1;
							$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";								
							$string_pmid = "<strong>PMID: </strong>".$link2;			
						}
						
						if ($issue1 != NULL)
							$issue_tot = "($issue1),";
						else
							$issue_tot = "";
							
						if ($doi1 != NULL)
							$doi_tot = "DOI: $doi1";
						else
							$doi_tot = "";							
						
						print ("
							</td>							
							<td align='left' width='85%' class='table_neuron_page2'>
							
							<font color='#000000'><strong>$title_temp[$i]</strong></font> <br>
							$authors2 <br>
							$publication1, $year1, $volume1 $issue_tot pages: $pages1 <br>
							$string_pmid <font class='font13'>$PMID1</font></a>; $doi_tot
							</td>	
							</tr>																																		
						</table>");
						
						// TABLE for Quotes: ------------------------------------------------------------------------------------------------------------------------------------------
						if ($show1 == 1)
						{					
							$query = "SELECT id_fragment, id_original, quote, page_location, type FROM $name_temporary_table WHERE title = '$title_temp[$i]' ORDER BY id_fragment ASC";	
							$rs = mysqli_query($GLOBALS['conn'],$query);	
							$rs_combo=mysqli_query($GLOBALS['conn'],$query); // to check for combo-neuron type
							$id_fragment_old = NULL;
							$type_old = NULL;
							$n5=0;				
							list($id_fragment_next, $id_original_next, $quote_next, $page_location_next, $type_next) = mysqli_fetch_row($rs_combo);
							while(list($id_fragment, $id_original, $quote, $page_location, $type) = mysqli_fetch_row($rs))
							{	
									list($id_fragment_next, $id_original_next, $quote_next, $page_location_next, $type_next) = mysqli_fetch_row($rs_combo);
								
								
									if (($id_fragment == $id_fragment_old));//duplicate  neuron copies
									else if(($id_fragment == $id_fragment_next)&&($type!=$type_next)){ //axon-dendrite neuron type
									
									if ($type)
									{
								//		if ($n5 == 0)
								//			$type_show = $type;
								//		else
											$type_show = "Axon and Dendrite";
									}
									else
										$type_show = '';								
								if($color == 'violet'){
		//								print("<br>");
								//		if ($type_show == 'Axons')
								//			print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axon'>");
								//		if ($type_show == 'Dendrites')
								//			print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendrite'>");
										if ($type_show == 'Axon and Dendrite')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendrite'>");								
									}else{
										print ("<table width='80%' border='0' cellspacing='2' cellpadding='5'>");
									
									}
								
								//	print ("<br><table width='80%' border='0' cellspacing='2' cellpadding='5'>");								
									print ("<tr>");
											
									if ($type_show == 'Axons')		
										print ("<td width='15%' rowspan='3' align='right' valign='top'><img src='images/axon.png'></td>");
									if ($type_show == 'Dendrites')		
										print ("<td width='15%' rowspan='3' align='right' valign='top'><img src='images/dendrite.png'></td>");											
									if ($type_show == 'Axon and Dendrite'){		
										print ("<td width='15%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendrite'><img src='images/axon-dendrite.png'></td>");
										print ("<td width='15%' rowspan='3' align='right' valign='top' style='display:none' class='comboflag-axon'><img src='images/axon.png'></td>");
										print ("<td width='15%' rowspan='3' align='right' valign='top' style='display:none' class='comboflag-dendrite'><img src='images/dendrite.png'></td>");	
									}
									if ($type_show == '')											
										print ("<td width='15%' rowspan='3' align='right' valign='top'></td>");	
										
		
									/* print ("<td width='70%' class='table_neuron_page2' align='left'>");
									print ("$id_fragment (original: $id_original) - $type_show");
									print ("</td>"); */
									
									
									//print ("<td width='15%' align='left'> </td></tr>");
																	
									// retrieve the attachament from "fragment" with original_id *****************************
								//	$fragment -> retrive_attachment_by_original_id($id_original);
								//	$attachment = $fragment -> getAttachment();
								//	$attachment_type = $fragment -> getAttachment_type();
									
									// retrieve the attachament from "attachment" with original_id and cell-id(id_neuron)*****************************
									$attachment_obj -> retrive_attachment_by_original_id($id_original, $id_neuron);
									$attachment = $attachment_obj -> getName();
									$attachment_type = $attachment_obj -> getType();
									
									
									
									// change PFD in JPG:
									$link_figure="";
									$attachment_jpg = str_replace('jpg', 'jpeg', $attachment);
									//echo "$attachment_jpg";
									if($attachment_type=="marker_figure"||$attachment_type=="marker_table"){
										$link_figure = "attachment/marker/".$attachment_jpg;
								//		echo "marker:-".$link_figure;
									}
									
									if($attachment_type=="morph_figure"||$attachment_type=="morph_table"){
										$link_figure = "attachment/morph/".$attachment_jpg;
								//		echo "morph:-".$link_figure;
									}
									
									if($attachment_type=="ephys_figure"||$attachment_type=="ephys_table"){
										$link_figure = "attachment/ephys/".$attachment_jpg;
								//		echo "ephys:-".$link_figure;
									}
									//$link_figure = "figure/".$attachment_jpg;
									
									$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
									$link_figure_pdf = "figure_pdf/".$attachment_pdf;
									// **************************************************************************************									
									
									print ("
									<tr>	
										<td width='70%' class='table_neuron_page2' align='left'>
											Page location: <span title='$id_fragment (original: $id_original)'>$page_location</span>
										</td>
										<td width='15%' align='center'>");																											
										
									print ("</td></tr>	
									<tr>		
										<td width='70%' class='table_neuron_page2' align='left'>
											<em>$quote</em>
										</td>
										<td width='15%' class='table_neuron_page2' align='center'>");
										
										if ($attachment_type=="morph_figure"||$attachment_type=="morph_table")
										{
											print ("<a href='$link_figure' target='_blank'>");
											print ("<img src='$link_figure' border='0' width='80%'>");
											print ("</a>");
										}	
										else;
										print("</td></tr>");
	
									print ("</table>");
								
									$id_fragment_old = $id_fragment;
									$type_old=$type;
								
					}//================================prasad changes=======================
								else
								{
									
									if ($type)
									{
								//		if ($n5 == 0)
											$type_show = $type;
								//		else
								//			$type_show = "Axon and Dendrite";
									}
									else
										$type_show = '';								
									if($color == 'violet'){
		//								print("<br>");
										if ($type_show == 'Axons')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axon'>");
										if ($type_show == 'Dendrites')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendrite'>");
					//					if ($type_show == 'Axon and Dendrite')
					//						print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendrite'>");								
									}else{
										print ("<table width='80%' border='0' cellspacing='2' cellpadding='5'>");
									
									}
								
								//	print ("<br><table width='80%' border='0' cellspacing='2' cellpadding='5'>");								
									print ("<tr>");
											
									if ($type_show == 'Axons')		
										print ("<td width='15%' rowspan='3' align='right' valign='top'><img src='images/axon.png'></td>");
									if ($type_show == 'Dendrites')		
										print ("<td width='15%' rowspan='3' align='right' valign='top'><img src='images/dendrite.png'></td>");											
					//				if ($type_show == 'Axon and Dendrite')		
					//					print ("<td width='15%' rowspan='3' align='right' valign='top'><img src='images/axon-dendrite.png'></td>");	
									if ($type_show == '')		
										print ("<td width='15%' rowspan='3' align='right' valign='top'></td>");	
										
		
									/* print ("<td width='70%' class='table_neuron_page2' align='left'>");
									print ("$id_fragment (original: $id_original) - $type_show");
									print ("</td>"); */
									
									
								//	print ("<td width='15%' align='left'> </td></tr>");
									print ("</tr>");
																	
									// retrieve the attachament from "fragment" with original_id *****************************
								//	$fragment -> retrive_attachment_by_original_id($id_original);
								//	$attachment = $fragment -> getAttachment();
								//	$attachment_type = $fragment -> getAttachment_type();
									
									// retrieve the attachament from "attachment" with original_id and cell-id(id_neuron)*****************************
									$attachment_obj -> retrive_attachment_by_original_id($id_original, $id_neuron);
									$attachment = $attachment_obj -> getName();
									$attachment_type = $attachment_obj -> getType();
									
									
									
									// change PFD in JPG:
									$link_figure="";
									$attachment_jpg = str_replace('jpg', 'jpeg', $attachment);
									//echo "$attachment_jpg";
									if($attachment_type=="marker_figure"||$attachment_type=="marker_table"){
										$link_figure = "attachment/marker/".$attachment_jpg;
								//		echo "marker:-".$link_figure;
									}
									
									if($attachment_type=="morph_figure"||$attachment_type=="morph_table"){
										$link_figure = "attachment/morph/".$attachment_jpg;
								//		echo "morph:-".$link_figure;
									}
									
									if($attachment_type=="ephys_figure"||$attachment_type=="ephys_table"){
										$link_figure = "attachment/ephys/".$attachment_jpg;
								//		echo "ephys:-".$link_figure;
									}
									//$link_figure = "figure/".$attachment_jpg;
									
									$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
									$link_figure_pdf = "figure_pdf/".$attachment_pdf;
									// **************************************************************************************									
									
									print ("
									<tr>	
										<td width='70%' class='table_neuron_page2' align='left'>
											Page location: <span title='$id_fragment (original: $id_original)'>$page_location</span>
										</td>
										<td width='15%' align='center'>");																											
										
									print ("</td></tr>	
									<tr>		
										<td width='70%' class='table_neuron_page2' align='left'>
											<em>$quote</em>
										</td>
										<td width='15%' class='table_neuron_page2' align='center'>");
										
										if ($attachment_type=="morph_figure"||$attachment_type=="morph_table")
										{
											print ("<a href='$link_figure' target='_blank'>");
											print ("<img src='$link_figure' border='0' width='80%'>");
											print ("</a>");
										}	
										else;
										print("</td></tr>");
	
									print ("</table>");
								
									$id_fragment_old = $id_fragment;
									$type_old=$type;
								}
						
								$n5 = $n5 + 1;
						
							}							
						}
		//				print("<br>");	

				} // end FOR $i
		?>

			<!-- PAGINATION TABLE ********************************************************************** -->	
				<table width="80%" border="0" cellspacing="2" cellpadding="0">
					<tr>			
						<td width="25%"></td>		
						<td width="50%" align="center">
							<font class="font3" id="combo-quote" style='display:block'>
							<?php
								$page_in1 = $page_in + 1;

								if ($page_end >= $n_id_tot) 
								{
									$page_end1 = $n_id_tot;
									$no_button_up = 1;
								}
								else
									$page_end1 = $page_end;
								
								if ($page_in == 0) 
									$no_button_down = 1;
								
								if ($n_id_tot != 0){
									print ("$page_in1 - $page_end1 of $n_id_tot articles ($number_of_quotes Quotes)");	
								 
								}
								 // Last page:
								 $last_page1 = $n_id_tot / 10;
								 $last_array =  explode('.', $last_page1);	
							
								 if ($last_array[1] == NULL)
								 	$last_page2 = ($last_array[0] - 1) * 10;	
								else	
								 	$last_page2 = $last_array[0] * 10;								 		 
							?>
							</font>
							<!-- AXON QUOTES -->
							
							<font class="font3" id="axon-quote" style='display:none'>
							<?php
								$page_in1 = $page_in + 1;

								if ($page_end >= $n_id_tot) 
								{
									$page_end1 = $n_id_tot;
									$no_button_up = 1;
								}
								else
									$page_end1 = $page_end;
								
								if ($page_in == 0) 
									$no_button_down = 1;
								
								if ($n_id_tot != 0){
									print ("$page_in1 - $page_end1 of $n_id_tot articles ($number_of_quotes_axon Axon Quotes)");	
										
								}
								 // Last page:
								 $last_page1 = $n_id_tot / 10;
								 $last_array =  explode('.', $last_page1);	
							
								 if ($last_array[1] == NULL)
								 	$last_page2 = ($last_array[0] - 1) * 10;	
								else	
								 	$last_page2 = $last_array[0] * 10;								 		 
							?>
							</font>
							<!--  -->
						<!-- DENDRITE QUOTES -->
							<font class="font3" id="dendrite-quote" style='display:none'>
							<?php
								$page_in1 = $page_in + 1;

								if ($page_end >= $n_id_tot) 
								{
									$page_end1 = $n_id_tot;
									$no_button_up = 1;
								}
								else
									$page_end1 = $page_end;
								
								if ($page_in == 0) 
									$no_button_down = 1;
								
								if ($n_id_tot != 0){
									print ("$page_in1 - $page_end1 of $n_id_tot articles ($number_of_quotes_dendrite Dendrite Quotes)");	
								}
								 // Last page:
								 $last_page1 = $n_id_tot / 10;
								 $last_array =  explode('.', $last_page1);	
							
								 if ($last_array[1] == NULL)
								 	$last_page2 = ($last_array[0] - 1) * 10;	
								else	
								 	$last_page2 = $last_array[0] * 10;								 		 
							?>
							</font>
						<!--  -->
						&nbsp; &nbsp;
						
						<form action="property_page_morphology_linking_pmid_isbn.php" method="post" style="display:inline">
							<?php 
								if ($no_button_down == 1);
								else
								{
									print ("<input type='submit' name='first_page' value=' << ' class='botton1'/>");
									print ("<input type='submit' name='down' value=' < ' class='botton1'/>");		
								}
							?>								
							<input type="hidden" name='start' value='<?php print $page_in-10; ?>' />
							<input type="hidden" name='stop' value='<?php print $page_end-10; ?>' />
							
						</form>	
						<form action="property_page_morphology_linking_pmid_isbn.php" method="post" style="display:inline">
						&nbsp; &nbsp;
							
							<?php 
								if ($no_button_up == 1);
								else
								{
									print ("<input type='submit' name='up' value=' > ' class='botton1'/>");
									print ("<input type='submit' name='last_page' value=' >> ' class='botton1'/>");
								}
							?>							
							<input type="hidden" name='start' value='<?php print $page_in+10; ?>' />
							<input type="hidden" name='stop' value='<?php print $page_end+10; ?>' />
							<input type="hidden" name='value_last_page' value='<?php print $last_page2; ?>' />
							<input type="hidden" name='value_last_page_final' value='<?php print $n_id_tot; ?>' />
						</form>
						</td>
						<td width="25%"></td>	
					</tr>
				</table>

		</td>
	</tr>
</table>
</body>
</html>	

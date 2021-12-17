<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
include ("function/quote_manipulation.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.synonym.php');
require_once('class/class.fragment.php');
require_once('synap_prob/class/class.fragment_synpro.php');
require_once('class/class.attachment.php');
require_once('synap_prob/class/class.attachment_synpro.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('synap_prob/class/class.evidencepropertyyperel_synpro.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.articleevidencerel.php');
require_once('synap_prob/class/class.articleevidencerel_synpro.php');
require_once('class/class.articleauthorrel.php');
include ("synap_prob/functions/retrieve_evidences.php");

$class_fragment='SynproFragment';
$fragment = new fragment_synpro($class_fragment);

function checkNeuronProperty($color)
{
	$part="";
	if ($color == 'red')
		$part = "axons";
	if ($color == 'redSoma')
		$part = "axons_somata";
	if ($color == 'blue')
		$part = "dendrites";
	if ($color == 'blueSoma')
		$part = "dendrites_somata";
	if ($color == 'violet')
		$part = "axons_dendrites";
	if ($color == 'violetSoma')
		$part = "axons_dendrites_somata";
	if ($color == 'somata')
		$part = "somata";	
	return $part;
}
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
	////set_magic_quotes_runtime(0);	
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
// set property of synapse probability page
$page = $_REQUEST['page'];
$sub_show_only = $_SESSION['synpro_sub_show_only']; 
$name_show_only_article = $_SESSION['synpro_name_show_only_article'];

$see_all = $_REQUEST['see_all']; 
// open all evidences
if ($see_all == 'Open All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}
// close all evidences
if ($see_all == 'Close All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}
// Change the show coloums in the temporary table: 
if ($_REQUEST['show_1']) //  ==> ON
{
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

if ($_REQUEST['show_0']) //  ==> OFF
{
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}
// Request coming from another page
if ($page) 
{
	$name_show_only = 'all';
	$_SESSION['synpro_name_show_only'] = $name_show_only;
	$sub_show_only = NULL;
	$_SESSION['synpro_sub_show_only'] = $sub_show_only;	
	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';	
	$name_show_only_authors = 'all';

	$id1_neuron = $_REQUEST['id1_neuron'];
	$id2_neuron = $_REQUEST['id2_neuron'];
	$val1_property = $_REQUEST['val1_property'];
	$val2_property = $_REQUEST['val2_property'];
	$color1 = $_REQUEST['color1'];
	$color2 = $_REQUEST['color2'];
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$ip_address = str_replace(':', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='temp_'.$ip_address.'_'.$id1_neuron.$color1.'__'.$time_t;
	//echo "name_temporary_table: ".$name_temporary_table;
	$_SESSION['synpro_name_temporary_table'] = $name_temporary_table;
	create_temp_table($name_temporary_table);	
	
	$val1_property = str_replace('_', ':', $val1_property);
	$_SESSION['id1_neuron'] = $id1_neuron;
	$_SESSION['id2_neuron'] = $id2_neuron;
	$_SESSION['val1_property'] = $val1_property;	
	$_SESSION['val2_property'] = $val2_property;	
	$_SESSION['color1'] = $color1;
	$_SESSION['color2'] = $color2;
	$neuron_show_only_value="";
	if(strstr(checkNeuronProperty($color1),"axons"))
		$neuron_show_only_value=$neuron_show_only_value.",Axons";
	if(strstr(checkNeuronProperty($color1),"dendrites"))
		$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
	if(strstr(checkNeuronProperty($color1),"somata"))
		$neuron_show_only_value=$neuron_show_only_value.",Somata";
	$_SESSION['synpro_neuron_show_only_value']=$neuron_show_only_value;
	
	$page_in = 0;
	$page_end = 10;
	
	$order_by = 'year';     //Default
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
	$name_show_only = $_SESSION['synpro_name_show_only'];
	$_SESSION['synpro_name_show_only'] = $name_show_only;
	$name_show_only_journal = $_SESSION['synpro_name_show_only_journal'];
	$name_show_only_authors = $_SESSION['synpro_name_show_only_authors'];
	$name_show_only_article = $_SESSION['synpro_name_show_only_article'];

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
	$id1_neuron = $_SESSION['id1_neuron'];
	$id2_neuron = $_SESSION['id2_neuron'];
	$val1_property = $_REQUEST['val1_property'];
	$val2_property = $_REQUEST['val2_property'];
	$color1 = $_SESSION['color1'];
	$color2 = $_SESSION['color2'];
	if(!$_SESSION['synpro_neuron_show_only_value']){
		$neuron_show_only_value="";
		if(strstr(checkNeuronProperty($color1),"axons"))
			$neuron_show_only_value=$neuron_show_only_value.",Axons";
		if(strstr(checkNeuronProperty($color1),"dendrites"))
			$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
		if(strstr(checkNeuronProperty($color1),"somata"))
			$neuron_show_only_value=$neuron_show_only_value.",Somata";	
		$_SESSION['synpro_neuron_show_only_value']=$neuron_show_only_value;
	}
	else{
		$neuron_show_only_value=$_SESSION['synpro_neuron_show_only_value'];
	}
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	
}
// SHOW ONLY 
$name_show_only_var = $_REQUEST['name_show_only_var'];

if ($name_show_only_var)
{
	
	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['synpro_name_show_only'] = $name_show_only;

	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['synpro_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$_SESSION['synpro_name_show_only_article'] = $name_show_only_article;
		$sub_show_only = 'article';
		$_SESSION['synpro_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$_SESSION['synpro_name_show_only_journal'] = $name_show_only_journal;
		$sub_show_only = 'name_journal';
		$_SESSION['synpro_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$_SESSION['synpro_name_show_only_authors'] = $name_show_only_authors;
		$sub_show_only = 'authors';
		$_SESSION['synpro_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
} 
// ARTICLE - BOOK OPTION
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['synpro_name_show_only_article'] = $name_show_only_article;
	$_SESSION['synpro_name_show_only_journal'] = 'all';
	$_SESSION['synpro_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['synpro_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
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
} 
// JOURNAL OPTION
$name_show_only_journal_var = $_REQUEST['name_show_only_journal_var'];
if ($name_show_only_journal_var)
{
	$name_show_only_journal = $_REQUEST['name_show_only_journal'];
	$_SESSION['synpro_name_show_only_journal'] = $name_show_only_journal;
	$_SESSION['synpro_name_show_only_article'] = 'all';
	$_SESSION['synpro_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['synpro_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	if ($name_show_only_journal == 'all')
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	else
		$query = "UPDATE $name_temporary_table SET show_only =  '0' WHERE publication != '$name_show_only_journal'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	

} 
// AUTHORS OPTION
$name_show_only_authors_var  = $_REQUEST['name_show_only_authors_var'];
if ($name_show_only_authors_var)
{
	$name_show_only_authors = $_REQUEST['name_show_only_authors'];
	$_SESSION['synpro_name_show_only_authors'] = $name_show_only_authors;
	$_SESSION['synpro_name_show_only_article'] = 'all';
	$_SESSION['synpro_name_show_only_journal'] = 'all';
	$name_show_only = $_SESSION['synpro_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];
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
} 
// axon, dedrite/soma checkbox checked or unchecked
$neuron_show_only = $_REQUEST['neuron_show_only'];
if ($neuron_show_only){
	$neuron_show_only_value = $_REQUEST['neuron_show_only_value'];
	$_SESSION['synpro_neuron_show_only_value'] = $neuron_show_only_value;
	$name_show_only = $_SESSION['synpro_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['synpro_name_temporary_table'];

}
$part=checkNeuronProperty($color1);
$part2=checkNeuronProperty($color2);

$type = new type($class_type);
$type -> retrive_by_id($id1_neuron);
$type2 = new type($class_type);
$type2 -> retrive_by_id($id2_neuron);
$property = new property($class_property);
//$fragment = new fragment($class_fragment);
$class_fragment='SynproFragment';
$fragment = new fragment_synpro($class_fragment);
$attachment_obj = new attachment_synpro($class_attachment);
//$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$class_evidence_property_type_rel = 'SynproEvidencePropertyTypeRel';
$evidencepropertyyperel = new evidencepropertyyperel_synpro($class_evidence_property_type_rel);
$class_evidencefragmentrel='SynproEvidenceFragmentRel';
$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);
//$articleevidencerel = new articleevidencerel($class_articleevidencerel);
$class_articleevidencerel='SynproArticleEvidenceRel';
$articleevidencerel = new articleevidencerel_synpro($class_articleevidencerel);
$article = new article($class_article);
$articleauthorrel = new articleauthorrel($class_articleauthorrel);
$author = new author($class_author);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<script type="text/javascript">
// Javascript function 
//================changes===========================
function changeCheckbox(start1,stop1){
	var axon = "";
	var dendrite = "";
	var soma="";
	if (document.getElementById('axoncheck') && document.getElementById('axoncheck').checked==true) {
		axon="Axons";
	}
	if (document.getElementById('dendritecheck') && document.getElementById('dendritecheck').checked==true) {
		dendrite="Dendrites";
	}
	if (document.getElementById('somatacheck') && document.getElementById('somatacheck').checked==true) {
		soma="Somata";
	}
	var checkbox_clicked=axon+","+dendrite+","+soma;
	var destination_page="property_page_synpro_nm.php";
	location.href = destination_page+"?neuron_show_only_value="+checkbox_clicked+"&start="+start1+"&stop="+stop1+"&neuron_show_only=1";
}


function show_only(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_synpro_nm.php";

	location.href = destination_page+"?name_show_only="+name+"&start="+start2+"&stop="+stop2+"&name_show_only_var=1";
}

function show_only_article(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_synpro_nm.php";
	location.href = destination_page+"?name_show_only_article="+name+"&start=0&stop="+stop2+"&name_show_only_article_var=1";
}

function show_only_publication(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_synpro_nm.php";
	location.href = destination_page+"?name_show_only_journal="+name+"&start=0&stop="+stop2+"&name_show_only_journal_var=1";
}

function show_only_authors(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_synpro_nm.php";
	location.href = destination_page+"?name_show_only_authors="+name+"&start=0&stop="+stop2+"&name_show_only_authors_var=1";
}


</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type->getNickname();
	$name2=$type2->getNickname();
	print("<title>Evidence - $name ($val1_property) and $name2 ($val2_property) </title>");
?>
<script type="text/javascript" src="style/resolution.js"></script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>

<div class='title_area' style="width:1200px">
	<font class='font1'>
<?php
	if (isset($_REQUEST['color1'])) {$color1 = $_REQUEST['color1'];}
	if (isset($_REQUEST['color2'])) {$color1 = $_REQUEST['color2'];}
	if (isset($_REQUEST['nm_page'])) {
		$nm_page=$_REQUEST['nm_page'];
		$_SESSION['nm_page']=$nm_page;
	}
	if (isset($_SESSION['nm_page'])) {
		$nm_page=$_SESSION['nm_page'];
	}
	if ($nm_page=='ps') {
		echo "Number of Potential Synapses Evidence Page";	
	}
	else if ($nm_page=='noc') {
		echo "Number of Contacts Evidence Page";	
	}
	else if ($nm_page=='prosyn') {		
		echo "Synaptic Probabilities Evidence Page";	
	}
?>
</font>
</div>

<br><br /><br><br />
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
					print("From: <a href='neuron_page.php?id=$id1_neuron'>$name</a>"); ?>
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right">&nbsp;</td>
				<!--td align="left" width="80%" class="table_neuron_page2">&nbsp;&nbsp;<strong>Hippocampome Neuron ID: <?php 
				//echo $id
				?></strong></td-->
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; <?php $id2=$type->getId();
								 $name_long2=$type2->getName();
					print("To: <a href='neuron_page.php?id=$id2_neuron'>$name_long2</a>"); ?>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; Type:
				<?php
					if (isset($_REQUEST['connection_type'])) {
										$connection_type=$_REQUEST['connection_type'];}
					if ($connection_type == 1)
						$conn_type="Potential Inhibitory";
					else 
						$conn_type="Potential Excitatory";
					if ($known_unknown_flag == 1)
						$conn_type=$conn_type." and Known";
					elseif ($known_unknown_flag == -1)
						$conn_type=" Refuted";
					$conn_type=$conn_type." Connections ";
					print ("<strong>$conn_type</strong>");
				?>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
				<?php
					$name_neuron1 = checkNeuronProperty($color1);						
					$name_neuron2 = checkNeuronProperty($color2);						
					print ("&nbsp; <strong>Axons and dendrites</strong> in <strong>$val1_property</strong>");
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
<tr>
<td class="table_neuron_page2" padding="5">
<?php 
	if ($nm_page=="ps") 
	{
	echo "The average number of synapses per neuron pair is calculated by combining neuron type specific lengths of the presynaptic axons and the postsynaptic dendrites (evidenced below), the volume of the anatomical parcel in which they overlap, and estimates of the mean inter-bouton and inter-spine (or inter-shaft contact) distances as well as of the axon-dendrite interaction distance.";
	}
	else if ($nm_page=="noc") 
	{
	echo "The number of contacts per connected neuron pair is calculated by combining neuron type specific lengths and convex hulls of the presynaptic axons and the postsynaptic dendrites (evidenced below), and estimates of the mean inter-bouton and inter-spine (or inter-shaft contact) distances as well as of the axon-dendrite interaction distance.";
	}
	else if ($nm_page=="prosyn") 
	{
	echo "The connection probability for a pair of neuron types is calculated by combining neuron-type-specific convex hulls of the presynaptic axons and the postsynaptic dendrites (evidenced below) and the volume of the anatomical parcel in which they overlap.";
	}
?>
</td>
</tr>
    </table>
		<br />			

		<?php
			/*if ($part == 'axons_dendrites_somata')
				$n_interraction = 3;
			else if ($part == 'axons_dendrites' || $part == 'axons_somata' || $part == 'dendrites_somata')
				$n_interraction = 2;
			else 
				$n_interraction = 1;*/
			$n_interraction = 2; // always 2 for N by N
			$part = 'axons_dendrites'; // always axons_dendrites for N by N
						
			for ($tt=0; $tt<$n_interraction; $tt++)
			{				
				$val1_property_mod = $val1_property;
				if ($val1_property=='DG:All') {
					$val1_property_mod = 'DG';
				}
				else if ($val1_property=='CA1:All') {
					$val1_property_mod = 'CA1';
				}
				else if ($val1_property=='CA2:All') {
					$val1_property_mod = 'CA2';
				}
				else if ($val1_property=='CA3:All') {
					$val1_property_mod = 'CA3';
				}
				else if ($val1_property=='Sub:All') {
					$val1_property_mod = 'SUB';
				}
				else if ($val1_property=='EC:All') {
					$val1_property_mod = 'EC';
				}
				if ($tt == 0)
				{
					$part1[$tt] = 'Axons';
					$property  -> retrive_ID(1, 'axons', 'in', $val1_property_mod);
					$n_property_id = $property -> getNumber_type();							
					//echo "n_property_id: ".$n_property_id;
				}
				if ($tt == 1)
				{
					$part1[$tt] = 'Dendrites';
					$property  -> retrive_ID(1, 'dendrites', 'in', $val1_property_mod);
					$n_property_id = $property -> getNumber_type();	
					//echo "n_property_id: ".$n_property_id;	
				}
				//$n_property_id = 2; // Always 2 for N by N
				for ($i=0; $i<$n_property_id; $i++)
				{
					$property_id[$i] = $property -> getProperty_id($i);

					// Retrive Evidence_id from evidencepropertyyperel by using $property_id and $type_id:
					// $i==0 is axons, $i==1 is dendrites
					if ($tt==0) {
						$evidencepropertyyperel -> retrive_evidence_id($property_id[$i], $id1_neuron);	
						//echo "<br>id1_neuron:: $id1_neuron | ".$property_id[$i]."<br>";	
					}
					else if ($tt==1) {
						$evidencepropertyyperel -> retrive_evidence_id($property_id[$i], $id2_neuron);	
						//echo "<br>id2_neuron:: $id2_neuron | ".$property_id[$i]."<br>";	
					}
					//$evidencepropertyyperel -> retrive_evidence_id_n_by_n($property_id[$i], $id1_neuron, $id2_neuron);			
					$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
				}			
				//echo "n_evidence_id:<br>".$n_evidence_id;
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
					$quote = $fragment -> getQuote();
					$quote = quote_replaceIDwithName($quote);
					$original_id = $fragment -> getOriginal_id();
					$pmid_isbn= $fragment -> getPmid_isbn();
					$pmid_isbn_page= $fragment -> getPmid_isbn_page();
					$page_location = $fragment -> getPage_location();
					//Retreive information from attachment table					
					if ($pmid_isbn_page!=0 && $pmid_isbn_page!= NULL)
					{
						$article -> retrive_by_pmid_isbn_and_page_number($pmid_isbn, $pmid_isbn_page);
						$id_article= $article -> getID();
					}
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
					// remove period in the title 
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
						
						if($name_authors ==NULL)
							$name_authors = $name_a;
						else
							$name_authors = $name_authors.', '.$name_a;
					}
					$pages= $first_page." - ".$last_page;
					////// check for values needed for article display ///////
					$dendrite_group = array('Dendrites', 'Somata', 'AxonsSomata', 'AxonsDendrites', 'DendritesSomata', 'AxonsDendritesSomata');
					$axon_group = array('Axons','Somata','AxonsSomata','AxonsDendrites','AxonsDendritesSomata');
					$type_for_display=$part1[$tt];//$type;
					if (in_array($type_for_display,$dendrite_group)) {
						$neurite_ref = $val1_property.":D";
						$neuron_id=$id2_neuron;
					}
					elseif (in_array($type_for_display,$axon_group)) {
						$neurite_ref = $val1_property.":A";	
						$neuron_id=$id1_neuron;
					}
					$nq_neurite_name = $fragment->prop_name_to_nq_name($neurite_ref);
					$refID=$original_id;
					///
					if ($nm_page=='prosyn' or $nm_page=='noc') {
						$convexhullvolume=$fragment->getConvexHullVolume($neuron_id,$nq_neurite_name,$refID);
					}
					if ($nm_page=='ps' or $nm_page=='noc' or $nm_page=='prosyn') {
						$neurite_lengths=$fragment->getNeuriteLengths($neuron_id,$nq_neurite_name,$refID);
					}
					/*
					if ($nm_page=='prosyn' or $nm_page=='noc') {
						print ("
						<tr>
						<td width='70%' class='table_neuron_page2' align='left'>");
						print ("Convex hull volume in ".$val1_property.": $convexhullvolume μm&sup3;");
						print ("</td></tr>");
					}
					if ($nm_page=='ps' or $nm_page=='noc' or $nm_page=='prosyn') {
						print ("
						<tr>
						<td width='70%' class='table_neuron_page2' align='left'>");
						$values_count=$neurite_lengths[2];
						if ($values_count>1) {
							if (in_array($type_for_display,$axon_group)) {
								print ("Axonal lengths: mean ".$neurite_lengths[1]." ± standard deviation ".$neurite_lengths[0]." (n = ".$neurite_lengths[2]."; min = ".$neurite_lengths[3]."; max = ".$neurite_lengths[4].")");
							}
							if (in_array($type_for_display,$dendrite_group)) {
								print ("Dendritic lengths: mean ".$neurite_lengths[1]." ± standard deviation ".$neurite_lengths[0]." (n = ".$neurite_lengths[2]."; min = ".$neurite_lengths[3]."; max = ".$neurite_lengths[4].")");
							}
						}
						else {
							if (in_array($type_for_display,$axon_group)) {
								print ("Axonal length in ".$parcel.": ".$neurite_lengths[1]." μm");										}
							if (in_array($type_for_display,$dendrite_group)) {
								print ("Dendritic length in ".$parcel.": ".$neurite_lengths[1]." μm");
							}
						}
						print ("</td></tr>");
					}
					*/
					////// filter articles //////
					$filter_out = true;
					if ($nm_page=='ps' && $neurite_lengths[1] != 0) {
						$filter_out = false;
					}
					if ($nm_page=='noc' && $neurite_lengths[1] != 0 && $convexhullvolume != 0) {
						$filter_out = false;
					}
					if ($nm_page=='prosyn' && $neurite_lengths[1] != 0 && $convexhullvolume != 0) {
						$filter_out = false;
					}
					if ($page && $filter_out != true)
					{
						// Insert the data in the temporary table:	 
						insert_temporary($name_temporary_table, $fragment_id[$i], $original_id, $quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $page_location, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, $part1[$tt], $volume, $issue);
					}
					//////                 ///////
				}
			}			
					// find the total number of Articles: 
					$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$n_id_tot = 0;	 // Total number of articles:
					while(list($id) = mysqli_fetch_row($rs))			
						$n_id_tot = $n_id_tot + 1;


					$query = "SELECT total.count as totalcount,axon.count as axoncount,dendrite.count as dendritecount,
							soma.count as somacount
							FROM
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table) as total,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Axons') as axon,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Dendrites') as dendrite,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Somata') as soma
							";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$total_count_all=$number_of_quotes_axon = $number_of_quotes_dendrite=$number_of_quotes_somata=0;
					 // total number of axon quotes
					while(list($total_count,$axon_count,$dendrite_count,$soma_count) = mysqli_fetch_row($rs))	{		
						$total_count_all=intval($total_count);
						$number_of_quotes_axon = intval($axon_count);	
						$number_of_quotes_dendrite = intval($dendrite_count);	
						$number_of_quotes_somata = intval($soma_count);	
					}
				
					$query = "SELECT total.count as totalcount,axon.count as axoncount,dendrite.count as dendritecount,
							soma.count as somacount
							FROM
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE show_only=1) as total,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Axons' and show_only=1) as axon,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Dendrites' and show_only=1) as dendrite,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Somata' and show_only=1) as soma
							";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$show_only_total_count_all=$show_only_number_of_quotes_axon = $show_only_number_of_quotes_dendrite=$show_only_number_of_quotes_somata=0;
					 // total number of axon quotes
					while(list($total_count,$axon_count,$dendrite_count,$soma_count) = mysqli_fetch_row($rs))	{		
						$show_only_total_count_all=intval($total_count);
						$show_only_number_of_quotes_axon = intval($axon_count);	
						$show_only_number_of_quotes_dendrite = intval($dendrite_count);	
						$show_only_number_of_quotes_somata = intval($soma_count);	
					}
				
					// get number of quotes pairwise
					if ($order_by == '-'){
						$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 ORDER BY type ASC LIMIT $page_in , 10";
					}
					else{
						$query = "SELECT DISTINCT title, $order_by FROM $name_temporary_table WHERE show_only = 1 ORDER BY $order_by $type_order LIMIT $page_in , 10";
					}
					$rs = mysqli_query($GLOBALS['conn'],$query);					
					$n_id = 0;
					while(list($title) = mysqli_fetch_row($rs))
					{
						$title_temp[$n_id] = $title;											
						$n_id = $n_id + 1;
					}					
				?>	

					
				<table width="80%" border="0" cellspacing="2" cellpadding="0">
					<tr>		
						<td width="25%" align="right">
						<form action="property_page_synpro_nm.php" method="post" style="display:inline">
						<?php
							if (isset($_REQUEST['sp_page'])) {
								$sp_page=$_REQUEST['sp_page'];
								echo "<input type='hidden' name='sp_page' value='$sp_page'>";
							}
						?>
						<input type="submit" name='see_all' value="Open All Evidence">
						<input type="submit" name='see_all' value="Close All Evidence">
						<input type="hidden" name='start' value='<?php print $page_in; ?>' />
						<input type="hidden" name='stop' value='<?php print $page_end; ?>' />
						<?php print ("<input type='hidden' name='name_show_only' value='$name_show_only'>"); ?>
						<?php print ("<input type='hidden' name='val1_property' value='$val1_property'>"); 
						if (isset($_REQUEST['sp_page'])) {
							$sp_page=$_REQUEST['sp_page'];
							print ("<input type='hidden' name='sp_page' value='$sp_page'>");
						}
						?>
						
						</form>
						</td>						
					</tr>
				</table>
				
				<br />	
				
				<table width="80%" border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td width="25%" align="left">
						<font class="font2">Show:</font> 
					<?php 
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only(this, $page_in, '10')\">");
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
																												
							print ("<OPTION VALUE='$name_show_only1'>$name_show_only1</OPTION>");
							print ("<OPTION VALUE='all'>-</OPTION>");
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
						// ARTICLE - BOOK: 
						if ($sub_show_only == 'article')
						{
							// retrieve the number of article or number of book:
							print("<font class='font2'>By:</font> ");
							$query = "SELECT DISTINCT title, PMID FROM $name_temporary_table";	
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
								print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, $page_in, '10')\">");
								print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
								print ("<OPTION VALUE='all'>All</OPTION>");
								print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
								print ("</select>");							
							}
							else if ($name_show_only_article == 'book')
							{
								print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, $page_in, '10')\">");
								print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
								print ("<OPTION VALUE='all'>All</OPTION>");
								print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
								print ("</select>");
							}
							else
							{
								print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_only_article(this, $page_in, '10')\">");
								print ("<OPTION VALUE='all'>All</OPTION>");
								print ("<OPTION VALUE='book'>Book(s) ($number_of_books_1)</OPTION>");
								print ("<OPTION VALUE='article'>Article(s) ($number_of_articles_1)</OPTION>");
								print ("</select>");
							}							
						}						
						// PUBLICATION: 
						if ($sub_show_only == 'name_journal')
						{						
							print("<font class='font2'>By:</font> ");
							print ("<select name='order' size='1' cols='10' class='select1' style='width: 200px;' onChange=\"show_only_publication(this, $page_in, '10')\">");
							if ( ($name_show_only_journal != 'all') &&  ($name_show_only_journal != NULL) )
								print ("<OPTION VALUE='$name_show_only_journal'>".stripslashes($name_show_only_journal)."</OPTION>");
							print ("<OPTION VALUE='all'>All</OPTION>");
							// retrieve the name of journal from temporary table:
							$query ="SELECT DISTINCT publication FROM $name_temporary_table";
							$rs = mysqli_query($GLOBALS['conn'],$query);					
							while(list($pub) = mysqli_fetch_row($rs))	
							{	
								// retrieve the number of articles for this publication:
								$pub= mysqli_real_escape_string($GLOBALS['conn'],$pub);
								$query1 ="SELECT DISTINCT title FROM $name_temporary_table WHERE publication = '$pub'";
								$rs1 = mysqli_query($GLOBALS['conn'],$query1);
								$n_pub1=0;					
								while(list($id) = mysqli_fetch_row($rs1))							
									$n_pub1 = $n_pub1 + 1;
							
								if ($pub == $name_show_only_journal);
								else
									print ("<OPTION VALUE='".htmlspecialchars($pub,ENT_QUOTES)."'>".stripslashes($pub)." ($n_pub1)</OPTION>");		
							}
							print ("</select>");				
						}
						
						// AUTHORS: 
						$author_string="";
						if ($sub_show_only == 'authors')
						{
							// retrieve the name of authors from temporary table:
							print("<font class='font2'>By:</font> ");
							$query ="SELECT distinct authors FROM $name_temporary_table";
							$rs = mysqli_query($GLOBALS['conn'],$query);				
							while(list($allauthors) = mysqli_fetch_row($rs))
							{
								if($author_string=="")
									$author_string=$allauthors;	
								else
									$author_string=$author_string.",".$allauthors;
							}
							$single_aut=explode(',', $author_string);
							$index=0;
							$unique_authors=array();
							for ($cnt=0; $cnt<count($single_aut); $cnt++)
							{

								if($single_aut[$cnt]){
									if(!in_array(trim($single_aut[$cnt]), $unique_authors)){
										$unique_authors[$index]=trim($single_aut[$cnt]);
										$index++;
									}
								}
							}
							sort($unique_authors);					
							print ("<select name='order' size='1' cols='10' class='select1' style='width: 200px;' onChange=\"show_only_authors(this, $page_in, '10')\">");	
							if ( ($name_show_only_authors != 'all') &&  ($name_show_only_authors != NULL) )
							{
								print ("<OPTION VALUE='$name_show_only_authors'>".stripslashes($name_show_only_authors)."</OPTION>");
								print ("<OPTION VALUE='all'>-</OPTION>");
							}
							print ("<OPTION VALUE='all'> All </OPTION>");
							
							for ($i1=0; $i1<count($unique_authors); $i1++)
							{	
								// retrieve the number of articles for this publication:
								$aut= mysqli_real_escape_string($GLOBALS['conn'],$unique_authors[$i1]);
								$query1 ="SELECT DISTINCT title FROM $name_temporary_table WHERE authors LIKE '%$aut%'";
								$rs1 = mysqli_query($GLOBALS['conn'],$query1);
								$n_auth1=0;					
								while(list($id) = mysqli_fetch_row($rs1))	
									$n_auth1 = $n_auth1 + 1;						
								print ("<OPTION VALUE='".htmlspecialchars($aut,ENT_QUOTES)."'>".stripslashes($unique_authors[$i1])." ($n_auth1)</OPTION>");
							}
							print ("</select>");				
						}						
					?>	
					</td>	
					<?php 
							if ($n_id_tot != 1)
							{
						?>			
							<td width="20%" align="right">
								<font class="font2">Order:</font>				
							<form action="property_page_synpro_nm.php" method="post" style="display:inline">
								<select name='order' size='1' cols='10' class='select1' onchange="this.form.submit()">
								<?php
									if ($order_by)
									{	
										if ($order_by == 'year')
											print ("<OPTION VALUE='$order_by'>Date</OPTION>");
										if ($order_by == 'publication')
											print ("<OPTION VALUE='$order_by'>Journal / Book</OPTION>");
										if ($order_by == 'authors')
											print ("<OPTION VALUE='$order_by'>First Authors</OPTION>");							
									}							
								?>
								<OPTION VALUE='-'>-</OPTION>
								<OPTION VALUE='year'>Date</OPTION>
								<OPTION VALUE='publication'>Journal / Book</OPTION>
								<OPTION VALUE='authors'>First Authors</OPTION>
								</select>
								<input type="hidden" name='order_ok' value="GO"  />
								<?php print ("<input type='hidden' name='val1_property' value='$val1_property'>"); ?>
								<?php
								if (isset($_REQUEST['sp_page'])) {
									$sp_page=$_REQUEST['sp_page'];
									echo "<input type='hidden' name='sp_page' value='$sp_page'>";
								}
								?>
								</form>	
							</td>
						<?php
							}
							else
							{
								print ("<td width='25%'></td>");
							}
						?>						
				</tr>
				</table>
				<br />

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
					// TABLE OF THE ARTICLES: 
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
						print ("<form action='property_page_synpro_nm.php' method='post' style='display:inline'>");
						print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
						print ("<input type='hidden' name='start' value='$page_in' />");
						print ("<input type='hidden' name='stop' value='$page_end' />");
						print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
						print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
						print ("<input type='hidden' name='val1_property' value='$val1_property'>");
						if (isset($_REQUEST['sp_page'])) {
							$sp_page=$_REQUEST['sp_page'];
							print ("<input type='hidden' name='sp_page' value='$sp_page'>");
						}
						print ("</form>");
					}
					if ($show1 == 1)
					{
						print ("<form action='property_page_synpro_nm.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
						print ("<input type='submit' name='show_0' value=' ' class='show0'>");
						print ("<input type='hidden' name='start' value='$page_in' />");
						print ("<input type='hidden' name='stop' value='$page_end' />");
						print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
						print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
						print ("<input type='hidden' name='val1_property' value='$val1_property'>");
						if (isset($_REQUEST['sp_page'])) {
							$sp_page=$_REQUEST['sp_page'];
							print ("<input type='hidden' name='sp_page' value='$sp_page'>");
						}
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
					
					// TABLE for Quotes:
					// Logic to form dynamic query to retrive evidences(axon,dendrite,soma ) depending on checkbox selection 
					$subquery=" and ( ";
					$property_array=explode(",",$neuron_show_only_value);
					for($index=0;$index<count($property_array);$index++){
						if($property_array[$index]){
							$subquery=$subquery."type like '".$property_array[$index]."' or ";
						}
					}	
					$subquery=substr($subquery,0,count($subquery)-4);
					$subquery=$subquery.")";
					// Retrive evidences stored in temporary table
					$subquery = "and ( type like 'Axons' )";
					try
					{				
						$query = "SELECT distinct id_fragment, id_original, quote, page_location, type FROM $name_temporary_table WHERE title = '$title_temp[$i]' $subquery ORDER BY id_fragment ASC";	
						//echo "<br><Br><br><br><br>subquery:".$subquery;
						//echo "<br>quote axon<br>".$query;
						$rs = mysqli_query($GLOBALS['conn'],$query);	
						while(list($id_fragment, $id_original, $quote, $page_location, $type) = mysqli_fetch_row($rs))
						{	
							$type_for_display=$type;
							$quote_count++;
							$attachment_obj = new attachment_synpro($class_attachment); // this clears prior attachment results
							retrieve_evidences($show1, $type_for_display, $fragment, $GLOBALS['conn'], $id1_neuron, $id_original, $val1_property, $name_temporary_table, $subquery, $id_fragment, $class_fragment, $color1, $nm_page, $page_location, $quote, $attachment_obj);
						}					
					}
					// if error occurs while retriving evidences show error message
					catch (Exception $e) {
						print ("<br><font class='font12'>Error Occured while processing.</font><br><br>");
					}		
					$subquery = "and ( type like 'Dendrites' )";
					try
					{			
						$avoid_dups = array();		
						$query = "SELECT distinct id_fragment, id_original, quote, page_location, type FROM $name_temporary_table WHERE title = '$title_temp[$i]' $subquery ORDER BY id_fragment ASC";
						//echo "<br>quote dend<br>".$query;
						$rs = mysqli_query($GLOBALS['conn'],$query);	
						while(list($id_fragment, $id_original, $quote, $page_location, $type) = mysqli_fetch_row($rs))
						{	
							$type_for_display=$type;
							$quote_count++;
							retrieve_evidences($show1, $type_for_display, $fragment, $GLOBALS['conn'], $id2_neuron, $id_original, $val1_property, $name_temporary_table, $subquery, $id_fragment, $class_fragment, $color2, $nm_page, $page_location, $quote, $attachment_obj);
						}					
					}
					// if error occurs while retriving evidences show error message
					catch (Exception $e) {
						print ("<br><font class='font12'>Error Occured while processing.</font><br><br>");
					}				
				} 
		?>
			<!-- PAGINATION TABLE -->	
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
								
								$cnt=0;
								$query = "SELECT distinct quote FROM $name_temporary_table WHERE show_only=1 $subquery";
								$rs = mysqli_query($GLOBALS['conn'],$query);			
								while(list($quote) = mysqli_fetch_row($rs))
								{
									$cnt++;
								}
								if($neuron_show_only_value&&$n_id_tot!=0){
										print ("$page_in1 - $page_end1 of $n_id_tot articles ($cnt Quotes)");	
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
						&nbsp; &nbsp;
						<form action="property_page_synpro_nm.php" method="post" style="display:inline">
							<?php 
								if ($no_button_down == 1);
								else
								{
									print ("<input type='submit' name='first_page' value=' << ' class='botton1'/>");
									print ("<input type='submit' name='down' value=' < ' class='botton1'/>");
									print ("<input type='hidden' name='val1_property' value='$val1_property'>");
									if (isset($_REQUEST['sp_page'])) {
										$sp_page=$_REQUEST['sp_page'];
										print ("<input type='hidden' name='sp_page' value='$sp_page'>");
									}
								}
							?>								
							<input type="hidden" name='start' value='<?php print $page_in-10; ?>' />
							<input type="hidden" name='stop' value='<?php print $page_end-10; ?>' />
							
						</form>	
						<form action="property_page_synpro_nm.php" method="post" style="display:inline">
						&nbsp; &nbsp;
							<?php 
								if ($no_button_up == 1);
								else
								{
									print ("<input type='submit' name='up' value=' > ' class='botton1'/>");
									print ("<input type='submit' name='last_page' value=' >> ' class='botton1'/>");
									print ("<input type='hidden' name='val1_property' value='$val1_property'>");
									if (isset($_REQUEST['sp_page'])) {
										$sp_page=$_REQUEST['sp_page'];
										print ("<input type='hidden' name='sp_page' value='$sp_page'>");
									}
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
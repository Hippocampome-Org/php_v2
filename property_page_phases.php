<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
include ("function/quote_manipulation.php");
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.synonym.php');
//require_once('class/class.fragment.php');
require_once('phases/class/class.fragment.php');
//require_once('class/class.attachment.php');
require_once('phases/class/class.attachment.php');
//require_once('class/class.evidencepropertyyperel.php');
require_once('phases/class/class.evidencepropertyyperel.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.evidencefragmentrel.php');
//require_once('class/class.articleevidencerel.php');
require_once('phases/class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');

$page="main_page";
//$_REQUEST['page']=$page;
include("phases/gen_json/generate_json.php");

$all_val_types = array("theta", "swr_ratio", "firingRate", "DS_ratio", "ripple", "gamma", "run_stop_ratio", "epsilon", "firingRateNonBaseline", "Vrest", "tau", "APthresh", "fAHP", "APpeak_trough");
$all_other_types = array("DS_ratio", "ripple", "gamma", "run_stop_ratio", "epsilon", "firingRateNonBaseline", "Vrest", "tau", "APthresh", "fAHP", "APpeak_trough");
$evi_page_descs = array("Theta", "SWR ratio", "Firing rate", "DS ratio", "Ripple", "Gamma", "Run stop ratio", "Epsilon", "Firing rate non-baseline", "Vrest", "Tau", "AP threshold", "fAHP", "APpeak trough");

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
				   referenceID BIGint(25),
				   PRIMARY KEY (id));";
	$query = mysqli_query($GLOBALS['conn'],$creatable);
}

function insert_temporary($table, $id_fragment, $id_original, $quote, $authors, $title, $publication, $year, $PMID, $pages, $page_location, $id_evidence, $show1,  $pmcid, $nihmsid, $doi, $open_access, $citation_count, $type, $volume, $issue, $referenceID)
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
	   issue,
	   referenceID
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
	   '$issue' ,
	   '$referenceID'  
	   )";
	   //echo $query_i."<br>";
	$rs2 = mysqli_query($GLOBALS['conn'],$query_i);					
 }
// set properties
$page = true;//$_REQUEST['page'];
$other_all = "";
$sub_show_only = $_SESSION['phases_sub_show_only']; 
$name_show_only_article = $_SESSION['phases_name_show_only_article'];
$val_type = "";
if (isset($_REQUEST['val_type'])) {$val_type = $_REQUEST['val_type'];}

$see_all = $_REQUEST['see_all']; 
// open all evidences
if ($see_all == 'Open All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}
// close all evidences
if ($see_all == 'Close All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}
// Change the show coloums in the temporary table: 
//echo "<br><br><br><br><br><br><br><br><br>";
//echo $_SESSION['phases_name_temporary_table'];
//echo "<br>";
if ($_REQUEST['show_1']) //  ==> ON
{
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
	//echo $query;
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
}

if ($_REQUEST['show_0']) //  ==> OFF
{
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}
//echo "<bR>show_0:".$_REQUEST['show_0'];
// Request coming from another page
//if ($page) 
if (true)
{
	$name_show_only = 'all';
	$_SESSION['phases_name_show_only'] = $name_show_only;
	$sub_show_only = NULL;
	$_SESSION['phases_sub_show_only'] = $sub_show_only;	
	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';	
	$name_show_only_authors = 'all';

	$id_neuron = $_REQUEST['id_neuron'];
	$val_property = $_REQUEST['val_property'];
	$all_val_check = $_REQUEST['all_val_check'];
	$color = $_REQUEST['color'];
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$ip_address = str_replace(':', '_', $ip_address);
	$time_t = time();
	//echo "name_temporary_table: ".$name_temporary_table;
	//if ($_SESSION['phases_name_temporary_table'] == NULL) {
	//if (true) {
		$name_temporary_table ='temp_'.$ip_address.'_'.$id_neuron.$color.'__'.$time_t;
		$_SESSION['phases_name_temporary_table'] = $name_temporary_table;
		create_temp_table($name_temporary_table);	
	//}
	
	//$val_property = str_replace('_', ':', $val_property);
	$_SESSION['id_neuron'] = $id_neuron;
	$_SESSION['val_property'] = $val_property;	
	$_SESSION['all_val_check'] = $all_val_check;	
	$_SESSION['color'] = $color;
	$neuron_show_only_value="";
	if(strstr(checkNeuronProperty($color),"axons"))
		$neuron_show_only_value=$neuron_show_only_value.",Axons";
	if(strstr(checkNeuronProperty($color),"dendrites"))
		$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
	if(strstr(checkNeuronProperty($color),"somata"))
		$neuron_show_only_value=$neuron_show_only_value.",Somata";
	$_SESSION['phases_neuron_show_only_value']=$neuron_show_only_value;
	
	$page_in = 0;
	$page_end = 10;
	
	$order_by = 'year';     //Default
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
	$name_show_only = $_SESSION['phases_name_show_only'];
	$_SESSION['phases_name_show_only'] = $name_show_only;
	$name_show_only_journal = $_SESSION['phases_name_show_only_journal'];
	$name_show_only_authors = $_SESSION['phases_name_show_only_authors'];
	$name_show_only_article = $_SESSION['phases_name_show_only_article'];

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
	$all_val_check = $_SESSION['all_val_check'];
	$color = $_SESSION['color'];
	if(!$_SESSION['phases_neuron_show_only_value']){
		$neuron_show_only_value="";
		if(strstr(checkNeuronProperty($color),"axons"))
			$neuron_show_only_value=$neuron_show_only_value.",Axons";
		if(strstr(checkNeuronProperty($color),"dendrites"))
			$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
		if(strstr(checkNeuronProperty($color),"somata"))
			$neuron_show_only_value=$neuron_show_only_value.",Somata";	
		$_SESSION['phases_neuron_show_only_value']=$neuron_show_only_value;
	}
	else{
		$neuron_show_only_value=$_SESSION['phases_neuron_show_only_value'];
	}
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	
}
// SHOW ONLY 
$name_show_only_var = $_REQUEST['name_show_only_var'];

if ($name_show_only_var)
{
	
	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['phases_name_show_only'] = $name_show_only;

	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['phases_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$_SESSION['phases_name_show_only_article'] = $name_show_only_article;
		$sub_show_only = 'article';
		$_SESSION['phases_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$_SESSION['phases_name_show_only_journal'] = $name_show_only_journal;
		$sub_show_only = 'name_journal';
		$_SESSION['phases_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$_SESSION['phases_name_show_only_authors'] = $name_show_only_authors;
		$sub_show_only = 'authors';
		$_SESSION['phases_sub_show_only'] = $sub_show_only;
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);			
	}
} 
// ARTICLE - BOOK OPTION
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['phases_name_show_only_article'] = $name_show_only_article;
	$_SESSION['phases_name_show_only_journal'] = 'all';
	$_SESSION['phases_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['phases_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
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
	$_SESSION['phases_name_show_only_journal'] = $name_show_only_journal;
	$_SESSION['phases_name_show_only_article'] = 'all';
	$_SESSION['phases_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['phases_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
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
	$_SESSION['phases_name_show_only_authors'] = $name_show_only_authors;
	$_SESSION['phases_name_show_only_article'] = 'all';
	$_SESSION['phases_name_show_only_journal'] = 'all';
	$name_show_only = $_SESSION['phases_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];
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
	$_SESSION['phases_neuron_show_only_value'] = $neuron_show_only_value;
	$name_show_only = $_SESSION['phases_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['phases_name_temporary_table'];

}
$part=checkNeuronProperty($color);

$type = new type($class_type);
$type -> retrive_by_id($id_neuron);
$property = new property($class_property);
//$fragment = new fragment($class_fragment);
$class_fragment='phases_fragment';
$fragment = new fragment_phases($class_fragment);
$class_attachment='attachment_phases';
$attachment_obj = new attachment_phases($class_attachment);
//$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$class_evidence_property_type_rel = 'phases_evidence_type_rel';
$evidencepropertyyperel = new evidencepropertyyperel_phases($class_evidence_property_type_rel);
$class_evidencefragmentrel='phases_evidence_fragment_rel';
$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);
//$articleevidencerel = new articleevidencerel($class_articleevidencerel);
$class_articleevidencerel='phasesArticleEvidenceRel';
$articleevidencerel = new articleevidencerel_phases($class_articleevidencerel);
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
	var destination_page="property_page_phases.php";
	location.href = destination_page+"?neuron_show_only_value="+checkbox_clicked+"&start="+start1+"&stop="+stop1+"&neuron_show_only=1";
}


function show_only(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_phases.php";

	location.href = destination_page+"?name_show_only="+name+"&start="+start2+"&stop="+stop2+"&name_show_only_var=1";
}

function show_only_article(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_phases.php";
	location.href = destination_page+"?name_show_only_article="+name+"&start=0&stop="+stop2+"&name_show_only_article_var=1";
}

function show_only_publication(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_phases.php";
	location.href = destination_page+"?name_show_only_journal="+name+"&start=0&stop="+stop2+"&name_show_only_journal_var=1";
}

function show_only_authors(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_phases.php";
	location.href = destination_page+"?name_show_only_authors="+name+"&start=0&stop="+stop2+"&name_show_only_authors_var=1";
}


</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type->getNickname();
	print("<title>Evidence - $name</title>");
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
	if (isset($_REQUEST['color'])) {$color = $_REQUEST['color'];}
	if (isset($_REQUEST['sp_page'])) {$sp_page=$_REQUEST['sp_page'];}
	if ($sp_page=='dal') {
		if ($color=='red') {
			echo "Synapse Probabilities - Axonal Lengths Evidence Page";
		}
		else if ($color=='blue') {
			echo "Synapse Probabilities - Dendritic Lengths Evidence Page";
		}		
	}
	else if ($sp_page=='sd') {
		if ($color=='red') {
			echo "Synapse Probabilities - Somatic Distances of Axons Evidence Page";
		}
		else if ($color=='blue') {
			echo "Synapse Probabilities - Somatic Distances of Dendrites Evidence Page";
		}			
	}
?>
</font>
</div>

<br><br /><br><br />
<table width="85%" border="0" cellspacing="0" cellpadding="0" class='body_table'>
  <tr height="40">
    <td><div class="title_area"><font class="font1">Phases Evidence Page</font></div></td>
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
				<td width="20%" align="right">&nbsp;</td>
				<td align="left" width="80%" class="table_neuron_page2">&nbsp;<strong>
				<?php 
					for ($i_e = 0; $i_e < count($all_val_types); $i_e++) {
						if ($val_property == $all_val_types[$i_e]) {
							echo $evi_page_descs[$i_e];
						}
					}	
					if ($val_property == "all_other") {
						echo "Any values of DS ratio, Ripple, Gamma, Run stop ratio, Epsilon, Firing rate non-baseline, Vrest, Tau,<br>&nbsp;&nbsp;AP threshold, fAHP, or APpeak trough.";
					}				
				?>
				</strong></td>
			</tr>
			<tr>
				<td width="20%" align="right">
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
		<br />			

		<?php
			if ($part == 'axons_dendrites_somata')
				$n_interraction = 3;
			else if ($part == 'axons_dendrites' || $part == 'axons_somata' || $part == 'dendrites_somata')
				$n_interraction = 2;
			else 
				$n_interraction = 1;
						
			for ($tt=0; $tt<$n_interraction; $tt++)
			{
				if ($n_interraction == 1)
				{	
					// Axons or Dendrites
					// Retrieve property_id from Property by using Type_id
					$part1[$tt] = ucfirst($part);
					$property  -> retrive_ID(1, $part, 'in', $val_property);
					$n_property_id = $property -> getNumber_type();	

				}					
				$evidencepropertyyperel -> retrive_evidence_id($id_neuron);				
				$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
				$n_article = 0; // <-- Number of articles
				for ($i=0; $i<$n_evidence_id; $i++)
				{
					$evidence_id[$i] = $evidencepropertyyperel -> getEvidence_id_array($i);
					//echo "$evidence_id[$i]: ".$evidence_id[$i]."<br>";
					// Retrieve Fragment_id from EvidenceFragmentRel by using Evidence_id
					$evidencefragmentrel -> retrive_fragment_id($evidence_id[$i]);
					
					$n_fragment_id = $evidencefragmentrel -> getN_fragment_id();
				
					for ($i1=0; $i1<$n_fragment_id; $i1++)
					{
						$fragment_id[$n_article] = $evidencefragmentrel -> getFragment_id_array($i1);
						//$fragment_id[$n_article] = $evidence_id[$i];
						$n_article = $n_article + 1;
					}

					//echo $evidence_id[$i]." test<br>";	
				}
				for ($i=0; $i<$n_article; $i++)
				{
					// Retrieve Quote and page_location and original_id from Fragment bu using fragment_id:
					$fragment -> retrive_by_id($fragment_id[$i]);
					$quote = $fragment -> getQuote();
					//echo $quote."<br>";
					$quote = quote_replaceIDwithName($quote);
					$original_id = $fragment -> getOriginal_id();
					$pmid_isbn= $fragment -> getPmid_isbn();
					$referenceID= $fragment -> getReferenceID();
					//echo $fragment_id[$i]." referenceID: ".$referenceID." | ";
					//echo "pmid_isbn ".$pmid_isbn."<br>";
					$pmid_isbn_page= $fragment -> getPmid_isbn_page();
					//echo "pmid_isbn_page: $pmid_isbn_page<br>";
					$page_location = $fragment -> getPage_location();
					//Retreive information from attachment table					
					if ($pmid_isbn_page!=0 && $pmid_isbn_page!= NULL)
					{
						$article -> retrive_by_pmid_isbn_and_page_number($pmid_isbn, $pmid_isbn_page);
						$id_article= $article -> getID();
						//echo $id_article."<br>";
					}
					else if ($pmid_isbn == 25375253) {
						$article -> retrive_by_pmid(25375253);
						$id_article= $article -> getID();
					}
					else 
					{
						// retrieve article_id from ArticleEvidenceRel by using Evidence_id
						$articleevidencerel -> retrive_article_id($evidence_id[$i]);
						//echo $evidence_id[$i]."<br>";
						$id_article = $articleevidencerel -> getArticle_id_array(0);
						//echo $id_article."<br>";
						// retrieve all information from article table by using article_id
						$article -> retrive_by_id($id_article) ;
					}
					$title = $article -> getTitle();
					//echo "<br>title: $title";
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
					//if ($title[$ui] == '.')
					//	$title[$ui] = '';	
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
					if ($page)
					//if ($_SESSION['phases_name_temporary_table'] == NULL)
					{
						// Insert the data in the temporary table:	 
						//echo "referenceID: $referenceID<br>";
						insert_temporary($name_temporary_table, $fragment_id[$i], $original_id, $quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $page_location, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, $part1[$tt], $volume, $issue, $referenceID);
					}
				}
			}			

			if ($see_all == 'Open All Evidence')
			{
				$page_in = $_REQUEST['start'];
				$page_end = $_REQUEST['stop'];
				$name_temporary_table = $_SESSION['phases_name_temporary_table'];
				$query = "UPDATE $name_temporary_table SET show1 =  '1'";
				$rs2 = mysqli_query($GLOBALS['conn'],$query);		
			}
			// close all evidences
			if ($see_all == 'Close All Evidence')
			{
				$page_in = $_REQUEST['start'];
				$page_end = $_REQUEST['stop'];
				$name_temporary_table = $_SESSION['phases_name_temporary_table'];
				$query = "UPDATE $name_temporary_table SET show1 =  '0'";
				$rs2 = mysqli_query($GLOBALS['conn'],$query);		
			}
			if (isset($_REQUEST['show_1']) && $_REQUEST['show_1']) //  ==> ON
			{
				$name_temporary_table = $_SESSION['phases_name_temporary_table'];
				$title_paper = $_REQUEST['title'];
				$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
				//echo $query;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);		
				$page_in = $_REQUEST['start'];
				$page_end = $_REQUEST['stop'];
			}

			if (isset($_REQUEST['show_0']) && $_REQUEST['show_0']) //  ==> OFF
			{
				$name_temporary_table = $_SESSION['phases_name_temporary_table'];
				$title_paper = $_REQUEST['title'];
				$page_in = $_REQUEST['start'];
				$page_end = $_REQUEST['stop'];
				$query = "UPDATE $name_temporary_table SET show1 =  '0' WHERE title = '$title_paper'";
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
					// find the total number of Articles: 
					$query = "SELECT DISTINCT title FROM $name_temporary_table";// WHERE show_only = 1";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$n_id_tot = 0;	 // Total number of articles:
					while(list($id) = mysqli_fetch_row($rs))			
						$n_id_tot = $n_id_tot + 1;

					//echo "$n_id_tot";
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
						//$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 ORDER BY type ASC LIMIT $page_in , 10";
						$query = "SELECT DISTINCT title FROM $name_temporary_table ORDER BY type ASC LIMIT $page_in , 10";
					}
					else{
						//$query = "SELECT DISTINCT title, $order_by FROM $name_temporary_table WHERE show_only = 1 ORDER BY $order_by $type_order LIMIT $page_in , 10";
						$query = "SELECT DISTINCT title, $order_by FROM $name_temporary_table ORDER BY $order_by $type_order LIMIT $page_in , 10";
					}
					$rs = mysqli_query($GLOBALS['conn'],$query);					
					$n_id = 0;
					while(list($title) = mysqli_fetch_row($rs))
					{
						$title_temp[$n_id] = $title;											
						$n_id = $n_id + 1;
					}					
					//echo $query." $n_id";
				?>	

					
				<table width="80%" border="0" cellspacing="2" cellpadding="0">
					<tr>		
						<td width="25%" align="right">
						<form action="property_page_phases.php" method="post" name="art_options" id="art_options" style="display:inline">
						<?php
							if (isset($_REQUEST['sp_page'])) {
								$sp_page=$_REQUEST['sp_page'];
								echo "<input type='hidden' name='sp_page' value='$sp_page'>";
							}
						?>
						<script>
							function set_avt_check() {
								let chk_val = document.getElementById("all_val_check").value;
								if (chk_val == "") {
									document.getElementById("all_val_check").value="checked";
									document.getElementById("art_options").submit();
								}
								else {
									document.getElementById("all_val_check").value="";
									document.getElementById("art_options").submit();
								}
								//document.write(document.getElementById("all_val_check").value);// document.getElementById("all_val_check").value;
							}
						</script>
						<span style="position:relative;float:left;display:none;"><input type="checkbox" id="show_all_vt" name="show_all_vt" onclick="javascript:set_avt_check();" <?php if($all_val_check=="checked"){echo "checked";} ?>><font class="font2">&nbsp;Show All Value Types</font></input></span>
						<input type="submit" name='see_all' value="Open All Evidence">
						<input type="submit" name='see_all' value="Close All Evidence">
						<input type="hidden" name='start' value='<?php print $page_in; ?>' />
						<input type="hidden" name='stop' value='<?php print $page_end; ?>' />
						<?php
						print ("<input type='hidden' name='id_neuron' value='$id_neuron'>");
						print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
						print ("<input type='hidden' name='val_property' value='$val_property'>");
						print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
						?>
						</form>
						</td>						
					</tr>
				</table>
				
				<br />	
				
				<table width="80%" border="0" cellspacing="2" cellpadding="0" style="display:none;">
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
							<form action="property_page_phases.php" method="post" style="display:inline">
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
								<?php 
									print ("<input type='hidden' name='val_property' value='$val_property'>");
									print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
								?>
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
				$hide_articles = array_fill(0, $n_id, true);
				// There are no results available:
				if ($n_id == 0)
					print ("<br><font class='font12'>There are no results available.</font><br><br>");

				for ($i=0; $i<$n_id; $i++)
				{	
					// retrieve information about the authors, journals and otehr by using name of article:
					$show1=0;
					$query = "SELECT id, authors, publication, year, PMID, pages, page_location, show1, pmcid, nihmsid, doi, show_only, volume, issue, referenceID FROM $name_temporary_table WHERE title = '$title_temp[$i]' ";
					//echo "$query"."<br>";
					$rs = mysqli_query($GLOBALS['conn'],$query);	
					$auth=array();	
							
					while(list($id, $authors, $publication, $year, $PMID, $pages, $page_location, $show, $pmcid, $nihmsid, $doi, $show_only, $volume, $issue, $referenceID_val) = mysqli_fetch_row($rs))
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
						$referenceID = $referenceID_val;
					}					
					
					display_article($authors1, $authors2, $publication1, $year1, $volume1, $issue_tot, $pages1, $string_pmid, $doi_tot, $show1, $PMID1, $issue1, $doi1, $page_in, $page_end, $title_temp, $name_show_only, $val_property, $id_neuron, $i);
						
					// TABLE for Quotes:
					try
					{			
						$avoid_dups = array();		
						$query = "SELECT distinct id_fragment, id_original, quote, page_location, type FROM $name_temporary_table WHERE title = '$title_temp[$i]' ORDER BY id_fragment ASC";	
						//echo $query."<br>";
						$rs = mysqli_query($GLOBALS['conn'],$query);	
						while(list($id_fragment, $id_original, $quote, $page_location, $type) = mysqli_fetch_row($rs))
						{	
							$current_record = $id_original.$quote.$page_location.$type;
							$type_for_display=$type;

							$conditions = "";
							$other_all = "checked";
							$referenceID = $fragment -> frag_id_to_ref_id($id_fragment);
							//echo "<br>test $referenceID ".$neuron_ids[0]." $array_index<br>";
							$array_index=$fragment->neuron_id_to_array_index($id_neuron, $neuron_ids);
							$write_output = retrieve_values($conn, $array_index, $theta_values, $spw_values, $firingrate_values, $other_values, $neuron_ids, $conditions, $best_ranks_theta, $best_ranks_swr, $best_ranks_firingrate, $npage_theta, $npage_swr, $npage_firingrate, $npage_other, $pmid_isbn, $referenceID, $other_all, $val_property);
							//echo "val_property ".$val_property."<br>";
							$theta_values = $write_output[0];
							$spw_values = $write_output[1];
							$firingrate_values = $write_output[2];
							$other_values = $write_output[3];
							$best_ranks_theta = $write_output[4];
							$best_ranks_swr = $write_output[5];
							$best_ranks_firingrate = $write_output[6];
							$npage_theta = $write_output[7];
							$npage_swr = $write_output[8];
							$npage_firingrate = $write_output[9];
							$npage_other = $write_output[10];
							$all_vals = $write_output[11];									
					      	$all_theta = ''; $all_swr = ''; $all_fr = ''; $all_other = '';
							$all_theta = $all_vals[0]; $all_swr = $all_vals[1]; 
							$all_fr = $all_vals[2]; $all_other = $all_vals[3]; 
							$other_frag = $all_vals[4];

							$theta_val = ''; $theta_prop1 = ''; $theta_prop2 = ''; $theta_prop3 = '';
					      	$swr_val = ''; $swr_prop1 = ''; $swr_prop2 = ''; $swr_prop3 = ''; 
					      	$other_val = ''; $other_prop = '';
					      	for ($i_t = 0; $i_t < count($npage_theta); $i_t++) {
					      		if ($npage_theta[$i_t][0] == $id_neuron) {
									$theta_val = $npage_theta[$i_t][5];
									$theta_prop1 = $npage_theta[$i_t][2];
									$theta_prop2 = $npage_theta[$i_t][3];
									$theta_prop3 = $npage_theta[$i_t][4];
									//$swr_val = $npage_swr[$i_t][1];
									$swr_val = $npage_swr[$i_t][5];
									$swr_prop1 = $npage_swr[$i_t][2];
									$swr_prop2 = $npage_swr[$i_t][3];
									$swr_prop3 = $npage_swr[$i_t][4];
									//$firingrate_val = $npage_firingrate[$i_t][1];
									$firingrate_val = $npage_firingrate[$i_t][5];
									$firingrate_prop1 = $npage_firingrate[$i_t][2];
									$firingrate_prop2 = $npage_firingrate[$i_t][3];
									$firingrate_prop3 = $npage_firingrate[$i_t][4];
									$other_val = $npage_other[$i_t][1];
									//$other_val = $npage_other[$i_t][3];
									$other_prop = $npage_other[$i_t][2];
					      		}
					      	}			

					      	$other_parsed = explode(":", $other_frag);
					      	$all_val_results = array("$theta_val", "$swr_val", "$firingrate_val", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other", "$all_other");
					      	$all_val_props = array("$theta_prop3", "$swr_prop3", "$firingrate_prop3", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag", "$other_frag");
					      	$all_val_descs = array("Theta", "SWR ratio", "Firing rate", "Other", "Other", "Other", "Other", "Other", "Other", "Other", "Other", "Other", "Other");

					      	// test for hiding articles
					      	for ($i_vt = 0; $i_vt < count($all_val_types); $i_vt++) {
					      		if (($val_property=="" || $val_property==$all_val_types[$i_vt] || ($val_property=="all_other" && in_array($all_val_types[$i_vt], $all_other_types))) && $all_val_results[$i_vt]!="") {
				      				$hide_articles[$i] = false;
				      			}
				      		}

				      		// display quotes
							if ($show1 == 1)
							{
								$type_show  = "";
								$query_type = "SELECT distinct type FROM $name_temporary_table WHERE id_fragment = $id_fragment ORDER BY type ASC";
								$rs_type = mysqli_query($GLOBALS['conn'],$query_type);	
								while(list($type) = mysqli_fetch_row($rs_type))
								{
									$type_show  = $type_show . $type;
								}	
								$row_span=30;	
								$original_id = $fragment -> getOriginal_id();
								$attachment_obj = new attachment_phases($class_attachment); // this clears prior attachment results
								$attachment_obj -> retrive_by_referenceID($referenceID);
								$attachment = $attachment_obj -> getName();
								$attachment_type = $attachment_obj -> getType();
								$link_figure="";									
								$attachment_jpg = $attachment;//str_replace('jpg', 'jpeg', $attachment);
								
								if($attachment_type=="phases_figure"){
									$link_figure = "attachment/phases/".$attachment_jpg;
								}								
								$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
								$link_figure_pdf = "figure_pdf/".$attachment_pdf;				
								$seg_1_text="";
								$seg_2_text="";
								print ($seg_1_text);
								$neuron_id=$id_neuron;
								$refID=$id_original;
								//echo "all_val_check|||||||||||||||||| ".$all_val_check." ".($all_val_check == "checked")."<br>";
								
								if ($val_property!="all_other" && $all_val_check != "checked") {
									for ($i_vt = 0; $i_vt < count($all_val_types); $i_vt++) {
							      		if (($val_property=="" || $val_property==$all_val_types[$i_vt]) && $all_val_results[$i_vt]!="") {
							      			display_quote($row_span, $all_val_results[$i_vt], $all_val_props[$i_vt], $link_figure, $fragment, $id_fragment, $seg_2_text, $attachment_type, $quote, $all_val_descs[$i_vt]);
							      		}
							      	}
						      	}
						      	else if ($all_val_check == "checked") {
						      		for ($i_vt = 0; $i_vt < 3; $i_vt++) {
							      		if (($val_property=="" || $val_property==$all_val_types[$i_vt]) && $all_val_results[$i_vt]!="") {
							      			display_quote($row_span, $all_val_results[$i_vt], $all_val_props[$i_vt], $link_figure, $fragment, $id_fragment, $seg_2_text, $attachment_type, $quote, $all_val_descs[$i_vt]);
							      		}
							      	}
							      	for ($i_of = 0; $i_of < count($other_parsed); $i_of++) {
						      			if (in_array($other_parsed[$i_of], $all_other_types)) {
						      				$frag_desc = $other_parsed[$i_of];
						      				$frag_entry = $other_parsed[$i_of].":".$other_parsed[$i_of+1].":".$other_parsed[$i_of+2];
						      				display_quote($row_span, "", $frag_entry, $link_figure, $fragment, $id_fragment, $seg_2_text, $attachment_type, $quote, "Other");
						      			}
						      		}
						      	}
						      	else {
						      		for ($i_of = 0; $i_of < count($other_parsed); $i_of++) {
						      			if (in_array($other_parsed[$i_of], $all_other_types)) {
						      				$frag_desc = $other_parsed[$i_of];
						      				$frag_entry = $other_parsed[$i_of].":".$other_parsed[$i_of+1].":".$other_parsed[$i_of+2];
						      				display_quote($row_span, "", $frag_entry, $link_figure, $fragment, $id_fragment, $seg_2_text, $attachment_type, $quote, "Other");
						      			}
						      		}
						      	}
							}														
						}	
					}
					// if error occurs while retriving evidences show error message
					catch (Exception $e) {
						print ("<br><font class='font12'>Error Occured while processing.</font><br><br>");
					}						
				} 
				// hide any irrelevant articles
				for ($i=0; $i<$n_id; $i++) {
			      	if ($hide_articles[$i] == true) {
						echo "<script>document.getElementById('art_tbl$i').style='display:none';</script>";
					}
				}
				function display_article($authors1, $authors2, $publication1, $year1, $volume1, $issue_tot, $pages1, $string_pmid, $doi_tot, $show1, $PMID1, $issue1, $doi1, $page_in, $page_end, $title_temp, $name_show_only, $val_property, $id_neuron, $i) {
					// TABLE OF THE ARTICLES: 
					$first_author = NULL;
					for ($yy=0; $yy<strlen($authors1); $yy++)
					{
						if ($authors1[$yy] != ',')
							$first_author = $first_author.$authors1[$yy];
						else
							break;	
					}
					
					print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' id='art_tbl$i' style='display:visible;'>");
					
					print ("
						<tr>
						<td width='10%' align='center'>
						</td>
						<td width='5%' align='center' class='table_neuron_page2' valign='center'>
					");							
					
					if ($show1 == 0)
					{
						print ("<form action='property_page_phases.php' method='post' style='display:inline'>");
						print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
						print ("<input type='hidden' name='start' value='$page_in' />");
						print ("<input type='hidden' name='stop' value='$page_end' />");
						print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
						//echo "name_show_only: $name_show_only, show1: $show1";
						print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
						print ("<input type='hidden' name='val_property' value='$val_property'>");
						print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
						print ("<input type='hidden' name='id_neuron' value='$id_neuron'>");
						print ("</form>");
					}
					if ($show1 == 1)
					{
						print ("<form action='property_page_phases.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
						print ("<input type='submit' name='show_0' value=' ' class='show0'>");
						print ("<input type='hidden' name='start' value='$page_in' />");
						print ("<input type='hidden' name='stop' value='$page_end' />");
						print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
						//echo "name_show_only: $name_show_only, show1: $show1";
						print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
						print ("<input type='hidden' name='val_property' value='$val_property'>");
						print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
						print ("<input type='hidden' name='id_neuron' value='$id_neuron'>");
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
				}
				function display_quote($row_span, $all_val, $curr_prop, $link_figure, $fragment, $id_fragment, $seg_2_text, $attachment_type, $quote, $val_desc) {
					echo "<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table'><tr><td width='16%' rowspan='".$row_span."' align='right' valign='top' style='display:table-cell'></td>";	
			      	echo "<tr><td width='70%' class='table_neuron_page2' align='left'>";	
			      	if ($val_desc != "Other") {
						echo "$val_desc value(s): ".str_replace(",", ", ", $all_val)."; Protocol: ".str_replace("<br>", " ", $curr_prop);	
					}
					else {
						echo "Other value(s): ".$curr_prop;
					}
					echo "</td></tr>";
					$att_link=$link_figure;

					// view info
					$lir = $fragment->eid_to_location_in_reference($id_fragment);
					print ("
					<tr>	
						<td width='70%' class='table_neuron_page2' align='left'>
							Page location: $lir
						</td>
						<td width='15%' align='center'>");	
					print ("</td></tr>	
					<tr>		
						<td width='70%' class='table_neuron_page2' align='left'>
							<em>$quote</em>");
					print ($seg_2_text);
					print("</td>
						<td width='15%' class='table_neuron_page2' align='center'>");

					if ($attachment_type=="phases_figure"&&$link_figure!='attachment/phases/')
					{
						print ("<a href='$link_figure' target='_blank'>");
						print ("<img src='$link_figure' border='0' width='80%' style='background-color:white;'>");
						print ("</a>");
					}	
					else;
					print("</td></tr>");
				}
		?>
			<!-- PAGINATION TABLE -->	
				</table><table width="80%" border="0" cellspacing="2" cellpadding="0">
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
								$query = "SELECT distinct quote FROM $name_temporary_table WHERE show_only=1";
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
						<form action="property_page_phases.php" method="post" style="display:inline">
							<?php 
								if ($no_button_down == 1);
								else
								{
									print ("<input type='submit' name='first_page' value=' << ' class='botton1'/>");
									print ("<input type='submit' name='down' value=' < ' class='botton1'/>");
									print ("<input type='hidden' name='val_property' value='$val_property'>");
									print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
									if (isset($_REQUEST['sp_page'])) {
										$sp_page=$_REQUEST['sp_page'];
										print ("<input type='hidden' name='sp_page' value='$sp_page'>");
									}
								}
							?>								
							<input type="hidden" name='start' value='<?php print $page_in-10; ?>' />
							<input type="hidden" name='stop' value='<?php print $page_end-10; ?>' />
							
						</form>	
						<form action="property_page_phases.php" method="post" style="display:inline">
						&nbsp; &nbsp;
							<?php 
								if ($no_button_up == 1);
								else
								{
									print ("<input type='submit' name='up' value=' > ' class='botton1'/>");
									print ("<input type='submit' name='last_page' value=' >> ' class='botton1'/>");
									print ("<input type='hidden' name='val_property' value='$val_property'>");
									print ("<input type='hidden' name='all_val_check' id='all_val_check' value='$all_val_check'>");
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

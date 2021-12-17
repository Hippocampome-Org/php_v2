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
require_once('class/class.attachment.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.evidencefragmentrel.php');
require_once('class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');

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
				   id_neuron int(10),
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

function insert_temporary($table, $id_fragment, $id_original, $quote, $authors, $title, $publication, $year, $PMID, $pages, $page_location, $id_evidence, $show1,  $pmcid, $nihmsid, $doi, $open_access, $citation_count, $type, $volume, $issue,$id_neuron_conn=NULL)
{
	if ($open_access == NULL)
		$open_access = -1;
	if ($citation_count == NULL)
		$citation_count = -1;
	if($id_neuron_conn==NULL)
		$id_neuron_conn=-1;
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
	   id_neuron,
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
	   '$id_neuron_conn',
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


$page = $_REQUEST['page'];
$sub_show_only = $_SESSION['conn_sub_show_only']; 
$name_show_only_article = $_SESSION['conn_name_show_only_article'];

$see_all = $_REQUEST['see_all']; 
if ($see_all == 'Open All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}

if ($see_all == 'Close All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}

// Change the show coloums in the temporary table: ------------------------------------------------
if ($_REQUEST['show_1']) //  ==> ON
{
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

if ($_REQUEST['show_0']) //  ==> OFF
{
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

// Request coming from the another page
if ($page) 
{
	$name_show_only = 'all';
	$_SESSION['conn_name_show_only'] = $name_show_only;
	$sub_show_only = NULL;
	$_SESSION['conn_sub_show_only'] = $sub_show_only;	
	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';
	$name_show_only_authors = 'all';	
	
	$id_neuron = $_REQUEST['id1_neuron'];
	$val_property = $_REQUEST['val1_property'];
	$val_property = str_replace('_', ':', $val_property);
	$color = $_REQUEST['color1'];
	
	// get the connection neuron types  
	for($i=1;$i<3;$i++){
		$conn_id_neuron[$i-1] = $_REQUEST['id'.$i.'_neuron'];
		$conn_val_property[$i-1] = str_replace('_', ':', $_REQUEST['val'.$i.'_property']);
		$conn_color[$i-1] = $_REQUEST['color'.$i];
	}
	// get connection properties
	$connection_type=$_REQUEST['connection_type'];
	$known_unknown_flag=$_REQUEST['known_conn_flag'];
	$axonic_basket_flag=$_REQUEST['axonic_basket_flag'];
	// create temporary table
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='temp_'.$ip_address.'_'.$conn_id_neuron[0].$conn_color[0].'__'.$time_t;
	$_SESSION['conn_name_temporary_table'] = $name_temporary_table;
	create_temp_table($name_temporary_table);	
	// add connection and its properties to session for future use
	for($i=1;$i<3;$i++){
		$_SESSION['id'.$i.'_neuron']=$conn_id_neuron[$i-1];
		$_SESSION['val'.$i.'_property']=$conn_val_property[$i-1];
		$_SESSION['color'.$i]=$conn_color[$i-1];

	}
	$_SESSION['connection_type']=$connection_type;
	$_SESSION['known_conn_flag']=$known_unknown_flag;
	$_SESSION['axonic_basket_flag']=$axonic_basket_flag;
	$neuron_show_only_value="Axons";
	// find which checkbox to view out of axon, dendrite, soma and known
	if(strstr(checkNeuronProperty($conn_color[1]),"dendrites"))
		$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
	if(strstr(checkNeuronProperty($conn_color[1]),"somata")&&$axonic_basket_flag!=0)
		$neuron_show_only_value=$neuron_show_only_value.",Somata";
	if($known_unknown_flag!=0){
		$neuron_show_only_value=$neuron_show_only_value.",Known";	
	}
	$_SESSION['conn_neuron_show_only_value']=$neuron_show_only_value;

	// default parameter for displaying evidences
	$page_in = 0;
	$page_end = 10;
	// default order
	$order_by = '-';     
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
	$name_show_only = $_SESSION['conn_name_show_only'];
	$_SESSION['conn_name_show_only'] = $name_show_only;
	$name_show_only_journal = $_SESSION['conn_name_show_only_journal'];
	$name_show_only_authors = $_SESSION['conn_name_show_only_authors'];
	$name_show_only_article = $_SESSION['conn_name_show_only_article'];
	$order_ok = $_REQUEST['order_ok'];
	// clicked the Order By options
	if ($order_ok == 'GO')             
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
	// clicked the paginations
	else    
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
	
	$id_neuron = $_SESSION['id1_neuron'];
	$val_property = $_SESSION['val1_property'];
	$color = $_SESSION['color1'];
	
	// get the connection neuron types  
	for($i=1;$i<3;$i++){
		$conn_id_neuron[$i-1] = $_SESSION['id'.$i.'_neuron'];
		$conn_val_property[$i-1] = $_SESSION['val'.$i.'_property'];
		$conn_color[$i-1] = $_SESSION['color'.$i];
	}
	// get connection properties
	$connection_type=$_SESSION['connection_type'];
	$axonic_basket_flag=$_SESSION['axonic_basket_flag'];
	$known_unknown_flag=$_SESSION['known_conn_flag'];
	// add connection and its properties to session for future use
	if(!$_SESSION['conn_neuron_show_only_value']){
		$neuron_show_only_value="Axons";
		if(strstr(checkNeuronProperty($conn_color[1]),"dendrites"))
			$neuron_show_only_value=$neuron_show_only_value.",Dendrites";
		if(strstr(checkNeuronProperty($conn_color[1]),"somata")&&$axonic_basket_flag!=0)
			$neuron_show_only_value=$neuron_show_only_value.",Somata";
		if($known_unknown_flag==1){
			$neuron_show_only_value=$neuron_show_only_value.",Known";	
		}
		$_SESSION['conn_neuron_show_only_value']=$neuron_show_only_value;
	}
	else{
		$neuron_show_only_value=$_SESSION['conn_neuron_show_only_value'];
	}
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
}


// show only dropdown clicked
$name_show_only_var = $_REQUEST['name_show_only_var']; 

if ($name_show_only_var)
{
	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['conn_name_show_only'] = $name_show_only;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];

	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['conn_sub_show_only'] = $sub_show_only;
	}
	
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$_SESSION['conn_name_show_only_article'] = $name_show_only_article;
		$sub_show_only = 'article';
		$_SESSION['conn_sub_show_only'] = $sub_show_only;
	}

	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$_SESSION['conn_name_show_only_journal']=$name_show_only_journal;
		$sub_show_only = 'name_journal';
		$_SESSION['conn_sub_show_only'] = $sub_show_only;		
	}

	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$_SESSION['conn_name_show_only_authors'] = $name_show_only_authors;
		$sub_show_only = 'authors';
		$_SESSION['conn_sub_show_only'] = $sub_show_only;			
	}
	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);
} 

// ARTICLE - BOOK OPTION - for clicked Article/Book's evidences(quotes) set the show only flag to 1 in temporary table 
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['conn_name_show_only_article'] = $name_show_only_article;
	$_SESSION['conn_name_show_only_journal'] = 'all';
	$_SESSION['conn_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['conn_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];

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

// JOURNAL OPTION - for clicked journal's evidences(quotes) set the show only flag to 1 in temporary table 
$name_show_only_journal_var = $_REQUEST['name_show_only_journal_var'];
if ($name_show_only_journal_var)
{
	$name_show_only_journal = $_REQUEST['name_show_only_journal'];
	$_SESSION['conn_name_show_only_journal'] = $name_show_only_journal;
	$_SESSION['conn_name_show_only_article'] = 'all';
	$_SESSION['conn_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['conn_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];

	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
		
	if ($name_show_only_journal == 'all')
		$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	else{
		$query = "UPDATE $name_temporary_table SET show_only =  '0' WHERE publication != '$name_show_only_journal'";
	}
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
} 
	
// AUTHORS OPTION - for clicked author's evidences(quotes) set the show only flag to 1 in temporary table 
$name_show_only_authors_var  = $_REQUEST['name_show_only_authors_var'];
if ($name_show_only_authors_var)
{	
	$name_show_only_authors = $_REQUEST['name_show_only_authors'];
	$_SESSION['conn_name_show_only_authors'] = $name_show_only_authors;
	$_SESSION['conn_name_show_only_article'] = 'all';
	$_SESSION['conn_name_show_only_journal'] = 'all';
	$name_show_only = $_SESSION['conn_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];
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

// axon, dedrite/soma, known checkbox checked or unchecked
$neuron_show_only = $_REQUEST['neuron_show_only'];
if ($neuron_show_only){
	$neuron_show_only_value = $_REQUEST['neuron_show_only_value'];
	$_SESSION['conn_neuron_show_only_value'] = $neuron_show_only_value;
	$name_show_only = $_SESSION['conn_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['conn_name_temporary_table'];

}
// find axon, dendrite or soma property
$part = checkNeuronProperty($color);
for($i=0;$i<2;$i++){
	$conn_part[$i] = checkNeuronProperty($conn_color[$i]);
}
		
$type = new type($class_type);
$type -> retrive_by_id($conn_id_neuron[0]);
$type2 = new type($class_type);
$type2 -> retrive_by_id($conn_id_neuron[1]);
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
// checkbox clicked hence change the selection and store it in session 
function changeCheckbox(start1,stop1){
	start1 = 0;
	stop1 = 10;
	var axon = "";
	var dendrite = "";
	var soma="";
	var known="";
	if (document.getElementById('axoncheck')&&document.getElementById('axoncheck').checked==true) {
		axon="Axons";
	}
	if (document.getElementById('dendritecheck') && document.getElementById('dendritecheck').checked==true) {
		dendrite="Dendrites";
	}
	if (document.getElementById('somatacheck') && document.getElementById('somatacheck').checked==true) {
		soma="Somata";
	}
	if (document.getElementById('knowncheck') && document.getElementById('knowncheck').checked==true) {
		known="Known";
	}
	var checkbox_clicked=axon+","+dendrite+","+soma+","+known;
	var destination_page="property_page_connectivity.php";
	location.href = destination_page+"?neuron_show_only_value="+checkbox_clicked+"&start="+start1+"&stop="+stop1+"&neuron_show_only=1";
}
function changePotentialCheckbox(start1,stop1){
	start1 = 0;
	stop1 = 10;
	var axon = "";
	var dendrite = "";
	var soma="";
	var known="";
	if (document.getElementById('axoncheck')&&document.getElementById('axoncheck').checked==true) {
		axon="Axons";
	}
	if (document.getElementById('dendritecheck') && document.getElementById('dendritecheck').checked==true) {
		dendrite="Dendrites";
	}
	if (document.getElementById('somatacheck') && document.getElementById('somatacheck').checked==true) {
		soma="Somata";
	}
	if (document.getElementById('knowncheck') && document.getElementById('knowncheck').checked==true) {
		known="Known";
	}
	if(document.getElementById('potentialcheck')&&document.getElementById('potentialcheck').checked==true){
		axon="Axons";
		dendrite="Dendrites";
		soma="Somata";
	}
	if(document.getElementById('potentialcheck')&&document.getElementById('potentialcheck').checked==false){
		axon="";
		dendrite="";
		soma="";
	}
	var checkbox_clicked=axon+","+dendrite+","+soma+","+known;
	var destination_page="property_page_connectivity.php";
	location.href = destination_page+"?neuron_show_only_value="+checkbox_clicked+"&start="+start1+"&stop="+stop1+"&neuron_show_only=1";
}
// show only drop down clicked
function show_only(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_connectivity.php";

	location.href = destination_page+"?name_show_only="+name+"&start="+start2+"&stop="+stop2+"&name_show_only_var=1";
}
// show only article option selected
function show_only_article(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_connectivity.php";
	location.href = destination_page+"?name_show_only_article="+name+"&start=0&stop="+stop2+"&name_show_only_article_var=1";
}
// show only publication selected 
function show_only_publication(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;
	var destination_page = "property_page_connectivity.php";
	location.href = destination_page+"?name_show_only_journal="+name+"&start=0&stop="+stop2+"&name_show_only_journal_var=1";
}
// show only author selected 
function show_only_authors(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_connectivity.php";
	location.href = destination_page+"?name_show_only_authors="+name+"&start=0&stop="+stop2+"&name_show_only_authors_var=1";
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type->getNickname();
	$name2=$type2->getNickname();
	print("<title>Evidence - $name->$name2</title>");
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
	<font class="font1">Connectivity Evidence Page</font>
</div>


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
					Connection Details  
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; From:
					 <?php 
					    $type -> retrive_by_id($conn_id_neuron[0]);
					 	$id=$type->getId();
						$name=$type->getName();
						$type2 -> retrive_by_id($conn_id_neuron[1]);
						$id2=$type2->getId();
						$name2=$type2 -> getName();
					print("<a href='neuron_page.php?id=$id'>$name</a>");?> 
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right">&nbsp;</td>
				<td align="left" width="80%" class="table_neuron_page2">&nbsp;&nbsp;To: <?php print("<a href='neuron_page.php?id=$id2'>$name2</a>");?></td>
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; Type:
				<?php
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
		// for evidences coming from morphology page
			for($conn_cnt=0;$conn_cnt<2;$conn_cnt++){
			$neuron_id_conn=$conn_id_neuron[$conn_cnt];
			$part=$conn_part[$conn_cnt];
			$val_property=$conn_val_property[$conn_cnt];
			if ($part == 'axons_dendrites_somata')
				$n_interraction = 3;
			else if ($part == 'axons_dendrites' || $part == 'axons_somata' || $part == 'dendrites_somata')
				$n_interraction = 2;
			else 
				$n_interraction = 1;
						
			for ($tt=0; $tt<$n_interraction; $tt++)
			{
				$part1[$tt]="";
				if ($n_interraction == 1)
				{	
					// Axons or Dendrites
					// Retrieve property_id from Property by using Type_id
					if(($conn_cnt==0&&$part=='axons')||($conn_cnt==1&&$part=='dendrites')||($conn_cnt==1&&$part=='somata'&&$axonic_basket_flag!=0)){
						$part1[$tt] = ucfirst($part);
						$property  -> retrive_ID(1, $part, 'in', $val_property);
						$n_property_id = $property -> getNumber_type();				
					}
				}
				else if ($n_interraction == 2)
				{
					// Axons and Dendrites
					if($part == 'axons_dendrites')
					{
					 if ($tt == 0 && $conn_cnt==0)
					 {
						$part1[$tt] = 'Axons';
						$property  -> retrive_ID(1, 'axons', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();										
					 }
					 if ($tt == 1 && $conn_cnt==1 )
					 {
						$part1[$tt] = 'Dendrites';
						$property  -> retrive_ID(1, 'dendrites', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();										
					
					 }
					}
					else if($part == 'axons_somata')
					{
					 if ($tt == 0 && $conn_cnt==0)
					 {
						$part1[$tt] = 'Axons';
						$property  -> retrive_ID(1, 'axons', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();										
					 }
					 if ($tt == 1 && $conn_cnt==1 && $axonic_basket_flag!=0)
					 {
						$part1[$tt] = 'Somata';
						$property  -> retrive_ID(1, 'somata', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();
					 }
					}
                     else
					 { 
				     if ($tt == 0 && $conn_cnt==1)
					 {
						$part1[$tt] = 'Dendrites';
						$property  -> retrive_ID(1, 'dendrites', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();										
					 }
					 if ($tt == 1 && $conn_cnt==1 && $axonic_basket_flag!=0)
					 {
						$part1[$tt] = 'Somata';
						$property  -> retrive_ID(1, 'somata', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();
					 }
						 
					 }						 
				}
				else
				{
					if ($tt == 0 && $conn_cnt==1 )
					 {
						$part1[$tt] = 'Dendrites';
						$property  -> retrive_ID(1, 'dendrites', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();										
					 }
					 if ($tt == 1 && $conn_cnt==0)
					 {
						$part1[$tt] = 'Axons';
						$property  -> retrive_ID(1, 'axons', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();	
					 }
					  if ($tt == 2 && $conn_cnt==1 && $axonic_basket_flag!=0)
					 {
						$part1[$tt] = 'Somata';
						$property  -> retrive_ID(1, 'somata', 'in', $val_property);
						$n_property_id = $property -> getNumber_type();
					 }
					
				}
						
				for ($i=0; $i<$n_property_id; $i++)
				{
					$property_id[$i] = $property -> getProperty_id($i);

					// Retrive Evidence_id from evidencepropertyyperel by using $property_id and $type_id:
					$evidencepropertyyperel -> retrive_evidence_id($property_id[$i], $conn_id_neuron[$conn_cnt]);				
					$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
				}
												
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
					if ($page&&$part1[$tt]!="")
					{
							insert_temporary($name_temporary_table, $fragment_id[$i], $original_id, $quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $page_location, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, $part1[$tt], $volume, $issue,$neuron_id_conn);
					}
				}
			  }	
			}
		
			
		// logic for retriving conndata evidences
		if($known_unknown_flag==1||$known_unknown_flag==-1){
				if ($known_unknown_flag == 1)
					$conn_type="positive";
				elseif ($known_unknown_flag == -1)
					$conn_type="negative";
				$query_to_get_conn_evidence = "SELECT cr.ConnFragment_id,cd.Type1_id,cd.Type2_id,cd.connection_status,cd.connection_location,
									cf.original_id,cf.dt,cf.quote,cf.page_location,cf.pmid_isbn ,a.id,a.title,a.publication,a.year,a.pmid_isbn,
									a.first_page,a.last_page,a.pmcid,a.nihmsid,a.doi,a.open_access,a.citation_count,a.volume,a.issue
									FROM Conndata cd, ConndataFragmentRel cr,ConnFragment cf,EvidenceFragmentRel ef,ArticleEvidenceRel ae,
									Article a
									WHERE cd.id=cr.Conndata_id AND cf.id=cr.ConnFragment_id
									AND ef.Fragment_id=cr.ConnFragment_id
									AND ef.Evidence_id=ae.Evidence_id
									AND ae.Article_id=a.id
									AND cd.Type1_id=".$conn_id_neuron[0]." AND cd.Type2_id=".$conn_id_neuron[1]." GROUP BY cf.original_id";
				$conn_evidence_rs = mysqli_query($GLOBALS['conn'],$query_to_get_conn_evidence);
				// get the article associated with these fragments
				while(list($conn_fragment_id,$type1_id,$type2_id,$conn_status,$conn_location,$original_id,$conn_dt,$conn_quote,$conn_page_location,$conn_pmid_isbn,$id_article,$title,$publication,$year,$pmid_isbn,$first_page,$last_page,$pmcid,$nihmsid,$doi,$open_access,$citation_count,$volume,$issue) = mysqli_fetch_row($conn_evidence_rs))	{		
					if ($title[$ui] == '.')
						$title[$ui] = '';	
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
					{
						insert_temporary($name_temporary_table, $conn_fragment_id, $original_id, $conn_quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $conn_page_location, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, 'Known', $volume, $issue);
					}
				}
			}
					

					// Logic to form dynamic query to retrive evidences(axon,dendrite,soma & known) depending on checkbox selection 
					$subquery=" and ( ";
					$property_array=explode(",",$neuron_show_only_value);
					for($index=0;$index<count($property_array);$index++){
						if($property_array[$index]){
							$subquery=$subquery."type like '".$property_array[$index]."' or ";
						}
					}	
					$subquery=substr($subquery,0,count($subquery)-4);
					$subquery=$subquery.")";

					// find the total number of Articles: 
					$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 $subquery";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$n_id_tot = 0;	 // Total number of articles:
					while(list($id) = mysqli_fetch_row($rs))			
						$n_id_tot = $n_id_tot + 1;

					// find the total number of quotes of type axon: 
					$query = "SELECT total.count as totalcount,axon.count as axoncount,dendrite.count as dendritecount,
							soma.count as somacount,known.count as knowncount
							FROM
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table) as total,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Axons') as axon,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Dendrites') as dendrite,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Somata') as soma,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Known') as known
							";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$total_count_all=$number_of_quotes_axon = $number_of_quotes_dendrite=$number_of_quotes_somata=$number_of_quotes_known=0;
					 // total number of axon quotes
					while(list($total_count,$axon_count,$dendrite_count,$soma_count,$known_count) = mysqli_fetch_row($rs))	{		
						$total_count_all=intval($total_count);
						$number_of_quotes_axon = intval($axon_count);	
						$number_of_quotes_dendrite = intval($dendrite_count);	
						$number_of_quotes_somata = intval($soma_count);	
						$number_of_quotes_known = intval($known_count);	
					}
				
					$query = "SELECT total.count as totalcount,axon.count as axoncount,dendrite.count as dendritecount,
							soma.count as somacount,known.count as knowncount
							FROM
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE show_only=1) as total,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Axons' and show_only=1) as axon,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Dendrites' and show_only=1) as dendrite,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Somata' and show_only=1) as soma,
							(SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE type='Known' and show_only=1) as known
							";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$show_only_total_count_all=$show_only_number_of_quotes_axon = $show_only_number_of_quotes_dendrite=$show_only_number_of_quotes_somata=$show_only_number_of_quotes_known=0;
					 // total number of axon quotes
					while(list($total_count,$axon_count,$dendrite_count,$soma_count,$known_count) = mysqli_fetch_row($rs))	{		
						$show_only_total_count_all=intval($total_count);
						$show_only_number_of_quotes_axon = intval($axon_count);	
						$show_only_number_of_quotes_dendrite = intval($dendrite_count);	
						$show_only_number_of_quotes_somata = intval($soma_count);	
						$show_only_number_of_quotes_known = intval($known_count);	
					}
					
					if ($order_by == '-'){
						$query = "SELECT DISTINCT temp.title from (SELECT DISTINCT title,type FROM $name_temporary_table WHERE show_only = 1 $subquery ORDER BY FIELD (type,'Known','Axons','Dendrites','Somata') ) temp LIMIT $page_in , 10";
					}
					else{
						$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 $subquery ORDER BY $order_by $type_order LIMIT $page_in , 10";
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
						<td width="55%" align='center'>	
								<?php 
								// logic to view checkbox
								$property_checked="".$neuron_show_only_value;
								$property_checked=str_replace(",", "", $property_checked);
								$property_checked=trim($property_checked);
								//echo "$property_checked....$neuron_show_only_value";
								if($show_only_number_of_quotes_axon==0&&$number_of_quotes_axon != 0){
									// don't print checkbox
									//print("<span style='color:rgb(254,1,2)'  ><input type='checkbox' name='axon' value='axon' id='axoncheck_disabled'  disabled > axon(from) </input></span>");
								}
								else if($number_of_quotes_axon != 0){
									if(strstr($neuron_show_only_value,"Axons")){
										print("<span style='color:rgb(254,1,2)'  ><input type='checkbox' name='axon' value='axon' id='axoncheck' checked ");
										if($property_checked=="Axons"||(($show_only_number_of_quotes_dendrite+$show_only_number_of_quotes_somata+$show_only_number_of_quotes_known)== 0))
											print(" disabled ");
										print("onclick='changeCheckbox($page_in,$page_end)'>axon(from) </input></span>");
									}
									else
										print("<span style='color:rgb(254,1,2)'  ><input type='checkbox' name='axon' value='axon' id='axoncheck' onclick='changeCheckbox($page_in,$page_end)'>axon(from) </input></span>");
								}
								if($show_only_number_of_quotes_dendrite==0&&$number_of_quotes_dendrite != 0){
									// don't print checkbox
									//print("<span style='color:rgb(1,1,153)' ><input type='checkbox' name='dendrite' value='dendrite' id='dendritecheck_disabled' disabled >dendrite(to) </input></span>");
								}
								else if($number_of_quotes_dendrite != 0){
									if(strstr($neuron_show_only_value,"Dendrites")){
										print("<span style='color:rgb(1,1,153)' ><input type='checkbox' name='dendrite' value='dendrite' id='dendritecheck' checked ");
										if($property_checked=="Dendrites"||(($show_only_number_of_quotes_axon+$show_only_number_of_quotes_somata+$show_only_number_of_quotes_known)== 0))
											print(" disabled ");
										print("onclick='changeCheckbox($page_in,$page_end)' >dendrite(to) </input></span>");
									}
									else
										print("<span style='color:rgb(1,1,153)' ><input type='checkbox' name='dendrite' value='dendrite' id='dendritecheck'  onclick='changeCheckbox($page_in,$page_end)' >dendrite(to) </input></span>");
								}
								if($show_only_number_of_quotes_somata==0&&$number_of_quotes_somata != 0){
									// don't print checkbox
									//print("<span style='color:rgb(84,84,84)' ><input type='checkbox' name='somata' value='somata' id='somatacheck_disabled'  disabled >somata(to) </input></span>");
								}
								else if($number_of_quotes_somata != 0){
									if(strstr($neuron_show_only_value,"Somata")){
										print("<span style='color:rgb(84,84,84)' ><input type='checkbox' name='somata' value='somata' id='somatacheck' checked ");
										if($property_checked=="Somata"||(($show_only_number_of_quotes_axon+$show_only_number_of_quotes_dendrite+$show_only_number_of_quotes_known)== 0))
											print(" disabled ");
										print("onclick='changeCheckbox($page_in,$page_end)' >somata(to) </input></span>");
									}
									else
										print("<span style='color:rgb(84,84,84)' ><input type='checkbox' name='somata' value='somata' id='somatacheck'  onclick='changeCheckbox($page_in,$page_end)' >somata(to) </input></span>");
								}
								if((($show_only_number_of_quotes_axon+$show_only_number_of_quotes_dendrite+$show_only_number_of_quotes_somata)== 0)&&(($number_of_quotes_axon+$number_of_quotes_dendrite+$number_of_quotes_somata)!= 0)){
									// don't print checkbox
									//print("<span style='color:rgb(0,0,0)' ><input type='checkbox' name='potential' value='potential' id='potentialcheck_disabled' opacity='0.1' disabled> potential  </input></span>");
								}
								else if(($number_of_quotes_axon+$number_of_quotes_dendrite+$number_of_quotes_somata)!= 0){
									if(strstr($neuron_show_only_value,"Axons")||strstr($neuron_show_only_value,"Dendrites")||strstr($neuron_show_only_value,"Somata")){
										print("<span style='color:rgb(0,0,0)' ><input type='checkbox' name='potential' value='potential' id='potentialcheck' checked ");
										if(($known_unknown_flag !=0&&(!strstr($neuron_show_only_value,"Known")))||($known_unknown_flag==0)||$show_only_number_of_quotes_known==0)
											print(" disabled  ");
										print("onclick='changePotentialCheckbox($page_in,$page_end)' >potential </input></span>");
									}
									else
										print("<span style='color:rgb(0,0,0)' ><input type='checkbox' name='potential' value='potential' id='potentialcheck'  onclick='changePotentialCheckbox($page_in,$page_end)' >potential </input></span>");
								}
								if($show_only_number_of_quotes_known==0&&$known_unknown_flag ==1){
									// don't print checkbox
									//print("<span style='color:#339900' ><input type='checkbox' name='known' value='known' id='knowncheck_disabled' disabled>known </input></span>");
								}
								else if($known_unknown_flag ==1){
									if(strstr($neuron_show_only_value,"Known")){
										print("<span style='color:#339900' ><input type='checkbox' name='known' value='known' id='knowncheck' checked ");
										if($property_checked=="Known"||$show_only_total_count_all==$show_only_number_of_quotes_known)
											print(" disabled ");
										print("onclick='changeCheckbox($page_in,$page_end)'><b>Known </b></input></span>");
									}
									else
										print("<span style='color:#339900' ><input type='checkbox' name='known' value='known' id='knowncheck'  onclick='changeCheckbox($page_in,$page_end)' ><b>Known </b> </input></span>");
								}
								if($show_only_number_of_quotes_known==0&&$known_unknown_flag ==-1){
									// don't print checkbox
									//print("<span style='color:#339900' ><input type='checkbox' name='known' value='known' id='knowncheck_disabled' disabled>known </input></span>");
								}
								else if($known_unknown_flag ==-1){
									if(strstr($neuron_show_only_value,"Known")){
										print("<span style='color:rgb(254,1,2)' ><input type='checkbox' name='known' value='known' id='knowncheck' checked ");
										if($property_checked=="Known"||$show_only_total_count_all==$show_only_number_of_quotes_known)
											print(" disabled ");
										print("onclick='changeCheckbox($page_in,$page_end)'><b>Refuted </b> </input></span>");
									}
									else
										print("<span style='color:rgb(254,1,2)' ><input type='checkbox' name='known' value='known' id='knowncheck' onclick='changeCheckbox($page_in,$page_end)' > <b>Refuted </b></input></span>");
								}?>
							
						</td>
	
						<td width="25%" align="right">
						<form action="property_page_connectivity.php" method="post" style="display:inline">
						<input type="submit" name='see_all' value="Open All Evidence">
						<input type="submit" name='see_all' value="Close All Evidence">
						<input type="hidden" name='start' value='<?php print $page_in; ?>' />
						<input type="hidden" name='stop' value='<?php print $page_end; ?>' />
						<?php print ("<input type='hidden' name='name_show_only' value='$name_show_only'>"); ?>
						
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
						// show only dropdown
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
							print("<font class='font2'>By:</font> ");
							// retrieve the number of article or number of book:
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
						if ($sub_show_only == 'name_journal')
						{		
							print("<font class='font2'>By:</font> ");				
							print ("<select name='order' size='1' cols='10' class='select1' style='width: 200px;'  onChange=\"show_only_publication(this, $page_in, '10')\">");
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
								$query_pub ="SELECT DISTINCT title FROM $name_temporary_table WHERE publication = '$pub'";
								$rs_pub = mysqli_query($GLOBALS['conn'],$query_pub);
								$n_pub1=0;					
								while(list($id) = mysqli_fetch_row($rs_pub))							
									$n_pub1 = $n_pub1 + 1;
								if ($pub == $name_show_only_journal);
								else
									print ("<OPTION VALUE='".htmlspecialchars($pub,ENT_QUOTES)."'>".stripslashes($pub)." ($n_pub1)</OPTION>");		
							}
							print ("</select>");				
						}
						
						// AUTHORS - retrive author and evidences count associated with them
						
						if ($sub_show_only == 'authors')
						{
							print("<font class='font2'>By:</font> ");
							$author_string="";
							// retrieve the name of authors from temporary table:
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
							for ($cnt=0; $cnt<count($single_aut); $cnt++){
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
							
							for ($index=0; $index<count($unique_authors); $index++)
							{
								// retrieve the number of articles for this publication:
								if($unique_authors[$index]){
									$aut= mysqli_real_escape_string($GLOBALS['conn'],$unique_authors[$index]);
									$query_author ="SELECT DISTINCT title FROM $name_temporary_table WHERE authors LIKE '%$aut%'";
									$rs_author = mysqli_query($GLOBALS['conn'],$query_author);
									$n_auth1=0;					
									while(list($id) = mysqli_fetch_row($rs_author))	
										$n_auth1 = $n_auth1 + 1;						
									print ("<OPTION VALUE='".htmlspecialchars($aut,ENT_QUOTES)."'>".stripslashes($unique_authors[$index])." ($n_auth1)</OPTION>");
								}
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
							<form action="property_page_connectivity.php" method="post" style="display:inline">
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
				$quote_count=0;					
				for ($i=0; $i<$n_id; $i++)
				{	
				
					// retrieve information about the authors, journals etc by using name of article:
					$query = "SELECT id, authors, publication, year, PMID, pages, page_location, show1, pmcid, nihmsid, doi, show_only, volume, issue FROM $name_temporary_table WHERE title = '$title_temp[$i]' ORDER BY type ";					
					$rs = mysqli_query($GLOBALS['conn'],$query);	
					$auth=array();	
					//print($query);	
					while(list($id, $authors, $publication, $year, $PMID, $pages, $page_location, $show, $pmcid, $nihmsid, $doi, $show_only, $volume, $issue) = mysqli_fetch_row($rs))
					{	
						//print($id.":");		
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
							</td> ");
						$type_show  = "";
						$query = "SELECT distinct type FROM $name_temporary_table WHERE title = '$title_temp[$i]' $subquery group by id_fragment ORDER BY FIELD (type,'Known','Axons','Dendrites','Somata') ";	
						$rs = mysqli_query($GLOBALS['conn'],$query);	
						while(list($type) = mysqli_fetch_row($rs))
						{	
							$type_show  = $type_show . $type;
						}
						//echo "$type_show";
						if($known_unknown_flag==-1&&strstr($type_show,"Known")){
							print(" <td width='5%' align='center' bgcolor=red  valign='center'> ");
						}
						else if($known_unknown_flag==1&&strstr($type_show,"Known")){
							print(" <td width='5%' align='center' bgcolor='#339900'  valign='center'> ");
						}
						else{
							print(" <td width='5%' align='center' class='table_neuron_page2' valign='center'> ");
						}						
						if ($show1 == 0)
						{
							print ("<form action='property_page_connectivity.php' method='post' style='display:inline'>");
							print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
							print ("<input type='hidden' name='start' value='$page_in' />");
							print ("<input type='hidden' name='stop' value='$page_end' />");
							print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
							print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
							print ("</form>");
						}
						if ($show1 == 1)
						{
							print ("<form action='property_page_connectivity.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
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
						
						// TABLE for Quotes: 
						
						// Retrive evidences stored in temporary table
						try {
							$query = "SELECT distinct id_fragment, id_original,id_neuron, quote, page_location FROM $name_temporary_table WHERE title = '$title_temp[$i]' $subquery group by id_fragment ORDER BY FIELD (type,'Known','Axons','Dendrites','Somata') ";	
							$rs = mysqli_query($GLOBALS['conn'],$query);	
							while(list($id_fragment, $id_original,$id_neuron_conn, $quote, $page_location, $type) = mysqli_fetch_row($rs))
							{	
								$quote_count++;	
								if ($show1 == 1)
								{		
									$type_show  = "";
									$query_type = "SELECT distinct type FROM $name_temporary_table WHERE id_fragment = $id_fragment $subquery ORDER BY FIELD (type,'Axons','Dendrites','Somata','Known')";
									$rs_type = mysqli_query($GLOBALS['conn'],$query_type);	
									while(list($type) = mysqli_fetch_row($rs_type))
									{
										$type_show  = $type_show . $type;
									}				
								    // Logic for viewing image associated with evidence(quote)
									if($type_show != ''){
										if ($type_show == 'Axons')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axon'>");
										else if ($type_show == 'Dendrites')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendrite'>");
									    else if ($type_show == 'Somata')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='somata'>");
										else if ($type_show == 'AxonsSomata')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axonsomata'>");
										else if ($type_show == 'AxonsDendrites')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendrite'>");
										else if ($type_show == 'DendritesSomata')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='dendritesomata'>");
										else if ($type_show == 'AxonsDendritesSomata')
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='axondendritesomata'>");								
										else if ($type_show == "Known")				
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='known'>");
										else
											print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='known'>");
			
									}
									print ("<tr>");
									if ($type_show == 'Axons')		
										print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p><img src='images/axon.png'></td>");
									else if ($type_show == 'Dendrites')		
										print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p><img src='images/dendrite.png'></td>");	
									else if ($type_show == 'Somata')		
										print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p></td>");
                                    else if ($type_show == 'AxonsSomata')	
                                        print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axonsomata'> <p style='color:rgb(0,0,0);font-size:60%'>Potential</p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon.png'></td>");										   
                                    else if ($type_show == 'AxonsDendrites')	
										print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendrite'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p><img src='images/axon-dendrite.png'></td>");
                                    else if ($type_show == 'DendritesSomata')
										print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-dendritesomata'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/dendrite.png'></td>");	
									else if ($type_show == 'AxonsDendritesSomata')
                                      	print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendritesomata'><p style='color:rgb(0,0,0);font-size:60%'>Potential</p> <p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon-dendrite.png'></td>");
									// known connection 
									if (strstr($type_show,"Known")){
										if($known_unknown_flag==1){
											if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Dendrites")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendritesomata'> <p style='color:#339900;font-size:70%'><b>Known</b></p> <p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon-dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Dendrites"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendrite'> <p style='color:#339900;font-size:70%'><b>Known</b></p><img src='images/axon-dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:#339900;font-size:70%'><b>Known</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon.png'></td>");
											else if(strstr($neuron_show_only_value,"Dendrites")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:#339900;font-size:70%'><b>Known</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:#339900;font-size:70%'><b>Known</b></p><img src='images/axon.png'></td>");										   
											else if(strstr($neuron_show_only_value,"Dendrites"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:#339900;font-size:70%'><b>Known</b></p><img src='images/dendrite.png'></td>");										  
											else if(strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:#339900;font-size:70%'><b>Known</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p></td>");										   
											else if(strstr($neuron_show_only_value,"Known"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'> <p style='color:#339900;font-size:70%'><b>Known</b></p></td>");										   
										}
										else if($known_unknown_flag==-1){
											if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Dendrites")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendritesomata'> <p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p> <p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon-dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Dendrites"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell' class='comboflag-axondendrite'> <p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><img src='images/axon-dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/axon.png'></td>");
											else if(strstr($neuron_show_only_value,"Dendrites")&&strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p><img src='images/dendrite.png'></td>");
											else if(strstr($neuron_show_only_value,"Axons"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><img src='images/axon.png'></td>");										   
											else if(strstr($neuron_show_only_value,"Dendrites"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><img src='images/dendrite.png'></td>");										  
											else if(strstr($neuron_show_only_value,"Somata"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'>  <p style='color:rgb(254,1,2);font-size:70%'><b>Refuted</b></p><p style='color:rgb(84,84,84);font-size:68%'>SOMA</p></td>");										   
											else if(strstr($neuron_show_only_value,"Known"))
												print ("<td width='15.5%' rowspan='3' align='right' valign='top'><p style='color:rgb(254,1,2);font-size:70%'><b> Refuted</b></p></td>");
										}
									}
									// retrieve the attachament from "attachment" with original_id and cell-id(id_neuron)
									$attachment_obj -> retrive_attachment_by_original_id($id_original, $id_neuron_conn);
									$attachment = $attachment_obj -> getName();
									$attachment_type = $attachment_obj -> getType();
									$link_figure="";
									$attachment_jpg = str_replace('jpg', 'jpeg', $attachment);
									if($attachment_type=="marker_figure"||$attachment_type=="marker_table"){
										$link_figure = "attachment/marker/".$attachment_jpg;
									}
									
									if($attachment_type=="morph_figure"||$attachment_type=="morph_table"){
										$link_figure = "attachment/morph/".$attachment_jpg;
									}
									
									if($attachment_type=="ephys_figure"||$attachment_type=="ephys_table"){
										$link_figure = "attachment/ephys/".$attachment_jpg;
									}
									
									$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
									$link_figure_pdf = "figure_pdf/".$attachment_pdf;
									
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
	 							}		
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
						<td width="15%"></td>		
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
						
						<form action="property_page_connectivity.php" method="post" style="display:inline">
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
						<form action="property_page_connectivity.php" method="post" style="display:inline">
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
						<td width="15%"></td>	
					</tr>
				</table>

		</td>
	</tr>
</table>
</body>
</html>	

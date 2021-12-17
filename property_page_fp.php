<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="jqGrid-4/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.2.custom/js/jquery.jqGrid.src-custom.js" type="text/javascript"></script>

<?php
include ("function/name_ephys.php");
include ("function/name_ephys_for_evidence.php");
include ("function/name_parameter_ephys.php");
include ("function/show_ephys.php");

include ("function/get_abbreviation_definition_box.php");
include ("function/stm_lib.php");
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
require_once('class/class.evidencemarkerdatarel.php');
require_once('class/class.markerdata.php');
require_once('class/class.evidenceevidencerel.php');
require_once('class/class.epdata.php');
require_once('class/class.epdataevidencerel.php');


function create_temp_table ($name_temporary_table)
{	
	$drop_table ="DROP TABLE $name_temporary_table";
	$query = mysqli_query($GLOBALS['conn'],$drop_table);
	$creatable=	"CREATE TABLE IF NOT EXISTS $name_temporary_table (
					id int(4) NOT NULL AUTO_INCREMENT,
					fp_id int(10),
					id_fragment int(10),
					id_neuron int(10),
					id_original BIGint(20),
					quote text(2000),
					authors varchar(600),
					title varchar(300),
					publication varchar(100),
					year varchar(15),
					PMID BIGint(25),
					pages varchar(20),
					page_location varchar(100),
					protocol varchar(80),
					id_evidence int(20),
					show1 int(5),
					pmcid varchar(400),
					nihmsid varchar(400),
					doi varchar(400),
					open_access int(6),
					citation_count int(7),
					show_only int(30),
					volume varchar(20),
					issue varchar(20),
					interpretation varchar(200),
					interpretation_notes varchar(800),
					linking_pmid_isbn varchar(80),
					linking_pmid_isbn_page varchar(80),
					linking_quote text(4000),
					linking_page_location varchar(80),
					istim varchar(32),
					tstim varchar(32),
					rep_value varchar(128),
					fp_original_name varchar(256),
					PRIMARY KEY (id));";
	$query = mysqli_query($GLOBALS['conn'],$creatable);
}

function create_temp_table_ephysprotocol ($name_temporary_table)
{
	$drop_table ="DROP TABLE $name_temporary_table";
	$query = mysqli_query($GLOBALS['conn'],$drop_table);

	$createtable=	"CREATE TABLE IF NOT EXISTS $name_temporary_table (
	id int(4) NOT NULL AUTO_INCREMENT,
	PMID BIGint(25),
	protocol varchar(80),
	rep_value varchar(128),
	PRIMARY KEY (id));";

	$query = mysqli_query($GLOBALS['conn'],$createtable);
}

function insert_temporary($table,$fp_id, $id_fragment, $id_original, $quote, $authors, 
	$title, $publication, $year, $PMID, $pages, $page_location, $protocol, $id_evidence, $show1,  $pmcid, $nihmsid, $doi, 
	$open_access, $citation_count,  $volume, $issue,$id_neuron_fp=NULL,
	$interpretation,$interpretation_notes,$linking_pmid_isbn,$linking_pmid_isbn_page,$linking_quote,$linking_page_location,$istim,$tstim,  $rep_value, $fp_original_name)
{
	
	if ($open_access == NULL)
		$open_access = -1;
	if ($citation_count == NULL)
		$citation_count = -1;
	if($id_neuron_conn==NULL)
		$id_neuron_conn=-1;
	//set_magic_quotes_runtime(0);	
	if (get_magic_quotes_gpc()) {
    	$publication = stripslashes($publication);  
    	$quote = stripslashes($quote);   
		$authors = stripslashes($authors); 
		$linking_quote = stripslashes($linking_quote);
		$linking_page_location = stripslashes($linking_page_location);
	}
	$publication= mysqli_real_escape_string($GLOBALS['conn'],$publication);
	$quote = mysqli_real_escape_string($GLOBALS['conn'],$quote);
	$authors = mysqli_real_escape_string($GLOBALS['conn'],$authors);
	$linking_quote = mysqli_real_escape_string($GLOBALS['conn'],$linking_quote);
	$linking_page_location = mysqli_real_escape_string($GLOBALS['conn'],$linking_page_location);
	$query_i = "INSERT INTO $table
	  (id,
	   fp_id,
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
	   protocol,
	   id_evidence,
	   show1,
	   pmcid,
	   nihmsid,
	   doi,
	   open_access,
	   citation_count,
	   show_only,
	   volume,
	   issue,
	   interpretation,
	   interpretation_notes,
	   linking_pmid_isbn,
       linking_pmid_isbn_page,
	   linking_quote,
	   linking_page_location,
	   istim,
	   tstim,
	   rep_value,
	   fp_original_name
	   )
	VALUES
	  (NULL,
	   '$fp_id',
	   '$id_fragment',
	   '$id_original',
	   '$id_neuron_fp',
	   '$quote',
	   '$authors',
	   '$title',
	   '$publication',
	   '$year',
	   '$PMID',
	   '$pages',
	   '$page_location',
	   '$protocol',
	   '$id_evidence',
	   '$show1',
	   '$pmcid',
	   '$nihmsid',
	   '$doi',
	   '$open_access',
	   '$citation_count',
	   '1',
	   '$volume' ,
	   '$issue',
	   '$interpretation',
	   '$interpretation_notes',
	   '$linking_pmid_isbn',
	   '$linking_pmid_isbn_page',
	   '$linking_quote',
	   '$linking_page_location',
	   '$istim',
	   '$tstim',
	   '$rep_value',
	   '$fp_original_name'  
	   )";
	$rs2 = mysqli_query($GLOBALS['conn'],$query_i);					
 }

function insert_temporary_ephysprotocol($table,$PMID, $protocol, $rep_value)
{
	$PMID = mysqli_real_escape_string($GLOBALS['conn'],$PMID);	
	$protocol = mysqli_real_escape_string($GLOBALS['conn'],$protocol);
	$query_i_p = "INSERT INTO $table
	(
		PMID,
		protocol,
		rep_value
		)
	VALUES
	(
	   '$PMID',
	   '$protocol',
	   '$rep_value'
	   )";

	$rs2p = mysqli_query($GLOBALS['conn'],$query_i_p);
}

function expand_protocol_text($protocol)
{
	$protocol = str_replace(' ', '', $protocol);
	$prot_pieces = explode("|", $protocol);
	
	if ($prot_pieces[0] == "r")
		$prot_pieces[0] = "rats";
	else if ($prot_pieces[0] == "m")
		$prot_pieces[0] = "mice";
	else if ($prot_pieces[0] == "r;m" || $prot_pieces[1] == "m;r")
		$prot_pieces[0] = "rats; mice";
	else if ($prot_pieces[0] == "g")
		$prot_pieces[0] = "guinea pigs";
	else
		$prot_pieces[0] = "species unknown";
	
	if ($prot_pieces[1] == "p")
		$prot_pieces[1] = "patch clamp";
	else if ($prot_pieces[1] == "e")
		$prot_pieces[1] = "microelectrodes";
	else if ($prot_pieces[1] == "e;p" || $prot_pieces[2] == "p;e")
		$prot_pieces[1] = "microelectrodes; patch clamp";
	else
		$prot_pieces[1] = "protocol unknown";
	
	if ($prot_pieces[2] != "")
		$prot_pieces[2] = "temperature=" . $prot_pieces[2] . "&deg;";
	
	if ($prot_pieces[3] == "r")
		$prot_pieces[3] = "(room)";
	else if ($prot_pieces[3] == "b")
		$prot_pieces[3] = "(body)";
	else
		$prot_pieces[3] = "temperature unknown";
	
	$protocol = $prot_pieces[0] . " | " . $prot_pieces[1] . " | " . $prot_pieces[2] . " " . $prot_pieces[3];
	
	return $protocol;
}



$page = $_REQUEST['page'];
$sub_show_only = $_SESSION['fp_sub_show_only']; 
$name_show_only_article = $_SESSION['fp_name_show_only_article'];

$name_show_animal = $_SESSION['name_show_animal'];
$name_show_protocol = $_SESSION['name_show_protocol'];
$name_show_temperature = $_SESSION['name_show_temperature'];

$see_all = $_REQUEST['see_all']; 
if ($see_all == 'Open All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	

	$name_show_animal_t = strtolower($name_show_animal);
	$name_show_protocol_t = strtolower($name_show_protocol);
	$name_show_protocol_t1 = substr($name_show_protocol_t , 0, 5);
	$name_show_temperature_t = strtolower($name_show_temperature);

	

	if($name_show_animal != 'All' && $name_show_protocol != 'All' && $name_show_temperature != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 =  '1' where protocol like '$name_show_animal_t%' and protocol like '%$name_show_protocol_t1%' and protocol like '%$name_show_temperature_t%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	elseif($name_show_animal != 'All' && $name_show_protocol != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '$name_show_animal_t%' and protocol like '%$name_show_protocol_t1%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	elseif($name_show_animal != 'All' && $name_show_temperature != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '$name_show_animal_t%' and protocol like '%$name_show_temperature_t%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	elseif($name_show_protocol != 'All' && $name_show_temperature != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%$name_show_protocol_t1%' and protocol like '%$name_show_temperature_t%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	elseif($name_show_animal != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '$name_show_animal_t%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	elseif($name_show_protocol != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%$name_show_protocol_t1%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	elseif($name_show_temperature != 'All')
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%$name_show_temperature_t%'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}
	else
	{
		$query = "UPDATE $name_temporary_table SET show1 = '1'";
		$rs2 = mysqli_query($GLOBALS['conn'],$query);
	}

}

if ($see_all == 'Close All Evidence')
{
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];	
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];
	$query = "UPDATE $name_temporary_table SET show1 =  '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);		
}

// Change the show coloums in the temporary table: ------------------------------------------------
if ($_REQUEST['show_1']) //  ==> ON
{
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];
	$title_paper = $_REQUEST['title'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$query = "UPDATE $name_temporary_table SET show1 =  '1' WHERE title = '$title_paper'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);	
}

if ($_REQUEST['show_0']) //  ==> OFF
{
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];
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
	$_SESSION['fp_name_show_only'] = $name_show_only;

	$sub_show_only = NULL;
	$_SESSION['fp_sub_show_only'] = $sub_show_only;	

		$name_show_animal = NULL;
	$_SESSION['name_show_animal'] = $name_show_animal;
	
	$name_show_protocol = NULL;
	$_SESSION['name_show_protocol'] = $name_show_protocol;
	
	$name_show_temperature = NULL;
	$_SESSION['name_show_temperature'] = $name_show_temperature;

	$name_show_only_article = 'all';
	$name_show_only_journal = 'all';
	$name_show_only_authors = 'all';	
	
	$id_neuron = $_REQUEST['id_neuron'];
	$parameter = $_REQUEST['parameter'];
	$par="".$parameter;
	
	// get connection properties
	$fp_count=$_REQUEST['count'];
	// create temporary table
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	if($parameter=="-"){
		$name_temporary_table ='temp_'.$ip_address.'_'.$id_neuron."_".'__'.$time_t;
		$name_temporary_table_ephys ='temp_ep_'.$ip_address.'_'.$id_neuron."_".'__'.$time_t;
	}
	else{
		$name_temporary_table ='temp_'.$ip_address.'_'.$id_neuron.str_replace(".", "", $parameter).'__'.$time_t;
		$name_temporary_table_ephys ='temp_ep_'.$ip_address.'_'.$id_neuron.str_replace(".", "", $parameter).'__'.$time_t;
	}
	$_SESSION['fp_name_temporary_table'] = $name_temporary_table;
	$_SESSION['fp_name_temporary_table_ephys'] = $name_temporary_table_ephys;
	create_temp_table($name_temporary_table);
	create_temp_table_ephysprotocol($name_temporary_table_ephys);	
	// add connection and its properties to session for future use
	$_SESSION['fp_id_neuron']=$id_neuron;
	$_SESSION['fp_parameter']=$parameter;

	$_SESSION['fp_count']=$fp_count;
	
	// default parameter for displaying evidences
	$page_in = 0;
	$page_end = 10;
	// default order
	$order_by = 'year';     
	$type_order = 'DESC';
	$_SESSION['order_by'] = $order_by;
	$_SESSION['type_order'] = $type_order;
	
}
else
{
	$name_show_only = $_SESSION['fp_name_show_only'];
	$_SESSION['fp_name_show_only'] = $name_show_only;
	$name_show_only_journal = $_SESSION['fp_name_show_only_journal'];
	$name_show_only_authors = $_SESSION['fp_name_show_only_authors'];
	$name_show_only_article = $_SESSION['fp_name_show_only_article'];
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
	
	$id_neuron = $_SESSION['fp_id_neuron'];
	$parameter = $_SESSION['fp_parameter'];
	
	// get connection properties
	$fp_count=$_SESSION['fp_count'];
	// add connection and its properties to session for future use

	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

}


// show only dropdown clicked
$name_show_only_var = $_REQUEST['name_show_only_var']; 

if ($name_show_only_var)
{
	$name_show_only = $_REQUEST['name_show_only'];
	$_SESSION['fp_name_show_only'] = $name_show_only;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

	// Option: All:
	if ($name_show_only == 'all')
	{
		$sub_show_only = 'all';
		$_SESSION['fp_sub_show_only'] = $sub_show_only;
	}
	
	// Option: Articles / books:
	if ($name_show_only == 'article_book')
	{
		$name_show_only_article = 'all';
		$_SESSION['fp_name_show_only_article'] = $name_show_only_article;
		$sub_show_only = 'article';
		$_SESSION['fp_sub_show_only'] = $sub_show_only;
	}

	// Option: Publication:
	if ($name_show_only == 'name_journal')
	{
		$name_show_only_journal = 'all';
		$_SESSION['fp_name_show_only_journal']=$name_show_only_journal;
		$sub_show_only = 'name_journal';
		$_SESSION['fp_sub_show_only'] = $sub_show_only;		
	}

	// Option: Authors:
	if ($name_show_only == 'authors')
	{
		$name_show_only_authors = 'all';
		$_SESSION['fp_name_show_only_authors'] = $name_show_only_authors;
		$sub_show_only = 'authors';
		$_SESSION['fp_sub_show_only'] = $sub_show_only;			
	}
	$query = "UPDATE $name_temporary_table SET show_only =  '1'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);
} 

// ARTICLE - BOOK OPTION - for clicked Article/Book's evidences(quotes) set the show only flag to 1 in temporary table 
$name_show_only_article_var = $_REQUEST['name_show_only_article_var'];
if ($name_show_only_article_var)
{
	$name_show_only_article = $_REQUEST['name_show_only_article'];
	$_SESSION['fp_name_show_only_article'] = $name_show_only_article;
	$_SESSION['fp_name_show_only_journal'] = 'all';
	$_SESSION['fp_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['fp_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

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
	$_SESSION['fp_name_show_only_journal'] = $name_show_only_journal;
	$_SESSION['fp_name_show_only_article'] = 'all';
	$_SESSION['fp_name_show_only_authors'] = 'all';
	$name_show_only = $_SESSION['fp_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

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
	$_SESSION['fp_name_show_only_authors'] = $name_show_only_authors;
	$_SESSION['fp_name_show_only_article'] = 'all';
	$_SESSION['fp_name_show_only_journal'] = 'all';
	$name_show_only = $_SESSION['fp_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

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


//Animal
$name_show_animal_var = $_REQUEST['name_show_animal_var'];

if ($name_show_animal_var)
{
	$query = "UPDATE $name_temporary_table SET show1 = '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);
	$name_show_animal = $_REQUEST['name_show_animal'];
	$_SESSION['name_show_animal'] = $name_show_animal;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

	// Option: Mice:
	if ($name_show_animal == 'Mice')
	{
		if($name_show_protocol == 'Patch_Clamp')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%patch clamp%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%patch clamp%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%patch clamp%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			
		}
		elseif($name_show_protocol == 'Microelectrodes')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%microelectrodes%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%microelectrodes%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%microelectrodes%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}			
	}
	//Option: Rats
	if ($name_show_animal == 'Rats')
	{
		if($name_show_protocol == 'Patch_Clamp')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%patch clamp%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%patch clamp%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%patch clamp%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_protocol == 'Microelectrodes')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%microelectrodes%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%microelectrodes%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%microelectrodes%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}			
	}
	//Option:All
	if ($name_show_animal == 'All')
	{
		if($name_show_protocol == 'Patch_Clamp')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_protocol == 'Microelectrodes')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
		}			
	}
	
}

//Protocol
$name_show_protocol_var = $_REQUEST['name_show_protocol_var'];

if ($name_show_protocol_var)
{
	$query = "UPDATE $name_temporary_table SET show1 = '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);
	$name_show_protocol = $_REQUEST['name_show_protocol'];
	$_SESSION['name_show_protocol'] = $name_show_protocol;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

	// Option: Patch Clamp:
	if ($name_show_protocol == 'Patch_Clamp')
	{
		if($name_show_animal == 'Rats')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'rats%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'rats%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'rats%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'mice%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'mice%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'mice%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
		}		
	}
	//Option: Microelectrodes
	if ($name_show_protocol == 'Microelectrodes')
	{
		if($name_show_animal == 'Rats')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'rats%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'rats%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'rats%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'mice%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'mice%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'mice%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}			
	}
	//Option:All
	if ($name_show_protocol == 'All')
	{
		if($name_show_animal == 'Rats')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if($name_show_temperature == 'Body')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			elseif($name_show_temperature == 'Room')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			elseif($name_show_temperature == 'Unknown')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);	
			}
		}
	}
}
	

//Temperature
$name_show_temperature_var = $_REQUEST['name_show_temperature_var'];

if ($name_show_temperature_var)
{
	$query = "UPDATE $name_temporary_table SET show1 = '0'";
	$rs2 = mysqli_query($GLOBALS['conn'],$query);
	$name_show_temperature = $_REQUEST['name_show_temperature'];
	$_SESSION['name_show_temperature'] = $name_show_temperature;
	
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

	// Option: Body:
	if ($name_show_temperature == 'Body')
	{
		if($name_show_animal == 'Rats')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'rats%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'rats%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'mice%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'mice%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%body%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}		
	}
	//Option: Room
	if ($name_show_temperature == 'Room')
	{
		if($name_show_animal == 'Rats')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'rats%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'rats%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'mice%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'mice%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%room%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}		
	}
	
	//Option:Unknown
	if ($name_show_temperature == 'Unknown')
	{
		if($name_show_animal == 'Rats')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'rats%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'rats%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'mice%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'mice%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%unknown%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}		
	}
	
	//Option:All
	if ($name_show_temperature == 'All')
	{
		if($name_show_animal == 'Rats')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'rats%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		elseif($name_show_animal == 'Mice')
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%' and protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like 'mice%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
		else
		{
			if ($name_show_protocol == 'Patch_Clamp')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%patch clamp%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			elseif ($name_show_protocol == 'Microelectrodes')
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1' where protocol like '%microelectrodes%'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
			else
			{
				$query = "UPDATE $name_temporary_table SET show1 = '1'" ;
				$rs2 = mysqli_query($GLOBALS['conn'],$query);
			}
		}
	}	
	
	
}


// axon, dedrite/soma, known checkbox checked or unchecked
$neuron_show_only = $_REQUEST['neuron_show_only'];
if ($neuron_show_only){
	$neuron_show_only_value = $_REQUEST['neuron_show_only_value'];
	$_SESSION['fp_neuron_show_only_value'] = $neuron_show_only_value;
	$name_show_only = $_SESSION['fp_name_show_only'];
	$page_in = $_REQUEST['start'];
	$page_end = $_REQUEST['stop'];
	$name_temporary_table = $_SESSION['fp_name_temporary_table'];
	$name_temporary_table_ephys = $_SESSION['fp_name_temporary_table_ephys'];

}






// find axon, dendrite or soma property

		
$type = new type($class_type);
$type -> retrive_by_id($id_neuron);

$property = new property($class_property);
$fragment = new fragment($class_fragment);

$attachment_obj = new attachment($class_attachment);
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$evidencefragmentrel = new evidencefragmentrel($class_evidencefragmentrel);

$epdataevidencerel = new epdataevidencerel($class_epdataevidencerel);
$epdata = new epdata($class_epdata);
$evidenceevidencerel = new evidenceevidencerel($class_evidenceevidencerel);

$articleevidencerel = new articleevidencerel($class_articleevidencerel);
$article = new article($class_article);
$articleauthorrel = new articleauthorrel($class_articleauthorrel);
$author = new author($class_author);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<script>
$(document).ready(function(){
     $("span[id^='flip']").click(function(){
     	if ( $(this).next().next().is(':visible') ){
     		$(this).text("View All Parameters");
     	}
     	else{
     		$(this).text("Hide All Parameters");
     	}
     	$(this).next().next().slideToggle("fast");
    });
});
</script>
<style>
.panel {
    padding: 0px;
    display: none;
    text-align: left;
}
</style>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
//================changes===========================
// checkbox clicked hence change the selection and store it in session 

// show only drop down clicked
function show_only(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";

	location.href = destination_page+"?name_show_only="+name+"&start="+start2+"&stop="+stop2+"&name_show_only_var=1";
}
// show only article option selected
function show_only_article(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";
	location.href = destination_page+"?name_show_only_article="+name+"&start=0&stop="+stop2+"&name_show_only_article_var=1";
}
// show only publication selected 
function show_only_publication(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;
	var destination_page = "property_page_fp.php";
	location.href = destination_page+"?name_show_only_journal="+name+"&start=0&stop="+stop2+"&name_show_only_journal_var=1";
}

//Animal
function show_animal(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";

	location.href = destination_page+"?name_show_animal="+name+"&start="+start2+"&stop="+stop2+"&name_show_animal_var=1";
}

//Protocol
function show_protocol(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";

	location.href = destination_page+"?name_show_protocol="+name+"&start="+start2+"&stop="+stop2+"&name_show_protocol_var=1";
}

//Temperature
function show_temperature(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";

	location.href = destination_page+"?name_show_temperature="+name+"&start="+start2+"&stop="+stop2+"&name_show_temperature_var=1";
}


// show only author selected 
function show_only_authors(link, start1, stop1)
{
	var name=link[link.selectedIndex].value;
	var start2 = start1;
	var stop2 = stop1;

	var destination_page = "property_page_fp.php";
	location.href = destination_page+"?name_show_only_authors="+name+"&start=0&stop="+stop2+"&name_show_only_authors_var=1";
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); 
	$name=$type->getNickname();
	print("<title>Evidence - $name ($parameter)</title>");
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
	<font class="font1">Firing Pattern Evidence Page</font>
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
					Firing Pattern Details  
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; Neuron Type:
					 <?php 
					    $type -> retrive_by_id($id_neuron);
					 	$id=$type->getId();
						$name=$type->getName();
					print("<a href='neuron_page.php?id=$id'>$name</a>");?> 
				</td>				
			</tr>
			<tr>
				<td width="20%" align="right">&nbsp;</td>
				<?php
					$query = "SELECT fp_name FROM FiringPattern WHERE overall_fp like '$parameter'";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$row_data = mysqli_fetch_row($rs);
					$fp_name_val=$row_data[0];
					print("<td align='left' width='80%' class='table_neuron_page2'>&nbsp;&nbsp;Firing Pattern: <a href='neuron_by_pattern.php?pattern=$parameter'>$fp_name_val ($parameter)</a></td>");
				?>
				
			</tr>
			<tr>
				<td width="20%" align="right">
				</td>
				<td align="left" width="80%" class="table_neuron_page2">
					&nbsp; 
				<?php
					if($fp_count<2)
						print("Occurrence:");
					else
						print("Occurrences:");
					print ("<strong>$fp_count</strong>");
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

				
		// logic for retriving conndata evidences
			$query_to_get_fp_evidence = "SELECT fp.id as firing_pattern_id,f.id,f.original_id,f.dt,f.quote,f.page_location,f.pmid_isbn , a.id,a.title,a.publication,a.year,a.pmid_isbn,
					a.first_page,a.last_page,a.pmcid,a.nihmsid,a.doi,a.open_access,a.citation_count,a.volume,a.issue,f.interpretation,f.interpretation_notes,f.linking_pmid_isbn,f.linking_pmid_isbn_page,f.linking_quote,f.linking_page_location,fr.istim_pa as istim,fr.tstim_ms as tstim,fp.fp_name									
					FROM Fragment f, EvidenceFragmentRel ef,ArticleEvidenceRel ae, Article a,FiringPatternRel fr,FiringPattern fp
					WHERE fr.FiringPattern_id=fp.id
					AND fr.original_id=f.original_id 
					AND ef.Fragment_id=f.id
					AND ef.Evidence_id=ae.Evidence_id
					AND ae.Article_id=a.id
					AND fp.overall_fp like '$parameter' AND  fr.Type_id='$id_neuron' AND fp.definition_parameter like 'parameter' ";
			$fp_evidence_rs = mysqli_query($GLOBALS['conn'],$query_to_get_fp_evidence);
			$id_neuron_fp=$id_neuron;

		$ep = array("Vrest", "Rin", "tm", "Vthresh", "fast_AHP", "AP_ampl", "AP_width", "max_fr", "slow_AHP", "sag_ratio" );

		for($i=0;$i<10;$i++)
		{
				$property -> retrive_ID(3, $ep[$i], NULL, NULL);
		
		
				$id_property = $property -> getProperty_id(0);

		
				// retrieve the id_evidence by id_type amd id_property:
		
				$evidencepropertyyperel -> retrive_evidence_id($id_property, $id_neuron);
		
				$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
		
				for ($i1=0; $i1<$n_evidence_id; $i1++)
			 	{
					$id_evidence[$i1] = $evidencepropertyyperel -> getEvidence_id_array($i1);

					// with evidence_id1 it needs to have evidence_id2 that is used for the id_article
					$evidenceevidencerel -> retrive_evidence2_id($id_evidence[$i1]);
					$id_evidence_2[$i1] = $evidenceevidencerel -> getEvidence2_id_array(0);
		
					// retrieve the id_epdata by id_evidence:
					$epdataevidencerel -> retrive_Epdata($id_evidence[$i1]);
					$id_epdata[$i1] = $epdataevidencerel -> getEpdata_id();
				 }// end FOR $i1
		
				$n_epdata = $n_evidence_id;
				$n_article = $n_epdata;

			

			for ($i1=0; $i1<$n_epdata; $i1++)
			 	{
			 		
			 		$epdata -> retrive_all_information($id_epdata[$i1]);

			 		$rep_value[$i1] = $epdata -> getRep_value();
					$locationValue[$i1] = $epdata -> getLocation();

					
					// retrieve information about fragment: --------------
					$evidencefragmentrel -> retrive_fragment_id_1($id_evidence_2[$i1]);
					$id_fragment = $evidencefragmentrel -> getFragment_id();
					$fragment -> retrive_by_id($id_fragment);
					$page_loc = $fragment -> getPage_location();
					
					// Extract page_location and protocol
					$protoc = explode(",", $page_loc);
					$page_location=$protoc[0];
						

					$locationValue1[$i1] = str_replace(' ', '', $locationValue[$i1]);
					$location_protoc = explode(",", $locationValue1[$i1]);
					$location_protocol = $location_protoc[1];				
					$location_animal = strpos($locationValue1[$i1],'mouse');					
							
							

					$protoc[1] = str_replace(' ', '', $protoc[1]);
					$protoc_pieces = explode("|", $protoc[1]);
					
					if($location_protocol == 'patchelectrode' && $protoc_pieces[1] != 'p')
					{
						$protoc_pieces[1] = 'p';
					}
					if($location_animal != null && $protoc_pieces[0] != 'm')
					{
						$protoc_pieces[0] = 'm';
					}
					$protocol = $protoc_pieces[0] . " | " . $protoc_pieces[1] . " | " . $protoc_pieces[2] . " | " . $protoc_pieces[3];
					$protocol = expand_protocol_text($protocol);	



					$articleevidencerel -> retrive_article_id($id_evidence_2[$i1]);
					$id_article = $articleevidencerel -> getarticle_id_array(0);
		
					$id_article_1[$i1] = $id_article;
		
					$article -> retrive_by_id($id_article);
					$pmid_isbn = $article -> getPmid_isbn();

		
					insert_temporary_ephysprotocol($name_temporary_table_ephys, $pmid_isbn, $protocol,$rep_value[$i1]);		
						
				}
		}

			// get the article associated with these fragments
			while(list($fp_id,$fp_fragment_id,$original_id,$fp_dt,$fp_quote,$fp_page_location,$fp_pmid_isbn,$id_article,$title,$publication,$year,$pmid_isbn,$first_page,$last_page,$pmcid,$nihmsid,$doi,$open_access,$citation_count,$volume,$issue,$interpretation,$interpretation_notes,$linking_pmid_isbn,$linking_pmid_isbn_page,$linking_quote,$linking_page_location,$istim,$tstim,$fp_original_name) = mysqli_fetch_row($fp_evidence_rs))	{	


				if ($title[$ui] == '.')
					$title[$ui] = '';	
				$articleauthorrel -> retrive_author_position($id_article);
				$n_author = $articleauthorrel -> getN_author_id();
				for ($ii3=0; $ii3<$n_author; $ii3++)
					$auth_pos[$ii3] = $articleauthorrel -> getAuthor_position_array($ii3);
					
				if ($auth_pos)	
					sort ($auth_pos);

				$query_to_get_protocol = "SELECT DISTINCT PMID,protocol,rep_value FROM $name_temporary_table_ephys";
				$fp_evidence_protocol = mysqli_query($GLOBALS['conn'],$query_to_get_protocol);
				//Compare PMID forr Protocol information
			
			
				while(list($pmid, $protocol, $rep_value)=mysqli_fetch_row($fp_evidence_protocol))
					{
						if($pmid == $pmid_isbn)
							{
								$protocol_insert = $protocol;
								$rep_value_insert = $rep_value;
							}
					} 

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
					$fp_quote = quote_replaceIDwithName($fp_quote);
					$interpretation = quote_replace_IDwithName($interpretation);
					$linking_quote = quote_replaceIDwithName($linking_quote);
					insert_temporary($name_temporary_table, $fp_id,$fp_fragment_id, $original_id, $fp_quote, $name_authors, $title, $publication, $year, $pmid_isbn, $pages, $fp_page_location, $protocol_insert, '0', '0', $pmcid, $nihmsid, $doi, $open_access, $citation_count, $volume, $issue,$id_neuron_fp,$interpretation,$interpretation_notes,$linking_pmid_isbn,$linking_pmid_isbn_page,$linking_quote,$linking_page_location,$istim,$tstim, $rep_value_insert, $fp_original_name);
				}
			}
					// find the total number of Articles: 
					$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1";
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$n_id_tot = 0;	 // Total number of articles:
					while(list($id) = mysqli_fetch_row($rs))			
						$n_id_tot = $n_id_tot + 1;

					// find the total number of quotes of type axon: 
					$query = "SELECT DISTINCT count(quote) as count FROM $name_temporary_table";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$total_count_all=0;
					 // total number of  quotes
					while(list($total_count) = mysqli_fetch_row($rs))	{		
						$total_count_all=intval($total_count);
					}
				
					$query = "SELECT DISTINCT count(quote) as count FROM $name_temporary_table WHERE show_only=1 ";	
					$rs = mysqli_query($GLOBALS['conn'],$query);
					$show_only_total_count_all=0;
					 // total number of show only quotes
					while(list($total_count) = mysqli_fetch_row($rs))	{		
						$show_only_total_count_all=intval($total_count);
					}
					
					if ($order_by == '-'){
						$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 LIMIT $page_in , 10";
					}
					else{
						$query = "SELECT DISTINCT title FROM $name_temporary_table WHERE show_only = 1 ORDER BY $order_by $type_order LIMIT $page_in , 10";
					}
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
						<td width='15%' align='left'>
								<font class='font2'>Animal:</font>
						
						<?php 
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_animal(this, $page_in, '10')\">");
						if ($name_show_animal)
						{
							if ($name_show_animal == 'All')
								$name_show_animal1 = 'All';
							if ($name_show_animal == 'Rats')
								$name_show_animal1 = 'Rats';								
							if ($name_show_animal== 'Mice')
								$name_show_animal1 = 'Mice';
							
							print ("<OPTION VALUE='$name_show_animal1'>$name_show_animal1</OPTION>");
							print ("<OPTION VALUE='All'>----</OPTION>");
						}
						?>
						<OPTION value='All'>All</OPTION>
						<OPTION value='Rats'>Rats</OPTION>
						<OPTION value='Mice'>Mice</OPTION>
						</td>
						
						<td width='25%' align='center'>
						<font class='font2'>Protocol:</font>
						<?php 
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_protocol(this, $page_in, '10')\">");
						if ($name_show_protocol)
						{
							if ($name_show_protocol == 'All')
								$name_show_protocol1 = 'All';
							if ($name_show_protocol == 'Patch_Clamp')
								$name_show_protocol1 = 'Patch Clamp';
							if ($name_show_protocol == 'Microelectrodes')
								$name_show_protocol1 = 'Microelectrodes';								
							
							print ("<OPTION VALUE='$name_show_protocol1'>$name_show_protocol1</OPTION>");
							print ("<OPTION VALUE='All'>----</OPTION>");
						}
						?>
						<OPTION value='All'>All</OPTION>
						<OPTION value='Patch_Clamp'>Patch Clamp</OPTION>
						<OPTION value='Microelectrodes'>Microelectrodes</OPTION>
						</td>
						
						
						<td width='20%' align='right'>
						<font class='font2'>Temperature:</font>
						
						<?php 
						print ("<select name='order' size='1' cols='10' class='select1' onChange=\"show_temperature(this, $page_in, '10')\">");
						if ($name_show_temperature)
						{
							if ($name_show_temperature == 'All')
								$name_show_temperature1 = 'All';
							if ($name_show_temperature == 'Body')
								$name_show_temperature1 = 'Body';								
							if ($name_show_temperature== 'Room')
								$name_show_temperature1 = 'Room';
							if ($name_show_temperature== 'Unknown')
								$name_show_temperature1 = 'Unknown';
							
							print ("<OPTION VALUE='$name_show_temperature1'>$name_show_temperature1</OPTION>");
							print ("<OPTION VALUE='All'>----</OPTION>");
						}
						?>
						<OPTION value='All'>All</OPTION>
						<OPTION value='Body'>Body</OPTION>
						<OPTION value='Room'>Room</OPTION>
						<OPTION value='Unknown'>Unknown</OPTION>
						</select>
						
						<td width="30%" align="right">
						<form action="property_page_fp.php" method="post" style="display:inline">
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
							<form action="property_page_fp.php" method="post" style="display:inline">
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
					$query = "SELECT DISTINCT id,fp_id, authors, publication, year, PMID, pages, page_location, show1, pmcid, nihmsid, doi, show_only, volume, issue FROM $name_temporary_table WHERE title = '$title_temp[$i]'  ";					
					$rs = mysqli_query($GLOBALS['conn'],$query);	
					$auth=array();	
					//print($query);	
					while(list($id,$fp_id, $authors, $publication, $year, $PMID, $pages, $page_location, $show, $pmcid, $nihmsid, $doi, $show_only, $volume, $issue) = mysqli_fetch_row($rs))
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
				
						print(" <td width='5%' align='center' class='table_neuron_page2' valign='center'> ");
						if ($show1 == 0)
						{
							print ("<form action='property_page_fp.php' method='post' style='display:inline'>");
							print ("<input type='submit' name='show_1' value=' ' class='show1' title='Show Evidence' alt='Show Evidence'>");
							print ("<input type='hidden' name='start' value='$page_in' />");
							print ("<input type='hidden' name='stop' value='$page_end' />");
							print ("<input type='hidden' name='title' value='$title_temp[$i]'>");
							print ("<input type='hidden' name='name_show_only' value='$name_show_only'>");
							print ("</form>");
						}
						if ($show1 == 1)
						{
							print ("<form action='property_page_fp.php' method='post' style='display:inline' title='Close Evidence' alt='Close Evidence'>");
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
							$query = "SELECT id_fragment,fp_id, id_original,id_neuron,interpretation,interpretation_notes,linking_pmid_isbn,linking_pmid_isbn_page,linking_quote,linking_page_location, quote, page_location, protocol, istim,tstim, rep_value, fp_original_name FROM $name_temporary_table WHERE title = '$title_temp[$i]' group by id_fragment ";	
							//print($query);
							$rs = mysqli_query($GLOBALS['conn'],$query);	
							while(list($id_fragment,$fp_id, $id_original,$id_neuron_fp,$interpretation,$interpretation_notes,$linking_pmid_isbn,$linking_pmid_isbn_page,$linking_quote,$linking_page_location, $quote, $page_location, $protocol, $istim, $tstim, $rep_value, $fp_original_name) = mysqli_fetch_row($rs))
							{	
								//print($fp_id);
								$quote_count++;	
								if ($show1 == 1)
								{		
									//print ("<table width='80%' border='0' cellspacing='2' cellpadding='5' style='display:table' class='known'>");
									//print ("<tr><td width='15.5%' rowspan='3' align='right' valign='top' style='display:table-cell'> </td>");	
									print ("<table width='80%' border='0' cellspacing='2' cellpadding='5'>");
									print ("<tr>");
									print ("<td width='15%' rowspan='11' align='right' valign='top'></td>");
									print ("<td width='15%' align='left'> </td></tr>");									   
									// retrieve the attachament from "attachment" with original_id and cell-id(id_neuron)
									$attachment_obj -> retrive_attachment_by_original_id($id_original, $id_neuron_fp);
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
									
									if($attachment_type=="fp_figure"||$attachment_type=="fp_table"){
										$link_figure = "attachment/fp/".$attachment_jpg;
									}
									
									$attachment_pdf = str_replace('jpg', 'pdf', $attachment);
									$link_figure_pdf = "figure_pdf/".$attachment_pdf;

									print ("
											<tr>
											<td width='70%' class='table_neuron_page2' align='left'>
											Page location: <span title='$id_fragment (original: $id_original)'>$page_location</span>
											</td>
											<td width='15%' align='center'>");

							// Display protocol, if any.
							
									if ($protocol) {
										if ($rep_value != NULL) {
											print("</td></tr>
											<tr>
											<td width='70%' class='table_neuron_page2' style='background-color:#AAAAAA' align='left'>
											Protocol: <span>$protocol *preferred conditions* </span>
											</td><td width='15%' align='center'>");
										}
									else {
										print("</td></tr>
										<tr>
										<td width='70%' class='table_neuron_page2' style='background-color:#AAAAAA' align='left'>
										Protocol: <span>$protocol</span>
										</td><td width='15%' align='center'>");
										}									
									}
							


										if ($istim||$tstim) {
											print ("</td></tr>
												<tr>
												<td width='70%' class='table_neuron_page2' align='left'>Parameters:");
												if($tstim && trim($tstime)!='no value') {
													print (" Tstim = <span>".floor($tstim)." ms</span>");
													if($istim && trim($istim)!='no value') 
														print(",");
													
												} 
												if($istim && trim($istim)!='no value') {
													print (" Istim = <span>".floor($istim)." pA</span>");
												}
												print ("<span style='float:right;cursor: pointer;text-align:right' align='right' id='flip_$fp_id'> View All Parameters</span></br>");
												print("<div class='panel' id='panel_$fp_id'> ");
												print("<table width='100%' border='1' cellspacing='2' cellpadding='3'>");
												print("<tr><th width='80%'>Name</th><th width='20%'>Value</th></tr>");
												// retrive parameters
												
												$query_for_view_flag="SELECT * FROM FiringPattern WHERE overall_fp='$parameter' AND definition_parameter like 'definition'";
												$query_for_values="SELECT * FROM FiringPattern WHERE id=$fp_id";
												$query_for_description="SELECT * FROM FiringPattern WHERE id=3";
												$query_for_units="SELECT * FROM FiringPattern WHERE id=4";
												$query_for_digits="SELECT * FROM FiringPattern WHERE id=5";
												$query_for_name="SELECT * FROM FiringPattern WHERE id=1";
												
												$result_view_flag = mysqli_query($GLOBALS['conn'],$query_for_view_flag);
												$result_values = mysqli_query($GLOBALS['conn'],$query_for_values);
												$result_description = mysqli_query($GLOBALS['conn'],$query_for_description);
												$result_units = mysqli_query($GLOBALS['conn'],$query_for_units);
												$result_digits = mysqli_query($GLOBALS['conn'],$query_for_digits);
												$result_name = mysqli_query($GLOBALS['conn'],$query_for_name);
												
												$row_view_flag=mysqli_fetch_array($result_view_flag, MYSQLI_BOTH);
												$row_values=mysqli_fetch_array($result_values, MYSQLI_BOTH);
												$row_description=mysqli_fetch_array($result_description, MYSQLI_BOTH);
												$row_units=mysqli_fetch_array($result_units, MYSQLI_BOTH);
												$row_digits=mysqli_fetch_array($result_digits, MYSQLI_BOTH);
												$row_name=mysqli_fetch_array($result_name, MYSQLI_BOTH);
												
												for($index=3;$index<count($row_name);$index++){
													if($row_view_flag[$index] and $row_view_flag[$index]!='definition' ){
														$value_of_parameter=$row_values[$index];
														if(trim($value_of_parameter)!='' and trim($value_of_parameter)!="no value" ){
															print("<tr>");
															print("<td width='80%' align='left'>");
															print($row_name[$index]);
															if($row_description[$index])
																print(" [".$row_description[$index]."] ");
															print("</td>");
															print("<td width='20%' align='left'>");
															if(trim($value_of_parameter)!='' and trim($value_of_parameter)!="no value" ){
																if(is_numeric($value_of_parameter)){
																	$value_of_parameter=number_format((float)$value_of_parameter,$row_digits[$index], '.', '');
																	print($value_of_parameter);
																	if($row_units[$index])
																		print(" ".$row_units[$index]);
																}
															}
															print("</td>");
															print("</tr>");
														}
													}

												}
												print("</table>");
												print("<div></td><td width='15%' class='table_neuron_page2' align='center'>");
												print ("<a href='download_spike_data.php?id=$fp_id' target='_blank'>");
												print ("<img src='images/ExportISI.png' border='0' width='50%'>");
												print ("</br>ISI Data </a>");
										}

										// Material methods
										//  "Show all animal data", "Show all preparation data", "Show all ACSF data", "Show all recording method data
										// array(7,12,15,35)
										if ($istim||$tstim) {
											// get data for material method
											$query_for_material="SELECT * FROM MaterialMethod WHERE istim_pa = '$istim' AND tstim_ms= '$tstim' AND overall_fp = '$parameter' AND unique_id = $id_neuron";
											//print($query_for_material);
											$query_for_description="SELECT * FROM MaterialMethod WHERE id=1";
											
											$result_material = mysqli_query($GLOBALS['conn'],$query_for_material);
											$result_description = mysqli_query($GLOBALS['conn'],$query_for_description);
											
											$row_material=mysqli_fetch_array($result_material, MYSQLI_BOTH);
											$row_description=mysqli_fetch_array($result_description, MYSQLI_BOTH);

											$material_method = array("Animal Data"=>8, "Preparation Data"=>13, "ACSF Data"=>16, "Recording Method Data"=>34);
											$material_method_index = array(8, 13, 16, 34, 62);
											$start = 0;
											foreach ($material_method as $key => $value) {

												print ("</td></tr>
													<tr>
													<td width='70%' class='table_neuron_page2' align='left'>$key:");
												print ("<span style='float:right;cursor: pointer;text-align:right' align='right' id='flip_".$start."_$fp_id'> View All $key</span></br>");
												print("<div class='panel' id='panel_".$start."_$fp_id'> ");
												print("<table width='100%' border='1' cellspacing='2' cellpadding='3'>");
												print("<tr><th width='80%'>Name</th><th width='20%'>Value</th></tr>");
												// retrive parameters
												
												for($index = $value; $index < $material_method_index[$start+1]; $index++){
													if($row_material[$index]){
														$value_of_parameter=$row_material[$index];
														if(trim($value_of_parameter)!='' and trim($value_of_parameter)!="no value" ){
															print("<tr>");
															print("<td width='80%' align='left'>");
															print($row_description[$index]);
															print("</td>");
															print("<td width='20%' align='left'>");
															if(trim($value_of_parameter)!='' and trim($value_of_parameter)!="no value" ){
																print($value_of_parameter);
															}
															print("</td>");
															print("</tr>");
														}
													}

												}
												print("</table>");
												print("<div></td><td width='15%' class='table_neuron_page2' align='center'> ");
												$start = $start + 1;
											}
										}

										// fp_original_name Author original FP description

										if ($fp_original_name) {
											print ("</td></tr>
												<tr>
												<td width='70%' class='table_neuron_page2' align='left'>Author original FP description: ");
												print($fp_original_name);
												print("</td><td width='15%' align='center'>");
										}
										// Display Linking information, if any.linking_cell_id, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location
										if ($linking_pmid_isbn||$linking_pmid_isbn_page||$linking_quote||$linking_page_location) {
											print ("</td></tr>
													<tr>
													<td width='70%' class='table_neuron_page2' align='left'>");
											//if($linking_cell_id)
												//print ("Linking cell ID: <span>$linking_cell_id</span>");
											if($linking_pmid_isbn){
											
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
												//print ("<br>Linking Quote: <span>$linking_quote</span>");
												
												$evidencepropertyyperel -> retrieve_morphology_evidence_id_by_type_and_pmid_isbn($id_neuron, $linking_pmid_isbn);
												$n_evidence_id = $evidencepropertyyperel -> getN_evidence_id();
												$linking_quote_url_to_property_page_morphology_linking_pmid_isbn =
													"<a href='property_page_morphology_linking_pmid_isbn.php?id_neuron=$id_neuron&linking_pmid_isbn=$linking_pmid_isbn&page=1'>$linking_quote</a>";
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
										print ("</td></tr>	
										<tr>		
											<td width='70%' class='table_neuron_page2' align='left'>
												<em>$quote</em>
											</td>
											<td width='15%' class='table_neuron_page2' align='center'>");
							
										if ($attachment_type=="fp_figure"||$attachment_type=="fp_table")
										{
											//print($link_figure);
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
								$query = "SELECT quote FROM $name_temporary_table";
								$rs = mysqli_query($GLOBALS['conn'],$query);			
								while(list($quote) = mysqli_fetch_row($rs))
								{
									$cnt++;
								}
								if($n_id_tot!=0){
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
						
						<form action="property_page_fp.php" method="post" style="display:inline">
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
						<form action="property_page_fp.php" method="post" style="display:inline">
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

<?php
	include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php	
require_once('class/class.temporary_neuronterm.php');
require_once('class/class.term.php');
require_once('class/class.type.php');
require_once('class/class.synonym.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.articleevidencerel.php');
require_once('class/class.articleauthorrel.php');
require_once('class/class.article.php');
require_once('class/class.author.php');
require_once('class/class.synonymtyperel.php');

$articleevidencerel = new articleevidencerel($class_articleevidencerel);
$temporary = new temporary_neuronterm();
$term = new term($class_term);
$type_1 = new type($class_type);
$synonym_1 = new synonym($class_synonym);	
$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);
$article = new article($class_article);
$author = new author($class_author);
$articleauthorrel = new articleauthorrel($class_articleauthorrel);
$synonymtyperel = new synonymtyperel($class_synonymtyperel);
$term_last = '';

// Resume searching
if ($_REQUEST['resume_searching_tab'])
{
	$resume_searching = $_SESSION['resume_searching'];	
	$name_temporary_table = $resume_searching;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	$temporary->setName_table($name_temporary_table);
}

// Creates the temporary table for the search 
if ($_REQUEST['searching'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	$temporary->setName_table($name_temporary_table);
	$temporary->create_temp_table ($name_temporary_table);
	$temporary->insert_temporary('all', '');
	$temporary_search = 0;
}

// New Request
if($_REQUEST['new'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	$temporary->setName_table($name_temporary_table);
	$temporary->create_temp_table ($name_temporary_table);
	$temporary->insert_temporary($_GET["first_neuron"], $_GET["name_neuron"]);
	$temporary_search = 0;
}

// update the letter in the temporary table: 
$letter = $_REQUEST['letter'];
if ($letter)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];

	// retrieve all neuron terms
	$term->retrive_name();
	$n_neuron_total_term = $term->getName_neuron();

	// keep only those neuron terms that have the first letter = $letter:
	$trm_neuron = array();
	$n_neuron3 = 0;
	for ($i1=0; $i1<$n_neuron_total_term; $i1++)
	{
		$name_trm_neuron = $term->getName_neuron_array($i1);		
		if ($letter == 'all')
		{
			$trm_neuron[$n_neuron3] = $name_trm_neuron;
			$n_neuron3 = $n_neuron3 + 1;			
		}
		else if (strtolower($name_trm_neuron[0]) == strtolower($letter))
		{
			$trm_neuron[$n_neuron3] = $name_trm_neuron;
			$n_neuron3 = $n_neuron3 + 1;
		}    						
	}
	$temporary->setName_table($name_temporary_table);
	if ($n_neuron3 > 0)
	{
		$temporary->update_temporary($letter, $trm_neuron[0], 1, $id_update);
	}
	else
	{
		$temporary->update_temporary($letter, '', 1, $id_update);
	}
	//sort($trm_neuron);
	$temporary_search = 0;
}

$neuron5 = $_REQUEST['neuron'];
if ($neuron5)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];
	$temporary->setName_table($name_temporary_table);
	$temporary->update_temporary(NULL, $neuron5, 2, $id_update);
	$temporary_search = 1;
}

// ADD a new line for a new Author: --------------------------------------------------------------------
if ($_REQUEST['plus'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary->setName_table($name_temporary_table);
	$temporary->insert_temporary('all', '');
	$temporary_search = 0;	
}

// REMOVE line  -----------------------------------------------------------------------------------------
if ($_REQUEST['remove'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$id_temp = $_REQUEST['id'];
	$temporary->remove($id_temp);
	$temporary_search = 1;
}

// Show result --------------------------------------------------------------------------------------------
if ($_REQUEST['see_result'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary->setName_table($name_temporary_table);
	$temporary_search = 1;
}
if ($temporary_search == 1)
{
	$temporary->retrieve_id();
	$n_id = $temporary->getN_id();
}

// Clear all ---------------------------------------------
if ($_REQUEST['clear_all'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$query = "TRUNCATE $name_temporary_table";
	$rs = mysqli_query($GLOBALS['conn'],$query);
	// Creates the temporary table:
	$temporary->setName_table($name_temporary_table);	
	$temporary->insert_temporary('all', '');
}
// -------------------------------------------------------
?>

<script type="text/javascript">
// Javascript function *****************************************************************************************************
function letter(link, id_1)
{
	var letter=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_neuron_term.php";
	location.href = destination_page+"?letter="+letter+"&id="+id;
}

function neuron(link, id_1)
{
	var neuron=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_neuron_term.php";
	location.href = destination_page+"?neuron="+neuron+"&id="+id;
}

function term_event(term_parm, term_id)
{
	var neuron = term_parm;
	var id = term_id;
	
	var destination_page = "find_neuron_term.php";
	location.href = destination_page+"?neuron="+neuron+"&id="+id;
}
</script>

<?php include ("function/icon.html"); ?>
<title>Neuron ID</title>
<script type="text/javascript" src="style/resolution.js"></script>
<script src="DataTables-1.9.4/media/js/jquery.js" type="text/javascript"></script>
<script src="DataTables-1.9.4/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table_jui.css"/>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#tab_res').dataTable({
		"sPaginationType":"full_numbers",
		"bJQueryUI":true,
		"oLanguage": {
			"sSearch": "Search for keywords inside the table:"
		},
		"iDisplayLength": 25
	});
});
</script>

</head>
<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
	
<div class='title_area'>
	<font class="font1">Search Neuron Term for Machine-Readable Definition Identifier</font>
</div>	

<div class="table_position_search_page" >
	<!-- ****************  BODY **************** -->
	<?php
		//if ($temporary_search == 1)
		//{
		//	if ($n_id == 1)
		//		print ("<font class='font12'>$n_id Neuron Term has been selected</font>");
		//	else if ($n_id > 1)
		//		print ("<font class='font12'> $n_id Neuron Terms have been selected</font>");
		//	else
		//		print ("<font class='font12'> 0 Neuron Terms have been selected</font>");
		//}
	?>
	<table border='0' cellspacing='3' cellpadding='0' class='table_search' width='100%'>
		<tr>
			<td align="center" width="6%" class='table_neuron_page3'>Initial</td>
		 	<td align="center" width="45%" class='table_neuron_page3'>Neuron Term - Selector</td>
		 	<td align="center" width="45%" class='table_neuron_page3'>Neuron Term - Autocomplete</td>
			<td align="center" width="2%" class='table_neuron_page3'>+OR</td>
			<td align="center" width="2%" class='table_neuron_page3'> - </td>
		</tr>
		<!-- tr -->
		<?php
			$temporary->retrieve_id();
			$n_search = $temporary->getN_id();
			for ($i=0; $i<$n_search; $i++)
			{
				print("<tr><td align='center' width='6%' class='table_neuron_page1'>");
				$id = $temporary->getID_array($i);
				print("<select name='letter1' size='1' class='select1' onChange='letter(this, $id)'>");
				$temporary->retrieve_letter_from_id($id);
				$letter_t = $temporary->getLetter();
				if ($letter_t)
				{
					if ($letter_t == 'all')
						$letter_t = 'all';
					print("<OPTION VALUE='$letter_t'> $letter_t </OPTION>");					
				}
				print(" <OPTION VALUE='A'> A </OPTION>			
					<OPTION VALUE='B'> B </OPTION>
					<OPTION VALUE='C'> C </OPTION>
					<OPTION VALUE='D'> D </OPTION>
					<OPTION VALUE='E'> E </OPTION>
					<OPTION VALUE='F'> F </OPTION>
					<OPTION VALUE='G'> G </OPTION>
					<OPTION VALUE='H'> H </OPTION>
					<OPTION VALUE='I'> I </OPTION>
					<OPTION VALUE='J'> J </OPTION>
					<OPTION VALUE='K'> K </OPTION>
					<OPTION VALUE='L'> L </OPTION>
					<OPTION VALUE='M'> M </OPTION>
					<OPTION VALUE='N'> N </OPTION>
					<OPTION VALUE='O'> O </OPTION>
					<OPTION VALUE='P'> P </OPTION>
					<OPTION VALUE='Q'> Q </OPTION>
					<OPTION VALUE='R'> R </OPTION>
					<OPTION VALUE='S'> S </OPTION>
					<OPTION VALUE='T'> T </OPTION>
					<OPTION VALUE='U'> U </OPTION>
					<OPTION VALUE='V'> V </OPTION>
					<OPTION VALUE='W'> W </OPTION>			
					<OPTION VALUE='X'> X </OPTION>
					<OPTION VALUE='Y'> Y </OPTION>
					<OPTION VALUE='Z'> Z </OPTION>		
					<OPTION VALUE='all'> all </OPTION>					
					</select></td>"
				);

				// retrieve all terms from table 'Term'
				$term->retrive_name();
				$n_neuron_total_term = $term->getName_neuron();

				// keep only the neuron terms from table 'Term' that have the first letter = $letter_t:
				$trm_neuron = array();
				$n_neuron3 = 0;
				for ($i1=0; $i1<$n_neuron_total_term; $i1++)
				{
					$name_trm_neuron = $term->getName_neuron_array($i1);		
					if ($letter_t == 'all')
					{
						$trm_neuron[$n_neuron3] = $name_trm_neuron;
						$n_neuron3 = $n_neuron3 + 1;
					}
					else if (strtolower($name_trm_neuron[0]) == strtolower($letter_t))
					{
						$trm_neuron[$n_neuron3] = $name_trm_neuron;
						$n_neuron3 = $n_neuron3 + 1;
					}
				}
				//sort($trm_neuron);

				$temporary->retrieve_neuron_from_id($id);
				$name_neuron_right = $temporary->getNeuron();
				$term_last = $temporary->getNeuron();
				$result = $trm_neuron;
				$total = $n_neuron3;

				// Selector
				print("<td align='left' width='45%'class='table_neuron_page1'>");
				print("<select name='neuron1' size='1' class='select1' value='$term_last' onChange='neuron(this,$id)' style='width:450px'>");
				$temp_neuron = htmlspecialchars($name_neuron_right,ENT_QUOTES);	
				echo"<option value='".$temp_neuron."'>".stripslashes($name_neuron_right)."</option>";
				print("<OPTION VALUE='' disabled></OPTION>");
				if ($total == 0)
				{
					print("<OPTION VALUE=''>-</OPTION>");
				}	
				else
				{
					for ($k1=0; $k1<$total; $k1++)
					{
						$temp_neuron = htmlspecialchars($result[$k1],ENT_QUOTES);
						echo"<option value='".$temp_neuron."'>".$result[$k1]."</option>";
					}
				}
				print("</select>");
				print("</td>");

				// Autocomplete
				print("<td align='left' width='45%' class='table_neuron_page1'>");				
				print("<datalist id='term_list'>");
				for ($k1=0; $k1<$total; $k1++)
				{
					$temp_neuron = htmlspecialchars($result[$k1],ENT_QUOTES);
					echo"<option value='".$temp_neuron."'>".$result[$k1]."</option>";
				}
				print("</datalist>");
				print("<input type='text' list='term_list' name='neuron1' class='select1' value='$term_last' onChange='term_event(value,$id)' style='width:450px' autocomplete='on' autofocus>");
				print("</td>");

				// AND term controls i.e. the plus and minus sign buttons
				print("<td align='center' width='2%'>
					<form action='find_neuron_term.php' method='post' style='display:inline'> 
					<input type='submit' name='plus' value=' + ' class='more_button'></form></td>"
				);
				if ($i > 0)		 
					print("</td><td align='center' width='2%'>
						<form action='find_neuron_term.php' method='post' style='display:inline'> 
						<input type='submit' name='remove' value=' - ' class='more_button'>
						<input type='hidden' name='id' value='$id'></form></td>"
					);
				else
					print("</td><td align='center' width='2%'></td>");

			} //END for ($i=0; $i<$n_search; $i++)
		?>
		</tr>
	</table>
	<div align="left" >
	<table width='100%'>
		<tr>
			<td width='6%'>
				<form action="find_neuron_term.php" method="post" style='display:inline'>	
					<input type='submit' name='clear_all' value='RESET' />
				</form>
			</td>
			<td width='45%' style='width:450px'>
				<form action="find_neuron_term.php" method="post" style='display:inline'>	
					<input type='submit' name='see_result' value='SEE RESULTS' />
				</form>
			</td>
			<td width='45%' style='width:450px'>
				<form action='find_neuron_term.php' method='post' style='display:inline'> 
					<input type='submit' name='see_result' value='SET SELECTOR' />
				</form>
			</td>
			<td width='4%' style='width:300px'>
			</td>
		</tr>
	</table>

	<?php
		if ($_REQUEST['see_result'])
		{
			print("<table border='0'  class='table_result' id='tab_res' width='100%'>");
			print("<thead><tr>
				<th style='display:none;' align='center' width=' 5%' class='table_neuron_page1'> <strong>Rank</strong></th></font>
				<th align='center' width='15%' class='table_neuron_page1'> <strong>Term</strong></th></font>
				<th align='center' width='15%' class='table_neuron_page1'> <strong>Concept</strong></th></font>
				<th align='center' width='10%' class='table_neuron_page1'> <strong>Resource</strong></th></font>
				<th align='center' width='55%' class='table_neuron_page1'> <strong>Definition</strong></th></font>
				</tr></thead><tbody>"
			);
			$temporary->retrieve_id();
			$n_id = $temporary->getN_id();
			for ($j1=0; $j1<$n_id; $j1++)
			{
				$name_trm_neur[$j1] = $temporary->getNeuron_array($j1);
				$name_neuron = $name_trm_neur[$j1];
				$term->retrive_name();
				$n_total_name = $term->getName_neuron();	
				for ($i2=0; $i2<$n_total_name; $i2++)
				{
					if ($name_neuron == $term->getName_neuron_array($i2))
					{
						$term->retrive_id_by_name($name_neuron);
						$n_term_id = $term->getN_id();
						$concept_title='';
						$terms_concept = '';
						$parents_concept = '';
						for ($k3=0; $k3<$n_term_id; $k3++)
						{
							$id_term = $term->getID_array($k3);
							$term->retrive_by_id($id_term);
							$term_parent = $term->getParent();
							$term_concept = $term->getConcept();
							//$term_term = $term->getTerm();
							$term_term = $name_neuron; // overide database term with selector term
							$term_resource_rank = $term->getResourceRank();
							$term_resource = $term->getResource();
							$term_portal = $term->getPortal();
							$term_repository = $term->getRepository();
							$term_unique_id = $term->getUniqueID();
							$term_definition_link = $term->getDefinitionLink();
							$term_definition = $term->getDefinition();
							$term_protein_gene = $term->getProteinGene();
							$term_human_rat = $term->getHumanRat();
							$term_term_display = '';
							$term_concept_display = '';
							if ($k3 == 0) {
								$term_term_display = $term_term;
								$term_concept_display = $term_concept;
							}
							print("	<tr>
								<td style='display:none;' align='center' width=' 5%' class='table_neuron_page4'>$term_resource_rank</td>
								<td align='center' width='15%' class='table_neuron_page4'>$term_term_display</td>
								<td id='concept' align='center' width='15%' class='table_neuron_page4' title=''>$term_concept_display</td>
								<td align='center' width='10%' class='table_neuron_page4'><a href='$term_definition_link' target='_blank'><font class='font13'>$term_resource</font></a></td>
								<td align='left' width='55%' class='table_neuron_page4'>$term_definition</td>
								</tr>"
							);
						}
						$terms_concept = $term->retrive_term_concept($term_concept);
						$value = '';
						$allTerms = '';
						if (!empty($terms_concept)) {
							foreach ($terms_concept as $value) {
								$allTerms .= $value.",".$allTerms;
							}
						}
						$allTerms = trim(implode(',',array_unique(explode(',', $allTerms))), ",");
						$allTerms = 'Synonym(s):\r\n    '.str_replace(",",'\r\n    ',$allTerms);
						$parents_concept = $term->retrive_parent_concept($term_concept);
						$value = '';
						$allParents = '';
						if (!empty($parents_concept)) {
							foreach ($parents_concept as $value) {
								$allParents .= $value.",".$allParents;
							}
						}
						$allParents = trim(implode(',',array_unique(explode(',', $allParents))), ",");
						$allParents = 'Term Source(s):\r\n    '.str_replace(",",'\r\n    ',$allParents);
						$concept_title = $allParents.'\r\n'.$allTerms;
						?>
						<script language="javascript">
							$('#concept').attr('title', '<?php echo $concept_title;?>');
						</script>
						<?php
					}
				} //END for ($i2=0; $i2<$n_total_name; $i2++)
			} //END for ($j1=0; $j1<$n_id; $j1++)
			print("</tbody></table>");
		}
	?>
	<br /><br />
	</div>
</div>

</body>
</html>

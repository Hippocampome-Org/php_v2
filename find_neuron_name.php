<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
require_once('class/class.utils_type.php');
require_once('class/class.utils_neuron_search.php');
require_once('class/class.utils_author_article.php');

$search_temporary_table='neuron_temporary_table';
$defualt_neuron_name='CA1 (e)2201 Radiatum Giant';
$default_neuron_id='4054';
$default_neuron_letter='C';

$temporary = new utils_neuron_search();
	
// Resume searching.
if ($_REQUEST['resume_searching_tab'])
{
	$resume_searching = $_SESSION['resume_searching'];	
	$name_temporary_table = $resume_searching;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
}

// Creates the temporary table for the search. 
if ($_REQUEST['searching'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary -> set_table_name ($name_temporary_table);
	$temporary -> create_temp_table ();
	$temporary -> insert_temporary($default_neuron_id,$default_neuron_letter,$defualt_neuron_name);
}
// New request.
if($_REQUEST['new'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary -> set_table_name ($name_temporary_table);
	$temporary -> create_temp_table ();
	$temporary -> insert_temporary($default_neuron_id,$_GET["first_neuron"], $_GET["name_neuron"]);
	
}
// Dropdown for letter is changed hence fetch all neuron name starting with that letter and insert first neuron name in temporary table. If no neuron name found display '-'
if ($_REQUEST['letter'])
{
	// if no neuron name found starting with letter then put -1 as type_id and '-' as searched neuron name.
	$neuron_name_update="-";
    $type_id_update="-1";
	$letter = $_REQUEST['letter'];
	$id_update = $_REQUEST['id'];
	// fetch all neuron name starting with letter and display first one.
	$utils_type=new utils_type();
    $type_or_synonym_array=$utils_type->retriveNeuronsWithLetter($letter);
    if(sizeof($type_or_synonym_array)>0){
    	$neuron_name_update=$type_or_synonym_array[0]->getName();
		$type_id_update=$type_or_synonym_array[0]->getId();
	}
	$temporary -> set_table_name ($_SESSION[$search_temporary_table]);
	// update record in temporary table at index $id_update with neuron id as $type_id_update, letter as $letter and name as $neuron_name_update.
	$temporary -> update_temporary($id_update,$type_id_update,$letter,$neuron_name_update,1);
}
// Dropdown for neuron name is changed hence get the new neuron name from option and update name, letter and type_id in the temporary table.
if ($_REQUEST['neuron'])
{
	$neuron_name = $_REQUEST['neuron'];
	$id_update = $_REQUEST['id'];
	$type_id_update = $_REQUEST['type_id'];
	$temporary ->set_table_name($_SESSION[$search_temporary_table]);
	// update record in temporary table at index $id_update with neuron id as $type_id_update and name as $neuron. Letter will remain same, hence NULL is passed
	$temporary -> update_temporary($id_update,$type_id_update,NULL, $neuron_name,2);
}
// Add new search neuron record at last index with default search neuron name and letter.
if ($_REQUEST['plus'])
{
	$temporary ->set_table_name($_SESSION[$search_temporary_table]);
	$temporary -> insert_temporary($default_neuron_id,$default_neuron_letter,$defualt_neuron_name);
}

// Remove search nueron record at specified index($id).
if ($_REQUEST['remove'])
{
	$temporary ->set_table_name($_SESSION[$search_temporary_table]);
	$id = $_REQUEST['id'];
	$temporary -> remove($id);
}

// Show result. 
if ($_REQUEST['see_result'])
{
	$name_temporary_table = $_SESSION[$search_temporary_table];
	$temporary ->set_table_name($name_temporary_table);
}

// Flush temporary table by removing all records.
if ($_REQUEST['clear_all'])
{
	$temporary->set_table_name($_SESSION[$search_temporary_table]);
	$temporary->flushTempNeuronSearchTable();
	// Creates the temporary table.
	$temporary -> insert_temporary($default_neuron_id,$default_neuron_letter,$defualt_neuron_name);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<script type="text/javascript">
	// Javascript function 
	// Dropdown for letter is changed.
	function letter(link, id)
	{
		var letter=link[link.selectedIndex].value;
		var destination_page = "find_neuron_name.php";
		location.href = destination_page+"?letter="+letter+"&id="+id;
	}
	// Dropdown for neuron name is changed. 
	function neuron(link, id)
	{
		var neuron=link[link.selectedIndex].value;	
		var type_id=link[link.selectedIndex].getAttribute('data-id');
		var destination_page = "find_neuron_name.php";
		location.href = destination_page+"?neuron="+neuron+"&id="+id+"&type_id="+type_id;
	}
</script>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php include ("function/icon.html"); ?>
	<title>Find Neuron Name/Synonym</title>
	<script type="text/javascript" src="style/resolution.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
		<font class="font1">Search Neuron Name/Synonym</font>
	</div>	
	<div class="table_position_search_page" >
		<table border="0" cellspacing="3" cellpadding="0" class='table_search' width='100%'>
			<tr >
		      <td align="center" width="6%" class='table_neuron_page3'>Initial</td>
		      <td align="center" width="45%" class='table_neuron_page3'>Neuron Name/Synonym - Selector</td>
		      <td align="center" width="2%" class='table_neuron_page3'>+OR</td>
		      <td align="center" width="2%" class='table_neuron_page3'> - </td>
			</tr>
			<?php
			$temporary=new utils_neuron_search();
			$searched_neuron_array=$temporary->retriveSearchedNeurons();
			for ($i=0; $i<sizeof($searched_neuron_array); $i++)
			{
				$type_id = $searched_neuron_array[$i]->get_type_id();
		        $id = $searched_neuron_array[$i]->get_id();
		        $letter=$searched_neuron_array[$i]->get_letter();
		        $name=$searched_neuron_array[$i]->get_neuron();
		     	$utils_type=new utils_type();
		     	$type_or_synonym_array=$utils_type->retriveNeuronsWithLetter($letter);
		     	print ("<tr><td align='center' width='6%' class='table_neuron_page1'>");
				print ("<select name='letter1' size='1' class='select1' onChange='letter(this, $id)'>");
				if ($letter)
				{
					if ($letter == 'all')
						$letter  = 'all';
					print ("<OPTION VALUE='$letter'> $letter </OPTION>");					
				}
				print ("
					<OPTION VALUE='A'> A </OPTION> <OPTION VALUE='B'> B </OPTION> <OPTION VALUE='C'> C </OPTION> <OPTION VALUE='D'> D </OPTION>
					<OPTION VALUE='E'> E </OPTION> <OPTION VALUE='F'> F </OPTION> <OPTION VALUE='G'> G </OPTION> <OPTION VALUE='H'> H </OPTION>
					<OPTION VALUE='I'> I </OPTION> <OPTION VALUE='J'> J </OPTION> <OPTION VALUE='K'> K </OPTION> <OPTION VALUE='L'> L </OPTION>
					<OPTION VALUE='M'> M </OPTION> <OPTION VALUE='N'> N </OPTION> <OPTION VALUE='O'> O </OPTION> <OPTION VALUE='P'> P </OPTION>
					<OPTION VALUE='Q'> Q </OPTION> <OPTION VALUE='R'> R </OPTION> <OPTION VALUE='S'> S </OPTION> <OPTION VALUE='T'> T </OPTION>
					<OPTION VALUE='U'> U </OPTION> <OPTION VALUE='V'> V </OPTION> <OPTION VALUE='W'> W </OPTION> <OPTION VALUE='X'> X </OPTION>
					<OPTION VALUE='Y'> Y </OPTION> <OPTION VALUE='Z'> Z </OPTION> 
					<OPTION VALUE='all'> all </OPTION>					
					</select>
				</td>");
				
				// retrieve all Names, Nicknames from table 'Type' and Names from table 'Synonym':	
				print ("<td align='center' width='45%' class='table_neuron_page1'>");				
				print ("<select name='neuron1' size='1' class='select1' onChange='neuron(this, $id)' style='width:450px'>");					
				if ($name)
				{
					$temp_neuron= htmlspecialchars($name,ENT_QUOTES);	
					echo "<option value='".$temp_neuron." data-id=".$type_id."'>".stripslashes($name)."</option>";
					print ("<option value='' disabled></option>");
				}	
				if (sizeof($type_or_synonym_array) == 0)
					print ("<option VALUE='-'>-</option>");
				else
				{
					for ($j=0; $j<sizeof($type_or_synonym_array); $j++)
					{
						$neuron_name=$type_or_synonym_array[$j]->getName();
						$neuron_id=$type_or_synonym_array[$j]->getId();
						$temp_neuron= htmlspecialchars($neuron_name,ENT_QUOTES);	
		                echo "<option value='".$temp_neuron."' data-id='".$neuron_id."'>".$neuron_name. "</option>";
					}
					
				}
				print ("</select>");
				print ("</td><td align='center' width='2%'>
							<form action='find_neuron_name.php' method='post' style='display:inline'> 
							<input type='submit' name='plus' value=' + ' class='more_button'>
							</form>
						 </td>");
									
				if ($i > 0)		 
					print ("</td><td align='center' width='2%'>
							<form action='find_neuron_name.php' method='post' style='display:inline'> 
							<input type='submit' name='remove' value=' - ' class='more_button'>
							<input type='hidden' name='id' value='$id'>
							</form>
							</td>");
				else
					print ("</td><td align='center' width='2%'> </td>");
				
			}
			?>
			</tr>
		</table>
		<div align="left" >
		<table width='100%'>
			<tr>
				<td width='6%'>
					<form action="find_neuron_name.php" method="post" style='display:inline'>	
					<input type='submit' name='clear_all' value='RESET' />
					</form>
				</td>
				<td width='45%' style='width:450px'>
					<form action='find_neuron_name.php' method='post' style='display:inline'> 
					<input type="submit" name='see_result' value='SEE RESULTS' />
					</form>
				</td>
				<td width='4%' style='width:300px'>
				</td>
			</tr>
		</table>

		<?php
			if ($_REQUEST['see_result'])
			{
				$aut_art_utils=new utils_author_article();
				$aut_art_typ_rec=$aut_art_utils->getAuthorArticleRelatedToType($_SESSION[$search_temporary_table]);
				print ("<table border='0'  class='table_result' id='tab_res' width='100%'>");
				print ("<thead><tr>
							<th align='center' width='20%' class='table_neuron_page1'> <strong>Authors</strong> </th>
						<th align='center' width='40%' class='table_neuron_page1'> <strong>Title </strong></th>
						<th align='center' width='10%' class='table_neuron_page1'> <strong>Journal/Book</strong> </th>
						<th align='center' width='5%' class='table_neuron_page1'> <strong>Year </strong></th>
						<th align='center' width='5%' class='table_neuron_page1'> <strong>PMID/ISBN</strong></th>
						<th align='center' width='20%' class='table_neuron_page1'> <strong>Types</strong></th>											
					</tr></thead><tbody>");
				for ($i=0; $i <sizeOf($aut_art_typ_rec) ; $i++) 
				{ 
					$link2="";
					$authors=$aut_art_typ_rec[$i]->getAuthors();
					$article_title=$aut_art_typ_rec[$i]->getTitle();
					$article_publication =$aut_art_typ_rec[$i]->getBook();
					$article_pmid_isbn=$aut_art_typ_rec[$i]->getPmidIsbn();
					$article_year = $aut_art_typ_rec[$i]->getYear();
					if(strlen($article_pmid_isbn)>10)
					{	
						$link2 = $link2."<a href='$link_isbn$article_pmid_isbn' target='_blank'>";	
					}
					else
					{
						$value_link ='PMID: '.$article_pmid_isbn;
						$link2 = $link2."<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";				

					}
					print ("<tr>
							<td align='left' width='20%' class='table_neuron_page4'>$authors.</td>
							<td align='left' width='40%' class='table_neuron_page4'>$article_title </td>
							<td align='left' width='10%' class='table_neuron_page4'>$article_publication</td>
							<td align='left' width='5%' class='table_neuron_page4'>$article_year</td>
							<td align='left' width='5%' class='table_neuron_page4'>$link2 <font class='font13'>$article_pmid_isbn</font> </a></td>");		
					print("<td align='left' width='20%' class='table_neuron_page4'>");
					$typ_rec=$aut_art_typ_rec[$i]->getTypesArray();
					$count=0;
					for ($j=0; $j <sizeOf($typ_rec) ; $j++){
						$type_name=$typ_rec[$j]->getName();
						$type_nickname=$typ_rec[$j]->getNickname();
						$type_status =$typ_rec[$j]->getStatus();
						$type_id = $typ_rec[$j]->getId();
						if($type_status!=NULL&&$type_status!='frozen')
						{
							$count++;
							print("$count)&nbsp;<a href='neuron_page.php?id=$type_id' target='_blank' title='".$type_name."'>$type_nickname</a><br/>");
						}	
					}
					if ($count==0) {
						print("(to be determined)");
					}
					print("</td></tr>");	
				}
				print("</tbody></table>");
			}
		?>
		<br /><br />
		</div>
	</div>
</body>
</html>


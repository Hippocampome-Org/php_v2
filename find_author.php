<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
require_once('class/class.temporary_author.php');
require_once('class/class.utils_type.php');	
require_once('class/class.utils_author_article.php');
$search_temporary_table='author_temporary_table';
$defualt_author_name='Amaral DG';
$default_author_letter='A';

$temporary = new temporary_author();	
// Select AND / OR:
if ($_REQUEST['and_or'])
{
	$and_or = $_REQUEST['and_or'];
	$_SESSION['and_or'] = $and_or;	
	$name_temporary_table = $_SESSION[$search_temporary_table];
	$temporary ->setName_table($name_temporary_table);
}

// Resume searching.
if ($_REQUEST['resume_searching_tab'])
{
	$resume_searching = $_SESSION['resume_searching'];	
	$name_temporary_table = $resume_searching;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
}	
	
// Creates the temporary table for search
if ($_REQUEST['searching'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary($default_author_letter, $defualt_author_name);
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;		
}

// New request.
if($_REQUEST['new'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION[$search_temporary_table] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary($_GET["first_author"], $_GET["name_author"]);
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;
}
	
// Dropdown for letter is changed hence fetch all author name starting with that letter and insert first author name in temporary table. If no neuron name found display '-'
if ($_REQUEST['letter'])
{
	$author_name_update="-";
	$letter = $_REQUEST['letter'];
	$id_update = $_REQUEST['id'];
	$temp_author= new temporary_author();
    $authors_array=$temp_author->retriveAuthorsWithLetter($letter);
    if(sizeof($authors_array)>0){
    	$author_name_update=$authors_array[0];
	}
	// update record in temporary table at index $id_update with letter as $letter and name as $author_name_update.
	$temp_author ->setName_table($_SESSION[$search_temporary_table]);
	$temp_author -> update_temporary($letter, $author_name_update, 1, $id_update);
	$and_or = $_SESSION['and_or'];
}
// Dropdown for author name is changed hence get the new author name from option and update name and letter in the temporary table.
if ($_REQUEST['author'])
{
	$author_name = $_REQUEST['author'];
	$id_update = $_REQUEST['id'];
	$temporary ->setName_table($_SESSION[$search_temporary_table]);
	$temporary -> update_temporary(NULL, $author_name, 2, $id_update);	
	$and_or = $_SESSION['and_or'];
}

// Add new search author record at last index with default search author name and letter.
if ($_REQUEST['plus'])
{
	$temporary ->setName_table($_SESSION[$search_temporary_table]);
	$temporary -> insert_temporary('A', 'Amaral DG');
	$and_or = $_SESSION['and_or'];
}
// Remove search author record at specified index($id_temp).
if ($_REQUEST['remove'])
{
	$temporary ->setName_table($_SESSION[$search_temporary_table]);
	$id_temp = $_REQUEST['id'];
	$temporary -> remove($id_temp);
	$and_or = $_SESSION['and_or'];
}
// Show result 
if ($_REQUEST['see_result'])
{
	$temporary ->setName_table($_SESSION[$search_temporary_table]);
	$and_or = $_SESSION['and_or'];
}
// Flush temporary table by removing all records.
if ($_REQUEST['clear_all'])
{
	$temporary -> setName_table($_SESSION[$search_temporary_table]);	
	$temporary->removeAll();
	// Creates the temporary table.
	$temporary -> insert_temporary($default_author_letter, $defualt_author_name);
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript">
		// Javascript function *****************************************************************************************************
		// Dropdown for letter is changed.
		function letter(link, id)
		{
			var letter=link[link.selectedIndex].value;
			var destination_page = "find_author.php";
			location.href = destination_page+"?letter="+letter+"&id="+id;
		}
		// Dropdown for Author is changed.
		function author(link, id)
		{
			var author=link[link.selectedIndex].value;
			var destination_page = "find_author.php";
			location.href = destination_page+"?author="+author+"&id="+id;
		}
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php include ("function/icon.html"); ?>
	<title>Find Author</title>
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
		<font class="font1">Search Articles Associated with Author</font>
	</div>	
	<div class="table_position_search_page">
			<!-- ****************  BODY **************** -->
			<table border="0" cellspacing="3" cellpadding="0" class='table_search' width='100%'>
				<tr>
					<td align="center" width="6%" class='table_neuron_page3'>Initial</td>
					<td align="center" width="45%" class='table_neuron_page3'>Author Name - Selector</td>
					<td align="center" width="2%" class='table_neuron_page3'> + </td>
					<td align="center" width="2%" class='table_neuron_page3'> - </td>
				</tr>
			<?php
				//retrive all searched author present in temporary table
				$temp_author= new temporary_author();
				$temp_author->setName_table($_SESSION[$search_temporary_table]);
				$searched_author_array=$temp_author->retriveSearchedAuthors();
				$n_search=sizeof($searched_author_array);
				for ($i=0; $i<sizeof($searched_author_array); $i++)
				{
			        $id = $searched_author_array[$i]->getID();
			        $letter=$searched_author_array[$i]->getLetter();
			        $author_name=$searched_author_array[$i]->getAuthor();
			        // retrive all authors with name starting with $letter
			        $author_record= new temporary_author();
			     	$author_array=$author_record->retriveAuthorsWithLetter($letter);
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
					print ("<td align='center' width='45%' class='table_neuron_page1'>");
					print ("<select name='author1' size='1' class='select1' onChange='author(this, $id)'  style='width:450px'>");			
					if ($author_name)
					{
						$temp_author= htmlspecialchars($author_name,ENT_QUOTES);
						echo "<option value='".$temp_author."'>".stripslashes($author_name)."</option>";
						print ("<OPTION VALUE='' disabled></OPTION>");
					}	
					if (sizeof($author_array) == 0)
					{
						print ("<OPTION VALUE=''>-</OPTION>");	
					}
					else
					{
						for ($j=0; $j<sizeof($author_array); $j++)
						{
							$temp_author= htmlspecialchars($author_array[$j],ENT_QUOTES);
							echo "<option value='".$temp_author."'>".$author_array[$j]."</option>";
						}
					}
					print ("</select>");
					print ("</td><td align='center' width='2%'>
								<form action='find_author.php' method='post' style='display:inline'> 
								<input type='submit' name='plus' value=' + ' class='more_button'>
								</form>
							 </td>");
										
					if ($i > 0)		 
						print ("</td><td align='center' width='2%'>
									<form action='find_author.php' method='post' style='display:inline'> 
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
			<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
			<tr>		
				
			 </tr>
		   </table>	
		<div align="left" >
		<table width='100%'>
			<tr>
				<td width='2%'>
					<form action="find_author.php" method="post" style='display:inline'>	
					<input type='submit' name='clear_all' value='RESET' />
					</form>
				</td>
				<td width='20%'>
					<form action='find_author.php' method='post' style='display:inline'> 
					<input type="submit" name='see_result' value='SEE RESULTS' />
					</form>
				</td>
				<td width='70%'>
				<?php
					if (($and_or == 'AND') && ($n_search > 1))
					{
						print ("<input type='radio' name='and_or' value='AND' checked='checked'/> 
							And ");
						print ("<input type='radio' name='and_or' value='OR' onClick=\"javascript:location.href='find_author.php?and_or=OR'\"/>  
							Or ");
					}
					if (($and_or == 'OR') && ($n_search > 1))
					{
						print ("<input type='radio' name='and_or' value='AND' onClick=\"javascript:location.href='find_author.php?and_or=AND'\" />  
							And ");
						print ("<input type='radio' name='and_or' value='OR' checked='checked'/> 
							Or");
					}		
				?>				
				</td>
			</tr>
		</table>
		</div>
		<div>
		<?php
		if ($_REQUEST['see_result'])
		{	
			$aut_art_typ_utils=new utils_author_article();
			$or_and_flag = $_SESSION['and_or'];
	    	$temp_table_name = $_SESSION[$search_temporary_table];
			$aut_art_typ_rec=$aut_art_typ_utils->getAuthorRelatedToArticle($or_and_flag,$temp_table_name);	
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
					if($type_status=='Onhold'){
						$count++;
						print("$count)&nbsp;$type_name<br/>");
//					}elseif($type_status!=NULL&&$type_status!='frozen')
					}elseif($type_status!=NULL)
					{
						$count++;
						if($type_status=='SUPPLEMENTAL')
							print("$count)&nbsp;<a href='neuron_page.php?id=$type_id' target='_blank' title='".$type_name."'>$type_nickname(S)</a><br/>");
						else
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

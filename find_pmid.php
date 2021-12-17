<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
//include ("access_db.php");
include ("function/scraper_pubmed.php");
require_once('class/class.article.php');
require_once('class/class.author.php');	
require_once('class/class.articleauthorrel.php');
require_once('class/class.utils_type.php');	
require_once('class/class.utils_author_article.php');

$author_1 = new author($class_author);
$articleauthorrel = new articleauthorrel($class_articleauthorrel);
$article = new article($class_article);	

function getSupplemental($sup_id){
	$types_array=array();
	$index=0;   	
	// retrive the neuron type associated with article using evidence id.
	// article to evidence link is found in ArticleEvidenceRel table. All these evidence are further mapped to one or more evidence
	// in table EvidenceEvidenceRel(source=evidence2_id and it is evidence_id in ArticleEvidenceRel table)
	$query_to_get_type= " SELECT DISTINCT
						    Typ.id AS type_id,
						    Typ.nickname,
						    Typ.name,
						    'SUPPLEMENTAL' AS status
						FROM
						    EvidencePropertyTypeRel eptr,
						    Type Typ
						WHERE
						    eptr.Type_id = Typ.id
						    AND LOCATE('$sup_id', eptr.supplemental_pmids)
						  UNION 
						SELECT DISTINCT
							t.Type_id AS type_id,
							t.name AS nickname, 
							t.name,
							'Onhold' AS status
						FROM
							Onhold t
						WHERE
							t.pmid_isbn=$sup_id"
						    ;
	//print($query_to_get_type);
	$article_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
	if (!$article_type) {
		die("<p>Error in Listing Types Table.</p>");
	}
	while($rows=mysqli_fetch_array($article_type, MYSQLI_ASSOC))
	{
		$types_array[$index]=new utils_type();
		$types_array[$index]->setName($rows['name']);
		$types_array[$index]->setNickname($rows['nickname']);
		$types_array[$index]->setStatus($rows['status']);
		$types_array[$index]->setId($rows['type_id']);
		$index++;	
	}
	return $types_array;
}
// Go to the search: --------------------------------------------------------------------------
if ($_REQUEST['search_pmid'])
{
	$type_search = $_SESSION['type_search'];

	$n_pmid = $_SESSION['n_pmid'];
	$pmid = trim($_REQUEST['pubmed_id']);


	// Check if the pmid is OK or not: ************
	if ($type_search == 'PMID')
	{
		if ((strlen($pmid) > 10) || (strlen($pmid) < 2))
			$error_pmid = 1;
		else
		{
			if (preg_match('[a-z]', $pmid)) 
				$error_pmid = 1;
			else
				$error_pmid = 0;
		}
	}
	if ($type_search == 'ISBN')
	{
		if (preg_match('[a-z]', $pmid)) 
			$error_pmid = 1;
		else
			$error_pmid = 0;	
	}
	// ********************************************

	if ($type_search == 'PMID')
		$article -> retrive_by_pmid_with_like($pmid, 1); 
	if ($type_search == 'ISBN')
		$article -> retrive_by_pmid_with_like($pmid, 2); 

	$n_id_article = $article -> getN_id(); // Number of articles founded
}
// -----------------------------------------------------------------------------------------------
else
{
	$type_code = $_REQUEST['type_code'];
	if ($type_code)
	{
		$type_search = $type_code;
		$_SESSION['type_search'] = $type_search;	
	}
	else
	{
		$type_search = 'PMID';
		$_SESSION['type_search'] = $type_search;
	}

	$n_pmid = 0;
	
	// Calculate the number of articles or book present in the hippocampone.org
	
	if ($type_search == 'PMID')
		$article -> retrive_number_PMID(1);
	if ($type_search == 'ISBN')
		$article -> retrive_number_PMID(2);		
		
	$n_pmid = $article -> getN_pmid();
	
	$_SESSION['n_pmid'] = $n_pmid;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>

<title>Find PMID/ISBN</title>

<script type="text/javascript" src="style/resolution.js"></script>
</head>
<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
	
<div class='title_area'>
	<font class="font1">Search by PMID/ISBN</font>
</div>	

<!-- submenu no tabs
<div class='sub_menu'>
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" align="left">
			<font class='font1'><em>Find:</em></font> &nbsp; &nbsp; 
			<a href="search.php?searching=1"><font class="font7">Neuron</font></a> <font class="font7_A">|</font> 
			<a href="find_author.php?searching=1"><font class="font7">  Author</font></a><font class="font7_A">|</font> 
			<font class="font7_B"> PMID/ISBN</font><font class="font7_A">|</font> 
			</font>	
		</td>
	</tr>
	</table>
</div>
-->
<!-- ------------------------ -->

<div class="table_position_search_page">
<table width="95%" border="0" cellspacing="5" cellpadding="0" class='body_table'>
  <tr>
    <td width="80%">
		<!-- ****************  BODY **************** -->
		<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
		<tr>		
			<td width="100%" align="left">
			<?php
				if ($type_search == 'PMID')
				{
					print ("<input type='radio' name='type_search' value='PMID' checked='checked'/> 
						<font class='font12'>PMID</font> ");
					print ("<input type='radio' name='type_search' value='ISBN' onClick=\"javascript:location.href='find_pmid.php?type_code=ISBN'\"/>  
						<font class='font12'>ISBN</font>");
				}
				if ($type_search == 'ISBN')
				{
					print ("<input type='radio' name='type_search' value='PMID' onClick=\"javascript:location.href='find_pmid.php?type_code=PMID'\" />  
						<font class='font12'>PMID </font>");
					print ("<input type='radio' name='type_search' value='ISBN' checked='checked'/> 
						<font class='font12'>ISBN</font>");
				}			
			?>
			</td>
		</tr>	
		<tr>		
			<td width="100%" align="left">
			<?php
			if ($type_search == 'PMID')
				print ("<font class='font12'>To search one or more publications in <img src='images/Hippocampome_logo.ico' border='0' width='15'/>Hippocampome.org please enter PMID (PubMed identifier) below: </font>");
			if ($type_search == 'ISBN')			
				print ("<font class='font12'>To search one or more books in <img src='images/Hippocampome_logo.ico' border='0' width='15'/>Hippocampome.org please enter ISBN (International Standard Book Number) below: </font>");			
			?>
			</td>
		</tr>
		<tr>	
			<td width="100%" align="left">
			<?php
			if ($type_search == 'PMID')
				print ("<font class='font12'>Total number of publications in <img src='images/Hippocampome_logo.ico' border='0' width='15'/>Hippocampome.org: <strong> $n_pmid <strong> </font>");
			if ($type_search == 'ISBN')			
				print ("<font class='font12'>Total number of books in <img src='images/Hippocampome_logo.ico' border='0' width='15'/>Hippocampome.org: <strong> $n_pmid <strong> </font>");		
			?>			
			</td>
		</tr>
		</table>
		<form action="find_pmid.php" method="post" style="display:inline">
			<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
			<tr>		
				<td width="20%" align="center" class='table_neuron_page1'>
					<?php
					if ($type_search == 'PMID')
						print ("<strong>Enter PMID</strong>");
					if ($type_search == 'ISBN')			
						print ("<strong>Enter ISBN</strong>");		
					?>					
				</td>
				<td width="30%" align="left">
					<input type="text" name='pubmed_id' size='40' />
				</td>			
				<td width="10%" align="center">
					<input type="submit" name='search_pmid' value='SEE RESULTS' />
				</td>			
				<td width="40%" align="center">				
				<?php
					if ($pmid)
					{
						if ($error_pmid == 1)
							print ("<font class='font12'>PMID is not valid!</font>");
						else
							print ("<font class='font12'>Result for: $pmid </font> <font class='font14'> ( $n_id_article result(s) )</font>");
					}
				?>				
				</td>	
			</tr>
			</table>		
		</form>
		
	<?php
		if ( ($n_id_article != 0) && ($error_pmid == 0) )
		{
			print ("<table border='0'  class='table_result' id='tab_res' width='100%'>");
			print ("<thead><tr>
						<td align='center' width='20%' class='table_neuron_page1'> <strong>Authors</strong> </td>
						<td align='center' width='40%' class='table_neuron_page1'> <strong>Title </strong></td>
						<td align='center' width='10%' class='table_neuron_page1'> <strong>Journal/Book</strong> </td>
						<td align='center' width='5%' class='table_neuron_page1'> <strong>Year </strong></td>
						<td align='center' width='5%' class='table_neuron_page1'> <strong>PMID</strong></td>
						<td align='center' width='20%' class='table_neuron_page1'> <strong>Types</strong></td>
					</tr></thead><tbody>");
			
			$aut_art_typ_utils = new utils_author_article();
			for ($i1=0; $i1<$n_id_article; $i1++)
			{	
				$id_article = $article -> getID_array($i1);
				
				$article -> retrive_by_id($id_article);
				$title = $article -> getTitle();
				$journal = $article -> getPublication();
				$year = $article -> getYearSansMonth();
				$PMID1 = $article -> getPmid_isbn();

				// retrieve tha list of authors: -----------------------------------------------			
					$articleauthorrel -> retrive_author_position($id_article);
					$n_author = $articleauthorrel -> getN_author_id();
					for ($ii3=0; $ii3<$n_author; $ii3++)
						$auth_pos[$ii3] = $articleauthorrel -> getAuthor_position_array($ii3);
											
					sort ($auth_pos);

					for ($ii3=0; $ii3<$n_author; $ii3++)
					{
						$articleauthorrel -> retrive_author_id($id_article, $auth_pos[$ii3]);
						$id_author = $articleauthorrel -> getAuthor_id_array(0);
			
						$author_1 -> retrive_by_id($id_author);
						$name_a = $author_1 -> getName_author_array(0);
						
						$name_authors[$ii3] = $name_a;	
					}

					$name_authors1 = NULL;
					for ($ii3=0; $ii3<$n_author; $ii3++)
						$name_authors1 = $name_authors1.", ".$name_authors[$ii3];
					
					$name_authors1[0]='';
				// -----------------------------------------------------------------------------
					
				
				if ($type_search == 'PMID')
				{	
					$value_link ='PMID: '.$PMID1;
					$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";	
				}
				if ($type_search == 'ISBN')
				{	
					$link2 = "<a href='$link_isbn$PMID1' target='_blank'>";	
				}				
					
				print ("<tr>
						<td align='left' width='20%' class='table_neuron_page4'>$name_authors1.</td>
						<td align='left' width='40%' class='table_neuron_page4'>$title </td>
						<td align='left' width='10%' class='table_neuron_page4'>$journal.</td>
						<td align='left' width='5%' class='table_neuron_page4'>$year </td>
						<td align='left' width='5%' class='table_neuron_page4'>$link2 <font class='font13'><strong>$PMID1</strong></font> </a> </td>
						<td align='left' width='20%' class='table_neuron_page4'>");
				
				// Get the Types using Article ID
				$type_id_array = $aut_art_typ_utils -> getArticleTypesArray($id_article);	
		
				$count=0;
				for ($j=0; $j < sizeof($type_id_array) ; $j++)
				{
					$type_name=$type_id_array[$j]->getName();
					$type_nickname=$type_id_array[$j]->getNickname();
					$type_status =$type_id_array[$j]->getStatus();
					$type_id = $type_id_array[$j]->getId();
				
					if($type_status!=NULL&&$type_status!='frozen')
					{
						$count++;
						if($type_status=='SUPPLEMENTAL')
							print("$count)&nbsp;<a href='neuron_page.php?id=$type_id' target='_blank' title='".$type_name."'>$type_nickname (Suppl)</a><br/>");
						if($type_status=='Onhold')
							print("$count)&nbsp;$type_nickname (On-hold)<br/>");
						else
							print("$count)&nbsp;<a href='neuron_page.php?id=$type_id' target='_blank' title='".$type_name."'>$type_nickname</a><br/>");
					}	
				}
				
				if ($count==0) 
				{
					print("(to be determined)");
				}
				
				print("</td></tr>");		

			} // end $i1
			print ("</tbody></table>");			
		}
		// for supplement id without articles
		else if($pmid!=""){
			$n_id_article=1;
			$sup_types=getSupplemental($pmid);
			if(count($sup_types)!=0){
				print ("<table border='0'  class='table_result' id='tab_res' width='100%'>");
				print ("<thead><tr>
						<td align='center' width='20%' class='table_neuron_page1'> <strong>Authors</strong> </td>
						<td align='center' width='40%' class='table_neuron_page1'> <strong>Title </strong></td>
						<td align='center' width='10%' class='table_neuron_page1'> <strong>Journal/Book</strong> </td>
						<td align='center' width='5%' class='table_neuron_page1'> <strong>Year </strong></td>
						<td align='center' width='5%' class='table_neuron_page1'> <strong>PMID</strong></td>
						<td align='center' width='20%' class='table_neuron_page1'> <strong>Types</strong></td>
					</tr></thead><tbody>");
				$value_link ='PMID: '.$pmid;
				$link2 = "<a href='http://www.ncbi.nlm.nih.gov/pubmed?term=$value_link' target='_blank'>";	
	
				print ("<tr>
						<td align='left' width='20%' class='table_neuron_page4'></td>
						<td align='left' width='40%' class='table_neuron_page4'></td>
						<td align='left' width='10%' class='table_neuron_page4'></td>
						<td align='left' width='5%' class='table_neuron_page4'></td>
						<td align='left' width='5%' class='table_neuron_page4'>$link2 <font class='font13'><strong>$pmid</strong></font> </a> </td>
						<td align='left' width='20%' class='table_neuron_page4'>");

				$count=0;
				for ($j=0; $j < sizeof($sup_types) ; $j++)
				{
					$type_name=$sup_types[$j]->getName();
					$type_nickname=$sup_types[$j]->getNickname();
					$type_status =$sup_types[$j]->getStatus();
					$type_id = $sup_types[$j]->getId();
					if($type_status!=NULL&&$type_status!='frozen')
					{
						$count++;
						if($type_status=='SUPPLEMENTAL')
							print("$count)&nbsp;<a href='neuron_page.php?id=$type_id' target='_blank' title='".$type_name."'>$type_nickname (Suppl)</a><br/>");
						else if($type_status=='Onhold')
							print("$count)&nbsp;$type_nickname (On-hold)<br/>");
						
					}
				}
				
				if ($count==0) 
				{
					print("(to be determined)");
				}
				
			}

		}
		
		
		
		// Send an email ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if ( ($n_id_article == 0) && ($error_pmid == 0) )
		{
			print ("<form action='send_email.php' method='post' style='display:inline'>	");
										
			if ($pmid != NULL)
			{
				if ($type_search == 'PMID')
					$res=scraper_pubmed($pmid);
				if ($type_search == 'ISBN');
				
				//if ($res[0] == '1')
				//{
				//	$res[0] = "Insert the title";
				//	$author_3  = "Insert the authors";					
				//	$res[2] = "Insert the publication";
				//}
				//else
				//	$author_3 = $res[1].". et al.";
				$res[0]   = "";
				$author_3 = "";					
				$res[2]   = "";
			
				print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
				print ("<tr>");
					print ("
						<td width='10%' ></td>
						<td width='80%' align='center' bgcolor='#CBDFE1'>
							<font class='font2'>
								This publication is not yet
								in the Hippocampome. <br> To add it to the pipeline, please complete the information below.<br>
								Include your e-mail address, if you would like an update on its status.
							 </font>
						</td>
						<td width='10%' ></td>
					");
				print ("</tr>");
				print ("</table>");	
			
				print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
				print ("<tr>");
					print ("
						<td width='10%' ></td>
						<td width='20%' class='table_neuron_page4' align='right'> $type_search </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='pmid_send' value='$pmid' size='20'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");
				
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' class='table_neuron_page4' align='right'> TITLE </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='title_send' value='$res[0]' size='70'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");				
				
				
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' align='right' class='table_neuron_page4'> AUTHOR </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='author_send' value='$author_3' size='30'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");					
				
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' align='right' class='table_neuron_page4'> PUBLICATION </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='publication_send' value='$res[2]' size='50'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");				
				print ("</table>");			
		
		
				print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' align='right' class='table_neuron_page4'> YOUR NAME </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='name_send' value='' size='50'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");				
				print ("</table>");			
		
				print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' align='right' class='table_neuron_page4'> YOUR INSTITUTE </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='institute_send' value='' size='50'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");				
				print ("</table>");			
		
				print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
				print ("<tr>");
					print ("
						<td width='10%'></td>
						<td width='20%' align='right' class='table_neuron_page4'> YOUR EMAIL* </td>
						<td width='60%' align='left' class='table_neuron_page4'>
							<input type='text' name='email_send' value='' size='50'>
						</td>
						<td width='10%'></td>
					");
				print ("</tr>");				
				print ("</table>");			
				
				print ("<br>
						<table border='0' cellspacing='2' cellpadding='0' class='table_result'>
						<tr>	
							<td width='100%' align='center'>
							<input type='submit' name='send_email' value=' SEND '>
							</form>
							</td>
						</tr>
						</table>
						<br><br>	
						");
			}
			
		} // END ELSE (send an email)
	?>
		</td>
	</tr>
</table>

</body>
</html>

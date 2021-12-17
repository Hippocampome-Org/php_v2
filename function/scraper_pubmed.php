<?php
// Scraper on PUBMED:
function posizioni($html, $s1)
{
	$pos1=strpos($html, $s1);
	$n1 = strlen($s1);
	$pos1=$pos1+$n1;

	return ($pos1);
}

function scraper_pubmed($pmid)
{
	$link = "http://www.ncbi.nlm.nih.gov/pubmed?term=$pmid";

	$html = file_get_contents($link);

	$empty = strpos($html, 'Empty');

	if ($empty)
		$result[0] = '1';
	else
	{
	
		// reucupera Title: *********************************
		$s1='<div class="ralinkpop offscreen_noflow">';
		$pos1= posizioni ($html, $s1);
	
		$s2='<div';
		$pos2=strpos($html, $s2, $pos1);
		
		$delta = ($pos2-$pos1);
		$title = substr($html,$pos1,$delta); 
		
		$result[0] = $title;
		// ***************************************************
		
		// reucupera Author: *********************************
		$s1='<div class="auths">';
		$pos1= posizioni ($html, $s1);
	
		$s2='/a>';
		$pos2=strpos($html, $s2, $pos1);
		
		$delta = ($pos2-$pos1);
		$author1 = substr($html,$pos1,$delta); 
		
		$s1='>';
		$pos1= posizioni ($author1, $s1);
	
		$s2='<';
		$pos2=strpos($author1, $s2, $pos1);
		
		$delta = ($pos2-$pos1);
		$author = substr($author1,$pos1,$delta);	
		$result[1] = $author;
		// ***************************************************
	
		// reucupera Journal: *********************************
		$s1='alterm="';
		$pos3= posizioni ($html, $s1);
	
		$s2='">';
		$pos4=strpos($html, $s2, $pos3);
		
		$delta = ($pos4-$pos3);
		$journal = substr($html,$pos3,$delta); 
		
		$result[2] = $journal;
		// ***************************************************
	
	}
	
	return ($result);
}
?>
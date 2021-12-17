<?php

class utils_author_article
{
	private $_authors;
	private $_title;
	private $_book;
	private $_year;
	private $_pmid_isbn;
	private $_fp;
	private $_types_array;
	private $_neuron;
	function __construct() {
		$this->_types_array=array();
   	}
   	// get the searched author with intials 
	public function getAuthorSearchArray($or_and_flag,$temp_table_name){
		$query_to_get_author="SELECT author FROM $temp_table_name";
		$result_set = mysqli_query($GLOBALS['conn'],$query_to_get_author);
		if (!$result_set) {
            	die("<p>Error in Listing Searched Authors.</p>");
        }
		$author_searched=array();
	    $index=0;
		// Get the Searched author names from temporary table
		while($rows=mysqli_fetch_array($result_set, MYSQLI_ASSOC))
		{
			$author_name=$rows['author'];
			// Split the author name to get its initial
			$pieces=explode(" ",$author_name);
			//append author name and first letter of initials. 
			//For Amaral DG, The code will add author_searched Amaral D.
			//For Roben G, The code will add author_searched Roben G
			if(sizeof($pieces)>1)
			{
				$author_searched[$index]=$pieces[0]." ".substr($pieces[1], 0,1);
			}	
			else
			{
				$author_searched[$index]=$pieces[0];
			}	
			$index++;
		}
		return $author_searched;
	}
    public function getAuthorRelatedToArticle($or_and_flag,$temp_table_name){
    		$author_article_array=array();
			$index=0;
			$authors_condition;
			// get the searched author name and initials in array
			// for searched author Amaral DG, Robinson JK, Miloni M, result will be [Amaral D, Robinson J, Miloni M] 
    		$author_searched=$this->getAuthorSearchArray($or_and_flag,$temp_table_name);
    		$temp_array=$author_searched;
			if($or_and_flag=='OR'){
				// create authors_condition from searched author name.
				// if searched authors  are Amaral DG, Abe KR  then authors_condition will become Author.name like 'Amaral D%' or Author.name like 'Abe K%'
				// so that even though Amaral DG is searched author. we Will Display author named Amaral D, Amaral DG, Amaral DK but not
				// Amaral S or Amaral PK because initials are different i.e. S or PK does not start from D.
				for ($i=0; $i < sizeOf($temp_array); $i++)
				{ 
					$temp_array[$i]=mysqli_real_escape_string($GLOBALS['conn'],$temp_array[$i]); 
					$temp_array[$i]="'".$temp_array[$i]."%'";
				}
				$authors_condition=implode(" OR Auth1.name like ",$temp_array);
			}
			// In case of AND only retrive first searched author name and check if remaining searched authors contains in the $authors stirng or not.
			// for searched author Amaral D, Raman J, Clinots M only retrive article for author Amaral D and in $authors string check, whether 
			// remaining two author are there or not.
			else{
				$temp_array[0]=mysqli_real_escape_string($GLOBALS['conn'],$temp_array[0]); 
				$authors_condition="'".$temp_array[0]."%'";
			}
			// append $authors_condition in query 
			// Query first get Searched author then it finds article asssociated with that author from ArticleAuthorRel table.
			// For particular article we need to retrive all authors in order of author position(in ArticleAuthorRel table) to form authors string.
			// Record must be sorted according to author position.
			// Group_concat forms the authors string, which consist of all authors related to article as per position seperated by comma.
			$query_to_get_article=" SELECT Auth1.name,Auth1.id AS author_id,ArtAuthRel1.author_pos AS search_auth_pos,ArtAuthRel2.author_pos,ArtAuthRel1.Article_id,
									Art.title,Art.publication,Art.year,Art.pmid_isbn,
									GROUP_CONCAT(distinct Auth2.name ORDER BY ArtAuthRel1.Article_id,ArtAuthRel2.author_pos SEPARATOR ', ')  AS authors
									FROM Author Auth1 
									INNER JOIN ArticleAuthorRel ArtAuthRel1 ON (Auth1.id=ArtAuthRel1.Author_id)
									INNER JOIN ArticleAuthorRel ArtAuthRel2 ON (ArtAuthRel1.Article_id=ArtAuthRel2.Article_id)
									INNER JOIN Author Auth2 ON (ArtAuthRel2.Author_id=Auth2.id)
									INNER JOIN Article Art ON (Art.id=ArtAuthRel1.Article_id)
									WHERE Auth1.name LIKE $authors_condition
									GROUP BY ArtAuthRel1.Article_id
									ORDER BY ArtAuthRel1.author_pos";
			$result_set = mysqli_query($GLOBALS['conn'],$query_to_get_article);
			if (!$result_set) {
            	die("<p>Error in Listing Searched Author Records.</p>");
        	}
			while($rows=mysqli_fetch_array($result_set, MYSQLI_ASSOC))
			{
				$author_name=$rows['name'];
				$article_id=$rows['Article_id'];
				$author_id=$rows['author_id'];
				$authors=$rows['authors'];
				$article_title=$rows['title'];
				$article_publication =$rows['publication'];
				$article_pmid_isbn=$rows['pmid_isbn'];
				$article_year = $rows['year'];
				$article_year=substr($article_year,0,4);
				$match=1;
				// make serached author name from authors as bold
				for ($i=0; $i < sizeOf($author_searched); $i++)
				{ 
					// check if Authors string contain searched author name and if not then authors-article record is skipped  
					// by making match=0 and continue the loop(this is to check AND condition in Auhor page only,in case of OR condition match will
					// be 1, and that record will appear in result)
					if(strpos($authors,$author_searched[$i])===false){   
						// In AND case we will skip the record if authors string don't contain the all searched author.
						if($or_and_flag=='AND'){
							$match=0;
							break;
						}
					}	
					// make the found searched author name in authors as bold
					else{
						$start=strpos($authors,$author_searched[$i]);
						$end=strpos($authors,",",$start);
						if($end===false){
							$end=strlen($authors);
						}
						// searched author name in authors string is starting from start and finishes at (end-start) so make it bold.
						// 'Amaral D'(searched author)  in 'Amaral D,Robin J, Linkon P'(authors) then '<b>Amaral D</b>,Robin J, Linkon P'
						// 'Amaral D'  in 'Robin J,Amaral D, Linkon P' then 'Robin J,<b>Amaral D</b>, Linkon P'
						// 'Amaral D'  in 'Robin J, Linkon P,Amaral D' then  'Robin J, Linkon P,<b>Amaral D</b>''
						$searched_name=substr($authors,$start,($end-$start));
						$authors=str_replace($searched_name,"<b>$searched_name</b>", $authors);
					}			
				}
				// In case of AND condtion skip the record. 	
				if ($match==0) {
					continue;
				}
				// create author, article, type record for searched author from utils_author_article object
				$author_article_array[$index]=new utils_author_article();
				$author_article_array[$index]->setAuthors($authors);
				$author_article_array[$index]->setTitle($article_title);
				$author_article_array[$index]->setBook($article_publication);
				$author_article_array[$index]->setYear($article_year);
				$author_article_array[$index]->setPmidIsbn($article_pmid_isbn);
				// get the all neuron type associated with the article_id
				$author_article_array[$index]->setTypesArray($this->getArticleTypesArray($article_id));
				$index++;
			}
		return $author_article_array;
    }
    // Get all the articles and respective authors that are related to type_id in temporary table.
    public function getAuthorArticleRelatedToType($temp_table_name){
    	$author_article_array=array();
		$index=0;
		// Get the Evidence associated with type_id and using evidence retrive article and then authors.
		$query_to_get_article=" SELECT ArtAuthRel1.Article_id,Art.title,Art.publication,Art.year,Art.pmid_isbn,
								GROUP_CONCAT(distinct Auth2.name ORDER BY ArtAuthRel1.Article_id,ArtAuthRel2.author_pos SEPARATOR ', ')  AS authors
								FROM $temp_table_name TempSearch
								INNER JOIN EvidencePropertyTypeRel EvdPrptTypRel ON (EvdPrptTypRel.Type_id=TempSearch.type_id)
								INNER JOIN ArticleEvidenceRel ArtEvdRel ON (ArtEvdRel.Evidence_id = EvdPrptTypRel.Evidence_id)
								INNER JOIN Article Art ON (Art.id=ArtEvdRel.Article_id)
								INNER JOIN ArticleAuthorRel ArtAuthRel1 ON (ArtAuthRel1.Article_id=Art.id)
								INNER JOIN Author Auth1 ON (Auth1.id=ArtAuthRel1.Author_id)
								INNER JOIN ArticleAuthorRel ArtAuthRel2 ON (ArtAuthRel2.Article_id=ArtAuthRel1.Article_id)
								INNER JOIN Author Auth2 ON (ArtAuthRel2.Author_id=Auth2.id)
								GROUP BY ArtAuthRel1.Article_id
								ORDER BY ArtAuthRel1.author_pos";
			$result_set = mysqli_query($GLOBALS['conn'],$query_to_get_article);
			if (!$result_set) {
            	die("<p>Error in Listing Author and Article Records From Type.</p>");
        	}
			while($rows=mysqli_fetch_array($result_set, MYSQLI_ASSOC))
			{
				$article_id=$rows['Article_id'];
				$authors=$rows['authors'];
				$article_title=$rows['title'];
				$article_publication =$rows['publication'];
				$article_pmid_isbn=$rows['pmid_isbn'];
				$article_year = $rows['year'];
				$article_year=substr($article_year,0,4);
				// add author, article and type information for searched author in utils_author_article object
				$author_article_array[$index]=new utils_author_article();
				$author_article_array[$index]->setAuthors($authors);
				$author_article_array[$index]->setTitle($article_title);
				$author_article_array[$index]->setBook($article_publication);
				$author_article_array[$index]->setYear($article_year);
				$author_article_array[$index]->setPmidIsbn($article_pmid_isbn);
				// get the all neuron type associated with the article_id
				$author_article_array[$index]->setTypesArray($this->getArticleTypesArray($article_id));
				$index++;
			}
		return $author_article_array;
    }
    // fetch all the article and type associated with the given firing pattern. 
    public function getAuthorArticleRelatedToFP($temp_table_name){
    	$author_article_array=array();
		$index=0;
		// Get the Evidence associated with type_id and using evidence retrive article and then authors.
		$query_to_get_article=" SELECT TempSearch.neuron,fp.overall_fp,ArtAuthRel1.Article_id,Art.title,Art.publication,Art.year,Art.pmid_isbn,
								GROUP_CONCAT(distinct Auth2.name ORDER BY ArtAuthRel1.Article_id,ArtAuthRel2.author_pos SEPARATOR ', ')  AS authors
								FROM $temp_table_name TempSearch
								INNER JOIN FiringPattern fp ON (fp.fp_name=TempSearch.neuron)
								INNER JOIN FiringPatternRel fpr ON (fpr.FiringPattern_id=fp.id)
								INNER JOIN Fragment f ON (f.original_id=fpr.original_id)
								INNER JOIN EvidenceFragmentRel efr ON (efr.Fragment_id=f.id)
								INNER JOIN ArticleEvidenceRel ArtEvdRel ON (ArtEvdRel.Evidence_id = efr.Evidence_id)
								INNER JOIN Article Art ON (Art.id=ArtEvdRel.Article_id)
								INNER JOIN ArticleAuthorRel ArtAuthRel1 ON (ArtAuthRel1.Article_id=Art.id)
								INNER JOIN Author Auth1 ON (Auth1.id=ArtAuthRel1.Author_id)
								INNER JOIN ArticleAuthorRel ArtAuthRel2 ON (ArtAuthRel2.Article_id=ArtAuthRel1.Article_id)
								INNER JOIN Author Auth2 ON (ArtAuthRel2.Author_id=Auth2.id)
								GROUP BY ArtAuthRel1.Article_id,TempSearch.neuron
								ORDER BY ArtAuthRel1.author_pos";
			//print($query_to_get_article);
			$result_set = mysqli_query($GLOBALS['conn'],$query_to_get_article);
			if (!$result_set) {
            	die("<p>Error in Listing Author and Article Records From Type.</p>");
        	}
			while($rows=mysqli_fetch_array($result_set, MYSQLI_ASSOC))
			{
				$neuron=$rows['neuron'];
				$fp_name=$rows['overall_fp'];
				$article_id=$rows['Article_id'];
				$authors=$rows['authors'];
				$article_title=$rows['title'];
				$article_publication =$rows['publication'];
				$article_pmid_isbn=$rows['pmid_isbn'];
				$article_year = $rows['year'];
				$article_year=substr($article_year,0,4);
				// add author, article and type information for searched author in utils_author_article object
				$author_article_array[$index]=new utils_author_article();
				$author_article_array[$index]->setFP($fp_name);
				$author_article_array[$index]->setNeuron($neuron);
				$author_article_array[$index]->setAuthors($authors);
				$author_article_array[$index]->setTitle($article_title);
				$author_article_array[$index]->setBook($article_publication);
				$author_article_array[$index]->setYear($article_year);
				$author_article_array[$index]->setPmidIsbn($article_pmid_isbn);
				// get the all neuron type associated with the fp original description
				$index_type=0;
				$types_array=array();
				$query_to_get_type_fp="SELECT DISTINCT fpr.Type_id,t.name,t.nickname,t.status FROM FiringPattern fp, FiringPatternRel fpr,Type t
				WHERE fp.id=fpr.FiringPattern_id AND t.id=fpr.Type_id
				AND fp.fp_name like '$neuron'";
				//print("<br>".$query_to_get_type_fp);
				$result_set_fp = mysqli_query($GLOBALS['conn'],$query_to_get_type_fp);
				if (!$result_set_fp) {
	            	die("<p>Error in Listing Author and Article Records.</p>");
	        	}
				while($rows=mysqli_fetch_array($result_set_fp, MYSQLI_ASSOC))
				{
					$types_array[$index_type]=new utils_type();
					$types_array[$index_type]->setName($rows['name']);
					$types_array[$index_type]->setNickname($rows['nickname']);
					$types_array[$index_type]->setStatus($rows['status']);
					$types_array[$index_type]->setId($rows['Type_id']);
					$index_type++;	
				}
				$author_article_array[$index]->setTypesArray($types_array);
				$index++;
			}
		return $author_article_array;
    }
    // fetch all the article and type associated with the given article id. 
    public function getArticleTypesArray($article_id){
 		$types_array=array();
		$index=0;   	
		// retrive the neuron type associated with article using evidence id.
		// article to evidence link is found in ArticleEvidenceRel table. All these evidence are further mapped to one or more evidence
		// in table EvidenceEvidenceRel(source=evidence2_id and it is evidence_id in ArticleEvidenceRel table)
    	$query_to_get_type= " SELECT DISTINCT Art.id as article_id,Typ.id as type_id,Typ.name,Typ.nickname,Typ.status
								FROM Article Art
								INNER  JOIN ArticleEvidenceRel ArtEvdRel ON (ArtEvdRel.Article_id = Art.id)
								INNER  JOIN EvidencePropertyTypeRel EvdPrptTypRel ON (ArtEvdRel.Evidence_id=EvdPrptTypRel.Evidence_id)
								INNER  JOIN Type Typ ON (Typ.id=EvdPrptTypRel.Type_id)
								where Art.id=$article_id
								UNION
								SELECT DISTINCT Art.id as article_id,Typ.id as type_id,Typ.name,Typ.nickname,Typ.status
								from Article Art
								INNER  JOIN ArticleEvidenceRel ArtEvdRel ON (ArtEvdRel.Article_id = Art.id)
								INNER  JOIN EvidenceEvidenceRel EvdEvdRel ON (EvdEvdRel.Evidence2_id=ArtEvdRel.Evidence_id)
								INNER  JOIN EvidencePropertyTypeRel EvdPrptTypRel ON (EvdEvdRel.Evidence1_id=EvdPrptTypRel.Evidence_id)
								INNER  JOIN Type Typ ON (Typ.id=EvdPrptTypRel.Type_id)
								WHERE Art.id=$article_id 
								UNION
								SELECT DISTINCT Art.id AS article_id, Typ.id AS type_id,
								Typ.name, Typ.nickname, 'SUPPLEMENTAL' as status
								FROM EvidencePropertyTypeRel eptr,Article Art,Type Typ
								WHERE eptr.Type_id=Typ.id 
								AND LOCATE(Art.pmid_isbn,eptr.supplemental_pmids) 
								AND Art.id=$article_id 
								UNION
                                SELECT DISTINCT
									Art.id as article_id,
									t.Type_id AS type_id,
                                    t.name,
									t.name AS nickname, 
									'Onhold' AS status
								FROM
									Onhold t,Article Art
								WHERE
									Art.pmid_isbn=t.pmid_isbn
                                    AND Art.id=$article_id
								ORDER BY type_id ";
		$article_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
		if (!$article_type) {
			die("<p>Error in Listing Types Table.</p>");
		}
		while($rows=mysqli_fetch_array($article_type, MYSQLI_ASSOC))
		{
			$type_name=$rows['name'];
			$type_nickname=$rows['nickname'];
			$type_status =$rows['status'];
			$type_id = $rows['type_id'];
			$types_array[$index]=new utils_type();
			$types_array[$index]->setName($rows['name']);
			$types_array[$index]->setNickname($rows['nickname']);
			$types_array[$index]->setStatus($rows['status']);
			$types_array[$index]->setId($rows['type_id']);
			$index++;	
		}
		return $types_array;
    }
    public function setFP($var)
    {
		  $this->_fp = $var;
    }
    public function getFP()
    {
		  return $this->_fp;
    }	
    public function setNeuron($var)
    {
		  $this->_neuron = $var;
    }
    public function getNeuron()
    {
		  return $this->_neuron;
    }	
    public function setAuthors($var)
    {
		  $this->_authors = $var;
    }	
		
 	public function setTitle($var)
    {
		  $this->_title = $var;
    }	
    public function setBook($var)
    {
		  $this->_book = $var;
    }	
		
 	public function setYear($var)
    {
		  $this->_year = $var;
    }
    public function setPmidIsbn($var)
    {
		  $this->_pmid_isbn = $var;
    }	
		
 	public function setTypesArray($var)
    {
		  $this->_types_array = $var;
    }
    public function getAuthors()
    {
		  return $this->_authors;
    }	
 	public function getTitle()
    {
		  return $this->_title;
    }	
    public function getBook()
    {
		  return $this->_book;
    }		
 	public function getYear()
    {
		  return $this->_year;
    }
    public function getPmidIsbn()
    {
		  return $this->_pmid_isbn;
    }		
	public function getTypesArray()
    {
		  return $this->_types_array;
    }
 
    public function getType($index)
    {
		  return $this->_types_array[$index];
    }
    public function addRecipients($var)
	{
		array_push($this->_types_array, $var);
	}
}
?>

<?php
class evidencetypetyperel_synpro
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_postsynaptic_cell_id_array;
	private $_presynaptic_cell_id;
	private $_n_postsynaptic_cell_id;
	private $_presynaptic_cell_id_array;
	private $_n_presynaptic_cell_id;
	private $_evidence_id_array;
	private $_n_evidence_id;
	private $_unvetted;
	private $_article_id;
	private $_conflict_note;
	private $_property_type_explanation;
	private $_n_linking_quote_array;
	private $_n_interpretation_notes_array;
	private $_min_n_by_k_evidence_id;
	private $_max_n_by_k_evidence_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
		$this->_min_n_by_k_evidence_id = 17505;
		$this->_max_n_by_k_evidence_id = 23403;
	}

	public function retrive_presynaptic_cell_id_by_postsynaptic_cell_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT presynaptic_cell_id FROM $table WHERE postsynaptic_cell_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setpresynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_presynaptic_cell_id($n);	
	}
	
	public function retrive_postsynaptic_cell_id_by_presynaptic_cell_id($presynaptic_cell_id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT postsynaptic_cell_id FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);	
	}	

	public function retrive_postsynaptic_cell_id_by_Subject_override($Subject, $Conflict_note)
	{
		$table 	= $this->getName_table();
		$table1 = "Property";
		$query = "SELECT DISTINCT ev.postsynaptic_cell_id
			FROM $table ev
			JOIN $table1 pr
			ON (ev.presynaptic_cell_id = pr.id)
			WHERE ev.conflict_note = '$Conflict_note'
			and pr.subject = '$Subject' and pr.object != 'unknown'";
		//echo "$query";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);
	}
	public function retrive_postsynaptic_cell_id_by_Subject_overrideIn($Subject, $Conflict_note)
	{
		$inferences=array("confirmed positive","positive inference","confirmed positive inference","confirmed negative","negative inference","confirmed negative inference","unresolved inferential conflict");
		$table 	= $this->getName_table();
		$table1 = "Property";
		$query = "SELECT DISTINCT ev.postsynaptic_cell_id,ev.conflict_note
			FROM $table ev
			JOIN $table1 pr
			ON (ev.presynaptic_cell_id = pr.id)
			WHERE ev.conflict_note in ($Conflict_note)
			and pr.subject = '$Subject' and pr.object != 'unknown'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id,$conflict) = mysqli_fetch_row($rs))
		{	
			if(in_array($conflict, $inferences)){
				$type_conflict="_".$id."_".$conflict;
				$this->setpostsynaptic_cell_id_array($type_conflict, $n);
			}
			else
				$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);
	}
	
	public function retrive_postsynaptic_cell_id_by_Subject_Object($Subject, $Object)
	{
		$table 	= $this->getName_table();
		$table1 = "Property";
		
		$query = "SELECT DISTINCT ev.postsynaptic_cell_id
			FROM $table ev
			JOIN $table1 pr
			ON (ev.presynaptic_cell_id = pr.id)
			WHERE pr.object = '$Object' and (conflict_note is null or conflict_note ='') and pr.subject = '$Subject'";
			
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);
	}

	/// added for "not in" type search. Issue 151
	public function retrive_for_Not_In($flag,$presynaptic_cell_id,$val,$rel,$part)
	{
		$table=$this->getName_table();
		$table1 = "Property";
		$table2 = "Type";
		if ($flag == 1)
			$query = "SELECT DISTINCT eptr.postsynaptic_cell_id FROM $table eptr
					JOIN ($table1 p, $table2 t)
					ON (eptr.presynaptic_cell_id = p.id AND eptr.postsynaptic_cell_id = t.id)
					WHERE p.subject = '$part' AND presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id NOT IN
						(SELECT DISTINCT eptr.postsynaptic_cell_id
							FROM EvidencePropertyTypeRel eptr
							JOIN ($table1 p, $table2 t)
							ON (eptr.presynaptic_cell_id = p.id AND eptr.postsynaptic_cell_id = t.id)
							WHERE subject = '$part' AND predicate = 'in' AND object = '$val')";
		else
			$query = "SELECT DISTINCT eptr.postsynaptic_cell_id FROM $table eptr
					JOIN ($table1 p, $table2 t)
					ON (eptr.presynaptic_cell_id = p.id AND eptr.postsynaptic_cell_id = t.id)
					WHERE p.subject = '$part' AND presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id NOT IN 
						(SELECT DISTINCT eptr.postsynaptic_cell_id
							FROM EvidencePropertyTypeRel eptr
							JOIN ($table1 p, $table2 t)
							ON (eptr.presynaptic_cell_id = p.id AND eptr.postsynaptic_cell_id = t.id)
							WHERE subject = '$part' AND predicate = 'in' AND object like '%$val%')";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);	
	}		

	public function retrive_evidence_id($presynaptic_cell_id, $postsynaptic_cell_id)
	{
		$table=$this->getName_table();		
		$min_id=$this->_min_n_by_k_evidence_id;
		$max_id=$this->_max_n_by_k_evidence_id;
		//$query = "SELECT DISTINCT Evidence_id,linking_quote,interpretation_notes FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id = '$postsynaptic_cell_id'";
		$query = "SELECT DISTINCT Evidence_id,linking_quote,interpretation_notes FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id = '$postsynaptic_cell_id' AND Evidence_id>=$min_id AND Evidence_id<=$max_id;";
		//echo "sql: ".$query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id,$linking_quote,$interpretation_notes) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);
			$this->setLinking_quote_array($linking_quote, $n);
			$this->setInterpretation_notes_array($interpretation_notes, $n);
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}	

	public function retrive_evidence_id1($presynaptic_cell_id)
	{
		$table=$this->getName_table();
		$min_id=$this->_min_n_by_k_evidence_id;
		$max_id=$this->_max_n_by_k_evidence_id;
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND Evidence_id>=$min_id AND Evidence_id<=$max_id;";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}	

	public function retrive_evidence_id2($postsynaptic_cell_id)
	{
		$table=$this->getName_table();
		$min_id=$this->_min_n_by_k_evidence_id;
		$max_id=$this->_max_n_by_k_evidence_id;
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE postsynaptic_cell_id = '$postsynaptic_cell_id' AND Evidence_id>=$min_id AND Evidence_id<=$max_id;";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{
			$this->setEvidence_id_array($id, $n);
			$n = $n +1;
		}
		$this->setN_evidence_id($n);
	}

	public function retrieve_morphology_evidence_id_by_type($postsynaptic_cell_id)
	{
		$table=$this->getName_table();
		$query="SELECT DISTINCT eptr.Evidence_id, eptr.linking_quote, eptr.interpretation_notes
			FROM $table eptr JOIN Property p ON eptr.presynaptic_cell_id = p.id
			WHERE eptr.postsynaptic_cell_id = '$postsynaptic_cell_id' AND p.subject IN ('axons', 'dendrites', 'somata')
		";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id, $linking_quote, $interpretation_notes) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$this->setLinking_quote_array($linking_quote, $n);
			$this->setInterpretation_notes_array($interpretation_notes, $n);
			$n = $n + 1;
		}
		$this->setN_evidence_id($n);	
	}

	public function retrieve_morphology_evidence_id_by_type_and_pmid_isbn($postsynaptic_cell_id, $pmid_isbn)
	{
		$table=$this->getName_table();
		$query="SELECT eptr.Evidence_id
			FROM $table eptr JOIN (ArticleEvidenceRel aer, Article a, Property p)
			ON (eptr.Evidence_id = aer.Evidence_id AND aer.Article_id = a.id AND eptr.presynaptic_cell_id = p.id)
			WHERE eptr.postsynaptic_cell_id = '$postsynaptic_cell_id' AND a.pmid_isbn = '$pmid_isbn' AND p.subject IN ('axons', 'dendrites', 'somata')
		";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$n = $n + 1;
		}
		$this->setN_evidence_id($n);	
	}

	public function retrive_postsynaptic_cell_id_by_evidence($evidence_id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT postsynaptic_cell_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setpostsynaptic_cell_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_postsynaptic_cell_id($n);	
	}


	public function retrive_unvetted($postsynaptic_cell_id, $presynaptic_cell_id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT unvetted FROM $table WHERE postsynaptic_cell_id = '$postsynaptic_cell_id' AND presynaptic_cell_id = '$presynaptic_cell_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{			
			$this->setUnvetted($var);		
		}	
	}


	// STM get an Article_id by specifying the other three ids
	public function retrive_article_id($presynaptic_cell_id, $postsynaptic_cell_id, $evidence_id)
	{
		$table=$this->getName_table();
		$query = "SELECT DISTINCT Article_id FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id = '$postsynaptic_cell_id' AND Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$row = mysqli_fetch_row($rs);
		$article_id = $row[0];
		return $article_id;
	}	

	// STM get a conflict_note by specifying Property and Type ids
	public function retrieve_conflict_note($presynaptic_cell_id, $postsynaptic_cell_id) 
	{
		$table=$this->getName_table();
		$query = "SELECT DISTINCT conflict_note FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id = '$postsynaptic_cell_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{			
			$this->setConflict_note($var);		
		}	
	}
  
	// CLR get a property_type_explanation by specifying Property and Type ids
	public function retrieve_property_type_explanation($presynaptic_cell_id, $postsynaptic_cell_id)
	{
		$table=$this->getName_table();
		$query = "SELECT DISTINCT property_type_explanation FROM $table WHERE presynaptic_cell_id = '$presynaptic_cell_id' AND postsynaptic_cell_id = '$postsynaptic_cell_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{
			$this->setProperty_type_explanation($var);
		}
	}
	
	// SET -------------------------------------
 	public function setpostsynaptic_cell_id_array($val1, $n)
	{
		$this->_postsynaptic_cell_id_array[$n] = $val1;
	}

 	public function setpresynaptic_cell_id_array($val1, $n)
	{
		$this->_presynaptic_cell_id_array[$n] = $val1;
	}

 	public function setEvidence_id_array($val1, $n)
	{
		$this->_evidence_id_array[$n] = $val1;
	}
		
	public function setN_postsynaptic_cell_id($val1)
	{
		$this->_n_postsynaptic_cell_id = $val1;
	}	

 	public function setN_presynaptic_cell_id($val1)
	{
		$this->_n_presynaptic_cell_id = $val1;
	}

 	public function setN_evidence_id($val1)
	{
		$this->_n_evidence_id = $val1;
	}
	
 	public function setUnvetted($val1)
	{
		$this->_unvetted = $val1;
	}	
	
 	public function setConflict_note($val1)
	{
		$this->_conflict_note = $val1;
	}

	public function setProperty_type_explanation($val1)
	{
		$this->_property_type_explanation = $val1;
	}
    
	public function setLinking_quote_array($val1, $n)
	{
		$this->_n_linking_quote_array[$n] = $val1;
	}
    
	public function setInterpretation_notes_array($val1, $n)
	{
		$this->_n_interpretation_notes_array[$n] = $val1;
	}
		 	
	// GET ++++++++++++++++++++++++++++++++++++++	
	public function getpostsynaptic_cell_id_array($i)
	{
		return $this->_postsynaptic_cell_id_array[$i];
	}

	public function getpresynaptic_cell_id_array($i)
	{
		return $this->_presynaptic_cell_id_array[$i];
	}

	public function getEvidence_id_array($i)
	{
		return $this->_evidence_id_array[$i];
	}
		
	public function getN_postsynaptic_cell_id()
	{
		return $this->_n_postsynaptic_cell_id;
	}	

	public function getN_presynaptic_cell_id()
	{
		return $this->_n_presynaptic_cell_id;
	}	

	public function getN_evidence_id()
	{
		return $this->_n_evidence_id;
	}	
		
	public function getName_table()
	{
		return $this->_name_table;
	}	
		
	public function getUnvetted()
	{
		return $this->_unvetted;
	}			
	
	public function getConflict_note()
	{
		return $this->_conflict_note;
	}		

	public function getProperty_type_explanation()
	{
		return $this->_property_type_explanation;
	}
	
	public function getLinking_quote_array($i)
	{
		return $this->_n_linking_quote_array[$i];
	}	

	public function getInterpretation_notes_array($i)
	{
		return $this->_n_interpretation_notes_array[$i];
	}
}
?>	

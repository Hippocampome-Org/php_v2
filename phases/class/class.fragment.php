<?php
class fragment_phases
{
	private $_name_table;
	private $_referenceID;
	private $_id;
	private $_quote;
	private $_original_id;
	private $_page_location;
	private $_pmid_isbn;
	private $_pmid_isbn_page;	
	private $_type;	
	private $_attachment;
	private $_attachment_type;
	private $_attachment_array;
	private $_attachment_type_array;
	private $_interpretation;
	private $_interpretation_notes;
	//private $_linking_cell_id;
	private $_linking_pmid_isbn;
	private $_linking_pmid_isbn_page;
	private $_linking_quote;
	private $_linking_page_location;
	private $_number_attachment;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	public function retrive_by_id($id) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, referenceID, cellID, location_in_reference, FTQ_ID, material_used, phase_parameter, phase_parameter_ID, authors, title, journal, year, PMID, pmid_isbn_page FROM $table WHERE id = '$id'";
		#echo $query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $referenceID, $cellID, $location_in_reference, $FTQ_ID, $material_used, $phase_parameter, $phase_parameter_ID, $authors, $title, $journal, $year, $PMID, $pmid_isbn_page) = mysqli_fetch_row($rs))
		{	
			$this->setReferenceID($referenceID);
			$this->setID($id);
			$this->setOriginal_id($FTQ_ID);			
			$this->setQuote($material_used);
			//$this->setPage_location($page_location);
			$this->setPmid_isbn($PMID);
			//echo "PMID: $PMID";
			$this->setPmid_isbn_page($pmid_isbn_page);
			/*$this->setType($type);	
			$this->setAttachment($attachment);	
			$this->setAttachment_type($attachment_type);
			$this->setInterpretation($interpretation);
			$this->setInterpretation_notes($interpretation_notes);
			//$this->setLinking_cell_id($linking_cell_id);
			$this->setLinking_page_location($linking_page_location);
			$this->setLinking_pmid_isbn($linking_pmid_isbn);
			$this->setLinking_pmid_isbn_page($linking_pmid_isbn_page);
			$this->setLinking_quote($linking_quote);
			$this->setLinking_page_location($linking_page_location);*/
			
		}
	}

	public function retrive_attachment_array_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment FROM $table WHERE fragment_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($attachment) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment_array($attachment, $n);	
			$n = $n + 1;
		}		
		$this->setNumber_attachment($n);
	}
	 
	public function retrive_attachment_type_array_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment_type FROM $table WHERE original_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($attachment_type) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment_type_array($attachment_type, $n);
			$n = $n + 1;
		}		
		$this->setNumber_attachment($n);
	}
	 
	public function retrive_attachment_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment, attachment_type FROM $table WHERE original_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment($attachment);	
			$this->setAttachment_type($attachment_type);	
		}		
	}
	 
	// SET -------------------------------------
	public function setReferenceID($val)
    {
		  $this->_referenceID = $val;
    }

 	public function setID($val)
    {
		  $this->_id = $val;
    }
			
 	public function setQuote($val)
    {
		  $this->_quote = $val;
    }
	
 	public function setPage_location($val)
    {
		  $this->_page_location = $val;
    }

 	public function setOriginal_id($val)
    {
		  $this->_original_id = $val;
    }

    public function setPmid_isbn($val)
    {
    	$this->_pmid_isbn = $val;
    }

    public function setPmid_isbn_page($val)
    {
    	$this->_pmid_isbn_page = $val;
    }
    
 	public function setType($val)
    {
		  $this->_type = $val;
    }

 	public function setAttachment($val)
    {
		  $this->_attachment = $val;
    }

 	public function setAttachment_type($val)
    {
		  $this->_attachment_type = $val;
    }
		
 	public function setAttachment_array($val, $n)
    {
		  $this->_attachment_array[$n] = $val;
    }

 	public function setAttachment_type_array($val)
    {
		  $this->_attachment_type_array = $val;
    }

	public function setInterpretation($val)
	{
		$this->_interpretation = $val;
	}
	
	public function setInterpretation_notes($val)
	{
		$this->_interpretation_notes = $val;
	}
	
/* 	public function setLinking_cell_id($val)
	{
		$this->_linking_cell_id = $val;
	} */
	
	public function setLinking_pmid_isbn($val)
	{
		$this->_linking_pmid_isbn = $val;
	}
	
	public function setLinking_pmid_isbn_page($val)
	{
		$this->_linking_pmid_isbn_page = $val;
	}
	
	public function setLinking_quote($val)
	{
		$this->_linking_quote = $val;
	}
	
	public function setLinking_page_location($val)
	{
		$this->_linking_page_location = $val;
	}
	
 	public function setNumber_attachment($n)
    {
		  $this->_number_attachment = $n;
    }		
	
			
 	// GET ++++++++++++++++++++++++++++++++++++++	
 	public function getReferenceID()
    {
    	return $this->_referenceID;
    }

    public function getID()
    {
    	return $this->_id;
    }	
			
    public function getQuote()
    {
    	return $this->_quote;
    }	

    public function getPage_Location()
    {
    	return $this->_page_location;
    }

    public function getOriginal_id()
    {
    	return $this->_original_id;
    }

    public function getPmid_isbn()
    {
    	return $this->_pmid_isbn;
    }
    
    public function getPmid_isbn_page()
    {
    	return $this->_pmid_isbn_page;
    }
    
    public function getType()
    {
    	return $this->_type;
    }
				
    public function getName_table()
    {
    	return $this->_name_table;
    }	
	
    public function getAttachment()
    {
    	return $this->_attachment;
    }		

    public function getAttachment_type()
    {
    	return $this->_attachment_type;
    }
		
    public function getAttachment_array($n)
    {
    	return $this->_attachment_array[$n];
    }		

    public function getAttachment_type_array()
    {
    	return $this->_attachment_type_array;
    }

    public function getInterpretation()
    {
    	return $this->_interpretation;
    }
    
    public function getInterpretation_notes()
    {
    	return $this->_interpretation_notes;
    }
    
   /*  public function getLinking_cell_id()
    {
    	return $this->_linking_cell_id;
    } */
    
    public function getLinking_pmid_isbn()
    {
    	return $this->_linking_pmid_isbn;
    }
    
    public function getLinking_pmid_isbn_page()
    {
    	return $this->_linking_pmid_isbn_page;
    }
    
    public function getLinking_quote()
    {
    	return $this->_linking_quote;
    }
    
    public function getLinking_page_location()
    {
    	return $this->_linking_page_location;
    }
    
    public function getNumber_attachment()
    {
    	return $this->_number_attachment;
    }	

    public function neuron_to_subregion($neuron_id)
    {
    	$subregion = Null;

    	$query = "SELECT subregion FROM SynproTypeTypeRel WHERE type_id=$neuron_id;";
    	//echo $query;
    	$rs = mysqli_query($GLOBALS['conn'],$query);
		#$subregion = mysqli_fetch_row($rs)[0];
		while(list($val_result) = mysqli_fetch_row($rs))
		{
			$subregion = $val_result;
		}

		return $subregion;
    }

    public function neuron_to_subregion2($neuron_id)
    {
    	#$subregion = Null;

    	$query = "SELECT subregion FROM SynproTypeTypeRel WHERE type_id=$neuron_id;";
    	#echo $query;
    	$rs = mysqli_query($GLOBALS['conn'],$query);
		#$subregion = mysqli_fetch_row($rs)[0];
		while(list($val_result) = mysqli_fetch_row($rs))
		{
			$subregion = $val_result;
		}

		#return $subregion;
    }    

    public function eid_to_location_in_reference($evidence_id) 
    {
    	$lir='';
		$query = "SELECT location_in_reference FROM phases_fragment WHERE id='$evidence_id';";
		//echo $query;
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($lir_result) = mysqli_fetch_row($rs))
		{	    	
			$lir=$lir_result;
		}

		return $lir;
    }

    public function neuron_id_to_array_index($neuron_id, $neuron_ids) 
    {
    	$array_index=0;
		for ($i = 0; $i < count($neuron_ids); $i++) {
			if ($neuron_id == $neuron_ids[$i]) {
				$array_index = $i;
			}
		}

		return $array_index;
    }

    public function frag_id_to_ref_id($frag_id) 
    {
    	$ref_id='';
		$query = "SELECT referenceID FROM phases_fragment WHERE id='$frag_id';";
		//echo $query;
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($referenceID) = mysqli_fetch_row($rs))
		{	    	
			$ref_id=$referenceID;
		}

		return $ref_id;
    }

    public function type_id_to_article_ids($type_id) 
    {
    	$eid = '';
    	$eids = array();
    	$query = "SELECT DISTINCT Evidence_id FROM phases_evidence_type_rel WHERE Type_id = '$type_id';";
		//echo $query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($eid) = mysqli_fetch_row($rs))
		{	    	
			array_push($eids, $eid);
			//echo " ".$eid."<br>";
		}

		$pmid = '';
    	$pmids = array();
    	for ($i = 0; $i < count($eids); $i++) {
	    	$query = "SELECT pmid FROM phases_fragment where id = '$eids[$i]';";
			//echo $query."<br>";
			$rs = mysqli_query($GLOBALS['conn'],$query);
			while(list($pmid) = mysqli_fetch_row($rs))
			{	    	
				array_push($pmids, $pmid);
			}
		}

		$artid = '';
    	$artids = array();
    	for ($i = 0; $i < count($pmids); $i++) {
	    	$query = "SELECT id FROM Article where pmid_isbn='$pmids[$i]';";
			//echo $query."<br>";
			$rs = mysqli_query($GLOBALS['conn'],$query);
			while(list($artid) = mysqli_fetch_row($rs))
			{	    	
				array_push($artids, $artid);
			}
		}

		return $artids;
    }

}

?>
<?php
class fragment
{
	private $_name_table;
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
		
		$query = "SELECT id, original_id, quote, page_location, pmid_isbn, pmid_isbn_page, type, attachment, attachment_type, interpretation, interpretation_notes, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $original_id, $quote, $page_location, $pmid_isbn, $pmid_isbn_page, $type, $attachment, $attachment_type, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setOriginal_id($original_id);			
			$this->setQuote($quote);
			$this->setPage_location($page_location);
			$this->setPmid_isbn($pmid_isbn);
			$this->setPmid_isbn_page($pmid_isbn_page);
			$this->setType($type);	
			$this->setAttachment($attachment);	
			$this->setAttachment_type($attachment_type);
			$this->setInterpretation($interpretation);
			$this->setInterpretation_notes($interpretation_notes);
			//$this->setLinking_cell_id($linking_cell_id);
			$this->setLinking_page_location($linking_page_location);
			$this->setLinking_pmid_isbn($linking_pmid_isbn);
			$this->setLinking_pmid_isbn_page($linking_pmid_isbn_page);
			$this->setLinking_quote($linking_quote);
			$this->setLinking_page_location($linking_page_location);
			
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
	
}

?>
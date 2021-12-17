<?php
class fragment
{
	private $_name_table;
	private $_id;
	private $_quote;
	private $_original_id;
	private $_page_location;	
	private $_type;	
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	public function retrive_by_id($id) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, original_id, quote, page_location, type FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $original_id, $quote, $page_location, $type) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setOriginal_id($original_id);			
			$this->setQuote($quote);
			$this->setPage_location($page_location);		
			$this->setType($type);	
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

 	public function setType($val)
    {
		  $this->_type = $val;
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

    public function getType()
    {
    	return $this->_type;
    }
				
    public function getName_table()
    {
    	return $this->_name_table;
    }	
}

?>
<?php
class author
{
	private $_name_table;
	private $_id;
	private $_name_author_array;
	private $_n_author;
	private $_id_array;
	private $_n_id;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	public function retrive_by_id($id) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT name FROM $table WHERE id = '$id' ";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName_author_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_author($n);			
	}

	public function retrive_name() 
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT name FROM $table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName_author_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_author($n);			
	}

	public function retrive_id_by_name($name) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT id FROM $table WHERE name='$name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_id($n);			
	}
	
	
	// SET -------------------------------------
 	public function setID($val)
    {
		  $this->_id = $val;
    }
			
 	public function setName_author_array($val, $n)
    {
		  $this->_name_author_array[$n] = $val;
    }

 	public function setID_array($val, $n)
    {
		  $this->_id_array[$n] = $val;
    }
	
 	public function setN_author($val)
    {
		  $this->_n_author = $val;
    }

 	public function setN_id($val)
    {
		  $this->_n_id = $val;
    }
		
 	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_id;
    }	
			
    public function getName_author_array($i)
    {
    	return $this->_name_author_array[$i];
    }	

    public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }	
	
    public function getN_author()
    {
    	return $this->_n_author;
    }

    public function getN_id()
    {
    	return $this->_n_id;
    }
				
    public function getName_table()
    {
    	return $this->_name_table;
    }	
}

?>
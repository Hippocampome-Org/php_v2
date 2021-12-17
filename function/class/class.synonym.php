<?php
class synonym
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_name;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}
		
	
	public function retrive_by_id($id)   // Retrive name by ID
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, dt, name FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $dt, $name) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
		}
	}		
	
	// SET -------------------------------------	
 	public function setId($var)
    {
		  $this->_id = $var;
    }		
	
 	public function setDt($var)
    {
		  $this->_dt = $var;
    }		
	
 	public function setName($var)
    {
		  $this->_name = $var;
    }			
	
 	// GET ++++++++++++++++++++++++++++++++++++++		
    public function getId()
    {
    	return $this->_id;
    }
	
    public function getDt()
    {
    	return $this->_dt;
    }	

    public function getName()
    {
    	return $this->_name;
	}	
	
	 public function getName_table()
    {
    	return $this->_name_table;
    }
	
}	
	
?>
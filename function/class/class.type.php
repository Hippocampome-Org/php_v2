<?php
class type
{	
	private $_name_table;
	private $_id;
	private $_dt;
	private $_name;
	private $_nickname;
	private $_status;
	private $_number_type;
	private $_id_array;	
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_id()   // Retrive the data from table: 'TYPE' by ID (only with STATUS = active):
    {
		$table=$this->getName_table();	
	
		$query = "SELECT id FROM $table WHERE status = 'active' ORDER BY position ASC";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_array($id, $n);
			$n = $n + 1;
		}
		$this->setNumber_type($n);
	}	

	public function retrive_name_by_nickname()   // Retrive the data from table: 'TYPE' by ID (only with STATUS = active):
    {
		$table=$this->getName_table();	
	
		$query = "SELECT name FROM $table WHERE nickname = '$nickname'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName($var);
		}
	}	
	
	public function retrive_by_id($id)   // Retrive all data by ID
    {
		$table=$this->getName_table();	
		
		$query = "SELECT id, dt, name, nickname, status FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $dt, $name, $nickname, $status) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setStatus($status);
		}	
	}	

	public function retrive_by_id_active($id)   // Retrive all data by ID
    {
		$table=$this->getName_table();	
		
		$query = "SELECT id, dt, name, nickname, status FROM $table WHERE id = '$id' AND status = 'active'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $dt, $name, $nickname, $status) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setStatus($status);
		}	
	}

	// SET -------------------------------------
 	public function setNumber_type($n)
    {
		  $this->_number_type = $n;
    }		
	
 	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }	
	
	public function setNickname($var)
    {
		  $this->_nickname = $var;
    }	
		
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

 	public function setStatus($var)
    {
		  $this->_status = $var;
    }	
		
 	// GET ++++++++++++++++++++++++++++++++++++++	  
    public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }		
	
    public function getNumber_type()
    {
    	return $this->_number_type;
    }	
	
    public function getNickname()
    {
    	return $this->_nickname;
    }		

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

    public function getStatus()
    {
    	return $this->_status;
    }		

    public function getName_table()
    {
    	return $this->_name_table;
    }
}
?>
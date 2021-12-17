<?php
class property
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_part;
	private $_rel;
	private $_val;
	private $_Property_id;	
	private $_number_type;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
		
	public function retrive_by_id($id)
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, subject, predicate, object FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $part, $rel, $val) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setPart($part);
			$this->setRel($rel);
			$this->setVal($val);			
		}
	}
	
	
	public function retrive_ID($flag, $part, $rel, $val)
    {
		$table=$this->getName_table();
		
		// flag = 1 use by part and val:
		if ($flag ==1 )
		{
			$query = "SELECT DISTINCT id FROM $table WHERE subject = '$part' AND predicate = '$rel' AND object = '$val'";	
		}
		if ($flag ==2 )
		{
			$query = "SELECT DISTINCT id FROM $table WHERE subject = '$part' AND object = '$val'";	
		}	
		if ($flag ==3 )
		{
			$query = "SELECT DISTINCT id FROM $table WHERE subject = '$part' AND object != 'unknown'";	
		}	
		if ($flag ==4 )
		{
			$query = "SELECT DISTINCT id FROM $table WHERE subject = '$part' AND predicate = '$rel'";	
		}	
		if ($flag ==5 )
		{
			$query = "SELECT DISTINCT id FROM $table WHERE subject = '$part' AND predicate = '$rel' AND object LIKE '%$val%'";	
		}	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n6=0;
		while(list($id) = mysqli_fetch_row($rs))
		{		
			$this->setProperty_id($id, $n6);
			$n6 = $n6 + 1;
		}
		$this->setNumber_type($n6);
	}	
	
			
		
	// SET -------------------------------------
 	public function setID($val1)
    {
		  $this->_id = $val1;
    }
			
 	public function setPart($val1)
    {
		  $this->_part = $val1;
    }
				
 	public function setRel($val1)
    {
		  $this->_rel = $val1;
    }	
	
 	public function setVal($val1)
    {
		  $this->_val = $val1;
    }	
 	
	public function setNumber_type($n)
    {
		  $this->_number_type = $n;
    }		
 	
	public function setProperty_id($var, $n)
    {
		  $this->_Property_id[$n] = $var;
    }	
	
 	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_id;
    }	
			
    public function getPart()
    {
    	return $this->_part;
    }		

    public function getRel()
    {
    	return $this->_rel;
    }	
	
    public function getVal()
    {
    	return $this->_val;
    }			
	
	public function getNumber_type()
    {
    	return $this->_number_type;
    }		
    
	public function getProperty_id($i)
    {
    	return $this->_Property_id[$i];
    }	

    public function getName_table()
    {
    	return $this->_name_table;
    }		
}
?>	
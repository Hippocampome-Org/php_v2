<?php
class temporary_result_neurons
{
	private $_id;
	private $_id_type;	
	private $_id_array;
	private $_n_id;
	
	
	public function retrieve_id_array()
	{
		$name_temporary_table=$this->getName_table();
		
		$query = "SELECT DISTINCT id_type FROM $name_temporary_table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($id)	= mysqli_fetch_row($rs))		
		{
			$this->setID_array($id, $n);
			$n = $n + 1;
		}		
		$this->setN_id($n);
	}		
	
	
	
	
	
	
	
	
	
	
	// GET -------------------------------------	
 	public function getName_table()
    {
		  return $this->_name_table;
    }	
		
 	public function getID()
    {
		  return $this->_id;
    }		
	
 	public function getID_type()
    {
		  return $this->_id_type;
    }			

 	public function getN_id()
    {
		  return $this->_n_id;
    }		
	
 	public function getID_array($i)
    {
		  return $this->_id_array[$i];
    }		
	
	// SET -------------------------------------	
 	public function setName_table($var)
    {
		  $this->_name_table = $var;
    }	
	
	public function setID($var)
    {
		  $this->_id = $var;
    }		
	
	public function setID_type($var)
    {
		  $this->_id = $var;
    }			
	
	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }		
	
	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }		
	
}
?>	
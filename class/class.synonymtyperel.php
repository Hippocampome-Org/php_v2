<?php
class synonymtyperel
{
	private $_name_table;
	private $_synonym_id;
	private $_type_id;	
	private $_n_synonym;
	private $_n_id;
    private $_id_type_array;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	public function retrive_synonym_id($id_type)
	{
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT Synonym_id FROM $table WHERE Type_id = '$id_type'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{
			$this->setSynonym_id($id, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_synonym($n);
	}	
	
	//new methdod 
	public function retrive_type_id_by_syn_id($synonym_id)  
    {
		$table=$this->getName_table();
	   $synonym_id= mysqli_real_escape_string($GLOBALS['conn'],$synonym_id);
		
		$query = "SELECT DISTINCT Type_id FROM $table WHERE Synonym_id = '$synonym_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_type_array($id, $n);				
			$n = $n +1;
		}
		$this->setN_id($n);			
	}
	
	// SET -------------------------------------
 	public function setID($val)
    {
		  $this->_id = $val;
    }	
	
 	public function setSynonym_id($val, $n)
    {
		  $this->_synonym_id[$n] = $val;
    }		
	
 	public function setType_id($val)
    {
		  $this->_type_id = $val;
    }		
	
 	public function setN_synonym($val)
    {
		  $this->_n_synonym = $val;
    }	
public function setID_type_array($var, $n)
    {
		  $this->_id_type_array[$n] = $var;
    }
	
	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }		
	
	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_id;
    }	
		
    public function getSynonym_id($i)
    {
    	return $this->_synonym_id[$i];
    }			
	
    public function getType_id()
    {
    	return $this->_type_id;
    }		
	
    public function getN_synonym()
    {
    	return $this->_n_synonym;
    }	

    public function getName_table()
    {
    	return $this->_name_table;
    }	
	public function getID_type_array($i)
    {
    	return $this->_id_type_array[$i];
    }
	
	public function getN_id()
    {
    	return $this->_n_id;
    }	
}

?>
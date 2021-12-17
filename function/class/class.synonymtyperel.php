<?php
class synonymtyperel
{
	private $_name_table;
	private $_synonym_id;
	private $_type_id;	
	private $_n_synonym;
	
	
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
}

?>
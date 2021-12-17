<?php
class markerdata
{
	private $_name_table;	
	private $_expression;
	private $_animal;
	private $_protocol;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrive_info($id)
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT expression, animal, protocol FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($expression, $animal, $protocol) = mysqli_fetch_row($rs))
		{	
			$this->setExpression($expression);	
			$this->setAnimal($animal);				
			$this->setProtocol($protocol);					
		}
	}




	// SET -------------------------------------
 	public function setProtocol($val1)
    {
		  $this->_protocol = $val1;
    }	

 	public function setExpression($val1)
    {
		  $this->_expression = $val1;
    }	
	
 	public function setAnimal($val1)
    {
		  $this->_animal = $val1;
    }			

	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getProtocol()
    {
    	return $this->_protocol;
    }	

    public function getExpression()
    {
    	return $this->_expression;
    }	
	
    public function getAnimal()
    {
    	return $this->_animal;
    }			
			
    public function getName_table()
    {
    	return $this->_name_table;
    }	
}
?>
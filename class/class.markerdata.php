<?php
class markerdata
{
	private $_name_table;	
	private $_expression;
	private $_animal;
	private $_protocol;
	private $_number_expression;

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

	public function retrieve_expression()   // Retrive the data from table: 'TYPE' by ID (only with STATUS = active):
    {
		$query = "SELECT subject FROM Property WHERE predicate = 'has name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($subject) = mysqli_fetch_row($rs))
		{	
			$this->setExpression($subject);
			$n = $n + 1;
		}
		$this->setNumber_expression($n);
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

 	public function setNumber_expression($n)
    {
		  $this->_number_expression = $n;
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

    public function getNumber_expression()
    {
    	return $this->_number_expression;
    }	
	
}
?>
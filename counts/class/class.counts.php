<?php
class counts
{	
	private $_name_table;
	private $_id;
	private $_measurement_eqn;
	private $_interpretation;
	private $_n_measurement_equations;
	private $_variable;
	private $_n_variables;
	private $_cell_type;
	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrieve_measurement_equation($cell_id)
	{
		$query = "SELECT DISTINCT measurement_equation, interpretation FROM counts_fragment WHERE cellID = '$cell_id'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($measurement_equation, $interpretation) = mysqli_fetch_row($rs))
		{
			$this->setMeasurement_eqn($measurement_equation, $n);
			$this->setInterpretation($interpretation, $n);
			$n = $n + 1;		
		}	

		$this->setN_measurement_equations($n);
	}	
	
	public function retrieve_variables($cell_id)
	{
		$query = "SELECT DISTINCT variable, cell_type FROM counts_fragment WHERE cellID = '$cell_id' ORDER BY variable";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($variable, $cell_type) = mysqli_fetch_row($rs))
		{
			$this->setVariable($variable, $n);
			$this->setCell_type($cell_type, $n);
			$n = $n + 1;		
		}	

		$this->setN_variables($n);
	}	
	
	public function retrieve_counts($id){
		$query = "SELECT counts FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$counts_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$counts_value=$rows['counts'];
		}
		return $counts_value;
	}

	public function retrieve_lower_bound($id){
		$query = "SELECT lower_bound FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$lower_bound_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$lower_bound_value=$rows['lower_bound'];
		}
		return $lower_bound_value;
	}

	public function retrieve_upper_bound($id){
		$query = "SELECT upper_bound FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$upper_bound_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$upper_bound_value=$rows['upper_bound'];
		}
		return $upper_bound_value;
	}
	
	// SET -------------------------------------
 	public function setMeasurement_eqn($val, $n)
    {
		  $this->_measurement_eqn[$n] = $val;
    }		
	
 	public function setInterpretation($val, $n)
    {
		  $this->_interpretation[$n] = $val;
    }		
	
 	public function setN_measurement_equations($val)
    {
		  $this->_n_measurement_equations = $val;
    }	 	
	
 	public function setVariable($val, $n)
    {
		  $this->_variable[$n] = $val;
    }		
	
 	public function setN_variables($val)
    {
		  $this->_n_variables = $val;
    }	 	
	
 	public function setCell_type($val, $n)
    {
		  $this->_cell_type[$n] = $val;
    }		
	
	// GET ++++++++++++++++++++++++++++++++++++++	  
    public function getMeasurement_eqn($i)
    {
    	return $this->_measurement_eqn[$i];
    }			
	
    public function getInterpretation($i)
    {
    	return $this->_interpretation[$i];
    }			
	
    public function getN_measurement_equations()
    {
    	return $this->_n_measurement_equations;
    }	
 
    public function getVariable($i)
    {
    	return $this->_variable[$i];
    }			
	
    public function getN_variables()
    {
    	return $this->_n_variables;
    }	
 
    public function getCell_type($i)
    {
    	return $this->_cell_type[$i];
    }			
	
}
?>

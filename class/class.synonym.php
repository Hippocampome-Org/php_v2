<?php
class synonym
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_name;
	private $_name_neuron_array;
	private $_name_neuron;
	private $_n_id;
    private $_id_array;
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


public function retrive_name() 
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT name FROM $table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName_neuron_array($id, $n);						
			$n = $n +1;
		}
		$this->setName_neuron($n);			
	}	
	
	
	
//new method 
public function retrive_id_by_name($name) //Retrieve id by the name from table 'Synonym'
    {
		$table=$this->getName_table();
	$name= mysqli_real_escape_string($GLOBALS['conn'],$name);
		
		$query = "SELECT id FROM $table WHERE name = '$name'";
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
 	
	public function setName_neuron_array($val, $n)
    {
			  $this->_name_neuron_array[$n] = $val;
    }
	
	public function setName_neuron($val)
    {
		  $this->_name_neuron = $val;
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
	
	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }
	
	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }	
	
	
 	// GET ++++++++++++++++++++++++++++++++++++++		
		 public function getName_neuron_array($i)
    {
    	return $this->_name_neuron_array[$i];
    }
	
	public function getName_neuron()
    {
    	return $this->_name_neuron;
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
	
	 public function getName_table()
    {
    	return $this->_name_table;
    }
		public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }
	
	public function getN_id()
    {
    	return $this->_n_id;
    }
}	
	
?>
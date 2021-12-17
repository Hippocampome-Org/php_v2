<?php

class temporary_neuronname
{
	private $_id;
	private $_letter;
	private $_neuron;
	private $_name_table;
	private $_n_id;
	private $_id_array;
	private $_neuron_array;


	public function create_temp_table ()
	{	
		$table=$this->getName_table();
	
		$drop_table ="DROP TABLE $table";
		$query = mysqli_query($GLOBALS['conn'],$drop_table);
		
		$creatable=	"CREATE TABLE IF NOT EXISTS $table (					
                      id int(4) NOT NULL AUTO_INCREMENT,
					   letter varchar(3),
					   neuron varchar(200),
					   PRIMARY KEY (id));";
		$query = mysqli_query($GLOBALS['conn'],$creatable);
	}

	public function insert_temporary($letter, $neuron)
	{
	//set_magic_quotes_runtime(0);
		if (get_magic_quotes_gpc()) {
        	$neuron = stripslashes($neuron);    
    	}
		$neuron= mysqli_real_escape_string($GLOBALS['conn'],$neuron);
		$table=$this->getName_table();
			
		$query_i = "INSERT INTO $table (id, letter, neuron) VALUES (NULL, '$letter', '$neuron')";
		$rs2 = mysqli_query($GLOBALS['conn'],$query_i);	
	}

	public function update_temporary($letter, $neuron, $flag, $id)
	{
	//set_magic_quotes_runtime(0);
	
    	if (get_magic_quotes_gpc()) {
        	$neuron = stripslashes($neuron);    
    	}
    
		$neuron= mysqli_real_escape_string($GLOBALS['conn'],$neuron);	
		$table=$this->getName_table();
	
		if ($flag == 1) // Update letter:
		{
			$query_i = "UPDATE $table SET letter = '$letter', neuron = '$neuron' WHERE id='$id'";				
		}
		if ($flag == 2) // Update neuron:
		{
			$query_i = "UPDATE $table SET neuron = '$neuron' WHERE id='$id'";	
		}
		$rs2 = mysqli_query($GLOBALS['conn'],$query_i);
	}


	public function retrieve_id()
	{
		$table=$this->getName_table();
	
		$query = "SELECT id, neuron FROM $table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($id, $neuron) = mysqli_fetch_row($rs))
		{
			$this->setID_array($id, $n);
			$this->setNeuron_array($neuron, $n);
			$n = $n + 1;
		}
		$this->setN_id($n);
	}

	public function retrieve_letter_from_id($id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT letter FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{
			$this->setLetter($var);
		}
	}

	public function retrieve_neuron_from_id($id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT neuron FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{
			$this->setNeuron($var);
		}
	}
	
	public function remove($id)
	{
		$table=$this->getName_table();
	
		$query = "DELETE FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
	}
	
		
	// SET -------------------------------------	
 	public function setName_table($var)
    {
		  $this->_name_table = $var;
    }	
		
 	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }	

 	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }	

 	public function setNeuron_array($var, $n)
    {
		  $this->_neuron_array[$n] = $var;
    }	
	
 	public function setLetter($var)
    {
		  $this->_letter = $var;
    }	

 	public function setNeuron($var)
    {
		  $this->_neuron = $var;
    }	
	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getName_table()
    {
    	return $this->_name_table;
    }	
		
    public function getId()
    {
    	return $this->_id;
    }

    public function getLetter()
    {
    	return $this->_letter;
    }

    public function getNeuron()
    {
    	return $this->_neuron;
    }

    public function getN_id()
    {
    	return $this->_n_id;
    }

    public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }
	
    public function getNeuron_array($i)
    {
    	return $this->_neuron_array[$i];
    }	
    
	
}
?>

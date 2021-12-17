<?php
class type
{	
	private $_name_table;
	private $_id;
	private $_n_id;
	private $_dt;
	private $_name;
	private $_nickname;
	private $_excit_inhib;
	private $_status;
	private $_number_type;
	private $_id_array;	
	private $_position;
	private $_notes;
	private $_subregion;
	private $_n_name_nickname;
	private $_id_namearray;
	private $_name_neuron_array;
	private $_nickname_neuron_array;
	private $_name_neuron;
	private $_nickname_neuron;
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
	
	
	public function retrive_by_id($id)   // Retrieve all data by ID
	{
		$table=$this->getName_table();	
		
		$query = "SELECT id, position, dt, name, nickname, excit_inhib, status, subregion FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $position, $dt, $name, $nickname,$excit_inhib, $status, $subregion) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setStatus($status);
			$this->setPosition($position);
			$this->setSubregion($subregion);
			$this->setExcit_Inhib($excit_inhib);
		}	
	}

	public function retrieve_by_id($id)   // Retrieve all data by ID
	{
		$table=$this->getName_table();	
		
		$query = "SELECT id, position, dt, name, nickname,excit_inhib, status, subregion FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$this->setStatus('');
		while(list($id, $position, $dt, $name, $nickname,$excit_inhib, $status, $subregion) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setStatus($status);
			$this->setPosition($position);
			$this->setSubregion($subregion);
			$this->setExcit_Inhib($excit_inhib);
		}	
	}

	public function get_counts($id){
		$query = "SELECT counts FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$counts_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$counts_value=$rows['counts'];
		}
		return $counts_value;
	}

	public function get_lower_bound($id){
		$query = "SELECT lower_bound FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$lower_bound_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$lower_bound_value=$rows['lower_bound'];
		}
		return $lower_bound_value;
	}

	public function get_upper_bound($id){
		$query = "SELECT upper_bound FROM Counts WHERE unique_ID ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$upper_bound_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$upper_bound_value=$rows['upper_bound'];
		}
		return $upper_bound_value;
	}

	public function retrieve_supertype($id){
		$table=$this->getName_table();

		$query = "SELECT supertype FROM Type WHERE id ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$supertype_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$supertype_value=$rows['supertype'];
		}
		return $supertype_value;
	}

	public function get_type_subtype($id){
		$table=$this->getName_table();

		$query = "SELECT type_subtype FROM $table WHERE id ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$type_subtype_value="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$type_subtype_value=$rows['type_subtype'];
		}
		return $type_subtype_value;
	}

	public function retrieve_name_derivation($id){
		$table=$this->getName_table();

		$query = "SELECT explanatory_notes FROM Type WHERE id ='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$explanatory_notes="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{	
			$explanatory_notes=$rows['explanatory_notes'];
		}
		return $explanatory_notes;
	}

	public function retrive_by_excit_inhib($pred)   // Retrive all data by excit_inhib
	{
		$table=$this->getName_table();
	
		$query = "SELECT id FROM $table WHERE excit_inhib ='$pred'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_array($id, $n);		
			$n = $n +1;
		}
		$this->setNumber_type($n);
	}

	public function retrive_by_id_active($id)   // Retrive all data by ID
	{
		$table=$this->getName_table();	
		
		$query = "SELECT id, position, dt, name, nickname,excit_inhib, status, subregion FROM $table WHERE id = '$id' AND status = 'active'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $position, $dt, $name, $nickname,$excit_inhib, $status, $subregion) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setExcit_Inhib($excit_inhib);
			$this->setStatus($status);
			$this->setPosition($position);
			$this->setSubregion($subregion);
		}	
	}

	public function retrive_notes($id)   // Retrive the data from table: 'TYPE' by ID (only with STATUS = active):
    {
		$table=$this->getName_table();	
	
		$query = "SELECT notes FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{	
			$this->setNotes($var);
		}
	}	
	
//------------------------------------------------------------------------------new methods-----------------------------------
	public function retrive_name() //Retrieve all the names in the table TYPE
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


public function retrive_nickname()   // Retrieve all the nicknames in the table TYPE
    {
		$table=$this->getName_table();	
	
		$query = "SELECT DISTINCT nickname FROM $table ";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setNickname_neuron_array($id, $n);		
			$n = $n +1;
		}
		$this->setNickame_neuron($n);			
	}
	

	public function retrive_id_by_name($name) //Retrieve id, nickname based on the name in the table TYPE
    {
		$table=$this->getName_table();
	$name= mysqli_real_escape_string($GLOBALS['conn'],$name);
		
		$query = "SELECT DISTINCT id FROM $table WHERE name='$name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_namearray($id, $n);					
			$n = $n +1;
		}
		$this->setN_id($n);			
	}
	
	

	public function retrive_nickname_by_name($name)  //Retrieve nickname by the name in table TYPE
    {
		$table=$this->getName_table();
	$name= mysqli_real_escape_string($GLOBALS['conn'],$name);
		
		$query = "SELECT DISTINCT nickname FROM $table WHERE name='$name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setNickname_neuron_array($id, $n);		
			$n = $n +1;
		}
		$this->setNickame_neuron($n);	
		}
		
		
	
		
		public function retrive_name_by_nickname1($nickname) //Retrieve name by the nickname in table TYPE
    {
		$table=$this->getName_table();
	$name= mysqli_real_escape_string($GLOBALS['conn'],$name);
		
		$query = "SELECT DISTINCT name FROM $table WHERE nickname='$nickname'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName_neuron_array($id, $n);		
			$n = $n +1;
		}
		$this->setName_neuron($n);	
		}
		

	public function retrive_id_by_nickname($nickname) //Retrive id by nickname
    {
		$table=$this->getName_table();
	$name= mysqli_real_escape_string($GLOBALS['conn'],$name);
		
		$query = "SELECT DISTINCT id FROM $table WHERE nickname='$nickname'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_namearray($id, $n);			
			$n = $n +1;
		}
		$this->setN_id($n);			
	}
	
	
		public function retrive_id1()   // Retrieve the data from table: 'TYPE' by ID (only with STATUS = active):
    {
		$table=$this->getName_table();	
	
		$query = "SELECT id FROM $table ";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setID_array($id, $n);
			$n = $n + 1;
		}
		$this->setN_id($n);
	}	
	
	
	
		public function retrieve_by_name($name)   // Retrieve all data by ID
	{
		$table=$this->getName_table();	
		
		$query = "SELECT id, position, dt, name, nickname,excit_inhib, status, subregion FROM $table WHERE name = '$name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$this->setStatus('');
		while(list($id, $position, $dt, $name, $nickname,$excit_inhib, $status, $subregion) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setName($name);
			$this->setNickname($nickname);
			$this->setStatus($status);
			$this->setPosition($position);
			$this->setSubregion($subregion);
			$this->setExcit_Inhib($excit_inhib);
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
	public function setExcit_Inhib($var)
    {
		  $this->_excit_inhib = $var;
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

 	public function setPosition($var)
    {
		  $this->_position = $var;
    }	

 	public function setNotes($var)
    {
		  $this->_notes = $var;
    }	
	
 	public function setSubregion($var)
    {
		  $this->_subregion = $var;
    }
//----------------new setmethods------------------
	
	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }	
	
	public function setName_neuron_array($val, $n)
    {
		  $this->_name_neuron_array[$n] = $val;
    }

	public function setID_namearray($var, $n)
    {
		  $this->_id_namearray[$n] = $var;
    }
	
	public function setName_neuron($val)
    {
		  $this->_name_neuron = $val;
    }
	
	public function setNickname_neuron_array($val, $n)
    {
		  $this->_nickname_neuron_array[$n] = $val;
    }

	public function setNickame_neuron($val)
    {
		  $this->_nickname_neuron = $val;
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

	public function getExcit_Inhib()
   	{
		return $this->_excit_inhib;
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
	
    public function getPosition()
    {
    	return $this->_position;
    }	

    public function getNotes()
    {
    	return $this->_notes;
    }	

    public function getSubregion()
    {
    	return $this->_subregion;
    }	

//---------------------new get methods------------------------------------------------------------
	 
	public function getN_id()
    {
    	return $this->_n_id;
    }
	
	public function getName_neuron_array($i)
    {
    	return $this->_name_neuron_array[$i];
    }	

	public function getID_namearray($i)
    {
    	return $this->_id_namearray[$i];
    }	

	public function getName_neuron()
    {
    	return $this->_name_neuron;
    }	
	
	public function getNickname_neuron_array($i)
    {
    	return $this->_nickname_neuron_array[$i];
    }
    public function getNickname_neuron()
    {
    	return $this->_nickname_neuron;
    }	
	
}
?>

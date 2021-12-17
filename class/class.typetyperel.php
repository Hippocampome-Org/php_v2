<?php
class typetyperel
{
	private $_type1_id;
	private $_type2_id_array;
	private $_type2_id;
	private $_n_type_2;	
	private $_n_connection_status;		
	private $_n_connection_location;		
	private $_connection_status_array;
	private $_connection_status;
	private $_connection_location;	
	
	private $_id_array;	

	private $_type1_id_array;
	private $_n_type_1;		
	

	public function retrive_connection_status($type1_id, $connection_location)
	{
		$table="TypeTypeRel";
		
		// with type_1:
		$query = "SELECT Connection_status FROM $table WHERE Type1_id = '$type1_id' AND connection_location = '$connection_location' ";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($Connection_status) = mysqli_fetch_row($rs))
		{
//			$this->setConnection_status_array($Connection_status, $n);
			$this->setConnection_status($Connection_status, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_connection_status($n);
	}

	
	public function retrive_type2_id($type1_id, $connection_location)
	{
		$table="TypeTypeRel";
		
//		$query = "SELECT Type2_id FROM $table WHERE Type1_id = '$type1_id' AND connection_location = '$connection_location' AND connection_status = 'positive' ";	
		$query = "SELECT Type2_id FROM $table WHERE Type1_id = '$type1_id' AND connection_location = '$connection_location' ";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($Type2_id) = mysqli_fetch_row($rs))
		{
//			$this->setType2_id_array($Type2_id, $n);
			$this->setType2_id($Type2_id, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_type_2($n);
	}	


	public function retrive_type1_id($type2_id, $connection_location)
	{
		$table="TypeTypeRel";
		
//		$query = "SELECT Type2_id FROM $table WHERE Type2_id = '$type2_id' AND connection_location = '$connection_location' AND connection_status = 'positive' ";	
		$query = "SELECT Type1_id FROM $table WHERE Type2_id = '$type2_id' AND connection_location = '$connection_location'  ";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($Type1_id) = mysqli_fetch_row($rs))
		{
			$this->setType1_id_array($Type1_id, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_type_1($n);
	}


	public function retrive_connection_location($id_type)
	{
		$table="TypeTypeRel";
		
		// with type_1:
		$query = "SELECT DISTINCT connection_location FROM $table WHERE Type1_id = '$id_type'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($connection_location) = mysqli_fetch_row($rs))
		{
			$this->setConnection_location($connection_location, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_connection_location($n);
	}
	
	
	public function retrive_connection_location_by_type2($id_type)
	{
		$table="TypeTypeRel";
		
		// with type_2:
		$query = "SELECT DISTINCT connection_location FROM $table WHERE Type2_id = '$id_type'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($connection_location) = mysqli_fetch_row($rs))
		{
			$this->setConnection_location($connection_location, $n);
			$n = $n + 1;		
		}	
		
		$this->setN_connection_location($n);
	}
	
	
	// SET -------------------------------------
 	public function setType1_id($val)
    {
		  $this->_type1_id = $val;
    }	
	
 	public function setType2_id_array($val, $n)
    {
		  $this->_type2_id_array[$n] = $val;
    }		
	
 	public function setType2_id($val, $n)
    {
		  $this->_type2_id[$n] = $val;
    }		
	
 	public function setConnection_status_array($val, $n)
    {
		  $this->_connection_status_array[$n] = $val;
    }		
	
 	public function setN_type_2($val)
    {
		  $this->_n_type_2 = $val;
    }		

 	public function setN_connection_status($val)
    {
		  $this->_n_connection_status = $val;
    }	
			
 	public function setN_connection_location($val)
    {
		  $this->_n_connection_location = $val;
    }	
			
 	public function setConnection_status($val, $n)
    {
		  $this->_connection_status[$n] = $val;
    }		
	
 	public function setConnection_location($val, $n)
    {
		  $this->_connection_location[$n]= $val;
    }		
	
 	public function setID_array($val, $n)
    {
		  $this->_id_array[$n] = $val;
    }		
	
	
 	public function setType1_id_array($val, $n)
    {
		  $this->_type1_id_array[$n] = $val;
    }		
	
 	public function setN_type_1($val)
    {
		  $this->_n_type_1 = $val;
    }			
	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getType1_id()
    {
    	return $this->_type1_id;
    }	
		
    public function getType2_id_array($i)
    {
    	return $this->_type2_id_array[$i];
    }	
			
    public function getType2_id($i)
    {
    	return $this->_type2_id[$i];
    }	
			
    public function getConnection_status_array($i)
    {
    	return $this->_connection_status_array[$i];
    }		
	
    public function getConnection_status($i)
    {
    	return $this->_connection_status[$i];
    }		
	
    public function getN_type_2()
    {
    	return $this->_n_type_2;
    }	

    public function getN_connection_status()
    {
    	return $this->_n_connection_status;
    }	
			
    public function getN_connection_location()
    {
    	return $this->_n_connection_location;
    }	
			
    public function getConnection_location($i)
    {
    	return $this->_connection_location[$i];
    }	

    public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }

    public function getType1_id_array($i)
    {
    	return $this->_type1_id_array[$i];
    }	
			
    public function getN_type_1()
    {
    	return $this->_n_type_1;
    }	
			
}

?>
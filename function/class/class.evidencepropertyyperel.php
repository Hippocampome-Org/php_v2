<?php
class evidencepropertyyperel
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_type_id_array;
	private $_Property_id;
	private $_n_type_id;
	private $_Property_id_array;
	private $_n_Property_id;
	private $_evidence_id_array;
	private $_n_evidence_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrive_Property_id_by_Type_id($id)
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT Property_id FROM $table WHERE Type_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setProperty_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_Property_id($n);	
	}
	
	public function retrive_Type_id_by_Property_id($Property_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Type_id FROM $table WHERE Property_id = '$Property_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setType_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_Type_id($n);	
	}		

	public function retrive_evidence_id($Property_id, $type_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE Property_id = '$Property_id' AND Type_id = '$type_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}	

	public function retrive_evidence_id1($Property_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE Property_id = '$Property_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}	

	public function retrive_evidence_id2($type_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE Type_id = '$type_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setEvidence_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}

	public function retrive_type_id_by_evidence($evidence_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Type_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{			
			$this->setType_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_Type_id($n);	
	}
			
		
	// SET -------------------------------------
 	public function setType_id_array($val1, $n)
    {
		  $this->_type_id_array[$n] = $val1;
    }

 	public function setProperty_id_array($val1, $n)
    {
		  $this->_Property_id_array[$n] = $val1;
    }

 	public function setEvidence_id_array($val1, $n)
    {
		  $this->_evidence_id_array[$n] = $val1;
    }
		
 	public function setN_Type_id($val1)
    {
		  $this->_n_type_id = $val1;
    }	

 	public function setN_Property_id($val1)
    {
		  $this->_n_Property_id = $val1;
    }

 	public function setN_evidence_id($val1)
    {
		  $this->_n_evidence_id = $val1;
    }
	
		 	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getType_id_array($i)
    {
    	return $this->_type_id_array[$i];
    }

    public function getProperty_id_array($i)
    {
    	return $this->_Property_id_array[$i];
    }

    public function getEvidence_id_array($i)
    {
    	return $this->_evidence_id_array[$i];
    }
		
    public function getN_Type_id()
    {
    	return $this->_n_type_id;
    }	

    public function getN_Property_id()
    {
    	return $this->_n_Property_id;
    }	

    public function getN_evidence_id()
    {
    	return $this->_n_evidence_id;
    }	
		
    public function getName_table()
    {
    	return $this->_name_table;
    }	
			
}
?>	
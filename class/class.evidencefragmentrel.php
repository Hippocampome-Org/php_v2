<?php
class evidencefragmentrel
{
	private $_name_table;
	private $_id;
	private $_evidence_id_array;
	private $_n_evidence_id;
	private $_fragment_id_array;
	private $_n_fragment_id;
	private $_fragment_id;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_fragment_id_1($evidence_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Fragment_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setFragment_id($id);		
		}
	}	
	
	public function retrive_fragment_id($evidence_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Fragment_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setFragment_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_fragment_id($n);	
    }	

	public function retrieve_evidence_id($fragment_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT Evidence_id FROM $table WHERE Fragment_id = '$fragment_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setEvidence_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence_id($n);	
	}	

	// SET -------------------------------------
 	public function setEvidence_id_array($val1, $n)
    {
		  $this->_evidence_id_array[$n] = $val1;
    }
		
 	public function setN_evidence_id($val1)
    {
		  $this->_n_evidence_id = $val1;
    }

 	public function setFragment_id_array($val1, $n)
    {
		  $this->_fragment_id_array[$n] = $val1;
    }

 	public function setFragment_id($val1)
    {
		  $this->_fragment_id = $val1;
    }
			
 	public function setEvidence_id($val1)
    {
		  $this->_evidence_id = $val1;
    }
			
    public function setN_Fragment_id($val1)
    {
		  $this->_n_fragment_id = $val1;
    }


	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getEvidence_id_array($i)
    {
    	return $this->_evidence_id_array[$i];
    }
		
    public function getN_evidence_id()
    {
    	return $this->_n_evidence_id;
    }	

    public function getFragment_id_array($i)
    {
    	return $this->_fragment_id_array[$i];
    }

    public function getFragment_id()
    {
    	return $this->_fragment_id;
    }
			
    public function getEvidence_id()
    {
    	return $this->_evidence_id;
    }
			
    public function getN_Fragment_id()
    {
    	return $this->_n_fragment_id;
    }	
			
    public function getName_table()
    {
    	return $this->_name_table;
    }	

}

?>
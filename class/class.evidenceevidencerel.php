<?php
class evidenceevidencerel
{
	private $_name_table;
	private $_id;
	private $_evidence1_id;
	private $_evidence2_id_array;
	private $_type;	
	private $_n_evidence2;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_evidence2_id($evidence1_id)
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT Evidence2_id FROM $table WHERE Evidence1_id = '$evidence1_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setEvidence2_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_evidence2($n);	
	}



	// SET -------------------------------------
 	public function setEvidence2_id_array($val1, $n)
    {
		  $this->_evidence2_id_array[$n] = $val1;
    }	
	
 	public function setN_evidence2($val1)
    {
		  $this->_n_evidence2 = $val1;
    }	

	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getEvidence2_id_array($i)
    {
    	return $this->_evidence2_id_array[$i];
    }

    public function getN_evidence2()
    {
    	return $this->_n_evidence2;
    }	
	
    public function getName_table()
    {
    	return $this->_name_table;
    }	

}

?>

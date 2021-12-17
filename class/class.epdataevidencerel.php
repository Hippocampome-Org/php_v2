<?php
class epdataevidencerel
{
	private $_name_table;
	private $_epdata_id;
	private $_evidence_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrive_Epdata($evidence_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT Epdata_id FROM $table WHERE Evidence_id = '$evidence_id'";

		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setEpdata_id($id);		
		}	
	}		

	public function retrive_evidence_id($epdata_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT Evidence_id FROM $table WHERE Epdata_id = '$epdata_id'";

		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setEvidence_id($id);		
		}	
	}


	// SET -------------------------------------
 	public function setEpdata_id($val1)
    {
		  $this->_epdata_id = $val1;
    }

 	public function setEvidence_id($val1)
    {
		  $this->_evidence_id = $val1;
    }

	// GET ++++++++++++++++++++++++++++++++++++++	

    public function getName_table()
    {
    	return $this->_name_table;
    }	
		
    public function getEpdata_id()
    {
    	return $this->_epdata_id;
    }	
		
    public function getEvidence_id()
    {
    	return $this->_evidence_id;
    }	
}
?>
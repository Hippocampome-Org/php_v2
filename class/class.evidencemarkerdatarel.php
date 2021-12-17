<?php
class evidencemarkerdatarel
{
	private $_name_table;
	private $_id;
	private $_evidence_id;	
	private $_markerdata_id_array;
	private $_n_markerdata_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_Markerdata_id($evidence_id)
    {
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT Markerdata_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setMarkerdata_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_markerdata_id($n);	
	}





	// SET -------------------------------------
 	public function setMarkerdata_id_array($val1, $n)
    {
		  $this->_markerdata_id_array[$n] = $val1;
    }	
	
 	public function setN_markerdata_id($val1)
    {
		  $this->_n_markerdata_id = $val1;
    }		


	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getMarkerdata_id_array($i)
    {
    	return $this->_markerdata_id_array[$i];
    }

    public function getN_markerdata_id()
    {
    	return $this->_n_markerdata_id;
    }	
			
    public function getName_table()
    {
    	return $this->_name_table;
    }	

}
?>
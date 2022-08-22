<?php
class hc2nmo
{	
	private $_archive_array;
	private $_n_archive;
	private $_name_array;
	private $_n_name;
	private $_reason_for_inclusion_array;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrieve_archives_by_id($id)   // Retrieve all NMO archive by ID
	{
		$query = "SELECT DISTINCT NMO_archive FROM Hippocampome_to_NMO WHERE Hippocampome_ID = '$id' ORDER BY NMO_archive ASC";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($NMO_archive) = mysqli_fetch_row($rs))
		{	
			$this->setArchive_array($NMO_archive, $n);
			$n = $n + 1;
		}	
		$this->setN_archive($n);	
	}

	public function retrieve_neuron_names_by_id_and_archive($id, $archive)  // Retrieve all Neuron Names by ID and Archive
	{
		$archive = addslashes($archive);
		$query = "SELECT NMO_neuron_name, reason_for_inclusion FROM Hippocampome_to_NMO WHERE Hippocampome_ID = '$id' AND NMO_archive = '$archive' ORDER BY NMO_neuron_name ASC";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($NMO_neuron_name, $reason_for_inclusion) = mysqli_fetch_row($rs))
		{	
			$this->setName_array($NMO_neuron_name, $n);
			$this->setReason_for_inclusion_array($reason_for_inclusion, $n);
			$n = $n + 1;
		}	
		$this->setN_name($n);	
	}


	// SET -------------------------------------
	public function setArchive_array($var, $n)
    {
		$this->_archive_array[$n] = $var;
	}	

 	public function setN_archive($var)
	{
		$this->_n_archive = $var;
	}
	
	public function setName_array($var, $n)
    {
		$this->_name_array[$n] = $var;
	}	

 	public function setN_name($var)
	{
		$this->_n_name = $var;
	}
	
	public function setReason_for_inclusion_array($var, $n)
    {
		$this->_reason_for_inclusion_array[$n] = $var;
	}	


	// GET ++++++++++++++++++++++++++++++++++++++	  
    public function getArchive_array($i)
    {
    	return $this->_archive_array[$i];
    }		

	public function getN_archive()
	{
		return $this->_n_archive;
	}	
		
    public function getName_array($i)
    {
    	return $this->_name_array[$i];
    }		

	public function getN_name()
	{
		return $this->_n_name;
	}	
		
    public function getReason_for_inclusion_array($i)
    {
    	return $this->_reason_for_inclusion_array[$i];
    }		

}
?>

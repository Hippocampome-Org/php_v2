<?php
class articleevidencerel
{
	private $_name_table;
	private $_id;
	private $_evidence_id_array;
	private $_n_evidence_id;
	private $_article_id_array;
	private $_n_article_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_article_id($evidence_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT article_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setarticle_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_article_id($n);	
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

 	public function setarticle_id_array($val1, $n)
    {
		  $this->_article_id_array[$n] = $val1;
    }
		
 	public function setN_article_id($val1)
    {
		  $this->_n_article_id = $val1;
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

    public function getarticle_id_array($i)
    {
    	return $this->_article_id_array[$i];
    }
		
    public function getN_article_id()
    {
    	return $this->_n_article_id;
    }	
			
    public function getName_table()
    {
    	return $this->_name_table;
    }	

}

?>
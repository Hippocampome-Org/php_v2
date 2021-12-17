<?php
/*
	This is a custom class for adapting the articleevidencerel
	class for synapse probabilities results.

	_min_n_by_k_evidence_id and _max_n_by_k_evidence_id are manually
	set here for speed increases when users query the database rather
	than dynamically looking up ranges in the table PhasesEviProTypRel.
	PhasesEviProTypRel is where the evidence ids relevant here are
	stored.
*/
class articleevidencerel_phases
{
	private $_name_table;
	private $_n_by_k_name_table;
	private $_n_by_m_name_table;
	private $_id;
	private $_evidence_id_array;
	private $_n_evidence_id;
	private $_article_id_array;
	private $_n_article_id;
	private $_min_n_by_k_evidence_id;
	private $_max_n_by_k_evidence_id;

	function __construct ($name)
	{
		$this->_name_table = $name;
		$this->_n_by_k_name_table = "neurite_quantified";
		$this->_n_by_m_name_table = "count_of_contacts";
		$this->_min_n_by_k_evidence_id = 17505;
		$this->_max_n_by_k_evidence_id = 23403;
	}


	public function retrive_article_id($evidence_id)
    {
		$table=$this->getName_table();
		//$min_id=$this->_min_n_by_k_evidence_id;
		//$max_id=$this->_max_n_by_k_evidence_id;

		//$query = "SELECT DISTINCT article_id FROM $table WHERE Evidence_id = '$evidence_id' AND Evidence_id>17505";
		//$query = "SELECT DISTINCT article_id FROM $table WHERE Evidence_id = '$evidence_id'";
		$query = "SELECT pmid FROM phases_fragment WHERE id='$evidence_id';";
		//echo $query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setarticle_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_article_id($n);	
	}	

	public function retrive_articles_n_by_k($source, $target)
    {
		$table=$this->getName_table();
		$ref_ID = "";
	
		$query = "SELECT DISTINCT reference_ID FROM $table WHERE source = '".$source."' AND target = '".$target."'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while($ref_ID = mysqli_fetch_row($rs))
		{	
			$this->setarticle_id_array($ref_ID, $n);		
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
	
	public function getNbyK_table()
    {
    	return $this->_n_by_k_name_table;
    }	    
	
	public function getNbyM_table()
    {
    	return $this->_n_by_m_name_table;
    }
}

?>
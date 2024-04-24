<?php
class citations
{	
	private $_name_table;
	private $_id;
	private $_citation_ID;
	private $_brief_citation;
	private $_full_citation;
	private $_n_citations;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrieve_citations()
	{
		$query = "SELECT DISTINCT brief_citation FROM citations";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($brief_citation) = mysqli_fetch_row($rs))
		{
			$this->setCitations_array($brief_citation, $n);
			$n = $n + 1;		
		}	

		$this->setN_citations($n);
	}	
	
	public function retrieve_brief_citation($citation_ID)
	{
		$query = "SELECT DISTINCT brief_citation FROM citations WHERE citation_ID='$citation_ID'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$brief_citation="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{
			$brief_citation=$rows['brief_citation'];
		}
		return $brief_citation;	
	}	
	
	public function retrieve_full_citation($citation_ID)
	{
		$query = "SELECT DISTINCT full_citation FROM citations WHERE citation_ID='$citation_ID'";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$full_citation="";
		while($rows=mysqli_fetch_array($rs, MYSQLI_ASSOC))
		{
			$full_citation=$rows['full_citation'];
		}
		return $full_citation;	
	}	
	
	// SET -------------------------------------
 	public function setCitations_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }	
	
	public function setN_citations($var)
    {
		  $this->_n_citations = $var;
    }	
	
 	public function setBrief_citation($val)
    {
		  $this->_brief_citation = $val;
    }		
	
 	public function setFull_citation($val)
    {
		  $this->_full_citation = $val;
    }		
	
	// GET ++++++++++++++++++++++++++++++++++++++
    public function getCitations_array($i)
    {
    	return $this->_id_array[$i];
    }		
	
	public function getN_citations()
    {
    	return $this->_n_citations;
    }
	
    public function getBrief_citation()
    {
    	return $this->_brief_citation;
    }			
	
    public function getFull_citation()
    {
    	return $this->_full_citation;
    }			
	
}
?>

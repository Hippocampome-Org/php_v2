<?php
class article
{
	private $_name_table;
	private $_id;
	private $_pmid_isbn;
	private $_title;
	private $_publication;
	private $_volume;		
	private $_first_page;	
	private $_last_page;	
	private $_year;	
	private $_pmcid;
	private $_nihmsid;
	private $_doi;
	private $_open_access;
	private $_citation_count;
	private $_n_pmid;
	private $_issue;

	private $_id_array;
	private $_n_id;
	

	function __construct ($name)
	{
		$this->_name_table = $name;
	}
		
	public function retrive_by_id($id) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, pmid_isbn, pmcid, nihmsid, doi, open_access, title, publication, volume, issue, first_page, last_page, year, citation_count FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $pmid_isbn, $pmcid, $nihmsid, $doi, $open_access, $title, $publication, $volume, $issue, $first_page, $last_page, $year, $citation_count) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setPmid_isbn($pmid_isbn);
			$this->setPmcid($pmicid);
			$this->setNihmsid($nihmsid);
			$this->setDoi($doi);
			$this->setOpen_access($open_access);
			$this->setTitle($title);
			$this->setPublication($publication);		
			$this->setVolume($volume);
			$this->setIssue($issue);
			$this->setFirst_page($first_page);
			$this->setLast_page($last_page);			
			$this->setYear($year);
			$this->setCitation_count($citation_count);
		}
	}	
	
	
	public function retrive_by_pmid_isbn_and_page_number($pmid_isbn, $pmid_isbn_page)
	{
		$table=$this->getName_table();
	
		$query = "SELECT id, pmid_isbn, pmcid, nihmsid, doi, open_access, title, publication, volume, issue, first_page, last_page, year, citation_count FROM $table WHERE pmid_isbn='$pmid_isbn' AND first_page='$pmid_isbn_page'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $pmid_isbn, $pmcid, $nihmsid, $doi, $open_access, $title, $publication, $volume, $issue, $first_page, $last_page, $year, $citation_count) = mysqli_fetch_row($rs))
		{
			$this->setID($id);
			$this->setPmid_isbn($pmid_isbn);
			$this->setPmcid($pmicid);
			$this->setNihmsid($nihmsid);
			$this->setDoi($doi);
			$this->setOpen_access($open_access);
			$this->setTitle($title);
			$this->setPublication($publication);
			$this->setVolume($volume);
			$this->setIssue($issue);
			$this->setFirst_page($first_page);
			$this->setLast_page($last_page);
			$this->setYear($year);
			$this->setCitation_count($citation_count);
		}
	}
	
	public function retrive_by_pmid($pmid) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, pmcid, nihmsid, doi, open_access, title, publication, volume, issue, first_page, last_page, year, citation_count FROM $table WHERE Pmid_isbn = '$pmid'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $pmcid, $nihmsid, $doi, $open_access, $title, $publication, $volume, $issue, $first_page, $last_page, $year, $citation_count) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setPmcid($pmicid);
			$this->setNihmsid($nihmsid);
			$this->setDoi($doi);
			$this->setOpen_access($open_access);
			$this->setTitle($title);
			$this->setPublication($publication);		
			$this->setVolume($volume);
			$this->setIssue($issue);
			$this->setFirst_page($first_page);
			$this->setLast_page($last_page);			
			$this->setYear($year);
			$this->setCitation_count($citation_count);
		}
	}	

	public function retrive_number_PMID($flag)
	{
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT pmid_isbn FROM $table";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($pmcid) = mysqli_fetch_row($rs))
		{
			if ($flag == 1)
			{
				if (strlen($pmcid) < 10)
					$n = $n + 1;
			}
			if ($flag == 2)
			{
				if (strlen($pmcid) > 10)
					$n = $n + 1;
			}			
		}	
		
		$this->setN_pmid($n);
	}
	
	public function retrive_by_pmid_with_like($pmid, $flag) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, Pmid_isbn FROM $table WHERE Pmid_isbn LIKE '%$pmid%'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($id, $Pmid_isbn) = mysqli_fetch_row($rs))
		{	
			if ($flag == 1)
			{	
				if (strlen($Pmid_isbn) < 10)
				{
					$this->setID_array($id, $n);
					$n = $n +1;
				}
			}
			if ($flag == 2)
			{	
				if (strlen($Pmid_isbn) > 10)
				{
					$this->setID_array($id, $n);
					$n = $n +1;
				}
			}			
		}
		$this->setN_id($n);
	}	
	
	// SET -------------------------------------
 	public function setID($val)
    {
		  $this->_id = $val;
    }	
	
 	public function setPmid_isbn($val)
    {
		  $this->_pmid_isbn = $val;
    }		
	
 	public function setTitle($val)
    {
		  $this->_title = $val;
    }		
	
 	public function setPublication($val)
    {
		  $this->_publication = $val;
    }		
	
 	public function setVolume($val)
    {
		  $this->_volume = $val;
    }		
	
 	public function setFirst_page($val)
    {
		  $this->_first_page = $val;
    }		
	
 	public function setLast_page($val)
    {
		  $this->_last_page = $val;
    }		
	
 	public function setYear($val)
    {
		  $this->_year = $val;
    }		
	
 	public function setPmcid($val)
    {
		  $this->_pmicid = $val;
    }	
	
	 public function setNihmsid($val)
    {
		  $this->_nihmsid = $val;
    }	

 	public function setDoi($val)
    {
		  $this->_doi = $val;
    }	

 	public function setOpen_access($val)
    {
		  $this->_open_access = $val;
    }	

 	public function setCitation_count($val)
    {
		  $this->_citation_count = $val;
    }	

 	public function setN_pmid($val)
    {
		  $this->_n_pmid = $val;
    }	

 	public function setN_id($val)
    {
		  $this->_n_id = $val;
    }		

 	public function setIssue($val)
    {
		  $this->_issue = $val;
    }	
				
 	public function setID_array($val, $n)
    {
		  $this->_id_array[$n] = $val;
    }	
	
	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_id;
    }		
	
    public function getPmid_isbn()
    {
    	return $this->_pmid_isbn;
    }		
	
    public function getTitle()
    {
    	return $this->_title;
    }		
	
    public function getPublication()
    {
    	return $this->_publication;
    }		
	
    public function getVolume()
    {
    	return $this->_volume;
    }		
	
    public function getFirst_page()
    {
    	return $this->_first_page;
    }		
	
    public function getLast_page()
    {
    	return $this->_last_page;
    }		
	
	public function getYear()
    {
    	return $this->_year;
    }	
	
	public function getYearSansMonth()
    {
    	return substr($this->_year,0,4);
    }	

	public function getPmcid()
    {
    	return $this->_pmicid;
    }	
	
	public function getNihmsid()
    {
    	return $this->_nihmsid;
    }		
	
	public function getDoi()
    {
    	return $this->_doi;
    }	
	
	public function getOpen_access()
    {
    	return $this->_open_access;
    }	
	
	public function getCitation_count()
    {
    	return $this->_citation_count;
    }	

	public function getN_pmid()
    {
    	return $this->_n_pmid;
    }	

	public function getN_id()
    {
    	return $this->_n_id;
    }

	public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }
	
    public function getIssue()
    {
    	return $this->_issue;
    }	
						
    public function getName_table()
    {
    	return $this->_name_table;
    }		
}

?>

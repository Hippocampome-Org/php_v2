<?php
class term
{
	private $_name_table;
	private $_id;
	private $_dt;
	private $_parent;
	private $_concept;
	private $_term;
	private $_resource_rank;
	private $_resource;
	private $_portal;
	private $_repository;
	private $_unique_id;
	private $_definition_link;
	private $_definition;
	private $_protein_gene;
	private $_human_rat;
	private $_control;

	private $_name;
	private $_name_neuron_array;
	private $_name_neuron;
	private $_n_id;
	private $_id_array;
	private $_term_concept;
	private $_parent_concept;

	function __construct ($name)
	{
		$this->_name_table = $name;
	}

	public function retrive_by_id($id)   // Retrive name by ID
	{
		$table = $this->getName_table();
		
		$query = "SELECT id, dt, parent, concept, term, resource_rank, resource, portal, repository, unique_id, definition_link, definition, protein_gene, human_rat, control FROM $table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while (list($id, $dt, $parent, $concept, $term, $resource_rank, $resource, $portal, $repository, $unique_id, $definition_link, $definition, $protein_gene, $human_rat, $control) = mysqli_fetch_row($rs))
		{	
			$this->setId($id);
			$this->setDt($dt);
			$this->setParent($parent);
			$this->setConcept($concept);
			$this->setTerm($term);
			$this->setResourceRank($resource_rank);
			$this->setResource($resource);
			$this->setPortal($portal);
			$this->setRepository($repository);
			$this->setUniqueID($unique_id);
			$this->setDefinitionLink($definition_link);
			$this->setDefinition($definition);
			$this->setProteinGene($protein_gene);
			$this->setHumanRat($human_rat);
			$this->setControl($control);
		}
	}

	public function retrive_name() 
	{
		$table=$this->getName_table();
		
		$query = "SELECT DISTINCT term FROM $table ORDER BY term";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setName_neuron_array($id, $n);						
			$n = $n + 1;
		}
		$this->setName_neuron($n);			
	}

	public function retrive_term_concept($concept) 
	{
		$table=$this->getName_table();
		$this->_term_concept = Array();
		$query = "SELECT DISTINCT term FROM $table WHERE concept='$concept'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
             $_term_concept[] = $id;		
		}
		return $_term_concept;
					
	}	
	
	public function retrive_parent_concept($concept) 
	{
		$table=$this->getName_table();
		$this->_parent_concept = Array();
		$query = "SELECT DISTINCT parent FROM $table WHERE concept='$concept'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
             $_parent_concept[] = $id;		
		}
		return $_parent_concept;
					
	}	

	//new method 
	public function retrive_id_by_name($name) //Retrieve id by the name from table 'Term'
	{
		$table = $this->getName_table();
		$name = mysqli_real_escape_string($GLOBALS['conn'],$name);

		// get concept for term
		$termconcept = $name;
		$query = "SELECT id, concept FROM $table WHERE term = '$name'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $concept) = mysqli_fetch_row($rs))
		{	
			$termconcept = $concept;
			break;
		}

		// use concept instead of term in query
		$query = "SELECT id FROM $table WHERE concept = '$termconcept' GROUP BY definition ORDER BY resource_rank";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{
			$this->setID_array($id, $n);
			$n = $n + 1;
		}
		$this->setN_id($n);
	}
	
	// SET -------------------------------------	
	public function setName_neuron_array($val, $n)
	{
		$this->_name_neuron_array[$n] = $val;
	}
	public function setName_neuron($val)
	{
		$this->_name_neuron = $val;
	}
	public function setId($var)
	{
		$this->_id = $var;
	}
	public function setDt($var)
	{
		$this->_dt = $var;
	}
	public function setParent($var)
	{
		$this->_parent = $var;
	}
	public function setConcept($var)
	{
		$this->_concept = $var;
	}
	public function setTerm($var)
	{
		$this->_term = $var;
	}
	public function setResourceRank($var)
	{
		$this->_resource_rank = $var;
	}
	public function setResource($var)
	{
		$this->_resource = $var;
	}
	public function setPortal($var)
	{
		$this->_portal = $var;
	}
	public function setRepository($var)
	{
		$this->_repository = $var;
	}
	public function setUniqueID($var)
	{
		$this->_unique_id = $var;
	}
	public function setDefinitionLink($var)
	{
		$this->_definition_link = $var;
	}
	public function setDefinition($var)
	{
		$this->_definition = $var;
	}
	public function setProteinGene($var)
	{
		$this->_protein_gene = $var;
	}
	public function setHumanRat($var)
	{
		$this->_human_rat = $var;
	}
	public function setControl($var)
	{
		$this->_control = $var;
	}
	public function setName($var)
	{
		$this->_name = $var;
	}
	public function setID_array($var, $n)
	{
		$this->_id_array[$n] = $var;
	}
	public function setN_id($var)
	{
		$this->_n_id = $var;
	}

	// GET ++++++++++++++++++++++++++++++++++++++		
	public function getName_neuron_array($i)
	{
		return $this->_name_neuron_array[$i];
	}
	public function getName_neuron()
	{
		return $this->_name_neuron;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function getDt()
	{
		return $this->_dt;
	}
	public function getParent()
	{
		return $this->_parent;
	}
	public function getConcept()
	{
		return $this->_concept;
	}
	public function getTerm()
	{
		return $this->_term;
	}
	public function getResourceRank()
	{
		return $this->_resource_rank;
	}
	public function getResource()
	{
		return $this->_resource;
	}
	public function getPortal()
	{
		return $this->_portal;
	}
	public function getRepository()
	{
		return $this->_repository;
	}
	public function getUniqueID()
	{
		return $this->_unique_id;
	}
	public function getDefinitionLink()
	{
		return $this->_definition_link;
	}
	public function getDefinition()
	{
		return $this->_definition;
	}
	public function getProteinGene()
	{
		return $this->_protein_gene;
	}
	public function getHumanRat()
	{
		return $this->_human_rat;
	}
	public function getControl()
	{
		return $this->_control;
	}
	public function getName()
	{
		return $this->_name;
	}
	public function getName_table()
	{
		return $this->_name_table;
	}
	public function getID_array($i)
	{
		return $this->_id_array[$i];
	}
	public function getN_id()
	{
		return $this->_n_id;
	}
}
?>

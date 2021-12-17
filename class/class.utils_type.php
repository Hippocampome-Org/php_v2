<?php

class utils_type{
	private $_name;
	private $_nickname;
	private $_status;
	private $_id;
	function __construct() {
   	}
    // retrive neuron names and id starting with $letter
    public function retriveNeuronsWithLetter($letter){
        $types_array=array();
        $index=0;
        // set letter as blank so that all name associated with type and synonym will be fetched in case of all.
        if($letter=='all'){
            $letter='';
        }
        // fetch the neuron name from name-type,nickname-type and name-synonym(column-table) starting with letter.
        $query_to_get_neurons_name=" SELECT id,name FROM Type WHERE name LIKE '".$letter."%' OR name LIKE '".strtolower($letter)."%' 
                                    UNION SELECT id,nickname as name FROM Type WHERE nickname LIKE '".$letter."%' OR nickname LIKE '".strtolower($letter)."%' 
                                    UNION SELECT cell_id,name FROM Synonym WHERE name LIKE '".$letter."%' OR name LIKE '".strtolower($letter)."%'
                                    ORDER BY name";
        //print("Query:".$query_to_get_neurons_name);
        $type_records = mysqli_query($GLOBALS['conn'],$query_to_get_neurons_name);
        if (!$type_records) {
            die("<p>Error in Listing Searched Neuron Records.</p>");
        }
        while($rows=mysqli_fetch_array($type_records, MYSQLI_ASSOC))
        {
            $name=$rows['name'];
            $id = $rows['id'];
            $types_array[$index]=new utils_type();
            $types_array[$index]->setName($rows['name']);
            $types_array[$index]->setId($rows['id']);
            $index++;   
        }
        
        return $types_array;
    }
  
   	public function setName($var)
    {
    	$this->_name = $var;
    }	
 	public function setNickname($var)
    {
        $this->_nickname = $var;
	}
	public function setStatus($var)
    {
    	$this->_status = $var;
    }		
 	public function setId($var)
    {
        $this->_id = $var;
	}
   	public function getName()
    {
    	return $this->_name;
    }	
 	public function getNickname()
    {
        return $this->_nickname;
	}
	public function getStatus()
    {
    	return $this->_status;
    }		
 	public function getId()
    {
        return $this->_id;
	}
}

?>

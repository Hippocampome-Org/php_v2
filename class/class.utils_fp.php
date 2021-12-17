<?php

class utils_fp{
	private $_name;
	private $_nickname;
	private $_status;
	private $_id;
	function __construct() {
   	}
    // retrive neuron names and id starting with $letter
    public function retriveNeuronsWithFP(){
        $types_array=array();
        $index=0;
        // set letter as blank so that all name associated with type and synonym will be fetched in case of all.
       // fetch the neuron name from name-type,nickname-type and name-synonym(column-table) starting with letter.
        $query_to_get_neurons_name=" SELECT DISTINCT fp.fp_name ,'' as type_id
                    FROM FiringPattern fp, FiringPatternRel fpr
                    WHERE fp.definition_parameter LIKE 'parameter'
                    AND fp.id=fpr.FiringPattern_id and fp.fp_name > '' ORDER BY fp.fp_name";
        //print("Query:".$query_to_get_neurons_name);
        $type_records = mysqli_query($GLOBALS['conn'],$query_to_get_neurons_name);
        if (!$type_records) {
            die("<p>Error in Listing Searched Neuron Records.</p>");
        }
        while($rows=mysqli_fetch_array($type_records, MYSQLI_ASSOC))
        {
            $name=$rows['fp_name'];
            $id = $rows['type_id'];
            $types_array[$index]=new utils_fp();
            $types_array[$index]->setName($name);
            $types_array[$index]->setId($id);
            //echo "$name,$id";
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

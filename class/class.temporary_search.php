<?php
class temporary_search
{
	private $_id;
	private $_N;
	private $_operator;
	private $_property;
	private $_part;
	private $_relation;
	private $_value;
	private $_min;
	private $_max;
	private $_mean;
	private $_name_table;
	private $n_search;
		
	private $_id_array;
	private $_n_id;	
		
	public function create_temp_table()
	{	
		$name_temporary_table=$this->getName_table();
	
		$drop_table ="DROP TABLE $name_temporary_table";
		$query = mysqli_query($GLOBALS['conn'],$drop_table);
		
		$creatable=	"CREATE TABLE IF NOT EXISTS $name_temporary_table (
					   id int(4) NOT NULL AUTO_INCREMENT,
					   N int(3),
					   operator varchar(20),
					   property varchar(100),
					   part varchar(100),
					   relation varchar(100),
					   value varchar(100),
					   min varchar(100),
					   max varchar(100),
					   mean varchar(100),
					   PRIMARY KEY (id));";
		$query = mysqli_query($GLOBALS['conn'],$creatable);
	}	
	
	
	public function update($flag, $property, $part, $relation, $value, $N)
	{	
		$name_temporary_table=$this->getName_table();
		
		if ($flag == 1)  // Update Property
			$query = "UPDATE $name_temporary_table SET property = '$property', part = '$part', relation = '$relation', value = '$value', min=NULL, max=NULL, mean=NULL WHERE  id = '$N' ";	
		if ($flag == 2)  // Update Part
			$query = "UPDATE $name_temporary_table SET part = '$part', relation = NULL, value = NULL WHERE  id = '$N' ";
		if ($flag == 3)  // Update Relation
			$query = "UPDATE $name_temporary_table SET relation = '$relation' WHERE id = '$N' ";	
		if ($flag == 4) { // Update Value 
			$value = str_replace('( )', '(+)', $value);	// hack to replace plus signs
			$query = "UPDATE $name_temporary_table SET value = '$value' WHERE id = '$N' ";
		}			
		
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}		

	public function retrieve_by_id($id)
	{
		$name_temporary_table=$this->getName_table();

		$query = "SELECT id, N, operator, property, part, relation, value FROM $name_temporary_table WHERE id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $N, $operator, $property, $part, $relation, $value) = mysqli_fetch_row($rs))
		{
			$this->setID($id);
			$this->setN($N);
			$this->setOperator($operator);
			$this->setProperty($property);
			$this->setPart($part);
			$this->setRelation($relation);
			$this->setValue($value);
		}			
	}
	
	public function retrieve_n_search()
	{
		$name_temporary_table=$this->getName_table();
		
		$query = "SELECT N FROM $name_temporary_table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($N) = mysqli_fetch_row($rs))
			 $n = $n + 1;	
			 
		$this->setN_search($n);	 	
	}
	
	public function retrieve_id_array()
	{
		$name_temporary_table=$this->getName_table();
		
		$query = "SELECT id FROM $name_temporary_table";	
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($id)	= mysqli_fetch_row($rs))		
		{
			$this->setID_array($id, $n);
			$n = $n + 1;
		}		
		$this->setN_id($n);
	}	
		
	public function remove_line($line)
	{
		$name_temporary_table=$this->getName_table();
		
		$query = "DELETE FROM $name_temporary_table WHERE id = '$line'";			
		$rs2 = mysqli_query($GLOBALS['conn'],$query);	
	}
	
	public function insert_temporary($N, $property, $part, $relation, $value, $operator)
	{
		$table=$this->getName_table();
	
		$query_i = "INSERT INTO $table
		  (id,
			N,
			operator,
			property,
			part,
			relation,
			value,
			max,
			min,
			mean
		   )
		VALUES
		  (NULL,
			'$N',
			'$operator',
			'$property',
			'$part',
			'$relation',
			'$value',
			NULL,
			NULL,
			NULL
		   )";
		$rs2 = mysqli_query($GLOBALS['conn'],$query_i);	
	}



	
	// GET -------------------------------------	
 	public function getName_table()
    {
		  return $this->_name_table;
    }	
		
 	public function getID()
    {
		  return $this->_id;
    }	
	
	public function getN()
    {
		  return $this->_N;
    }	
	
	public function getOperator()
    {
		  return $this->_operator;
    }	
	
	public function getProperty()
    {
		  return $this->_property;
    }	
	
	public function getPart()
    {
		  return $this->_part;
    }	
	
	public function getRelation()
    {
		  return $this->_relation;
    }	
	
	public function getValue()
    {
		  return $this->_value;
    }	
	
	public function getMin()
    {
		  return $this->_min;
    }	
	
	public function getMax()
    {
		  return $this->_max;
    }	
	
	public function getMean()
    {
		  return $this->_mean;
    }	

	public function getN_search()
    {
		  return $this->_n_search;
    }	

	public function getN_id()
    {
		  return $this->_n_id;
    }	
	
	public function getID_array($i)
    {
		  return $this->_id_array[$i];
    }		
		
	// SET -------------------------------------	
 	public function setName_table($var)
    {
		  $this->_name_table = $var;
    }	
	
	public function setID($var)
    {
		  $this->_id = $var;
    }	
	
	public function setN($var)
    {
		  $this->_N = $var;
    }	
	
	public function setOperator($var)
    {
		  $this->_operator = $var;
    }	
	
	public function setProperty($var)
    {
		  $this->_property = $var;
    }	
	
	public function setPart($var)
    {
		  $this->_part = $var;
    }	
	
	public function setRelation($var)
    {
		  $this->_relation = $var;
    }	
	
	public function setValue($var)
    {
		  $this->_value = $var;
    }	
	
	public function setMin($var)
    {
		  $this->_min = $var;
    }	
	
	public function setMax($var)
    {
		  $this->_max = $var;
    }	
	
	public function setMean($var)
    {
		  $this->_mean = $var;
    }			
	
	public function setN_search($var)
    {
		  $this->_n_search = $var;
    }

	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }
	
	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }

}

?>
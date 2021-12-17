<?php
class firingpatternrel
{
	private $_name_table;
	private $_firing_pattern_id;
	private $_type_id;
	private $_pattern_array;
	private $_n_firing_pattern_id;
	private $_type_id_array_count1;
	private $_type_id_array_count2;
	private $_type_id_array_count3;
	private $_type_id_array_count4;
	private $_n_type_id_array_count1;
	private $_n_type_id_array_count2;
	private $_n_type_id_array_count3;
	private $_n_type_id_array_count4;
	
	
	function __construct($name)
	{
		$this->_name_table = $name;
	}
	
	function retrieve_by_typeId($id)
	{
		$table=$this->getName_table();	
	
		$query = "SELECT FiringPattern_id FROM $table WHERE Type_id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($firingpatternid) = mysqli_fetch_row($rs))
		{
			$this->setPattern_array($firingpatternid, $n);
			$n=$n+1;
		}
		$this->setN_firing_pattern_ID($n);	
	}
	
	function retrieve_by_firingPatternId($id)
	{
		$table=$this->getName_table();	
	
		$query = "SELECT Type_id FROM $table WHERE FiringPattern_id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		
		while(list($Type_id) = mysqli_fetch_row($rs))
		{
				$this->setTypeId($Type_id);
		}	
	}
	
	//SET---------------------
	public function setFiringPatternId($var)
    {
		  $this->_firing_pattern_id = $var;
    }	
	
	public function setTypeId($var)
    {
		  $this->_type_id = $var;
    }
	
	public function setPattern_array($val1, $n)
	{
		$this->_pattern_array[$n] = $val1;
	}
	
	public function setN_firing_pattern_ID($var)
    {
		  $this->_n_firing_pattern_id = $var;
    }
	
	public function setType_id_array_count1($val1, $n)
	{
			$this->_type_id_array_count1[$n] = $val1;
	}
	
	public function setType_id_array_count2($val1, $n)
	{
			$this->_type_id_array_count2[$n] = $val1;
	}
	
	public function setType_id_array_count3($val1, $n)
	{
			$this->_type_id_array_count3[$n] = $val1;
	}
	
	public function setType_id_array_count4($val1, $n)
	{
			$this->_type_id_array_count4[$n] = $val1;
	}
	
	public function setN_type_id_array_count1($var)
    {
		  $this->_n_type_id_array_count1 = $var;
    }
	
	public function setN_type_id_array_count2($var)
    {
		  $this->_n_type_id_array_count2 = $var;
    }
	
	public function setN_type_id_array_count3($var)
    {
		  $this->_n_type_id_array_count3 = $var;
    }
	
	public function setN_type_id_array_count4($var)
    {
		  $this->_n_type_id_array_count4 = $var;
    }
	
	//GET-----------------------
	public function getName_table()
    {
		  return $this->_name_table;
    }
	
	public function getFiringPatternId()
    {
		  return $this->_firing_pattern_id;
    }
	
	public function getTypeId()
    {
		  return $this->_type_id;
    }
	
	public function getType_id_array_count1($i)
    {
		  return $this->_type_id_array_count1[$i];
    }
	
	public function getType_id_array_count2($i)
    {
		  return $this->_type_id_array_count2[$i];
    }
	
	public function getType_id_array_count3($i)
    {
		  return $this->_type_id_array_count3[$i];
    }
	
	public function getType_id_array_count4($i)
    {
		  return $this->_type_id_array_count4[$i];
    }
	
	public function getPattern_array($i)
	{
		return $this->_pattern_array[$i];
	}
	
	public function getN_firing_pattern_ID()
	{
		return $this->_n_firing_pattern_id;
	}
	
	public function getN_type_id_array_count1()
	{
		return $this->_n_type_id_array_count1;
	}
	
	public function getN_type_id_array_count2()
	{
		return $this->_n_type_id_array_count2;
	}
	
	public function getN_type_id_array_count3()
	{
		return $this->_n_type_id_array_count3;
	}
	
	public function getN_type_id_array_count4()
	{
		return $this->_n_type_id_array_count4;
	}
	
}
?>
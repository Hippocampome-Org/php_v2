<?php
class fragmenttyperel
{
	private $_fragment_id;
	private $_type_id;
	private $_priority;	
	
	public function retrive_fragment_id($type_id)
    {
		$query = "SELECT DISTINCT Fragment_id FROM FragmentTypeRel WHERE type_id = '$type_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setFragment_id($id);		
		}		
	}	

	public function retrive_fragment_id_priority_uno($type_id)
    {
		$query = "SELECT DISTINCT Fragment_id FROM FragmentTypeRel WHERE type_id = '$type_id' AND priority = '1'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setFragment_id($id);		
		}		
	}	
		

	public function setFragment_id($val1)
    {
		  $this->_fragment_id = $val1;
    }
	
	public function setPriority($val1)
    {
		  $this->_priority = $val1;
    }	
	
	
	
	 public function getFragment_id()
    {
    	return $this->_fragment_id;
    }
	
	 public function getPriority()
    {
    	return $this->_priority;
    }	
	
	
}
?>
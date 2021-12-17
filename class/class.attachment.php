<?php
class attachment
{
	private $_name_table;
	private $_a_id;
	private $_cell_id;
	private $_a_original_id;
	private $_name;	
	private $_a_type;	
	private $_protocol_tag;
	//unused
	
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	

	
	public function retrive_by_id($id ,$id_neuron) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, cell_id, original_id, name, type, protocol_tag FROM Attachment WHERE id = '$id' and cell_id = '$id_neuron'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id,$cell_id, $original_id, $name, $type, $protocol_tag) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setCell_id($cell_id);
			$this->setOriginal_id($original_id);	
			$this->setName($name);	
			$this->setProtocol_tag($protocol_tag);
			$this->setType($type);	
				
		}
	}
	
	public function retrieve_by_originalId($original_id ,$id_neuron) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, cell_id, original_id, name, type, protocol_tag FROM Attachment WHERE original_id = '$original_id' and cell_id = '$id_neuron'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id,$cell_id, $original_id, $name, $type, $protocol_tag) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setCell_id($cell_id);
			$this->setOriginal_id($original_id);	
			$this->setName($name);	
			$this->setProtocol_tag($protocol_tag);
			$this->setType($type);		
		}
	}
	
	public function retrive_attachment_by_original_id($id,$id_neuron)
	{
		$table=$this->getName_table();
		//print("original id:".$id);
		//print("cell id".$id_neuron);
		$query = "SELECT name, type FROM Attachment WHERE original_id = '$id' and cell_id = '$id_neuron'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		if(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		{
		//	while(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		//	{	
		//		print("attachment:".$attachment);
				$this->setName($attachment);	
				$this->setType($attachment_type);	
		//	}
		}
		else{
			$attachment="";
			$attachment_type="";
			$this->setName($attachment);	
				$this->setType($attachment_type);	
		}		
		//print("figure:".$this->getName());
	}
	
	public function retrieve_attachment_by_original_id($id,$id_neuron,$parameter)
	{
		$table=$this->getName_table();
		//print("original id:".$id);
		//print("cell id".$id_neuron);
		$query = "SELECT name, type FROM Attachment WHERE original_id = '$id' and cell_id = '$id_neuron' and parameter= '$parameter'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		if(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		{
			//	while(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
			//	{
			//		print("attachment:".$attachment);
			$this->setName($attachment);
			$this->setType($attachment_type);
			//	}
		}
		else{
			$attachment="";
			$attachment_type="";
			$this->setName($attachment);
			$this->setType($attachment_type);
		}
		//print("figure:".$this->getName());
	}

	public function retrieve_attachment_by_original_id_protocolTag($id,$id_neuron,$parameter,$protocolTag)
	{
		$table=$this->getName_table();
		//print("original id:".$id);
		//print("cell id".$id_neuron);
		$query = "SELECT name, type FROM Attachment WHERE original_id = '$id' and cell_id = '$id_neuron' and parameter= '$parameter' and protocol_tag LIKE '$protocolTag'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		if(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		{
			//	while(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
			//	{
			//		print("attachment:".$attachment);
			$this->setName($attachment);
			$this->setType($attachment_type);
			//	}
		}
		else{
			$attachment="";
			$attachment_type="";
			$this->setName($attachment);
			$this->setType($attachment_type);
		}
		//print("figure:".$this->getName());
	}
	// SET -------------------------------------
 	public function setID($val)
    {
		  $this->_a_id = $val;
    }
    //new
	public function setCell_id($val)
    {
		  $this->_cell_id = $val;
    }
    
    
 	public function setOriginal_id($val)
    {
		  $this->_a_original_id = $val;
    }
    
	public function setName($val)
    {
		  $this->_name = $val;
    }
	
	public function setProtocol_tag($protocol_tag)
	{
		$this->_protocol_tag = $protocol_tag;
	}
    //new ends
	
 	
 	public function setType($val)
    {
		  $this->_a_type = $val;
    }

 	

	
			
 	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_a_id;
    }	
			

    public function getOriginal_id()
    {
    	return $this->_a_original_id;
    }

    public function getType()
    {
    	return $this->_a_type;
    }
				
    public function getName_table()
    {
    	return $this->_name_table;
    }	
	
	public function getProtocol_tag()
	{
		return $this->_protocol_tag;
	}
		
    
    
     //new
	public function getCell_id()
    {
		  return $this->_cell_id;
    }
    
	public function getName()
    {
		  return $this->_name;
    }
    //new ends
    
    
	
}

?>

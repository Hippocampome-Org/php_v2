<?php
class articleauthorrel
{
	private $_name_table;
	private $_id;
	private $_article_id;
	private $_n_author_id;
	private $_author_id_array;
	private $_author_position_array;
	private $_article_id_array;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}


	public function retrive_author_id($article_id, $position)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT author_id FROM $table WHERE Article_id = '$article_id' AND author_pos = '$position'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setAuthor_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_author_id($n);	
	}	

	public function retrive_article_id($author_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT DISTINCT article_id FROM $table WHERE Author_id = '$author_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($id) = mysqli_fetch_row($rs))
		{	
			$this->setArticle_id_array($id, $n);		
			$n = $n +1;
		}
		$this->setN_author_id($n);	
	}


	public function retrive_author_position($article_id)
    {
		$table=$this->getName_table();
	
		$query = "SELECT author_pos FROM $table WHERE Article_id = '$article_id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($pos) = mysqli_fetch_row($rs))
		{	
			$this->setAuthor_position_array($pos, $n);		
			$n = $n +1;
		}
		$this->setN_author_id($n);	
	}	
	
	
	// SET -------------------------------------
 	public function setAuthor_id_array($val1, $n)
    {
		  $this->_author_id_array[$n] = $val1;
    }

 	public function setAuthor_position_array($val1, $n)
    {
		  $this->_author_position_array[$n] = $val1;
    }
			
 	public function setN_author_id($val1)
    {
		  $this->_n_author_id = $val1;
    }

	 public function setArticle_id($val1)
    {
		  $this->_article_id = $val1;
    }
	
 	public function setArticle_id_array($val1, $n)
    {
		  $this->_article_id_array[$n] = $val1;
    }	
		

	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getAuthor_id_array($i)
    {
    	return $this->_author_id_array[$i];
    }

    public function getAuthor_position_array($i)
    {
    	return $this->_author_position_array[$i];
    }
			
    public function getN_author_id()
    {
    	return $this->_n_author_id;
    }	

    public function getArticle_id_array($i)
    {
    	return $this->_article_id_array[$i];
    }
		
    public function getArticle_id()
    {
    	return $this->_article_id;
    }	

    public function getName_table()
    {
    	return $this->_name_table;
    }	
		
}

?>
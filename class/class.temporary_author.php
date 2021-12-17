<?php

class temporary_author
{
	private $_id;
	private $_letter;
	private $_author;
	private $_name_table;
	private $_n_id;
	private $_id_array;
	private $_author_array=array();


	public function create_temp_table ()
	{	
		$table=$this->getName_table();
	
		$drop_table ="DROP TABLE $table";
		$query = mysqli_query($GLOBALS['conn'],$drop_table);
		
		$creatable=	"CREATE TABLE IF NOT EXISTS $table (
					   id int(4) NOT NULL AUTO_INCREMENT,
					   letter varchar(3),
					   author varchar(200),
					   PRIMARY KEY (id));";
		$query = mysqli_query($GLOBALS['conn'],$creatable);
	}
	public function retriveAuthorsWithLetter($letter){
        $authors_array=array();
        $index=0;
        // set letter as blank so that all name associated with author will be fetched in case of all.
        if($letter=='all'){
            $letter='';
        }
        $query_to_get_authors_name=" SELECT name FROM Author where name LIKE '".$letter."%' ORDER BY name";
        $author_records = mysqli_query($GLOBALS['conn'],$query_to_get_authors_name);
        if (!$author_records) {
            die("<p>Error in Listing Author Records.:" . mysql_error() . "</p>");
        }
        while($rows=mysqli_fetch_array($author_records, MYSQLI_ASSOC))
        {
            $authors_array[$index]=$rows['name'];
            $index++;   
        }        
        return $authors_array;
    }
    public function retriveSearchedAuthors(){
        $authors_array=array();
        $index=0;
        $table=$this->getName_table();
        $query_to_get_authors_name=" SELECT id,letter,author FROM $table";
        $author_records = mysqli_query($GLOBALS['conn'],$query_to_get_authors_name);
        if (!$author_records) {
            die("<p>Error in Listing Author Records.:" . mysql_error() . "</p>");
        }
        while($rows=mysqli_fetch_array($author_records, MYSQLI_ASSOC))
        {
            $id=$rows['id'];
            $letter=$rows['letter'];
            $author_name=$rows['author'];
            $authors_array[$index]=new temporary_author();
            $authors_array[$index]->setId($id);
            $authors_array[$index]->setAuthor($author_name);
            $authors_array[$index]->setLetter($letter);
            $index++;   
        }        
        return $authors_array;
    }

	public function insert_temporary($letter, $author)
	{
		//set_magic_quotes_runtime(0);
		if (get_magic_quotes_gpc()) {
        	$author = stripslashes($author);    
    	}
		$author= mysqli_real_escape_string($GLOBALS['conn'],$author);
		$table=$this->getName_table();
			
		$query_i = "INSERT INTO $table (id, letter, author) VALUES (NULL, '$letter', '$author')";
		$rs2 = mysqli_query($GLOBALS['conn'],$query_i);	
	}

	public function update_temporary($letter, $author, $flag, $id)
	{
	//set_magic_quotes_runtime(0);
	
    	if (get_magic_quotes_gpc()) {
        	$author = stripslashes($author);    
    	}
    
		$author= mysqli_real_escape_string($GLOBALS['conn'],$author);	
		$table=$this->getName_table();
	
		if ($flag == 1) // Update letter:
		{
			$query_i = "UPDATE $table SET letter = '$letter', author = '$author' WHERE id='$id'";				
		}
		if ($flag == 2) // Update author:
		{
			$query_i = "UPDATE $table SET author = '$author' WHERE id='$id'";	
		}
		$rs2 = mysqli_query($GLOBALS['conn'],$query_i);
	}


	public function retrieve_id()
	{
		$table=$this->getName_table();
	
		$query = "SELECT id, author FROM $table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n = 0;
		while(list($id, $author) = mysqli_fetch_row($rs))
		{
			$this->setID_array($id, $n);
			$this->setAuthor_array($author, $n);
			$n = $n + 1;
		}
		$this->setN_id($n);
	}

	public function retrieve_letter_from_id($id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT letter FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{
			$this->setLetter($var);
		}
	}

	public function retrieve_author_from_id($id)
	{
		$table=$this->getName_table();
	
		$query = "SELECT author FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($var) = mysqli_fetch_row($rs))
		{
			$this->setAuthor($var);
		}
	}
	
	public function remove($id)
	{
		$table=$this->getName_table();
	
		$query = "DELETE FROM $table WHERE id='$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
	}
	public function removeAll()
	{
		$table=$this->getName_table();
	
		$query = "DELETE FROM $table";
		$rs = mysqli_query($GLOBALS['conn'],$query);
	}
	
		
	// SET -------------------------------------	
 	public function setName_table($var)
    {
		  $this->_name_table = $var;
    }	
		
 	public function setN_id($var)
    {
		  $this->_n_id = $var;
    }	

 	public function setID_array($var, $n)
    {
		  $this->_id_array[$n] = $var;
    }	

 	public function setAuthor_array($var, $n)
    {
		  $this->_author_array[$n] = $var;
    }	
	
 	public function setLetter($var)
    {
		  $this->_letter = $var;
    }	

 	public function setAuthor($var)
    {
		  $this->_author = $var;
    }	
    public function setId($var)
    {
		  $this->_id = $var;
    }
  
	
	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getName_table()
    {
    	return $this->_name_table;
    }	
		
    public function getID()
    {
    	return $this->_id;
    }

    public function getLetter()
    {
    	return $this->_letter;
    }

    public function getAuthor()
    {
    	return $this->_author;
    }

    public function getN_id()
    {
    	return $this->_n_id;
    }

    public function getID_array($i)
    {
    	return $this->_id_array[$i];
    }
	
    public function getAuthor_array($i)
    {
    	return $this->_author_array[$i];
    }	
	public function getCanonical_author($author)
    {
    	$author = substr($author, 0,(strpos($author, ' ')+2)); //1st parameter string,2nd parameter starting index ,3rd parameter total length after the space
		$author= mysqli_real_escape_string($GLOBALS['conn'],$author);
		$query_canonical="SELECT name FROM Author WHERE name LIKE '$author%'"; //Bring all the authors with first name and first initial of the last name same.
		$rs = mysqli_query($GLOBALS['conn'],$query_canonical);	
		$i=0;				
		while(list($author_name) = mysqli_fetch_row($rs))	
		{	
			$canonical[$i]=$author_name;
			$i++;
		}
		return $canonical;
    }
    
	
}
?>

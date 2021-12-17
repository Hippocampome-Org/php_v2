<?php
class fragment_synpro
{
	private $_name_table;
	private $_id;
	private $_quote;
	private $_original_id;
	private $_page_location;
	private $_pmid_isbn;
	private $_pmid_isbn_page;	
	private $_type;	
	private $_attachment;
	private $_attachment_type;
	private $_attachment_array;
	private $_attachment_type_array;
	private $_interpretation;
	private $_interpretation_notes;
	//private $_linking_cell_id;
	private $_linking_pmid_isbn;
	private $_linking_pmid_isbn_page;
	private $_linking_quote;
	private $_linking_page_location;
	private $_number_attachment;
	
	function __construct ($name)
	{
		$this->_name_table = $name;
	}
	
	public function retrive_by_id($id) 
    {
		$table=$this->getName_table();
		
		$query = "SELECT id, original_id, quote, page_location, pmid_isbn, pmid_isbn_page, type, attachment, attachment_type, interpretation, interpretation_notes, linking_pmid_isbn, linking_pmid_isbn_page, linking_quote, linking_page_location FROM $table WHERE id = '$id'";
		//echo $query;
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($id, $original_id, $quote, $page_location, $pmid_isbn, $pmid_isbn_page, $type, $attachment, $attachment_type, $interpretation, $interpretation_notes, $linking_pmid_isbn, $linking_pmid_isbn_page, $linking_quote, $linking_page_location) = mysqli_fetch_row($rs))
		{	
			$this->setID($id);
			$this->setOriginal_id($original_id);			
			$this->setQuote($quote);
			$this->setPage_location($page_location);
			$this->setPmid_isbn($pmid_isbn);
			$this->setPmid_isbn_page($pmid_isbn_page);
			$this->setType($type);	
			$this->setAttachment($attachment);	
			$this->setAttachment_type($attachment_type);
			$this->setInterpretation($interpretation);
			$this->setInterpretation_notes($interpretation_notes);
			//$this->setLinking_cell_id($linking_cell_id);
			$this->setLinking_page_location($linking_page_location);
			$this->setLinking_pmid_isbn($linking_pmid_isbn);
			$this->setLinking_pmid_isbn_page($linking_pmid_isbn_page);
			$this->setLinking_quote($linking_quote);
			$this->setLinking_page_location($linking_page_location);
			
		}
			/*$this->setID(1);
			$this->setOriginal_id(612028);			
			$this->setQuote("Dentate granule cells <% 1000 %> communicate with their postsynaptic targets by three distinct terminal types.  These include the large mossy terminals filopodial extensions of the mossy terminals...");
			$this->setPage_location("p3386");
			$this->setPmid_isbn(9547246);
			$this->setPmid_isbn_page(0);
			$this->setType("data");	
			$this->setAttachment("");	
			$this->setAttachment_type("");
			$this->setInterpretation("");
			$this->setInterpretation_notes("");
			//$this->setLinking_cell_id($linking_cell_id);
			$this->setLinking_page_location("");
			$this->setLinking_pmid_isbn(123456);
			$this->setLinking_pmid_isbn_page(1234512345);
			$this->setLinking_quote("");
			$this->setLinking_page_location("");*/
	}

	public function retrive_attachment_array_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment FROM $table WHERE fragment_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($attachment) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment_array($attachment, $n);	
			$n = $n + 1;
		}		
		$this->setNumber_attachment($n);
	}
	 
	public function retrive_attachment_type_array_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment_type FROM $table WHERE original_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$n=0;
		while(list($attachment_type) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment_type_array($attachment_type, $n);
			$n = $n + 1;
		}		
		$this->setNumber_attachment($n);
	}
	 
	public function retrive_attachment_by_original_id($id)
	{
		$table=$this->getName_table();
		
		$query = "SELECT attachment, attachment_type FROM $table WHERE original_id = '$id'";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($attachment, $attachment_type) = mysqli_fetch_row($rs))
		{	
			$this->setAttachment($attachment);	
			$this->setAttachment_type($attachment_type);	
		}		
	}
	 
	// SET -------------------------------------
 	public function setID($val)
    {
		  $this->_id = $val;
    }
			
 	public function setQuote($val)
    {
		  $this->_quote = $val;
    }
	
 	public function setPage_location($val)
    {
		  $this->_page_location = $val;
    }

 	public function setOriginal_id($val)
    {
		  $this->_original_id = $val;
    }

    public function setPmid_isbn($val)
    {
    	$this->_pmid_isbn = $val;
    }

    public function setPmid_isbn_page($val)
    {
    	$this->_pmid_isbn_page = $val;
    }
    
 	public function setType($val)
    {
		  $this->_type = $val;
    }

 	public function setAttachment($val)
    {
		  $this->_attachment = $val;
    }

 	public function setAttachment_type($val)
    {
		  $this->_attachment_type = $val;
    }
		
 	public function setAttachment_array($val, $n)
    {
		  $this->_attachment_array[$n] = $val;
    }

 	public function setAttachment_type_array($val)
    {
		  $this->_attachment_type_array = $val;
    }

	public function setInterpretation($val)
	{
		$this->_interpretation = $val;
	}
	
	public function setInterpretation_notes($val)
	{
		$this->_interpretation_notes = $val;
	}
	
/* 	public function setLinking_cell_id($val)
	{
		$this->_linking_cell_id = $val;
	} */
	
	public function setLinking_pmid_isbn($val)
	{
		$this->_linking_pmid_isbn = $val;
	}
	
	public function setLinking_pmid_isbn_page($val)
	{
		$this->_linking_pmid_isbn_page = $val;
	}
	
	public function setLinking_quote($val)
	{
		$this->_linking_quote = $val;
	}
	
	public function setLinking_page_location($val)
	{
		$this->_linking_page_location = $val;
	}
	
 	public function setNumber_attachment($n)
    {
		  $this->_number_attachment = $n;
    }		
	
			
 	// GET ++++++++++++++++++++++++++++++++++++++	
    public function getID()
    {
    	return $this->_id;
    }	
			
    public function getQuote()
    {
    	return $this->_quote;
    }	

    public function getPage_Location()
    {
    	return $this->_page_location;
    }

    public function getOriginal_id()
    {
    	return $this->_original_id;
    }

    public function getPmid_isbn()
    {
    	return $this->_pmid_isbn;
    }
    
    public function getPmid_isbn_page()
    {
    	return $this->_pmid_isbn_page;
    }
    
    public function getType()
    {
    	return $this->_type;
    }
				
    public function getName_table()
    {
    	return $this->_name_table;
    }	
	
    public function getAttachment()
    {
    	return $this->_attachment;
    }		

    public function getAttachment_type()
    {
    	return $this->_attachment_type;
    }
		
    public function getAttachment_array($n)
    {
    	return $this->_attachment_array[$n];
    }		

    public function getAttachment_type_array()
    {
    	return $this->_attachment_type_array;
    }

    public function getInterpretation()
    {
    	return $this->_interpretation;
    }
    
    public function getInterpretation_notes()
    {
    	return $this->_interpretation_notes;
    }
    
   /*  public function getLinking_cell_id()
    {
    	return $this->_linking_cell_id;
    } */
    
    public function getLinking_pmid_isbn()
    {
    	return $this->_linking_pmid_isbn;
    }
    
    public function getLinking_pmid_isbn_page()
    {
    	return $this->_linking_pmid_isbn_page;
    }
    
    public function getLinking_quote()
    {
    	return $this->_linking_quote;
    }
    
    public function getLinking_page_location()
    {
    	return $this->_linking_page_location;
    }
    
    public function getNumber_attachment()
    {
    	return $this->_number_attachment;
    }	

    public function neuron_to_subregion($neuron_id)
    {
    	$subregion = Null;

    	$query = "SELECT subregion FROM SynproTypeTypeRel WHERE type_id=$neuron_id;";
    	//echo $query;
    	$rs = mysqli_query($GLOBALS['conn'],$query);
		#$subregion = mysqli_fetch_row($rs)[0];
		while(list($val_result) = mysqli_fetch_row($rs))
		{
			$subregion = $val_result;
		}

		return $subregion;
    }

    public function neuron_to_subregion2($neuron_id)
    {
    	#$subregion = Null;

    	$query = "SELECT subregion FROM SynproTypeTypeRel WHERE type_id=$neuron_id;";
    	//echo $query;
    	$rs = mysqli_query($GLOBALS['conn'],$query);
		#$subregion = mysqli_fetch_row($rs)[0];
		while(list($val_result) = mysqli_fetch_row($rs))
		{
			$subregion = $val_result;
		}

		#return $subregion;
    }    

    public function prop_name_to_nq_name($prop_name)
    {
    	$nq_neurite_name='';
    	$query = "SELECT neurite_quant_neurite FROM SynproPropParcelRel WHERE parcel='".$prop_name."';";
		
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($neurite_quant_neurite) = mysqli_fetch_row($rs))
		{	    	
			# just saves the variable neurite_quant_neurite
			$nq_neurite_name=$neurite_quant_neurite;
		}

		return $nq_neurite_name;
    }

    public function getNeuriteLengths($neuron_id,$neurite,$refID)
    {
    	$neurite_lengths=array();
    	$query = "SELECT CAST(STD(CAST(total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_tl, CAST(AVG(CAST(total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg_tl, CAST(COUNT(CAST(total_length AS DECIMAL(10,0))) AS DECIMAL(10,0)) AS count_tl, CAST(MIN(CAST(total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS min_tl, CAST(MAX(CAST(total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS max_tl FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND total_length!='';";
    	//echo $query;
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($std, $avg, $count, $min, $max) = mysqli_fetch_row($rs))
		{	    	
			array_push($neurite_lengths, $std);
			array_push($neurite_lengths, $avg);
			array_push($neurite_lengths, $count);
			array_push($neurite_lengths, $min);
			array_push($neurite_lengths, $max);
		}

		return $neurite_lengths;
    }    

    public function getConvexHullVolume($neuron_id,$neurite,$refID)
    {
    	$convexhull=0;
    	//$query = "SELECT CAST(STD(total_length) AS DECIMAL(10,2)) AS std_tl, CAST(AVG(total_length) AS DECIMAL(10,2)) AS avg_tl, CAST(COUNT(total_length) AS DECIMAL(10,0)) AS count_tl, CAST(MIN(total_length) AS DECIMAL(10,2)) AS min_tl, CAST(MAX(total_length) AS DECIMAL(10,2)) AS max_tl FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND total_length!='';";
    	$query = "SELECT convexhull FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND convexhull!='';";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($convexhullvolume) = mysqli_fetch_row($rs))
		{	    	
			$convexhull = $convexhullvolume;
		}

		return $convexhull;
    }    

    public function getSingleNeuriteLength($neuron_id,$neurite,$refID)
    {
    	$length=Null;
		$query = "SELECT CAST(total_length AS DECIMAL(10,2)) AS tl FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND total_length!='';";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($tl) = mysqli_fetch_row($rs))
		{	    	
			# just saves the variable neurite_quant_neurite
			$length=$tl;
		}

		return $length;
    }

    public function getSomaticDistances($neuron_id,$neurite,$refID)
    {
    	$somatic_distances=array();
		$query = "SELECT CAST(STD(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_sd, CAST(AVG(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, CAST(COUNT(CAST(avg_path_length AS DECIMAL(10,0))) AS DECIMAL(10,0)) AS count_sd, CAST(min_path_length AS DECIMAL(10,2)) AS min_sd, CAST(max_path_length AS DECIMAL(10,2)) AS max_sd FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND avg_path_length!='';";
		//echo $query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($std_sd, $avg, $count_sd, $min_sd, $max_sd) = mysqli_fetch_row($rs))
		{	    	
			array_push($somatic_distances, $std_sd);
			array_push($somatic_distances, $avg);
			array_push($somatic_distances, $count_sd);
			array_push($somatic_distances, $min_sd);
			array_push($somatic_distances, $max_sd);
		}

		return $somatic_distances;
    }    

    public function getSingleSomaticDistance($neuron_id,$neurite,$refID)
    {
    	$somatic_distance=Null;
		$query = "SELECT CAST(avg_path_length AS DECIMAL(10,2)) AS mpl FROM neurite_quantified WHERE unique_id=".$neuron_id." AND neurite_quantified.neurite='".$neurite."' AND reference_ID=".$refID." AND avg_path_length!='';";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		//echo $query."<br>";
		while(list($mpl) = mysqli_fetch_row($rs))
		{	    	
			$somatic_distance = $mpl;
		}

		return $somatic_distance;
    }     

    public function getRarFile($neuron_id,$neurite_name,$refID)
    {
    	$rar_file='';
		$query = "SELECT rar_file FROM attachment_neurite_rar WHERE neuron_id=".$neuron_id." AND neurite_name='".$neurite_name."' AND reference_ID=".$refID.";";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($rar_file_result) = mysqli_fetch_row($rs))
		{	    	
			$rar_file=$rar_file_result;
		}

		return $rar_file;
    } 

    public function refid_to_species($refID)
    {
    	$species='';
		$query = "SELECT species FROM neurite WHERE referenceID=".$refID.";";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($species_result) = mysqli_fetch_row($rs))
		{	    	
			$species=$species_result;
		}

		return $species;
    } 

    public function type_id_to_article_ids($type_id) 
    {
    	$eid = '';
    	$eids = array();
    	$query = "SELECT DISTINCT Evidence_id FROM SynproEvidencePropertyTypeRel WHERE Type_id = '$type_id';";
		//echo $query."<br>";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($eid) = mysqli_fetch_row($rs))
		{	    	
			array_push($eids, $eid);
			//echo " ".$eid."<br>";
		}

		$artid = '';
    	$artids = array();
    	for ($i = 0; $i < count($eids); $i++) {
	    	$query = "SELECT Article_id FROM SynproArticleEvidenceRel where Evidence_id = '$eids[$i]';";
			//echo $query."<br>";
			$rs = mysqli_query($GLOBALS['conn'],$query);
			while(list($artid) = mysqli_fetch_row($rs))
			{	    	
				array_push($artids, $artid);
			}
		}

		return $artids;
    }	
}

?>
<?php
class parcel {
	
	private $typeId;
	private $propertyId;
	private $name;
	private $nickname;
	private $excit_inhib;
	private $subregion;
	private $subject;
	private $predicate;
	private $object;
	private $type1_id;
	private $type1_subregion;
	private $type1_nickname;
	private $type2_id;
	private $type2_subregion;
	private $type2_nickname;
	private $parcelList;
	private $type1_IdArray;
	private $type2_IdArray;
	
	function __construct() {
	}
	   
	// Getter methods
	public function getTypeId()
	{
		return $this->typeId;
	}
	
	public function getPropertyId()
	{
		return $this->propertyId;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getNickname()
	{
		return $this->nickname;
	}
	public function getExcitInhib()
	{
		return $this->excit_inhib;
	}
	
	public function getSubRegion()
	{
		return $this->subregion;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function getPredicate()
	{
		return $this->predicate;
	}
	
	public function getObject()
	{
		return $this->object;
	}
	
	public function getParcelList()
	{
		return $this->parcelList;
	}
	
	public function getType1Id()
	{
		return $this->type1_id;
	}
	
	public function getType2Id()
	{
		return $this->type2_id;
	}
	
	public function getType1SubRegion()
	{
		return $this->type1_subregion;
	}
	
	public function getType1Nickname()
	{
		return $this->type1_nickname;
	}
	
	public function getType2Nickname()
	{
		return $this->type2_nickname;
	}
	
	public function getType2SubRegion()
	{
		return $this->type2_subregion;
	}
	
	public function getType1ID_array()
	{
		return $this->type1_IdArray;
	}
	
	public function getType2ID_array()
	{
		return $this->type2_IdArray;
	}
	
	// Setter methods
	public function setTypeId($val)
	{
		$this->typeId = $val;
	}
	
	public function setPropertyId($val)
	{
		$this->propertyId = $val;
	}
	
	public function setName($val)
	{
		$this->name = $val;
	}
	
	public function setNickname($val)
	{
		$this->nickname = $val;
	}

	public function setExcitInhib($val)
	{
		$this->excit_inhib = $val;
	}
	
	public function setSubRegion($val)
	{
		$this->subregion = $val;
	}
	
	public function setSubject($val)
	{
		$this->subject = $val;
	}
	
	public function setPredicate($val)
	{
		$this->predicate = $val;
	}
	
	public function setObject($val)
	{
		$this->object = $val;
	}
	
	public function setParcelList($list)
	{
		$this->parcelList = $list;
	}
	
	public function setType1Id($type1_id)
	{
		$this->type1_id = $type1_id;
	}
	
	public function setType2Id($type2_id)
	{
		$this->type2_id = $type2_id;
	}
	
	public function setType1SubRegion($type1subregion)
	{
		$this->type1_subregion = $type1subregion;
	}
	
	public function setType1Nickname($type1nickname)
	{
		$this->type1_nickname = $type1nickname;;
	}
	
	public function setType2SubRegion($type2subregion)
	{
		$this->type2_subregion = $type2subregion;
	}
	
	public function setType2Nickname($type2nickname)
	{
		$this->type2_nickname = $type2nickname;
	}
	
	/* public function setType1ID_array($var, $n)
	{
		$this->type1_IdArray[$n] = $var;
	}
	
	public function setType2ID_array($val, $n)
	{
		$this->type2_IdArray[$n] = $val;
	} */
	
	public function retrieve_neuron_list_by_property($objectType,$subject)
	{
		$parcelList = Array();
		//$query = "SELECT DISTINCT t.name, t.subregion, t.nickname,t.excit_inhib, p.subject, p.predicate, p.object, eptr.Type_id, eptr.Property_id "
		//		." FROM EvidencePropertyTypeRel eptr JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id) "
		//		." WHERE predicate = 'in' AND object REGEXP '".$objectType."' and t.status ='active' AND subject = '".$subject."'";
		$query = "SELECT DISTINCT t.name, t.subregion, t.nickname,t.excit_inhib, p.subject, p.predicate, p.object, eptr.Type_id, eptr.Property_id "
				." FROM EvidencePropertyTypeRel eptr JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id) "
				." WHERE predicate = 'in' AND object = '".$objectType."' and t.status ='active' AND subject = '".$subject."' ORDER BY t.position";
		
		$rs = mysqli_query($GLOBALS['conn'],$query);
		while(list($name,$subregion,$nickname,$excit_inhib,$subject,$predicate,$object,$typeId,$propertyId) = mysqli_fetch_row($rs))
		{
			$parcel = new parcel();
			$parcel->setName($name);
			$parcel->setSubRegion($subregion);
			$parcel->setNickname($nickname);
			$parcel->setExcitInhib($excit_inhib);
			$parcel->setSubject($subject);
			$parcel->setPredicate($predicate);
			$parcel->setObject($object);
			$parcel->setTypeId($typeId);
			$parcel->setPropertyId($propertyId);
			$parcelList[] = $parcel;
		}
		$this->setParcelList($parcelList);
	}
	
	public function retrive_neuron_list_by_input_output($connectionType,$id_type,$parcel_type)
	{
		$parcelList = Array();
		//$type1_IdArray = Array();
	    //$type2_IdArray = Array();
		$query = " SELECT distinct t1.id as type1_id, t1.subregion as type1_subregion, t1.nickname as type1_nickname,t2.id as type2_id, t2.subregion as type2_subregion, t2.nickname as type2_nickname ".
				 " FROM TypeTypeRel ttr JOIN (Type t1, Type t2) ON ttr.Type1_id = t1.id AND ttr.Type2_id = t2.id".
				 " where ".$id_type." in (SELECT distinct eptr.Type_id FROM EvidencePropertyTypeRel eptr".
				 " JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id) WHERE predicate = 'in'".
				 " AND object REGEXP '".$parcel_type."')".
				 " and connection_status = '".$connectionType."' and connection_location REGEXP '".$parcel_type."' ";
		/* if($connectionType =="negative")
			echo " Query : ".$query; */
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$count = 0;
		while(list($type1_id,$type1_subregion,$type1_nickname,$type2_id,$type2_subregion,$type2_nickname) = mysqli_fetch_row($rs))
		{
			$parcel = new parcel();
			$parcel->setType1Id($type1_id);
			$parcel->setType1SubRegion($type1_subregion);
			$parcel->setType1Nickname($type1_nickname);
			$parcel->setType2Id($type2_id);
			$parcel->setType2Nickname($type2_nickname);
			$parcel->setType2SubRegion($type2_subregion);
			$parcelList[] = $parcel;
			$count++;
		}
		$this->setParcelList($parcelList);
	}
}
?>

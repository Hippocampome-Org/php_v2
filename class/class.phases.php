<?php

/**
 * @author aviaw
 *
 */
class phases
{
    private $_name_table;
    private $_id;
    private $_sub_Id;
    private $_name;
    private $_preferred;
    private $_theta;
    private $_SWRratio;
    private $_other;

    /**
     * @return mixed
     */
    public function getPreferred()
    {
        return $this->_preferred;
    }

    /**
     * @param mixed $_preferred
     */
    public function setPreferred($_preferred)
    {
        $this->_preferred = $_preferred;
    }

    public function get_all_id($id)
    {
        $table = $this->getName_table();
        $query = "SELECT * FROM $table where unique_id = '$id'";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        
        // Will set the values and return the arryay
        $phasesReturnArray = array();
        // Check whether every column is mapped to correct variable.
        while(List($temp,$id,$sub_Id,$name,$preferred,$theta,$SWRratio,$other
            ) =  mysqli_fetch_row($rs))
        {   
            
            $phasesReturnPopulate = new izhmodelsmodel($table);
            $phasesReturnPopulate->setPreferred($preferred);
            $phasesReturnPopulate->setTheta($theta);
            $phasesReturnPopulate->setSWRratio($SWRratio);
            $phasesReturnPopulate->setOther($other);
     
            array_push($phasesReturnArray,$phasesReturnPopulate);
        }

        return $phasesReturnArray;
    }
    
    public function getElementsArray()
    {
        //$izReturnAray[] = "name_table";
        //$izReturnAray[] = "id";
        //$izReturnAray[] = "name";
        $phasesReturnArray = array("theta","SWRratio","other");
        return $phasesReturnArray;
        
    }
    
    
    
    
    
    /**
     * @return mixed
     */
    public function getName_table()
    {
        return $this->_name_table;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getSub_Id()
    {
        return $this->_sub_Id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getTheta()
    {
        return $this->_theta;
    }

    /**
     * @return mixed
     */
    public function getSWRratio()
    {
        return $this->_SWRratio;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->_other;
    }

    function __construct ($name)
    {
        $this->_name_table   = $name;
    } 
}

?>
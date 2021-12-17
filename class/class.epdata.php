<?php
class epdata
{
    private $_raw;
    private $_value1;
    private $_value2;
    private $_error;
    private $_std_sem;
    private $_n;
    private $_istim;
    private $_time;    
    private $_value1_array;
    private $_n_value1;
    private $_rep_value;
    private $_gt_value;
	private $_location;
    
    function __construct ($name)
    {
        $this->_name_table = $name;
    }

    public function retrive_all_information($id)
    {
        $table=$this->getName_table();
        $query = "SELECT raw, value1, value2, error, std_sem, n, istim, time, location, rep_value, gt_value FROM $table WHERE id = '$id'";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        while (list($raw, $value1, $value2, $error, $std_sem, $n, $istim, $time, $location, $rep_value, $gt_value) = mysqli_fetch_row($rs))
        {    
            $this->setRaw($raw);    
            $this->setValue1($value1);
            $this->setValue2($value2);    
            $this->setError($error);    
            $this->setN($n);
            $this->setIstim($istim);        
            $this->setTime($time); 
			$this->setLocation($location);
            $this->setStd_sem($std_sem);                            
            $this->setRep_value($rep_value);   
            $this->setGt_value($gt_value);
        }    
    }    

    public function retrive_value1_array($id)
    {
        $table = $this->getName_table();
        $query = "SELECT value1 FROM $table WHERE id='$id'";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        $n = 0;
        while (list($value1) = mysqli_fetch_row($rs))
        {    
            $this->setValue1_array($n, $value1);
            $n = $n + 1;
        }    
        $this->setN_value1($n);
    }    


    // SET -------------------------------------

    public function setRaw($val1)
    {
        $this->_raw = $val1;
    }

    public function setValue1($val1)
    {
        $this->_value1 = $val1;
    }

    public function setValue1_array($n, $val1)
    {
        $this->_value1_array[$n] = $val1;
    }
    
    public function setValue2($val1)
    {
        $this->_value2 = $val1;
    }

    public function setError($val1)
    {
        $this->_error = $val1;
    }

    public function setN($val1)
    {
        $this->_n = $val1;
    }

    public function setN_value1($val1)
    {
        $this->_n_value1 = $val1;
    }

    public function setIstim($val1)
    {
        $this->_istim = $val1;
    }

    public function setTime($val1)
    {
        $this->_time = $val1;
    }
	
	public function setLocation($val1)
    {
        $this->_location = $val1;
    }

    public function setStd_sem($val1)
    {
        $this->_std_sem = $val1;
    }

    public function setRep_value($val1)
    {
        $this->_rep_value = $val1;
    }
    
    public function setGt_value($val1)
    {
    	$this->_gt_value = $val1;
    }


    // GET ++++++++++++++++++++++++++++++++++++++    

    public function getName_table()
    {
        return $this->_name_table;
    }    
        
    public function getRaw()
    {
        return $this->_raw;
    }    
        
    public function getValue1()
    {
        return $this->_value1;
    }    

    public function getValue2()
    {
        return $this->_value2;
    }    
    
    public function getError()
    {
        return $this->_error;
    }    

    public function getN()
    {
        return $this->_n;
    }    

    public function getValue1_array($i)
    {
        return $this->_value1_array[$i];
    }    

    public function getN_value1()
    {
        return $this->_n_value1;
    }
    
    public function getIstim()
    {
        return $this->_istim;
    }

    public function getTime()
    {
        return $this->_time;
    }
    
	public function getLocation()
    {
        return $this->_location;
    }
	
    public function getStd_sem()
    {
        return $this->_std_sem;
    }    
    
    public function getRep_value()
    {
        return $this->_rep_value;
    }    
    
    public function getGt_value()
    {
    	return $this->_gt_value;
    }
}
?>

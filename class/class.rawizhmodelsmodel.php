<?php

/**
 * @author aviaw
 *
 */
class rawizhmodelsmodel
{
    private $_name_table;
    private $_id;
    private $_sub_Id;
    private $_name;
    private $_preferred;
    private $_k;
    private $_a;
    private $_b;
    private $_d;
    private $_C;
    private $_Vr;
    private $_Vpeak;
    private $_Vmin;
    private $_Vt;
    private $_k0;
    private $_a0;
    private $_b0;
    private $_d0;
    private $_C0;
    private $_Vr0;
    private $_Vt0;
    private $_Vpeak0;
    private $_Vmin0;
    private $_k1;
    private $_a1;
    private $_b1;
    private $_d1;
    private $_C1;
    private $_Vr1;
    private $_Vt1;
    private $_Vpeak1;
    private $_Vmin1;
    private $_G0;
    private $_P0;
    private $_k2;
    private $_a2;
    private $_b2;
    private $_d2;
    private $_C2;
    private $_Vr2;
    private $_Vt2;
    private $_Vpeak2;
    private $_Vmin2;
    private $_G1;
    private $_P1;
    private $_k3;
    private $_a3;
    private $_b3;
    private $_d3;
    private $_C3;
    private $_Vr3;
    private $_Vt3;
    private $_Vpeak3;
    private $_Vmin3;
    private $_G2;
    private $_P2;


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
        $izReturnAray = array();
        // Check whether every column is mapped to correct variable.
        while(List($temp,$id,$sub_Id,$name,$preferred,$k,$a,$b,$d,$C,$Vr,$Vt,$Vpeak,$Vmin,$k0,$a0,$b0,$d0
            ,$C0,$Vr0,$Vt0,$Vpeak0,$Vmin0,$k1,$a1,$b1,$d1,$C1,$Vr1,$Vt1,$Vpeak1
            ,$Vmin1,$G0,$P0,$k2,$a2,$b2,$d2,$C2,$Vr2,$Vt2,$Vpeak2,$Vmin2,$G1
            ,$P1,$k3,$a3,$b3,$d3,$C3,$Vr3,$Vt3,$Vpeak3,$Vmin3,$G2,$P2
            ) =  mysqli_fetch_row($rs))
        {   
            
            $izreturnPopulate = new rawizhmodelsmodel($table);
            $izreturnPopulate->setPreferred($preferred);
            $izreturnPopulate->setA($a);
            $izreturnPopulate->setA0($a0);
            $izreturnPopulate->setA1($a1);
            $izreturnPopulate->setA2($a2);
            $izreturnPopulate->setA3($a3);
            $izreturnPopulate->setB($b);
            $izreturnPopulate->setB0($b0);
            $izreturnPopulate->setB1($b1);
            $izreturnPopulate->setB2($b2);
            $izreturnPopulate->setB3($b3);
            $izreturnPopulate->setC($C);
            $izreturnPopulate->setC0($C0);
            $izreturnPopulate->setC1($C1);
            $izreturnPopulate->setC2($C2);
            $izreturnPopulate->setC3($C3);
            $izreturnPopulate->setD($d);
            $izreturnPopulate->setD0($d0);
            $izreturnPopulate->setD1($d1);
            $izreturnPopulate->setD2($d2);
            $izreturnPopulate->setD3($d3);
            $izreturnPopulate->setG0($G0);
            $izreturnPopulate->setG1($G1);
            $izreturnPopulate->setG2($G2);
            $izreturnPopulate->setId($id);
            $izreturnPopulate->setK($k);
            $izreturnPopulate->setK0($k0);
            $izreturnPopulate->setK1($k1);
            $izreturnPopulate->setK2($k2);
            $izreturnPopulate->setK3($k3);
            $izreturnPopulate->setName($name);
            //$izreturnPopulate->setName_table($name_table); --> no need, as this is not in the table anyway.
            $izreturnPopulate->setP0($P0);
            $izreturnPopulate->setP1($P1);
            $izreturnPopulate->setP2($P2);
            $izreturnPopulate->setSub_Id($sub_Id);
            $izreturnPopulate->setVmin($Vmin);
            $izreturnPopulate->setVmin0($Vmin0);
            $izreturnPopulate->setVmin1($Vmin1);
            $izreturnPopulate->setVmin2($Vmin2);
            $izreturnPopulate->setVmin3($Vmin3);
            $izreturnPopulate->setVpeak($Vpeak);
            $izreturnPopulate->setVpeak0($Vpeak0);
            $izreturnPopulate->setVpeak1($Vpeak1);
            $izreturnPopulate->setVpeak2($Vpeak2);
            $izreturnPopulate->setVpeak3($Vpeak3);
            $izreturnPopulate->setVr($Vr);
            $izreturnPopulate->setVr0($Vr0);
            $izreturnPopulate->setVr1($Vr1);
            $izreturnPopulate->setVr2($Vr2);
            $izreturnPopulate->setVr3($Vr3);
            $izreturnPopulate->setVt($Vt);
            $izreturnPopulate->setVt0($Vt0);
            $izreturnPopulate->setVt1($Vt1);
            $izreturnPopulate->setVt2($Vt2);
            $izreturnPopulate->setVt3($Vt3);
          
            array_push($izReturnAray,$izreturnPopulate);
        }

        return $izReturnAray;
    }
    
    // Returns the name of all the coloumsn in this wrapper as array.
    public function isMultiCompartement($id)
    {
        $table = $this->getName_table();
        $query = "SELECT k0 FROM $table where unique_id = '$id' LIMIT  0,1";
        $rs = mysqli_query($GLOBALS['conn'],$query);
        $row = mysqli_fetch_assoc($rs);
        if($row["k0"] == 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }

    }

    public function getMultiComparementElementsArray()
    {
        $izReturnAray = array("k0","a0","b0","d0","C0","Vr0","Vt0","Vpeak0","Vmin0","k1","a1","b1","d1","C1","Vr1","Vt1","Vpeak1","Vmin1","G0","P0","k2","a2","b2","d2","C2","Vr2","Vt2","Vpeak2","Vmin2","G1","P1","k3","a3","b3","d3","C3","Vr3","Vt3","Vpeak3","Vmin3","G2","P2");
        return $izReturnAray;


    }
    public function getElementsArray()
    {
        //$izReturnAray[] = "name_table";
        //$izReturnAray[] = "id";
        //$izReturnAray[] = "name";
        $izReturnAray = array("k","a","b","d","C","Vr","Vt","Vpeak","Vmin","k0","a0","b0","d0","C0","Vr0","Vt0","Vpeak0","Vmin0","k1","a1","b1","d1","C1","Vr1","Vt1","Vpeak1","Vmin1","G0","P0","k2","a2","b2","d2","C2","Vr2","Vt2","Vpeak2","Vmin2","G1","P1","k3","a3","b3","d3","C3","Vr3","Vt3","Vpeak3","Vmin3","G2","P2");
        return $izReturnAray;
        
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
    public function getK()
    {
        return $this->_k;
    }

    /**
     * @return mixed
     */
    public function getA()
    {
        return $this->_a;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->_b;
    }

    /**
     * @return mixed
     */
    public function getD()
    {
        return $this->_d;
    }

    /**
     * @return mixed
     */
    public function getC()
    {
        return $this->_C;
    }

    /**
     * @return mixed
     */
    public function getVpeak()
    {
        return $this->_Vpeak;
    }

     public function getVr()
    {
        return $this->_Vr;
    }

    /**
     * @return mixed
     */
    public function getVmin()
    {
        return $this->_Vmin;
    }

    /**
     * @return mixed
     */
    public function getVt()
    {
        return $this->_Vt;
    }

    /**
     * @return mixed
     */
    public function getK0()
    {
        return $this->_k0;
    }

    /**
     * @return mixed
     */
    public function getA0()
    {
        return $this->_a0;
    }

    /**
     * @return mixed
     */
    public function getB0()
    {
        return $this->_b0;
    }

    /**
     * @return mixed
     */
    public function getD0()
    {
        return $this->_d0;
    }

    /**
     * @return mixed
     */
    public function getC0()
    {
        return $this->_C0;
    }

    /**
     * @return mixed
     */
    public function getVr0()
    {
        return $this->_Vr0;
    }

    /**
     * @return mixed
     */
    public function getVt0()
    {
        return $this->_Vt0;
    }

    /**
     * @return mixed
     */
    public function getVpeak0()
    {
        return $this->_Vpeak0;
    }

    /**
     * @return mixed
     */
    public function getVmin0()
    {
        return $this->_Vmin0;
    }

    /**
     * @return mixed
     */
    public function getK1()
    {
        return $this->_k1;
    }

    /**
     * @return mixed
     */
    public function getA1()
    {
        return $this->_a1;
    }

    /**
     * @return mixed
     */
    public function getB1()
    {
        return $this->_b1;
    }

    /**
     * @return mixed
     */
    public function getD1()
    {
        return $this->_d1;
    }

    /**
     * @return mixed
     */
    public function getC1()
    {
        return $this->_C1;
    }

    /**
     * @return mixed
     */
    public function getVr1()
    {
        return $this->_Vr1;
    }

    /**
     * @return mixed
     */
    public function getVt1()
    {
        return $this->_Vt1;
    }

    /**
     * @return mixed
     */
    public function getVpeak1()
    {
        return $this->_Vpeak1;
    }

    /**
     * @return mixed
     */
    public function getVmin1()
    {
        return $this->_Vmin1;
    }

    /**
     * @return mixed
     */
    public function getG0()
    {
        return $this->_G0;
    }

    /**
     * @return mixed
     */
    public function getP0()
    {
        return $this->_P0;
    }

    /**
     * @return mixed
     */
    public function getK2()
    {
        return $this->_k2;
    }

    /**
     * @return mixed
     */
    public function getA2()
    {
        return $this->_a2;
    }

    /**
     * @return mixed
     */
    public function getB2()
    {
        return $this->_b2;
    }

    /**
     * @return mixed
     */
    public function getD2()
    {
        return $this->_d2;
    }

    /**
     * @return mixed
     */
    public function getC2()
    {
        return $this->_C2;
    }

    /**
     * @return mixed
     */
    public function getVr2()
    {
        return $this->_Vr2;
    }

    /**
     * @return mixed
     */
    public function getVt2()
    {
        return $this->_Vt2;
    }

    /**
     * @return mixed
     */
    public function getVpeak2()
    {
        return $this->_Vpeak2;
    }

    /**
     * @return mixed
     */
    public function getVmin2()
    {
        return $this->_Vmin2;
    }

    /**
     * @return mixed
     */
    public function getG1()
    {
        return $this->_G1;
    }

    /**
     * @return mixed
     */
    public function getP1()
    {
        return $this->_P1;
    }

    /**
     * @return mixed
     */
    public function getK3()
    {
        return $this->_k3;
    }

    /**
     * @return mixed
     */
    public function getA3()
    {
        return $this->_a3;
    }

    /**
     * @return mixed
     */
    public function getB3()
    {
        return $this->_b3;
    }

    /**
     * @return mixed
     */
    public function getD3()
    {
        return $this->_d3;
    }

    /**
     * @return mixed
     */
    public function getC3()
    {
        return $this->_C3;
    }

    /**
     * @return mixed
     */
    public function getVr3()
    {
        return $this->_Vr3;
    }

    /**
     * @return mixed
     */
    public function getVt3()
    {
        return $this->_Vt3;
    }

    /**
     * @return mixed
     */
    public function getVpeak3()
    {
        return $this->_Vpeak3;
    }

    /**
     * @return mixed
     */
    public function getVmin3()
    {
        return $this->_Vmin3;
    }

    /**
     * @return mixed
     */
    public function getG2()
    {
        return $this->_G2;
    }

    /**
     * @return mixed
     */
    public function getP2()
    {
        return $this->_P2;
    }

    /**
     * @param mixed $_name_table
     */
    public function setName_table($_name_table)
    {
        $this->_name_table = $_name_table;
    }

    /**
     * @param mixed $_id
     */
    public function setId($_id)
    {
        $this->_id = $_id;
    }

    /**
     * @param mixed $_sub_Id
     */
    public function setSub_Id($_sub_Id)
    {
        $this->_sub_Id = $_sub_Id;
    }

    /**
     * @param mixed $_name
     */
    public function setName($_name)
    {
        $this->_name = $_name;
    }

    /**
     * @param mixed $_k
     */
    public function setK($_k)
    {
        if(is_null($_k)){
            $this->_k = "";
        }else{
        $this->_k = $_k;}
    }

    /**
     * @param mixed $_a
     */
    public function setA($_a)
    {
        if(is_null($_a)){
            $this->_a = "";
        }else{
        $this->_a = $_a;}
    }

    /**
     * @param mixed $_b
     */
    public function setB($_b)
    {
        if(is_null($_b)){
            $this->_b = "";
        }else{
        $this->_b = $_b;}
    }

    /**
     * @param mixed $_d
     */
    public function setD($_d)
    {
        if(is_null($_d)){
            $this->_d = "";
        }else{
        $this->_d = $_d;}
    }

    /**
     * @param mixed $_C
     */
    public function setC($_C)
    {
        if(is_null($_C)){
            $this->_C = "";
        }else{
        $this->_C = $_C
        ;}
    }

    /**
     * @param mixed $_Vpeak
     */
    public function setVpeak($_Vpeak)
    {
        if(is_null($_Vpeak)){
            $this->_Vpeak = "";
        }else{
        $this->_Vpeak =$_Vpeak;}
    }

    /**
     * @param mixed $_Vmin
     */
    public function setVmin($_Vmin)
    {
        if(is_null($_Vmin)){
            $this->_Vmin = "";
        }else{
        $this->_Vmin = $_Vmin;}
    }

    /**
     * @param mixed $_Vt
     */
    public function setVt($_Vt)
    {
        if(is_null($_Vt)){
            $this->_Vt = "";
        }else{
        $this->_Vt = $_Vt;}
    }

    /**
     * @param mixed $_k0
     */
    public function setK0($_k0)
    {
        if(is_null($_k0)){
            $this->_k0 = "";
        }else{
        $this->_k0 = $_k0;}
    }

    /**
     * @param mixed $_a0
     */
    public function setA0($_a0)
    {
        if(is_null($_a0)){
            $this->_a0 = "";
        }else{
        $this->_a0 = $_a0;}
    }

    /**
     * @param mixed $_b0
     */
    public function setB0($_b0)
    {
        if(is_null($_b0)){
            $this->_b0 = "";
        }else{
        $this->_b0 = $_b0;}
    }

    /**
     * @param mixed $_d0
     */
    public function setD0($_d0)
    {
        if(is_null($_d0)){
            $this->_d0 = "";
        }else{
        $this->_d0 = $_d0;}
    }

    /**
     * @param mixed $_C0
     */
    public function setC0($_C0)
    {
        if(is_null($_C0)){
            $this->_C0 = "";
        }else{
        $this->_C0 = $_C0;}
    }

    /**
     * @param mixed $_Vr0
     */
    public function setVr0($_Vr0)
    {
        if(is_null($_Vr0)){
            $this->_Vr0 = "";
        }else{
        $this->_Vr0 = $_Vr0;}
    }

    /**
     * @param mixed $_Vt0
     */
    public function setVt0($_Vt0)
    {
        if(is_null($_Vt0)){
            $this->_Vt0 = "";
        }else{
        $this->_Vt0 = $_Vt0;}
    }

    /**
     * @param mixed $_Vpeak0
     */
    public function setVpeak0($_Vpeak0)
    {
        if(is_null($_Vpeak0)){
            $this->_Vpeak0 = "";
        }else{
        $this->_Vpeak0 = $_Vpeak0;}
    }

    /**
     * @param mixed $_Vmin0
     */
    public function setVmin0($_Vmin0)
    {
        if(is_null($_Vmin0)){
            $this->_Vmin0 = "";
        }else{
        $this->_Vmin0 = $_Vmin0;}
    }

    /**
     * @param mixed $_k1
     */
    public function setK1($_k1)
    {
        if(is_null($_k1)){
            $this->_k1 = "";
        }else{
        $this->_k1 = $_k1;}
    }

    /**
     * @param mixed $_a1
     */
    public function setA1($_a1)
    {
        if(is_null($_a1)){
            $this->_a1 = "";
        }else{
        $this->_a1 = $_a1;}
    }

    /**
     * @param mixed $_b1
     */
    public function setB1($_b1)
    {
        if(is_null($_b1)){
            $this->_b1 = "";
        }else{
        $this->_b1 = $_b1;}
    }

    /**
     * @param mixed $_d1
     */
    public function setD1($_d1)
    {
        if(is_null($_d1)){
            $this->_d1 = "";
        }else{
        $this->_d1 = $_d1;}
    }

    /**
     * @param mixed $_C1
     */
    public function setC1($_C1)
    {
        if(is_null($_C1)){
            $this->_C1 = "";
        }else{
        $this->_C1 = $_C1;}
    }

    /**
     * @param mixed $_Vr1
     */
    public function setVr1($_Vr1)
    {
        if(is_null($_Vr1)){
            $this->_Vr1 = "";
        }else{
        $this->_Vr1 = $_Vr1;}
    }

    /**
     * @param mixed $_Vt1
     */
    public function setVt1($_Vt1)
    {
        if(is_null($_Vt1)){
            $this->_Vt1 = "";
        }else{
        $this->_Vt1 = $_Vt1;}
    }


     public function setVr($_Vr)
    {
        if(is_null($_Vr)){
            $this->_Vr = "";
        }else{
        $this->_Vr = $_Vr;}
    }


    /**
     * @param mixed $_Vpeak1
     */
    public function setVpeak1($_Vpeak1)
    {
        if(is_null($_Vpeak1)){
            $this->_Vpeak1 = "";
        }else{
        $this->_Vpeak1 = $_Vpeak1;}
    }

    /**
     * @param mixed $_Vmin1
     */
    public function setVmin1($_Vmin1)
    {
        if(is_null($_Vmin1)){
            $this->_Vmin1 = "";
        }else{
        $this->_Vmin1 = $_Vmin1;}
    }

    /**
     * @param mixed $_G0
     */
    public function setG0($_G0)
    {
        if(is_null($_G0)){
            $this->_G0 = "";
        }else{
        $this->_G0 = $_G0;}
    }

    /**
     * @param mixed $_P0
     */
    public function setP0($_P0)
    {
        if(is_null($_P0)){
            $this->_P0 = "";
        }else{
        $this->_P0 = $_P0;}
    }

    /**
     * @param mixed $_k2
     */
    public function setK2($_k2)
    {
        if(is_null($_k2)){
            $this->_k2 = "";
        }else{
        $this->_k2 = $_k2;}
    }

    /**
     * @param mixed $_a2
     */
    public function setA2($_a2)
    {
        if(is_null($_a2)){
            $this->_a2 = "";
        }else{
        $this->_a2 = $_a2;}
    }

    /**
     * @param mixed $_b2
     */
    public function setB2($_b2)
    {
        if(is_null($_b2)){
            $this->_b2 = "";
        }else{
        $this->_b2 = $_b2;}
    }

    /**
     * @param mixed $_d2
     */
    public function setD2($_d2)
    {
        if(is_null($_d2)){
            $this->_d2 = "";
        }else{
        $this->_d2 = $_d2;}
    }

    /**
     * @param mixed $_C2
     */
    public function setC2($_C2)
    {
        if(is_null($_C2)){
            $this->_C2 = "";
        }else{
        $this->_C2 = $_C2;}
    }

    /**
     * @param mixed $_Vr2
     */
    public function setVr2($_Vr2)
    {
        if(is_null($_Vr2)){
            $this->_Vr2 = "";
        }else{
        $this->_Vr2 = $_Vr2;}
    }

    /**
     * @param mixed $_Vt2
     */
    public function setVt2($_Vt2)
    {
        if(is_null($_Vt2)){
            $this->_Vt2 = "";
        }else{
        $this->_Vt2 = $_Vt2;}
    }

    /**
     * @param mixed $_Vpeak2
     */
    public function setVpeak2($_Vpeak2)
    {
        if(is_null($_Vpeak2)){
            $this->_Vpeak2 = "";
        }else{
        $this->_Vpeak2 = $_Vpeak2;}
    }

    /**
     * @param mixed $_Vmin2
     */
    public function setVmin2($_Vmin2)
    {
        if(is_null($_Vmin2)){
            $this->_Vmin2 = "";
        }else{
        $this->_Vmin2 = $_Vmin2;}
    }

    /**
     * @param mixed $_G1
     */
    public function setG1($_G1)
    {
        if(is_null($_G1)){
            $this->_G1 = "";
        }else{
        $this->_G1 = $_G1;}
    }

    /**
     * @param mixed $_P1
     */
    public function setP1($_P1)
    {
        if(is_null($_P1)){
            $this->_P1 = "";
        }else{
        $this->_P1 = $_P1;}
    }

    /**
     * @param mixed $_k3
     */
    public function setK3($_k3)
    {
        if(is_null($_k3)){
            $this->_k3 = "";
        }else{
        $this->_k3 = $_k3;}
    }

    /**
     * @param mixed $_a3
     */
    public function setA3($_a3)
    {
        if(is_null($_a3)){
            $this->_a3 = "";
        }else{
        $this->_a3 = $_a3;}
    }

    /**
     * @param mixed $_b3
     */
    public function setB3($_b3)
    {
        if(is_null($_b3)){
            $this->_b3 = "";
        }else{
        $this->_b3 = $_b3;}
    }

    /**
     * @param mixed $_d3
     */
    public function setD3($_d3)
    {
        if(is_null($_d3)){
            $this->_d3 = "";
        }else{
        $this->_d3 = $_d3;}
    }

    /**
     * @param mixed $_C3
     */
    public function setC3($_C3)
    {
        if(is_null($_C3)){
            $this->_C3 = "";
        }else{
        $this->_C3 = $_C3;}
    }

    /**
     * @param mixed $_Vr3
     */
    public function setVr3($_Vr3)
    {
        if(is_null($_Vr3)){
            $this->_Vr3 = "";
        }else{
        $this->_Vr3 = $_Vr3;}
    }

    /**
     * @param mixed $_Vt3
     */
    public function setVt3($_Vt3)
    {
        if(is_null($_Vt3)){
            $this->_Vt3 = "";
        }else{
        $this->_Vt3 = $_Vt3;}
    }

    /**
     * @param mixed $_Vpeak3
     */
    public function setVpeak3($_Vpeak3)
    {
        if(is_null($_Vpeak3)){
            $this->_Vpeak3= "";
        }else{
        $this->_Vpeak3 = $_Vpeak3;}
    }

    /**
     * @param mixed $_Vmin3
     */
    public function setVmin3($_Vmin3)
    {

        if(is_null($_Vmin3)){
            $this->_Vmin3 = "";
        }else{
        $this->_Vmin3 = $_Vmin3;}
    }

    /**
     * @param mixed $_G2
     */
    public function setG2($_G2)
    {
        if(is_null($_G2)){
            $this->_G2 = "";
        }else{
        $this->_G2 = $_G2;}
    }

    /**
     * @param mixed $_P2
     */
    public function setP2($_P2)
    {
        if(is_null($_P2)){
            $this->_P2 = "";
        }else{
        $this->_P2 = $_P2;}
    }

    function __construct ($name)
    {
        $this->_name_table   = $name;
    } 
}

?>
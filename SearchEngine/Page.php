<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 2/3/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */
class Page
{

    public function __construct()
    {

    }
    /*
     *  $subject= axons, dendrites and somata
     *  $predicate= in, not in
     *  $object= principle layer : sub layer
     *         = $ppl,$layer
     *         = DG:H
     */
    public function  typeWithMorphology($morphCond){
        #print("In type with morph:");
        $cond="";
        if (stripos($morphCond, Keyword::MORP_AXONS) !== false) {
            $cond=Keyword::MORP_AXONS;
        } else if (stripos($morphCond, Keyword::MORP_DENDRITES) !== false) {
            $cond=Keyword::MORP_DENDRITES;
        } else if (stripos($morphCond, Keyword::MORP_SOMA) !== false) {
            $cond=Keyword::MORP_SOMA;
        }
        $condValue=trim(str_ireplace($cond.Operator::COLON,"", $morphCond));
        #print($condValue.$cond.$morphCond.stripos($morphCond, Keyword::MORP_SOMA));
        $morphPage=new MorphologyPage();
        return $morphPage->getMorphNeuron($cond,$condValue);
    }
    // d+:SSM
    public  function typeWithMarker($markerCond){
        //print_r($markerCond);
        $matchingNeuron=array();
        $operator=$this->getOperator($markerCond);
        if($operator!="") {
            $values = explode($operator, $markerCond);
            //print_r($values);
            if (count($values) == 2) {
                $property=trim($values[0]);
                if(strtolower($property)==Keyword::MK_DIR_POS ){
                    $operator="positive";
                }else if(strtolower($property)==Keyword::MK_DIR_NEG)
                    $operator="negative";
                else if(strtolower($property)==Keyword::MK_INF_POS )
                    $operator="positive inference";
                else if(strtolower($property)==Keyword::MK_INF_NEG)
                    $operator="negative inference";
                else if(strtolower($property)==Keyword::MK_DIR_POS_NEG||strtolower($property)==Keyword::MK_DIR_NEG_POS||strtolower($property)==Keyword::MK_DIR_PN)
                    $operator="negative and positive";
                else if(strtolower($property)==Keyword::MK_INF_POS_NEG||strtolower($property)==Keyword::MK_INF_NEG_POS||strtolower($property)==Keyword::MK_INF_PN)
                    $operator="negative inference and positive inference";
                else 
                    return $matchingNeuron;
                $propertyValue=trim($values[1]);
                $queryUtil = new QueryUtil();
                $matchingNeuron = $queryUtil->markerMatchingNeuron($propertyValue, $operator);
            } else {
                print("<p>Invalid Marker Condition $markerCond</p>");
            }
        }
        return $matchingNeuron;
    }
    // rin>200
    // fr>=200
    public  function typeWithEphys($ephysCond){
        $matchingNeuron=array();
        $operator=$this->getOperator($ephysCond);
        
        if($operator!="") {
            $values = explode($operator, $ephysCond);
            //print("<pre>" . print_r($values, true) . "</pre>");
            if (count($values) == 2) {
                $property=trim($values[0]);
                $property=str_replace(Operator::COLON,"",$property);
                $propertyValue=trim($values[1],',');
                
                //print("<pre>property value" . print($propertyValue) . "</pre>");
                $roundDigit=0;
                $queryUtil = new QueryUtil();
                if($operator==Operator::COLON)
                    $operator=Operator::EQUAL_TO;
                   
                if(strpos($propertyValue,".")!==false){
                    $roundDigit=strlen($propertyValue)-(strpos($propertyValue,".")+1)+1;
                }
                // echo("OP:$property,$propertyValue,$operator:".stripos($ephysCond, Operator::COLON.Operator::LESS_THAN));
                //echo "OP:$property,$propertyValue,$operator";
                //print("<pre>" . print($operator) . "</pre>");
                $matchingNeuron = $queryUtil->ephysMatchingNeuron($property, $propertyValue, $operator,$roundDigit);
            } else {
                print("<p>Invalid Electorphysiology Condition $ephysCond</p>");
            }
        }
        return $matchingNeuron;
    }
    public  function typeWithFP($fpCond){
        $matchingNeuron=array();
        $operator=$this->getOperator($fpCond);
        if($operator!="") {
            $values = explode($operator, $fpCond);
            if (count($values) == 2) {
                $property=trim($values[0]);
                if(strtolower($property)==Keyword::FP_DIR_POS )
                    $operator=">";
                else if(strtolower($property)==Keyword::FP_DIR_NEG)
                    $operator="=";
                else
                    return $matchingNeuron;
                $propertyValue=trim($values[1]);
                $queryUtil = new QueryUtil();
                $matchingNeuron = $queryUtil->fpMatchingNeuron($propertyValue, $operator,0);
            } else {
                print("<p>Invalid Firing Pattern Condition $fpCond</p>");
            }
        }
        return $matchingNeuron;
    }
    public  function typeWithFP_Parameter($fppCond){
        $matchingNeuron=array();
        $operator=$this->getOperator($fppCond);
        if($operator!="") {
            $values = explode($operator, $fppCond);
            if (count($values) == 2) {
                $property=trim($values[0]);
                $property=str_replace(Operator::COLON,"",$property);
                $propertyValue=trim($values[1]);
                $roundDigit=0;
                $queryUtil = new QueryUtil();
                if($operator==Operator::COLON)
                    $operator=Operator::EQUAL_TO;
                if(strpos($propertyValue,".")!==false){
                    $roundDigit=strlen($propertyValue)-(strpos($propertyValue,".")+1);
                }
                $matchingNeuron = $queryUtil->fppMatchingNeuron($property, $propertyValue, $operator,$roundDigit);
            } else {
                print("<p>Invalid Firing Pattern Parameter Condition $fppCond</p>");
            }
        }
        return $matchingNeuron;
    }
    public  function typeWithNeuronName($name){
        $queryUtil=new QueryUtil();
        $matchingNeuron = $queryUtil->getMatchingNameNeuronOnly($name);
        return $matchingNeuron;
    }

    public function getOperator($str){
        $operator="";
        if ((stripos($str, Operator::GREATER_THAN_EQUAL_TO) !== false) || (stripos($str, Operator::COLON.Operator::GREATER_THAN_EQUAL_TO) !== false)) {
            $operator=Operator::GREATER_THAN_EQUAL_TO;
        }
        else  if ((stripos($str, Operator::LESS_THAN_EQUAL_TO) !== false) || (stripos($str, Operator::COLON.Operator::LESS_THAN_EQUAL_TO) !== false)) {
            $operator=Operator::LESS_THAN_EQUAL_TO;
        }
        else if ((stripos($str, Operator::GREATER_THAN) !== false) || (stripos($str, Operator::COLON.Operator::GREATER_THAN)) !== false) {
            $operator=Operator::GREATER_THAN;
        }
        else  if ((stripos($str, Operator::LESS_THAN) !== false) || (stripos($str, Operator::COLON.Operator::LESS_THAN) !== false)) {
            $operator=Operator::LESS_THAN;
        }
        else if (stripos($str, Operator::COLON) !== false ){
            $operator=Operator::COLON;
        }
        else if((stripos($str, Operator::COLON) !== false) || (stripos($str, Operator::EQUAL_TO) !== false)) {
            $operator=Operator::EQUAL_TO;
        }
        return $operator;
    }
}
?>
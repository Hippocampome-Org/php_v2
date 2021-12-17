<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 1/30/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */

class MorphologyPage
{
     private $parcels = array("DG:SMo","DG:SMi","DG:SG","DG:H",
        "CA3:SLM","CA3:SR","CA3:SL","CA3:SP","CA3:SO",
        "CA2:SLM","CA2:SR","CA2:SP","CA2:SO",
        "CA1:SLM","CA1:SR","CA1:SP","CA1:SO",
        "SUB:SM","SUB:SP","SUB:PL",
        "EC:I","EC:II","EC:III","EC:IV","EC:V","EC:VI");
    private $subregions = array("DG"=>0,"CA3"=>4,"CA2"=>9,"CA1"=>13,"SUB"=>17,"EC"=>20);
    private $subregionsCount = array("DG"=>4,"CA3"=>5,"CA2"=>4,"CA1"=>4,"SUB"=>3,"EC"=>6);
    private $parts = array(Keyword::MORP_AXONS=>"axons",Keyword::MORP_DENDRITES=>"dendrites",Keyword::MORP_SOMA=>"somata");
    private $relations = array(Operator::PRESENT=>"in",Operator::ABSENT=>"not in");

    public function getMorphNeuron($property,$propertyValue){
        #print("<br>In Morph Neuron<br>");
        $queryUtil=new QueryUtil();
        $allNeuron=$queryUtil->getBothNtrType();
        $matchingNeuron=$allNeuron;
        $value=explode(Operator::COLON,$propertyValue);
        #print("cojn:$propertyValue".count($value));
        if(count($value)==2) {
            $ppl = $value[0];
            $pplValues=$value[1];
            #print(strlen($pplValues));
            if(strlen($pplValues)==$this->subregionsCount[$ppl]){
                for ($ind = 0; $ind < strlen($pplValues); $ind++) {
                    $neuronFound=array();
                    if($pplValues[$ind]==Operator::ABSENT){
                        $subject=$this->parts[strtolower($property)];
                        $predicate=$this->relations[Operator::PRESENT];
                        $object=$this->parcels[$this->subregions[$ppl]+$ind];
                        $neuronFound=$queryUtil->morphMatchingNeuron($subject,$predicate,$object);
                        $neuronFound=array_diff($allNeuron,$neuronFound);
                    }
                    else if($pplValues[$ind]!=Operator::WILDCARD){
                        $subject=$this->parts[strtolower($property)];
                        $predicate=$this->relations[Operator::PRESENT];
                        $object=$this->parcels[$this->subregions[$ppl]+$ind];
                        $neuronFound=$queryUtil->morphMatchingNeuron($subject,$predicate,$object);

                    }
                    // print("<pre>".print_r($neuronFound,true)."</pre>");
                    if(count($neuronFound)>0){
                        $matchingNeuron=array_intersect($matchingNeuron,$neuronFound);
                    }else if (count($neuronFound)==0 && $matchingNeuron==$allNeuron && $pplValues[$ind]!=Operator::WILDCARD ) {
                            return $neuronFound;
                        }
                    }
            }
            else{
                print("<br>Invalid count of $propertyValue for condition $property<br>");
            }
        }
        else{
            print("<br>Invalid morphology condition....$property....$propertyValue<br>");
        }

        return $matchingNeuron;
    }
}

?>
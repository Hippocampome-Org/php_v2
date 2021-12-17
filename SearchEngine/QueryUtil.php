<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 2/5/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */
Class QueryUtil{
   public function getNtrType($ntr){
       $row_type = array();
       $index=0;
       $query_to_get_type="SELECT DISTINCT id FROM Type WHERE excit_inhib like '$ntr' ORDER BY id";
       $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
       if (!$rs_type) {
           echo("<p>Error in Listing Neuron Type </p>");
       }
       while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
           $row_type[$index++]=$row[0];
       }
       return $row_type;
   }
   public  function getBothNtrType(){
       $row_type = array();
       $index=0;
       $query_to_get_type="SELECT DISTINCT id FROM Type ORDER BY id";
       $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
       if (!$rs_type) {
           echo("<p>Error in Listing Neuron Type For Neurotransmitter </p>");
       }
       while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
           $row_type[$index++]=$row[0];
       }
       return $row_type;
   }
    public  function getMatchingNameNeuronOnly($name){
        $row_type = array();
        $index=0;
        $query_to_get_type="SELECT DISTINCT id FROM Type WHERE nickname like '%$name%' ORDER BY id";
        #echo("<br>".$query_to_get_type);
        $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Name </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        return $row_type;
    }
    public  function getMatchingNameNeuron($name){
        $row_type = array();
        $index=0;
        $query_to_get_type="SELECT DISTINCT id FROM Type WHERE nickname in $name ORDER BY id";
        #echo("<br>".$query_to_get_type);
        $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Name </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        return $row_type;
    }
    public function  morphMatchingNeuron($subject,$predicate,$object){
        $row_type = array();
        $index=0;
        $query_to_get_type="SELECT DISTINCT eptr.Type_id FROM EvidencePropertyTypeRel eptr,Property p,Type t
                            WHERE p.id=eptr.Property_id
                            AND t.id=eptr.Type_id
                            AND p.subject LIKE '$subject'
                            AND p.object LIKE '$object'
                            AND p.predicate LIKE '$predicate'
                            ORDER BY eptr.Type_id";
        #print("<br>$query_to_get_type<br>");
        $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Morphology </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        #echo("Total Type Found:".count($row_type));
        return $row_type;
    }
    public function  markerMatchingNeuron($subject,$value){
        if($value=="negative"||$value=="negative inference"||$value=="positive"||$value=="positive inference"){
        $row_type = array();
        $index=0;
        $query_get_type_id = "SELECT DISTINCT eptr.Type_id FROM Property p,EvidencePropertyTypeRel eptr
                            WHERE eptr.Property_id=p.id 
                            AND p.subject like '$subject'
                            AND p.predicate like 'has expression'
                            AND (eptr.conflict_note like '$value' OR eptr.conflict_note like 'confirmed $value')
                            ORDER BY eptr.Type_id";
        //echo $query_get_type_id;
        //print("<br>");
        $rs_type = mysqli_query($GLOBALS['conn'],$query_get_type_id);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Marker </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        }else{
        $row_type = array();
        $index=0;
        $query_get_type_id = "SELECT DISTINCT eptr.Type_id FROM Property p,EvidencePropertyTypeRel eptr
                            WHERE eptr.Property_id=p.id 
                            AND p.subject like '$subject'
                            AND p.predicate like 'has expression'
                            AND (eptr.conflict_note LIKE 'subtypes' OR eptr.conflict_note LIKE 'subcellular expression differences'  OR eptr.conflict_note LIKE 'species/protocol differences'  OR eptr.conflict_note LIKE 'unresolved')
                            ORDER BY eptr.Type_id";
        //echo $query_get_type_id;
        //print("<br>");
        $rs_type = mysqli_query($GLOBALS['conn'],$query_get_type_id);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Marker </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
    }
        return $row_type;
    }
    public function  ephysMatchingNeuron($property,$propertyValue,$operator,$roundDigit){
        $row_type = array();
        $index=0;
        $query_to_get_type="SELECT DISTINCT eptr.Type_id 
                            FROM EvidencePropertyTypeRel eptr, Epdata e, EpdataEvidenceRel eer, Property p
                            WHERE e.id=eer.Epdata_id
                            AND eer.Evidence_id=eptr.Evidence_id
                            AND p.id=eptr.Property_id
                            AND p.subject like '$property'
                            AND ROUND(e.value1,$roundDigit) $operator $propertyValue";
        #print("<br>$query_to_get_type<br>");
        $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Electrophysiology</p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        #echo("Total Type Found:".count($row_type));
        return $row_type;
    }
    public function  fpMatchingNeuron($subject, $predicate,$value){
        $row_type = array();
        $index=0;
        $query_get_type_id = "SELECT DISTINCT sub.id
        FROM(
        SELECT DISTINCT t.id,fp_def.overall_fp as def_overall_fp, fpr.Type_id,fp.overall_fp,fp.id as firing_id
        FROM (Type t CROSS JOIN FiringPattern fp_def) LEFT JOIN FiringPatternRel fpr ON t.id=fpr.Type_id 
        LEFT JOIN FiringPattern fp ON fp.id=fpr.FiringPattern_id AND fp_def.overall_fp=fp.overall_fp
        ORDER BY t.id
        ) as sub
        GROUP BY sub.def_overall_fp,sub.id
        HAVING sub.def_overall_fp like '$subject'
        AND COUNT(DISTINCT sub.firing_id) $predicate $value";
        #echo $query_get_type_id;
        $rs_type = mysqli_query($GLOBALS['conn'],$query_get_type_id);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Firing Pattern </p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        #echo("Total Type Found:".count($row_type));
        return $row_type;
    }
    public function  fppMatchingNeuron($property,$propertyValue,$operator,$roundDigit){
        $row_type = array();
        $index=0;
        $propertyLower=strtolower($property);
        if($propertyLower=='istim_pa' || $propertyLower=='tstim_ms')
            $query_to_get_type="SELECT DISTINCT fpr.Type_id FROM FiringPatternRel fpr
                            WHERE fpr.$property not like 'no value'
                            AND ROUND(fpr.$property,$roundDigit) $operator $propertyValue
                            ORDER BY fpr.Type_id";
        else
            $query_to_get_type="SELECT DISTINCT fpr.Type_id FROM FiringPattern fp,FiringPatternRel fpr
                                WHERE fp.id=fpr.FiringPattern_id
                                AND fp.$property not like 'no value'
                                AND fp.definition_parameter like 'parameter'
                                AND ROUND(fp.$property,$roundDigit) $operator $propertyValue
                                ORDER BY fpr.Type_id";
        #print("<br>$query_to_get_type<br>");
        $rs_type = mysqli_query($GLOBALS['conn'],$query_to_get_type);
        if (!$rs_type) {
            echo("<p>Error in Listing Neuron Type For Firing Pattern Parameter</p>");
        }
        while($row=mysqli_fetch_array($rs_type, MYSQLI_NUM)){
            $row_type[$index++]=$row[0];
        }
        #echo("Total Type Found:".count($row_type));
        return $row_type;
    }
}

?>
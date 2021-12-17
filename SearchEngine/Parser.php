<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 1/30/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */
    class Parser{
        private $searchQuery;

        public function __construct()
        {
            $this->searchQuery = "";
        }

        public function getSearchQuery()
        {
            return $this->searchQuery;
        }

        public function setSearchQuery($searchQuery)
        {
            $this->searchQuery = $searchQuery;
        }

        public function getIncludeNeuron($queryArray){
            // condition for include neuron
            $incNeuron=array();
            for($index=0;$index<count($queryArray);$index++){
                if(!is_array($queryArray[$index])) {
                    if (stripos($queryArray[$index], Keyword::INC) === 0) {
                        $result=$this->includeNeuron($queryArray,$index);
                        $index=$result[0];
                        $incNeuron=$result[1];
                        // add include neuron to earlier result
                        return $incNeuron;
                        //print("Neuron included:");
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                    }
                }
            }
        }
        public function getExcludeNeuron($queryArray){
            // condition for exclude neuron
            $excNeuron=array();
            for($index=0;$index<count($queryArray);$index++){
                if(!is_array($queryArray[$index])) {
                    if (stripos($queryArray[$index], Keyword::EXC) === 0) {
                        $result=$this->excludeNeuron($queryArray,$index);
                        $index=$result[0];
                        $excNeuron=$result[1];
                        // remove exclude neuron from earlier result
                        return $excNeuron;
                        //print("Neuron excluded:");
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                    }
                }
            } 
        }
        public function parseSynapticNeuron($queryArray,$ind){
            $mathcingNeruonArray=array();
            //print("<pre>".print_r($queryArray,true)."</pre>");
            for($index=$ind;$index<count($queryArray);$index++){
                if(!is_array($queryArray[$index])) {
                    if (stripos($queryArray[$index], Name::MORPH) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Name::MORPH) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");

                    } else if (stripos($queryArray[$index], Name::MARKER) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Name::MARKER) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);
                    } else if (stripos($queryArray[$index], Name::EPHY) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Name::EPHY) ;
                        $index=$result[0];
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);

                    } else if (stripos($queryArray[$index], Name::FP_PARAMETER) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Name::FP_PARAMETER) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);

                    } else if (stripos($queryArray[$index], Name::FP) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Name::FP) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);

                    }  else if (stripos($queryArray[$index], Keyword::NEURON_NAME) === 0) {
                        $result =$this->matchingNeuronCond($queryArray,$index,Keyword::NEURON_NAME) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);
                        //print("Neuron Name:");
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                    }
                    // neurotransmitter condition
                    else if (stripos($queryArray[$index], Keyword::NTR) === 0) {
                        $result =$this->matchingNtrNeuron($queryArray,$index) ;
                        $index=$result[0];
                        if(count($result[1])>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$result[1]);
                        //print("Neuron NTR:");
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                    }
                    else if (stripos($queryArray[$index], Operator::ANDD) !== false) {
                        $result=$this->parseSynapticNeuron($queryArray,$index+1);
                        $index=$result[0];
                        $incNeuron=$result[1];
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                        $mathcingNeruonArray=array_intersect($mathcingNeruonArray,$incNeuron);
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("ANND out");

                    } else if (stripos($queryArray[$index], Operator::ORR) !==false) {
                        $result=$this->parseSynapticNeuron($queryArray,$index+1);
                        $index=$result[0];
                        $incNeuron=$result[1];
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                        if(count($incNeuron)>0)
                            $mathcingNeruonArray=array_merge($mathcingNeruonArray,$incNeuron);
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("ANND ORR");
                    }
                    else if (stripos($queryArray[$index], Operator::NOT) !==false) {
                        //print("IN Not:");
                        //print($queryArray);
                        $result=$this->parseSynapticNeuron($queryArray,$index+1);
                        $index=$result[0];
                        $excNeuron=$result[1];
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                        
                        $mathcingNeruonArray=array_diff($mathcingNeruonArray,$excNeuron);
                        //print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
                        //print("ANND NOT");
                    }
                }else if (is_array($queryArray[$index]) && stripos($queryArray[$index-1], Keyword::EXC) ===false && stripos($queryArray[$index-1], Keyword::INC) ===false) {
                    $result=$this->parseSynapticNeuron($queryArray[$index],0);
                    return $result;
                }
            }
            return array($index,$mathcingNeruonArray);
        }
        public function findNeuron($neuron){
             $types_array = array();
            //print("<br>Connection to be found Are:<br>");
            //print("<pre>" . print_r($neuron, true) . "</pre>");
        
            if(count($neuron)!=0) {
                $neuron = implode(",", $neuron);
                $index = 0;
                $query_to_get_type = "SELECT DISTINCT c.Type1_id,t1.name as sourceName,t1.nickname as sourceNickname
                            FROM Conndata c,Type t1
                            WHERE c.Type1_id=t1.id 
                            AND c.Type1_id in ($neuron)
                            ORDER BY c.Type1_id
                             ";
                //print($query_to_get_type);
                $conn_type = mysqli_query($GLOBALS['conn'], $query_to_get_type);
                if (!$conn_type) {
                    die("<p>Error in Listing Type Tables In Connection.</p>");
                }
                while ($rows = mysqli_fetch_array($conn_type, MYSQLI_ASSOC)) {
                    $record = new NeuronConnection();
                    $record->setSourceId($rows['Type1_id']);
                    $record->setSourceName($rows['sourceName']);
                    $record->setSourceNickname($rows['sourceNickname']);
                    $types_array[$index] = $record;
                    $index++;
                }
            }
            return $types_array;
        }
        public function findConnection($preSynNeuron,$postSynNeuron){
            $types_array = array();
            //print("<br>Connection to be found Are:<br>");
            //print("<pre>" . print_r($preSynNeuron, true) . "</pre>");
            //print("<pre>" . print_r($postSynNeuron, true) . "</pre>");

            if(count($preSynNeuron)!=0 && count($postSynNeuron)!=0) {
                $preSynNeuronCond = implode(",", $preSynNeuron);
                $postSynNeuronCond = implode(",", $postSynNeuron);
                $index = 0;
                $query_to_get_type = "SELECT DISTINCT c.Type1_id,c.Type2_id,t1.name as sourceName,t1.nickname as sourceNickname,t2.name as DestName, t2.nickname as DestNickname 
                            FROM Conndata c,Type t1,Type t2
                            WHERE c.Type1_id=t1.id AND c.Type2_id=t2.id
                            AND c.Type1_id in ($preSynNeuronCond)
                            AND c.Type2_id in ($postSynNeuronCond)
                            AND (c.connection_status like 'positive' OR c.connection_status like 'potential')
                            AND NOT EXISTS (
                                            SELECT *
                                            FROM Conndata c1
                                            WHERE c.Type1_id=c1.Type1_id
                                            AND c.Type2_id=c1.Type2_id
                                            AND c1.connection_status like 'negative'
                                            )
                            ORDER BY c.Type1_id,c.Type2_id
                             ";
                //print($query_to_get_type);
                $conn_type = mysqli_query($GLOBALS['conn'], $query_to_get_type);
                if (!$conn_type) {
                    die("<p>Error in Listing Type Tables In Connection.</p>");
                }
                while ($rows = mysqli_fetch_array($conn_type, MYSQLI_ASSOC)) {
                    $record = new NeuronConnection();
                    $record->setSourceId($rows['Type1_id']);
                    $record->setSourceName($rows['sourceName']);
                    $record->setSourceNickname($rows['sourceNickname']);
                    $record->setDestinationId($rows['Type2_id']);
                    $record->setDestinationName($rows['DestName']);
                    $record->setDestinationNickname($rows['DestNickname']);
                    $types_array[$index] = $record;
                    $index++;
                }
            }
            return $types_array;
        }

        protected function isValidQuery(){
            $query=$this->searchQuery;
        }
        public function  parseQuery(){
            $connectionIndex=0;
            $presynapticIndex=0;
            $postsynapticIndex=3;
            $fillLengthConn=2;
            $fillLengthPre=2;
            $fillLengthPost=2;
            $presynStart=0;
            $postsynStart=3;
            $connStart=0;
            $error=true;
            $query=$this->searchQuery;
            $p = new ParenthesisParser();
            $parsedQuery = $p->parseParenthesis($query);
            //print("<pre>".print_r($parsedQuery,true)."</pre>");
            if(count($parsedQuery)==$fillLengthConn){
                if(stripos($parsedQuery[$connStart],Name::CONN)!==false){
                    $parsedQueryConn=$parsedQuery[1];
                    //print("<pre>".print_r($parsedQueryConn,true)."</pre>");
                    //if connection query proceed
                    if(count($parsedQueryConn)>=($fillLengthPre+$fillLengthPost) && stripos($parsedQueryConn[$presynStart], Keyword::CONN_PRESYN) !== false && stripos($parsedQueryConn[$postsynStart], Keyword::CONN_POSTSYN) !== false) {
                        $parsedQueryPreSynap=$parsedQueryConn[$presynStart+1];
                        $parsedQueryPostSynap=$parsedQueryConn[$postsynStart+1];
                        
                        $resultPre=$this->parseSynapticNeuron($parsedQueryPreSynap,0);
                        $resultPost=$this->parseSynapticNeuron($parsedQueryPostSynap,0);
                        $preSynNeuron=$resultPre[1];
                        // include, exclude these neuron
                        $incNeuron=$this->getIncludeNeuron($parsedQueryPreSynap);
                        //print("Include pre syn<pre>".print_r($incNeuron,true)."</pre>");
                        if($incNeuron && (count($incNeuron))>0)
                            $preSynNeuron=array_merge($preSynNeuron,$incNeuron);
                        $excNeuron=$this->getExcludeNeuron($parsedQueryPreSynap);
                        if($excNeuron && (count($excNeuron))>0)
                            $preSynNeuron=array_diff($preSynNeuron,$excNeuron);
                        //print("pre syn<pre>".print_r($preSynNeuron,true)."</pre>");
                        $postSynNeuron=$resultPost[1];
                        // include, exclude these neuron
                        $incNeuron=$this->getIncludeNeuron($parsedQueryPostSynap);
                        if($incNeuron && (count($incNeuron))>0)
                            $postSynNeuron=array_merge($postSynNeuron,$incNeuron);
                        $excNeuron=$this->getExcludeNeuron($parsedQueryPostSynap);
                        if($excNeuron && (count($excNeuron))>0)
                            $postSynNeuron=array_diff($postSynNeuron,$excNeuron);
                        //print("post syn<pre>".print_r($postSynNeuron,true)."</pre>");
                        $neuronConnection=$this->findConnection($preSynNeuron,$postSynNeuron);
                        //$test->findConnection(array(1000),array(1002,1009))
                        return $neuronConnection;
                    }
                }else if(stripos($parsedQuery[$connStart],"Neuron")!==false){
                      $parsedQueryPreSynap=$parsedQuery[1];
                      $resultPre=$this->parseSynapticNeuron($parsedQueryPreSynap,0);
                      $preSynNeuron=$resultPre[1];
                      $incNeuron=$this->getIncludeNeuron($parsedQueryPreSynap);
                      if($incNeuron && (count($incNeuron))>0)
                         $preSynNeuron=array_merge($preSynNeuron,$incNeuron);
                      $excNeuron=$this->getExcludeNeuron($parsedQueryPreSynap);
                      if($excNeuron && (count($excNeuron))>0)
                         $preSynNeuron=array_diff($preSynNeuron,$excNeuron);
                      $neuroncon = $this->findNeuron($preSynNeuron);
                      return $neuroncon;
                }
            }
            //$morph=new Morphology();
            //$morph->typeWithMorphology("axons","in","DG","SG");
        }
        private function matchingNtrNeuron($queryArray,$index){
            $queryUtil=new QueryUtil();
            $incNeuron = array();
            $exctInht="";
            // Neurotransmitter:Inhibitory
            if (strcasecmp(trim($queryArray[$index]), Keyword::NTR.":") != 0) {
                $includeCond = $queryArray[$index];
                $replaceStr=Keyword::NTR.":";
                $ntrCond = str_ireplace($replaceStr,"", $includeCond);
            }
            // Neurotransmitter: Inhibitory,
            // Neurotransmitter:Inhibitory,
            else {
                // go to next index to get array
                $neuronIncArray = $queryArray[$index + 1];
                // skip the next index
                $index++;
                // if its just a single and not array
                if(!is_array($neuronIncArray)) {
                    $ntrCond = trim($neuronIncArray);
                }
                //if its array
                else{
                    $ntrCond = trim($neuronIncArray[0]);
                }
            }
            $ntrCondChar=substr($ntrCond,0,1);
            if($ntrCondChar== "i" ||$ntrCondChar=="I" ){
                $exctInht="i";
                $incNeuron=$queryUtil->getNtrType($exctInht);
            }
            else if($ntrCondChar== "e" ||$ntrCondChar=="E" ){
                $exctInht="e";
                $incNeuron=$queryUtil->getNtrType($exctInht);
            }
            else if($ntrCondChar== "b" ||$ntrCondChar=="B" ){
                $incNeuron=$queryUtil->getBothNtrType($exctInht);
            }
            return array($index,$incNeuron);
        }
        private function matchingNameNeuron($queryArray,$index){
            $queryUtil=new QueryUtil();
            $incNeuron = array();
            $neuronNameArray=array();
            // Neurotransmitter:Inhibitory
            if (strcasecmp(trim($queryArray[$index]), Keyword::NEURON_NAME.":") != 0) {
                $includeCond = $queryArray[$index];
                $replaceStr=Keyword::NEURON_NAME.":";
                $neuronName=trim(str_ireplace($replaceStr,"", $includeCond));
                array_push($neuronNameArray,$neuronName);
            }
            // Neurotransmitter: Inhibitory,
            // Neurotransmitter:Inhibitory,
            else {
                // go to next index to get array
                $neuronIncArray = $queryArray[$index + 1];
                // skip the next index
                $index++;
                // if its just a single and not array
                if(!is_array($neuronIncArray)) {
                    array_push($neuronNameArray,$neuronIncArray);
                }
                //if its array
                else{
                    // iterate over all neuron
                    for ($ind = 0; $ind < count($neuronIncArray); $ind++) {
                        //2000,3000
                        if (strpos($neuronIncArray[$ind], ",") !== false) {
                            $splitArray = explode(",", $neuronIncArray[$ind]);
                            // check for each neuron
                            for ($i = 0; $i < count($splitArray); $i++) {
                                // if not blank push id
                                $neuronName = trim($splitArray[$i]);
                                if ($neuronName !== "") {
                                    array_push($neuronNameArray, $neuronName);
                                }
                            }
                        }
                        else {
                            array_push($neuronNameArray, trim($neuronIncArray[$ind]));
                        }
                    }
                }
            }
            if(count($neuronNameArray)>0){
                $neuronName=implode("','",$neuronNameArray);
                $neuronName="('$neuronName')";
                //echo($neuronName);
                $incNeuron=$queryUtil->getMatchingNameNeuron($neuronName);
            }
            return array($index,$incNeuron);
        }
        private function matchingNeuronCond($queryArray,$index,$pageType){
            $matchingNeuron=array();
            if (strcasecmp(trim($queryArray[$index]), $pageType.":") != 0) {
                $includeCond = $queryArray[$index];
                $replaceStr=$pageType.":";
                //remove word
                //print("<br>..1Condition is..............$includeCond<br>");
                $neuronCond=trim(str_ireplace($replaceStr,"", $includeCond));
                //print("<br>..1Condition is...............$neuronCond<br>");
                $matchingNeuron=$this->executeCondition($pageType,$neuronCond);
                //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
            }

            else {
                // go to next index to get array
                $neuronIncArray = $queryArray[$index + 1];
                // skip the next index
                $index++;
                 #print_r($queryArray);
                if(is_array($queryArray[$index])) {
                    $result =$this->neuronMatchingInnerCond($queryArray[$index], 0, $pageType);
                    $matchingNeuron=$result[1];
                }
            }
            return array($index,$matchingNeuron);
        }
        public function includeNeuron($queryArray,$index){
            $incNeuron = array();
            // Include:4000
            if (strcasecmp(trim($queryArray[$index]), Keyword::INC.":") != 0) {
                //echo("mathcing Include:2000");
                $includeCond = $queryArray[$index];
                $replaceStr=Keyword::INC.":";
                $neuronId = str_ireplace($replaceStr,"", $includeCond);
                array_push($incNeuron, trim($neuronId));
            } // Include:(4000,2000, 3000,1200 ,3333)
            else {
                //echo("mathcing Include:");
                // go to next index to get array
                $neuronIncArray = $queryArray[$index + 1];
                // skip the next index
                $index++;
                // if its just a single id and not array if ids
                if(!is_array($neuronIncArray)) {
                    array_push($incNeuron, trim($neuronIncArray));
                }
                // its array of ids
                else{
                    // iterate over all neuron
                    for ($ind = 0; $ind < count($neuronIncArray); $ind++) {
                        //2000,3000
                        if (strpos($neuronIncArray[$ind], ",") !== false) {
                            $splitArray = explode(",", $neuronIncArray[$ind]);
                            // check for each neuron
                            for ($i = 0; $i < count($splitArray); $i++) {
                                // if not blank push id
                                $typeId = trim($splitArray[$i]);
                                if ($typeId !== "") {
                                    array_push($incNeuron, $typeId);
                                }
                            }
                        }
                        else {
                            array_push($incNeuron, trim($neuronIncArray[$ind]));
                        }
                    }
                }
            }
            return array($index,$incNeuron);
        }
        public function excludeNeuron($queryArray,$index){
            $excNeuron = array();
            // Exclude:4000
            if (strcasecmp(trim($queryArray[$index]), Keyword::EXC.":") != 0) {
                $excludeCond = $queryArray[$index];
                $replaceStr=Keyword::EXC.":";
                $neuronId = str_ireplace($replaceStr,"", $excludeCond);
                array_push($excNeuron, trim($neuronId));
            } // Exclude:(4000,2000, 3000,1200 ,3333)
            else {
                // go to next index to get array
                $neuronExcArray = $queryArray[$index + 1];
                // skip the next index
                $index++;
                // if its just a single id and not array if ids
                if(!is_array($neuronExcArray)) {
                    array_push($excNeuron, trim($neuronExcArray));
                }
                // its array of ids
                else{
                    // iterate over all neuron
                    for ($ind = 0; $ind < count($neuronExcArray); $ind++) {
                        //2000,3000
                        if (strpos($neuronExcArray[$ind], ",") !== false) {
                            $splitArray = explode(",", $neuronExcArray[$ind]);
                            // check for each neuron
                            for ($i = 0; $i < count($splitArray); $i++) {
                                // if not blank push id
                                $typeId = trim($splitArray[$i]);
                                if ($typeId !== "") {
                                    array_push($excNeuron, $typeId);
                                }
                            }
                        }
                        else {
                            array_push($excNeuron, trim($neuronExcArray[$ind]));
                        }
                    }
                }
            }
            print("<pre>" . print_r($mathcingNeruonArray, true) . "</pre>");
            return array($index,$excNeuron);
        }
        public function neuronMatchingInnerCond($queryArray,$ind,$pageType){
            $matchingNeuron=array();
            for($index=$ind;$index<count($queryArray);$index++) {
                //print("<br>Index...............$index<br>");
                $val=$queryArray[$index];
                $incNeuron = array();
                if (is_array($val)) {
                    $result=$this->neuronMatchingInnerCond($val,0,$pageType);
                    $incNeuron=$result[1];
                    if(count($incNeuron)>0)
                        $matchingNeuron=array_merge($matchingNeuron,$incNeuron);
                }
                else if(stripos($val, Operator::ANDD) !== false){
                    $index++;
                    $result=$this->neuronMatchingInnerCond($queryArray,$index,$pageType);
                    $index=$result[0];
                    $incNeuron=$result[1];
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                    $matchingNeuron=array_intersect($matchingNeuron,$incNeuron);
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("ANDD------");
                }
                else if(stripos($val, Operator::ORR) !== false){
                    //print("<br>OR FOUND...............<br>");
                    $index++;
                    $result=$this->neuronMatchingInnerCond($queryArray,$index,$pageType);
                    $index=$result[0];
                    $incNeuron=$result[1];
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                    if(count($incNeuron)>0)
                        $matchingNeuron=array_merge($matchingNeuron,$incNeuron);
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("ORR------");
                }
                else if(stripos($val, Operator::NOT) !== false){
                    $index++;
                    $result=$this->neuronMatchingInnerCond($queryArray,$index,$pageType);
                    $index=$result[0];
                    $incNeuron=$result[1];
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                    $matchingNeuron=array_diff($matchingNeuron,$incNeuron);
                    //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
                    //print("NOT------");
                }
                else {
                    $cond=$val;
                    $incNeuron=$this->executeCondition($pageType,$cond);
                    if(count($incNeuron)>0)
                        $matchingNeuron=array_merge($matchingNeuron,$incNeuron);
                }
               //print("<br>INC Inner Type FOund at index:+$index...".count($incNeuron)."<br>");
               //print("<pre>" . print_r($incNeuron, true) . "</pre>");
                //print("<br>Matching Inner Type FOund at index:+$index...".count($matchingNeuron)."<br>");
                //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
            }
            //print("<br>Type FOund at index:+$index<br>");
            //print("<pre>" . print_r($matchingNeuron, true) . "</pre>");
            return array($index,$matchingNeuron);
        }
        public function executeCondition($pageType,$cond){
            //print("Condition is...................$pageType..................$cond<br>");
            $page= new Page();
            $incNeuron=array();
            if($pageType==Name::MORPH)
                $incNeuron=$page->typeWithMorphology($cond);
            else if($pageType==Name::EPHY)
                $incNeuron=$page->typeWithEphys($cond);
            else if($pageType==Name::MARKER)
                $incNeuron=$page->typeWithMarker($cond);
            else if($pageType==Name::FP)
                $incNeuron=$page->typeWithFP($cond);
            else if($pageType==Name::FP_PARAMETER)
                $incNeuron=$page->typeWithFP_Parameter($cond);
            else if($pageType==Keyword::NEURON_NAME)
                $incNeuron=$page->typeWithNeuronName($cond);

            return $incNeuron;
        }
    }

?>
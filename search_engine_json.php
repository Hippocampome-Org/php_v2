<?php
require_once("SearchEngine/ParenthesisParser.php");
require_once("SearchEngine/NeuronConnection.php");
require_once('SearchEngine/Parser.php');
require_once('SearchEngine/MorphologyPage.php');
require_once('SearchEngine/Term.php');
require_once('SearchEngine/QueryUtil.php');
require_once('SearchEngine/Page.php');
require_once("access_db.php");

if($_REQUEST['query_str']){
	$qeueryString =$_REQUEST['query_str'];
	$test=new Parser();
	$test->setSearchQuery($qeueryString);
	$matchingConn=$test->parseQuery();
	$data = array();
	for($i=0;$i<count($matchingConn);$i++){
		$index=$i+1;
		$data["$index"]=array("source_id"=>$matchingConn[$i]->getSourceId(),"destination_id"=>$matchingConn[$i]->getDestinationId());		
	}
	header('Content-type:application/json;charset=utf-8');
	echo json_encode($data);
	//echo($_REQUEST['query_str']);
}
?>
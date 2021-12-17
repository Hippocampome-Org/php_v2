<?php
class utils {
	private $headerStr;
	function __construct() {
	}
	
	public function getHeaderStr()
	{
		return $this->headerStr;
	}
	public function setHeaderStr($header)
	{
		$this->headerStr =$header;
	}
	
	public function setHeader($tableName)
	{
		$query = "select id,subregion,nickname from ".$tableName." where status ='active' order by position";
		$rs = mysqli_query($GLOBALS['conn'],$query);
		$str = "'&nbsp;','<div id=\"frmCntr\">FROM</div><div id=\"toCntr\" class=\"rotate\">TO</div>'";
		while(list($id,$subregion,$nickname) = mysqli_fetch_row($rs))
		{
			$str=$str.","."'<a href=\"neuron_page.php?id=".$id."\" onClick=\"OpenInNewTab(this);\" target=\"_blank\">".$subregion.":".$nickname."</a>'";
		}
		$this->setHeaderStr($str);
	}
}
?>
<?php
/*
Author: Amar Gawade
Created: 01/30/2017
*/
include ("permission_check.php");
require_once("SearchEngine/ParenthesisParser.php");
require_once("SearchEngine/NeuronConnection.php");
require_once('SearchEngine/Parser.php');
require_once('SearchEngine/MorphologyPage.php');
require_once('SearchEngine/Term.php');
require_once('SearchEngine/QueryUtil.php');
require_once('SearchEngine/Page.php');
require_once("access_db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<script type="text/javascript" src="syntaxhighlighter/balanced.js"></script>
<script type="text/javascript" src="syntaxhighlighter/rangy.js"></script>
<script type="text/javascript">     
function hide(){
    $('#conn tr > *:nth-child(1)').toggle();
    $('#conn tr > *:nth-child(4)').toggle();}
function show(){
    $('#conn tr > *:nth-child(2)').toggle();
    $('#conn tr > *:nth-child(5)').toggle();
  }
  function highlighter(txt) {
         var findGroup1 = /(\b(?:Neuron|Connection|Presynaptic|Postsynaptic|Neurotransmitter|Morphology|Markers|Electrophysiology|FiringPattern(?:Parameter)?|Exclude|Include|Name)\b)/ig;
         var findGroup2 = /(\b(?:Axons|Dendrites|Soma|[di][\-+±])|(?:Excita|Inhibi)tory|both\b)/ig;
         var findGroup3 = /(\b(?:CA[1-3]|DG|EC|SUB)\b)/g;
         var findGroup4 = /(\b(?:AND|OR|NOT)\b)/ig;
         var findGroup5 = /((?<=:(?:<b[^>]*?>)?(?:DG|CA[12])(?:<\/b>)?:)[0-2\?]{4}|(?<=:(?:<b[^>]*?>)?SUB(?:<\/b>)?:)[0-2\?]{3}|(?<=:(?:<b[^>]*?>)?EC(?:<\/b>)?:)[0-2\?]{6}|(?<=:(?:<b[^>]*?>)?CA3(?:<\/b>)?:)[0-2\?]{5})(?![0-2\?])/ig;
         var wordAroundCursor = /([a-z]*)(?:<span.*id=.*selectionBoundary.*>\uFEFF<\/span>)([a-z]*)/ig;
         var morphologyAroundCursor = /(:[ECASUBDG1-3]{0,3}:?[0-2\?]{0,6})(?:<span.*id=.*selectionBoundary.*>\uFEFF<\/span>)([ECASUBDG1-3]{0,3}:?[0-2\?]{0,6})/g;
         //+- to ±
         txt = txt.replace(/(?<=[DI])(?:\+(<span.*id=.*selectionBoundary.*>\uFEFF<\/span>)?\-|\-(<span.*id=.*selectionBoundary.*>\uFEFF<\/span>)?\+)/ig, "±$1")
         if ((results = wordAroundCursor.exec(txt)) && (results[1]+results[2] !== '')) {
           [wf,w] = [results[0],results[1]+results[2]];
           if      (findGroup1.test(w)) txt = txt.replace(wf,"<b>"+wf+"</b>")
           else if (findGroup2.test(w)) txt = txt.replace(wf,"<b style='color:navy'><i>"+wf+"</i></b>")
           else if (findGroup3.test(w)) txt = txt.replace(wf,"<b style='color:darkred'>"+wf+"</b>")
           else if (findGroup4.test(w)) txt = txt.replace(wf,"<b style='color:purple'>" +wf+"</b>");
         } else if (results = morphologyAroundCursor.exec(txt)) {
           [wf,w] = [results[0],results[1]+results[2]];//console.log('match',txt)
           if (findGroup5.test(w)) txt = txt.replace(wf,f=>f.replace(/(?<=:)([0-2\?]{0,6})<span/,"<i>$1<span").replace(/(?<=<\/span>:)([0-2\?]{0,6})/,"<i>$1</i>").replace(/<\/span>([0-2\?]{0,6})/,"</span>$1</i>"));
         }
         return txt.replace(findGroup1,(f,p1)=>"<b>"+p1.replace(/^[a-z]/,t=>t.toUpperCase())+"</b>").replace(findGroup2,(f,p1)=>"<b style='color:navy'><i>"+p1.replace(/^[a-z]/,t=>t.toUpperCase())+"</i></b>").replace(findGroup3,(f,p1)=>"<b style='color:darkred'>"+p1.toUpperCase()+"</b>").replace(findGroup4,(f,p1)=>"<b style='color:purple'>" +p1.toUpperCase()+"</b>").replace(findGroup5,"<i>$1</i>");
       }
     function queryHighlighter(string){
       return balanced.replacements({
         source: highlighter(string),
         head:/\(/g,
         open: '(',
         close: ')',
         balance: true, 
         replace: function (source, head, tail) {
           return '<b>' + head + '</b>' + source + '<b>' + tail + '</b>';
     }})}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <?php include ("function/icon.html"); ?>
  <title>Search Engine</title>
  <script type="text/javascript" src="style/resolution.js"></script>
  <script type="text/javascript" src="lightbox/js/sorttable.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <script src="DataTables-1.9.4/media/js/jquery.js" type="text/javascript"></script>
  <script src="DataTables-1.9.4/media/js/jquery.dataTables.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table_jui.css"/>
  <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css"/>
   <base target="_top">
   <style>
     table {
       border-collapse: collapse;
     }
     table, th, td {
       border: 1px solid black;
       text-align: left;
       padding: 5px;
     }
     tr:hover{background-color:#f5f5f5}
     th {
       background-color: #4CAF50;
       color: white;
     }
     .text {
       width: 95vw;
       height: calc(20vh - 26px); //775px; //615px
       padding: 0px;
       font: 12px/18px 'Open Sans', sans-serif;
       letter-spacing: 1px;
       line-height: 1.5em;
     }
     div[contenteditable]:focus {
       border: 1px solid rgb(86, 180, 239);
       box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05) inset, 0px 0px 8px rgba(82, 168, 236, 0.6);
     }
     div[contenteditable] {
       width: 100%;
       max-width: 99%;
       min-height: 30px;
       overflow: hidden;
       margin-right: 10px;
       font-family: Arial,sans-serif;
       -webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,.05),0 1px 0 rgba(255,255,255,.075);
       box-shadow: inset 0 1px 3px rgba(0,0,0,.05),0 1px 0 rgba(255,255,255,.075);
       display: inline-block;
       padding: 4px;
       margin: 0;
       outline: 0;
       background-color: #fff;
       border: 1px solid #ccc;
       border-radius: 3px;
       font-size: 13px;
       line-height: 20px;
     }
     mark{
       background: white;
       color: black;
       font-weight: bold;
     }
   </style>
</head>
<body>
  <?php 
    include ("function/title.php");
    include ("function/menu_main.php");
  ?>    <div class='title_area'>
    <font class="font1">Search Engine</font>
  <form name="search_engine_form" action="search_engine_custom.php" method="post" style="display:inline" onsubmit="submitcheck()">
      <table border="0" cellspacing="3" cellpadding="0" class='table_search' style="width: 175%;">
        <td width="10%" align="center" class='table_neuron_page1'>
          <strong>Search <br>Query<br>String</strong>       
        </td>
        <td width="90%">
          <div contenteditable='true' id='editor' class="text">
            <?php if($_REQUEST['query_str']) 
            echo "<script type='text/javascript'>document.getElementById('editor').innerHTML=queryHighlighter(".json_encode($_REQUEST['query_str']).");</script>";?>
            </div>
          <span id="error"></span>
          <textarea style="display:none;" name='query_str' rows='5' cols='100'><?php if($_REQUEST['query_str']) print($_REQUEST['query_str']); ?></textarea>
        </td>
      </tr>
      <tr>      
        <td width="10%" >
        </td>
        <td width="90%" align='right'>
          <input type="submit" name='search_engine' value='SEE RESULTS'/>
        </td>     
      </table>    
  </form>
  <br>
  <table width="1200px" style="border: none;">
      <td width="100%" style="border: none;">
          <font class="font2">
          All queries should start with either a “Neuron:(…)” or “Connection:(Presynaptic:(…), Postsynaptic:(…))”
          clause, which means the user is searching for neuron types or potential connections, respectively. “…” is
          the place holder for neuronal properties: <a href="Help_Search_Engine.php">Advanced Search Engine Manual</a>
          </font>
        </td>
    </table>
    <br>
   <script>
     var errorElem = document.getElementById("error");
     var savedSel = null;
     var savedSelActiveElement = document.getElementById("editor");
     function submitcheck(){
           savedSelActiveElement = document.getElementById("editor");
           ['b','i','br'].forEach((tag)=>{
               while (elem = savedSelActiveElement.querySelector(tag))
                 elem.outerHTML = elem.innerHTML;
             })
           var text = unescape(savedSelActiveElement.innerHTML.replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&nbsp;/g,' ').replace(/\s+/g,' ').replace(/,Postsynaptic/gi, ", Postsynaptic"));
           document.search_engine_form.query_str.value = text;
           return true;       }
     window.onload = function() {
        show();
       try {
         // Turn multiple selections on in IE
         document.execCommand("MultipleSelection", null, true);
         rangy.init();
         var saveRestoreModule = rangy.modules.SaveRestore;
         if (!(rangy.supported && saveRestoreModule && saveRestoreModule.supported))
           throw 'rangy is not supported';
         savedSelActiveElement = editor = document.getElementById("editor");
         // editor.innerHTML = queryHighlighter((editor.innerText)? editor.innerText : 'Connection:(Presynaptic:(Neurotransmitter: AND Morphology:(Dendrites: Axons: Soma:)), Postsynaptic:(Morphology:(Dendrites: Axons: Soma:)))');
         // allow plane text paste only
         editor.addEventListener("paste", function(e) {
           e.preventDefault();
           document.execCommand("insertText", false, e.clipboardData.getData('text/plain').replace(/^[\s\n\r]+|[\s\n\r]+$/g,''))
         })
         savedSelActiveElement.addEventListener("input", 
           function() {
             saveSelection();
             //check for errors in the syntax
             errorElem.innerHTML = '';
             var string = editor.innerText.replace(/\uFEFF/g,'');
             //mismatched parenthesis
             try {
               balanced.matches({source    : string,
                                 open      : '(',
                                 close     : ')', 
                                 balance   : true, 
                                 exceptions: true});
             } catch(e) {
               errorElem.innerHTML = "<b style='color:red'> : </b>imbalanced parentheses";
             };
             //for incorrect morphology syntax
             var tmpstr = string.replace(/:(?:(?:DG|CA[12]):[\d\?]{4}|SUB:[\d\?]{3}|EC:[\d\?]{6}|CA3:[\d\?]{5})(?=[\s)\uFEFF])/g,'');//console.log(string,tmpstr)
             if (/:(?:DG|CA[1-3]|EC|SUB):|(?:[Aa]xons|[Dd]endrites|[Ss]oma):[\d\?]+/g.test(tmpstr))
               errorElem.innerHTML += "<b style='color:red;'> : </b>check morphology syntax";
             //remove older highlights
             ['b','i','br'].forEach((tag)=>{
               while (elem = savedSelActiveElement.querySelector(tag))
                 elem.outerHTML = elem.innerHTML;
             })
             //add new highlights 
             //innerText should not be used to let rangy work properly 
             savedSelActiveElement.innerHTML = queryHighlighter(savedSelActiveElement.innerHTML);  
             restoreSelection();
           }, false);
       } catch(error) {
         alert('onload: '+error)
       }
   };     function saveSelection() {
       if (savedSel) rangy.removeMarkers(savedSel);
       savedSel = rangy.saveSelection();
     }
     function restoreSelection() {
       if (savedSel) {
         rangy.restoreSelection(savedSel, true);
         savedSel = null;
         window.setTimeout(function() {
           if (savedSelActiveElement && typeof savedSelActiveElement.focus != "undefined") {
             savedSelActiveElement.focus();
           }
         }, 1);
       }
     }               function reCheckQuery() {
       var value = savedSelActiveElement.innerText.replace(/\s*(AND|OR|NOT)\s*/g,' $1 ').replace(/,postsynaptic:\s*/ig,', Postsynaptic:').replace(/\(\s+/g,'(').replace(/\s+\)/g,')').replace(/(?<=[DI])\+(<\/b>)?\-|\-(<\/b>)?\+/ig, "±$1");
       savedSelActiveElement.innerHTML = queryHighlighter(value);
       }
</script>
<?php
/**
 * User: Gas10
 */
if($_REQUEST['search_engine']){
  $qeueryString = trim($_REQUEST['query_str']);
  echo "<script>console.log('Debug Objects: " . $qeueryString . "' );</script>";
  #$qeueryString="Connection:(Presynaptic:(Morphology:(Soma:DG:??1? AND Dendrites:DG:22?? AND Axons:DG:001?) AND Neurotransmitter:Inhibitory), Postsynaptic:(Morphology:DG:2201 AND Name:\"Granule\"))";
  #echo "query<br>".$qeueryString;  
  $test=new Parser();
  $test->setSearchQuery($qeueryString);
  #$test->parseQuery();
  #print("<pre>".print_r($test->parseQuery(),true)."</pre>");
  #print("<pre>".print_r($test->findConnection(array(1000),array(1002,1009)),true)."</pre>");
  $matchingConn=$test->parseQuery();
  if(count($matchingConn)==0){
    print('No Matching Connection Found');
  }
  else{
    print("<b>Total:".count($matchingConn)."</b><br>");
    if(property_exists($matchingConn[0], 'destinationNickname')==1){
    print('<input id="id_toggle" checked type="checkbox" name="Id" value="Id" onclick="hide()"> Neuron Id</input>&nbsp;&nbsp;&nbsp;&nbsp;');
    print('<input id="sourceName_toggle" type="checkbox" name="sourceName" value="sourceName" onclick="show()"> Full Names</input><br>');
    print('<table id="conn" border="0" cellspacing="3" cellpadding="0" class="sortable" width="175%">');
    print('<tr>');
    print("<td align='center' width='10%' class='table_neuron_page3'> Presynaptic ID </td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Presynaptic Cell Type Full Names </td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Presynaptic Cell Type Nicknames </td>");
    print("<td align='center' width='10%' class='table_neuron_page3'> Postsynaptic ID</td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Postsynaptic Cell Type Full Names </td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Postsynaptic Cell Types Nicknames </td>");
     }else{
    print('<input id="id_toggle" checked type="checkbox" name="Id" value="Id" onclick="hide()"> Neuron Id</input>&nbsp;&nbsp;&nbsp;&nbsp;');
    print('<input id="sourceName_toggle" type="checkbox" name="sourceName" value="sourceName" onclick="show()"> Full Names</input><br>');
    print('<table id="conn" border="0" cellspacing="3" cellpadding="0" class="sortable" width="200%">');
    print('<tr>');
    print("<td align='center' width='10%' class='table_neuron_page3'> Neuron ID </td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Neuron Cell Type Full Names </td>");
    print("<td align='center' width='20%' class='table_neuron_page3'> Neuron Cell Type Nicknames </td>");
  }
    for($i=0;$i<count($matchingConn);$i++){
      if (property_exists($matchingConn[0], 'destinationNickname')==1){
      print('<tr>');
      print('<td align="center" width="10%" class="table_neuron_page4">'.$matchingConn[$i]->getSourceId().'</td>');
      print("<td align='center' width='20%' class='table_neuron_page4'>
        <a href='neuron_page.php?id=".$matchingConn[$i]->getSourceId()."'>
        <font class='font13'>".$matchingConn[$i]->getSourceName() . "</font>
        </a></td>");
      print("<td align='center' width='20%' class='table_neuron_page4'>
        <a href='neuron_page.php?id=".$matchingConn[$i]->getSourceId()."'>
        <font class='font13'>".$matchingConn[$i]->getSourceNickname() . "</font>
        </a></td>");
      print('<td align="center" width="10%" class="table_neuron_page4">'.$matchingConn[$i]->getDestinationId().'</td>');
      print ("<td align='center' width='20%' class='table_neuron_page4'> 
        <a href='neuron_page.php?id=".$matchingConn[$i]->getDestinationId()."'>
        <font class='font13'>".$matchingConn[$i]->getDestinationName() . "</font>
        </a></td>");
      print ("<td align='center' width='20%' class='table_neuron_page4'> 
        <a href='neuron_page.php?id=".$matchingConn[$i]->getDestinationId()."'>
        <font class='font13'>".$matchingConn[$i]->getDestinationNickname() . "</font>
        </a></td>
        </tr>");
    }else{
      print('<tr>');
      print('<td align="center" width="10%" class="table_neuron_page4">'.$matchingConn[$i]->getSourceId().'</td>');
      print("<td align='center' width='20%' class='table_neuron_page4'>
        <a href='neuron_page.php?id=".$matchingConn[$i]->getSourceId()."'>
        <font class='font13'>".$matchingConn[$i]->getSourceName() . "</font>
        </a></td>");
      print("<td align='center' width='20%' class='table_neuron_page4'>
        <a href='neuron_page.php?id=".$matchingConn[$i]->getSourceId()."'>
        <font class='font13'>".$matchingConn[$i]->getSourceNickname() . "</font>
        </a></td></tr>");
    }
    }
    print("</table>");
  }
}
?>
</div>
</body>
</html>

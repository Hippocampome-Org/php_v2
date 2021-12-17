<?php
  include ("permission_check.php");
?>
<html>

<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>	
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<title>Query Language</title>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Verdana;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:0in;
	line-height:107%;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";}
h1
	{mso-style-link:"Heading 1 Char";
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:150%;
	page-break-after:avoid;
	font-size:28.0pt;
	font-family:"Verdana","sans-serif";
	color:#2F5496;
	font-weight:bold;}
h2
	{mso-style-link:"Heading 2 Char";
	margin-top:2.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:150%;
	page-break-after:avoid;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";
	color:#2F5496;
	font-weight:bold;}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:36.0pt;
	font-family:"Verdana","sans-serif";
	letter-spacing:-.5pt;
	background:white;
	font-weight:bold;}
p.MsoTitleCxSpFirst, li.MsoTitleCxSpFirst, div.MsoTitleCxSpFirst
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:36.0pt;
	font-family:"Verdana","sans-serif";
	letter-spacing:-.5pt;
	background:white;
	font-weight:bold;}
p.MsoTitleCxSpMiddle, li.MsoTitleCxSpMiddle, div.MsoTitleCxSpMiddle
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:36.0pt;
	font-family:"Verdana","sans-serif";
	letter-spacing:-.5pt;
	background:white;
	font-weight:bold;}
p.MsoTitleCxSpLast, li.MsoTitleCxSpLast, div.MsoTitleCxSpLast
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:36.0pt;
	font-family:"Verdana","sans-serif";
	letter-spacing:-.5pt;
	background:white;
	font-weight:bold;}
a:link, span.MsoHyperlink
	{color:#0563C1;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:#954F72;
	text-decoration:underline;}
p
	{margin-right:0in;
	margin-left:0in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:9.0pt;
	font-family:"Segoe UI","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:.5in;
	line-height:107%;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:107%;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:107%;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:.5in;
	line-height:107%;
	font-size:20.0pt;
	font-family:"Verdana","sans-serif";}
p.msonormal0, li.msonormal0, div.msonormal0
	{mso-style-name:msonormal;
	margin-right:0in;
	margin-left:0in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	mso-style-link:"Heading 1";
	font-family:"Verdana","sans-serif";
	color:#2F5496;
	font-weight:bold;}
span.TitleChar
	{mso-style-name:"Title Char";
	mso-style-link:Title;
	font-family:"Verdana","sans-serif";
	letter-spacing:-.5pt;
	font-weight:bold;}
span.Heading2Char
	{mso-style-name:"Heading 2 Char";
	mso-style-link:"Heading 2";
	font-family:"Verdana","sans-serif";
	color:#2F5496;
	font-weight:bold;}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-link:"Balloon Text";
	font-family:"Segoe UI","sans-serif";}
span.UnresolvedMention
	{mso-style-name:"Unresolved Mention";
	color:#605E5C;
	background:#E1DFDD;}
.MsoPapDefault
	{margin-bottom:8.0pt;
	line-height:107%;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US link="#0563C1" vlink="#954F72">

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>

		
<BR><BR><BR><BR><BR>
		
<div class=WordSection1>

<p class=MsoTitle>Hippocampome.org Query Language</p>

<p class=MsoNormal>&nbsp;</p>

<h1>Objective:</h1>

<p class=MsoNormal>Researchers use different criteria to select the neuron type
they want to study. For example, a researcher might want to study all the
interneurons in the stratum pyramidale of CA1. To manually map the potential
neuron types being studied in this example to Hippocampome.org neuron types,
one should go to the Morphology page of Hippocampome.org and look under CA1:SP
column and choose all the interneurons having soma in this layer. We want to
facilitate this task with the search engine. We have designed a query language
to easily translate experimental criteria to a machine-readable syntax. We have
also designed a search engine to get a query and return neuron types or
potential connection among them. The criteria for fetching the presynaptic or
postsynaptic neurons are morphology, electrophysiology, markers, firing
patterns, and firing pattern parameters. Also, the neuron name, ID, and type
can be included in criteria. </p>

<h1>Query Syntax:</h1>

<p class=MsoNormal>The syntax is inspired by Google’s search operators and we
have tried to make queries easy to read in as much as possible. All queries
should start with either “<b>Neuron:(…)</b>” or “<b>Connection:(Presynaptic:(…),
Postsynaptic:(…))</b>” clause, which means we are searching for neuron types or
potential connections, respectively. “<b>…</b>” is the place holder for neuronal
properties.</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>The syntax for describing the neuronal morphology,
biomarkers, membrane electrophysiology, firing patterns, firing properties,
neurotransmitter, and name are “<b>Morphology:(…)</b>,” “<b>Markers:(…)</b>,” “<b>Electrophysiology:(…)</b>,”
“<b>FiringPattern:(…)</b>,” “<b>FiringPatternParameter:(…)</b>,” “<b>Neurotransmitter:(…)</b>,”
and “<b>Name:(…)</b>,” respectively. Here, <b>…</b> is specific to the neuronal
property. Different neuronal properties can be linked with “<b>AND</b>,” “<b>OR</b>,”
or “<b>NOT</b>” logical operators. To include and exclude specific neuronal
types we allow “<b>Include:(…)</b>” and “<b>Exclude:(…)</b>” clauses.</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>To search for neurons the following format can be used.</p>

<p class=MsoNormal><b>Neuron</b>:(</p>

<p class=MsoNormal style='text-indent:.5in'><b>Morphology</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Electrophysiology</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Markers</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>FiringPattern</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>FiringPatternParameters</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Name</b>:(…)</p>

<p class=MsoNormal style='margin-left:.5in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Neurotransmitter</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Include</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:.5in'><b>Exclude</b>:(…)</p>

<p class=MsoNormal>)</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>To search for potential connections the following format can
be used.</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Connection</b>:(</p>

<p class=MsoNormal style='text-indent:.5in'><b>Presynaptic</b>:(</p>

<p class=MsoNormal style='text-indent:.5in'>     <b>Morphology</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Electrophysiology</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Markers</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>FiringPattern</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>FiringPatternParameters</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Name</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Neurotransmitter</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Include</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Exclude</b>:(…)</p>

<p class=MsoNormal style='text-indent:.5in'>), </p>

<p class=MsoNormal style='text-indent:.5in'><b>Postsynaptic</b>:(</p>

<p class=MsoNormal style='text-indent:.5in'>     <b>Morphology</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Electrophysiology</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Markers</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>FiringPattern</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>FiringPatternParameters</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Name</b>:(…)</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'><span
style='color:#7030A0'>AND/OR/NOT</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Neurotransmitter</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Include</b>:(…)<span
style='color:#7030A0'>,</span></p>

<p class=MsoNormal style='margin-left:1.0in'><b>Exclude</b>:(…)</p>

<p class=MsoNormal>     )</p>

<p class=MsoNormal>)</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Note:</b></p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Although the formats presented in this document are indented and
cross multiple lines for legibility, the search engine only accepts query
strings presented in a single continuous line. </p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Multiple instances of each clause are allowed except Include and
Exclude clauses, for which only one instance is allowed. For example, <b>Neuron</b>:(<b>Morphology</b>:(…)
AND <b>Morphology</b>:(…)) is a valid clause.</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>You should avoid using the Include and Exclude clauses as much as
possible, which contrast with the objective of the search engine.</p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>On the result page, “source” means presynaptic neuron, whereas “destination”
means postsynaptic neuron.</p>

<p class=MsoNormal>&nbsp;</p>

<h1>Search Clauses:</h1>

<h2>Morphology:</h2>

<p class=MsoNormal>Information about the presence “<b>1</b>” or the absence “<b>0</b>”
of dendrites, axons and soma of neurons in a hippocampal layer can be explained
with “<b>Dendrites:(…)</b>,” “<b>Axons:(…)</b>,” and “<b>Soma:(…)</b>” clauses.
Any number of these clauses can be joined with AND/OR/NOT. Here, <b>…</b> are
morphological criteria, which should include subregion and layer-values joined
by a colon, i.e. <b>Subregion</b>:<b>LayerValues</b>. </p>

<p class=MsoNormal><b>Subregion</b> can be either “<b>DG</b>,” “<b>CA3</b>,” “<b>CA2</b>,”
“<b>CA1</b>,” “<b>SUB</b>,” or “<b>EC</b>.”</p>

<p class=MsoNormal><b>LayerValues</b> is a list of “1”s, “0”s, or “?”s. </p>

<p class=MsoNormal style='text-indent:.5in'>1 = present, </p>

<p class=MsoNormal style='text-indent:.5in'>0 = absent, and </p>

<p class=MsoNormal style='text-indent:.5in'>“?” = present or absent. </p>

<p class=MsoNormal><b>LayerValues</b> length should be equal to the number of
layers present within the given subregion in the order present in the
Hippocampome.org morphology page.</p>

<p class=MsoNormal><img width=894 height=133 id="Picture 2"
src="images/Help_Search_Engine_files/image001.png"></p>

<p class=MsoNormal>In other words, DG, CA2, and CA1 need four layer-values, CA3
needs five, SUB needs three, and EC needs six, in the order presented in the
following table. </p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;background:#000099;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b><span style='color:white'>Subregion</span></b></p>
  </td>
  <td valign=top style='border:solid windowtext 1.0pt;border-left:none;
  background:#000099;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b><span style='color:white'>:</span></b></p>
  </td>
  <td colspan=6 valign=top style='border:solid windowtext 1.0pt;border-left:
  none;background:#000099;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><b><span style='color:white'>Layer</span></b></p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>DG</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SMo</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SMi</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SG</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>H</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>CA3</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SLM</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SR</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SL</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SP</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SO</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>CA2</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SLM</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SR</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SP</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SO</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>CA1</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SLM</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SR</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SP</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SO</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SUB</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SM</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>SP</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>PL</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td valign=top style='border:solid windowtext 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>EC</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>:</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>I</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>II</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>III</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>IV</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>V</p>
  </td>
  <td valign=top style='border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>VI</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>A colon is necessary but parentheses are not if only one
morphological criterion is present. For example,</p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Morphology</b>:<b><span style='color:#0000CC'>Axons</span></b>:<b><span
style='color:#C00000'>DG</span></b>:<i>???1</i>” means axons were present in DG
Hilus.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Morphology</b>:<b><span style='color:#0000CC'>Dendrites</span></b>:<b><span
style='color:#C00000'>DG</span></b>:<i>11?0</i>” means dendrites were present in
DG outer Stratum Moleculare (SMo: at 1st index of layer values) and in DG inner
Stratum Moleculare (SMi: 2nd index) but not in DG Hilus (H: 4th index), while presence
or absence of dendrites in DG Stratum Granulosum (SG: 3<sup>rd</sup> index) is unknown.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Morphology</b>:<b><span style='color:blue'>Soma</span></b>:<b><span
style='color:#C00000'>CA3</span></b>:<i>00000</i>” means soma were not present in
any layer of CA3.</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Morphology</b>:(<b><span style='color:blue'>Axons</span></b>:<b><span
style='color:#C00000'>DG</span></b>:<i>0???</i> <b><span style='color:#7030A0'>AND</span></b><span
style='color:#7030A0'> </span>(<b><span style='color:blue'>Dendrites</span></b>:<b><span
style='color:#C00000'>DG</span></b>:<i>1111</i> <b><span style='color:#7030A0'>OR</span></b><span
style='color:#7030A0'> </span><b><span style='color:blue'>Soma</span></b>:<b><span
style='color:#C00000'>CA3</span></b>:<i>10001</i>))” is an example that
combines different criteria.</p>

<p class=MsoNormal>Layer values greater than one are allowed and, like one
itself, they indicate presence.</p>

<p class=MsoListParagraph style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><b><span style='color:blue'>Dendrites</span></b>:<b><span
style='color:#C00000'>DG</span></b>:<i>2222</i> is equivalent to <b><span
style='color:blue'>Dendrites</span></b>:<b><span style='color:#C00000'>DG</span></b>:<i>1111.</i></p>

<p class=MsoNormal>&nbsp;</p>

<h2>Markers: </h2>

<p class=MsoNormal>A neuron can either express a marker “<b>+</b>,” not express
it “<b>-</b>,” or have a mixed profile “<b>±</b>.” The information we have for
the presence or absence of markers can be either based on direct “<b>D</b>” or
inferential “<b>I</b>” evidence.</p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Markers</b>:<b><span style='color:blue'>D+</span></b>:CCK” finds
all neuron types that have a positive direct inference for CCK.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Markers</b>:(<b><span style='color:blue'>I+</span></b>:CCK <b><span
style='color:#7030A0'>OR</span></b><span style='color:#7030A0'> </span><b><span
style='color:blue'>I±</span></b>:CB)” finds all neuron types that have positive
inference for CCK or mixed inference for CB.</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Markers</b>:(<b><span style='color:blue'>D+</span></b>:CCK <b><span
style='color:#7030A0'>OR</span></b> (<b><span style='color:blue'>D-</span></b>:CB
<b><span style='color:#7030A0'>AND</span></b> <b><span style='color:blue'>D-</span></b>:PV))”
is an example for multiple marker criteria.</p>

<p class=MsoNormal><img width=1766 height=230 id="Picture 3"
src="images/Help_Search_Engine_files/image002.png"></p>

<h2>Firing Patterns:</h2>

<p class=MsoNormal>The syntax is similar to markers, except that here we have
only direct inferences.</p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>FiringPattern</b>:<b><span style='color:blue'>D+</span></b>:ASP.”
finds all neuron types that have the firing pattern “ASP.”</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>FiringPattern</b>:(<b><span style='color:blue'>D+</span></b>:ASP.
<b><span style='color:#7030A0'>AND</span></b> <b><span style='color:blue'>D+</span></b>:FASP.)”
finds all neuron types that have the firing patterns “ASP.” and “FASP.”</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>FiringPattern</b>:(<b><span style='color:blue'>D-</span></b>:PSWB
<b><span style='color:#7030A0'>AND</span></b> (<b><span style='color:blue'>D+</span></b>:ASP.
<b><span style='color:#7030A0'>OR</span></b> <b><span style='color:blue'>D-</span></b>:FASP.))”
is an example for multiple firing-pattern criteria.</p>

<p class=MsoNormal>&nbsp;</p>

<h2>Electrophysiology and Firing Pattern Parameter:</h2>

<p class=MsoNormal>These are numerical parameters for which we want to set a cutoff
point.</p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Electrophysiology</b>:<b><span style='color:blue'>Rin</span></b>:&lt;100”
finds neurons having an input-resistance of less than 100 M&#8486;.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Electrophysiology</b>:<b><span style='color:blue'>max_fr</span></b>:&gt;100”
or “<b>Electrophysiology</b>:<b><span style='color:blue'>max_fr</span></b>&gt;100”
find all neuron types that have a maximum firing rate greater than 100 Hz.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Electrophysiology</b>:(<b><span style='color:blue'>max_fr</span></b>:&gt;50
<b><span style='color:#7030A0'>OR</span></b> <b><span style='color:blue'>Vrest</span></b>:&gt;=-65)”
finds all neuron types that have a maximum firing rate greater than 50 Hz or a
resting potential greater than or equal to -65 mV.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Electrophysiology</b>:((<b><span style='color:blue'>max_fr</span></b>:&gt;29.89
<b><span style='color:#7030A0'>OR</span></b> <b><span style='color:blue'>Vrest</span></b>:&gt;=4.3)
<b><span style='color:#7030A0'>AND</span></b> <b><span style='color:blue'>Rin</span></b>:147)”
is an example of multiple criteria.</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>FiringPatternParameter</b>:<b><span style='color:blue'>delay_ms</span></b>:&gt;2”
finds all neuron types that have a delayed firing greater than 2 ms.</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>FiringPatternParameter</b>:(<b><span style='color:blue'>delay_ms</span></b>:&gt;2
<b><span style='color:#7030A0'>OR</span></b> <b><span style='color:blue'>istim_pa</span></b>:&lt;=4.3)”
is an example of multiple criteria.</p>

<p class=MsoNormal><b>Note:</b> For equal either use “:” or “=,” but not both
at the same time. For example, “<b>Electrophysiology</b>:<b><span
style='color:#7030A0'>Rin</span></b>:=147” is Invalid.</p>

<h2>&nbsp;</h2>

<h2>Name:</h2>

<p class=MsoNormal>Search based on the formal neuron names. Multiple criteria
are allowed. Space, ' or &quot; characters are not allowed instead you can use
the AND condition. </p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><b>Name</b>:(Interneuron <b><span style='color:#7030A0'>AND</span></b>
Specific) finds any neuron named “Interneuron Specific.”</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><b>Name</b>:((Interneuron <b><span style='color:#7030A0'>AND</span></b>
Specific) <b><span style='color:#7030A0'>OR</span></b> Basket <b><span
style='color:#7030A0'>OR</span></b> Axo-Axonic) is an example of multiple
criteria.</p>

<p class=MsoNormal>&nbsp;</p>

<h2>Neurotransmitter:</h2>

<p class=MsoNormal>A neuron can be either “Excitatory” or “Inhibitory.” We also
recognize the “Both” flag.</p>

<p class=MsoListParagraph style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><b>“Connection</b>:(<b>Presynaptic</b>:(<b>Neurotransmitter</b>:<b><span
style='color:blue'>Both</span></b>), <b>Postsynaptic</b>:(<b>Neurotransmitter</b>:<b><span
style='color:blue'>Both</span></b>))” returns all the potential connections in
the Hippocampome.org</p>

<p class=MsoNormal>&nbsp;</p>

<h2>Include and Exclude:</h2>

<p class=MsoNormal>Whenever search by neuronal properties needs to be trimmed,
these commands are used. You need to know the numerical neuron IDs to use these
commands.</p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><b>“Include</b>:1000” adds DG Granule cell to the list of
presynaptic or postsynaptic neuron types.</p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;text-indent:-.5in'><span
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>“<b>Include</b>:(1000,1002,1005)” adds DG Granule, Mossy, and
MOLAX cells to the list of presynaptic or postsynaptic neuron types.</p>

<p class=MsoNormal><b>Note:</b> The search engine returns the neuron IDs. If
you go to the neuron page of each neuron, you can find the neuron ID in the
URL.</p>

<p class=MsoNormal><img width=432 height=431 id="Picture 6"
src="images/Help_Search_Engine_files/image003.png"></p>

<p class=MsoNormal><img width=677 height=264 id="Picture 8"
src="images/Help_Search_Engine_files/image004.png"></p>

<p class=MsoNormal>&nbsp;</p>

<h1>List of Parameters</h1>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 title=""
 summary="" width="100%" style='width:100.0%;border-collapse:collapse;
 border:none'>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  background:#002060;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%;color:white'>Morphology</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border:solid #A3A3A3 1.0pt;
  border-left:none;background:#002060;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%;color:white'>Markers</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border:solid #A3A3A3 1.0pt;
  border-left:none;background:#002060;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%;color:white'>Electrophysiology</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border:solid #A3A3A3 1.0pt;
  border-left:none;background:#002060;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%;color:white'>FiringPattern </span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border:solid #A3A3A3 1.0pt;
  border-left:none;background:#002060;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%;color:white'>FiringPatternParameters</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>axons</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CB</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Vrest</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>istim_pa</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>dendrites</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CR</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Rin</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ASP.ASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>tstim_pa</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>soma</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PV</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>tm</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ASP.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>delay_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CB1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Vthresh</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ASP.SLN</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>pfs_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Mus2R</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>fast_AHP</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>swa_mv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Sub P Rec</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AP_ampl</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.ASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>nisi</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>5HT-3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AP_width</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.FASP.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Gaba-a-alpha</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>max_fr</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>sd_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR1a</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slow_AHP</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.PSTUT</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>max_isi_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>vGluT3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>sag_ratio</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>D.TSWB.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>min_isi_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CCK</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>FASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>first_isi_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ENK</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>FASP.ASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav1_2_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>NPY</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>FASP.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav1_3_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>SOM</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>FASP.SLN</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav1_4_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>VIP</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>last_isi_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>NG</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PSTUT</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiavn_n_1_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>alpha-actinin</span><span
  style='line-height:107%'>-2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PSWB</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiavn_n_2_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CoupTF II</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSTUT.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiavn_n_3_ms</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>nNOS</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSTUT</span><span
  style='line-height:107%'>.ASP.</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisi_minisi</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>RLN</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSTUT.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisin_isin_m1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>DYN</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSTUT.SLN</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisin_isin_p1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>NKB</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSWB.NASP</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ai</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PPTA</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TSWB.SLN</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>rdmax</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>vGluT2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>df</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GAT-1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>sf</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CGRP</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>tmax_scaled</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR2/3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isimax_scaled</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR5</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav_scaled</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Prox1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>sd_scaled</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa \delta</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>VILIP</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Mus1R</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Mus3R</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Mus4R</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>css_yc1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ErbB4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>xc1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CaM</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Y1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Man1a</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope3</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Bok</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept3</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PCP4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>xc2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AMIGO2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>yc2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AMPAR 2/3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f1_2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Disc1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f1_2crit</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PSA-NCAM</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f2_3</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>BDNF</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f2_3crit</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p-CREB</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f3_4</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>SCIP</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f3_4crit</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Math-2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p1_2</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Neuropilin2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p2_3</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>vGAT</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p3_4</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p1_2uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Caln</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p2_3uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>vGlut1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p3_4uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isii_isii_m1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>i</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>SPO</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav_i_n_isi1_i_m1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\alpha 2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisij_isij_m1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\alpha 3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisij_isij_p1</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\alpha 4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>nisi_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\alpha 5</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav_ms_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\alpha 6</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>maxisi_ms_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\beta 1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>minisi_ms_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\beta 2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>first_isi_ms_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\beta 3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>tmax_scaled_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\gamma 1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isimax_scaled_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABAa\gamma 2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>isiav_scaled_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR5a</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>sd_scaled_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GAT-3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>ChAT</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>EAAT3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope1_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GlyT2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept1_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR7a</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>css_yc1_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR8a</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>xc1_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>MOR</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>vAChT</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AChE</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>slope3_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Kv3.1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>intercept3_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Cx36</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>xc2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Sub P</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>yc2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Id-2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f1_2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AR-beta1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f1_2crit_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>AR-beta2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f2_3_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>SATB1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f2_3crit_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>TH</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f3_4_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>NECAB1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f3_4crit_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>mGluR4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p1_2_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Chrna2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p2_3_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>SATB2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p3_4_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>Ctip2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p1_2uv_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CXCR4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p2_3uv_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GABA-B1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p3_4uv_c</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GluA2</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>m_2p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GluA1</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c_2p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GluA3</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>m_3p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>GluA4</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c1_3p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>PPE</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c2_3p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>CRF</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>m1_4p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c1_4p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>m2_4p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c2_4p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>n_isi_cut_3p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>n_isi_cut_4p</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_12</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_crit_12</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_23</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_crit_23</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_34</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>f_crit_34</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_12</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_12_uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_23</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_23_uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_34</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>p_34_uv</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>m_fasp</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>c_fasp</span></p>
  </td>
 </tr>
 <tr>
  <td width="14%" valign=top style='width:14.3%;border:solid #A3A3A3 1.0pt;
  border-top:none;padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="18%" valign=top style='width:18.42%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="21%" valign=top style='width:21.06%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="17%" valign=top style='width:17.4%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>&nbsp;</span></p>
  </td>
  <td width="28%" valign=top style='width:28.82%;border-top:none;border-left:
  none;border-bottom:solid #A3A3A3 1.0pt;border-right:solid #A3A3A3 1.0pt;
  padding:2.0pt 3.0pt 2.0pt 3.0pt'>
  <p class=MsoNormal><span style='line-height:107%'>n_isi_cut_fasp</span></p>
  </td>
 </tr>
</table>

<h1>Sample Query:</h1>

<p class=MsoNormal>You can find hundreds of examples on the Evidence tab of our
Synaptome spreadsheet.</p>

<p class=MsoNormal><b>Connection</b>:(<b>Presynaptic</b>:(<b>Morphology</b>:<b><span
style='color:blue'>Soma</span></b>:<b><span style='color:#C00000'>DG</span></b>:<i>0???</i>
<b><span style='color:#7030A0'>AND</span></b> <b>Neurotransmitter</b>:<b><span
style='color:blue'>Inhibitory</span></b>), <b>Postsynaptic</b>:(<b>FiringPatternParameter</b>:<b><span
style='color:blue'>delay_ms</span></b>:&gt;0 <b><span style='color:#7030A0'>AND</span></b>
<b>Markers</b>:<b><span style='color:blue'>D-</span></b>:CCK <b><span
style='color:#7030A0'>AND</span></b> <b>Electrophysiology</b>:<span
style='color:blue'>vrest</span>&lt;0))</p>

<p class=MsoNormal>&nbsp;</p>

<h1>API access</h1>

<p class=MsoNormal>The link <a
href="http://hippocampome.org/csv2db/search_engine_json.php?query_str=">http://hippocampome.org/csv2db/search_engine_json.php?query_str=</a>
behaves like an API. You need to put your query after “=” sign. For example,
the URL</p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%;background:#BFBFBF;border-collapse:collapse;border:none'>
 <tr>
  <td width="100%" valign=top style='width:100.0%;border:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><a
  href="http://hippocampome.org/csv2db/search_engine_json.php?query_str=">http://hippocampome.org/csv2db/search_engine_json.php?query_str=</a>Connection:(Presynaptic:(Neurotransmitter:Inhibitory
  AND Morphology:(Axons:CA3:??1?? OR Soma:CA3:??1??)), Postsynaptic:(Morphology:(Soma:DG:??1?)
  AND Name:Granule))</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>After URL encoding and resolving, you get a stringified JSON.
<span style='background:white'>Parsing the results, you can access a JSON
database of potential connections.</span></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%;background:#BFBFBF;border-collapse:collapse;border:none'>
 <tr>
  <td width="100%" valign=top style='width:100.0%;border:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>{</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>   &quot;<b>1</b>&quot;:{</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>      &quot;<b>source_id</b>&quot;:&quot;1026&quot;,</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>      &quot;<b>destination_id</b>&quot;:&quot;1000&quot;</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>   },</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>   &quot;<b>2</b>&quot;:{</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>      &quot;<b>source_id</b>&quot;:&quot;2019&quot;,</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>      &quot;<b>destination_id</b>&quot;:&quot;1000&quot;</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>   }</p>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'>}</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>If there was an error, you may want to detect it with regex <span
style='color:#C45911'>/\s*&lt;pre&gt;\s*?&lt;\/pre&gt;/</span><span
style='background:white'> </span>before parsing the results.</p>

<p class=MsoNormal>&nbsp;</p>

</div>

</body>

</html>

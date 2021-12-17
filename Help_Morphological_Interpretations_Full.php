<?php
  include ("permission_check.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Help</title>
<script type="text/javascript" src="style/resolution.js"></script>
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
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
h1
	{mso-style-link:"Heading 1 Char";
	margin-top:15.0pt;
	margin-right:0in;
	margin-bottom:2.0pt;
	margin-left:0.15in;
	line-height:115%;
	font-size:16.0pt;
	font-family:"Calibri","sans-serif";
	font-variant:small-caps;
	letter-spacing:.25pt;
	font-weight:normal;}
p.MsoFootnoteText, li.MsoFootnoteText, div.MsoFootnoteText
	{mso-style-link:"Footnote Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	text-align:justify;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-name:"Header\, Char";
	mso-style-link:"Header Char\, Char Char1";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-name:"Title\,Char Char Char";
	mso-style-link:"Title Char\,Char Char Char Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0.15in;
	text-align:right;
	border:none;
	padding:0in;
	font-size:24.0pt;
	font-family:"Calibri","sans-serif";
	font-variant:small-caps;}
p.MsoDate, li.MsoDate, div.MsoDate
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
p
	{margin-right:0in;
	margin-left:0.15in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-name:"Balloon Text\, Char";
	mso-style-link:"Balloon Text Char\, Char Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.65in;
	text-align:justify;
	line-height:115%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.65in;
	margin-bottom:.0001pt;
	text-align:justify;
	line-height:115%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.65in;
	margin-bottom:.0001pt;
	text-align:justify;
	line-height:115%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.65in;
	text-align:justify;
	line-height:115%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	mso-style-link:"Heading 1";
	font-family:"Calibri","sans-serif";
	font-variant:small-caps;
	letter-spacing:.25pt;}
span.FootnoteTextChar
	{mso-style-name:"Footnote Text Char";
	mso-style-link:"Footnote Text";
	font-family:"Calibri","sans-serif";}
span.TitleChar
	{mso-style-name:"Title Char\,Char Char Char Char";
	mso-style-link:"Title\,Char Char Char";
	font-family:"Calibri","sans-serif";
	font-variant:small-caps;}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char\, Char Char";
	mso-style-link:"Balloon Text\, Char";
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char\, Char Char1";
	mso-style-link:"Header\, Char";}
span.url
	{mso-style-name:url;}
span.subpages
	{mso-style-name:subpages;}
.MsoChpDefault
	{font-size:10.0pt;}
 /* Page Definitions */
 @page WordSection1
	{size:11.0in 8.5in;
	margin:23.75pt .25in .25in 23.75pt;}
div.WordSection1
	{page:WordSection1;}
@page WordSection2
	{size:11.0in 8.5in;
	margin:23.75pt .25in .25in 23.75pt;}
div.WordSection2
	{page:WordSection2;}
@page WordSection3
	{size:11.0in 8.5in;
	margin:23.75pt .25in .25in 23.75pt;}
div.WordSection3
	{page:WordSection3;}
@page WordSection4
	{size:11.0in 8.5in;
	margin:23.75pt .25in .25in 23.75pt;}
div.WordSection4
	{page:WordSection4;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>
		
<BR><BR><BR><BR><BR>
	
<div class=WordSection1>

<p class=MsoTitle align=left style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:left;border:none'><b><u><span style='font-size:16.0pt;font-family:
"Arial","sans-serif";font-variant:normal !important'>Full<span
style='text-transform:uppercase'> P</span>rotocols<span style='text-transform:
uppercase'> </span>for<span style='text-transform:uppercase'> M</span>orphological<span
style='text-transform:uppercase'> I</span>nterpretations</span></u></b></p>

<p class=MsoNormal style='margin-left:.5in'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-.5in'><b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>1<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on a drawing or reconstruction of an actual
neuron</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-.5in'><b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>2<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on a schematic</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-.5in'><b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>3<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on text where the locations are categorically
stated</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:-.5in'><b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>4<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on text where the locations are equivocal</span></b></p>

<p class=MsoNormal style='margin-left:.75in'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:.15in;'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>1<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on a drawing or reconstruction of an actual
neuron</span></b></p>

<p class=MsoListParagraphCxSpFirst align=left style='margin-bottom:0in;
margin-bottom:.0001pt;text-align:left;text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'>A.<span
style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'>First,
in order for a given layer to be considered, the axons or dendrites in that
layer must be 15% or more of the arbor and must penetrate 15% or more of the
layer.</span></p>

<p class=MsoListParagraphCxSpMiddle align=left style='margin-bottom:0in;
margin-bottom:.0001pt;text-align:left'><span style='font-size:14.0pt;
line-height:115%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpLast align=left style='margin-bottom:0in;
margin-bottom:.0001pt;text-align:left;text-indent:-.25in'><span
style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'>B.<span
style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'>If
the proportion of branches / boutons / synapses is reported (i.e. 25% in SO,
10% in SR, etc.), then the layer is recorded if the proportion is at least 15%
of the entire tree.  If none of the proportions qualify (i.e. 12%, 10%, 8%,
etc.), compare the relative sizes of the proportions to the largest proportion
(i.e. 12/12, 10/12, 8/12, etc.) and report those layers where the proportions
are at least half the size of the largest proportion.</span></p>

<p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoListParagraph align=left style='margin-bottom:0in;margin-bottom:
.0001pt;text-align:left;text-indent:-.25in'><span style='font-size:14.0pt;
line-height:115%;font-family:"Arial","sans-serif"'>C.<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span><span style='font-size:14.0pt;line-height:115%;font-family:"Arial","sans-serif"'>3-point
Rule: Report an axonal/dendritic location if the given layer has at least 3
points worth of branches.  (e.g. 2 terminating branches, 1 terminating + 1
continuing branch, or 3 continuing branches), and the branches making up the
three points are 15% or more of the total dendritic/axonal arbor.</span></p>

<p class=MsoNormalCxSpFirst><span style='font-size:1.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:.5in;line-height:115%'><b><span style='font-size:14.0pt;
line-height:115%;font-family:"Arial","sans-serif"'>Definitions:</span></b></p>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
 style='margin-left:.5in;border-collapse:collapse;border:none'>
 <tr>
  <td width=389 valign=top style='width:292.1pt;border:solid windowtext 1.0pt;
  border-right:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>1) A terminating branch ends in a</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>given layer and satisfies the 15% rule</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>(the length of the branch and the</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>invasion depth into the layer are both</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>at least 15%</span><span style='font-size:
  14.0pt;font-family:"Arial","sans-serif"'> of the layers thickness).</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>(also see note below)</span></p>
  <p class=MsoNormal style='margin-left:7.7pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif";color:red'> (2 points for each encircled
  branch)</span></p>
  </td>
  <td width=78 valign=top style='width:58.8pt;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>
  <p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'><img
  width=64 height=191 id="Picture 13"
  src="help/images/Morphological_Interpretations_Full_001.gif"></span></p>
  <p class=MsoNormal><b><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>
  </td>
  <td width=390 valign=top style='width:292.3pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-left:7.8pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>2) A continuing branch invades at</span></p>
  <p class=MsoNormal style='margin-left:7.8pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>least 15% of a layer but does not</span></p>
  <p class=MsoNormal style='margin-left:7.8pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>terminate in that layer. (also see note)</span></p>
  <p class=MsoNormal style='margin-left:7.8pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif";color:red'>(1 point for each encircled
  branch)</span></p>
  </td>
  <td width=79 valign=top style='width:59.05pt;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>
  <p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'><img
  width=60 height=191 id="Picture 1"
  src="help/images/Morphological_Interpretations_Full_002.gif"></span></p>
  <p class=MsoNormal><b><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>
  </td>
  <td width=390 valign=top style='width:292.3pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>(note) A continuing branch that fails</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>the definition of a terminating branch</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>in the next layer is reported as a</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>terminating branch in the continuing</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>layer if the branch satisfies the 15%</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>rule in the continuing layer, otherwise</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif"'>it is disregarded.</span></p>
  <p class=MsoNormal style='margin-left:7.45pt'><span style='font-size:14.0pt;
  font-family:"Arial","sans-serif";color:red'>(2 points for each encircled
  branch)</span></p>
  </td>
  <td width=79 valign=top style='width:59.05pt;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>
  <p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'><img
  width=64 height=191 id="Picture 16"
  src="help/images/Morphological_Interpretations_Full_003.gif"></span></p>
  <p class=MsoNormal><b><span style='font-size:4.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-left:.25in'><b><span style='font-size:1.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal style='margin-left:.25in;line-height:200%'><b><span
style='font-size:14.0pt;line-height:200%;font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

</div>

<b><span style='font-size:14.0pt;line-height:200%;font-family:"Arial","sans-serif"'><br
clear=all style='page-break-before:auto'>
</span></b>

<div class=WordSection2>

<p class=MsoNormal style='margin-left:.25in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></p>

</div>

<b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'><br
clear=all style='page-break-before:auto'>
</span></b>

<div class=WordSection3>

<p class=MsoNormal style='margin-top:0in;margin-right:121.5pt;margin-bottom:
12.0pt;margin-left:0.15in'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>2<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><span style='position:absolute;z-index:251670016;left:0px;
margin-left:941px;margin-top:7px;width:125px;height:148px'><img width=125
height=148 src="help/images/Morphological_Interpretations_Full_004.jpg"></span><b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on a schematic</span></b></p>


<p class=MsoNormal style='text-indent:.35in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>Report an axonal/dendritic location based 
on layers traversed by more than 15% in a schematic</span></p>

<p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='text-indent:.35in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>e.g. In the figure to the right, the shaded
box depicts axons, so report axons in stratum</span></p>

<p class=MsoNormal style='text-indent:.35in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>pyramidale, but do not report axons in
stratum oriens and stratum radiatum.</span></p>

<p class=MsoNormal style='line-height:150%'><span style='font-size:14.0pt;
line-height:150%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:0.15in;line-height:
150%'><b><span style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>3<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;line-height:150%;font-family:
"Arial","sans-serif"'>Reporting axonal/dendritic locations based on text where
the locations are categorically stated</span></b></p>

<p class=MsoNormal style='margin-left:.35in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>e.g. Report CA1 O-LM neuron dendrites in 
CA1 stratum oriens: In the CA1 area, O-LM cells are located in stratum oriens and have horizontally extending dendrites
with hairy spines on distal segments. (Klausberger T, Eur J Neurosci, 2009
Sep, 30 (6), pages: 947  957, PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/19735288"><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>19735288</span></a><span style='font-size:
14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='line-height:150%'><span style='font-size:14.0pt;
line-height:150%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:0.15in'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>4<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Reporting
axonal/dendritic locations based on text where the locations are equivocal</span></b><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'> </span></p>

<p class=MsoNormal style='margin-left:.35in'><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>e.g.
Report dendrites in CA1 stratum radiatum (SR) and stratum lacunosum-moleculare
(SLM), but omit dendrites in stratum pyramidale (SP) and stratum oriens (SO):
2. [CA1] Schaffer-associated interneurones. These &#64257;ve cells were
multipolar, with most of their smooth or sparsely spiny dendritic arborisation
contained within the SR and SLM (Figs. 10, 11) and only rarely entering the SP
and SO. (Pawelzik H, Hughes DI, and Thomson AM, J Comp Neurol, 2002 Feb 18,
443 (4), pages: 346  367, PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/11807843"><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>11807843</span></a><span style='font-size:
14.0pt;font-family:"Arial","sans-serif"'>).  </span></p>

<p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.5in;text-indent:-.25in'><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>1)<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Trigger words or
phrases:</span></p>

</div>

<span style='font-size:14.0pt;font-family:"Arial","sans-serif"'><br clear=all
style='page-break-before:auto'>
</span>

<div class=WordSection4>

<p class=MsoNormal style='margin-left:.5in'><b><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
 style='margin-left:27.9pt;border-collapse:collapse;border:none'>
 <tr style='height:206.5pt'>
  <td width=264 valign=top style='width:2.75in;border:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:206.5pt'>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><u><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>Report</span></u></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>most</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>majority</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>superficial/deep
  layer X</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>usually</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>proximal/distal
  layer X</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>septal/temporal
  layer X</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>all
  layers</span></p>
  </td>
  <td width=294 valign=top style='width:220.5pt;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt;height:206.5pt'>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><u><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>Omit</span></u></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>a
  few/some</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>minority</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>rarely</span><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'> </span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>at
  the border of</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>sometimes/occasional</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>toward
  layer X</span></p>
  <p class=MsoNormal style='margin-left:8.1pt;line-height:150%'><span
  style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>a
  small fraction/number of</span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:.5in'><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:.5in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'>2)<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>Interpreting
ambivalent phrases.  </span></p>

<p class=MsoNormal style='margin-left:.75in;text-indent:-.75in;line-height:
150%'><span style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'><span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>i.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><u><span style='font-size:14.0pt;line-height:150%;font-family:
"Arial","sans-serif"'>If not specifically defined otherwise by the author(s) </span></u></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>entorhinal cortex
deep layers are layers V-VI.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>entorhinal cortex
superficial layers are layers I-III.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the alveus is part of
stratum oriens (SO). </span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>hippocampus is CA1
and CA3.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><img
width=252 height=161 src="help/images/Morphological_Interpretations_Full_005.jpg"
align=left hspace=24 style='margin-left:-24px;margin-right:24px'><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>apical dendrites are
the portion of the dendritic tree located in both stratum radiatum (SR) and
stratum lacunosum-moleculare (SLM) for CA1, CA2, and CA3.</span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'> </span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase apical
tuft is interpreted as the portion of the apical dendritic tree located in
stratum lacunosum-moleculare (SLM).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase oblique
dendrites is interpreted as a subset of the apical dendrites located in
stratum radiatum (SR) for CA1/CA2.</span><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'> </span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase basal
dendrites is interpreted as the portion of the dendritic tree located in
stratum oriens (SO).      </span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:12.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the stratum
moleculare (SM) of the dentate gyrus (DG) is not specific enough for reporting
locations of axons and dendrites.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase outer
stratum moleculare (SMo) of the dentate gyrus (DG) is interpreted as the
two-thirds of the layer farthest from the stratum granulosum (SG).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase inner
stratum moleculare (SMi) of the dentate gyrus (DG) is interpreted as the
one-third of the layer closest to the stratum granulosum (SG).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase perforant
path termination zone is interpreted as the outer stratum moleculare (SMo) for
the dentate gyrus (DG), stratum lacunosum-moleculare (SLM) for CA1/CA2/CA3, and
stratum moleculare (SM) for the subiculum.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase regio
inferior is interpreted as CA3 (see Blaabjerg M and Zimmer J, Prog Brain Res,
2007, pages: 85  107. PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/?term=17765713"><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>17765713</span></a><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase regio
superior is interpreted as CA1 (see Blaabjerg M and Zimmer J, Prog Brain Res,
2007, pages: 85  107. PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/?term=17765713"><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>17765713</span></a><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase CA4 is
interpreted as the dentate gyrus (DG) hilus (see Blaabjerg M and Zimmer J, Prog
Brain Res, 2007, pages: 85  107. PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/?term=17765713"><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>17765713</span></a><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase fascia
dentata is interpreted as the dentate gyrus (DG) stratum granulosum (SG) and
stratum moleculare (SM) (see Blaabjerg M and Zimmer J, Prog Brain Res, 2007,
pages: 85  107. PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/?term=17765713"><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>17765713</span></a><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase Brodmann
Area 28 is interpreted as entorhinal cortex (EC) (see <span class=subpages>Witter
M, 2011, Scholarpedia, 6 (10), page: </span></span><a
href="http://www.scholarpedia.org/article/Entorhinal_cortex#Definition_and_history"><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>4380</span></a><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase lateral
entorhinal area (LEA) is interpreted as lateral entorhinal cortex (LEC).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase medial
entorhinal area (MEA) is interpreted as medial entorhinal cortex (MEC).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase Schaffer
collaterals refers specifically to CA3 pyramidal neuron axons.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the phrase mossy
fibers refers specifically to dentate gyrus granule cell axons.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>rats under 200 g
and/or less than 3 weeks old are considered to be juveniles (Dumas TC, personal
communication).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>rats at least 200 g
and/or more than 3 weeks old are considered to be adults (Dumas TC, personal
communication).</span></p>

<p class=MsoNormal style='margin-left:1.0in;line-height:150%'><span
style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.75in;text-indent:-.75in;line-height:
150%'><span style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'><span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>ii.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><u><span style='font-size:14.0pt;line-height:150%;font-family:
"Arial","sans-serif"'>Despite what is stated by the author(s) </span></u></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the location of
apical proximal dendrites is reported as stratum radiatum (SR) for CA1/CA2,
stratum lucidum (SL) for CA3, and inner stratum moleculare (SMi) for the
dentate gyrus (DG).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>the location of
basal proximal dendrites is reported as stratum oriens (SO) for CA1/CA2/CA3,
and the hilus (H) for the dentate gyrus (DG).</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>perisomatic axonal
targeting, such as somata, proximal dendrites, and axon initial segments, is
reported as stratum pyramidale (SP) for CA1/CA2/CA3/subiculum (SUB) and stratum
granulosum (SG) for the dentate gyrus (DG).  This rule applies specifically to
basket and axo-axonic (a.k.a. chandelier) neurons.</span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>depictions of axons
or dendrites in a principal cell layer do not have their locations reported if
they are within ~100 </span><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&#956;</span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>m of the soma, as
they are considered to be perisomatic, i.e. part of the soma, as defined by
Freund and Katona (Neuron, 2007 Oct 4, 56 (1), pages: 33  42, PMID: </span><a
href="http://www.ncbi.nlm.nih.gov/pubmed/17920013"><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>17920013</span></a><span style='font-size:
14.0pt;font-family:"Arial","sans-serif"'>).</span><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'> </span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:6.0pt;
margin-left:1.0in;text-indent:-.25in'><span style='font-size:14.0pt;font-family:
"Arial","sans-serif"'><span style='font:7.0pt "Times New Roman"'>&nbsp; </span></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'>
CA2 stratum lucidum (SL) is interpreted as the incursion of mossy fibers,
i.e. Granule cell axons, into CA2 stratum pyramidale (SP).
</span></p>

<p class=MsoNormalCxSpMiddle style='line-height:150%'><span style='font-size:
14.0pt;line-height:150%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormalCxSpMiddle style='margin-top:0in;margin-right:0in;margin-bottom:
12.0pt;margin-left:.75in;text-indent:-.75in;line-height:150%'><span
style='font-size:14.0pt;line-height:150%;font-family:"Arial","sans-serif"'><span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>iii.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><u><span style='font-size:14.0pt;line-height:150%;font-family:
"Arial","sans-serif"'>Extending the principal cell layers:</span></u></p>

<p class=MsoNormal style='margin-left:.75in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>The 15% of CA1/CA2/CA3 stratum oriens (SO)
and CA1/CA2 stratum radiatum (SR) that are adjacent to CA1/CA2/CA3 stratum
pyramidale (SP) are loosely interpreted as parts of SP, if not specifically
defined otherwise by the author(s).</span></p>

<p class=MsoNormal style='margin-left:.75in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.75in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>The 15% of the inner stratum moleculare (SMi)
and the hilus (H) that are adjacent to stratum granulosum (SG) are loosely
interpreted as parts of stratum granulosum, if not specifically defined
otherwise by the author(s).</span></p>

<p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.75in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>The 15% of the stratum moleculare (SM) and
the polymorphic layer (PL) in the subiculum (SUB) that are adjacent to stratum
pyramidale (SP) are loosely interpreted as parts of SP, if not specifically
defined otherwise by the author(s).</span></p>

<p class=MsoNormal style='margin-left:.75in'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.75in'><span style='position:absolute;
z-index:251678208;left:0px;margin-left:718px;margin-top:11px;width:198px;
height:49px'><img width=198 height=49
src="help/images/Morphological_Interpretations_Full_006.gif"
alt="from Gulyas et al. (1993) Eur. J. Neurosci. 5:1729."></span><span
style='position:absolute;z-index:251676160;left:0px;margin-left:486px;
margin-top:150px;width:25px;height:17px'><img width=25 height=17
src="help/images/Morphological_Interpretations_Full_007.gif"></span><span
style='position:absolute;z-index:251675136;left:0px;margin-left:225px;
margin-top:141px;width:13px;height:17px'><img width=13 height=17
src="help/images/Morphological_Interpretations_Full_008.gif"></span><span
style='position:absolute;z-index:251672064;left:0px;margin-left:670px;
margin-top:261px;width:32px;height:9px'><img width=32 height=9
src="help/images/Morphological_Interpretations_Full_009.gif"></span><span
style='position:absolute;z-index:251671040;left:0px;margin-left:217px;
margin-top:238px;width:18px;height:28px'><img width=18 height=28
src="help/images/Morphological_Interpretations_Full_010.gif"></span><span
style='font-size:14.0pt;font-family:"Arial","sans-serif"'><img border=0
width=633 height=369 id="Group 11"
src="help/images/Morphological_Interpretations_Full_011.gif"></span></p>

<p class=MsoNormal><span style='font-size:14.0pt;font-family:"Arial","sans-serif";
color:red'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='font-size:14.0pt;
font-family:"Arial","sans-serif"'>&nbsp;</span></p>

</div>
<!-- ------------------------ -->

</body>

</html>

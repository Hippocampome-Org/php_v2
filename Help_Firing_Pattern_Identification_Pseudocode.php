<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FP Abbreviations</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-link:"Balloon Text";
	font-family:"Tahoma","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:11.0in 8.5in;
	margin:23.75pt .25in .25in 23.75pt;}
div.WordSection1
	{page:WordSection1;}
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

<p class=Default><b style='mso-bidi-font-weight:normal'><u><span
style='font-size:18.0pt;font-family:"Times New Roman","serif"'>Pseudocode for
the identification of firing pattern elements <o:p></o:p></span></u></b></p>

<p class=Default style='margin-left:.25in'><b style='mso-bidi-font-weight:normal'><span
style='font-size:14.0pt;font-family:"Times New Roman","serif"'><o:p>&nbsp;</o:p></span></b></p>

<p class=Default style='margin-left:.75in;text-indent:-.5in;mso-list:l0 level1 lfo1'><![if !supportLists]><span
style='font-size:14.0pt;mso-fareast-font-family:"Courier New"'><span
style='mso-list:Ignore'>(i)<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:14.0pt'>IF <span
style='mso-bidi-font-weight:bold'>HAS_<span class=GramE>DELAY(</span>): </span>add
&quot;</span><b style='mso-bidi-font-weight:normal'><span style='font-size:
14.0pt;color:windowtext'>D.</span></b><span style='font-size:14.0pt'>&quot; <o:p></o:p></span></p>

<p class=Default style='margin-left:.25in'><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=Default style='margin-left:.75in;text-indent:-.5in;mso-list:l0 level1 lfo1'><![if !supportLists]><span
style='font-size:14.0pt;mso-fareast-font-family:"Courier New"'><span
style='mso-list:Ignore'>(ii)<span style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:14.0pt'>IF HAS_TSTUT(): <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>If <span class=SpellE>swa</span> &gt; MIN_SWA: add &quot;</span><b
style='mso-bidi-font-weight:normal'><span style='font-size:14.0pt;color:windowtext'>TSWB.</span></b><span
style='font-size:14.0pt'>&quot; <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>Else: add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;color:windowtext'>TSTUT.</span></b><span
style='font-size:14.0pt'>&quot; <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=Default style='margin-left:.75in;text-indent:-.5in;mso-list:l0 level1 lfo1'><![if !supportLists]><span
style='font-size:14.0pt;mso-fareast-font-family:"Courier New"'><span
style='mso-list:Ignore'>(iii)<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:14.0pt'>RUN_SOLVER_STAT_TESTS()
<o:p></o:p></span></p>

<p class=Default style='margin-left:.75in'><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=Default style='margin-left:.75in;text-indent:-.5in;mso-list:l0 level1 lfo1'><![if !supportLists]><span
style='font-size:14.0pt;mso-fareast-font-family:"Courier New"'><span
style='mso-list:Ignore'>(iv)<span style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:14.0pt'>IF STEADY_STATE_FIRING: <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>IF HAS_<span class=GramE>PSTUT(</span>): <o:p></o:p></span></p>

<p class=Default style='margin-left:1.0in;text-indent:.5in'><span
style='font-size:14.0pt'>If <span class=SpellE>swa</span>&gt; MIN_SWA: add &quot;</span><b
style='mso-bidi-font-weight:normal'><span style='font-size:14.0pt;color:windowtext'>PSWB</span></b><span
style='font-size:14.0pt'>&quot; <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>ELSE: add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;color:windowtext'>PSTUT</span></b><span
style='font-size:14.0pt'>&quot; <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=Default style='margin-left:.75in;text-indent:-.5in;mso-list:l0 level1 lfo1'><![if !supportLists]><span
style='font-size:14.0pt;mso-fareast-font-family:"Courier New"'><span
style='mso-list:Ignore'>(v)<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><![endif]><span style='font-size:14.0pt'>IF HAS_SLN(): add
&quot;</span><b style='mso-bidi-font-weight:normal'><span style='font-size:
14.0pt;color:windowtext'>SLN</span></b><span style='font-size:14.0pt'>&quot;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Times New Roman","serif";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><i><span
style='font-size:14.0pt;font-family:"Times New Roman","serif";color:black'>Function
definitions: </span></i><span style='font-size:14.0pt;font-family:"Times New Roman","serif";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Courier New";color:black;mso-bidi-font-weight:bold'>HAS_<span
class=GramE>DELAY()</span> </span><span style='font-size:14.0pt;font-family:
"Courier New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-indent:
.5in;line-height:normal;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>IF <span
class=SpellE>fsl</span> &gt; DELAY_FACTOR * ISI_<span class=GramE>AVG(</span>1,2):
</span><span style='font-size:14.0pt;font-family:"Times New Roman","serif";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return TRUE <o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-indent:
.5in;line-height:normal;mso-layout-grid-align:none;text-autospace:none'><span
style='font-size:14.0pt;font-family:"Times New Roman","serif";color:black'>ELSE:
<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return FALSE <o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Courier New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Courier New";color:black;mso-bidi-font-weight:bold'>HAS_<span
class=GramE>TSTUT()</span> </span><span style='font-size:14.0pt;font-family:
"Courier New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>For ISIs i = 2, 3 and 4: </span><span style='font-size:14.0pt;
font-family:"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>IF <span style='mso-tab-count:1'> </span><span
class=SpellE>ISIi</span> &gt; ISIi-1 * TSTUT_PRE_FACTOR &amp;&amp; </span><span
style='font-size:14.0pt;font-family:"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.0in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span class=SpellE><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>ISIi</span></span><span
style='font-size:14.0pt;font-family:"Courier New";color:black'> &gt; ISIi+1 *
TSTUT_POST_FACTOR &amp;&amp; </span><span style='font-size:14.0pt;font-family:
"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.0in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span class=SpellE><span
class=GramE><span style='font-size:14.0pt;font-family:"Courier New";color:black'>Avg</span></span></span><span
class=GramE><span style='font-size:14.0pt;font-family:"Courier New";color:black'>(</span></span><span
class=SpellE><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>ISIi:n</span></span><span style='font-size:14.0pt;font-family:
"Courier New";color:black'>) &gt; <span class=SpellE>Avg</span>(ISI1:i-1) *
TSTUT_PRE_FACTOR &amp;&amp; </span><span style='font-size:14.0pt;font-family:
"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.0in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span class=GramE><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>Freq(</span></span><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>ISI1:i-1) &gt;
MIN_TSTUT_FREQ </span><span style='font-size:14.0pt;font-family:"Times New Roman","serif";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return TRUE <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>IF <span style='mso-tab-count:1'> </span><span class=SpellE>pss</span>
&gt; <span class=SpellE>ISIn</span> * TSTUT_PRE_FACTOR &amp;&amp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span class=GramE><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>Freq(</span></span><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>ISI1:n) &gt;
MIN_TSTUT_FREQ &amp;&amp;<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span class=SpellE><span
class=GramE><span style='font-size:14.0pt;font-family:"Courier New";color:black'>swa</span></span></span><span
style='font-size:14.0pt;font-family:"Courier New";color:black'> &gt; MIN_SWA<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:1.0in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return TRUE<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Courier New";color:black;mso-bidi-font-weight:bold'>RUN_SOLVER_STAT_<span
class=GramE>TESTS(<span style='mso-bidi-font-weight:normal'>)</span></span></span><span
style='font-size:14.0pt;font-family:"Courier New";color:black'> </span><span
style='font-size:14.0pt;font-family:"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>Fit ISIs against their latencies using 1 parameter (Y=c0), 2
parameter (Y=m1X+c1), 3 parameter (Y=m2X+c2, Y=c3) and 4 parameter (Y=m4X+c4, Y=m5X+c5)
piecewise linear fits<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>IF NOT significant improvement from 1 <span class=SpellE>parm</span>
to 2 <span class=SpellE>parm</span> linear fit: <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;font-family:"Courier New"'>NASP/STEADY_STATE</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; </span><span
style='font-size:14.0pt;font-family:"Times New Roman","serif";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>IF NOT significant improvement from 2 <span class=SpellE>parm</span>
to 3 <span class=SpellE>parm</span> linear fit: <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>IF slope &gt; SLOPE_THRESHOLD: <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.0in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;font-family:"Courier New"'>ASP.</span></b><span
style='font-size:14.0pt;font-family:"Courier New"'>&quot; <span
style='color:black'><o:p></o:p></span></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>ELSE: <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.0in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;font-family:"Courier New"'>NASP</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>IF NOT significant improvement from 3 <span class=SpellE>parm</span>
to 4 <span class=SpellE>parm</span> linear fit: <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;font-family:"Courier New"'>ASP.</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Add &quot;</span><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;font-family:"Courier New"'>NASP</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;
mso-layout-grid-align:none;text-autospace:none'><span style='font-size:14.0pt;
font-family:"Courier New";color:black'>Return <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>Add &quot;</span><b style='mso-bidi-font-weight:normal'><span
style='font-size:14.0pt;font-family:"Courier New"'>ASP.</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>Add &quot;</span><b style='mso-bidi-font-weight:normal'><span
style='font-size:14.0pt;font-family:"Courier New"'>ASP.</span></b><span
style='font-size:14.0pt;font-family:"Courier New";color:black'>&quot; <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:normal;mso-layout-grid-align:
none;text-autospace:none'><span style='font-size:14.0pt;font-family:"Courier New";
color:black'>Return <o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;mso-layout-grid-align:none;text-autospace:none'><span style='font-size:
14.0pt;font-family:"Courier New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=Default><span style='font-size:14.0pt;mso-bidi-font-weight:bold'>HAS_<span
class=GramE>PSTUT()</span> </span><span style='font-size:14.0pt'><o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span class=SpellE><span
style='font-size:14.0pt'>ISIi</span></span><span style='font-size:14.0pt'> =
maximum of ISIs <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span style='font-size:14.0pt'>factor_1
= <span class=SpellE>ISIi</span>/ISIi-1 <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span style='font-size:14.0pt'>factor_2
= <span class=SpellE>ISIi</span>/ISIi+1 <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span style='font-size:14.0pt'>IF
factor_1 + factor_2 &gt; PSTUT_FACTOR <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>Return TRUE <o:p></o:p></span></p>

<p class=Default><span style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=Default><span style='font-size:14.0pt;mso-bidi-font-weight:bold'>HAS_<span
class=GramE>SLN()</span></span><span style='font-size:14.0pt'><o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span style='font-size:14.0pt'>IF <span
style='mso-tab-count:1'> </span><span class=SpellE>pss</span> &gt; SLN_FACTOR *
ISI_<span class=GramE>AVG(</span>n,n-1) &amp;&amp; <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span class=SpellE><span
class=GramE><span style='font-size:14.0pt'>pss</span></span></span><span
style='font-size:14.0pt'> &gt; SLN_FACTOR * ISI_MAX: <o:p></o:p></span></p>

<p class=Default style='margin-left:1.0in;text-indent:.5in'><span
style='font-size:14.0pt'>Return TRUE <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in'><span style='font-size:14.0pt'>ELSE: <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'>Return FALSE <o:p></o:p></span></p>

<p class=Default style='margin-left:.5in;text-indent:.5in'><span
style='font-size:14.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
style='font-size:14.0pt;line-height:107%;font-family:"Times New Roman","serif"'>Abbreviations:</span></i><span
style='font-size:14.0pt;line-height:107%;font-family:"Times New Roman","serif"'>
<i style='mso-bidi-font-style:normal'>ISI</i> - inter spike interval, <span
class=SpellE><i style='mso-bidi-font-style:normal'>fsl</i></span> - first spike
latency, <span class=SpellE><i style='mso-bidi-font-style:normal'>pss</i></span>
- post spike silence, <span class=SpellE><i style='mso-bidi-font-style:normal'>swa</i></span>
- slow after hyperpolarizing wave amplitude.<o:p></o:p></span></p>

<p class=MsoNormal><i style='mso-bidi-font-style:normal'><span
style='font-size:14.0pt;line-height:107%;font-family:"Times New Roman","serif"'>Constants:
</span></i><span style='font-size:14.0pt;line-height:107%;font-family:"Courier New"'>MIN_SWA
= 5mV, <span style='color:black'>DELAY_FACTOR = 2, </span>SLN_FACTOR = 2, <span
style='color:black'>TSTUT_PRE_FACTOR=2.5, TSTUT_POST_FACTOR=1.5,</span>
PSTUT_FACTOR = 5, <span style='color:black'>SLOPE_THRESHOLD=0.003,
MIN_TSTUT_FREQ = 25Hz</span><o:p></o:p></span></p>

<p class=MsoNormal><span style='font-size:14.0pt;line-height:107%'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>

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

<p class=MsoNormal style='margin-left:.5in'><b style='mso-bidi-font-weight:
normal'><u><span style='font-size:16.0pt;line-height:106%;color:#365F91;
mso-themecolor:accent1;mso-themeshade:191'>Model definition page:<o:p></o:p></span></u></b></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>Spike
Patterns are simulated using a two-dimensional system <span style='color:black'>(Izhikevich,
2003 &amp; 2007) as follows:</span><o:p></o:p></span></p>

<p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:
.5in'><!--[if gte msEquation 12]><m:oMathPara><m:oMath><i style='mso-bidi-font-style:
  normal'><span lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r>C</m:r></span></i><i style='mso-bidi-font-style:
  normal'><span style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>&#8729;</m:r></span></i><m:f><m:fPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:fPr><m:num><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>dV</m:r></span></i></m:num><m:den><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>dt</m:r></span></i></m:den></m:f><span
  lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>=</m:r><m:r><i
   style='mso-bidi-font-style:normal'>k</i></m:r></span><i style='mso-bidi-font-style:
  normal'><span style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>&#8729;</m:r></span></i><m:d><m:dPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i><span
    lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>-</m:r></span><m:sSub><m:sSubPr><span
      style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
      14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
      mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
      mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
      style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
      mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
      style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
      mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>r</m:r></span></i></m:sub></m:sSub></m:e></m:d><i
  style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
  "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
  color:black'><m:r>&#8729;</m:r></span></i><span lang="" style='font-size:
  14.0pt;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
  mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>(</m:r><m:r><i style='mso-bidi-font-style:
   normal'>V</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>-</m:r></span><m:sSub><m:sSubPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>t</m:r></span></i></m:sub></m:sSub><span
  lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>)-</m:r><m:r><i
   style='mso-bidi-font-style:normal'>U</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>+</m:r><m:r><i style='mso-bidi-font-style:normal'>I</i></m:r></span></m:oMath></m:oMathPara><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shapetype id="_x0000_t75"
 coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe"
 filled="f" stroked="f">
 <v:stroke joinstyle="miter"/>
 <v:formulas>
  <v:f eqn="if lineDrawn pixelLineWidth 0"/>
  <v:f eqn="sum @0 1 0"/>
  <v:f eqn="sum 0 0 @1"/>
  <v:f eqn="prod @2 1 2"/>
  <v:f eqn="prod @3 21600 pixelWidth"/>
  <v:f eqn="prod @3 21600 pixelHeight"/>
  <v:f eqn="sum @0 0 1"/>
  <v:f eqn="prod @6 1 2"/>
  <v:f eqn="prod @7 21600 pixelWidth"/>
  <v:f eqn="sum @8 21600 0"/>
  <v:f eqn="prod @7 21600 pixelHeight"/>
  <v:f eqn="sum @10 21600 0"/>
 </v:formulas>
 <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
 <o:lock v:ext="edit" aspectratio="t"/>
</v:shapetype><v:shape id="_x0000_i1025" type="#_x0000_t75" style='width:229.8pt;
 height:45.6pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image001.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=383 height=76
src="images/Help_Model_Definition_files/image023.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;
color:black;mso-ansi-language:#007F'><o:p></o:p></span></p>

<p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;
margin-left:.5in'><!--[if gte msEquation 12]><m:oMathPara><m:oMath><m:f><m:fPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:fPr><m:num><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>dU</m:r></span></i></m:num><m:den><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>dt</m:r></span></i></m:den></m:f><span
  style='font-size:14.0pt;font-family:"Cambria Math","serif";mso-bidi-font-family:
  Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>=</m:r><m:r><i style='mso-bidi-font-style:normal'>a</i></m:r><m:r><i
   style='mso-bidi-font-style:normal'>&#8729;</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>{</m:r><m:r><i style='mso-bidi-font-style:normal'>b</i></m:r><m:r><i
   style='mso-bidi-font-style:normal'>&#8729;</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>(</m:r><m:r><i style='mso-bidi-font-style:normal'>V</i></m:r><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>-</m:r></span><m:sSub><m:sSubPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black'><m:r>V</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black'><m:r>r</m:r></span></i></m:sub></m:sSub><span
  style='font-size:14.0pt;font-family:"Cambria Math","serif";mso-bidi-font-family:
  Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>)-</m:r><m:r><i style='mso-bidi-font-style:normal'>U</i></m:r><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>}</m:r></span></m:oMath></m:oMathPara><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025"
 type="#_x0000_t75" style='width:158.4pt;height:45.6pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image003.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=264 height=76
src="images/Help_Model_Definition_files/image024.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;
color:black'><o:p></o:p></span></p>

<p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:
.5in'><!--[if gte msEquation 12]><m:oMathPara><m:oMath><i style='mso-bidi-font-style:
  normal'><span lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r>if</m:r></span></i><span lang=""
  style='font-size:14.0pt;font-family:"Cambria Math","serif";mso-bidi-font-family:
  Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>&nbsp;</m:r><m:r><i
   style='mso-bidi-font-style:normal'>V</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>=&nbsp;</m:r></span><m:sSub><m:sSubPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>peak</m:r></span></i></m:sub></m:sSub><span
  lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>&nbsp;</m:r><m:r><i
   style='mso-bidi-font-style:normal'>t</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>h</m:r><m:r><i style='mso-bidi-font-style:normal'>en</i></m:r><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>&nbsp;</m:r><m:r><i
   style='mso-bidi-font-style:normal'>V</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>=</m:r></span><m:sSub><m:sSubPr><span style='font-size:
    14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;font-family:
    "Cambria Math","serif";mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:
    "Cambria Math";mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
    color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
    minor-latin;color:black;mso-ansi-language:#007F'><m:r>min</m:r></span></i></m:sub></m:sSub><span
  lang="" style='font-size:14.0pt;font-family:"Cambria Math","serif";
  mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
  mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>,&nbsp;</m:r><m:r><i
   style='mso-bidi-font-style:normal'>U</i></m:r><m:r><m:rPr><m:scr m:val="roman"/><m:sty
     m:val="p"/></m:rPr>=</m:r><m:r><i style='mso-bidi-font-style:normal'>U</i></m:r><m:r><m:rPr><m:scr
     m:val="roman"/><m:sty m:val="p"/></m:rPr>+</m:r><m:r><i style='mso-bidi-font-style:
   normal'>d</i></m:r></span></m:oMath></m:oMathPara><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025"
 type="#_x0000_t75" style='width:238.2pt;height:31.8pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image005.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=397 height=53
src="images/Help_Model_Definition_files/image025.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;
color:black;mso-ansi-language:#007F'><o:p></o:p></span></p>

<p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:
.5in'><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>r</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r> </m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:17.0pt;mso-text-raise:
-17.0pt;mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:
AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025" type="#_x0000_t75"
 style='width:12.6pt;height:28.2pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image007.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=21 height=47
src="images/Help_Model_Definition_files/image026.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:black;
mso-ansi-language:#007F'>- resting voltage, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>t</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r> </m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:17.0pt;mso-text-raise:
-17.0pt;mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:
AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025" type="#_x0000_t75"
 style='width:13.2pt;height:28.2pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image009.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=22 height=47
src="images/Help_Model_Definition_files/image027.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:black'>-
threshold voltage, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>peak</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:18.0pt;mso-text-raise:
-18.0pt;mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:
AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025" type="#_x0000_t75"
 style='width:27pt;height:29.4pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image011.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=45 height=49
src="images/Help_Model_Definition_files/image028.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:black;
mso-ansi-language:#007F'><span style='mso-spacerun:yes'></span>- s</span><span
style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:black'>pike
cutoff value, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F'><m:r>min</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r> </m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:17.0pt;mso-text-raise:
-17.0pt;mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:
AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025" type="#_x0000_t75"
 style='width:25.8pt;height:28.2pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image013.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=43 height=47
src="images/Help_Model_Definition_files/image029.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:black'>-
post-spike reset value for the voltage, C - cell capacitance<o:p></o:p></span></p>

<p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:
.5in'><span style='font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;
color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><span
style='font-size:12.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black'>Multi-compartment currents
are calculated as follows:<o:p></o:p></span></p>

<p class=MsoListParagraph style='margin-bottom:0in;margin-bottom:.0001pt;
mso-add-space:auto;line-height:16.55pt'><span style='font-size:12.0pt;
mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><!--[if gte msEquation 12]><m:oMathPara><m:oMath><m:sSub><m:sSubPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>I</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>soma</m:r></span></i></m:sub></m:sSub><i
  style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
  "Cambria Math","serif";mso-fareast-font-family:Calibri;mso-bidi-font-family:
  Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
  mso-font-kerning:12.0pt'><m:r>=</m:r><m:r>G</m:r><m:r> . </m:r><m:r>P</m:r><m:r>
   . </m:r></span></i><m:d><m:dPr><span style='font-size:14.0pt;mso-ansi-font-size:
    14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
    mso-ascii-font-family:"Cambria Math";mso-fareast-font-family:Calibri;
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
    mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><m:sSub><m:sSubPr><span
      style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
      14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
      mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>V</m:r></span></i></m:e><m:sub><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>soma</m:r></span></i></m:sub></m:sSub><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>-</m:r></span></i><m:sSub><m:sSubPr><span
      style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
      14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
      mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>V</m:r></span></i></m:e><m:sub><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>dend</m:r></span></i></m:sub></m:sSub></m:e></m:d></m:oMath></m:oMathPara><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025"
 type="#_x0000_t75" style='width:178.2pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image015.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=297 height=30
src="images/Help_Model_Definition_files/image030.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt;mso-bidi-font-style:italic'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><!--[if gte msEquation 12]><m:oMathPara><m:oMath><m:sSub><m:sSubPr><span
    style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
    mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>I</m:r></span></i></m:e><m:sub><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>dend</m:r></span></i></m:sub></m:sSub><i
  style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
  "Cambria Math","serif";mso-fareast-font-family:Calibri;mso-bidi-font-family:
  Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
  mso-font-kerning:12.0pt'><m:r>=</m:r><m:r>G</m:r><m:r> . (1-</m:r><m:r>P</m:r><m:r>)
   . </m:r></span></i><m:d><m:dPr><span style='font-size:14.0pt;mso-ansi-font-size:
    14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
    mso-ascii-font-family:"Cambria Math";mso-fareast-font-family:Calibri;
    mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
    mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
    mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><m:sSub><m:sSubPr><span
      style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
      14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
      mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>V</m:r></span></i></m:e><m:sub><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>dend</m:r></span></i></m:sub></m:sSub><i
    style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
    font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
    mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
    mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>-</m:r></span></i><m:sSub><m:sSubPr><span
      style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
      14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
      mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>V</m:r></span></i></m:e><m:sub><i
      style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
      font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
      mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
      mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>soma</m:r></span></i></m:sub></m:sSub></m:e></m:d></m:oMath></m:oMathPara><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape id="_x0000_i1025"
 type="#_x0000_t75" style='width:213pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image017.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=355 height=30
src="images/Help_Model_Definition_files/image031.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt;mso-bidi-font-style:italic'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><span
style='font-size:14.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt;mso-bidi-font-style:italic'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;font-family:
 "Cambria Math","serif";mso-fareast-font-family:Calibri;mso-bidi-font-family:
 Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
 mso-font-kerning:12.0pt'><m:r><span style='mso-spacerun:yes'> </span></m:r><m:r>G</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:10.8pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image019.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=18 height=25
src="images/Help_Model_Definition_files/image032.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black'><span
style='mso-spacerun:yes'></span>- coupling strength, </span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;font-family:
 "Cambria Math","serif";mso-fareast-font-family:Calibri;mso-bidi-font-family:
 Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;
 mso-font-kerning:12.0pt'><m:r>P</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:7.8pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Definition_files/image021.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=13 height=25
src="images/Help_Model_Definition_files/image033.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin;color:black'><span
style='mso-spacerun:yes'></span>- degree of coupling asymmetry.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><span
style='font-size:12.0pt;font-family:"Cambria","serif";mso-ascii-theme-font:
major-latin;mso-fareast-font-family:"Times New Roman";mso-hansi-theme-font:
major-latin;mso-bidi-font-family:Cambria;mso-bidi-theme-font:major-latin;
color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;line-height:16.55pt'><i
style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;font-family:
"Cambria","serif";mso-ascii-theme-font:major-latin;mso-fareast-font-family:
"Times New Roman";mso-hansi-theme-font:major-latin;mso-bidi-font-family:Cambria;
mso-bidi-theme-font:major-latin;color:black'>References:<o:p></o:p></span></i></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:.5in;margin-bottom:.0001pt;mso-layout-grid-align:none;text-autospace:
none'><span style='font-size:10.0pt;line-height:107%;font-family:"Cambria","serif";
mso-ascii-theme-font:major-latin;mso-hansi-theme-font:major-latin;mso-bidi-font-family:
Cambria;mso-bidi-theme-font:major-latin;mso-bidi-font-weight:bold;mso-no-proof:
yes'>Izhikevich EM</span><span style='font-size:10.0pt;line-height:107%;
font-family:"Cambria","serif";mso-ascii-theme-font:major-latin;mso-hansi-theme-font:
major-latin;mso-bidi-font-family:Cambria;mso-bidi-theme-font:major-latin;
mso-no-proof:yes'>. (2003). Simple model of spiking neurons. <i>IEEE
Transactions on Neural Networks.</i> 14: 1569-72.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:10.0pt;
line-height:107%;font-family:"Cambria","serif";mso-ascii-theme-font:major-latin;
mso-hansi-theme-font:major-latin;mso-bidi-font-family:Cambria;mso-bidi-theme-font:
major-latin;mso-bidi-font-weight:bold;mso-no-proof:yes'>Izhikevich EM</span><span
style='font-size:10.0pt;line-height:107%;font-family:"Cambria","serif";
mso-ascii-theme-font:major-latin;mso-hansi-theme-font:major-latin;mso-bidi-font-family:
Cambria;mso-bidi-theme-font:major-latin'>. (2007). <i>Dynamical systems in
neuroscience</i>. MIT press<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><o:p>&nbsp;</o:p></p>

</div>

</body>

</html>

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
normal'><u><span style='font-size:16.0pt;line-height:107%;color:#365F91;
mso-themecolor:accent1;mso-themeshade:191'>Model fitting page:<o:p></o:p></span></u></b></p>

<p class=MsoListParagraph style='margin-left:.5in'><span style='font-size:12.0pt;line-height:107%;
mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>Nine model
parameters are optimized to reproduce a set (</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin'><m:r>S</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shapetype
 id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
 path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
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
</v:shapetype><v:shape id="_x0000_i1025" type="#_x0000_t75" style='width:6.6pt;
 height:15pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image001.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=11 height=25
src="images/Help_Model_Fitting_files/image002.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>) of following features (</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:7.2pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image003.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=12 height=25
src="images/Help_Model_Fitting_files/image004.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>) of spike patterns:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- <span class=GramE>first-</span>spike latency
(<span class=SpellE><i style='mso-bidi-font-style:normal'>fsl</i></span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- <span class=GramE>post-spike</span> silence
(<span class=SpellE><i style='mso-bidi-font-style:normal'>pss</i></span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- spike frequency adaptation (<span
class=SpellE><i style='mso-bidi-font-style:normal'>sfa</i></span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- <span class=GramE>number</span> of
inter-spike intervals (<span class=SpellE>n_ISIs</span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- burst width (<span class=SpellE><span
class=GramE><i style='mso-bidi-font-style:normal'>bw</i></span></span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- <span class=GramE>post-burst</span> interval
(<span class=SpellE><i style='mso-bidi-font-style:normal'>pbi</i></span>)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:0in;
margin-left:1.25in;margin-bottom:.0001pt;tab-stops:85.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- number of bursts (<span class=SpellE><i
style='mso-bidi-font-style:normal'>n_bursts</i></span>)<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;mso-add-space:auto'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:.5in'><span style='font-size:12.0pt;line-height:
107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>Pattern error
in the model is calculated as follows:<o:p></o:p></span></p>

<p class=MsoNoSpacing style='margin-left:.5in;text-indent:.5in'><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
 "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>pattern</m:r><m:r>_</m:r><m:r>error</m:r><m:r>=</m:r></span></i><m:nary><m:naryPr><m:chr
    m:val="&#8721;"/><m:limLoc m:val="undOvr"/><m:supHide m:val="on"/><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:naryPr><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
   "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin'><m:r>f</m:r><m:r>&#8712;</m:r><m:r>S</m:r></span></i></m:sub><m:sup></m:sup><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;font-style:italic;mso-bidi-font-style:
     normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
     normal'><span style='font-size:14.0pt;font-family:"Cambria Math","serif";
     mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>W</m:r></span></i></m:e><m:sub><i
     style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
   "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin'><m:r>×</m:r></span></i><m:func><m:funcPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;font-style:italic;mso-bidi-font-style:
     normal'><m:ctrlPr></m:ctrlPr></span></m:funcPr><m:fName><span
     style='font-size:14.0pt;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin'><m:r><m:rPr><m:scr m:val="roman"/><m:sty
        m:val="p"/></m:rPr>log</m:r></span></m:fName><m:e><i style='mso-bidi-font-style:
     normal'><span style='font-size:14.0pt;font-family:"Cambria Math","serif";
     mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r> </m:r></span></i><m:d><m:dPr><span
       style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
       14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
       mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
       mso-bidi-theme-font:minor-latin;font-style:italic;mso-bidi-font-style:
       normal'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><i style='mso-bidi-font-style:
       normal'><span style='font-size:14.0pt;font-family:"Cambria Math","serif";
       mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>1+</m:r></span></i><m:d><m:dPr><m:begChr
          m:val="|"/><m:endChr m:val="|"/><span style='font-size:14.0pt;
         mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
         mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
         mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
         font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><m:sSub><m:sSubPr><span
           style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
           14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:
           "Cambria Math";mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:
           Calibri;mso-bidi-theme-font:minor-latin;font-style:italic;
           mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
           style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
           font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
           mso-bidi-theme-font:minor-latin'><m:r>exp</m:r></span></i></m:e><m:sub><i
           style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
           font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
           mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub><i
         style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
         font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
         mso-bidi-theme-font:minor-latin'><m:r>-</m:r></span></i><m:sSub><m:sSubPr><span
           style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:
           14.0pt;font-family:"Cambria Math","serif";mso-ascii-font-family:
           "Cambria Math";mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:
           Calibri;mso-bidi-theme-font:minor-latin;font-style:italic;
           mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
           style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
           font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
           mso-bidi-theme-font:minor-latin'><m:r>model</m:r></span></i></m:e><m:sub><i
           style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;
           font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
           mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub></m:e></m:d></m:e></m:d></m:e></m:func></m:e></m:nary><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;font-family:
 "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>
  </m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:5.5pt;mso-text-raise:-5.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:333pt;height:19.2pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image005.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=555 height=32
src="images/Help_Model_Fitting_files/image006.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'>,
<o:p></o:p></span></p>

<p class=MsoNoSpacing style='margin-left:.5in'><span style='mso-bidi-font-size:
12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:minor-fareast;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing style='margin-left:.5in'><span class=GramE><span
style='mso-bidi-font-size:12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'>where</span></span><span
style='mso-bidi-font-size:12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'>
</span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;font-style:
   italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='mso-bidi-font-size:12.0pt;
   font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin'><m:r>exp</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
   normal'><span style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:24.6pt;height:15.6pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image007.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=41 height=26
src="images/Help_Model_Fitting_files/image008.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='mso-bidi-font-size:12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><span
style='mso-spacerun:yes'></span> and </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;font-style:
   italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='mso-bidi-font-size:12.0pt;
   font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin'><m:r>model</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
   normal'><span style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:38.4pt;height:15.6pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image009.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=64 height=26
src="images/Help_Model_Fitting_files/image010.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='mso-bidi-font-size:12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><span
style='mso-spacerun:yes'></span> are experimentally observed and simulated
features respectively. </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;font-style:
   italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='mso-bidi-font-size:12.0pt;
   font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin'><m:r>W</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
   normal'><span style='mso-bidi-font-size:12.0pt;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><m:r>f</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:15pt;height:15.6pt'>
 <v:imagedata src="images/Help_Model_Fitting_files/image011.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=25 height=26
src="images/Help_Model_Fitting_files/image012.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='mso-bidi-font-size:12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-fareast-font-family:"Times New Roman";mso-fareast-theme-font:
minor-fareast;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><span
style='mso-spacerun:yes'></span><span class=GramE> is</span> a feature-specific
weight determined by comparing the spike pattern classes of experimental and
candidate model traces during the optimization. <o:p></o:p></span></p>

<p class=MsoNoSpacing style='margin-left:.5in'><span style='mso-bidi-font-size:
12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing style='margin-left:.5in'><span style='mso-bidi-font-size:
12.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:minor-latin;
mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'>For more
details and discussion of the error function, please see the following article:
</span><span style='font-size:10.0pt;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
minor-latin;color:#222222'>Venkadesh S, Komendantov AO, <span class=SpellE>Listopad</span>
S, Scott EO, De Jong K, <span class=SpellE>Krichmar</span> JL, Ascoli GA.
(2018). <span class=GramE>Evolving Simple Models of Diverse Intrinsic Dynamics
in Hippocampal Neuron Types.</span> <span class=GramE><i style='mso-bidi-font-style:
normal'>Frontiers in neuroinformatics.</i></span><i style='mso-bidi-font-style:
normal'> </i></span><a href="https://doi.org/10.3389/fninf.2018.00008"><span
style='font-size:10.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'>https://doi.org/10.3389/fninf.2018.00008</span></a><span
style='font-size:10.0pt;font-family:"Calibri","sans-serif";mso-ascii-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>For
details of firing pattern classification, please see the following article: </span><span
style='font-size:10.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;mso-no-proof:yes'>Komendantov AO, Venkadesh S,
Rees CL, Wheeler DW, Hamilton DJ, and Ascoli GA. (2018). Quantitative firing
pattern phenotyping of hippocampal neuron types. <i style='mso-bidi-font-style:
normal'>bioRxiv</i> doi: 10.1101/212084.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:10.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;
mso-no-proof:yes'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>Optimization
code is available here:</span> <a
href="https://github.com/Hippocampome-Org/Time">https://github.com/Hippocampome-Org/Time</a>
</p>

<p class=MsoNormal style='margin-left:.5in'><o:p>&nbsp;</o:p></p>

</div>

</body>

</html>

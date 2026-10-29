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
mso-themecolor:accent1;mso-themeshade:191'>Model simulation using CARLsim:<o:p></o:p></span></u></b></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;mso-add-space:auto;
text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>1.<span
style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:12.0pt;line-height:107%'>See CARLsim documentation at </span><a
href="http://uci-carl.github.io/CARLsim4/"><span style='font-size:12.0pt;
line-height:107%'>http://uci-carl.github.io/CARLsim4/</span></a><span
style='font-size:12.0pt;line-height:107%'> for library setup<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:.75in;mso-add-space:
auto;text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>2.<span
style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:12.0pt;line-height:107%'>Simulation scripts and <span
class=SpellE>Makefile</span> are available at <a
href="https://github.com/Hippocampome-Org/Time/">https://github.com/Hippocampome-Org/Time/</a>
(select tuneIzh9p)<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;mso-add-space:auto;
text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>3.<span
style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:12.0pt;line-height:107%'>Download CARLsim parameter file (<span
class=SpellE><i style='mso-bidi-font-style:normal'>param_file</i></span>) for a
neuron type/subtype from the neuron page <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%'>- Parameter file structure: </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>k</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
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
</v:shapetype><v:shape id="_x0000_i1025" type="#_x0000_t75" style='width:13.8pt;
 height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image001.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=23 height=30
src="images/Help_Model_Simulation_files/image002.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>k</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black'><m:r>,...,</m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>a</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:51pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image003.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=85 height=30
src="images/Help_Model_Simulation_files/image004.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black'>,</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black'><m:r> </m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>a</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black'><m:r>1</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:16.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image005.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=28 height=30
src="images/Help_Model_Simulation_files/image006.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black'>,... </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>b</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:13.2pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image007.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=22 height=30
src="images/Help_Model_Simulation_files/image008.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black'>,</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black'><m:r> </m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black'><m:r>b</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black'><m:r>1</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:16.2pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image009.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=27 height=30
src="images/Help_Model_Simulation_files/image010.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black'>,... </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>d</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:14.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image011.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=24 height=30
src="images/Help_Model_Simulation_files/image012.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>,</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r> </m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>d</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:33pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image013.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=55 height=30
src="images/Help_Model_Simulation_files/image014.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'><span
style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>C</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:13.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image015.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=23 height=30
src="images/Help_Model_Simulation_files/image016.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>C</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:29.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image017.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=49 height=30
src="images/Help_Model_Simulation_files/image018.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:12.0pt;line-height:107%'><span
style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>V</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>r</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:11.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image019.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=19 height=30
src="images/Help_Model_Simulation_files/image020.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>t</m:r></span></i></m:sub></m:sSub></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:7.0pt;mso-text-raise:-7.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:18.6pt;height:19.8pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image021.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=31 height=33
src="images/Help_Model_Simulation_files/image022.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>,</span><!--[if gte msEquation 12]><m:oMath><span
 lang="" style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>
  </m:r></span><m:sSub><m:sSubPr><span style='font-size:14.0pt;mso-ansi-font-size:
   14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F;font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>t</m:r></span></i></m:sub></m:sSub><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:7.0pt;mso-text-raise:-7.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:37.2pt;height:19.8pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image023.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=62 height=33
src="images/Help_Model_Simulation_files/image024.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'><span
style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>min</m:r></span></i></m:sub></m:sSub></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:7.0pt;mso-text-raise:-7.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:33.6pt;height:19.8pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image025.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=56 height=33
src="images/Help_Model_Simulation_files/image026.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>,</span><!--[if gte msEquation 12]><m:oMath><span
 lang="" style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>
  </m:r></span><m:sSub><m:sSubPr><span style='font-size:14.0pt;mso-ansi-font-size:
   14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F;font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>min</m:r></span></i></m:sub></m:sSub><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:7.0pt;mso-text-raise:-7.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:51.6pt;height:19.8pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image027.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=86 height=33
src="images/Help_Model_Simulation_files/image028.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'><span
style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F;
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>peak</m:r></span></i></m:sub></m:sSub></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:8.5pt;mso-text-raise:-8.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:38.4pt;height:21.6pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image029.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=64 height=36
src="images/Help_Model_Simulation_files/image030.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>,</span><!--[if gte msEquation 12]><m:oMath><span
 lang="" style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-ansi-language:#007F'><m:r><m:rPr><m:scr m:val="roman"/><m:sty m:val="p"/></m:rPr>
  </m:r></span><m:sSub><m:sSubPr><span style='font-size:14.0pt;mso-ansi-font-size:
   14.0pt;mso-bidi-font-size:14.0pt;font-family:"Cambria Math","serif";
   mso-ascii-font-family:"Cambria Math";mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-ansi-language:#007F;font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><m:sSub><m:sSubPr><span
     style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
     font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
     mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
     mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
     style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
     line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
     Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:
     #007F'><m:r>V</m:r></span></i></m:e><m:sub><i style='mso-bidi-font-style:
     normal'><span lang="" style='font-size:14.0pt;line-height:107%;font-family:
     "Cambria Math","serif";mso-bidi-font-family:Calibri;mso-bidi-theme-font:
     minor-latin;color:black;mso-ansi-language:#007F'><m:r>peak</m:r></span></i></m:sub></m:sSub><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
 line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:Calibri;
 mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:8.5pt;mso-text-raise:-8.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:56.4pt;height:21.6pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image031.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=94 height=36
src="images/Help_Model_Simulation_files/image032.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'><span
style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt;mso-bidi-font-weight:bold;
   font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>G</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:15pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image033.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=25 height=30
src="images/Help_Model_Simulation_files/image034.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt;mso-bidi-font-weight:bold;mso-bidi-font-style:italic'>,</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r> </m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt;mso-bidi-font-weight:bold;
   font-style:italic'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>G</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>1</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:17.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image035.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=29 height=30
src="images/Help_Model_Simulation_files/image036.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt;mso-bidi-font-weight:bold;mso-bidi-font-style:italic'>,...
</span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-fareast-font-family:Calibri;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin;color:black;mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>P</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>0</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:13.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image037.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=23 height=30
src="images/Help_Model_Simulation_files/image038.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt'>,</span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r> </m:r></span></i><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-fareast-font-family:Calibri;mso-hansi-font-family:"Cambria Math";
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt;font-style:italic;mso-bidi-font-style:
   normal'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i style='mso-bidi-font-style:
   normal'><span style='font-size:14.0pt;line-height:107%;font-family:"Cambria Math","serif";
   mso-fareast-font-family:Calibri;mso-bidi-font-family:Calibri;mso-bidi-theme-font:
   minor-latin;color:black;mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>P</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
   mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
   mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>1</m:r></span></i></m:sub></m:sSub><i
 style='mso-bidi-font-style:normal'><span style='font-size:14.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-fareast-font-family:Calibri;
 mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;
 mso-themecolor:text1;mso-font-kerning:12.0pt'><m:r>,...</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:31.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image039.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=53 height=30
src="images/Help_Model_Simulation_files/image040.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-themecolor:text1;
mso-font-kerning:12.0pt'><span style='mso-spacerun:yes'></span></span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>I</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:10.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image041.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=18 height=30
src="images/Help_Model_Simulation_files/image042.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>I</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>2</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:10.8pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image043.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=18 height=30
src="images/Help_Model_Simulation_files/image044.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, ..., </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>I</m:r><m:r>_</m:r><m:r>dur</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>1</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:38.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image045.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=64 height=30
src="images/Help_Model_Simulation_files/image046.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>, </span><!--[if gte msEquation 12]><m:oMath><m:sSub><m:sSubPr><span
   style='font-size:14.0pt;mso-ansi-font-size:14.0pt;mso-bidi-font-size:14.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:Calibri;
   mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:ctrlPr></m:ctrlPr></span></m:sSubPr><m:e><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>I</m:r><m:r>_</m:r><m:r>dur</m:r></span></i></m:e><m:sub><i
   style='mso-bidi-font-style:normal'><span lang="" style='font-size:14.0pt;
   line-height:107%;font-family:"Cambria Math","serif";mso-bidi-font-family:
   Calibri;mso-bidi-theme-font:minor-latin;color:black;mso-ansi-language:#007F'><m:r>2</m:r></span></i></m:sub></m:sSub></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.5pt;mso-text-raise:-4.5pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:38.4pt;height:18pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image047.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=64 height=30
src="images/Help_Model_Simulation_files/image048.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
lang="" style='font-size:14.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;color:black;mso-ansi-language:#007F'>,...</span><i
style='mso-bidi-font-style:normal'><span lang="" style='mso-no-proof:yes'> </span><span
style='mso-no-proof:yes'><o:p></o:p></span></i></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%'>- Every file has a single compartment
model and if the morphology warrants it, a multi-compartment model (Venkadesh
et al., 2018)<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-left:.75in;mso-add-space:auto;
text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>4.<span
style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:12.0pt;line-height:107%'>Choose the appropriate wrapper script
for a compartment layout and run a CARLsim <span class=SpellE><i
style='mso-bidi-font-style:normal'>param_file</i></span> as follows:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle align=center style='text-align:center'><span
style='font-size:12.0pt;line-height:107%'>Single-compartment model:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle align=center style='text-align:center'><span
class=SpellE><span class=GramE><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:107%;font-family:"Courier New"'>sed</span></b></span></span><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'> -n 6p &lt;</span></b><span class=SpellE><i
style='mso-bidi-font-style:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'>param_file_name</span></i></span><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'>&gt; | ./carlsim_tuneIzh9p_1c_wrapper<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle align=center style='text-align:center'><span
style='font-size:12.0pt;line-height:107%'>Multi-compartment model:<o:p></o:p></span></p>

<p class=MsoListParagraphCxSpMiddle align=center style='text-align:center'><span
class=SpellE><span class=GramE><b style='mso-bidi-font-weight:normal'><span
style='font-size:10.0pt;line-height:107%;font-family:"Courier New"'>sed</span></b></span></span><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'> -n 7p &lt;</span></b><span class=SpellE><i
style='mso-bidi-font-style:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'>param_file_name</span></i></span><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'>&gt; | ./carlsim_tuneIzh9p_&lt;</span></b><span
class=SpellE><i style='mso-bidi-font-style:normal'><span style='font-size:10.0pt;
line-height:107%;font-family:"Courier New"'>param_file_suffix</span></i></span><b
style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;line-height:
107%;font-family:"Courier New"'>&gt;_wrapper<o:p></o:p></span></b></p>

<p class=MsoListParagraphCxSpMiddle align=center style='text-align:center'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><o:p>&nbsp;</o:p></span></p>

<p class=MsoListParagraphCxSpLast style='margin-left:.75in;mso-add-space:auto;
text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>5.<span style='font:7.0pt "Times New Roman"'>
</span></span></span><![endif]><span style='font-size:12.0pt;line-height:107%;
mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>F</span><span
style='font-size:12.0pt;line-height:107%'>ollowing output files are generated
in </span><span style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>/results/<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%'>- One phenotype file (as a JSON
object) that includes a list of spike times for every </span><span
style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>I/<span
class=SpellE>I_dur</span></span><span style='font-size:12.0pt;line-height:107%'>
</span><span style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>(<span
class=SpellE>soma_I_scenario</span>)</span><span style='font-size:12.0pt;
line-height:107%'> in <span class=SpellE><i style='mso-bidi-font-style:normal'>param_file</i></span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast'>- </span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:"Courier New"'><m:r>c</m:r><m:r>×</m:r></span></i><m:d><m:dPr><span
   style='font-size:12.0pt;mso-ansi-font-size:12.0pt;mso-bidi-font-size:12.0pt;
   font-family:"Cambria Math","serif";mso-ascii-font-family:"Cambria Math";
   mso-hansi-font-family:"Cambria Math";mso-bidi-font-family:"Courier New";
   font-style:italic;mso-bidi-font-style:normal'><m:ctrlPr></m:ctrlPr></span></m:dPr><m:e><i
   style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
   107%;font-family:"Cambria Math","serif";mso-bidi-font-family:"Courier New"'><m:r>n</m:r><m:r>_</m:r><m:r>soma</m:r><m:r>_</m:r><m:r>I</m:r><m:r>_</m:r><m:r>scenarios</m:r><m:r><span
    style='mso-spacerun:yes'>  </span>+</m:r><m:r>n</m:r><m:r>_</m:r><m:r>mc</m:r><m:r>_</m:r><m:r>test</m:r><m:r>_</m:r><m:r>scenarios</m:r></span></i></m:e></m:d></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:265.8pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image049.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=443 height=25
src="images/Help_Model_Simulation_files/image050.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:"Courier New"'><span
style='mso-spacerun:yes'></span><span class=GramE> files</span> for voltage
plotting<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:94.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:"Courier New"'>- </span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:"Courier New"'><m:r>c</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:6pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image051.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=10 height=25
src="images/Help_Model_Simulation_files/image052.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:"Courier New"'>:
number of compartments<span class=GramE>, </span></span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:"Courier New"'><m:r>n</m:r><m:r>_</m:r><m:r>soma</m:r><m:r>_</m:r><m:r>I</m:r><m:r>_</m:r><m:r>scenarios</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:106.8pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image053.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=178 height=25
src="images/Help_Model_Simulation_files/image054.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:"Courier New"'>:
number of </span><span class=SpellE><span style='font-size:12.0pt;line-height:
107%;font-family:"Courier New"'>soma_I_scenarios</span></span><span
style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>, </span><!--[if gte msEquation 12]><m:oMath><i
 style='mso-bidi-font-style:normal'><span style='font-size:12.0pt;line-height:
 107%;font-family:"Cambria Math","serif";mso-bidi-font-family:"Courier New"'><m:r>n</m:r><m:r>_</m:r><m:r>mc</m:r><m:r>_</m:r><m:r>test</m:r><m:r>_</m:r><m:r>scenarios</m:r></span></i></m:oMath><![endif]--><![if !msEquation]><span
style='font-size:11.0pt;line-height:107%;font-family:"Calibri","sans-serif";
mso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:"Times New Roman";
mso-bidi-theme-font:minor-bidi;position:relative;top:4.0pt;mso-text-raise:-4.0pt;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><!--[if gte vml 1]><v:shape
 id="_x0000_i1025" type="#_x0000_t75" style='width:109.8pt;height:15pt'>
 <v:imagedata src="images/Help_Model_Simulation_files/image055.png" o:title=""
  chromakey="white"/>
</v:shape><![endif]--><![if !vml]><img width=183 height=25
src="images/Help_Model_Simulation_files/image056.png" v:shapes="_x0000_i1025"><![endif]></span><![endif]><span
style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:"Times New Roman";
mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:"Courier New"'>:
number </span><span style='font-size:12.0pt;line-height:107%;mso-fareast-font-family:
"Times New Roman";mso-fareast-theme-font:minor-fareast;mso-bidi-font-family:
Calibri;mso-bidi-theme-font:minor-latin'>of </span><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>simulation
scenarios to test multi-compartment constraints (Venkadesh et al., 2018)<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- Naming convention for voltage files: </span><span
class=SpellE><span style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>allV</span></span><span
style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'>_&lt;<span
class=SpellE>scenario_id</span>&gt;_&lt;<span class=SpellE>compartment_id</span>&gt;</span><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>. For example,</span><span style='font-size:
12.0pt;line-height:107%;font-family:"Courier New"'> allV_0_0 </span><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>denotes somatic voltage for the first</span><span
style='font-size:12.0pt;line-height:107%;font-family:"Courier New"'> I/<span
class=SpellE>I_dur</span> </span><span style='font-size:12.0pt;line-height:
107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>scenario
specified in the </span><span class=SpellE><i style='mso-bidi-font-style:normal'><span
style='font-size:12.0pt;line-height:107%'>param_file</span></i></span><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>, and </span><span style='font-size:12.0pt;
line-height:107%;font-family:"Courier New"'>allV_0_1 </span><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>denotes dendritic voltage for the same
simulation scenario. Voltage is recorded at 1<i style='mso-bidi-font-style:
normal'>ms</i> resolution. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:58.5pt;text-indent:-4.5pt'><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'>- One simulation log file</span><span
style='font-size:12.0pt;line-height:107%'><o:p></o:p></span></p>

<p class=MsoListParagraph style='margin-left:.75in;mso-add-space:auto;
text-indent:-.25in;mso-list:l1 level1 lfo1'><![if !supportLists]><span
style='font-size:12.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><span style='mso-list:Ignore'>6.<span
style='font:7.0pt "Times New Roman"'> </span></span></span><![endif]><span
style='font-size:12.0pt;line-height:107%'>Optionally, you can include <i
style='mso-bidi-font-style:normal'>N </i>models in a single <span class=SpellE><i
style='mso-bidi-font-style:normal'>param_file</i></span> and run them all at
once. Make sure to replace the line number (6p/7p) by the appropriate range of <i
style='mso-bidi-font-style:normal'>N</i> lines. All output files will be
prefixed with an index from <i style='mso-bidi-font-style:normal'>0</i> to <i
style='mso-bidi-font-style:normal'>N-1</i><span style='mso-spacerun:yes'></span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:12.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>Refer
to this article for more details and discussion on multi-compartment models: </span><span
style='font-size:10.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin;color:#222222'>Venkadesh S, Komendantov AO, <span
class=SpellE>Listopad</span> S, Scott EO, De Jong K, <span class=SpellE>Krichmar</span>
JL, Ascoli GA. (2018). <span class=GramE>Evolving Simple Models of Diverse
Intrinsic Dynamics in Hippocampal Neuron Types.</span> <span class=GramE><i
style='mso-bidi-font-style:normal'>Frontiers in neuroinformatics.</i></span><i
style='mso-bidi-font-style:normal'> </i></span><a
href="https://doi.org/10.3389/fninf.2018.00008"><span style='font-size:10.0pt;
line-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin'>https://doi.org/10.3389/fninf.2018.00008</span></a><span
style='font-size:10.0pt;line-height:107%;mso-bidi-font-family:Calibri;
mso-bidi-theme-font:minor-latin'><o:p></o:p></span></p>

</div>

</body>

</html>

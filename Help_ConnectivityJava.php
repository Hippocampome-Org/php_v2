<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Help</title>
<script type="text/javascript" src="style/resolution.js"></script>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0.15in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:11.0in 8.5in;
	margin:.5in .5in .5in .5in;}
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

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=967 valign=top style='width:725.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  150%'><b><u><span style='font-size:16.0pt;line-height:150%;font-family:"Arial","sans-serif"'>The Java connectivity map won't launch.  What can I do?</span></u></b></p>
  </td>
 </tr>

 <tr>
  <td width=967 valign=top style='width:725.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:12.0pt;font-family:"Arial","sans-serif"'>
  <br>The connectivity map allows the user to explore the connectivity of one or all of the neuron types
  in a (hippocampal-formation-wide) anatomical context.  It is designed to be downloaded and run on the user's machine. Because 
  the program is Java-based, it is subject to constraints imposed by local security settings 
  in the Java Control Panel of your system. If the Connectivity Map fails to launch, please try 
  the following to troubleshoot:
  <ol>
	<li>Update your Java Runtime Environment (JRE) to the latest version</li>
	<li>Locate and open the Java Control Panel in your system (e.g. in the Control Panel on Windows machines or System Preferences on Macs)</li>
	<li>Go to the Security tab and click on the Edit Site List button</li>
	<li>Add a new entry to the exception list using the following URL: http://hippocampome.org</li>
	<li>Save the new preferences and close</li>
	<li>Download the file again.  If the browser informs you that this type of file can harm your computer and asks whether you want to keep it, choose to do so.</li>
	<li><B>**Right click**</B> on the downloaded .jnlp file and choose to "Open" or "Launch" it.  Alternatively (Mac only), right-click (or Control-click) the .jnlp file and then select "Open With > Java Web Start.app"; then click "Open" in the dialog box which appears.</li>
  </ol>
  </span></p>
  </td>
 </tr>
 
</table>

<p class=MsoNormal>&nbsp;</p>

</div>
<!-- ------------------------ -->

</body>

</html>

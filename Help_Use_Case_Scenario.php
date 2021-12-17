<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Usage Scenario</title>
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
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0.15in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:.5in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:.5in .5in .5in .5in;}
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

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
		
<BR><BR><BR><BR><BR>
	
<div class=WordSection1>
		
<p class=MsoNormal><b><u><span style='font-size:16.0pt;line-height:115%;
font-family:"Arial","sans-serif"'>Hippocampome Usage Scenario</span></u></b></p>


<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-indent:
.5in;line-height:200%'><span style='font-size:14.0pt;line-height:200%'>Consider
the following scenario: a neuroscientist applies intracellular, stimulating
current to a neuron in CA1 SLM and observes action potentials in a neuron with
a soma in CA1 SO.<span style='mso-spacerun:yes'>  </span>Examination of the
axons and dendrites of the presynaptic cell shows that it has dendrites in CA1
SLM and axons in CA1 SR.<span style='mso-spacerun:yes'>  </span>The
Hippocampome indicates that this <span class=SpellE>axo</span>-dendritic
pattern corresponds to the CA1 IS LM-R neuron type (also called CA1 IS2: Fig.
13 </span><!--[if supportFields]><span style='font-size:14.0pt;line-height:
200%'><span style='mso-element:field-begin'></span><span
style='mso-spacerun:yes'> </span>ADDIN ZOTERO_ITEM CSL_CITATION
{&quot;citationID&quot;:&quot;ixLcm5bj&quot;,&quot;properties&quot;:{&quot;formattedCitation&quot;:&quot;(Hajos
et al., 1996)&quot;,&quot;plainCitation&quot;:&quot;(Hajos et al., 1996)&quot;},&quot;citationItems&quot;:[{&quot;id&quot;:7238,&quot;uris&quot;:[&quot;http://zotero.org/users/274354/items/VRF3Q56I&quot;],&quot;uri&quot;:[&quot;http://zotero.org/users/274354/items/VRF3Q56I&quot;],&quot;itemData&quot;:{&quot;id&quot;:7238,&quot;type&quot;:&quot;article-journal&quot;,&quot;title&quot;:&quot;Target
selectivity and neurochemical characteristics of VIP-immunoreactive
interneurons in the rat dentate
gyrus.&quot;,&quot;container-title&quot;:&quot;The European journal of
neuroscience&quot;,&quot;page&quot;:&quot;1415-1431&quot;,&quot;volume&quot;:&quot;8&quot;,&quot;issue&quot;:&quot;7&quot;,&quot;abstract&quot;:&quot;Vasoactive
intestinal polypeptide (VIP) has been shown to be present in a morphologically
heterogeneous subpopulation of interneurons in the dentate gyrus, but the
relationship between their input and output characteristics and neurochemical
features has not been established. Three types
of&quot;,&quot;note&quot;:&quot;PMID: 8758949&quot;,&quot;journalAbbreviation&quot;:&quot;Eur
J
Neurosci&quot;,&quot;language&quot;:&quot;eng&quot;,&quot;author&quot;:[{&quot;family&quot;:&quot;Hajos&quot;,&quot;given&quot;:&quot;N.&quot;},{&quot;family&quot;:&quot;Acsady&quot;,&quot;given&quot;:&quot;L.&quot;},{&quot;family&quot;:&quot;Freund&quot;,&quot;given&quot;:&quot;T.
F.&quot;}],&quot;issued&quot;:{&quot;date-parts&quot;:[[&quot;1996&quot;,7]]},&quot;PMID&quot;:&quot;8758949&quot;}}],&quot;schema&quot;:&quot;https://github.com/citation-style-language/schema/raw/master/csl-citation.json&quot;}
<span style='mso-element:field-separator'></span></span><![endif]--><span
style='font-size:14.0pt;mso-bidi-font-size:12.0pt;line-height:200%'>(<span
class=SpellE>Hajos</span> et al., 1996)</span><!--[if supportFields]><span
style='font-size:14.0pt;line-height:200%'><span style='mso-element:field-end'></span></span><![endif]--><span
style='font-size:14.0pt;line-height:200%'> and Fig. 1 </span><!--[if supportFields]><span
style='font-size:14.0pt;line-height:200%'><span style='mso-element:field-begin'></span><span
style='mso-spacerun:yes'> </span>ADDIN ZOTERO_ITEM CSL_CITATION
{&quot;citationID&quot;:&quot;1ofmsl6ohl&quot;,&quot;properties&quot;:{&quot;formattedCitation&quot;:&quot;(Klausberger
and Somogyi, 2008)&quot;,&quot;plainCitation&quot;:&quot;(Klausberger and
Somogyi,
2008)&quot;},&quot;citationItems&quot;:[{&quot;id&quot;:&quot;ox0Mv0aQ/6cp3aKK9&quot;,&quot;uris&quot;:[&quot;http://zotero.org/users/local/vWOcJXfS/items/5XTTB9AX&quot;],&quot;uri&quot;:[&quot;http://zotero.org/users/local/vWOcJXfS/items/5XTTB9AX&quot;],&quot;itemData&quot;:{&quot;id&quot;:&quot;ox0Mv0aQ/6cp3aKK9&quot;,&quot;type&quot;:&quot;article-journal&quot;,&quot;title&quot;:&quot;Neuronal
diversity and temporal dynamics: the unity of hippocampal circuit
operations&quot;,&quot;container-title&quot;:&quot;Science (New York,
N.Y.)&quot;,&quot;page&quot;:&quot;53-57&quot;,&quot;volume&quot;:&quot;321&quot;,&quot;issue&quot;:&quot;5885&quot;,&quot;abstract&quot;:&quot;In
the cerebral cortex, diverse types of neurons form intricate circuits and
cooperate in time for the processing and storage of information. Recent
advances reveal a spatiotemporal division of labor in cortical circuits, as
exemplified in the CA1 hippocampal area. In particular, distinct GABAergic
(gamma-aminobutyric acid-releasing) cell types subdivide the surface of
pyramidal cells and act in discrete time windows, either on the same or on
different subcellular compartments. They also interact with glutamatergic
pyramidal cell inputs in a domain-specific manner and support synaptic temporal
dynamics, network oscillations, selection of cell assemblies, and the
implementation of brain states. The spatiotemporal specializations in cortical
circuits reveal that cellular diversity and temporal dynamics coemerged during
evolution, providing a basis for cognitive
behavior.&quot;,&quot;DOI&quot;:&quot;10.1126/science.1149381&quot;,&quot;note&quot;:&quot;PMID:
18599766&quot;,&quot;shortTitle&quot;:&quot;Neuronal diversity and temporal
dynamics&quot;,&quot;journalAbbreviation&quot;:&quot;Science&quot;,&quot;author&quot;:[{&quot;family&quot;:&quot;Klausberger&quot;,&quot;given&quot;:&quot;Thomas&quot;},{&quot;family&quot;:&quot;Somogyi&quot;,&quot;given&quot;:&quot;Peter&quot;}],&quot;issued&quot;:{&quot;year&quot;:2008,&quot;month&quot;:7,&quot;day&quot;:4},&quot;accessed&quot;:{&quot;year&quot;:2012,&quot;month&quot;:7,&quot;day&quot;:13},&quot;page-first&quot;:&quot;53&quot;,&quot;title-short&quot;:&quot;Neuronal
diversity and temporal
dynamics&quot;,&quot;container-title-short&quot;:&quot;Science&quot;}}],&quot;schema&quot;:&quot;https://github.com/citation-style-language/schema/raw/master/csl-citation.json&quot;}
<span style='mso-element:field-separator'></span></span><![endif]--><span
style='font-size:14.0pt;mso-bidi-font-size:12.0pt;line-height:200%'>(Klausberger
and Somogyi, 2008)</span><!--[if supportFields]><span style='font-size:14.0pt;
line-height:200%'><span style='mso-element:field-end'></span></span><![endif]--><span
style='font-size:14.0pt;line-height:200%'>).<span style='mso-spacerun:yes'> 
</span>Labeling of the axons and dendrites of the postsynaptic neuron is
incomplete, but it shows that the cell has dendrites in CA1 SLM, SR, and SP and
axons in CA1 SP.<span style='mso-spacerun:yes'>  </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-indent:
.5in;line-height:200%'><span style='font-size:14.0pt;line-height:200%'>In
addition to the Hippocampome providing a list of candidate neurons types, it
provides biomarker expression properties to distinguish them.<span
style='mso-spacerun:yes'>  </span>Assume further that the postsynaptic neuron
is CB-positive and PV-negative, which points strongly to its being a CA1
Oriens/alveus neuron.<span style='mso-spacerun:yes'>  </span>These happen to be
the only two biomarkers for which there is expression information for this
neuron type; consequently, the researcher makes plans to extract the mRNA and
preserves the slice in preparation for future experiments to ascertain a fuller
biomarker profile for the neuron, thereby using the Hippocampome to illuminate
targets for future work.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
200%'><span style='font-size:14.0pt;line-height:200%'><span style='mso-tab-count:
1'>          </span>In speculating about the role of the presynaptic CA1 IS
LM-R neuron <i style='mso-bidi-font-style:normal'>in vivo</i>, the researcher
uses the Hippocampome to identify neuron types with axons arborizing in CA1
SLM.<span style='mso-spacerun:yes'>  </span>Interestingly, both excitatory and
inhibitory neuron types have axons in this parcel.<span
style='mso-spacerun:yes'>  </span>The potential excitatory inputs come from
either CA1, Sub, or EC neuron types, so the researcher is able to convert the
slice experiment to stimulate subicular pyramidal neurons and monitor an EPSP
response in the IS LM-R neuron.<span style='mso-spacerun:yes'>  </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-indent:
.5in;line-height:200%'><span style='font-size:14.0pt;line-height:200%'>This
information on the potential connection of Sub Pyramidal-CA1 projecting and CA1
IS LM-R neuron types is part of the wiring diagram for the CA1 SLM local
environment that can be created from knowledge in the Hippocampome.<span
style='mso-spacerun:yes'>  </span>The researcher uses all of the wiring
information, in combination with available electrophysiological properties in
the Hippocampome for the neuron types, to create a realistic small network
model centered on the CA1 IS LM-R neuron.<o:p></o:p></span></p>

<p class=MsoBibliography><!--[if supportFields]><span style='mso-element:field-begin'></span><span
style='mso-spacerun:yes'> </span>ADDIN ZOTERO_BIBL {&quot;custom&quot;:[]}
CSL_BIBLIOGRAPHY <span style='mso-element:field-separator'></span><![endif]--><span
class=SpellE><span class=GramE>Hajos</span></span><span class=GramE>, N., <span
class=SpellE>Acsady</span>, L., and Freund, T.F. (1996).</span> <span
class=GramE>Target selectivity and neurochemical characteristics of
VIP-immunoreactive interneurons in the rat dentate gyrus.</span> Eur. J. <span
class=SpellE>Neurosci</span>. <i>8</i>, 14151431.</p>

<p class=MsoBibliography><span class=GramE>Klausberger, T., and Somogyi, P.
(2008).</span> Neuronal diversity and temporal dynamics: the unity of
hippocampal circuit operations. Science <i>321</i>, 5357.</p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
200%'><!--[if supportFields]><span style='mso-element:field-end'></span><![endif]--><span
style='font-size:14.0pt;line-height:200%'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span style='font-size:14.0pt;line-height:115%'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>

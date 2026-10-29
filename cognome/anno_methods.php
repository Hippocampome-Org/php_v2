<?php include ("permission_check.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  <?php include('set_theme.php'); ?>
  <?php include('function/hc_header.php'); ?>
  <script type="text/javascript">
    function toggle_vis(elem_name) {
     var elem = document.getElementById(elem_name);
     if (elem.style.display === "none") {
      elem.style.display = "block";
    } else {
      elem.style.display = "none";
    }
  }
  </script>
</head>
<body>
  <?php include("function/hc_body.php"); ?>   
  <br>
  <br>
    <!-- start of header -->
    <?php echo file_get_contents('header.html'); ?>
    <div style="width:90%;position:relative;left:5%;"> 
    <script type='text/javascript'>
      document.getElementById('header_title').innerHTML="<a href='anno_methods.php' style='text-decoration: none;color:black !important'><span class='title_section'>Annotation Methods</span></a>";
      document.getElementById('fix_title').style='width:90%;position:relative;left:5%;';
    </script>
    <!-- end of header -->

<?php

function sec_start($sec_desc, $sec_name, $check) {
	$sec_start = "<div class='wrap-collabsible' id='art_select'><input id='collapsible_$sec_name' class='toggle' type='checkbox' ";
	if ($check == "checked") {
		$sec_start = $sec_start."checked";
	}
	$sec_start = $sec_start."><label for='collapsible_$sec_name' class='lbl-toggle'>$sec_desc</label><div class='collapsible-content'><div class='content-inner' style='font-size:22px;'><p><div style='max-height:1000px;font-size:22px;overflow:auto'><table border=1>";

	return $sec_start;
}
$sec_end = "</table></div></p></div><a style='font-size:10px'><hr></a></div></div><br>";

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="subject") {
echo sec_start("Subject Dimension:", "subj_dim", "checked");
echo "
Subjects annotated must be connected to an acceptable simulation that includes hippocampal activity. Specifically, articles that include multiple simulations with some that don't include hippocampal content will have the non-hippocampal associated simulations not annotated with subjects they include.
<br><br>
The subjects annotated are what are interpreted as the focus of the article. Some subjects can be mentioned in a short amount of writing in the article but if they are not a focus of the experimentation in the article then they are not annotated. One type of evidence that applies toward the choice of annotating a subject is text that supports a recognition of the subject as being a purpose of investigation in the simulation experiment. Another source of evidence is clear and explicit descriptions of the subject being included in the experimental design. A balance between evidence representing that the subject was a study purpose and explicit description(s) that were made of the subject being included in the simulation should be used to justify an annotation.
<br><br>
Subjects that were not described as a focus of the study and/or are not explicitly described to a reasonable level as being included in the experimental design are not included as subject annotations. This will exclude subject annotations with weak or circumstantial evidence as being included, and this is intentional. Descriptions that are unlikely to count toward evidence of a subject have the lack of a direct description of the subject or ones where an inference needs to be made which contains some ambiguity about the presence of the subject. The objective of the annotation method is to be based on clear evidence with minimal ambiguity.
<br><br>
Requirement: at least one entity of this dimension is needed to be annotated for an article to be accepted into the core collection. The subject can include a cognitive/behavioral function or other neural activity.
";
echo $sec_end;

include("anno_methods_subj.php");
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="detail") {
echo sec_start("Level of Detail Dimension:", "det_dim", "checked");
echo "
The detail level dimension provides the type of simulation model used in the work. The level of biological abstractness of the model can be inferred from its core equations, without extensions to its complexity. The model included in the work at the lowest level is annotated as this property's value.
<br><br>
Requirement: individual spike times modeled. More specifically, the computational work must simulate the occurrence of spikes with the time of each spike captured on an individual spike basis. The neurons must be either simulated in a rodent or an animal type is not stated. Simulations with no stated animal types are assumed to be relevant to rodents. 
<br><br>
The precision of timing should be at time steps of 2ms or less. The times step does not need to be explicitly stated in an article for it to be accepted, it can be assumed to be 1ms, but if it is stated than this rule applies.
<br><br>
Requirement: one entity of this dimension is needed to be annotated for an article to be accepted into the core collection.
";
echo $sec_end;
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="scale") {
echo sec_start("Simulation Scale Dimension:", "scl_dim", "checked");
echo "
Requirement: one entity of this dimension is needed to be annotated for an article to be accepted into the core collection. The simulation must be a scale of at least 10 neurons. The neurons must be spiking. Of these minimum number of neurons, each spike time must be recorded and not only an average reported of multiple spikes. The neurons must have at least some connections, and must be more than no connections. 
<br><br>
Only neurons that are fully modeled, e.g., no signal generators, etc., are counted in the scale of the network. Neurons that are outside of the hippocampus region but in the hippocampus-included simulation are counted. Any neurons in a simulation where the simulation does not include the hippocampus are excluded from the count. The total neurons in individual simulations are counted, not the sum count of neuron across multiple simulations. For example, two simulations with 400 neurons each would be annotated as a scale of 400 neurons total, not 800 neurons. A minimum acceptable number of neurons needs to be explicitly described in the article. Network scales are not assumed or guessed.
<br><br>
The circuit/network simulated must be based in biology. An artificial neural network does not count toward the presence of a circuit/network simulation. An original simulation must be performed, not only described as methods. In other words, not only do computational methods need to be described, but a simulation must have been performed with them.
<br><br>
It is permissible to reuse a previously developed simulation design, as long as the authors created a new  simulation using that design. More specifically, only referencing results from another article’s simulation is insufficient to qualify an article for acceptance into this annotation collection. In the work described with the article being annotated the authors must have created a new run of a simulation that meets annotation requirements listed here for the article to be acceptable for inclusion in this collection.
<br><br>
Q: Is there a minimum spiking amount needed for each neuron?
<br>
A: A requirement is that the simulation in general needs to produce some spiking. However, if a neuron has a neuron model is capable of spiking, but it didn't spike in a simulation, it still counts as a neuron with an acceptable neuron model. For example, if a certain neuron only receives inhibitory input for the purposes of the simulation, and that causes no spiking, as long as other neurons in the simulation perform spiking, that neuron that didn't spike still counts as an acceptable neuron because its neuron model would model spiking if relevant input was provided by that.
";
echo $sec_end;
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="impl") {
echo sec_start("Level of Implementation Dimension:", "impl_dim", "checked");
echo "
<u>Fully implemented:</u> the research reports having constructed and successfully run a simulation with the model
<br><u>Partially implemented:</u> some approaches, techniques, or formulas are described that can be used in a future model. A model has not been reported to have been run in a simulation.
<br><u>Not implemented:</u> No specific approaches, techniques, or formulas are described for use in a model. A model has not been reported to have been run in a simulation. A general type or category of model has been included in the article’s writing.
<br>
<br><u>All methods available:</u> all information needed to recreate the model is available directly through descriptions included in the article.
<br><u>Some methods available:</u> some methods are included in the articles writing but key elements are missing that are needed for reproduction. For example, those elements can be one of the following: formulas used to represent neurons, biophysical parameters to represent the region under study, formulas used to generate network-level activity of neurons.
<br><u>Not implemented:</u> a significant lack of methods are explicitly described in the literature which would be used to recreate the model described.
<br><br>
Requirement: one entity of this dimension is needed to be annotated for an article to be accepted into the core collection.
";
echo $sec_end;
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="region") {
echo sec_start("Anatomical Region Dimension:", "reg_dim", "checked");
echo "
The region dimension is an annotation of which anatomical brain regions or subregions were included in simulation(s) in the article's research. Regions that were described but not simulated are not included in this annotation.
<br><br>
If an article states the simulation is possibly relevant to more than one subregion (e.g., could potentially apply to CA1 or CA3) than both subregions are annotated.
<br><br>
It is acceptable to include signal generators or other non-fully modeled neurons as evidence of region modeling, as long as specific text in the article describes that the region was included in the simulation. For example, if input from the perforant path was modeled as entorhinal cortex (EC) signals created through a signal generator that didn't fully model neurons and no other EC neurons were included, than it is acceptable to annotate EC as a part of the simulation.
<br><br>
Requirement: at least one entity of this dimension is needed to be annotated for an article to be accepted into the core collection. No minimum number of neurons is needed in each region.
";
echo $sec_end;
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="theory") {
echo sec_start("Theories or Computational Network Algorithm Dimension:", "thy_dim", "checked");
echo "
The theory or computational network algorithm dimension includes which theories were found to be included in the literature. This dimension also includes computational algorithms that are applied toward capturing network activities of neurons.
<br><br>
Requirement: there are no minimum number of entities of this dimension that are needed to be annotated for articles to be accepted into the core collection.
";
echo $sec_end;
echo sec_start("Theta Phase Precession:", "tpp_dim", "unchecked");
echo "
A definition of phase precession used for annotations is the process in which the times of spikes firing by individual neurons occurs progressively earlier in relation to the phase of an oscillatory rhythm with each successive rhythm cycle [1, 2]. The annotation of theta phase precession (TPP) is made when phase precession is simulated with a theta rhythm as the rhythm connected to it. 
<br><br>
Based on descriptions of the oscillatory interference model by Burgess et al. in the article on that work, any work that includes a simulation based on that model is understood to contain TPP [3]. This is unless the article explicitly describes that TPP was not simulated in the implementation of the Burgess et al. model. Evidence toward this annotation choice is in the quote \"One aspect of the model deserves further scrutiny. The linear interference patterns, whose product generates grid cell firing, result from modulation of the difference between dendritic and somatic oscillators by the cosine of running direction. Each linear pattern shows the familiar phase precession relative to theta (assumed to reflect the somatic oscillator, i.e. from late phase to earlier phases) as the rat runs in the ‘preferred direction.’\" [3]. The inclusion of TPP activity in the interference processing as described in the quote is evidence toward the annotation choice.
<br><br>
References:
<br>[1] https://en.wikipedia.org/wiki/Phase_precession
<br>[2] Maurer, A. P., Cowen, S. L., Burke, S. N., Barnes, C. A., & McNaughton, B. L. (2006). Organization of hippocampal cell assemblies based on theta phase precession. Hippocampus, 16(9), 785–794. https://doi.org/10.1002/hipo.20202
<br>[3] Burgess, N., Barry, C., & O’Keefe, J. (2007). An oscillatory interference model of grid cell firing. Hippocampus, 17(9), 801–812. https://doi.org/10.1002/hipo.20327
";
echo $sec_end;
}


if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="types") {
echo sec_start("Neuron Types Dimension:", "nrn_dim", "checked");
echo "
<u>When to annotate neuron types</u>
<br>Only neuron types that were specifically named as being modeled are annotated. At this time, general forms of neurons, e.g., grid cells, are too unspecific to annotate a particular neuron type for them unless a specific type is described such as stellate cell, etc. In the future there potentially will be an automated process where such general types are automatically assigned to specific neuron types, and that process will be able to be updated when new knowledge is gained about them over time.
<br><br>
<u>Which neurons are included</u>
<br>Neurons must be fully modeled to be included in neuron type annotations. A fully modeled neuron has an equation that receives input, translates that input through a function (e.g., action potential detection), and creates output. A simple form of this is a binary neuron that passes input through a function that calculates if it reaches a spike threshold then outputs a value of 1 if it does. An example of a non-fully modeled neuron is a signal generator that generates values based on probability but does not process input through a function that determines its output. Such a non-fully modeled neuron is considered not sufficiently complete to be acceptable for annotation as a neuron type representation. A distinction is also that if a neuron model's equations are capable of receiving synapses or other connections, even if it does not receive input in the simulation, it is still counted as fully-modeled. An exception to the requirement to directly state a neuron type is if an article references a pathway or process with known neuron types, e.g., Schaffer collaterals, and includes fully modeled neurons to represent the the pathway, the annotation of relevant neuron types is made because of neuron types known to exist in the pathway. In contrast, for another example, a signal generator that provides general CA3 input is not annotated as a neuron type because there is a lack of specificity about what neuron type was included and non-fully modeled neurons were used.
<br><br>
<u>When to use references</u>
<br>It is acceptable to count a neuron type as included if properties of that neuron type are included, even if a specific description of the neuron type is not present. For example, the article can state that the modeling parameters for a neuron were based on the results of an experiment and that experiment was found to record CA1 Ivy cells. In this case CA1 Ivy cells are annotated even if the modeling article did not specifically describe that its neuron model was of CA1 Ivy cells and only included a reference
for that information. The exception to this rule is if the article describes the intention to represent a general group of neurons, e.g., principle cells or interneurons, and the neuron type properties were arbitrarily chosen to represent that group, even though they were based on specific neuron types. In that case the intention is for a general and not specific neuron type. For example, the model is for CA1 interneurons, and properties of CA1 basket cells were used, but the article specifically described 
that the neurons are to be interpreted as CA1 interneurons in general, and therefore the simulated neurons are interpreted as a general form and not a specific type. In general, whatever the article describes as its intention to simulate is what is annotated as being simulated. 
<br><br>
<u>Resolving reference vs. annotated article annotation choices</u>
<br>If the article only describes that ‘interneurons’ were in the model and indicates that CA1 was simulated, then even if the properties of the neurons simulated were from specific neuron types in the references, an interpretation of only general neurons and not specific types will be made because that was what was described in the annotated article. The annotated article's descriptions, including lack of further descriptions, supersedes the descriptions in the references in the event of a confusion about what annotation choice should be made. It is reemphasized here that the interpretation of the intent of the annotated article in its entity descriptions should be the basis of annotation choices as compared to referenced articles.
<br><br>
<u>Lack of subregions specification</u>
<br>Neuron type annotations are only made when hippocampal subregions are specified in the simulation, because otherwise the annotation would be too general.
<br><br>
<u>What is the difference between a normal and fuzzy neuron type annotation?</u>
<br>A normal neuron type annotation has direct written evidence in an article supporting the annotation of an individual neuron type. Fuzzy neuron type annotations are made when a description of a simulated neuron type is present that could represent or be referring to more than one neuron type. It is therefore “fuzzy” (not directly clear) which individual neuron type is being simulated. For example, if a simulation describes it modeled neurons within a subregion and including the expression of a biomarker only known to be found in four neuron types in the subregion, then those four neuron types are annotated as fuzzy. That is annotated because the modeled neurons could represent any of the four neuron types and no further clarification is provided in the article about which individual neuron type is  simulated. The knowledge about which neuron types are represented by a given set of conditions described in an article is mainly based on the knowledge present on hippocampome.org, including the neuron search, at the time of annotation. Other sources of information are also permitted for reference if needed.
<br><br>
Requirement: there are no minimum number of entities of this dimension that are needed to be annotated for articles to be accepted into the core collection.
<br><br><br>
";
echo $sec_end;
}

if (isset($_REQUEST['disp']) && $_REQUEST['disp']=="keyword") {
echo sec_start("Keywords Dimension:", "kwd_dim", "checked");
echo "
The keyword dimension is used for annotating keywords that are useful to track for various research areas.
<br><br>
Requirement: there are no minimum number of entities of this dimension that are needed to be annotated for articles to be accepted into the core collection.
";
echo $sec_end;
}

	?>
</body>
</html>
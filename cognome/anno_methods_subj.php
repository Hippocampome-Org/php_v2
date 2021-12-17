<?php

echo "<center><font style='font-size:24px'><u>Subject Entities</u></font></center><span style='font-size:16px;'><br></span>";
echo sec_start("Spatial memory or navigation", "spm_dim", "unchecked");
echo "
This subject is annotated when spatial cognition in the form of memories of spatial understanding or navigation is described as a part of an article's simulation methods. A subject simply traveling through a defined spatial environment may be insufficient evidence toward annotating this subject. Acceptable evidence toward annotating this subject includes descriptions of a study focusing on investigating the cognitive process of a rodent developing memories of spatial knowledge, e.g., how to navigate a maze.
";
echo $sec_end;

echo sec_start("Episodic memory", "epi_dim", "unchecked");
echo "
An annotation is made of this subject when the article specifically states that episodic memory was studied. The presence of spatial memory as a subject does not automatically apply as evidence toward the inclusion of this subject. The article needs to specifically make a point of stating that episodic memory was a focus of the study for this subject to be annotated. Simply having a sequence of events occur and having the model learn from that is not sufficient evidence of this subject. One reason for that is to help avoid spatial memory annotations automatically causing episodic memory annotations, given that a large amount of spatial memory experimentation can involve remembering sequences. This annotation approach helps make the subjects distinct from each other.
";
echo $sec_end;

echo sec_start("Semantic memory", "sem_dim", "unchecked");
echo "
The definition of semantic memory used for annotations is: “‘Semantic memory’ refers to a major division of long-term memory that includes knowledge of facts, events, ideas, and concepts.” (Martin, A., 2009). For the purposes of annotations, learning information that can lead to long-term memories is an acceptable topic that can be a part of this subject. Therefore, the subject of long-term memory does not need to be annotated every time this subject is annotated. A requirement is that the article needs to specifically state that a focus of the research was on investigating the properties of semantic memory itself, not only that learning facts or ideas where present in a task that was included in the experimental methods.
<br><br>
An example is that a rat can be performing a test that involves recognizing object for a food reward. The objects are interpreted as ideas and it can be presumed that eventually the rat may commit them to long-term memory but the simulation does not need to simulate the process of forming long-term memories (as opposed to recent ones) in order for this subject to be annotated. In this example, the ability for the rat to store information that will represent semantic memories is specifically analyzed in the research, and therefore in general this is acceptable evidence of this subject.
<br><br>
A distinction is made with this memory type compared to episodic memory. While this memory type represents remembering individual facts and ideas separate from the context of a sequence of events, episodic memory is annotated instead of this then episodes or sequences of events are stored in memory.
<br><br>
The presence of pattern learning, as in pattern completion and separation does not automatically apply was evidence toward annotating this subject. Patterns could be episodic sequences or fact knowledge. Unless an article specifies what the content of simulated patterns are, to distinguish between episodic and semantic memory, a type of memory is not assumed.
<br><br>
<u>References</u>
<br>Martin, A. (2009). Semantic Memory. In L. R. Squire (Ed.), Encyclopedia of Neuroscience (pp. 561–566). Academic Press. https://doi.org/10.1016/B978-008045046-9.00786-5
";
echo $sec_end;

echo sec_start("Long-term memory or consolidation", "ltm_dim", "unchecked");
echo "
This subject is annotated when specific descriptions of studying long term memory (LTM) are included in the simulation. Long term potentiation (LTP) or long term depression (LTD) does not automatically represent evidence of LTM. Consolidation is present in an article's study when it is explicitly
described as a part of the experimental methods. Simply transferring a memory between brain subregions does not necessarily represent evidence of consolidation.
<br><br>
Because LTM and consolidation can take a long time to simulate, not all relevant articles will do a full simulation of the processes. It is acceptable for this subject to include articles that explicitly state that their simulation studies properties connected to LTM or consolidation. The article must directly state that connection, not have it only be something that an annotator has to make an inference about because the connection was not directly described in writing.
";
echo $sec_end;

echo sec_start("Working or short-term memory", "stm_dim", "unchecked");
echo "
Annotation for this subject occurs when an article specifically states that studying working (WM) or short-term memory (STM) was a focus of the simulation(s). Evidence that can also contribute to annotating this subject are the methods explicitly describing investigations of the capacity of memory in working or short-term capacities. Short-term synaptic plasticity and short-term synaptic depression does not automatically qualify as STM. Simply describing neural activity simulated in limited time periods, e.g., one second, does not necessarily qualify as evidence toward this subject. A reason for that is to make this annotation represent cases when the cognition of WM and STM was explored in their capabilities, and not cases where only short recording periods occurred without further applicable evidence.
";
echo $sec_end;

echo sec_start("Associative memory", "asc_dim", "unchecked");
echo "
The definition of associative memory used for annotations is “the ability to learn and remember the relationship between unrelated items such as the name of someone we have just met or the aroma of a particular perfume.” (Associative Learning and the Hippocampus, n.d.).
<br><br>
Evidence that qualifies as supporting this subject annotation is if an article describes a focus of its simulation investigations is on analyzing the cognitive process of forming associative memories. To avoid ambiguity, a requirement is that the term “associative” (including different forms of the word, e.g., “association”) must be described explicitly as a part of a method used in the simulation work, and that description must be supporting evidence toward this subject being studied. This is needed to reduce the number of concepts expressed in writing that could be considered an “association”.
<br><br>
In general, a description of the formation of a memory that an object has significance is not necessarily sufficient as evidence toward annotation of this subject. More specifically, a subject learning that an object has value or relevance in an experiment does not automatically count as evidence of this subject. A form of evidence that would count toward the annotation of this subject is a study’s methods explicitly stating that investigations were made into the dynamics changing over a course of an experiment of how associations between objects were learned, saved as memories, and applied toward a rodent’s goals. To contribute toward evidence supporting annotation of this subject, a simulation’s methods should describe a specific emphasis on the investigation of creating associative memories.
<br><br>
Given the definition of autoassociative memory as “effectively, a pattern can be recalled or recognized because of associations formed between its parts.” (Rolls, E. T., 2015). In other words, a pattern that is able to be recalled from only matching a limited portion of that pattern. This is interpreted as a separate concept as associative memory and therefore the presence of autoassociative memory is not necessarily evidence of associative memory.
<br><br>
<u>References</u>
<br>Associative learning and the hippocampus. (n.d.). https://www.apa.org. Retrieved May 11, 2021, from https://www.apa.org/science/about/psa/2005/02/suzuki
<br>Rolls, E. T. (2015). Chapter 2—Diluted connectivity in pattern association networks facilitates the recall of information from the hippocampus to the neocortex. In S. O’Mara & M. Tsanov (Eds.), Progress in Brain Research (Vol. 219, pp. 21–43). Elsevier. https://doi.org/10.1016/bs.pbr.2015.03.007
";
echo $sec_end;

echo sec_start("Reinforcement learning", "ril_dim", "unchecked");
echo "
This subject is annotated when a simulation specifically describes that synaptic weights were changed based on a reinforcement learning mechanism. Simply having a subject learn behavior based on a reward is not necessarily sufficient evidence to annotate this subject. The article must explicitly describe that learning occurred through synapse training from a reinforcement process based on neurons meeting or not meeting a goal objective.
<br><br>
An example of a reinforcement learning algorithm is one that reinforces behavior through discrete values of synapse strengthening when a reward is encountered. Alternatively, when a reward is not encountered a “punishment” is signaled through synaptic depression. Competition among neurons, e.g., lateral connections within a layer, can also cause only a certain number of neurons that had the strongest response when a reward was encountered to be reinforced with synaptic strengthening. The other neurons have synaptic depression. This creates specialization among neurons that designates them for different purposes. Some general sources of more information and examples can be found in (Hu, J., et al., 2020) and (Gupta, A., Long, L. N., 2007).
<br><br>
<u>References</u>
<br>Hu, J.; Niu, H.; Carrasco, J.; Lennox, B.; Arvin, F. (2020). Voronoi-Based Multi-Robot Autonomous Exploration in Unknown Environments via Deep Reinforcement Learning. IEEE Transactions on Vehicular Technology. 69 (12): 14413-14423.
<br>Gupta, A., & Long, L. N. (2007). Character recognition using spiking neural networks. In 2007 International Joint Conference on Neural Networks (pp. 53-58). IEEE.
";
echo $sec_end;

echo sec_start("Pattern completion or separation", "pcs_dim", "unchecked");
echo "
Evidence that supports the annotation of this subject includes descriptions of a simulation recreating the neural processes involved in pattern completion and separation (PCS). The article needs to have a focus of its work on investigating PCS. The article needs to specifically include in its writing that neural activity representing completion of patterns or separation of patterns was simulated. It can not only be inferred that PCS occurred, the article needs to directly state that PCS was studied in its work.
";
echo $sec_end;


echo sec_start("Epilepsy", "epy_dim", "unchecked");
echo "
Epileptic activity can be complex to simulate, and therefore studies that specifically describe their simulations are informative about Epilepsy, even if they don’t directly simulate Epilepsy, are acceptable. For example, if an article simulated a neural property that was described as increasing the chance of Epilepsy, even if Epilepsy itself was not simulated in the article, that article is still acceptable for annotation of this subject. The article must directly state in writing the presence of a connection between its work and Epilepsy, rather than the connection only being implied without writing stating the connection. In addition to an article stating descriptions with the term Epilepsy, descriptions of simulation connections to epileptic, epileptiform, or seizure activities are terms that can count as evidence for this subject.
";
echo $sec_end;

echo sec_start("Schizophrenia", "scz_dim", "unchecked");
echo "
Since Schizophrenia may not be directly modeled in the hippocampus in a variety of cases, if an article specifically states its study included analyzing the effects of its simulation on Schizophrenia then that is evidence toward an annotation of this subject. In other words, not only modeling Schizophrenia processes, but also the effects of modeled neural activity on the disorder is acceptable evidence.
";
echo $sec_end;

echo sec_start("Alzheimer’s disease", "alz_dim", "unchecked");
echo "
Since Alzheimer’s disease may not be directly modeled in the hippocampus in a variety of cases, if an article specifically states its study included analyzing the effects of its simulation on Alzheimer’s disease then that is evidence toward an annotation of this subject. In other words, not only modeling Alzheimer’s disease processes, but also the effects of modeled neural activity on the disorder is acceptable evidence.
";
echo $sec_end;

echo sec_start("Time cells or timekeeping", "tim_dim", "unchecked");
echo "
This subject describes a study of time cells or a specific emphasis on the brain's cognition of time. This subject investigates the mental understanding and recognition of the passage of time in one's life. It is not simply setting time periods on neural activities in an experiment. It instead is the cognitive processes that captures the occurrence of time that a subject perceives.
";
echo $sec_end;

echo sec_start("Other subjects: rhythms", "osr_dim", "unchecked");
echo "
An article needs to specifically describe that rhythm activity was modeled in its simulation to have this subject annotated. This subject is a part of the “other subjects” group that are only annotated when a subject not in that group are found. Rhythms themselves in isolation are not considered a cognitive function, although they can contribute to cognitive functions, and therefore are designated as being in the “other subjects” group.
";
echo $sec_end;

echo sec_start("Other subjects: non-rhythms", "osn_dim", "unchecked");
echo "
This subject choice is annotated when an article is found to contain no subject outside of the “other subject” group and does not contain an annotation representing “other subjects: rhythms”. The purpose of the “other subjects” group is to annotate articles that don’t fit into the named subject (e.g., “spatial memory”) annotation choices (however, this subject choice does have the exception of including the “time cells” subject). Generally, it is a group representing miscellaneous objectives of simulation experiments in articles different than the named subject annotation choices.
";
echo $sec_end;

?>
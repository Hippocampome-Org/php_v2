<?php
// function text file creation for neruon page:

function neuron_page_text_file($id1, $type, $synonymtyperel, $synonym, $evidencepropertyyperel, $property, $epdataevidencerel, $epdata, $class_type)
{
	$name_file = "temp/Neuron_Page.txt";
	
	unlink($name_file );	
	
	$name_cell = $type->getName();
	$nick_cell= $type->getNickname();
	
	$nick_cell = str_replace(':', '_', $nick_cell);
	

	$name_text = " $name_cell \n---------------------------------------------------\n\n";
	$syn_text = "Synonym(s): \n";
	
	// SYNONYMS ****************************************************************************
	$synonymtyperel -> retrive_synonym_id($id1);
	$n_syn = $synonymtyperel -> getN_synonym();
	
	$syn_text1 = NULL;
	for ($i1=0; $i1<$n_syn; $i1++)
	{
		$Synonym_id = $synonymtyperel -> getSynonym_id($i1);
		
		$synonym -> retrive_by_id($Synonym_id);
		$syn = $synonym -> getName();					
		$syn_text1 = $syn_text1.$syn."\n";							
	} 	
	// *******************************************************************************************
	

	// MORPHOLOGY ****************************************************************************	
	$evidencepropertyyperel -> retrive_Property_id_by_Type_id($id1);

	$n = $evidencepropertyyperel -> getN_Property_id();
	$q=0;
	for ($i5=0; $i5<$n; $i5++)
		$property_id[$i5] = $evidencepropertyyperel -> getProperty_id_array($i5);	
	

	$morph_text = "\n******** MORPHOLOGY ********\n";
	
	$morph_soma = "SOMA:\n";
	// SOMA ----------------------------------------------------------------
	$morph_soma1 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$part = $property -> getPart();
		if ($part == 'somata')
		{
			$val = $property -> getVal();
			$rel = $property -> getRel();
			$id_somata = $property -> getID();
			
			$val1 = str_replace(':', '_', $val);
			
			$morph_soma1 = $morph_soma1.$val." (".$rel.")\n";									
		}	
	}
	// ---------------------------------------------------------------------------
		
	$morph_dend = "DENDRITE(S):\n";
	// DENDRITE ----------------------------------------------------------------
	$morph_dend1 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$part = $property -> getPart();
		if ($part == 'dendrites')
		{
			$val = $property -> getVal();
			$rel = $property -> getRel();
			
			$val1 = str_replace(':', '_', $val);
			
			$morph_dend1 = $morph_dend1.$val." (".$rel.")\n";							
		}
	}
	// ---------------------------------------------------------------------------	
	
	$morph_axon = "AXON(S):\n";
	// AXON ----------------------------------------------------------------
	$morph_axon1 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$part = $property -> getPart();
		if ($part == 'axons')
		{
			$val = $property -> getVal();
			$rel = $property -> getRel();
			
			$val1 = str_replace(':', '_', $val);
			
			$morph_axon1 = $morph_axon1.$val." (".$rel.")\n";							
		}
	}
	// ---------------------------------------------------------------------------		
	
	

	// MARKERS ****************************************************************************	
	$markers_text = "\n******** MOLECULAR MARKERS ********\n";
	
	$markers_positive = "POSITIVE:\n";
	// POSITIVE ----------------------------------------------------------------
	
	
	$markers_positive1 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$val = $property -> getVal();
		if ($val == 'positive')
		{
			$part = $property -> getPart();
			$markers_positive1 = $markers_positive1.$part."\n";												
		}
	}	
	
	// WEAK POSITIVE ----------------------------------------------------------------
	$markers_positive2 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$val = $property -> getVal();
		if ($val == 'weak_positive')
		{
			$part = $property -> getPart();
			$markers_positive2 = $markers_positive2.$part."(weak-positive)\n";													
		}
	}		
	
	$markers_negative = "NEGATIVE:\n";
	// NEGATIVE ----------------------------------------------------------------
	$markers_negative1 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$val = $property -> getVal();
		if ($val == 'negative')
		{
			$part = $property -> getPart();
			$markers_negative1 = $markers_negative1.$part."\n";												
		}
	}				

	
	// Electrophysiological properties ****************************************************************************	
	$ephys_text = "\n******** Electrophysiological properties ********\n";
	$ephys_text10 = "- property: value ± S.D (n. measurements)\n";

	for ($i=0; $i<$n; $i++)
	{
		$property -> retrive_by_id($property_id[$i]);
		$predicate = $property -> getRel();
	
		if ($predicate != 'is between');
		else
		{
			$subject = $property -> getPart();
	
	
			// Keep only property_id related by id_type;
			// and retrieve id_evidence by these id:
			$evidencepropertyyperel -> retrive_evidence_id($property_id[$i], $id1);
			$nn = $evidencepropertyyperel ->getN_evidence_id();	
				
			if ($nn == 0);
			else 
			{
				$evidence_id = $evidencepropertyyperel -> getEvidence_id_array(0);
				
				// Retrieve Epdata from EpdataEvidenceRel by using Evidence ID: 
				$epdataevidencerel -> retrive_Epdata($evidence_id);
				
				$epdata_id = $epdataevidencerel -> getEpdata_id();
				
				if ($epdata_id == NULL);
				else
				{
					$epdata -> retrive_all_information($epdata_id);
					$value1 = $epdata -> getValue1();
					$value2 = $epdata -> getValue2();
					$error = $epdata -> getError();
					$n_measurement = $epdata -> getN();
	
					if ($value2)
						$ephys2 = "$value1 - $value2";
					else
					{
						if ($error)
							$ephys2 = "$value1 ± $error ($n_measurement)";
						else
						{
							if ($n_measurement)
								$ephys2 = "$value1 ($n_measurement)";
							else
								$ephys2 = "$value1";
						}
					}							
					$id_ephys2 = $epdata_id;						
				}					
			}	
			$ephys_text1=$ephys_text1.$subject.": ".$ephys2."\n";
		}
	}
	
	
	// Potential presynaptic connections ****************************************************************************	
	$pre_text = "\n******** Potential presynaptic connections ********\n";	
	
	$pre_text1 = NULL;
	$pre_text2 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		// retrieve the name of type from TABLE TYPE:
		$type_3 = new type($class_type);
		$type_3 -> retrive_by_id($id1);
		$name1 = $type_3 -> getName();
				
		$property -> retrive_by_id($property_id[$i]);
		$part1 = $property -> getPart();
		if ($part1 == 'axons')
		{
			$val1 = $property -> getVal();
			$rel1 = $property -> getRel();
		
			if ($rel1 == 'in')
			{
			
				$pre_text2 = $pre_text2."For ".$val1.": \n";		

				$property -> retrive_ID(1, 'dendrites', $rel1, $val1);
				$n_prop = $property -> getNumber_type();
				
				for ($ii=0; $ii<$n_prop; $ii++)
				{
					$property_id2 = $property -> getProperty_id($ii);
					$evidencepropertyyperel -> retrive_Type_id_by_Property_id($property_id2);
					$number_type_id = $evidencepropertyyperel -> getN_Type_id();

					for ($ii2=0; $ii2<$number_type_id; $ii2++)
					{
						$id_type = $evidencepropertyyperel -> getType_id_array($ii2);
						
						if ($id_type == $id1);
						else
						{
							$type_3 -> retrive_by_id($id_type);
							$nick_name= $type_3 -> getNickname();
							$name10= $type_3 -> getName();
							$status = $type_3 -> getStatus();
						
							// check if the connection is Excitatory (+) or  Inhibitory (-)				
							if (strpos($name10, '(+)'))
								$font_col = '(+)';
							if (strpos($name10, '(-)'))
								$font_col = '(-)';
										
							if ($status == 'active')
								$pre_text2=$pre_text2." ".$nick_name.$font_col."\n";
						}
					}							
				}
			}				
		}
	}				
	

	// Potential postsynaptic connections ****************************************************************************

	$post_text = "\n******** Potential presynaptic connections ********\n";	
	
	$post_text1 = NULL;
	$post_text2 = NULL;
	for ($i=0; $i<$n; $i++)
	{
		// retrieve the name of type from TABLE TYPE:
		$type_3 = new type($class_type);
		$type_3 -> retrive_by_id($id1);
		$name1 = $type_3 -> getName();
				
		$property -> retrive_by_id($property_id[$i]);
		$part1 = $property -> getPart();
		if ($part1 == 'dendrites')
		{
			$val1 = $property -> getVal();
			$rel1 = $property -> getRel();
		
			if ($rel1 == 'in')
			{		
				$post_text2 = $post_text2."For ".$val1.": \n";		

				$property -> retrive_ID(1, 'axons', $rel1, $val1);
				$n_prop = $property -> getNumber_type();
				
				for ($ii=0; $ii<$n_prop; $ii++)
				{
					$property_id2 = $property -> getProperty_id($ii);
					$evidencepropertyyperel -> retrive_Type_id_by_Property_id($property_id2);
					$number_type_id = $evidencepropertyyperel -> getN_Type_id();

					for ($ii2=0; $ii2<$number_type_id; $ii2++)
					{
						$id_type = $evidencepropertyyperel -> getType_id_array($ii2);
						
						if ($id_type == $id1);
						else
						{
							$type_3 -> retrive_by_id($id_type);
							$nick_name= $type_3 -> getNickname();
							$name10= $type_3 -> getName();
							$status = $type_3 -> getStatus();
						
							// check if the connection is Excitatory (+) or  Inhibitory (-)				
							if (strpos($name10, '(+)'))
								$font_col = '(+)';
							if (strpos($name10, '(-)'))
								$font_col = '(-)';
										
							if ($status == 'active')
								$post_text2=$post_text2." ".$nick_name.$font_col."\n";
						}
					}							
				}
			}				
		}
	}				

	$ret = "\n";	

	$string = $name_text.$syn_text.$syn_text1.$morph_text.$morph_soma.$morph_soma1.$ret.$morph_dend.$morph_dend1.$ret.$morph_axon.$morph_axon1.$markers_text.$markers_positive.$markers_positive1.$markers_positive2.$ret.$markers_negative.$markers_negative1.$ephys_text.$ephys_text10.$ephys_text1.$pre_text.$pre_text2.$post_text.$post_text2.$ret.$ret;

	$write_file1 = fopen($name_file,"w");
	
	fwrite($write_file1, $string);	

	fclose($write_file1);

	return ($name_file);
}
?>
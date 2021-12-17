<?php
function relation($n, $property, $part)
{
	if ($property == 'Morphology')
	{
		if ($n == 0)
			$relation = 'is found in';
		if ($n == 1)
			$relation = 'is not found in';
	}

	if ($property == 'Molecular markers')
	{
		if ($n == 0)
			$relation = 'is expressed';
		if ($n == 1)
			$relation = 'is not expressed';		
		if ($n == 2)
			$relation = 'expression differences';
		if ($n == 3)
			$relation = 'subtypes';
		if ($n == 4)
			$relation = 'unresolved mixed';
		if ($n == 5)
			$relation = 'unknown';									
	}

	if ($property == 'Electrophysiology' || $property == 'Unique Id')
	{
		if ($n == 0)
			$relation = '=';
		if ($n == 1)
			$relation = '<';		
		if ($n == 2)
			$relation = '<=';
		if ($n == 3)
			$relation = '>';
		if ($n == 4)
			$relation = '>=';
	}
	
	if ($property == 'Connectivity')
	{
		if (strpos($part,'input') == true) {
			if ($n == 0)
				$relation = 'potentially from';
			if ($n == 1)
				$relation = 'known to come from';
			if ($n == 2)
				$relation = 'known not to come from';
		}
		elseif (strpos($part,'output') == true) {
			if ($n == 0)
				$relation = 'potentially targeting';
			if ($n == 1)
				$relation = 'known to target';
			if ($n == 2)
				$relation = 'known not to target';
		}	

	}
	
	if ($property == 'Major Neurotransmitter')
	{
		if ($n == 0)
			$relation = 'is expressed';
		if ($n == 1)
			$relation = 'is not expressed';
	}
	
	if ($property == 'Firing Pattern')
	{
		if ($n == 0)	
			$relation = 'Occurrences =';
		if ($n == 1)
			$relation = 'Occurrences <';		
		if ($n == 2)
			$relation = 'Occurrences <=';
		if ($n == 3)
			$relation = 'Occurrences >';
		if ($n == 4)
			$relation = 'Occurrences >=';
	}
	if ($property == 'Firing Pattern Parameter')
	{
		if ($n == 0)
			$relation = '=';
		if ($n == 1)
			$relation = '<';		
		if ($n == 2)
			$relation = '<=';
		if ($n == 3)
			$relation = '>';
		if ($n == 4)
			$relation = '>=';
	}
	return $relation;
}
?>

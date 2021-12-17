<?php
function property($n)
{
	if ($n == 0)
		$property = 'Morphology';
	if ($n == 1)	
		$property = 'Molecular markers';
	if ($n == 2)
		$property = 'Electrophysiology';
	if ($n == 3)
		$property = 'Connectivity';
	if ($n == 4)
		$property = 'Major Neurotransmitter';
	if ($n == 5)
		$property = 'Firing Pattern';
	if ($n == 6)
		$property = 'Firing Pattern Parameter';
	if ($n == 7)
		$property = 'Unique Id';
	

	return $property;
}
?>

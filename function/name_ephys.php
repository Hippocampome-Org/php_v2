<?php
// Function for real name eletrophisiology: +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function real_name_ephys($name)
{
	if ($name == 'Fast AHP')
	{
		$real_name = 'fast_AHP';
		return $real_name;
	}
	else if ($name == 'AP ampl')
	{
		$real_name = 'AP_ampl';
		return $real_name;
	}
	else if ($name == 'AP width')
	{
		$real_name = 'AP_width';
		return $real_name;
	}
	else if ($name == 'Max F.R.')
	{
		$real_name = 'max_fr';
		return $real_name;
	}
	else if ($name == 'Slow AHP')
	{
		$real_name = 'slow_AHP';
		return $real_name;
	}
	else if ($name == 'V rest')
	{
		$real_name = 'Vrest';
		return $real_name;
	}
	else if ($name == 'V thresh')
	{
		$real_name = 'Vthresh';
		return $real_name;
	}
	else if ($name == 'R in')
	{
		$real_name = 'Rin';
		return $real_name;
	}	
	else if ($name == 'tau m')
	{
		$real_name = 'tm';
		return $real_name;
	}	
	else if ($name == 'Sag ratio')
	{
		$real_name = 'sag_ratio';
		return $real_name;
	}		
	else
	{
		$real_name = $name;
		return $real_name;
	}	
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
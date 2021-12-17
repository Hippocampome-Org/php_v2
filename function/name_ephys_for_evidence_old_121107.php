<?php
// Function for real name eletrophisiology: +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function real_name_ephys_evidence($name)
{
	if ($name == 'Vrest')
	{
		$real_name = 'Resting membrane potential';
		return $real_name;
	}
	if ($name == 'Rin')
	{
		$real_name = 'Input resistance';
		return $real_name;
	}
	if ($name == 'tau')
	{
		$real_name = 'Time constant';
		return $real_name;
	}
	if ($name == 'tm')
	{
		$real_name = 'Time constant';
		return $real_name;
	}	
	if ($name == 'V-thresh')
	{
		$real_name = 'Threshold potential';
		return $real_name;
	}
	if ($name == 'Vthresh')
	{
		$real_name = 'Threshold potential';
		return $real_name;
	}	
	if ($name == 'Fast AHP')
	{
		$real_name = 'Fast afterhyperpolaziring potential amplitude';
		return $real_name;
	}
	if ($name == 'fast_AHP')
	{
		$real_name = 'Fast afterhyperpolaziring potential amplitude';
		return $real_name;
	}
	if ($name == 'AP ampl')
	{
		$real_name = 'Action potential amplitude';
		return $real_name;
	}
	if ($name == 'AP_ampl')
	{
		$real_name = 'Action potential amplitude';
		return $real_name;
	}	
	
	if ($name == 'AP width')
	{
		$real_name = 'Action potential width';
		return $real_name;
	}
	if ($name == 'AP_width')
	{
		$real_name = 'Action potential width';
		return $real_name;
	}	
	if ($name == 'Slow AHP')
	{
		$real_name = 'Slow ahterhyperpolarizing potential amplitude';
		return $real_name;
	}
	if ($name == 'slow_AHP')
	{
		$real_name = 'Slow ahterhyperpolarizing potential amplitude';
		return $real_name;
	}	
	if ($name == 'Sag-ratio')
	{
		$real_name = 'Sag ratio';
		return $real_name;
	}
	if ($name == 'sag_ratio')
	{
		$real_name = 'Sag ratio';
		return $real_name;
	}




}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
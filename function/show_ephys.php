<?php
function show_ephys($var)
{
	include ("function/ephys_unit_table.php");
	include ("function/ephys_num_decimals_table.php");
	
	$units = $ephys_unit_table[$var];
	$num_decimals = $ephys_num_decimals_table[$var];
	
	if($var == 'Vrest')
	{	
		$name_show = 'V<small><sub>rest</small></sub>';
		$flag = 2;
	}
	if($var == 'Rin')
	{	
		$name_show = 'R<small><sub>in</small></sub>';
		$flag = 2;
		$units = 'M&Omega;';	// use the greek symbol here
	}
	if($var == 'tm')
	{	
		$name_show = '&tau;<small><sub>m</small></sub>';
		$flag = 1;
	}
	if($var == 'Vthresh')
	{	
		$name_show = 'V<small><sub>thresh</small></sub>';
		$flag = 2;
	}	
	if($var == 'fast_AHP')
	{	
    //		$name_show = 'Fast AHP<small><sub>ampl</small></sub>';
		$name_show = 'Fast AHP';
		$flag = 2;
	}	
	if($var == 'AP_ampl')
	{	
		$name_show = 'AP<small><sub>ampl</small></sub>';
		$flag = 1;
	}		
	if($var == 'AP_width')
	{	
		$name_show = 'AP<small><sub>width</small></sub>';
		$flag = 1;
	}		
	if($var == 'max_fr')
	{	
		$name_show = 'Max F.R.';
		$flag = 1;
	}		
	if($var == 'slow_AHP')
	{	
		$name_show = 'Slow AHP';
		$flag = 1;
	}
	if($var == 'sag_ratio')
	{	
		$name_show = 'Sag ratio';
		$flag = 1;
	}	

	$res[0] = $name_show;    //name showed
	$res[1] = $flag;
	$res[2] = $units;
	$res[3] = $num_decimals;

	return($res);
}
?>

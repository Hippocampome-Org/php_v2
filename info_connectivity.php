<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$type_post = $_REQUEST['type_post'];
$main = $_REQUEST['main'];
$connection = $_REQUEST['connection'];
// type_post=E&main=$nickname_type&connection=$nickname_type1

if ($type_post == 'E')
	$post = 'Excitatory Postsynaptic Connection for: ';
if ($type_post == 'I')
	$post = 'Inhibitory Postsynaptic Connection for: ';
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Information of connectivity</title>
<link rel='stylesheet' type='text/css' href='style/style.css'>
</head>

<body>
<div align="center">
<br />
	<table border="0" width="90%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="70%">
			<img src="images/Hippocampome Logo.png" width="70px" />
		</td>
		<td width="30%">
		</td>	
	</tr>
</table>

<br /><br /><br />


	<table border="1" width="80%" cellpadding="0" cellspacing="2">
	<tr>
		<td width="60%">
			<font class='font4'> <?php print $post; ?> </font>
		</td>
		<td width="40%">
		<font class='font4'> <strong><?php print $main; ?></strong> </font>
		</td>	
	</tr>
	<tr>
		<td width="60%">
			<font class='font4'> </font>
		</td>
		<td width="40%" bgcolor="#FFFFCC">
		<font class='font4'> <?php print $connection; ?> </font>
		</td>	
	</tr>	
	<tr>
		<td width="60%">
			<font class='font4'> Other:</font>
		</td>
		<td width="40%" bgcolor='#66FFFF'>
		<font class='font4'> Other connections (to do)</font>
		</td>	
	</tr>		
	</table>
</div>
</body>
</html>

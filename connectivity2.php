<?php
  include ("permission_check.php");
?>
<?php
require_once('class/class.type.php');
require_once('class/class.property.php');
require_once('class/class.evidencepropertyyperel.php');
require_once('class/class.epdataevidencerel.php');
require_once('class/class.epdata.php');

$type = new type($class_type);
$type -> retrive_id();
$number_type = $type->getNumber_type();

$property = new property($class_property);

$evidencepropertyyperel = new evidencepropertyyperel($class_evidence_property_type_rel);

$column = '170px';

$width_table = ($number_type * 190)+170;
$width_table1 = $width_table.'px';



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<script language="JavaScript">

function apri(url, w, h) {
var windowprops = "width=" + w + ",height=" + h;
popup = window.open(url,'remote',windowprops);
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link rel='stylesheet' type='text/css' href='style/style.css'>
</head>

<body>


<table width="<?php print $width_table1; ?>" border="1" cellspacing="1" cellpadding="0">
  <tr>
	<td width="190px" align="center">
	</td>
	
	<?php
		for ($i=0; $i<$number_type; $i++)
		{
			// retrieve the id_type from Type
			$id_type = $type->getID_array($i);
			$type -> retrive_by_id($id_type);
			$nickname_type = $type->getNickname();
			
			$nickname_type = str_replace('_', ' ', $nickname_type);
		
			print ("<td width='$column' bgcolor='#E0FFFF' align='center'>");
			print ("<font class='font5'>$nickname_type</font>");	
			print ("</td>");
		}
	?>
	</tr>
</table>

<table width="<?php print $width_table1; ?>" border="1" cellspacing="1" cellpadding="0">

		<?php
		// SCRIPT to retrieve POTENTIAL POSTSYNAPTIC CONNECTIONS: ************************************************************************
		// *******************************************************************************************************************************

		
			
			for ($i9=0; $i9<$number_type; $i9++) //$number_type
			{
				$n_connection = 0;
			
						$id_type = $type->getID_array($i9);
						$id = $id_type;
						$type->retrive_by_id($id_type);
												
						$nickname_type = $type->getNickname(0);
							
						// retrive propertytyperel.property_id By type.id 
						$evidencepropertyyperel -> retrive_Property_id_by_Type_id($id_type);
					
						$n = $evidencepropertyyperel -> getN_Property_id();

						$q=0;
						for ($i5=0; $i5<$n; $i5++)
							$property_id[$i5] = $evidencepropertyyperel -> getProperty_id_array($i5);
						
						for ($i=0; $i<$n; $i++)
						{
							$property -> retrive_by_id($property_id[$i]);
							$part = $property -> getPart();
							if ($part == 'dendrites')
							{		
								$val = $property -> getVal();
								$rel = $property -> getRel();
				
								if ($rel == 'in')
								{
				
									$property -> retrive_ID(1, 'axons', $rel, $val);
									$n_prop = $property -> getNumber_type();
									
									for ($ii=0; $ii<$n_prop; $ii++)
									{
										$property_id2 = $property -> getProperty_id($ii);
										$evidencepropertyyperel -> retrive_Type_id_by_Property_id($property_id2);
										$number_type_id = $evidencepropertyyperel -> getN_Type_id();
				
										for ($ii2=0; $ii2<$number_type_id; $ii2++)
										{
											$id_type = $evidencepropertyyperel -> getType_id_array($ii2);
											
											if ($id_type == $id);
											else
											{
												$type -> retrive_by_id($id_type);
												$nick_name1= $type -> getNickname();
												$status = $type -> getStatus();
												
												if ($status == 'active')
												{
													$postsynaptic[$i9][$n_connection] = $nick_name1;
													
													$n_connection = $n_connection + 1;					
												}
												else;											
											}

										}	
																	
									}
									
								}	
								else;
									
										
							}
							else;
								
						}	
					$n_conn[$nickname_type] = $n_connection;
										
			}		
									
		// *******************************************************************************************************************************
		// *******************************************************************************************************************************			
		?>

<?php
	for ($i=0; $i<$number_type; $i++) //$number_type
	{
	// retrieve the id_type from Type
	$id_type = $type->getID_array($i);
	$type -> retrive_by_id($id_type);
	$nickname_type = $type->getNickname();

	$nickname_type2 = str_replace('_', ' ', $nickname_type);
		
		print ("
			<tr>
				<td width='190px' align='center' bgcolor='#E0FFFF'>
					<font class='font5'>$nickname_type2</font>
				</td>
		");

		for ($i1=0; $i1<$number_type; $i1++) //$number_type
		{
			$id_type1 = $type->getID_array($i1);
			$type -> retrive_by_id($id_type1);
			$nickname_type1 = $type->getNickname();	
		
		
			
			$nnn = $n_conn[$nickname_type];
		
			for ($i2=0; $i2<$nnn; $i2++)
			{
				$post=$postsynaptic[$i][$i2];

				if ($nickname_type1 == $postsynaptic[$i][$i2])
				{
					$flag = 1;
					break;
				}	
				else
					$flag = 0;		
			
			}

			if ($flag == 1)
			{
				$type -> retrive_name_by_nickname($nickname_type1); 
				$name = $type -> getName(); 
			
				if ( strpos($name, '(+)') )
				{
					print ("<td width='$column' align='center' bgcolor='#000000'>");
					print ("<a href=\"JavaScript:apri('info_connectivity.php?type_post=E&main=$nickname_type&connection=$nickname_type1','500','500');\">
					<img src='images/connectivity/black.png' /></a>");
				}
				if ( strpos($name, '(-)') )
				{
					print ("<td width='$column' align='center' bgcolor='#999999'>");			
					print ("<a href=\"JavaScript:apri('info_connectivity.php?type_post=I&main=$nickname_type&connection=$nickname_type1','500','500');\">
					<img src='images/connectivity/grey.png' /></a>");		
				}
			
			}
			else
				print ("<td width='$column' align='center'>");
									
			print ("</td>");		
		}
		print ("<tr>");
}

?>
</table>
	

</body>
</html>

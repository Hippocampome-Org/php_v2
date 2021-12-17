<!--  <%@LANGUAGE="JAVASCRIPT" CODEPAGE="1252"%> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html" />
<title></title>
</head>

<body>
	<!--
		Note: <?php echo $menuaddr ?> is present below to fix subdirectory relative links.
	-->
<div class='main_bar'>
	<div class='hippocampo_immage'>
		<script type="text/javascript">
		if ((w == 1280) && (h == 1024))
		{
			 document.write("<a href='<?php echo $menuaddr ?>index.php'><img src='<?php echo $menuaddr ?>images/hippo_title.gif' height='70px' border=0/></a>");
		}
		else if ((w == 1152) && (h == 864))
		{
			  document.write("<a href='<?php echo $menuaddr ?>index.php'><img src='<?php echo $menuaddr ?>images/hippo_title.gif' height='70px' border=0/></a>");
		}	
		else if ((w == 1024) && (h == 768))
		{
			  document.write("<a href='<?php echo $menuaddr ?>index.php'><img src='<?php echo $menuaddr ?>images/hippo_title.gif' height='70px' border=0/></a>");
		}			
		else
		{
			 document.write("<a href='<?php echo $menuaddr ?>index.php'><img src='<?php echo $menuaddr ?>images/hippo_title1.gif' height='70px' border=0/></a>");
		}
		</script>
	</div>
</div>
</body>
</html>

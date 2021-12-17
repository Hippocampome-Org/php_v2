<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>

<meta http-equiv="Content-Type" content="text/html" />
<script type="text/javascript" src="style/resolution.js"></script>
<link rel="stylesheet" href="function/menu_support_files/menu_main_style.css" type="text/css" />
<script src="jqGrid-4/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<title id="title_id">Firing Pattern Evidence Image</title>
<style type="text/css">
div{
   width: 1200px;
   height:550px;
 }

img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    }
</style>
</head>

<body>


	<?php
	$image="";
	print("<div>");
	if ($_REQUEST['image'])
	{
		$image=$_REQUEST['image'];
		print("<img title='$image' src='attachment/fp/$image' alt='Image Missing' /><p>");
		$query_to_get_types = "SELECT t.id,t.name,t.nickname FROM FiringPatternRel fpr, Type t
			WHERE SUBSTR(fpr.original_id,5,length(fpr.original_id))=(
				SELECT DISTINCT substr(a.original_id,5,length(a.original_id)) 
				FROM Attachment a
				WHERE a.name like '$image'
				)
			AND t.id=fpr.Type_id";
		$rs_types = mysqli_query($GLOBALS['conn'],$query_to_get_types);
		$index=1;
		while(list($type_id,$type_name,$type_nick) = mysqli_fetch_row($rs_types))	{		
			print("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$index) <a title='$type_nick' href='neuron_page.php?id=$type_id' target='_blank'>$type_name</a><br>");
			$index++;
		}
	}
	else{
		print("<img src='$image' alt='Image Missing' />");
	}
	print("</div>");
	?>
</body>

</html>

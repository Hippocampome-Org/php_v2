<?php
	include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>
<title>User Feedback Form</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>
<body>
<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
<div class='title_area'>
	<font class="font1">User Feedback Form</font>
</div>	
<div class="table_position_search_page">
	<table width="95%" border="0" cellspacing="5" cellpadding="0" class='body_table'>
		<tr>
			<td width="80%">
				<!-- ****************  BODY **************** -->
				<br />
				<?php
					print ("<form action='user_feedback_send_email.php' method='post' style='display:inline'>	");

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%' ></td>
						<td width='80%' align='center' bgcolor='#CBDFE1'>
							<font class='font2'>
								Please use the form below to submit feedback to the Hippocampome staff.
								Please try to include an informative subject line such as error report,
								favorite feature, missing feature, missing article, etc.
							 </font>
						</td>
						<td width='10%' ></td>
					");
					print ("</tr>");
					print ("</table>");	

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%'></td>
						<td width='10%' align='right' class='table_neuron_page4'> SUBJECT </td>
						<td width='70%' align='left' class='table_neuron_page4'>
							<input type='text' name='subject_send' value='' size='92'>
						</td>
						<td width='10%'></td>
					");
					print ("</tr>");				
					print ("</table>");			

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%'></td>
						<td width='10%' align='right' class='table_neuron_page4'> NAME </td>
						<td width='70%' align='left' class='table_neuron_page4'>
							<input type='text' name='name_send' value='' size='60'>
						</td>
						<td width='10%'></td>
					");
					print ("</tr>");				
					print ("</table>");			

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%'></td>
						<td width='10%' align='right' class='table_neuron_page4'> INSTITUTE </td>
						<td width='70%' align='left' class='table_neuron_page4'>
							<input type='text' name='institute_send' value='' size='60'>
						</td>
						<td width='10%'></td>
					");
					print ("</tr>");				
					print ("</table>");			

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%'></td>
						<td width='10%' align='right' class='table_neuron_page4'> EMAIL </td>
						<td width='70%' align='left' class='table_neuron_page4'>
							<input type='text' name='email_send' value='' size='60'>
						</td>
						<td width='10%'></td>
					");
					print ("</tr>");				
					print ("</table>");			

					print ("<table border='0' cellspacing='2' cellpadding='0' class='table_result'>");
					print ("<tr>");
					print ("<td width='10%'></td>
						<td width='10%' align='right' class='table_neuron_page4'> MESSAGE </td>
						<td width='70%' align='left' class='table_neuron_page4'>
							<textarea rows='10' cols='70' name='message_send'></textarea>
						</td>
						<td width='10%'></td>
					");
					print ("</tr>");				
					print ("</table>");			

					print ("<br>
						<table border='0' cellspacing='2' cellpadding='0' class='table_result'>
						<tr>	
							<td width='100%' align='center'>
							<input type='submit' name='send_email' value=' SEND '>
							</form>
							</td>
						</tr>
						</table>
						<br><br>	
					");
				?>
			</td>
		</tr>
	</table>
</div>	
</body>
</html>

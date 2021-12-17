<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$gmdatetimenice = gmdate('Y-m-d H:i');
	$gmdatetimestamp = gmdate('YmdHi');

	$subject_send   = $_REQUEST['subject_send'];
	$name_send      = $_REQUEST['name_send'];
	$institute_send = $_REQUEST['institute_send'];
	$email_send     = $_REQUEST['email_send'];
	$message_send   = $_REQUEST['message_send'];

	// Check if the user email is valid:
	$pos = strpos($email_send, '@');
	if ($pos == NULL)
	{
		$error = 1;
	}
	else
	{
		$from_user = $email_send; 
		$to = "hippocampome.org@gmail.com"; 
		$subject = "Hippocampome.org - User Feedback " . $gmdatetimestamp;
	
		$mess_text="
				User Feedback $gmdatetimestamp \n
				Date/Time(UTC): $gmdatetimenice \n
				Subject: $subject_send \n
				Name: $name_send \n
				Institute: $institute_send \n
				Email user: $from_user \n
				Message: $message_send \n
		";
	
		require 'class/class.phpmailer.php';
		$mail = new PHPMailer;
		$mail->Username = 'hippocampome.org@gmail.com';
		$mail->Password = 'NeuroHipp2010';
		$mail->From = 'hippocampome.org';
		$mail->FromName = 'Portal User ' . $email_send;
		$mail->Subject = $subject;
		$mail->AddAddress($to);//to:email address
		$mail->Body = $mess_text;
		$mail->send();
	}
?>
<%@LANGUAGE="JAVASCRIPT" CODEPAGE="1252"%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Google Analytics Tracking -->  
<?php include_once("analytics.php") ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User Feedback Send Email</title>
<script type="text/javascript" src="style/resolution.js"></script>
</head>
<body>
<!-- COPY IN ALL PAGES -->
<?php include ("function/title.php"); ?>
<div align="center">
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
		if ($error == 1)
			print ("<font face='Verdana, Arial, Helvetica, sans-serif' color='red' size='4'>Email address not valid</font>");
		else
			print ("<font face='Verdana, Arial, Helvetica, sans-serif' color='red' size='4'>Your information was sent successfully. Thanks</font>");
	?>
	<br /><br />
</div>
</body>
</html>

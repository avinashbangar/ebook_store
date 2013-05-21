<?php 
	session_start();
	require 'connect.php';
	require 'validation.php';
	require 'mail.php';
	
	if($_POST)
	{
		$email = $_POST['email'];
		//first we check if the email exists in our database
		if (CheckEmail($email))
		{
			sendmail($email);
		}else{
			alert('There is no such mail in our database');
		}
	}
?>
<html>
<head>
	<title> Ebook Store</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="content">	
	<p class="title">Welcome to Online Ebook Store</p>
	<table>
		<p style="color:blue;" class="paragraph">Password recovery:
		<p class="paragraph">Please give us your mail to send you a password changing ticket</p>
	</table>
	<form action="recovery.php" method="POST" class="form">
		<table>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" id="f1">
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr><td>&nbsp;</td>
				<td><input type="submit" name="Send" value="Send it!"></td>
			</tr>
		</table>
	</form>
	</div>
</body>
</html>
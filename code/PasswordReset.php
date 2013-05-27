<?php 
	require 'connect.php';
	require 'validation.php';
	require 'mail.php';
	
	if($_POST)
	{
		$email = $_POST['email'];
		$resetTicket = $_POST['resetTicket'];
		$newPassword = $_POST['newPassword'];
		$newPasswordBis = $_POST['newPassword2'];
		
		if ($newPassword != $newPasswordBis)
		{
			alert('The passwords do not match. Please try it again');
		}else
		{
			//first we check if the email exists in our database
			if (CheckEmail($email))
			{
				//we now check that the ticket is in the database, that it corresponds to that address and that the ticket has not expired
				if(CheckTicket($email,$resetTicket))
				{
					//After the ticket has been verified we update the password on the given user.
					//$hashedValue = GenerateHashedString($newPassword);
					$hashedValue = hash('sha512', $newPassword);
					UpdatePassword($hashedValue, $email);
				}
				else {
					alert('There seems to be some problem with your ticket. Please try again or if the problem persists obtain a new ticket.');
				}
			}else{
				alert('There is no such mail in our database');
			}
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
	<p class="title">Did you lost your password? Don't worry! You can reset it here.</p>
	<table>
		<p style="color:blue;" class="paragraph">Password reset:
		<p class="paragraph">Please fill out these fields to reset your password</p>
	</table>
	<form action="PasswordReset.php" method="POST" class="form">
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
			<tr>
				<td>Reset ticket</td>
				<td><input type="text" name="resetTicket" id="f2">
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr>
				<td>New password</td>
				<td><input type="password" name="newPassword" id="f3">
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr>
				<td>Please reintroduce the new password</td>
				<td><input type="password" name="newPassword2" id="f4">
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
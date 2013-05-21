 <?php
 
 	function GenerateRandomString()
	{
		$length = 15;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		return $randomString;
	}
	
	function GenerateHashedString($input)
	{
		//Generates the hashed value of a string and returns its value
		//$6 --> Algorithm prefix
		//$rounds --> nº of times the algorithm is going to be looping
		//$SillyString -->string used for encryption.
		$hashed = crypt($input,'$6$rounds=8000$Pikachu3Dabai4$');
		
		//this will return the generated key
		return substr($hashed,30);
	}
	
	function UpdatePassword($hashedValue, $address)
	{
		$stmt = $con->prepare("UPDATE user SET password=? WHERE email=".$address);
		//bind parameters for email and password
		$stmt->bind_param("s", $hashedValue);
		
		//execute the query
		 if(false == $stmt->execute()) {
		 	printf("Unable to update password");
		 }
		 else {
			 //bind result variable
			 $stmt->bind_result($id);
			 $stmt->close();
		}
	}
	
	
 	function sendMail($address)
	{
		$ticket = GenerateRandomString();

		//We send the mail
		require("./phpMailer/class.phpmailer.php"); // path to the PHPMailer class
		$mail = new PHPMailer();  
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->Mailer = "smtp";
		$mail->Host = "ssl://smtp.gmail.com";
		$mail->SMTPSecure = "ssl";
		$mail->Port = 465;
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = "lareostia@gmail.com"; // SMTP username
		$mail->Password = "Tracasa06"; // SMTP password 
		$mail->From     = "lareostia@gmail.com";
		$mail->AddAddress($address);  
		 
		$mail->Subject  = "First PHPMailer Message";
		$mail->Body     = "Hi! \n\n This is your validation string to reset your password: ".$ticket.".";
		$mail->WordWrap = 50;  
		 
		if(!$mail->Send()) {
			alert('Message was not sent.');
			alert('Mailer error: ' . $mail->ErrorInfo);
		} else {
			alert('Message has been sent.');
			//We store the hashed value on the database
			updatePassword(GenerateHashedString($ticket),$address);
		}
	}
?> 

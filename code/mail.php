 <?php
	require 'connect.php';
	require 'Utility.php';
	
/* 	function GenerateRandomString()
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
	}*/
	
	function UpdatePassword($hashedValue, $address)
	{
		$con=mysqli_connect("localhost","root","maha2013","ebook_store");
		$stmt = $con->prepare("UPDATE user SET password=?, pwd_timeStamp=CURRENT_TIMESTAMP() WHERE email=?");
		//bind parameters for email and password
		$stmt->bind_param("ss", $hashedValue, $address);
		
		//execute the query
		 if(false == $stmt->execute()) {
		 	printf("Unable to update password");
			 $stmt->close();
		 }
		 else {
			 //bind result variable
			 $stmt->bind_result($id);
			 $stmt->close();
		}
	}
	
	
	function CheckTicket($email,$resetTicket)
	{
		$con=mysqli_connect("localhost","root","maha2013","ebook_store");
		//This function will return true if the email exists in the database, the password assigned to that mail is
		//the hash function of the ticket and that the ticket has not yet expired. It will return false otherwise.
		$hashedValue = GenerateHashedString($resetTicket);
		//Expiration for the ticket: 30 minutes
		$stmt = $con->prepare("SELECT id FROM user WHERE email=? AND password=? AND CURRENT_TIMESTAMP() < DATE_ADD(pwd_timestamp, INTERVAL 30 MINUTE)");
		//bind parameters for email and password
		$stmt->bind_param("ss", $email, $hashedValue);
		
		//execute the query
		 $stmt->execute();
		 if(1==$stmt->num_rows()) {
		 	
			//There is a user with such an email, password and in the correct timestamp
			return true;
			$stmt->close();
		 }
		 else {
		 	//wait for 5 seconds to prevent brute force/guessing attacks
		 	 sleep(5);
			 return false;
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
		$mail->CharSet="UTF-8";
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPDebug  = 2;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = "lareostia@gmail.com"; // SMTP username
		$mail->Password = "fltqyjjkquqjtmpk"; // SMTP password 
		$mail->From     = "lareostia@gmail.com";
		$mail->AddAddress($address);  
		 
		$mail->Subject  = "First PHPMailer Message";
		
		////////////////          UPDATE ADDRESS!!!   //////////////////
		$mail->Body     = "Hi! \n\n This is your validation ticket to reset your password: ".$ticket.".\n\n You can reset your password with this ticket in the address http://54.214.242.33/ebook_store/code/PasswordReset.php";
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

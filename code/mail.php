 <?php
 	function sendMail($address)
	{
		echo "entrance mail";
		require("./phpMailer/class.phpmailer.php"); // path to the PHPMailer class
		echo "gets require";
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
		$mail->AddAddress("speleato@gmail.com");  
		 
		$mail->Subject  = "First PHPMailer Message";
		$mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
		$mail->WordWrap = 50;  
		 
		if(!$mail->Send()) {
			echo 'Message was not sent.';
			echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent.';
		}
	}

		/*$myemail = "admin@scu-ecommerce.dx.am"; //Caution: replace youremail@yourdomain.com with a vaild one you created in Email Manager 
		$subject = "Password recovery";
		$name = 'Ecommerce admin';
		$email = $address;
		$message = "This is a test message";
		$headers = "From:Contact Form <admin@scu-ecommerce.dx.am>\r\n";
		$headers .= "Reply-To: Admin <admin@scu-ecommerce.dx.am>\r\n";
		alert("Your message has been sent successfully! (process in development, not really working)");
		mail($myemail, $subject, $message, $headers);*/
	
	 /* include('phpMailer/class.phpmailer.php');
		 include('phpMailer/class.smtp.php');
		 $mail = new PHPMailer();
		 $mail->IsSMTP();
		 $mail->SMTPAuth = true;
		 $mail->SMTPSecure = 'ssl';
		 $mail->Host = 'mail.scu-ecommerce.dx.am/';
		 $mail->Port = 220;
		 $mail->Username = 'admin@scu-ecommerce.dx.am';
		 $mail->Password = 'Ecommerce1';
		 $mail->From = 'admin@scu-ecommerce.dx.am';
		 $mail->FromName = 'Admin Ecommerce';
		 $mail->Subject = 'testEmail';
		 $mail->AltBody = 'This is a test mail';
		 $mail->MsgHTML('This is a test mail');
		 //$mail->AddAttachment('files/files.zip');
		 //$mail->AddAttachment('files/img03.jpg');
		 $mail->AddAddress('speleato@gmail.com', 'Destinatario');
		 $mail->IsHTML(true);
		 if(!$mail->Send()) {
		 echo 'Error: ' . $mail->ErrorInfo;
		 } else {
		 echo 'Mensaje enviado correctamente';
		 }*/
?> 

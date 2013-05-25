<?php
session_start();
require 'connect.php';

if ($_POST)
{
	$email = $_POST['email'];
	$pass = $_POST['password'];
	//create a prepared statement
	if ($stmt = $con->prepare("SELECT id FROM user WHERE email=? and password=?")) {
		//bind parameters for email and password. bind password after encryption
		$encryptedPassword = hash('sha512', $pass);
		$stmt->bind_param("ss", $email, $encryptedPassword);
		
		//execute the query
		 if(false == $stmt->execute()) {
		 	printf("Unable to validate login");
		 }
		 else {
			 //bind result variable
			 $stmt->bind_result($id);
					  
			 if($stmt->fetch()) {
				$_SESSION['cuser'] = $email;
				$_SESSION['cuserid'] = $id;
				header('Location:home.php');
			 } 
			 else{
				printf("No rows found! \n");
				printf("Incorrect email/password");
			}
			$stmt->close();
		}
	}
	else{
		echo "Unable to validate login";
	}
}
?>
<html>
<head>
	<title> Ebook Store</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
	<script type="text/javascript">
		function alert(Input)
		{
			window.alert(Input);
		}
	</script>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
	<div class="content">	
		<p class="title">Welcome to Online Ebook Store</p>
		<a href="registration.php" class="title">Sign Up!</a>
			<form action="index.php" method="POST" class="form">
				<table class="table">
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
						<td>Password</td>
						<td><input type="password" name="password" id="f2" >
							<script type="text/javascript">
				         	var f2 = new LiveValidation('f2');
				           	f2.add(Validate.Presence);
				     		</script>							
						</td>
					</tr>
					<tr><td>&nbsp;</td>
						<td><input type="submit" name="Login" value="Login"></td>
					</tr>
				</table>
				<table>
					<tr>
						<td>
							<a href="recovery.php">Forgot your password?</a>
						</td>
					</tr>
				</table>
			</form>
	</div>
</body>
</html>



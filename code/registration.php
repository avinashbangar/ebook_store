<?php 
	require 'connect.php';
	
	function isPasswordStrong($password) {
	   $upper = false;
	   $numbers = false; 
	   $symbols = false;
	   $greaterThan8 = false;
	   
	   if(strlen($password) > 8) {
	   	$greaterThan8 = true;
	   }
			
	   for($i = 0; $i < strlen($password); $i++) {
			$c = $password[$i];
			if(!$upper && (strrpos('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $c) != false)) {
				$upper = true;
			}
			else if(!$numbers && (strrpos('0123456789', $c) != false)) {
				$numbers = true;
			}
			else if(!$symbols && (strrpos('!@#$%^&*()', $c) != false)) {
				$symbols = true;
			}
		}
					
		return ($upper && $numbers && $symbols && $greaterThan8);
	}

	$validationFailed = false;
	$validationMsg = "";
	
	if($_POST){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passworBis = $_POST['password2'];

		// Sanitizing user inputs to encode html special characters to avoid xss attacks 
		$fname = htmlspecialchars($fname);
		$lname = htmlspecialchars($lname);
		$email = htmlspecialchars($email);
		$password = htmlspecialchars($password);
		$passworBis = htmlspecialchars($passworBis);

		$stmt = $con->prepare("select * from user where email =?");
		$stmt->bind_param("s",$email);
		$stmt->execute();
		if($stmt->fetch())
		{
			$validationFailed = true;
			$validationMsg = 'You are already registered';
		}
		else if ($password == $passworBis){
			if(isPasswordStrong($password))
			{
				 //create a prepared statement;
  				$stmt = $con->prepare("insert into user(first_name,last_name, email, password) values (?,?,?,?)");
    			//bind parameters for email and password;

    			$stmt->bind_param("ssss", $fname, $lname, $email, $password);
    
    			//execute the query;
     			$stmt->execute(); 
	       		header('Location:home.php');
 				$stmt->close();
 			}
 			else 
 			{
 				$validationFailed = true;
 				$validationMsg = 'Password not strong enough: Please ensure that the password is atleast 8 characters long 
 						and has an upper case, a number and one of these special characters:
 						!@#$%^&*()';
 			}
		}
		else{
			$validationFailed = true;
			$validationMsg = 'Your passwords do not match. Please re-type them.';
		}

	}
	
?>
<html>
<head>
	<title>Registration</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<div class="content">				
			<a href="index.php" class="title">Login</a>	
			
<?php
	if($validationFailed) {
		echo '<div class="errorContent">' .  $validationMsg . '</div>';
	}
?>
			<form action="registration.php" method="POST" class="form">
				<table>
					<tr>
						<td>&nbsp;</td>
						<td>Registration Details</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" name="fname" id="f1">
							<script type="text/javascript">
		         			var f1 = new LiveValidation('f1');
		           			f1.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="lname" id="f2">
							<script type="text/javascript">
		         			var f2 = new LiveValidation('f2');
		           			f2.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="email" id="f3">
							<script type="text/javascript">
		         			var f3 = new LiveValidation('f3');
		           			f3.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="password" id="f4">
							<script type="text/javascript">
		         			var f4 = new LiveValidation('f4');
		           			f4.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Re-type the password</td>
						<td><input type="password" name="password2" id="f4">
							<script type="text/javascript">
		         			var f4 = new LiveValidation('f4');
		           			f4.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="Register" value="Register"></td>
					</tr>
				</table>
			</form>
		</div>	
</body>
</html>

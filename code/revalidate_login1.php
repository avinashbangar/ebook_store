<?php
	require 'session.php';
	require 'connect.php';
	
if($_GET)
{
	$isbn = $_GET['isbn'];
	if ($stmt = $con->prepare("SELECT title FROM book WHERE isbn=?")) {
		$stmt->bind_param("i", $isbn);
		 if(false == $stmt->execute()) {
		 	printf("Error");
		 }		
		 else {
			 //bind result variable
			 $stmt->bind_result($title);
			 if($stmt->fetch())
			 {
			    $_SESSION['isbn'] = $isbn; 
			 }
			 else
			 {
			    printf("Book does not exists");
			 }
			 $stmt->close();
	}
	
}}
	
if ($_POST)
{
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$username=$_POST['email'];

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
				header("Location: buy.php");
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
	<title>Re-login page!</title>
	<link href="Styles/Revalidate_login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p><a class="paragraph" href="home.php">Home</a></p>
	<p><a class="paragraph" href="logout.php">Logout</a></p>
	<div class="content">	
		<?php
			echo"<p class='paragraph'>Please provide your password again for re-validation.</p>";
		?>
		<form action="revalidate_login1.php" method="POST" class="form">
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
				</form>
				</div>
				</body>
				
				</html>
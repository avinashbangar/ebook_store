<?php
	require 'session.php';
	require 'connect.php';
	
	
if ($_POST)
{
	$email = $_POST['email'];
	$pass = $_POST['password'];
	//$isbn = $_POST['isbn'];
	$username=$_POST['email'];

	//create a prepared statement
	if ($stmt = $con->prepare("SELECT id FROM user WHERE email=? and password=?")) {
		//bind parameters for email and password
		$stmt->bind_param("ss", $email, $pass);
		
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
				$isbn = $_SESSION['isbn'];
				//header("Location:buy1.php?isbn=".$isbn."");
				header("Location:buy1.php");
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
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a href="home.php">Home</a>
	<a href="logout.php">Logout</a>
	<div class="body">	
		<?php
			echo "<p class='title'>Welcome ".$_SESSION['cuser']."!</p>";
			echo"<p>Please provide your password again for re-validation.</p>";
			// echo "<p class='title'>".$_GET['isbn']."</p>";
			 echo $_GET['isbn']; echo "Hi";
		?>
		<form action="revalidate_login.php" method="POST" class="form">
				<table class="table">
					<tr>
						<td>Email</td>
						<td><input type="text" value="<?php echo $_SESSION['cuser']?>" name="email" id="f1">
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
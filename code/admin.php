<?php

require 'connect.php';
session_start();

if ($_POST)
{

	$username = $_POST['username'];
	$pass = $_POST['password'];
	
	
	// $result = mysqli_query($con,"SELECT * FROM admin WHERE username='" .$username."' and password='" .$pass. "'");
// 	
// 	if($result){
// 
// 		$_SESSION['user'] = $username;
// 		header('Location:admin_home.php');
// 		
// 	}else{
// 		
// 		echo "Incorrect username/password, Please try again";
// 		
// 	}
	
	$stmt=$con->prepare("select id from admin where username=? and password=?");
	$stmt->bind_param("ss",$username,$pass);
	$stmt->execute();
	$row = $stmt->fetch();
	if($row==1)
	{
		$_SESSION['user'] = $username;
		header('Location:admin_home.php');
		}
		else{
		echo "Incorrect username/password, please try again";
		}
	$stmt->close();

}
?>

<html>
<head>
	<title> Ebook Store</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
	<div align="center">	
	<p>Welcome to Admin Login Page</p>
	<form action="admin.php" method="POST">
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" id="f1">
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" id="f2">
					<script type="text/javascript">
		         	var f2 = new LiveValidation('f2');
		           	f2.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr><td>&nbsp;</td>
				<td><input type="submit" name="Login"></td>
			</tr>
		</table>
	</form>
	</div>
</body>
</html>


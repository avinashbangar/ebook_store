<?php 
	session_start(); 
	require 'connect.php';

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}

	if($_POST){
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		
		
		$stmt = $con->prepare("select * from author where first_name=? and last_name=?");
		$stmt->bind_param("ss",$fname,$lname);
		$stmt->execute();
		if($stmt->fetch()){
		echo "Author already added to the database!";
			}
		
		else{
	
		$stmt->close();
		$stmt1 = $con->prepare("insert into author(first_name, last_name) values(?,?)");
		$stmt1->bind_param("ss", $fname, $lname);
		
		 if($stmt1->execute()){
 		header('Location:list.php?param=author');
 		}
 		else{
 		echo "Could not add the author, please try again!";
 		}
         $stmt1->close();
		}
	}
	
?>
<html>
<head>
	<title>Admin Home!</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
		<a href="admin_home.php">Home</a>
		<div align="center">	
			<p>Add Author</p>

			<form action="add_author.php" method="POST">
				<table>
					<tr>
						<td></td>
						<td>Details</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" id="f1" name="fname">
							<script type="text/javascript">
		            		var f1 = new LiveValidation('f1');
		            		f1.add(Validate.Presence);
		          			</script>
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" id="f2" name="lname">
							<script type="text/javascript">
		            		var f2 = new LiveValidation('f2');
		            		f2.add(Validate.Presence);
		          			</script>							

						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="Add"></td>
					</tr>
				</table>
			</form>
		</div>	
</body>
</html>

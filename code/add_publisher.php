<?php 
	session_start(); 
	require 'connect.php';

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}

	if($_POST){
		$name = $_POST['name'];
		$stmt = $con->prepare("select * from publisher where name=?");
		$stmt->bind_param("s",$name);
		$stmt->execute();
		if($stmt->fetch()){
		echo "Publisher already added to the database!";
		}
		else
		{
		$stmt->close();
		$stmt1 = $con->prepare("insert into publisher(name) values (?)");
		$stmt1->bind_param("s", $name);
		
		 if($stmt1->execute()){
 		header('Location:list.php?param=publisher');
 		}
 		else{
 		echo "Could not add the publisher, please try again!";
 		}
         $stmt1->close();
		}
		
		
		
	// 	$result = mysqli_query($con,"SELECT * FROM publisher WHERE name = '$name'");
// 		if($result->num_rows == 1){
// 			echo "Publisher already added to database!";
// 
// 		}else{
// 			$sql = "INSERT INTO publisher( name) VALUES ('$name')";
// 			if( !mysqli_query($con,$sql) ){
// 				echo " ". mysqli_error();
// 				die( 'Error: '. mysqli_error() );
// 			}else{
// 				header('Location:list.php?param=publisher');
// 			}
// 		}
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
			<p>Add Publisher</p>
			<form action="add_publisher.php" method="POST">
				<table>
					<th>
						<td>Publisher</td>
					</th>
					<tr>
						<td>Name</td>
						<td><input type="text" id="f1" name="name">
							<script type="text/javascript">
		            		var f1 = new LiveValidation('f1');
		            		f1.add(Validate.Presence);
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

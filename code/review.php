<?php 
	require 'session.php';
	require 'connect.php';


?>
<html>
<head>
	<title>Buy Ebook</title>
</head>
<body>
	<a href="home.php">Home</a>
	<a href="logout.php">Logout</a>
<div align="center">	

<?php

	if($_GET){
		$user_id = $_SESSION['cuserid'];
		$isbn = $_GET['isbn'];

		$result = mysqli_query($con,"select title FROM book WHERE isbn = '$isbn' ");
		
		if($result){
			$reviews = mysqli_query($con,"SELECT review FROM reviews WHERE book_isbn = '$isbn'");
		}	
		else{
			die("Error ".mysqli_error($con));
		}

	}

?>
	<a href="add_review.php?isbn=<?php echo $_GET['isbn']?>">Add Review</a>
	<table border="1">
			<tr>
				<td>Title</td>
				<td><?php if($result){
							while($rw = mysqli_fetch_array($result)){
								echo $rw['title'];
							}
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Review</td>
				<td></td>
			</tr>
			<?php 
				
				if($reviews){
					while($row = mysqli_fetch_array($reviews)){
					?>
					<tr>
						<td></td>
						<td><?php echo $row['review'];?></td>
					</tr>
			<?php
				   } 
				}
			?>

	</table>


</div>	
</body>
</html>

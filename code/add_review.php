<?php 
	require 'session.php';
	require 'connect.php';

?>
<html>
<head>
	<title>Buy Ebook</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
	<a href="home.php">Home</a>
	<a href="logout.php">Logout</a>
<div align="center">	

<?php
	if($_POST){
		
		$user_id = $_SESSION['cuserid'];
		$isbn = $_POST['isbn'];
		$review = $_POST['review'];
		echo $isbn;
		echo $user_id;
		$result = mysqli_query($con,"insert into ebook_store.reviews (user_id, book_isbn, review) values ('$user_id','$isbn','$review')");
		
		if($result){
			
			header("Location:review.php?isbn=$isbn");
		}	
		else{
			die("Error ".mysqli_error($con));
		}

	}

?>


	<form action="add_review.php" method="POST">
		<input type="hidden" name="isbn" value="<?php echo $_GET['isbn']; ?>">
		<table border="1">
			<tr>
				<td>Review</td>
				<td>
					<textarea rows="10" cols="30" name="review" id="f1"></textarea>
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
		
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Submit"></td>
			</tr>
		</table>
	</form>

</div>	
</body>
</html>

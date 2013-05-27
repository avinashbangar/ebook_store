<?php 
	require 'session.php';
	require 'connect.php';
	require 'validation.php';

?>

<?php
if($_POST){
	$session = GenerateHashedString($_SESSION['id']);
	$str = "select user_id from session where id = '$session'";
	if($result = $con->query($str)) {
		if($row = $result->fetch_row()) {
			$isbn = $_POST['isbn'];
			//echo "isbn" . $isbn . "<BR>";
			$review = $_POST['review'];
			//echo "review:". $review . "<BR>";
			$user_id = $row[0];
			//echo "user_id:" . $user_id . "<BR>";
			// Sanitizing user input to encode html special characters to avoid xss attacks 
			$review = htmlspecialchars($review);
			$stmt=$con->prepare("insert into ebook_store.reviews(user_id,book_isbn,review) values(?,?,?)");
			$stmt->bind_param("sss",$user_id,$isbn,$review);
			if($stmt->execute()){
				//echo "Review added successfully!";
			}
			else{
				echo "The review for the book was not added, please try again";
				//echo mysqli_error($con);
			}
		}
		else {
			echo "You need to be logged in to add reviews";
		}
	}
	else {
		echo "The review for the book was not added, please try again";
		echo mysqli_error($con);
	}
}

?>

<html>
<head>
	<title>Buy Ebook</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
	<link href="Styles/add_review.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<p><a class="paragraph" href="home.php">Home</a></p>
	<p><a class="paragraph" href="logout.php">Logout</a></p>
<div class="body">	


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

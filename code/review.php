<?php 
	require 'session.php';
	require 'connect.php';


?>
<html>
<head>
	<title>Buy Ebook</title>
	<link href="Styles/review.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
	<p><a class="paragraph" href="home.php">Home</a></p>
	<p><a class="paragraph" href="logout.php">Logout</a></p>
<div class="content">	

<?php

	if($_GET){
		$user_id = $_SESSION['cuserid'];
		$isbn = $_GET['isbn'];
		
		
		//create a prepared statement
		if ($stmt = $con->prepare("Select title, review FROM book, reviews WHERE book.isbn = reviews.book_isbn AND
								   book.isbn = ?")) {
			//bind parameters for isbn
			$stmt->bind_param("i", $isbn);
			
			//execute the query
			 if(false == $stmt->execute()) {
				printf("Unable to execute query");
			 }
			 else {
				//bind result variable
				$stmt->bind_result($title, $review);
			}
		}
		else{
			printf("Unable to display review(s)! \n");
		}
	}

?>
	<p><a href="add_review.php?isbn=<?php echo $_GET['isbn']?>">Add Review</a></p>
	<table border="1">
			<tr>
				<td>Title</td>
				<td>
					<?php
						$rowExists = false;
						if($stmt->fetch()){
								echo $title;
								$rowExists = true;
						  }
					?>
				</td>
			</tr>
			<tr>
				<td>Reviews</td>
				<td></td>
			</tr>
			
			<?php 
				do {
						if($rowExists) {
			?>
							<tr>
								<td></td>
								<td><?php echo $review;?></td>
							</tr>
						
			<?php
						}
				   } while($stmt->fetch());

				$stmt->close();
			?>

	</table>


</div>	
</body>
</html>

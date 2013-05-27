<?php
	require 'session.php';
	require 'connect.php';

	if($_POST)
	{
		$search_str = $_POST['search_text'];	
		$success_flag = false;
		$query_template = "SELECT isbn,title,edition,publisher_id,price,coverpage,
								  author.id,author.first_name, author.last_name, 
								  publisher.name
								  FROM book, book_author, author, publisher 
								  WHERE book.isbn=book_author.book_isbn AND book_author.author_id=author.id AND book.publisher_id=publisher.id";
	
		if($_POST['option'] == 'isbn')
		{
			
			//create a prepared statement
			if ($stmt = $con->prepare($query_template . " AND book.isbn = ?"))
			{
				$success_flag = true;
				
				//bind parameters for isbn
				$stmt->bind_param("s", $search_str);
			}
	
		}
		else if($_POST['option'] == 'title')
		{
			//create a prepared statement
			if ($stmt = $con->prepare($query_template . " AND book.title LIKE CONCAT('%', ?, '%')"))
			{
				$success_flag = true;
				
				//bind parameters for title
				$stmt->bind_param("s", $search_str);
			}	
	
		}else if($_POST['option'] == 'author')
		{
			$search_arr = explode(" ",$search_str);
			if(count($search_arr) == 1){ 
				$search_arr[1] = '';
			}
			
			//create a prepared statement
			if ($stmt = $con->prepare($query_template . " AND (
																author.first_name LIKE CONCAT('%', ?, '%')  
																OR author.last_name LIKE CONCAT('%', ?, '%')
															   )"))
    		{
				
				$success_flag = true; 
				
				//bind parameters for title
				$stmt->bind_param("ss", $search_arr[0], $search_arr[0]);			
			}
		}else if($_POST['option'] == 'publisher'){
		
			//create a prepared statement
			if ($stmt = $con->prepare($query_template . " AND publisher.name LIKE CONCAT('%', ?, '%')"))
    		{
				$success_flag = true; 
				
				//bind parameter for publisher_id
				$stmt->bind_param("s", $search_str);
			}
		}
		
		if($success_flag == true)
		{				
			//execute the query
			if(false == $stmt->execute()) 
			{
				$success_flag = false;
			}
			else 
			{
				//bind result variables
				$stmt->bind_result($isbn, $title, $edition, $publisher_id, $price, $coverpage, 
									$author_id, $author_first_name, $author_last_name, $publisher_name);
			}
		}
	}

?>

<html>
<head>
	<title>Search for Ebooks!</title>
<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
		<div class="content">
			<a href="home.php">Ebooks List</a>
			<a href="logout.php">Logout</a>
			<p>Search for Ebooks</p>
			<form action="search.php" method="post">
				<input type="text" name="search_text">
				<select name="option">
					<option value="isbn">ISBN</option>
					<option value="title">Title</option>
					<option value="author">Author</option>
					<option value="publisher">Publisher</option>
				</select>
				<input type="submit" value="Search">
			</form>

	<?php if($_POST) { ?>


		    <table border="1">
				    
				    	<tr>
				    		<td><b>ISBN</b></td>
				    		<td><b>Title</b></td>
				    		<td><b>Edition</b></td>
				    		<td><b>Author</b></td>
				    		<td><b>Publisher</b></td>
				    		<td><b>Price</b></td>
				    		<td><b>CoverPage</b></td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    	</tr>
				    	
				    
					    <?php if($success_flag){
					    		while($stmt->fetch()){ 
						?>
								  <tr>
								  	<td><?php echo $isbn; ?></td>
								  	<td><?php echo $title; ?></td>
								  	<td><?php echo $edition; ?></td>
								  	<td>
								  		<?php 
								  				echo $author_first_name . " " . $author_last_name . "<br/> ";
								  		?>
								  	</td>
								  	<td>
								  		<?php 
								  				echo $publisher_name; 
								  		?>
								  	</td>
								  	<td>$<?php echo $price; ?></td>
								  	<td>
								  		<?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $coverpage) . '" heigh="92" width="42"/>'; ?>
								  	</td>
								  	<td><a href="review.php?isbn=<?php echo $isbn ?>">Review</a></td>
								  	<!-- <td><a href="buy.php?isbn=<?php echo $isbn ?>">Buy</a></td> -->
								  	<td><a href="add_to_cart.php?isbn=<?php echo $isbn?>">Add to cart</a></td>
								  </tr>
								<?php } //end while
								$stmt->close();
							} //end if ($success_flag)
							?>
    			
					</table>
	<?php } //end if($_POST)
	?>
		</div>



</body>
</html>


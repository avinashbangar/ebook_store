<?php
	require 'session.php';
	require 'connect.php';

?>
<html>
<head>
	<title>Welcome home!</title>
</head>
<body>
	<div align="center">	
		<?php

			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book");
			echo "Welcome ".$_SESSION['cuser']."!";
		?>
		<a href="logout.php">Logout</a>

				<p><b>Ebooks List</b></p>
				<p><a href="search.php">Search</a>
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
				    	
				    
					    <?php while($row = mysqli_fetch_array($result)){ 
						?>
							  <tr>
							  	<td><?php echo $row['isbn']; ?></td>
							  	<td><?php echo $row['title']; ?></td>
							  	<td><?php echo $row['edition']; ?></td>
							  	<td>
							  		<?php 
							  				$author_id_res = mysqli_query($con,"SELECT author_id FROM book_author WHERE book_isbn = " .$row['isbn']. "");
							  				$author_id_arr = array();
							  				while($author_row = mysqli_fetch_array($author_id_res)){
						  						array_push($author_id_arr,$author_row['author_id']);

							  				}
							  				
							  				$ids = join(',',$author_id_arr);  	
							  				$authors = mysqli_query($con,"SELECT first_name,last_name FROM author WHERE id IN ($ids)");
							  				while($author = mysqli_fetch_array($authors)){
							  					echo $author['first_name'] ." ".$author['last_name']."<br/> ";
							  				}

							  		?>
							  	</td>
							  	<td>
							  		<?php 
							  				$pub_res = mysqli_query($con,"SELECT name FROM publisher WHERE id = " .$row['publisher_id']. "");
							  				$pub_row = mysqli_fetch_array($pub_res);
							  				echo $pub_row['name']; 
							  		?>
							  	</td>
							  	<td>$<?php echo $row['price']; ?></td>
							  	<td>
							  		<?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?>
							  	</td>
							  	<td><a href="review.php?isbn=<?php echo $row['isbn']?>">Reviews</a></td>
							  	<td><a href="buy.php?isbn=<?php echo $row['isbn']?>">Buy</a></td>
							  </tr>
						<?php }?>
    			
					</table>
	</div>
</body>
</html>
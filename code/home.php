<?php
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';

?>
<html>
<head>
	<title>Welcome home!</title>
	<link href="Styles/Home.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="content">	
		<?php

			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book");
			$session = GenerateHashedString($_SESSION['id']);
			$str = "SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')";
			$userresult = mysqli_query($con,$str);
			$user = mysqli_fetch_array($userresult);
			echo "<p class='title'>Welcome ". $user['first_name'] ."!</p>";
		?>
		<a href="logout.php" class="paragraph_Center2">Logout</a>

				<p class="paragraph_Center"><b>Ebooks List</b></p>
				<p class="paragraph_Center"><a href="search.php" class="paragraph">Search</a>
				<a href="topdownloads.php" class="paragraph">Top Downloads</a>
				<a href="cart.php" class="paragraph">My Cart</a></p>
				    <table border="1" class="form">
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
							  	<!-- <td><a href="buy.php?isbn=<?php echo $row['isbn']?>">Buy</a></td> -->
							  	<td><a href="revalidate_login1.php?isbn=<?php echo $row['isbn']?>">Buy</a></td>
								<td><a href="add_to_cart.php?isbn=<?php echo $row['isbn']?>">Add to cart</a></td>
							  </tr>
						<?php }?>
    			
					</table>
	</div>
</body>
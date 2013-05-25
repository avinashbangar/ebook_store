<?php
	require 'session.php';
	require 'connect.php';

?>
	<a href="home.php">Home</a>
	<p>My cart</p>


		<?php
			$user_id = $_SESSION['cuserid'];
			$result = mysqli_query($con,"SELECT title,isbn,coverpage FROM book where isbn in (select book_isbn from cart where user_id = $user_id)");
			
			if($result->num_rows>0)
			{
			
		?>
		<table border=1 class=Form>
			<tr>
				<td>Coverpage</td>
				<td>Title</td>
				<td>Action</td>
			</tr>

		<?php	
			  while($row = mysqli_fetch_array($result)){ 
		?>
				<tr>
					<td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><a href="remove_cart.php?isbn=<?php echo $row['isbn']?>">Remove</a></td>
				</tr>
		<?php } ?>
		
		</table>
		<a href="buy1.php">Checkout</a>
		<?php	
		}
			else 
			{
					echo "Cart is Empty!!!...Add books to the cart";
			}	
		?>

	

<?php
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';

?>
	<a href="home.php">Home</a>
	<p>My cart</p>


		<?php
			$session = GenerateHashedString($_SESSION['id']);
			$res = mysqli_query($con,"Select user_id from session Where id = '$session'");
			$user = mysqli_fetch_array($res);
			$str = "SELECT title,isbn,coverpage FROM book where isbn in (select book_isbn from cart where user_id = ".$user['user_id'].")";
			$result = mysqli_query($con,$str);
			
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
						<!-- 
	<td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?></td>
						<td><?php echo $row['title']; ?></td>
						<td><a href="remove_cart.php?isbn=<?php echo $row['isbn']?>">Remove</a></td>
	 -->
	 <td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?></td>
						<td><?php echo $row['title']; ?></td>
						<td><a href="remove_cart.php?isbn=<?php echo $row['isbn']?>">Remove</a></td>
					</tr>
			<?php } ?>
			
			</table>
			<a href="revalidate_login.php">Checkout</a>
			<?php	
			}
			
				else 
				{
						echo "Cart is Empty!!!...Add books to the cart";
				}	
			?>
	</div>
</body>

<?php
	require 'session.php';
	require 'connect.php';


?>
	<a href="home.php">Home</a>
	<p>My cart</p>

	<table border=1 class=Form>
		<tr>
			<td>Coverpage</td>
			<td>Title</td>
			<td>Action</td>
		</tr>

		<?php
			$user_id = $_SESSION['cuserid'];
			$result = mysqli_query($con,"SELECT title,isbn,coverpage FROM book where isbn in (select book_isbn from cart where user_id = $user_id)");

			while($row = mysqli_fetch_array($result)){ 
		?>
				<tr>
					<td><?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><a href="remove_cart.php?isbn=<?php echo $row['isbn']?>">Remove</a></td>
				</tr>
		<?php } ?>

	</table>

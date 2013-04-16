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
	if($_POST){
		
		$user_id = $_SESSION['cuserid'];
		$isbn = $_POST['isbn'];

		$result = mysqli_query($con,"insert into ebook_store.order (user_id, book_isbn)	values ('$user_id','$isbn')");
		
		if($result){
			echo "<br/><a href='download.php?isbn=".$isbn."' target='_blank'>Download Ebook!</a>";
		}	
		else{
			die("Error ".mysqli_error($con));
		}

	}

?>


	<form action="buy.php" method="POST">
		<input type="hidden" name="isbn" value="<?php echo $_GET['isbn']; ?>">
		<table border="1">
			<tr>
				<td>Credit Card Details</td>
				<td></td>
			</tr>
			<tr>
				<td>Credit Card Number</td>
				<td><input type="text" name="ccn"></td>
			</tr>
			<tr>
				<td>Expiry Month</td>
				<td>
					<select name="e_month">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Expiry Year</td>
				<td>
					<select name="e_year">
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Security Code</td>
				<td><input type="text" name="s_code"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="purchase" value="Purchase"></td>
			</tr>
		</table>
	</form>

</div>	
</body>
</html>

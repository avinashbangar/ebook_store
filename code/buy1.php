<?php 
	require 'session.php';
	require 'connect.php';

?>
<html>
<head>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
<?php
  $user_id = $_SESSION['cuserid'];
  $result = mysqli_query($con,"SELECT * FROM book WHERE isbn IN (SELECT book_isbn FROM cart where user_id = ".$user_id.")");
  if($result)
  {?>
    <table border="1">
    <tr>
        <td>Book</td>
		<td>Price</td>
    </tr>	
    <?php	
    if($result->num_rows>0)
	{
	  $sum = 0;
	  while($row = mysqli_fetch_array($result))
	  {
	    $sum = $sum + $row['price'];?>
		<tr>
			<td><?php echo "".$row['title'];?></td>
			<td><?php echo "".$row['price'];?></td>
		</tr>		
	<?php	
	  }
	  ?>
		<tr>
			<td><b>Total</b></td>
			<td><b><?php echo "".$sum;?></b></td>
		</tr></table></br></br>		  
	  <?php
	}	
  }
?>
<div class="content">
	<form action="" method="POST" class="form">
		<input type="hidden" name="total" value="<?php echo $sum; ?>">
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

</br></br>
<a href="cart.php">Cancel</a>
</body>
</html>
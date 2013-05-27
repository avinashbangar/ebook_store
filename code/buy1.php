<?php 
	require 'session.php';
	require 'connect.php';
	include_once 'mail.php';
	include_once 'Utility.php';

?>
<html>
<head>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
<?php
  $session = GenerateHashedString($_SESSION['id']);
  $str = "SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')";
  $userresult = mysqli_query($con,$str);
  $user = mysqli_fetch_array($userresult);
  $result = mysqli_query($con,"SELECT * FROM book WHERE isbn IN (SELECT book_isbn FROM cart where user_id = ".$user['id'].")");
  if($result)
  {?>
<div class="content">
	<a href="home.php" class="paragraph">Home</a>
	<a href="logout.php" class="paragraph" style="float:right;">Logout</a>
    <table border="1" class="table" style="max-width: 100px;margin-left: 50px;">
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
</div>
<div class="content">
	<form action="buy1.php" method="POST" class="form">
		<input type="hidden" name="total" value="<?php echo $sum; ?>">
		<table border="1" class="table">
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
	<a href="cart.php" class="paragraph">Cancel</a>
</div>	
<?php 
	if($_POST){
		
  $session = GenerateHashedString($_SESSION['id']);
  $str = "SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')";
  $userresult = mysqli_query($con,$str);
  $user = mysqli_fetch_array($userresult);		
  		$result = mysqli_query($con,"SELECT * FROM book WHERE isbn IN (SELECT book_isbn FROM cart where user_id = ".$user['id'].")");
  		if($result->num_rows>0)
		{
			while($row = mysqli_fetch_array($result))
	  		{
				$isbn = $row['isbn'];
				$ticket = GenerateRandomString();
				$intvar = intval(0);
				$hashvar  = hash('sha512',$ticket);
				$stmt = $con->prepare("INSERT INTO `order` (user_id,book_isbn,hash_Ticket, downloaded) VALUES (?,?,?,?)");
				$stmt->bind_param("iisi",$user['id'],$isbn,$hashvar,$intvar);

				if($stmt->execute()){
					echo "<br/><a href='download.php?isbn=".$isbn."&ticket=".$ticket."' target='_blank'>Download this book: ".$row['title']."</a>";
				
					$stmt->close();
					//Delete from cart where user_id = and book_isbn =
					$stmt1 = $con->prepare("Delete from cart where user_id = ? and book_isbn = ?");
					$stmt1->bind_param("ii",$user['id'],$isbn);
			  if(!$stmt1->execute())
			  {
				 echo "Error in process";
			  }
			  $stmt1->close();
			}
		    else{
					echo "The book was not purchased, please try again!";
				}
			}
		}
	}

?>
</br></br>
</body>
</html>
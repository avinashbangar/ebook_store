<?php 
	require 'session.php';
	require 'connect.php';
	include_once 'mail.php';
	include_once 'Utility.php';

?>
<html>
<head>
	<title>Buy Ebook</title>
	<link href="Styles/Style.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
<div class="content">	
	<div style="max-width:400px;margin-top:25px;">
		<a href="home.php" class="title">Home</a>
		<a href="logout.php" class="title" style="float:right;margin-right:30px;">Logout</a>
	</div>
	<form action="buy.php" method="POST" class="form">
		<input type="hidden" name="isbn" value="<?php echo $_GET['isbn']; ?>">
		<?php
		  $result = mysqli_query($con,"SELECT * FROM book WHERE isbn=".$_SESSION['isbn']);
		  if($result)
		 {
		 	if($result->num_rows>0)
			{
	 	 		while($row = mysqli_fetch_array($result))
	  			{
		 			echo "<p class='priceMessage'>Your purchase price is ".$row['price'].".</p>";
				}
			}
		 }
		 ?>
		<table border="1" class="table">
			<tr>
				<td class="Title">Credit Card Details</td>
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
	<?php 
	if($_POST){
		
  $session = GenerateHashedString($_SESSION['id']);
  $str = "SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')";
  $userresult = mysqli_query($con,$str);
  $user = mysqli_fetch_array($userresult);
		$isbn = $_SESSION['isbn'];
		$ticket = GenerateRandomString();
		
				$intvar = intval(0);
				$hashvar  = hash('sha512',$ticket);
				$stmt = $con->prepare("INSERT INTO `order` (user_id,book_isbn,hash_Ticket, downloaded) VALUES (?,?,?,?)");
				$stmt->bind_param("iisi",$user['id'],$isbn,$hashvar,$intvar);
				
				
		if($stmt->execute()){
			echo "<br/><a href='download.php?isbn=".$isbn."&ticket=".$ticket."' target='_blank' class='paragraph'>Download Ebook!</a>";
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

?>
</div>	
</body>
</html>

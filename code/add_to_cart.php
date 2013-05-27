<?php
	ob_start();
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';


	$isbn = $_GET['isbn'];
	$flag = 0;

		$stmt=$con->prepare("select isbn from book where isbn=?");
		$stmt->bind_param("s",$isbn);
		if($stmt->execute()){
		$row = $stmt->fetch();
		if($row == 1){
		    $stmt->close();
			$session = GenerateHashedString($_SESSION['id']);
			//echo $session;
			echo $str = "SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')";
			$userresult = mysqli_query($con,$str);
			$user = mysqli_fetch_array($userresult);

			$stmt1 = $con->prepare("insert into cart(user_id,book_isbn,session_id) values (?,?,?)");
			$stmt1->bind_param("sss",$user['id'],$isbn,$session);
			if(!$stmt1->execute()){
			echo "Error adding to cart!";
			}
			$stmt1->close();
     		header('Location:home.php');
		}else{
			$flag = 1;
		}

	}else{

		$flag =1;
	}

	if($flag == 1){

		echo "Invalid Book, please try again!";
	}
	//ob_end_flush();
?>
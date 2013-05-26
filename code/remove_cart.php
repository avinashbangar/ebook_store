<?php
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';


	$isbn = $_GET['isbn'];
	
	$session = GenerateHashedString($_SESSION['id']);
	echo $session;
	$userresult = mysqli_query($con,"SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')");
	$user = mysqli_fetch_array($userresult);

	$result = mysqli_query($con,"SELECT * FROM cart WHERE book_isbn = ".$isbn." AND user_id = ".$user['id']);
	if($result){
	  if($result->num_rows >= 1){
		if(mysqli_query($con,"DELETE FROM cart WHERE book_isbn = ".$isbn." AND user_id = ".$user['id']))
		   header('location: cart.php');
	  }
	}
	?>

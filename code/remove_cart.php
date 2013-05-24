<?php
	require 'session.php';
	require 'connect.php';


	$isbn = $_GET['isbn'];
	
	$result = mysqli_query($con,"SELECT * FROM cart WHERE book_isbn = ".$isbn." AND user_id = ".$_SESSION['cuserid']);
	if($result){
	  if($result->num_rows >= 1){
		if(mysqli_query($con,"DELETE FROM cart WHERE book_isbn = ".$isbn." AND user_id = ".$_SESSION['cuserid']))
		   header('location: cart.php');
	  }
	}

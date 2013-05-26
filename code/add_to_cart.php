<?php
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';


	$isbn = $_GET['isbn'];
	$flag = 0;
    
	$result = mysqli_query($con,"SELECT isbn FROM book WHERE isbn = $isbn");
	if($result){

		if($result->num_rows == 1){
			$session = GenerateHashedString($_SESSION['id']);
			echo $session;
			$userresult = mysqli_query($con,"SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')");
			$user = mysqli_fetch_array($userresult);
/*
			$stmt = $con->prepare("insert into cart(user_id, book_isbn, session_id) values (?,?,?)");

    		$stmt->bind_param("sss", $user_id, $book_isbn, $session_id);

       		//execute the query;
     		$stmt->execute(); 
     		$stmt->close();
     		echo "success";
     		*/

     		$result = mysqli_query($con,"insert into cart (user_id, book_isbn, session_id) values (".$user['id'].",'$isbn','$session')");
     		if(!$result){
     			echo "Error adding to cart!" .mysqli_error($con);
     		}	
     		
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
?>
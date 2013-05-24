<?php
	require 'session.php';
	require 'connect.php';


	$isbn = $_GET['isbn'];
	$flag = 0;
    
	$result = mysqli_query($con,"SELECT isbn FROM book WHERE isbn = $isbn");
	if($result){

		if($result->num_rows == 1){
			$session_id = 123;
			$user_id = $_SESSION['cuserid'];
/*
			$stmt = $con->prepare("insert into cart(user_id, book_isbn, session_id) values (?,?,?)");

    		$stmt->bind_param("sss", $user_id, $book_isbn, $session_id);

       		//execute the query;
     		$stmt->execute(); 
     		$stmt->close();
     		echo "success";
     		*/

     		$result = mysqli_query($con,"insert into ebook_store.cart (user_id, book_isbn, session_id) values ('$user_id','$isbn','$session_id')");
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
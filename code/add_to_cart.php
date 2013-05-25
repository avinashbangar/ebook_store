<?php
	require 'session.php';
	require 'connect.php';


	$isbn = $_GET['isbn'];
	$flag = 0;
    // 
// 	$result = mysqli_query($con,"SELECT isbn FROM book WHERE isbn = $isbn");
// 	if($result){
		$stmt=$con->prepare("select isbn from book where isbn=?");
		$stmt->bind_param("s",$isbn);
		if($stmt->execute()){
		$row = $stmt->fetch();
		
//echo $row;
		if($row == 1){
//if($result->num_rows == 1){
			$session_id = session_id();
			$user_id = $_SESSION['cuserid'];
			
/*
			$stmt = $con->prepare("insert into cart(user_id, book_isbn, session_id) values (?,?,?)");

    		$stmt->bind_param("sss", $user_id, $book_isbn, $session_id);

       		//execute the query;
     		$stmt->execute(); 
     		$stmt->close();
     		echo "success";
     		*/

    // $ result = mysqli_query($con,"insert into cart (user_id, book_isbn, session_id) values ('$user_id','$isbn','$session_id')");
//      		if(!$result){
//      			echo "Error adding to cart!" .mysqli_error($con);
//      		}	
			$stmt->close();
			$stmt1 = $con->prepare("insert into cart(user_id,book_isbn,session_id) values (?,?,?)");
			$stmt1->bind_param("sss",$user_id,$isbn,$session_id);
			if(!$stmt1->execute()){
			echo "Error adding to cart!";
			}
		 //else{echo "Error adding to cart!";}
     		
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
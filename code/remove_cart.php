<?php
	require 'session.php';
	require 'connect.php';
	include_once 'Utility.php';


	$isbn = $_GET['isbn'];
	
	$session = GenerateHashedString($_SESSION['id']);
	$userresult = mysqli_query($con,"SELECT id, first_name from user Where id IN (Select user_id  from session Where id = '$session')");
	$user = mysqli_fetch_array($userresult);



	$stmt=$con->prepare("select * from cart where book_isbn=? and user_id=?");
	$stmt->bind_param("ss",$isbn,$user['id']);
	if($stmt->execute()){
	$row=$stmt->fetch();
	if($row>=1){
	$stmt->close();
	$stmt1=$con->prepare("delete from cart where book_isbn=? and user_id=?");
	$stmt1->bind_param("ss",$isbn, $user['id']);
	if($stmt1->execute()){
	  header('location: cart.php');
	  }
    $stmt1->close();}}

?>
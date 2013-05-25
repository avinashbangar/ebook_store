<?php
	require 'session.php';
	require 'connect.php';


	$isbn = $_GET['isbn'];
	

	$stmt=$con->prepare("select * from cart where book_isbn=? and user_id=?");
	$stmt->bind_param("ss",$isbn,$_SESSION['cuserid']);
	if($stmt->execute()){
	$row=$stmt->fetch();
	if($row>=1){
	$stmt->close();
	$stmt1=$con->prepare("delete from cart where book_isbn=? and user_id=?");
	$stmt1->bind_param("ss",$isbn, $_SESSION['cuserid']);
	if($stmt1->execute()){
	  header('location: cart.php');
	  }}
	  $stmt1->close();}
    ?>
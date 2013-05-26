<?php
  require 'connect.php';
  include_once 'Utility.php';
  
	session_start();
	if(isset($_SESSION['user'])){
  		unset($_SESSION['user']);
  		header('Location:admin.php');
	}
	
	if(isset($_SESSION['id'])){
		$session = $_SESSION['id'];	
		$session = GenerateHashedString($session);
		mysqli_query($con,"delete from session where id = '$session'");
		unset($_SESSION['id']);
  		header('Location:index.php');
		session_destroy();
	}
?>
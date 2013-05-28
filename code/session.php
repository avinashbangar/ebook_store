<?php
    require 'Cookies/cookies.php';
	include_once 'Utility.php';
	require 'connect.php';
	
    session_start(); 
	
    if(check_cookie() || !isset($_SESSION['id']) )
	{
		$session = fnDecrypt(get_cookie_value(),'a4t14A20z');
		if (strpos($session,$_SERVER['REMOTE_ADDR']) !== false) {
		$hashed = GenerateHashedString($session);
		$result = mysqli_query($con,"select * from session where id = '$hashed'");
		if($result)
		{
		  if($result->num_rows>0)
		  {
				$_SESSION['id'] = $session;
		  }	
		  else
			{
				header('Location:index.php');
			}	
		}
		else
		{
			header('Location:index.php');
		}	
	}
		else
		{
			header('Location:index.php');
		}	
	}
	else
	{
		header('Location:index.php');
	}
	
/*	if(!isset($_SESSION['id'])){
	  
    	$_SESSION['resultString']='You are not authorized for this page!';
		
	}*/
?>

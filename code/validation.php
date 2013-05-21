<?php 
	function ValidateSpecialCharacters($input)
	{
		//prevents SQL injections by prohibiting certain strings on the input
		// returns TRUE if the input has no prohibited characters, false otherwise.
		if((strpos($input,'=') !== false)
			||(strpos($input,'"') !== false)
			||(strpos($input,"'") !== false)
			||(strpos($input,'-') !== false)
			||(strpos($input,' ') !== false)
			||(strpos($input,'*') !== false)
			||(strpos($input,'NULL') !== false))
		{
			return false;
		}else{
			return true;
		}
	}
		
	function ValidateUpperletterAndNumber($input)
	{
		//validates that the input has at least one capital letter and a number
		//returns true if he has found both a capital letter and a number, false otherwise.
		if((preg_match('/[A-Z]/', $input)) && (preg_match('/[0-9]/', $input)))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function ValidateLength($input, $minimumLenght, $maximumLenght)
	{
		//validates that a string has at least $minimumLenght characters or more and $maximumLenght characters or less
		//returns true if it does, false otherwise
		if (strlen($input) >= $minimumLenght && strlen($input) <= $maximumLenght)
		{
			return true;
		}else
			return false;
	}
	
	function alert($message)
	{
		//Sends a message to the user via a standard output window.
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function CheckEmail($email)
	{
		// returns true if the email exists in our database, false otherwise
		// Create connection
		$con=mysqli_connect("fdb5.awardspace.com","1387051_books","9pijohe2","1387051_books");
		// Check connection
		if (mysqli_connect_errno($con))
		{
		  alert("Failed to connect to MySQL: " . mysqli_connect_error());
		}else if($email != ''){
			//Input validation
			$result = mysqli_query($con,"SELECT id FROM user WHERE email = '$email'");
			if($result->num_rows == 1 ){	
				return true;
			}else
			{
				//either there is no such email or we have suffered an sql injection and we have multiple results
				return false;
			}
		}else{
			return false;
		}
	}
?>
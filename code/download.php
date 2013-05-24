<?php
	require 'session.php';
	require 'connect.php';
	require 'validation.php';

	if($_GET){

		$isbn = $_GET['isbn'];
		
		if (ValidateNumber($isbn) && ($stmt = $con->prepare("SELECT title,ebook FROM book WHERE isbn = ?")))
		{
			//bind parameter for isbn
			$stmt->bind_param("i", $isbn);
			
			//execute the query
			if(false == $stmt->execute()) {
				printf("");
			}
			else {
				 //bind result variable
				 $stmt->bind_result($title, $ebook);
						  
				 if($stmt->fetch()) 
				 {
					header("Content-type: application/pdf");
					header("Content-Disposition: attachment; filename=".$title);
					header("Content-Description: PHP Generated Data");
					echo $ebook;
				 } 
				 else{
					printf("No rows found! \n");
					printf("Incorrect email/password");
				}
				$stmt->close();
		   }
		}
		else{
			echo("Unable to download book! Invalid isbn! ");
		}
	}

?>
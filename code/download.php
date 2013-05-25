<?php
	require 'session.php';
	require 'connect.php';
	require 'validation.php';
	require 'mail.php';

	if($_GET){

		$isbn = $_GET['isbn'];
		$ticket = $_GET['ticket'];
		
		$hashedValue = GenerateHashedString($ticket);
		
			if (ValidateNumber($isbn))
			{
				$stmt = $con->prepare("SELECT title,ebook 
							   FROM book INNER JOIN `order` ord ON book.isbn = ord.book_isbn 
							   WHERE book.isbn=? AND ord.hash_Ticket=?");
				$stmt->bind_param("is",$isbn,$hashedValue);
				if(!$stmt->execute()){
					if ($stmt->num_rows == 1)
					{
						$stmt->bind_result($title, $ebook);
						while(mysqli_stmt_fetch($stmt))
						{
							header("Content-type: application/pdf");
				  			header("Content-Disposition: attachment; filename=".$title."");
				  			header("Content-Description: PHP Generated Data");
				  			echo $ebook;
				  			/*
				  			header("Content-type: image/jpg");
				  			header("Content-Disposition: attachment; filename=".$row['title']."");
				  			header("Content-Description: PHP Generated Data");
				  			echo $row['coverpage'];
				  			*/
				  		}
						//we delete the permissions for that file
						$stmt->close();
						$stmt = $con->prepare("Delete * 
									   		  FROM order
									   		  WHERE book_isbn=? AND order.hash_Ticket=?");
						$stmt->bind_param("ss",$isbn,$hashedValue);
						if (!$stmt->execute())
							alert("error deleting");
					}else{
						alert('too many rows obtained');
					}
				}else{
					alert('sql error');
				}
			}
			else{
				echo("Unable to download book! Invalid isbn! ");
			}
		}


?>
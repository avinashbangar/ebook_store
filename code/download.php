<?php
	require 'session.php';
	require 'connect.php';
	require 'validation.php';

	if($_GET){

		$isbn = $_GET['isbn'];
		$ticket = $_GET['ticket'];
		
		$hashedValue = GenerateHashedString($ticket);
		
			if (ValidateNumber($isbn))
			{
				$stmt = $con->prepare("SELECT title,ebook 
							   FROM book INNER JOIN order ON book.isbn = order.book_isbn 
							   WHERE book.isbn=? AND order.hash_Ticket=?");
				$stmt->bind_param("ss",$isbn,$hashedValue);
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
				  			
				  			//After the user downloads the book, I delete the order so they cannot download it again
				  			$stmt = $con->prepare("Delete * 
									   			   FROM order
									   				WHERE book_isbn=? AND order.hash_Ticket=?");
							$stmt->bind_param("ss",$isbn,$hashedValue);
							$stmt->execute();
				  		}
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
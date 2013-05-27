<?php
	require 'session.php';
	require 'connect.php';
	//require 'validation.php';
	//require 'mail.php';

	if($_GET){

		$isbn = $_GET['isbn'];
		$ticket = $_GET['ticket'];
		
		$hashedValue = hash('sha512',$ticket);
				$stmt = $con->prepare("SELECT title,ebook,downloaded
							   FROM book INNER JOIN `order` ord ON book.isbn = ord.book_isbn 
							   WHERE book.isbn=? AND ord.hash_Ticket=?");
				$stmt->bind_param("is",$isbn,$hashedValue);
				if($stmt->execute()){
						$stmt->bind_result($title, $ebook, $downloaded);
						while(mysqli_stmt_fetch($stmt)&& $downloaded==0)
						{
							header("Content-type: application/pdf");
				  			header("Content-Disposition: attachment; filename=".$title."");
				  			header("Content-Description: PHP Generated Data");
							header('Content-Transfer-Encoding: binary');
    						header('Expires: 0');
    						header('Cache-Control: must-revalidate');
  							header('Pragma: public');
							header('Content-Length: ' . filesize($title));
							echo $ebook;
				  			//echo $ebook;
				  			/*
				  			header("Content-type: image/jpg");
				  			header("Content-Disposition: attachment; filename=".$row['title']."");
				  			header("Content-Description: PHP Generated Data");
				  			echo $row['coverpage'];
				  			*/
				  		}
						//we delete the permissions for that file
						$stmt->close();
						$stmt = $con->prepare("UPDATE `order`
									   		  SET downloaded = 1
									   		  WHERE book_isbn=? AND order.hash_Ticket=?");
						$stmt->bind_param("is",$isbn,$hashedValue);
						if (!$stmt->execute())
							alert("error updating");
				}else{
					alert('sql error');
				}
		}


?>
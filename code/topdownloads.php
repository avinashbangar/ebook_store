<?php 
	require 'session.php';
	require 'connect.php';

?>

<link href="Styles/Topdownloads.css" rel="stylesheet" type="text/css" />
	<p><a class="paragraph" href="home.php">Home</a></p>
	<!-- <p> -->
<?php
    $result = mysqli_query($con,"SELECT a.isbn as isbn, a.title as title, count(a.title) as count from ebook_store.book as a, ebook_store.order WHERE a.isbn = ebook_store.order.book_isbn Group by isbn Order by count desc");
	if($result)
    {
	?>
	<div class="content">
	<body>
	<table border="1">
		<tr>
		     <td>ISDN</td>
			 <td>BOOK</td>
			 <td>Downloads</td>
		</tr>	
		<?php
	   while($row = mysqli_fetch_array($result))
	   {?>
	     <tr>
			  <td><?php echo "".$row['isbn'];?></td>	
		      <td><?php echo "".$row['title'];?></td>
			  <td><?php echo "".$row['count'];?></td>
		 </tr>	
	   <?php } ?>
	   </table>
	   <?php
    }	
?>

</body>
</div>
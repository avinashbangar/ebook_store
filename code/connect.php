<?php
// Create connection
//
$con=mysqli_connect("localhost","root","avi6186","ebook_store");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>

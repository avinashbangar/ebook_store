<?php
// Create connection
$con=mysqli_connect("fdb5.awardspace.com","1387051_books","9pijohe2","1387051_books");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
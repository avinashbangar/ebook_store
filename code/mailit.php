<?php
require_once "Mail.php";


$from = "lareostia@gmail.com";
$to = "abangar@scu.edu";
$subject = "Hi!";
$body = "Hi,\n\nHow are you?";

$host = "ssl://smtp.gmail.com";
$port = "465";
$username = "lareostia@gmail.com";
$password = "Tracasa06";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
?>
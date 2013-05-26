<?php
require "cookies.php";

if(check_cookie())
  echo get_cookie_value();
else
{
   set_cookie('123');	
   //header('Location: http://localhost/ebook_store/code/index.php');
}   
?>
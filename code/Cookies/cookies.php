<?php

function check_cookie()
{
  return isset($_COOKIE["e-commerce"]);
}

function set_cookie($value)
{
  $expire=time()+60*60*24;
  setcookie("e-commerce", $value, $expire);
}

function get_cookie_value()
{
  return $_COOKIE["e-commerce"];
}
?>
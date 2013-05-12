<?php
require 'users.php';

function auth($login = null, $pass = null) {
  if(!isset($login)) {
      if(isset($_SESSION['login']))
	$login = $_SESSION['login'];
      if(isset($_SESSION['pass']))
	$pass = $_SESSION['pass'];
  }


if(isset($login) && isset($pass)) {
      return getUser($login, $pass);
  } else {
      global $NO_USER;
      return $NO_USER;
  }
}
?>
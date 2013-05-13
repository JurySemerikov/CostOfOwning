<?php
error_reporting(E_ALL);

require 'include/auth.php';

session_start();
sqlConnect();

$user = auth();

switch($user['access']) {
  case 2:
      header('Location: /list.php');
      break;
  case 1:
      header('Location: /owner.php');
      break;
  case 0:
      header('Location: /admin.php');
      break;
  case -1:
  default:
      header('Location: /auth.php');
}
?>

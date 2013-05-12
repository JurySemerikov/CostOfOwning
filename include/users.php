<?php

$NO_USER = array('access'=>-1, 'id'=>0);

require 'bd.php';

function getUser($login, $pass) {
  global $SQL_TABLES;
  $res = sqlSelect($SQL_TABLES['users'], array('login'=>$login, 'password'=>$pass))->fetch(PDO::FETCH_ASSOC);
  if($res == false) {
      global $NO_USER;
      return $NO_USER;
  }
  return $res;
}

function createUser($access, $login, $password, $name = null) {
  global $SQL_TABLES;
  $array = array('access'=>$access, 'login'=>$login, 'password'=>$password);
  if(isset($name))
    $array['name'] = $name;
    
  sqlInsert($SQL_TABLES['users'], $array);
}

function editUser() {
  
}

function removeUser($id) {
  global $SQL_TABLES;
  sqlQuery("DELETE FROM $SQL_TABLES[users] WHERE id='$id';", true);
}
?>
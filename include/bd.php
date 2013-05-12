<?php

$SQL_CONFIG = array (
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'gah5Ooqu',
    'database' => 'cost_of_motor',
    'adminpass'=> '600895');
$SQL_TABLES = array (
    'users' => 'Users',
    'access'=> 'Access');

// $SQL_DBH = null;

function sqlQuery($query, $service = false) {
  global $SQL_DBH;
  try {
      $res = $SQL_DBH->query($query);
      if($res == false)
	throw new Exception($SQL_DBH->errorInfo()[2]);
      return $res;
  } catch(Exception $e) {
      if($service)
	  die($query . '<br/>' . $e->getMessage());
      else
	  die($e->getMessage());
	 
  }
}

function sqlConnect() {
  sqlCreateConnect();
  sqlUseDatabase();
}

function sqlClose() {
  global $SQL_DBH;
  if(isset($SQL_DBH))
    unset($SQL_DBH);
}

function sqlCreateConnect() {
  global $SQL_DBH;
  if(isset($SQL_DBH))
    return;
  global $SQL_CONFIG;
  try {
      $SQL_DBH = new PDO("mysql:host=$SQL_CONFIG[hostname]", $SQL_CONFIG['username'], $SQL_CONFIG['password']);
  } catch (PDOException $e) {
      die('Подключение не удалось: ' . $e->getMessage() );
  }
}

function sqlUseDatabase() {		
  global $SQL_CONFIG;
  sqlQuery("USE $SQL_CONFIG[database];");
}

function sqlSelect($table, $array) {
  global $SQL_DBH;
  
  $where = '';
  foreach ($array as $name => $value)
      $where .= $name . '=' . $SQL_DBH->quote($value) . ' AND ';
  $where = substr($where, 0, -5);
  
  return sqlQuery("SELECT * FROM $table WHERE $where;");
}

function sqlInsert($table, $array) {
  global $SQL_DBH;
  $names = '(';
  $values = '(';
  foreach ($array as $name => $value) {
      $names  .= $name . ', ';
      $values .= $SQL_DBH->quote($value) . ', ';
  }
  $names  = substr($names,  0, -2) . ')';
  $values = substr($values, 0, -2) . ')';
  
  sqlQuery("INSERT INTO $table $names VALUES $values;");
}
?>
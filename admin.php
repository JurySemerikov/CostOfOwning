<?php
require 'include/auth.php';

session_start();
sqlConnect();

$user = auth();

if($user['access'] != 0) {
  header('Location: /');
  exit();
}

if(isset($_POST['id']) && isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['access'])) {
    $id = 1*$_POST['id'];
    $access = 1*$_POST['access'];
    $login = trim($_POST['login']);
    $pass = $_POST['pass'];
    
    if($id > 1)
      if(empty($login))
	removeUser($id);
      else
	editUser($id, $login, $pass, $access);
    else
      if(!empty($login))
	createUser($access, $login, $pass);
      
    
}
?>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <title>Авторизация</title>
</head>
<body>
<table>

<?php

$access = array();
$res = sqlQuery("SELECT * FROM $SQL_TABLES[access]");
while($row = $res->fetch(PDO::FETCH_ASSOC))
  $access[$row['id']] = $row['name'];

$res = sqlQuery("SELECT * FROM $SQL_TABLES[users]");
while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo "<form method='POST'><input type='hidden' name='id' value='$row[id]'>\n";
    echo "\t<tr><td><input type='text' name='login' value='$row[login]'></td><td><input type='text' name='pass' value='$row[password]'></td><td><select name='access'>";
    
    foreach($access as $key=>$value) {
      echo "<option " . ($key == $row['access'] ? 'selected ' : '') . "value='$key'>$value</option>";
    }
    
    echo "</select></td><td><input type='submit' value='Изменить'></td></tr>\n";
    echo "</form>\n";
}
?>
<form method='POST'><input type='hidden' name='id' value='1'>
<tr><td><input type='text' name='login' placeholder='Login'></td><td><input type='text' name='pass' placeholder='Password'></td><td><select name='access'><option value='0'>Администратор</option><option selected value='1'>Владелец</option><option value='2'>Пользователь</option></select></td><td><input type='submit' value='Добавить'></td></tr>
</table>
</body>
</html>
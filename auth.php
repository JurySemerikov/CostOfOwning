<?php

require 'include/auth.php';

session_start();
sqlConnect();

if(isset($_POST['login']) && isset($_POST['pass'])) {
  $user = auth($_POST['login'], $_POST['pass']);
  if($user['access'] >= 0) { // Если пользователь существует
      $_SESSION['login'] = $_POST['login'];
      $_SESSION['pass'] = $_POST['pass'];
      header('Location: /');
      exit();
  }
  else
    $error = 'Такого поьзователя не существует или пароль неверен';
}
?>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <title>Авторизация</title>
</head>
<body>
<?= isset($error)?"<div style='color: red;'>$error</div>":"" ?>
  <form method='POST'>
    <input type='text' name='login' placeholder='Login'>
    <input type='password' name='pass' placeholder='Password'>
    <input type='submit'>
  </form>
</body>
</html>
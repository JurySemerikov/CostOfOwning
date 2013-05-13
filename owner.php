<?php

error_reporting(E_ALL);

require 'include/auth.php';

session_start();
sqlConnect();

$user =  auth();

if($user['access']==-1) {
    header('Location: /');
    exit();
}

$canWrite = $user['access'] < 2;

if($canWrite && isset($_POST['text'])) {
    $text = $_POST['text'];
    sqlInsert($SQL_TABLES[node], array('text'=>$text, 'user_id'=>$user['id']));
}

if(isset($_GET['id']))
  $id = 1*$_GET['id'];
else
  $id = $user['id'];

?>

<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <title>Своя страница</title>
</head>
<body>
<table>
<?php
if($canWrite && $id == $user['id'])
    echo "	<tr><td><form method='POST'><textarea name='text' maxlength='128'></textarea><input type='submit'></form></td></tr>";

$empty = true;
$res = sqlQuery("SELECT * FROM $SQL_TABLES[node] WHERE user_id='$id' GROUP BY id DESC", true);
while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo "	<tr><td>$row[text]</td></tr>\n";
    $empty = false;
}

if($empty)
  echo "	<tr><td>Нет записей</td></tr>\n";
?>
</table>
</body>
</html>

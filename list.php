<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <title>Авторизация</title>
</head>
<body>
<table>
<?php
error_reporting(E_ALL);

require 'include/auth.php';

sqlConnect();

$res = sqlQuery("SELECT id, login, access FROM $SQL_TABLES[users]");
while($row = $res->fetch(PDO::FETCH_ASSOC))
  echo "	<tr><td><a" . ($row['access']<2?" href='/owner.php?id=$row[id]'":"") . ">$row[login]</a></td></tr>\n";
?>

</table>
</body>
</html>


<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <title></title>
</head>
<body>
<?php
error_reporting(E_ALL);

require 'include/users.php';

createDatabase();
createTableAccess();
createTableUsers();
echo 'All Right!';

function createDatabase() {
  global $SQL_CONFIG;
  sqlCreateConnect();
  sqlQuery("DROP DATABASE IF EXISTS $SQL_CONFIG[database];", true);
  sqlQuery("CREATE DATABASE $SQL_CONFIG[database];", true);
  sqlUseDatabase();
}

function createTableAccess() {
  global $SQL_TABLES;
  
  sqlQuery("DROP TABLE IF EXISTS $SQL_TABLES[access];", true);
  
  sqlQuery("CREATE TABLE $SQL_TABLES[access] (
  id int NOT NULL PRIMARY KEY,
  name varchar(128) UNIQUE
  );", true);
  
  sqlQuery("INSERT INTO $SQL_TABLES[access] VALUES (0, 'Администратор');", true);
  sqlQuery("INSERT INTO $SQL_TABLES[access] VALUES (1, 'Владелец');", true);
  sqlQuery("INSERT INTO $SQL_TABLES[access] VALUES (2, 'Пользователь');", true);
}

function createTableUsers() {
  global $SQL_TABLES, $SQL_CONFIG;
  
  sqlQuery("DROP TABLE IF EXISTS $SQL_TABLES[users];", true);

  sqlQuery("CREATE TABLE $SQL_TABLES[users] (
  id int NOT NULL PRIMARY KEY auto_increment,
  login varchar(128) NOT NULL UNIQUE,
  password varchar(64) NOT NULL,
  name varchar(1024),
  access int NOT NULL REFERENCES $SQL_TABLES[access](id)
  );", true);
  
  createUser(0, 'admin', $SQL_CONFIG[adminpass], 'Администратор');
}


?>
</body>
</html>
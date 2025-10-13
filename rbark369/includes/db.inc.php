<?php
//helper file for database connection
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'stocks');
define('DBCONNSTRING', 'mysql:host=' . DBHOST . ';dbname=' . DBNAME);

$conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
<?php
//helper file for database connection
define('DBPATH', 'data/stocks.db');
define('DBCONNSTRING', 'sqlite:' . DBPATH);

$conn = new PDO(DBCONNSTRING);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
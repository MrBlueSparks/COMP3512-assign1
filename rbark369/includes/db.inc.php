<?php
//helper file for database connection
// Try multiple paths to find the database
if (file_exists('../data/stocks.db')) {
    $dbPath = '../data/stocks.db';
} elseif (file_exists('data/stocks.db')) {
    $dbPath = 'data/stocks.db';
} else {
    die('Database file not found');
}

define('DBPATH', $dbPath);
define('DBCONNSTRING', 'sqlite:' . DBPATH);

$conn = new PDO(DBCONNSTRING);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



?>
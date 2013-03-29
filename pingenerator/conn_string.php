<?php

if($_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'silo-it:8080')
{
$hostname = "localhost";
$database = "ame";
$username = "root";
$password = "mindzpark";
$db = mysql_connect($hostname, $username, $password);
mysql_select_db($database, $db);
}
else
{
$hostname = "localhost";
$database = "ame";
$username = "root";
$password = "mindzpark";
//$dbm = new mysqli($hostname, $username, $password, $database);
}
?>

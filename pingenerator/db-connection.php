<?php
$hostname = "localhost";
$database = "moodle24";
$username = "root";
$password = "mindzpark";
$db = mysql_connect($hostname, $username, $password);
mysql_select_db($database, $db);
//$sql = "select id from mdl_passcode where code = 'fff' ";
//                echo $sql;
//		$rs = mysql_query($sql,$db) or die(mysql_error());
/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */

?>

<?php

$hostname="localhost";
$username="root";
$password="";
$dbname="ibms";
$connect = mysqli_connect($hostname, $username, $password, $dbname, 3306);
if (!$connect)
{
	die('Could not connect:'. mysqli_error($connect));
}
?>
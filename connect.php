<?php

$hostname="localhost";
$username="fayub4";
$password="123";
$dbname="fayub4";
$connect = mysqli_connect($hostname, $username, $password, $dbname);
if (!$connect)
{
	die('Could not connect:'. mysqli_error($connect));
}
?>
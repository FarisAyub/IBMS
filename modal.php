<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['mod'])) {
		$modid = $_POST['id'];
		$upd = "UPDATE `IBMS-Data` SET `Views`=`Views`+1 WHERE Policy_id='".$modid."'";
	  	$exec = mysqli_query($connect, $upd) or die(mysqli_error($connect));
	}
}
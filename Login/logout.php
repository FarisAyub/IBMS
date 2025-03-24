<?php
$ROOT = '../';
header("Location: ".$ROOT."index.php");  // Redirect to index page
include $ROOT . 'nav.php'; // Include navigation bar 
if(isset($_SESSION['username'])) {  // If logged in
	session_destroy(); // End session (logs out)
}
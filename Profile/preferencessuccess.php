<?php
$ROOT = '../'; 
include $ROOT.'nav.php';
if (isset($_SESSION['username'])) {
	?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--- Title --->
    <title>Success!</title>
</head>

<body>
    <!--- Navigation bar --->
    <div>
	</div>
    <!--- Container to center page --->
    <div class="container">
        <h1>Preferences set!</h1>
        <p>You have successfully selected your preferences.</p>
        <br>
    </div>
</body>

</html>
<?php
} else {
	header("Location: ".$ROOT."index.php");
}
?>
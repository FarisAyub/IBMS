<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "SELECT * FROM `FYP-Accounts` WHERE Username='$username' and Password='$password'"; 
	$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	
	if ($count == 1){
		$_SESSION['level'] = $row['Access'];
		$_SESSION['username'] = $username;
		header("Refresh:0");

	} else {
		
		$error = "Invalid username or password";
		
	}

}
if(!isset($_SESSION['username'])){ 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body class="login-form">
    <!--- Card --->
    <br>
    <div class="card mx-auto card-login">
    <div class="card-body text-center">	
    <form action="" method="POST">
    <fieldset>
    	<?php 
		if (isset($error)) {
			echo '<div class="alert alert-danger alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Error! </Strong>' . $error;
			echo '</div>';
		}
		?>
    	<h1 class="card-title">LOGIN</h1>
    	<div class="form-group">
    		<input id="1" type="text" name="username" class="form-control" size="48" maxlength="12" placeholder="Username" autocomplete="on" required title="Enter your username.">
		</div>
		<div class="form-group">
    		<input id="2" type="password" name="password" class="form-control" size="48" maxlength="12" placeholder="Password" autocomplete="on" required title="Enter your password.">
		</div>
		<div class="card text-center">	
        	<input class="btn btn-primary" type="submit" value="Submit">
        </div>
        <br>
        Don't have an account? <a href="<?=$ROOT?>Register/register.php">Sign up.</a>
        </fieldset>
    </form>
    </div>
    </div>
    <!--- End of card above --->
    </div>
</body>

</html>
<?php
} else { 
	echo 
	"<br>
    <div class='card mx-auto' style='max-width: 30rem;'>
    <div class='card-body text-center'>
	<div class='container'>
	<h1>Logged in</h1>
	Redirecting in 3 seconds...<br>
	</div>
	</div>
	</div>";
	header("refresh:3;url='../Profile/preferences.php'");
}
?>
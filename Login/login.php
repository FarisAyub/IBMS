<?php
$ROOT = '../';
include $ROOT . 'nav.php'; // Include navigation bar
if ($_SERVER["REQUEST_METHOD"] == "POST") { // If form submitted
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "SELECT * FROM `IBMS-Accounts` WHERE Username='$username' and Password='$password'"; 
	$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	
	if ($count == 1){ // If account exists
		$_SESSION['level'] = $row['Access']; // Set to admin or user
        $_SESSION['username'] = $username; // Session variable
        $checkPreferences = "SELECT * FROM `IBMS-Preferences` WHERE Username='$username'";
        $checkResult = mysqli_query($connect, $checkPreferences) or die(mysqli_error($connect));
        $checkRow = mysqli_num_rows($checkResult);
        if ($checkRow == 1) { // Set preferences session variable
            $_SESSION['preferences'] = 'Set'; 
        } else {
            $_SESSION['preferences'] = 'Not';
        }
        if ($_SESSION['preferences'] == 'Set') { // If set preferences before
            header("refresh:3;url='../Profile/profile.php'"); // Go to profile 
        } else { // If not 
            header("refresh:3;url='../Profile/preferences.php'"); // Go to set preferences
        }
	} else {
		
		$error = "Invalid username or password";
		
	}

}

if(!isset($_SESSION['username'])) { // If not logged in
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
		if (isset($error)) { // If form submit fails display error in alert
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
} else { // If already logged in
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
}
?>
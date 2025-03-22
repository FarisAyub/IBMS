<?php 
$ROOT = '../'; include $ROOT . 'nav.php';
 if(isset($_SESSION['username'])) { 
	session_destroy();
	header("Refresh:0");
} else { 
?> 
	<!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Login</title>
    </head>

    <body>
        <div class="container">
			<br>
			<div class="card mx-auto" style="max-width: 40rem;">
				<div class="card-body text-center">	
					<h1>Logged out</h1>
					Redirecting to home in 3 seconds...<br>
					<?php header("refresh:3;url='".$ROOT."index.php'"); ?>
				</div>
			</div>
        </div>
    </body>

    </html>
<?php
} 
?>
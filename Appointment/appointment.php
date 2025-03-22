<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if(isset($_SESSION['username'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
		$username = $_SESSION['username'];
		$message = $_POST['message'];
		
		$sql = "INSERT INTO `FYP-Appointments`
		(`Username`, `Message`, `Status`) VALUES 
		('$username', '$message', 'Pending')"; 
			
		if (mysqli_query($connect,$sql)) {
			// Select email of user requesting appointment
			$sql2 = "SELECT `Email` FROM `FYP-Accounts` WHERE Username='".$username."'";
			$result = mysqli_query($connect, $sql2);
			$row = mysqli_fetch_assoc($result);
			$email = $row['Email'];
			// Send email to the email account linked
			$to = $email; 
			$subject = "Appointment request submitted"; 
			$emessage = "Your request for an appointment was received successfully, you will be notified when your appointment has been scheduled!";
		
			// If over 70 characters 
			$emessage = wordwrap($emessage, 70, "\r\n");
		
			// Email + link
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/plain; charset=iso-8859-1";
			$headers[] = "From: IB <noreply@IBMS.com>";
			$headers[] = "Subject: {$subject}";
			$headers[] = "X-Mailer: PHP/".phpversion();
			mail($to, $subject, $emessage, implode("\r\n", $headers));
			
			$done = "Appointment requested!";
			
		} else {
			
			$error = "Error requesting appointment";
			
		}
	} 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Request appointment</title>
</head>

<body class="body-form">
<!--- Register form --->
<div class="container">
<!--- Card --->
<br>
<div class="card mx-auto" style="max-width: 25rem;">
<div class="card-header">
	<a href='../index.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
</div>
<div class="card-body">	
<form action="" method="POST">
    <fieldset>
		<?php 
		if (isset($error)) {
            echo '<div class="alert alert-danger alert-dismissible">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<Strong>Error! </Strong>' . $error;
            echo '</div>';
        }
		// If the appointment successful display below
		if (isset($done)) {
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Successs! </Strong>' . $done;
			echo '</div>';
			echo "<p>Redirecting to profile in 3 seconds...</p>";
			header("refresh:3;url='../Profile/profile.php'");
		} else { // If appointment not successfully submitted display below
        ?>
        <h1 class="card-title text-center">APPOINTMENT</h1>
        <p class="card-text text-center">Request an appointment with an insurance advisor.</p>
        <!--- Message --->
        <div class="form-group">
            <textarea id="2" type="text" name="message" class="form-control" maxlength="255" placeholder="Message..." autocomplete="off" required title="Enter a message"></textarea>
        </div>
        <br>
        <div class="card text-center">	
        <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </fieldset>
</form>
<?php
		}
?>
</div>
</div>
<!--- Card end above --->
</div>
</body>

</html>
<?php
} else { 
	echo 
	"<div class='container'>
	<br>
	<div class='card mx-auto' style='max-width: 40rem;'>
	<div class='card-body text-center'>	
	<h1>Log in</h1>
	You must be logged logged in to request an appointment<br>
	<a href='../index.php'>Return to home page</a>
	</div>
	</div>
	</div>";
}
?>
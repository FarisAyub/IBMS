<?php
$ROOT = '../'; include $ROOT . 'nav.php'; // Load navigation bar
require('../connect.php'); // Include the connection file
if(isset($_SESSION['username'])){ // If logged in
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form submitted
			
		// Form variables
		$username = $_SESSION['username']; 
		$message = $_POST['message'];
		
		// SQL statement
		$sql = "INSERT INTO `IBMS-Appointments`
		(`Username`, `Message`, `Status`) VALUES 
		('$username', '$message', 'Pending')"; 
			
		if (mysqli_query($connect,$sql)) { // If sql runs
			// Select email of user requesting appointment
			$sql2 = "SELECT `Email` FROM `IBMS-Accounts` WHERE Username='".$username."'";
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
			echo mysqli_error($connect);
			$error = "Error requesting appointment";
			
		}
    } 
    if (isset($done)) { // If appointment requested send page transition
        header("refresh:3;url='../Profile/profile.php'");
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
	<a href='../index.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a> <!-- Go back -->
</div>
<div class="card-body">	
<form action="" method="POST">
    <fieldset>
		<?php 
		if (isset($error)) { // If error display in an alert
            echo '<div class="alert alert-danger alert-dismissible">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<Strong>Error! </Strong>' . $error;
            echo '</div>';
        }
		if (isset($done)) { // If no error display in an alert and redirect
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Successs! </Strong>' . $done;
			echo '</div>';
		} else { // If an appointment aint been subbmited
        ?>
        <h1 class="card-title text-center">APPOINTMENT</h1>
        <p class="card-text text-center">Request an appointment with an insurance advisor.</p>
        <!--- Message --->
        <div class="form-group">
            <textarea id="2" type="text" name="message" class="form-control" maxlength="80" placeholder="Leave a message (max 80 characters)..." autocomplete="off" required title="Enter a message"></textarea>
        </div>
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
} else { // If not logged in
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
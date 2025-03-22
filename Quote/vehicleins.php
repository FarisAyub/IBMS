<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if(isset($_SESSION['username'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$username = $_SESSION['username'];
	$make = $_POST['make'];
	$model = $_POST['model'];
	$manufacyear = $_POST['manufactureyear'];
	$reginput = $_POST['regdate'];
	$policyinput = $_POST['policystart'];
	$regdate = date('Y-m-d', strtotime($reginput));
	$policystart = date('Y-m-d', strtotime($policyinput));
	
	$sql = "INSERT INTO `FYP-Vehicleins`
	(`Username`, `Make`, `Model`, `Manufacture_Year`, `Reg_Date`, `Policy_Start`, `Status`) VALUES 
	('$username', '$make', '$model', '$manufacyear', '$regdate', '$policystart', 'Pending')"; 
		
	if (mysqli_query($connect,$sql)) {
		$sql2 = "SELECT `Email` FROM `FYP-Accounts` WHERE Username='".$username."'";
		$result = mysqli_query($connect, $sql2);
		$row = mysqli_fetch_assoc($result);
		$email = $row['Email'];
		$to = $email; 
		$subject = "Vehicle Insurance Quote Request Successful"; 
		$emessage = "Your request for vehicle insurance for " . $make . " " . $model . " was received successfully!";
	
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
		
		$done = "Quote request successful!";
		
	} else {
		
		$error = "Error submitting quote";
		
	}
} 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Vehicle Insurance</title>
</head>

<body class="body-form">
<!--- Register form --->
<div class="container">
<!--- Card --->
<br>
<div class="card">
<div class="card-header">
	<a href='./quotes.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
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
		// If the account is created the variable is set meaning this message will display and remove registration form
		if (isset($done)) {
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Successs! </Strong>' . $done;
			echo '</div>';
			echo "<p>Redirecting to quotes in 3 seconds...</p>";
			header("refresh:3;url='../Quotes/quotes.php'");
		} else {
        ?>
        <h1 class="card-title">VEHICLE INSURANCE QUOTE</h1>
        <p class="card-text">Please fill in all the fields before selecting the submit button.</p>
        <!--- Make --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Make</p>
            <input id="1" type="text" name="make" class="form-control" size="48" maxlength="255" placeholder="Ford" required>
        </div>
		<!--- Model --->
        <div class="form-group">
       		<p class="card-subtitle mb-2 text-muted">&nbsp;Model</p>
            <input id="2" type="text" name="model" class="form-control" size="48" maxlength="255" placeholder="Focus" required>
        </div>
        <!--- Manufacture year --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Manufacture Year</p>
            <input id="3" type="text" name="manufactureyear" class="form-control" size="48" maxlength="4" placeholder="2015" required pattern="^[0-9]{4}$" required>
        </div>
        <!--- Registration date --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Registration Date</p>
            <input id="4" type="date" name="regdate" value="2018-01-01" class="form-control" required title="Date format">
        </div>
        <!--- Policy start date	 --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Policy Start Date</p>
            <input id="5" type="date" name="policystart" value="2018-01-01" class="form-control" required title="Date format">
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
	You must be logged logged in to request a quote<br>
	<a href='../index.php'>Return to home page</a>
	</div>
	</div>
	</div>";
}
?>
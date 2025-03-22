<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if(isset($_SESSION['username'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
	$username = $_SESSION['username'];
	$ssn = $_POST['ssn'];
	$job = $_POST['job'];
	$employer = $_POST['employer'];
	$hireinput = $_POST['hiredate'];
	$policyinput = $_POST['policystart'];
	$hiredate = date('Y-m-d', strtotime($hireinput));
	$policystart = date('Y-m-d', strtotime($policyinput));
	
	$sql = "INSERT INTO `FYP-Healthins`
	(`Username`, `SSN`, `Job`, `Employer`, `Hire_date`, `Policy_start_date`, `Status`) VALUES 
	('$username', '$ssn', '$job', '$employer', '$hiredate', '$policystart', 'Pending')"; 
		
	if (mysqli_query($connect,$sql)) {
		$sql2 = "SELECT `Email` FROM `FYP-Accounts` WHERE Username='".$username."'";
		$result = mysqli_query($connect, $sql2);
		$row = mysqli_fetch_assoc($result);
		$email = $row['Email'];
		$to = $email; 
		$subject = "Health Insurance Quote Request Successful"; 
		$emessage = "Your request for health insurance for " . $username . " was received successfully!";
	
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
    <title>Health Insurance</title>
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
        <h1 class="card-title">HEALTH INSURANCE QUOTE</h1>
        <p class="card-text">Please fill in all the fields before selecting the submit button.</p>
        <!--- Social Security Number --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Social Security Number (SSN)</p>
            <input id="1" type="text" name="ssn" class="form-control" size="48" maxlength="9" placeholder="192403120" required>
        </div>
        <!--- Occupation/job title --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Occupation/Job Title</p>
            <input id="2" type="text" name="job" class="form-control" size="48" maxlength="255" placeholder="Software developer" required>
        </div>
        <!--- Hire Date --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Hire Date</p>
            <input id="3" type="date" name="hiredate" value="2018-01-01" class="form-control" required title="Date format">
        </div>
        <!--- Employer Name --->
        <div class="form-group">
        	<p class="card-subtitle mb-2 text-muted">&nbsp;Employer Name</p>
            <input id="4" type="text" name="employer" class="form-control" size="48" maxlength="255" placeholder="John Doe" required>
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
<br>
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
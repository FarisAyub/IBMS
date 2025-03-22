<?php
$ROOT = '../../'; include $ROOT . 'nav.php';
require('../../connect.php');
if(isset($_SESSION['username'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
		$selected = $_POST['quote'];
		$array = explode("&&&", $selected);
		$id = $array[0];
		$table = $array[1];
		$username = $array[2];
		$status = $_POST['status'];
		switch ($table) {
		  case "FYP-Homeins":
		  	$row = "homeins_id";
			$em = "home insurance";
			break;
		  case "FYP-Healthins":
		  	$row = "healthins_id";
			$em = "health insurance";
			break;
		  case "FYP-Vehicleins":
		  	$row = "vehins_id";
			$em = "vehicle insurance";
			break;
		  default: 
			$error = "Error submitting update";
		}
		$sql = "UPDATE `$table` SET 
						Status='$status'
				 		WHERE $row='$id';"; 
			
		if (mysqli_query($connect,$sql)) {
			$sql2 = "SELECT `Email` FROM `FYP-Accounts` WHERE Username='".$username."'";
			$result = mysqli_query($connect, $sql2);
			$row = mysqli_fetch_assoc($result);
			$email = $row['Email'];
			$to = $email; 
			$subject = "Quote request updated"; 
			$emessage = "Your quote for " . $em . " was: " . $status . ".";
			$emessage = wordwrap($emessage, 70, "\r\n");
		
			$headers   = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/plain; charset=iso-8859-1";
			$headers[] = "From: IB <noreply@IBMS.com>";
			$headers[] = "Subject: {$subject}";
			$headers[] = "X-Mailer: PHP/".phpversion();
			mail($to, $subject, $emessage, implode("\r\n", $headers));
			
			$done = "Quote completed";
			
		} else {
			
			$error = "Error submitting update";
			
		}
	}
	if ($_SESSION['level'] == "2") {
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Manage quotes</title>
</head>

<body class="body-form">
<div class="container">
<!--- Card --->
<br>
<div class="card mx-auto" style="max-width: 25rem;">
<div class="card-header">
	<a href='./adminpanel.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
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
		}
		$result = mysqli_query($connect, "SELECT * FROM `FYP-Healthins` WHERE Status='Pending'") or die(mysqli_error($connect));
		$result1 = mysqli_query($connect, "SELECT * FROM `FYP-Homeins` WHERE Status='Pending'") or die(mysqli_error($connect));
		$result2 = mysqli_query($connect, "SELECT * FROM `FYP-Vehicleins` WHERE Status='Pending'") or die(mysqli_error($connect));
		$count = mysqli_num_rows($result) + mysqli_num_rows($result1) + mysqli_num_rows($result2);
		if ($count == 0) {
			echo "<h1 class='card-title text-center'>QUOTES</h1>";
			echo "<p class='text-center'>No quotes to append.</p>";
		} else {
        ?>
        <h1 class="card-title text-center">QUOTES</h1>
        <!--- Select quote --->
        <div class="form-group">
            <select multiple id="1" class="form-control" name="quote" required>
            <?php
            while($row = mysqli_fetch_array($result)) {
                echo "<option value='" . $row['healthins_id'] . "&&&FYP-Healthins&&&" . $row['Username'] . "'>" . $row['Job'] . " | " . $row['Username'] . " | Health insurance </option>";
            }
			while($row1 = mysqli_fetch_array($result1)) {
                echo "<option value='" . $row1['homeins_id'] . "&&&FYP-Homeins&&&" . $row1['Username'] . "'>" . $row1['Property'] . " | " . $row1['Username'] . " | Home insurance </option>";
            }
			while($row2 = mysqli_fetch_array($result2)) {
                echo "<option value='" . $row2['vehins_id'] . "&&&FYP-Vehicleins&&&" . $row2['Username'] . "'>" . $row2['Make'] . " " . $row2['Model'] . " | " . $row2['Username'] . " | Vehicle insurance </option>";
            }
            ?>
            </select>
        </div>
        <!--- Status --->
        <div class="form-group">
            <select id="2" class="form-control" name="status" required>
            	<option value="Declined">Declined</option>
                <option value="Pending" selected>Pending</option>
                <option value="Successful">Successful</option>
           </select>
        </div>
        <div class="card text-center">	
        <input class="btn btn-primary" type="submit" value="Submit">
        </div>
        <?php
		}
		?>
    </fieldset>
</form>
</div>
</div>
<!--- Card end above --->
</div>
</body>

</html>
<?php
	} else {
		header("Location: ".$ROOT."index.php");
	}
} else { 
	header("Location: ".$ROOT."index.php");
}
?>
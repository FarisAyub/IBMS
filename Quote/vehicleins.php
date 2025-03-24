<?php
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if(isset($_SESSION['username'])) { // If logged in
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get all vehicle insurance quote request details and assign to variables
    $username = $_SESSION['username'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $manufacyear = $_POST['manufactureyear'];
    $reginput = $_POST['regdate'];
    $policyinput = $_POST['policystart'];
    $policy = $_POST['policy'];
    $regdate = date('Y-m-d', strtotime($reginput));
    $policystart = date('Y-m-d', strtotime($policyinput));
    
    // SQL to insert vehicle insurance quote rest
    $sql = "INSERT INTO `ibms-Vehicleins`
    (`Username`, `Policy_id`, `Make`, `Model`, `Manufacture_Year`, `Reg_Date`, `Policy_Start`, `Status`) VALUES 
    ('$username', '$policy', '$make', '$model', '$manufacyear', '$regdate', '$policystart', 'Pending')"; 
        
    if (mysqli_query($connect,$sql)) { // If query succesful
      $sql2 = "SELECT `Email` FROM `ibms-Accounts` WHERE Username='".$username."'"; // Get email
      $result = mysqli_query($connect, $sql2);
      $row = mysqli_fetch_assoc($result);
      $email = $row['Email'];
      $to = $email; 

      // Send email to let user know their insurance quote was succesfully received
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
      
      $done = "Quote request successful!"; // Set succesful alert message
    } else { // If query failed
      $error = "Error submitting quote"; // Set error alert message
    }
  } 
  if (isset($done)) { // If successful 
    header("refresh:3;url='../Quotes/quotes.php'"); // Redirect in 3 seconds
  }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Vehicle Insurance</title>
</head>

<body class="body-form">
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card mx-auto" style="max-width: 30rem;">
      <div class="card-header">
        <a href='./quotes.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
      </div>
      <div class="card-body">	
        <form action="" method="POST">
          <fieldset>
            <?php 
            if (isset($error)) { // If an error is set, display alert
              echo '<div class="alert alert-danger alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Error! </Strong>' . $error;
              echo '</div>';
            }
            if (isset($done)) { // If successful display alert
              echo '<div class="alert alert-success alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Successs! </Strong>' . $done;
              echo '</div>';
              echo "<p>Redirecting to quotes in 3 seconds...</p>";
              header("refresh:3;url='../Quotes/quotes.php'");
            } else { // If not succesful yet, display
            ?>
              <h1 class="card-title text-center">VEHICLE INSURANCE</h1>
              <p class="card-text">Please fill in all the fields before selecting the submit button.</p>
              <!--- Select policy --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy</p>
                <select multiple class="form-control" name="policy" required>
                  <?php
                  $policies = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Type='Car Insurance'") or die(mysqli_error($connect)); 
                  while($row = mysqli_fetch_array($policies)) { // For all policies create a select option
                    echo "<option value='" . $row['Policy_id']. "'>" . $row['Title'] . " " . $row['Type'] . "</option>";
                  }
                  ?>
                </select>
              </div>
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
} else { // If not logged in
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
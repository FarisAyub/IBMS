<?php
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if(isset($_SESSION['username'])) { // If logged in
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form submitted	
    // Get life insurance form details and assign to variables
    $username = $_SESSION['username'];
    $ssn = $_POST['ssn'];
    $job = $_POST['job'];
    $employer = $_POST['employer'];
    $hireinput = $_POST['hiredate'];
    $policyinput = $_POST['policystart'];
    $policy = $_POST['policy'];
    $hiredate = date('Y-m-d', strtotime($hireinput));
    $policystart = date('Y-m-d', strtotime($policyinput));
    
    // SQL to insert into quote requests for health insurance
    $sql = "INSERT INTO `ibms-Healthins`
    (`Username`, `Policy_id`, `SSN`, `Job`, `Employer`, `Hire_date`, `Policy_start_date`, `Status`) VALUES 
    ('$username', '$policy', '$ssn', '$job', '$employer', '$hiredate', '$policystart', 'Pending')"; 
        
    if (mysqli_query($connect,$sql)) { // If query succesful
      $sql2 = "SELECT `Email` FROM `ibms-Accounts` WHERE Username='".$username."'"; // Get email
      $result = mysqli_query($connect, $sql2);
      $row = mysqli_fetch_assoc($result);
      $email = $row['Email'];
      $to = $email; 

      // Send an email to let user know their insurance request went through
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
      
      $done = "Quote request successful!"; // Set success alert message
    } else { // If query fails
      $error = "Error submitting quote"; // Set error alert message
    }
  } 
  if (isset($done)) { // If succesful query
    header("refresh:3;url='../Quotes/quotes.php'"); // Redirect in 3 seconds
  }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Health Insurance</title>
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
            if (isset($error)) { // If error is set, display alert
              echo '<div class="alert alert-danger alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Error! </Strong>' . $error;
              echo '</div>';
            }
            if (isset($done)) { // If successful, display success alert
                echo '<div class="alert alert-success alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<Strong>Successs! </Strong>' . $done;
                echo '</div>';
                echo "<p>Redirecting to quotes in 3 seconds...</p>";
            } else { // If not successful yet, display
            ?>
              <h1 class="card-title text-center">HEALTH INSURANCE</h1>
              <p class="card-text">Please fill in all the fields before selecting the submit button.</p>
              <!--- Select policy --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy</p>
                <select multiple class="form-control" name="policy" required>
                  <?php
                  $policies = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Type='Health Insurance'") or die(mysqli_error($connect)); 
                  while($row = mysqli_fetch_array($policies)) { // for all policies create select option
                    echo "<option value='" . $row['Policy_id']. "'>" . $row['Title'] . " " . $row['Type'] . "</option>";
                  }
                  ?>
                </select>
              </div>
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
    <br>
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
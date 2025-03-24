<?php
$ROOT = '../../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../../connect.php'); // Include database connection
if(isset($_SESSION['username'])) { // If logged in
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form has been submitted
    // Get values submitted for quote update and assign to variables
    $selected = $_POST['quote'];
    $array = explode("&&&", $selected); // Creates array by splitting string every time 3 and signs are found together
    $id = $array[0]; // First section of array
    $table = $array[1]; // Second section of array
    $username = $array[2]; // Third section of array
    $status = $_POST['status'];
    $quote = $_POST['quoteamount'];

    // Different variables depending on the insurance type given
    switch ($table) {
      case "ibms-Homeins":
        $row = "homeins_id";
        $em = "home insurance";
        break;
      case "ibms-Healthins":
        $row = "healthins_id";
        $em = "health insurance";
        break;
      case "ibms-Vehicleins":
        $row = "vehins_id";
        $em = "vehicle insurance";
        break;
      default: 
        $error = "Error submitting update";
    }

    // SQL to update quote
    $sql = "UPDATE `$table` SET Status='$status', Quote='$quote' WHERE $row='$id';"; 
      
    if (mysqli_query($connect,$sql)) { // If query successful
      // Get email of user
      $sql2 = "SELECT `Email` FROM `ibms-Accounts` WHERE Username='".$username."'";
      $result = mysqli_query($connect, $sql2);
      $row = mysqli_fetch_assoc($result);
      $email = $row['Email'];
      $to = $email; 
      
      // Send email letting user know their quote request was updated
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
      
      $done = "Quote completed"; // Set alery message
        
    } else { // If query fails
      $error = "Error submitting update"; // Set alert error
    }
  }
  if ($_SESSION['level'] == "2") { // If administrator
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
            if (isset($error)) { // If an error is set, display it in an alert
              echo '<div class="alert alert-danger alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Error! </Strong>' . $error;
              echo '</div>';
            }
            if (isset($done)) { // If the appointment successful display alert
              echo '<div class="alert alert-success alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Successs! </Strong>' . $done;
              echo '</div>';
            }
            // SQL gets all quotes that are pending
            $result = mysqli_query($connect, "SELECT * FROM `ibms-Healthins` WHERE Status='Pending'") or die(mysqli_error($connect));
            $result1 = mysqli_query($connect, "SELECT * FROM `ibms-Homeins` WHERE Status='Pending'") or die(mysqli_error($connect));
            $result2 = mysqli_query($connect, "SELECT * FROM `ibms-Vehicleins` WHERE Status='Pending'") or die(mysqli_error($connect));
            // Count of quotes
            $count = mysqli_num_rows($result) + mysqli_num_rows($result1) + mysqli_num_rows($result2);
            if ($count == 0) { // If no quotes, display different content
              echo "<h1 class='card-title text-center'>QUOTES</h1>";
              echo "<p class='text-center'>No quotes to append.</p>";
            } else {
            ?>
              <h1 class="card-title text-center">QUOTES</h1>
              <!--- Select quote --->
              <div class="form-group">
                <select multiple id="1" class="form-control" name="quote" required>
                <?php
                while($row = mysqli_fetch_array($result)) { // Loop through all health insurance
                  echo "<option value='" . $row['healthins_id'] . "&&&ibms-Healthins&&&" . $row['Username'] . "'>" . $row['Job'] . " | " . $row['Username'] . " | Health insurance </option>";
                }
                while($row1 = mysqli_fetch_array($result1)) { // Loop through all home insurance
                  echo "<option value='" . $row1['homeins_id'] . "&&&ibms-Homeins&&&" . $row1['Username'] . "'>" . $row1['Property'] . " | " . $row1['Username'] . " | Home insurance </option>";
                }
                while($row2 = mysqli_fetch_array($result2)) { // Loop through all vehicle insurance
                  echo "<option value='" . $row2['vehins_id'] . "&&&ibms-Vehicleins&&&" . $row2['Username'] . "'>" . $row2['Make'] . " " . $row2['Model'] . " | " . $row2['Username'] . " | Vehicle insurance </option>";
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
              <!-- Quote -->
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" name="quoteamount" class="form-control" size="48" maxlength="255" placeholder="Quote" required>
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
  } else { // If not administrator
    header("Location: ".$ROOT."index.php"); // Redirect to home page
  }
} else { // If not logged in
  header("Location: ".$ROOT."index.php"); // Redirect to home page
}
?>
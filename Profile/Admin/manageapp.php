<?php
$ROOT = '../../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../../connect.php'); // Use connection to database
if(isset($_SESSION['username'])){ // If logged in
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form is submitted
      
    // Get submitted appointment details and assign to variables
    $selected = $_POST['app'];
    $array = explode("&&&", $selected); // Creates array by splitting string every time 3 and signs are found together
    $app = $array[0]; // First section of array
    $username = $array[1]; // Second section of array
    $retmessage = $_POST['ret'];
    $location = $_POST['loc'];
    $date = $_POST['date'];
    $time1 = $_POST['time1'];
    $time2 = $_POST['time2'];
    $time = $time1 . $time2;
    $status = $_POST['status'];
    
    // SQL to update appointment details
    $sql = "UPDATE `ibms-Appointments` SET Return_message='$retmessage', App_loc='$location', App_date='$date', Time='$time', Status='$status' WHERE app_id='$app';"; 
    // Query checks if the appointment date and time set already exists
    $checkifnotexists = mysqli_query($connect, "SELECT * FROM `ibms-Appointments` WHERE App_date='$date' AND Time='$time'") or die(mysqli_error($connect)); 
    $checkcount = mysqli_num_rows($checkifnotexists); // Check if exists
    if ($checkcount >= 1) { // If an appointment is already set on that date AND time, return error
      $error = "Appointmet already set for that date and time";
    } else { // If no appointments set for the time and date, continue
      if (mysqli_query($connect,$sql)) { // If query successful
          // Get the email of user
          $sql2 = "SELECT `Email` FROM `ibms-Accounts` WHERE Username='".$username."'";
          $result = mysqli_query($connect, $sql2);
          $row = mysqli_fetch_assoc($result);
          $email = $row['Email'];
          $to = $email; 
          
          // Send an email to the user to tell them an appointment has been scheduled
          $subject = "Appointment scheduled"; 
          $emessage = "Your request for an appointment has been scheduled, the location for the meeting is at " . $location . " on the date " . $date . " at " . $time . ".";
          
          $emessage = wordwrap($emessage, 70, "\r\n");
      
          $headers   = array();
          $headers[] = "MIME-Version: 1.0";
          $headers[] = "Content-type: text/plain; charset=iso-8859-1";
          $headers[] = "From: IB <noreply@IBMS.com>";
          $headers[] = "Subject: {$subject}";
          $headers[] = "X-Mailer: PHP/".phpversion();
          mail($to, $subject, $emessage, implode("\r\n", $headers));
          
          $done = "Appointment scheduled"; // Set alert message
          
      } else { // If query fails
        $errorstring = mysqli_error($connect);  // Error updating appointments
        if (strpos($errorstring, "Duplicate entry") !== false) { // If the reason for error is duplicate entry
          $error = "Appointment already set for that date and time"; // Display error letting user know the problem
        } else { // If it isn't
          $error = "Error scheduling appointment"; // Just dusplay alert saying error
        }
      }
    }
  }
  if ($_SESSION['level'] == "2") { // If administrator
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Manage appointment</title>
</head>

<body class="body-form">
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card mx-auto">
      <div class="card-header">
        <a href='./adminpanel.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
      </div>
      <div class="card-body">	
        <form action="" method="POST">
          <fieldset>
            <?php 
            if (isset($error)) { // If error is set, show alert 
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
            // Get all appointments which are still pending
            $result = mysqli_query($connect, "SELECT * FROM `ibms-Appointments` WHERE Status='Pending'") or die(mysqli_error($connect));
            $count = mysqli_num_rows($result); // Total amount of results
            if ($count == 0) { // If no pending appointments, display different content to let user know
              echo "<h1 class='card-title text-center'>APPOINTMENT</h1>";
              echo "<p class='text-center'>No appointments to schedule</p>";
            } else { // If appointments exist
            ?>
              <h1 class="card-title text-center">APPOINTMENT</h1>
              <!--- Select request --->
              <div class="form-group">
                <select multiple id="6" class="form-control" name="app" required>
                <?php
                while($row = mysqli_fetch_array($result)) {
                  echo "<option value='" . $row['app_id'] . "&&&" . $row['Username'] . "'>" . $row['app_id'] . " | " . $row['Username'] . " | ". $row['Message'] ."</option>";
                }
                ?>
                </select>
              </div>
              <!--- Status --->
              <div class="form-group">
                <select class="form-control" name="status" required>
                  <option value="Declined">Declined</option>
                  <option value="Pending" selected>Pending</option>
                  <option value="Successful">Successful</option>
                </select>
              </div>
              <!--- Return Message --->
              <div class="form-group">
                <textarea id="1" type="text" name="ret" class="form-control" maxlength="255" placeholder="Return Message..." autocomplete="off" required title="Enter a return message"></textarea>
              </div>
              <!--- Location --->
              <div class="form-group">
                <input id="2" type="text" name="loc" class="form-control" size="48" maxlength="255" placeholder="Location" required>
              </div>
              <!--- Date --->
              <div class="form-group">
                <input id="3" type="date" name="date" value="2019-01-01" class="form-control" required title="Date">
              </div>
              <!--- Time --->
              <div class="form-group">
                <select id="4" class="form-control" name="time1" style="width: 75%; display: inline;" required>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select id="5" class="form-control" name="time2" style="width: 20%; display: inline;" required>
                  <option value="AM">AM</option>
                  <option value="PM">PM</option>
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
  } else { // If not admin
    header("Location: ".$ROOT."index.php"); // Redirect to home page
  }
} else { // If not logged in
  header("Location: ".$ROOT."index.php"); // Redirect to home page
}
?>
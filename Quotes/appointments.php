<?php 
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if(isset($_SESSION['username'])) {  // If logged in
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Insurance Brokerage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    
<body>
  <div class="container">
    <br>
    <h1 class="display-3"><p class="text-center text-white bg-dark">Appointments</p></h1>
    <div class="row">
      <?php
      $username = $_SESSION['username']; // Username
      $result = mysqli_query($connect, "SELECT * FROM `IBMS-Appointments` WHERE `Username`='$username'") or die(mysqli_error($connect)); // Get all appointments
      $appcount = mysqli_num_rows($result); // Count the rows
      $counter = 0; // New counter
      if ($appcount == 0) { // if no appointments
      ?>
        <div class="card mx-auto" style="max-width: 24rem;">
          <div class="card-body text-center">
            You have no appointments.
          </div>
        </div>
      <?php
      } else { // If appointments    
        while ($row = mysqli_fetch_array($result)) { // For all appointments
          $counter++; // Increment counter
          $datetocheck = $row['App_date']; // Date to variable
          if ($datetocheck == "0000-00-00") { // If date is default
              $date = ""; // Set variable to blank
          } else { // If date is set
              $date = date("d-m-Y", strtotime($datetocheck)); // Change format of date to date - month - year
          }
          ?>
          <div class="col-sm-4">
            <div class="card" style="max-width: 24rem;">
              <div class="card-header text-center">
                <!-- Status of appointment -->
                <h5 class="card-title"><?=$row['Status']?></h5>
                <!-- Date and time of appointment -->
                <div class="input-group mb-3">  
                  <!-- Date of appointment -->
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?=$date?>" disabled>
                  <!-- Time of appointment -->
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?=$row['Time']?>" disabled>
                </div>
                <!-- Location of appointment -->
                <div class="input-group mb-3">  
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?=$row['App_loc']?>" disabled>
                </div>
                <!-- Message from user -->
                <div class="input-group mb-3">  
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                  </div>
                  <textarea class="form-control" aria-label="With textarea" disabled><?=$row['Message']?></textarea>
                </div>
                <!-- Reply with appointment -->
                <div class="input-group mb-3">  
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-reply"></i></span>
                  </div>
                  <textarea class="form-control" aria-label="With textarea" disabled><?=$row['Return_message']?></textarea>
                </div>
              </div>
            </div>
          </div>
          <?php
          if ($counter == 3) { // when 3 appointments
            $counter = 0; // Reset counter
            echo '</div><br><div class="row">';  // End row and start new row (this enables 3 appointments per row consistently)
          } 
        }
      }
      ?>
  </div>
</body>
 
</html>

<?php 
} else { // If not logged in
  echo 
  "<div class='container'>
  <h1>Log in to access this page</h1>
  </div>";
}
?>
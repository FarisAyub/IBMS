<?php 
$ROOT = '../../'; // Absolute path to start of directory
include $ROOT . 'nav.php'; // Include navigation bar
require('../../connect.php'); // Include database connection
if(isset($_SESSION['username'])) { // If user is logged in
	if ($_SESSION['level'] == "2") { // And the user is administrator
    ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Insurance Brokerage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
</head>
    
<body>
  <br>
  <div class="container">
    <!-- Card with buttons as an admin panel -->
    <div class="card card-dark">
      <div class="card-header text-center">
        &nbsp;Admin Panel
      </div>
      <!-- In main card -->
      <div class="card-body">
        <div class="row">
          <div class="col-sm">
            <!-- Green card which is used as a button with a design, links to database management page -->
            <div class="card card-green">
              <a class="card-full" href="./adminmanage.php"></a>
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-xs-3">
                    <i class="far fa-edit fa-5x"></i>
                  </div>
                  <div class="col text-center">
                    <a class="link-normal" href="./adminmanage.php"><h1 class="display-4" style="font-size: 30px;">Database</h1></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm">
            <!-- Red card which works as a button and links to the manage appointments page -->
            <div class="card card-red">
              <a class="card-full" href="./manageapp.php"></a>
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-xs-3">
                    <i class="far fa-calendar-alt fa-5x"></i>
                  </div>
                  <div class="col text-right">
                    <a class="link-normal" href="./manageapp.php"><h1 class="display-4" style="font-size: 30px;">Appointments</h1></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm">
            <!-- Blue card that functions as a button that links to the manage quotes page -->
            <div class="card card-blue">
              <a class="card-full" href="./manageq.php"></a>
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-xs-3">
                    <i class="fas fa-file-signature fa-5x"></i>
                  </div>
                  <div class="col text-center">
                    <a class="link-normal" href="./manageq.php"><h1 class="display-4" style="font-size: 30px;">Quotes</h1></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php 
	} else { // If the user is not ad admin
		header("Location: ".$ROOT."index.php"); // Redirect to home page
	}
} else { // If the user is not logged in
	header("Location: ".$ROOT."index.php"); // Redirect to home page
}
?>
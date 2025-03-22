<?php 
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if(isset($_SESSION['username'])){ 
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
    <?php
	$username = $_SESSION['username'];
	$result = mysqli_query($connect, "SELECT * FROM `FYP-Appointments` WHERE `Username`='$username'") or die(mysqli_error($connect));
	while ($row = mysqli_fetch_array($result)) {
		if ($row['Status'] == "Successful") {
			echo "<div class='card card-green'>";
		} else {
			echo "<div class='card card-red'>";
		}
	?>
        <div class="card-header text-center">
        <h5 class="card-title">Appointment ID <?=$row['app_id']?></h5>
        <!-- Rows of content -->
          <div class="row">
            <div class="col">
                <b>
                Message<br>
                Response<br>
                Location<br>
                Date<br>
                Time<br>
                </b>
            </div>
            <div class="col">
				<i>
				<?=$row['Message']?><br>
                <?=$row['Return_message']?><br>
                <?=$row['App_loc']?><br>
                <?=$row['App_date']?><br>
                <?=$row['Time']?><br>
                </i>
            </div>
          </div>
        <!-- Rows end -->
        </div>
    </div>
    <br>
	<?php 
	}
	?>
  </div>
</body> 
</html>
<?php 
} else {
	echo 
	"<div class='container'>
	<h1>Log in to access this page</h1>
	</div>";
}
?>
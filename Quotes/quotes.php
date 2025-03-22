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
    <!-- 3 columns -->
    <div class="row">
    <!-- Column 1 -->
    <div class="col">
    <h1 class="display-3"><p class="text-center text-white bg-dark">HOME</p></h1>
    <?php
	$username = $_SESSION['username'];
	$resulthome = mysqli_query($connect, "SELECT * FROM `FYP-Homeins` WHERE `Username`='$username'") or die(mysqli_error($connect));
	$resultveh = mysqli_query($connect, "SELECT * FROM `FYP-Vehicleins` WHERE `Username`='$username'") or die(mysqli_error($connect));
	$resulthealth = mysqli_query($connect, "SELECT * FROM `FYP-Healthins` WHERE `Username`='$username'") or die(mysqli_error($connect));
	while ($row = mysqli_fetch_array($resulthome)) {
	?>
    <!-- Home insurance -->
    <div class="card">
        <div class="card-body text-center">
        <h5 class="card-title">Quote ID <?=$row['homeins_id']?></h5>
        <?php
		switch ($row['Status']) {
		  case "Declined":
		  	echo "<span class='badge badge-danger'>Declined</span>";
			break;
		  case "Pending":
		  	echo "<span class='badge badge-warning'>Pending</span>";
			break;
		  case "Successful":
		  	echo "<span class='badge badge-success'>Successful</span>";
			break;
		  default: 
			echo "<span class='badge badge-warning'>Pending</span>";
		}
		?>
        <br><br>
        <!-- Rows of content -->
          <div class="row">
            <div class="col">
                <b>
                Property<br>
                Year built<br>
                Purchase date<br>
                Policy start date<br>
                Bedroom count<br>
                Square footage<br>
                Stories<br>
                Purchase price<br>
                </b>
            </div>
            <div class="col">
				<i>
				<?=$row['Property']?><br>
                <?=$row['Year_built']?><br>
                <?=$row['Purchase_date']?><br>
                <?=$row['Policy_start_date']?><br>
                <?=$row['Bedroom_count']?><br>
                <?=$row['Square_footage']?><br>
                <?=$row['Stories']?><br>
                <?=$row['Purchase_price']?><br>
                </i>
            </div>
          </div>
        <!-- Rows end -->
        </div>
    </div>
    <br>
	<?php 
	}
	echo "</div><div class='col'><h1 class='display-3'><p class='text-center text-white bg-dark'>VEHICLE</p></h1>"; // Column 2
	while ($row1 = mysqli_fetch_array($resultveh)) {
	?>
    <!-- Vehicle insurance -->
    <div class="card">
        <div class="card-body text-center">
        <h5 class="card-title">Quote ID <?=$row1['vehins_id']?></h5>
        <?php
		switch ($row1['Status']) {
		  case "Declined":
		  	echo "<span class='badge badge-danger'>Declined</span>";
			break;
		  case "Pending":
		  	echo "<span class='badge badge-warning'>Pending</span>";
			break;
		  case "Successful":
		  	echo "<span class='badge badge-success'>Successful</span>";
			break;
		  default: 
			echo "<span class='badge badge-warning'>Pending</span>";
		}
		?>
        <br><br>
        <!-- Rows of content -->
          <div class="row">
            <div class="col">
                <b>
                Make<br>
                Model<br>
                Manufacture year<br>
                Registration date<br>
                Policy start date<br>
                </b>
            </div>
            <div class="col">
				<i>
				<?=$row1['Make']?><br>
                <?=$row1['Model']?><br>
                <?=$row1['Manufacture_year']?><br>
                <?=$row1['Reg_Date']?><br>
                <?=$row1['Policy_Start']?><br>
                </i>
            </div>
          </div>
        <!-- Rows end -->
        </div>
    </div>
    <br>
    <?php
	}
	echo "</div><div class='col'><h1 class='display-3'><p class='text-center text-white bg-dark'>HEALTH</p></h1>"; // Column 3
	while ($row2 = mysqli_fetch_array($resulthealth)) { 
	?>
    <!-- Health insurance -->
    <div class="card">
        <div class="card-body text-center">
        <h5 class="card-title">Quote ID <?=$row2['healthins_id']?></h5>
        <?php
		switch ($row2['Status']) {
		  case "Declined":
		  	echo "<span class='badge badge-danger'>Declined</span>";
			break;
		  case "Pending":
		  	echo "<span class='badge badge-warning'>Pending</span>";
			break;
		  case "Successful":
		  	echo "<span class='badge badge-success'>Successful</span>";
			break;
		  default: 
			echo "<span class='badge badge-warning'>Pending</span>";
		}
		?>
        <br><br>
        <!-- Rows of content -->
          <div class="row">
            <div class="col">
                <b>
                SSN<br>
                Job<br>
                Employer<br>
                Hire date<br>
                Policy start date<br>
                </b>
            </div>
            <div class="col">
				<i>
				<?=$row2['SSN']?><br>
                <?=$row2['Job']?><br>
                <?=$row2['Employer']?><br>
                <?=$row2['Hire_date']?><br>
                <?=$row2['Policy_start_date']?><br>
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
    <!-- Column end -->
    </div>
    <!-- Row end -->
    </div>
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
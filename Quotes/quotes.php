<?php 
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if(isset($_SESSION['username'])) {  // if logged in
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
    <div class="row">
      <!-- Column 1 -->
      <div class="col">
        <h1 class="display-3"><p class="text-center text-white bg-dark">HOME</p></h1>
        <?php
        $username = $_SESSION['username']; // Username
        // All requested quotes
        $resulthome = mysqli_query($connect, "SELECT * FROM `ibms-Homeins` WHERE `Username`='$username'") or die(mysqli_error($connect));
        $resultveh = mysqli_query($connect, "SELECT * FROM `ibms-Vehicleins` WHERE `Username`='$username'") or die(mysqli_error($connect));
        $resulthealth = mysqli_query($connect, "SELECT * FROM `ibms-Healthins` WHERE `Username`='$username'") or die(mysqli_error($connect));
        $homecount = mysqli_num_rows($resulthome);
        $vehcount = mysqli_num_rows($resultveh);
        $healthcount = mysqli_num_rows($resulthealth);
        if ($homecount == 0) { // If 0 quotes display this instead
        ?>
          <div class="card">
            <div class="card-body text-center">
              You have no home insurance quote requests.
            </div>
          </div>
        <?php
        } else {
          while ($row = mysqli_fetch_array($resulthome)) { // For all rows
            $policyid = $row['Policy_id']; // Policy id
            $policy = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Policy_id='$policyid'") or die(mysqli_error($connect)); // Get the policy details
            $polrow = mysqli_fetch_array($policy); // Assign policy details
            ?>
            <!-- Home insurance -->
            <div class="card">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$polrow['img']?>" alt="policy" height="200px">
              <div class="card-body text-center">
                <?php
                switch ($row['Status']) { // Policy status display badge
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
                $monthly = floor($row['Quote'] / 12);
                ?>
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
              <div class="card-footer text-center">
                Annual: <?php echo "$".$row['Quote'];?> | Monthly: <?php echo "$".$monthly; ?>
              </div>
            </div>
            <br>
          <?php 
          }
        }
        ?>
      </div>
      <!-- Column 2 -->
      <div class="col">
        <h1 class="display-3"><p class="text-center text-white bg-dark">VEHICLE</p></h1>
        <?php
        if ($vehcount == 0) { // If vehicle insurance count 0 display this instead
        ?>
          <div class="card">
            <div class="card-body text-center">
              You have no vehicle insurance quote requests.
            </div>
          </div>
        <?php
        } else {
          while ($row1 = mysqli_fetch_array($resultveh)) {
            $policyid = $row1['Policy_id']; // Policy id
            $policy = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Policy_id='$policyid'") or die(mysqli_error($connect)); // Get all policy details
            $polrow = mysqli_fetch_array($policy); // Assign to variable
            ?>
            <!-- Vehicle insurance -->
            <div class="card">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$polrow['img']?>" alt="policy" height="200px">
              <div class="card-body text-center">
                <?php
                switch ($row1['Status']) { // Display badge for policy status
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
              <div class="card-footer text-center">
                You Quote is: $<?=$row1['Quote']?>
              </div>
            </div>
            <br>
        <?php
          }
        }
        ?>
      </div>
      <!-- Column 3 -->
      <div class="col">
        <h1 class="display-3"><p class="text-center text-white bg-dark">HEALTH</p></h1>
        <?php
        if ($healthcount == 0) { // If health insurance count is 0 display following
        ?>
          <div class="card">
            <div class="card-body text-center">
              You have no health insurance quote requests.
            </div>
          </div>
        <?php
        } else {
          while ($row2 = mysqli_fetch_array($resulthealth)) { 
            $policyid = $row2['Policy_id']; // Policy id
            $policy = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Policy_id='$policyid'") or die(mysqli_error($connect)); // Get all policy details
            $polrow = mysqli_fetch_array($policy); // Assign to a variable
            ?>
            <!-- Health insurance -->
            <div class="card">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$polrow['img']?>" alt="policy" height="200px">
              <div class="card-body text-center">
                <?php
                switch ($row2['Status']) { // Check status and display different badge
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
              <div class="card-footer text-center">
                You Quote is: $<?=$row2['Quote']?>
              </div>
            </div>
            <br>
          <?php 
          }
        }
        ?>
      </div>
    </div>
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
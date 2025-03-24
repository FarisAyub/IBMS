<?php
ob_start(); // Prevents header errors
require($ROOT.'connect.php'); // Opens database connection on all pages
if(!isset($_SESSION['username'])) { // If not logged in
	session_start(); // Start session
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <!-- Font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" type="text/css">
  <!--- Bootstrap --->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!--- My stylesheet --->
  <link rel="stylesheet" href="<?php echo $ROOT;?>style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark sm-text">
  <div class="container">
  <a class="navbar-brand" href="<?=$ROOT?>index.php"><img src="<?=$ROOT?>favicon.ico" alt="IBMS" width="48" height="15"></a>
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Policies/viewpolicies.php"><i class="fas fa-eye"></i> Policies</a></li>&nbsp;
      <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Quote/quotes.php"><i class="fas fa-comments-dollar"></i> Quote</a></li>&nbsp;
      <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Appointment/appointment.php"><i class="fas fa-clock"></i> Appointment</a></li>&nbsp;
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php
      if(!isset($_SESSION['username'])) { // If the user is not logged in show:
      ?>
        <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Register/register.php"> <i class="fas fa-pencil-alt"></i> Register</a></li>&nbsp;
        <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Login/login.php"> <i class="fas fa-sign-in-alt"></i> Log in</a></li>
      <?php
      } else { // If the user is logged in show:
        $username = $_SESSION['username'];
        $result = mysqli_query($connect, "SELECT * FROM `IBMS-Accounts` WHERE `Username`='$username'") or die(mysqli_error($connect));
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbardrop" role="button">
              <img src="<?=$ROOT?>Profile/Avatar/<?=$row['AvatarId']?>.svg" class="rounded-circle" alt="Profile" width="24" height="24">
              <?=$_SESSION['username']?>
              <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="<?=$ROOT?>Profile/profile.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-user-alt"></i>
                  </div>
                  <div class="col-8">
                    P<span class="lowc">rofile</span>
                  </div>
                </div>
              </a>
              <a class="dropdown-item" href="<?=$ROOT?>Quotes/quotes.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-comments-dollar"></i>
                  </div>
                  <div class="col-8">
                    Q<span class="lowc">uotes</span>
                  </div>
                </div>
              </a>
              <a class="dropdown-item" href="<?=$ROOT?>Quotes/appointments.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-calendar-alt"></i>
                  </div>
                  <div class="col-8">
                    A<span class="lowc">ppointments</span>
                  </div>
                </div>                     
              </a>
              <a class="dropdown-item" href="<?=$ROOT?>Profile/preferences.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-cog"></i>
                  </div>
                  <div class="col-8">
                    P<span class="lowc">references</span>
                  </div>
                </div>
              </a>	
              <?php if ($_SESSION['level'] == 2) { ?>
              <a class="dropdown-item" href="<?=$ROOT?>Profile/Admin/adminpanel.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-cogs"></i>
                  </div>
                  <div class="col-8">
                    A<span class="lowc">dmin</span>
                  </div>
                </div>
              </a>
              <?php } ?>
              <a class="dropdown-item" href="<?=$ROOT?>Login/logout.php">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-sign-out-alt"></i>
                  </div>
                  <div class="col-8">
                    L<span class="lowc">ogout</span>
                  </div>
                </div>               
              </a>
            </div>
          </li>
        <?php 	
        }
      }
      ?>
    </ul>
  </div>
  </nav>
</body>

</html>
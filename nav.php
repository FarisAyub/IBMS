<?php
// if not logged in start session
if(!isset($_SESSION['username'])) {
	session_start();
	require($ROOT.'connect.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--- Navbar included on all pages so stylesheet referenced in all pages --->
    <!--- Open source --->
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--- Bootstrap 4 --->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!--- My stylesheet --->
    <link rel="stylesheet" href="<?php echo $ROOT;?>style.css">
    <!--- Title --->
    <title>Navigation</title>
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
            <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Register/register.php"> <span class="fa fa-pencil"></span> Register</span></a></li>&nbsp;
            <li class="nav-item"><a class="nav-link" href="<?=$ROOT?>Login/login.php"> <span class="fa fa-sign-in"></span> Log in</span></a></li>
	<?php
        } else { // If the user is logged in show:
			$username = $_SESSION['username'];
			$result = mysqli_query($connect, "SELECT * FROM `FYP-Accounts` WHERE `Username`='$username'") or die(mysqli_error($connect));
			while ($row = mysqli_fetch_array($result)) {
    ?>
            <li class="nav-item dropdown">
            	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbardrop" role="button">
					<img src="<?=$ROOT?>Profile/Avatar/<?=$row['AvatarId']?>.svg" class="rounded-circle" alt="Profile" width="24" height="24">
                    <?=$_SESSION['username']?>
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?=$ROOT?>Profile/profile.php"> <span class="fa fa-user"></span>&nbsp;&nbsp;P<span class="lowc">rofile</span></a>
                    <a class="dropdown-item" href="<?=$ROOT?>Quotes/quotes.php"> <span class="fa fa-user"></span>&nbsp;&nbsp;Q<span class="lowc">uotes</span></a>
                    <a class="dropdown-item" href="<?=$ROOT?>Quotes/appointments.php"> <span class="fa fa-user"></span>&nbsp;&nbsp;A<span class="lowc">ppointments</span></a>
                    <a class="dropdown-item" href="<?=$ROOT?>Profile/preferences.php"> <span class="fa fa-cog"></span>&nbsp;&nbsp;P<span class="lowc">references</span></a>	
                    <?php 
					if ($_SESSION['level'] == 2) {
						echo '<a class="dropdown-item" href="'. $ROOT .'Profile/Admin/adminpanel.php"> <span class="fa fa-cogs"></span>&nbsp;&nbsp;A<span class="lowc">dmin</span></a>';
					} 
					?>
                    <a class="dropdown-item" href="<?=$ROOT?>Login/logout.php"> <span class="fa fa-sign-out"></span>&nbsp;&nbsp;L<span class="lowc">ogout</span></a>
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
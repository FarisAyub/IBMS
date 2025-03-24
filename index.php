<!DOCTYPE html>

<html lang="en">

<head>
  <title>Insurance Brokerage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<!-- Navigation bar -->
<?php $ROOT = './'; include $ROOT.'nav.php'; ?>

<div class="container">
  <?php 
  if (isset($_SESSION['preferences'])) { // If preferences are set 
    if ($_SESSION['preferences'] == "Not") { // If preferences are set to not then display alert
    ?>
      <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong>Preferences not set!</strong> Set your <a href="<?$ROOT?>Profile/preferences.php" class="alert-link">preferences</a> to receive custom recommendations!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <!-- Gets recommendations from php file -->
    <?php 
    }
  }
  if (isset($_SESSION['username'])) { // If logged in
    include $ROOT.'reccomendation.php'; // Include recommedation system
    $id = $preferenceRow['Policy_id']; // Checks star rating of id
    include $ROOT.'Policies/stars.php'; // Convert rating to icons
  ?> 
    <!-- Reccomender cards start -->
    <div class="card card-dark-matt text-center">
      <div class="card-header text-center">Recommendations for you</div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="inner-image">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$preferenceRow['img']?>" alt="No organisation image" height="300px">
              <div class="hover">
                <div class="text">
                  <br><?=$preferenceRow['Title']?><br><br><?=$preferenceRow['Description']?><br><br><p class="text-warning"><?=$stars?></p>
                </div>
              </div>
            </div>
          </div>
          <?php 
          $id = $popularRow['Policy_id']; // Checks star rating of id
          include $ROOT.'Policies/stars.php'; // Convert rating to icons
          ?>
          <div class="col">
            <div class="inner-image">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$popularRow['img']?>" alt="No organisation image" height="300px">
              <div class="hover">
                <div class="text">
                  <br><?=$popularRow['Title']?><br><br><?=$popularRow['Description']?><br><br><p class="text-warning"><?=$stars?></p>
                </div>
              </div>
            </div>
          </div>
          <?php 
          $id = $popularRow['Policy_id']; // Checks star rating of id
          include $ROOT.'Policies/stars.php'; // Convert rating to icons
          ?>
          <div class="col">
            <div class="inner-image">
              <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$RowS['img']?>" alt="No organisation image" height="300px">
              <div class="hover">
                <div class="text">
                  <br><?=$RowS['Title']?><br><br><?=$RowS['Description']?><br><br><p class="text-warning"><?=$stars?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }
  ?>
	<br>
	<!-- Reccomender cards end -->
	<div class="jumbotron">
		<h1 class="display-4">IBMS</h1>
		<p class="lead">Insurance Brokerage Management System.</p>
		<hr class="my-4">
		<p>Welcome to IBMS the insurance broker management site. Here you can view all the great insurance policies and find one that suits you!</p>
		<a class="btn btn-primary btn-lg" href="<?=$ROOT?>Policies/viewpolicies.php" role="button">View policies!</a>
	</div>

</div>

</body>
</html>
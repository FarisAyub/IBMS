<!DOCTYPE html>
<html lang="en">
<head>
  <title>Insurance Brokerage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div><?php $ROOT = '../'; include $ROOT.'nav.php'; ?></div>
<div class="container">
<br>

<div class="row">

  <div class="col-sm">
    <div class="card card-dark">
      <div class="fade-zoom">
        <img class="card-img-top" src="<?=$ROOT?>Images/homeins.jpg" alt="Home Insurance">
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Home insurance</h5>
        <p class="card-text">
        Home insurance is an insurance which covers your private residence. The insurance covers various damage to the house such as
        damage to the contents of the house, liability insurance for damage caused by the house owner of the house under policy and natural disasters.<br><br>
        </p>
        <a href="./homeins.php" class="btn btn-primary">Request quote</a>
      </div>
    </div>
  </div>
  
  <div class="col-sm">
    <div class="card card-dark">
      <div class="fade-zoom">
  	    <img class="card-img-top" src="<?=$ROOT?>Images/healthins.jpg" alt="Health Insurance">
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Health insurance</h5>
        <p class="card-text">
        Health insurance covers the cost of medical treatments.
		Health insurance is a monthly subscription which is a percentage of the medical conditions that you have while you are insured.<br><br><br><br>
        </p>
        <a href="./lifeins.php" class="btn btn-primary">Request quote</a>
      </div>
    </div>
  </div>
  
  <div class="col-sm">
    <div class="card card-dark">
      <div class="fade-zoom">
        <img class="card-img-top" src="<?=$ROOT?>Images/vehicleins.jpeg" alt="Vehicle Insurance">
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Vehicle insurance</h5>
        <p class="card-text">
        Vehicle insurance is insurance which is used for cars, trucks, vans, motorcycles and various other road vehicles. The purpose of vehicle insurance is to
		protect yourself financially against any accidents that happen to you or your vehicle.<br><br><br>
        </p>
        <a href="./vehicleins.php" class="btn btn-primary">Request quote</a>
      </div>
    </div>
  </div>
  
</div>
	
</div>
</body>
</html>
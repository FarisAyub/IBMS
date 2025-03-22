<!DOCTYPE html>
<html lang="en">
<head>
  <title>Insurance Brokerage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div><?php $ROOT = './'; include $ROOT.'nav.php'; ?></div>
<div class="container">
<br>
	<!-- Reccomender cards start -->
	<div class="card card-dark-matt text-center">
        <div class="card-header text-center">Recommendations for you</div>
        <div class="card-body">
        	<div class="row">
                <?php 
                // Get 3 policies with highest view count from data table and get the associated details from policies table for each
                $sqltop3 = "SELECT * FROM `FYP-Data` INNER JOIN `FYP-Policies` ON `FYP-Data`.Policy_id = `FYP-Policies`.Policy_id ORDER BY Views DESC LIMIT 3";
                $result = mysqli_query($connect, $sqltop3) or die(mysqli_error($connect));
                while ($row = mysqli_fetch_array($result)) { // Go through all 3 elements and display the top 3 viewed 
                ?>
                <div class="col">
                    <div class="inner-image">
                        <img class="card-img-top zoom" src="<?=$ROOT?>Images/<?=$row['img']?>" alt="No organisation image" height="300px">
                         <div class="hover">
                            <div class="text">
                                <br><?=$row['Title']?><br><br><?=$row['Description']?><br><br>
                            </div>
                         </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
	</div>
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
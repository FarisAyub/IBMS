<?php 
$ROOT = '../../';
include $ROOT . 'nav.php';
require('../../connect.php');
if(isset($_SESSION['username'])){ 
	if ($_SESSION['level'] == "2") {
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
		<div class="card card-dark">
          <div class="card-header text-center">
            &nbsp;Admin Panel
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-sm">
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
                      <div class="card card-blue">
                      <a class="card-full" href="#"></a>
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
	} else {
		header("Location: ".$ROOT."index.php");
	}
} else {
	header("Location: ".$ROOT."index.php");
}
?>
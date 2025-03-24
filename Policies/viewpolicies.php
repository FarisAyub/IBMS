<?php

$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if ($_SERVER["REQUEST_METHOD"] == "POST") { // If form has been submitted
	if (isset($_POST['delete'])) { // If the form submitted was delete form
		// Get variable names
		$deleteid = $_POST['deleteid'];
		$sqlx = "SELECT img FROM `IBMS-Policies` WHERE Policy_id='$deleteid'";
		$result = mysqli_query($connect, $sqlx);
		$value = mysqli_fetch_object($result);
		$imgname = $value->img;
		echo $deleteid;

		// Series of SQL to run whenever a policy is deleted (has to be removed from all sources)
		
		$sqldel = "DELETE FROM `IBMS-Data` WHERE Policy_id='$deleteid';"; // Query to delete from data table
		$sqldel .= "DELETE FROM `IBMS-Likes` WHERE Policy_id='$deleteid';"; // Query to delete from likes table
		$sqldel .= "DELETE FROM `IBMS-Homeins` WHERE Policy_id='$deleteid';"; // Query to delete from home insurance table
		$sqldel .= "DELETE FROM `IBMS-Healthins` WHERE Policy_id='$deleteid';"; // Query to delete from health insurance table
		$sqldel .= "DELETE FROM `IBMS-Vehicleins` WHERE Policy_id='$deleteid';"; // Query to delete from vehicle insurance table
		$sqldel .= "DELETE FROM `IBMS-Policies` WHERE Policy_id='$deleteid';"; // Query to delete from policy table
		
		// Multi query executes both at same time to prevent problems if 1 executes and other doesnt (inconsistent data)
		if (mysqli_multi_query($connect,$sqldel)) { 
			$myFile = "../Images/".$imgname; // Path to the file of policy deleted
			if ($imgname == "defaultpol.jpg") { // Check if it is default image
			} else { // If it isn't delete it, if it is, keep it
				unlink($myFile) or die("Couldn't delete file"); // Delete file
      }
      header("Location: viewpolicies.php");
		} else {
      header("Location: viewpolicies.php");
		}
	} else if (isset($_POST['add'])){ // If the form submitted was add form
		// Add form values
		$policytitle = $_POST['poltitle'];
		$policytype = $_POST['poltype'];
		$policydes = $_POST['poldesc'];
		// Upload file
		$target_dir = "../Images/";
		$file = $_FILES['fileToUpload']['name'];
		$target_file = $target_dir . $file;
		$uploadOk = 1; // If value ever becomes 0, upload failed
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		// Check if image file is a actual image or not
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$_SESSION['error'] = "File is not an image.";
				$uploadOk = 0;
			}
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			$_SESSION['error'] = "Sorry, file already exists.";
			$uploadOk = 0;
		}

		// Check file size meets requirements
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$_SESSION['error'] = "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Only allow JPG/JPEG or PNG
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$_SESSION['error'] = "Sorry, only JPG, JPEG or PNG allowed";
			$uploadOk = 0;
		}

		// Check if any of conditions not met
		if ($uploadOk == 0) {
			// if everything is ok, try to upload file
		} else {
			$name = basename($_FILES["fileToUpload"]["name"]);
			$sql = "INSERT INTO `IBMS-Policies`
			(`Title`, `Type`, `Description`, `img`) VALUES 
			('$policytitle', '$policytype' , '$policydes', '$name')"; 
			if (mysqli_query($connect,$sql)) { // If file is ready to upload and sql upload is ok
				$sqlgetter = "SELECT MAX(Policy_id) AS 'Policy_id' FROM `IBMS-Policies`"; // Select largest (latest added for auto increment) value
				$getterresult = mysqli_query($connect, $sqlgetter) or die(mysqli_error($connect)); // Execute sql and assign it to a variable
				$instance = mysqli_fetch_array($getterresult); // Creating an instance of the SQL
				$policyid = $instance['Policy_id']; // Gets the latest id added into policies to be used to create the data entry for it
				$sql2 = "INSERT INTO `IBMS-Data` (`Policy_id`, `Views`) VALUES ('$policyid', '0')"; // Add data row
				mysqli_query($connect,$sql2); // Execute SQL
				$_SESSION['done'] = "Policy was added to database successfully!"; // Success message
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file); // Upload the file
			} else { // If SQL failed
				$_SESSION['error'] = "Could not add policy!";
			}
		}	
	} else if (isset($_POST['close']) && isset($_SESSION['username'])) { // If the form submitted was close form whilst logged in

    	$do = false; // Don't run next result unless it's set
		$orig = $_POST['orig']; // Get original like status
		$likestatus = $_POST['valstatus']; // Get new like status
		$user = $_SESSION['username']; // Username
		$polied = $_POST['polied']; // Get policy id
		$radio = $_POST['radio']; // Get rating
		$checker = "SELECT * FROM `IBMS-Likes` WHERE Username='$user' AND Policy_id='$polied'"; // Get previous like/rating
		$checkerresults = mysqli_query($connect, $checker); // Execute SQL

		if (mysqli_num_rows($checkerresults) == 1) { // if row already exists, update
			$sqlA = "UPDATE `IBMS-Likes` SET `Liked` = '$likestatus', `Rating` = '$radio' WHERE `Username`='$user' AND `Policy_id`='$polied';";
		} else { // If row doesn't exist, insert it
			$sqlA = "INSERT INTO `IBMS-Likes` (`Username`, `Policy_id`, `Liked`, `Rating`) VALUES ('$user', '$polied', '$likestatus', '$radio');";
		}

    if ($likestatus == 1 && $likestatus !== $orig) { // If liked and previously wasn't
      $sqlA .= "UPDATE `IBMS-Data` SET `Likes` = `Likes` + 1 WHERE Policy_id='$polied'"; // Update status
      $do = true; // clears for next result
		} else if ($likestatus == '0' && $likestatus !== $orig) { // If disliked but previously liked
      $sqlA .= "UPDATE `IBMS-Data` SET `Likes` = `Likes` - 1 WHERE Policy_id='$polied'"; // Update status
      $do = true; // clears for next result
    }
    
    mysqli_multi_query($connect,$sqlA); // Run SQL
    if ($do) { // Only run if there is an sql to update
      mysqli_next_result($connect);
    }
	}
}
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
		<?php 
		if (isset($_SESSION['error'])) { // If error was received, display in alert
			echo '<div class="alert alert-danger alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Error! </Strong>' . $_SESSION['error'];
      echo '</div>';
      unset($_SESSION['error']);
		}
		if (isset($_SESSION['done'])) { // If successful display alert to show it
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Successs! </Strong>' . $_SESSION['done'];
      echo '</div>';
      unset($_SESSION['done']);
		}
		?>
		<!--- Cards start --->
		<div class="row">
			<?php
			// Select policies
			$resultPol = mysqli_query($connect, "SELECT * FROM `IBMS-Policies`") or die(mysqli_error($connect));
			$counter = 0;
			while ($rowPol = mysqli_fetch_array($resultPol)) { // For all policies
        $counter += 1; // Counter increments by 1 and keeps track of amount of policies entered
        $id = $rowPol['Policy_id'];
				include './stars.php'; // Include the star variable 
				?>
				<div class="col-sm-4">
					<!-- Displays the content over image with hover and colour change -->
					<div class="inner-image">
						<!-- Image of policy -->
						<img class="card-img-top" src="<?=$ROOT?>Images/<?=$rowPol['img']?>" alt="No organisation image" height="300px">
						<div class="hover">
							<div class="text">
									<!-- Content of policies, all details and the star rating -->
									<br><?=$rowPol['Title']?> <?=$rowPol['Type']?><br><br><?=$rowPol['Description']?><br><br><p class="text-warning"><?=$stars?></p>
									<!-- Form submit to view policy -->
									<form name="modform" style="display: inline;">
										<input type="text" value="<?=$rowPol['Policy_id']?>" name="id" hidden>
										<button type="submit" name="mod" class="btn btn-primary">View policy</button>
									</form>	
									<?php
									if (isset($_SESSION["level"])) { // If logged in
										if ($_SESSION["level"] == "2") { // If admin, display delete button
											?>
											<!-- Form submits to delete policy --> 
											<form action="" method="POST" style="display: inline;">
												<input id="3" type="hidden" name="deleteid" value="<?=$rowPol['Policy_id']?>">
												<button type="submit" name="delete" class="btn btn-danger" value="Submit">X</button>
											</form>
											<?php
										}
									}
									?>			
							</div>
						</div>
					</div>
				</div>
				<?php
				if ($counter == 3) { // When 3 policies have been listed
					$counter = 0; // Counter resets to 0 for next 3 policies
					echo '</div><br><div class="row">'; // The row is ended and a new one is started so that policies are displayed in rows of 3
				}
			}
			if (isset($_SESSION['level'])) { // If logged in
				if ($_SESSION['level'] == "2") { // If admin
					echo '<div class="col-sm-4">
						<div class="card card-dark" style="max-height: 300px;">
							<button type="button" class="policy-add" data-toggle="modal" data-target="#add">
								<img class="card-img-top" src="'.$ROOT.'Images/add.png" alt="Card image cap" height="300px">
							</button>
						</div>
					</div>'; // Show button to add new policy
				}
			}
			?>
		</div>
		<br>
		<!-- Modal to view a policy -->
		<div class="modal fade" id="policy" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<!-- Form is submittable for rating/likes -->
					<form method="POST">
						<!-- Contains all modal content from modal.php -->
						<div id="policy_detail">	
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Add policy modal -->
		<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">ADD POLICY</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form start -->
						<form action="" method="POST" enctype="multipart/form-data">
							<fieldset>
								<p>Please fill in policy detail fields</p>
								<div class="form-group">
									<input type="file" name="fileToUpload" id="fileToUpload" required>
								</div>
								<div class="form-group">
									<input id="1" type="text" name="poltitle" class="form-control" size="255" maxlength="255" placeholder="Policy title..." autocomplete="on" required title="Enter the policy title.">
								</div>
								<div class="form-group">
									<select multiple class="form-control" id="3" name="poltype" required>
										<option value="Car Insurance">Car Insurance</option>
										<option value="Home Insurance">Home Insurance</option>
										<option value="Health Insurance">Health Insurance</option>
									</select>
								</div>
								<div class="form-group">
									<textarea id="2" type="text" name="poldesc" class="form-control" maxlength="255" placeholder="Policy descrition..." autocomplete="on" required title="Enter the description of the policy."></textarea>
								</div>
								<div class="card text-center">	
									<input class="btn btn-primary" name="add" type="submit" value="Submit">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
		if ( window.history.replaceState ) { // Prevents refresh form submit
			window.history.replaceState( null, null, window.location.href );
		}
		$('#policy').on('show.bs.modal', function () {
			// when the user clicks on like
			$('.like').on('click', function(){
				document.getElementById('vallike').value = '1';
				document.getElementById('like').disabled = true;
				document.getElementById('unlike').disabled = false;
			});

			// when the user clicks on unlike
			$('.unlike').on('click', function(){
				document.getElementById('vallike').value = '0';
				document.getElementById('like').disabled = false;
				document.getElementById('unlike').disabled = true;
			});
		});
		$(function () {
			$('body').on('submit', "form[name='modform']", function(e) {
				e.preventDefault();
				$.ajax({
				type: 'post',
				url: 'modal.php',
				data: $(this).serialize(),
				success: function (data) {
					$('#policy_detail').html(data);  
					$('#policy').modal("show");
				}
				});
			});
		});
		</script>
	</div>
</body>

</html>
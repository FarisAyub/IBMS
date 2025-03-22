<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['delete'])) {
		// If delete
		$deleteid = $_POST['deleteid'];
		$sqlx = "SELECT img FROM `FYP-Policies` WHERE Policy_id='$deleteid'";
		$result = mysqli_query($connect, $sqlx);
		$value = mysqli_fetch_object($result);
		$imgname = $value->img;
		$sqldel = "DELETE FROM `FYP-Policies` WHERE Policy_id='$deleteid';"; // Query to delete from policy table
		$sqldel .= "DELETE FROM `FYP-Data` WHERE Policy_id='$deleteid';"; // Query to delete from data table
		$sqldel .= "DELETE FROM `FYP-Likes` WHERE Policy_id='$deleteid';"; // Query to delete from likes table
		if (mysqli_multi_query($connect,$sqldel)) { // Multi query executes both at same time to prevent problems if 1 executes and other doesnt (inconsistent data)
			$myFile = "../Images/".$imgname;
			if ($imgname == "defaultpol.jpg") {
			} else {
				unlink($myFile) or die("Couldn't delete file");
			}
			$done = "Policy was deleted from database!";
		} else {
			$error = "Could not remove policy";
		}
	} else if (isset($_POST['add'])){
		// Add form values
		$policytitle = $_POST['poltitle'];
		$policytype = $_POST['poltype'];
		$policydes = $_POST['poldesc'];
		// Upload file
		$target_dir = "../Images/";
		$file = $_FILES['fileToUpload']['name'];
		$target_file = $target_dir . $file;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$error = "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			$error = "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$error = "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$error = "Sorry, only JPG, JPEG or PNG allowed";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		// if everything is ok, try to upload file
		} else {
			$name = basename($_FILES["fileToUpload"]["name"]);
			$sql = "INSERT INTO `FYP-Policies`
			(`Title`, `Type`, `Description`, `img`) VALUES 
			('$policytitle', '$policytype' , '$policydes', '$name')"; 
			if (mysqli_query($connect,$sql)) { // If file is ready to upload and sql upload is ok
				$sqlgetter = "SELECT MAX(Policy_id) AS 'Policy_id' FROM `FYP-Policies`"; // Select largest (latest added for auto increment) value
				$getterresult = mysqli_query($connect, $sqlgetter) or die(mysqli_error($connect)); // Execute sql and assign it to a variable
				$instance = mysqli_fetch_array($getterresult); // Creating an instance of the sql
				$policyid = $instance['Policy_id']; // Gets the latest id added into policies to be used to create the data entry forr it
				$sql2 = "INSERT INTO `FYP-Data`
							(`Policy_id`, `Views`) VALUES 
							('$policyid', '0')";
				mysqli_query($connect,$sql2); // add in the data value row for the newly created policy
				$done = "Policy was added to database successfully!"; // Success
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file); // Upload the file
			} else {
				$error = "Could not add policy!";
			}
		}	
	} else if (isset($_POST['close']) && isset($_SESSION['username'])) {
		$orig = $_POST['orig'];
		$likestatus = $_POST['valstatus'];
		$user = $_SESSION['username'];
		$polied = $_POST['polied'];
		$radio = $_POST['radio'];
		$checker = "SELECT * FROM `FYP-Likes` WHERE Username='$user' AND Policy_id='$polied'";
		$checkerresults = mysqli_query($connect, $checker);
		if (mysqli_num_rows($checkerresults) == 1) { // Update
			$sqlA = "UPDATE `FYP-Likes` SET `Liked` = '$likestatus', `Rating` = '$radio' WHERE `Username`='$user' AND `Policy_id`='$polied';";
		} else { // Insert
			$sqlA = "INSERT INTO `FYP-Likes` (`Username`, `Policy_id`, `Liked`, `Rating`) VALUES ('$user', '$polied', '$likestatus', '$radio');";
		}
		if ($likestatus == 1 && $likestatus !== $orig) { // Like
			$sqlA .= "UPDATE `FYP-Data` SET `Likes` = `Likes` + 1 WHERE Policy_id='$polied'";
		} else if ($likestatus == '0' && $likestatus !== $orig) { // Dislike
			$sqlA .= "UPDATE `FYP-Data` SET `Likes` = `Likes` - 1 WHERE Policy_id='$polied'";
		}
		mysqli_multi_query($connect,$sqlA);
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
if (isset($error)) {
	echo '<div class="alert alert-danger alert-dismissible">';
	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	echo '<Strong>Error! </Strong>' . $error;
	echo '</div>';
}
if (isset($done)) {
	echo '<div class="alert alert-success alert-dismissible">';
	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	echo '<Strong>Successs! </Strong>' . $done;
	echo '</div>';
}
?>
<!--- Cards start --->
<div class="row">
<?php
require('../connect.php');
$result = mysqli_query($connect, "SELECT * FROM `FYP-Policies`") or die(mysqli_error($connect));
$counter = 0;
while ($row = mysqli_fetch_array($result)) {
	$counter += 1; //counter incrememnts by 1 and keeps track of amount of policies entered
	$id = $row['Policy_id'];
	$ratingRoundSQL = "SELECT ROUND(AVG(`rating`) * 2, 0) / 2 AS avg FROM `FYP-Likes` WHERE Policy_id='$id' AND Rating > 0";
	$ratingRoundResult = mysqli_query($connect, $ratingRoundSQL);
	$ratingRow = mysqli_fetch_array($ratingRoundResult);
	$one_decimal_place = number_format($ratingRow['avg'], 1);
	if ($one_decimal_place == 0.0) {
		$one_decimal_place = "N/A";
	}
	?>
	<div class="col-sm">
        <div class="inner-image">
            <img class="card-img-top" src="<?=$ROOT?>Images/<?=$row['img']?>" alt="No organisation image" height="300px">
            <div class="hover">
                <div class="text">
                    <br><?=$row['Title']?> <?=$row['Type']?><br><br><?=$row['Description']?><br><br><?=$one_decimal_place?> <i class="fas fa-star"></i><br>
                    <form name="modform" style="display: inline;">
                    <input type="text" value="<?=$row['Policy_id']?>" name="id" hidden>
                    <button type="submit" name="mod" class="btn btn-primary">View policy</button>
                    </form>	
                    <?php
                    if (isset($_SESSION["level"])) {
                        if ($_SESSION["level"] == "2"){
                    ?>
                    	<form action="" method="POST" style="display: inline;">
                            <input id="3" type="hidden" name="deleteid" value="<?=$row['Policy_id']?>">
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
	if ($counter == 3) { //when 3 policies have been listed
	$counter = 0; //counter resets to 0 for next 3 policies
	echo '</div><br><div class="row">'; //the row is ended and a new one is started so that policies are displayed in rows of 3
	}
}
if (isset($_SESSION['level'])) {
	if ($_SESSION['level'] == "2"){
		echo '<div class="col">
				<div class="card card-dark" style="width: 20rem; height: 20rem;">
					<button type="button" class="policy-add" data-toggle="modal" data-target="#add">
						<img class="card-img-top" src="'.$ROOT.'Images/add.png" alt="Card image cap">
					</button>
				</div>
			</div>';
	}
}
?>
</div>
<!--- Cards end --->
	<br>
<!-- Modal View-->
<div class="modal fade" id="policy" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST">
        <div id="policy_detail">	<!-- Contains all modal content -->
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Add-->
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
					  <option value="Vehicle Insurance">Vehicle Insurance</option>
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
	  <!-- Form end -->
      </div>
    </div>
  </div>
</div>
<!--- Modal end --->
<!-- Prevent refresh resubmitting form -->
<script>
if ( window.history.replaceState ) {
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
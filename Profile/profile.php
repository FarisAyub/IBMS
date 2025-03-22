<?php 
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if(isset($_SESSION['username'])){ 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['avatar'])) {
			// If avatar is selected
			$avatarid = $_POST['avatar'];
			$username = $_SESSION['username'];
			$sql = "UPDATE `FYP-Accounts` SET AvatarId='$avatarid' WHERE Username='$username'";
			mysqli_query($connect,$sql);
			header("Location: ".$ROOT."Profile/profile.php");
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
    <?php
	$username = $_SESSION['username'];
	$result = mysqli_query($connect, "SELECT * FROM `FYP-Accounts` WHERE `Username`='$username'") or die(mysqli_error($connect));
	while ($row = mysqli_fetch_array($result)) {
	?>
		<input type="image" src="Avatar/<?=$row['AvatarId']?>.svg" alt="Profile Avatar" width="300px" height="300px" class="rounded mx-auto d-block" data-toggle="modal" data-target="#avatar">
		<br>
        <div class="card card-dark mx-auto" style="max-width: 35rem;">
          <div class="card-header text-center">
            &nbsp;<?=$row['Username']?>'s Profile
          </div>
          <div class="card-body">
            <p class="card-text">
            <?php
			if (isset($_GET['updated'])) {
				$done = $_GET['updated'];
				if ($done == "true") {
					echo '<div class="alert alert-success alert-dismissible">';
					echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
					echo '<Strong>Success!</Strong> Details updated!';
					echo '</div>';
				}
			}
        	?>
            Welcome to your profile, you can edit and view your account details here.
            <?php 
			if ($_SESSION['level'] == "2"){
				echo "Administrator rights are active.";
			}
			?>
            <table class='table table-bordered'>
            <!-- Password -->
            <tr>
            <td width="18%"><b>Password</b></td>
            <td width="82%">********</td>
            </tr>
            <!-- Email -->
            <tr>
            <td><b>Email</b></td>
            <td><?=$row['Email']?></td>
            </tr>
            <!-- Name -->
            <tr>
            <td><b>Name</b></td>
            <td><?=$row['Name']?></td>
            </tr>
            <!-- Gender -->
            <tr>
            <td><b>Gender</b></td>
            <td><?=$row['Gender']?></td>
            </tr>
            <!-- Age -->
            <tr>
            <td><b>Age</b></td>
            <td><?=$row['Age']?></td>
            </tr>
            <!-- Phone number -->
            <tr>
            <td><b>Phone number</b></td>
            <td><?=$row['Phone']?></td>
            </tr>
            <!-- Street -->
            <tr>
            <td><b>Street</b></td>
            <td><?=$row['Street']?></td>
            </tr>
            <!-- Country -->
            <tr>
            <td><b>Country</b></td>
            <td><?=$row['Country']?></td>
            </tr>
            <!-- Account created date -->
            <tr>
            <td><b>Created</b></td>
            <td><?=$row['Created']?></td>
            </tr>
            </table>
            </p>
          </div>
          <div class="card-footer text-center">
          <a href="./editaccount.php?sub=acc" class="btn btn-primary">Edit Account Details</a>&emsp;
          <?php 
		  if ($row['Access'] == 2) {
		  ?>
          <a href="<?=$ROOT?>Profile/Admin/adminmanage.php" class="btn btn-primary">Management</a>&emsp;
          <?php
		  }
		  ?>
          <a href="./editaccount.php?sub=per" class="btn btn-primary">Edit Personal Details</a>
          </div>
        </div>
		<?php } ?>
      </div>
		<!-- Modal Avatar select-->
		<div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
			  <h5 class="modal-title">Select Avatar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
			  <!-- Form start -->
				  <form action="" method="POST">
					<fieldset>
						<div class="form-group">
							<button type="submit" class="empty-button" name="avatar" value="ava1">
								<img src="Avatar/ava1.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava2">
								<img src="Avatar/ava2.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava3">
								<img src="Avatar/ava3.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava4">
								<img src="Avatar/ava4.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava5">
								<img src="Avatar/ava5.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava6">
								<img src="Avatar/ava6.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava7">
								<img src="Avatar/ava7.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava8">
								<img src="Avatar/ava8.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava9">
								<img src="Avatar/ava9.svg" alt="Profile Avatar">
							</button>
							<button type="submit" class="empty-button" name="avatar" value="ava10">
								<img src="Avatar/ava10.svg" alt="Profile Avatar">
							</button>
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
		</script>
        <br>
    </body>
    
</html>
<?php 
} else {
	header("Location: ".$ROOT."index.php");
}
?>
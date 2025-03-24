<?php
$ROOT = '../'; 
session_start(); // Start session
require('../connect.php'); // Open database connection
if ($_POST) { // If modal is submitted
	// For policy info
	$modid = $_POST['id']; 
	$upd = "UPDATE `IBMS-Data` SET `Views`=`Views`+1 WHERE Policy_id='".$modid."'";
	$selectquery = "SELECT * FROM `IBMS-Policies` WHERE Policy_id='".$modid."'";
	$selectresult = mysqli_query($connect, $selectquery) or die(mysqli_error($connect));
	$row = mysqli_fetch_array($selectresult);
	$title = $row['Title'];
	$description = $row['Description'];
	
	// For like/rating
	if (isset($_SESSION['username'])) { // If logged in
		$user = $_SESSION['username']; // Username
		$likeresults = mysqli_query($connect, "SELECT * FROM `IBMS-Likes` WHERE Username='".$user."' AND Policy_id='".$modid."'");
		$rates = array(0, 1, 2, 3, 4, 5); // Array of like options
		$exec = mysqli_query($connect, $upd) or die(mysqli_error($connect));
	}
	?>
	<!-- Header -->
	<div class='modal-header'>
		<h5 class='modal-title w-100 text-center' id='title'><?=$title?></h5>
	</div>
	<!-- Body -->
	<div class='modal-body'>
		<?=$description?>
	</div>
	<input type='text' hidden name='polied' value='<?=$modid?>'>
	<div class='modal-footer'>
    <div class='container'>
      <div class='row'>
        <div class='col' style='display: inline;'>
					<?php
					if (isset($_SESSION['username'])) { // If logged in
						$row = mysqli_fetch_array($likeresults); // Get likes
						if (!is_null($row)) {
							if ($row['Liked'] == 1) { // If it's liked set button to liked
            		?>
              <button id='like' disabled class='like btn btn-success' onclick='return false'><i class='fas fa-thumbs-up'></i></button>
              <button id='unlike' class='unlike btn btn-danger' onclick='return false'><i class='far fa-thumbs-down'></i></button>
              <input type='text' id='vallike' hidden name='valstatus' value='1'>
              <input type='text' hidden name='orig' value='1'>
            <?php
            } else { // If it is not liked, display not liked button
            ?>
              <button id='like' class='like btn btn-success' onclick='return false'><i class='fas fa-thumbs-up'></i></button>
              <button id='unlike' disabled class='unlike btn btn-danger' onclick='return false'><i class='far fa-thumbs-down'></i></button>
              <input type='text' id='vallike' name='valstatus' hidden value='0'>
              <input type='text' hidden name='orig' value='0'>
          <?php
            }
			} else {
				?>
				<button id='like' class='like btn btn-success' onclick='return false'><i class='fas fa-thumbs-up'></i></button>
              	<button id='unlike' class='unlike btn btn-danger' onclick='return false'><i class='far fa-thumbs-down'></i></button>
              	<input type='text' id='vallike' name='valstatus' hidden value='0'>
              	<input type='text' hidden name='orig' value='0'>
				<?php
			}
          }
          ?>
        </div>
        <div class='col-5 text-center'>
          <?php
					if (isset($_SESSION['username'])) { // If logged in
						// Get my rating of the policy
						$likeresults = mysqli_query($connect, "SELECT * FROM `IBMS-Likes` WHERE Username='".$user."' AND Policy_id='".$modid."'");
						$row = mysqli_fetch_array($likeresults);
						if (!is_null($row)) {
							$rating = $row['Rating'];
						}
							if ($row != null && $rating != null) { // If i have a rating
								foreach ($rates as $rate) { // Create  select option with selected value as previously selected
									if ($rate == $rating) { // For previous selected
										echo '<label class="radio-inline">';
										if ($rate == 0) {
											echo '<input type="radio" name="radio" value="'. $rate. '" checked hidden>'; 
										} else {	
											echo '<input type="radio" name="radio" value="'. $rate. '" checked> ' . $rate . '&nbsp;'; 
										}
										echo '</label>';
									} else { // For not selected
										echo '<label class="radio-inline">';
										if ($rate == 0) {
											echo '<input type="radio" name="radio" value="'. $rate. '" hidden>';
										} else {
											echo '<input type="radio" name="radio" value="'. $rate. '"> ' . $rate . '&nbsp;'; 
										}
										echo '</label>';
									}
								}
							} else { // If i have no rating
								foreach ($rates as $rate) {
									echo '<label class="radio-inline">';
									if ($rate == 0) {
										echo '<input type="radio" name="radio" value="'. $rate. '" checked hidden>'; 
									} else {
										echo '<input type="radio" name="radio" value="'. $rate. '"> ' . $rate. '&nbsp;'; 
									}
									echo '</label>';
								}
							}

					}
					?>
        </div>
        <div class='col text-right'>
            <input type='submit' name='close' value='Close' class='btn btn-secondary'>
        </div>
      </div>
    </div>
	</div>
<?php
}
?>
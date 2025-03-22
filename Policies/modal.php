<?php
$ROOT = '../';
session_start();
require('../connect.php');
if ($_POST) {
	// For policy info
	$modid = $_POST['id'];
	$upd = "UPDATE `FYP-Data` SET `Views`=`Views`+1 WHERE Policy_id='".$modid."'";
	$selectquery = "SELECT * FROM `FYP-Policies` WHERE Policy_id='".$modid."'";
	$selectresult = mysqli_query($connect, $selectquery) or die(mysqli_error($connect));
	$row = mysqli_fetch_array($selectresult);
	$title = $row['Title'];
	$description = $row['Description'];
	
	// For like/rating
	if (isset($_SESSION['username'])) {
		$user = $_SESSION['username'];
		$likeresults = mysqli_query($connect, "SELECT * FROM `FYP-Likes` WHERE Username='".$user."' AND Policy_id='".$modid."'");
		$rates = array(0, 1, 2, 3, 4, 5);
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
					if (isset($_SESSION['username'])) {
						$row = mysqli_fetch_array($likeresults);
						if ($row['Liked'] == 1) {
                    ?>
                            <button id='like' disabled class='like btn btn-success' onclick='return false'><i class='fas fa-thumbs-up'></i></button>
                            <button id='unlike' class='unlike btn btn-danger' onclick='return false'><i class='far fa-thumbs-down'></i></button>
                            <input type='text' id='vallike' hidden name='valstatus' value='1'>
                            <input type='text' hidden name='orig' value='1'>
                    <?php
                    	} else {
                    ?>
                            <button id='like' class='like btn btn-success' onclick='return false'><i class='fas fa-thumbs-up'></i></button>
                            <button id='unlike' disabled class='unlike btn btn-danger' onclick='return false'><i class='far fa-thumbs-down'></i></button>
                            <input type='text' id='vallike' name='valstatus' hidden value='0'>
                            <input type='text' hidden name='orig' value='0'>
                    <?php
                    	}
					}
                    ?>
                </div>
                <div class='col-5 text-center'>
                    <?php
					if (isset($_SESSION['username'])) {
						$likeresults = mysqli_query($connect, "SELECT * FROM `FYP-Likes` WHERE Username='".$user."' AND Policy_id='".$modid."'");
						$row = mysqli_fetch_array($likeresults);
						$rating = $row['Rating'];
						if ($rating != null) {
							foreach ($rates as $rate) {
								if ($rate == $rating) {
									echo '<label class="radio-inline">';
									if ($rate == 0) {
										echo '<input type="radio" name="radio" value="'. $rate. '" checked hidden>'; 
									} else {	
										echo '<input type="radio" name="radio" value="'. $rate. '" checked> ' . $rate . '&nbsp;'; 
									}
									echo '</label>';
								} else {
									echo '<label class="radio-inline">';
									if ($rate == 0) {
										echo '<input type="radio" name="radio" value="'. $rate. '" hidden>';
									} else {
										echo '<input type="radio" name="radio" value="'. $rate. '"> ' . $rate . '&nbsp;'; 
									}
									echo '</label>';
								}
							}
						} else {
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
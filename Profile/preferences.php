<?php
$ROOT = '../'; include $ROOT . 'nav.php';
require('../connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$field1 = $_POST['field1'];
	$field2 = $_POST['field2'];
	$field3 = $_POST['field3'];
	$field4 = $_POST['field4'];
	
	$sql = "INSERT INTO `FYP-Preferences`
	(`Preference_1`, `Preference_2`, `Preference_3`, `Preference_4`) VALUES 
	('$field1', '$field2', '$field3', '$field4')"; 
		
	if (mysqli_query($connect,$sql)) {
		
		$done = "Preferences set!";
		
	} else {
		
		$error = "Invalid preferences selected";
		
	}
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Preferences</title>
</head>

<body>
<!--- Register form --->
<div class="container">
<!--- Card --->
<br>
<div class="card">
<div class="card-body">	
<form action="" method="POST">
    <fieldset>
		<?php 
		if (isset($error)) {
            echo '<div class="alert alert-danger alert-dismissible">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<Strong>Error! </Strong>' . $error;
            echo '</div>';
        }
		// If the account is created the variable is set meaning this message will display and remove registration form
		if (isset($done)) {
			echo '<div class="alert alert-success alert-dismissible">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<Strong>Successs! </Strong>' . $done;
			echo '</div>';
		} else {
        ?>
        <h1 class="card-title">Preferences</h1>
        <p class="card-text">Please fill in fields in order of preference with the most desirable preference at the top.</p>
        <!--- Preference 1 --->
        <div class="form-group">
          <select class="form-control" name="field1">
			<option selected disabled hidden>Select first preference...</option>
			<option value="Cost">Cost</option>
			<option value="Name">Name</option>
			<option value="Another filter">Another filter</option>
			<option value="Last filter">Last filter</option>
		  </select>
        </div>
        <!--- Preference 2 --->
        <div class="form-group">
          <select class="form-control" name="field2">
			<option selected disabled hidden>Select second preference...</option>
			<option value="Cost">Cost</option>
			<option value="Name">Name</option>
			<option value="Another filter">Another filter</option>
			<option value="Last filter">Last filter</option>
		  </select>
        </div>
		<!--- Preference 3 --->
        <div class="form-group">
          <select class="form-control" name="field3">
			<option selected disabled hidden>Select third preference...</option>
			<option value="Cost">Cost</option>
			<option value="Name">Name</option>
			<option value="Another filter">Another filter</option>
			<option value="Last filter">Last filter</option>
		  </select>
        </div>
        <!--- Preference 4 --->
        <div class="form-group">
          <select class="form-control" name="field4">
			<option selected disabled hidden>Select last preference...</option>
			<option value="Cost">Cost</option>
			<option value="Name">Name</option>
			<option value="Another filter">Another filter</option>
			<option value="Last filter">Last filter</option>
		  </select>
        </div>
        <br>
        <div class="card text-center">	
        <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </fieldset>
	<script>
    function showPassword() {
        var x = document.getElementById("2");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</form>
<?php
		}
?>
</div>
<div class="card-footer text-right">
	<a href='./profile.php'>Skip&nbsp;<i class="fas fa-chevron-right"></i></a>
</div>
</div>
<!--- Card end above --->
</div>
</body>

</html>
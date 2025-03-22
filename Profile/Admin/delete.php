<?php
include('../../connect.php');
// Check url variable
if (isset($_GET['id'])) {
    // Id variable
    $id = $_GET['id'];
	// Table variable
	$table = $_GET['frm'];
	// Local variable
	$query = "";
	if ($table == "a") { // Home insurance
		$query = "DELETE FROM `FYP-Homeins` WHERE homeins_id=$id";
	} else if ($table == "b") { // Health insurance
		$query = "DELETE FROM `FYP-Healthins` WHERE healthins_id=$id";
	} else if ($table == "c") { // Vehicle insurance
		$query = "DELETE FROM `FYP-Vehicleins` WHERE vehins_id=$id";
	} else if ($table == "d") { // Accounts
		$query = "DELETE FROM `FYP-Accounts` WHERE Username='$id'";
	} else if ($table == "e") { // Policies
		$query = "DELETE FROM `FYP-Policies` WHERE Policy_id=$id";
	} else if ($table == "f") { // Appointments
		//$query = "DELETE FROM FYP-Appointments WHERE app_id=$id";
	}
	echo $query;
	// Execute query
	mysqli_query($connect, $query) or die(mysqli_error($connect));
}
header("Location: adminmanage.php");
?>
<?php
include('../../connect.php'); // Include database connection
if (isset($_GET['id'])) { // If a URL was selected to read the page
    $id = $_GET['id']; // Get unique id of the row being deleted
    $table = $_GET['frm']; // Get the table that delete was sent from
    $query = ""; // Variable initialisation

    if ($table == "a") { // Home insurance
        $query = "DELETE FROM `ibms-Homeins` WHERE homeins_id=$id"; // Delete the row
        mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    } else if ($table == "b") { // Health insurance
        $query = "DELETE FROM `ibms-Healthins` WHERE healthins_id=$id"; // Delete the row
        mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    } else if ($table == "c") { // Vehicle insurance
        $query = "DELETE FROM `ibms-Vehicleins` WHERE vehins_id=$id"; // Delete the row
        mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    } else if ($table == "d") { // Accounts
        $query = "DELETE FROM `ibms-Accounts` WHERE Username='$id'"; // Delete the row
        mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    } else if ($table == "e") { // Policies
        $query = "DELETE FROM `ibms-Policies` WHERE Policy_id=$id;"; // Delete the row
        $query .= "DELETE FROM `ibms-Data` WHERE Policy_id=$id"; // Delete the data
        $query .= "DELETE FROM `ibms-Likes` WHERE Policy_id='$id';"; // Delete the likes
        $query .= "DELETE FROM `ibms-Homeins` WHERE Policy_id='$id';"; // Delete the insurance quotes for the policy
        $query .= "DELETE FROM `ibms-Healthins` WHERE Policy_id='$id';"; // Delete the insurance quotes for the policy
        $query .= "DELETE FROM `ibms-Vehicleins` WHERE Policy_id='$id';"; // Delete the insurance quotes for the policy
        $sqlx = "SELECT img FROM `ibms-Policies` WHERE Policy_id='$id'"; // Get the image associated
        $result = mysqli_query($connect, $sqlx); // Execute query
        $value = mysqli_fetch_object($result); // Get the object
        $imgname = $value->img; // Get image name
        if (mysqli_multi_query($connect, $query)) { // If delete from tables worked
            $myFile = "../Images/".$imgname; // Path to the policies image
            if ($imgname == "defaultpol.jpg") { // If the policy is the default policy image, do nothing
            } else { // If it isn't defalt
                unlink($myFile) or die("Couldn't delete file"); // Delete the file
            }
        } else { // If the delete query fails (shouldn't ever really happen)
            echo "error"; // Display an error (shouldn't be reached)
        }
    } else if ($table == "f") { // Appointments
        $query = "DELETE FROM ibms-Appointments WHERE app_id=$id"; // Delete row
        mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    }
}
header("Location: adminmanage.php"); // Redirect back to administrator management page
?>
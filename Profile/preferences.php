<?php
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include connection to database
if (isset($_SESSION['username'])) {
  $insurancetypes = array("Car Insurance", "Home Insurance", "Vehicle Insurance"); // Array of preference 1 options
  $preference2 = array("Popular", "Requested"); // Array of preference 2 options
  $user = $_SESSION['username']; // Username
  $query = "SELECT * FROM `IBMS-Preferences` WHERE Username='$user'"; // Get all preferences of logged in user
  $result = mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute sql
  $row = mysqli_fetch_array($result); // Store details

  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form has been submitted
    $user = $_SESSION['username']; // Get username
    $field1 = $_POST['field1']; // Get preference 1
    $field2 = $_POST['field2']; // Get preference 2

    // SQL to insert preferences, also uses update instead of already exists
    $sql = "INSERT INTO `IBMS-Preferences` (`Username`, `Preference_1`, `Preference_2`) VALUES('$user', '$field1', '$field2') ON DUPLICATE KEY UPDATE `Preference_1`='$field1', `Preference_2`='$field2'"; 
    if (mysqli_query($connect,$sql)) { // If query successful
      $_SESSION['preferences'] = 'Set'; // Update session variable to set
      $done = "Preferences set!"; // Set success alert
      header("Location: preferencessuccess.php"); // Go to success page
    } else { // If query fails
      $error = "Invalid preferences selected"; // Set error alert
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
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card mx-auto" style="max-width: 25rem;">
      <div class="card-body">	
        <form action="" method="POST">
          <fieldset>
            <?php 
            if (isset($error)) { // If an error is set, display in alert
              echo '<div class="alert alert-danger alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Error! </Strong>' . $error;
              echo '</div>';
            }
            if (isset($done)) { // If the account is created the variable is set meaning this message will display and remove preference form
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
                <p class="card-subtitle mb-2 text-muted">&nbsp;I am interested in...</p>
                <select class="form-control" name="field1" required>
                  <option disabled hidden value="">Select first preference...</option>
                  <?php
                  foreach ($insurancetypes as $insurance) { // Loop through all preference 1 options
                    if ($insurance == $row['Preference_1']) { // If current set preference is found, set to selected
                      echo '<option value="' . $insurance . '" selected>' . $insurance . '</option>';
                    } else { // All others not selected
                      echo '<option value="' . $insurance . '">' . $insurance . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!--- Preference 2 --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Reccomend policies based on...</p>
                <select class="form-control" name="field2" required>
                  <option disabled hidden value="">Select second preference...</option>
                  <?php
                  foreach ($preference2 as $pref2) { // Loop through all preference 2 options
                    if ($pref2 == $row['Preference_2']) { // If current set preference is found, set to selected
                      echo '<option value="' . $pref2 . '" selected>Most ' . $pref2 . '</option>';
                    } else { // All other values not selected
                      echo '<option value="' . $pref2 . '">Most ' . $pref2 . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="card text-center">	
                <input class="btn btn-primary" type="submit" value="Submit">
              </div>
            <?php
            }
            ?>
          </fieldset>
        </form>
      </div>
      <div class="card-footer text-right">
        <a href='./profile.php'>Skip&nbsp;<i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
    <!--- Card end above --->
  </div>
</body>

</html>
<?php
} else { // If not logged in
  header("Location: ".$ROOT."index.php"); // Redirect to home page
}
?>
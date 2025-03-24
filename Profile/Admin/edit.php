<?php
$ROOT = '../../';
include $ROOT . 'nav.php'; // Use navigation bar
require('../../connect.php'); // Open connection to database

if (isset($_SESSION['username'])) { // if logged in
  $username = $_SESSION['username']; // Set username
  
  if (isset($_GET['id'])) { // Check url to find variables
    $id = $_GET['id']; // Get id of row being edited
    $table = $_GET['frm']; // Get table being edited
    $query = ""; // Initialise variable
    $statuses = array("Declined", "Pending", "Successful"); // Create array of status'

    if ($table == "a") { // Home insurance
      $query = "SELECT * FROM `ibms-Homeins` WHERE homeins_id=$id"; // All home insurance rows
      $properties = array("Flat", "Detatched", "Semi-Detatched", "Terraced", "End of Terrace", "Cottage", "Bungalow", "Other");
    } else if ($table == "b") { // Health insurance
      $query = "SELECT * FROM `ibms-Healthins` WHERE healthins_id=$id"; // All health insurance rows
    } else if ($table == "c") { // Vehicle insurance
      $query = "SELECT * FROM `ibms-Vehicleins` WHERE vehins_id=$id"; // All vehicle insurance rows
    } else if ($table == "d") { // Accounts
      $query = "SELECT * FROM `ibms-Accounts` WHERE Username='$id'"; // All accounts from database
      // Creates an array of all countries, looped through to create a select option for country
      $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
    } else if ($table == "e") { // Policies
      $query = "SELECT * FROM `ibms-Policies` WHERE Policy_id=$id"; // All policies in the databasse
      $types = array("Car Insurance", "Home Insurance", "Vehicle Insurance"); // Creates an array of each insurance type
    } else if ($table == "f") { // Appointments
      $query = "SELECT * FROM ibms-Appointments WHERE app_id=$id"; // All appointments
    } else if ($table == "x") { // Data
      $query = "SELECT * FROM `ibms-Data` WHERE Policy_id='$id'"; // All policy data 
    }

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect)); // Execute query
    $row = mysqli_fetch_array($result); // Get results

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If update form has been submitted
      if ($table == "a") { // Home insurance
        // Get all updated fields and assign to variables
        $field1 = $_POST['username'];
        $field2 = $_POST['property'];
        $field3 = $_POST['year'];
        $field4 = $_POST['bed'];
        $field5 = $_POST['sqf'];
        $field6 = $_POST['pp'];
        $field7 = $_POST['stories'];
        $field8 = $_POST['pd'];
        $field9 = $_POST['psd'];
        $field10 = $_POST['status'];
        
        // SQL to update the details
        $sql = "UPDATE `ibms-Homeins` SET Username='$field1', Property='$field2', Year_built='$field3', Bedroom_count='$field4', Square_footage='$field5', Purchase_price='$field6', Stories='$field7', Purchase_date='$field8', Policy_start_date='$field9', Status='$field10' WHERE homeins_id='$id'"; 
        
        if (mysqli_query($connect,$sql)) { // if update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to administrator management page
        } else {
          $error = "Update failed, try again."; // If error display it
        }
      } else if ($table == "b") { // Health insurance
        // Get all updated health insurance details and assign them to variables
        $field1 = $_POST['username'];
        $field2 = $_POST['ssn'];
        $field3 = $_POST['job'];
        $field4 = $_POST['employer'];
        $field5 = $_POST['hd'];
        $field6 = $_POST['psd'];
        $field7 = $_POST['status'];

        // SQL used to update health insurance details
        $sql = "UPDATE `ibms-Healthins` SET Username='$field1', SSN='$field2', Job='$field3', Employer='$field4', Hire_date='$field5', Policy_start_date='$field6', Status='$field7' WHERE healthins_id='$id';"; 
        if (mysqli_query($connect,$sql)) { // If update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to administrator management page
        } else { // If query fails
          $error = "Update failed, try again."; // Show error
        }
      } else if ($table == "c") { // Vehicle insurance
        // Get updated vehicle insurance details and assign to variables
        $field1 = $_POST['username'];
        $field2 = $_POST['make'];
        $field3 = $_POST['model'];
        $field4 = $_POST['my'];
        $field5 = $_POST['rd'];
        $field6 = $_POST['ps'];
        $field7 = $_POST['status'];

        // SQL statement to update details
        $sql = "UPDATE `ibms-Vehicleins` SET Username='$field1', Make='$field2', Model='$field3', Manufacture_year='$field4', Reg_Date='$field5', Policy_Start='$field6', Status='$field7' WHERE vehins_id='$id';"; 
        if (mysqli_query($connect,$sql)) { // If update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to administrator management page
        } else { // If update fails
          $error = "Update failed, try again."; // Display error
        }
      } else if ($table == "d") { // Accounts
        // Get updated account details and assign to variables
        $field1 = $_POST['username'];
        $field2 = $_POST['password'];
        $field3 = $_POST['email'];
        $field4 = $_POST['name'];
        $field5 = $_POST['gender'];
        $field6 = $_POST['age'];
        $field7 = $_POST['phone'];
        $field8 = $_POST['street'];
        $field9 = $_POST['country'];
        $field10 = $_POST['access'];

        // SQL to update data
        $sql = "UPDATE `ibms-Accounts` SET Username='$field1', Password='$field2', Email='$field3', Name='$field4', Gender='$field5', Age='$field6', Phone='$field7', Street='$field8', Country='$field9', Access='$field10' WHERE Username='$id';"; 
        if (mysqli_query($connect,$sql)) { // if update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to administrator management page
        } else { // If query fails
          $error = "Update failed, try again."; // Display error
        }
      } else if ($table == "e") { // Policies
        // Assign updated policy details to variales
        $field1 = $_POST['title'];
        $field2 = $_POST['desc'];
        $field3 = $_POST['type'];

        // SQL to update policy details
        $sql = "UPDATE `ibms-Policies` SET Title='$field1', Description='$field2', Type='$field3' WHERE Policy_id='$id';"; 
        if (mysqli_query($connect,$sql)) { // If update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to administrator management
        } else { // If query fails
          $error = "Update failed, try again."; // Display error
        }
      } else if ($table == "f") { // Appointments
        // Update query for appointments
        //$query = "SELECT * FROM ibms-Appointments WHERE app_id=$id";
      } else if ($table == "x") { // Data
        // Get all updated policy data and assign to variables
        $field1 = $_POST['views'];
        $field1 = $_POST['likes'];

        // SQL to update data
        $sql = "UPDATE `ibms-Data` SET Views='$field1', Likes='$field2' WHERE Policy_id='$id'"; 
        if (mysqli_query($connect,$sql)) { // If update success
          header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to the administrator management page
        } else { // If the query fails
          $error = "Update failed, try again."; // Display error 
        }
      }				
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit</title>
</head>

<body class="body-form">
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card no-pad">
      <div class="card-header">
          <a href='./adminmanage.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
      </div>
      <div class="card-body">	
        <form action="" method="POST">
          <fieldset>
            <?php 
            if (isset($error)) { // If error, display it
                echo '<div class="alert alert-danger alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<Strong>Error! </Strong>' . $error;
                echo '</div>';
            }
            ?>
            <h1 class="card-title text-center">EDIT</h1>
            <?php
            if ($table == "a") { // Home insurance form
            ?>
              <!--- Username --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Username</p>
                <input id="1" type="text" name="username" class="form-control" value="<?=$row['Username']?>" size="48" maxlength="12" placeholder="Username" required pattern="^[\w]{4,12}$" title="Length. 4-12">
              </div>
              <!--- Type of property --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Type of Property</p>
                <select multiple id="2" class="form-control" name="property" required>
                <?php
                foreach ($properties as $property) {
                  if ($property == $row['Property']) {
                      echo '<option value="' . $property . '" selected>' . $property . '</option>';
                  } else {
                      echo '<option value="' . $property . '">' . $property . '</option>';
                  }
                }
                ?>
                </select>
              </div>
              <!--- Year Built --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Year Built</p>
                <input id="3" type="text" name="year" class="form-control" value="<?=$row['Year_built']?>" size="48" maxlength="255" placeholder="1990" required>
              </div>
              <!--- Bedroom count --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Bedroom Count</p>
                <input id="4" type="text" name="bed" class="form-control" value="<?=$row['Bedroom_count']?>" size="48" maxlength="2" placeholder="4" required>
              </div>
              <!--- Square Footage --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Square Footage</p>
                <input id="5" type="text" name="sqf" class="form-control" value="<?=$row['Square_footage']?>" size="48" maxlength="4" placeholder="100" required>
              </div>
              <!--- Purchase Price --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Purchase Price</p>
                <input id="6" type="text" name="pp" class="form-control" value="<?=$row['Purchase_price']?>" size="48" maxlength="255" placeholder="£50000" required>
              </div>
              <!--- Stories --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Stories</p>
                <input id="7" type="text" name="stories" class="form-control" value="<?=$row['Stories']?>" size="48" maxlength="2" placeholder="3" required>
              </div>
              <!--- Purchase Date --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Purchase Date</p>
                <input id="8" type="date" name="pd" value="<?=$row['Purchase_date']?>" class="form-control" required title="Date format">
              </div>
              <!--- Policy start date	 --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy Start Date</p>
                <input id="9" type="date" name="psd" value="<?=$row['Policy_start_date']?>" class="form-control" required title="Date format">
              </div>
              <!--- Status --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Status</p>
                <select multiple id="10" class="form-control" name="status" required>
                <?php
                foreach ($statuses as $status) {
                  if ($status == $row['Status']) {
                      echo '<option value="' . $status . '" selected>' . $status . '</option>';
                  } else {
                      echo '<option value="' . $status . '">' . $status . '</option>';
                  }
                }
                ?>
                </select>
              </div>
            <?php
            } else if ($table == "b") { // Health insurance form
            ?>
              <!--- Username --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Username</p>
                <input id="1" type="text" name="username" class="form-control" value="<?=$row['Username']?>" size="48" maxlength="12" placeholder="Username" required pattern="^[\w]{4,12}$" title="Length. 4-12">
              </div>
              <!--- Social Security Number --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Social Security Number (SSN)</p>
                <input id="2" type="text" name="ssn" class="form-control" value="<?=$row['SSN']?>" size="48" maxlength="9" placeholder="192403120" required>
              </div>
              <!--- Occupation/job title --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Occupation/Job Title</p>
                <input id="3" type="text" name="job" class="form-control" value="<?=$row['Job']?>" size="48" maxlength="255" placeholder="Software developer" required>
              </div>
              <!--- Employer Name --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Employer Name</p>
                <input id="4" type="text" name="employer" class="form-control" value="<?=$row['Employer']?>" size="48" maxlength="255" placeholder="John Doe" required>
              </div>
              <!--- Hire Date --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Hire Date</p>
                <input id="5" type="date" name="hd" value="<?=$row['Hire_date']?>" class="form-control" required title="Date format">
              </div>
              <!--- Policy start date	 --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy Start Date</p>
                <input id="6" type="date" name="psd" value="<?=$row['Policy_start_date']?>" class="form-control" required title="Date format">
              </div>
              <!--- Status --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Status</p>
                <select multiple id="7" class="form-control" name="status" required>
                <?php
                foreach ($statuses as $status) {
                  if ($status == $row['Status']) {
                      echo '<option value="' . $status . '" selected>' . $status . '</option>';
                  } else {
                      echo '<option value="' . $status . '">' . $status . '</option>';
                  }
                }
                ?>
                </select>
              </div>
            <?php
            } else if ($table == "c") { // Vehicle Insurance form
            ?>
              <!--- Username --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Username</p>
                <input id="1" type="text" name="username" class="form-control" value="<?=$row['Username']?>" size="48" maxlength="12" placeholder="Username" required pattern="^[\w]{4,12}$" title="Length. 4-12">
              </div>
              <!--- Make --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Make</p>
                <input id="2" type="text" name="make" class="form-control" value="<?=$row['Make']?>" size="48" maxlength="255" placeholder="Ford" required>
              </div>
              <!--- Model --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Model</p>
                <input id="3" type="text" name="model" class="form-control" value="<?=$row['Model']?>" size="48" maxlength="255" placeholder="Focus" required>
              </div>
              <!--- Manufacture year --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Manufacture Year</p>
                <input id="4" type="text" name="my" class="form-control" value="<?=$row['Manufacture_year']?>" size="48" maxlength="4" placeholder="2015" required pattern="^[0-9]{4}$" required>
              </div>
              <!--- Registration date --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Registration Date</p>
                <input id="5" type="date" name="rd" value="<?=$row['Reg_Date']?>" class="form-control" required title="Date format">
              </div>
              <!--- Policy start date	 --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy Start Date</p>
                <input id="6" type="date" name="ps" value="<?=$row['Policy_Start']?>" class="form-control" required title="Date format">
              </div>
              <!--- Status --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Status</p>
                <select multiple id="7" class="form-control" name="status" required>
                <?php
                foreach ($statuses as $status) {
                  if ($status == $row['Status']) {
                      echo '<option value="' . $status . '" selected>' . $status . '</option>';
                  } else {
                      echo '<option value="' . $status . '">' . $status . '</option>';
                  }
                }
                ?>
                </select>
              </div>
            <?php
            } else if ($table == "d") { // Account details form
            ?>
              <!--- Username --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Username</p>
                <input id="1" type="text" name="username" class="form-control" value="<?=$row['Username']?>" size="48" maxlength="12" placeholder="Username" required pattern="^[\w]{4,12}$" title="Length. 4-12">
              </div>
              <!--- Password --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Password</p>
                <input id="2" type="text" name="password" class="form-control" value="<?=$row['Password']?>" size="48" maxlength="12" placeholder="Password" required pattern="^(?=.*\d).{4,12}$" title="Length. 4-12 (must contain a number)">
              </div>
              <!--- Email --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Email</p>
                <input id="3" type="email" name="email" class="form-control" value="<?=$row['Email']?>" size="48" maxlength="255" placeholder="Email" required title="Email must follow valid format. E.g. Test@Email.com">
              </div>
              <!--- Name --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Name</p>
                <input id="4" type="text" name="name" class="form-control" value="<?=$row['Name']?>" size="48" maxlength="50" placeholder="Name" required pattern="^[a-zA-Z\s]{3,50}$" required title="Length. 3-50">
              </div>
              <!--- Age --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Age</p>
                <input id="5" type="text" name="age" class="form-control" value="<?=$row['Age']?>" size="48" maxlength="3" placeholder="Age" required pattern="^[0-9]{1,3}$" required title="Valid age">
              </div>
              <!--- Phone number --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Phone</p>
                <input id="6" type="text" name="phone" class="form-control" value="<?=$row['Phone']?>" size="48" maxlength="11" placeholder="Phone Number" required pattern="^[\d]{11}$" required title="Length. 11">
              </div>
              <!--- Street --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Street</p>
                <input id="7" type="text" name="street" class="form-control" value="<?=$row['Street']?>" size="48" maxlength="255" placeholder="Street Name" required pattern="^[a-zA-Z]{1-15}$" required title="Length. 1-15">
              </div>
              <!--- Country --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Country</p>
                <select multiple class="form-control" name="country" required>
                <?php
                foreach ($countries as $country) {
                  if ($country == $row['Country']) {
                    echo '<option value="' . $country . '" selected>' . $country . '</option>';
                  } else {
                    echo '<option value="' . $country . '">' . $country . '</option>';
                  }
                }
                ?>
                </select>
              </div>
              <!--- Gender --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Gender</p>
                <?php
                if ($row['Gender'] == "Male") { // If male previously entered
                  $mchecked = 'checked="checked"';
                  $fchecked = '';
                } else if ($row['Gender'] == "Female") { // If female previously entered
                  $mchecked = '';
                  $fchecked = 'checked="checked"';
                } else { // If anything else previously entered
                  $mchecked = '';
                  $fchecked = '';	
                }
                ?>
                <label class="radio-inline"><input type="radio" name="gender" value="Male" <?=$mchecked?>>&nbsp;Male&emsp;&emsp;</label>
                <label class="radio-inline"><input type="radio" name="gender" value="Female" <?=$fchecked?>>&nbsp;Female</label>
              </div>
              <!--- Access -->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Access Level (1 = user, 2 = admin)</p>
                <input id="8" type="text" name="access" class="form-control" value="<?=$row['Access']?>" size="48" maxlength="1" placeholder="Access" required pattern="^[0-9]{1}$" required title="Valid access level">
              </div>
            <?php
            } else if ($table == "e") { // Policy details form
            ?>
              <!--- Title of the policy -->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Title</p>
                <input id="1" type="text" name="title" class="form-control" value="<?=$row['Title']?>" size="255" maxlength="255" placeholder="Policy title..." autocomplete="on" required title="Enter the policy title.">
              </div>
              <!--- Type of insurance --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Type of Property</p>
                <select multiple id="3" class="form-control" name="type" required>
                <?php
                foreach ($types as $type) {
                  if ($type == $row['Type']) {
                    echo '<option value="' . $type . '" selected>' . $type . '</option>';
                  } else {
                    echo '<option value="' . $type . '">' . $type . '</option>';
                  }
                }
                ?>
                </select>
              </div>
              <!--- Description of policy --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Description</p>
                <textarea id="2" type="text" name="desc" class="form-control" maxlength="255" placeholder="Policy descrition..." autocomplete="on" required title="Enter the description of the policy."><?=$row['Description']?></textarea>
              </div>
            <?php
            } else if ($table == "f") { // Appointment form (WIP)
            ?>
              <!--- Form f --->
              <p>form f</p>
            <?php	
            } else if ($table == "x") { // Policy data form
            ?>
              <!--- Access -->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy id</p>
                <input id="1" type="text" name="id" class="form-control" value="<?=$row['Policy_id']?>" size="255" maxlength="255" disabled>
              </div>
              <!--- View count -->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;View counter</p>
                <input id="2" type="text" name="views" class="form-control" value="<?=$row['Views']?>" size="255" maxlength="255" placeholder="Views" required pattern="^[0-9]*$" title="Valid view count">
              </div>
              <!--- Likes count -->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Likes counter</p>
                <input id="3" type="text" name="likes" class="form-control" value="<?=$row['Likes']?>" size="255" maxlength="255" placeholder="Views" required pattern="^[0-9]*$" title="Valid likes count">
              </div>
            <?php
            }
            ?>
            <div class="card text-center">	
              <input class="btn btn-primary" type="submit" value="Submit">
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <!--- Card end above --->
  </div>
</body>

</html>
<?php 
  } else { // If page is accessed without the correct variables
    header("Location: ".$ROOT."Profile/Admin/adminmanage.php"); // Redirect to the admin management page
  }
} else { // If not logged in
  header("Location: ".$ROOT."index.php"); // Redirect to home page
}
?>
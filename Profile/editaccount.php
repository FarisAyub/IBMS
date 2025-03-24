<?php
$ROOT = '../'; 
include $ROOT . 'nav.php'; // Include navigation bar
if (isset($_SESSION['username'])) { // If logged in 
  $username = $_SESSION['username']; // Username
  $sub = $_GET['sub']; // Get button selected
  // Get all account details
  $result = mysqli_query($connect, "SELECT * FROM `IBMS-Accounts` WHERE `Username`='$username'") or die(mysqli_error($connect));
  $row = mysqli_fetch_array($result);
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form has been submitted
    $desc = $_POST['desc']; // Get type of form being submitted
    if ($desc == "acc") { // If form is for account details
      $password = $_POST['password']; // Get new password
      $email = $_POST['email']; // Get new 
      
      // SQL to update account details
      $sql = "UPDATE `IBMS-Accounts` SET Password='$password', Email='$email' WHERE Username='$username';"; 

      if (mysqli_query($connect,$sql)) { // If query successful
        // Send email letting the user know their email was changed
        $to = $email; 
        $subject = "Account details changed"; 
        $emessage = "Your account details have been changed, if this was not done by you your account may be compromised.";
    
        // If over 70 characters
        $emessage = wordwrap($emessage, 70, "\r\n");
    
        // Email + link
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=iso-8859-1";
        $headers[] = "From: IB <noreply@InsBrok.com>";
        $headers[] = "Subject: {$subject}";
        $headers[] = "X-Mailer: PHP/".phpversion();
        mail($to, $subject, $emessage, implode("\r\n", $headers));
        
        $done = "Account updated"; // Success message for alert
        header("refresh:3;url='../Profile/profile.php?updated=true'"); // Redirect to profile page in 3 seconds
      } else { // If query fails
        $error = "Update failed, try again."; // Set error variable for alert
      }
    
    } else { // If personal details form
      // Get all form details and assign to variables
      $name = $_POST['name'];
      $gender = $_POST['gender'];
      $age = $_POST['age'];
      $phone = $_POST['phone'];
      $street = $_POST['street'];
      $country = $_POST['country'];
      $email = $_POST['email'];
      // SQL to update account personal details
      $sql = "UPDATE `IBMS-Accounts` SET Name='$name', Gender='$gender', Age='$age', Phone='$phone', Street='$street', Country='$country' WHERE Username='$username';";      
      if (mysqli_query($connect,$sql)) { // If query successful
        // Send an email letting user know their personal details were changed
        $to = $email; 
        $subject = "Personal details changed"; 
        $emessage = "Your personal details have been changed, if this was not done by you your account may be compromised.";
    
        // If over 70 characters
        $emessage = wordwrap($emessage, 70, "\r\n");
    
        // Email + link
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=iso-8859-1";
        $headers[] = "From: IB <noreply@InsBrok.com>";
        $headers[] = "Subject: {$subject}";
        $headers[] = "X-Mailer: PHP/".phpversion();
        mail($to, $subject, $emessage, implode("\r\n", $headers));
        
        $done = "Personal details updated"; // Success alert message 
        header("refresh:3;url='../Profile/profile.php?updated=true'"); // Redirect user to profile page after 3 seconds
      } else { // If query fails
        $error = "Update failed, try again."; // Set error alert message
      }
    }
  }
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Edit Account Details</title>
</head>

<body class="body-form">
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card mx-auto" style="max-width: 24rem;">
      <div class="card-header">
        <a href='./profile.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
      </div>
      <div class="card-body text-center">	
        <form action="" method="POST">
          <fieldset>
              <?php
              // Array of all countries 
              $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
              if (isset($error)) { // If an error is set, display alert
                echo '<div class="alert alert-danger alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<Strong>Error! </Strong>' . $error;
                echo '</div>';
              }
              if (isset($done)) { // If the account is created the variable is set meaning this message will display and remove edit account form
                echo '<div class="alert alert-success alert-dismissible">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<Strong>Successs! </Strong>' . $done;
                echo '</div>';
                echo 'Redirecting in 3 seconds...';
              } else {
              ?>
                <h1 class="card-title">EDIT ACCOUNT</h1>
                <?php
                if ($sub == "acc") {
                ?>
                  <!--- Hidden form type --->
                  <div class="form-group">
                    <input id="10" type="text" name="desc" value="acc" hidden>
                  </div>
                  <!--- Password --->
                  <div class="form-group">
                    <input id="1" type="password" name="password" class="form-control" size="48" maxlength="12" placeholder="New Password" value="<?=$row['Password'];?>" required pattern="^(?=.*\d).{4,12}$" title="Length. 4-12 (must contain a number)">
                  </div>
                  <p class="small text-right"><input type="checkbox" onclick="showPassword()"> Show Password</p>
                  <!--- Email --->
                  <div class="form-group">
                    <input id="2" type="email" name="email" class="form-control" size="48" maxlength="255" placeholder="New Email" value="<?=$row['Email'];?>" required title="Email must follow valid format. E.g. Test@Email.com">
                  </div>
                <?php
                } else {
                ?>
                  <!--- Hidden form type --->
                  <div class="form-group">
                    <input id="10" type="text" name="desc" value="per" hidden>
                  </div>
                  <!--- Hidden Email --->
                  <div class="form-group">
                    <input id="2" type="email" name="email" class="form-control" size="48" maxlength="255" placeholder="New Email" value="<?=$row['Email'];?>" hidden required title="Email must follow valid format. E.g. Test@Email.com">
                  </div>
                  <!--- Name --->
                  <div class="form-group">
                    <input id="3" type="text" name="name" class="form-control" size="48" maxlength="50" placeholder="Name" value="<?=$row['Name'];?>" required pattern="^[a-zA-Z\s]{3,50}$" required title="Length. 3-50">
                  </div>
                  <!--- Age --->
                  <div class="form-group">
                    <input id="4" type="text" name="age" class="form-control" size="48" maxlength="3" placeholder="Age" value="<?=$row['Age'];?>" required pattern="^[0-9]{1,3}$" required title="Valid age">
                  </div>
                  <!--- Phone number --->
                  <div class="form-group">
                    <input id="5" type="text" name="phone" class="form-control" size="48" maxlength="11" placeholder="Phone Number" value="<?=$row['Phone'];?>" required pattern="^[\d]{11}$" required title="Length. 11">
                  </div>
                  <!--- Street --->
                  <div class="form-group">
                    <input id="6" type="text" name="street" class="form-control" size="48" maxlength="255" placeholder="Street Name" value="<?=$row['Street'];?>" required pattern="^[a-zA-Z]{1-15}$" required title="Length. 1-15">
                  </div>
                  <!--- Country --->
                  <div class="form-group">
                    <select multiple class="form-control" name="country" selected="<?=$row['Country'];?>" required>
                    <?php
                    foreach ($countries as $country) {
                      echo '<option value="' . $country . '">' . $country . '</option>';
                    }
                    ?>
                    </select>
                  </div>
                  <!--- Gender --->
                  <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="gender" value="Male" checked>&nbsp;Male&emsp;&emsp;</label>
                    <label class="radio-inline"><input type="radio" name="gender" value="Female">&nbsp;Female</label>
                  </div>
                <?php	
                }
                ?>
                <div class="card text-center">	
                  <input class="btn btn-primary" type="submit" value="Submit">
                </div>
              <?php 
              }
              ?>
          </fieldset>
          <script>
            function showPassword() { // Change field between password and text to make text visible or not
              var x = document.getElementById("1");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
          </script>
        </form>
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
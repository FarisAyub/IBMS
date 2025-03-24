<?php
$ROOT = '../'; include $ROOT . 'nav.php'; // Include navigation bar
require('../connect.php'); // Include database connection
if(isset($_SESSION['username'])) { // If logged in
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If form submitted
      // Get home insurance form details and assign to variables
      $username = $_SESSION['username'];
      $property = $_POST['property'];
      $year = $_POST['year'];
      $bed = $_POST['bedrooms'];
      $sqf = $_POST['sqfootage'];
      $price = $_POST['price'];
      $stories = $_POST['stories'];
      $policy = $_POST['policy'];
      $purchaseinput = $_POST['purchasedate'];
      $policyinput = $_POST['policystart'];
      $purchase = date('Y-m-d', strtotime($purchaseinput));
      $policystart = date('Y-m-d', strtotime($policyinput));
      
      // SQL to insert quote request
      $sql = "INSERT INTO `ibms-Homeins`
      (`Username`, `Policy_id`, `Property`, `Year_built`, `Bedroom_count`, `Square_footage`, `Purchase_price`, `Stories`, `Purchase_date`, `Policy_start_date`, `Status`) VALUES 
      ('$username', '$policy', '$property', '$year', '$bed', '$sqf', '$price', '$stories', '$purchase', '$policystart', 'Pending')"; 
          
      if (mysqli_query($connect,$sql)) { // If query successful
        $sql2 = "SELECT `Email` FROM `ibms-Accounts` WHERE Username='".$username."'"; // Get account details
        $result = mysqli_query($connect, $sql2); 
        $row = mysqli_fetch_assoc($result); 
        $email = $row['Email']; // Get email
        
        // Send email letting user know their quote request went through
        $to = $email; 
        $subject = "Home Insurance Quote Request Successful"; 
        $emessage = "Your request for home insurance for " . $property . " property was received successfully!";
    
        // If over 70 characters
        $emessage = wordwrap($emessage, 70, "\r\n");
    
        // Email + link
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=iso-8859-1";
        $headers[] = "From: IB <noreply@IBMS.com>";
        $headers[] = "Subject: {$subject}";
        $headers[] = "X-Mailer: PHP/".phpversion();
        mail($to, $subject, $emessage, implode("\r\n", $headers));
        
        $done = "Quote request successful!"; // Set success alert message
          
      } else { // If query fails
        $error = "Error submitting quote"; // Set error for alert
      }
  } 
  if (isset($done)) { // If alert is set to done
    header("refresh:3;url='../Quotes/quotes.php'"); // redirect in 3 seconds
  }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Home Insurance</title>
</head>

<body class="body-form">
  <div class="container">
    <!--- Card --->
    <br>
    <div class="card mx-auto" style="max-width: 30rem;">
      <div class="card-header">
        <a href='./quotes.php'><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
      </div>
      <div class="card-body">	
        <form action="" method="POST">
          <fieldset>
            <?php 
            if (isset($error)) { // If an error is set, show error alert
              echo '<div class="alert alert-danger alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Error! </Strong>' . $error;
              echo '</div>';
            }
            if (isset($done)) { // If successful, display succesful alert
              echo '<div class="alert alert-success alert-dismissible">';
              echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
              echo '<Strong>Successs! </Strong>' . $done;
              echo '</div>';
              echo "<p>Redirecting to quotes in 3 seconds...</p>";
            } else {
            ?>
              <h1 class="card-title text-center">HOME INSURANCE</h1>
              <p class="card-text">Please fill in all the fields before selecting the submit button.</p>
              <!--- Select policy --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy</p>
                <select multiple class="form-control" name="policy" required>
                  <?php
                  $policies = mysqli_query($connect, "SELECT * FROM `ibms-Policies` WHERE Type='Home Insurance'") or die(mysqli_error($connect)); 
                  while($row = mysqli_fetch_array($policies)) {
                    echo "<option value='" . $row['Policy_id'] . "'>" . $row['Title'] . " " . $row['Type'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <!--- Type of property --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Type of Property</p>
                <select multiple id="1" class="form-control" name="property" required>
                  <option value="Flat">Flat</option>
                  <option value="Detatched">Detatched</option>
                  <option value="Semi-Detatched">Semi-Detatched</option>
                  <option value="Terraced">Terraced</option>
                  <option value="End of Terrace">End of Terrace</option>
                  <option value="Cottage">Cottage</option>
                  <option value="Bungalow">Bungalow</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <!--- Year Built --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Year Built</p>
                <input id="2" type="text" name="year" class="form-control" size="48" maxlength="255" placeholder="1990" required>
              </div>
              <!--- Bedroom count --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Bedroom Count</p>
                <input id="3" type="text" name="bedrooms" class="form-control" size="48" maxlength="2" placeholder="4" required>
              </div>
              <!--- Square Footage --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Square Footage</p>
                <input id="4" type="text" name="sqfootage" class="form-control" size="48" maxlength="4" placeholder="100" required>
              </div>
              <!--- Purchase Date --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Purchase Date</p>
                <input id="5" type="date" name="purchasedate" value="2018-01-01" class="form-control" required title="Date format">
              </div>
              <!--- Purchase Price --->
              <p class="card-subtitle mb-2 text-muted">&nbsp;Purchase Price</p>
              <div class="input-group mb-3">  
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input id="6" type="text" name="price" class="form-control" size="48" maxlength="255" placeholder="50000" required>
              </div>
              <!--- Stories --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Stories</p>
                <input id="7" type="text" name="stories" class="form-control" size="48" maxlength="2" placeholder="3" required>
              </div>
              <!--- Policy start date	 --->
              <div class="form-group">
                <p class="card-subtitle mb-2 text-muted">&nbsp;Policy Start Date</p>
                <input id="8" type="date" name="policystart" value="2018-01-01" class="form-control" required title="Date format">
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
    </div>
    <br>
    <!--- Card end above --->
  </div>
</body>

</html>

<?php
} else { // If not logged in
  echo 
  "<div class='container'>
  <br>
  <div class='card mx-auto' style='max-width: 40rem;'>
  <div class='card-body text-center'>	
  <h1>Log in</h1>
  You must be logged logged in to request a quote<br>
  <a href='../Login/login.php'>Click here to log in</a>
  </div>
  </div>
  </div>";
}
?>
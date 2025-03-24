<?php
// Common vars
$viewsMultiplier = 1; // How much each view counts as
$likesMultiplier = 10; // How much each like counts as
$ratingMultiplier = 2; // How much each rating counts as
$user = $_SESSION['username']; // User currently logged in

// Preferences
$getPreferences = "SELECT * FROM `IBMS-Preferences` WHERE Username='$user'"; // Gets the preferences of current user
$prefResult = mysqli_query($connect, $getPreferences) or die(mysqli_error($connect)); // Execute query
$prefRow = mysqli_fetch_array($prefResult); // Create an array of the values
$insType = $prefRow['Preference_1']; // Set preference 1 to variable
$filterType = $prefRow['Preference_2']; // Set preference 2 to variable
switch ($insType) { // Alter sql statement based on type of insurance
  case "Health Insurance":
    $table = "IBMS-Healthins";
    break;
  case "Home Insurance":
    $table = "IBMS-Homeins";
    break;
  case "Vehicle Insurance":
    $insType = "Car Insurance"; // Change the search term to car insurance not vehicle as listed differently
    $table = "IBMS-Vehicleins";
    break;
  default: // If no preferences are set
    $insType = "Home Insurance"; 
    $table = "IBMS-Homeins"; 
    break;
}
switch ($filterType) { // Alter sql statements based on method of recommendation
  case "Requested":
    $preferencesql = "SELECT *, (SELECT DISTINCT COALESCE(COUNT(`$table`.`Policy_id`),0) FROM `$table` WHERE `$table`.`Policy_id`=`IBMS-Policies`.`Policy_id`) AS RequestCount 
    FROM `IBMS-Policies` ORDER BY RequestCount DESC LIMIT 1";
    break;
  case "Popular":
    $preferencesql = "SELECT *, 
    (`Likes`*$likesMultiplier) + 
    (SELECT DISTINCT COALESCE((SUM(`IBMS-Likes`.`Rating`)*$ratingMultiplier),0) FROM `IBMS-Likes` WHERE `IBMS-Likes`.`Policy_id`=`IBMS-Data`.`Policy_id`) + 
    (`Views`*$viewsMultiplier) AS TotalScore FROM `IBMS-Data` INNER JOIN `IBMS-Policies` ON `IBMS-Data`.`Policy_id`=`IBMS-Policies`.`Policy_id` 
    WHERE `IBMS-Policies`.`Type`='$insType' ORDER BY TotalScore DESC LIMIT 1";
    break;
  default: // If no preference is set
    $preferencesql = "SELECT *, 
    (`Likes`*$likesMultiplier) + 
    (SELECT DISTINCT COALESCE((SUM(`IBMS-Likes`.`Rating`)*$ratingMultiplier),0) FROM `IBMS-Likes` WHERE `IBMS-Likes`.`Policy_id`=`IBMS-Data`.`Policy_id`) + 
    (`Views`*$viewsMultiplier) AS TotalScore FROM `IBMS-Data` INNER JOIN `IBMS-Policies` ON `IBMS-Data`.`Policy_id`=`IBMS-Policies`.`Policy_id` 
    WHERE `IBMS-Policies`.`Type`='$insType' ORDER BY TotalScore DESC LIMIT 1";
    break;
}
$preferenceResult = mysqli_query($connect, $preferencesql); // Get the result for whichever sql statement was successful
$preferenceRow = mysqli_fetch_array($preferenceResult); // Execute sql

// Popular
$allScores = "SELECT *, 
(`Likes`*$likesMultiplier) + 
(SELECT DISTINCT COALESCE((SUM(`IBMS-Likes`.`Rating`)*$ratingMultiplier),0) FROM `IBMS-Likes` WHERE `IBMS-Likes`.`Policy_id`=`IBMS-Data`.`Policy_id`) + 
(`Views`*$viewsMultiplier) AS TotalScore FROM `IBMS-Data` INNER JOIN `IBMS-Policies` ON `IBMS-Data`.`Policy_id`=`IBMS-Policies`.`Policy_id` ORDER BY TotalScore DESC LIMIT 1"; // Gets most popular sql
$popularResult = mysqli_query($connect, $allScores); // Execute sql
$popularRow = mysqli_fetch_array($popularResult); // Get result as array

// Similarity
$myLikedpolicies = "SELECT Policy_id FROM `IBMS-Likes` WHERE username='$user' AND Liked='1'"; // Get liked policies from current user
$myLPResults = mysqli_query($connect, $myLikedpolicies); // execute sql
$MLCount = mysqli_num_rows($myLPResults); // Count of users
$check = ""; $oppositeCheck = ""; // Initialise
$i = 0; // Counter
if ($MLCount == 0) { // No policies liked
    $check .= true;
} else { // If atleast 1 policy liked
  while($MyLPRow = mysqli_fetch_array($myLPResults)) { // Loop through each result
    if ($i == 0) { // For first row
      $check .= "`Policy_id`='" . $MyLPRow['Policy_id'] . "'"; // Alters sql to find similarities based on these policies
      $oppositeCheck .= "`Policy_id`!='" . $MyLPRow['Policy_id'] . "' AND "; // Alters sql to filter out already liked policies
      $i++; // Counter so above only runs first time
    } else {
      $check .= " OR `Policy_id`='" . $MyLPRow['Policy_id'] . "'"; // Alters sql to find similarities based on these policies
      $oppositeCheck .= "`Policy_id`!='" . $MyLPRow['Policy_id'] . "' AND "; // Alters sql to filter out already liked policies
    }
  }
}

// Gets the user with highest similarities (most similar likes)
$SqlA = "SELECT *, Username as temp, (SELECT COUNT(*) FROM `IBMS-Likes` WHERE `IBMS-Likes`.`Liked`='1' AND `Username`=temp AND ($check)) AS SimScore 
FROM `IBMS-Likes` WHERE `Username`!='$user' GROUP BY Username ORDER BY SimScore DESC LIMIT 1";
$QueryA = mysqli_query($connect, $SqlA); // Execute sql
$CountA = mysqli_num_rows($QueryA); // Count of results

if ($CountA >= 1) { // If a user with similarities exists
  $RowA = mysqli_fetch_array($QueryA); // Put data into array
  $suser = $RowA['Username']; // Assign the user that is most similar to a variable
  // Get a policy that isn't liked by logged in user, but is by similar user
  $SqlB = "SELECT * FROM (SELECT * FROM `IBMS-Likes` WHERE $oppositeCheck `Liked`='1' AND `Username`='$suser') as Temp 
  INNER JOIN `IBMS-Policies` ON `IBMS-Policies`.`Policy_id`=`Temp`.`Policy_id` LIMIT 1";
  $QueryB = mysqli_query($connect, $SqlB); // Execute sql
  $CountB = mysqli_num_rows($QueryB); // Get the total amount of rows returned by sql
  if ($CountB == 0) { // If no similar policies found aka 0 count
    // Run alternate sql to find any policy that isn't liked currently
    $oppositeCheck = substr_replace($oppositeCheck, "", -4); // Removes last 4 letters of the string (removes "AND " as this sql statement doesnt have need for it)
    if ($oppositeCheck == "") {
      $SqlC = "SELECT * FROM `IBMS-Policies` ORDER BY RAND() LIMIT 1"; // If no liked policies
    } else {
      $SqlC = "SELECT * FROM `IBMS-Policies` WHERE $oppositeCheck ORDER BY RAND() LIMIT 1"; // Random policy NOT liked
    }
    $QueryC = mysqli_query($connect, $SqlC); // Re-execute sql
    $RowS = mysqli_fetch_array($QueryC); // Assign results to an array
  } else { // If similar policy is found
    $RowS = mysqli_fetch_array($QueryB); // Assign results to an array
  }
    
} else { // No similar users found
  // Run alternate sql to find any policy that isn't liked currently
  if ($oppositeCheck == "") {
    $SqlS = "SELECT * FROM `IBMS-Policies` ORDER BY RAND() LIMIT 1"; // If no policies liked
  } else {
    $oppositeCheck = substr_replace($oppositeCheck, "", -4); // Remove extra "AND"
    $SqlS = "SELECT * FROM `IBMS-Policies` WHERE $oppositeCheck ORDER BY RAND() LIMIT 1"; // Random policy NOT liked
  }
  $QueryS = mysqli_query($connect, $SqlS); // Execute sql
  $RowS = mysqli_fetch_array($QueryS); // Assign values to a array
}
if ($RowS['Policy_id'] == "") { // If for whatever reason, no result returns
  $SqlS = "SELECT * FROM `IBMS-Policies` ORDER BY RAND() LIMIT 1"; // Get random policy
  $QueryS = mysqli_query($connect, $SqlS); // Execute sql
  $RowS = mysqli_fetch_array($QueryS); // Assign values to a array
}
?>
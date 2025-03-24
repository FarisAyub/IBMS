<?php
$ROOT = '../'; 
include $ROOT.'nav.php'; // Include navigation bar

if (isset($_SESSION['username'])) { // If logged in
  header("refresh:3;url='../Profile/profile.php'"); // Redirect to profile page in 3 seconds
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Success!</title>
</head>

<body>  
  <br>
  <div class='card mx-auto' style='max-width: 30rem;'>
    <div class='card-body text-center'>
      <div class='container'>
        <h1>Preferences set</h1>
        Redirecting in 3 seconds...<br>
      </div>
    </div>
  </div>
</body>

</html>
<?php
} else {
  header("Location: ".$ROOT."index.php");
}
?>
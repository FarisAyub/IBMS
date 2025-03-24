<?php
// SQL gets average rating by adding all values above 0 and dividing by amount, then rounding to nearest .5
$ratingRoundSQL = "SELECT ROUND(AVG(`rating`) * 2, 0) / 2 AS avg FROM `IBMS-Likes` WHERE Policy_id='$id' AND Rating > 0";
$ratingRoundResult = mysqli_query($connect, $ratingRoundSQL);
$ratingRow = mysqli_fetch_array($ratingRoundResult);

// Create variable with the value
$one_decimal_place = number_format($ratingRow['avg'], 1);

// Depending on how what value was received (for example 1.5, display the appropriate icons)
switch ($one_decimal_place) {
  case 0.0:
    $stars = '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;
  case 1.0:
    $stars = '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;
  case 1.5:
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;
  case 2.0: 
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;
  case 2.5: 
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;    
  case 3.0: 
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
    break;
  case 3.5:
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>';
    break;
  case 4.0: 
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
    break;
  case 4.5: 
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>';
    break;
  case 5.0:
    $stars = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
    break;
}
?>
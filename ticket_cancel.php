<?php
  /*
    Cancel selected ticket operation.
  */
  session_start();
  /*connect to database and check connection*/
  require 'connect.php';
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  /*pass value from url into a variable*/
  $id = mysqli_real_escape_string($con,$_GET['id']);
  /*update value if fails then return an error message*/
  $sql = "UPDATE `payment` SET `Status` = 'Cancelled' WHERE `payment`.`PaymentID` = $id";
  if (!mysqli_query($con,$sql)) {
	die('Error: ' . mysqli_error($con));
	}
  /*after finish updating, go to customerview.php*/
    header("Location: customerview.php");
    mysqli_close($con);
?>
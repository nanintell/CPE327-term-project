<!--
  Add a new customer into the database.
  All needed data is passed from customersignup.php.
-->
<?php

session_start();
/*connect to the database*/
include 'connect.php';

/*Pass input values from customersignup.php into variables*/
$Name = mysqli_real_escape_string($con, $_POST['Name']);
$Bday = mysqli_real_escape_string($con, $_POST['Bday']);
$CitizenID = mysqli_real_escape_string($con, $_POST['CitizenID']);
$Address = mysqli_real_escape_string($con, $_POST['Address']);
$pass = mysqli_real_escape_string($con, $_POST['pass']);

/*Insert data into the database. If fails, return an error message.*/
$sql = "INSERT INTO customer(Name, Bday,CitizenID,Address,Password) VALUES
  ('$Name','$Bday','$CitizenID','$Address','$pass')";

if (!mysqli_query($con, $sql)) {
  die('Error: ' . mysqli_error($con));
  echo "<script>setTimeout(\"location.href = 'customersignup.php';\",1500);</script>";
} else {
  /*Add newly added customer and his id into session
     *Due to id being auto increment, the new data's id will have highest value
     *After finish adding into session, change destination to signupsuccess.php
     */
  $_SESSION['Name'] = $Name;
  $sql = "SELECT MAX(CustomerID) AS CustomerID FROM customer WHERE Name='$Name'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $_SESSION['id'] = $row["CustomerID"];
  mysqli_close($con);
  header("Location: signupsuccess.php");
  exit;
}


?>
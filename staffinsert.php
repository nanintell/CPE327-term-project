<?php

session_start();
/*connect to database*/
require 'connect.php';

  /*pass values from input from staffregister.php into variables*/
  $Name = mysqli_real_escape_string($con, $_POST['Name']);
  $Bday = mysqli_real_escape_string($con, $_POST['Bday']);
  $CitizenID = mysqli_real_escape_string($con, $_POST['CitizenID']);
  $Address=mysqli_real_escape_string($con,$_POST['Address']);
  $pass=mysqli_real_escape_string($con,$_POST['pass']);

  /*add data into database if fails then return an error message*/
  $sql="INSERT INTO staff(Name, BDay,CitizenID,Address,Password)  VALUES('$Name', '$Bday','$CitizenID','$Address','$pass')";

  if (!mysqli_query($con,$sql)) {
      echo('Error na: ' . mysqli_error($con));
      echo "<script>setTimeout(\"location.href = 'staffregister.php';\",1500);</script>";
  }

  else{
    /*Similar to customerinsert.php
     *Add newly added staff and his id into session
     *Due to id being auto increment, the new data's id will have highest value
     *After finish adding into session, change destination to staffreceive.php
     */
    $_SESSION['Name'] = $Name;
    $sql= "SELECT MAX(StaffID) AS StaffID FROM staff WHERE Name='$Name'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row["StaffID"];
    mysqli_close($con);
    header("Location: staffrecive.php");
    exit;
  }
  mysqli_close($con);
?>

<?php
/*
  Log in user
*/

session_start();
/*connect to the database*/
require 'connect.php';
/*clear session*/
session_unset();

/*pass values from input from login.html into variables*/
$numID = mysqli_real_escape_string($con,$_POST['numID']);
$pass =  mysqli_real_escape_string($con,$_POST['pass']);
$choice = mysqli_real_escape_string($con,$_POST['choice']);
/*add choice and id into session*/
$_SESSION['choice'] = $choice;
$_SESSION['numID'] = $numID;

/*check database connection*/
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

/*if choice is "customer", query customer data to check
 *if choice is "staff", query staff data instead
 */
if($choice == 'customer'){

    $sql = "SELECT Name FROM customer WHERE CustomerID = '$numID' AND Password = '$pass'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    /*if empty result then return an error message and go back to login.html after 1.5 seconds*/
    if($row['Name'] == ""){
      echo "ID or Password is incorrect !";
      echo "<script>setTimeout(\"location.href = 'login.html';\",1500);</script>";
    }else {
      /*if found then add id, pass and name into session then go to customerview.php*/
      $_SESSION['CustomerID'] = $numID;
      $_SESSION['Password'] = $pass;
      $_SESSION['Name'] = $row['Name'];
      header("Location: customerview.php");
      exit;
    }

  } else {
  $sql = "SELECT Name FROM staff WHERE StaffID = '$numID' AND Password = '$pass'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);

  /*if empty result then return an error message and go back to login.html after 1.5 seconds*/
  if($row['Name'] == ""){
    echo "ID or Password is incorrect !";
    echo "<script>setTimeout(\"location.href = 'login.html';\",1500);</script>";
  }else {
    /*if found then add id, pass and name into session then go to customerview.php*/
    $_SESSION['StaffID'] = $numID;
    $_SESSION['Password'] = $pass;
    $_SESSION['Name'] = $row['Name'];
    header("Location: staffview.php"); //go to staff view
    exit;

  }
}

mysqli_close($con);
?>
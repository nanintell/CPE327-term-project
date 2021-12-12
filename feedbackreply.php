<?php
  /*
    add staff's reply into non-replied feedback
  */
  session_start();
  /*connect to the database*/
  require 'connect.php';
  /*if user is staff, pass name and StaffID values,stored within session, into variables.
   *if user is customer, change destination to customerview.php instead.
   *if user is neither staff nor customer, change destination to login.html instead.
   */
  if(isset($_SESSION['Name']) && $_SESSION['choice'] =='staff'){
    $Name = $_SESSION['Name'];
    $id = $_SESSION['StaffID'];
  }
  else if(isset($_SESSION['Name']) && $_SESSION['choice'] =='customer'){
    header("location: customerview.php");
    exit;
  }
  else {
    header("location: login.html");
    exit;
  }

  /*check database connection*/
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  /*pass values from url and input from staffview.php into variables*/
  $feedback = mysqli_real_escape_string($con,$_GET['id']);
  $reply =  mysqli_real_escape_string($con,$_POST['reply']);
  /*update values into the feedback 
  *if fails, return an error message
  */
  $sql = "UPDATE feedback SET StaffReply = '$reply', StaffID = $id WHERE FeedbackID = $feedback;";
  if (!mysqli_query($con,$sql)) {
	die('Error: ' . mysqli_error($con));
	}
    /*after finish updating, go to staffview.php*/
    header("Location: staffview.php");
    mysqli_close($con);
?>

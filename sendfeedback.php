<?php
  /*
    Send feedback of the selected payment.
  */
  session_start();
  /*connect to database*/
  require 'connect.php';
  /*if user is customer, pass name and StaffID values,stored within session, into variables.
   *if user is staff, change destination to staffview.php instead.
   *if user is neither staff nor customer, change destination to login.html instead.
   */
  if(isset($_SESSION['Name']) && $_SESSION['choice'] =='customer'){
    $Name = $_SESSION['Name'];
    $id = $_SESSION['CustomerID'];
  }
  else if(isset($_SESSION['Name']) && $_SESSION['choice'] =='staff'){
    header("location: staffview.php");
    exit;
  }
  else {
    header("location: login.html");
    exit;
  }
  /*check connection*/
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  /*same as feedbackreply.php
   *pass values from url and input from customerview.php into variables
   */
  $paymentid = mysqli_real_escape_string($con,$_GET['id']);
  $comment =  mysqli_real_escape_string($con,$_POST['comment']);
  /*add feedback into database 
   *if fails return an error message
   */
  $sql = "INSERT INTO `feedback` (`FeedbackID`, `PaymentID`, `Comment`, `StaffReply`, `StaffID`) 
                VALUES (NULL, $paymentid, '$comment', NULL, NULL)";
  if (!mysqli_query($con,$sql)) {
	die('Error: ' . mysqli_error($con));
	}
  /*after finish adding, go to customerview.php*/
    header("Location: customerview.php");
    mysqli_close($con);
?>

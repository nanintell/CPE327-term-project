<?php
/*
    Add a new movie into the database
  */
session_start();

/*connect to the database*/
require 'connect.php';
/*if user is staff, pass name and StaffID values,stored within session, into variables.
   *if user is customer, change destination to customerview.php instead.
   *if user is neither staff nor customer, change destination to login.html instead.
   */
if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'staff') {
  $Name = $_SESSION['Name'];
  $id = $_SESSION['StaffID'];
} else if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'customer') {
  header("location: customerview.php");
  exit;
} else {
  header("location: login.html");
  exit;
}

/*pass values from input from addmovie.php into variables*/
$title = mysqli_real_escape_string($con, $_POST['title']);
$plot = mysqli_real_escape_string($con, $_POST['plot']);
$duration = mysqli_real_escape_string($con, $_POST['duration']);
$airdate = mysqli_real_escape_string($con, $_POST['airdate']);
$audio = mysqli_real_escape_string($con, $_POST['audio']);
$subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
$photo = mysqli_real_escape_string($con, $_POST['photo']);
/*same as genresinsert.php
   *genres' passed values are number of genres data which are in 0 or 1
   *so we have to convert them to an array of genres id
   */
$genres = array();
$i = 0;
/*check database connection*/
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
/*query genres data*/
$sql = "SELECT GenresID FROM genres";
$result = mysqli_query($con, $sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    /*pass a value from genres checkbox input from addgenres.php into a temporary variable
       *if that value is not 0, pass its id into an array
       */
    $tempt = mysqli_real_escape_string($con, $_POST['g' . $row["GenresID"]]);
    if ($tempt != 0) {
      $genres[$i] = $tempt;
      $i = $i + 1;
    }
  }
}

/*add movie into the database*/
$sql = "INSERT INTO `movie` (`MovID`, `Title`, `Plot`, `Duration`, `AirDate`, `Audio`, `Subtitle`, `Photo`, `StaffID`) 
    VALUES (NULL, '$title', '$plot', '$duration', '$airdate', '$audio', '$subtitle', '$photo', $id)";
if (!mysqli_query($con, $sql)) {
  die('Error: ' . mysqli_error($con));
}

/*query newly added movie id 
   *due to id being auto increment, the new data's id will have highest value
   *add genres into the database by calling function insertgenresintodb from insertgenresintodb.php
   */
require 'insertgenresintodb.php';
$sql = "SELECT MAX(MovID) AS newmovie FROM movie";
$result = mysqli_query($con, $sql);
if ($result->num_rows == 1) {
  while ($row = $result->fetch_assoc()) {
    insertgenresintodb($i, $genres, $row["newmovie"]);
  }
}
/*after finish adding, go to movieconfig.php*/
header("Location: movieconfig.php");
mysqli_close($con);
?>

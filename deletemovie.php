<?php
/*
    Delete a movie from database
  */
session_start();
/*connect to the database*/
require 'connect.php';

/*check database connection*/
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

/*pass value from url into a variable*/
$id = mysqli_real_escape_string($con, $_GET['id']);

/*call deletemov function from deletefunction.php*/
require 'deletefunction.php';
deletemov($id);
/*after finish deleting, go to movieconfig.php*/
header("Location: movieconfig.php");
?>

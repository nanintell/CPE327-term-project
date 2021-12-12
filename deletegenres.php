<?php
  /*
    Delete a genre from database
  */
  session_start();
  /*connect to the database*/
  require 'connect.php';

  /*check database connection*/
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  /*pass values from url into variables*/
  $movieid = $_GET['movieid'];
  $genresid = $_GET['genresid'];

  /*call deletegen function from deletefunction.php*/
  require 'deletefunction.php';
  deletegen($movieid, $genresid);
  /*after finish deleting, go to movieconfig.php*/
  header("Location: movieconfig.php");
?>
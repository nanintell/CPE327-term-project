<?php
/*
  Log out user
*/
  session_start();
  /*destroy session*/
  session_destroy();
  /*after finish, go to hompage.php*/
  header("Location: homepage.php");
  exit;
?>

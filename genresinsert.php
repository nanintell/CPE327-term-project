<?php
  /*
    add new genres to the movie
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

    /*pass a value from movie input from addgenres.php into a variable*/
    $movie = mysqli_real_escape_string($con, $_POST['movie']);
    /*genres' passed values are number of genres data which are in 0 or 1
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
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
          /*pass a value from genres checkbox input from addgenres.php into a temporary variable
           *if that value is not 0, pass its id into an array
           */
          $tempt = mysqli_real_escape_string($con, $_POST['g'.$row["GenresID"]]);
          if($tempt != 0)
          {
            $genres[$i] = $tempt;
            $i = $i + 1;
          }
        }
    }

  /*add genres into the database by calling function insertgenresintodb from insertgenresintodb.php*/
  require 'insertgenresintodb.php';
  insertgenresintodb($i, $genres, $movie);
  /*after finish adding, go to movieconfig.php*/
  header("Location: movieconfig.php");

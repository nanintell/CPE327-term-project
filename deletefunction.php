<?php
  /*this file contains function to delete ticket, genres and movie
   *it was created to simplify delete movie operation as we need to delete all foreign keys first 
   *and movie is connected to many entities 
   */

  /*function to delete ticket*/
  function deletetics($id)
  {
    /*connect to the database and check connection*/
    require 'connect.php';
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    /*ticket is connected to payment but payment is also connected to seatbooking and feedback
     *thus, we have to delete payments' foreign keys first
     */

    /*delete connected data from seatbooking 
     *if fails, return an error message
     */
    $sql = "DELETE FROM `seatbooking` WHERE PaymentID IN (SELECT PaymentID FROM payment WHERE TicketID = $id)";
    if (!mysqli_query($con,$sql)) {
	    die('Error: ' . mysqli_error($con));
	}  

    /*delete connected data from feedback 
     *if fails, return an error message
     */
    $sql = "DELETE FROM `feedback` WHERE PaymentID IN (SELECT PaymentID FROM payment WHERE TicketID = $id)";
    if (!mysqli_query($con,$sql)) {
	    die('Error: ' . mysqli_error($con));
	}  

    /*delete connected data from payment 
     *if fails, return an error message
     */
    $sql = "DELETE FROM `payment` WHERE TicketID = $id";
    if (!mysqli_query($con,$sql)) {
	    die('Error: ' . mysqli_error($con));
	}
    
    /*delete ticket
    *if fails, return an error message
    */
    $sql = "DELETE FROM `ticket` WHERE TicketID = $id";
    if (!mysqli_query($con,$sql)) {
	    die('Error: ' . mysqli_error($con));
	}
    mysqli_close($con);
  }

  /*function to delete genres*/
  /*however, all it does is simply deleting a row of movgenres entity which tells which genres the movie belongs to.*/
  function deletegen($movieid, $genresid)
  {
    /*connect to the database and check connection*/
    require 'connect.php';
    if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
    }
  
    /*delete the row in movgenres
    *if fails, return an error message
    */
    $sql = "DELETE FROM `movgenres` WHERE MovID = $movieid AND GenresID = $genresid";
    if (!mysqli_query($con,$sql)) {
        die('Error: ' . mysqli_error($con));
      }

    mysqli_close($con);
  }

  /*function to delete movie
   *movie entity is connected to movgenres and ticket 
   *so we have to delete connnected tickets and movgenres first
   */
  function deletemov($id)
  {
    /*connect to the database and check connection*/
    require 'connect.php';
    if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
    }
  
    /*delete connected tickets
     *query connected ticket data
     */
    $sql = "SELECT TicketID FROM ticket WHERE MovID = $id";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) 
      {
        /*delete those tickets if found by calling deletetics function*/
        deletetics($row["TicketID"]);
      }
    }
  
    /*delete connected movgenres
     *query connected movgenres data
     */
    $sql = "SELECT GenresID FROM movgenres WHERE MovID = $id";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) 
      {
        /*delete those rows if found by calling deletegen function*/
        deletegen($id, $row["GenresID"]);
      }
    }
    
    /*delete movie
    *if fails, return an error message
    */
    $sql = "DELETE FROM `movie` WHERE MovID = $id";
    if (!mysqli_query($con,$sql)) {
        die('Error on deleting movie: ' . mysqli_error($con));
      }
    
    mysqli_close($con);
  }
?>
<?php
/*
    Add a new payment and booked seat into database.
  */
session_start();
/*connect to database*/
require 'connect.php';
/*if user is customer then pass values Name and CustomerID, stored within session, into name and id variables
   *also pass values from url into other variables 
   *if user is staff then change destination to staffview.php instead
   *if user is neither customer nor staff then change destination to login.html instead
   */
if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'customer') {
  $Name = $_SESSION['Name'];
  $id = $_SESSION['CustomerID'];
  $ticketid = $_GET["ticketid"];
  $seatid = $_GET["seatid"];
  $movieid = $_GET["movieid"];
} else if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'staff') {
  header("location: staffview.php");
  exit;
} else {
  header("location: login.html");
  exit;
}

/*function to validate values from url
   *since customer can edit values in url, we must check if they are valid values
   */
function ValidateValues($con, $movieid, $ticketid, $seatid)
{
  /*check database connection*/
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  /*query ticket data*/
  $sql = "SELECT MovID, AirTime from ticket where ticketID = $ticketid AND AirTime > CURRENT_TIMESTAMP;";
  $result = mysqli_query($con, $sql);
  /*if empty result ie. the ticketid value doesn't exist or the ticket's airtime has already been passed
      then return an error message and a button for user to go back to previous page.*/
  if ($result->num_rows == 0) {
    echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
              This ticket airtime has already been passed. Please choose ticket again.</h2>';
?>
    <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
      <a href="ticketselect.php?movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
        <strong>Go back</strong>
      </a>
    </div>
    <?php
  } else if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    /*if found but movieid does not match the input movieid 
       *then return an error message and buttons for user to go back to previous pages
       */
    if ($row["MovID"] != $movieid) {
      echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
        The movie ID does not match. Please choose ticket or movie again.</h2>';
    ?>
      <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:20px; padding-top:20px;">
        <a href="ticketselect.php?movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
          <strong>Ticket Selection</strong>
        </a>
      </div>
      <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
        <a href="movieselect.php" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
          <strong>Movie Selection</strong>
        </a>
      </div>
      <?php
    } else {
      /*query theater data from both seat and theater*/
      $sql = "SELECT t.TheaterID AS ttheater, s.TheaterID AS stheater FROM ticket t, seat s 
                  WHERE t.TicketID = $ticketid AND s.SeatID = $seatid";
      $result = mysqli_query($con, $sql);
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        /*if theaterID does not match then return an error message with buttons to go back to previous pages*/
        if ($row["ttheater"] != $row["stheater"]) {
          echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
                    Seat ID and Ticket ID are not valid. Please choose seat or ticket again.</h2>';
      ?>
          <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:20px; padding-top:20px;">
            <a href="seatselect.php?ticketid=<?php echo $ticketid; ?>&movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
              <strong>Seat Selection</strong>
            </a>
          </div>
          <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
            <a href="ticketselect.php?movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
              <strong>Ticket Selection</strong>
            </a>
          </div>
          <?php
        } else {
          /*query seat data*/
          $sql = "SELECT sb.SeatID FROM ticket t, seatbooking sb, payment p 
                    WHERE t.TicketID = p.TicketID AND p.PaymentID = sb.PaymentID AND p.Status != 'Cancelled'
                    AND sb.SeatID = $seatid AND t.TicketID = $ticketid";
          $result = mysqli_query($con, $sql);
          /*if empty result ie. the selected seat is free 
             *then return 1 to caller
             */
          if ($result->num_rows == 0)
            return 1;
          /*if found ie. the selected seat is booked already
             *then return an error message with buttons to go back to previous pages
             */
          else {
            echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
              The selected seat has already been booked. Please choose seat or ticket again.</h2>';
          ?>
            <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:20px; padding-top:20px;">
              <a href="seatselect.php?ticketid=<?php echo $ticketid; ?>&movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
                <strong>Seat Selection</strong>
              </a>
            </div>
            <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
              <a href="ticketselect.php?movieid=<?php echo $movieid; ?>" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
                <strong>Ticket Selection</strong>
              </a>
            </div>
<?php
          }
        }
      }
      /*for cases which do not match others then return an unknown error message*/ else {
        echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
                Unknown Error. Please try again.</h2>';
      }
    }
  } else {
    echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
              Unknown Error. Please try again.</h2>';
  }
  /*for cases which are not valid, return 0 to caller*/
  return 0;
}


/*if values are valid then insert payment and booked seat into database*/
if (ValidateValues($con, $movieid, $ticketid, $seatid) == 1) {
  /*insert payment data*/
  $sql = "INSERT INTO `payment` (`PaymentID`, `CustomerID`, `TicketID`, `Price`, `Status`) 
              SELECT NULL, '$id', '$ticketid', t.price + st.price, 'Unpaid' FROM ticket t, seattype st, seat s
              WHERE t.TicketID = $ticketid AND s.SeatID = $seatid AND s.STypeID = st.STypeID";
  if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
  }

  /*insert seatbooking data*/
  $sql = "INSERT INTO `seatbooking` (`SeatID`, `PaymentID`) 
            SELECT '$seatid', MAX(PaymentID) FROM `payment`";
  if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
  }
  /*after finish adding, go to customerview.php*/
  header("Location: customerview.php");
}
mysqli_close($con);
?>
<?php
/*
    Select seat to book.
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
    $movieid = $_GET["movieid"];
} else if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'staff')
    header("location: staffview.php");
else {
    header("location: login.html");
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Seat Selection</title>
    <script src="myscripts.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>


    <style>
        * {
            font-family: 'Waffle Regular';


        }

        .menubar {
            background-color: #225A69;
            /* padding: 15px; */
            opacity: 0.85;
            width: 100%;
            color: white;
            font-size: 30px;
            text-align: right;

        }

        .element {
            background-color: #119FA4;
            /* padding: 15px; */
            opacity: 0.85;
            width: 100%;
            color: white;
            font-size: 50px;
            text-align: left;
            margin: 0px 0px;
        }

        .element2 {
            background-color: rgba(17, 159, 164, 0.60);
            /* padding: 15px; */
            width: 100%;
            color: white;
            font-size: 30px;
            text-align: center;
            margin: 0px 0px;

        }

        .picstyle {
            width: 50px;
            position: absolute;
            z-index: 999;
            bottom: -160px;
        }

        .button1 {
            background-color: rgba(255, 255, 255, 0.3);
            background-position: center;
            border: none;
            padding: 0px 0px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 32px;
            font-family: 'Waffle Regular';
            border-radius: 12px;
            color: white;

        }

        h2 {
            font-size: 50px;
            color: navy;
        }

        .form-group {
            text-align: right;
        }

        .modal-body {
            color: black;
        }

        .btn-primary {
            font-size: 30px;
            border-radius: 12px;
        }

        .table-bordered {
            width: 100%;
        }

        .gg td,
        .gg th,
        .gg tr,
        .table-bordered thead td,
        .table-bordered thead th {
            border: 4px solid white;


        }
    </style>
</head>

<body>
    <!--header-->
    <div class="container-fluid">
        <div class="row">
            <div class="menubar">
                <div class="col">
                    <div class="col-sm-12" style="color:white; font-size:35px; text-align:center;">

                        <div class="form-group">
                            <a class="button1" style="width:250px">
                                <strong> <?php echo 'ID: ' . $id ?></strong>
                            </a>
                            <a class="button1" style="width:250px">
                                <strong> <?php echo $Name ?></strong>
                            </a>
                            <a href='logout.php' class="button1" style="width:250px">
                                <img src="picture/login (1).png" alt="" width="40px">
                                <strong> Log out</strong>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-12" style="color:white; font-size:35px; text-align:left;">
                        <div class="form-group">
                            <a href='ticketselect.php?movieid=<?php echo $movieid ?>' class="button1" style="width:250px">
                                <img src="picture/login (1).png" alt="" width="30px">
                                <strong> Back</strong>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-image:linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);">
        <!--title-->
        <h2 style='text-align:center;'><strong>Pick your seat</strong></h2>
        <?php
        /*check database connection*/
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        /*query ticket data ,same as paymentinsert.php*/
        $sql = "SELECT AirTime, MovID FROM ticket WHERE TicketID = $ticketid AND AirTime > CURRENT_TIMESTAMP";
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
            /*if found but movieid does not match the input movieid 
                 *then return an error message and buttons for user to go back to previous pages
                 */
            $row = $result->fetch_assoc();
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
                /*query seat data and show data in the form of 5 rows and 10 columns of seats
                     *unbooked seats can be clicked to select that seat and pass ticketid and movieid values to paymentinsert.php
                     *booked seats will have different color
                     */
                $sql = "SELECT s.SeatID, s.Row, s.Column
                                FROM ticket t, seat s, theater th
                                WHERE t.TheaterID = th.TheaterID AND s.TheaterID = th.TheaterID AND t.TicketID = $ticketid 
                                ORDER BY s.Row DESC, s.Column ASC";
                $rowcheck = '';
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                    echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
                                Screen
                            </h2><div style="width:720px;height:20px;background-color:white;margin: 0 auto;"></div>';
                    echo '<table style="width:720px;font-size:35px; text-align:center;margin: 0 auto; background-color:white;">
                                <thead>
                                    <tr style="color:#8F038E;font-size:40px;"></tr>
                                </thead>
                                <tbody style="color:#4B4D4A;">';
                    while ($row = $result->fetch_assoc()) {
                        if ($row["Column"] == 1 && $rowcheck == NULL)
                            echo '<tr>';
                        else if ($row["Column"] == 1 && $rowcheck != NULL)
                            echo '</tr><tr>';
                        if ($rowcheck != $row["Row"]) {
                            echo '<td style="width:75px;">' . $row["Row"] . '</td>';
                            $rowcheck = $row["Row"];
                        } else {
                            if ($row["Column"] == 4 || $row["Column"] == 8)
                                echo '<td style="width:20px"></td>';
                        }
                        echo '<td id=seat' . $row["SeatID"] . ' style="width:60px;">
                                    <a href="paymentinsert.php?seatid=' . $row["SeatID"] . '&ticketid=' . $ticketid . '&movieid=' . $movieid . '">
                                        <img src="picture/seatunbook.png" width="50" height="50"></a></td>';
                    }
                    echo '</tr>';
                    echo '<tr><td style="width:75px;"></td>';
                    for ($x = 1; $x <= 10; $x++) {
                        if ($x == 4 || $x == 8)
                            echo '<td style="width:20px"></td>';
                        echo '<td>' . $x . '</td>';
                    }
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                }
                /*query booked seats data*/
                $sql = "SELECT p.TicketID, s.SeatID FROM seatbooking sb, seat s, payment p, ticket t 
                                WHERE sb.SeatID = s.SeatID AND sb.PaymentID = p.PaymentID AND p.TicketID = t.TicketID 
                                AND p.Status != 'Cancelled' AND p.TicketID = $ticketid";
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        /*if found any then change those seats' picture into booked one
                             *each seat has its own id for javascript to identify and alter its appearance 
                             */
                ?>
                        <script>
                            document.getElementById("seat<?php echo $row["SeatID"] ?>").innerHTML =
                                '<img src="picture/seatbooked.png" width="50" height="50">';
                        </script>
        <?php
                    }
                }
            }
        } else {
            echo '<h2 style="width:720px;text-align:center;margin: 0 auto;background-color:silver;">
                        Unknown Error. Please try again.</h2>';
        }

        ?>
    </div>
</body>

</html>
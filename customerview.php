<!--
    Customer profile. 
    Consists of booked ticket data (logged in customer's payment data), sent feedback and/or replies.
-->
<?php
session_start();
/*connect to the database */
require 'connect.php';
/*if user is customer, pass name and StaffID values,stored within session, into variables.
   *if user is staff, change destination to staffview.php instead.
   *if user is neither staff nor customer, change destination to login.html instead.
   */
if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'customer') {
    $Name = $_SESSION['Name'];
    $id = $_SESSION['CustomerID'];
} else if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'staff') {
    header("location: staffview.php");
    exit;
} else {
    header("location: login.html");
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Customer View</title>
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
                            <a href='homepage.php' class="button1" style="width:250px">
                                <img src="picture/house.png" alt="" width="30px">
                                <strong> Home</strong>
                            </a>
                            <a href='movieselect.php' class="button1" style="width:250px">
                                <strong> Movie </strong>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-image:linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);">
        <!--payment view table's title-->
        <h2 style='text-align:center;'><strong>Reserved movie tickets</strong></h2>
        <?php
        /*check all payments' status
            *if any payments' status is unpaid and its booked ticket's airtime has already passed, 
            *that ticket is automatically cancelled.
            */
        /*check database connection*/
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        /*query data*/
        $sql = "SELECT PaymentID FROM payment, ticket 
            WHERE payment.TicketID = ticket.TicketID AND ticket.AirTime < CURRENT_TIMESTAMP AND payment.Status = 'Unpaid'";
        $result = mysqli_query($con, $sql);
        /*if query result is not empty, cancel those payment*/
        if ($result->num_rows > 0) {
            $sql = "UPDATE payment SET `Status` = 'Cancelled' 
                WHERE PaymentID IN (SELECT PaymentID FROM payment, ticket WHERE payment.TicketID = ticket.TicketID AND ticket.AirTime < CURRENT_TIMESTAMP AND payment.Status = 'Unpaid')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }

        /*payment view*/
        /*query payment data and show them in table*/
        $sql = "SELECT p.PaymentID, m.Title, t.AirTime, th.Name, s.Row, s.Column,  p.Price, p.Status 
            FROM payment p, ticket t, movie m, seatbooking sb, seat s, theater th, customer c
            WHERE t.TicketID = p.TicketID AND t.MovID = m.MovID AND sb.PaymentID = p.PaymentID AND sb.SeatID = s.SeatID 
            AND th.TheaterID = s.TheaterID AND c.CustomerID = p.CustomerID AND c.CustomerID = '$id'
            ORDER BY PaymentID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                          <tr style="color:#8F038E;font-size:40px;">
                            <th>PaymentID</th>
                            <th>Title</th>
                            <th>Air Time</th>
                            <th>Theater</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr style="color:#6E038E;font-size:40px;">
                    <td><?php echo $row["PaymentID"]; ?></td>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo $row["AirTime"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Row"] . $row["Column"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Status"] ?></td>
                    <!--cancel button-->
                    <!--the button will appear as the last attribute when the payment status of that row is "Unpaid" only-->
                    <td id="tic_status<?php echo $row["PaymentID"]; ?>">
                        <a class="button1" style="color:#8F038E;width:150px;cursor:pointer; " onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" onclick="ProceedNext(<?php echo $row['PaymentID']; ?>)" ;>
                            Cancel
                        </a>
                    </td>
                    <!--feedback form-->
                    <!--the form will appear as the last attribute when the payment status of that row is "Paid" and "Cancelled"-->
                    <td id="feedback_status<?php echo $row["PaymentID"]; ?>">
                        <form action="sendfeedback.php?id=<?php echo $row["PaymentID"]; ?>" method="POST">
                            <input type="text" class="form-control" style="font-size:25px;" id="commment" name="comment" required>
                            <button type="submit" class="button1" style="color:#8F038E;width:150px;cursor:pointer;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                                Send feedback
                            </button>
                        </form>
                    </td>
                </tr>
                <script>
                    /*script to control displaying of cancel button and feedback form.
                        *if status of the row is not "Unpaid", make cancel button of that row disappear.
                        *if it is "Unpaid", make feedback form disappear instead.
                        *each row's cancel button and feedback form has its own id 
                        *for javascript to identify which object to alter display.
                        */
                    status = "<?php echo $row["Status"] ?>"
                    id = "tic_status<?php echo $row["PaymentID"] ?>"
                    feedback = "feedback_status<?php echo $row["PaymentID"] ?>"
                    if (status != "Unpaid")
                        document.getElementById(id).style.display = "none";
                    else
                        document.getElementById(feedback).style.display = "none";
                </script>
                <script>
                    /*this script will make pop-up appear when user clicks cancel button
                     *if user confirms, it will cancel the selected ticket 
                     *ie. go to ticket_cancel.php and pass the paymentid to it.
                     */
                    function ProceedNext($id) {
                        answer = confirm("Cancel the ticket? This action cannot be undone.");
                        if (answer) {
                            window.location = "ticket_cancel.php?id=" + $id;
                        }
                    }
                </script>
        <?php
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if user hasn't booked any tickets yet, return an error message*/
            echo "<h2 style ='text-align:center;'>No reservation yet.</h2>";

        /*sent feedback view*/
        /*query feedback data and put them in table*/
        $sql = "SELECT t.AirTime, th.Name, s.Row, s.Column, p.Price, p.Status, 
            f.Comment, f.StaffReply
            FROM payment p, ticket t, seatbooking sb, seat s, theater th, feedback f
            WHERE t.TicketID = p.TicketID AND sb.PaymentID = p.PaymentID AND sb.SeatID = s.SeatID 
            AND th.TheaterID = s.TheaterID AND f.PaymentID = p.PaymentID AND p.CustomerID = $id";
        $result = mysqli_query($con, $sql);
        /*sent feedback view table's title*/
        echo "<h2 style ='text-align:center;'><strong>Sent Feedback</strong></h2>";
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                            <tr style="color:#8F038E;font-size:40px;">
                            <th>Air Time</th>
                            <th>Theater</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Reply</th>
                            </tr>
                        </thead>
                        <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
                echo '<tr style="color:#6E038E;font-size:40px;">';
                echo '<td>' . $row["AirTime"] . '</td>';
                echo '<td>' . $row["Name"] . '</td>';
                echo '<td>' . $row["Row"] . '' . $row["Column"] . '</td>';
                echo '<td>' . $row["Price"] . '</td>';
                echo '<td>' . $row["Status"] . '</td>';
                echo '<td>' . $row["Comment"] . '</td>';
                echo '<td>' . $row["StaffReply"] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if user hasn't sent any feedback yet, return an error message*/
            echo "<h2 style ='text-align:center;'>You haven't sent any feedback yet.</h2>";
        mysqli_close($con);
        ?>
    </div>


</body>

</html>
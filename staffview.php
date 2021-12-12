<?php
/*
    Staff profile. Consist of ticket data (only show tickets with future air date), non-replied and replied feedback.
  */
session_start();
/*connect to database*/
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
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Staff View</title>
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
                            <a href='movieconfig.php' class="button1" style="width:250px">
                                <strong> Edit Movie </strong>
                            </a>
                            <a href='ticketconfig.php' class="button1" style="width:250px">
                                <strong> Edit Ticket</strong>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-image:linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);">
        <?php
        /*check database connection*/
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        /*booked to-be-air tickets table*/
        /*query payment data and show them as a table*/
        $sql = "SELECT p.PaymentID, c.Name AS Customer, t.AirTime, th.Name, s.Row, s.Column, p.Price, p.Status
            FROM payment p, ticket t, seatbooking sb, seat s, theater th, customer c
            WHERE t.TicketID = p.TicketID AND sb.PaymentID = p.PaymentID AND sb.SeatID = s.SeatID 
            AND th.TheaterID = s.TheaterID AND c.CustomerID = p.CustomerID AND AirTime > CURRENT_TIMESTAMP 
            ORDER BY AirTime, Status";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            /*booked to-be-air tickets table's title*/
            echo "<h2 style ='text-align:center;'><strong>Reserved tickets</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                          <tr style="color:#8F038E;font-size:40px;">
                            <th>PaymentID</th>
                            <th>Customer</th>
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
                    <td><?php echo $row["Customer"]; ?></td>
                    <td><?php echo $row["AirTime"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Row"] . $row["Column"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Status"] ?></td>
                    <!--Paid button-->
                    <td id="tic_status<?php echo $row["PaymentID"]; ?>">
                        <a class="button1" style="color:#8F038E;width:150px;cursor:pointer; " onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" onclick="ProceedNext(<?php echo $row['PaymentID']; ?>)" ;>
                            Paid
                        </a>
                    </td>
                </tr>
                <script>
                    /*script to control displaying of paid button.
                     *if status of the row is not "Unpaid", make paid button of that row disappear.
                     *each row's paid button has its own id for javascript to identify which object to alter display.
                     */
                    status = "<?php echo $row["Status"] ?>"
                    id = "tic_status<?php echo $row["PaymentID"] ?>"
                    if (status != "Unpaid")
                        document.getElementById(id).style.display = "none";
                </script>
                <script>
                    /*this script will make pop-up appear when user clicks cancel button
                     *if user confirms, it will cancel the selected ticket 
                     *ie. go to ticket_paid.php and pass the paymentid to it.
                     */
                    function ProceedNext($id) {
                        answer = confirm("Confirm? This action cannot be undone.");
                        if (answer) {
                            window.location = "ticket_paid.php?id=" + $id;
                        }
                    }
                </script>
            <?php
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if empty result then return an error message*/
            echo "<h2 style ='text-align:center;'>No reservation yet.</h2>";

        /*same as customerview.php
             *check all payments' status
             *if any payments' status is unpaid and its booked ticket's airtime has already passed, 
             *that ticket is automatically cancelled.
             */
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

        /*non-replied feedback*/
        /*query feedback data with empty staffid and shows them as a table*/
        $sql = "SELECT c.Name AS Customer, t.AirTime, th.Name, s.Row, s.Column, p.Price, 
            p.Status, f.Comment, f.StaffReply, f.FeedbackID
            FROM payment p, ticket t, seatbooking sb, seat s, theater th, customer c, feedback f 
            WHERE t.TicketID = p.TicketID AND sb.PaymentID = p.PaymentID AND sb.SeatID = s.SeatID 
            AND th.TheaterID = s.TheaterID AND c.CustomerID = p.CustomerID AND f.StaffID IS NULL 
            AND f.PaymentID = p.PaymentID 
            ORDER BY p.PaymentID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            /*non-replied feedback table's title*/
            echo "<h2 style ='text-align:center;'><strong>Non-Replied Feedback</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                          <tr style="color:#8F038E;font-size:40px;">
                            <th>Customer</th>
                            <th>Air Time</th>
                            <th>Theater</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr style="color:#6E038E;font-size:40px;">
                    <td><?php echo $row["Customer"]; ?></td>
                    <td><?php echo $row["AirTime"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Row"] . $row["Column"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Status"]; ?></td>
                    <td><?php echo $row["Comment"]; ?></td>
                    <td>
                        <!--form to reply feedback-->
                        <form action="feedbackreply.php?id=<?php echo $row["FeedbackID"]; ?>" method="POST">
                            <input type="text" class="form-control" style="font-size:25px;" id="reply" name="reply" required>
                            <button type="submit" class="button1" style="color:#8F038E;width:150px;cursor:pointer;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                                <strong>Reply</strong>
                            </button>
                        </form>
                    </td>
                </tr>
        <?php
            }
            echo '</tbody>';
            echo '</table>';
        }

        /*replied feedback*/
        /*query feedback data and shows them as a table*/
        $sql = "SELECT c.Name AS Customer, t.AirTime, th.Name, s.Row, s.Column, p.Price, p.Status, 
            f.Comment, f.StaffReply, st.Name AS Staff 
            FROM payment p, ticket t, seatbooking sb, seat s, theater th, customer c, feedback f, staff st 
            WHERE t.TicketID = p.TicketID AND sb.PaymentID = p.PaymentID AND sb.SeatID = s.SeatID 
            AND th.TheaterID = s.TheaterID AND c.CustomerID = p.CustomerID AND f.StaffID = st.StaffID 
            AND f.PaymentID = p.PaymentID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            echo "<h2 style ='text-align:center;'><strong>Replied Feedback</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                          <tr style="color:#8F038E;font-size:40px;">
                            <th>Customer</th>
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
                echo '<td>' . $row["Customer"] . '</td>';
                echo '<td>' . $row["AirTime"] . '</td>';
                echo '<td>' . $row["Name"] . '</td>';
                echo '<td>' . $row["Row"] . '' . $row["Column"] . '</td>';
                echo '<td>' . $row["Price"] . '</td>';
                echo '<td>' . $row["Status"] . '</td>';
                echo '<td>' . $row["Comment"] . '</td>';
                echo '<td><b>' . $row["Staff"] . ": </b>" . $row["StaffReply"] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if empty result then return an error messsage*/
            echo "<h2 style ='text-align:center;'>No feedback yet.</h2>";
        mysqli_close($con);
        ?>
    </div>


</body>

</html>
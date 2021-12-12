<?php
/*
    Ticket Configuration. Consists of ticket data.
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
    <title>Ticket Configuration</title>
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
                            <a href='staffview.php' class="button1" style="width:250px">
                                <img src="picture/house.png" alt="" width="30px">
                                <strong> Back</strong>
                            </a>
                            <a href='movieconfig.php' class="button1" style="width:250px">
                                <strong> Edit Movie</strong>
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
        /*ticket table*/
        /*query ticket data and show them as a table*/
        $sql = "SELECT t.TicketID, m.Title, th.Name, t.AirTime, t.Price, s.Name as Staff, s.StaffID
        FROM ticket t, movie m, theater th, staff s
        WHERE m.MovID = t.MovID AND th.TheaterID = t.TheaterID AND s.StaffID = m.StaffID
        ORDER BY t.TicketID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            /*ticket table's title*/
            echo "<h2 style ='text-align:center;'><strong>Ticket List</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                    <thead>
                      <tr style="color:#8F038E;font-size:40px;">
                        <th>Ticket ID</th>
                        <th>Movie</th>
                        <th>Theater</th>
                        <th>AirTime</th>
                        <th>Price</th>
                        <th>Staff Added</th>
                        </tr>
                    </thead>
                    <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr style="color:#6E038E;font-size:40px;">
                    <td><?php echo $row["TicketID"]; ?></td>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["AirTime"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Staff"]; ?></td>
                    <td>
                        <!--delete button-->
                        <a class="button1" style="color:#8F038E;width:150px;cursor:pointer; " onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" onclick="ProceedNext(<?php echo $row['TicketID'] . ',' . $row['StaffID'] . ',' . $id; ?>)" ;>
                            <strong>Delete</strong>
                        </a>
                    </td>
                </tr>
                <script>
                    /*same as movieconfig.php
                     *this script will make pop-up appear when user clicks delete button
                     *if user confirms, it will delete the selected ticket 
                     *ie. go to deleteticket.php and pass the ticketid to it.
                     *however, if user is not staff who added clicked ticket, 
                     *pop-up will appear an error message instead.
                     */
                    function ProceedNext($ticid, $staffadd, $stafflog) {
                        if ($staffadd == $stafflog) {
                            answer = confirm("Delete the ticket? This action cannot be undone.");
                            if (answer) {
                                window.location = "deleteticket.php?id=" + $ticid;
                            }
                        } else {
                            window.alert("Only the staff ID " + $staffadd + " can manage this ticket.");
                        }
                    }
                </script>
        <?php
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if empty result then return an error message*/
            echo "<h2>No ticket</h2>";
        mysqli_close($con);
        ?>

        <!--add ticket button-->
        <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
            <a href="addticket.php" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
                <strong>Add ticket</strong>
            </a>
        </div>
    </div>
</body>

</html>
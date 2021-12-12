<?php
session_start();
/*connect to database*/
require 'connect.php';
/*if user is customer, pass name and CustomerID values,stored within session, into variables.
   *if user is not customer, set name to "Guest" and id to 0
   */
if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'customer') {
    $Name = $_SESSION['Name'];
    $id = $_SESSION['CustomerID'];
} else {
    $Name = "Guest";
    $id = 0;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Ticket Selection</title>
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
                                <!--if user is not a customer then do not show id-->
                                <strong> <?php
                                            if ($id != 0)
                                                echo 'ID: ' . $id;
                                            ?>
                                </strong>
                            </a>
                            <a class="button1" style="width:250px">
                                <strong> <?php echo $Name ?></strong>
                            </a>
                            <?php
                            /*if user is customer, show logout and profile buttons
                             *if not, show register, login and home buttons instead
                             */
                            if ($id != 0) {
                                echo
                                '<a href="logout.php" class="button1" style="width:250px">
                                <img src="picture/login (1).png" alt="" width="40px">
                                <strong> Log out</strong>
                            </a>';
                            } else {
                                echo
                                '<a href="customersignup.php" class="button1" style="width:250px">
                                <img src="picture/user.png" alt="" width="40px">
                                <strong> Register</strong>
                            </a>
                            <a href="login.html" class="button1" style="width:250px">
                                <img src="picture/login (1).png" alt="" width="40px">
                                <strong> Log IN</strong>
                            </a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-12" style="color:white; font-size:35px; text-align:left;">
                        <div class="form-group">
                            <a href='movieselect.php' class="button1" style="width:250px">
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
        <?php
        /*check database connection*/
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        /*pass value from url into a variable*/
        $movieid = $_GET["movieid"];

        /*query movie data and show result*/
        $sql = "SELECT Title, Plot, Duration, Audio, Subtitle, Photo FROM `movie` WHERE MovID = $movieid";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <h2><b><?php echo $row["Title"]; ?></b></h2>
                <p>
                    <img src=<?php echo $row["Photo"]; ?> style="width:300px;height:auto;margin-right:15px;float:left;">
                    <br>
                <h3 style="font-size:35px"><b>Plot</b></h3>
                <p style="font-size:35px"><?php echo $row["Plot"]; ?><br></p>
                <p style="font-size:35px"><b>Duration: </b><?php echo $row["Duration"]; ?><br></p>
                <p style="font-size:35px"><b>Audio: </b><?php echo $row["Audio"]; ?></p>
                <p style="font-size:35px"><b>Subtitle: </b><?php echo $row["Subtitle"]; ?></p>
                <p style="font-size:35px"><b>Genres: </b>
                    <?php
                }
                /*query movie's genres data
                 *if found any then show them
                 *if not, then display "-"
                 */
                $sql = "SELECT g.Name FROM `movgenres` mg, `genres` g WHERE mg.GenresID = g.GenresID AND MovID = $movieid";
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <?php echo $row["Name"]; ?>
                    <?php
                    }
                } else
                    echo '-';
                echo '</p></p>';

                /*query to-be-aired tickets and show them as a table*/
                $sql = "SELECT t.TicketID, th.Name AS Theater, t.AirTime, t.Price
            FROM ticket t, theater th
            WHERE th.TheaterID = t.TheaterID AND t.MovID = $movieid AND t.AirTime > CURRENT_TIMESTAMP
            ORDER BY t.AirTime ASC";
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                    /*ticket's table title*/
                    echo "<h2 style ='text-align:center;'><strong>Ticket List</strong></h2>";
                    echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                        <thead>
                          <tr style="color:#8F038E;font-size:40px;">
                            <th>Air Time</th>
                            <th>Theater</th>
                            <th>Price</th>
                            </tr>
                        </thead>
                        <tbody style="color:#4B4D4A;">';
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr style="color:#6E038E;font-size:40px;">
                            <td><?php echo $row["AirTime"]; ?></td>
                            <td><?php echo $row["Theater"]; ?></td>
                            <td><?php echo $row["Price"]; ?></td>
                            <td id=<?php echo "customeronly" . $row["TicketID"]; ?>>
                                <!--select ticket button-->
                                <a class="button1" style="color:#8F038E;width:150px;cursor:pointer; " onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" href="seatselect.php?ticketid=<?php echo $row["TicketID"]; ?>&movieid=<?php echo $movieid; ?>">
                                    <strong>Select</strong>
                                </a>
                            </td>
                        </tr>
                        <script>
                            /*script to control displaying of select button.
                             *if id is 0, make all of select buttons disappear.
                             *each row's select button has its own id for javascript to identify which object to alter display.
                             */
                            var userid = <?php echo $id ?>;
                            if (userid == 0) {
                                id = "customeronly<?php echo $row["TicketID"] ?>";
                                document.getElementById(id).style.display = "none";
                            }
                        </script>
            <?php
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else
                    /*if empty result then return an error message*/
                    echo "<h2>No tickets avaliable for this movie yet.</h2>";
            } else
                echo "<h2>Unknown Error. Please try again later.</h2>";
            mysqli_close($con);
            ?>
    </div>
</body>

</html>
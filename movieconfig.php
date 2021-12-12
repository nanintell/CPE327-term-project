<?php
/*
    Movie setting for staffs. Consists of movie view and genres view.
*/
session_start();
/*connect to the database*/
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
    <title>Movie Configuration</title>
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
        /*query movie data and add them to the table*/
        $sql = "SELECT m.MovID, m.Title, m.Plot, m.Duration, m.AirDate, m.Audio, m.Subtitle, m.Photo, s.Name, s.StaffID 
          FROM `movie` m, staff s 
          WHERE m.StaffID = s.StaffID
          ORDER BY m.MovID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            /*movie view table's title*/
            echo "<h2 style ='text-align:center;'><strong>Movie List</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                    <thead>
                      <tr style="color:#8F038E;font-size:40px;">
                        <th>Movie ID</th>
                        <th>Title</th>
                        <th>Plot</th>
                        <th>Duration</th>
                        <th>Air Date</th>
                        <th>Audio</th>
                        <th>Subtitle</th>
                        <th>Photo</th>
                        <th>Staff Added</th>
                        </tr>
                    </thead>
                    <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr style="color:#6E038E;font-size:40px;">
                    <td><?php echo $row["MovID"]; ?></td>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo $row["Plot"]; ?></td>
                    <td><?php echo $row["Duration"]; ?></td>
                    <td><?php echo $row["AirDate"]; ?></td>
                    <td><?php echo $row["Audio"]; ?></td>
                    <td><?php echo $row["Subtitle"]; ?></td>
                    <td><?php echo '<img src="' . $row["Photo"] . '"width="200" height="300">'; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td>
                        <!--delete button-->
                        <a class="button1" style="color:#8F038E;width:150px;cursor:pointer; " onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" onclick="ProceedNext(<?php echo $row['MovID'] ?>, <?php echo $row['StaffID'] ?>)" ;>
                            <strong>Delete</strong>
                        </a>
                    </td>
                </tr>
                <script>
                    /*this script will make pop-up appear when user clicks delete button
                     *if user confirms, it will delete the selected movie 
                     *ie. go to deletemovie.php and pass the movieid to it.
                     *however, if user is not staff who added clicked movie, 
                     *pop-up will appear an error message instead.
                     */
                    function ProceedNext($movie, $staff) {
                        $logstaff = <?php echo $id; ?>;
                        if ($logstaff == $staff) {
                            answer = confirm("Delete the movie? This action cannot be undone.");
                            if (answer) {
                                window.location = "deletemovie.php?id=" + $movie;
                            }
                        } else {
                            alert("Only Staff ID " + $staff + " can manage this movie.");
                        }
                    }
                </script>
        <?php
            }
            echo '</tbody>';
            echo '</table>';
        } else
            /*if empty result then return an error message*/
            echo "<h2>No movie</h2>";
        ?>

        <!--add movie button-->
        <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
            <a href="addmovie.php" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
                <strong>Add movie</strong>
            </a>
        </div>

        <?php
        /*genres view*/
        /*query movie data and add them to the table*/
        $sql = "SELECT m.MovID, m.Title, s.Name AS Staff, s.StaffID
        FROM `movie` m, staff s
        WHERE m.StaffID = s.StaffID
        ORDER BY m.MovID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            echo "<h2 style ='text-align:center;'><strong>Genres List</strong></h2>";
            echo '<table class="table table-bordered gg" style="font-size:35px; text-align:center;">
                    <thead>
                      <tr style="color:#8F038E;font-size:40px;">
                        <th>Movie ID</th>
                        <th>Title</th>
                        <th>Staff</th>
                        <th>Genres</th>
                        </tr>
                    </thead>
                    <tbody style="color:#4B4D4A;">';
            while ($row = $result->fetch_assoc()) {
                echo '<tr style="color:#6E038E;font-size:40px;">';
                echo '<td>' . $row["MovID"] . '</td>';
                echo '<td>' . $row["Title"] . '</td>';
                echo '<td>' . $row["Staff"] . '</td>';
                $movieid = $row["MovID"];
                /*query genres data and add them to the table*/
                $sql = "SELECT g.Name, g.GenresID FROM movgenres mg, genres g 
                        WHERE g.GenresID = mg.GenresID AND mg.MovID = $movieid";
                $result2 = mysqli_query($con, $sql);
                if ($result2->num_rows > 0) {
                    echo '<td>';
                    while ($row2 = $result2->fetch_assoc()) {
                        echo $row2["Name"];
        ?>
                        <!--delete button-->
                        <a class="button1" style="color:#8F038E;width:150px;cursor:pointer;float:right;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" onclick="ProceedNextG(<?php echo $row['MovID'] . ',' . $row2['GenresID'] . ',' . $row['StaffID']; ?>)" ;>
                            <strong>Delete</strong>
                        </a>
                        <br>
                        <script>
                            /*this script will make pop-up appear when user clicks delete button
                             *if user confirms, it will delete the selected genre 
                             *ie. go to deletegenres.php and pass the movieid and genresid to it.
                             *however, if user is not staff who added clicked movie, 
                             *pop-up will appear an error message instead.
                             */
                            function ProceedNextG($movie, $genre, $staff) {
                                $logstaff = <?php echo $id; ?>;
                                if ($logstaff == $staff) {
                                    answer = confirm("Delete the genre of this movie? This action cannot be undone.");
                                    if (answer) {
                                        window.location = "deletegenres.php?movieid=" + $movie + "&genresid=" + $genre;
                                    }
                                } else {
                                    alert("Only Staff ID " + $staff + " can manage this movie.");
                                }
                            }
                        </script>
        <?php
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else
            echo "No genres";
        ?>
        <!--add genres button-->
        <div class="col-sm-12" style="color:#8F038E; font-size:35px; text-align:center; padding-bottom:70px; padding-top:20px;">
            <a href="addgenres.php" class="button1" style="width:250px;color:#8F038E;cursor:pointer;">
                <strong>Add genres</strong>
            </a>
        </div>

        <?php
        mysqli_close($con);
        ?>
    </div>
</body>

</html>
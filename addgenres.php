<!--
  Form for staff to add genres to one of the movies he added.
-->
<?php
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
<html>

<head>
    <meta charset="utf-8" />
    <title>Add Movie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <style>
        * {
            font-family: 'Waffle Regular';
        }

        .element {
            background-color: #119FA4;
            /* padding: 15px; */
            opacity: 0.85;
            width: 100%;
            color: white;
            font-size: 50px;
            text-align: left;
            margin: 20px 0px;
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

        .element2 {
            background-color: rgba(17, 159, 164, 0.36);
            /* padding: 15px; */
            width: 100%;
            color: white;
            font-size: 30px;
            text-align: center;
            margin: 20px 0px;
            padding: 10px 500px;
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

        .form-control {
            font-size: 25px !important;
        }

        .picstyle {
            width: 50px;
            position: absolute;
            z-index: 999;
            bottom: -160px;
            padding: 0px 0px;
        }

        .text {
            font-size: 30px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 204px;
            top: 275px;
        }

        .text1 {
            font-size: 25px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 10px;
            top: 320px;
        }

        .text2 {
            font-size: 25px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 200px;
            top: 340px;
        }

        .text3 {
            font-size: 25px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 95px;
            top: 360px;
        }

        .text4 {
            font-size: 25px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 220px;
            top: 380px;
        }

        .text5 {
            font-size: 25px;
            color: black;
            position: absolute;
            z-index: 999;
            right: 265px;
            top: 400px;
        }
    </style>
</head>

<body>
    <!--header-->
    <div class="container-fluid">
        <div class="row">
            <div class="menubar">
                <div class="col">
                    <div class="col-sm-12" style="color:white; font-size:35px; text-align:right;">

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

                    <div class="col-sm-12" style="color:white; font-size:35px; text-align:right;">
                        <div class="form-group">
                            <a href='movieconfig.php' class="button1" style="width:250px">
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

    <!--form-->
    <!--require all input to be filled-->
    <div class="container-fluid">
        <div class="row">
            <div class="element2">
                <form action="genresinsert.php" method="POST" id="sectionForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <!--movie select input-->
                            <!--let staff choose the movie he added only-->
                            <label for="title">Movie</label>
                            <select name="movie" class="form-control" required>
                                <?php
                                /*check database connection*/
                                if (!$con) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }
                                /*query data*/
                                $sql = "SELECT MovID, Title FROM movie WHERE StaffID = $id";
                                $result = mysqli_query($con, $sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value=' . $row["MovID"] . '>' . $row["Title"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <!--genres checkbox input-->
                            <!--query all genres in the database-->
                            <label for="genres">Movie Genres<br>Note: If some input are already existed, they will not be added.</label>
                            <?php
                            /*check database connection*/
                            if (!$con) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                            /*query data*/
                            $sql = "SELECT GenresID, `Name` FROM genres";
                            $result = mysqli_query($con, $sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    /*unchecked checkbox will send value 0 while checked ones will send value 1*/
                                    echo '<input type="hidden" name=g' . $row["GenresID"] . ' value=0>';
                                    echo '<input type="checkbox" class="form-control" id=g' . $row["GenresID"] . ' name=g' . $row["GenresID"] . ' 
                                                value=' . $row["GenresID"] . '>';
                                    echo '<label for=g' . $row["GenresID"] . '>' . $row["Name"] . '</label>';
                                }
                            }
                            ?>
                        </div>
                        <div style="width:100%">
                            <input type="submit" value="submit" style="border-radius: 15px; width: 100px; border: 1px solid black; font-size: 25px;background-color: white;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
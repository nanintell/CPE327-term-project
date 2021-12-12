<?php
/*
    Search operation and show result.
 */
session_start();
/*connect to database*/
require 'connect.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Search Result</title>
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
    <?php
    /*pass value from keyword input from movieselect.php into a variable*/
    $keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    /*same as genresinsert.php
         *genres' passed values are number of genres data which are in 0 or 1
         *we need to loop check and add the values to string
        */
    $genres_query = "";
    /*check database connection*/
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    /*query genres data*/
    $sql = "SELECT GenresID FROM genres";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            /*pass a value from genres checkbox input from addgenres.php into a temporary variable
                 *if that value is not 0, add the value and a space to string 
                 */
            $tempt = mysqli_real_escape_string($con, $_POST['g' . $row["GenresID"]]);
            if ($tempt != 0) {
                $genres_query = $genres_query . $tempt . " ";
            }
        }
        /*if string is not empty ie. there are some values added to the string
             *trim outer space of string and replace inner space with comma
             *make it into a part of query code
             */
        if ($genres_query != "") {
            $genres_query = str_replace(' ', ', ', rtrim($genres_query, " "));
            $genres_query = " AND g.GenresID IN (" . $genres_query . ") ";
        }
    }

    /*query movie data with keyword and selected genres*/
    $sql = "SELECT DISTINCT m.MovID, m.Title, m.Photo 
        FROM movie m, movgenres mg, genres g
        WHERE m.MovID = mg.MovID AND g.GenresID = mg.GenresID 
        AND (m.Title LIKE '%$keyword%' OR m.Plot LIKE '%$keyword%')" . $genres_query . " ORDER BY m.MovID";
    /*if found then show result in gallery form, same as in movieselect.php*/
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
            <div style="margin: 5px;border: 1px solid #ccc;float: left;width: 286px;height:507px">
                <a href=<?php echo "ticketselect.php?movieid=" . $row["MovID"]; ?>>
                    <img style="width: 100%;height: auto;" src=<?php echo $row["Photo"] ?> width="400" height="600">
                </a>
                <div style="font-size:24px;padding:15px;text-align:center;height:80px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                    <a style="color:black;" href=<?php echo "ticketselect.php?movieid=" . $row["MovID"]; ?>>
                        <?php echo $row["Title"]; ?>
                    </a>
                </div>
            </div>
    <?php
        }
    }
    /*if empty result then return an error message*/ else
        echo "<h2>No movie found</h2>";
    mysqli_close($con);
    ?>
    </div>

</body>

</html>
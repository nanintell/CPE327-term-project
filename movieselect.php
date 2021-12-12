<?php
/* 
   Movie menu 
  */
session_start();
/*connect to the database*/
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
    <title>Movie Selection</title>
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
                            </a>
                            ';
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
                            <?php
                            if ($id != 0) {
                                echo
                                '<a href="customerview.php" class="button1" style="width:250px">
                                <img src="picture/671802.png" alt="" width="40px">
                                <strong> Profile</strong>
                            </a>';
                            }
                            ?>
                            <a href='homepage.php' class="button1" style="width:250px">
                                <img src="picture/house.png" alt="" width="30px">
                                <strong> Home</strong>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-image:linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);">
        <!--title-->
        <h2 style='text-align:center;'><strong>Movie List</strong></h2>
        <!--search movie form-->
        <!--this form does not require all input to submit-->
        <form class="form-inline" action="search.php" method="POST">
            <!--keyword text input-->
            <div style="padding-right:20px;padding-top:20px;padding-bottom:30px;margin:auto;">
                <input type="text" class="form-control" style="font-size:25px;width:500px;" id="keyword" name="keyword" placeholder="Input keyword here">
            </div>
            <!--genres checkbox input-->
            <?php
            /*check database connection*/
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }
            /*query genres data*/
            $sql = "SELECT GenresID, `Name` FROM genres";
            $result = mysqli_query($con, $sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<label class="checkbox-inline" style="padding-right:20px;padding-top:20px;font-size:30px;">';
                    echo '<input type="hidden" name=g' . $row["GenresID"] . ' value=0>';
                    echo '<input type="checkbox" class="form-control" id=g' . $row["GenresID"] . ' name=g' . $row["GenresID"] . ' 
                            value=' . $row["GenresID"] . '>' . $row["Name"];
                    echo '</label>';
                }
            }
            ?>
            <button type="submit" class="button1" style="color:#8F038E;width:150px;cursor:pointer;margin:auto;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                Search
            </button>
        </form>
        <?php
        /*query movie data and shows it in gallery form*/
        $sql = "SELECT MovID, Title, Photo FROM movie ORDER BY MovID";
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
        } else
            /*if empty result, return an error message*/
            echo "<h2>No movie</h2>";
        mysqli_close($con);
        ?>
    </div>

</body>

</html>
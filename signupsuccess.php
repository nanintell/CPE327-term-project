<?php
/*
    After submit customer form and have no problem, this file will appear to notify id and name
*/
session_start();

/*if id in session is empty then change destination to customersignup.php instead*/
if ($_SESSION['id'] == "") {
    header("location: customersignup.php");
    exit();
}

$Name = $_SESSION['Name'];
$id = $_SESSION['id'];
session_unset();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.0/normalize.css"> -->

    <!-- import font to html -->
    <link rel="stylesheet" type="text/css" href="font.css">
    <style>
        html {
            background: url(picture/hi-2.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            font-family: 'Waffle Regular';
            width: 100%;
        }


        body,
        html {
            height: 100%;
        }

        h1 {
            font-family: 'Waffle Regular';
            font-size: 60px;
            color: white;

        }

        h2 {
            font-family: 'Waffle Regular';
            font-size: 45px;
            color: white;

        }

        body {
            /* height: 100%; */
            background-color: transparent;
        }

        .button {
            background-color: white;
            background-position: center;
            opacity: 0.7;
            border: none;
            padding: 10px 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 40px;
            font-family: 'Waffle Regular';
            border-radius: 12px;
            color: navy;
        }


        .show {
            display: block;
        }
    </style>
</head>

<body>
    <!--message-->
    <!--show name and id for customer-->
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-sm" style="text-align: center">
                <div class="form-group">
                    <div>
                        <img src="picture/registericon.png" alt="" width=180px;>
                    </div>
                    <h1><strong>Register Success</strong></h1>
                    <h1><strong>Welcome</strong></h1>
                    <h2><?php echo $Name . " (ID: " . $id . ")"; ?></h2>
                    <h2>Please use your ID and Password to log in.</h2>
                    <div class="form-group">
                        <a href="homepage.php" class="button">Home</a>
                        <a href="login.html" class="button">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        /*When the user clicks on the button,toggle between hiding and showing the dropdown content*/
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        /*Close the dropdown if the user clicks outside of it*/
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {

                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>


</body>

</html>
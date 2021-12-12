<!--
    Homepage
-->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home Page</title>
    <script src="myscripts.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        * {
            font-family: 'Waffle Regular';
        }

        html {
            background: url(picture/home.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            font-family: 'Waffle Regular';
            width: 100%;
        }

        body {
            /* height: 100%; */
            background-color: transparent;
        }

        box {
            top: 350px;
            border-radius: 15%
        }

        .button {
            background-color: #76FF00;
            background-position: center;
            border: none;
            padding: 0px 0px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 30px;
            font-family: 'Waffle Regular';
            border-radius: 12px;
            color: white;
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

        .dropbtn {
            background-color: transparent;
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
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: lightskyblue;
        }

        .dropdown {

            display: inline-block;
            height: 100%;
            border-radius: 12px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            font-family: 'Waffle Regular';
            font-size: 32px;
            color: navy;
            border-radius: 12px;
        }

        .dropdown-content a {
            color: n;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-family: 'Waffle Regular';
            font-size: 35px;
        }

        .dropdown a:hover {
            background-color: lightskyblue
        }
    </style>
</head>

<body>
    <!--menu-->
    <div class="container-fluid" style="margin-top:200px;text-align:center;">
        <div class="row">
            <div class="col" style="display:inline-flex;">
                <!--movie-->
                <div class="col-sm-4" style="color:white; font-size:50px; text-align:center; ">
                    <div class="form-group">
                        <a href="movieselect.php" class="button1" style="width:50%">
                            <img src="picture/film.png" alt="" width="100%">
                            <strong> Movie</strong>
                        </a>
                    </div>
                </div>
                <!--
                    these 2 menus differ depending on users
                    if user is customer or staff, menu will show log out and his name 
                    and clicking his name will lead to his customer or staff profile
                    if not, register and log in will show instead
                -->
                <?php
                if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'customer') {
                    echo "<div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
        <div class=\"form-group\">
            <div class=\"dropdown\">
                <a href=\"#\" class=\"button1\" style=\"width:70%\">
                    <img src=\"picture/user.png\" alt=\"\" width=\"20%\">
                    <button onclick =\"location.href='customerview.php'\"onmouseover=\"myFunction()\" class=\"dropbtn\">" . $_SESSION['Name'] . "</button>
                </a>

            </div>
        </div>
    </div>";
                    echo "  <div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
        <div class=\"form-group\">
            <a href='logout.php' class=\"button1\" style=\"width:40%\">
                <img src=\"picture/user.png\" alt=\"\" width=\"30%\">
                <strong> Log out</strong>
            </a>
        </div>
    </div>";
                } else if (isset($_SESSION['Name']) && $_SESSION['choice'] == 'staff') {
                    echo "<div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
      <div class=\"form-group\">
          <div class=\"dropdown\">
              <a href=\"#\" class=\"button1\" style=\"width:70%\">
                  <img src=\"picture/user.png\" alt=\"\" width=\"20%\">
                  <button onclick =\"location.href='staffview.php'\"onmouseover=\"myFunction()\" class=\"dropbtn\">" . $_SESSION['Name'] . "</button>
              </a>

          </div>
      </div>
  </div>";
                    echo "  <div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
      <div class=\"form-group\">
          <a href='logout.php' class=\"button1\" style=\"width:40%\">
              <img src=\"picture/login (1).png\" alt=\"\" width=\"30%\">
              <strong> Log out</strong>
          </a>
      </div>
  </div>";
                } else {
                    echo "<div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
        <div class=\"form-group\">
            <div class=\"dropdown\">
                <a href=\"#\" class=\"button1\" style=\"width:50%\">
                    <img src=\"picture/user.png\" alt=\"\" width=\"100%\">
                    <button onmouseover=\"myFunction()\" class=\"dropbtn\">Sign up</button>
                    <div id=\"myDropdown\" class=\"dropdown-content\">
                        <a href='customersignup.html'>Customer</a>
                        <a href='staffregister.html'>Apply for job</a>
                    </div>
                </a>

            </div>
        </div>
    </div>";
                    echo "<div class=\"col-sm-4\" style=\"color:white; font-size:25px;text-align:center;\">
          <div class=\"form-group\">
              <a href='login.html' class=\"button1\" style=\"width:50%\">
                  <img src=\"picture/login (1).png\" alt=\"\" width=\"100%\">
                  <strong> Log in</strong>
              </a>
          </div>
      </div>";
                }

                ?>

                <!--faq-->
                <div class="col-sm-4" style="color:white; font-size:25px;text-align:center;">
                    <div class="form-group">
                        <a href="FAQ.html" class="button1" style="width:50%">
                            <img src="picture/question (1).png" alt="" width="100%">
                            <strong> FAQ</strong>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        /* When the user clicks on the button,
         * toggle between hiding and showing the dropdown content 
         */
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

<?php
/* connect to the database for the application, ticket_reservation
   if fail, return error message
 */
$con = mysqli_connect("localhost", "root", "", "ticket_reservation");


if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_set_charset($con, "utf8");

?>

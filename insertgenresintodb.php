<?php
  /*this file contains function to insert an array of genres into the database
   *it was created to simplify adding movie operation as it also needs to add genres as well  
   */

    /*function to insert an array of genres into the database*/
    function insertgenresintodb($i, $genres, $movie)
    {
        /*connect to the database*/
        require 'connect.php';
        /*check database connection*/
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        /*for loop adding each element into movgenres
         *however, before we add, we check if values have already existed first
         *if some values do, skip those values
         */
        for($j = 0; $j < $i; $j++)
        {
            $sql = "SELECT `MovID`, `GenresID` FROM `movgenres` WHERE MovID = $movie AND GenresID = $genres[$j]";
            $result = mysqli_query($con, $sql);
            if($result->num_rows == 0)
            {
                $sql = "INSERT INTO `movgenres` (`MovID`, `GenresID`) 
                    VALUES ($movie, $genres[$j])";
	            if (!mysqli_query($con,$sql)) {
                    die('Error: ' . mysqli_error($con));
                }
            }
        }
        mysqli_close($con);
    }
?>
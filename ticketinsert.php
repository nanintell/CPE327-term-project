<?php
  session_start();
  /*connect to database*/
  require 'connect.php';
  /*if user is staff, pass name and StaffID values,stored within session, into variables.
   *if user is customer, change destination to customerview.php instead.
   *if user is neither staff nor customer, change destination to login.html instead.
   */
  if(isset($_SESSION['Name']) && $_SESSION['choice'] =='staff'){
    $Name = $_SESSION['Name'];
    $id = $_SESSION['StaffID'];
  }
  else if(isset($_SESSION['Name']) && $_SESSION['choice'] =='customer')
  {
    header("location: customerview.php");
    exit;
  }
  else {
    header("location: login.html");
    exit;
  }
  
	/*pass values from input from addticket.php into variables*/
	$movie = mysqli_real_escape_string($con, $_POST['movie']);
	$theater = mysqli_real_escape_string($con, $_POST['theater']);
	$airtime_tempt = mysqli_real_escape_string($con, $_POST['airtime']);
  /*convert airtime to valid datetime format*/
  $airtime_insert = date('Y-m-d G:i:s', strtotime($airtime_tempt));
	$price = mysqli_real_escape_string($con, $_POST['price']);
  /*this variable is to check is input airtime has overlapped with others or not*/
  $timeoverlap = false;

    /*check database connection*/
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    /*query input movie duration data and passed value to a variable*/
    $sql = "SELECT Duration FROM movie WHERE MovID = $movie";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows == 1)
    {
        while($row = $result->fetch_assoc())
        {
            $duration = $row["Duration"];
        }

        /*edited on 2021/08/12 - fix bug on check time overlapping operation*/
        /*split duration data into 3 variables representing hours, minutes and seconds
         *convert the 3 variables into a dateinterval 
         *convert airtime into datetime and add dateinterval to create endtime
         *https://www.php.net/manual/en/datetime.add.php
         */
        sscanf($duration, '%d:%d:%d', $h,$m,$s);
        $interval_string = 'PT'.$h.'H'.$m.'M'.$s.'S';
        /*we need to set endtime separately because 
         *datetime.add's result is added to the original variable
         *ex. date->add(dateinterval) means date = date + dateinterval 
         */
        $airtime = new DateTime($airtime_insert);
        $endtime = new DateTime($airtime_insert);

        $endtime->add(new DateInterval($interval_string));

        /*query tickets' time data*/
        $sql = "SELECT t.AirTime, m.Duration, ADDTIME(t.AirTime, m.Duration) as EndTime FROM `ticket`t, movie m
          WHERE t.TheaterID = $theater AND m.MovID = t.MovID";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {
                /*set temporary variables for checking
                 *if input airtime overlaps with others then set timeoverlap to true
                 */
                $check_airtime = new DateTime($row["AirTime"]);
                $check_endtime = new DateTime($row["EndTime"]);
                $check_duration = $row["Duration"];

                if($duration <= $check_duration)
                {
                    if((($check_airtime <= $endtime) && ($endtime <= $check_endtime)) || 
                          (($check_airtime <= $airtime) && ($airtime <= $check_endtime)))
                          {
                            $timeoverlap = true;
                          }
                }
                else
                {
                    if((($airtime < $check_airtime) && ($check_airtime < $endtime)) || 
                      (($airtime < $check_endtime) && ($check_endtime < $endtime)))
                      {
                        $timeoverlap = true;

                      }
                }
            }
        }

        /*if timeoverlap is false then add ticket data into database
         *if fails return an error message
         */
        if($timeoverlap == false)
        {
            $sql="INSERT INTO `ticket` (`TicketID`, `MovID`, `TheaterID`, `AirTime`, `Price`) 
                VALUES (NULL, '$movie', '$theater', '$airtime_insert', '$price')";
	        if (!mysqli_query($con,$sql)) {
	            die('Error: ' . mysqli_error($con));
	        }
            /*after finish adding, go to ticketconfig.php*/
            header("Location: ticketconfig.php");
        }
        else
        {
            /*if timeoverlap is true then display an error message 
             *and automatically go back to ticketconfig.php in 1.5 seconds
             */
            echo "Your Air Time is overlapped with other tickets'. Please check and try again.";
            echo "<script>setTimeout(\"location.href = 'ticketconfig.php';\",1500);</script>";
        }
    }
    else
    {
        echo "Unknown error. Please try again.";
        echo "<script>setTimeout(\"location.href = 'addticket.php';\",1500);</script>"; 
    }
    mysqli_close($con);
?>
<?php
    session_start();
    $con = mysqli_connect("localhost:3306", "root", "");
    mysqli_select_db($con, 'clubsofpdeu');

    $club = $_POST['club'];
    $event = $_POST['event-name'];
    $password = $_POST['event-pass'];

    $isauthorized = "select * from authorization where Club='$club' and Password='$password'";
    $result = mysqli_query($con, $isauthorized);

    if(mysqli_num_rows($result)==1) {
        mysqli_query($con, "delete from events where Name='$event' and Club='$club'");
        echo 'The event has been successfully removed!<br>';
        echo '<a href="upcoming_events.php">Click here to view all the events!</a>'; 
    }
    else{
        echo 'The name of the club and secret key do not match. The event has not been removed!';
    }
?>
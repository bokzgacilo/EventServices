<?php
// Establish a connection to the database
$con = mysqli_connect("localhost", "root", "", "reservationform");

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($con, "reservationform")) {
    die("Database selection failed: " . mysqli_error($con));
}
?>
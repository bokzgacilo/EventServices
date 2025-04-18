<?php
  include("connection.php");

  session_start();

  $pid = $_POST['pid'];
  $price = $_POST['price'];

  $event_date = $_POST['event_date'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];

  $event_address = $_POST['event_address'];
  $client_name = $_SESSION['userfullname'];
  $client_contact = $_POST['client_contact'];
  $client_email = $_SESSION['useremail'];

  $insert = $conn -> query("INSERT INTO event_reservations(pid, price, event_date, event_start, event_end, client_name, client_contact, client_email, venue) VALUES(
  $pid, $price, '$event_date', '$start_time', '$end_time', '$client_name', '$client_contact', '$client_email', '$event_address')");

  if($insert){
    echo "ok";
  }

  $conn -> close();
?>
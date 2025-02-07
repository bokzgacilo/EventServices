<?php
  include("connection.php");

  $pid = $_POST['pid'];
  $price = $_POST['price'];
  $event_date = $_POST['event_date'];
  $event_address = $_POST['event_address'];
  $client_name = $_POST['client_name'];
  $client_contact = $_POST['client_contact'];
  $client_email = $_POST['client_email'];

  $insert = $conn -> query("INSERT INTO event_reservations(pid, price, event_date, client_name, client_contact, client_email, venue) VALUES(
  $pid, $price, '$event_date', '$client_name', '$client_contact', '$client_email', '$event_address')");

  if($insert){
    echo "ok";
  }

  $conn -> close();
?>
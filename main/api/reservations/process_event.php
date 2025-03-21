<?php
include("../connection.php");

$reservation_id = $_POST['rid'];
$action = $_POST['action'];

$updated_status = "";

switch($action){
  case "confirm" :
    $updated_status = "Pending";
    break;
  case "pending" :
    $updated_status = "Completed";
    break;
  case "cancelled" :
    $updated_status = "Cancelled";
    break;
}

$sql = "UPDATE event_reservations SET event_status = '$updated_status' WHERE id = $reservation_id";
if($conn -> query($sql)){
  echo 1;
}

$conn -> close();

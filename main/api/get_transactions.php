<?php
  // include_once 'connection.php';
  include("connection.php");

  $query = "
    SELECT 
      payments.*, 
      event_reservations.payment_status 
    FROM 
      payments 
    LEFT JOIN 
      event_reservations 
    ON 
      payments.event_id = event_reservations.id
  ";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
  }

  $packages = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $packages[] = $row;
  }

  header('Content-Type: application/json');
  echo json_encode($packages);
?>
<?php
  include("connection.php");

  $query = "SELECT * FROM event_reservations";
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
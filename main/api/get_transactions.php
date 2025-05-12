<?php
  // include_once 'connection.php';
  include("connection.php");

  $query = "SELECT * FROM payments";
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
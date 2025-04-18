<?php
  include("connection.php");

  $client = $_POST['client'];
  $query = "SELECT * FROM tbl_users WHERE name = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $client);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
      echo "Name: " . htmlspecialchars($row['name']) . "<br>";
      echo "Email: " . htmlspecialchars($row['email']);
  } else {
      echo "No user found.";
  }
  $stmt->close();
  $conn->close();

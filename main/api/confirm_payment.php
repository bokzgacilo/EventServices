<?php
require 'connection.php'; // Adjust to your setup

if (isset($_POST['event_id'])) {
  $event_id = intval($_POST['event_id']);

  $stmt = $conn->prepare("UPDATE event_reservations SET payment_status = 'Partially Paid' WHERE id = ?");
  $stmt->bind_param("i", $event_id);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
  } else {
    http_response_code(500);
    echo json_encode(['status' => 'error']);
  }

  $stmt->close();
  $conn->close();
}
?>
<?php
// delete_user.php
include 'connection.php'; // adjust this as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);

  $stmt = $conn->prepare("DELETE FROM tbl_users WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    http_response_code(200);
    echo "User deleted";
  } else {
    http_response_code(500);
    echo "Failed to delete user";
  }

  $stmt->close();
  $conn->close();
} else {
  http_response_code(400);
  echo "Invalid request";
}

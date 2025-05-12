<?php
session_start();
header('Content-Type: application/json');
include("connection.php");

if (!isset($_SESSION['userfullname'])) {
  echo json_encode([
    "status" => "error",
    "message" => "User not logged in"
  ]);
  exit;
}

$who = $_SESSION['userfullname'];
$message = trim($_POST['feedback'] ?? '');
$event_id = intval($_POST['event_id_feedback'] ?? 0);

if ($message === '' || $event_id === 0) {
  echo json_encode([
    "status" => "error",
    "message" => "Feedback message or event ID is missing."
  ]);
  exit;
}

$stmt = $conn->prepare("INSERT INTO feedback (event_id, message, who, date_created) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iss", $event_id, $message, $who);

if ($stmt->execute()) {
  echo json_encode([
    "status" => "success",
    "message" => "Feedback submitted successfully."
  ]);
} else {
  echo json_encode([
    "status" => "error",
    "message" => "Database error: " . $conn->error
  ]);
}

$stmt->close();
$conn->close();
?>
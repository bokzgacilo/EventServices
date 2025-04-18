<?php
header('Content-Type: application/json');

session_start();
include("connection.php");

$client_id = $_POST['client_id']; // Assuming client_id is sent in the POST request

$query = "SELECT otp FROM tbl_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  if ((string)$_POST['otp'] === (string)$row['otp']) {
      // Set session variables
      $_SESSION['usertype'] = $_POST['client_type'];
      $_SESSION['userid'] = $_POST['client_id'];
      $_SESSION['userfullname'] = $_POST['client_name'];
      $_SESSION['useremail'] = $_POST['client_email'];

      echo json_encode(['status' => 'success', 'message' => 'OTP Verified']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'OTP Mismatch']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'No User Found']);
  exit;
}
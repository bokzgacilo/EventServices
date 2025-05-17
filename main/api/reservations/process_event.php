<?php
include("../connection.php");
include("../../../mailer.php");
header('Content-Type: application/json'); // Set header to return JSON

$reservation_id = $_POST['rid'];
$action = $_POST['action'];

$updated_status = "";

switch ($action) {
  case "confirmed":
    $updated_status = "Confirmed";
    break;
  case "pending":
    $updated_status = "Completed";
    break;
  case "cancelled":
    $updated_status = "Cancelled";
    break;
}

$sql = "SELECT id, client_email, client_name, price FROM event_reservations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $id = $row['id'];
  $email = $row['client_email'];
  $name = $row['client_name'];
  $price = $row['price'];

  // Step 2: Send payment link
  sendPaymentLink($email, $name, $id, $price);

  // Step 3: Update status
  $updateSql = "UPDATE event_reservations SET event_status = ? WHERE id = ?";
  $updateStmt = $conn->prepare($updateSql);
  $updateStmt->bind_param("si", $updated_status, $reservation_id);
  $updateStmt->execute();
  

  echo json_encode(["status" => "success", "title" => "Event Confirmed", "description" => "Payment link sent to the email."]);
} else {
  echo json_encode(["status" => "not-found", "title" => "Reservation Not Found", "description" => "Reservation not found, please contact administrator."]);
}

$stmt->close();
$conn->close();

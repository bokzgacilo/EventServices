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

  $getContactSql = "SELECT client_contact FROM event_reservations WHERE id = ?";
  $stmtGetContact = $conn->prepare($getContactSql);
  $stmtGetContact->bind_param("i", $event_id);
  $stmtGetContact->execute();
  $result = $stmtGetContact->get_result();

  $clientNumber = "";

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clientNumber = $row['client_contact'];
    // Do something with $clientNumber, like send SMS
  } else {
    // Handle case when no matching record is found
    $clientNumber = null;
  }

  $client = new GuzzleHttp\Client();
  $apiKey = 'uk_amG_hB7AfEE6Jn_DrAQ9kG67x4bW_6REbbbugwjcHwbNHS4-wXzSE2UQ_QjBBlfr';
  $devApiKey = 'uk_ir-RizoshRhFu2X-IxEoQBY_aRb56AWfUG85YFnbO-IyDzAUJRD3hMZNouQh05oj';

  $message = "Payment with event with an ID: $event_id is confirmed, please coordinate with Queens And Knights Event Services.";

  $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
    'headers' => [
      'x-api-key' => $apiKey,
    ],
    'json' => [
      'content' => $message,
      'from' => '+639187885334', //default
      'to' => $clientNumber
    ]
  ]);

  $stmt->close();
  $conn->close();
}
?>
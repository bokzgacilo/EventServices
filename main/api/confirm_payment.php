<?php
require 'connection.php'; // Adjust to your setup
include_once("../../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

  $getContactSql = "SELECT client_contact, client_name, client_email FROM event_reservations WHERE id = ?";
  $stmtGetContact = $conn->prepare($getContactSql);
  $stmtGetContact->bind_param("i", $event_id);
  $stmtGetContact->execute();
  $result = $stmtGetContact->get_result();

  $clientNumber = "";
  $clientName = "";
  $clientEmail = "";

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clientNumber = $row['client_contact'];
    $clientName = $row['client_name'];
    $clientEmail = $row['client_email'];
  } else {
    $clientNumber = null;
  }

  $mail = new PHPMailer(true);
  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@queenandknighteventservices.site';
    $mail->Password = '2/fF9>|Jk';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 'ssl' also works
    $mail->Port = 465;

    // Recipients
    $mail->setFrom('support@queenandknighteventservices.site', 'Queens And Knights Support');
    $mail->addAddress($clientEmail, $clientName);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Reservation Confirmed!';

    $mail->Body = "
          Dear $clientName,<br><br>
          Reservation ID: <strong>$event_id</strong><br>
          If you have any questions or concerns, feel free to reach out to our support team.<br><br>
          Best regards,<br>
          Queen and Knights Event Services
        ";


    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
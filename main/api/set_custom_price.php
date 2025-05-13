

<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require '../../vendor/autoload.php';
  include("../../mailer.php");
  
  function notifyClient($custom_request_id, $clientEmail, $clientName, $price) {
    $mail = new PHPMailer(true);
  
    try {
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
      $mail->Subject = 'Price Change Notification';
      // $mail->Body = "Dear $clientName,<br><br>The price has been updated to PHP$price.<br><br>You can view the details of your request <a href='http://localhost/eventservices/main/my-account.php?req=$custom_request_id'>here</a>.<br><br>Best regards,<br>Queen and Knights Event Services";
      $mail->Body = "Dear $clientName,<br><br>The price has been updated to PHP$price.<br><br>You can view the details of your request <a href='https://queenandknighteventservices.site/main/my-account.php?req=$custom_request_id'>here</a>.<br><br>Best regards,<br>Queen and Knights Event Services";
  
      $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
  
  include("connection.php");

  $requestid = $_POST['custom_request_id'];
  $client = $_POST['client'];
  $client_email = $_POST['client_email'];
  $price = $_POST['price'];
  $event_status = "Confirmed";

  $sql = "UPDATE event_reservations SET price = ?, event_status = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("dsi", $price,$event_status, $requestid);

  if ($stmt->execute()) {
    sendPaymentLink( $client_email, $client, $requestid, $price);
    echo 1;
  } else {
    echo "Error updating price: " . $conn->error;
  }

  $stmt->close();
  $conn -> close();
?>
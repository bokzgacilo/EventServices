

<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require '../../vendor/autoload.php';
  
  function notifyClient($custom_request_id, $clientEmail, $clientName, $price) {
    $mail = new PHPMailer(true);
  
    try {
      // Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
      $mail->SMTPAuth = true;
      $mail->Username = 'bokwebmaster2000@gmail.com'; // Replace with your email
      $mail->Password = 'wakjlhpqrwuvgkdn'; // Replace with your email password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;
  
      // Recipients
      $mail->setFrom('bokwebmaster2000@gmail.com', 'Queens And Knights Support'); // Replace with your email and name
      $mail->addAddress($clientEmail, $clientName);
  
      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Price Change Notification';
      $mail->Body = "Dear $clientName,<br><br>The price has been updated to PHP$price.<br><br>You can view the details of your request <a href='http://localhost/eventservices/main/my-account.php?req=$custom_request_id'>here</a>.<br><br>Best regards,<br>Queen and Knights Event Services";
  
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

  $sql = "UPDATE custom_packages_request SET price = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("di", $price, $requestid);

  if ($stmt->execute()) {
    notifyClient($requestid, $client_email, $client, $price);
    echo 1;
  } else {
    echo "Error updating price: " . $conn->error;
  }

  $stmt->close();
  $conn -> close();
?>
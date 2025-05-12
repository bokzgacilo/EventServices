<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'vendor/autoload.php';

  function sendOtpToEmail($email, $name, $otp) {
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
      $mail->addAddress($email, $name);
  
      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Your OTP Code';
      $mail->Body = "Dear $name,<br><br>Your OTP code is <strong>$otp</strong>.<br><br>Please use this code to complete your login.<br><br>Best regards,<br>Queen and Knights Event Services";
  
      $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }

  function sendSignupOtpToEmail($email, $name, $otp) {
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
      $mail->addAddress($email, $name);
  
      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Verify Your Signup - OTP Code';
      $mail->Body = "Dear $name,<br><br>Your One-Time Password (OTP) for verifying your signup is <strong>$otp</strong>.<br><br>Please enter this code to complete your registration.<br><br>Best regards,<br>Queen and Knights Event Services";
  
      $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }

  function sendPaymentLink($email, $name, $reservation_id, $price) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bokwebmaster2000@gmail.com';
        $mail->Password = 'wakjlhpqrwuvgkdn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('bokwebmaster2000@gmail.com', 'Queens And Knights Support');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Complete Your Payment for Reservation #' . $reservation_id;

        $paymentLink = "http://localhost/eventservices/main/payment.php?rid=$reservation_id"; // Adjust the link as needed

        $mail->Body = "
            Dear $name,<br><br>
            Thank you for your reservation!<br><br>
            Reservation ID: <strong>$reservation_id</strong><br>
            Amount Due: <strong>₱" . number_format($price, 2) . "</strong><br><br>
            To complete your booking, please proceed with the payment using the link below:<br>
            <a href='$paymentLink'>Pay Now</a><br><br>
            <strong>Please note:</strong> Your payment must be made <u>before the event date</u> to process and confirm your reservation.<br><br>
            If you have any questions or concerns, feel free to reach out to our support team.<br><br>
            Best regards,<br>
            Queen and Knights Event Services
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require '../../vendor/autoload.php';

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
?>
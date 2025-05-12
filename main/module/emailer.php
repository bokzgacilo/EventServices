<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require '../../vendor/autoload.php';

  function sendOtpToEmail($email, $name, $otp) {
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
     $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@queenandknighteventservices.site';
        $mail->Password = '2/fF9>|Jk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 'ssl' also works
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('support@queenandknighteventservices.site', 'Queens And Knights Support');
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
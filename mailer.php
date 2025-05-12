<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'vendor/autoload.php';

  function sendPaymentLink($email, $name, $reservation_id, $price) {
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
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Complete Your Payment for Reservation #' . $reservation_id;

        $paymentLink = "https://queenandknighteventservices.site/main/payment.php?rid=$reservation_id"; // Adjust the link as needed
        // $paymentLink = "http://localhost/eventservices/main/payment.php?rid=$reservation_id"; // Adjust the link as needed

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
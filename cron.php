<?php
  include "sms.php";
  include "main/api/connection.php";
  include "vendor/autoload.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $today = date('Y-m-d');
  $tomorrow = date('Y-m-d', strtotime('+1 day'));
  $nextWeek = date('Y-m-d', strtotime('+7 days'));

  function processReminders($conn, $targetDate, $label) {
    $mail = new PHPMailer(true);
    

    $sql = "SELECT id, event_date, client_email, client_name, client_contact
            FROM event_reservations
            WHERE DATE(event_date) = '$targetDate' AND payment_status='Partially Paid' AND event_status='Confirmed'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      try {
          // Server settings
          $mail->isSMTP();
          $mail->Host = 'smtp.hostinger.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'support@queenandknighteventservices.site';
          $mail->Password = '2/fF9>|Jk';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 'ssl' also works
          $mail->Port = 465;
          $mail->setFrom('support@queenandknighteventservices.site', 'Queens And Knights Support');

           while ($row = $result->fetch_assoc()) {
            $rowWithLabel = $row;
            $rowWithLabel['label'] = $label;
            print_r($rowWithLabel);
            sendReminderSms($row['id'], "+63".$row['client_contact']);

            $mail->addAddress($row['client_email'], name: $row['client_name']);
            $mail->isHTML(true);
            $mail->Subject = 'Event Reminder ' . $row['id'];
            $formattedDate = date('M d, Y', strtotime($targetDate));
            $mail->Body = "
              Dear ".$row['client_name'].",<br><br>
              Upcoming Reservation!<br><br>
              Reservation ID: <strong>".$row['id']."</strong><br>
              You have upcoming event $label, $formattedDate
              <br>If you have any questions or concerns, feel free to reach out to our support team.<br><br>
              Best regards,<br>
              Queen and Knights Event Services
            ";

            $mail->send();
          }
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }
  
  processReminders($conn, $today, 'Today');
  processReminders($conn, $tomorrow, 'Tomorrow');
  processReminders($conn, $nextWeek, 'Nextweek');

  $conn->close();
?>
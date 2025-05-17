<?php
  include "sms.php";
  include "main/api/connection.php";
  include "vendor/autoload.php";

  $today = date('Y-m-d');
  $tomorrow = date('Y-m-d', strtotime('+1 day'));
  $nextWeek = date('Y-m-d', strtotime('+7 days'));

  function processReminders($conn, $targetDate, $label) {
    $sql = "SELECT id, event_date, client_contact
            FROM event_reservations
            WHERE DATE(event_date) = '$targetDate'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $rowWithLabel = $row;
        $rowWithLabel['label'] = $label;
        print_r($rowWithLabel);
        sendReminderSms($row['id'], "+63".$row['client_contact']);
      }
    }
  }
  
  processReminders($conn, $today, 'today');
  processReminders($conn, $tomorrow, 'tomorrow');
  processReminders($conn, $nextWeek, 'next_week');

  $conn->close();
?>
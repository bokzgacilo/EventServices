<?php
include("connection.php");

$event_id = $_GET['event_id'];
// Fetch feedback for the event
$feedback_sql = "SELECT * FROM feedback WHERE event_id = ?";
if ($feedback_stmt = $conn->prepare($feedback_sql)) {
  $feedback_stmt->bind_param("i", $event_id);
  $feedback_stmt->execute();
  $feedback_result = $feedback_stmt->get_result();

  if ($feedback_result->num_rows > 0) {
    echo "<div class='feedback-section mt-4'>
                <h5 class='mb-4'>Feedbacks</h5>";

    while ($feedback = $feedback_result->fetch_assoc()) {
      $feedback_date = date("F j, Y", strtotime($feedback['date_created']));
      echo "
            <div class='feedback mb-3'>
              <div class='d-flex flex-row justify-content-between'>
                <p><strong>" . htmlspecialchars($feedback['who']) . "</strong> </p>
                <p style='font-size: 10px;'>$feedback_date</p>              
              </div>
              <p class='mt-1'>" . htmlspecialchars($feedback['message']) . "</p>
            </div>
          ";
    }

    echo "</div>"; // End of feedback section
  } else {
    echo "<p>No feedback available for this event.</p>";
  }

  $feedback_stmt->close();
}
?>
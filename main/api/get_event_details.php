<?php
include("connection.php");

// Get the event_id from the URL
$event_id = $_GET['id'];

// Query to get event reservation details
$sql = "SELECT * FROM event_reservations WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $event_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $reservation = $result->fetch_assoc();

    // Event date formatting
    $event_date = date("F j, Y", strtotime($reservation['event_date']));
    $start_time = date("g:i A", strtotime($reservation['event_start']));
    $end_time = date("g:i A", strtotime($reservation['event_end']));

    // Rendering the UI content
    echo "
      <div class='event-details'>
        <div class='image-container-modal'>";

    // Fetch images for the event
    $image_dir = "../../images/event_gallery/$event_id";
    $images = glob($image_dir . "/*.{jpg,png,gif,jpeg}", GLOB_BRACE); // Assuming all images are .jpg, adjust as needed
    foreach ($images as $image) {
      // Use basename to get only the file name and make sure the relative path is correct
      $image_name = basename($image);
      echo "<img style='width:100%; height: 300px; object-fit: cover;'  class='img-fluid' src='../images/event_gallery/$event_id/$image_name' alt='Event Image' />";
    }

    echo "
      </div>
        <div class='event-info'>
          <h3>Event: " . htmlspecialchars($reservation['client_name']) . "'s Event</h3>
          <p><strong>Date:</strong> $event_date</p>
          <p><strong>Time:</strong> $start_time - $end_time</p>
          <p><strong>Venue:</strong> " . htmlspecialchars($reservation['venue']) . "</p>
        </div>
      </div>
    ";
    echo "
    <script>
        $('.image-container-modal').slick({
          arrows: true,
          dots: true,
        });
    </script>
    ";
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
                <p><strong>" . htmlspecialchars($feedback['who'])."</strong> </p>
                <p style='font-size: 10px;'>$feedback_date</p>              
              </div>
              <p class='mt-1'>".htmlspecialchars($feedback['message'])."</p>
            </div>
          ";
        }

        echo "</div>"; // End of feedback section
      } else {
        echo "<p>No feedback available for this event.</p>";
      }

      $feedback_stmt->close();
    }
    $stmt->close();
  } else {
    echo "<p>No reservation found for this event.</p>";
  }

} else {
  echo "<p>Failed to prepare the query.</p>";
}

$conn->close();
?>
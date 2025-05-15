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

    // Format the price (e.g., 10000 -> 10,000.00)
    $formattedPrice = number_format($reservation['price'], 2);

    // Check if inclusions is "default"
    $inclusions = $reservation['inclusions'];
    if (strtolower(trim($inclusions)) === 'default') {
        // Fetch default inclusions from event_packages using pid
        $pid = $reservation['pid'];
        $stmt = $conn->prepare("SELECT inclusions FROM event_packages WHERE id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $inclusions = $row['inclusions'];
        }
    }

    // Break inclusions by comma and format into lines
    $inclusionLines = '';
    foreach (explode(',', $inclusions) as $item) {
        $inclusionLines .= "<li>" . htmlspecialchars(trim($item)) . "</li>";
    }

    


    echo "
      </div>
        <div class='event-info d-flex flex-column gap-2'>
          <h4>" . htmlspecialchars($reservation['client_name']) . "'s Event</h3>
          <p><strong>Date:</strong> $event_date</p>
          <p><strong>Time:</strong> $start_time - $end_time</p>
          <p><strong>Venue:</strong> " . htmlspecialchars($reservation['venue']) . "</p>
          <p><strong>Price:</strong> ₱" . $formattedPrice . "</p>
          <p><strong>Inclusions:</strong></p><ul>" . $inclusionLines . "</ul>
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
    
    $stmt->close();
  } else {
    echo "<p>No reservation found for this event.</p>";
  }

} else {
  echo "<p>Failed to prepare the query.</p>";
}

$conn->close();
?>
<?php
include_once("connection.php");

if (isset($_POST['req'])) {
  $id = $_POST['req'];

  $sql = "SELECT * FROM event_reservations WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id); // "i" = integer
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $formattedPrice = number_format($row['price'], 2);
    $formattedDate = date("F j, Y", strtotime($row['event_date']));
    $formattedStart = date("g:i A", strtotime($row['event_start']));
    $formattedEnd = date("g:i A", strtotime($row['event_end']));
    $formattedCreatedAt = date("F j, Y g:i A", strtotime($row['created_at']));

    echo "<div style='margin-bottom: 2rem;'>";
    echo "<p><strong>ID:</strong> " . htmlspecialchars($row['id']) . "</p>";
    echo "<p><strong>Price:</strong> ₱" . $formattedPrice . "</p>";
    echo "<p><strong>Event Date:</strong> " . $formattedDate . "</p>";
    echo "<p><strong>Time:</strong> " . $formattedStart . " - " . $formattedEnd . "</p>";
    echo "<p><strong>Client Name:</strong> " . htmlspecialchars($row['client_name']) . "</p>";
    echo "<p><strong>Client Email:</strong> " . htmlspecialchars($row['client_email']) . "</p>";
    echo "<p><strong>Venue:</strong> " . htmlspecialchars($row['venue']) . "</p>";

    echo "<p><strong>Inclusions:</strong></p><ul>";
    $inclusions = explode(',', $row['inclusions']);
    foreach ($inclusions as $inclusion) {
      echo "<li>" . htmlspecialchars(trim($inclusion)) . "</li>";
    }
    echo "</ul>";

    echo "<p><strong>Event Status:</strong> " . htmlspecialchars($row['event_status']) . "</p>";
    echo "<p><strong>Payment Status:</strong> " . htmlspecialchars($row['payment_status']) . "</p>";
    echo "<p class='mb-4'><strong>Created At:</strong> " . $formattedCreatedAt . "</p>";

    echo "<p class='mt-4'>If you wish to cancel or have any issues with your reservation, please contact our support team at:</p>";
        echo "<p><strong>Phone:</strong> 0976222095X</p>";
        echo "<p><strong>Email:</strong> <a href='mailto:support@queenandknighteventservices.site'>support@queenandknighteventservices.site</a></p>";
    echo "</div>";
  } else {
    echo "No event found.";
  }

  $stmt->close();
} else {
  echo "Invalid request.";
}
?>
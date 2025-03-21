<?php
session_start();
include_once("api/connection.php");

$sql = "SELECT id, event_date, client_name, venue FROM event_reservations WHERE event_status = 'Completed'";
$result = $conn->query($sql);

$reservations = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Gallery</title>
  <script src="../assets/fullcalendar/main.min.js"></script>
  <link rel="stylesheet" href="../assets/fullcalendar/main.min.css" />
  <link rel="stylesheet" href="../assets/fullcalendar/custom-calendar.css" />

  <?php
  include './reusables/asset_loader.php';
  ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
</head>

<body>
  <div class="container-fluid p-0 m-0">
    <?php
    include_once("reusables/headbar.php");
    ?>

    <div class="event-gallery-section">
      <h1 class="event-title">EVENT GALLERY</h1>
      <p>Completed Reservations Showcase</p>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($reservations as $reservation): ?>
          <div class="col">
            <div class="card">
              <div class="p-0 card-body">
                <div class="images-container">
                  <?php
                  $imageDir = "../images/event_gallery/" . $reservation['id'];
                  $images = glob($imageDir . "/*.{jpg,png,gif,jpeg}", GLOB_BRACE); // Get all image files

                  if (!empty($images)):
                    foreach ($images as $image):
                  ?>
                      <img src="<?= htmlspecialchars($image) ?>" class="img-fluid" style="width: 100%; height: 500px; object-fit: cover;" alt="Event Image">
                    <?php
                    endforeach;
                  else:
                    ?>
                    <img src="images/default.jpg" class="img-fluid" style="width: 100%; height: 500px; object-fit: cover;" alt="Default Image"> <!-- Fallback image -->
                  <?php endif; ?>
                </div>

                <div class="d-flex flex-column p-4">
                  <h5 class="card-title"><?= htmlspecialchars($reservation['client_name']) ?></h5>
                  <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($reservation['event_date']) ?></p>
                  <p class="card-text"><strong>Venue:</strong> <?= htmlspecialchars($reservation['venue']) ?></p>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>

  <?php
  include_once("reusables/footbar.php");
  ?>

  <script>
    $('.images-container').slick({
      arrows: true,
      dots: true,
    });
  </script>
</body>

</html>
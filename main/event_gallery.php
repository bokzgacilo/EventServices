<?php
session_start();
include_once("api/connection.php");

$sql = "SELECT 
  er.id, 
  er.event_date, 
  er.client_name, 
  er.venue, 
  ep.type 
FROM 
  event_reservations er
JOIN 
  event_packages ep ON er.pid = ep.id
WHERE 
  er.event_status = 'Completed';
";

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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
</head>

<body>
  <style>
    .feedback {
      display: flex;
      flex-direction: column;
    }
  </style>
  <div class="container-fluid p-0 m-0">
    <?php
    include_once("reusables/headbar.php");
    ?>

    <div class="modal fade" id="eventDetailsModal" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Event Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column" id="event-detail-container">

            </div>
            <form id="feedbackForm" class="d-flex flex-row gap-2 justify-content-between align-items-start">
              <input type="hidden" name="event_id_feedback" />
              <textarea class="form-control form-control-sm auto-resize" name="feedback" rows="1"
                placeholder="Write a comment..." required></textarea>
              <button type="submit" class="btn btn-primary btn-sm">Comment</button>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


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
                      <img src="<?= htmlspecialchars($image) ?>" class="img-fluid"
                        style="width: 100%; height: 500px; object-fit: cover;" alt="Event Image">
                      <?php
                    endforeach;
                  else:
                    ?>
                    <img src="images/default.jpg" class="img-fluid" style="width: 100%; height: 500px; object-fit: cover;"
                      alt="Default Image"> <!-- Fallback image -->
                  <?php endif; ?>
                </div>

                <div class="d-flex flex-row justify-content-between p-4">
                  <a href="javascript:void(0);" class="open-modal" data-id="<?= $reservation['id'] ?>">
                    <?= htmlspecialchars($reservation['client_name']) ?>'s <?= htmlspecialchars($reservation['type']) ?>
                    Event
                  </a>
                  <p><strong></strong> <?= htmlspecialchars(date('F j, Y', strtotime($reservation['event_date']))) ?></p>
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

    $('#feedbackForm').on('submit', function (e) {
      e.preventDefault();

      var formdata = new FormData(this);

      $.ajax({
        url: 'api/make_feedback.php',
        type: 'POST',
        processData: false, 
        contentType: false,
        data: formdata,
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire('Success', response.message, 'success');

            $('#feedbackForm')[0].reset(); // clear textarea
            $("#eventDetailsModal").modal("hide")
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        },
        error: function () {
          Swal.fire('Error', 'Something went wrong with the request.', 'error');
        }
      });
    });


    $(".open-modal").on("click", function () {
      var event_id = $(this).attr("data-id");
      $.ajax({
        type: 'get',
        url: "api/get_event_details.php",
        data: {
          id: event_id
        },
        success: response => {
          $("input[name='event_id_feedback']").val(event_id)
          $("#eventDetailsModal").modal("show")
          $("#event-detail-container").html(response)
        }
      })
    })
  </script>
</body>

</html>
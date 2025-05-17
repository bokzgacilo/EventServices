<?php
session_start();
$packageid = $_GET['packageid'];
$package = [];
$reservedDates = [];

include_once("api/connection.php");

$get_all_reserved_dates = $conn->query("SELECT event_date FROM event_reservations WHERE payment_status='Partially Paid'");
if ($get_all_reserved_dates->num_rows > 0) {
  while ($row = $get_all_reserved_dates->fetch_assoc()) {
    $reservedDates[] = $row['event_date'];
  }
} else {
  $reservedDates = [];
}

$datesJSON = json_encode($reservedDates);

$sql = "SELECT * FROM event_packages WHERE id = $packageid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $package = $result->fetch_assoc();
} else {
  header('Location: index.php');
  exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $package['package_name']; ?></title>
  <script src="../assets/fullcalendar/main.min.js"></script>
  <link rel="stylesheet" href="../assets/fullcalendar/main.min.css" />
  <link rel="stylesheet" href="../assets/fullcalendar/custom-calendar.css" />

  <?php
  include './reusables/asset_loader.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

</head>

<body>
  <style>
    .fc-daygrid-day.fc-day-reserved {
      background-color: red !important;
      color: white !important;
    }

    .hero-img {
      width: 100%;
      height: 600px;
      object-fit: cover;
    }

    .main-container {
      max-width: 800px;
    }

    @media (max-width: 700px) {
      .hero-img {
        height: 200px;
      }

      .main-container {
        max-width: 100%;
      }
    }
  </style>

  <div class="container-fluid p-0 mb-4">
    <?php
    include_once("reusables/headbar.php");
    ?>
    <div class="d-flex flex-column align-items-center justify-content-center">
      <div class="main-container d-flex flex-column">
        <img src="../<?php echo $package['thumbnail']; ?>" class="img img-fluid hero-img" />
        <div class="row p-4 p-lg-0">
          <div class="col-lg-5 col-12 d-flex flex-column gap-2 mt-lg-4 mt-2">
            <h4 class="fw-bold">PACKAGE INFORMATION</h4>
            <div class="row">
              <div class="col-4">
                <h6 class="fw-semibold">Name</h6>
              </div>
              <div class="col">
                <p><?php echo $package['package_name']; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <h6 class="fw-semibold">Max Pax</h6>
              </div>
              <div class="col">
                <p><?php echo $package['max_pax']; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <h6 class="fw-semibold">Package Price</h6>
              </div>
              <div class="col">
                <p>PHP <?php echo number_format($package['package_price'], 2); ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <h6 class="fw-semibold">Category</h6>
              </div>
              <div class="col">
                <p>Wedding</p>
              </div>
            </div>

            <h4 class="fw-bold mt-4">PACKAGE INCLUSIONS</h4>
            <ul>
              <?php
              $inclusions = explode(",", $package['inclusions']);
              foreach ($inclusions as $inclusion) {
                echo "<li>$inclusion</li>";
              }
              ?>
            </ul>
          </div>
          <div class="col-lg-7 col-12 d-flex flex-column mt-4">
            <div id="calendar"></div>
          </div>
        </div>

        <div class="d-flex flex-column gap-2 mt-4">
          <div class="d-flex flex-row align-items-center mt-4 mb-2">
            <h4 class="fw-bold">COMMENTS AND REVIEWS (3)</h4>
          </div>
          <div class="card">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 mt-2 text-muted">Review by: John Doe</h6>
              <div class="mb-2">
                <span class="badge">⭐⭐⭐⭐⭐</span>
              </div>
              <p class="card-text">
                "The event package exceeded our expectations! The venue was amazing, the staff was very professional,
                and everything was perfectly organized. Highly recommend!"
              </p>
              <p class="card-text"><small class="text-muted">Reviewed on: February 4, 2025</small></p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 mt-2 text-muted">Review by: Sarah Miller</h6>
              <div class="mb-2">
                <span class="badge text-dark">⭐⭐⭐⭐</span>
              </div>
              <p class="card-text">
                "The event was good, but there were a few hiccups during the setup. Overall, the staff did their best to
                ensure everything went smoothly. Would still recommend it for a great experience."
              </p>
              <p class="card-text"><small class="text-muted">Reviewed on: January 25, 2025</small></p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 mt-2 text-muted">Review by: Emily Smith</h6>
              <div class="mb-2">
                <span class="badge text-dark">⭐⭐⭐⭐⭐</span>
              </div>
              <p class="card-text">
                "Absolutely loved the event! Everything was well organized from start to finish. The food, the
                entertainment, and the ambiance were fantastic. Would book again for future events!"
              </p>
              <p class="card-text"><small class="text-muted">Reviewed on: February 2, 2025</small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="fw-bold">Reservation Form</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="reserveform">
          <div class="modal-body">
            <h6 class="fw-semibold mb-2">Event Date</h6>
            <input type="hidden" name="pid" value="<?php echo $packageid; ?>" />
            <input type="hidden" name="price" value="<?php echo $package['package_price']; ?>" />
            <input class="form-control mb-2" type="date" name="event_date" readonly />
            <h6 class="fw-semibold mb-2">Event Time</h6>
            <div class="input-group mb-2">
              <input class="form-control" type="time" name="start_time" required />
              <span class="input-group-text">to</span>
              <input class="form-control" type="time" name="end_time" required />
            </div>
            <h6 class="fw-semibold mb-2">Event Address</h6>
            <input class="form-control mb-2" type="text" name="event_address" required
              placeholder="Block 2, Lot 5, Amelia St, Bagumbayan, Bulacan" />
            <h6 class="fw-semibold mb-2">Client Contact Number</h6>
            <div class="input-group mb-2">
              <span class="input-group-text">+63</span>
              <input class="form-control" type="text" name="client_contact" required placeholder="9762210951" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Confirm Reservation</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  include_once("reusables/footbar.php");
  ?>

  <script>
    $(document).ready(function () {
      $("input[name='client_contact']").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length > 10) {
          this.value = this.value.substring(0, 10);
        }
      });
    });

    $(document).ready(function () {
      var reservedDates = <?php echo $datesJSON; ?>;
      var userFullname = <?= json_encode($_SESSION['userfullname'] ?? '') ?>;
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        validRange: {
          start: moment().format('YYYY-MM-DD')
        },
        events: reservedDates.map(function (date) {
          return {
            start: date,
            end: date,
            display: 'background',
            backgroundColor: "#b83939"
          };
        }),
        dateClick: function (info) {
          var clickedDate = new Date(info.dateStr);
          var today = new Date();
          var oneMonthAhead = new Date();
          oneMonthAhead.setDate(today.getDate() + 30); // minimum 30 days ahead

          // Reset time portion for comparison
          clickedDate.setHours(0, 0, 0, 0);
          oneMonthAhead.setHours(0, 0, 0, 0);

          if (clickedDate < oneMonthAhead) {
            Swal.fire({
              title: 'Select a Later Date',
              text: 'Please select a date at least 1 month ahead. We want to be perfectly prepared for your event.',
              icon: 'info',
              confirmButtonText: 'OK'
            });
            return;
          }

          var clickedDateStr = info.dateStr;

          if (!reservedDates.includes(clickedDateStr)) {
            if (userFullname && userFullname.trim() !== '') {
              $("input[name='event_date']").val(clickedDateStr);
              $('#eventModal').modal('toggle');
            } else {
              Swal.fire({
                title: 'Login Required',
                text: 'Please log in to book an event.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  document.querySelector('a.login-btn')?.click();
                }
              });
            }
          }
        }
      });

      calendar.render();
    });
  </script>
  <script>
    $("#reserveform").submit(function (e) {
      e.preventDefault();

      var formdata = new FormData(this);

      $.ajax({
        type: 'post',
        url: 'api/send-reservation.php',
        data: formdata,
        processData: false,
        contentType: false,
        success: response => {
          if (response === "ok") {
            Swal.fire({
              icon: 'success',
              title: 'Reservation Submitted',
              text: 'Your reservation has been submitted successfully!',
            }).then(() => {
              location.reload();
            });
          }
        }
      })
    })
  </script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION['userfullname']) || !isset($_SESSION['useremail']) || $_SESSION['usertype'] === 'admin') {
  header("Location: index.php");
  exit();
}

include_once("api/connection.php");

$userFullName = $_SESSION['userfullname'];

$sqlRequests = "SELECT * FROM event_reservations WHERE client_name = ?";
$stmtRequests = $conn->prepare($sqlRequests);
$stmtRequests->bind_param("s", $userFullName);
$stmtRequests->execute();
$resultRequests = $stmtRequests->get_result();

$sqlCustomPackages = "SELECT * FROM custom_packages_request WHERE client = ?";
$stmtCustomPackages = $conn->prepare($sqlCustomPackages);
$stmtCustomPackages->bind_param("s", $userFullName);
$stmtCustomPackages->execute();
$resultCustomPackages = $stmtCustomPackages->get_result();

$reservations = [];

if ($resultRequests->num_rows > 0) {
  while ($row = $resultRequests->fetch_assoc()) {
    $reservations[] = $row;
  }
}

if ($resultCustomPackages->num_rows > 0) {
  while ($row = $resultCustomPackages->fetch_assoc()) {
    $reservations[] = $row;
  }
}

foreach ($reservations as &$reservation) {
  if (isset($reservation['pid'])) {
    $sqlPackageName = "SELECT package_name FROM event_packages WHERE id = ?";
    $stmtPackageName = $conn->prepare($sqlPackageName);
    $stmtPackageName->bind_param("i", $reservation['pid']);
    $stmtPackageName->execute();
    $resultPackageName = $stmtPackageName->get_result();
    if ($resultPackageName->num_rows > 0) {
      $package = $resultPackageName->fetch_assoc();
      $reservation['package_name'] = $package['package_name'];
    } else {
      $reservation['package_name'] = 'Unknown Package';
    }
  } else {
    $reservation['package_name'] = 'Custom Package';
  }
}
unset($reservation);

$reqId = isset($_GET['req']) ? htmlspecialchars($_GET['req']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account</title>
  <?php
  include './reusables/asset_loader.php';
  ?>
</head>

<body class="d-flex flex-column min-vh-100">
  <div class="container-fluid p-0 m-0">
    <?php
    include_once("reusables/headbar.php");
    ?>
  </div>
  <div class="container mt-4 flex-grow-1">
    <h1 class="mb-4 mt-4">Welcome, <?php echo htmlspecialchars($userFullName); ?></h1>
    <h4 class="fw-semibold mb-2">Your Reservations</h4>
    <table class="table table-bordered mt-2">
      <thead>
        <tr>
          <th>Reservation ID</th>
          <th>Event Name</th>
          <th>Event Date</th>
          <th>Price</th>
          <th>Date Requested</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $reservation): ?>
          <tr>
            <td>
              <a href="#" class="open-modal" data-id="<?php echo htmlspecialchars($reservation['id']); ?>">
                <?php echo htmlspecialchars($reservation['id']); ?>
              </a>
            </td>
            <td><?php echo htmlspecialchars($reservation['package_name'] ?? 'Custom Package'); ?></td>
            <td><?php echo htmlspecialchars(date("F j, Y g:iA", strtotime($reservation['event_date']))); ?></td>
            <td><?php echo htmlspecialchars("PHP " . $reservation['price'] ?? 'PHP 0'); ?></td>
            <td><?php echo htmlspecialchars(date("F j, Y g:iA", strtotime($reservation['created_at']))); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reservationModalLabel">Reservation Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Reservation ID:</strong> <span id="reservationId"></span></p>
          <p><strong>Client Name:</strong> <span id="clientName"></span></p>
          <p><strong>Other Details:</strong> <span id="otherDetails"></span></p>
        </div>
      </div>
    </div>
  </div>
  <footer class="mt-auto">
    <?php
    include_once("reusables/footbar.php");
    ?>
  </footer>
  <script>
    function openReservationModal(reqId) {
      if (!reqId) return;
      $('#reservationModal').modal('show');

      $.ajax({
        url: "api/get_reservation_details.php",
        type: "GET",
        data: {
          req: reqId
        },
        success: function(response) {
          let data = JSON.parse(response);

          // Update modal content with reservation details
          $('#reservationId').text(data.id);
          $('#clientName').text(data.client_name);
          $('#otherDetails').text(data.other_details);
        },
        error: function() {
          $('#reservationId').text('Error loading details.');
        }
      });
    }

    $(document).ready(function() {
      let reqId = "<?php echo $reqId; ?>"; // Get the PHP variable

      if (reqId) {
        openReservationModal(reqId);
      }

      $('.open-modal').click(function(e) {
        e.preventDefault();
        let reservationId = $(this).data('id');
        history.pushState(null, '', `my-account.php?req=${reservationId}`);

        openReservationModal(reservationId);
      });

      $('#reservationModal').on('hide.bs.modal', function() {
        history.pushState(null, '', 'my-account.php');
      });
    });
  </script>
</body>

</html>
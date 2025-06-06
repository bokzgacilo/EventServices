<?php
session_start();

if (!isset($_SESSION['userfullname']) || !isset($_SESSION['useremail']) || $_SESSION['usertype'] === 'admin') {
  header("Location: index.php");
  exit();
}

if (!isset($_GET['rid']) || empty($_GET['rid'])) {
  header("Location: index.php");
  exit();
}

$reservation_id = $_GET['rid'];
$client_name = $_SESSION['userfullname'];

include_once("api/connection.php");

$sql = "SELECT * FROM event_reservations WHERE id = ? AND client_name = ? AND payment_status = 'Unpaid'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $reservation_id, $client_name);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
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
    <h1 class="mb-4">Payment</h1>
    <form id="paymentForm" enctype="multipart/form-data" class="row">
      <div class="col-4 d-flex flex-column">
        <img src="../images/gcash_qr.jpg" />
        <p>Scan the QR using GCash app.</p>
      </div>
      <div class="col-4 d-flex flex-column gap-4">
        <div class="form-group">
          <label class="form-label">Reference Number</label>
          <input type="text" placeholder="000021222A" name="reference_number" class="form-control" required />
        </div>
        <div class="form-group">
          <label class="form-label">Payment Date</label>
          <input type="date" name="payment_date" class="form-control" required />
        </div>
        <div class="form-group">
          <label class="form-label">Payment Receipt</label>
          <input type="file" name="payment_receipt" class="form-control" required />
          <p class="mt-2" style="font-size: 12px;">Please upload the receipt here.</p>
        </div>
      </div>
      <div class="col-4 d-flex flex-column">
        <h3>Order Detail</h3>
        <hr />
        <div class="mb-2 d-flex flex-row justify-content-between">
          <p>Event ID</p>
          <p><?php echo $reservation_id; ?></p>
        </div>
        <div class="mb-2 d-flex flex-row justify-content-between">
          <p>Total Amount Due <small class="text-muted">(after event)</small></p>
          <p><?php echo '₱' . number_format($row['price'], 2); ?></p>
        </div>
        <div class="mb-2 d-flex flex-row justify-content-between">
          <h5 class="fw-bold text-danger">Down Payment</h5>
          <h5 class="fw-bold text-danger">₱5,000.00</h5>
        </div>
        <hr />
        <h5>Terms and Conditions</h5>
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="noRefundCheckbox">
          <label class="form-check-label" for="noRefundCheckbox">
            I understand that the ₱5,000 down payment is <strong>non-refundable</strong>.
          </label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="rescheduleCheckbox">
          <label class="form-check-label" for="rescheduleCheckbox">
            I acknowledge that <strong>reschedule concerns</strong> must be coordinated with the admin.
          </label>
        </div>
        <button id="confirmBtn" type="submit" class="btn btn-success btn-lg mt-2" disabled>Pay Down Payment</button>
      </div>
    </form>
  </div>

  <footer class="mt-auto">
    <?php
    include_once("reusables/footbar.php");
    ?>
  </footer>
  <script>
    $(document).ready(function () {
      function toggleButton() {
        const bothChecked = $('#noRefundCheckbox').is(':checked') && $('#rescheduleCheckbox').is(':checked');
        $('#confirmBtn').prop('disabled', !bothChecked);
      }

      $('#noRefundCheckbox, #rescheduleCheckbox').on('change', toggleButton);
    });

    $("#paymentForm").on("submit", function (e) {
      e.preventDefault();
      var formData = new FormData(this);
      formData.append('reservation_id', '<?php echo $reservation_id; ?>'); // You can use a variable here

      $.ajax({
        url: 'api/make_payment.php',
        type: 'post',
        data: formData,
        contentType: false, // Required for FormData
        processData: false, // Required for FormData
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Payment recorded successfully',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'my-account.php';
            }
          });

        },
        error: function (jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error: ' + textStatus + ' - ' + errorThrown,
          });
        }
      });
    })
  </script>
</body>

</html>
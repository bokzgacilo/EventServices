<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Payment History</title>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Payment History</h2>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Event ID</th>
              <th>Client Name</th>
              <th>Reference Number</th>
              <th>Payment Date</th>
              <th>Date Created</th>
              <th>Receipt</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <script>
    $(document).ready(function () {
      $('#example').DataTable({
        "ajax": {
          "url": "api/get_transactions.php",
          "dataSrc": ""
        },
        columns: [{
          data: 'id'
        },
        {
          data: 'event_id'
        },
        {
          data: 'client_name'
        },
        {
          data: 'reference_number'
        },
        {
          data: 'payment_date',
          render: function (data) {
            if (!data) return '';
            const date = new Date(data);
            return date.toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            });
          }
        },
        {
          data: 'date_created',
          render: function (data) {
            if (!data) return '';
            const date = new Date(data);
            return date.toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            });
          }
        },
        {
          data: 'receipt_path',
          render: function (data, type, row) {
            if (data) {
              // Remove "../" or "../../" from path
              let cleanPath = data.replace(/^\.\.\//, '');

              // Only show "Confirm Payment" if status is not "Paid" or "Partially Paid"
              let confirmBtn = '';
              if (row.payment_status !== 'Paid' && row.payment_status !== 'Partially Paid') {
                confirmBtn = `<button class="btn btn-sm btn-success confirm-payment-btn" data-event-id="${row.event_id}">Confirm Payment</button>`;
              }

              return `
        ${confirmBtn}
        <a href="${cleanPath}" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>
      `;
            } else {
              return `<span class="text-muted">No Receipt</span>`;
            }
          }
        }
        ]
      });
    });

    $(document).on('click', '.confirm-payment-btn', function () {
      const eventId = $(this).data('event-id');

      Swal.fire({
        title: 'Are you sure?',
        text: "Confirm payment for this reservation?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'api/confirm_payment.php',
            method: 'POST',
            data: { event_id: eventId },
            success: function (response) {
              Swal.fire('Confirmed!', 'Payment has been marked as partially paid.', 'success');
              // Optionally reload the table
              $('#example').DataTable().ajax.reload();
            },
            error: function () {
              Swal.fire('Error!', 'Failed to confirm payment.', 'error');
            }
          });
        }
      });
    });

  </script>
</body>

</html>
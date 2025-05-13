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
          render: function (data) {
            if (data) {
              // Remove "../" or "../../" from path
              let cleanPath = data.replace(/^\.\.\//, '');
              return `<a href="${cleanPath}" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>`;

            } else {
              return `<span class="text-muted">No Receipt</span>`;
            }
          }
        }
        ]
      });
    });
  </script>
</body>

</html>
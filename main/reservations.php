<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Reservations</title>
</head>

<body class="d-flex flex-row">
  <div class="d-flex flex-column p-4 text-center">
    <?php
    include 'reusables/sidebar.php';
    ?>
  </div>
  <main>
    <h2 class="mb-4">Incoming Reservations</h2>
    <table id="example" class="table table-striped table-bordered" width="100%">
      <thead>
        <tr>
          <th>Package ID</th>
          <th>Price</th>
          <th>Client's Name</th>
          <th>Client's Contact</th>
          <th>Client's Email</th>
          <th>Event Address</th>
          <th>Event Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </main>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#example').DataTable({
        "ajax": {
          "url": "api/get_reservations.php", // Your API endpoint to fetch packages
          "dataSrc": "" // Assumes the data from the API is an array of objects
        },
        columns: [{
            data: 'pid'
          },
          {
            data: 'price'
          },
          {
            data: 'client_name'
          },
          {
            data: 'client_contact'
          },
          {
            data: 'client_email'
          },
          {
            data: 'venue'
          },
          {
            data: 'event_date'
          },
          {
            data: 'event_status'
          },
          {
            data: 'id',
            render: function(data, type, row) {
              return row.status == 0 ? `
                    <button class='btn btn-primary btn-sm'>Edit</button>
                    <button class='btn btn-success btn-sm'>Activate</button>
                  ` : `
                  <button class='btn btn-primary btn-sm'>Edit</button>
                  <button class='btn btn-danger btn-sm'>Deactivate</button>`;
            }
          },
        ]
      });
    });
  </script>
</body>

</html>
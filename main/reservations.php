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
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Incoming Reservations</h2>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>Package ID</th>
              <th>Price</th>
              <th>Client</th>
              <th>Event Address</th>
              <th>Event Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <script>
    // Function to handle status update via Axios
    function updateEventStatus(eventId, action) {
      let url = '/update-event-status'; // Replace with your actual API endpoint
      let data = {
        id: eventId,
        status: action
      };

      console.log(data)
    }

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
            data: 'venue'
          },
          {
            data: 'event_date',
            render: function(data, type, row) {
              if (!data) return ''; // Handle empty or null values

              const date = new Date(data);
              return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              });
            }
          },
          {
            data: 'event_status',
            render: function(data, type, row) {
              switch (data) {
                case 'Confirmed':
                  return 'Waiting event to process';
                case 'Pending':
                  return 'Waiting event to be completed';
                case 'Completed':
                  return 'Event Completed';
                case 'Cancelled':
                  return 'Event Cancelled';
                default:
                  return '';
              }
            }
          },
          {
            data: 'id',
            render: function(data, type, row) {
              let buttons = '';

              if (row.event_status === 'Confirmed') {
                buttons += `<button class='btn btn-primary btn-sm' onclick="updateEventStatus(${data}, 'confirm')">Process Event</button>`;
              }
              if (row.event_status === 'Pending') {
                buttons += `<button class='btn btn-success btn-sm' onclick="updateEventStatus(${data}, 'pending')">Mark as Done</button>`;
              }

              // Add Cancel button for events that are not already Cancelled or Completed
              if (row.event_status !== 'Cancelled' && row.event_status !== 'Completed') {
                buttons += `<button class='ms-2 btn btn-danger btn-sm' onclick="updateEventStatus(${data}, 'cancelled')">Cancel</button>`;
              }

              return buttons;
            }
          }
        ]
      });
    });
  </script>
</body>

</html>
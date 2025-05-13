<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Export Data</title>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Export Data</h2>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">Select a Plan:</label>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="timerange" id="weekly" value="weekly" checked>
              <label class="form-check-label" for="weekly">
                Weekly
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="timerange" id="monthly" value="monthly">
              <label class="form-check-label" for="monthly">
                Monthly
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="timerange" id="yearly" value="yearly">
              <label class="form-check-label" for="yearly">
                Yearly
              </label>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-2">
            <p>Select data to export:</p>

          </div>
          <div class="col-4">
            <select id="what_to_export" class="col-4 form-control">
              <option value="packages">All Packages</option>
              <option value="reservations">All Reservations</option>
              <option value="users">All User Accounts</option>
            </select>
          </div>
          <div class="col-2">
            <button id="export_btn" class="btn btn-success">Export</button>
            <a id="download_link">Download</a>
          </div>

        </div>
        <table id="example" class="table table-striped table-bordered" width="100%">

        </table>
      </div>
    </div>

  </main>
  <script>
    $("#export_btn").on("click", function () {
      var what_to_export = $("#what_to_export").val();
      var time_range = $('input[name="timerange"]:checked').val();
      $('#example').DataTable().clear().destroy();
      $('#example').empty();

      $.ajax({
        type: 'POST',
        url: 'api/generate_reports/generate.php',
        data: {
          target: what_to_export, // 'users' or 'packages'
          range: time_range
        },
        success: function (response) {
          console.log(response)
          // $("#download_link").attr("href", "http://localhost/eventservices/main/api/generate_reports/" + response.url);
          $("#download_link").attr("href", "https://queenandknighteventservices.site/main/api/generate_reports/" + response.url);

          // Clear any existing table data
          // Check if the response is valid
          if (response.status === 'success') {
            let tableData = response.tableData;

            // Define columns based on target
            if (what_to_export === 'users') {
              // Users table columns
              $('#example').DataTable({
                data: tableData,
                destroy: true, // Allows reinitializing the table
                columns: [
                  { data: 'name' },
                  { data: 'email' },
                  { data: 'type' },
                  {
                    data: 'created_at',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { year: 'numeric', month: 'long', day: 'numeric' };
                      return date.toLocaleDateString('en-US', options); // Format as March 25, 2025
                    }
                  }
                ]
              });
            } else if (what_to_export === 'reservations') {
              // Reservations table columns
              $('#example').DataTable({
                data: tableData,
                destroy: true, // Allows reinitializing the table
                columns: [
                  { data: 'id' },
                  { data: 'pid' }, // Reservation package ID
                  {
                    data: 'price',
                    render: function (data) {
                      return '₱' + parseFloat(data).toLocaleString(); // Format price with ₱ symbol
                    }
                  },
                  {
                    data: 'event_date',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { year: 'numeric', month: 'long', day: 'numeric' };
                      return date.toLocaleDateString('en-US', options); // Format event date as March 25, 2025
                    }
                  },
                  {
                    data: 'event_start',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { hour: '2-digit', minute: '2-digit', hour12: true };
                      return date.toLocaleTimeString('en-US', options); // Format event start time as 11:00 AM
                    }
                  },
                  {
                    data: 'event_end',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { hour: '2-digit', minute: '2-digit', hour12: true };
                      return date.toLocaleTimeString('en-US', options); // Format event end time as 12:00 PM
                    }
                  },
                  { data: 'client_name' },
                  { data: 'client_contact' },
                  { data: 'client_email' },
                  { data: 'venue' },
                  {
                    data: 'event_status',
                    render: function (data) {
                      return data === "1" ? 'Confirmed' : 'Pending'; // Format event status
                    }
                  },
                  {
                    data: 'payment_status',
                    render: function (data) {
                      return data === "1" ? 'Paid' : 'Unpaid'; // Format payment status
                    }
                  },
                  {
                    data: 'created_at',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { year: 'numeric', month: 'long', day: 'numeric' };
                      return date.toLocaleDateString('en-US', options); // Format creation date as March 25, 2025
                    }
                  }
                ]
              });
            }
            else if (what_to_export === 'packages') {
              // Packages table columns
              $('#example').DataTable({
                data: tableData,
                destroy: true, // Allows reinitializing the table
                columns: [
                  { data: 'id' },
                  { data: 'package_name' },
                  { data: 'max_pax' },
                  {
                    data: 'package_price',
                    render: function (data) {
                      return '₱' + parseFloat(data).toLocaleString(); // Format price with ₱ symbol
                    }
                  },
                  { data: 'type' },
                  { data: 'inclusions' },
                  {
                    data: 'status',
                    render: function (data) {
                      return data === "1" ? 'Active' : 'Inactive'; // Format status
                    }
                  },
                  {
                    data: 'created_at',
                    render: function (data) {
                      const date = new Date(data);
                      const options = { year: 'numeric', month: 'long', day: 'numeric' };
                      return date.toLocaleDateString('en-US', options); // Format as March 25, 2025
                    }
                  }
                ]
              });
            }
          } else {
            alert('No data found or error in fetching data.');
          }
        }
      });

    })
  </script>
</body>

</html>
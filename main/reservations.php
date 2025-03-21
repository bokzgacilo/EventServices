<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Reservations</title>
  <style>
    .images-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }

    .images-container img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      margin: 5px;
      border-radius: 5px;
    }
  </style>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="modal fade" id="ImportEventPicturesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Mark as Done</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="importPictures" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="eventid" value="" />
              <p class="fw-semibold">Import Event Pictures</p>
              <input type="file" name="images[]" id="imagesInput" class="form-control" accept="image/*" multiple>
              <p class="fw-semibold mt-4">Preview</p>
              <div id="preview" class="images-container"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Mark as Done</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Incoming Reservations</h2>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>Price</th>
              <th>Client</th>
              <th>Address</th>
              <th>Date</th>
              <th>Start</th>
              <th>End</th>
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
    function OpenImportPicture(eventId) {
      $("input[name='eventid']").val(eventId)
      $("#ImportEventPicturesModal").modal("toggle")
    }

    // Function to handle status update via Axios
    function updateEventStatus(eventId, action) {
      let data = {
        rid: eventId,
        action: action
      };

      $.ajax({
        type: 'post',
        url: "api/reservations/process_event.php",
        data: data,
        success: response => {
          if (response === "1") {
            alert("Reservation updated");
            location.reload();
          }
        }
      })
    }

    $("#importPictures").on("submit", function(e) {
      e.preventDefault();

      let formData = new FormData(this)

      $.ajax({
        url: "api/reservations/mark_as_done.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          let jsonResponse = JSON.parse(response); // Parse JSON response
          console.log(jsonResponse); // Log the full response

          if (jsonResponse.status === "success") {
            alert(jsonResponse.message);
            location.reload();
          } else {
            alert("Error: " + jsonResponse.message);
          }
        }
      });
    })
    $("#imagesInput").on("change", function() {
      let preview = $("#preview");
      preview.empty(); // Clear previous previews

      let files = this.files;
      if (files.length < 3 || files.length > 5) {
        alert("Please select between 3 to 5 images.");
        this.value = ""; // Reset file input
        return;
      }

      $.each(files, function(index, file) {
        let reader = new FileReader();
        reader.onload = function(e) {
          $("<img>", {
            src: e.target.result,
            class: "img-thumbnail",
          }).appendTo(preview);
        };
        reader.readAsDataURL(file);
      });
    });

    $(document).ready(function() {
      // Initialize DataTable
      $('#example').DataTable({
        "ajax": {
          "url": "api/get_reservations.php", // Your API endpoint to fetch packages
          "dataSrc": "" // Assumes the data from the API is an array of objects
        },
        columns: [
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
            data: 'event_start',
            render: function(data, type, row) {
              if (!data) return ''; // Handle empty or null values

              // Ensure `data` is a valid time string
              const [hours, minutes] = data.split(':'); // Extract hours & minutes
              const date = new Date();
              date.setHours(hours, minutes, 0); // Set time while keeping today's date

              return date.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
              });
            }
          },
          {
            data: 'event_end',
            render: function(data, type, row) {
              if (!data) return ''; // Handle empty or null values

              // Ensure `data` is a valid time string
              const [hours, minutes] = data.split(':'); // Extract hours & minutes
              const date = new Date();
              date.setHours(hours, minutes, 0); // Set time while keeping today's date

              return date.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
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
                buttons += `<button class='btn btn-success btn-sm' onclick="OpenImportPicture(${data})">Mark as Done</button>`;
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
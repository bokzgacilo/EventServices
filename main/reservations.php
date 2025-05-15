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
    <div class="modal fade" id="ImportEventPicturesModal" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
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

    <div class="modal fade" id="offerPriceModal" tabindex="-1" aria-labelledby="offerPriceModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Set Price</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="setPriceForm">

            <div class="modal-body">
              <input type="hidden" name="client">
              <input type="hidden" name="client_email">
              <input type="hidden" name="custom_request_id">
              <input type="number" class="form-control" name="price" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Set</button>
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
              <th>Payment Status</th>
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

    function updateEventStatus(eventId, action) {
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to proceed with this request?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading modal
          Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();

              // Send AJAX after loading starts
              let data = {
                rid: eventId,
                action: action
              };

              $.ajax({
                type: 'post',
                url: "api/reservations/process_event.php",
                data: data,
                success: response => {
                  Swal.fire(
                    response.title || 'Success!',
                    response.description || 'The request has been processed.',
                    'success'
                  );

                  $('#example').DataTable().ajax.reload();
                },
                error: () => {
                  Swal.fire(
                    'Error!',
                    'Something went wrong while processing the request.',
                    'error'
                  );
                }
              });
            }
          });
        }
      });
    }


    $("#importPictures").on("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this)

      $.ajax({
        url: "api/reservations/mark_as_done.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          let jsonResponse = JSON.parse(response); // Parse JSON response
          console.log(jsonResponse); // Log the full response

          if (jsonResponse.status === "success") {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: jsonResponse.message,
            }).then(() => {
              location.reload();
            });

          } else {
            alert("Error: " + jsonResponse.message);
          }
        }
      });
    })
    $("#imagesInput").on("change", function () {
      let preview = $("#preview");
      preview.empty(); // Clear previous previews

      let files = this.files;
      if (files.length < 3 || files.length > 5) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Selection',
          text: 'Please select between 3 to 5 images.',
        });
        this.value = ""; // Reset file input
        return;
      }


      $.each(files, function (index, file) {
        let reader = new FileReader();
        reader.onload = function (e) {
          $("<img>", {
            src: e.target.result,
            class: "img-thumbnail",
          }).appendTo(preview);
        };
        reader.readAsDataURL(file);
      });
    });

    $(document).ready(function () {
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
            render: function (data, type, row) {
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
            render: function (data, type, row) {
              if (!data) return ''; // Handle empty or null values

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
            render: function (data, type, row) {
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
            render: function (data, type, row) {
              switch (data) {
                case 'Confirmed':
                  return row.payment_status === 'Unpaid'
                    ? 'Waiting for payment'
                    : 'Waiting event to process';
                case 'Pending':
                  return row.price == 0 || row.price === '0.00' ? 'No Price' : 'Waiting for confirmation';

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
            data: 'payment_status'
          },
          {
            data: 'id',
            render: function (data, type, row) {
              let buttons = '';

              if (row.event_status === 'Confirmed') {
                if (row.payment_status === 'Partially Paid') {
                  buttons += `<button class='btn btn-success btn-sm me-2' onclick="OpenImportPicture(${data})">Mark As Done</button>`;
                }
              }


              if (row.event_status === 'Pending') {
                if (!row.price || row.price == 0) {
                  buttons += `<button class="btn btn-primary btn-sm offer-price-btn me-2" data-id="${row.id}" data-client="${row.client_name}" data-email="${row.client_email}">Set Price</button>`;
                } else {
                  buttons += `<button class='btn btn-primary btn-sm me-2' onclick="updateEventStatus(${data}, 'confirmed')">Confirm</button>`;
                }
              }

              // Add Cancel button for events that are not already Cancelled or Completed
              if (row.event_status !== 'Cancelled' && row.event_status !== 'Completed') {
                buttons += `<button class='btn btn-danger btn-sm' onclick="updateEventStatus(${data}, 'cancelled')">Cancel</button>`;
              }

              return buttons;
            }
          }
        ]
      });
    });

    $('#example').on('click', '.offer-price-btn', function () {
      $("input[name='custom_request_id']").val($(this).data('id'));
      $("input[name='client']").val($(this).data('client'));
      $("input[name='client_email']").val($(this).data('email'));

      $('#offerPriceModal').modal('show');
    });

    $("#setPriceForm").on("submit", function (e) {
      e.preventDefault();
      $('#loadingOverlay').css("display", "flex");
      $.ajax({
        url: "api/set_custom_price.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (data) {
          console.log(data)

          if (data == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Price set successfully!',
            });
            $('#offerPriceModal').modal('hide');
            $('#example').DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error setting price: ' + data,
            });
          }
        },
        complete: function () {
          $('#loadingOverlay').css("display", "none");
        }
      });
    });
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Packages</title>
  
  <style>
    #loadingOverlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      /* Transparent Gray */
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1056;
      /* display: none; */
      /* Initially Hidden */
    }
  </style>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <div id="loadingOverlay">
    <div class="spinner-border text-light" role="status"></div>
  </div>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Custom Package Request</h2>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Pax</th>
              <th>Inclusions</th>
              <th>Price</th>
              <th>Venue</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clientModalLabel">Client Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="client-detail-body" class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="offerPriceModal" tabindex="-1" aria-labelledby="offerPriceModalLabel" aria-hidden="true">
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

  <script>
    $("#setPriceForm").on("submit", function(e) {
      e.preventDefault();
      $('#loadingOverlay').css("display", "flex");
      $.ajax({
        url: "api/set_custom_price.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(data) {
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
        complete: function() {
          $('#loadingOverlay').css("display", "none");
        }
      });
    });

    function openClientModal(client) {
      $("#clientModal").modal("toggle")
      $.ajax({
        url: "api/get_client_details.php",
        type: "POST",
        data: {
          client: client
        },
        success: function(data) {
          $("#client-detail-body").html(data);
        }
      });
    }

    $('#example').on('click', '.offer-price-btn', function() {
      $("input[name='custom_request_id']").val($(this).data('id'));
      $("input[name='client']").val($(this).data('client'));
      $("input[name='client_email']").val($(this).data('email'));

      $('#offerPriceModal').modal('show');
    });

    $(document).ready(function() {


      $('#example').DataTable({
        "ajax": {
          "url": "api/get_custom_request.php",
          "dataSrc": ""
        },
        columns: [{
            data: 'id'
          },
          {
            data: 'client',
            render: function(data, type, row) {
              return `<button onclick="openClientModal('${row.client}')" class="btn btn-link btn-sm">${data}</button>`;
            }
          },
          {
            data: 'pax'
          },
          {
            data: 'inclusions'
          },
          {
            data: 'price'
          },
          {
            data: 'venue'
          },
          {
            data: 'id',
            render: function(data, type, row) {
              return `<button class="btn btn-primary btn-sm offer-price-btn" data-id="${row.id}" data-client="${row.client}" data-email="${row.client_email}">Set Price</button>`;
            }
          },
        ]
      });
    });
  </script>
</body>

</html>
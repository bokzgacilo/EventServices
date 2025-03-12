<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Chats</title>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Packages</h2>
      </div>
      <div class="card-body">
        <button class="btn btn-primary btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addPackageModal">Create New Package</button>
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Pax</th>
              <th>Price</th>
              <th>Thumbnail</th>
              <th>Inclusions</th>
              <th>Is Active?</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Package</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createpackage_form" enctype="multipart/form-data">
          <div class="modal-body">
            <label for="name" class="fw-semibold">Package Name</label>
            <input class="form-control mb-4" type="text" name="name" required>

            <label for="pax" class="fw-semibold">Max Pax</label>
            <input class="form-control mb-4" type="number" name="pax" required>

            <label for="price" class="fw-semibold">Package Price</label>
            <input class="form-control mb-4" type="number" step="0.01" name="price" required>

            <label for="thumbnail" class="fw-semibold">Thumbnail Image</label>
            <input class="form-control mb-4" type="file" name="thumbnail" accept="image/*" required>

            <label for="inclusions" class="fw-semibold">Inclusions</label>
            <textarea class="form-control mb-2" name="inclusions" rows="4" cols="50" required></textarea>
            <button type="submit" class="mt-4 btn btn-success">Create Package</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $("#createpackage_form").on('submit', function(e) {
        e.preventDefault();

        var formdata = new FormData(this)

        $.ajax({
          url: 'api/create_new_package.php',
          type: 'POST',
          data: formdata,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response)
          }
        });

      })

      $('#example').DataTable({
        "ajax": {
          "url": "api/get_packages.php",
          "dataSrc": ""
        },
        columns: [{
            data: 'id'
          },
          {
            data: 'package_name'
          },
          {
            data: 'max_pax'
          },
          {
            data: 'package_price'
          },
          {
            data: 'thumbnail',
            render: function(data) {
              return `<img src="../${data}" alt="Thumbnail" style="width: 100px; height: auto;">`;
            }
          },
          {
            data: 'inclusions'
          },
          {
            data: 'status',
            render: function(data) {
              return data == 1 ? `<span class='badge text-bg-success'>Active</span>` : `<span class='badge text-bg-danger'>Inactive</span>`;
            }
          },
          {
            data: 'id',
            render: function(data, type, row) {
              return `<button class='btn btn-primary btn-sm'>Edit</button>`
            }
          },
        ]
      });
    });
  </script>
</body>
</html>
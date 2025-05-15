<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>Packages</title>
</head>

<body class="d-flex flex-row">
  <style>
    .img-preview {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    .img-table {
      width: 100%;
      height: 100px;
      object-fit: cover;
    }
  </style>
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">Packages</h2>
      </div>
      <div class="card-body">
        <button class="btn btn-primary btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addPackageModal">Create
          New Package</button>
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

  <div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Package</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="EditPackageForm" enctype="multipart/form-data">
          <input type="hidden" name="edit_id" />
          <div class="modal-body d-flex flex-column gap-2">
            <div class="form-group">
              <label>Status</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="edit_status" value="1">
                <label class="form-check-label" for="enable">Enable</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="edit_status" value="0">
                <label class="form-check-label" for="disable">Disable</label>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Package Name</label>
              <input class="form-control form-control-sm" type="text" name="edit_name"
                placeholder="Anime Theme Birthday Party" required>
            </div>
            <div class="form-group">
              <label class="form-label">Category</label>
              <select class="form-control form-control-sm" name="edit_category" required>
                <option value="Birthday">Birthday</option>
                <option value="Wedding">Wedding</option>
                <option value="Party">Party</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Max Pax</label>
              <input class="form-control form-control-sm" type="number" name="edit_pax" min="10" required>
            </div>
            <div class="form-group">
              <label class="form-label">Price</label>
              <input class="form-control form-control-sm" type="number" step="0.01" name="edit_price" min="1000"
                required>
            </div>
            <div class="form-group">
              <label class="form-label">Thumbnail Image</label>
              <input class="form-control form-control-sm" type="file" name="edit_thumbnail">
            </div>
            <img src="" id="edit_image_preview" class="img-preview img-fluid" />
            <div class="form-group">
              <label class="form-label">Inclusion/Description</label>
              <textarea class="form-control mb-2" name="edit_inclusions" rows="4" cols="50" required></textarea>
            </div>

            <button type="submit" class="btn btn-lg btn-success">Update Package</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Package</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createpackage_form" enctype="multipart/form-data">
          <div class="modal-body d-flex flex-column gap-2">
            <div class="form-group">
              <label class="form-label">Package Name</label>
              <input class="form-control form-control-sm" type="text" name="name"
                placeholder="Anime Theme Birthday Party" required>
            </div>
            <div class="form-group">
              <label class="form-label">Category</label>
              <select class="form-control form-control-sm" name="category" required>
                <option value="Birthday">Birthday</option>
                <option value="Wedding">Wedding</option>
                <option value="Party">Party</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Max Pax</label>
              <input class="form-control form-control-sm" type="number" name="pax" min="10" required>
            </div>
            <div class="form-group">
              <label class="form-label">Price</label>
              <input class="form-control form-control-sm" type="number" step="0.01" name="price" min="1000" required>
            </div>
            <div class="form-group">
              <label class="form-label">Thumbnail Image</label>
              <input class="form-control form-control-sm" type="file" name="thumbnail" required>
            </div>
            <img src="../images/no-image.webp" id="image_preview" class="img-preview img-fluid" />
            <div class="form-group">
              <label class="form-label">Inclusion/Description</label>
              <textarea class="form-control mb-2" name="inclusions" rows="4" cols="50" required></textarea>
            </div>

            <button type="submit" class="btn btn-lg btn-success">Create Package</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $("input[name='thumbnail']").on("change", function (e) {
        var file = e.target.files[0]; // Get the selected file
        if (file) {
          var reader = new FileReader(); // Create a new FileReader
          reader.onload = function (event) {
            $("#image_preview").attr("src", event.target.result);
          };
          reader.readAsDataURL(file);
        }
      });

      $("input[name='edit_thumbnail']").on("change", function (e) {
        var file = e.target.files[0]; // Get the selected file
        if (file) {
          var reader = new FileReader(); // Create a new FileReader
          reader.onload = function (event) {
            $("#edit_image_preview").attr("src", event.target.result);
          };
          reader.readAsDataURL(file);
        }
      });

      $("#createpackage_form").on('submit', function (e) {
        e.preventDefault();

        var formdata = new FormData(this)

       $.ajax({
        url: 'api/create_new_package.php',
        type: 'POST',
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Package Created',
            text: response,
          }).then(() => {
            location.reload();
          });
        }
      });
      })

      $("#EditPackageForm").on('submit', function (e) {
        e.preventDefault();

        var formdata = new FormData(this)

        $.ajax({
          url: 'api/edit_package.php',
          type: 'POST',
          data: formdata,
          contentType: false,
          processData: false,
          success: function (response) {
            Swal.fire({
              icon: response.status === 'success' ? 'success' : 'error',
              title: response.title,
              text: response.description,
            }).then(() => {
              if (response.status === 'success') {
                $('#example').DataTable().ajax.reload();
                $('#editPackageModal').modal('hide');
              }
            });
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
          render: function (data) {
            return `<img src="../${data}" class="img-table img-fluid" />`;
          }
        },
        {
          data: 'inclusions'
        },
        {
          data: 'status',
          render: function (data) {
            return data == 1 ? `<span class='badge text-bg-success'>Active</span>` : `<span class='badge text-bg-danger'>Inactive</span>`;
          }
        },
        {
          data: 'id',
          render: function (data, type, row) {
            return `
      <button class='btn btn-primary btn-sm' onclick="openEditModal(${data})">Edit</button>
      <button class='btn btn-danger btn-sm' onclick="confirmDelete(${data})">Delete</button>
    `;
          }
        },
        ]
      });
    });

    function confirmDelete(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This will delete the package permanently.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'api/delete_package.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
          Swal.fire('Deleted!', response, 'success');
          $('#example').DataTable().ajax.reload();
        },
        error: function(xhr, status, error) {
          Swal.fire('Error!', 'Failed to delete the package.', 'error');
        }
      });
    }
  });
}

    function openEditModal(packageId) {
      $.ajax({
        url: 'api/get_package.php',
        method: 'POST',
        data: { id: packageId },
        success: function (response) {
          $("input[name='edit_id']").val(response.id)
          $("input[name='edit_name']").val(response.package_name)
          var categoryValue = response.type;
          if ($("select[name='edit_category'] option[value='" + categoryValue + "']").length > 0) {
            $("select[name='edit_category']").val(categoryValue);
          } else {
            console.log("Value not found in select options");
          }
          $("input[name='edit_pax']").val(response.max_pax)
          $("input[name='edit_price']").val(response.package_price)
          $("textarea[name='edit_inclusions']").val(response.inclusions)
          $("#edit_image_preview").attr("src", "../" + response.thumbnail)
          if (response.status === 1) {
            $("input[name='edit_status'][value='1']").prop('checked', true);
          } else {
            $("input[name='edit_status'][value='0']").prop('checked', true);
          }
          $('#editPackageModal').modal('show');
        }
      });
    }

  </script>
</body>

</html>
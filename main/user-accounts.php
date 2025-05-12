<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  include 'reusables/asset_loader.php';
  ?>
  <title>User Accounts</title>
</head>

<body class="d-flex flex-row">
  <?php
  include 'reusables/sidebar.php';
  ?>
  <main>
    <div class="card">
      <div class="card-header">
        <h2 class="panel-title">User Accounts</h2>
      </div>
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>

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
    $(document).ready(function () {

      $('#example').DataTable({
        "ajax": {
          "url": "api/get_all_users.php",
          "dataSrc": ""
        },
        columns: [{
          data: 'id'
        },
        {
          data: 'name'
        },
        {
          data: 'email'
        },
        {
          data: 'password',
          render: function (data, type, row) {
            return '*'.repeat(data.length);
          }
        },
        {
          data: 'id',
          render: function (data, type, row) {
            return `
    <button class='btn btn-danger btn-sm delete-btn' data-id="${row.id}">Delete</button>
  `;
          }

        },
        ]
      });
    });

    $(document).on('click', '.delete-btn', function () {
      const userId = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'api/delete_user.php',
            method: 'POST',
            data: { id: userId },
            success: function (response) {
              Swal.fire('Deleted!', 'User has been deleted.', 'success');
              // Reload table if you're using DataTables:
              $('#example').DataTable().ajax.reload();
            },
            error: function () {
              Swal.fire('Error', 'Failed to delete user.', 'error');
            }
          });
        }
      });
    });
  </script>
</body>

</html>
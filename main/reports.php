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
              <div class="row align-items-center">
                <div class="col-2">
                <p >Select data to export:</p>

                </div>
                <div class="col-4">
                <select id="what_to_export" class="col-4 form-control">
                  <option value="packages">All Packages</option>
                  <option value="reservations">All Reservations</option>
                  <option value="user_accounts">All User Accounts</option>
                </select>
                </div>
                <div class="col-2">
                <button id="export_btn" class="btn btn-success">Export</button>

                </div>
               
              </div>
            </div>
        </div>

    </main>
    <script>
      $("#export_btn").on("click", function(){
        var what_to_export = $("#what_to_export").val();

        $.ajax({
          type: 'post',
          url: 'api/generate_reports/generate.php',
          data: {
            target: what_to_export
          },
          success: response => {
            console.log(response)
          }
        })
      })
    </script>
</body>

</html>
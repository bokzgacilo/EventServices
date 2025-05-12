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
              <option value="custom_packages">All Custom Packages</option>
              <option value="users">All User Accounts</option>
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
    $("#export_btn").on("click", function () {
      var what_to_export = $("#what_to_export").val();
      var time_range = $('input[name="timerange"]:checked').val();

      $.ajax({
        type: 'post',
        url: 'api/generate_reports/generate.php',
        data: {
          target: what_to_export,
          range: time_range
        },
        success: response => {
          var json = JSON.parse(response)
          location.href = "../main/api/generate_reports" + json.url;
        }
      })
    })
  </script>
</body>

</html>
<?php
  include("api/connection.php");
  $reservedDates = [];
  $events = [];

  $get_all_reserved_dates = $conn->query("SELECT event_date, venue, client_name FROM event_reservations");
  if ($get_all_reserved_dates->num_rows > 0) {
    while ($row = $get_all_reserved_dates->fetch_assoc()) {
      $reservedDates[] = $row['event_date'];
      $events[] = [
        "venue" => $row['venue'],
        "client_name" => $row['client_name'],
        "event_date" => $row['event_date'],
      ];
    }
  } else {
    $reservedDates = [];
  }
  $datesJSON = json_encode($reservedDates);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/fullcalendar/main.min.css" />
  <link rel="stylesheet" href="../assets/fullcalendar/custom-calendar.css" />
  <script src="../assets/fullcalendar/main.min.js"></script>
  <?php
    include 'reusables/asset_loader.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
  <title>Calendar</title>
</head>

<body class="d-flex flex-row">
<style>
    .fc-daygrid-day.fc-day-reserved {
      background-color: red !important;
      color: white !important;
    }
  </style>
  <?php
    include 'reusables/sidebar.php';
  ?>
  <main class="d-flex flex-row gap-2">
    <div class="col-4 card d-flex flex-column">
      <div class="card-header">
        <h2 class="panel-title">Upcoming Events</h2>
      </div>
      <div class="card-body">
      <?php
        foreach ($events as $key => $event) {
            echo "
              <div class='card mb-2'>
                <div class='card-body'>
                  <h5 class='fw-bold'>".$event['client_name']."</h5>
                  <div class='d-flex flex-row align-items-center justify-content-between'>
                    <p class='fw-semibold'>".$event['venue']."</p>                  
                    <p class='fw-semibold'>".$event['event_date']."</p>                  
                  </div>
                </div>
              </div>
            ";
        }
      ?>
      </div>
      
    </div>
    <div class="card col-8">
      <div class="card-header">
        <h2 class="panel-title">Calendar</h2>
      </div>
      <div class="card-body">
        <div id="calendar"></div>
      </div>
    </div>  
  </main>

  
  <script>
   $(document).ready(function() {
      var reservedDates = <?php echo $datesJSON; ?>;
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        validRange: {
          start: moment().format('YYYY-MM-DD')
        },
        events: reservedDates.map(function(date) {
          return {
            start: date,
            end: date,
            display: 'background',
            backgroundColor: "#b83939"
          };
        }),
        dateClick: function(info) {
          var clickedDate = info.dateStr;

          if (!reservedDates.includes(clickedDate)) {

          }
        }
      });

      calendar.render();
    });
  </script>
</body>

</html>
<?php
include("api/connection.php");
$reservedDates = [];
$events = [];

$get_all_reserved_dates = $conn->query("
  SELECT event_date, event_start, event_end, venue, client_name 
  FROM event_reservations 
  WHERE (payment_status = 'Paid' OR payment_status = 'Partially Paid') 
    AND (event_status = 'Confirmed' OR event_status = 'Completed')
");

if ($get_all_reserved_dates->num_rows > 0) {
  while ($row = $get_all_reserved_dates->fetch_assoc()) {
    $reservedDates[] = $row['event_date'];
    $events[] = [
      "venue" => $row['venue'],
      "client_name" => $row['client_name'],
      "event_date" => $row['event_date'],
      "event_start" => $row['event_start'],
      "event_end" => $row['event_end'],
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

    .fc .fc-bg-event {
      opacity: 1 !important;
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
          $eventDate = date('F j, Y', strtotime($event['event_date']));
          $startTime = date('g:iA', strtotime($event['event_start']));
          $endTime = date('g:iA', strtotime($event['event_end']));
          $formattedDateTime = "$eventDate $startTime - $endTime";

          echo "
              <div class='card mb-2'>
                <div class='card-body'>
                  <p class='fw-bold'>" . $event['client_name'] . "</p]>
                  <div class='d-flex flex-column'>
                    <p class='fw-semibold'>" . $event['venue'] . "</p>                  
                    <p class='fw-semibold'>" . $formattedDateTime . "</p>                 
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
        <div class="d-flex flex-row gap-3 flex-wrap">
          <div class="d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: green;" class="me-2 border rounded"></div>
            <span>Ongoing Event</span>
          </div>
          <div class="d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: red;" class="me-2 border rounded"></div>
            <span>Reserved Event</span>
          </div>
          <div class="d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: gray;" class="me-2 border rounded"></div>
            <span>Past Reserved</span>
          </div>
          <div class="d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: yellow;" class="me-2 border rounded"></div>
            <span>Current Date</span>
          </div>
        </div>
        <div id="calendar"></div>
      </div>
    </div>
  </main>


  <script>
    $(document).ready(function () {
      const reservedDates = <?php echo $datesJSON; ?>; // must be array of 'YYYY-MM-DD'
      const calendarEl = document.getElementById('calendar');
      const today = new Date();
      const todayStr = today.toLocaleDateString('en-CA'); 
      const dateColors = {}; // Store one background color per date

      reservedDates.forEach(function (dateStr) {
        // Normalize date comparison
        if (dateStr === todayStr) {
          dateColors[dateStr] = 'green'; // Ongoing
        } else if (dateStr < todayStr) {
          dateColors[dateStr] = 'gray'; // Past
        } else {
          dateColors[dateStr] = 'red'; // Future
        }
      });

      // If today is not in reservedDates, mark it yellow
      if (!dateColors[todayStr]) {
        dateColors[todayStr] = 'yellow';
      }

      // Convert dateColors into background events
      const events = Object.entries(dateColors).map(([dateStr, color]) => ({
        start: dateStr,
        end: dateStr,
        display: 'background',
        backgroundColor: color
      }));

      // Init FullCalendar
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        dateClick: function (info) {
          const clickedDate = info.dateStr;

          if (!reservedDates.includes(clickedDate)) {
            // Available date clicked, do something here
          }
        }
      });

      calendar.render();
    });

  </script>
</body>

</html>
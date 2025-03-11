<?php
  session_start();
  include_once("api/connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Gallery</title>
  <script src="../assets/fullcalendar/main.min.js"></script>
  <link rel="stylesheet" href="../assets/fullcalendar/main.min.css" />
  <link rel="stylesheet" href="../assets/fullcalendar/custom-calendar.css" />

  <?php
  include './reusables/asset_loader.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

</head>

<body>

  <div class="container-fluid p-0 m-0">
    <?php
    include_once("reusables/headbar.php");
    ?>
  </div>

  <?php
  include_once("reusables/footbar.php");
  ?>

  <script></script>
</body>

</html>
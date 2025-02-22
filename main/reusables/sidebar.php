<?php
  include_once("api/connection.php");

  $package_count = 0;
  $reservation_count = 0;
  $users_count = 0;

  $sql = "SELECT 
    (SELECT COUNT(*) FROM tbl_users WHERE type='customer') AS users_count, 
    (SELECT COUNT(*) FROM event_packages) AS package_count, 
    (SELECT COUNT(*) FROM event_reservations) AS reservation_count";

  $result = $conn->query($sql);

  if ($result) {
    $row = $result->fetch_assoc();
    $users_count = $row['users_count'];
    $package_count = $row['package_count'];
    $reservation_count = $row['reservation_count'];
  } else {
    $users_count = 0;
    $package_count = 0;
    $reservation_count = 0;
  }

  $conn->close();
?>

<style>
  .sidebar {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    height: 100vh;
    padding: 1rem 2rem;
    width: 25%;
  }

  .sidebar-title {
    font-family: "Bebas";
    font-size: 28px;
    text-align: center;
  }

  .sidebar-links {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    text-decoration: none;
    align-items: center;
    color: #000;
    font-size: 24px;
    font-family: "Bebas";
  }

  .sidebar-links>span {
    margin-left: auto;
  }
</style>

<div class="sidebar">
  <img class="img img-fluid align-self-center mt-4 mb-4" src="../images/logo3.png" width="90px" height="90px" />
  <h2 class="sidebar-title">Queen and Knights Event Services</h2>
  <a href="index.php" class="sidebar-links mt-4">
    <i class="fa-solid fa-globe"></i>
    <p>Website</p>
  </a>
  <a href="packages.php" class="sidebar-links mt-4">
    <i class="fa-solid fa-list"></i>
    <p>Packages</p>
    <span><?php echo $package_count; ?></span>
  </a>
  <a href="reservations.php" class="sidebar-links mt-4">
    <i class="fa-solid fa-list"></i>
    <p>Reservations</p>
    <span><?php echo $reservation_count; ?></span>

  </a>
  <a href="calendar.php" class="sidebar-links mt-4">
    <i class="fa-regular fa-calendar-days"></i>
    <p>Calendar</p>
  </a>
  <a href="user-accounts.php" class="sidebar-links mt-4">
    <i class="fa-solid fa-users"></i>
    <p>User Accounts</p>
    <span><?php echo $users_count; ?></span>
  </a>
  <a href="reports.html" class="sidebar-links mt-4">
    <i class="fa-solid fa-file-lines"></i>
    <p>Generate Reports</p>
  </a>
  <hr class="mt-4" />
  <a href="api/logout.php" class="sidebar-links mt-2">
    <i class="fa-solid fa-right-from-bracket"></i>
    <p>Logout</p>
  </a>
</div>
<?php
  include("../connection.php");

  $items_per_page = 3;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $offset = ($page - 1) * $items_per_page;

  $total_result = $conn->query("SELECT COUNT(*) AS total FROM event_packages");
  $total_row = $total_result->fetch_assoc();
  $total_packages = $total_row['total'];
  $total_pages = ceil($total_packages / $items_per_page);

  $get_all_packages = $conn->query("SELECT * FROM event_packages LIMIT $offset, $items_per_page");

  while ($package = $get_all_packages->fetch_assoc()) {
    echo "
      <div class='package'>
        <img src='../" . $package['thumbnail'] . "' />
        <div class='package-body'>
          <div class='info'>
            <h2>" . $package['package_name'] . "</h2>
            <p>Up to " . $package['max_pax'] . " PAX</p>
          </div>
          <div class='link'>
            <p>PHP " . number_format($package['package_price'], 2) . "</p>
            <a href='reservation-page.php?packageid=" . $package['id'] . "'>More Details</a>
          </div>
        </div>
      </div>
      
    ";
  }

  $conn -> close();
?>
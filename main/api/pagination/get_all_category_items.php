<?php
include("../connection.php");

$items_per_page = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;
$category = $_GET['category'];


$total_result = $conn->query("SELECT COUNT(*) AS total FROM event_packages WHERE type='$category'");
$total_row = $total_result->fetch_assoc();
$total_packages = $total_row['total'];
$total_pages = ceil($total_packages / $items_per_page);

$get_all_packages = $conn->query("SELECT * FROM event_packages WHERE type='$category' LIMIT $offset, $items_per_page ");

if ($get_all_packages->num_rows > 0) {
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
} else {
  echo "<p>No package to show</p>";
}


$conn->close();
?>
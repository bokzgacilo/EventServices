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

if ($total_pages > 1) {
  echo "<button class='pag-outside' id='previous-button'>Previous</button>";

  for ($i = 1; $i <= $total_pages; $i++) {
    echo "<button class='page-num" . ($i == $page ? " active" : "") . "' data-target='$i'>$i</button>";
  }

  echo "<button class='pag-outside' id='next-button'>Next</button>";
}



$conn->close();
?>
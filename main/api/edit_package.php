<?php
include("connection.php");
header('Content-Type: application/json');

$reservation_id = $_POST['edit_id'];
$status = $_POST['edit_status'];
$name = mysqli_real_escape_string($conn, $_POST['edit_name']);
$pax = intval($_POST['edit_pax']);
$price = floatval($_POST['edit_price']);
$inclusions = mysqli_real_escape_string($conn, $_POST['edit_inclusions']);
$category = $_POST['edit_category'];

$thumbnail_sql = ""; // default is empty

// Check if file is uploaded and not empty
if (isset($_FILES["edit_thumbnail"]) && $_FILES["edit_thumbnail"]["size"] > 0) {
  $target_dir = "images/packages/";
  $image_name = basename($_FILES["edit_thumbnail"]["name"]);
  $image_file_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

  // Create directory if not exists
  $folder_path = "../../" . $target_dir . $name;
  if (!is_dir($folder_path)) {
    mkdir($folder_path, 0777, true);
  }

  $new_image_path = $target_dir . $name . '/' . $image_name;
  $full_path = "../../" . $new_image_path;

  if (move_uploaded_file($_FILES["edit_thumbnail"]["tmp_name"], $full_path)) {
    // Add thumbnail part to query only if uploaded successfully
    $thumbnail_sql = ", thumbnail = '$new_image_path'";
  } else {
    echo "Error uploading image.";
    exit;
  }
}

// Final SQL query
$sql = "UPDATE event_packages SET 
          package_name = '$name',
          max_pax = $pax,
          package_price = $price,
          inclusions = '$inclusions',
          type = '$category',
          status = $status
          $thumbnail_sql
        WHERE id = $reservation_id";

// Run query
if ($conn->query($sql) === TRUE) {
  echo json_encode([
    "status" => "success",
    "title" => "Success!",
    "description" => "Package updated successfully!"
  ]);
} else {
  echo json_encode([
    "status" => "error",
    "title" => "Update Failed",
    "description" => "Error: " . $conn->error
  ]);
}

$conn->close();
?>
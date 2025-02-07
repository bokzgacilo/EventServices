<?php
include("connection.php");

$name = mysqli_real_escape_string($conn, $_POST['name']);
$pax = intval($_POST['pax']);
$price = floatval($_POST['price']);
$inclusions = mysqli_real_escape_string($conn, $_POST['inclusions']);

// Handle image upload
  if (isset($_FILES["thumbnail"])) {
    $target_dir = "images/packages/";
    $image_name = basename($_FILES["thumbnail"]["name"]);
    $target_file = $target_dir . $image_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Create directory for the image if it doesn't exist
    if (!is_dir("../../" . $target_dir . $name)) {
      mkdir("../../" . $target_dir . $name, 0777, true);
    }

    // Move the uploaded image to the specific folder
    $new_image_path = $target_dir . $name . '/' . $image_name;

    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../../" . $new_image_path)) {
      // Prepare and execute the insert query
      $sql = "INSERT INTO event_packages (package_name, max_pax, package_price, thumbnail, inclusions) VALUES ('$name', $pax, $price, '$new_image_path', '$inclusions')";

      if ($conn->query($sql) === TRUE) {
        echo "New package added successfully!";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "Sorry, there was an error uploading your image.";
    }
  } else {
    echo "Image is required.";
  }

  $conn->close();
?>
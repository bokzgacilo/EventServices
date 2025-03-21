<?php
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_FILES["images"])) {
  $eventid = $_POST['eventid'];

  $uploadDir = "images/event_gallery/$eventid/";

  if (!is_dir("../../../" . $uploadDir)) {
    mkdir("../../../" . $uploadDir, 0777, true);
  }

  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  $uploadedFiles = [];

  foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
    $fileType = $_FILES["images"]["type"][$key];
    $fileExt = pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION); // Get file extension
    $fileIndex = $key + 1; // Ensure filenames start from 1
    $fileName = "img_{$eventid}_{$fileIndex}.{$fileExt}"; // Format: img_eventid_1.jpg, img_eventid_2.png, etc.
    $targetFilePath = $uploadDir . $fileName;

    if (in_array($fileType, $allowedTypes)) {
      if (move_uploaded_file($tmp_name, "../../../" . $targetFilePath)) {
        $uploadedFiles[] = $fileName;
      }
    }
  }

  if (!empty($uploadedFiles)) {
    $sql = "UPDATE event_reservations SET event_status = 'Completed' WHERE id = $eventid";
    if($conn -> query($sql)){
      echo json_encode(["status" => "success", "message" => "Files uploaded, and event updated."]);
    }
  } else {
    echo json_encode(["status" => "error", "message" => "File upload failed."]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "No files received."]);
}

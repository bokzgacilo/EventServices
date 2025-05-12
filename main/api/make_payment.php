<?php
include_once("connection.php");

$reservation_id = $_POST['reservation_id'] ?? '';
$reference_number = $_POST['reference_number'] ?? '';
$payment_date = $_POST['payment_date'] ?? '';

if (isset($_FILES['payment_receipt']) && $_FILES['payment_receipt']['error'] === UPLOAD_ERR_OK) {
  $fileTmpPath = $_FILES['payment_receipt']['tmp_name'];
  $imageInfo = getimagesize($fileTmpPath);
  $destinationFolder = '../../images/payment_receipts/';
  $newFileName = $reservation_id . '.jpeg';

  $destination = $destinationFolder . $newFileName;

  switch ($imageInfo['mime']) {
    case 'image/jpeg':
      $image = imagecreatefromjpeg($fileTmpPath);
      break;
    case 'image/png':
      $image = imagecreatefrompng($fileTmpPath);
      break;
    case 'image/webp':
      $image = imagecreatefromwebp($fileTmpPath);
      break;
    case 'image/gif':
      $image = imagecreatefromgif($fileTmpPath);
      break;
    default:
      http_response_code(400);
      echo "Unsupported image type.";
      exit;
  }
  if (move_uploaded_file($fileTmpPath, $destination)) {
    // Sanitize inputs as needed
    $reservation_id = $_POST['reservation_id'];
    $payment_date = $_POST['payment_date'];
    $reference_number = $_POST['reference_number'];
    $receipt_path = $destination; // This is already your final saved path

    // 1. Update event_reservations: set payment_status = 'Paid'
    $updateSql = "UPDATE event_reservations SET payment_status = 'Paid' WHERE id = ?";
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param("i", $reservation_id);
    $stmtUpdate->execute();

    // 2. Insert into payment
    $insertSql = "INSERT INTO payments (event_id, payment_date, reference_number, receipt_path) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertSql);
    $stmtInsert->bind_param("isss", $reservation_id, $payment_date, $reference_number, $receipt_path);
    $stmtInsert->execute();

    echo "Payment recorded successfully.";
  }
} else {
  echo "Error uploading file.";
}

print_r($_POST);
?>
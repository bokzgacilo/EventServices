<?php
include("../connection.php");
require '../../../vendor/autoload.php'; // Make sure to install PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function exportToExcel($conn, $sql, $filenamePrefix = 'export')
{
  $result = $conn->query($sql);

  if (!$result || $result->num_rows == 0) {
    return json_encode(["status" => "error", "message" => "No data found."]);
  }

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $columns = array_keys($result->fetch_assoc());
  $result->data_seek(0); // reset pointer

  // Write headers to first row
  foreach ($columns as $colIndex => $colName) {
    $cell = chr(65 + $colIndex) . '1'; // A, B, C, ...
    $sheet->setCellValue($cell, $colName);
  }
  $rowIndex = 2;
  while ($row = $result->fetch_assoc()) {
    foreach ($columns as $colIndex => $colName) {
      $cell = chr(65 + $colIndex) . $rowIndex;
      $sheet->setCellValue($cell, $row[$colName]);
    }
    $rowIndex++;
  }
  // Save to file
  $filename = $filenamePrefix . '_' . time() . '.xlsx';
  $exportPath = __DIR__ . '/exports/' . $filename;
  $publicUrl = '/exports/' . $filename; // adjust depending on your URL structure

  $writer = new Xlsx($spreadsheet);
  $writer->save($exportPath);

  return json_encode(["status" => "success", "url" => $publicUrl]);
}

$target = $_POST['target'];

$sql = "";

switch ($_POST['target']) {
  case 'packages':
    $sql = "SELECT * FROM event_packages";
    break;
  case 'reservations':
    $sql = "SELECT * FROM event_reservations";
    break;
  case 'custom_packages':
    $sql = "SELECT * FROM custom_packages_request";
    break;
  case 'users':
    $sql = "SELECT * FROM tbl_users";
    break;
  default:
    echo json_encode(["status" => "type-error", "message" => "Type of Export Error", "description" => "Unable to generate selected type."]);
    exit();
}

echo exportToExcel($conn, $sql, $_POST['target']);
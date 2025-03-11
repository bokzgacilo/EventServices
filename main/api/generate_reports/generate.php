<?php
include("../connection.php");
require '../../../vendor/autoload.php'; // Make sure to install PhpSpreadsheet

$target = $_POST['target'];

// Set the folder to store the file
$folderPath = "exports/";
if (!file_exists($folderPath)) {
  mkdir($folderPath, 0777, true); // Create folder if it doesn't exist
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Generate a unique filename
$filename = "$target-" . time() . ".xlsx";
$filePath = $folderPath . $filename;

$query = "SELECT * FROM tbl_users WHERE type='customer'";
$result = mysqli_query($conn, $query);

if (!$result) {
  die('Query Failed: ' . mysqli_error($conn));
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fetch column names
$columns = [];
while ($field = mysqli_fetch_field($result)) {
    $columns[] = $field->name;
}

// Add column headers
$colIndex = 1;
foreach ($columns as $column) {
    $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
    $sheet->setCellValue($columnLetter . '1', $column); // Column letter + row number
    $colIndex++;
}

// Add data rows
$rowIndex = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $colIndex = 1;
    foreach ($columns as $column) {
        $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($columnLetter . $rowIndex, $row[$column]); // Column letter + row number
        $colIndex++;
    }
    $rowIndex++;
}

// Write the file and send it as a download
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");

// Return the URL of the generated file
$fileUrl = "http://localhost/eventservices/main/" . $filePath; // Change this to your actual domain

// echo json_encode(["success" => true, "file_url" => $fileUrl]);
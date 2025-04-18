<?php
session_start();
include("connection.php");

$pax = $_POST['pax'];
$chairs = $_POST['chairs'];
$tables = $_POST['tables'];
$inclusion = isset($_POST['inclusion']) ? implode(", ", $_POST['inclusion']) : '';
$allergy = $_POST['allergy'];
$menu = $_POST['menu'];

$sql = "INSERT INTO custom_packages_request (client, client_email, pax, no_of_chairs,  no_of_tables, inclusions, allergy, menu) 
  VALUES (?,?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiisss", $_SESSION['userfullname'], $_SESSION['useremail'], $pax, $chairs, $tables, $inclusion, $allergy, $menu);

if ($stmt->execute()) {
  echo 1;
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();

$conn->close();

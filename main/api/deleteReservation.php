<?php

header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'reservationform';
$dbusername = 'root'; // Your database username
$dbpassword = ''; // Your database password

// Get the reservation ID from the request
$reservationId = $_POST['id']; // Make sure to pass this correctly from JavaScript

// Connecting to the database using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("DELETE FROM tbl_info WHERE keyId = :id"); // Use keyId instead of id
    $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
    $stmt->execute();

    // Return success message
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Connection Failed: " . $e->getMessage()]);
}

$pdo = null; // Close the connection
?>

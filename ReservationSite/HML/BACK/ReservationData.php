<?php

header('Content-Type: application/json'); // Set the content type to JSON

$host = 'localhost';
$dbname = 'reservationform';
$dbusername = 'root'; // Your database username
$dbpassword = ''; // Your database password

// Connecting to the database using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM tbl_info");
    $stmt->execute();

    // Fetch all results
    $tbl_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return results as JSON
    echo json_encode($tbl_info);
} catch(PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

$pdo = null; // Close the connection
?>

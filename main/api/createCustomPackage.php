<?php
// Start session and include DB connection
session_start();
include_once("connection.php");

// Get form data
$event_date = $_POST['date'];
$venue = $_POST['venue'];
$pax = $_POST['pax'];
$chairs = $_POST['chairs'];
$tables = $_POST['tables'];
$contact_number = $_POST['contact_number'];
$allergy = isset($_POST['allergy']) ? $_POST['allergy'] : '';
$menu = isset($_POST['menu']) ? $_POST['menu'] : '';

// Combine selected inclusions into a string
$inclusions = implode(", ", $_POST['inclusion']);

// Append allergy, menu, chairs, and tables info with line breaks
$inclusions .= "\nAllergy: " . $allergy;
$inclusions .= "\nPreferred Menu: " . $menu;
$inclusions .= "\nNumber of Chairs: " . $chairs;
$inclusions .= "\nNumber of Tables: " . $tables;

// Insert into event_packages table
$sql = "INSERT INTO event_reservations (
            event_date, event_start, event_end, client_name, client_contact, client_email, 
            venue, event_status, payment_status, price, inclusions
        ) VALUES (
            ?, '06:00:00', '18:00:00', ?, ?, ?, ?, 'Pending', 'Unpaid', 0, ?
        )";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param(
    "ssssss",
    $event_date,
    $_SESSION['userfullname'],
    $contact_number,
    $_SESSION['useremail'],
    $venue,
    $inclusions
);


// Execute and return response
if ($stmt->execute()) {
    echo 1;
} else {
    echo 0;
}
?>

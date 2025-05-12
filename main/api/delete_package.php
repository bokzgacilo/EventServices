<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    include("connection.php");

    $stmt = $conn->prepare("DELETE FROM event_packages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Package deleted successfully.";
    } else {
        http_response_code(500);
        echo "Failed to delete package.";
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo "Invalid request.";
}

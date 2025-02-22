<?php
    header("Content-Type: application/json");
    session_start();

    include_once("connection.php");

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM tbl_users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['userid'] = $row['id'];
        $_SESSION['useremail'] = $row['email'];
        $_SESSION['usertype'] = $row['type'];
        $_SESSION['userfullname'] = $row['name'];

        echo json_encode(["status" => "success", "data" => $row]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
    }

    $stmt->close();
    $conn->close();

?>
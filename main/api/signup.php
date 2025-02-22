<?php

    header("Content-Type: application/json");
    session_start();

    include_once("connection.php");

    $fullname = $_POST['signup_fullname'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    
    // Check if email already exists
    $sql = "SELECT * FROM tbl_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
    } else {
        // Insert new user into the database
        $insertSql = "INSERT INTO tbl_users (name, email, password) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sss", $fullname, $email, $password);
    
        if ($insertStmt->execute()) {
            $_SESSION['userid'] = $insertStmt->insert_id;
            $_SESSION['useremail'] = $email;
            $_SESSION['userfullname'] = $fullname;
            $_SESSION['usertype'] = "customer";
            echo json_encode(["status" => "success", "message" => "User registered successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to register user"]);
        }
    
        $insertStmt -> close();
    }
    
    $stmt->close();
    $conn->close();
?>
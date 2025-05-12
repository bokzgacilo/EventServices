<?php
include_once("../module/emailer.php");
include_once("connection.php");

header("Content-Type: application/json");
session_start();

$email = $_POST['login_email'];
$password = $_POST['login_password'];

$sql = "SELECT email, id, name, type FROM tbl_users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  if ($row['type'] !== 'admin') {
    $otp = rand(100000, 999999);
    $update_otp = $conn->query("UPDATE tbl_users SET otp = $otp WHERE id = " . $row['id']);
    sendOtpToEmail($row['email'], $row['name'], $otp);
    echo json_encode(["status" => "otp_required", "data" => $row, "message" => "OTP sent to your email."]);
  } else {
    $_SESSION['userid'] = $row['id'];
    $_SESSION['useremail'] = $row['email'];
    $_SESSION['usertype'] = $row['type'];
    $_SESSION['userfullname'] = $row['name'];

    echo json_encode(["status" => "success", "data" => $row, "redirect" => "packages.php"]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}

$stmt->close();
$conn->close();

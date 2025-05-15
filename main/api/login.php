<?php
include_once("../module/emailer.php");
include_once("connection.php");
include_once("../../sms.php");

header("Content-Type: application/json");
session_start();

$email = $_POST['login_email'];
$password = $_POST['login_password'];

$sql = "SELECT email, id, name, type, contact_number FROM tbl_users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $contact = $row['contact_number'];
  if ($row['type'] !== 'admin') {
    $otp = rand(100000, 999999);
    $update_otp = $conn->query("UPDATE tbl_users SET otp = $otp WHERE id = " . $row['id']);

    $message = "Your OTP code for signing is: $otp

If you did not request this, please disregard this message.

- Queen And Knights Event Services";

    sendSms(  $contact, $message);
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

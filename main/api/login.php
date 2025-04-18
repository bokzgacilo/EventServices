<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function sendOtpToEmail($email, $name, $otp) {
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'bokwebmaster2000@gmail.com'; // Replace with your email
    $mail->Password = 'wakjlhpqrwuvgkdn'; // Replace with your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('bokwebmaster2000@gmail.com', 'Queens And Knights Support'); // Replace with your email and name
    $mail->addAddress($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = "Dear $name,<br><br>Your OTP code is <strong>$otp</strong>.<br><br>Please use this code to complete your login.<br><br>Best regards,<br>Queen and Knights Event Services";

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

header("Content-Type: application/json");
session_start();

include_once("connection.php");

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

    echo json_encode(["status" => "success", "data" => $row]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}

$stmt->close();
$conn->close();

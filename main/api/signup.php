<?php

include_once("../module/emailer.php");
include_once("connection.php");
include_once("../../sms.php");

header("Content-Type: application/json");
session_start();

function deleteFromSignupTable($email) {
  global $conn;

  $sql = "DELETE FROM pre_signup_otp WHERE email = ?";
  $stmt = $conn -> prepare($sql);
  $stmt -> bind_param("s", $email);
  if($stmt -> execute()){
    return true;
  }else {
    return false;
  }
}

switch($_GET['step']){
  case 1:
    $fullname = $_POST['signup_fullname'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $contact = $_POST['signup_contact'];
    $otp = rand(100000, 999999);
    $sms_otp = rand(100000, 999999);

    $sql = "SELECT * FROM tbl_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $message = "Your OTP code for signup is: $sms_otp

If you did not request this, please disregard this message.

- Queen And Knights Event Services";

    
    if ($result->num_rows > 0) {
      echo json_encode(["status" => "error", "message" => "Email already exists"]);
    } else {
      $createOTP = $conn -> prepare("INSERT INTO pre_signup_otp (email, otp, sms_otp) VALUES (?,?, ?)");
      $createOTP -> bind_param("sii", $email, $otp, $sms_otp);

      if($createOTP -> execute()){
        sendSms("+63$contact", $message);
        sendSignupOtpToEmail($email, $fullname, $otp);
        echo json_encode(["status" => "success", "message" => "Ready to create", "data" => $_POST]);
      }else {
        echo json_encode(["status" => "error", "message" => "Error creating otp"]);
      }
    }
    break;
  case 2:
    $fullname = $_POST['hidden_signup_name'];
    $email = $_POST['hidden_signup_email'];
    $password = $_POST['hidden_signup_password'];
    $contact = "+63".$_POST['hidden_signup_contact'];
    $otp = $_POST['otp'];
    $sms_otp = $_POST['sms_otp'];

    $select = $conn -> prepare("SELECT otp, sms_otp FROM pre_signup_otp WHERE email = ?");
    $select -> bind_param("s", $email);
    $select -> execute();
    $result = $select -> get_result();

    if($result -> num_rows > 0){
      $row = $result -> fetch_assoc();

      if($row['otp'] == $otp && $row['sms_otp'] == $sms_otp){
        $insertSql = "INSERT INTO tbl_users (name, email, password, contact_number) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssss", $fullname, $email, $password, $contact);
  
        if ($insertStmt->execute()) {
          $_SESSION['userid'] = $insertStmt->insert_id;
          $_SESSION['useremail'] = $email;
          $_SESSION['userfullname'] = $fullname;
          $_SESSION['usertype'] = "customer";
          echo json_encode(["status" => "success", "message" => "OTP Verified", "description" => "You can now login using your credential"]);
        } else {
          echo json_encode(["status" => "error", "message" => "Failed to register user"]);
        }
        deleteFromSignupTable($email);
        $insertStmt->close();
      }else {
        echo json_encode(["status" => "mismatch-otp", "message" => "Wrong OTP Codes", "description" => "You provided wrong otp code. Signup process will be aborted"]);
        deleteFromSignupTable($email);
        exit();
      }
    }else {
      echo json_encode(["status" => "missing-otp", "message" => "OTP is not existing"]);
      exit();
    }
    
    break;
  default:
  echo json_encode(["status" => "invalid-step", "message" => "Invalid step code. Please try again."]);
  exit();
}
?>
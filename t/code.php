<?php
session_start();

date_default_timezone_set('Asia/Manila');

require 'phpmailer/PHPMailerAutoload.php';
include "../db_connect/config.php";

$email = $_POST['email'];

// Check if an unexpired OTP already exists for the provided email
$checkSql = "SELECT id FROM otp_codes WHERE email = ? AND expiration_time >= NOW()";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    // No unexpired OTP found for the provided email, proceed to generate a new OTP
    $otp = mt_rand(100000, 999999);
    
    // Define the expiration time as 2 minutes from the current time
    $expirationTime = date('Y-m-d H:i:s', strtotime('+3 minutes'));

    $stmt = $conn->prepare("INSERT INTO otp_codes (email, code, expiration_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $otp, $expirationTime);

    if ($stmt->execute()) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'blazered098@gmail.com'; // Your email
        $mail->Password = 'nnhthgjzjbdpilbh'; // Your email password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('blazered098@gmail.com', 'Z-Skin Care');
        $mail->addAddress($_POST['email']); // Replace with the email address from your form
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body = 'Your verification code is: ' . $otp;

        if ($mail->send()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    // An unexpired OTP already exists for the provided email
    echo json_encode(['success' => false, 'error' => 'An unexpired OTP already exists for this email. Wait next 3 minutes to request a OTP']);
}

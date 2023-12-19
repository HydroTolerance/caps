<?php
session_start();

date_default_timezone_set('Asia/Manila');

require 'phpmailer/PHPMailerAutoload.php';
include "../db_connect/config.php";

$email = $_POST['email'];
$currentTimestamp = time();
$expirationTimestamp = $currentTimestamp + 600;
$checkSql = "SELECT id FROM otp_codes WHERE email = ? AND expiration_time >= ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $email, $currentTimestamp);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $otp = mt_rand(100000, 999999);

    $stmt = $conn->prepare("INSERT INTO otp_codes (email, code, expiration_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $otp, $expirationTimestamp);

    if ($stmt->execute()) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'blazered098@gmail.com';
        $mail->Password = 'nnhthgjzjbdpilbh';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('blazered098@gmail.com', 'Z Skin Care Center');
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                padding: 20px;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #6537AE;
            }

            p {
                font-size: 16px;
            }

            .otp {
                font-size: 24px;
                font-weight: bold;
                color: #dc3545;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 style="text-align: center;">Z Skin Care Center</h1>
            <p>Dear user,</p>
            <p>Your verification code is: <span class="otp">' . $otp . '</span></p>
            <p>This code will expire in 10 minutes. Please use it to complete the verification process.</p>
            <p>Thank you for choosing Z Skin Care Center.</p>
        </div>
    </body>
    </html>
';

        if ($mail->send()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'An unexpired OTP already exists for this email. Wait next 10 minutes to request an OTP']);
}
?>

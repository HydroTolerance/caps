<?php
include "db_connect/config.php";
require 't/phpmailer/PHPMailerAutoload.php';

if (isset($_POST["send_otp"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    
    // Check if the email exists in zp_accounts table
    $clinicSql = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_email = '$email'");
    $clinicCount = mysqli_num_rows($clinicSql);

    // Check if the email exists in zp_client_record table
    $clientSql = mysqli_query($conn, "SELECT * FROM zp_client_record WHERE client_email = '$email'");
    $clientCount = mysqli_num_rows($clientSql);

    if ($clinicCount > 0 || $clientCount > 0) {
        // Email exists in either table, proceed with OTP generation and sending
        $otp = sprintf('%06d', mt_rand(0, 999999));
        $expiration_time = time() + 6000;
        
        // Update the OTP and expiration time in the appropriate table
        if ($clinicCount > 0) {
            mysqli_query($conn, "UPDATE zp_accounts SET otp = '$otp', expiration_time = $expiration_time WHERE clinic_email = '$email'");
        } else {
            mysqli_query($conn, "UPDATE zp_client_record SET otp = '$otp', expiration_time = $expiration_time WHERE client_email = '$email'");
        }

        $mail = new PHPMailer();

        $smtpHost = 'smtp.gmail.com';
        $smtpPort = 587;
        $smtpUsername = 'blazered098@gmail.com';
        $smtpPassword = 'nnhthgjzjbdpilbh';

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;

        $mail->setFrom($smtpUsername, 'Zephyris Skin Care');
        $mail->addAddress($email);
        $mail->Subject = 'OTP Code';
        $mail->isHTML(true);
        $mail->Body = "Your OTP code is: $otp";
        $mailSent = $mail->send();

        if ($mailSent) {
            $success_message = "OTP code sent to your email. Check your inbox (and spam folder) for the code.";
            header("Location: verified_otp.php?email=" . urlencode($email));
            exit();
        } else {
            $error_message = "Email sending failed. Please try again later.";
        }
    } else {
        $error_message = "Email does not exist. Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.19.0/font/bootstrap-icons.css" rel="stylesheet">

    <title>Forgot Password</title>
</head>
<body>
<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Forgot Password</h2>
                    <form method="post">
                        <div class="form-outline mb-2 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            </div>
                            <input type="email" id="form2ExampleEmail" class="form-control" name="clinic_email" placeholder="Enter your Email" required />
                        </div>
                        <div class="text-center pt-1 mb-5 pb-1">
                            <button type="submit" name="send_otp" value="Send OTP" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Send OTP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

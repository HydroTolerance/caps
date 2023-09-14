<?php
include "db_connect/config.php";
require 'CapDev/phpmailer/PHPMailerAutoload.php';

if (isset($_POST["send_otp"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $otp = sprintf('%06d', mt_rand(0, 999999));
    $expiration_time = time() + 6000;
    mysqli_query($conn, "UPDATE zp_accounts SET otp = '$otp', expiration_time = $expiration_time WHERE clinic_email = '$email'");
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
}
?>
<style>

.container {
        background-color: #FFFF;
        padding: 20px;
        border-radius: 10px;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #F2B85A;
        
    }

    .form-outline {
            text-align: center;
            padding: 50px;
        }
        .form-outline label {
            display: block;
            margin-top: 5px;
        }

        .text-center {
            justify-content: center;
            margin-left: 95px;
            margin-top: 5px;
           
        }
    
        .header-text {
       
        text-align: center;
        margin-bottom: 20px;
        color: #F2B85A;
        font-size: 30px;
        
    }

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
<div class="container">

<p class="header-text">Forgot Password</p>

    <form method="post">
        <div class="form-outline mb-2">
            <input type="email" id="form2ExampleEmail" class="form-control" name="clinic_email" required />
            <label class="form-label" for="form2ExampleEmail">Enter your email address</label>
        </div>
        <div class="text-center pt-1 mb-5 pb-1">
            <button type="submit" name="send_otp" value="Send OTP" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Send OTP</button>
        </div>
    </form>
</div>
</body>
</html>

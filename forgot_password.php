<?php
session_start();
include "db_connect/config.php";
require 't/phpmailer/PHPMailerAutoload.php';

if (isset($_POST["send_otp"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $clinicSql = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_email = '$email'");
    $clinicCount = mysqli_num_rows($clinicSql);
    $clientSql = mysqli_query($conn, "SELECT * FROM zp_client_record WHERE client_email = '$email'");
    $clientCount = mysqli_num_rows($clientSql);

    if ($clinicCount > 0 || $clientCount > 0) {
        $otp = sprintf('%06d', mt_rand(0, 999999));
        $expiration_time = time() + 180;
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
    <link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">
    <title>Forgot Password</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}
    #pageloader {
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader {

        margin: 0 auto;
        margin-top: 35vh;
    }

    /* FlipX animation for the custom-loader and the image */
    @keyframes flipX {
        0% {
            transform: scaleX(1);
        }
        50% {
            transform: scaleX(-1);
        }
        100% {
            transform: scaleX(1);
        }
    }

    .flipX-animation {
        animation-name: flipX;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
    }
</style>
<body style="background-color: #6537AE;">
    <div id="pageloader">
        <div class="custom-loader flipX-animation"></div>
        <div class="text-center">
            <img src="t/images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
        </div>
        <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
    </div>
    
<body >
<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-sm-10 col-md-8 col-lg-8 animate__animated animate__fadeIn">
        
            <div class="card shadow">
                 <div class="card-header d-flex justify-content-end">
                    <a href="index.php" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="card-body p-4"> <!-- Added padding class p-4 -->
                    <div class="row">
                        <div class="col-lg-6 m-auto">
                            <img src="./t/images/Forgot password-amico.svg" alt="" class=" d-none d-lg-block  img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center mb-4">
                                <img src="t/images/6.png" style="width: 125px;" alt="logo" class="mb-3">
                                <h2 class="text-center" style="font-family: Lora;">FORGOT PASSWORD</h2>
                            </div>
                            <form method="post" id="signUpForm" class="needs-validation" novalidate>
                            <div class="form-floating mb-3 mt-3">
                                <input type="email" id="form2ExampleEmail" class="form-control" name="clinic_email" placeholder="Enter your Email" required />
                                <label for="email">Email</label>
                                <div class="invalid-feedback">
                                    Please enter your email.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-center pt-1 mb-5 pb-1">
                                <button type="submit" name="send_otp" value="Send OTP" class="btn w-100 text-white my-3" style="background-color: #6537AE;">Proceed to Forgot Password</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()
        $(document).ready(function() {
        $("#signUpForm").on("submit", function(e) {
            if (this.checkValidity()) {
            $("#pageloader").fadeIn();
            } else {
            e.preventDefault();
            }
        });
        });
    </script>
</div>
</body>
</html>

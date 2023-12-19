<?php
session_start();
include "db_connect/config.php";

if (isset($_POST["verify_otp"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $entered_otp = '';
    for ($i = 1; $i <= 6; $i++) {
        $entered_otp .= mysqli_real_escape_string($conn, trim($_POST['otp' . $i]));
    }
    $resultClinic = mysqli_query($conn, "SELECT otp, expiration_time FROM zp_accounts WHERE clinic_email = '$email'");
    if ($rowClinic = mysqli_fetch_assoc($resultClinic)) {
        $stored_otp = $rowClinic['otp'];
        $expiration_time = $rowClinic['expiration_time'];
        if ($entered_otp === $stored_otp && time() <= $expiration_time) {
            header("Location: reset_password.php?email=" . urlencode($email));
            exit();
        } elseif (time() > $expiration_time) {
            $error_message = "The OTP has expired. Please request a new OTP.";
        } else {
            $error_message = "Invalid OTP. Please try again.";
        }
    } else {
        $resultClient = mysqli_query($conn, "SELECT otp, expiration_time FROM zp_client_record WHERE client_email = '$email'");
        if ($rowClient = mysqli_fetch_assoc($resultClient)) {
            $stored_otp_client = $rowClient['otp'];
            $expiration_time_client = $rowClient['expiration_time'];
            if ($entered_otp === $stored_otp_client && time() <= $expiration_time_client) {
                header("Location: reset_password.php?email=" . urlencode($email));
                exit();
            } elseif (time() > $expiration_time_client) {
                $error_message = "The OTP has expired. Please request a new OTP.";
            } else {
                $error_message = "Invalid OTP. Please try again.";
            }
        } else {
            $error_message = "Email not found. Please try again.";
        }
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
    <title>Verify OTP</title>
</head>
<body style="background-color: #6537AE;">
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
                            <img src="./t/images/Enter OTP-amico.svg" alt="" class=" d-none d-lg-block  img-fluid">
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="text-center mb-4">
                                <img src="t/images/6.png" style="width: 125px;" alt="logo" class="mb-3">
                                <h2 class="text-center" style="font-family: Lora;">INPUT YOUR OTP</h2>
                            </div>
                            <form method="post" id="signUpForm" class="needs-validation" novalidate>
                                <div class="form-group mb-3 mt-3 d-flex justify-content-center">
                                    <?php
                                    for ($i = 1; $i <= 6; $i++) {
                                        echo '<input type="text" class="form-control otp-input mx-2 text-center" name="otp' . $i . '" maxlength="1" required />';
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="clinic_email" value="<?php echo htmlspecialchars($_GET['email']); ?>" />
                                <div class="mb-3">
                                    <?php if (!empty($error_message)) : ?>
                                        <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($success_message)) : ?>
                                        <div class="alert alert-success animate__animated animate__fadeIn" role="alert">
                                            <?php echo $success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center pt-1 mb-5 pb-1">
                                    <button type="submit" name="verify_otp" value="Send OTP" class="btn w-100 text-white my-3" style="background-color: #6537AE;">Verify Your OTP</button>
                                </div>
                            </form>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Well done!</h4>
                                <p>Your OTP has been successfully sent to your email.</p>
                                <hr>
                                <p class="mb-0">Please check your email for the One-Time Password (OTP). If you have any issues, ensure that you use margin utilities to keep your display neat and organized.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
include "db_connect/config.php";

if (isset($_POST["verify_otp"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $entered_otp = mysqli_real_escape_string($conn, trim($_POST['otp']));
    $result = mysqli_query($conn, "SELECT otp, expiration_time FROM zp_accounts WHERE clinic_email = '$email'");
    if ($row = mysqli_fetch_assoc($result)) {
        $stored_otp = $row['otp'];
        $expiration_time = $row['expiration_time'];
        if ($entered_otp === $stored_otp && time() <= $expiration_time) {
            header("Location: reset_password.php?email=" . urlencode($email));
            exit();
        } else {
            $error_message = "Invalid OTP. Please try again.";
        }
    } else {
        $error_message = "Email not found. Please try again.";
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
    <title>Verify OTP</title>
</head>
<body>
<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
            <div class="card shadow">
                <div class="card-body">
                        <h2 class="card-title text-center">Input your OTP</h2>
                        <form method="post">
                            <div class="form-outline mb-2">
                                <input type="text" id="otp" class="form-control" name="otp" required />
                            </div>
                            <input type="hidden" name="clinic_email" value="<?php echo htmlspecialchars($_GET['email']); ?>" />
                            <div class="text-center pt-1 mb-5 pb-1">
                                <button type="submit" name="verify_otp" value="Verify OTP" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Verify OTP</button>
                            </div>
                            <?php if (isset($error_message)) : ?>
                                <p><?php echo $error_message; ?></p>
                            <?php endif; ?>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

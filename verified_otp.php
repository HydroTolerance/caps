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
    <title>Verify OTP</title>
</head>
<body>
<div class="container">

<p class="header-text">OTP Verification</p>

    <form method="post">
        <div class="form-outline mb-2">
            <input type="text" id="otp" class="form-control" name="otp" required />
            <label class="form-label" for="otp">Enter OTP</label>
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
</body>
</html>

<?php
session_start();

if (isset($_POST['verify'])) {
    // Check if the submitted email and OTP are correct (you should have a database to store this information)
    $submittedEmail = $_POST['email'];
    $submittedOTP = $_POST['otp'];

    // Verify the email and OTP (You need to implement this part)
    if (verifyEmailAndOTP($submittedEmail, $submittedOTP)) {
        $_SESSION['verified'] = true; // Set a session variable to indicate successful verification
        header("Location: appointment_form.php");
        exit;
    } else {
        // Invalid email or OTP, show an error message or redirect back to the verification page
        echo "Invalid email or OTP. Please try again.";
    }
}

function verifyEmailAndOTP($submittedEmail, $submittedOTP) {
    include "db_connect/config.php"; // Include your database connection

    // Set an expiration time for OTP (e.g., 10 minutes)
    $otpExpirationTime = time() - 600; // 600 seconds = 10 minutes

    $query = "SELECT email, otp, timestamp FROM otp_verification WHERE email = ? AND otp = ? AND timestamp >= ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $submittedEmail, $submittedOTP, $otpExpirationTime);
    mysqli_stmt_execute($stmt);

    // Fetch the results
    mysqli_stmt_store_result($stmt);
    $numRows = mysqli_stmt_num_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // If a valid entry is found and OTP is not expired, return true; otherwise, return false
    return $numRows > 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary CSS and JavaScript libraries -->
    <!-- Add your CSS styles if needed -->
    <!-- Include jQuery, Bootstrap, etc. -->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Email and OTP Verification</h2>
            <form method="post" action="verification.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="otp">OTP:</label>
                    <input type="text" class="form-control" name="otp" required>
                </div>
                <button type="submit" name="verify" class="btn btn-primary">Verify</button>
                <button type="button" id="sendOTP" class="btn btn-secondary">Send OTP</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

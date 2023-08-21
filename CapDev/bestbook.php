<?php
session_start();

if (isset($_POST['verify_otp'])) {
    $enteredOTP = $_POST['otp'];
    $storedOTP = $_SESSION['verification_otp'];

    if ($enteredOTP == $storedOTP) {
        // OTP matches, proceed to the appointment form or any other action
        header("Location: booking.php");
        exit;
    } else {
        // OTP doesn't match, display error message
        echo "Invalid OTP. Please try again.";
    }
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
</head>
<body>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 border p-4 shadow bg-light">
                    <h3 class="fs-4 text-uppercase mb-4" style="color: #6537AE;">Verify OTP</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="otp">Enter OTP:</label>
                            <input type="text" class="form-control" name="otp" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="verify_otp">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

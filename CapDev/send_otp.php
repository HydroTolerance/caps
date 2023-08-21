<?php
// Include PHPMailer autoloader
require 'phpmailer/PHPMailerAutoload.php';

function generateOTP() {
    return rand(100000, 999999); // Generate a 6-digit OTP
}

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $otp = generateOTP(); // Generate OTP

    // Store the OTP and email in session for verification later
    session_start();
    $_SESSION['verification_email'] = $email;
    $_SESSION['verification_otp'] = $otp;

    // Send the OTP via email using PHPMailer with SMTP
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'blazered098@gmail.com'; // Your SMTP username
    $mail->Password = 'nnhthgjzjbdpilbh'; // Your SMTP password
    $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' depending on your server
    $mail->Port = 587; // SMTP port (587 for TLS, 465 for SSL)

    $mail->setFrom('blazered098@gmail.com', 'Your Name');
    $mail->addAddress($email);
    $mail->Subject = "Your One-Time Password";
    $mail->Body = "Your OTP for appointment booking is: " . $otp;

    if ($mail->send()) {
        // Email sent successfully
        header("Location: bestbook.php");
        exit;
    } else {
        echo "Error sending OTP email.";
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
                    <h3 class="fs-4 text-uppercase mb-4" style="color: #6537AE;">Send OTP</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="email">Enter Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="send_otp">Send OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

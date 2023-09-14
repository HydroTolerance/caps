<?php
include "db_connect/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE zp_accounts SET clinic_password = '$hashed_password' WHERE clinic_email = '$email'");
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form method="post">
        <div class="form-outline mb-2">
            <input type="password" id="new_password" class="form-control" name="new_password" required />
            <label class="form-label" for="new_password">Enter Your New Password</label>
        </div>
        <input type="hidden" name="clinic_email" value="<?php echo htmlspecialchars($_GET['email']); ?>" />
        <div class="text-center pt-1 mb-5 pb-1">
            <button type="submit" name="reset_password" value="Reset Password" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Reset Password</button>
        </div>
    </form>
</body>
</html>

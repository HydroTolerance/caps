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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.19.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
            <div class="card shadow">
                <div class="card-body">
                <h2 class="card-title text-center">Reset Password</h2>
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
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

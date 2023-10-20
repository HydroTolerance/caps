<?php
include "db_connect/config.php";
session_start();
$error_message = ""; // Initialize error message

if (isset($_SESSION['clinic_email'])) {
    $role = $_SESSION['clinic_role'];
    switch ($role) {
        case 'Admin':
            header("Location: Admin/dashboard/dashboard.php");
            exit();
        case 'Derma':
            header("Location: Derma/dashboard/dashboard.php");
            exit();
        case 'Staff':
            header("Location: Staff/dashboard/dashboard.php");
            exit();
        default:
            break;
    }
}

if (isset($_POST["submit"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $password = trim($_POST['clinic_password']);

    $sql = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_email = '$email'");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        $fetch = mysqli_fetch_assoc($sql);
        $hashpassword = $fetch["clinic_password"];
        $accountStatus = $fetch["account_status"];

        if (password_verify($password, $hashpassword)) {
            if ($accountStatus === 'active') {
                $role = $fetch["clinic_role"];
                $_SESSION['clinic_email'] = $email;
                $_SESSION['clinic_role'] = $role;
                $_SESSION['id'] = $fetch;

                switch ($role) {
                    case 'Admin':
                        header("Location: Admin/dashboard/dashboard.php");
                        exit();
                    case 'Derma':
                        header("Location: Derma/dashboard/dashboard.php");
                        exit();
                    case 'Staff':
                        header("Location: Staff/dashboard/dashboard.php");
                        exit();
                    default:
                        $error_message = "Invalid role.";
                        break;
                }
            } else {
                $error_message = "Deactivated account. Please contact the administrator.";
            }
        } else {
            $error_message = "Invalid email or password, please try again.";
        }
    } else {
        $clientSql = mysqli_query($conn, "SELECT * FROM zp_client_record WHERE client_email = '$email'");
        $clientCount = mysqli_num_rows($clientSql);

        if ($clientCount > 0) {
            $userData = mysqli_fetch_assoc($clientSql);
            $hashedPassword = $userData['client_password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['id'] = $userData;
                $_SESSION['client_email'] = $userData;
                $_SESSION['client_password'] = $userData;
                header("Location: Client/client_record/view.php");
                exit();
            } else {
                $error_message = "Invalid email or password, please try again.";
            }
        } else {
            $error_message = "Invalid email or password, please try again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>

<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center">Login</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="clinic_email" class="form-label">Username</label>
                            <input type="text" class="form-control" id="clinic_email" name="clinic_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="clinic_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="clinic_password" name="clinic_password" required>
                        </div>
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <a href="forgot_password.php" class="float-end" style="color: grey;">Forgot Password?</a>
                        </div>
                        <button type="submit" name="submit" class="btn btn-block text-white" style="background-color: #6537AE;">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
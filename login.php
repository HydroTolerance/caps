

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">
    <title>Login</title>
</head>

<body>
<?php
include "db_connect/config.php";
session_start();
$error_message = "";

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_failed_login_time'])) {
    $_SESSION['last_failed_login_time'] = 1;
}

if ($_SESSION['login_attempts'] >= 5) {
    $timeToWait = 120;
    $currentTime = time();

    if (($currentTime - $_SESSION['last_failed_login_time']) < $timeToWait) {
        $remainingTime = $timeToWait - ($currentTime - $_SESSION['last_failed_login_time']);
        $error_message = "Too many failed login attempts. Please wait for " . gmdate("i:s", $remainingTime) . " before trying again.";
    } else {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_failed_login_time'] = 1;
    }
}

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

if (isset($_SESSION['client_email'])) {
    $role = $_SESSION['client_role'];
    if ($role === 'Client') {
        header("Location: Client/client_record/view.php");
        exit();
        $error_message = "Invalid role.";
    }
}

if (isset($_POST["submit"])) {
    if ($_SESSION['login_attempts'] >= 5) {
        if ($_SESSION['last_failed_login_time'] === 1) {
            $_SESSION['last_failed_login_time'] = time();
        }

        $timeToWait = 120;
        $currentTime = time();

        if (($currentTime - $_SESSION['last_failed_login_time']) < $timeToWait) {
            $remainingTime = $timeToWait - ($currentTime - $_SESSION['last_failed_login_time']);
            $error_message = "Too many failed login attempts. Please wait for " . gmdate("i:s", $remainingTime) . " before trying again.";
        } else {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_failed_login_time'] = 1;
        }
    } else {
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
                $_SESSION['login_attempts']++;
                $remainingAttempts = 5 - $_SESSION['login_attempts'];
                $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
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
                    $_SESSION['client_role'] = 'Client';
                    header("Location: Client/client_record/view.php");
                    exit();
                } else {
                    $_SESSION['login_attempts']++;
                    $remainingAttempts = 5 - $_SESSION['login_attempts'];
                    $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
                }
            } else {
                $_SESSION['login_attempts']++;
                $remainingAttempts = 5 - $_SESSION['login_attempts'];
                $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
            }
        }
        $_SESSION['last_failed_login_time'] = time();
    }
}
?>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" href="index.php">
    <img src="./t/images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white fs-5" href="index.php">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/about.php">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/service.php">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/FAQ.php">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/contact.php">Contact</a>
        </li>
      </ul>
            <a href="login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
        <a href="./t/booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
<div class="container-fluid" style="background-color: #eee;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center">Login Account</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="clinic_email" class="form-label">Username</label>
                            <input type="text" class="form-control" id="clinic_email" name="clinic_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="clinic_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="clinic_password" name="clinic_password" required>
                        </div>
                        <button type="submit" name="submit" class="btn w-100 text-white my-3" style="background-color: #6537AE;">Log In</button>
                        <a href="forgot_password.php" class="float-end my-3" style="color: grey;">Forgot Password?</a>
                        <div>
                            
                        </div>
                        
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

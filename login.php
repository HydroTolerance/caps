<?php
include "Client/function.php";
checklogin('Client', true);
$userData = [];
$isClientLoggedIn = isset($_SESSION['client_email']);
if ($isClientLoggedIn) {
    $userData = $_SESSION['id'];
}
?>
<?php
include "db_connect/config.php";
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

        // Check if the account is archived
        if ($accountStatus === 'archived') {
            $_SESSION['login_attempts']++;
            $remainingAttempts = 5 - $_SESSION['login_attempts'];
            $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
        } elseif ($accountStatus === 'active' && password_verify($password, $hashpassword)) {
            $_SESSION['clinic_email'] = $email;
            $_SESSION['clinic_role'] = $fetch["clinic_role"];
            $_SESSION['clinic_password'] = $password;
            $_SESSION['id'] = $fetch;

            switch ($_SESSION['clinic_role']) {
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
            if ($count > 0) {
        $_SESSION['login_attempts']++;
        $remainingAttempts = 5 - $_SESSION['login_attempts'];

        // Check if the maximum attempts are reached
        if ($_SESSION['login_attempts'] >= 5) {
            $_SESSION['last_failed_login_time'] = time();
        }

        $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
    } else {
        $_SESSION['login_attempts']++;
        $remainingAttempts = 5 - $_SESSION['login_attempts'];
        $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
    }
}
    } else {
        $clientSql = mysqli_query($conn, "SELECT * FROM zp_client_record WHERE client_email = '$email'");
        $clientCount = mysqli_num_rows($clientSql);

        if ($clientCount > 0) {
            $userData = mysqli_fetch_assoc($clientSql);

            // Check if the account is archived
            if ($userData['is_archived'] == 1) {
                $_SESSION['login_attempts']++;
                $remainingAttempts = 5 - $_SESSION['login_attempts'];
                $error_message = "Invalid email or password. You have $remainingAttempts attempts left.";
            } elseif (password_verify($password, $userData['client_password'])) {
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

        $_SESSION['last_failed_login_time'] = time();
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
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
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
                            <img src="./t/images/Login-amico.svg" alt="" class=" d-none d-lg-block  img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center mb-4">
                                <img src="t/images/6.png" style="width: 125px;" alt="logo" class="mb-3">
                                <h2 class="text-center" style="font-family: Lora;">LOGIN ACCOUNT</h2>
                            </div>
                            <form method="post">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" placeholder="Username" id="email" name="clinic_email" required>
                                <label for="email">Email</label>
                            </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="Password" name="clinic_password" required>
                                    <label for="password">Password</label>
                            </div>
                                <label for="" class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></label>
                        </div>
                        <div class="mb-3">
                            <?php if (!empty($error_message)) : ?>
                                <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-center pt-1 mb-5 pb-1">
                            <button type="submit" name="submit" class="btn w-100 text-white my-3" style="background-color: #6537AE;">Log In</button>
                            <a href="forgot_password.php" class="my-3" style="color: grey;">Forgot Password?</a><br>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using getAttribute() method
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.classList.toggle('bi-eye');
    });
</script>

</body>
</html>
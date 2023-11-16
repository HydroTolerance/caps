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

            if (password_verify($password, $hashpassword)) {
                if ($accountStatus === 'active') {
                    $role = $fetch["clinic_role"];
                    $_SESSION['clinic_email'] = $email;
                    $_SESSION['clinic_role'] = $role;
                    $_SESSION['clinic_password'] = $password;
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Z-Skin Care Center</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
<link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">
</head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}


.footer {
    background-color: #6537AE;
    color: #fff;

}
.footer-wave-svg {
    background-color: transparent;
    display: block;
    height: 30px;
    position: relative;
    top: -1px;
    width: 100%;
}
.footer-wave-path {
    fill: #fffff2;
}

.fixed-text {
  position: fixed;
  top: 50%; /* Adjust the vertical position as needed */
  left: 40%; /* Adjust the horizontal position as needed */
  transform: translate(-50%, -50%);
}
.custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}


</style>
<body>

<body>
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
      <?php if ($isClientLoggedIn): ?>
        <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle me-3" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="Client/client_record/view.php">Profile Account</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                    <li><a class="dropdown-item" href="../Client/logout.php">Sign out</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline-light mx-2" type="submit">Login</a>
        <?php endif; ?>
        <a href="./t/booking.php" class="btn btn-outline-light" type="submit">Book an Appointment</a>
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
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="clinic_password" required>
                                <label for="" class="input-group-text "><i class="bi bi-eye-slash" id="togglePassword"></i></label>
                            </div>
                                
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>


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

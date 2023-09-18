<?php
include "db_connect/config.php";
session_start();
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
            $_SESSION['zep_acc'] = $fetch;

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
    $error_message = "Invalid email or password, please try again.";
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<script>
    const bgImages = ['side1.png', 'side2.png', 'side3.png'];
    let currentIndex = 0;

    function changeBackgroundImage() {
      const bgElement = document.querySelector('.bg');
      const fadeInDuration = 600;
      bgElement.style.transition = `opacity ${fadeInDuration / 2}ms ease-out`;
      bgElement.style.opacity = 0;

      setTimeout(() => {
        bgElement.style.backgroundImage = `url('${bgImages[currentIndex]}')`;
        bgElement.style.transition = `opacity ${fadeInDuration / 1}ms ease-in`;
        bgElement.style.opacity = 1;

        currentIndex = (currentIndex + 1) % bgImages.length;
      }, fadeInDuration / 2);
    }
    setTimeout(changeBackgroundImage);
    setInterval(changeBackgroundImage, 15000);
</script>

<body>
  <div class="d-lg-flex half">
    <div class="bg order-2 order-md-1 bg"></div>
    <div class="contents order-1 order-md-2">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <div class="mb-4" >
              <h3>Login</h3>
            </div>
            <form method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="clinic_email" id="username">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="clinic_password" id="password">
                
              </div>
              <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
              <div class="d-flex mb-5 align-items-center">
                <span class="ml-auto"><a href="forgot_password.php" class="forgot-pass">Forgot Password</a></span> 
              </div>
              <input type="submit" name="submit" value="Log In" class="btn btn-block btn-primary w-100">
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
  <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>


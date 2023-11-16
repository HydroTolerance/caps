<?php
include "../Client/client.php";
checklogin('Client', true);
$userData = [];
$isClientLoggedIn = isset($_SESSION['client_email']);
if ($isClientLoggedIn) {
    $userData = $_SESSION['id'];
}
?>

<?php
if (isset($_POST['submit'])) {
    $receivedOTP = $_POST['verificationCode'];
    $email = $_POST['email'];
    $currentTimestamp = time();
    include "../db_connect/config.php";
    $sql = "SELECT * FROM otp_codes WHERE email = ? AND code = ? AND expiration_time >= ? AND is_used = 0";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $email, $receivedOTP, $currentTimestamp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $updateSql = "UPDATE otp_codes SET is_used = 1 WHERE email = ? AND code = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ss", $email, $receivedOTP);
        mysqli_stmt_execute($updateStmt);

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $health = $_POST['health_concern'];
        $services = $_POST['services'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $currentdate = date("Y-m-d H:i:s");

        $reference = generateReferenceCode();
        $appointment_id = generateAppointmentID();
        $insertSql = "INSERT INTO zp_appointment (appointment_id, reference_code, firstname, lastname, number, email, health_concern, services, date, time, appointment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "ssssssssss", $appointment_id, $reference, $firstname, $lastname, $number, $email, $health, $services, $date, $time);

        if (mysqli_stmt_execute($insertStmt)) {
            $to = $email;
$subject = "Appointment Summary";
$body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }


        h1 {
            color: #6537AE;
        }
        p {
          font-size: 16px;
      }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 16px;
        }

        li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Z Skin Care Center</h1>
        <p>Dear $firstname $lastname,</p>
        <p>Thank you for scheduling your appointment with us!</p>
        <p>Here is a summary of your appointment details:</p>
        <ul>
            <li><strong>Name:</strong> $firstname $lastname</li>
            <li><strong>Phone number:</strong> $num</li>
            <li><strong>Email:</strong> $email</li>
            <li><strong>Health Concern:</strong> $message</li>
            <li><strong>Service:</strong> $option</li>
            <li><strong>Schedule Date:</strong> " . date("F j, Y", strtotime($d)) . "</li>
            <li><strong>Schedule Time:</strong> $time</li>
        </ul>
        <p style='font-weight: bold; font-size: 20px;'>Reference Code: $reference</p>
        <p>Thank you for your transaction! You can check your email for instructions on how to reschedule or cancel your appointment. Please note that rescheduling or cancelling of the appointment will only be possible within 2 weeks upon creating the appointment</p>
        <p><a href='https://zskincarecenter.online/t/reschedule.php?reference_code=$reference'>Tap Here to Reschedule or Cancel</a></p>
    </div>
</body>
</html>";

$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'blazered098@gmail.com';
$smtpPassword = 'nnhthgjzjbdpilbh';

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;

$mail->setFrom($smtpUsername, 'Z Skin Care Center');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = $body;

$imagePath = 'img/dermalogo.png';
$mail->addEmbeddedImage($imagePath, 'dermalogo.png', 'dermalogo.png');

$mailSent = $mail->send();

            if ($mailSent) {
                // Email sent successfully
                $_SESSION['authenticated'] = true; // Set a session variable
                $redirectUrl = "display.php?" .
                    "reference_code=" . urlencode($reference) .
                    "&firstname=" . urlencode($firstname) .
                    "&lastname=" . urlencode($lastname) .
                    "&number=" . urlencode($number) .
                    "&email=" . urlencode($email) .
                    "&health_concern=" . urlencode($health) .
                    "&services=" . urlencode($services) .
                    "&date=" . urlencode($date) .
                    "&time=" . urlencode($time) .
                    "&created=" . urlencode($currentdate);

                header("Location: $redirectUrl");
                exit;
            } else {
                // Email sending failed
                echo '<script>
                    console.log("JavaScript code is executing"); // Add this line for debugging
                    alert("Error sending confirmation email. Please contact support.");
                </script>';
            }
        } else {
            // Appointment creation failed
            echo '<script>
                console.log("JavaScript code is executing"); // Add this line for debugging
                alert("Error creating appointment. Please try again.");
            </script>';
        }
    } else {
        // Invalid OTP
        echo '<script>
            console.log("JavaScript code is executing"); // Add this line for debugging
            alert("Your OTP is incorrect or has already been used!");
        </script>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function generateReferenceCode()
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $reference = '';
    $length = 6;

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $reference .= $characters[$randomIndex];
    }

    return $reference;
}

function generateAppointmentID()
{
    $counterFile = 'appointment_counter.txt';
    $counter = file_get_contents($counterFile);
    $counter++;
    $appointmentID = 'apt#' . str_pad($counter, 3, '0', STR_PAD_LEFT);
    file_put_contents($counterFile, $counter);

    return $appointmentID;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@loadingio/loading-bar@0.1.1/dist/loading-bar.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">
<!-- Stylesheets -->
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6.3.1/dist/tippy-bundle.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../js/appointment.js"></script>
    <title>Appoinment</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
    background-color: #eee;
    /* Other main content styles */
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
        option:disabled {
            color: red;
        }
        option:enabled {
            cursor: pointer;
        }
        .error {
        color: #F00;
        font-size: 10px;
        }
        #pageloader {
    background: rgba(255, 255, 255, 0.8);
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
}

.custom-loader {
    border: 5px solid #6537AE;
    border-top: 5px solid transparent;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation-name: spin;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    margin: 0 auto;
    margin-top: 50vh;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
    fill: #eee;
}
.custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}
    </style>
</head>
<body style="background-color: #eee;">
<div id="pageloader">
    <div class="custom-loader"></div>
</div>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" href="../index.php">
    <img src="images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white fs-5" href="../index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="contact.php" id="s5">Contact</a>
        </li>
      </ul>
      <?php if ($isClientLoggedIn): ?>
        <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle me-3" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="../Client/client_record/view.php">Profile Account</a></li>
                    <li><a class="dropdown-item" href="../Client/logout.php">Sign out</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
        <?php endif; ?>
        <a href="booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
<main>
<section class="h-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-12">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-7 d-flex align-items-center">
              <div class=" px-3 py-4 p-md-5">
              <form action="" method="post" id="signUpForm" class="row g-3 needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-12">
                        <h3 class="fs-4 text-uppercase mb-4 text-center">Appointment Request form</h3>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First Name" name="firstname" required>
                        <div class="invalid-feedback">
                            Please enter your firstname.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                        <div class="invalid-feedback">
                            Please enter your lastname.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom03">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter Email" name="email" id="e" required>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="verificationCode">Verification Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="verificationCode" name="verificationCode" required pattern="[0-9]{6}">
                            <button type="button" id="requestVerificationCode" class="btn text-white rounded-end" style="background-color:#6537AE;">Request</button>
                            <div class="invalid-feedback">
                                Please input a valid 6-digit OTP.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom02">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number" required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                        <div class="invalid-feedback">
                        Please enter a valid phone number that starts with '09'.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Schedule Appointment Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required autocomplete="off">
                        <div class="invalid-feedback">
                            Please choose a date.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom05">Schedule Appointment Time<span class="text-danger">*</span></label>
                        <select class="form-control" name="time" id="time" required>
                        </select>
                        <div class="invalid-feedback">
                            Please enter your time.
                        </div>
                    </div>

                    <div class="col-md-6">
                    <label for="validationCustom06">Select Service<span class="text-danger">*</span></label>
                    <select class="select2 form-select" name="services" style="width: 100%;" required>
                        <option value=""></option>

                        <?php
                        include "../db_connect/config.php";
                        $stmt = mysqli_prepare($conn, "SELECT DISTINCT services FROM service");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $category);

                        while (mysqli_stmt_fetch($stmt)) {
                            echo '<optgroup label="' . $category . '">';
                            $stmt2 = mysqli_prepare($conn, "SELECT id, services, name, image, description FROM service WHERE services = ?");
                            mysqli_stmt_bind_param($stmt2, "s", $category);
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_store_result($stmt2);
                            mysqli_stmt_bind_result($stmt2, $id, $services, $name, $image, $description);

                            while (mysqli_stmt_fetch($stmt2)) {
                                echo '<option value="' . $name . '">' . $name . '</option>';
                            }
                            echo '</optgroup>';
                        }
                        ?>
                    </select>

                    <div class="invalid-feedback">
                            Please Select Services.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label>Health Complaint<span class="text-danger">*</span></label>
                        <textarea class="form-control" placeholder="Description" name="health_concern" required oninput="limitHealthConcern(this, 250);" onpaste="onPaste(event, this);"></textarea>
                        <div class="invalid-feedback">
                            Please enter your health complaint.
                        </div>
                        <div class="text-muted" id="wordCount">250 words remaining</div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                            <span><a href="terms_and_condition.php" class="text-dark text-decoration-none">I agree to the terms and conditions</a><span class="text-danger">*</span></span>
                            <div class="invalid-feedback">
                                You must agree to the terms and conditions to book an appointment.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">                        
                        <button type="submit" class="btn text-white float-end" name="submit" style="Background-color:#6537AE;">Book Appointment</button>
                        <button type="button" class="btn btn-secondary float-end me-2" id="clearFormButton">Clear Form</button>
                    </div>
                </div>
            </form>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="card-body mx-md-4 mt-3">            
                <div>
                        <div class="mb-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.983622552614!2d120.97964317502418!3d14.656870885836176!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5d44210563b%3A0xbffa6a071a665e60!2sZ%20Skin%20Care%20Center!5e0!3m2!1sen!2sph!4v1698127735993!5m2!1sen!2sph" width="800" height="400" style="max-width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                <div class="text-center mt-3">
                <h3 class="fs-4 text-uppercase"style="col;">Z-Skin Schedule</h3>
                    <?php
                        include "../db_connect/config.php";

                        // Fetch available days
                        $stmt = mysqli_prepare($conn, "SELECT day FROM availability WHERE is_available != '0'");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $day);
                        ?>
                        <div class="row">
                        <h4 class="fs-4 text-uppercase mt-3">Day Open</h4>
                            <?php while (mysqli_stmt_fetch($stmt)) { ?>
                                <div class="col-lg-4">
                                    <div class="">
                                        <p><?php echo $day; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <h3 class="fs-4 text-uppercase"style="col;">Time Open</h3>
                        <?php
                        $stmt = mysqli_prepare($conn, "SELECT slots FROM appointment_slots");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $time);

                        $startTime = null;
                        $endTime = null;

                        while (mysqli_stmt_fetch($stmt)) {
                            list($start, $end) = explode(" - ", $time);

                            if ($startTime === null || strtotime($start) < strtotime($startTime)) {
                                $startTime = $start;
                            }

                            if ($endTime === null || strtotime($end) > strtotime($endTime)) {
                                $endTime = $end;
                            }
                        }

                        $combinedTimeRange = $startTime . " - " . $endTime;
                        ?>
                        <div class="row">
                            <div class="d-flex align-items-center justify-content-center">
                                <p><?php echo $combinedTimeRange; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


</main>

<footer >
<div class="mt-5">
    <footer class="footer">
      <svg class="footer-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 100" preserveAspectRatio="none">
        <path class="footer-wave-path" d="M851.8,100c125,0,288.3-45,348.2-64V0H0v44c3.7-1,7.3-1.9,11-2.9C80.7,22,151.7,10.8,223.5,6.3C276.7,2.9,330,4,383,9.8 c52.2,5.7,103.3,16.2,153.4,32.8C623.9,71.3,726.8,100,851.8,100z"></path>
      </svg>
<div style="background-color: #6537AE; width: 100%; top: 20px">
  <div class="container text-white py-5" style="background-color: #6537AE;">
        <div class="row">
          <div class="col-lg-4">
              <div>
                <h2 style="font-family: Lora;">Z-SKIN</h2>
                  <p>Care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention
                  </p>
              </div>
          </div>
          <div class="col-lg-2">
            <div>
              <h2 style="font-family: Lora;">Navigation</h2>
              <ul class="list-unstyled">
                <li>
                  <a href="#" class="text-white">About Us</a>
                </li>
                <li>
                  <a href="#" class="text-white">Services</a>
                </li>
                <li>
                  <a href="#" class="text-white">Faq</a>
                </li>
                <li>
                  <a href="#" class="text-white">Contact Us</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 style="font-family: Lora;"> Legal</h2>
              <ul class="list-unstyled">
                <li>
                  <a href="#" class="text-white">Terms and Condition</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div>
              <h2 style="font-family: Lora;">Social Media</h2>
              <ul class="list-unstyled">
                <li>
                <a>
                    <i class="bi bi-facebook text-white me-2"> </i>
                    Facebook</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
          <h2 style="font-family: Lora;">Address</h2>
            <p>Address: Unit 4 One Kalayaan Place Building 284 Samson Road Victory Liner Compound, Caloocan, Philippines</p>
            <p> You can Contact Us</p>
            <p>Phone: 0915 759 2213</p>
            <p >Email: zskincarecenter @gmail.com</p>
          </div>
          </div>
          <div>
            
  </div>
</div>
</footer>
<div class=" text-center text-white p-1" style="background-color: #c23fe3;"> ©2023. | Z-Skin | All rights reserved. </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@loadingio/loading-bar@0.1.1/dist/loading-bar.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" async></script>
<script>
$(document).ready(function() {
    $('#requestVerificationCode').on('click', function() {
        var email = $('#e').val();
        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email field cannot be empty.'
            });
            return;
        }
        Swal.fire({
          imageUrl: 'images/loading.gif',
          imageWidth: 100,
          imageHeight: 100,
            title: 'Sending Verification Code',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: 'code.php',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Verification code sent successfully. Check your email.'
                    });
                    $('#verificationCode').val(response.verificationCode);
                } else {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to send verification code. Error: ' + response.error
                    });
                }
            }
        });
    });
});

</script>

<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
    <script>
$(document).ready(function() {
  $("#signUpForm").on("submit", function(e) {
    if (this.checkValidity()) {
      $("#pageloader").fadeIn();
    } else {
      e.preventDefault();
    }
  });
});
    </script>
<script>
      function validateInput(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 11) {
            inputElement.value = inputElement.value.slice(0, 11);
        }
    };
function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var slots = response.slots;
            var slotsLeft = response.slots_left;

            for (var slot in slots) {
                var option = document.createElement("option");
                option.value = slot;
                option.text = slot;
                var num_bookings = slots[slot];
                var slotsLeftForOption = slotsLeft - num_bookings;
                if (slotsLeftForOption <= 0) {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                time.add(option);
                var slotText = option.text + " (" + slotsLeftForOption + " slot(s) left)";
                option.text = slotText;
            }

            var num_slots = Object.keys(slots).length;
            document.getElementById("num_slots").innerHTML = " (" + num_slots + " slots available)";
        }
    };
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(d), true);
    xmlhttp.send();
}

</script>
<?php
include "../db_connect/config.php";

$sql = "SELECT day_to_disable FROM disabled_days";
$result = $conn->query($sql);
$disableDates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disableDates[] = $row['day_to_disable'];
    }
}
$sql = "SELECT day, is_available FROM availability";
$result = $conn->query($sql);
$disableDays = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['is_available'] == 0) {
            $disableDays[] = $row['day'];
        }
    }
}

$conn->close();
?>
<script>
    var configuration = {
        dateFormat: "Y-m-d",
        allowInput: true,
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(60),
        "disable": [
            function(date) {
                date.setHours(23, 59, 59, 999);
                var dateString = date.toISOString().split('T')[0];
                var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                
                return <?php echo json_encode($disableDates); ?>.includes(dateString) ||
                       <?php echo json_encode($disableDays); ?>.includes(dayName[date.getDay()]);
            },
        ]
    };

    flatpickr("#d", configuration);

</script>


<script>
function showReminderAlert() {
  Swal.fire({
  icon: 'info',
  title: 'Important Reminders',
  html: '<div class="text-start"> 1. Minors cannot book appointments.<br>' +
    '2. If an authorized representative is making the appointment, they must present an original authorization letter and a valid ID.<br>' +
    '3. Ensure accurate information for the applicant or authorized representative. .<br>' +
    '4. Appointments are allocated on a first-come, first-served basis.</div?',
  confirmButtonColor: '#6537AE',
  showClass: {
    html: 'text-start'
  },
});
}

document.querySelector('input[type="checkbox"]').addEventListener('change', function () {
  if (this.checked) {
    showReminderAlert();
  }
});

</script>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: {
            id: '',
            text: 'None Selected'
        },
        theme: 'bootstrap-5',
        allowClear: true
    });
});
</script>
<script>
function limitHealthConcern(textarea, maxWords) {
    let text = textarea.value;
    let words = text.split(/\s+/);
    if (words.length > maxWords) {
        words = words.slice(0, maxWords);
        textarea.value = words.join(" ");
    }
    let wordsRemaining = maxWords - words.length;
    let wordCountElement = document.getElementById("wordCount");
    wordCountElement.textContent = wordsRemaining + " words remaining";
}

function onPaste(event, textarea) {
    setTimeout(function () {
        limitHealthConcern(textarea, 250);
    }, 0);
}
</script>

<script>

function clearFormFields() {
    document.getElementById('signUpForm').reset();
    const textarea = document.getElementById('healthComplaint');
    textarea.value = ''; // Clear the textarea
    textarea.disabled = false;
    limitHealthConcern(textarea, 250); // Reset word count
}


document.getElementById('clearFormButton').addEventListener('click', clearFormFields);

</script>





</body>
</html>
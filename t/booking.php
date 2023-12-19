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
    date_default_timezone_set('Asia/Manila');
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
        $insertSql = "INSERT INTO zp_appointment (appointment_id, reference_code, firstname, lastname, number, email, health_concern, services, date, time, created, appointment_status, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";
        if (isset($userData['id'])) {
            $client_id = $userData['id'];
        } else {
            // User is not logged in, set client_id to a default value (e.g., empty string)
            $client_id = '';
        }
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "ssssssssssss", $appointment_id, $reference, $firstname, $lastname, $number, $email, $health, $services, $date, $time, $currentdate, $client_id);

        if (mysqli_stmt_execute($insertStmt)) {
            date_default_timezone_set('Asia/Manila');
            $lastInsertedId = mysqli_insert_id($conn);
            $currentDate = date("Y-m-d H:i:s");
            $notificationMessage = "<strong>Appointment Created: </strong>" . mysqli_real_escape_string($conn, $firstname) . " " . mysqli_real_escape_string($conn, $lastname);
            $notificationSql = "INSERT INTO notifications (message, appointment_id, created_at) VALUES (?, ?, ?)";
            $notificationStmt = mysqli_prepare($conn, $notificationSql);
            mysqli_stmt_bind_param($notificationStmt, "sss", $notificationMessage, $lastInsertedId, $currentDate);
            mysqli_stmt_execute($notificationStmt);
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
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
            <li><strong>Phone number:</strong> $number</li>
            <li><strong>Email:</strong> $email</li>
            <li><strong>Service:</strong> $services</li>
            <li><strong>Schedule Date:</strong> " . date("F j, Y", strtotime($date)) . "</li>
            <li><strong>Schedule Time:</strong> $time</li>
            <li><strong>Health Concern:</strong> $health</li>
        </ul>
        <p style='font-weight: bold; font-size: 20px;'>Reference Code: $reference</p>
        <p>Thank you for your transaction. Please note that rescheduling your appointment is limited to 5 attempts, and cancelling is allowed only once. To proceed with rescheduling or cancelling, <a href='https://zephyderm.infinityfreeapp.com/t/reschedule.php?reference_code=$reference'>tap here.</a></p>
        <p>Z Skin Care Center will need to <strong>acknowledge</strong> your requested date and time in order to confirm your appointment. Please note that this reference code will be used for your appointment.</p>
        <p style='color: #888; margin-top: 20px;'>This is an automated email, please do not reply.</p>
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
    $currentYear = date('Y');
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomLetters = '';
    $letterLength = 3;

    for ($i = 0; $i < $letterLength; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $randomLetters .= $characters[$randomIndex];
    }
    $counterFile = 'reference_counter.txt';
    $incrementNumber = file_get_contents($counterFile);
    if ($currentYear != substr($incrementNumber, 0, 4)) {
        $incrementNumber = sprintf('%s%05d', $currentYear, 1);
    } else {
        $incrementNumber++;
    }
    file_put_contents($counterFile, $incrementNumber);
    $reference = sprintf('%s-%s-%05d', $currentYear, $randomLetters, substr($incrementNumber, 4));

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
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader {

        margin: 0 auto;
        margin-top: 35vh;
    }

    /* FlipX animation for the custom-loader and the image */
    @keyframes flipX {
        0% {
            transform: scaleX(1);
        }
        50% {
            transform: scaleX(-1);
        }
        100% {
            transform: scaleX(1);
        }
    }

    .flipX-animation {
        animation-name: flipX;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
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
    <div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
    <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
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
          <a class="nav-link text-white fs-5" href="about.php" id="s5">About Us</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="contact.php" id="s5">Contact Us</a>
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
              <form action="" method="post" id="signUpForm" class="needs-validation" novalidate>
                <div class="row g-3">
                    <?php
                    if (isset($_GET['service_id']) && isset($_GET['service_name'])) {
                        $service_id = $_GET['service_id'];
                        $service_name = urldecode($_GET['service_name']);
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Well done!</h4>
                                <p>The service <strong>' . $service_name . '</strong> has been selected.</p>
                                <hr>
                                <p class="mb-0">You can continue with your booking process.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                    ?>
                    <div class="col-12">
                        <h3 class="text-uppercase text-center" style="font-family: Lora;">Appointment Request form</h3>
                        <p class="text-muted text-center">All times are in Manila Time</p>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Enter your first name" name="firstname" value="<?php echo isset($userData['client_firstname']) ? $userData['client_firstname'] : ''; ?>" <?php echo isset($userData['client_firstname']) ? 'readonly' : ''; ?> required>
                        <div class="invalid-feedback">
                            Please enter your firstname.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom01">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter your last name" name="lastname" value="<?php echo isset($userData['client_lastname']) ? $userData['client_lastname'] : ''; ?>" <?php echo isset($userData['client_lastname']) ? 'readonly' : ''; ?> required>
                        <div class="invalid-feedback">
                            Please enter your lastname.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom03">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter your email" name="email" id="e" value="<?php echo isset($userData['client_email']) ? $userData['client_email'] : ''; ?>" <?php echo isset($userData['client_email']) ? 'readonly' : ''; ?> required>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="verificationCode">Verification Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="verificationCode" name="verificationCode" placeholder="Enter your OTP" required pattern="[0-9]{6}" maxlength="6" oninput="validateNum(this)">
                            <button type="button" id="requestVerificationCode" class="btn text-white rounded-end" style="background-color:#6537AE;">Request</button>
                            <div class="invalid-feedback">
                                Please input a valid 6-digit OTP.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom02">Phone Number (Optional)</label>
                        <input type="tel" class="form-control" id="number" placeholder="Enter your phone number"  name="number"pattern="09[0-9]{9}" value="<?php echo isset($userData['client_number']) ? $userData['client_number'] : ''; ?>" <?php echo isset($userData['client_number']) ? 'readonly' : ''; ?> oninput="validateInput(this)">
                        <div class="invalid-feedback">
                        Please enter a valid phone number that starts with '09'.
                        </div>
                    </div>
                    <div class="col-md-6">
                    <label for="validationCustom06">Select Service<span class="text-danger">*</span></label>
                    <select class="select2 form-select" name="services" style="width: 100%;" required>
                        <option value=""></option>

                        <?php
                        include "../db_connect/config.php";
                        $selectedService = isset($_GET['service_name']) ? urldecode($_GET['service_name']) : '';
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
                                $selected = ($selectedService == $name) ? 'selected' : '';
                                echo '<option value="' . $name . '" ' . $selected . '>' . $name . '</option>';
                            }

                            echo '</optgroup>';
                        }

                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        ?>
                    </select>


                    <div class="invalid-feedback">
                            Please Select Services.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Schedule Appointment Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required autocomplete="off" readonly>
                        <div class="invalid-feedback">
                            Please choose a date.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                <label for="validationCustom05">Schedule Appointment Time<span class="text-danger">*</span></label>
                <select class="form-control" name="time" id="time" required>
                </select>
                <div class="invalid-feedback">
                    Please enter your time.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
                    
                    

                    <div class="col-md-12">
                        <label>Health Concern (optional)</label>
                        <textarea class="form-control" placeholder="Description" name="health_concern" oninput="limitHealthConcern(this, 1700);" onpaste="onPaste(event, this);" rows="10"></textarea>
                        <div class="invalid-feedback">
                            Please enter your health complaint.
                        </div>
                        <div class="text-muted" id="characterCount">1700 characters remaining</div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                            <span>I agree to the <a href="terms_and_condition.php" class="text-dark">terms and conditions</a><span class="text-danger">*</span></span>
                            <div class="invalid-feedback">
                                You must agree to the terms and conditions to book an appointment.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-muted text-center" id="characterCount">Z Skin Care Center will need to acknowledge your requested date and time in order to confirm your appointment</div>
                    </div>
                    <div class="col-md-12 mt-5">                        
                        <button type="submit" class="btn text-white float-end" name="submit" style="Background-color:#6537AE;">Book Appointment</button>
                        <button type="button" class="btn btn-secondary float-end me-2" id="clearFormButton">Clear Form</button>
                    </div>
                </div>
            </form>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="card-body"> 
                <div class="text-center border">
                    <h2 style="font-family: Lora;" class="mt-3">Z SKIN CARE CENTER</h3>
                            <div class="row">
                            <h3 class="mt-3" style="font-family: Lora;">DAYS OPEN</h4>
                                <p>Monday, Wenesday, Friday and Saturday</p>
                            </div>
                            <h3 class=""style="font-family: Lora;">TIME OPEN</h3>
                            <p>Around 1:00 PM to 5:00 PM</p>
                        </div>
                    </div>
                    <div class="mb-4 px-3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.983622552614!2d120.97964317502418!3d14.656870885836176!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5d44210563b%3A0xbffa6a071a665e60!2sZ%20Skin%20Care%20Center!5e0!3m2!1sen!2sph!4v1698127735993!5m2!1sen!2sph" width="900" height="500" style="max-width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>         
                    <div>
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
                <h2 style="font-family: Lora;">Z SKIN CARE CENTER</h2>
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
                  <a href="about.php" class="text-white">About Us</a>
                </li>
                <li>
                  <a href="service.php" class="text-white">Services</a>
                </li>
                <li>
                  <a href="FAQ.php" class="text-white">FAQ</a>
                </li>
                <li>
                  <a href="contact.php" class="text-white">Contact Us</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 style="font-family: Lora;"> Legal</h2>
              <ul class="list-unstyled">
                <li>
                  <a href="terms_and_condition.php" class="text-white">Terms and Condition</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div>
              <h2 style="font-family: Lora;">Social Media</h2>
              <ul class="list-unstyled">
                <li>
                <a href="https://www.facebook.com/Zskincarecenter" class="text-white">
                    <i class="bi bi-facebook text-white me-2"></i>
                    Facebook</a>
                </li>
                <li>
                <a href="https://www.instagram.com/zskincarecenter" class="text-white">
                    <i class="bi bi-instagram text-white me-2"></i>
                    Instagram</a>
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
<div class=" text-center text-white p-1" style="background-color: #c23fe3;"> © 2023 Z Skin Care Center. All Rights Reserved. </div>

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
            text: 'The OTP code will be sending to your Email',
            showConfirmButton: false,
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
    function validateNum(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 6) {
            inputElement.value = inputElement.value.slice(0, 6);
        }
    };
    function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";

    // Get current time
    var currentTime = new Date();
    var currentHours = currentTime.getHours();
    var currentMinutes = currentTime.getMinutes();
    var currentTotalMinutes = currentHours * 60 + currentMinutes;

    // Set the time limits
    var limit1Hours = 13;
    var limit1Minutes = 0;
    var limit1TotalMinutes = limit1Hours * 60 + limit1Minutes;

    var limit2Hours = 13;
    var limit2Minutes = 30;
    var limit2TotalMinutes = limit2Hours * 60 + limit2Minutes;

    var limit3Hours = 14;
    var limit3Minutes = 0;
    var limit3TotalMinutes = limit3Hours * 60 + limit3Minutes;
    
    var limit4Hours = 14;
    var limit4Minutes = 30;
    var limit4TotalMinutes = limit4Hours * 60 + limit4Minutes;
    
    var limit5Hours = 15;
    var limit5Minutes = 0;
    var limit5TotalMinutes = limit5Hours * 60 + limit5Minutes;

    var limit6Hours = 15;
    var limit6Minutes = 30;
    
    var limit6TotalMinutes = limit6Hours * 60 + limit6Minutes;

    var limit7Hours = 16;
    var limit7Minutes = 0;
    var limit7TotalMinutes = limit7Hours * 60 + limit7Minutes;

    // Check if the current time is beyond the limits
    var disableAllSlots1 = currentTotalMinutes > limit1TotalMinutes;
    var disableAllSlots2 = currentTotalMinutes > limit2TotalMinutes;
    var disableAllSlots3 = currentTotalMinutes > limit3TotalMinutes;
    var disableAllSlots4 = currentTotalMinutes > limit4TotalMinutes;
    var disableAllSlots5 = currentTotalMinutes > limit5TotalMinutes;
    var disableAllSlots6 = currentTotalMinutes > limit6TotalMinutes;
    var disableAllSlots7 = currentTotalMinutes > limit7TotalMinutes;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
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

                // Disable slots based on different time limits
                var currentDate = new Date();
                var selectedDate = new Date(d);
                var isCurrentDay = currentDate.toDateString() === selectedDate.toDateString();

                if (disableAllSlots1 && isCurrentDay && slot == "1:00 PM - 1:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }

                if (disableAllSlots2 && isCurrentDay && slot == "1:30 PM - 2:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots3 && isCurrentDay && slot == "2:00 PM - 2:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots4 && isCurrentDay && slot == "2:30 PM - 3:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots5 && isCurrentDay && slot == "3:00 PM - 3:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots6 && isCurrentDay && slot == "3:30 PM - 4:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots6 && isCurrentDay && slot == "4:00 PM - 4:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }

                // Add more conditions for additional time limits

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
        minDate: new Date().fp_incr(0),
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
    $('#d').on('focus', ({ currentTarget }) => $(currentTarget).blur())
$("#d").prop('readonly', false)
</script>


<script>
function showReminderAlert() {
  Swal.fire({
  icon: 'info',
  title: 'Important Reminders',
  html: '<div class="text-start"> 1. Arrived at least 10 mins. before the scheduled appointment.<br>' +
    '2. All patients and their companions are required to wear masks at all times.<br>' +
    '3. Observe 1 patient - 1 companion policy for minors (<18 y/o), PWD, & seniors.<br>' +
    '4. Patients with cough, colds, and fever are highly encouraged to reschedule their appointment.</div>',
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
    });
});
</script>
<script>
function limitHealthConcern(textarea, maxCharacters) {
    let text = textarea.value;
    if (text.length > maxCharacters) {
        textarea.value = text.slice(0, maxCharacters);
    }
    let charactersRemaining = maxCharacters - textarea.value.length;
    let characterCountElement = document.getElementById("characterCount");
    characterCountElement.textContent = charactersRemaining + " characters remaining";
}

function onPaste(event, textarea) {
    setTimeout(function () {
        limitHealthConcern(textarea, 1700);
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
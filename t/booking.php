<?php
session_start();

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $health = $_POST['health_concern'];
    $services = $_POST['services'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    include "../db_connect/config.php";

    $reference = generateReferenceCode();
    $appointment_id = generateAppointmentID();
    $currentTimestamp = date("Y-m-d H:i:s");

    $insertSql = "INSERT INTO zp_appointment (appointment_id, reference_code, firstname, lastname, number, email, health_concern, services, date, time, appointment_status, created ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";
    $insertStmt = mysqli_prepare($conn, $insertSql);
    mysqli_stmt_bind_param($insertStmt, "sssssssssss", $appointment_id, $reference, $firstname, $lastname, $number, $email, $health, $services, $date, $time, $currentTimestamp);

    if (mysqli_stmt_execute($insertStmt)) {
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
    "&created=" . urlencode($currentTimestamp);

        header("Location: $redirectUrl");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_stmt_close($insertStmt);
    mysqli_close($conn);
}

function generateReferenceCode() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $reference = '';
    $length = 6;

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $reference .= $characters[$randomIndex];
    }

    return $reference;
}

function generateAppointmentID() {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@loadingio/loading-bar@0.1.1/dist/loading-bar.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <script src="../js/appointment.js"></script>
    <title>Document</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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

        .header {
        background-color: #eee;
        color: white;
        padding: 10px;
        text-align: center;
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

.footer-content {
    margin-left: auto;
    margin-right: auto;
    max-width: 1230px;
    padding: 40px 15px 450px;
    position: relative;
}

.footer-content-column {
    box-sizing: border-box;
    float: left;
    padding-left: 15px;
    padding-right: 15px;
    width: 100%;
    color: #fff;
}

.footer-content-column ul li a {
  color: #fff;
  text-decoration: none;
}

.footer-logo-link {
    display: inline-block;
}
.footer-menu {
    margin-top: 30px;
}

.footer-menu-name {
    color: #fffff2;
    font-size: 15px;
    font-weight: 900;
    letter-spacing: .1em;
    line-height: 18px;
    margin-bottom: 0;
    margin-top: 0;
    text-transform: uppercase;
}
.footer-menu-list {
    list-style: none;
    margin-bottom: 0;
    margin-top: 10px;
    padding-left: 0;
}
.footer-menu-list li {
    margin-top: 5px;
}

.footer-call-to-action-description {
    color: #fffff2;
    margin-top: 10px;
    margin-bottom: 20px;
}
.footer-call-to-action-button:hover {
    background-color: #fffff2;
    color: #00bef0;
}
.button:last-of-type {
    margin-right: 0;
}
.footer-call-to-action-button {
    background-color: #027b9a;
    border-radius: 21px;
    color: #fffff2;
    display: inline-block;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .1em;
    line-height: 18px;
    padding: 12px 30px;
    margin: 0 10px 10px 0;
    text-decoration: none;
    text-transform: uppercase;
    transition: background-color .2s;
    cursor: pointer;
    position: relative;
}
.footer-call-to-action {
    margin-top: 30px;
}
.footer-call-to-action-title {
    color: #fffff2;
    font-size: 14px;
    font-weight: 900;
    letter-spacing: .1em;
    line-height: 18px;
    margin-bottom: 0;
    margin-top: 0;
    text-transform: uppercase;
}
.footer-call-to-action-link-wrapper {
    margin-bottom: 0;
    margin-top: 10px;
    color: #fff;
    text-decoration: none;
}
.footer-call-to-action-link-wrapper a {
    color: #fff;
    text-decoration: none;
}





.footer-social-links {
    bottom: 0;
    height: 54px;
    position: absolute;
    right: 0;
    width: 236px;
}

.footer-social-amoeba-svg {
    height: 54px;
    left: 0;
    display: block;
    position: absolute;
    top: 0;
    width: 236px;
}

.footer-social-amoeba-path {
    fill: #027b9a;
}

.footer-social-link.linkedin {
    height: 26px;
    left: 3px;
    top: 11px;
    width: 26px;
}

.footer-social-link {
    display: block;
    padding: 10px;
    position: absolute;
}

.hidden-link-text {
    position: absolute;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px,1px,1px,1px);
    -webkit-clip-path: inset(0px 0px 99.9% 99.9%);
    clip-path: inset(0px 0px 99.9% 99.9%);
    overflow: hidden;
    height: 1px;
    width: 1px;
    padding: 0;
    border: 0;
    top: 50%;
}

.footer-social-icon-svg {
    display: block;
    
}

.footer-social-icon-path {
    fill: #fffff2;
    transition: fill .2s;
}

.footer-social-link.twitter {
    height: 28px;
    left: 62px;
    top: 3px;
    width: 28px;
}

.footer-social-link.youtube {
    height: 24px;
    left: 123px;
    top: 12px;
    width: 24px;
}

.footer-social-link.github {
    height: 34px;
    left: 172px;
    top: 7px;
    width: 34px;
}

.footer-copyright {
    background-color: #c23fe3;
    color: #fff;
    padding: 15px 30px;
  text-align: center;
}

.footer-copyright-wrapper {
    margin-left: auto;
    margin-right: auto;
    max-width: 1200px;
}

.footer-copyright-text {
  color: #fff;
    font-size: 13px;
    font-weight: 400;
    line-height: 18px;
    margin-bottom: 0;
    margin-top: 0;
}

.footer-copyright-link {
    color: #fff;
    text-decoration: none;
}







/* Media Query For different screens */
@media (min-width:320px) and (max-width:479px)  { /* smartphones, portrait iPhone, portrait 480x320 phones (Android) */
  .footer-content {
    margin-left: auto;
    margin-right: auto;
    max-width: 1230px;
    padding: 40px 15px 1050px;
    position: relative;
  }
}
@media (min-width:480px) and (max-width:599px)  { /* smartphones, Android phones, landscape iPhone */
  .footer-content {
    margin-left: auto;
    margin-right: auto;
    max-width: 1230px;
    padding: 40px 15px 1050px;
    position: relative;
  }
}
@media (min-width:600px) and (max-width: 800px)  { /* portrait tablets, portrait iPad, e-readers (Nook/Kindle), landscape 800x480 phones (Android) */
  .footer-content {
    margin-left: auto;
    margin-right: auto;
    max-width: 1230px;
    padding: 40px 15px 1050px;
    position: relative;
  }
}
@media (min-width:801px)  { /* tablet, landscape iPad, lo-res laptops ands desktops */

}
@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */

}
@media (min-width:1281px) { /* hi-res laptops and desktops */

}




@media (min-width: 1025px) {
  .footer-content {
      margin-left: auto;
      margin-right: auto;
      max-width: 1030px;
      padding: 20px 15px 450px;
      position: relative;
  }

  .footer-wave-svg {
      height: 50px;
  }

  .footer-content-column {
      width: 24.99%;
  }
}
@media (min-width: 568px) {
  /* .footer-content-column {
      width: 49.99%;
  } */
}

* {
box-sizing: border-box;
}

body,
html {
overflow-x: hidden;
}


a {
text-decoration: none;
transition: all 0.5s ease-in-out;
}

a:hover {
transition: all 0.5s ease-in-out;
}

.we-are-block {
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
flex-wrap: nowrap;
width: 100%;
height: 900px;
}

@media screen and (max-width: 860px) {
.we-are-block {
height: 2200px;
}
}

@media screen and (max-width: 500px) {
.we-are-block {
height: 2300px;
}
}

#about-us-section {
background: #6537AE;
width: 100%;
height: 50%;
display: flex;
flex-direction: row;
flex-wrap: nowrap;
align-items: center;
justify-content: center;
position: relative;
}

@media screen and (max-width: 860px) {
#about-us-section {
flex-direction: column;
justify-content: space-between;
}
}

.about-us-image {
position: absolute;
top: 0;
right: 0;
height: 100%;
overflow: hidden;
}

@media screen and (max-width: 860px) {
.about-us-image {
position: relative;
width: 100%;
height: 45%;
}
}

@media screen and (max-width: 747px) {
.about-us-image {
height: 35%;
}
}

@media screen and (max-width: 644px) {
.about-us-image img {
position: absolute;
left: -220px;
}
}

.about-us-info {
display: flex;
flex-direction: column;
align-items: flex-end;
justify-content: space-evenly;
width: 40%;
height: 80%;
margin-right: 850px;
margin-left: 12px;
z-index: 2;
}

@media screen and (max-width: 1353px) {
.about-us-info {
margin-right: 400px;
width: 60%;
background: #6537AE99;
padding: 0px 25px 0px 0px;
}
}

@media screen and (max-width: 1238px) {
.about-us-info {
margin-right: 340px;
width: 100%;
}
}

@media screen and (max-width: 1111px) {
.about-us-info {
margin-right: 270px;
}
}

@media screen and (max-width: 910px) {
.about-us-info {
margin-right: 150px;
}
}

@media screen and (max-width: 860px) {
.about-us-info {
margin: 0px 0px 0px 0px !important;
padding: 0px 20px 0px 20px !important;
width: 100%;
height: 55%;
align-items: center;
}
}

@media screen and (max-width: 747px) {
.about-us-info {
height: 65%;
}
}

.about-us-info h2 {
color: white;
font-size: 40pt;
text-align: right;
}

@media screen and (max-width: 860px) {
.about-us-info h2 {
text-align: center;
}
}

.about-us-info p {
color: white;
font-size: 14pt;
text-align: right;
}

@media screen and (max-width: 860px) {
.about-us-info p {
text-align: center;
}
}



#history-section {
width: 100%;
height: 50%;
display: flex;
flex-direction: row;
flex-wrap: nowrap;
align-items: center;
justify-content: center;
position: relative;
}

@media screen and (max-width: 860px) {
#history-section {
flex-direction: column;
justify-content: space-between;
}
}

.history-image {
position: absolute;
top: 0;
left: 0;
max-width: 820px;
height: 100%;
overflow: hidden;
}

@media screen and (max-width: 860px) {
.history-image {
position: relative;
width: 100%;
height: 40%;
}
}

@media screen and (max-width: 747px) {
.history-image {
height: 35%;
}
}

@media screen and (max-width: 644px) {
.history-image img {
position: absolute;
right: -220px;
}
}

.history-info {
display: flex;
flex-direction: column;
align-items: flex-start;
justify-content: space-evenly;
width: 40%;
height: 80%;
margin-left: 850px;
margin-right: 12px;
z-index: 2;
}

@media screen and (max-width: 1353px) {
.history-info {
margin-left: 400px;
width: 60%;
background: #ffffff99;
padding: 0px 0px 0px 25px;
}
}

@media screen and (max-width: 1238px) {
.history-info {
margin-left: 340px;
width: 100%;
}
}

@media screen and (max-width: 1111px) {
.history-info {
margin-left: 270px;
}
}

@media screen and (max-width: 910px) {
.history-info {
margin-left: 150px;
}
}

@media screen and (max-width: 860px) {
.history-info {
margin: 0px 0px 0px 0px !important;
padding: 0px 40px 0px 40px !important;
width: 100%;
height: 60%;
align-items: center;
}
}

@media screen and (max-width: 747px) {
.history-info {
height: 65%;
}
}

.history-info h2 {
color: #6537AE;
font-size: 40pt;
text-align: left;
}

@media screen and (max-width: 860px) {
.history-info h2 {
text-align: center;
}
}

.history-info p {
color: #6537AE;
font-size: 14pt;
text-align: left;
}

@media screen and (max-width: 860px) {
.history-info p {
text-align: center;
}
}

.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
.select2-results__option { 
  font-size: 14px;
}

li {
    font-size: 20px;
}
    </style>
</head>
<body style="background-color: #eee;">
<div id="pageloader">
    <div class="custom-loader"></div>
</div>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" style="margin-right: 37px;" href="../index.php">
    <img src="images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon text-white"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white" href="../index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="contact.php" id="s5">Contact</a>
        </li>
      </ul>
      <a href="../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
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
                        <label for="validationCustom02">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number" required>
                        <div class="invalid-feedback">
                            Please enter your number.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Schedule Appointment Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required>
                        <div class="invalid-feedback">
                            Please choose a date.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom05">Schedule Appointment Time<span class="text-danger">*</span></label>
                        <select class="form-control" name="time" id="time" placeholder="Enter Time Appointment" required></select>
                        <div class="invalid-feedback">
                            Please enter your time.
                        </div>
                    </div>

                    <div class="col-6">
                    <label for="validationCustom06">Select Service<span class="text-danger">*</span></label>
                    <select class="select2 form-select" name="services" style="width: 100%;"  required>
                        <option value=""></option>
                        <optgroup label="HAIR">
                            <option value="hair-face">Face-to-face Hair Consultation</option>
                            <option value="hair-removal">Laser Hair Removal</option>
                            <option value="hair-prp">Platelet Rich Plasma</option>
                        </optgroup>
                        <optgroup label="NAIL">
                            <option value="nail-face">Face-to-face Nail Consultation</option>
                        </optgroup>
                        <optgroup label="SKIN">
                            <option value="skin-face">Face-to-face Skin Consultation</option>
                        </optgroup>
                        <optgroup label="OTHER SERVICES">
                            <option value="HIFU">HIFU</option>
                            <option value="Skin biopsy">Skin biopsy</option>
                            <option value="Cryolipolysis">Cryolipolysis</option>
                            <option value="Mohs Microhraphic Surgery">Mohs Microhraphic Surgery</option>
                            <option value="Platelet Rich Plasma">Platelet Rich Plasma</option>
                            <option value="Warts, Milia Removal">Warts, Milia Removal</option>
                            <option value="Chemical Peel">Chemical Peel</option>
                            <option value="Syringoma Removal">Syringoma Removal</option>
                            <option value="Tattoo Removal">Tattoo Removal</option>
                            <option value="Dermalux - LED Phototherapy">Dermalux - LED Phototherapy</option>
                            <option value="Acne Treatment">Acne Treatment</option>
                            <option value="Double Chin treatment">Double Chin treatment</option>
                            <option value="Botulinum toxin injection">Botulinum toxin injection</option>
                            <option value="Ear Keloid Removal">Ear Keloid Removal</option>
                            <option value="Excision of ear keloid">Excision of ear keloid</option>
                            <option value="Treatment for Excessive Sweating">Treatment for Excessive Sweating</option>
                            <option value="Sclerotherapy">Sclerotherapy</option>
                            <option value="Mole Removal">Mole Removal</option>
                            <option value="Melasma treatment">Melasma treatment</option>
                            <option value="Fractional CO2 laser">Fractional CO2 laser</option>
                            <option value="Easy TCA Peel">Easy TCA Peel</option>
                            <option value="Cyst / Tumor Excision">Cyst / Tumor Excision</option>
                            <option value="Electrocautery, Laser">Electrocautery, Laser</option>
                            <option value="Power Peel">Power Peel</option>
                        </optgroup>
                    </select>
                    <div class="invalid-feedback">
                            Please Select Services.
                        </div>
                    </div>
                    <div class="col-12">
                        <label>Health Complaint<span class="text-danger">*</span></label>
                        <textarea class="form-control" placeholder="Health Complaint" name="health_concern" required></textarea>
                        <div class="invalid-feedback">
                            Please enter your health complaint.
                        </div>
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
                        <a href="home.php"><button type="button" class="btn btn-outline-secondary float-end me-2">Cancel</button></a>
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
                        // Combine time slots
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

<div class="pg-footer" id="s1">
    <footer class="footer">
      <svg class="footer-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 100" preserveAspectRatio="none">
        <path class="footer-wave-path" d="M851.8,100c125,0,288.3-45,348.2-64V0H0v44c3.7-1,7.3-1.9,11-2.9C80.7,22,151.7,10.8,223.5,6.3C276.7,2.9,330,4,383,9.8 c52.2,5.7,103.3,16.2,153.4,32.8C623.9,71.3,726.8,100,851.8,100z"></path>
      </svg>
      <div class="footer-content">
        <div class="footer-content-column">
          <div class="footer-logo">
            <a class="footer-logo-link text-white" href="#" style="text-decoration: none;">
              <span class="hidden-link-text"></span>
              <h1 >Z-SKIN</h1>
            </a>
          </div>
          <div class="footer-menu">
            <h2 class="footer-menu-name">Get Started</h2>
            <ul id="menu-get-started" class="footer-menu-list">
            <p>Care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention</p>
            </ul>
          </div>
        </div>
        <div class="footer-content-column">
          <div class="footer-menu">
            <h2 class="footer-menu-name">Navigation</h2>
            <ul id="menu-company" class="footer-menu-list">
              <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a href="#">About Us</a>
              </li>
              <li class="menu-item menu-item-type-taxonomy menu-item-object-category">
                <a href="#">Services</a>
              </li>
              <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a href="#">Faq</a>
              </li>
              <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a href="#">Contact Us</a>
              </li>
            </ul>
          </div>
          <div class="footer-menu">
            <h2 class="footer-menu-name"> Legal</h2>
            <ul id="menu-legal" class="footer-menu-list">
              <li class="menu-item menu-item-type-post_type menu-item-object-page">
                <a href="#">Terms and Condition</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="footer-content-column">
          <div class="footer-menu">
            <h2 class="footer-menu-name">Social Media</h2>
            <ul id="menu-quick-links" class="footer-menu-list">
              <li class="menu-item menu-item-type-custom menu-item-object-custom">
                <a target="_blank" rel="noopener noreferrer" href="#">
                  <i class="bi bi-tiktok text-white me-2"> </i>
                  Tiktok</a>
              </li>
              <li class="menu-item menu-item-type-custom menu-item-object-custom">
                <a target="_blank" rel="noopener noreferrer" href="#">
                  <i class="bi bi-facebook text-white me-2"> </i>
                  Facebook</a>
              </li>
              <li class="menu-item menu-item-type-custom menu-item-object-custom">
                <a target="_blank" rel="noopener noreferrer" href="#">
                  <i class="bi bi-youtube text-white me-2"> </i>
                  Youtube</a>
              </li>
              <li class="menu-item menu-item-type-custom menu-item-object-custom">
                <a target="_blank" rel="noopener noreferrer" href="#">
                  <i class="bi bi-instagram text-white me-2"> </i>
                  Instagran</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="footer-content-column">
          <div class="footer-call-to-action">
            <h2 class="footer-call-to-action-title">Address</h2>
            <p>Address: Unit 4 One Kalayaan Place Building 284 Samson Road Victory Liner Compound, Caloocan, Philippines</p>
            <p >Email: </p>
            <p>zskincarecenter @gmail.com</p>
          </div>
          <div class="footer-call-to-action">
            <h2 class="footer-call-to-action-title"> You can Contact Us</h2>
            <p class="footer-call-to-action-link-wrapper"> <a class="footer-call-to-action-link" href="tel:0124-64XXXX" target="_self">Phone: 0915 759 2213 </a></p>

          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="footer-copyright-wrapper">
          <p class="footer-copyright-text">
            <a class="footer-copyright-link" href="#" target="_self"> ©2023. | Z-Skin | All rights reserved. </a>
          </p>
        </div>
      </div>
    </footer>
  </div>
  <div class="pace hide pace-running">
  <div data-progress="0" data-progress-text="0%" style="width: 0%;" class="pace-progress">
    <div class="pace-progress-inner"></div>
  </div>
  <div class="pace-activity"></div>
</div>
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
  html: '<div class="align-left"> 1. Minors cannot book appointments.<br>' +
    '2. If an authorized representative is making the appointment, they must present an original authorization letter and a valid ID.<br>' +
    '3. Ensure accurate information for the applicant or authorized representative. .<br>' +
    '4. Appointments are allocated on a first-come, first-served basis.</div?',
  confirmButtonColor: '#6537AE', // Corrected double '#' in the color code
  customClass: {
    html: 'text-start'
  }
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
                    id: '', // the value of the option
                    text: 'None Selected'
                },
                allowClear: true
            });
        });
</script>




</body>
</html>
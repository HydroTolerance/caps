<?php
include "../Client/function.php";
checklogin('Client', true);
$userData = [];
$isClientLoggedIn = isset($_SESSION['client_email']);
if ($isClientLoggedIn) {
    $userData = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contact-Us</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">
<link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}

.contact-container {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 20px;
    height: 60vh;
    background-image: url('images/bgc4.jpg');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(128, 0, 128, 0.6); /* Purple color with 0.6 opacity */
    z-index: 1; /* Ensure the overlay is on top of the background image */
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
  top: 50%;
  left: 40%;
  transform: translate(-50%, -50%);
}
.custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}

    .contact-box {
            background-color:rgba(255, 255, 255, 0.09);
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .send-button {
            background-color:#6537AE;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

  


 </style>
<body>
<?php

include "../db_connect/config.php";
if (isset($_POST['update'])) {
  $name = $_POST['name']; // Updated to use "name"
  $email = $_POST['email']; // Updated to use "email"
  $message = $_POST['message'];

  require 'phpmailer/PHPMailerAutoload.php';
  $mail = new PHPMailer(true);
  try {
            $mail->isSMTP(); 
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;         
            $mail->Username = 'blazered098@gmail.com';
            $mail->Password = 'nnhthgjzjbdpilbh';
            $mail->SMTPSecure = 'tls';       
            $mail->Port = 587;              
            $mail->setFrom($email, $name);
            $mail->addAddress('hydrokaido@gmail.com', 'Z-skin Care Center');
            $mail->addReplyTo($email, $name);


        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Contact Form Submission from ' . $name;
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        echo '<script>
        Swal.fire({
            title: "Success",
            text: "Your message has been sent successfully!",
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "contact.php"; // Redirect to the contact page
            }
        });
    </script>';
    exit;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>
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
        <a href="./t/booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>


<section>
    <div class="contact-container">
        <div class="contact-text" style="z-index: 20;">
            <h1 style="font-family: Lora;" class="text-white">Contact Us</h1>
            <h3  style="font-family: Lora;" class="text-white">Contact us for any assistance or inquiries. We're here to help!</h3>
        </div>
        <div class="overlay">
        </div>
    </div>
</section>


        


<section class="my-5">
    <div class="container rounded border shadow-sm p-5">
        <div class="row g-5">
            <div class="col-lg-6 m-auto py-4">
                <div>
                    <div>
                        <div>
                            <h2 class="fw-bold" style="font-family: Lora;">Talk To Us</h2>
                            <p><span class="fw-bold">Contact Number:</span> 0915 759 2213</p>
                            <p><span class="fw-bold">Email:</span> zskincarecenter@gmail.com</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h2 class="fw-bold" style="font-family: Lora;">Visit Us</h2>
                            <p>Unit 4 One Kalayaan Place Building 284 Samson Road Victory Liner Compound, Caloocan, Philippines</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h2 class="fw-bold" style="font-family: Lora;">Social Media</h2>
                            <p><span class="fw-bold ">Facebook:</span> <a class="d-block text-break" href="https://www.facebook.com/Zskincarecenter">https://www.facebook.com/Zskincarecenter</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div>
                    <div class="mb-4">
                        <h2 class="fw-bold text-center mb-3" style="font-family: Lora;">Z Skin Care Center Map</h2>
                        <div style="position: relative; padding-bottom: 75%; height: 0; overflow: hidden;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15439.9714972879!2d120.9841704!3d14.6563458!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca0386f5cd2d%3A0xd71dbae6fc5329e3!2sZ%20Skin%20Care%20Center!5e0!3m2!1sen!2sph!4v1697965644980!5m2!1sen!2sph" width="100%" height="100%" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <div>
    <div style="background-image: url('images/bgc5.jpg'); background-size: cover; background-repeat: no-repeat; width: 100%;">
        <div class="container p-5">
            <div class="row g-5 my-auto">
                <div class="col-md-6">
                    <p style="font-family: Lora; font-size: 50px; color: white;">Sent Us A Message</p>
                    <p style=" font-size: 25px; color: white;">
                        If you have any questions or need further assistance,
                        feel free to reach out to us.
                        You can easily message us through email in this contact form,
                        and we'll get back to you as soon as possible
                    </p>
                </div>
                <div class="col-md-6 py-3 rounded" style="background-color:rgba(255, 255, 255, 0.09)">
                    <h2 style=" color: white; font-family: Lora;" class="mb-3">Contact Us</h2>
                    <form method="post" onsubmit="showLoading()">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="6" name="message" placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" name="update" class="btn text-white" style="background-color: #6537AE;">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script>
    function showLoading() {
        Swal.fire({
            title: 'Sending Email',
            html: 'Please wait while we send your email...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        });
    }
</script>

</body>

</html>

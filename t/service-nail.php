<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <style>
    
    body {
        background-color:white;
    }
    

.service-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        height: 60vh;
        background-image: url('images/image10.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        
    }

.service-text {
        color: white;
        font-size: 80px;
        
        }

.item-container1 {
    background-color: #6537AE;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 33vh;
    color: white;
  }

.item-container1 p:first-child {
    font-size: 50px;
    font-weight: bold;
  }

.item-container1 p:last-child {
    font-size: 30px;
  }

.item-container2 {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    text-align: left;
    font-size: 20px;
  }

.centered-line {
        margin: 0 auto;
        width: 90%;
    }




.image-wrapper {
  position: relative;
  text-align: center;
  
}


.image-wrapper img {
  max-width: 100%;
  height: auto;
  transition: opacity 0.5s;
}

.image-wrapper img:hover {
  opacity: 0.7;
}

.image-wrapper .text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 24px;
  font-weight: bold;
  color: white;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  opacity: 0;
  transition: opacity 0.5s;
}

.image-wrapper:hover .text {
  opacity: 1;
}

.services-container .navbar-nav a.nav-link {
    color: black !important;
font-size: 20px;
transition: color 0.3s;
}

.services-container .navbar-nav a.nav-link:hover {

    color: #E1BB86 !important;

}

.nav-tabs .nav-link:not(.active) {
    color: #6537AE;
}
.bg-purple {
  color: #6537AE!important;
}
 </style>


</head>

<body>

<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-2 text-white" style="margin-right: 115px;" href="../index.php" id="s5">Z-Skin</a>
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

    <div class="service-container">
            <div class="service-text">
                <p><span style="font-weight: bold; font-family: Roboto;"></span>
               </p>
            </div>
        </div> 

        <div class="item-container1 " style=" font-family: Roboto;">
    <p>OUR SERVICES</p>
    <p>Consult a Board Certified Dermatologist</p>
  </div>


  <div class="p-5 text-center" style=" font-family: Poppins;">
    <p>We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. <br>
      Our experienced team offers personalized medical and cosmetic dermatology services using the latest <br>
      advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for <br>
        yourself.</p>
  </div>
<div class="services-container">

<p sytle="font-family: roboto;" class="text-center fw-bold fs-2 mb-3 bg-purple">SERVICES OFFER</p>

<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Hair</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Face</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Nail</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <?php
    include "../db_connect/config.php";

    $stmt = mysqli_prepare($conn, "SELECT id, services, image, description FROM service");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $services, $image, $description);

    ?>
    <div class="row imagers">
            <?php
    while (mysqli_stmt_fetch($stmt)) {
        ?>
            <div class=" col-xl-3 col-lg-4 col-md-6 my-3">
                <div class="image-wrapper">
                    <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
                    <div class="text"><?php echo $description; ?></div>
                </div>
            </div>
        <?php
    }
    ?>
    </div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  <?php
    include "../db_connect/config.php";

    $stmt = mysqli_prepare($conn, "SELECT id, services, image, description FROM service");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $services, $image, $description);

    ?>
    <div class="row imagers">
            <?php
    while (mysqli_stmt_fetch($stmt)) {
        ?>
            <div class=" col-xl-3 col-lg-4 col-md-6 my-3">
                <div class="image-wrapper">
                    <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
                    <div class="text"><?php echo $description; ?></div>
                </div>
            </div>
        <?php
    }
    ?>
    </div>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <?php
    include "../db_connect/config.php";

    $stmt = mysqli_prepare($conn, "SELECT id, services, image, description FROM service");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $services, $image, $description);

    ?>
    <div class="row imagers">
            <?php
    while (mysqli_stmt_fetch($stmt)) {
        ?>
            <div class=" col-xl-3 col-lg-4 col-md-6 my-3">
                <div class="image-wrapper">
                    <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
                    <div class="text"><?php echo $description; ?></div>
                </div>
            </div>
        <?php
    }
    ?>
    </div>
  </div>
</div>

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




    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

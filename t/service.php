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
    <title>Service</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
<link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">
<script src="https://unpkg.com/scrollreveal"></script>
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



.service-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        height: 60vh;
        background-image: url('images/services.jpg');
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
    text-align: center;
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
<?php include "announcement.php" ?>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */">
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
        <a class="nav-link active  text-white fs-5" href="../index.php">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="about.php">About Us</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="service.php">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="FAQ.php">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="contact.php">Contact Us</a>
        </li>
      </ul>
      <?php if ($isClientLoggedIn): ?>
        <div class="dropdown float-start">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle me-3" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1" style="left: -10px;">
                <li><a class="dropdown-item" href="../Client/client_record/view.php">Profile Account</a></li>
                    <li><a class="dropdown-item" href="../Client/logout.php">Sign out</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="../login.php" class="btn btn-outline-light mx-2" type="submit">Login</a>
        <?php endif; ?>
        <a href="booking.php" class="btn btn-outline-light float-start" type="submit">Book an Appointment</a>
    </div>
  </div>
</nav>

<div class="container-fluid p-0">
    <div>
        <div class="col-md-12">
            <div class="FAQ-container text-center text-white">
                <div style="background-color: #6537AE; height: 60vh; max-width: 100%;">
                    <img src="images/services.jpg" alt="Background Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    <!-- Content within your FAQ container goes here -->
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="item-container1" id="s1">
    <h1 style=" font-family: Lora;">OUR SERVICES</h1>
    <h3 style=" font-family: Lora;">Consult a Board Certified Dermatologist</h3>
  </div>

<div class="services-container" id="s1">
<h2 style=" font-family: Lora;" class="text-center fw-bold fs-2 my-5 bg-purple">SERVICES OFFER</h2>

<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Skin</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Hair</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Nail</button>
  </li>
</ul>
<div class="tab-content mb-5" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="container">
      <div class="row">
      <?php
  include "../db_connect/config.php";
  $stmt = mysqli_prepare($conn, "SELECT id, services, image, name, description FROM service WHERE services = 'Skin'");
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
  ?>
  <?php
  while (mysqli_stmt_fetch($stmt)) {
  ?>
      <div class="image-wrapper col-xl-4 col-lg-4 col-md-6 my-3">
      <a href="list_services.php?id=<?php echo $id; ?>">
          <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
          <div class="text"><?php echo $name; ?></div>
      </a>
      </div>
  <?php
  }
  ?>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="container">
      <div class="row">
          <?php
              include "../db_connect/config.php";
              $stmt = mysqli_prepare($conn, "SELECT id, services, image, name, description FROM service WHERE services = 'Hair'");
              mysqli_stmt_execute($stmt);
              mysqli_stmt_store_result($stmt);
              mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
              ?>
                      <?php
              while (mysqli_stmt_fetch($stmt)) {
              ?>
                <div class="image-wrapper col-xl-4 col-lg-4 col-md-6 my-3">
                <a href="list_services.php?id=<?php echo $id; ?>">
                    <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
                    <div class="text"><?php echo $name; ?></div>
                </a>
                </div>
              <?php
              }
          ?>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <div class="container">
      <div class="row">
          <?php
              include "../db_connect/config.php";
              $stmt = mysqli_prepare($conn, "SELECT id, services, image, name,  description FROM service WHERE services = 'Nail'");
              mysqli_stmt_execute($stmt);
              mysqli_stmt_store_result($stmt);
              mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
              ?>
                      <?php
              while (mysqli_stmt_fetch($stmt)) {
              ?>
                <div class="image-wrapper col-xl-4 col-lg-4 col-md-6 my-3">
                  <a href="list_services.php?id=<?php echo $id; ?>">
                      <img src="../img/services/<?php echo $image; ?>" class="image-fluid" style="height: 400px; width: 400px;" alt="Image 1">
                      <div class="text"><?php echo $name; ?></div>
                  </a>
                </div>
              <?php
              }
          ?>
      </div>
    </div>
  </div>
  </div>
</div>
<footer >
<div class="mt-5">
    <footer class="footer" id="s1">
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
            <p >Email: zskincarecenter@gmail.com</p>
          </div>
          </div>
          <div>
            
  </div>
</div>
</footer>
<div class=" text-center text-white p-1" style="background-color: #c23fe3;"> © 2023 Z Skin Care Center. All Rights Reserved. </div>
    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  ScrollReveal().reveal('#s1',{
  delay: 175,
  duration: 1500,
  origin: "bottom",
  interval: 600,
});
ScrollReveal().reveal('#s2',{
  delay: 155,
  duration: 2000,
  opacity: 0,
  easing   : 'ease-in-out',
  distance: "70%",
  origin: "bottom",
});
ScrollReveal().reveal('#s4',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "70%",
  origin: "top",
});
ScrollReveal().reveal('#s3',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "70%",
  origin: "top",
});
ScrollReveal().reveal('#s5',{
  delay: 175,
  duration: 1500,
  origin: "center",
});
ScrollReveal().reveal('#carouselExampleDark',{
  delay: 175,
  duration: 1500,
  origin: "center",
});

ScrollReveal().reveal('.col-md-4', {
    duration: 1000, 
    origin: 'bottom',
    distance: '100px',
    delay: 200,
  });
</script>
<!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "184630898063490");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v18.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
</body>

</html>

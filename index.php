<?php
include "Client/function.php";
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
.image-container {
      position: relative;
      max-width: 500px; /* Adjust the max-width as needed */
    }

    .blurred-image {
      filter: blur(20px); /* Adjust the blur effect as needed */
      transition: filter 0.5s ease-in-out;
      width: 100%;
    }

    .warning-message {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white; /* Adjust text color as needed */
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .warning-message h3 {
      margin-bottom: 10px;
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
/* medium and up screens */
#loading-animation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white; /* Set the background to white */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.loader {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.card {
  border: none;
  border-radius: 0;
  box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
}

.carousel-control-prev,
.carousel-control-next {
  background-color: #6537AE;
  width: 6vh;
  height: 6vh;
  border-radius: 50%;
  top: 50%;
  transform: translateY(-50%);
}
.carousel-control-prev span,
.carousel-control-next span {
  width: 1.5rem;
  height: 1.5rem;
}
@media screen and (min-width: 577px) {
  .cards-wrapper {
    display: flex;
  }
  .card {
    margin: 0 0.5em;
    width: calc(100% / 2);
    height: calc(100% / 2);
  }
  .image-wrapper {
    height: 20vw;
    margin: 0 auto;
  }
}
@media screen and (max-width: 576px) {
  .card:not(:first-child) {
    display: none;
  }
}

.image-wrapper img {
  max-width: 100%;
  max-height: 100%;
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


<div id="carouselExampleDark" class="carousel carousel-dark slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
        <div class="row">
            <div class="col-md-6">
                <img src="./t/images/1.png" class="d-block w-100" alt="./t/images/1.png">
              </div>
              <div class="col-md-6 m-auto p-5">
                <div>
                  <div>
                    <h1 style="font-family: Lora;" class="mb-3">Discover Your Best Skin Care with Expert Care</h1>
                    <p>Explore our expertly formulated skincare solutions and reveal your radiant, healthy skin.</p>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
        <div class="row">
            <div class="col-md-6">
                <img src="./t/images/2.png" class="d-block w-100" alt="./t/images/1.png">
              </div>
              <div class="col-md-6 m-auto p-5">
                <div>
                  <div>
                    <h1 style="font-family: Lora;" class="mb-3">Wish Granted: Unlock Your Dreams</h1>
                    <p>Discover a world where your wishes come true with our expert guidance and support.</p>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<section id="s1" class="mb-3">
  <div class="container py-5">
      <h2 style="font-family: Lora;" class="text-center mb-5">FIND THE TREATMENTS FOR YOU</h2>
    <div class="row mt-3">
      <div class="col-md-4 mx-auto">
        <img src="./t/images/skin.png" alt="" height="200px" width="200px" class="d-block mx-auto">
        <p class="text-center mt-4">Skin Treatment</p>
      </div>
      <div class="col-md-4 mx-auto">
        <img src="./t/images/hair.png" alt="" height="200px" width="200px" class="d-block mx-auto">
        <p class="text-center mt-4">Hair Treatment</p>
      </div>
      <div class="col-md-4 mx-auto">
        <img src="./t/images/nail.png" alt="" height="200px" width="200px" class="d-block mx-auto">
        <p class="text-center mt-4">Nail Treatment</p>
      </div>
    </div>
  </div>
</section>


<section class="mb-5" id="s1">
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner mx-auto">
  <?php
include "db_connect/config.php";
$stmt = mysqli_prepare($conn, "SELECT id, services, image, name, description FROM service");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
?>
      <?php
      $groupSize = 3;
      $groupIndex = 0;

      while (mysqli_stmt_fetch($stmt)) {
        if ($groupIndex % $groupSize === 0) {
          $activeClass = $groupIndex === 0 ? 'active' : '';

          echo '<div class="carousel-item ' . $activeClass . '">';
          echo '<div class="cards-wrapper mx-auto">';
        }

        echo '<div class="card h-100">';
        echo '<div class="image-wrapper">';
        echo '<img style="max-width:100%;" src="img/services/' . $image . '" alt="...">';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $name . '</h5>';
        echo '<p class="card-text">' . $description . '</p>';
        echo '<a href="./t/service.php" class="btn text-white" style="background-color:#6537AE;">Go to services</a>';
        echo '</div>';
        echo '</div>';

        if (($groupIndex + 1) % $groupSize === 0) {
          echo '</div>';
          echo '</div>';
        }

        $groupIndex++;
      }
      if ($groupIndex % $groupSize !== 0) {
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" ariahidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>



<section id="s1">
  <div class="d-flex justify-content-center align-items-center py-5" style="background-color: #6537AE; min-height: 500px;">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="bg-light p-4 h-100">
            <div class="border border-2 p-4" style="border-color: #6537AE;">
              <h1 style="font-family: Lora;">About Us</h1>
              <p >Get to know our Story</p>
              <p class="">We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. Our experienced team offers personalized medical and cosmetic dermatology services using the latest advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for yourself.</p>
              <a href="./t/about.php" class="btn rounded-pill text-white" style="font-family: 'Poppins', sans-serif; font-size: 1rem; background-color:#6537AE;">Our Story</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <img src="./t/images/aboutus.png" alt="Description of the image" class="img-fluid h-100 w-100"  alt="About Us Image">
        </div>
      </div>
    </div>
  </div>
</section>

<section id="s1">
  <div class="my-5">
      <h1  class="text-center" style="font-family: Lora;">Highlight</h1>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <iframe class="embed-responsive-item" src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FANCalerts%2Fvideos%2F10155732800023791%2F&show_text=false&t=0" frameborder="0" allowfullscreen="true" height="400px" width="800px" style="max-width: 100%;"></iframe>
        </div>
        <div class="col-md-6">
          <iframe height="400px" width="800px" style="max-width: 100%;" src="https://www.youtube.com/embed/Oxji-IWGGfE?si=y0nVisFy62PyPtyQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" style="max-width: 100%;" allowfullscreen></iframe>
        </div>
      </div>
    </div>
</section>


<section class="my-5" id="s1">
  <div class="container">
  <h1  class="text-center" style="font-family: Lora;">Results</h1>
      <div class="row">
          <div class="col-lg-4">
            <div class="image-container">
              <img src="./t/images/result (1).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
          <div class="image-container">
              <img src="./t/images/result (2).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
          <div class="image-container">
              <img src="./t/images/result (3).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
          <div class="image-container">
              <img src="./t/images/result (4).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="image-container">
              <img src="./t/images/result (5).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="image-container">
              <img src="./t/images/result (6).png" alt="" class="blurred-image" height="500px" width="500px" style="max-width: 100%;">
              <div class="warning-message">
                <h3 class="text-nowrap">Trigger Warning</h3>
                <p>Click on the button below to see the results.</p>
                <button class="btn btn-danger" onclick="showImage(this)">Show Me</button>
              </div>
            </div>
          </div>
      </div>
  </div>
</section>



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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

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
<script>
  document.getElementById("loading-animation").style.display = "block";
  window.addEventListener("load", function () {
    document.getElementById("loading-animation").style.display = "none";
  });

  function showImage(button) {
    // Get the parent container of the clicked button
    var imageContainer = button.parentElement.parentElement;
    
    // Remove the blur effect and show the original image
    var blurredImage = imageContainer.querySelector('.blurred-image');
    blurredImage.style.filter = 'none';

    // Hide the warning message
    var warningMessage = imageContainer.querySelector('.warning-message');
    warningMessage.style.display = 'none';
  }
</script>
</body>

</html>

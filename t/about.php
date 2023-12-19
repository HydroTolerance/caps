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
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
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



.card-body {
    height: 200px; /* Adjust the height as needed */
    overflow: hidden; /* Hide overflow content */
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
                    <li>
                    <a class="dropdown-item" href="../Client/client_record/view.php">Profile Account</a>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
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
<div class="container-fluid p-0" id="s5">
    <div>
        <div class="col-md-12">
            <div class="FAQ-container text-center text-white">
                <div style="background-color: #6537AE; height: 60vh; max-width: 100%;">
                    <img src="images/z-skin.jpg" alt="Background Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    <!-- Content within your FAQ container goes here -->
                </div>
            </div>
        </div>
    </div>
</div>
<section id="s5">
  <div style="background-color: #6537AE;">
    <div class="py-5">
      <h1 style=" font-family: Lora;" class="text-center text-white">OUR STORY</h1>
      <h2 style=" font-family: Lora;" class="text-center text-white">Get to know our Story</h2>
  </div>
</section>

<section class="mx-3 py-5 text-center" id="s5">
  <div class="col-md-9 mx-auto">
    <p style="font-size: 20px;">We are a leading dermatology clinic <span class="fw-bold" style="font-size: 20px;"> dedicated to helping our patients
      achieve optimal skin health and wellness.</span>
      Our experienced team <span class="fw-bold" style="font-size: 20px;">offers personalized medical 
      and cosmetic dermatology services using the latest advancements 
      in the field.</span> Contact us to schedule an appointment and experience our patient-centered care for yourself.
    </p>
  </div>
</section>

<section id="s5">
  <div style="background-color: #6537AE;" class="pt-3 pb-5">
    <div class="container bg-light p-3 rounded">
          <div class="row gx-3">
              <div class="col-lg-6 rounded-image m-auto">
                  <img src="images/dra. Zharlah.jpg" alt="Dr. Zharlah" class="img-fluid" id="s1">
              </div>
              <div class="col-lg-6 content m-auto"  id="s1">
                  <h2 class="mb-4 mt-3" style="font-family: Lora;">Dr. Zharlah Gulmatico-Flores MD, MMPHA, FPDS, FPADSFI</h2>
                  <p>
                      Dr. Zharlah A. Gulmatico-Flores, MD, FPDS. FPADSFI obtained her Doctor of Medicine degree at Our Lady of Fatima University.
                      She completed her residency training in Dermatology at the Jose R. Reyes Memorial Medical Center and went on to pursue further training
                      on Mohs Micrographic Surgery at Yonsei Severance Hospital in Seoul, South Korea and under the tutelage of Professor Isaac Zilinsky and
                      Dr. Euhud Miller at Assaf Harofeh Medical Center in Israel. At present, Dr. Gulmatico-Flores is the Training Officer and Research Coordinator
                      of the Department of Dermatology at Jose R. Reyes Memorial Medical Center and is the Chairperson of the same institution's Institutional
                      Review Board Committee. She is an Associate Professor III at the Metropolitan Medical Center College of Medicine and Assistant professor
                      III in Our Lady of Fatima University College of Medicine in the Department of Biochemistry. She is a Fellow and the Head of the Public
                      Relations External Affairs Committee of the Philippine Dermatological Society. She is a Fellow of the American Academy of Dermatology
                      and European Academy of Dermatology and Venereology. She is an active consultant at Quezon City General Hospital, ACE Medical Center,
                      and Zephyris Skin Care Center.
                  </p>
              </div>
          </div>
      </div>
    </div>
  </div>
</section>

<section class="my-5" id="s5">
<h1 style=" font-family: Lora;" class="text-center mb-5">AWARDS</h1>
<div id="carouselExampleControls" class="carousel slide mx-3" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="cards-wrapper">
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards2.jpg" alt="...">
          </div>
          <div class="card-body text-center">
            <h5 class="card-title" style="font-weight: 700;">CERTIFICATE OF ACHIEVEMENT</h5>
            <p class="card-title">American Academy of Dermatology</p>
          </div>
        </div>
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards7.jpg" alt="...">
          </div>
          <div class="card-body text-center">
            <h5 class="card-title" style="font-weight: 700;">PLAQUE OF RECOGNITION</h5>
            <p class="card-title">Philippine Academy of Aesthetic and Age Management Medicine Inc</p>
          </div>
        </div>
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards3.jpg"  alt="...">
          </div>
          <div class="card-body  text-center">
            <h5 class="card-title" style="font-weight: 700;">RESIDENCY TRAINING PROGRAM IN DERMATOLOGY</h5>
            <p class="card-title">Jose R. Reyes Memorial Medical Center</p>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="cards-wrapper">
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards4.jpg" alt="...">
          </div>
          <div class="card-body text-center">
            <h5 class="card-title " style="font-weight: 700;">CERTIFICATE OF ACHIEVEMENT</h5>
            <p class="card-text">Yonsei University of College of Medicine</p>
          </div>
        </div>
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards5.jpg" alt="...">
          </div>
          <div class="card-body  text-center">
            <h5 class="card-title" style="font-weight: 700;">PLAQUE OF RECOGNITION</h5>
            <p class="card-title">Philippine Academy of Aesthetic and Age Management Medicine Inc</p>
          </div>
        </div>
        <div class="card">
          <div class="image-wrapper">
            <img src="images/awards6.jpg" alt="...">
          </div>
          <div class="card-body text-center">
            <h5 class="card-title" style="font-weight: 700;">SKIN TECH PHARMA GROUP AND PLAQUE APPRECIATION</h5>
            <p class="card-title">Philippine Academy of Aesthetic and Age Management Medicine Inc</p>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</section>



                    
        <hr class="centered-line">
                      

       

        <div class="we-are-block my-5"  id="s5">
  <div id="about-us-section">
    <div class="about-us-image" id="s1">
    <img src="images/image6.png" width="851" height="459" alt="Building Pic">
    </div>

    <div class="about-us-info"  id="s1">
      <h2 style=" font-family: Lora;">Mission</h2>
      <p>Our mission is to provide you with the highest quality of
                    care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention.</p>
    </div>
  </div>

  <div id="history-section">
    <div class="history-image" id="s1">
      <img src="images/image6.png" width="951" height="471" alt="Building Pic"  id="s5">
    </div>
    <div class="history-info" id="s1">
      <h2 style=" font-family: Lora;">Vision</h2>
      <p>Our vision for the clinic is to be a leading provider of
                    dermatology services in your community, known for
                    exceptional patient care and innovative treatment
                    options. We aim to provide you with personalized and
                    comprehensive care, offer innovative treatment options,
                    prioritize your comfort and satisfaction, and promote skin
                    health education. Ultimately, we want to create a warm
                    and welcoming environment where you feel comfortable
                    and confident in your care, and to be a trusted resource
                    for you, helping you achieve optimal skin
                    health and wellness. </p>
        </div>
      </div>
    </div>

    <footer >
<div class="mt-5">
    <footer class="footer"  id="s5">
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

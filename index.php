<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="./t/css/style.css">
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
</head>
<style>

/* Style the pagination next button */
.swiper-button-prev:after,
.swiper-button-next:after {
  display: none;
}
i{
 color:#6537AE;
}
i:hover {
 color:#A740A4;
}

.fixed-text {
  position: fixed;
  top: 50%; /* Adjust the vertical position as needed */
  left: 40%; /* Adjust the horizontal position as needed */
  transform: translate(-50%, -50%);
}

/* Media query for smaller screens (e.g., mobile) */
@media (max-width: 768px) {
  .fixed-text {
    font-size: 30px; /* You can adjust the font size for mobile as needed */
  }
}


div.carousel-nav-icon > svg {
    height: 48px;
    width: 48px;
}

html[data-bs-theme="dark"] div.carousel-nav-icon > svg {
    fill: #FFF !important;
}

@media (max-width: 767px) {
    .carousel-inner .carousel-item > div {
        display: none;
    }
    .carousel-inner .carousel-item > div:first-child {
        display: block;
    }
}

.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item-next,
.carousel-inner .carousel-item-prev {
    display: flex;
}

/* medium and up screens */
@media (min-width: 768px) {

    .carousel-inner .carousel-item-end.active,
    .carousel-inner .carousel-item-next {
        transform: translateX(33%);
    }

    .carousel-inner .carousel-item-start.active, 
    .carousel-inner .carousel-item-prev {
        transform: translateX(-33%);
    }
}

.carousel-inner .carousel-item-end,
.carousel-inner .carousel-item-start { 
    transform: translateX(0);
}
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
</style>
<body>

<body>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" style="margin-right: 37px;" href="index.php">
    <img src="t/images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon text-white"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white" href="index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="t/about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="t/service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="t/FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="contact.php" id="s5">Contact</a>
        </li>
      </ul>
      <a href="login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
      <a href="t/booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
<div class="swiper-container" id="s1">
    <div class="swiper-wrapper" >
        <div class="swiper-slide" style="background-image: url(./t/images/1.png); min-height: 100vh;">
        <div class="centered-text">
          <div class="fixed-text">
            <div style="font-size: 50px; margin-bottom: -20px; color:#6537AE;">Z-SKIN</div>
            <div style="font-size: 50px; color:#6537AE;">TREATMENT</div>
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
              Necessitatibus suscipit numquam obcaecati totam molestias tempore consequatur 
              assumenda beatae soluta, voluptatibus expedita nobis possimus amet cupiditate 
              vel dolorum, at ratione? Ratione!</div>
          </div>
        </div>
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/2.png); min-height: 100vh;">
        <div class="centered-text">
          <div class="fixed-text">
            <div style="font-size: 50px; margin-bottom: -20px; color:#6537AE;">Z-SKIN</div>
            <div style="font-size: 50px; color:#6537AE;">TREATMENT</div>
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
              Necessitatibus suscipit numquam obcaecati totam molestias tempore consequatur 
              assumenda beatae soluta, voluptatibus expedita nobis possimus amet cupiditate 
              vel dolorum, at ratione? Ratione!</div>
          </div>
        </div>
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/3.png); min-height: 100vh;">
        <div class="centered-text">
          <div class="fixed-text">
            <div style="font-size: 50px; margin-bottom: -20px; color:#6537AE;">Z-SKIN</div>
            <div style="font-size: 50px; color:#6537AE;">TREATMENT</div>
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
              Necessitatibus suscipit numquam obcaecati totam molestias tempore consequatur 
              assumenda beatae soluta, voluptatibus expedita nobis possimus amet cupiditate 
              vel dolorum, at ratione? Ratione!</div>
          </div>
        </div>
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/4.png); min-height: 100vh;">
        <div class="centered-text">
          <div class="fixed-text">
            <div style="font-size: 50px; margin-bottom: -20px; color:#6537AE;">Z-SKIN</div>
            <div style="font-size: 50px; color:#6537AE;">TREATMENT</div>
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
              Necessitatibus suscipit numquam obcaecati totam molestias tempore consequatur 
              assumenda beatae soluta, voluptatibus expedita nobis possimus amet cupiditate 
              vel dolorum, at ratione? Ratione!</div>
          </div>
        </div>
        </div>
        <div class="swiper-button-next"><i class="fa-solid fa-circle-chevron-right fa-2x"></i></div>
        <div class="swiper-button-prev"><i class="fa-solid fa-circle-chevron-left fa-2x"></i></div>
    </div>
    
</div>
<section id="s1">
  <div class="d-flex justify-content-center align-items-center py-5" style="background-color: #6537AE; min-height: 500px;">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="bg-light p-4 h-100">
            <div class="border border-2 p-4" style="border-color: #6537AE;">
              <h1 class="fw-bold fs-1 fs-lg-1">About Us</h1>
              <p class="fs-5">Get to know our Story</p>
              <p class="fs-4 fs-lg-5">We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. Our experienced team offers personalized medical and cosmetic dermatology services using the latest advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for yourself.</p>
              <a href="about.php" class="btn rounded-pill text-white" style="font-family: 'Poppins', sans-serif; font-size: 1rem; background-color:#6537AE;">Our Story</a>
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
    <hr class="centered-line">
    <main id="s1" class="d-flex flex-wrap justify-content-between" style="padding: 20px;">
    <div class="container-service">
        <h1  style="font-family: Roboto;">Services</h1>
        <p class="fs-5" style="font-family: Poppins;">What Zephyris Skin Care Center Offers</p>
    </div>
    <div class="text-center">
        <a href="http://" class="btn text-white rounded-pill" style="background-color: #6537AE;">Show All</a>
    </div>
</main>

  <hr>
  <section id="s1">
    <div class="container">
        <div class="row mx-auto my-auto justify-content-center">
            <div class="col">
                <div class="row">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <a role="button" href="#recipeCarousel" role="button" data-bs-slide="prev">
                            <div class="carousel-nav-icon">
                            <i class="fa-solid fa-circle-chevron-left fa-2x"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-10">
                        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="col-md-4">
                                      <div class="card" style="margin-bottom: 30px; margin-top:30px">
                                        <img src="./t/images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                                        <div class="card-body">
                                          <h5 class="card-title">First Service label</h5>
                                          <p class="card-text">Service Description Paragraph.</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <a role="button" href="#recipeCarousel" role="button" data-bs-slide="next">
                            <div class="carousel-nav-icon">
                              <i class="fa-solid fa-circle-chevron-right fa-2x"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  <hr>
<main id="s1">
  <div>
    <span>discover</span>
    <h1>Our Achievement</h1>
    <hr>
    <p>Unlock the Beauty Within: Your Comprehensive Dermatology Discovery Companion</p>
    <a href="#">View About Us</a>
  </div>
  <div class="swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide swiper-slide--one">
        <div>
          <h2 class="high2">Achievement</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. A debitis eaque blanditiis quas saepe incidunt. Soluta perferendis temporibus aliquam! Eum esse iusto vitae reprehenderit a quia hic, ab officia culpa.</p>
          <a href="images/image4.jpg" target="_blank">explore</a>
        </div>
      </div>
      <div class="swiper-slide swiper-slide--two">
        <div>
          <h2 class="high2">Achievement</h2>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime dolore fugit labore autem, soluta consequuntur reiciendis magnam dolores quisquam sint numquam, iusto ipsa sed aut natus illo libero, harum ex?
          </p>
          <a href="https://scontent-mnl1-1.xx.fbcdn.net/v/t39.30808-6/385890639_764396422379519_5576928239451780772_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeGhGO7cqA8OUXlDHRIjTgvgggFKscCYjeKCAUqxwJiN4n6Cqafydr1Erh-Y_n7qG_U1zD14Ly4c7UivfqIKuSMv&_nc_ohc=8xIcmD0dHEAAX-Z1XBG&_nc_ht=scontent-mnl1-1.xx&oh=00_AfCFE6mZmpUDhu9C6YVHlUDXIqkvSOyLvq0CMczPjIdwsg&oe=6531222F" target="_blank">explore</a>
        </div>
      </div>

      <div class="swiper-slide swiper-slide--three">

        <div>
          <h2 class="high2">Achievement</h2>
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde aperiam fuga quod ratione debitis reiciendis impedit dolorum maxime molestias laboriosam sapiente vero, quaerat nulla quasi ad architecto qui, repellat dolor!
          </p>
          <a href="images/image4.jpg" target="_blank">explore</a>
        </div>
      </div>

      <div class="swiper-slide swiper-slide--four">

        <div>
          <h2 class="high2">Achievement</h2>
          <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum modi ducimus impedit nulla voluptas voluptates laboriosam qui aut cupiditate perspiciatis, velit quidem mollitia aspernatur officiis accusantium. Officiis eos magni obcaecati.
          </p>
          <a href="images/image4.jpg" target="_blank">explore</a>
        </div>
      </div>

      <div class="swiper-slide swiper-slide--five">

        <div>
          <h2 class="high2">Achievement</h2>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus reiciendis a quidem nulla sed voluptate molestiae architecto perferendis eum amet voluptates distinctio, omnis, magni accusamus eaque corporis rerum nemo mollitia?
          </p>
          <a href="images/image4.jpg" target="_blank">explore</a>
        </div>
      </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
  </div>
  <img src="images/background.jpg" alt="" class="bg">
  <img src="https://cdn.pixabay.com/photo/2012/04/13/13/57/scallop-32506_960_720.png" alt="" class="bg2">

  
</main>
<hr>
<main class="justify-content-center" id="s1">
        <div class="me-5">
            <h1 style="font-family: Roboto;">Watch Our Video</h1>
            <p class="fs-5" style="font-family: Poppins;">Discover Z-Skin Care Center</p>
        </div>
        <div>
            <iframe class="embed-responsive-item" src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FANCalerts%2Fvideos%2F10155732800023791%2F&show_text=false&t=0" frameborder="0" allowfullscreen="true" height="400px" width="800px" style="max-width: 100%;"></iframe>
        </div>
    </div>

</main>
<hr>



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
<script>
var mySwiper = new Swiper('.swiper-container', {
  effect: "fade",
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});

</script>
<script>
  var swiper = new Swiper(".swiper", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 100,
    modifier: 3,
    slideShadows: true
  },
  keyboard: {
    enabled: true
  },
  mousewheel: {
    thresholdDelta: 70
  },
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  breakpoints: {
    640: {
      slidesPerView: 2
    },
    768: {
      slidesPerView: 1
    },
    1024: {
      slidesPerView: 2
    },
    1560: {
      slidesPerView: 3
    }
  }
});
</script>
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
</script>
<script>
  let items = document.querySelectorAll('.carousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 3
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true)
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
})

/* Nothing below this point is needed. */
const darkSwitch = document.getElementById("darkSwitch");
window.addEventListener("load", function () {
    if (darkSwitch) {
        initTheme();
        darkSwitch.addEventListener("change", function () {
            resetTheme();
        });
    }
});
</script>
<script>
  // Show the loading animation
  document.getElementById("loading-animation").style.display = "block";

  // Hide the loading animation once the page is fully loaded
  window.addEventListener("load", function () {
    document.getElementById("loading-animation").style.display = "none";
  });
</script>
</body>

</html>

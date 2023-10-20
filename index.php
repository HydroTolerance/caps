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
.centered-text {
  width: 60%;
  position: absolute;
  left: 10%;
  top: 50%;
  transform: translateY(-50%);
  padding: 20px;
}
.about-container {
      background-color: #6537AE;
      min-height: 500px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .about-content {
      background-color: #fff;
      border: 2px solid #6537AE;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
    }

    .about-title {
      font-size: 2rem;
      font-weight: bold;
    }

    .about-description {
      font-size: 1.5rem;
    }

    .about-button {
      font-family: 'Poppins', sans-serif;
      font-size: 1.5rem;
      border: none;
      padding: 15px 30px;
      border-radius: 30px;
      background-color: #6537AE;
      color: #fff;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .about-button:hover {
      background-color: #522A99;
    }
@media (max-width: 768px) {
  .centered-text {
    width: 100%;
  }
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
</style>
<body>

<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-2 text-white" style="margin-right: 115px;" href="#">Z-Skin</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon text-white"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active  text-white" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="./t/about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="./t/service.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="./t/FAQ.php">FAQ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="./t/contact.php">Contact Us</a>
        </li>
      </ul>
      <a href="../login.php" class="btn btn-outline-light fw-bold mx-2" type="submit">Login</a>
      <a href="booking.php" class="btn btn-outline-light fw-bold" type="submit">Book an Appointment</a>
    </div>
  </div>
</nav>
<div class="swiper-container" >
    <div class="swiper-wrapper" >
        <div class="swiper-slide" style="background-image: url(./t/images/1.png);">
        <div class="centered-text" data-sr="enter left, move 50px over 0.5s">
          <div class="fixed-text" data-sr="enter right, move 50px over 0.5s">
            <div style="font-size: 50px; margin-bottom: -20px; color:#6537AE;">Z-SKIN</div>
            <div style="font-size: 50px; color:#6537AE;">TREATMENT</div>
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
              Necessitatibus suscipit numquam obcaecati totam molestias tempore consequatur 
              assumenda beatae soluta, voluptatibus expedita nobis possimus amet cupiditate 
              vel dolorum, at ratione? Ratione!</div>
          </div>
        </div>
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/2.png);">
          <div class="float-center">
            <h3 class="text-center">HELLO WORLD</h3>
          </div> 
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/3.png);">
            <h3>Random Text 1</h3>
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/4.png);">
        </div>
        <div class="swiper-slide" style="background-image: url(./t/images/5.png);">
        </div>
    </div>
    <div class="swiper-button-next"><i class="fa-solid fa-circle-chevron-right fa-2x"></i></div>
  <div class="swiper-button-prev"><i class="fa-solid fa-circle-chevron-left fa-2x"></i></div>
</div>
<section>
  <div class="d-flex justify-content-center align-items-center py-5" style="background-color: #6537AE; min-height: 500px;">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="bg-light p-4 h-100" id="s1">
            <div class="border border-2 p-4" style="border-color: #6537AE;">
              <h1 class="fw-bold fs-4 fs-lg-2">About Us</h1>
              <p class="fs-5">Get to know our Story</p>
              <p class="fs-6 fs-lg-5">We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. Our experienced team offers personalized medical and cosmetic dermatology services using the latest advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for yourself.</p>
              <a href="about.php" class="btn btn-primary rounded-pill" style="font-family: 'Poppins', sans-serif; font-size: 1rem">Our Story</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <img src="images/aboutus.png" alt="Description of the image" class="img-fluid h-100"  id="s4" alt="About Us Image">
        </div>
      </div>
    </div>
  </div>
</section>



    <hr class="centered-line">

    <br>

    <div class="container-service">
    <h2 style="font-weight: bold; font-size: 50px; margin: 20px 0 0 30px; font-family:Roboto;">Services</h2>
    <p style = "font-size: 20px;   margin: 20px 0 0 30px; font-family:Poppins;">What Zephyris Skin Care Center Offer</p>
  </div>

  
<section>
  <div class="carouselsection" >
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row">
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice24.jpg" class="card-img-top" alt="pic1" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice25.jpg" class="card-img-top" alt="pic2" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice26.jpg" class="card-img-top" alt="pic3" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="carousel-item">
          <div class="row">
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice19.jpg" class="card-img-top" alt="pic4" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice17.jpg" class="card-img-top" alt="pic5" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice16.jpg" class="card-img-top" alt="pic6" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="row">
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice14.jpg" class="card-img-top" alt="pic7" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice13.jpg" class="card-img-top" alt="pic8" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice12.jpg" class="card-img-top" alt="pic9" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="carousel-item">
          <div class="row">
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice11.jpg" class="card-img-top" alt="pic4" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice10.jpg" class="card-img-top" alt="pic5" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" style="margin-bottom: 30px; margin-top:30px">
                <img src="images/skinservice9.jpg" class="card-img-top" alt="pic6" >
                <div class="card-body">
                  <h5 class="card-title">First Service label</h5>
                  <p class="card-text">Service Description Paragraph.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

      <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div> 
</section>
  
<main>
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

<div class="last-container" style="display: flex; padding: 50px;">
            <div class="last1-container" style="text-align: left; width: 50vh;">
                <p style="font-weight: bold; font-size: 50px; font-family: roboto;">Z-Skin</p>
                <p>Care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention</p>
            </div>
            <div class="lastcontain"  style="display: flex;"> 

            
            <div class="last2-container" style="text-align: left; margin-left:50px">
            <p style="font-weight: bold; font-size: 20px; font-family: roboto;">Navigation</p>
            <ul class="black"style="list-style-type: none; padding: 0;">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="service.php">Services</a></li>
                <li><a href="FAQ.php">FAQs</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="reschedule.php">Reschedule</a></li>
            </ul>
        </div>


            <div class="last3-container" style="text-align: left; margin-left:70px ">
                <p style="font-weight: bold; font-size: 20px; font-family: roboto;">Social Media</p>
                <ul style="list-style-type: none; padding: 0;">
                    <li><span style="font-weight:bold;">FaceBook: <br>
                </span>https://www.facebook.com/Zskincarecenter</li>
                </ul>
            </div>

            
            </div>
        </div>



    

    <footer class="styled-footer">
        <div class="footer-content">
            <h3>Z-Skin Care</h3>
            <p>Unit 4 One Kalayaan Place Building 284 Samson Road Victory Liner Compound, Caloocan, Philippines</p>
            <p>Email: zskincarecenter@gmail.com</p>
            <p>Phone: 0915 759 2213</p>
        </div>
        <div class="footer-social">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>




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
    /* autoplay: {
        //delay: 5000, // Set the time in milliseconds (e.g., 3000ms = 3 seconds)
        disableOnInteraction: false, // Autoplay continues after user interaction
    }, */
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
    delay: 75,
  duration: 1500,
  opacity: 0,
  distance: "50%",
  origin: "top",
  reset: true
});
ScrollReveal().reveal('#s2',{
  delay: 125,
  duration: 1500,
  opacity: 0,
  distance: "50%",
  origin: "right",
  reset: true
});
ScrollReveal().reveal('#s4',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "50%",
  origin: "top",
  reset: true
});
ScrollReveal().reveal('#s3',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "50%",
  origin: "top",
  reset: true
});
</script>

</body>

</html>

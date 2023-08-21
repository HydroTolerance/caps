<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-rD27HZnRnF+2ovqZ0uKkDjKc8zLl2vIfC2s8yRTAl5SGneMqqc3fBnF7HjKgGhArINpSyyxV6y0Woj+fjL/oMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
  <style>
    .bgcolornavbar {
      background-color: #6537AE;
    }
    .navbar-nav .nav-link{
      color: white;
      padding: 10px;
    }
    .navbar-brand {
      color: white;
      font-weight: bold;
      text-decoration: none;
      margin-left: 30px;
    }
    /* Center the ul element */
    .navbar-nav-center {
      position: absolute;
      right: 400px;
      top: 50%;
      transform: translateY(-50%);
      
    }

    .custom-button {
      background-color: #FFFFFF;
      color: #6537AE;
      border-radius: 20px;
      padding: 0.365rem 1rem;
    }

    .custom-button2 {
      background-color: #6537AE;
      color: #FFFFFF;
      border-radius: 20px;
      padding: 0.500rem 2rem;
      font-size: 25px;
    }

    .custom-button3 {
      background-color: #ffffff;
      color: #6537AE;
      border-radius: 20px;
      padding: 0.500rem 2rem;
      font-size: 25px;
    }


    .navbutton {
      position: absolute;
      right: 300px;
      top: 50%;
      transform: translateY(-50%);
    }
    .header-image {
      width: 100%;
      max-width: 100%;
      height: auto;
      margin-top: 20px;
    }
    .text-container {
      text-align: center;
      margin-top: 20px;
    }
    .text-container h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .text-container p {
      font-size: 16px;
      margin-bottom: 0;
    }
    .containers-second {
        padding-bottom: 50px;
        background-image: url(img/web_img/MODEL.svg);
        background-size: cover;
        background-position: center;
        height: 100vh;
    }

    .secondcontainer{
      background-color: #6537AE;
      height: 80vh;

    }

    .aboutpara {
      color: #ffffff;
      

    }

    .container-service {
      color: #6537AE
    }

    footer{
      background-color: #6537AE;
      color: #ffffff;
      
      height: 250px;
    }

    
   
    

  </style>
</head>
<body>
  
  <nav class="navbar navbar-expand-lg bgcolornavbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="#" style="font-size: 30px; font-family: 'Fira Sans', sans-serif;">ZephyDerm</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav navbar-nav-center mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="home.php" style="margin-right: 30px; font-size:20px;">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php" style="margin-right: 30px; margin-left:30px; font-size:20px;">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="service.php" style="margin-right: 30px; margin-left:30px; font-size:20px;">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="faq.php" style="margin-right: 30px; margin-left:30px; font-size:20px;">FAQs</a>
          </li>
        </ul>
        <ul class="navbutton ms-auto">
           <div class="nav-item">
            <button class="btn btn-primary btn-sm rounded-pill custom-button" type="button" style="font-size:20px;">Login</button>
            </div>
        </ul>
        <div class="d-flex ms-auto">
          <a class="btn btn1 me-2" href="#">
            <img src="./img/web_img/FB icon.svg" alt="Facebook" style="width: 35px; height: 35px;">
          </a>
          <a class="btn btn2" href="#">
            <img src="./img/web_img/IG icon.svg" alt="Instagram" style="width: 35px; height: 35px;">
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="containers-second">
    <div class="row">
      <div class="col-12 text-left">
      <h1 style= "margin: 120px 0 0 80px; font-size: 95px; font-family: 'Fira Sans', sans-serif;">Discover your <br>
      <span style="font-weight: bold;">Best Skin</span> with <br>
      <span style="font-weight: bold;">Expert Care</span></h1>
      </div>

        <div class="nav-item">
            <a href="booking.php"><button class="btn btn-primary btn-sm rounded-pill custom-button2" type="button" style= "margin: 150px 0 0 220px;">Book Now</button></a>
        </div>     

    </div>
  </div>




  

<div class="d-flex mb-3 secondcontainer">
      <div class="aboutpara">
        <h1 class="aboutus" style="font-weight: bold; margin: 20px 0 0 110px;">About Us </h1>
        <p  style = "font-size: 20px;   margin: 20px 0 0 110px;">Get to know Our Story</p>
        <p  style = "font-size: 20px;   margin: 100px 0 0 110px;">We are a leading dermatology clinic dedicated to helping our <br>
        patients achieve optimal skin health and wellness. Our <br>
        experienced team offers personalized medical and cosmetic <br>
        dermatology services using the latest advancements in the <br>
        field. Contact us to schedule an appointment and experience <br>
         our patient-centered care for yourself.</p>

         <div class="nav-item">
            <button class="btn btn-primary btn-sm rounded-pill custom-button3" type="button" style= "margin: 70px 0 0 110px;">Our Story</button>
          </div>  

      </div>

     
 
  <div class="ms-auto p-2" style="margin: 20px 150px 0 0; height: 200px;"><img src="./img/web_img/MODEL 2.svg" alt="Image Description" height="550px" width="400px">
  </div>
</div>

<div class="container-service">
    <h2 style="font-weight: bold; font-size: 15; margin: 20px 0 0 30px;">Services</h2>
    <p style = "font-size: 20px;   margin: 20px 0 0 30px;">What Zephyris Skin Care Center Offer</p>
  </div>

  <div class="carouselsection">
  <div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="row">
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/1.svg" class="card-img-top" alt="pic1" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/2.svg" class="card-img-top" alt="pic2" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/3.svg" class="card-img-top" alt="pic3" >
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="row">
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/4.svg" class="card-img-top" alt="pic4" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/5.svg" class="card-img-top" alt="pic5" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/6.svg" class="card-img-top" alt="pic6" >
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="row">
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/7.svg" class="card-img-top" alt="pic7" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/8.svg" class="card-img-top" alt="pic8" >
            </div>
          </div>
          <div class="col">
            <div class="card" style="margin-bottom: 30px; margin-top:30px">
              <img src="./img/carousel/9.svg" class="card-img-top" alt="pic9" >
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>





  <footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="footer-container d-flex align-items-center">
          <h3  style = "margin: 50px 0 0 0px;">ZephyDerm</h3>
         
        </div>
      </div>
      <div class="col-md-4">
        <div class="footer-container d-flex align-items-center">
          
          <p  style = "margin: 50px 0 0 0px;">
            Unit 4 One Kalayaan Place Building 284 <br>
            Samson Road Victory Liner Compound <br>
            1440 Caloocan, Philippines
            <br>
            <br>zskincarecenter@gmail.com</p>
        </div>
        <div class="iconcontainer" style="margin: 10px 0 0 30px;">
            <img src="./img/web_img/FB icon.svg" alt="FaceBook">
            <img src="./img/web_img/IG icon.svg" alt="Instagram">
    </div>
      </div>
      <div class="col-md-4">
        <div class="footer-container d-flex align-items-center" >
          <p style= "margin:50px 0 0 0px;">Call or Text: 0915 759 2213 <Br>
            Clinic Hours: 1:00pm - 4:30pm <br>
            Monday, Wednesday, Friday & Saturday</p>
        </div>
      </div>
    </div>
  </div>
</footer>






  
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

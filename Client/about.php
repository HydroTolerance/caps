<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us</title>
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

      .navbutton {
      position: absolute;
      right: 300px;
      top: 50%;
      transform: translateY(-50%);
    }
    .container {
  text-align: justify;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

p {
  font-size: 16px;
  line-height: 1.5;
}


    .custom-button {
      background-color: #FFFFFF;
      color: #6537AE;
      border-radius: 20px;
      padding: 0.365rem 1rem;
    }
      
    .containers-second {
         /* Set the container height to 100% of the viewport height */
         /* Add padding if needed */
        padding-bottom: 50px; /* Add padding if needed */
        background-image: url(./img/web_img/picabout.png);
        background-size: cover;
        background-position: center;
        height: 60vh;
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
    font-size: 70px;
    font-weight: bold;
  }

  .item-container1 p:last-child {
    font-size: 40px;
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

  .container3 {
    
    color: #ffffff;
    background-color: #6537AE;
    display: flex;
    align-items: flex-start;
    flex-direction: row;
    justify-content: center;
  }

  .container3 .image {
    margin-right: 50px;
    margin-top: 30px;
    
  }

  .container3 .image img {
    width: 350px;
    height: 350px;
  }

  .container3 .paragraph {
    
    margin-top: 30px;
  }

   
  .container4 {

    display: flex;
    align-items: flex-start;
    flex-direction: row;
    justify-content: center;

  }

  .container4 .image2 img {
    width: 511px;
    height: 515px;
  }

  .container4 .image2 {
    margin-right: 50px;
    margin-top: 30px;
    
  }
  
  .container5 {

display: flex;
align-items: flex-start;
flex-direction: row;
justify-content: center;

}

.container5 .image3 img {
    width: 511px;
    height: 515px;
  }

  .container5 .image3 {
    margin-left: 100px;
    margin-top: 30px;
    margin-bottom: 50px;
    
  }

 .container5 .paragraph3{
    margin-right: 20px;
    margin-left: 100px;
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
            <a class="nav-link" href="index.php" style="margin-right: 30px; font-size:20px;">Home</a>
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
  
</div>

<div class="item-container1 " style=" font-family: 'Fira Sans', sans-serif;">
    <p>OUR STORY</p>
    <p>Get to Know Our Story</p>
  </div>

  <div class="item-container2 ">
    <p>We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. <br>
Our experienced team offers personalized medical and cosmetic dermatology services using the latest <br>
 advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for <br>
  yourself.</p>
    
  </div>

<div class="container3 d-flex justify-content-center align-items-center">
  <div class="image" style="margin-left: 200px;">
    <img src="./img/doc.png" alt="Image">
  </div>
  <div class="container" style="margin-left:-10px;">
    <p><span style="font-weight: bold; font-size: 20px;">Dr. Zharlah Gulmatico-Flores MD, MMPHA, FPDS, FPADSFI </span> <br><br><br>
    Dr. Zharlah A. Gulmatico-Flores, MD, FPDS. FPADSFI obtained
     her Doctor of Medicine degree at Our Lady of Fatima University. 
     She completed her residency training in Dermatology at the Jose R. Reyes 
     Memorial Medical Center and went on to pursue further training on Mohs Micrographic
      Surgery at Yonsei Severance Hospital in Seoul, South Korea and under the tutelage 
      of Professor Isaac Zilinsky and Dr. Euhud Miller at Assaf Harofeh Medical Center 
      in Israel. At present, Dr. Gulmatico-Flores is the Training Officer and Research 
      Coordinator of the Department of Dermatology at Jose R. Reyes Memorial Medical Center
       and is the Chairperson of the same institution's Institutional Review Board Committee. 
       She is an Associate Professor III at the Metropolitan Medical Center College of Medicine 
       and Assistant professor III in Our Lady of Fatima University College of Medicine in the 
       Department of Biochemistry. She is a Fellow and the Head of the Public Relations External 
       Affairs Committee of the Philippine Dermatological Society. She is a Fellow of the American 
       Academy of Dermatology and European Academy of Dermatology and Venereology. She is an active 
       consultant at Quezon City General Hospital, ACE Medical Center, and Zephyris Skin Care Center.</p>
  </div>
</div>


<div class="container4">
  <div class="image2">
    <img src="./img/web_img/zephy.png" alt="Image">
  </div>
  <div class="paragraph2">
    <p style= "margin: 100px 0 25px 100px; font-size: 40px; font-weight: bold; color: #6537AE; ">VISION</p>

    <p style= "font-size: 20px;  ">Our vision for the clinic is to be a leading provider of <br>
    dermatology services in your community, known for <br>
     exceptional patient care and innovative treatment <br>
      options. We aim to provide you with personalized and <br>
       comprehensive care, offer innovative treatment options, <br>
        prioritize your comfort and satisfaction, and promote skin <br>
         health education. Ultimately, we want to create a warm <br>
          and welcoming environment where you feel comfortable <br>
           and confident in your care, and to be a trusted resource <br>
            for you, helping you achieve optimal skin <br>
             health and wellness. <br><br><br> </p>
  </div>
</div>


<div class="container5">
  <div class="paragraph3">
    <p style= "margin: 150px 0 25px 100px; font-size: 40px; font-weight: bold; color: #6537AE; ">MISSION</p>

    <p style= "font-size: 20px;">Our mission is to provide you with the highest quality of <br>
     care and help you achieve optimal skin health. We are  <br>
      committed to providing you with comprehensive, <br>
       personalized care, staying up-to-date with the latest <br>
        advancements in dermatology, and treating you with <br>
         compassion, respect, and individualized attention. <br><br><br> </p>
  </div>
  <div class="image3">
    <img src="./img/web_img/clinic.png" alt="Image">
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



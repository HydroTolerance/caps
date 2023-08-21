<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>service</title>
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
        background-image: url(modelss.svg);
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

  

  .container1 {
    display: flex;
    align-items: flex-start;
    flex-direction: column;

  }

  .container1 ul {
    list-style-type: none;
    padding: 0;
    margin-left: 20px;
    margin-top: 20px;
  }

  .container1 li {
    margin-bottom: 10px;
    color: #6537AE;
    font-size: 30px;
    font-weight: bold;
   

  
    
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
        <!-- Add navbar-nav-center class to center the ul element -->
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
            <img src="FB icon.svg" alt="Facebook" style="width: 35px; height: 35px;">
          </a>
          <a class="btn btn2" href="#">
            <img src="IG icon.svg" alt="Instagram" style="width: 35px; height: 35px;">
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="containers-second">
  
</div>


<div class="item-container1 " style=" font-family: 'Fira Sans', sans-serif;">
    <p>OUR SERVICES</p>
    <p>Consult a Board Certified Dermatologist</p>
  </div>


  <div class="item-container2 ">
    <p>We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. <br>
Our experienced team offers personalized medical and cosmetic dermatology services using the latest <br>
 advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for <br>
  yourself.</p>

</div>

<hr>

<br><br><br>
<div>
<div class="container1" style="margin-left: 50px; margin-bottom: 30px; margin-top: -40px;">
  <?php
  include "../db_connect/config.php";
  $result = mysqli_query($conn, "SELECT * FROM service");
  while ($row = mysqli_fetch_array($result)) {
      ?>
      <div class="faq-item">
          <h1 style="color:#6537AE; font-weight:bolder"><?php echo $row['services']; ?></h1>
      </div>
      <?php
  }
  ?>
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
            <img src="FB icon.svg" alt="FaceBook">
            <img src="IG icon.svg" alt="Instagram">
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

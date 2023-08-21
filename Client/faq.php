<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>faq</title>
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
        background-image: url(./img/web_img/talk.svg);
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
  padding: 30px;
}

.container1 .faq-item {
  margin-top: 30px;
  border-bottom: 3px solid #ccc;
  padding-bottom: 20px;
}

.container1 .faq-item h1 {
  color: #6537AE;
  
}

.container1 .faq-item p {
  font-size: 20px;
}

  hr {
    height: 2px; /* Adjust the thickness of the line */
    background-color: black;
    margin: 5px 0; /* Adjust the spacing above and below the line */
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
    <p>FAQs</p>
    <p>Frequently Asked Questions</p>
  </div>

 


  <div class="container1">
  <?php
  include "../db_connect/config.php";
  $result = mysqli_query($conn, "SELECT * FROM faq");
  while ($row = mysqli_fetch_array($result)) {
      ?>
      <div class="faq-item">
          <h1><?php echo $row['question']; ?></h1>
          <p><?php echo $row['answer']; ?></p>
      </div>
      <?php
  }
  ?>
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

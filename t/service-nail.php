<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">


    <style>
    
    body {
        background-color:white;
    }
    

    .navbar-nav .nav-link {
    color: white !important;
    }

    .navbar-nav .nav-link:hover {
    color: #E1BB86 !important;
    }

    

    .styled-footer {
    background-color:#6537AE;
    color: #fff;
    padding: 20px;
    text-align: center;
    }


.footer-content {
    max-width: 600px;
    margin: 0 auto;
}

.footer-content h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.footer-content p {
    font-size: 0.9em;
    margin-bottom: 5px;
}

.footer-social a {
    font-size: 1.2em;
    margin: 0 10px;
    color: #fff;
    text-decoration: none;
}

.footer-social a:hover {
    color: #e1bb86; /* Change color on hover */
}

.nav-item{
           
           font-size: 20px;
           margin-right: 15px;

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

.services-container p {

display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  height: 20vh;
  color: black;
  font-size: 40px;
  font-style: san-serif;

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


 </style>


</head>

<body>

<nav class="navbar navbar-expand-lg" style="background-color: #6537AE; ">
        <a class="navbar-brand" href="#" style="color: white;" ><span style="font-weight: bold; font-size: 40px; margin-left: 25px;">Z-Skin</span></a>
        <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">

        
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="service.php">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="FAQ.php">FAQs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reschedule.php">Reschedule</a>
            </li>
        </ul>

            <ul class="navbar-nav ml-auto">
            <li class="litems1" style="padding: 3px;">
                <a href="../login.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Login</a>
                </li>
                <li class="litems1" style="padding: 3px;">
                <a href="booking.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Book an Appointment</a>
                </li>   
            </ul>    
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


  <div class="item-container2 " style=" font-family: Poppins;">
    <p>We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. <br>
Our experienced team offers personalized medical and cosmetic dermatology services using the latest <br>
 advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for <br>
  yourself.</p>

</div>

<hr class="centered-line">



<div class="services-container">

<p sytle="font-family: roboto;">SERVICES</p>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto"> <!-- mx-auto centers the items -->
        <li class="nav-item">
          <a class="nav-link" href="service.php">Skin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="service-hair.php">Hair</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="service-nail.php">Nails</a>
        </li>
        <!-- Add more items as needed -->
      </ul>
    </div>
  </div>
</nav>
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
<br>
<br>
<hr class="centered-line">







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

</body>

</html>

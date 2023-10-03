<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>About</title>
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
    

   .about-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        height: 60vh;
        background-image: url('image2.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        
    }

    .about-text {
        color: white;
        font-size: 80px;
        
        }

    .centered-line {
        margin: 0 auto;
        width: 90%;
        
        
        }
    
        .nav-item{
           
            font-size: 20px;
            margin-right: 15px;

        }

        .styled-footer {
    background-color: #6537AE;
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
  



 </style>


</head>

<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #6537AE; ">
        <a class="navbar-brand" href="#" style="color: white;" ><span style="font-weight: bold; font-size: 40px; margin-left: 25px;">Z-Skin</span></a>
        <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">

        
        <ul class="navbar-nav mx-auto" >
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">FAQs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Reschedule</a>
            </li>
        </ul>

            <ul class="navbar-nav ml-auto">
            <li class="litems1" style="padding: 3px;">
                <a href="about.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Login</a>
                </li>
                <li class="litems1" style="padding: 3px;">
                <a href="about.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Book an Appointment</a>
                </li>  
            </ul>    
        </div>        
    </nav>



       
       <div class="about-container">
            <div class="about-text">
                <p><span style="font-weight: bold; font-family: roboto;">ABOUT US</span>
               </p>
            </div>
        </div> 

        <div class="story-container" style="display: flex; padding: 50px; ">
            <div class="ourstory-text" style="text-align: left; margin-left: 30px; ">
                <p><span style="font-weight: bold; color: #6537AE; font-size: 35px; font-family: roboto;">OUR STORY</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness.
                Our experienced team offers personalized medical and cosmetic dermatology services using the latest
                advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for
                yourself.</p>
            </div>
            <div class="ourstory-text" style="text-align: center; ">
                <img src="images/image1.jpg" alt="Description of the image" width="500" height="300" style="border-radius: 10px;">

            </div>
        </div> 

        <hr class="centered-line">

        <div class="doc-container" style="display: flex; padding: 50px; ">
            <div class="images/doc-text" style="text-align: center;">
                <img src="doc.png" alt="Description of the image" width="500" height="300" style="border-radius: 10px;">
            </div>
            <div class="doc-text" style="text-align: right; margin-left: 30px; ">
                <p><span style="font-weight: bold; color: #6537AE; font-size: 35px; font-family: roboto;">Dr. Zharlah Gulmatico-Flores MD, MMPHA, FPDS, FPADSFI</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">Dr. Zharlah A. Gulmatico-Flores, MD, is a distinguished dermatologist with extensive training in Mohs Micrographic Surgery. She serves as Training Officer at Jose R. Reyes Memorial Medical Center and holds academic positions at two medical colleges. Dr. Gulmatico-Flores is an active member of professional dermatological societies and consults at multiple medical centers.
                </p>
            </div>
        </div>
        
        <hr class="centered-line">

        <br>

        <div class="awards-container">
            <div class="awards-text" style=" text-align: center; font-size: 70px; font-weight: bold;  font-family: roboto;">
                <p>AWARDS</p>
            </div>
        </div>

        
        <div class="award1-container" style="display: flex; padding: 50px; background-color:#6537AE; color: white; ">
            <div class="award1-text" style="text-align: center;">
                <img src="images/image4.jpg" alt="Description of the image" width="500" height="300" style="border-radius: 10px;">
            </div>
            <div class="award1-text" style="text-align: left; margin-left: 30px;">
                <p><span style="font-weight: bold; font-size: 35px; font-family: roboto;">Best Dermatology Clinic</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">Z-Skin Care Center has been honored with the prestigious accolade of Best Dermatology Clinic. This well-deserved recognition is a testament to the unwavering commitment and expertise demonstrated by the dedicated team at Z-Skin Care Center. Their tireless efforts in providing cutting-edge dermatological care, coupled with a steadfast dedication to their clients' well-being, have set them apart as leaders in the field. 
                </p>
            </div>
        </div>

        

        <div class="award2-container" style="display: flex; padding: 50px; background-color:#6537AE; color: white; ">
           
            <div class="award2-text" style="text-align: right; margin-right: 30px;">
                <p><span style="font-weight: bold; font-size: 35px; font-family: roboto;">Clinic Award</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">Z-Skin Care Center has been bestowed with the prestigious honor of being recognized as one of the most hygienic clinics in the industry. This remarkable achievement underscores the unwavering commitment of the Z-Skin Care Center team towards maintaining the highest standards of cleanliness and safety. Their rigorous protocols and meticulous attention to detail have set a new benchmark for hygiene in the realm of skincare and dermatology. 
                </p>
            </div>
            <div class="award2-text">
                <img src="images/image5.jpg" alt="Description of the image" width="500" height="300" style="border-radius: 10px;">
            </div>
        </div>

        <br>
        <hr class="centered-line">

        
    
        <div class="missionvision-container" style="display: flex; padding: 50px; ">
           
            <div class="vision-text" style="text-align: left; margin-right: 30px;">
                <p><span style="font-weight: bold; font-size: 35px; font-family: roboto;">Vision</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">Our vision for the clinic is to be a leading provider of
                    dermatology services in your community, known for
                    exceptional patient care and innovative treatment
                    options. We aim to provide you with personalized and
                    comprehensive care, offer innovative treatment options,
                    prioritize your comfort and satisfaction, and promote skin
                    health education. Ultimately, we want to create a warm
                    and welcoming environment where you feel comfortable
                    and confident in your care, and to be a trusted resource
                    for you, helping you achieve optimal skin
                    health and wellness. 
                </p>
            </div>
            <div class="vision-text">
                <img src="images/image6.png" alt="Description of the image" width="400" height="400" style="border-radius: 10px;">
            </div>
        </div>

        <hr class="centered-line">



        <div class="missionvision2-container" style="display: flex; padding: 50px; ">

            <div class="mission-text">
                <img src="images/image7.png" alt="Description of the image" width="400" height="400" style="border-radius: 10px;">
            </div>
           
            <div class="mission-text" style="text-align: right; margin-left: 30px;">
                <p><span style="font-weight: bold; font-size: 35px; font-family: roboto;">Mission</span></p>
                <br>
                <p style="font-family: poppins; font-size: 20px;">Our mission is to provide you with the highest quality of
                    care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention.
                </p>
            </div>
            
            
        </div>

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
                <p>Home</p>
                <p>About Us</p>
                <p>Services</p>
                <p>FAQs</p>
                <p>Resechedule</p>
            </div>

            <div class="last3-container" style="text-align: left; margin-left:70px ">
                <p style="font-weight: bold; font-size: 20px; font-family: roboto;">Social Media</p>
                <p>FaceBook</p>
                <p>Instagram</p>
                <p>Tiktom</p>
            </div>
            <div class="last4-container" style="text-align: left; margin-left:90px ">
                <p style="font-weight: bold; font-size: 20px; font-family: roboto;">Contact Us</p>
                <p>Local Hotline</p>
                <p>Contact No.</p>
                <p>Email</p>
            </div>
            </div>
        </div>

        <footer class="styled-footer">
        <div class="footer-content">
            <h3>Company Name</h3>
            <p>Address: 123 Main Street, City, Country</p>
            <p>Email: info@example.com</p>
            <p>Phone: 123-456-7890</p>
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

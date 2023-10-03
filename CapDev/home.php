<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
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
    

   .content-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        height: 80vh;
        background-image: url('newpic1.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        
    }

    .CC {
        color: black;
        font-size: 80px;
        
    }
    
        
    .service-container{
        background-image: url('image9.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        height:90vh;
        align-items: center;
        justify-content:center;
                
    }

    .service-cards{
        display:flex;
        align-items: center;
        justify-content:center;
        margin-top: 70px;
    }


    .about{
    background: url(ZLogo.svg) no-repeat left;
    background-size: 35%;
    background-color: #6537AE;
    overflow: hidden;
    padding: 100px 0;
    }
    .inner-section{
        width: 55%;
        float: right;
        background-color: white;
        padding: 140px;
        box-shadow: 13px 12px 8px rgba(0,0,0,0.3);
    }
    .inner-section h1{
        margin-bottom: 30px;
        font-size: 30px;
        font-weight: 900;
    }
   .text{
        font-size: 15px;
        color: #545454;
        line-height: 30px;
        text-align: justify;
        margin-bottom: 40px;
    }

    

    .container-service {
      color: black;
      
    }

    .card {
    width: 18rem;
    margin: 10px; /* Adjust the value as needed */
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

.centered-line {
        margin: 0 auto;
        width: 90%;    
 }


 </style>


</head>

<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #6537AE; ">
        <a class="navbar-brand" href="#" style="color: white;" ><span style="font-weight: bold; font-size: 40px; margin-left: 25px;">Z-Skin</span></a>
        <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">

        
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
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



        <div class="content-container">
            <div class="CC">
                <p> Discover your <span style="font-weight: bold; ">Best Skin</span> <br>
                with <span style="font-weight: bold;">Expert Care</span></p>
            </div>
        </div>
        
        
   

    <div class="about-container" style="display: flex; padding: 50px;;">
        <div class="about-info">
            <p style="font-weight: bold; font-size: 50px; font-family: roboto; color: #6537AE"> About Us</p>
            <p style=" font-size: 20px; font-family: poppins;">Get to know our Story</p>
            <br>
            <p style="font-size: 20px; font-family: poppins;">We are a leading dermatology clinic dedicated to helping our
                patients achieve optimal skin health and wellness. Our
                experienced team offers personalized medical and cosmetic
                dermatology services using the latest advancements in the
                field. Contact us to schedule an appointment and experience
                our patient-centered care for yourself.</p>
                <a href="about.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins;">Our Story</a>
        </div>
        <div class="about-image">
                <img src="images/image8.jpg" alt="Description of the image" width="400" height="400" style="border-radius: 10px;">
            </div>

    </div>


   
    
    <hr class="centered-line">

    <br>

    <div class="service-background">
        <div class="service-container">
                <div class="service-header" Style=" text-align: center;">
                    <p><span style="font-size: 50px; color: black; font-family: roboto;" >Services </span></p>
                    <p><span style="font-size: 20px; color: black; font-family: poppins;">Z-Skin offers a range of services including treatments for hair, skin, and feet.</span></p>
                </div>
                <div class="service-cards">
                    <div class="card" style="width: 18rem; height: 100%;">
                        <img src="images/pichairservice.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Hair Service</h5>
                            <p class="card-text" >Revitalize your locks with our nourishing hair treatment, designed to restore shine, strength, and vitality to even the most damaged strands.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem; height: 100%;">
                        <img src="images/picskin.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Skin Service</h5>
                            <p class="card-text" >Revitalize your skin with our custom-tailored treatment, designed to rejuvenate, nourish, and reveal your natural radiance with the help of our therapists.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem; height: 100%;">
                        <img src="images/picfoot.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Foot Service</h5>
                            <p class="card-text"> Try a foot treatment at our exquisite spa, where skilled therapists oerform nourishing treatments, leaving experience relaxation and comfort.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>


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

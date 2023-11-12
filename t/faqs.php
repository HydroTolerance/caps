<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;600&display=swap">
        
        <link rel="stylesheet" href="style.css">
        <title>FAQ</title>

    </head>
    <body>
        <header>
            <div class="icon-text-container">
                 
                <span class="text">ZephyDerm</span>
              </div>

            <nav>
                <ul>
                    <li>
                        <a href="#">Home</a>
                    </li>

                    <li>
                        <a href="#">About Us</a>
                    </li>

                    <li>
                        <a href="service.html">Services</a>
                    </li>

                    <li>
                        <a href="#">FAQ</a>   
                    </li>
                        
                    <li>
                        <div class="button"></div>
                <a href="#" class="btn btn1">Login
                </a>
                    </li>

                </ul>
            </nav>

            <navicons>
                <ul>

                <li><a href="#"><img src="FB icon.svg" alt="Icon"> </a> </li>
                <li><a href="#"><img src="IG icon.svg" alt="Icon"> </a> </li>
            </ul>
        </navicons>
        
        </header>
        <div>
          <img src="talk 1.svg" alt="logo" style="background-repeat: no-repeat; width: 100%; height:auto;">
        </div>
        <div style="background-color: #6537AE; padding: 80px; text-align:center; color: #fff; margin-bottom: 50px;">
        <h1>FAQS</h1><br><br>
        <h3>Frequently Asked Question</h3>
        </div>
          
        <?php
                    include "../db_connect/config.php";
                    $result = mysqli_query($conn,"SELECT * FROM faq");
                    while($row = mysqli_fetch_array($result)) {
                        ?>
                            <h1 style="color: #6537AE"><?php echo $row['question']?></h1><br>
                            <p style="font-size: 20px;"><?php echo $row['answer']?></p>
                            
                            <br>
                            <hr><br>
                <?php
                }
                ?>

      <footer>
        <div class="footer" style="margin-top:50px;">

        
           <div class="footainer">
            
            <h1 class="titlename firasans">ZephyDerm</h1>

            </div>
            
           <div class="footext">
                <p class="footeraddress" >Unit 4 One Kalayaan Place Building 284 <br>
                     Samson Road Victory Liner Compound <br>
                      1440 Caloocan, Philippines</p>

                <p class="email">zskincarecenter@gmail.com</p>
                
                <div class="ds"><ul>
                    <li><a href="#"><img src="FB icon.svg" alt="Icon"> </a> </li>
                    <li><a href="#"><img src="IG icon.svg" alt="Icon"> </a> </li>
                </ul></div>

            </div>

            <div class="footext2">

                <p class="footeropen">Call or Text:0915 759 2213 <br>
                    Clinic Hours: 1:00pm - 4:30pm <br>
                    Monday, Wednesday, Friday & Saturday</p>

                </div>

        </div>
    </ul>
    </footer>



       
       
    

    


           

           
        
            
        
    </body>
</html> 
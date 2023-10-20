<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: unauthorized.php");
    exit;
}
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$num = $_GET['number'];
$email = $_GET['email'];
$message = $_GET['health_concern'];
$option = $_GET['services'];
$d = $_GET['date'];
$time = $_GET['time'];
$reference = $_GET['reference_code'];

$to = $email;
$subject = "Appointment Summary";
$body = "<html><body style='color: #000000;'>";
$body .= "<p><img src='cid:dermalogo.png' alt='Image' height='100px' width='100%'></p>";
$body .= "<p>Dear $firstname $lastname,</p>";
$body .= "<p>Thank you for your appointment!</p>";
$body .= "<p>Here is your appointment summary:</p>";
$body .= "<ul>";
$body .= "<li><strong>Name:</strong> $firstname $lastname</li>";
$body .= "<li><strong>Phone number:</strong> $num</li>";
$body .= "<li><strong>Email:</strong> $email</li>";
$body .= "<li><strong>Message:</strong> $message</li>";
$body .= "<li><strong>Service:</strong> $option</li>";
$body .= "<li><strong>Date:</strong> " . date("F j, Y", strtotime($d)) . "</li>";
$body .= "<li><strong>Time:</strong> $time</li>";
$body .= "</ul>";
$body .= "<p style='font-weight: bold; font-size: 20px;'>Reference Code: $reference</p>";
$body .= "<p>Thank you for your transaction!</p>";
$body .= "<p>";
$body .= "<a href='localhost/caps/t/reschedule.php?reference_code=$reference' style='display:inline-block; padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Reschedule</a>";
$body .= "<a href='cancel.php?reference_code=$reference' style='display:inline-block; padding: 10px 20px; background-color: #FF0000; color: #fff; text-decoration: none; border-radius: 5px;'>Cancel</a>";
$body .= "</p>";
$body .= "</body></html>";

// Gmail SMTP configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'blazered098@gmail.com'; // Replace with your Gmail email address
$smtpPassword = 'nnhthgjzjbdpilbh'; // Replace with your Gmail password

// Create a new PHPMailer instance
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);

// Enable SMTP debugging (optional)
$mail->SMTPDebug = 0;

// Set the SMTP parameters for Gmail
$mail->isSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;

// Set the email parameters
$mail->setFrom($smtpUsername, 'Zephyris Skin Care');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = $body;

// Add image attachment
$imagePath = 'img/dermalogo.png';
$mail->addEmbeddedImage($imagePath, 'dermalogo.png', 'dermalogo.png'); // Attach the image and assign it a content ID (CID)

$mailSent = $mail->send();

?>


<!DOCTYPE html>
<html>
<head>
  <title>Appointment Summary</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
  <link rel="stylesheet" href="./../">

  <style>
    /* Add your custom CSS styles here */
    .center-content {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    
    .background-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none; /* Prevent the confetti container from blocking interactions */
      z-index: 1; /* Place the confetti behind the content */
    }

    .container {
      position: relative;
      z-index: 99999;
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg" style="background-color: #6537AE; z-index: 99999;">
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
        </ul>

            <ul class="navbar-nav ml-auto">
            <li class="litems1" style="padding: 3px;">
                <a href="login.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Login</a>
                </li>
                <li class="litems1" style="padding: 3px;">
                <a href="booking.php" class="btn btn-primary" style="background-color:  #6537AE; font-family: poppins; border-color: white;">Book an Appointment</a>
                </li>   
            </ul>    
        </div>        
    </nav>
<body style="background-color:#eee;">
  <div class="center-content">
    <!-- Background container for confetti -->
    <div class="background-container"></div>
    <div> <!-- Apply padding to the summary box -->
      <div class="container mt-2">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="canvas text-center p-5 bg-white border border-3 rounded mb-3">
              <h2 class="mb-3 text-success">Appointment Summary</h2>
              <p><strong>Name:</strong> <?php echo "$firstname $lastname"; ?></p>
              <p><strong>Phone number:</strong> <?php echo $num; ?></p>
              <p><strong>Email:</strong> <?php echo $email; ?></p>
              <p><strong>Message:</strong> <?php echo $message; ?></p>
              <p><strong>Services:</strong> <?php echo $option; ?></p>
              <p><strong>Date:</strong> <?php echo date("F j, Y", strtotime($d)); ?></p>
              <p><strong>Time:</strong> <?php echo $time; ?></p>
              <p><strong>Reference Code:</strong> <?php echo $reference; ?></p>
              <p>Thank you for your transaction!</p>
              <p>Check your email (<strong><?php echo $email; ?></strong>) </p>
              <p>for your Appointment Summary</p>
              
            </div>
            <button id="downloadButton" class="btn btn-primary">Download Summary as Image</button>
          </div>
        </div>
        <img src="fpdf/fpdf.php" alt="">
      </div>
    </div>
  </div>
  <script src="js/book.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('downloadButton').addEventListener('click', function () {
      const summaryContainer = document.querySelector('.canvas');
      html2canvas(summaryContainer).then(function (canvas) {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'appointment_summary.png';
        link.click();
      });
    });
  });
</script>

</body>
</html>





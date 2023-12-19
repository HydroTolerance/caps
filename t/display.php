

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
$currentdate = $_GET['created'];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Appointment Summary</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">

  <style>
          @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}
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
      pointer-events: none;
      z-index: 1;
    }

    .container {
      position: relative;
      z-index: 99999;
    }
    .context{
  margin: 0;
  text-indent: 2rem;
  text-align: justify;
  font-size: 15px;
}
  </style>
</head>
<body style="background-color:#eee;">

<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" style="margin-right: 37px;" href="../index.php">
    <img src="images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon text-white"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white" href="../index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="contact.php" id="s5">Contact</a>
        </li>
      </ul>
      <a href="../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
      <a href="booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
    <div class="container-fluid my-5">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="bg-white p-4 rounded shadow-sm border">
            <div class="text-center mb-3">
              <img src="images/6.png" alt="" class="img-fluid" height="100px" width="100px">
            </div>
            <h2 class="mb-4 text-center" style="color:#6537AE; font-family: Lora;">APPOINTMENT SUMMARY</h2>
          <div class="row border mx-auto py-4">
            <div class="col-lg-6">
              <p><strong>Name:</strong> <?php echo "$firstname $lastname"; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Services:</strong> <?php echo $option; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Phone number:</strong> <?php echo $num; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Schedule Date:</strong> <?php echo date("F j, Y", strtotime($d)); ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Schedule Time:</strong> <?php echo $time; ?></p>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <p><strong>Health Concern:</strong> <?php echo $message; ?></p>
              </div>
            </div>
            <div class="col-lg-12">
              <p><strong>Reference Code:</strong> <?php echo $reference; ?></p>
            </div>
            <div class="col-lg-12">
              <p><strong>Created: </strong> <?php echo date("F j, Y, g:i a", strtotime($currentdate)); ?></p>
            </div>
            <div class="row">
  <div class="col-lg-12 context">
    <p class="fst-italic">Thank you for your transaction! You can check your email for instructions on how to reschedule or cancel your appointment. Please note that you can reschedule the appointment up to 5 times, and cancellation is allowed only once. Make sure to review and make any changes accordingly.</p>
  </div>
</div>

          </div>
          
          
        </div>
      </div>
  </div>
  
      <div class="mt-4 text-center">
          <button id="downloadButton" class="btn text-white" style="background-color: #6537AE;">Download Summary as Image</button>
        </div>
    </div>
  </div>
    </div>
  </div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('downloadButton').addEventListener('click', function () {
        const summaryContainer = document.querySelector('.col-lg-7');
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





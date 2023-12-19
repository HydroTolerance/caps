<?php
include "../Client/function.php";
checklogin('Client', true);
$userData = [];
$isClientLoggedIn = isset($_SESSION['client_email']);
if ($isClientLoggedIn) {
    $userData = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
<link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">
<link rel="stylesheet" href="css/style.css">


    <style>
   
   @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;

}
 body {
  background-color: #fff;
 }

.footer {
    background-color: #6537AE;
    color: #fff;

}
.footer-wave-svg {
    background-color: transparent;
    display: block;
    height: 30px;
    position: relative;
    top: -1px;
    width: 100%;
}
.footer-wave-path {
    fill: #fffff2;
}

.fixed-text {
  position: fixed;
  top: 50%; /* Adjust the vertical position as needed */
  left: 40%; /* Adjust the horizontal position as needed */
  transform: translate(-50%, -50%);
}
.custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}

    
.contact-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        height: 60vh;
        background-image: url('images/z-skin.jpg');
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        
        
    }

    .item-container1 {
    background-color: #6537AE;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 33vh;
    color: white;
    text-align: center;
  }

.item-container1 p:first-child {
    font-size: 50px;
    font-weight: bold;
  }

.item-container1 p:last-child {
    font-size: 30px;
  }
    
  .container-center {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.bg-white {
    /* Add any other styling for the .bg-white class */
    padding: 20px; /* Add padding to the container if needed */
}
 </style>


</head>

<body style="background-color: #eee;">
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" href="../index.php">
    <img src="images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white fs-5" href="../index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="contact.php" id="s5">Contact</a>
        </li>
      </ul>
        <?php if ($isClientLoggedIn): ?>
        <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle me-3" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../Client/logout.php">Sign out</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
        <?php endif; ?>
        <a href="booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>

<div class="container-fluid mt-5 ">
    <div class="row justify-content-center mx-3">
        <div class="col-md-12 bg-white rounded border shadow-sm">
            <?php
            include "../db_connect/config.php";
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $stmt = mysqli_prepare($conn, "SELECT id, services, image, name, description FROM service WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
            while (mysqli_stmt_fetch($stmt)) {
            ?>
            <div class="container">
                <div class="text-center">
                    <h1 class="mb-4" style="font-family: Lora;"><?php echo $name; ?></h1>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 h-100 d-flex flex-column">
                        <img src="../img/services/<?php echo $image; ?>" class="img-fluid rounded" alt="Service Image">
                    </div>
                    <div class="col-md-8 h-100 d-flex flex-column">
                        <div class="border p-5 flex-grow-1">
                            <p class="lead"><?php echo $description; ?></p>
                            
                        </div>
                        <a href="booking.php?service_id=<?php echo $id; ?>&service_name=<?php echo urlencode($name); ?>" class="btn float-end text-white" style="background-color: #6537AE;">Book this services</a>
                    </div>
                    
                </div>
            </div>
            <?php
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>
<div class="mt-3">

</div>


    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

</body>

</html>

<?php
include "Client/function.php";
checklogin('Client', true);
$userData = [];
$isClientLoggedIn = isset($_SESSION['client_email']);
if ($isClientLoggedIn) {
    $userData = $_SESSION['id'];
}
?>
<?php
include "db_connect/config.php";
$stmt = mysqli_prepare($conn, "SELECT id, name, image, description FROM announcement ORDER BY id DESC");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $image, $description);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Z Skin Care Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/scrollreveal"></script>
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
<link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">

</head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}
.image-container {
        position: relative;
        overflow: hidden;
        max-width: 100%;
    }

    .blurred-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(20px);
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .eye-icon {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .blurred-image {
        display: block;
        max-width: 100%;
        height: auto;
        z-index: 0;
    }

    .blur-disabled .blurred-overlay {
        display: none;
    }


    .warning-message {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white; /* Adjust text color as needed */
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .warning-message h3 {
      margin-bottom: 10px;
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
/* medium and up screens */
#loading-animation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white; /* Set the background to white */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.loader {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.card {
  border: none;
  border-radius: 0;
  box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
}

.carousel-control-prev,
.carousel-control-next {
  background-color: #6537AE;
  width: 6vh;
  height: 6vh;
  border-radius: 50%;
  top: 50%;
  transform: translateY(-50%);
  margin-left:20px;
  margin-right:20px;
}
.carousel-control-prev span,
.carousel-control-next span {
  width: 1.5rem;
  height: 1.5rem;
}
@media screen and (min-width: 577px) {
  .cards-wrapper {
    display: flex;
  }
  .card {
    margin: 0 0.5em;
    width: calc(100% / 2);
    height: calc(100% / 2);
  }
  .image-wrapper {
    height: 20vw;
    margin: 0 auto;
  }
}
@media screen and (max-width: 576px) {
  .card:not(:first-child) {
    display: none;
  }
}

.image-wrapper img {
  max-width: 100%;
  max-height: 100%;
}

.card {
  justify-content: center;
  align-items: center;
  display: flex;
}

.card-body {
    height: 200px; /* Adjust the height as needed */
    overflow: hidden; /* Hide overflow content */
}
#popupButton {
            position: fixed;
            bottom: 100px;
            right: 28px;
            padding: 25px;
            background-color: #6537AE;
            color: #fff;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            z-index: 99;
        }

        #popupContainer {
            display: none;
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 90%; /* Adjust the width as needed */
            max-width: 400px; /* Set a maximum width if needed */
            height: 80vh; /* Adjust the height as needed */
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        #popupContent {
            padding: 15px;
            height: calc(100% - 40px); /* Adjust the height to leave space for the close button */
            overflow-y: auto;
            z-index: 99;
        }

        #closeButton {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 5px;
            background-color: #6537AE;
            color: fff;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            z-index: 99;
        }

        .announcement {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            z-index: 99;
        }

        .announcement img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            
        }
</style>
<body>
<button id="popupButton" class="rounded-circle p-3"><i class="bi bi-megaphone fs-3"></i></button>

<div id="popupContainer">
<button id="closeButton" type="button" class="close fs-2" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
    <div id="popupContent">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var popupButton = document.getElementById('popupButton');
    var popupContainer = document.getElementById('popupContainer');
    var popupContent = document.getElementById('popupContent');
    var closeButton = document.getElementById('closeButton'); // Added this line

    popupButton.addEventListener('click', function () {
        // Clear existing announcements when opening the popup
        popupContent.innerHTML = '';

        <?php
        mysqli_stmt_data_seek($stmt, 0); // Reset the statement pointer
        while (mysqli_stmt_fetch($stmt)) {
            echo "var announcement = document.createElement('div');";
            echo "announcement.classList.add('announcement');";
            echo "announcement.innerHTML = '<strong>$name</strong><br>$description<img src=img/announcement/$image >';"; // Customize as needed
            echo "popupContent.appendChild(announcement);";
        }
        ?>
        popupContainer.style.display = 'block';
    });

    closeButton.addEventListener('click', function () {
        popupContainer.style.display = 'none';
    });
});
</script>
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "184630898063490");
  chatbox.setAttribute("attribution", "biz_inbox");

  // Add event listener to the chatbox
  chatbox.addEventListener('click', function() {
    // Check if the user is on a mobile device
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      // Redirect to the Messenger link for mobile
      window.location.href = 'https://m.me/184630898063490';
    }
  });
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v18.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>



<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" href="index.php">
    <img src="./t/images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white fs-5" href="index.php">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/about.php">About Us</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/service.php">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/FAQ.php">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="./t/contact.php">Contact Us</a>
        </li>
      </ul>
      <?php if ($isClientLoggedIn): ?>
        <div class="dropdown float-start">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle me-3" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1" style="left: -10px;">
                <li><a class="dropdown-item" href="Client/client_record/view.php">Profile Account</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                    <li><a class="dropdown-item" href="../Client/logout.php">Sign out</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline-light mx-2" type="submit">Login</a>
        <?php endif; ?>
        <a href="./t/booking.php" class="btn btn-outline-light float-start" type="submit">Book an Appointment</a>
    </div>
  </div>
</nav>

<div id="carouselExampleDark" class="carousel carousel-dark slide mb-5 " data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
        <div class="row">
            <div class="col-md-6">
                <img src="./t/images/1.png" class="d-block w-100" alt="./t/images/1.png">
              </div>
              <div class="col-md-6 m-auto p-5">
                <div>
                  <div>
                    <h1 style="font-family: Lora;" class="mb-3">Discover Your Best Skin Care with Expert Care</h1>
                    <p>Explore our expertly formulated skincare solutions and reveal your radiant, healthy skin.</p>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
        <div class="row">
            <div class="col-md-6">
                <img src="./t/images/2.png" class="d-block w-100" alt="./t/images/1.png">
              </div>
              <div class="col-md-6 m-auto p-5">
                <div>
                  <div>
                    <h1 style="font-family: Lora;" class="mb-3">Wish Granted: Unlock Your Dreams</h1>
                    <p>Discover a world where your wishes come true with our expert guidance and support.</p>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<section  class="mb-3">
  <div class="container py-5">
      <h2 style="font-family: Lora;" class="text-center mb-5" id="s5">FIND THE TREATMENTS FOR YOU</h2>
    <div class="row mt-3">
      <div class="col-md-4 mx-auto" id="s1">
        <img src="./t/images/skin.png" alt="" height="200px" width="200px" class="d-block mx-auto" >
        <p class="text-center mt-4">Skin Treatment</p>
      </div>
      <div class="col-md-4 mx-auto" id="s1">
        <img src="./t/images/hair.png" alt="" height="200px" width="200px" class="d-block mx-auto">
        <p class="text-center mt-4">Hair Treatment</p>
      </div>
      <div class="col-md-4 mx-auto" id="s1">
        <img src="./t/images/nail.png" alt="" height="200px" width="200px" class="d-block mx-auto">
        <p class="text-center mt-4">Nail Treatment</p>
      </div>
    </div>
  </div>
</section>


<section class="mb-5 mx-3" id="s1">
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner m-auto">
  <?php
include "db_connect/config.php";
$stmt = mysqli_prepare($conn, "SELECT id, services, image, name, description FROM service");
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $id, $services, $image, $name, $description);
?>
      <?php
      $groupSize = 3;
      $groupIndex = 0;

      while (mysqli_stmt_fetch($stmt)) {
        if ($groupIndex % $groupSize === 0) {
          $activeClass = $groupIndex === 0 ? 'active' : '';

          echo '<div class="carousel-item ' . $activeClass . '">';
          echo '<div class="cards-wrapper mx-auto">';
        }

        echo '<div class="card">';
        echo '<div class="image-wrapper">';
        echo '<img style="max-width:100%;" src="img/services/' . $image . '" alt="...">';
        echo '</div>';
        echo '<div class="card-body text-center">';
        echo '<h5 class="card-title">' . $name . '</h5>';
        echo '<a href="./t/list_services.php?id=' . $id . '" class="btn text-white" style="background-color:#6537AE;">Go to services</a>';
        echo '</div>';
        echo '</div>';

        if (($groupIndex + 1) % $groupSize === 0) {
          echo '</div>';
          echo '</div>';
        }

        $groupIndex++;
      }
      if ($groupIndex % $groupSize !== 0) {
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" ariahidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>



<section id="s1">
  <div class="d-flex justify-content-center align-items-center py-5 " style="background-color: #6537AE; min-height: 500px;">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="bg-light p-4 h-100">
            <div class="border border-2 p-4" style="border-color: #6537AE;">
              <h1 style="font-family: Lora;">About Us</h1>
              <p >Get to know our Story</p>
              <p class="">We are a leading dermatology clinic dedicated to helping our patients achieve optimal skin health and wellness. Our experienced team offers personalized medical and cosmetic dermatology services using the latest advancements in the field. Contact us to schedule an appointment and experience our patient-centered care for yourself.</p>
              <a href="./t/about.php" class="btn rounded-pill text-white" style="font-family: 'Poppins', sans-serif; font-size: 1rem; background-color:#6537AE;">Our Story</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <img src="./t/images/aboutus.png" alt="Description of the image" class="img-fluid h-100 w-100"  alt="About Us Image">
        </div>
      </div>
    </div>
  </div>
</section>

<section id="s1">
  <div class="my-5">
      <h1  class="text-center" style="font-family: Lora;">HIGHLIGHT</h1>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <iframe class="embed-responsive-item" src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FANCalerts%2Fvideos%2F10155732800023791%2F&show_text=false&t=0" frameborder="0" allowfullscreen="true" height="400px" width="800px" style="max-width: 100%;"></iframe>
        </div>
        <div class="col-md-6">
          <iframe height="400px" width="800px" style="max-width: 100%;" src="https://www.youtube.com/embed/Oxji-IWGGfE?si=y0nVisFy62PyPtyQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" style="max-width: 100%;" allowfullscreen></iframe>
        </div>
      </div>
    </div>
</section>


<section >
  <div class="container mt-5" id="s5">
  <h1  class="text-center mb-3" style="font-family: Lora;">RESULTS</h1>
    <div class="row">
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (1).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (2).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (3).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (4).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (5).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="border bg-white shadow mb-3 py-3" id="s1">
              <div class="image-container">
                  <div class="blurred-overlay text-white">
                      <div class="eye-icon bi bi-eye-slash"></div>
                      <p>This photo may show graphic content.</p>
                  </div>
                  <img src="./t/images/result (6).png" alt="" class="warning blurred-image" height="500px" width="500px" style="max-width: 100%;">
              </div>
              <div class="text-center">
                <div class="bg-light border-bottom mb-3">
                  <p>We covered this photo so you can decide if you want to see it.</p>
                </div>
                  <button class="btn text-white bi bi-eye" style="background-color:#6537AE" onclick="showImage(this)"> Uncover Photo</button>
              </div>
          </div>
      </div>
    </div>
  </div>
  
</section>



<footer id="s5">
<div class="mt-5">
    <footer class="footer" id="s5">
      <svg class="footer-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 100" preserveAspectRatio="none">
        <path class="footer-wave-path" d="M851.8,100c125,0,288.3-45,348.2-64V0H0v44c3.7-1,7.3-1.9,11-2.9C80.7,22,151.7,10.8,223.5,6.3C276.7,2.9,330,4,383,9.8 c52.2,5.7,103.3,16.2,153.4,32.8C623.9,71.3,726.8,100,851.8,100z"></path>
      </svg>
<div style="background-color: #6537AE; width: 100%; top: 20px">
  <div class="container text-white py-5" style="background-color: #6537AE;">
        <div class="row">
          <div class="col-lg-4">
              <div>
                <h2 style="font-family: Lora;">Z SKIN CARE CENTER</h2>
                  <p>Care and help you achieve optimal skin health. We are
                    committed to providing you with comprehensive,
                    personalized care, staying up-to-date with the latest
                    advancements in dermatology, and treating you with
                    compassion, respect, and individualized attention
                  </p>
              </div>
          </div>
          <div class="col-lg-2">
            <div>
              <h2 style="font-family: Lora;">Navigation</h2>
              <ul class="list-unstyled">
                <li>
                  <a href="t/about.php" class="text-white">About Us</a>
                </li>
                <li>
                  <a href="t/service.php" class="text-white">Services</a>
                </li>
                <li>
                  <a href="t/FAQ.php" class="text-white">FAQ</a>
                </li>
                <li>
                  <a href="t/contact.php" class="text-white">Contact Us</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 style="font-family: Lora;"> Legal</h2>
              <ul class="list-unstyled">
                <li>
                  <a href="t/terms_and_condition.php" class="text-white">Terms and Condition</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div>
              <h2 style="font-family: Lora;">Social Media</h2>
              <ul class="list-unstyled">
                <li>
                <a href="https://www.facebook.com/Zskincarecenter" class="text-white">
                    <i class="bi bi-facebook text-white me-2"></i>
                    Facebook</a>
                </li>
                <li>
                <a href="https://www.instagram.com/zskincarecenter" class="text-white">
                    <i class="bi bi-instagram text-white me-2"></i>
                    Instagram</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
          <h2 style="font-family: Lora;">Address</h2>
            <p>Address: Unit 4 One Kalayaan Place Building 284 Samson Road Victory Liner Compound, Caloocan, Philippines</p>
            <p> You can Contact Us</p>
            <p>Phone: 0915 759 2213</p>
            <p >Email: zskincarecenter@gmail.com</p>
          </div>
          </div>
          <div>
            
  </div>
</div>
</footer>

<div class=" text-center text-white p-1" style="background-color: #c23fe3;"> © 2023 Z Skin Care Center. All Rights Reserved. </div>
    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

<script>
  ScrollReveal().reveal('#s1',{
  delay: 175,
  duration: 1500,
  origin: "bottom",
  interval: 600,
});
ScrollReveal().reveal('#s2',{
  delay: 155,
  duration: 2000,
  opacity: 0,
  easing   : 'ease-in-out',
  distance: "70%",
  origin: "bottom",
});
ScrollReveal().reveal('#s4',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "70%",
  origin: "top",
});
ScrollReveal().reveal('#s3',{
  delay: 175,
  duration: 1500,
  opacity: 0,
  distance: "70%",
  origin: "top",
});
ScrollReveal().reveal('#s5',{
  delay: 175,
  duration: 1500,
  origin: "center",
});
ScrollReveal().reveal('#carouselExampleDark',{
  delay: 175,
  duration: 1500,
  origin: "center",
});

ScrollReveal().reveal('.col-md-4', {
    duration: 1000, 
    origin: 'bottom',
    distance: '100px',
    delay: 200,
  });
</script>
<script>
  document.getElementById("loading-animation").style.display = "block";
  window.addEventListener("load", function () {
    document.getElementById("loading-animation").style.display = "none";
  });

    function showImage(button) {
        var container = button.closest('.border');
        container.classList.toggle('blur-disabled');
    }
</script>

</body>

</html>

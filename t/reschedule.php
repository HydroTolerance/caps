<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="shortcut icon" href="images/icon1.png" type="image/x-icon">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vn539f3m5K/PDweF5IV3b3O+d0bi6b7fV5dw5VlVfj5F5a5/J+76j5U5z6W5O5w5D5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <title>Reschedule / Cancel Appointment</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', serif;
    font-size: 16px;
}
        li {
            font-size: 20px;
        }
        #pageloader {
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader {

        margin: 0 auto;
        margin-top: 35vh;
    }

    /* FlipX animation for the custom-loader and the image */
    @keyframes flipX {
        0% {
            transform: scaleX(1);
        }
        50% {
            transform: scaleX(-1);
        }
        100% {
            transform: scaleX(1);
        }
    }

    .flipX-animation {
        animation-name: flipX;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
    }
    .custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}

    </style>
</head>
<body style="background-color: #eee;">
  <?php
  include "../db_connect/config.php";
  $rescheduleCount = 0;
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM zp_appointment WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $date = $row['date'];
        $time = $row['time'];
        $reference = $row['reference_code'];
        $name = $row['firstname'] . ' ' . $row['lastname'];
    }
}
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $time = mysqli_real_escape_string($conn, $_POST['time']);
  $reason = mysqli_real_escape_string($conn, $_POST['apt_reason']);
  $query = "SELECT email, date, `time`, apt_reason, reschedule_count FROM zp_appointment WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
      $existingValues = mysqli_fetch_assoc($result);
      $rescheduleCount = $existingValues['reschedule_count'];

      if ($rescheduleCount >= 5) {
          echo '<script>
              Swal.fire({
                  title: "Limit Exceeded",
                  text: "You have reached the maximum number of reschedules for this appointment.",
                  icon: "warning",
                  confirmButtonText: "OK"
              });
          </script>';
      } else {
          if ($email == $existingValues['email'] && $date == $existingValues['date'] && $time == $existingValues['time']) {
              echo '<script>
                  Swal.fire({
                      title: "No Changes",
                      text: "You did not make any changes.",
                      icon: "info",
                      confirmButtonText: "OK"
                  });
              </script>';
          } else {
              $updateQuery = "UPDATE zp_appointment SET email = ?, date = ?, `time` = ?, apt_reason = ?, appointment_status = 'Rescheduled (Client)', schedule_status = 'Sched', reschedule_count = ? WHERE id = ?";
              $updateStmt = mysqli_prepare($conn, $updateQuery);
              $newRescheduleCount = $rescheduleCount + 1;
              mysqli_stmt_bind_param($updateStmt, 'ssssii', $email, $date, $time, $reason, $newRescheduleCount, $id);
              $updateResult = mysqli_stmt_execute($updateStmt);
              if ($updateResult) {
                date_default_timezone_set('Asia/Manila');
                $currentDate = date("Y-m-d H:i:s");
                $cancelNotification = "The appointment for <strong>$name</strong> has been <strong>rescheduled.</strong>";
                $notificationSql = "INSERT INTO notifications (message, appointment_id, created_at) VALUES (?, ?, ?)";
                $notificationStmt = mysqli_prepare($conn, $notificationSql);
                mysqli_stmt_bind_param($notificationStmt, "sss", $cancelNotification, $id, $currentDate);
                mysqli_stmt_execute($notificationStmt);

                require 'phpmailer/PHPMailerAutoload.php';
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP(); 
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;         
                    $mail->Username = 'blazered098@gmail.com';
                    $mail->Password = 'nnhthgjzjbdpilbh';
                    $mail->SMTPSecure = 'tls';       
                    $mail->Port = 587;              
                    $mail->setFrom($email, 'Z Skin Care Center');
                    $mail->addAddress('hydrokaido@gmail.com', 'Z Skin Care Center');
                    $mail->addAddress($email, $name);
                    $mail->addReplyTo($email, $name);
                    $mail->isHTML(true); 
                    $mail->Subject = 'Appointment Rescheduled';
                    $mail->Body = '
                  <!DOCTYPE html>
                  <html>
                  <head>
                      <style>
                          body {
                              font-family: Arial, sans-serif;
                              background-color: #f4f4f4;
                              color: #333;
                              padding: 20px;
                          }
              
              
                          h1 {
                              color: #6537AE;
                          }
              
                          p {
                              font-size: 16px;
                          }
              
                          .appointment-details {
                              margin-top: 20px;
                          }
              
                          .detail-label {
                              font-weight: bold;
                          }
                      </style>
                  </head>
                  <body>
                      <div class="container">
                          <h1>Z Skin Care Center</h1>
                          <p>Dear user,</p>
                          <p>Your appointment has been rescheduled:</p>
                          
                          <div class="appointment-details">
                              <p><span class="detail-label">New Date:</span>'. ' ' . $date .'</p>
                              <p><span class="detail-label">New Time:</span>'. ' ' . $time .'</p>
                              <p><span class="detail-label">Reason:</span>'. ' ' . $reason .'</p>
                              <p style="font-weight: bold; font-size: 20px;">Reference Code: ' . $reference . '</p>
                          </div>
                          
                          <p>Thank you for choosing Z Skin Care Center.</p>
                      </div>
                  </body>
                  </html>
              ';
                $mail->send();
                header("location: success.php?date=" . urlencode($date) . "&time=" . urlencode($time) . "&reason=" . urlencode($reason));
                exit();
                } catch (Exception $e) {
                    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
            }
      
        } 
        }
  ?>
  <?php
  if (isset($_POST['cancell'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $reason = $_POST['apt_reason'];
    $stmt = mysqli_prepare($conn, "UPDATE zp_appointment SET email=?, apt_reason = ?, appointment_status = 'Cancelled', schedule_status = 'Cancel' WHERE id =?");
    mysqli_stmt_bind_param($stmt, "ssi", $email, $reason, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        date_default_timezone_set('Asia/Manila');
        $currentDate = date("Y-m-d H:i:s");
        $cancelNotification = "The appointment for <strong>$name</strong> has been <strong>cancelled.</strong>";
        $notificationSql = "INSERT INTO notifications (message, appointment_id, created_at) VALUES (?, ?, ?)";
        $notificationStmt = mysqli_prepare($conn, $notificationSql);
        mysqli_stmt_bind_param($notificationStmt, "sss", $cancelNotification, $id, $currentDate);
        mysqli_stmt_execute($notificationStmt);

      require 'phpmailer/PHPMailerAutoload.php';
      $mail = new PHPMailer(true);
      try {
          $mail->isSMTP(); 
          $mail->Host = 'smtp.gmail.com'; 
          $mail->SMTPAuth = true;         
          $mail->Username = 'blazered098@gmail.com';
          $mail->Password = 'nnhthgjzjbdpilbh';
          $mail->SMTPSecure = 'tls';       
          $mail->Port = 587;              
          $mail->setFrom($email, 'Z Skin Care Center');
          $mail->addAddress('hydrokaido@gmail.com', 'Z Skin Care Center');
          $mail->addAddress($email, $name);
          $mail->addReplyTo($email, $name);
          $mail->isHTML(true); 
          $mail->Subject = 'Appointment Cancelled';
          $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        padding: 20px;
                    }
        
        
                    h1 {
                        color: #6537AE;
                    }
        
                    p {
                        font-size: 16px;
                    }
        
                    .appointment-details {
                        margin-top: 20px;
                    }
        
                    .detail-label {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Z Skin Care Center</h1>
                    <p>Dear user,</p>
                    <p>Your appointment has been Cancelled:</p>
                    
                    <div class="appointment-details">
                        <p><span class="detail-label">Your Reason:</span>'. ' ' . $reason .'</p>
                    </div>
                    
                    <p>Thank you for choosing Z Skin Care Center.</p>
                </div>
            </body>
            </html>
          ';
             $mail->send();
            header("location: success1.php");
            exit();
          } catch (Exception $e) {
              echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
      }
  }
  ?>
<div id="pageloader">
    <div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
    <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
</div>
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; /* Use your preferred solid color */" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" style="margin-right: 12px;" href="../index.php">
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
          <a class="nav-link text-white" href="about.php" id="s5">About Us</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="contact.php" id="s5">Contact Us</a>
        </li>
      </ul>
      <a href="../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
      <a href="booking.php" class="btn btn-outline-light" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
<div class="container mt-5">
            <?php
                date_default_timezone_set('Asia/Manila');
            include "../db_connect/config.php";
            if (isset($_GET['reference_code'])) {
                $reference = $_GET['reference_code'];
                $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE reference_code = ?");
                mysqli_stmt_bind_param($stmt, "s", $reference);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                ?>
          <div class="center-content">
            <div class="background-container"></div>
            <div class="container my-5">
              <div class="row justify-content-center">
                <div class="col-lg-10">
                  <div class="bg-white p-4 rounded shadow-sm border">
                    <div class="text-center mb-3">
                      <img src="images/6.png" alt="" class="img-fluid" height="100px" width="100px">
                    </div>
                    
                    <h2 class="mb-4 text-center" style="color:#6537AE; font-family: Lora;">Appointment Reschedule / Cancel</h2>
                  <div class="row border mx-auto py-4">
                    <div class="col-lg-6">
                      <p><strong>Name: </strong><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></p>
                    </div>
                    <div class="col-lg-6">
                      <p><strong>Services: </strong><?php echo $row['services'] ?></p>
                    </div>
                    <div class="col-lg-6">
                      <p><strong>Phone number: </strong> <?php echo $row['number']; ?></p>
                    </div>
                    <div class="col-lg-6">
                      <p><strong>Schedule Date: </strong><?php echo date('M d, Y', strtotime($row['date'])) ?></p>
                    </div>
                    <div class="col-lg-6">
                      <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    </div>
                    <div class="col-lg-6">
                      <p><strong>Scheduel Time: </strong> <?php echo $row['time'] ?></p>
                    </div>
                    <div class="col-lg-12">
                      <p><strong>Reference Code: </strong> <?php echo $reference; ?></p>
                    </div>
                    <div class="col-lg-12">
                      <p><strong>Created: </strong> <?php echo date('F j, Y g:i a', strtotime($row['created'])); ?></p>
                    </div>
                    <div class="col-md-6">
                      <?php
                        if ($rescheduleCount < 5 && $row['appointment_status'] !== 'Completed' && $row['appointment_status'] !== 'Cancelled' && $row['appointment_status'] !== 'Did not show') {
                            echo '<button class="btn btn-primary w-100 mb-3" onclick="showRescheduleModal(' . $row['id'] . ', \'Reschedule\')">Reschedule Appointment</button>';
                        } else {
                            echo '<button class="btn btn-primary w-100  mb-3" disabled>Reschedule Appointment (Limit Exceeded or Invalid Status)</button>';
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        if ($row['schedule_status'] !== 'Cancel' && $row['appointment_status'] !== 'Completed' && $row['appointment_status'] !== 'Cancelled' && $row['appointment_status'] !== 'Did not show') {
                            echo '<button class="btn btn-danger w-100  mb-3" onclick="showCancelledModal(' . $row['id'] . ', \'Cancelled\')">Cancel Appointment</button>';
                        } else {
                            echo '<button class="btn btn-danger w-100  mb-3" disabled>Cancel Appointment (Already Cancelled or Invalid Status)</button>';
                        }
                      ?>
                    </div>
                        <?php
                    }
                    mysqli_close($conn);
                    }
                    ?>
                  </div>
        </div>
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Cancelled appointment details will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelledModal" tabindex="-1" aria-labelledby="cancelledLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelledLabel">Cancelled Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Cancelled appointment details will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('#patientTable').DataTable({
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        "buttons": [
          'searchBuilder',
          'copy',
          'csv',
          'excel',
          'pdf',
          'print'
      ],
    });
});


function showRescheduleModal(id) {
$.ajax({
    url: 'get_reschedule.php',
    type: 'POST',
    data: { id: id},
    success: function (response) {
        $('#rescheduleModal .modal-body').html(response);
        $('#rescheduleModal').modal('show');
    }
});
}

function showCancelledModal(id) {
$.ajax({
    url: 'get_cancelled.php',
    type: 'POST',
    data: { id: id},
    success: function (response) {
        $('#cancelledModal .modal-body').html(response);
        $('#cancelledModal').modal('show');
    }
});
}
</script>

</body>
</html>

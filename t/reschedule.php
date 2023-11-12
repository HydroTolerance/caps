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
    <title>Reschedule / Cancel Appointment</title>
    <style>
        li {
            font-size: 20px;
        }
#pageloader {
    background: rgba(255, 255, 255, 0.8);
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
}

.custom-loader {
    border: 5px solid #6537AE;
    border-top: 5px solid transparent;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation-name: spin;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    margin: 0 auto;
    margin-top: 50vh;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
    </style>
</head>
<body style="background-color: #eee;">
  <?php
  include "../db_connect/config.php";
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM zp_appointment WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $date = $row['date'];
        $time = $row['time'];
        $name = $row['firstname'] . ' ' . $row['lastname'];
    }
}
  if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $date = mysqli_real_escape_string($conn, $_POST['date']);
      $time = mysqli_real_escape_string($conn, $_POST['time']);
      $reason = mysqli_real_escape_string($conn, $_POST['apt_reason']);
  
      // Retrieve existing values from the database
      $query = "SELECT email, date, `time`, apt_reason FROM zp_appointment WHERE id = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
  
      if ($result && mysqli_num_rows($result) > 0) {
          $existingValues = mysqli_fetch_assoc($result);
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
              $updateQuery = "UPDATE zp_appointment SET email = ?, date = ?, `time` = ?, apt_reason = ?, appointment_status = 'Rescheduled' , schedule_status = 'Sched' WHERE id = ?";
              $updateStmt = mysqli_prepare($conn, $updateQuery);
              mysqli_stmt_bind_param($updateStmt, 'ssssi', $email, $date, $time, $reason, $id);
              $updateResult = mysqli_stmt_execute($updateStmt);
              if ($updateResult) {
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
              $mail->setFrom($email, 'Z SKin Care Center');
              $mail->addAddress('hydrokaido@gmail.com', 'Z-skin Care Center');
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
        
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
        
                    h1 {
                        color: #007BFF;
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
                    </div>
                    
                    <p>Thank you for choosing Z Skin Care Center.</p>
                </div>
            </body>
            </html>
        ';
              $mail->send();
              echo '<script>
              Swal.fire({
                  icon: "success",
                  title: "Success",
                  text: "Appointment rescheduled successfully!"
              }).then(function() {
                  window.location = "success.php"; // Redirect after user clicks OK
              });
          </script>';
          exit();
          } catch (Exception $e) {
              echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
          $mail->setFrom($email, 'Z SKin Care Center');
          $mail->addAddress('hydrokaido@gmail.com', 'Z-skin Care Center');
          $mail->addAddress($email, $name);
          $mail->addReplyTo($email, $name);
          $mail->isHTML(true); 
          $mail->Subject = 'Appointment Cancelled';
          $mail->Body = "Your appointment has been cancelled:<br><br>Reason: $reason";
          $mail->send();
          echo '<script>
              Swal.fire({
                  icon: "success",
                  title: "Success",
                  text: "Appointment rescheduled successfully!"
              }).then(function() {
                  window.location = "success.php"; // Redirect after user clicks OK
              });
          </script>';
          exit();
      } catch (Exception $e) {
          echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
  }
}
  ?>
  <div id="pageloader">
    <div class="custom-loader"></div>
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
<div class="container mt-5">

            <?php
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
        <div class="col-lg-7">
          <div class="bg-white p-4 rounded shadow-sm border">
            <h2 class="mb-4 text-center" style="color:#6537AE">Appointment Reschedule / Cancel</h2>
          <div class="row">
            <div class="col-lg-6">
              <p><strong>Name: </strong><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Services: </strong><?php echo $row['services'] ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Phone number:</strong> <?php echo $row['number']; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Schedule Date:</strong><?php echo date('M d, Y', strtotime($row['date'])) ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            </div>
            <div class="col-lg-6">
              <p><strong>Scheduel Time:</strong> <?php echo $row['time'] ?></p>
            </div>
            <div class="col-lg-12">
              <p><strong>Reference Code:</strong> <?php echo $reference; ?></p>
            </div>
            <div class="col-lg-12">
              <p><strong>Created: </strong> <?php echo $row['created']; ?></p>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary my-3 w-100" onclick="showRescheduleModal(<?php echo $row['id']; ?>, 'Reschedule')">Reschedule Appointment</button>
                <button class="btn btn-danger w-100" onclick="showCancelledModal(<?php echo $row['id']; ?>, 'Cancelled')">Cancel Appointment</button>
            </div>
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

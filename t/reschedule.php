<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>Document</title>
    <style>
        li {
            font-size: 20px;
        }
    </style>
</head>
<body>
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
              <p><strong>Scheduel Time:</strong> <?php echo date('M d, Y', strtotime($row['date'])) ?></p>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vn539f3m5K/PDweF5IV3b3O+d0bi6b7fV5dw5VlVfj5F5a5/J+76j5U5z6W5O5w5D5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    data: { id: id, secret_key: 'helloimjaycearon' },
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
    data: { id: id, secret_key: 'helloimjaycearon' },
    success: function (response) {
        $('#cancelledModal .modal-body').html(response);
        $('#cancelledModal').modal('show');
    }
});
}
</script>

</body>
</html>

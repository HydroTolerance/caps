<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
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
</style>
<body style="background-color: #6537AE;">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card p-4" style="width: 40rem;">
            <div class="text-center">
                <div class="text-center mb-3">
                  <img src="images/6.png" alt="" class="img-fluid" height="100px" width="100px">
                </div>
                <h1 style="color: #6537AE; font-family: Lora;" class="mb-3">THANK YOU</h1>
                <div class="additional-info">
                    <p class="mb-3">Your new appointment details:</p>
                    <?php
                      // Retrieve parameters from the URL
                      $rescheduledDate = urldecode($_GET['date']);
                      $rescheduledTime = urldecode($_GET['time']);
                      $rescheduledReason = urldecode($_GET['reason']);
                      $formattedDate = date("F j, Y", strtotime($rescheduledDate));
                      // Display rescheduled appointment details
                      echo "<p>Appointment Date: <span class='fw-bold'>$formattedDate</span></p>";
                      echo "<p>Appointment Time: <span class='fw-bold'>$rescheduledTime</span></p>";
                      echo "<p>Reschedule Reason:<span class='fw-bold'> $rescheduledReason</span></p>";
                    ?>
                    <p class="fst-italic">You can also check your email to see your reschedule appointment</p>
                </div>

                <button id="loadingBtn" class="btn text-white" style="background-color: #6537AE;" onclick="showLoading()">Go back to Website</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoading() {
            var btn = document.getElementById('loadingBtn');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
                            '<span class="visually-hidden">Loading...</span>';
            btn.disabled = true;
            setTimeout(function () {
                window.location.href = '../index.php';
            }, 1000);
        }
    </script>
</body>

</html>

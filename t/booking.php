<?php
session_start();

if(isset($_POST['submit'])){
    include "../db_connect/config.php";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $health = $_POST['health_concern'];
    $services = $_POST['services'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $reference = generateReferenceCode();
    $appointment_id = generateAppointmentID();
    $currentTimestamp = date("Y-m-d H:i:s");

    $sql = "INSERT INTO zp_appointment (appointment_id, reference_code, firstname, lastname, number, email, health_concern, services, date, time, appointment_status, created ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssss", $appointment_id, $reference, $firstname, $lastname, $number, $email, $health, $services, $date, $time, $currentTimestamp);

    if (mysqli_stmt_execute($stmt)) {
    $_SESSION['authenticated'] = true; // Set a session variable
    header("Location: display.php?reference_code=$reference&firstname=$firstname&lastname=$lastname&number=$number&email=$email&health_concern=$health&services=$services&date=$date&time=$time");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
}

function generateReferenceCode() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $reference = '';
    $length = 6;

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $reference .= $characters[$randomIndex];
    }

    return $reference;
}

function generateAppointmentID() {
    $counterFile = 'appointment_counter.txt';
    $counter = file_get_contents($counterFile);
    $counter++;
    $appointmentID = 'apt#' . str_pad($counter, 3, '0', STR_PAD_LEFT);
    file_put_contents($counterFile, $counter);

    return $appointmentID;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@loadingio/loading-bar@0.1.1/dist/loading-bar.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../js/appointment.js"></script>
    <title>Document</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        option:disabled {
            color: red;
        }
        option:enabled {
            cursor: pointer;
        }
        .error {
        color: #F00;
        font-size: 10px;
        }

        .header {
        background-color: #684717;
        color: white;
        padding: 10px;
        text-align: center;
        }
        p {
        white-space: nowrap;
    }
    #pageloader
    {
    background: rgba( 255, 255, 255, 0.8 );
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
    }
    /* Add this to your CSS file or in a <style> block within your HTML */
    .custom-loader {
        border: 5px solid #684717; /* Change the border color as needed */
        border-top: 5px solid transparent; /* Change the border color as needed */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
        margin-top: 50vh; /* Adjust the margin-top to center the loading spinner */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }


    </style>
</head>
<body style="background-color:  #F2B85A;">
<div id="pageloader">
    <div class="custom-loader"></div>
</div>
<div class="header">
<img src="ZLogo.svg" alt="Image Description" height="180px" width="180px">
</div>
<main>
<section class="h-100 gradient-form">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class=" px-3 py-4 p-md-5 mx-md-4">
              <form action="" method="post" id="signUpForm" class="row g-3 needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-12">
                        <h3 class="fs-4 text-uppercase mb-4"style="color:#684717;">Appointment form</h3>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First Name" name="firstname" required>
                        <div class="invalid-feedback">
                            Please enter your firstname.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom01">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                        <div class="invalid-feedback">
                            Please enter your lastname.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom02">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number" required>
                        <div class="invalid-feedback">
                            Please enter your number.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom03">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter Email" name="email" id="e" required>
                        <div class="invalid-feedback">
                            Please enter your email.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom04">Schedule Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required>
                        <div class="invalid-feedback">
                            Please choose a date.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom05">Schedule Time <span class="text-danger">*</span></label>
                        <select class="form-control" name="time" id="time" placeholder="Enter Time Appointment" required></select>
                        <div class="invalid-feedback">
                            Please enter your time.
                        </div>
                    </div>
                    <div class="col-12" required>
                        <label for="validationCustom06">Services</label>
                        <select class="form-select" name="services">
                            <option value="Consultation">Consultation</option>
                            <option value="Nail">Nail Consultation</option>
                            <option value="Hair">Hair Consultation</option>
                            <option value="Skin">Skin Consultation</option>
                            <option value="Face">Eye Consultation</option>
                            <option value="Face">Skin Biopsy</option>
                            <option value="Face">HIFU</option>
                            <option value="Face">Cryolipolysis</option>
                            <option value="Face">Carbon Laser Peel</option>
                            <option value="Face">Mohs Microhaphic Surgery</option>
                            <option value="Face">Platelet Rich Plasma</option>
                            <option value="Face">Warts, Milia Removal</option>
                            <option value="Face">Chemical Peel</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label>Select Health Complaint</label>
                        <textarea class="form-control" placeholder="Health Complaint" name="health_concern" required></textarea>
                        <div class="invalid-feedback">
                            Please enter your health complaint.
                        </div>
                    </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                        <span>I agree to the <a href="terms_and_condition.php">terms and conditions</a><span class="text-danger">*</span></span>
                        <div class="invalid-feedback">
                            You must agree to the terms and conditions to book an appointment.
                        </div>
                    </div>
                </div>
                    <div class="col-12 mt-5">                        
                        <button type="submit" class="btn btn-primary float-end" name="submit" style="Background-color:#684717;">Book Appointment</button>
                        <a href="home.php"><button type="button" class="btn btn-outline-secondary float-end me-2">Cancel</button></a>
                    </div>
                </div>
            </form>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card-body p-md-8 mx-md-4">            
                <div id="map" style="height: 400px;"></div>
                <div class="text-center mt-3">
                    <h3>Z-Skin Opening Hours:</h3>
                    <?php
                        include "../db_connect/config.php";

                        // Fetch available days
                        $stmt = mysqli_prepare($conn, "SELECT day FROM availability WHERE is_available != '0'");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $day);
                        ?>
                        <div class="row">
                        <h4 class="text-center">Day Open:</h4>
                            <?php while (mysqli_stmt_fetch($stmt)) { ?>
                                <div class="col-lg-4">
                                    <div>
                                        <p><?php echo $day; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <h4 class="text-center">Time Open:</h4>
                        <?php
                        // Combine time slots
                        $stmt = mysqli_prepare($conn, "SELECT slots FROM appointment_slots");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $time);

                        $startTime = null;
                        $endTime = null;

                        while (mysqli_stmt_fetch($stmt)) {
                            list($start, $end) = explode(" - ", $time);

                            if ($startTime === null || strtotime($start) < strtotime($startTime)) {
                                $startTime = $start;
                            }

                            if ($endTime === null || strtotime($end) > strtotime($endTime)) {
                                $endTime = $end;
                            }
                        }

                        $combinedTimeRange = $startTime . " - " . $endTime;
                        ?>
                        <div class="row">
                            <div class="d-flex align-items-center justify-content-center">
                                <p><?php echo $combinedTimeRange; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


</main>
<footer style="background-color: #684717; color: white; text-align: center; padding: 10px; margin-top: 30px; font-size: 23px; font-family: DM-Sans;" >
    ZephyDerm
</footer>
<script src="https://cdn.jsdelivr.net/npm/@loadingio/loading-bar@0.1.1/dist/loading-bar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.6/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" async></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
<script>
        // Customize map options
        var mapOptions = {
            center: [14.648295, 120.983827],
            zoom: 24
        };
        var map = L.map('map', mapOptions);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        L.marker([14.648295, 120.983827]).addTo(map)
            .bindPopup("Zephyris Skin Care Center<br>One Kalayaan Place Building<br>Samson Rd, Caloocan, 1400 Metro Manila")
            .openPopup();
    </script>
    <script>
$(document).ready(function() {
  $("#signUpForm").on("submit", function(e) {
    if (this.checkValidity()) {
      // Form is valid, show the loading spinner
      $("#pageloader").fadeIn();
    } else {
      // Form is invalid, prevent submission
      e.preventDefault();
    }
  });
});
    </script>
<script>
function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var slots = response.slots;
            var slotsLeft = response.slots_left;

            for (var slot in slots) {
                var option = document.createElement("option");
                option.value = slot;
                option.text = slot;
                var num_bookings = slots[slot];
                var slotsLeftForOption = slotsLeft - num_bookings;
                if (slotsLeftForOption <= 0) {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                time.add(option);
                var slotText = option.text + " (" + slotsLeftForOption + " slot(s) left)";
                option.text = slotText;
            }

            var num_slots = Object.keys(slots).length;
            document.getElementById("num_slots").innerHTML = " (" + num_slots + " slots available)";
        }
    };
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(d), true);
    xmlhttp.send();
}

</script>
<?php
include "../db_connect/config.php";

// Fetch specific dates to disable from the database
$sql = "SELECT day_to_disable FROM disabled_days";
$result = $conn->query($sql);
$disableDates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disableDates[] = $row['day_to_disable'];
    }
}

// Fetch specific days to disable from the database
$sql = "SELECT day, is_available FROM availability";
$result = $conn->query($sql);
$disableDays = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['is_available'] == 0) {
            $disableDays[] = $row['day'];
        }
    }
}

$conn->close();
?>
<script>
    var configuration = {
        dateFormat: "Y-m-d",
        allowInput: true,
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(60),
        "disable": [
            function(date) {
                date.setHours(23, 59, 59, 999);
                var dateString = date.toISOString().split('T')[0];
                var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                
                return <?php echo json_encode($disableDates); ?>.includes(dateString) ||
                       <?php echo json_encode($disableDays); ?>.includes(dayName[date.getDay()]);
            },
        ]
    };

    flatpickr("#d", configuration);

</script>


<script>
  // Function to display the reminder alert
  function showReminderAlert() {
    Swal.fire({
      icon: 'info',
      title: 'Important Reminders',
      html: 'Minors are not allowed to book an appointment.<br>' +
        'If the requesting party is a duly authorized representative, the original copy of the authorization letter and valid ID must be presented.<br>' +
        'Provide correct details for the applicant/authorized representative.<br>' +
        'This appointment and scheduling system allocates slots on a first come, first served basis.',
      confirmButtonColor: '#684717', // Customize the confirm button color
    });
  }

  // Add an event listener to the checkbox
  document.querySelector('input[type="checkbox"]').addEventListener('change', function () {
    if (this.checked) {
      showReminderAlert();
    }
  });
</script>






</body>
</html>
<?php
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
      <script>
        $().ready(function () {
 
            $("#signUpForm").validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    number: {
                        required: true,
                        minlength: 11,
                        number: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    agree: "required"
                },
                messages: {
                    firstname: " Please enter your firstname",
                    lastname: " Please enter your lastname",
                    username: {
                        required: " Please enter a username",
                        minlength:
                      " Your username must consist of at least 2 characters"
                    },
                    number: {
                        required: " Please enter a number",
                        minlength:
                      " Your number must be consist of at least 11 numbers",
                      number : "Please enter only number"
                    },
                    agree: "Please accept our policy"
                }
            });
        });
    </script>
    <script src="../js/appointment.js"></script>
    <title>Document</title>
    <style>
        .container {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Make the container at least the full viewport height */
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
#pageloader
{
  background: rgba( 255, 255, 255, 0.8 );
  display: none;
  height: 100%;
  position: fixed;
  width: 100%;
  z-index: 9999;
}
.custom-loader {
  border: 5px solid #684717;
  border-top: 5px solid transparent;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin: 0 auto;
  margin-top: 50vh;
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
              <form action="" method="post" id="signUpForm">
                <div class="row g-3">
                    <div class="col-12">
                        <h3 class="fs-4 text-uppercase mb-4"style="color:#684717;">Appointment form</h3>
                    </div>
                    <div class="col-md-6">
                        <label for="">First Name <span class="text-warning">*</span></label>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname">
                    </div>
                    <div class="col-md-6">
                        <label for="">Last Name <span class="text-warning">*</span></label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Phone Number <span class="text-warning">*</span></label>
                        <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number">
                    </div>
                    <div class="col-md-6">
                        <label for="">Email <span class="text-warning">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter Email" name="email" id="e">
                    </div>
                    <div class="col-md-6">
                        <label for="">Schedule Date <span class="text-warning">*</span></label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required>
                    </div>
                    <div class="col-md-6">
                        <label>Schedule Time <span class="text-warning">*</span></label>
                        <select class="form-control" name="time" id="time" placeholder="Enter Time Appointment" required></select>
                    </div>
                    <div class="col-12" required>
                        <label for="">Services</label>
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
              <div class="card-body p-md-5 mx-md-4">            
                <div id="map" style="height: 400px;"></div>
                <div class="text-center mt-3">
                    <h3>Z-Skin Opening Hours:</h3>
                    <label for="">Monday, Wenesday, Friday, and Saturday</label>
                    <p>1:00 PM - 5:00 PM</p>
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

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" async></script>
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

        // Add a custom marker at the specified location
        L.marker([14.648295, 120.983827]).addTo(map)
            .bindPopup("Zephyris Skin Care Center<br>One Kalayaan Place Building<br>Samson Rd, Caloocan, 1400 Metro Manila")
            .openPopup();
    </script>
    <script>
        $(document).ready(function(){
  $("#signUpForm").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
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

</script>




    <script>
        configuration = {
          dateFormat: "Y-m-d",
          minDate: new Date().fp_incr(1),
          maxDate: new Date().fp_incr(60),
          "disable": [
        // Disable weekends
        function(date) {
            return (date.getDay() === 2 || date.getDay() === 4 || date.getDay() === 0);

        }
    ]

        }
        flatpickr("#d", configuration);
      </script>
</body>
</html>
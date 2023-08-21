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

    $sql = "INSERT INTO book1 (appointment_id, reference_code, firstname, lastname, number, email, health_concern, services, date, time, appointment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $appointment_id, $reference, $firstname, $lastname, $number, $email, $health, $services, $date, $time);

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
    $length = 15;

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
    <script src="../js/appointment.js"></script>
    <title>Document</title>
    <style>
        #formContainer {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        option:disabled {
            color: red;
        }
        option:enabled {
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: #6537AE;">
<main>
<div class="container" id="formContainer">
    <div class="row">
        <div class="col-md-6 offset-md-3 border p-4 shadow bg-light">
            <div class="col-12">
                <h3 class="fs-4 text-uppercase mb-4" style="color: #6537AE;">Appointment form</h3>
            </div>
            <form action="" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="">First Name (Required)</label>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Last Name (Required)</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Phone Number</label>
                        <input type="tel" class="form-control" placeholder="Phone Number" pattern="[0-9]{11}" name="number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Email (Required)</label>
                        <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Schedule Date (Required)</label>
                        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required>
                    </div>
                    <div class="col-md-6">
                        <label>Select Time Appointment (Required)</label>
                        <select class="form-control" name="time" id="time" placeholder="Enter Time Appointment" required></select>
                    </div>
                    <div class="col-12" required>
                        <select class="form-select" name="services">
                            <option value="Consultation">Consultation</option>
                            <option value="Nail">Nail</option>
                            <option value="Hair">Hair</option>
                            <option value="Skin">Skin</option>
                            <option value="Face">Face</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label>Select Health Complaint</label>
                        <textarea class="form-control" placeholder="Health Complaint" name="health_concern" required></textarea>
                    </div>
                    <div class="col-12 mt-5">                        
                        <button type="submit" class="btn btn-primary float-end" name="submit" style="background-color: #6537AE;">Book Appointment</button>
                        <a href="home.php"><button type="button" class="btn btn-outline-secondary float-end me-2">Cancel</button></a>
                    </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>
</main>
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
      <script src="https://hcaptcha.com/1/api.js" async defer></script>
</body>
</html>
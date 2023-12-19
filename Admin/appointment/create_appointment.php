<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <form action="appointment.php" method="post" id="signUpForm" class="row g-3 needs-validation" novalidate>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="validationCustom01">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="validationCustom01" placeholder="First Name" name="firstname" required>
                <div class="invalid-feedback">
                    Please enter your firstname.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom01">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                <div class="invalid-feedback">
                    Please enter your lastname.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom03">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" id="e" required>
                <div class="invalid-feedback">
                    Please enter your email.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom02">Phone Number (Optional)</label>
                <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number" pattern="09[0-9]{9}" oninput="validateInput(this)">
                <div class="invalid-feedback">
                    Please enter a valid phone number that starts with '09'.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom04">Schedule Appointment Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required autocomplete="off">
                <div class="invalid-feedback">
                    Please choose a date.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom05">Schedule Appointment Time<span class="text-danger">*</span></label>
                <select class="form-control" name="time" id="time" required>
                </select>
                <div class="invalid-feedback">
                    Please enter your time.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom06">Select Service<span class="text-danger">*</span></label>
                <select class="select2 form-select" name="services" style="width: 100%;" required>
                    <option value=""></option>
                    <?php
                    include "../../db_connect/config.php";
                    $stmt = mysqli_prepare($conn, "SELECT DISTINCT services FROM service");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_bind_result($stmt, $category);

                    while (mysqli_stmt_fetch($stmt)) {
                        echo '<optgroup label="' . $category . '">';
                        $stmt2 = mysqli_prepare($conn, "SELECT id, services, name, image, description FROM service WHERE services = ?");
                        mysqli_stmt_bind_param($stmt2, "s", $category);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_store_result($stmt2);
                        mysqli_stmt_bind_result($stmt2, $id, $services, $name, $image, $description);

                        while (mysqli_stmt_fetch($stmt2)) {
                            echo '<option value="' . $name . '">' . $name . '</option>';
                        }
                        echo '</optgroup>';
                    }
                    ?>
                </select>

                <div class="invalid-feedback">
                    Please Select Services.
                </div>
                </div>
            </div>
            <div class="col-md-12">
                <label>Health Concern (Optional)</label>
                <textarea class="form-control" placeholder="Description" name="health_concern" required oninput="limitHealthConcern(this, 1700);" onpaste="onPaste(event, this);" rows="10"></textarea>
                <div class="invalid-feedback">
                    Please enter your health concern.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="text-muted" id="characterCount">1700 characters remaining</div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-end me-2" id="clearFormButton">Clear Form</button>
                    <button type="submit" class="btn text-white float-end" name="submit" style="Background-color:#6537AE;">Book Appointment</button>
                </div>
        </div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
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
$(document).ready(function() {
  $("#signUpForm").on("submit", function(e) {
    if (this.checkValidity()) {
      $("#pageloader").fadeIn();
    } else {
      e.preventDefault();
    }
  });
});
    </script>
<script>
          function validateInput(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 11) {
            inputElement.value = inputElement.value.slice(0, 11);
        }
    };
    function validateNum(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 6) {
            inputElement.value = inputElement.value.slice(0, 6);
        }
    };
</script>
<script>
      function validateInput(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 11) {
            inputElement.value = inputElement.value.slice(0, 11);
        }
    };
    function validateNum(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 6) {
            inputElement.value = inputElement.value.slice(0, 6);
        }
    };
    function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";

    // Get current time
    var currentTime = new Date();
    var currentHours = currentTime.getHours();
    var currentMinutes = currentTime.getMinutes();
    var currentTotalMinutes = currentHours * 60 + currentMinutes;

    // Set the time limits
    var limit1Hours = 13;
    var limit1Minutes = 0;
    var limit1TotalMinutes = limit1Hours * 60 + limit1Minutes;

    var limit2Hours = 13;
    var limit2Minutes = 30;
    var limit2TotalMinutes = limit2Hours * 60 + limit2Minutes;

    var limit3Hours = 14;
    var limit3Minutes = 0;
    var limit3TotalMinutes = limit3Hours * 60 + limit3Minutes;
    
    var limit4Hours = 14;
    var limit4Minutes = 30;
    var limit4TotalMinutes = limit4Hours * 60 + limit4Minutes;
    
    var limit5Hours = 15;
    var limit5Minutes = 0;
    var limit5TotalMinutes = limit5Hours * 60 + limit5Minutes;

    var limit6Hours = 15;
    var limit6Minutes = 30;
    
    var limit6TotalMinutes = limit6Hours * 60 + limit6Minutes;

    var limit7Hours = 16;
    var limit7Minutes = 0;
    var limit7TotalMinutes = limit7Hours * 60 + limit7Minutes;

    // Check if the current time is beyond the limits
    var disableAllSlots1 = currentTotalMinutes > limit1TotalMinutes;
    var disableAllSlots2 = currentTotalMinutes > limit2TotalMinutes;
    var disableAllSlots3 = currentTotalMinutes > limit3TotalMinutes;
    var disableAllSlots4 = currentTotalMinutes > limit4TotalMinutes;
    var disableAllSlots5 = currentTotalMinutes > limit5TotalMinutes;
    var disableAllSlots6 = currentTotalMinutes > limit6TotalMinutes;
    var disableAllSlots7 = currentTotalMinutes > limit7TotalMinutes;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
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

                // Disable slots based on different time limits
                var currentDate = new Date();
                var selectedDate = new Date(d);
                var isCurrentDay = currentDate.toDateString() === selectedDate.toDateString();

                if (disableAllSlots1 && isCurrentDay && slot == "1:00 PM - 1:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }

                if (disableAllSlots2 && isCurrentDay && slot == "1:30 PM - 2:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots3 && isCurrentDay && slot == "2:00 PM - 2:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots4 && isCurrentDay && slot == "2:30 PM - 3:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots5 && isCurrentDay && slot == "3:00 PM - 3:30 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots6 && isCurrentDay && slot == "3:30 PM - 4:00 PM") {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                if (disableAllSlots6 && isCurrentDay && slot == "4:00 PM - 4:30 PM") {
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
include "../../db_connect/config.php";

$sql = "SELECT day_to_disable FROM disabled_days";
$result = $conn->query($sql);
$disableDates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disableDates[] = $row['day_to_disable'];
    }
}
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
        allowInput: false,
        minDate: new Date().fp_incr(0),
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
function limitHealthConcern(textarea, maxCharacters) {
    let text = textarea.value;
    if (text.length > maxCharacters) {
        textarea.value = text.slice(0, maxCharacters);
    }
    let charactersRemaining = maxCharacters - textarea.value.length;
    let characterCountElement = document.getElementById("characterCount");
    characterCountElement.textContent = charactersRemaining + " characters remaining";
}

function onPaste(event, textarea) {
    setTimeout(function () {
        limitHealthConcern(textarea, 1700);
    }, 0);
}

</script>
<script>

function clearFormFields() {
    document.getElementById('signUpForm').reset();
    const textarea = document.getElementById('healthComplaint');
    textarea.value = ''; // Clear the textarea
    textarea.disabled = false;
    limitHealthConcern(textarea, 250); // Reset word count
}


document.getElementById('clearFormButton').addEventListener('click', clearFormFields);

</script>
</body>
</html>
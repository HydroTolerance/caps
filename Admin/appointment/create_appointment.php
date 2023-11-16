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
            </div>
            <div class="col-md-6">
                <label for="validationCustom03">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" id="e" required>
                <div class="invalid-feedback">
                    Please enter your email.
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom02">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="number" placeholder="Phone Number"  name="number" required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                <div class="invalid-feedback">
                Please enter a valid phone number that starts with '09'.
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom04">Schedule Appointment Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" onchange="updateTime()" required autocomplete="off">
                <div class="invalid-feedback">
                    Please choose a date.
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom05">Schedule Appointment Time<span class="text-danger">*</span></label>
                <select class="form-control" name="time" id="time" required>
                </select>
                <div class="invalid-feedback">
                    Please enter your time.
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
                        <label>Health Complaint<span class="text-danger">*</span></label>
                        <textarea class="form-control" placeholder="Description" name="health_concern" rows="8" required oninput="limitHealthConcern(this, 250);" onpaste="onPaste(event, this);"></textarea>
                        <div class="invalid-feedback">
                            Please enter your health complaint.
                        </div>
                        <div class="text-muted" id="wordCount">250 words remaining</div>
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
    $(document).ready(function(){
        $('.select2').select2({
        placeholder: {
            id: '',
            text: 'None Selected'
        },
        theme: 'bootstrap-5',
        allowClear: true,
        dropdownParent: $("#insertAppointment")
    });
    })

</script>
<script>
function limitHealthConcern(textarea, maxWords) {
    let text = textarea.value;
    let words = text.split(/\s+/);
    if (words.length > maxWords) {
        words = words.slice(0, maxWords);
        textarea.value = words.join(" ");
    }
    let wordsRemaining = maxWords - words.length;
    let wordCountElement = document.getElementById("wordCount");
    wordCountElement.textContent = wordsRemaining + " words remaining";
}

function onPaste(event, textarea) {
    setTimeout(function () {
        limitHealthConcern(textarea, 250);
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